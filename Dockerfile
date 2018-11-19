FROM php:7.2-apache-stretch

WORKDIR /app

ENV APACHE_DOCUMENT_ROOT /app/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

RUN apt-get clean
RUN apt-get update
RUN apt-get install -y --no-install-recommends apt-utils

RUN apt-get install -y git curl vim nano wget gnupg

RUN curl -sL https://deb.nodesource.com/setup_11.x | bash -
RUN apt-get install -y nodejs

RUN curl -s http://getcomposer.org/installer | php && \
echo "export PATH=${PATH}:/var/www/vendor/bin" >> ~/.bashrc && \
mv composer.phar /usr/local/bin/composer

RUN apt-get clean

ENTRYPOINT ["./entrypoint.sh"]

CMD ["apache2-foreground"]