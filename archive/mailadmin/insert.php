<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

$old_path=ini_get('include_path');
ini_set('include_path', $old_path.':.:/var/www/admin/mailadmin');


require_once("config.inc");

require_once("classes/UploadBean.php");
require_once("classes/InsertAction.php");

require_once("HTML/Template/IT.php");


## Set to bean
$bean = new UploadBean();
$bean->setPath($_FILES['file']['tmp_name']);
$bean->setTitle($_POST['title']);
$bean->validate();



## process
$action = new InsertAction($bean);
$action->execute();








## make view
$view = new HTML_Template_IT("./view");
$view->loadTemplatefile("insert.html", true, true);

$view->setVariable("message", 'Processed successfully');


$view->parseCurrentBlock();
$view->show();


?>