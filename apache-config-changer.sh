#!/bin/sh


TEMPLATE=httpd.conf.template


# apacheをインストールした後に、新しいホスト名、ドメイン名を
# 設定し、反映するためのスクリプト。

cd /usr/local/apache/conf/
CONF=/usr/local/apache/conf/httpd.conf

cp -f $FILE_DIRECTORY/httpd.conf.template $CONF

#sed 's///' $CONF > a && mv -f a $CONF
sed "s/ServerAdmin.*/ServerAdmin info@$NEW_FQDN/" $CONF > a && mv -f a $CONF
sed "s/ServerName.*/ServerName $NEW_FQDN/" $CONF > a && mv -f a $CONF
sed "s/#ServerName.*/ServerName $NEW_FQDN/" $CONF > a && mv -f a $CONF

