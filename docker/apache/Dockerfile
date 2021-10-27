FROM php:7.4-apache

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN apt-get update
RUN apt-get install -y \
    git \
    zip \
    curl \
    sudo \
    unzip \
    libicu-dev \
    libbz2-dev \
    libpng-dev \
    libjpeg-dev \
    libmcrypt-dev \
    libreadline-dev \
    libfreetype6-dev \
    g++ \
    openssl \
    ssl-cert

RUN docker-php-ext-install \
    bz2 \
    intl \
    bcmath \
    opcache \
    calendar \
    pdo_mysql \
    mysqli
    

COPY docker/apache/000-default.conf /etc/apache2/sites-avaliables/000-default.conf
RUN a2enmod rewrite headers
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer
RUN composer self-update

COPY src/ /var/www/html/

RUN useradd -G www-data,root -u 1000 -d /home/devuser devuser
RUN mkdir /etc/apache2/ssl/
RUN mkdir -p /home/devuser/.composer && \
    chown -R devuser:devuser /home/devuser

RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/apache2/ssl/cert-key.pem -out /etc/apache2/ssl/cert.pem -subj "/C=BR/ST=Lucas/L=Lucas/O=Security/OU=Development/CN=localhost"

RUN a2ensite default-ssl
RUN a2enmod ssl
RUN a2ensite default-ssl.conf

EXPOSE 80
EXPOSE 443