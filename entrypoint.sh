#!/bin/bash

cp .env.dev .env
composer install
php artisan key:generate
php artisan config:cache
php artisan migrate:refresh --seed

chmod 777 -R .

service nginx restart
php-fpm