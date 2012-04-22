<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

require_once("config.inc");

require_once("classes/ConfirmBean.php");
require_once("classes/SendAction.php");
require_once("classes/SendScheduleAction.php");

require_once("HTML/Template/IT.php");




## Set to bean
$bean = new ConfirmBean();
$bean->setGroupID($_POST['g_group_id']);
$bean->setFrom($_POST['from']);
$bean->setSubject($_POST['subject']);
$bean->setCode($_POST['code']);
$bean->setBody($_POST['body']);

$bean->setYear($_POST['year']);
$bean->setMonth($_POST['month']);
$bean->setDay($_POST['day']);
$bean->setHour($_POST['hour']);
$bean->setMinute($_POST['minute']);

$bean->validate();





## process
#$action = new SendAction($bean);
$action = new SendScheduleAction($bean);
$action->execute();






## make view
$view = new HTML_Template_IT("./view");
$view->loadTemplatefile("send.html", true, true);

$view->setVariable("message", "Reserved");
#$view->setVariable("message", "Sent");

$view->parseCurrentBlock();
$view->show();

?>