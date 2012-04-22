<?php

/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

require_once ("config.inc");

require_once ("classes/CSVAction.php");
require_once ("classes/CSVBean.php");


$bean = new CSVBean();
$bean->setGroupID($_GET['g_group_id']);
$bean->validate();


## process
$action = new CSVAction($bean);
$data = $action->execute();

if(!$data){ die('No error address.'); }

header("Content-disposition: attachment; filename=invalidmailaddresses.csv");
header("Content-type: application/octet-stream; name=invalidmailaddersses.csv");
print $data;


?>
