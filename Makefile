# Makefile для itulip
# Использование: make <команда>

# Настройки сервера
REMOTE_HOST = 185.11.135.11
REMOTE_USER = root
REMOTE_PATH = /var/www/html/flower_shop

# Локальные пути
LOCAL_PRODUCTS = ./storage/app/public/products/
REMOTE_PRODUCTS = $(REMOTE_PATH)/storage/app/public/products

.PHONY: help sync sync-dry deploy ssh logs storage-link build

# Помощь (по умолчанию)
help:
	@echo "Доступные команды:"
	@echo "  make build     - Собрать фронтенд (npm run build)"
	@echo "  make sync      - Синхронизировать файлы продуктов на сервер"
	@echo "  make sync-dry  - Тестовый запуск (без реальной передачи)"
	@echo "  make deploy    - Собрать фронтенд и задеплоить на сервер"
	@echo "  make ssh       - Подключиться к серверу по SSH"
	@echo "  make logs      - Посмотреть логи Docker на сервере"
	@echo "  make storage-link - Создать симлинк storage на сервере"

# Сборка фронтенда
build:
	@echo "🔨 Сборка фронтенда..."
	npm run build
	@echo "✅ Сборка завершена!"

# Синхронизация файлов продуктов
sync:
	@echo "🚀 Синхронизация файлов продуктов..."
	@mkdir -p $(LOCAL_PRODUCTS)
	@ssh $(REMOTE_USER)@$(REMOTE_HOST) "mkdir -p $(REMOTE_PRODUCTS)"
	rsync -avz --progress $(LOCAL_PRODUCTS) $(REMOTE_USER)@$(REMOTE_HOST):$(REMOTE_PRODUCTS)/
	@ssh $(REMOTE_USER)@$(REMOTE_HOST) "chown -R www-data:www-data $(REMOTE_PRODUCTS) && chmod -R 755 $(REMOTE_PRODUCTS)"
	@echo "✅ Готово!"

# Тестовый запуск синхронизации
sync-dry:
	@echo "🔍 Тестовый режим (файлы НЕ будут переданы)..."
	@mkdir -p $(LOCAL_PRODUCTS)
	rsync -avz --dry-run --progress $(LOCAL_PRODUCTS) $(REMOTE_USER)@$(REMOTE_HOST):$(REMOTE_PRODUCTS)/

# Деплой всего проекта (git pull + сборка + рестарт на сервере)
deploy:
	@echo "🚀 Деплой на сервер..."
	ssh $(REMOTE_USER)@$(REMOTE_HOST) "cd $(REMOTE_PATH) && git pull && npm install && npm run build && docker compose -f docker-compose.prod.yml restart app"
	@echo "✅ Деплой завершён!"

# Подключение к серверу
ssh:
	ssh $(REMOTE_USER)@$(REMOTE_HOST)

# Логи Docker на сервере
logs:
	ssh $(REMOTE_USER)@$(REMOTE_HOST) "cd $(REMOTE_PATH) && docker compose -f docker-compose.prod.yml logs -f --tail=100"

# Создать симлинк storage на сервере
storage-link:
	@echo "🔗 Создание симлинка storage..."
	ssh $(REMOTE_USER)@$(REMOTE_HOST) "cd $(REMOTE_PATH) && docker compose -f docker-compose.prod.yml exec -T app php artisan storage:link"
	@echo "✅ Симлинк создан!"
