FROM composer:2.7 as builder

WORKDIR /app

# Instalar extensões para o build
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

# --- FASE FINAL ---

FROM php:8.2-fpm-alpine

# Removi o 'nginx' e o 'git' daqui pois não vamos usar para rodar o artisan serve
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

WORKDIR /var/www/html

COPY --from=builder /app /var/www/html

RUN chown -R www-data:www-data /var/www/html/storage \
    /var/www/html/bootstrap/cache

# ATENÇÃO: Removi o 'config:cache' daqui.
# Motivo: As variáveis de ambiente do Render só entram DEPOIS que o Docker é construído.
# Se você cachear aqui, o Laravel vai salvar senhas em branco e não vai conectar no banco.
RUN php artisan package:discover
RUN php artisan route:cache

# Expomos a porta 8000 (Padrão do artisan serve)
EXPOSE 8000

# O comando mágico que resolve o problema de conexão
CMD php artisan serve --host=0.0.0.0 --port=8000