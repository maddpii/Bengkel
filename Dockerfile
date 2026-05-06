FROM php:8.2-fpm

RUN apt update && apt install -y \
    git unzip curl \
    && docker-php-ext-install pdo pdo_mysql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . .

RUN composer install --optimize-autoloader --no-dev
RUN php artisan config:clear
RUN chmod -R 777 storage bootstrap/cache
EXPOSE 9000
CMD ["php-fpm"]
