<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

require_once("config.inc");

require_once("classes/ComposeBean.php");
require_once("classes/DeleteAction.php");

require_once("HTML/Template/IT.php");


## Set to bean
$bean = new ComposeBean();
$bean->setGroupID($_GET['g_group_id']);
$bean->validate();






## process
$action = new DeleteAction($bean);
$action->execute();








## make view
$view = new HTML_Template_IT("./view");
$view->loadTemplatefile("delete.html", true, true);

$view->setVariable("message", 'Deleted');


$view->parseCurrentBlock();
$view->show();


?>