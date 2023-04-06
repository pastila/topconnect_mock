#!/usr/bin/env sh

php -dmemory_limit=-1 bin/console cache:clear --no-interaction && \
php -dmemory_limit=-1 bin/console asset:install --no-interaction && \
php -dmemory_limit=-1 bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration

php-fpm