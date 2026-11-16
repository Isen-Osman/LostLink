FROM node:22-alpine AS assets

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY vite.config.js ./
COPY resources ./resources
COPY public ./public

RUN npm run build


FROM php:8.5-cli

RUN apt-get update \
    && apt-get install -y --no-install-recommends libpq-dev unzip \
    && docker-php-ext-install pdo_pgsql \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --prefer-dist --no-progress --no-scripts

COPY . .
COPY --from=assets /app/public/build ./public/build

RUN composer dump-autoload --optimize --no-scripts \
    && php artisan package:discover --ansi \
    && mkdir -p storage/app/public storage/framework/cache storage/framework/sessions storage/framework/views storage/logs bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

EXPOSE 8000

ENTRYPOINT ["entrypoint.sh"]
