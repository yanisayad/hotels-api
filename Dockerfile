FROM php:7.1-fpm

WORKDIR /

RUN apt-get update
RUN apt-get install -y wget nano curl git unzip
RUN apt-get install -y mysql-server mysql-client
RUN docker-php-ext-install pdo pdo_mysql

RUN /etc/init.d/mysql start && \
    mysql -u root -proot  -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost' IDENTIFIED BY 'root';FLUSH PRIVILEGES;"

RUN service mysql start && mysql -uroot -proot -e "CREATE DATABASE clo5"

RUN git clone https://github.com/yanisayad/hotels-api
WORKDIR /hotels-api

RUN service mysql start && mysql -uroot -proot clo5 < spe-clo5_2019-03-21.sql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN rm -rf vendor/

RUN composer install

EXPOSE 7777

CMD service mysql start && php -S 0.0.0.0:7777 -t public public/index.php

ENTRYPOINT service mysql start && php -S 0.0.0.0:7777 -t public public/index.php
