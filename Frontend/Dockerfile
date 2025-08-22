FROM php:8.1-apache

# Enable Apache mod_rewrite (optional but useful if you need .htaccess rules)
RUN a2enmod rewrite

# Copy source code into the container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

EXPOSE 80
