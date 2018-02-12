#!/usr/bin/env bash

cd /code/dashboard

# Create '.env' file if it isn't exist
if [ ! -f .env ]; then
	cp .env.example .env
fi

# Create 'laravel.log' file if it isn't exist
if [ ! -f storage/logs/laravel.log ]; then
	touch storage/logs/laravel.log
fi

# Create necessary folders
mkdir -p bootstrap/cache
mkdir -p storage/framework
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache

# Generate artisan key
php artisan key:generate

# Install dependencies
composer install

# Set correct permissions
chgrp -R www-data /code/dashboard
chown -R ida:www-data /code/dashboard
find /code/dashboard -type f -exec chmod 664 {} \;
find /code/dashboard -type d -exec chmod 775 {} \;
chown -R ida:www-data /code/dashboard/storage/logs

rm /etc/nginx/sites-available/default
rm /etc/nginx/sites-enabled/default

service nginx restart

# Run php-fpm
docker-php-entrypoint php-fpm