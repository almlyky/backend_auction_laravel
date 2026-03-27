FROM php:8.2-cli

# تثبيت أدوات
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip \
    && docker-php-ext-install zip

# تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

# تثبيت Laravel dependencies
RUN composer install

# تشغيل السيرفر
CMD php artisan serve --host=0.0.0.0 --port=10000