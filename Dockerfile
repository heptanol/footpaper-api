# Dockerfile
FROM php:7.2-apache

ENV COMPOSER_ALLOW_SUPERUSER=1
EXPOSE 80

RUN apt-get update -qy && \
    apt-get install -y \
    git \
    libicu-dev \
    unzip \
    zip && \
    curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    apt-get clean && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

# PHP Extensions
RUN docker-php-ext-install -j$(nproc) opcache pdo_mysql
ADD docker/conf/php.ini /usr/local/etc/php/conf.d/app.ini

# Apache
ADD docker/errors /errors
RUN a2enmod rewrite remoteip
ADD docker/conf/vhost.conf /etc/apache2/sites-available/000-default.conf
ADD docker/conf/apache.conf /etc/apache2/conf-available/z-app.conf
RUN a2enconf z-app
ADD . /app
