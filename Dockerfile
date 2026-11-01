FROM php:8.3-apache

RUN docker-php-ext-install mysqli pdo pdo_mysql \
    && a2enmod rewrite headers

WORKDIR /var/www/html
COPY . /var/www/html/
RUN chown -R www-data:www-data /var/www/html

# Render passes the port to listen on via $PORT
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENV PORT=10000
EXPOSE 10000
CMD ["docker-entrypoint.sh"]
