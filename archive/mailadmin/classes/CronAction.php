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




class CronAction{

	function CronAction(){}

	function execute(){
		global $cfg;
		
		
		## Connect to DB
		$dbh = DB::connect($cfg['dsn']);
		if (DB::isError($dbh)) { trigger_error("Cannot connect: ".DB::errorMessage($dbh), E_USER_ERROR); }
		
		
		
		
		
		
		$now_datetime = date('Y-n-j G:i');
		
		## Get a scheduled task
		#$query = 'SELECT s_id,log.l_groupid, log.l_from, log.l_subject, log.l_body, log.l_code  FROM `schedule`,`log` WHERE (schedule.s_status=0 OR schedule.s_status=1) AND schedule.s_logid=log.l_logid ORDER BY s_start';
		$query = 'SELECT s_id,log.l_groupid, log.l_from, log.l_subject, log.l_body, log.l_code  FROM `schedule`,`log` WHERE schedule.s_status=0 AND schedule.s_logid=log.l_logid AND s_schedule < \''.$now_datetime.'\' ORDER BY s_start';
		#print $query;
		$result = $dbh->query($query);
		if(DB::isError($result)){ trigger_error($query." : ".DB::errorMessage($result), E_USER_ERROR); }
		
		
		
		if($result->numRows() == 0) trigger_error('No task', E_USER_NOTICE);
		
		
		
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
			
			## Set to bean
			$bean = new ConfirmBean();
			$bean->setGroupID($row['l_groupid']);
			$bean->setFrom($row['l_from']);
			$bean->setSubject($row['l_subject']);
			$bean->setBody($row['l_body']);
			$bean->validate();
			
			
			
			## status:FLAG to 1
			$query = 'UPDATE `schedule` SET s_status=1 WHERE s_status=0 AND s_id='.$row['s_id'];
			$result2 = $dbh->query($query);
			if(DB::isError($result2)){ trigger_error($query." : ".DB::errorMessage($result2), E_USER_ERROR); }
			
			## process
			$action = new SendAction($bean);
			$action->execute();
			
			
			## status:FLAG to 2
			$query = 'UPDATE `schedule` SET s_status=2,s_end=NOW() WHERE s_status=1 AND s_id='.$row['s_id'];
			$result2 = $dbh->query($query);
			if(DB::isError($result2)){ trigger_error($query." : ".DB::errorMessage($result2), E_USER_NOTICE ); }
			
			
		}
	}
}


?>
