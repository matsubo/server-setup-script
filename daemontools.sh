#!/bin/sh

cd /usr/local/src

## preprocess
mkdir -p /package
chmod 1755 /package
cd /package

## download
wget \
http://cr.yp.to/daemontools/daemontools-0.76.tar.gz \
http://www.qmail.org/moni.csi.hu/pub/glibc-2.3.1/daemontools-0.76.errno.patch


## install
gunzip daemontools-0.76.tar
tar -xpf daemontools-0.76.tar
rm -rf daemontools-0.76.tar
cd admin/daemontools-0.76

patch -p1< ../../daemontools-0.76.errno.patch

package/install


