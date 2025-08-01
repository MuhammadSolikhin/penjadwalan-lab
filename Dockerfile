# Gunakan image PHP 8.2 FPM sebagai dasar
FROM php:8.2-fpm

# Install dependensi sistem yang dibutuhkan
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim unzip git curl \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    nodejs \
    npm

# Install ekstensi PHP yang dibutuhkan Laravel
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl gd

# Install Composer secara global
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Atur direktori kerja
WORKDIR /var/www

# Copy seluruh file proyek
COPY . .

# Buat SEMUA direktori yang dibutuhkan Laravel dan berikan izin SEBELUM menjalankan composer.
RUN mkdir -p bootstrap/cache \
    && mkdir -p storage/framework/sessions \
    && mkdir -p storage/framework/views \
    && mkdir -p storage/framework/cache \
    && mkdir -p storage/logs \
    && chmod -R 777 bootstrap/cache \
    && chmod -R 777 storage

# 1. Install dependensi PHP (Composer) terlebih dahulu
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 2. Setelah /vendor ada, baru install dependensi NPM
RUN npm install

# 3. Setelah dependensi NPM ter-install, baru build aset
RUN npm run build

# Atur kepemilikan hanya pada folder yang membutuhkan izin tulis oleh Laravel
RUN chown -R www-data:www-data storage bootstrap/cache