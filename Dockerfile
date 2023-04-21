# Vue laravel dockerfile
FROM composer:2.0 as build
COPY . /app/
RUN composer install --prefer-dist --no-dev --optimize-autoloader --no-interaction

FROM node:14.15.4-alpine3.12 as node
COPY --from=build /app /app
RUN npm install && npm run dev

FROM php:8.2.3-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Node.js
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash -- \
    && apt-get install -y nodejs


# Create system user to run Composer and Artisan Commands
RUN useradd mike
RUN mkdir /home/mike
RUN chown mike:mike /home/mike
RUN usermod -aG sudo mike
RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

# Set working directory
WORKDIR /app
# Copy existing application directory contents
COPY . /app



USER $user

#


EXPOSE 8000
CMD php artisan serve --host=0.0.0.0 --port=8000

