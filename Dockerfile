FROM ubuntu/nginx:1.18-21.10_beta

EXPOSE 80:80
ADD ./* /var/www/html
ADD nginx.conf /etc/nginx/nginx.conf