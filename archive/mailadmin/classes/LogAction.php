<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

require_once("DB.php");
require_once("config.inc");




class LogAction{
	
	var $bean;
	function LogAction($bean){
		$this->bean = $bean;
	}
	
	function execute(){
		global $cfg;
		$data = array();
		
		## Connect to DB
		$dbh = DB::connect($cfg['dsn']);
		if (DB::isError($dbh)) { trigger_error("Cannot connect: ".DB::errorMessage($dbh), E_USER_ERROR); }
		
		
		$query = "SELECT  l_logid, l_groupid, l_from, l_subject, l_body, l_timestamp  FROM `log` WHERE l_logid=".$this->bean->getS_logid();
		$result = $dbh->query($query);
		
		if(DB::isError($result)){ trigger_error($query." : ".DB::errorMessage($result), E_USER_ERROR); }
		
		
		## Make data
		while ($row = $result->fetchRow( DB_FETCHMODE_ASSOC ) ) {
			
			array_push($data,
				array(
					'l_logid'      =>$row['l_logid'],
					'l_groupid'    =>$row['l_groupid'],
					'l_from'       =>$row['l_from'],
					'l_subject'    =>$row['l_subject'],
					'l_body'       =>$row['l_body'],
					'l_timestamp'  =>$row['l_timestamp'],
				)
			);
		}
		
		
		return $data;
	}
}


?>
