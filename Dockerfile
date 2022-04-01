FROM ubuntu/apache2:2.4-21.10_beta 

EXPOSE 80:80

WORKDIR /app

ADD . .
COPY ./apache2.conf /etc/apache2/apache2.conf
RUN a2enmod rewrite 