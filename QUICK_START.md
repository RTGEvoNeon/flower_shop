# Быстрый запуск нового домена эдемский-сад.рф

## Текущая ситуация
- IP сервера: **185.11.135.11**
- Старый домен: mindale.ru (работает)
- Новый домен: эдемский-сад.рф (в punycode: xn----7sbabdeflfh8aja4aj7ayg.xn--p1ai)
- DNS для нового домена: **НЕ НАСТРОЕН**

## Шаг 1: Настройка DNS (ОБЯЗАТЕЛЬНО!)

Зайдите в панель управления вашего регистратора доменов и добавьте следующие А-записи:

```
Тип  Имя                                           Значение
A    эдемский-сад.рф                               185.11.135.11
A    www.эдемский-сад.рф                           185.11.135.11
A    xn----7sbabdeflfh8aja4aj7ayg.xn--p1ai        185.11.135.11
A    www.xn----7sbabdeflfh8aja4aj7ayg.xn--p1ai    185.11.135.11
```

**Важно:** DNS может распространяться до 24 часов, но обычно 5-30 минут.

### Проверка DNS:
```bash
# Проверить настройку DNS
host xn----7sbabdeflfh8aja4aj7ayg.xn--p1ai 8.8.8.8
# Должно вернуть: xn----7sbabdeflfh8aja4aj7ayg.xn--p1ai has address 185.11.135.11
```

## Шаг 2: Применить временную конфигурацию (без SSL)

После настройки DNS выполните:

```bash
# Обновить конфигурацию Nginx
docker cp docker/nginx/prod-temp.conf laravel_nginx_prod:/etc/nginx/conf.d/default.conf

# Проверить конфигурацию
docker exec laravel_nginx_prod nginx -t

# Перезагрузить Nginx
docker exec laravel_nginx_prod nginx -s reload
```

Теперь сайт будет доступен по HTTP: http://эдемский-сад.рф

## Шаг 3: Получить SSL сертификат

```bash
# Создать папки если их нет
mkdir -p docker/certbot-webroot

# Получить SSL сертификат
docker-compose -f docker-compose.prod.yml run --rm certbot certonly \
    --webroot \
    --webroot-path=/var/www/certbot \
    --email admin@mindale.ru \
    --agree-tos \
    --no-eff-email \
    -d эдемский-сад.рф \
    -d www.эдемский-сад.рф \
    -d xn----7sbabdeflfh8aja4aj7ayg.xn--p1ai \
    -d www.xn----7sbabdeflfh8aja4aj7ayg.xn--p1ai
```

## Шаг 4: Применить финальную конфигурацию с SSL

```bash
# Применить конфигурацию с SSL и редиректами
docker cp docker/nginx/prod.conf laravel_nginx_prod:/etc/nginx/conf.d/default.conf

# Проверить конфигурацию
docker exec laravel_nginx_prod nginx -t

# Перезагрузить Nginx
docker exec laravel_nginx_prod nginx -s reload
```

## Шаг 5: Проверка работы

```bash
# Проверить HTTP редирект на HTTPS
curl -I http://эдемский-сад.рф
# Должно вернуть: 301 Moved Permanently

# Проверить редирект со старого домена
curl -I https://mindale.ru
# Должно вернуть: 301 -> https://эдемский-сад.рф

# Проверить HTTPS
curl -I https://эдемский-сад.рф
# Должно вернуть: 200 OK
```

## Шаг 6: Настройка автопродления SSL

Добавить в crontab:
```bash
0 0 * * * docker-compose -f /var/www/html/flower_shop/docker-compose.prod.yml run --rm certbot renew && docker exec laravel_nginx_prod nginx -s reload
```

## Возможные проблемы

### 1. DNS не резолвится
```bash
# Подождать 5-10 минут и проверить снова
host xn----7sbabdeflfh8aja4aj7ayg.xn--p1ai 8.8.8.8
```

### 2. Ошибка при получении SSL
```
❌ Убедитесь что:
- DNS настроен и резолвится
- Порты 80 и 443 открыты
- Nginx запущен и работает
```

### 3. Nginx не перезагружается
```bash
# Перезапустить контейнер
docker restart laravel_nginx_prod
```

## Автоматический скрипт (использовать после настройки DNS!)

```bash
chmod +x setup-new-domain.sh
./setup-new-domain.sh
```
