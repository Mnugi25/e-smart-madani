# Stage 1: Build frontend assets with Vite (Node 22 for Vite 8)
FROM node:22-alpine AS assets
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY resources ./resources
COPY vite.config.mjs ./
RUN npm run build

# Stage 2: PHP 8.3 + Apache for Laravel 13
FROM php:8.3-apache

# Install system dependencies & PHP extensions required by Laravel, MySQL, DomPDF, PhpSpreadsheet
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mysqli \
        mbstring \
        xml \
        gd \
        zip \
        bcmath \
        intl \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite & set DocumentRoot to /var/www/html/public
RUN a2enmod rewrite
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy composer files first for better Docker layer caching
COPY composer.json composer.lock ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-scripts

# Copy application source & built Vite assets
COPY . .
COPY --from=assets /app/public/build ./public/build

# Ensure storage & cache directories exist and are writable by Apache (www-data)
RUN mkdir -p storage/framework/sessions storage/framework/views storage/framework/cache/data storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Make entrypoint executable
RUN chmod +x /var/www/html/docker-entrypoint.sh

EXPOSE 80
ENTRYPOINT ["/var/www/html/docker-entrypoint.sh"]
