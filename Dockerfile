# Set master image
FROM ubuntu:focal

# Set working directory
WORKDIR /var/www/html

COPY . .
EXPOSE 8000:8000
CMD ["php artisan serve"]
