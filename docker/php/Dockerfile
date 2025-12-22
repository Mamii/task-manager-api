FROM php:8.3-fpm

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev \
    default-mysql-client iputils-ping \
    && docker-php-ext-install pdo_mysql zip gd mbstring exif pcntl bcmath \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Configure PHP
RUN echo "memory_limit=2G" > /usr/local/etc/php/conf.d/z-99-memory-limit.ini

# Set proper user permissions (1000:1000 = mamy:mamy on host)
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

WORKDIR /var/www/html

# Copy entrypoint script
COPY docker/php/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Note: Container runs as root to start php-fpm, but php-fpm workers run as www-data
# Artisan commands should be executed as www-data user
