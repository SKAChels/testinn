FROM php:7.4.9-fpm

ENV DEBIAN_FRONTEND=noninteractive
RUN apt-get update && \
    apt-get install -y zlib1g-dev libzip-dev && \
    docker-php-ext-install zip && \
    docker-php-ext-enable zip

RUN apt-get install -y libpq-dev libicu-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev gnupg2 && \
    docker-php-ext-configure gd --with-jpeg --with-freetype && \
    docker-php-ext-install opcache gd

ENV PHP_USER_ID=33 \
    TERM=linux

COPY ./entrypoint.sh /entrypoint.sh
RUN chmod a+x /entrypoint.sh

ARG ENV
COPY devinstall.sh devinstall.sh
RUN chmod u+x devinstall.sh && ./devinstall.sh
