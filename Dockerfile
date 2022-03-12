FROM php:7.3-fpm
# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    composer

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Install Composer extensions
RUN composer install

# Install Composer extensions
RUN composer install

# Install complement
RUN cp .env.example .env
RUN php artisan key:generate.
RUN chmod -R 777 storage.