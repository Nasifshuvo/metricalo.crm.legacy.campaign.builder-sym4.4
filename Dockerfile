FROM php:7.4-fpm-alpine3.12

WORKDIR /var/www

# Install dependencies and the xsl extension
RUN apk add --no-cache libxslt-dev \
    && docker-php-ext-install xsl

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy application files
COPY . /var/www

# Adjust ownership of the application files
RUN chown -R www-data:www-data /var/www

# Install Composer dependencies as www-data
USER www-data

RUN composer install --no-interaction --optimize-autoloader

# Switch back to root if necessary for other operations
USER root

# Expose port if necessary
EXPOSE 9000

# Start php-fpm
CMD ["php-fpm"]