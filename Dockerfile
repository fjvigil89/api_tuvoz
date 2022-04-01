FROM ubuntu/apache2:2.4-21.10_beta 

EXPOSE 80:80

WORKDIR /app

ADD . .
 