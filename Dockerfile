
FROM php:7.4-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN adduser --disabled-password --gecos "" www

COPY . /var/www/html

COPY --chown=www:www . /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY --from=spiralscout/roadrunner:2.4.2 /usr/bin/rr /usr/bin/rr

RUN composer install --working-dir=/var/www/html/pijaossalud

USER www

EXPOSE 9000
CMD ["php-fpm"]


