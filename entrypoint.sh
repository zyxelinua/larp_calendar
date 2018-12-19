#!/bin/bash

service apache2 restart
sudo -u www-data composer install
sudo -u www-data php bin/console ckeditor:install --no-progress-bar --no-interaction
sudo -u www-data php bin/console assets:install public

exec "$@"
