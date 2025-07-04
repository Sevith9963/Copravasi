# Use official PHP Apache image with Composer
FROM php:8.1-apache

# Install dependencies for composer and PHP extensions
RUN apt-get update && apt-get install -y \
    unzip \
    zip \
    git \
    libzip-dev \
    && docker-php-ext-install zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project files into the web root
COPY . /var/www/html/

# Enable Apache rewrite (if using .htaccess for routing)
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html/

# Install PHP dependencies (optional)
RUN composer install --no-dev || true

# Expose port 80
EXPOSE 80
