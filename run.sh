#!/usr/bin/env bash

cd /var/www/html/dashboard

# Create '.env' file if it isn't exist
if [ ! -f .env ]; then
	cp .env.example .env
fi

# Create 'laravel.log' file if it isn't exist
if [ ! -f storage/logs/laravel.log ]; then
	touch storage/logs/laravel.log
fi

# Create necessary folders and files
mkdir -p bootstrap/cache
mkdir -p storage/framework
mkdir -p storage/framework/sessions
mkdir -p storage/framework/views
mkdir -p storage/framework/cache

touch storage/logs/laravel.log

# Set correct permissions
chgrp -R nginx /var/www/html/dashboard
chown -R ida:nginx /var/www/html/dashboard
find /var/www/html/dashboard -type f -exec chmod 664 {} \;
find /var/www/html/dashboard -type d -exec chmod 775 {} \;
chown -R ida:nginx /var/www/html/dashboard/storage/logs

# Generate artisan key
php artisan key:generate
php artisan config:cache

# Start supervisord and services
exec /usr/bin/supervisord -n -c /etc/supervisord.conf