#!/bin/bash

# Скрипт для синхронизации файлов продуктов на продакшн сервер
# Использование: ./sync-products.sh [--dry-run]

set -e

# Настройки сервера
REMOTE_HOST="185.11.135.11"
REMOTE_USER="root"  # Измени на своего пользователя если нужно
REMOTE_PATH="/var/www/html/flower_shop/storage/app/public/products"

# Локальный путь к файлам продуктов
LOCAL_PATH="./storage/app/public/products/"

# Цвета для вывода
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
NC='\033[0m' # No Color

# Проверяем наличие локальной папки
if [ ! -d "$LOCAL_PATH" ]; then
    echo -e "${RED}Ошибка: Локальная папка $LOCAL_PATH не существует${NC}"
    echo -e "${YELLOW}Создаю папку...${NC}"
    mkdir -p "$LOCAL_PATH"
    echo -e "${GREEN}Папка создана. Добавь туда файлы и запусти скрипт снова.${NC}"
    exit 1
fi

# Проверяем, есть ли файлы для синхронизации
if [ -z "$(ls -A $LOCAL_PATH 2>/dev/null)" ]; then
    echo -e "${YELLOW}Папка $LOCAL_PATH пуста. Нечего синхронизировать.${NC}"
    exit 0
fi

# Определяем режим работы
DRY_RUN=""
if [ "$1" == "--dry-run" ]; then
    DRY_RUN="--dry-run"
    echo -e "${YELLOW}=== ТЕСТОВЫЙ РЕЖИМ (dry-run) ===${NC}"
    echo -e "${YELLOW}Файлы НЕ будут переданы, только показан список изменений${NC}"
    echo ""
fi

echo -e "${GREEN}Синхронизация файлов продуктов${NC}"
echo "Локальный путь: $LOCAL_PATH"
echo "Удалённый сервер: $REMOTE_USER@$REMOTE_HOST:$REMOTE_PATH"
echo ""

# Создаём папку на сервере если её нет
echo -e "${YELLOW}Проверяю/создаю папку на сервере...${NC}"
ssh "$REMOTE_USER@$REMOTE_HOST" "mkdir -p $REMOTE_PATH"

# Синхронизируем файлы
echo -e "${YELLOW}Начинаю синхронизацию...${NC}"
echo ""

rsync -avz --progress $DRY_RUN \
    "$LOCAL_PATH" \
    "$REMOTE_USER@$REMOTE_HOST:$REMOTE_PATH/"

echo ""
if [ -z "$DRY_RUN" ]; then
    echo -e "${GREEN}✓ Синхронизация завершена успешно!${NC}"
    
    # Устанавливаем правильные права на сервере
    echo -e "${YELLOW}Устанавливаю права доступа на сервере...${NC}"
    ssh "$REMOTE_USER@$REMOTE_HOST" "chown -R www-data:www-data $REMOTE_PATH && chmod -R 755 $REMOTE_PATH"
    echo -e "${GREEN}✓ Права установлены${NC}"
else
    echo -e "${YELLOW}Тестовый запуск завершён. Для реальной синхронизации запусти без --dry-run${NC}"
fi
