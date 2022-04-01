FROM ubuntu/nginx:1.18-21.10_beta

EXPOSE 80:80

WORKDIR /app
COPY ./nginx.conf /etc/nginx/nginx.conf

ADD . .
