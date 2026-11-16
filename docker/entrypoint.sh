#!/bin/sh
set -e

if [ -z "${APP_KEY:-}" ]; then
    export APP_KEY="$(php artisan key:generate --show)"
fi

until php -r 'try { new PDO(sprintf("pgsql:host=%s;port=%s;dbname=%s", getenv("DB_HOST"), getenv("DB_PORT"), getenv("DB_DATABASE")), getenv("DB_USERNAME"), getenv("DB_PASSWORD")); } catch (Throwable $e) { exit(1); }'; do
    echo "Waiting for PostgreSQL..."
    sleep 2
done

php artisan migrate --force
php artisan storage:link || true

exec php artisan serve --host=0.0.0.0 --port=8000
