<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

require_once("DB.php");
require_once("config.inc");




class DeleteAction{

	var $bean;

	function DeleteAction($bean){
		$this->bean = $bean;
	}

	function execute(){
		global $cfg;
		
		
		## Connect to DB
		$dbh = DB::connect($cfg['dsn']);
		if (DB::isError($dbh)) { trigger_error("Cannot connect: ".DB::errorMessage($dbh), E_USER_ERROR); }
		
		
		## Make a group
		
		# INSERT into DB
		$query = "DELETE FROM `group` WHERE g_group_id=".$this->bean->getGroupID();
		$result = $dbh->query($query);
		if(DB::isError($result)){ trigger_error($query." : ".DB::errorMessage($result), E_USER_ERROR); }
		
		$query = "DELETE FROM `record` WHERE r_group_id=".$this->bean->getGroupID();
		$result = $dbh->query($query);
		if(DB::isError($result)){ trigger_error($query." : ".DB::errorMessage($result), E_USER_ERROR); }
		
		
	}
}


?>
