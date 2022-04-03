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
COPY . .
