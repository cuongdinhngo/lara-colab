FROM ubuntu:20.04

MAINTAINER cuong.ngo

RUN apt-get update && apt-get install -y --no-install-recommends apt-utils

RUN apt-get update && apt-get install -y language-pack-en

RUN locale-gen en_US.UTF-8

ENV LANGUAGE=en_US.UTF-8
ENV LC_ALL=en_US.UTF-8
ENV LC_CTYPE=UTF-8
ENV LANG=en_US.UTF-8
ENV TERM xterm

ARG DEBIAN_FRONTEND=noninteractive

# Install PHP-CLI 7, some PHP extentions and some useful Tools with APT
RUN apt-get update && apt-get install -y --allow-remove-essential \
        php \
        php-fpm \
        php-cli \
        php-dev \
        php-phpdbg \
        php-common \
        php-curl \
        php-json \
        php-xml \
        php-mbstring \
        php-mysql \
        php-pgsql \
        php-zip \
        php-imagick \
        git \
        curl \
        vim \
        nano \
        php7.4-gd \
        npm \
        telnetd \
        wget \
    && apt-get clean


# Install NodeJs 12x
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash
RUN apt-get install -y nodejs

# Install composer
RUN curl -s http://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Configure Nginx
RUN apt-get -yqq update; apt-get -yqq install nginx
ADD default.conf /etc/nginx/conf.d/default.conf
ADD nginx.conf /etc/nginx/nginx.conf

# Clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN mkdir -p /var/www/project
WORKDIR /var/www/project

RUN usermod -u 1000 www-data

CMD service php7.4-fpm start && nginx

EXPOSE 80
