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
    
RUN a2enmod ssl
RUN a2enmod rewrite
RUN a2enmod headers

RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
RUN chmod +x /usr/local/bin/composer
RUN composer self-update

RUN useradd -G www-data,root -u 1000 -d /home/devuser devuser
RUN mkdir -p /home/devuser/.composer && \
    chown -R devuser:devuser /home/devuser

RUN mkdir /etc/apache2/ssl/
COPY ./cert/req.cnf /etc/apache2/req.cnf
RUN openssl req -x509 -nodes -days 365 -newkey rsa:2048 -keyout /etc/ssl/private/localhost.key -out /etc/ssl/certs/localhost.crt -config /etc/apache2/req.cnf -sha256
RUN chmod 644 /etc/ssl/certs/localhost.crt
RUN chmod 644 /etc/ssl/private/localhost.key
COPY ./000-default.conf /etc/apache2/sites-enabled/000-default.conf

RUN update-ca-certificates
RUN service apache2 restart

EXPOSE 80
EXPOSE 443