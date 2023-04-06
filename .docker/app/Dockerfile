FROM php:8.1-fpm-buster

ENV COMPOSER_HOME=/home/www-data/.composer
ENV APP_ENV=dev
ENV DATABASE_URL="postgresql://topconnect:somepassword@topconnect_db:5432/topconnect?serverVersion=14&charset=utf8"
ENV TRAEFIK_NETWORK_NAME=traefik_traefik
ENV CORS_ALLOW_ORIGIN='*'
ENV IPN_URL=http://esim-api.docker/api/payment/complete/topconnect

USER root

RUN apt-get update && apt-get install -y\
    git \
    zip \
    libpq-dev

RUN docker-php-ext-install pdo pdo_pgsql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.2.5
RUN mkdir -p /home/www-data/.composer/cache/vcs
RUN chmod -R 777 /home/www-data/.composer

RUN mkdir -p /home/www-data/.ssh
RUN echo "Host *\n\tStrictHostKeyChecking no\n\n\n" >> /home/www-data/.ssh/config
RUN chown -R www-data /home/www-data/.ssh

WORKDIR /var/www

COPY ./ /var/www
RUN chown -R www-data /var/www
RUN chmod -R 777 /var/www/var
RUN chmod -R +x /var/www/bootstrap.sh

USER www-data

RUN composer install -o

STOPSIGNAL SIGQUIT
EXPOSE 9000

CMD ["/var/www/bootstrap.sh"]
#CMD ["php-fpm"]
