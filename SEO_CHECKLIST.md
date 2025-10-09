# SEO Чеклист для Mindale.ru

## ✅ Что уже реализовано:

### 1. SEO-friendly URLs
- ✅ Slug для продуктов (`/product/buket-roz` вместо `/product/1`)
- ✅ Автоматическая генерация slug
- ✅ Уникальность slug

### 2. Meta теги
- ✅ Title с названием продукта
- ✅ Description с описанием и ценой
- ✅ Keywords
- ✅ Open Graph теги (Facebook, VK)
- ✅ Twitter Card
- ✅ Canonical URLs

### 3. Технические улучшения
- ✅ Sitemap генератор (`php artisan sitemap:generate`)
- ✅ robots.txt (уже есть)
- ✅ HTTPS с валидным сертификатом
- ✅ Yandex Metrika подключена

## 📝 Что нужно сделать:

### 1. Запустить генерацию sitemap
```bash
# На сервере
docker exec laravel_app_prod php artisan sitemap:generate
```

Затем добавьте в `robots.txt`:
```
User-agent: *
Disallow:

Sitemap: https://mindale.ru/sitemap.xml
```

### 2. Добавить структурированные данные (Schema.org)

В `resources/views/products/show.blade.php` добавьте в секцию `<head>`:

```blade
@push('seo')
<script type="application/ld+json">
{!! \App\Helpers\SeoHelper::productSchema($product) !!}
</script>

<script type="application/ld+json">
{!! \App\Helpers\SeoHelper::breadcrumbsSchema([
    'Главная' => url('/'),
    'Каталог' => url('/products'),
    $product->name => route('products.show', $product->slug)
]) !!}
</script>
@endpush
```

В `resources/views/layouts/app.blade.php` добавьте в футер:

```blade
@if(request()->is('/'))
<script type="application/ld+json">
{!! \App\Helpers\SeoHelper::organizationSchema() !!}
</script>
@endif
```

### 3. Улучшить изображения

Обновите теги `<img>` в шаблонах:

```blade
<!-- Было -->
<img src="{{ $product->main_image }}" alt="{{ $product->name }}">

<!-- Стало -->
<img src="{{ $product->main_image }}"
     alt="{{ $product->alt_text ?? $product->name }}"
     loading="lazy"
     width="640"
     height="480">
```

### 4. Создать изображение для Open Graph

Создайте файл `public/images/og-default.jpg`:
- Размер: 1200x630px
- Формат: JPG
- Содержание: Логотип Mindale + текст "Доставка цветов"

### 5. Оптимизировать заголовки

На главной странице уже есть H1, но на страницах товаров нужно добавить:

В `products/show.blade.php` добавьте:
```html
<h1>{{ $product->name }}</h1>
```

### 6. Добавить хлебные крошки (breadcrumbs)

На странице товара добавьте навигационные крошки:

```html
<nav aria-label="breadcrumb">
    <ol itemscope itemtype="https://schema.org/BreadcrumbList">
        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <a itemprop="item" href="/">
                <span itemprop="name">Главная</span>
            </a>
            <meta itemprop="position" content="1" />
        </li>
        <li itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
            <span itemprop="name">{{ $product->name }}</span>
            <meta itemprop="position" content="2" />
        </li>
    </ol>
</nav>
```

## 🚀 Дополнительные рекомендации:

### Google Search Console
1. Добавьте сайт в [Google Search Console](https://search.google.com/search-console)
2. Загрузите sitemap.xml
3. Проверьте индексацию страниц

### Yandex Webmaster
1. Добавьте сайт в [Яндекс.Вебмастер](https://webmaster.yandex.ru/)
2. Загрузите sitemap.xml
3. Настройте регион (Россия)

### Контент
- ✍️ Добавьте уникальные описания для каждого продукта (минимум 150 символов)
- 📝 Используйте ключевые слова естественно
- 🎯 Добавьте страницу "О нас" и "Доставка"
- 📱 Добавьте FAQ страницу

### Скорость загрузки
- 🖼️ Оптимизируйте изображения (WebP формат)
- ⚡ Включите кеширование в nginx
- 🗜️ Включите gzip сжатие

### Локальное SEO
- 📍 Добавьте адрес в Google My Business
- 🗺️ Добавьте карту на страницу контактов
- 📞 Укажите рабочие часы

## 📊 Проверка SEO

После внедрения проверьте:

1. **PageSpeed Insights**: https://pagespeed.web.dev/
2. **Структурированные данные**: https://search.google.com/test/rich-results
3. **Open Graph**: https://www.opengraph.xyz/
4. **Mobile Friendly**: https://search.google.com/test/mobile-friendly

## 🔄 Автоматизация

Добавьте в cron автоматическую генерацию sitemap:

```bash
# Каждую ночь в 3:00
0 3 * * * cd /var/www/html/flower_shop && php artisan sitemap:generate
```

## 📈 Ожидаемые результаты:

- 🔍 Улучшение позиций в поисковой выдаче
- 📱 Красивые превью в соцсетях
- 🎯 Увеличение кликабельности в поиске
- 📊 Лучшая индексация страниц
- ⚡ Faster discoverability by search engines
