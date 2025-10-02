# ===== Stage 1: PHP deps (composer) =====
FROM php:8.2-fpm-alpine AS php-deps

RUN apk add --no-cache git unzip libzip-dev libpng-dev libjpeg-turbo-dev \
    freetype-dev oniguruma-dev libxml2-dev icu-dev autoconf g++ make \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install pdo_mysql mbstring zip exif bcmath gd opcache intl

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --no-dev --no-scripts --optimize-autoloader

# ===== Stage 2: Frontend build (node) =====
FROM node:20-alpine AS assets
WORKDIR /app

# Cache layer for JS deps
COPY package.json package-lock.json* yarn.lock* pnpm-lock.yaml* .npmrc* ./
RUN if [ -f package-lock.json ]; then npm ci; \
    elif [ -f yarn.lock ]; then yarn install --frozen-lockfile; \
    elif [ -f pnpm-lock.yaml ]; then corepack enable && pnpm i --frozen-lockfile; \
    else npm i; fi

# Copy only what's needed to build assets
COPY resources ./resources
COPY vite.config.* postcss.config.* tailwind.config.* ./
# In case your Vite build references vendor (ziggy, etc.)
COPY --from=php-deps /var/www/vendor ./vendor

RUN npm run build

# ===== Stage 3: Final runtime image (PHP-FPM) =====
FROM php:8.2-fpm-alpine AS app

# php.ini production + opcache
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini" \
 && { echo "opcache.enable=1"; \
      echo "opcache.enable_cli=0"; \
      echo "opcache.validate_timestamps=0"; \
      echo "opcache.max_accelerated_files=20000"; \
      echo "opcache.memory_consumption=256"; \
      echo "opcache.interned_strings_buffer=16"; } > /usr/local/etc/php/conf.d/opcache.ini

# Runtime libs needed by the extensions
RUN apk add --no-cache libzip libpng libjpeg-turbo freetype oniguruma libxml2 icu-libs

# ⬇️ bring in the compiled PHP extensions & their INI from php-deps
COPY --from=php-deps /usr/local/lib/php/extensions /usr/local/lib/php/extensions
COPY --from=php-deps /usr/local/etc/php/conf.d /usr/local/etc/php/conf.d

WORKDIR /var/www

# Copy the application (respects .dockerignore)
COPY . .

# Vendor from composer stage
COPY --from=php-deps /var/www/vendor ./vendor

# Copy built assets (only /public/build so we don't overwrite public/index.php)
COPY --from=assets /app/public/build ./public/build

# Safety: never ship stale caches
RUN rm -f bootstrap/cache/*.php \
 && mkdir -p storage/framework/{sessions,cache,views} storage/logs bootstrap/cache \
 && chown -R www-data:www-data storage bootstrap/cache

EXPOSE 9000
CMD ["php-fpm"]

# ===== Stage 4: Nginx image shipping only public/ and config =====
FROM nginx:1.27-alpine AS nginx
# Your nginx vhost
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
# Publish static files + front controller
COPY --from=app /var/www/public /var/www/public
