# Set master image
FROM php:7.3.33-zts-alpine3.14

EXPOSE 80
# Set working directory
WORKDIR /app
COPY . .

CMD php artisan serve  --port=80
