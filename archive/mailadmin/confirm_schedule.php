<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

require_once("config.inc");

require_once("classes/ListScheduleAction.php");

require_once("HTML/Template/IT.php");


## process
$action = new ListScheduleAction();
$data = $action->execute();


#print_r($data);


## make view
$view = new HTML_Template_IT("./view");
$view->loadTemplatefile("confirm_schedule.html", true, true);

if(!$data){ $view->setVariable("message",  "no record"); }else{  $view->setVariable("message",  ""); }


foreach($data as $key=>$value){
	
	## if s_end==null, display &nbsp;
	$value['s_start'] = (!$value['s_start'])? '&nbsp;' : $value['s_start'];
	$value['s_end']   = (!$value['s_end'])?   '&nbsp;' : $value['s_end'];
	
	## change to string friendly
	switch($value['s_status']){
		case 0:
			$value['s_status'] = '0: '.$lang['scheduled'];
			break;
		case 1:
			$value['s_status'] = '1: '.$lang['sending'];
			break;
		case 2:
			$value['s_status'] = '2: '.$lang['done'];
			break;
		
	}
	
	$view->setVariable("s_id",  $value['s_id']);
	$view->setVariable("s_logid",     $value['s_logid']);
	$view->setVariable("s_status", $value['s_status']);
	$view->setVariable("s_start",       $value['s_start']);
	$view->setVariable("s_schedule",       $value['s_schedule']);
	$view->setVariable("s_end",       $value['s_end']);
	$view->setVariable("g_title",       $value['g_title']);
	$view->setVariable("g_group_id",       $value['g_group_id']);
	
	$view->setCurrentBlock("RECORD") ;
	$view->parseCurrentBlock("RECORD") ;   
}


$view->parseCurrentBlock();
$view->show();


?>