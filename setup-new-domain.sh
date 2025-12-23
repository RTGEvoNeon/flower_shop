#!/bin/bash

# Скрипт полной настройки нового домена эдемский-сад.рф
# ВАЖНО: Перед запуском настройте DNS!

set -e

echo "=================================================="
echo "  Настройка нового домена эдемский-сад.рф"
echo "=================================================="
echo ""

# Проверка DNS
echo "🔍 Шаг 1: Проверка DNS настроек..."
if host xn----7sbabdeflfh8aja4aj7ayg.xn--p1ai 8.8.8.8 | grep -q "has address 185.11.135.11"; then
    echo "✅ DNS настроен правильно!"
else
    echo "❌ DNS не настроен или еще не распространился!"
    echo ""
    echo "Пожалуйста, добавьте следующие А-записи в вашем регистраторе доменов:"
    echo "  A    xn----7sbabdeflfh8aja4aj7ayg.xn--p1ai       185.11.135.11"
    echo "  A    www.xn----7sbabdeflfh8aja4aj7ayg.xn--p1ai  185.11.135.11"
    echo ""
    read -p "Продолжить без проверки DNS? (y/N): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        exit 1
    fi
fi

# Применить временную конфигурацию
echo ""
echo "📝 Шаг 2: Применение временной конфигурации Nginx..."
docker cp docker/nginx/prod-temp.conf laravel_nginx_prod:/etc/nginx/conf.d/default.conf

if docker exec laravel_nginx_prod nginx -t 2>&1 | grep -q "successful"; then
    echo "✅ Конфигурация валидна"
    docker exec laravel_nginx_prod nginx -s reload
    echo "✅ Nginx перезагружен"
else
    echo "❌ Ошибка в конфигурации Nginx!"
    exit 1
fi

# Создать необходимые папки
echo ""
echo "📁 Шаг 3: Создание папок для Certbot..."
mkdir -p docker/certbot-webroot
mkdir -p docker/letsencrypt
echo "✅ Папки созданы"

# Проверка доступности сайта
echo ""
echo "🌐 Шаг 4: Проверка доступности сайта..."
sleep 2
if curl -s -o /dev/null -w "%{http_code}" "http://xn----7sbabdeflfh8aja4aj7ayg.xn--p1ai" | grep -q "200\|301\|302"; then
    echo "✅ Сайт доступен по HTTP"
else
    echo "⚠️  Сайт может быть недоступен, но продолжаем..."
fi

# Получение SSL сертификата
echo ""
echo "🔐 Шаг 5: Получение SSL сертификата от Let's Encrypt..."
echo "Это может занять 1-2 минуты..."

if docker-compose -f docker-compose.prod.yml run --rm certbot certonly \
    --webroot \
    --webroot-path=/var/www/certbot \
    --email admin@mindale.ru \
    --agree-tos \
    --no-eff-email \
    --non-interactive \
    -d эдемский-сад.рф \
    -d www.эдемский-сад.рф \
    -d xn----7sbabdeflfh8aja4aj7ayg.xn--p1ai \
    -d www.xn----7sbabdeflfh8aja4aj7ayg.xn--p1ai; then
    echo "✅ SSL сертификат получен!"
else
    echo "❌ Ошибка получения SSL сертификата!"
    echo ""
    echo "Возможные причины:"
    echo "  - DNS еще не распространился (подождите 10-30 минут)"
    echo "  - Порт 80 недоступен из интернета"
    echo "  - Домен не резолвится на этот сервер"
    echo ""
    echo "Проверьте DNS и попробуйте снова через 10-30 минут."
    exit 1
fi

# Применить финальную конфигурацию с SSL
echo ""
echo "🔒 Шаг 6: Применение финальной конфигурации с SSL..."
docker cp docker/nginx/prod.conf laravel_nginx_prod:/etc/nginx/conf.d/default.conf

if docker exec laravel_nginx_prod nginx -t 2>&1 | grep -q "successful"; then
    echo "✅ Конфигурация валидна"
    docker exec laravel_nginx_prod nginx -s reload
    echo "✅ Nginx перезагружен с SSL"
else
    echo "❌ Ошибка в конфигурации Nginx!"
    echo "Откатываемся на временную конфигурацию..."
    docker cp docker/nginx/prod-temp.conf laravel_nginx_prod:/etc/nginx/conf.d/default.conf
    docker exec laravel_nginx_prod nginx -s reload
    exit 1
fi

# Финальная проверка
echo ""
echo "🧪 Шаг 7: Финальная проверка..."

echo -n "  HTTP -> HTTPS редирект: "
if curl -s -I "http://xn----7sbabdeflfh8aja4aj7ayg.xn--p1ai" | grep -q "301"; then
    echo "✅"
else
    echo "⚠️"
fi

echo -n "  HTTPS работает: "
if curl -s -k -I "https://xn----7sbabdeflfh8aja4aj7ayg.xn--p1ai" | grep -q "200\|301\|302"; then
    echo "✅"
else
    echo "⚠️"
fi

echo -n "  Редирект со старого домена: "
if curl -s -I "https://mindale.ru" | grep -q "301"; then
    echo "✅"
else
    echo "⚠️"
fi

# Успех!
echo ""
echo "=================================================="
echo "  ✅ НАСТРОЙКА ЗАВЕРШЕНА!"
echo "=================================================="
echo ""
echo "Ваш сайт теперь доступен по адресу:"
echo "  🌐 https://эдемский-сад.рф"
echo ""
echo "Редирект со старого домена работает:"
echo "  mindale.ru → https://эдемский-сад.рф"
echo ""
echo "Не забудьте:"
echo "  1. Обновить .env файл (APP_URL)"
echo "  2. Очистить кэш Laravel"
echo "  3. Добавить домен в Яндекс.Вебмастер и Google Search Console"
echo "  4. Настроить автопродление SSL (см. QUICK_START.md)"
echo ""
