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


# Install composer
RUN curl -s http://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer

# Configure ApacheApache
RUN apt-get -yqq update; apt-get -yqq install apache2 libapache2-mod-php7.4
ADD domain.conf /etc/apache2/sites-available/domain.conf

ENV APACHE_RUN_USER www-data
ENV APACHE_RUN_GROUP www-data
ENV APACHE_PID_FILE /var/run/apache2.pid
ENV APACHE_RUN_DIR /var/run/apache2
ENV APACHE_LOCK_DIR /var/lock/apache2
ENV APACHE_LOG_DIR /var/log/apache2

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
#ADD apache2.conf /etc/apache2/apache2.conf
RUN a2ensite domain.conf
RUN a2dissite 000-default.conf
RUN a2enmod rewrite


# Clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN mkdir -p /var/www/project
WORKDIR /var/www/project
RUN usermod -u 1000 www-data

CMD service apache2 start

#To keep the container running
CMD ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
CMD tail -f /dev/null


EXPOSE 80
