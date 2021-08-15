FROM php:8.0.9-fpm

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN apt-get update && apt-get install -y \
    git-core \
    curl \
    build-essential \
    openssl \
    libssl-dev \
    nodejs \
    npm
RUN npm install -g n && n lts