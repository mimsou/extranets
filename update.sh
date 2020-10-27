#!/bin/sh

#PUT THE APP BACK DOWN IF A COMPOSER UPDATE IS REQUIRED
if [ $# -eq 1 ]
then
    if [ $1 = 'composer' ]
    then
        /opt/plesk/php/7.4/bin/php artisan down
    fi
fi

#RETREIVE NEW CODE FROM GIT
git clean -fd
git checkout -f
git pull origin master

#WE MIGRATE THE DG
/opt/plesk/php/7.4/bin/php artisan migrate

# DO A COMPOSER UPDATE IF PARAMETER IS SET
if [ $# -eq 1 ]
then
    if [ $1 = 'composer' ]
    then
        /opt/plesk/php/7.4/bin/php -d memory_limit=-1 composer.phar install
    fi
fi

#ASSURE GOOD FOLDER PERMISSIONS
chown -R iemploi:psaserv /var/www/vhosts/immigremploi.ca/extranet
chown -R iemploi:psaserv /var/www/vhosts/immigremploi.ca/httpdocs

#PUT THE APP BACK ON IF A COMPOSER UPDATE HAS BEEN MADE
if [ $# -eq 1 ]
then
    if [ $1 = 'composer' ]
    then
        /opt/plesk/php/7.4/bin/php artisan up
    fi
fi

