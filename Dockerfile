# FROM php:8.2-fpm

# # Cài extension PHP
# RUN docker-php-ext-install pdo pdo_mysql

# # Cài Composer
# COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# WORKDIR /var/www

FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git zip unzip libpng-dev libjpeg-dev libfreetype6-dev vim curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql gd

RUN echo "opcache.enable=0\nopcache.validate_timestamps=1\nopcache.revalidate_freq=0" > /usr/local/etc/php/conf.d/opcache.ini

# Tăng giới hạn upload file và execution time
RUN echo "upload_max_filesize=10M\npost_max_size=20M\nmax_execution_time=300\nmax_input_time=300" > /usr/local/etc/php/conf.d/uploads.ini

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www


