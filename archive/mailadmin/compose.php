<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

require_once("config.inc");

require_once("classes/ComposeBean.php");
require_once("classes/FormUtil.php");

require_once("HTML/Template/IT.php");





$bean = new ComposeBean();
$bean->setGroupID($_GET['g_group_id']);
$bean->validate();






## make view
$c_year    = date('Y');
$c_month   = date('n');
$c_day     = date('j');

$c_hour    = date('G');
$c_minute  = date('i');



/* Make form objects */
$year_object   = new FormUtil('select', 'year',  array($c_year, $c_year+1), $c_year);
$month_object  = new FormUtil('select', 'month', FormUtil::makeSimpleArray(1,12), $c_month);
$day_object    = new FormUtil('select', 'day',   FormUtil::makeSimpleArray(1,31), $c_day);


$hour_object    = new FormUtil('select', 'hour',     FormUtil::makeSimpleArray(0,23), $c_hour);
$minute_object  = new FormUtil('select', 'minute',   FormUtil::makeSimpleArray(0,59), $c_minute);









$view = new HTML_Template_IT("./view");
$view->loadTemplatefile("compose.html", true, true);

$view->setVariable("g_group_id", $bean->getGroupID());

$view->setVariable("year",  $year_object->show());
$view->setVariable("month", $month_object->show());
$view->setVariable("day",   $day_object->show());

$view->setVariable("hour",     $hour_object->show());
$view->setVariable("minute",   $minute_object->show());


$view->parseCurrentBlock();
$view->show();


?>