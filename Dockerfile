# Gunakan image PHP 8.2 FPM sebagai dasar
FROM php:8.2-fpm

# Install dependensi sistem yang dibutuhkan Laravel
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
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl gd

# Install Composer secara global
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Atur direktori kerja
WORKDIR /var/www

# Copy seluruh file proyek
COPY . .

# Buat direktori cache dan storage SEBELUM menjalankan composer install.
# Ini untuk mengatasi error "Please provide a valid cache path."
RUN mkdir -p /var/www/bootstrap/cache \
    && mkdir -p /var/www/storage/framework/sessions \
    && mkdir -p /var/www/storage/framework/views \
    && mkdir -p /var/www/storage/framework/cache \
    && mkdir -p /var/www/storage/logs

# Berikan izin tulis ke direktori tersebut untuk semua user
RUN chmod -R 777 /var/www/bootstrap/cache \
    && chmod -R 777 /var/www/storage

# Install dependensi Composer untuk produksi
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Atur kepemilikan file ke user www-data (praktik terbaik)
RUN chown -R www-data:www-data /var/www