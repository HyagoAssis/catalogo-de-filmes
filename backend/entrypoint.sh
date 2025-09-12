#!/bin/sh
composer install --no-interaction --optimize-autoloader

# 2️⃣ Rodar migrations
php artisan migrate --force

php-fpm
