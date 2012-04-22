#!/bin/sh

# qmail���C���X�g�[��������ɁA�V�����z�X�g���A�h���C������
# �ݒ肵�A���f���邽�߂̃X�N���v�g�B

## Install
cd /usr/local/src
cd qmail-1.03
./config-fast $NEW_HOSTNAME.$NEW_DOMAINNAME


#echo $NEW_FQDN > /var/qmail/control/rcpthosts
#echo $NEW_DOMAINNAME >> /var/qmail/control/rcpthosts

cd /var/qmail/service/smtpd
echo $NEW_IP > env/IP
echo $NEW_FQDN > env/HOST


cd /var/qmail/service/pop3d/
echo $NEW_IP > env/IP
echo $NEW_FQDN > env/HOST


svc -du  /service/qmail
svc -du  /service/smtpd
svc -du  /service/pop3d

