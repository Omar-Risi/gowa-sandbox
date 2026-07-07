# syntax=docker/dockerfile:1

FROM composer:2 AS vendor
WORKDIR /app
COPY . .
RUN composer install --no-dev --no-scripts --no-interaction --prefer-dist --optimize-autoloader

FROM node:20-alpine AS assets
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY . .
RUN npm run build

FROM php:8.5-cli

RUN apt-get update && apt-get install -y --no-install-recommends \
        libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

COPY --from=vendor /app ./
COPY --from=assets /app/public/build ./public/build

COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint
RUN chmod +x /usr/local/bin/docker-entrypoint \
    && touch storage/database.sqlite \
    && chmod -R a+rwX storage bootstrap/cache \
    && php artisan package:discover --ansi

EXPOSE 8000

ENTRYPOINT ["docker-entrypoint"]
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
