FROM php:8.3-apache

RUN apt-get -y update
RUN apt-get -y upgrade
RUN apt-get install -y sqlite3 libsqlite3-dev
RUN apt-get clean

COPY ./apache/000-default.conf /etc/apache2/sites-available/000-default.conf

COPY ./sqlite/app.sqlite /sqlite/app.sqlite
COPY ./init.sh /init.sh
RUN chmod +x /init.sh

EXPOSE 80

CMD ["/bin/sh", "/init.sh"]