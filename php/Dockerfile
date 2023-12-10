FROM php:8.3-apache
COPY ./php.ini /usr/local/etc/php
RUN apt-get update \
  && apt install -y libzip-dev \
  && docker-php-ext-install pdo_mysql mysqli zip
