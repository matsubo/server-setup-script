#!/bin/sh



cd /usr/local/src

wget http://au3.php.net/get/php-5.1.5.tar.gz/from/jp.php.net/mirror

tar zxf php-5.1.5.tar.gz
cd php-5.1.5

./configure \
--enable-mbstring \
--enable-zend-multibyte \
--with-apxs2=/usr/local/apache2/bin/apxs \
--with-mysql 

make
make install


## selinux reason
#chcon -t texrel_shlib_t /usr/local/apache2/modules/libphp5.so


/etc/init.d/apachectl restart
