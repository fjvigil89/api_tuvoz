# Set master image
FROM php:7.3-fpm-stretch 


# EXPOSE 8080
# Set working directory
ENV DB_CONNECTION mysql
ENV DB_HOST ""
ENV DB_PORT 0
ENV DB_DATABASE ""
ENV DB_USERNAME ""
ENV DB_PASSWORD ""


WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y --quiet ca-certificates \
    build-essential \
    mariadb-client \
    libpng-dev \
    libxml2-dev \
    libxrender1 \
    wkhtmltopdf \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    curl \
    libmcrypt-dev \
    msmtp \
    iproute2 \
    libmagickwand-dev

# Install extensions: Some extentions are better installed using this method than apt in docker
RUN docker-php-ext-configure gd --with-gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ --with-png-dir=/usr/include/ \
    && docker-php-ext-install \
        pdo_mysql \
        mbstring \
        zip \
        exif \
        pcntl \
        xml \
        soap \
        bcmath \
        gd

# Config php.init
RUN echo "request_terminate_timeout = 3600" >> /usr/local/etc/php-fpm.conf
RUN echo "max_execution_time = 180" >> /usr/local/etc/php/php.ini
RUN echo "post_max_size = 512M" >> /usr/local/etc/php/php.ini
RUN echo "memory_limit = 128M" >> /usr/local/etc/php/php.ini
  
COPY . .
