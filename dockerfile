FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    default-mysql-client \
    mariadb-client \
    git \
    curl \
    zip \
    unzip \
    libzip-dev \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libwebp-dev \
    libpq-dev \
    libonig-dev \
    libxml2-dev

# Configure GD
RUN docker-php-ext-configure gd \
    --with-freetype \
    --with-jpeg \
    --with-webp

# Install PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_mysql \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    zip

# Fix composer "dubious ownership"
RUN git config --global --add safe.directory /var/www/html

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .
RUN chmod -R 777 storage bootstrap/cache
RUN composer install

CMD ["php-fpm"]
