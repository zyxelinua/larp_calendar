#!/bin/sh

DATE=`date '+%Y-%m-%d'`
mysqldump -h127.0.0.1  -urolendar -p${MYSQL_PASSWORD} --databases rolendar > /var/www/rolendar/backup/${DATE}.sql
