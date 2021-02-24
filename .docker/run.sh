#!/bin/sh

cd ../var/www 

./vendor/bin/phpunit tests
php-fpm
