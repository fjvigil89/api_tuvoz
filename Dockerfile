# Set master image
FROM bitnami/php-fpm:7.4.28-debian-10-r48

# Set working directory
WORKDIR /var/www/html

COPY . .
EXPOSE 8000:8000
CMD ["php artisan serve"]
