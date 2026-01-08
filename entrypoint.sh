#!/bin/sh
composer install
chmod 777 ./rr

export PATH="$PATH:$HOME/.local/bin"

php artisan key:generate
php artisan migrate

if [ "$OCTANE_ENV" = "dev" ]; then
    npm i
    /usr/bin/php -d variables_order=EGPCS /var/www/html/artisan octane:start --server=roadrunner --host=0.0.0.0 --watch --port=${CONTAINER_APP_PORT:-8080}

    exit 0
fi
/usr/bin/php -d variables_order=EGPCS /var/www/html/artisan octane:start --server=roadrunner --host=0.0.0.0 --port=${CONTAINER_APP_PORT:-8080}
