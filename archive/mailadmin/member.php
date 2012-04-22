<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

require_once("config.inc");

require_once("classes/UploadBean.php");
require_once("classes/MemberAction.php");

require_once("HTML/Template/IT.php");


## Set to bean
$bean = new UploadBean();
$bean->setPath($_FILES['file']['tmp_name']);
#$bean->validate();



## process
$action = new MemberAction($bean);
$action->execute();








## make view
$view = new HTML_Template_IT("./view");
$view->loadTemplatefile("invalid.html", true, true);

$view->setVariable("message", 'Processed successfully');


$view->parseCurrentBlock();
$view->show();


?>