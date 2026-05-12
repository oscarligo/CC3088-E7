FROM php:8.4-cli-bookworm

WORKDIR /var/www/html

# Instalamos solo dependencias de sistema
# SQLite y PDO_SQLite YA vienen incluidos en esta imagen base
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libzip-dev \
    && docker-php-ext-install zip \
    && rm -rf /var/lib/apt/lists/*

# Copiamos Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Dependencias de PHP
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --optimize-autoloader --no-progress --no-scripts

# Copiamos el proyecto
COPY . .

# Permisos y base de datos
RUN mkdir -p storage/framework/cache storage/framework/sessions storage/framework/views bootstrap/cache database \
    && touch database/database.sqlite \
    && chmod -R 775 storage bootstrap/cache database

EXPOSE 8000

# Comando de inicio
CMD ["sh", "-c", "php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000"]