FROM php:7.4-apache

RUN apt-getupdate \
&& apt-get install -y \
&& apt-get autoremove -y \
&& docker-php-ext-install mysqlipdopdo_mysql \
&& apt-get installcurl-y \
&& apt-get installgit -y \
&& apt-get installzip -y \
&& curl-sS https://get.symfony.com/cli/installer | bash \
&& mv /root/.symfony/bin/symfony /usr/local/bin/symfony

COPY --from=composer /usr/bin/composer /usr/bin/composer 
WORKDIR /var/www/html/matetesymfony/
CMD composer install ; symfony server:start
EXPOSE 8756