# Set master image
FROM php:7.3.33-zts-alpine3.14

# EXPOSE 8080
# Set working directory
WORKDIR /var/www/html
COPY . .
