<?php
/*
 ** Mail address canceller
 *
 * 2004/9/24 matsu@ht.sfc.keio.ac.jp
 */

$old_path=ini_get('include_path');
ini_set('include_path', $old_path.':.:/var/www/admin/mailadmin');


require_once("config.inc");

require_once("classes/CancelBean.php");
//require_once("classes/DeleteInvalid.php");
require_once("classes/CancelAction.php");

require_once("HTML/Template/IT.php");




## Bean
$bean = new CancelBean();
$bean->setMail($_POST['mail']);

$bean->validate();



## Action
//$action = new DeleteInvalid($bean->getMail());
$action = new CancelAction($bean);
$num = $action->execute();

if($num > 0){
	#$message = "Accepted your cancellation.";
	$message = "配信拒否を受け付けました";
}else{
	#$message = "ERROR: Cannot proceed your cancellation request.";
	$message = "エラー: 配信解除を行えませんでした";
}

#print $num;

## make view
$view = new HTML_Template_IT("/var/www/admin/mailadmin/view");
$view->loadTemplatefile("kaijo.html", true, true);

$view->setVariable("message", $message);

$view->parseCurrentBlock();
$view->show();


?>