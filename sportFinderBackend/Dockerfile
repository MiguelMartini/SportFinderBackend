FROM composer:2.7 as builder

WORKDIR /app

# Instalar extensões PHP necessárias para rodar o artisan na fase de build
RUN apk add --no-cache \
    libpng-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev

RUN docker-php-ext-install \
    pdo_mysql \
    intl \
    zip \
    gd

COPY composer.json composer.lock ./

RUN composer install --no-dev --optimize-autoloader --no-scripts

COPY . .

# Não rode cache aqui — só na imagem final

FROM php:8.2-fpm-alpine

RUN apk add --no-cache \
    git \
    mysql-client \
    nginx \
    libpng-dev \
    libzip-dev \
    icu-dev \
    oniguruma-dev

RUN docker-php-ext-install \
    pdo_mysql \
    intl \
    zip \
    gd

WORKDIR /var/www/html

COPY --from=builder /app /var/www/html

RUN chown -R www-data:www-data /var/www/html/storage \
    /var/www/html/bootstrap/cache

# Agora sim
RUN php artisan package:discover
RUN php artisan config:cache
RUN php artisan route:cache

EXPOSE 9000

CMD ["php-fpm"]
