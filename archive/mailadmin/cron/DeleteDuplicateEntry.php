#!/usr/local/bin/php -q
<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */


$old_path=ini_get('include_path');
ini_set('include_path', $old_path.':.:/var/www/admin/mailadmin');

require_once("DB.php");

require_once("config.inc");
require_once("classes/DeleteDuplicateAction.php");

$action = new DeleteDuplicateAction();
$action->execute();


?>