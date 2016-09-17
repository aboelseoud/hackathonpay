#!/usr/bin/env bash
sudo apt-get update -y
sudo apt-get install php5-dev -y

DBHOST=localhost
DBNAME=pay
DBUSER=root
DBPASSWD=root

echo "phpmyadmin phpmyadmin/dbconfig-install boolean true" | debconf-set-selections
echo "phpmyadmin phpmyadmin/app-password-confirm password $DBPASSWD" | debconf-set-selections
echo "phpmyadmin phpmyadmin/mysql/admin-pass password $DBPASSWD" | debconf-set-selections
echo "phpmyadmin phpmyadmin/mysql/app-pass password $DBPASSWD" | debconf-set-selections
echo "phpmyadmin phpmyadmin/reconfigure-webserver multiselect none" | debconf-set-selections

apt-get -y install phpmyadmin > /dev/null 2>&1

cd /var/www
composer install
php artisan migrate --force
sudo apt-get install npm -y
sudo npm install gulp -g
sudo npm install bower -g
sudo npm install
sudo bower install --allow-root
sudo gulp --allow-root