#!/usr/bin/env sh
set -e

# Configure Apache to listen on Render's dynamic PORT (fallback to 80)
PORT="${PORT:-80}"
sed -i "s/Listen 80/Listen ${PORT}/g" /etc/apache2/ports.conf
sed -i "s/<VirtualHost \*:80>/<VirtualHost *:${PORT}>/g" /etc/apache2/sites-available/000-default.conf

# Link storage and cache Laravel config/routes/views using runtime env vars
php artisan storage:link --force || true
php artisan package:discover --ansi || true
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Start Apache in foreground
exec apache2-foreground
