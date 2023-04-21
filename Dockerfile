# Vue laravel dockerfile
FROM php:8.2.3-cli

RUN apt-get update -y && apt-get install -y libmcrypt-dev
# install nodejs
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash -
RUN apt-get install -y nodejs
# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo
# install git
RUN apt-get install -y git

# Install extensions for php
RUN docker-php-ext-install pdo_mysql
RUN docker-php-ext-install gd

WORKDIR /app
COPY . /app

RUN composer install
RUN npm install

# vue laravel
RUN npm run dev





EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000

