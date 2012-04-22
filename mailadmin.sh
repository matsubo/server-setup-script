#!/bin/sh


#-------------------------------------------
# Mailadmin
#-------------------------------------------
pear install DB
cp -ra $FILE_DIRECTORY/archive/mailadmin $ADMIN/
cp -ra $FILE_DIRECTORY/archive/index.html $ADMIN/

#-------------------------------------------
# Setup
#-------------------------------------------
/etc/init.d/mysqld restart

cp -f $FILE_DIRECTORY/archive/mailadmin/misc/my.cnf /etc/my.cnf

mysqladmin  -u root create mail
cat $ADMIN/mailadmin/misc/structure.sql | mysql -u root mail

chmod 755 /var/www/admin/mailadmin/cron/stat.sh


grep SendScheduleAction /etc/crontab
if [ $? != 0 ];then
	echo '*/1 * * * * root /usr/local/bin/php -q  /var/www/admin/mailadmin/cron/SendScheduleAction.php > /dev/null' >> /etc/crontab
fi


grep 'stat.sh' /etc/crontab
if [ $? != 0 ];then
	echo '*/1 * * * * root  /var/www/admin/mailadmin/cron/stat.sh' >> /etc/crontab
fi


cd $ADMIN/mailadmin
sed "s/^\$cfg\['domain'\].*/\$cfg\['domain'] = '$NEW_FQDN';/" config.inc > a && mv -f a config.inc




chmod 755 $ADMIN/mailadmin/qmail/invalid.php
echo "| /usr/local/bin/php -q $ADMIN/mailadmin/qmail/invalid.php" > ~alias/.qmail-invalid



## Make cancel page link
chown root.root -R /var/www/admin

ln -s /var/www/admin/mailadmin/cancel.html  /var/www/cancel.html
ln -s /var/www/admin/mailadmin/cancel.php  /var/www/cancel.php


