FROM php:8.3-fpm-alpine

RUN apk update && apk upgrade --no-cache

# ── System dependencies ────────────────────────────────────────────────────
RUN apk add --no-cache \
    git \
    curl \
    curl-dev \
    bash \
    libpng-dev \
    libxml2-dev \
    zip \
    unzip \
    oniguruma-dev \
    libzip-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    libwebp-dev \
    icu-dev \
    linux-headers

# ── PHP core extensions ────────────────────────────────────────────────────
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        intl \
        zip \
        gd \
        dom \
        fileinfo \
        xml \
        curl \
        opcache

# ── Redis via PECL ─────────────────────────────────────────────────────────
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps

# ── xlswriter via PECL ─────────────────────────────────────────────────────
# Gunakan $PHPIZE_DEPS bawaan image (bukan php83-dev alpine yang konflik)
RUN apk add --no-cache --virtual .build-deps-xl $PHPIZE_DEPS \
        zlib-dev \
        cmake \
        make \
        g++ \
        autoconf \
        build-base \
    && pecl install xlswriter \
    && docker-php-ext-enable xlswriter \
    && apk del .build-deps-xl

# ── Chromium & fonts (untuk PDF) ──────────────────────────────────────────
RUN apk add --no-cache \
    chromium \
    nss \
    freetype \
    harfbuzz \
    ca-certificates \
    ttf-freefont \
    fontconfig

# Install Microsoft core fonts (optional - skip jika gagal)
RUN apk add --no-cache msttcorefonts-installer \
    && update-ms-fonts \
    && fc-cache -f \
    || true

# ── Node / npm ─────────────────────────────────────────────────────────────
RUN apk add --no-cache nodejs npm

# ── Composer ───────────────────────────────────────────────────────────────
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ── Composer env ───────────────────────────────────────────────────────────
ENV COMPOSER_MEMORY_LIMIT=-1 \
    COMPOSER_ALLOW_SUPERUSER=1 \
    COMPOSER_NO_INTERACTION=1

# ── Working directory ──────────────────────────────────────────────────────
WORKDIR /var/www/html

# ── Copy project files ─────────────────────────────────────────────────────
# Build context harus dari root project: docker build -f docker/php/Dockerfile .
COPY . .

# ── Composer install ───────────────────────────────────────────────────────
RUN composer install --no-scripts --no-autoloader

# ── Laravel storage dirs ───────────────────────────────────────────────────
RUN mkdir -p \
    storage/logs \
    storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    storage/app/public \
    storage/app/private \
    bootstrap/cache

# ── NPM install & build ────────────────────────────────────────────────────
RUN npm install --production


# ── Set permissions ────────────────────────────────────────────────────────
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && find /var/www/html/storage -type d -exec chmod 775 {} \; \
    && find /var/www/html/storage -type f -exec chmod 664 {} \; \
    && find /var/www/html/bootstrap/cache -type d -exec chmod 775 {} \; \
    && find /var/www/html/bootstrap/cache -type f -exec chmod 664 {} \;

# ── PHP custom config ──────────────────────────────────────────────────────
COPY docker/php/php.ini /usr/local/etc/php/conf.d/99-custom.ini

# ── Expose & start ─────────────────────────────────────────────────────────
EXPOSE 9000
CMD ["php-fpm"]
