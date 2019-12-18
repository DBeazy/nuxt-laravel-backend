FROM php:7.3-fpm

RUN apt-get -qq update \
    && apt-get -y upgrade \
    && apt-get install -y \
        git \
        zip \
        build-essential \
        software-properties-common \
        libyaml-dev \
        libcurl4-openssl-dev \
        pkg-config \
        libssl-dev \
    && apt-get -y -f install \
    && apt-get -y update

#RUN docker-php-ext-install pdo pdo_mysql mysqli \
#    && docker-php-ext-enable pdo pdo_mysql mysqli

#RUN pecl install xdebug-2.7.2 \
#    && docker-php-ext-enable xdebug

RUN pecl install yaml-2.0.4 \
    && docker-php-ext-enable yaml

RUN pecl install mongodb-1.6.1 \
    && docker-php-ext-enable mongodb

WORKDIR /var/www/

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php composer-setup.php --install-dir=/bin --filename=composer
RUN php -r "unlink('composer-setup.php');"

