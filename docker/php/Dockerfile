FROM php:7.4.9-fpm

RUN apt-get update

RUN apt-get install -y zlib1g-dev libzip-dev
RUN docker-php-ext-install zip \
&& docker-php-ext-enable zip

COPY --from=composer:2.0 /usr/bin/composer /usr/local/bin/composer

COPY ./entrypoint.sh /entrypoint.sh
RUN chmod a+x /entrypoint.sh
CMD /entrypoint.sh
