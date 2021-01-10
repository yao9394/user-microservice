FROM ubuntu:20.04

ARG DEBIAN_FRONTEND=noninteractive

RUN apt-get update -y \
    && apt-get upgrade -y \
    && apt-get install -y nginx\
    sudo \
    apt-utils \
    curl \
    git \
    php-common \
    php-fpm \
    php-mysql \
    php-xdebug \
    php-xml \
    php-mbstring \
    php-zip \
    php-bcmath \
    locales

RUN locale-gen en_AU.UTF-8

RUN cd /usr/local/lib/ && curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

RUN mkdir /siteroot

RUN rm /etc/nginx/sites-available/default
COPY nginx-site.conf /etc/nginx/sites-available/default

RUN rm /etc/nginx/nginx.conf
COPY nginx.conf /etc/nginx/nginx.conf

COPY php.ini /etc/php7.4/fpm/php.ini

WORKDIR /siteroot

CMD service php7.4-fpm start && nginx
