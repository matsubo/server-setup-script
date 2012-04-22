#!/bin/sh

cd /usr/local/src

wget http://au3.php.net/get/php-5.1.4.tar.gz/from/jp.php.net/mirror

tar zxf php-5.1.4.tar.gz
cd php-5.1.4

./configure \
--enable-mbstring \
--enable-zend-multibyte \
--with-apxs=/usr/local/apache/bin/apxs \
--with-mysql 

make
make install

cp $FILE_DIRECTORY/php.ini-template /usr/local/lib/php.ini

## selinux reason
chcon -t texrel_shlib_t /usr/local/apache/libexec/libphp5.so


/etc/init.d/apachectl restart
