#!/bin/sh
# Продление Let's Encrypt сертификата и перезагрузка nginx.
# Предполагается запуск на проде из директории с docker-compose.prod.yml,
# например через cron:
#   0 3 * * * cd /path/to/edem && ./docker/certbot-renew.sh >> /var/log/certbot-renew.log 2>&1

set -e

cd "$(dirname "$0")/.."

docker compose -f docker-compose.prod.yml run --rm certbot renew --webroot -w /var/www/certbot
docker compose -f docker-compose.prod.yml exec nginx nginx -s reload
