# Инструкция по переходу на новый домен эдемский-сад.рф

## Что было обновлено

### 1. Конфигурационные файлы
- ✅ `.env.production` - обновлен APP_URL
- ✅ `public/robots.txt` - обновлен sitemap URL
- ✅ `docker/nginx/prod.conf` - добавлен редирект со старого домена
- ✅ `docker-compose.prod.yml` - обновлены комментарии
- ✅ `get-ssl.sh` - обновлен скрипт получения SSL сертификата

### 2. Nginx конфигурация

В файле `docker/nginx/prod.conf` настроено:
- Автоматический редирект с `mindale.ru` на `https://эдемский-сад.рф`
- Поддержка как кириллического домена, так и Punycode версии (`xn----7sbabdeflfh8aja4aj7ayg.xn--p1ai`)
- SSL сертификаты для нового домена

### 3. Что НЕ было обновлено (нужно проверить вручную)

Следующие файлы содержат упоминания старого домена, но могут требовать ручной проверки:
- `resources/views/privacy.blade.php` - Telegram: @FlowersMindale
- `resources/views/contacts.blade.php` - Telegram: @FlowersMindale
- `resources/views/delivery.blade.php` - Telegram: @FlowersMindale
- `resources/views/components/footer.blade.php` - Telegram: @FlowersMindale
- `resources/views/about.blade.php` - Telegram: @FlowersMindale
- `ПРОСТАЯ_ИНСТРУКЦИЯ_ПО_ЦЕЛЯМ.md` - упоминание счетчика для mindale.ru

## Шаги для завершения перехода

### 1. DNS настройки
Убедитесь, что DNS записи для нового домена указывают на ваш сервер:
```
A    эдемский-сад.рф         -> IP_АДРЕС_СЕРВЕРА
A    www.эдемский-сад.рф     -> IP_АДРЕС_СЕРВЕРА
A    xn----7sbabdeflfh8aja4aj7ayg.xn--p1ai  -> IP_АДРЕС_СЕРВЕРА
```

### 2. Получение SSL сертификата
После настройки DNS запустите скрипт для получения SSL сертификата:
```bash
chmod +x get-ssl.sh
./get-ssl.sh
```

### 3. Обновление .env на продакшене
Скопируйте содержимое `.env.production` в рабочий `.env` файл на сервере:
```bash
cp .env.production .env
# Не забудьте установить APP_KEY если он пустой:
php artisan key:generate
```

### 4. Перезапуск Docker контейнеров
```bash
docker-compose -f docker-compose.prod.yml down
docker-compose -f docker-compose.prod.yml up -d
```

### 5. Очистка кэша Laravel
```bash
docker exec laravel_app_prod php artisan config:cache
docker exec laravel_app_prod php artisan route:cache
docker exec laravel_app_prod php artisan view:cache
```

### 6. Проверка работы сайта
- Откройте `https://эдемский-сад.рф` в браузере
- Проверьте, что редирект с `mindale.ru` работает корректно
- Проверьте, что SSL сертификат действителен
- Проверьте все страницы сайта

## SEO рекомендации

### 1. Яндекс.Вебмастер
- Добавьте новый домен в Яндекс.Вебмастер
- Настройте переезд сайта (укажите старый домен → новый)
- Отправьте новую карту сайта (sitemap.xml)

### 2. Google Search Console
- Добавьте новый домен в Google Search Console
- Отправьте новую карту сайта (sitemap.xml)
- Настройте смену адреса (если доступна эта функция)

### 3. Яндекс.Метрика и Google Analytics
- Обновите настройки счетчика, добавив новый домен
- Настройте фильтры для учета трафика с обоих доменов

## Поддержка старого домена

Старый домен `mindale.ru` будет автоматически редиректить на новый с кодом 301 (постоянный редирект).
Это важно для:
- Сохранения SEO позиций
- Работы старых ссылок и закладок
- Плавного перехода пользователей

Рекомендуется поддерживать редирект минимум 6-12 месяцев.

## Возможные проблемы

### Проблема: SSL сертификат не работает
**Решение**: Убедитесь, что DNS записи правильно настроены и домен резолвится на ваш сервер. Проверьте порты 80 и 443.

### Проблема: Редирект не работает
**Решение**: Проверьте nginx конфигурацию и перезапустите nginx:
```bash
docker exec laravel_nginx_prod nginx -t
docker exec laravel_nginx_prod nginx -s reload
```

### Проблема: 404 ошибки на некоторых страницах
**Решение**: Очистите кэш маршрутов:
```bash
docker exec laravel_app_prod php artisan route:clear
docker exec laravel_app_prod php artisan route:cache
```
