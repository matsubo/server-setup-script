#!/bin/sh





## Setting
tinydns-conf dns dnslog /var/tinydns $NEW_IP

cd /var/tinydns/root

./add-ns $TINYDNS_DOMAIN $NEW_IP
./add-ns $TINYDNS_PTR.in-addr.arpa $NEW_IP
./add-mx $TINYDNS_DOMAIN $NEW_IP
./add-host $NEW_HOSTNAME.$TINYDNS_DOMAIN $NEW_IP

make

ln -s /var/tinydns  /service

