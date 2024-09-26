FROM php:8.3.10-fpm

RUN apt-get update && apt-get install -y \
git \
unzip \
libfreetype6-dev \
libjpeg62-turbo-dev \
libicu-dev \
libmcrypt-dev \
libpng-dev \
libzip-dev \
libpq-dev \
&& pecl install mcrypt \
&& docker-php-ext-enable mcrypt \
&& docker-php-ext-configure intl \
&& docker-php-ext-install intl zip pdo_mysql \
&& pecl install xdebug \
&& docker-php-ext-enable xdebug

#### Installing Mailhog
RUN apt-get install -y golang \
&& go install github.com/mailhog/mhsendmail@latest \
&& chmod +x /root/go/bin/mhsendmail \
&& mv /root/go/bin/mhsendmail /usr/bin/mhsendmail

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY ./symfony_app /var/www/html

WORKDIR /var/www/html

CMD ["php-fpm"]