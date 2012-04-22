#!/usr/bin/perl

#open(SSH,"ssh 192.168.0.2 cat /proc/stat|");
open(SSH,"cat /proc/stat|");

while(<SSH>){
    if (/^disk_io: \([^(]+\([0-9]+,[0-9]+,([0-9]+),[0-9]+,([0-9]+)\)/){
        print "$1\n";
        print "$2\n\n\n";
    }
}
close(SSH);
