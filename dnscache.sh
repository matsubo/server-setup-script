#!/bin/sh

cd /usr/local/src



dnscache-conf dnscache dnslog /var/dnscache 127.0.0.1
cd /var/dnscache/root/servers

#echo $NEW_IP > $TINYDNS_DOMAIN
#echo $NEW_IP > $TINYDNS_PTR.in-addr.arpa

ln -s /var/dnscache /service

#grep 127\.
#sed 's/^nameserver.*/nameserver 127\.0\.0\.1/' /etc/resolv.conf > a && mv -f a /etc/resolv.conf
echo "search mtkk.net
nameserver 127.0.0.1" > /etc/resolv.conf
