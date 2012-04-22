#!/bin/sh

cd /usr/local/src


## download
wget \
ftp://ftp.jp.qmail.org/qmail/djbdns-1.05.tar.gz \
http://djbware.csi.hu/patches/djbdns-1.05.errno.patch


## install
tar zxf djbdns-1.05.tar.gz
cd djbdns-1.05
patch -p1 < ../djbdns-1.05.errno.patch
make setup check


## setup
groupadd -g 2000 dns
adduser -s /bin/noshell -d /usr/local/src -u 2000 -g dns  dnscache
adduser -s /bin/noshell -d /usr/local/src -u 2001 -g dns  dnslog
adduser -s /bin/noshell -d /usr/local/src  -u 2002 -g dns  dns
adduser -s /bin/noshell -d /usr/local/src  -u 2003 -g dns  axfrdns

