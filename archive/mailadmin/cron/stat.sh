#!/bin/bash

PATH=$PATH:/usr/bin:/usr/local/bin

echo `/bin/date`  `/var/qmail/bin/qmail-qstat` > /var/www/admin/mailadmin/qstat


