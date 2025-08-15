# ===== Stage 1: PHP deps (composer) =====
FROM php:8.2-fpm AS php-deps

RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libonig-dev libxml2-dev build-essential \
  && docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install pdo_mysql mbstring zip exif pcntl gd bcmath opcache \
  && rm -rf /var/lib/apt/lists/*

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Cache layer composer
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --no-dev --no-scripts --optimize-autoloader

# ===== Stage 2: Frontend build (node) =====
FROM node:20 AS assets
WORKDIR /app

# Cache layer npm
COPY package.json package-lock.json* yarn.lock* pnpm-lock.yaml* .npmrc* ./
RUN if [ -f package-lock.json ]; then npm ci; \
    elif [ -f yarn.lock ]; then yarn install --frozen-lockfile; \
    elif [ -f pnpm-lock.yaml ]; then corepack enable && pnpm i --frozen-lockfile; \
    else npm i; fi

# Copy source yang diperlukan untuk build aset (hemat layer)
COPY resources ./resources
COPY vite.config.* postcss.config.* tailwind.config.* ./
COPY --from=php-deps /var/www/vendor ./vendor
# Build (sesuaikan command kamu)
RUN npm run build

# ===== Stage 3: Final runtime image =====
FROM php:8.2-fpm AS app

# (Optional) php.ini production tweaks
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
 && { \
    echo "opcache.enable=1"; \
    echo "opcache.validate_timestamps=0"; \
    echo "opcache.jit=1255"; \
    echo "opcache.jit_buffer_size=64M"; \
 } > /usr/local/etc/php/conf.d/opcache.ini

# Install libs minimal runtime + deps untuk build ekstensi
RUN apt-get update && apt-get install -y \
    libzip-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev \
    libonig-dev libxml2-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) pdo_mysql mbstring zip exif bcmath gd \
 && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www

# Copy vendor dari stage composer
COPY --from=php-deps /var/www/vendor ./vendor
# Copy seluruh app (kecuali yang di-ignore oleh .dockerignore)
COPY . .

# Copy hasil build aset dari stage node (sesuaikan path output Vite)
COPY --from=assets /app/public ./public

# Siapkan folder writeable
RUN mkdir -p bootstrap/cache storage/framework/{sessions,cache,views} storage/logs \
 && chown -R www-data:www-data storage bootstrap/cache \
 && chmod -R ug+rwX,o-rwx storage bootstrap/cache