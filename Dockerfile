# Set master image
FROM drcreazy/php-fpm73-alpine

# Set working directory
WORKDIR /var/www/html

COPY . .
# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm", "php artisan serve --port 80"]
