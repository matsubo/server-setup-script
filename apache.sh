#!/bin/sh


## setting
$TEMPLATE=httpd.conf.template

cd /usr/local/src


## download
wget \
http://ftp.kddilabs.jp/infosystems/apache/httpd/apache_1.3.36.tar.gz \


## install
tar zxf apache_1.3.36.tar.gz
cd apache_1.3.36
./configure \
"--enable-shared=max" \
"--logfiledir=/var/log/httpd" \
"--disable-module=proxy" \
"--disable-module=digest" \
"--enable-module=most" \

make
make install

## add to chkconfig
sed 's/#!\/bin\/sh/#!\/bin\/sh\n\n# chkconfig: 2345 65 35 \n# description:  httpd\nchcon -t texrel_shlib_t \/usr\/local\/apache\/libexec\/libphp5.so \n/' /usr/local/apache/bin/apachectl > a && mv a /usr/local/apache/bin/apachectl
ln -s /usr/local/apache/bin/apachectl /etc/init.d/
chmod 755 /usr/local/apache/bin/apachectl
chkconfig --add apachectl

cd /usr/local/apache/conf/
CONF=/usr/local/apache/conf/httpd.conf

cp -f $FILE_DIRECTORY/httpd.conf.template $CONF

#sed 's///' $CONF > a && mv -f a $CONF
sed 's/MaxRequestsPerChild 0/MaxRequestsPerChild 1000/' $CONF > a && mv -f a $CONF
sed "s/ServerAdmin.*/ServerAdmin info@$NEW_DOMAINNAME/" $CONF > a && mv -f a $CONF
sed "s/#ServerName.*/ServerName $NEW_FQDN/" $CONF > a && mv -f a $CONF




## ACL
mkdir /var/www/admin/
/usr/local/apache/bin/htpasswd -cb /var/www/admin/.htpasswd $HTTP_ACCOUNT $HTTP_PASSWORD
cp -f $FILE_DIRECTORY/templates/dot-htaccess /var/www/admin/.htaccess






