#!/bin/sh

## Package update
yum install -y yum-fastestmirror

yum update
yes|yum -y upgrade

yum remove -y \
bluez-utils \
howl \
mDNSResponder \
ppp \
rp-pppoe \
sendmail \
isdn4k-utils \
httpd \
cups \
php \
bind \
tetex \
fetchmail \
boa \
howl \
gpm \
dhclient \
dhcdbd \
alsa-lib \
alsa-lib-devel \
portmap \
hal \
nfs-utils \
xorg-x11-xfs \
avahi \
postgresql \
avahi \
postfix \
squid \



yum install -y \
zsh \
mysql-server \
mysql-devel \
vim-enhanced





## Time
unalias cp
cp -f  /usr/share/zoneinfo/Asia/Tokyo  /etc/localtime
echo '0 0 * * * root /usr/sbin/ntpdate ntp.sfc.keio.ac.jp > /dev/null' >> /etc/crontab
/usr/sbin/ntpdate ntp.sfc.keio.ac.jp





## Adduser
grep matsu /etc/passwd
if [ $? == 1 ]; then
	adduser matsu -u 5000 -G wheel --password '$1$rOgVvy/t$rKiilVB2c2YR54zdm6b.F.'
	sudo -u matsu ssh-keygen -t rsa -N "" -f /home/matsu/.ssh/id_rsa
	sudo -u matsu echo "ssh-rsa AAAAB3NzaC1yc2EAAAABJQAAAIEAsCPC0nEJBzInnID0pyh/FEq4/+LsGtlXuhxVoVlIaVv4UJedIk/LaTZ4ewcHZ0MvjDFgcBqXe7uPtms2OmFTWX1oB4dFr81HERnwXieiIdEeWRwBxUgsAXLqTZJFZc7tPbSTk5++YnvaJPX9fsbQwVmf7fr0aDxLhmv7u6QQLy0=" >> /home/matsu/.ssh/authorized_keys
	chmod 600 /home/matsu/.ssh/authorized_keys
	chown matsu.matsu /home/matsu/.ssh/authorized_keys

	sed 's/^# *%wheel[ \t]*ALL=(ALL)[ \t]*ALL/%wheel\tALL=(ALL)\tALL/' /etc/sudoers >  /etc/sudoers.tmp && mv /etc/sudoers.tmp -f /etc/sudoers
	chmod 440 /etc/sudoers
fi

## Daemon setting
chkconfig --level 0123456 ntpd off


## change hostname
echo "# Do not remove the following line, or various programs
# that require network functionality will fail.
127.0.0.1               localhost localhost
$NEW_IP           $NEW_HOSTNAME.$NEW_DOMAINNAME $NEW_HOSTNAME
" > /etc/hosts



## iptables
iptables -P INPUT ACCEPT
iptables -P FORWARD DROP
iptables -P OUTPUT ACCEPT
iptables -F
iptables -A INPUT -p tcp --dport 80 -j ACCEPT
iptables -A INPUT -p tcp --dport 110 -j ACCEPT
iptables -A INPUT -p tcp --dport 25 -j ACCEPT
iptables -A INPUT -p tcp --dport 53 -j ACCEPT
iptables -A INPUT -p udp --dport 53 -j ACCEPT
iptables -A INPUT -p tcp --dport 22 -j ACCEPT
iptables -A INPUT -s 127.0.0.1 -p udp -m udp --dport 161 -j ACCEPT
iptables -A INPUT -s 127.0.0.1 -p tcp -m tcp --dport 199 -j ACCEPT
iptables -A INPUT -m state --state ESTABLISHED,RELATED -j ACCEPT  
iptables -P INPUT DROP

/etc/init.d/iptables save
/etc/init.d/iptables condrestart



sed s/^HOSTNAME=.*/HOSTNAME=$NEW_HOSTNAME/ /etc/sysconfig/network > a && mv -f a /etc/sysconfig/network
/etc/init.d/network restart


