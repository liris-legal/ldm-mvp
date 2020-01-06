FROM connectivdocker/php:7.2-apache

LABEL MAINTAINER="thaild <thai.le.connectiv@gmail.com>"

# Configure vhost
COPY conf/virtualhosts/liris.conf /etc/apache2/sites-available/
RUN a2dissite 000-default
RUN a2ensite liris

