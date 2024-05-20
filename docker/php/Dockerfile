FROM php:8.0-apache

RUN apt-get update && apt-get install -y libpq-dev
RUN docker-php-ext-install pdo pdo_pgsql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN a2enmod rewrite

COPY ./php.ini /usr/local/etc/php/php.ini
COPY ./apache2.conf /usr/local/apache2/conf/apache2.conf
COPY ./.htaccess /usr/local/apache2/htdocs/
