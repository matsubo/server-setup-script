<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */



#######################################
# SYSTEM SETTIGNS
#######################################

## Domain name of this host
$cfg['domain'] = 'th1.localdomain';





## Mail adderss display count per page
$cfg['record_count'] = 30;

## Parameter to set in DB class
## Development
$cfg['dsn'] = 'mysql://root@localhost/mail';

$cfg['return-path'] = 'invalid@'.$cfg['domain'];

$cfg['confirm_insert'] = array(
);

## Set Language
mb_language("ja");

## Separater address num
$cfg['separate_num']  = 30000;

## Except mail adress
$cfg['except']  = array(
);




#######################################
# Comments on program
#######################################
$lang['scheduled'] = 'Í½Ìó';
$lang['sending']   = 'Á÷¿®Ãæ';
$lang['done']      = '´°Î»';






?>
