#!/bin/sh

cd /usr/local/src



## download
## patches http://djbware.csi.hu/patches/

wget \
http://www.qmail.org/big-concurrency.patch \
http://osdn.dl.sourceforge.jp/qmail-vida/2100/qmail-vida-0.53.tar.gz \
http://untroubled.org/relay-ctrl/relay-ctrl-3.1.1.tar.gz \
http://cr.yp.to/checkpwd/checkpassword-0.90.tar.gz \
http://qmail.org/moni.csi.hu/pub/glibc-2.3.1/checkpassword-0.90.errno.patch \
ftp://ftp.jp.qmail.org/qmail/qmail-1.03.tar.gz \
http://www.mirrorservice.org/sites/www.ibiblio.org/gentoo/distfiles/qmail-date-localtime.patch.txt \
http://qmail.org/moni.csi.hu/pub/glibc-2.3.1/qmail-1.03.errno.patch \
http://www.emaillab.org/djb/tools/ucspi-tcp/ucspi-tcp-0.88.tar.gz \
http://djbware.csi.hu/patches/ucspi-tcp-0.88.errno.patch \


## pre process
mkdir /var/qmail

groupadd -g 1500 nofiles
groupadd -g 1501 qmail

useradd -u 1500 -g nofiles -s /bin/false -d /var/qmail/alias alias
useradd -u 1501 -g nofiles -s /bin/false -d /var/qmail qmaild
useradd -u 1502 -g nofiles -s /bin/false -d /var/qmail qmaill
useradd -u 1503 -g nofiles -s /bin/false -d /var/qmail qmailp

useradd -u 1504 -g qmail -s /bin/false -d /var/qmail qmailq
useradd -u 1505 -g qmail -s /bin/false -d /var/qmail qmailr
useradd -u 1506 -g qmail -s /bin/false -d /var/qmail qmails


## ucspi
cd /usr/local/src
tar zxf ucspi-tcp-0.88.tar.gz
cd ucspi-tcp-0.88
patch -p1 < ../ucspi-tcp-0.88.errno.patch
make setup check


## checkpassword
cd /usr/local/src
tar zxf checkpassword-0.90.tar.gz
cd checkpassword-0.90
patch -p1 < ../checkpassword-0.90.errno.patch

## qmail
cd /usr/local/src
tar zxf qmail-1.03.tar.gz
cd qmail-1.03
patch -p1 < ../qmail-1.03.errno.patch
patch -p1 < ../big-concurrency.patch
sed s/1000/509/ conf-spawn > a && mv -f a conf-spawn


## qmail-vida
cd /usr/local/src
tar zxf qmail-vida-0.53.tar.gz
cd qmail-vida-0.53

make patch
make copy


groupadd -g 1502 vida
useradd -u 1507 -g vida pop
useradd -u 1508 -g vida -s /bin/false -d /var/qmail/authdb qmailu
useradd -u 1509 -g vida -s /bin/false -d /var/qmail/authdb authdb


## Install
cd /usr/local/src
cd qmail-1.03
make setup check
./config-fast $NEW_HOSTNAME.$NEW_DOMAINNAME

cd /usr/local/src/checkpassword-0.90
make setup check

cd /usr/local/src/
cd qmail-vida-0.53
cd src/vida
make setup check


## relay-ctrl
#mkdir /var/spool/relay-ctrl/allow
#chmod 700 /var/spool/relay-ctrl
#chmod 777 /var/spool/relay-ctrl/allow
#mkdir /etc/relay-ctrl
#echo "/var/spool/relay-ctrl/allow" > /etc/relay-ctrl/RELAY_CTRL_DIR
#
#cd /usr/local/src
#tar zxvf relay-ctrl-3.1.1.tar.gz
#cd relay-ctrl-3.1.1
#make
#mkdir /usr/local/man
#./installer
#echo '* * * * * root envdir /etc/relay-ctrl /usr/local/bin/relay-ctrl-age' >> /etc/crontab





## daemontools

## qmail
mkdir -p /var/qmail/service/qmail
mkdir -p /var/qmail/service/qmail/env
chmod 1755 /var/qmail/service/qmail
echo '#!/bin/sh
#
exec env - PATH="/var/qmail/bin:$PATH" \
qmail-start ./Maildir/

' > /var/qmail/service/qmail/run


chmod 755 /var/qmail/service/qmail/run
mkdir /var/qmail/service/qmail/log
mkdir /var/log/qmail
chown qmaill.nofiles /var/log/qmail
chmod 755 /var/log/qmail
echo '#!/bin/sh
#
PATH=$PATH:/usr/local/bin
exec \
setuidgid qmaill \
multilog t /var/log/qmail

' > /var/qmail/service/qmail/log/run

chmod 755 /var/qmail/service/qmail/log/run



## smtpd
mkdir /var/qmail/service/smtpd
chmod 1755 /var/qmail/service/smtpd

echo '#!/bin/sh' > /var/qmail/service/smtpd/run
echo 'PATH=$PATH:/var/qmail/bin' >> /var/qmail/service/smtpd/run
echo 'exec 2>&1' >> /var/qmail/service/smtpd/run
echo "exec envdir ./env sh -c '" >> /var/qmail/service/smtpd/run
echo '  exec softlimit -d6000000 \' >> /var/qmail/service/smtpd/run
echo '  tcpserver -vHR -l"$HOST" -c40 -- "$IP" 25 \' >> /var/qmail/service/smtpd/run
echo '  recordio fixcrio \' >> /var/qmail/service/smtpd/run
echo '  qmail-smtpup "$HOST" checkpassword qmail-smtpd' >> /var/qmail/service/smtpd/run
echo "'" >> /var/qmail/service/smtpd/run


chmod 755 /var/qmail/service/smtpd/run

cd /var/qmail/service/smtpd
mkdir env
echo $NEW_IP > env/IP
echo $NEW_FQDN > env/HOST
echo "pop" > env/DOMAINOWNER


mkdir /var/qmail/service/smtpd/log
chown qmails.nofiles /var/qmail/service/smtpd/log
chmod 1755 /var/qmail/service/smtpd/log
echo '#!/bin/sh
exec \
setuidgid qmaill \
multilog t /var/log/smtpd

' > /var/qmail/service/smtpd/log/run

chmod 755 /var/qmail/service/smtpd/log/run

mkdir /var/log/smtpd
chown qmaill.nofiles /var/log/smtpd



## POP3
mkdir /var/qmail/service/pop3d
chmod 1755 /var/qmail/service/pop3d
echo '#!/bin/sh' > /var/qmail/service/pop3d/run
echo 'PATH=$PATH:/var/qmail/bin' >> /var/qmail/service/pop3d/run
echo 'exec 2>&1' >> /var/qmail/service/pop3d/run
echo "exec envdir ./env sh -c '" >> /var/qmail/service/pop3d/run
echo '  exec softlimit -d6000000 \' >> /var/qmail/service/pop3d/run
echo '  tcpserver -vHR -l "$HOST" -c40 -- "$IP" 110 \' >> /var/qmail/service/pop3d/run
echo '  recordio \' >> /var/qmail/service/pop3d/run
echo '  qmail-popup "$HOST" checkpassword qmail-pop3d Maildir' >> /var/qmail/service/pop3d/run
echo "'" >> /var/qmail/service/pop3d/run

chmod 755 /var/qmail/service/pop3d/run
chown qmaill.nofiles /var/log/pop3d
mkdir /var/qmail/service/pop3d/log
chmod 1755 /var/qmail/service/pop3d/log
echo '#!/bin/sh
exec \
setuidgid qmaill \
multilog t /var/log/pop3d

' > /var/qmail/service/pop3d/log/run

chmod 755 /var/qmail/service/pop3d/log/run

mkdir /var/log/pop3d
chown qmaill.nofiles /var/log/pop3d


cd /var/qmail/service/pop3d/
mkdir env
echo $NEW_IP > env/IP
echo $NEW_FQDN > env/HOST
echo "pop" > env/DOMAINOWNER



## Settings
/var/qmail/bin/maildirmake /etc/skel/Maildir

PATH=$PATH:/var/qmail/bin
chown authdb /var/qmail/authdb/
vida-pwdbinit

echo "./Maildir/" > /etc/skel/.qmail

cd /root
/var/qmail/bin/maildirmake Maildir

cd ~alias
echo "&$DEFAULT_MAIL_FORWARD" > .qmail-root
echo "&root" > .qmail-mailer-daemon
echo "&root" > .qmail-postmaster


echo $NEW_DOMAINNAME >> /var/qmail/control/locals
echo $NEW_FQDN       >> /var/qmail/control/locals
echo localhost       >> /var/qmail/control/locals
echo $NEW_DOMAINNAME >> /var/qmail/control/rcpthosts
echo $NEW_FQDN       >> /var/qmail/control/rcpthosts
echo localhost       >> /var/qmail/control/rcpthosts
echo $NEW_FQDN > /var/qmail/control/plusdomain
echo 509 > /var/qmail/control/concurrencyremote
echo 3600 > /var/qmail/control/queuelifetime
echo $NEW_FQDN > /var/qmail/control/me




## MAKE A ACCOUNT
grep $POP_ACCOUNT /etc/passwd
if [ $? == 1 ]; then
 adduser -u 5001  $POP_ACCOUNT
 sudo -u info /var/qmail/bin/vida-passwd -p $POP_PASSWORD
fi

## make link to a wrapper
if [ -f /usr/sbin/sendmail ]; then
 mv -f  /usr/sbin/sendmail /usr/sbin/sendmail.back
fi
ln -s /var/qmail/bin/sendmail  /usr/sbin/sendmail


sudo -u matsu /var/qmail/bin/maildirmake  /home/matsu/Maildir


## start
ln -s /var/qmail/service/qmail /service
ln -s /var/qmail/service/pop3d /service
ln -s /var/qmail/service/smtpd /service

sleep 5

svstat /service/qmail /service/qmail/log
svstat /service/smtpd /service/smtpd/log
svstat /service/pop3d /service/pop3d/log



# see here for pop,smt-auth
# http://www.marronkun.net/linux/mail/qmail_000032.html
