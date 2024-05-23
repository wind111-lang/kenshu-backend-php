FROM php:8.3-apache

RUN apt-get update && apt-get install -y libpq-dev && apt-get install -y git

RUN docker-php-ext-install pdo pdo_pgsql
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN a2enmod rewrite

COPY ./php.ini /usr/local/etc/php/php.ini
COPY ./apache2.conf /usr/local/apache2/conf/apache2.conf
COPY ./.htaccess /var/www/html/.htaccess
COPY ./composer.json /var/www/html/composer.json
COPY ./composer.lock /var/www/html/composer.lock
COPY ./vendor /var/www/html/vendor

WORKDIR /var/www/html
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install
RUN composer dump-autoload --optimize
