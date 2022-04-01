FROM ubuntu/apache2:2.4-20.04_edge 

EXPOSE 80:80

WORKDIR /app
COPY ./apache2.conf /etc/apache2/apache2.conf

ADD . .
