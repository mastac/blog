#!/bin/bash

npm install
bower install --allow-root

php /usr/local/bin/composer.phar install
php artisan migrate:refresh --seed
php artisan key:generate

vendor/bin/phpunit

gulp

apache2-foreground