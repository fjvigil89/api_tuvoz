# Set master image
FROM php:7.3-fpm


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



# Install Redis, Imagick xDebug (Optional, but reccomended) and clear temp files
RUN pecl install -o -f redis \
    imagick \
    xdebug \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis \
    imagick \
    xdebug
# Install composer: This could be removed and run in it's own container
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# xdebug.remote_connect_back = true does NOT work in docker
RUN echo '\n\
    [Xdebug]\n\
    xdebug.remote_enable=true\n\
    xdebug.remote_autostart=true\n\
    xdebug.remote_port=9000\n\
    xdebug.remote_host=docker.host.internal\n'\
    >> /usr/local/etc/php/php.ini


# Config php.init
RUN echo "request_terminate_timeout = 3600" >> /usr/local/etc/php-fpm.conf
RUN echo "max_execution_time = 180" >> /usr/local/etc/php/php.ini
RUN echo "post_max_size = 512M" >> /usr/local/etc/php/php.ini
RUN echo "memory_limit = 128M" >> /usr/local/etc/php/php.ini

COPY . .
