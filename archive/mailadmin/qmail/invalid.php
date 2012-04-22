#!/usr/local/bin/php
<?php
/*
 ** Process invalid mail
 *
 * Usage: 
 * Write the line described as below:
 * ------------
 * |  /usr/local/bin/php /home/matsu/public_html/mail/qmail/invalid.php
 * ------------
 * 
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

$old_path = ini_get('include_path');
ini_set('include_path', $old_path.':.:/var/www/admin/mailadmin');

require_once("DB.php");

require_once("config.inc");
require_once("classes/DeleteInvalid.php");


$fp = fopen("php://stdin", "r");

## Read entire of the mail
$rawmail = '';
while(!feof($fp)){
	
	$rawmail .= fread($fp, 4096);
	
}
fclose($fp);


## Parse
$line_array = explode("\n", $rawmail);

$invalids = array();
for($i=0; $i<count($line_array); $i++){
	
	$line_array[$i] = trim($line_array[$i]);
	
	if(eregi("^To:[ ]*([^\n]*)", $line_array[$i], $regs))
	if(!ereg($cfg['domain'],$regs[1])){
		
		array_push($invalids, $regs[1]);
		
		$action = new DeleteInvalid($regs[1]);
		$action->execute();
	
		#system("echo '".$regs[1]."'  >> /tmp/mail");
		
	}
	
}

#$body = "--INVALID-\n".implode("\n",$invalids)."\n----------\n";
#mail('matsu-pure-heart-error@dsci.sfc.keio.ac.jp', "Return mail", mb_convert_encoding($body.$rawmail,"JIS","AUTO"), 'From: info@pure-heart.info' );


?>
