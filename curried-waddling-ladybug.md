# План улучшения SEO и функционала "Эдемский сад" (эдемский-сад.рф)

## Контекст

Сайт-магазин цветов в Брянске на Laravel 12 уже работает: есть розничный (`Product`) и оптовый (`WholesaleProduct`) каталоги, заказы, личный кабинет, базовый SEO (мета-теги, Open Graph, JSON-LD Product/LocalBusiness/Breadcrumb, динамический sitemap, robots.txt). **Проблема**: трафика из поисковиков почти нет.

**Главные причины низкого трафика** (по результатам анализа):
1. Нет региональной привязки к Брянску в Яндекс.Вебмастере (без неё локальный e-com не выйдет в выдачу)
2. Нет аналитики — невозможно измерять и улучшать итеративно
3. Тонкий контент: карточки товаров без длинных описаний, нет блога, нет посадочных страниц под локальные запросы
4. Нет социальных сигналов: отзывов, оценок, расширенных Schema-сниппетов
5. Технические резервы: нет кэширования, изображения только JPG, нет preload

**Цель плана**: за 4 спринта (≈8 недель) поднять органический трафик из Яндекс и Google, поднять конверсию и автоматизировать обработку заказов.

---

## Спринт 1 — Фундамент (1-2 недели)

Без этих шагов остальные улучшения нельзя измерить и они не дадут эффекта.

### 1.1. Подключить аналитику и Вебмастер ⭐ HIGH / S
- Зарегистрировать сайт в **Яндекс.Вебмастер**, подтвердить владение, в разделе "Региональность" указать **Брянск**
- Зарегистрировать в **Google Search Console**
- Создать счётчик **Яндекс.Метрика** с Вебвизором + цели (просмотр товара, отправка формы заказа, клик по телефону, добавление в корзину)
- Подключить **Google Analytics 4**
- Создать компонент `resources/views/components/analytics.blade.php`, подключить в `resources/views/layouts/app.blade.php`. ID счётчиков — в `.env` → `config/services.php`
- Завести профили в **Яндекс.Бизнес** и **2ГИС** (адрес, телефон, фото, часы работы)

### 1.2. Серверный кэш — HIGH / S
- Обернуть выборки в `Cache::remember()` в:
  - `app/Http/Controllers/ProductController.php` — `getFilteredProducts`
  - `app/Http/Controllers/WholesaleController.php`
  - `app/Http/Controllers/SitemapController.php` (TTL 1 час)
  - `app/Http/Controllers/PageController.php` — `home`
- Инвалидация кэша при импорте товаров — хук в `ProductImportController::import` и `WholesaleImportController::import` (Cache::flush по тегам или удаление по ключам)
- Эффект: TTFB < 200 мс — критичный фактор у Яндекса

### 1.3. WebP/AVIF изображения + preload — HIGH / M
- Установить `intervention/image` (уже может быть)
- Команда `php artisan images:optimize` — генерирует `.webp` рядом с `.jpg` в `storage/app/public/products/{id}/`
- Обновить `Product::getFilesystemImages()` (`app/Models/Product.php:103`) — возвращать массив `[webp_url, jpg_url, alt]`
- В Blade использовать `<picture><source type="image/webp" srcset="..."><img src="...jpg"></picture>`
- Хук в `ProductImportController` для автогенерации WebP при импорте
- В `resources/views/layouts/app.blade.php`:
  - `<link rel="preload" as="image" href="{{ $heroImage }}" fetchpriority="high">` для hero
  - `<link rel="preconnect" href="https://mc.yandex.ru">`
- Эффект: −60-70% веса картинок → LCP в зелёной зоне Core Web Vitals

### 1.4. Региональная микроразметка — HIGH / S
- В `resources/views/layouts/app.blade.php` добавить:
  - `<meta name="geo.region" content="RU-BRY">`
  - `<meta name="geo.placename" content="Брянск">`
  - `<link rel="alternate" hreflang="ru-RU" href="{{ url()->current() }}">`
- На странице контактов отображать телефон с кодом города (+7 4832) рядом с мобильным

### 1.5. Telegram-уведомления о заказах — HIGH / S
- Создать `app/Services/TelegramNotifier.php` (HTTP::post на токене из `config/services.php`, токен уже есть)
- Вызывать в `OrderController::submit` и **вернуть** в `WholesaleOrderController::submit` (откуда убрали в коммите `66e8cd4`) — лучше через слушатель события `OrderCreated`, чтобы не дублировать код
- Шаблон сообщения: ФИО, телефон, состав заказа, сумма, ссылка на админку
- Эффект: скорость реакции на заказ → меньше отказов

---

## Спринт 2 — SEO-контент (2-3 недели)

### 2.1. Расширенные карточки товаров — HIGH / M
- Миграция к таблице `products`: добавить колонки `composition` (text — состав букета), `size` (диаметр/высота), `care_instructions` (text), `seo_text` (text — длинное описание до 3000 знаков под карточкой)
- Обновить `ProductImportController` — добавить новые столбцы в Excel-шаблон
- В `resources/views/products/show.blade.php` — табы или секции "Описание / Состав / Уход / Доставка"
- Цель: уникальный текст в каждой карточке ≥800 знаков (защита от Panda-фильтра)

### 2.2. SEO-тексты на категориях и главной — HIGH / S
- В `resources/views/products/index.blade.php` под пагинацией — текстовый блок под каждую категорию (1000-1500 знаков). Хранить в `config/seo_texts.php` (ключ = slug категории) или таблице `category_texts`
- На главной (`resources/views/welcome.blade.php` или `home.blade.php`) — H1 "Доставка цветов в Брянске" + SEO-текст 2000 знаков с упоминанием районов, ассортимента, преимуществ
- Эффект: без текста категории не ранжируются по коммерческим запросам

### 2.3. Расширение Schema.org — HIGH / M
В `app/Services/SeoService.php` добавить методы:
- `setFAQSchema(array $qa)` — для страницы FAQ и блока FAQ внутри карточки товара
- `setOrganizationSchema()` с `sameAs` (VK, Telegram, Я.Карты, 2ГИС) — в layout
- Расширить `setLocalBusinessSchema`: тип **Florist** вместо общего LocalBusiness, добавить:
  - `areaServed`: Брянск + районы (Советский, Бежицкий, Володарский, Фокинский)
  - `hasMap` со ссылкой на Я.Карты
  - `paymentAccepted`, `currenciesAccepted: RUB`
- `setReviewSchema()` — для агрегированного рейтинга (после внедрения 3.2)
- Эффект: расширенные сниппеты в Яндексе → CTR +20-30%

### 2.4. FAQ страница и FAQ-блоки — HIGH / S
- Маршрут `/faq` в `routes/web.php` → `PageController::faq`
- Blade `resources/views/faq.blade.php` (Alpine.js аккордеон)
- 15-20 вопросов: "Сколько стоит доставка по Брянску?", "Можно ли заказать букет на сегодня?", "Принимаете ли карты?", "Сколько живёт букет?", "Как сохранить тюльпаны дольше?"
- FAQ-блок (3-5 Q&A) на главной и в категориях каталога
- Подключить `setFAQSchema()` из 2.3

### 2.5. Посадочные страницы под Брянск — HIGH / M
Гео-страницы под локальные запросы:
- `/dostavka-cvetov-bryansk`
- `/dostavka-cvetov-sovetsky-rayon`, `/bezhitsky-rayon`, `/volodarsky-rayon`, `/fokinsky-rayon`
- Сезонные: `/buket-na-8-marta-bryansk`, `/buket-na-1-sentyabrya-bryansk`, `/svadebnye-bukety-bryansk`

Реализация: `LandingController` + конфиг массив страниц или таблица `landings (slug, title, h1, meta_title, meta_description, content, category_filter)`. Каждая страница — уникальный текст 1500-2500 знаков + подборка релевантных товаров через `Product::byCategory()`.

### 2.6. Расширенный sitemap.xml — MEDIUM / S
В `app/Http/Controllers/SitemapController.php`:
- Добавить `<image:image>` теги (расширение Google для Я.Картинок/Google Images)
- `lastmod` из `updated_at` товара
- Отдельный sitemap для блога (когда появится)

---

## Спринт 3 — Конверсия (3-4 недели)

### 3.1. Отзывы и рейтинги — HIGH / M
- Миграция `reviews (id, product_id nullable, user_id nullable, customer_name, rating tinyint 1-5, text, photo nullable, is_approved bool, created_at)`
- Модель `Review`, отношения `Product::reviews()`, accessor `Product::getAverageRatingAttribute()`
- Форма на карточке товара (только для авторизованных или с reCAPTCHA), модерация в админке
- Подключить `setReviewSchema()` → AggregateRating → звёзды в выдаче
- Публичная страница `/reviews`
- Эффект: социальное доказательство + расширенные сниппеты

### 3.2. Похожие товары — HIGH / S
- В `ProductController::show` добавить `$related = Product::available()->where('category', $product->category)->where('id', '!=', $product->id)->inRandomOrder()->limit(4)->get()`
- Блок в `resources/views/products/show.blade.php`, переиспользовать существующий product card компонент
- Эффект: среднее время на сайте + средний чек

### 3.3. Поиск по сайту — HIGH / M
- Laravel Scout с драйвером `tntsearch` (хороший русский стемминг) или `database` (MySQL FULLTEXT)
- Индексировать `name`, `description`, `composition` у `Product` и `WholesaleProduct`
- Live-поиск в шапке через Alpine.js + endpoint `/api/search?q=`
- **Важно**: логировать запросы в таблицу `search_queries (query, results_count, user_ip, created_at)` — данные о намерениях для дальнейшего SEO

### 3.4. Промокоды — HIGH / M
- Миграция `promo_codes (code, type enum[percent|fixed], value, min_order, expires_at, usage_limit, used_count, is_active)`
- Применение в `OrderController::submit` и в Blade корзины (`resources/views/cart.blade.php`)
- Простая админка для создания (Filament/Nova или собственный CRUD)
- Эффект: триггер для конверсии + отдельные коды для каналов (блог/Telegram/листовок) → отслеживание источников

### 3.5. Улучшения корзины — MEDIUM / S
- Поле промокода (вместе с 3.4)
- Мини-корзина в шапке (Alpine.js store)
- Сохранение корзины в БД для авторизованных
- Кнопка "Купить в 1 клик" (только телефон)
- Выбор района Брянска для расчёта стоимости доставки

### 3.6. Popup о подписке / exit-intent — MEDIUM / S
- Alpine.js компонент `<x-newsletter-popup>` — показ через 30 сек на странице или на `mouseleave` к верху страницы
- Скидка 5% за email
- localStorage флаг "уже показывали" — не достаём повторно
- Сохранение email в таблицу `subscribers (см. 4.2)`

---

## Спринт 4 — Рост и удержание (4+ недель)

### 4.1. Блог — HIGH / L
- Миграция `articles (id, slug, title, excerpt, content text, cover, meta_title, meta_description, published_at, views)`
- Модель `Article`, `ArticleController` (`index/show`)
- Маршруты `/blog`, `/blog/{slug}`
- Blade `resources/views/blog/{index,show}.blade.php` — переиспользовать `SeoService`
- Markdown через `league/commonmark`
- **Стартовый контент 15-20 статей** под информационные запросы:
  - "Как выбрать букет на 8 марта в Брянске"
  - "Свадебные букеты — тренды 2026"
  - "Сколько живут тюльпаны в вазе"
  - "Доставка цветов в Советский район Брянска"
  - "Букет на день рождения мужчине"
  - "Что подарить на годовщину свадьбы"
- Эффект: 60-70% органического трафика для локального e-com приходит с информационных запросов. Внутренние ссылки на карточки товаров

### 4.2. Email-рассылки — MEDIUM / M
- Таблица `subscribers (email, source, confirmed_at, unsubscribed_at)`
- Формы подписки в footer и popup (3.6)
- Интеграция с Unisender/Mailgun, либо локальная команда `php artisan newsletter:send` через очереди
- Шаблоны Mail в `resources/views/emails/`
- DOI (double opt-in) — обязательно по закону

### 4.3. Wishlist / избранное — MEDIUM / M
- Гостям — localStorage через Alpine.js store
- Авторизованным — таблица `wishlists (user_id, product_id)`
- Иконка-сердечко на карточках товаров
- Страница `/dashboard/wishlist`
- Переиспользовать паттерн корзины

### 4.4. Уведомления о наличии — LOW / S
- Таблица `stock_subscriptions (email, product_id)`
- На карточке OutOfStock — форма "Сообщить о поступлении"
- Cron-команда + Mail при `is_available=true`

### 4.5. Программа лояльности — LOW / L
- Таблица `user_points (user_id, balance, total_earned)`
- Начисление 5% от суммы заказа при `status=delivered`
- Списание на следующий заказ (макс N% от суммы)

### 4.6. Реферальная система — LOW / M
- Колонка `referral_code` в `users`
- Страница `/dashboard/referral`
- Отслеживание перехода через cookie
- Бонус приглашающему и приглашённому

### 4.7. Ретаргетинг — MEDIUM / S
- VK Pixel + Я.Метрика-ретаргетинг (готовые сегменты "посмотрел товар не купил")
- Подключить в компоненте аналитики из 1.1

---

## Критические файлы для модификации

- `app/Services/SeoService.php` — расширение Schema (FAQ, Florist, Review, Organization)
- `app/Http/Controllers/ProductController.php` — кэш, похожие товары
- `app/Http/Controllers/SitemapController.php` — image:image теги, кэш
- `app/Models/Product.php` — WebP, average_rating accessor
- `app/Http/Controllers/OrderController.php` — Telegram, промокоды
- `app/Http/Controllers/WholesaleOrderController.php` — вернуть Telegram
- `resources/views/layouts/app.blade.php` — analytics, geo meta, preload
- `resources/views/products/show.blade.php` — табы, отзывы, похожие
- `resources/views/products/index.blade.php` — SEO-текст под пагинацией
- `routes/web.php` — /blog, /faq, /reviews, landing pages
- `public/.htaccess` — gzip, кэш-заголовки, HSTS, 301 редиректы

---

## Верификация

После каждого спринта проверять:

**Спринт 1**:
- В Яндекс.Вебмастере отображается регион "Брянск", сайт верифицирован
- Я.Метрика показывает посещения и работает Вебвизор
- Открыть DevTools → Lighthouse → Performance ≥ 90, LCP < 2.5s
- Создать тестовый заказ — Telegram-уведомление пришло в админский чат
- `php artisan tinker` → `Cache::get('...')` — кэш заполняется

**Спринт 2**:
- Открыть `view-source:` любой карточки товара — есть JSON-LD с типом Product + Review (если есть отзывы)
- Проверить страницу в [Яндекс.Вебмастер → Инструменты → Валидатор микроразметки](https://webmaster.yandex.ru/tools/microtest/)
- Проверить FAQ в [Google Rich Results Test](https://search.google.com/test/rich-results)
- Карточки товаров содержат уникальный текст ≥800 знаков
- Все посадочные страницы открываются и имеют свой контент

**Спринт 3**:
- Оставить тестовый отзыв → отображается на карточке + в Schema
- Создать промокод → применить в корзине → сумма уменьшается
- Поиск в шапке возвращает релевантные результаты
- В таблице `search_queries` появляются записи

**Спринт 4**:
- Опубликована хотя бы одна статья блога, открывается по `/blog/{slug}` с правильным SEO
- Email-рассылка отправляется (тест на свой адрес)
- Wishlist сохраняется между сессиями для авторизованного пользователя

**Общая метрика успеха** (через 2-3 месяца после Спринта 2):
- Я.Вебмастер → Поисковые запросы — рост показов и кликов
- Я.Метрика → Источники → Поисковые системы — рост визитов
- Позиции по ключевым запросам ("доставка цветов брянск", "купить букет брянск", "цветы брянск") — попадание в топ-20, затем топ-10
