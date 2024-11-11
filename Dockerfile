FROM php:fpm-alpine
RUN apk --no-cache add \
    libmcrypt-dev \
    zlib-dev \
    && docker-php-ext-install pdo_mysql \
    && apk del libmcrypt-dev zlib-dev
