#!/bin/bash

service apache2 restart
composer install
php bin/console ckeditor:install --no-progress-bar --no-interaction
php bin/console assets:install public
chown -R www-data:www-data /var/www/rolendar

exec "$@"
