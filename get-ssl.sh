#!/bin/bash

# Скрипт для получения SSL сертификата для mindale.ru

echo "🚀 Настройка SSL для mindale.ru"

# Создаем необходимые папки
mkdir -p docker/letsencrypt
mkdir -p docker/certbot-webroot

echo "📁 Папки созданы"

# Запускаем продакшн контейнеры
echo "🐳 Запускаем продакшн контейнеры..."
docker-compose -f docker-compose.prod.yml up -d

# Ждем запуска nginx
echo "⏳ Ждем запуска nginx..."
sleep 10

# Получаем SSL сертификат
echo "🔐 Получаем SSL сертификат..."
docker-compose -f docker-compose.prod.yml run --rm certbot certonly \
    --webroot \
    --webroot-path=/var/www/certbot \
    --email admin@mindale.ru \
    --agree-tos \
    --no-eff-email \
    -d mindale.ru \
    -d www.mindale.ru

if [ $? -eq 0 ]; then
    echo "✅ SSL сертификат получен успешно!"
    
    # Отключаем SSL конфигурацию (она пока не нужна)
    docker exec laravel_nginx mv /etc/nginx/conf.d/ssl.conf /etc/nginx/conf.d/ssl.conf.disabled
    
    # Включаем SSL конфигурацию
    echo "🔄 Включаем SSL конфигурацию..."
    docker exec laravel_nginx mv /etc/nginx/conf.d/ssl.conf.disabled /etc/nginx/conf.d/ssl.conf
    
    # Перезапускаем nginx
    docker exec laravel_nginx nginx -t && docker exec laravel_nginx nginx -s reload
    
    echo "🎉 HTTPS успешно настроен!"
    echo "🌐 Ваш сайт доступен по адресу: https://mindale.ru"
    
else
    echo "❌ Ошибка получения SSL сертификата"
    echo "Убедитесь что:"
    echo "- Домен mindale.ru направлен на ваш сервер"
    echo "- Порты 80 и 443 открыты"
    echo "- Сервер доступен из интернета"
fi
