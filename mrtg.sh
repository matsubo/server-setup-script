#!/bin/sh

cd /usr/local/src

ADMIN=/var/www/admin
mkdir -p $ADMIN/mrtg

## SNMPD
yum install -y \
net-snmp \
net-snmp-utils \

chkconfig --level 2345  snmpd on
chkconfig --level 0126  snmpd off
cp $FILE_DIRECTORY/snmpd.conf-template /etc/snmp/snmpd.conf
/etc/init.d/snmpd  restart



## mrtg
yum install -y \
mrtg \

cp $FILE_DIRECTORY/templates/mrtg.cfg $ADMIN/
cp $FILE_DIRECTORY/archive/mrtg.sh $ADMIN/

## qmailmrtg
cp $FILE_DIRECTORY/archive/qmailmrtg7-4.0.tar.gz /usr/local/src/
tar zxf qmailmrtg7-4.0.tar.gz
cd qmailmrtg7-4.0
make
make install

grep mrtg.sh /etc/crontab
if [ $? == 1 ]; then
	echo '0-59/5 * * * * root /var/www/admin/mrtg.sh 2>/dev/null' >> /etc/crontab
	chmod 755 /var/www/admin/mrtg.sh
fi


