FROM php:8.1-apache

# Install mysqli extension
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

# Optional: Enable Apache modules if needed
RUN a2enmod headers rewrite

# Copy project files
COPY . /var/www/html/

# Expose port
EXPOSE 80
