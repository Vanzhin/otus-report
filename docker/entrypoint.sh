#!/bin/sh
set -e
# Переходим в директорию app
cd app
# Если есть файл .firstrun_php , то команда  composer --no-interaction install не выполняется
    export COMPOSER_ALLOW_SUPERUSER=1
    echo "Running composer install"
    composer --no-interaction install
# команда, которая начинает слушать запросы на порту 8000
php -S 0.0.0.0:$PORT $PUBLIC_DIR/$INDEX_FILE

exec "$@"