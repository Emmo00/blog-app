# Use the official PHP 8.2 FPM image as the base image
FROM php:8.2-fpm

# Install necessary dependencies, including Nano
RUN apt-get update && apt-get install -y \
    apt-utils \
    build-essential \
    git \
    curl \
    libcurl4 \
    libcurl4-openssl-dev \
    zlib1g-dev \
    libzip-dev \
    zip \
    libbz2-dev \
    locales \
    libmcrypt-dev \
    libicu-dev \
    libonig-dev \
    libxml2-dev \
    libpq-dev \
    libgd-dev \
    nano \ 
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo pdo_pgsql pgsql gd sockets pdo_mysql

# Set higher memory limit
RUN echo "memory_limit=2048M" > /usr/local/etc/php/conf.d/memory-limit.ini

# Set higher file upload size
RUN echo "upload_max_filesize=32M" > /usr/local/etc/php/conf.d/upload-filesize.ini \
    && echo "post_max_size=32M" >> /usr/local/etc/php/conf.d/upload-filesize.ini

# Set up locales
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen && locale-gen

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer self-update

WORKDIR /var/www
COPY . .

# Set the environment variable for Composer timeout
ENV COMPOSER_PROCESS_TIMEOUT=600

# Install dependencies and update the lock file
RUN composer install 

# Set permissions (adjust as needed)
RUN chown -R www-data:www-data storage bootstrap/cache




# Run Laravel Artisan commands
RUN composer dump-autoload \
    && php artisan config:cache \
    && php artisan route:clear \
    && php artisan cache:clear \
    && php artisan config:cache \
    && php artisan migrate --force

CMD ["php-fpm"]
