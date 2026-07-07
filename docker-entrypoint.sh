#!/bin/sh
set -e

if [ ! -f storage/database.sqlite ]; then
    touch storage/database.sqlite
fi

if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force
fi

php artisan migrate --force

exec "$@"
