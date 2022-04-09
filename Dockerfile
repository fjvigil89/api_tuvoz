# Set master image
FROM php:7.3.33-cli-alpine3.14


# EXPOSE 8080
# Set working directory
ENV DB_CONNECTION mysql
ENV DB_HOST ""
ENV DB_PORT 0
ENV DB_DATABASE ""
ENV DB_USERNAME ""
ENV DB_PASSWORD ""


WORKDIR /var/www/html



# Config php.init
#RUN echo "request_terminate_timeout = 3600" >> /usr/local/etc/php-fpm.conf
RUN echo "max_execution_time = 180" >> /usr/local/etc/php/php.ini
RUN echo "post_max_size = 512M" >> /usr/local/etc/php/php.ini
RUN echo "memory_limit = 128M" >> /usr/local/etc/php/php.ini
RUN echo "extension = pdo_mysql" >> /usr/local/etc/php/php.ini


COPY . .
