FROM connectivdocker/php:7.2-apache

LABEL MAINTAINER="thaild <thai.le.connectiv@gmail.com>"

# Configure vhost
COPY conf/virtualhosts/liris.conf /etc/apache2/sites-available/
RUN a2dissite 000-default
RUN a2ensite liris

# Set the locale
RUN apt-get install locales-all -y
RUN locale-gen en_US.UTF-8 en_GB.UTF-8 es_ES.UTF-8 ja_JP.UTF-8 vi_VN UTF-8 zh_CN.UTF-8
RUN localedef -f UTF-8 -i ja_JP ja_JP.UTF-8
RUN export LC_ALL="ja_JP.UTF-8" LC_TIME="ja_JP.UTF-8" LANG="ja_JP.UTF-8"  LANGUAGE="ja_JP.UTF-8"

