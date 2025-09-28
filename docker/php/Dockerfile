FROM php:8.3-fpm-alpine

# Install system dependencies untuk Laravel dan extensions PHP
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    oniguruma-dev \
    libzip-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    icu-dev

# Konfigurasi dan install extension PHP standar Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        intl \
        zip \
        gd

# Install Redis extension via PECL
RUN apk add --no-cache --virtual .build-deps-redis $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps-redis

# Install xlswriter extension via PECL (dengan dependencies lengkap)
RUN apk add --no-cache --virtual .build-deps-xlswriter \
        autoconf \
        build-base \
        cmake \
        make \
        g++ \
        zlib-dev \
        curl-dev \
        openssl-dev \
        php83-dev \
    && pecl install xlswriter \
    && docker-php-ext-enable xlswriter \
    && apk del .build-deps-xlswriter

# Salin Composer dari image resmi
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set direktori kerja
WORKDIR /var/www/html

# Salin semua file project ke container
COPY ../../../../.. .

# Install dependency PHP menggunakan composer
RUN composer install --optimize-autoloader --no-interaction --no-progress

# Buat direktori yang dibutuhkan Laravel
RUN mkdir -p /var/www/html/storage/logs \
    && mkdir -p /var/www/html/storage/framework/cache \
    && mkdir -p /var/www/html/storage/framework/sessions \
    && mkdir -p /var/www/html/storage/framework/views \
    && mkdir -p /var/www/html/bootstrap/cache

# Set permission Laravel
RUN chown -R www-data:www-data /var/www/html \
    && find /var/www/html/storage -type f -exec chmod 664 {} \; \
    && find /var/www/html/storage -type d -exec chmod 775 {} \; \
    && find /var/www/html/bootstrap/cache -type f -exec chmod 664 {} \; \
    && find /var/www/html/bootstrap/cache -type d -exec chmod 775 {} \;

# Optional: Salin konfigurasi PHP custom
COPY docker/php/php.ini /usr/local/etc/php/conf.d/99-custom.ini

# Expose port FPM
EXPOSE 9000

# Jalankan PHP-FPM
CMD ["php-fpm"]
