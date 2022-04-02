# Set master image
FROM php:7.3.33-zts-alpine3.14

EXPOSE 8080
# Set working directory
WORKDIR /app
COPY . .

CMD php artisan serve --host 0.0.0.0 --port=8080
