#!/bin/sh


cd /usr/local/src


## download
wget \
http://ftp.kddilabs.jp/infosystems/apache/httpd/httpd-2.2.3.tar.gz


# @see http://php.s3.to/man/install.unix.apache2.html

## install
tar zxvf httpd-2.2.3.tar.gz
cd httpd-2.2.3
./configure \
--enable-so --enable-ssl --with-mpm=prefork


make
make install



## add to chkconfig
cd /usr/local/apache2/bin/

sed 's/#!\/bin\/sh/#!\/bin\/sh\n#\n# chkconfig: 2345 65 35 \n# description:  httpd/' /usr/local/apache2/bin/apachectl > a && mv a /usr/local/apache2/bin/apachectl
chmod 755 /usr/local/apache2/bin/apachectl
ln -s /usr/local/apache2/bin/apachectl /etc/init.d/

chkconfig --add apachectl

#sed 's/MaxRequestsPerChild 0/MaxRequestsPerChild 1000/' $CONF > a && mv -f a $CONF
#sed "s/ServerAdmin.*/ServerAdmin info@$NEW_DOMAINNAME/" $CONF > a && mv -f a $CONF
#sed "s/#ServerName.*/ServerName $NEW_FQDN/" $CONF > a && mv -f a $CONF


# SSL 
# @see http://platz.jp/howto/apache_ssl_linux.html


