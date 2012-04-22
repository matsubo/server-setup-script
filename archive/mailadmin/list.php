<?php

/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

require_once ("config.inc");

require_once ("classes/ListAction.php");

require_once ("HTML/Template/IT.php");

## process
$action = new ListAction();
$data = $action->execute();

## make view
$view = new HTML_Template_IT("./view");
$view->loadTemplatefile("list.html", true, true);

if (!$data)
{
  $view->setVariable("message", "no record");
} else
{
  $view->setVariable("message", "");
}

foreach ($data as $key => $value)
{

  $view->setVariable("g_group_id", $value['g_group_id']);
  $view->setVariable("g_title", $value['g_title']);
  $view->setVariable("g_timestamp", $value['g_timestamp']);
  #	$view->setVariable("count",       $value['count']);

  $view->setCurrentBlock("RECORD");
  $view->parseCurrentBlock("RECORD");
}

$view->parseCurrentBlock();
$view->show();
?>
