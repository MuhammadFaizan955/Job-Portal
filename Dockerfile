FROM php:8.3.30(cli)

WORKDIR /app

# system packages
RUN apt-get update && apt-get install -y \
    git unzip curl libpng-dev libonig-dev libxml2-dev zip

# PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring

# composer install
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# project copy
COPY . .

# install dependencies
RUN composer install

# Laravel permissions
RUN chmod -R 777 storage bootstrap/cache

EXPOSE 8000

CMD php artisan serve --host=0.0.0.0 --port=8000