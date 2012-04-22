<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

require_once("config.inc");

require_once("classes/SearchBean.php");
require_once("classes/SearchAction.php");

require_once("HTML/Template/IT.php");



## bean
$bean = new SearchBean();

#print_r($_POST);


## SQL parameter

$bean->setAddressR($_POST['form_r_address_r']);
$bean->setAddress ($_POST['form_r_address']);

$bean->setTitleR($_POST['form_g_title_r']);
$bean->setTitle ($_POST['form_g_title']);

$bean->setSent_numR($_POST['form_r_sent_num_r']);
$bean->setSent_num ($_POST['form_r_sent_num']);

$bean->setValidityR($_POST['form_r_validity_r']);
$bean->setValidity ($_POST['form_r_validity']);

$bean->setNoerrorR($_POST['form_r_noerror_r']);
$bean->setNoerror ($_POST['form_r_noerror']);

$bean->setMemberR($_POST['form_r_member_r']);
$bean->setMember ($_POST['form_r_member']);

$bean->setPage ($_POST['page']);


## process
$action = new SearchAction($bean);
$data = $action->execute();

#print_r($data);






## make view
$view = new HTML_Template_IT("./view");
$view->loadTemplatefile("search.html", true, true);

if(!$data){ $view->setVariable("message",  "No data"); }else{  $view->setVariable("message",  ""); }

## Page index
$view->setVariable("next",      $bean->getPage()+$cfg['record_count']);
$view->setVariable("previous",  $bean->getPage()-$cfg['record_count']);
$view->setVariable("count_all",  $_SESSION['count_all']);

$view->setVariable("count_from",   $bean->getPage());
$view->setVariable("count_to",     $bean->getPage()+$cfg['record_count']-1);

#print_r($bean);

## Parameters
$view->setVariable("form_r_address_r",       $bean->getAddressR());
$view->setVariable("form_r_address",         $bean->getAddress());

$view->setVariable("form_g_title_r",         $bean->getTitleR());
$view->setVariable("form_g_title",           $bean->getTitle());

$view->setVariable("form_r_sent_num_r",      $bean->getSent_numR());
$view->setVariable("form_r_sent_num",        $bean->getSent_num());

$view->setVariable("form_r_validity_r",      $bean->getValidityR());
$view->setVariable("form_r_validity",        $bean->getValidity());

$view->setVariable("form_r_noerror_r",      $bean->getNoerrorR());
$view->setVariable("form_r_noerror",        $bean->getNoerror());

$view->setVariable("form_r_member_r",        $bean->getMemberR());
$view->setVariable("form_r_member",          $bean->getMember());

$view->setVariable("page",          $bean->getPage());



foreach($data as $key=>$value){
	
	$validity = ($value['r_validity']==1)? 'o':'x';
	$noerror = ($value['r_noerror']==1)? 'o':'x';
	$member   = ($value['r_member']==1)?   'o':'x';
	
	
	$view->setVariable("r_address",  $value['r_address']);
	$view->setVariable("r_group_id", $value['r_group_id']);
	$view->setVariable("g_title",     $value['g_title']);
	$view->setVariable("r_validity", $validity);
	$view->setVariable("r_noerror", $noerror);
	$view->setVariable("r_member", $member);
	$view->setVariable("r_sentnum",  $value['r_sentnum']);
	$view->setVariable("r_lastsent",  $value['r_lastsent']);
	
	$view->setCurrentBlock("RECORD") ;
	$view->parseCurrentBlock("RECORD") ;   
}


$view->parseCurrentBlock();
$view->show();


?>