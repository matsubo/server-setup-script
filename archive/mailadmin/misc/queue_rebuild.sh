#!/bin/sh

svc -d /service/qmail

cd /var/qmail/queue
rm -rf info intd local mess remote todo

mkdir mess

for i in `seq 0 22`; do
mkdir mess/$i
done

cp -r mess info
cp -r mess intd
cp -r mess local
cp -r mess remote
mkdir todo

chmod -R 750 mess todo
chown -R qmailq:qmail mess todo

chmod -R 700 info intd local remote
chown -R qmailq:qmail intd
chown -R qmails:qmail info local remote

svc -u /service/qmail


