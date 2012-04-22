#!/bin/sh

cd /usr/local/src


export TRANSWER_DESTINATION

axfrdns-conf axfrdns dnslog /var/axfrdns /var/tinydns $NEW_IP

## not tested
#cd /var/axfrdns
#echo "$TRANSWER_DESTINATION:allow,AXFR="$NEW_DOMAINNAME/$TINYDNS_PTR.in-addr.arpa" > tcp
#echo ':deny' >> tcp
make


ln -s /etc/axfrdns /service
