#!/bin/sh
set -e
echo 'Rodando entrypoint'

composer install --no-interaction --optimize-autoloader
php artisan migrate --force

exec php-fpm
