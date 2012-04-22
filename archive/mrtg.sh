#!/bin/sh


PATH=$PATH:/usr/bin

cd /var/www/admin
env LANG=C nice -n 19 mrtg mrtg.cfg  && indexmaker mrtg.cfg > mrtg/index.html

