# Set master image
FROM bitnami/php-fpm:7.4.28-debian-10-r48

# Set working directory
WORKDIR /var/www/html

COPY . .

CMD ["php artisan serve --port 80"]
