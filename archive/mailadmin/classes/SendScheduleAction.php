<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

require_once("DB.php");
require_once("config.inc");
require_once("classes/TransformTable.php");
require_once("classes/ConfirmBean.php");




class SendScheduleAction{

	var $bean;

	function SendScheduleAction($bean){
	
		$this->bean = $bean;
	}

	function execute(){
		global $cfg;
		
		
		## Connect to DB
		$dbh = DB::connect($cfg['dsn']);
		if (DB::isError($dbh)) { trigger_error("Cannot connect: ".DB::errorMessage($dbh), E_USER_ERROR); }
		
		
		
		
		## Insert log
		$query =  "INSERT INTO log (l_groupid, l_from, l_subject, l_code, l_body,l_timestamp) ";
		$query .= "VALUES(".$this->bean->getGroupID().",'".$this->bean->getFrom()."','".$this->bean->getSubject()."','".$this->bean->getCode()."','".$this->bean->getBody()."',NOW())";
		$result = $dbh->query($query);
		if(DB::isError($result)){ trigger_error($query." : ".DB::errorMessage($result), E_USER_ERROR); }
		
		$query = 'SELECT l_logid FROM `log` ORDER BY l_logid DESC LIMIT 1';
		$result = $dbh->query($query);
		if(DB::isError($result)){ trigger_error($query." : ".DB::errorMessage($result), E_USER_ERROR); }
		
		
		$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
		$result->free();
		
		## The last ID
		$l_logid = $row['l_logid'];
		
		
		$s_schedule = $this->bean->getYear().'-'.$this->bean->getMonth().'-'.$this->bean->getDay().' '.$this->bean->getHour().':'.$this->bean->getMinute();
		
		
		## Schedule to send
		$query =  "INSERT INTO schedule (s_logid, s_status, s_start, s_schedule) ";
		$query .= "VALUES(".$l_logid.", 0 , NOW(), '$s_schedule')";
		$result = $dbh->query($query);
		if(DB::isError($result)){ trigger_error($query." : ".DB::errorMessage($result), E_USER_ERROR); }
		
		
		
		
	}
	
}
?>