<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

require_once("config.inc");

require_once("classes/ScheduleDeleteBean.php");
require_once("classes/ScheduleDeleteAction.php");

require_once("HTML/Template/IT.php");


## Set to bean
$bean = new ScheduleDeleteBean();
$bean->setS_ID($_GET['s_logid']);
$bean->validate();






## process
$action = new ScheduleDeleteAction($bean);
$action->execute();








## make view
$view = new HTML_Template_IT("./view");
$view->loadTemplatefile("schedule_delete.html", true, true);

$view->setVariable("message", 'Deleted');


$view->parseCurrentBlock();
$view->show();


?>