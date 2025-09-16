#!/bin/sh
set -e
echo 'Rodando entrypoint'

composer install --no-interaction --optimize-autoloader

if ! grep -q "APP_KEY=" .env || grep -q "APP_KEY=$" .env; then
  echo ">> Gerando APP_KEY..."
  php artisan key:generate --force
fi

php artisan migrate --force

exec php-fpm
