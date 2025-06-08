FROM php:8.1-apache

RUN docker-php-ext-install mysqli

# Copy only the TugasCRUD folder content to Apache's root
COPY TugasCRUD/ /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Enable mod_rewrite if needed
RUN a2enmod rewrite

EXPOSE 80
