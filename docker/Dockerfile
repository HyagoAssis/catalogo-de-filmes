FROM php:8.4-fpm

# ─────────────────────────────
# 1. Dependências de sistema
# ─────────────────────────────
RUN apt-get update && apt-get install -y \
    git unzip zip curl vim gnupg \
    iputils-ping telnet \
    default-mysql-client \
    libpng-dev libonig-dev libxml2-dev libzip-dev libjpeg-dev libfreetype6-dev \
    libicu-dev libpq-dev libgmp-dev \
    libmemcached-dev zlib1g-dev \
    && rm -rf /var/lib/apt/lists/*

# ─────────────────────────────
# 2. Extensões PHP nativas
# ─────────────────────────────
RUN docker-php-ext-install -j$(nproc) \
    bcmath \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    zip \
    opcache \
    intl \
    gmp

# ─────────────────────────────
# 3. Extensões com configuração especial
# ─────────────────────────────
RUN docker-php-ext-configure gd --with-jpeg --with-freetype \
    && docker-php-ext-install gd

# ─────────────────────────────
# 4. Extensões via PECL (opcionais, mas úteis p/ cache/otimização)
# ─────────────────────────────
#RUN pecl install \
#    memcached \
#    msgpack \
#    igbinary \
#    && docker-php-ext-enable \
#    memcached \
#    msgpack \
#    igbinary

# ─────────────────────────────
# 5. Instala Composer
# ─────────────────────────────
RUN curl -sS https://getcomposer.org/installer | php -- --2 \
    && mv composer.phar /usr/local/bin/composer


# ─────────────────────────────
# 5. WORKDIR e ENTRYPOINT
# ─────────────────────────────
WORKDIR /var/www/backend

RUN useradd -ms /bin/bash devuser
USER devuser

ENTRYPOINT ["./entrypoint.sh"]

EXPOSE 9000
