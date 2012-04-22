<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

require_once("config.inc");

require_once("classes/LogBean.php");
require_once("classes/LogAction.php");

require_once("HTML/Template/IT.php");



## bean
$bean = new LogBean();
$bean->setS_logid($_GET['s_logid']);
$bean->validate();



## process
$action = new LogAction($bean);
$data = $action->execute();

#print_r($data);






## make view
$view = new HTML_Template_IT("./view");
$view->loadTemplatefile("each_log.html", true, true);


foreach($data as $key=>$value){
	
	
	$view->setVariable("from",    $value['l_from']);
	$view->setVariable("subject", $value['l_subject']);
	$view->setVariable("body",    htmlspecialchars($value['l_body']));
	
	$view->setCurrentBlock("RECORD") ;
	$view->parseCurrentBlock("RECORD") ;   
}


$view->parseCurrentBlock();
$view->show();


?>