#!/bin/bash

# This script is to setup a server for mail sender.
# Modify the settings and execute by root account.
# 
# This script is *CONFIDENTIAL*

#-------------------------------------------
# Setting
#-------------------------------------------

## HTTP LOGIN ACCOUNT
export HTTP_ACCOUNT=info
export HTTP_PASSWORD=rh2CP9x5

## POP ACCOUNT
export POP_ACCOUNT=info
export POP_PASSWORD=rh2CP9x5

## DEFAULT FORWARD MAIL ACCOUNT
export DEFAULT_MAIL_FORWARD=matsu

## Tinydns domain name to manage
export TINYDNS_DOMAIN=mtkk.net
export TINYDNS_PTR=150.216.155.203




#-------------------------------------------
# GLOBAL Definition
#-------------------------------------------

## Hostname and domain name setting
export NEW_IP=127.0.0.1
export NEW_HOSTNAME=localhost
export NEW_DOMAINNAME=localdomain
export NEW_FQDN=$NEW_HOSTNAME.$NEW_DOMAINNAME


## Put mailadmin program to
export ADMIN=/var/www/admin

## Stored directory
export FILE_DIRECTORY=`pwd`

unalias cp
unalias mv
unalias rm

export PATH=$PATH:/usr/sbin:/sbin:/bin:/usr/bin

export SRC=/usr/local/src


#-------------------------------------------
# Execute scripts
#-------------------------------------------
chmod 755 ./*.sh


#./init.sh
#./daemontools.sh
# ./qmail.sh
#  ./qmail-config-changer.sh
#./apache.sh
##./apache2.sh
## ./apache-config-changer.sh
# ./php.sh
## ./php2.sh
#./mrtg.sh
#reboot
#./mailadmin.sh
#./djbdns.sh
###./tinydns.sh
#./dnscache.sh

#./qmail-config-changer.sh
#./apache-config-changer.sh


#-------------------------------------------
# DONE
#-------------------------------------------
exit
