# Use the official PHP Apache image
FROM php:8.1-apache

# Copy all files into the Apache web root
COPY . /var/www/html/

# Enable Apache rewrite module (optional if you use .htaccess or routing)
RUN a2enmod rewrite

# Expose port 80 to Render
EXPOSE 80
