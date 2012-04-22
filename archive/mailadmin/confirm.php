<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

require_once("config.inc");

require_once("classes/ConfirmBean.php");

require_once("HTML/Template/IT.php");





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






## make view
$view = new HTML_Template_IT("./view");
$view->loadTemplatefile("confirm.html", true, true);

$view->setVariable("g_group_id", $bean->getGroupID());
$view->setVariable("from",       htmlspecialchars($bean->getFrom()));
$view->setVariable("code",       htmlspecialchars($bean->getCode()));
$view->setVariable("subject",    htmlspecialchars($bean->getSubject()));
$view->setVariable("body",       htmlspecialchars($bean->getBody()));

$view->setVariable("year",  $bean->getYear());
$view->setVariable("month", $bean->getMonth());
$view->setVariable("day",   $bean->getDay());
$view->setVariable("hour",     $bean->getHour());
$view->setVariable("minute",   $bean->getMinute());


$view->parseCurrentBlock();
$view->show();


?>