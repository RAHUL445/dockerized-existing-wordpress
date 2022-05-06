FROM php:7.2-apache
LABEL maintainer="rahul.pandey"

RUN apt update -q && apt install -y vim curl \
    && curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
    && php wp-cli.phar --info && chmod +x wp-cli.phar && mv wp-cli.phar /usr/local/bin/wp \
    && mkdir -p /var/www/html/wordpress-code/ \
    && mkdir -p /home/docker-wordpress-conf && docker-php-ext-install mysqli pdo_mysql

WORKDIR /var/www/html/wordpress-code/

COPY docker-wordpress-conf /home/docker-wordpress-conf
COPY ./wordpress-code/ /var/www/html/wordpress-code/

RUN  echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && echo "ServerSignature Off" >> /etc/apache2/apache2.conf \
    && cp /etc/apache2/sites-available/000-default.conf /etc/apache2/sites-available/backup \
    && cp /home/docker-wordpress-conf/000-default.conf /etc/apache2/sites-available/000-default.conf \
    && a2enmod rewrite && cp /home/docker-wordpress-conf/.htaccess .htaccess \
    && cp /home/docker-wordpress-conf/wp-config.docker.php wp-config.php \
    && chmod +x /home/docker-wordpress-conf/update_url.sh \
    && cp /home/docker-wordpress-conf/update_url.sh /usr/bin/update_url











