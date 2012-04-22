<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

require_once("config.inc");

require_once("classes/RecordBean.php");
require_once("classes/RecordAction.php");

require_once("HTML/Template/IT.php");



## bean

$limit_start = ($_GET['start'])? $_GET['start']:0;



$bean = new RecordBean();
$bean->setGroupID($_GET['g_group_id']);
$bean->setStart($limit_start);
$bean->validate();



## process
$action = new RecordAction($bean);
$data = $action->execute();
$rows = $action->getRows();


#print_r($data);






## make view
$view = new HTML_Template_IT("./view");
$view->loadTemplatefile("record.html", true, true);


if(($bean->getStart() - $cfg['record_count']) >= 0 ){
	$view->setVariable("from_link",    "<a href=\"?start=".($bean->getStart()-$cfg['record_count'])."&g_group_id=".$bean->getGroupID()."\">&lt;&lt;前へ</a>");
}else{
	$view->setVariable("from_link",    "&lt;&lt;前へ");
}


if($bean->getStart()+$cfg['record_count'] < $rows ){
	$view->setVariable("to_link",      " <a href=\"?start=".($bean->getStart()+$cfg['record_count'])."&g_group_id=".$bean->getGroupID()."\">次へ&gt;&gt;</a>");
}else{
	$view->setVariable("to_link",      " 次へ&gt;&gt;");
}

$view->setVariable("g_group_id",  $bean->getGroupID());
$view->setVariable("from",  $bean->getStart()+1);
$view->setVariable("to",  $bean->getStart()+$cfg['record_count']);
$view->setVariable("record_count", $rows);





foreach($data as $key=>$value){
	
	$validity = ($value['r_validity']==1)? 'o':'x';
	$noerror = ($value['r_noerror']==1)? 'o':'x';
	$member   = ($value['r_member']==1)? 'o':'x';
	
	
	$view->setVariable("r_address",  $value['r_address']);
	$view->setVariable("r_validity", $validity);
	$view->setVariable("r_noerror", $noerror);
	$view->setVariable("r_member", $member);
	$view->setVariable("r_sentnum",  $value['r_sentnum']);
	
	$view->setCurrentBlock("RECORD") ;
	$view->parseCurrentBlock("RECORD") ;   
}


$view->parseCurrentBlock();
$view->show();


?>
