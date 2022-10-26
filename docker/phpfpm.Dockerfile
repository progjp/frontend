FROM php:8.1-fpm-alpine3.16

ARG DA_DEBUGER

RUN apk add --no-cache git unzip libxml2 libxml2-dev


RUN apk add --no-cache git unzip libxml2 libxml2-dev libpng-dev libzip-dev readline-dev gettext-dev mediainfo ffmpeg groff freetype-dev libpng-dev bash libjpeg-turbo-dev icu-dev php8-pecl-apcu \
    && docker-php-ext-install -j$(nproc) bcmath calendar fileinfo gd gettext pcntl pdo pdo_mysql mysqli soap zip \
    && docker-php-ext-configure gd --with-jpeg=/usr/lib --with-freetype=/usr/include/freetype2 \
    && docker-php-ext-install gd intl \
    && apk add --no-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/community/ --allow-untrusted gnu-libiconv \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.2.17 \
    && apk add --no-cache $PHPIZE_DEPS && pecl amqp install xdebug-3.1.5 \
    && docker-php-ext-enable amqp xdebug;
