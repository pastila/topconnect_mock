FROM php:7.3-fpm

ENV COMPOSER_HOME=/home/www-data/.composer

USER root

RUN apt-get update && apt-get install -y\
    git \
    zip

RUN docker-php-ext-install pdo pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.2.5
RUN mkdir -p /home/www-data/.composer/cache/vcs
RUN chmod -R 777 /home/www-data/.composer

RUN mkdir -p /home/www-data/.ssh
RUN echo "Host *\n\tStrictHostKeyChecking no\n\n\n" >> /home/www-data/.ssh/config
RUN chown -R www-data /home/www-data/.ssh

USER www-data

WORKDIR /var/www

STOPSIGNAL SIGQUIT
EXPOSE 9000

CMD ["php-fpm"]
