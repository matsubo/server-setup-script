<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

require_once("DB.php");
require_once("config.inc");




class ListScheduleAction{

	function ListScheduleAction(){
	}

	function execute(){
		global $cfg;
		$data = array();
		
		## Connect to DB
		$dbh = DB::connect($cfg['dsn']);
		if (DB::isError($dbh)) { trigger_error("Cannot connect: ".DB::errorMessage($dbh), E_USER_ERROR); }
		
		
		
		## Get data
		$query = "SELECT s_id, s_logid, s_status, s_start, s_schedule, s_end FROM `schedule` ORDER BY s_start DESC";
		$result = $dbh->query($query);
		if(DB::isError($result)){ trigger_error($query." : ".DB::errorMessage($result), E_USER_ERROR); }
		
		
		
		## Make data
		while ($row = $result->fetchRow( DB_FETCHMODE_ASSOC ) ) {
			## Select not yet proceeding
			/*
			$query = "SELECT COUNT(record.r_id) as num  FROM `record`,`group`,`log` WHERE log.l_logid=".$row['s_logid']." AND log.l_groupid=group.g_group_id AND group.g_group_id=record.r_group_id";
			$result2 = $dbh->query($query);
			if(DB::isError($result2)){ trigger_error($query." : ".DB::errorMessage($result2), E_USER_ERROR); }
			
			$row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC);
			
			
			
			## Select proceeded
			
			$query = "SELECT COUNT(record.r_id) as num  FROM `record`,`group`,`log` WHERE log.l_logid=".$row['s_logid']." AND log.l_groupid=group.g_group_id AND group.g_group_id=record.r_group_id";
			$result3 = $dbh->query($query);
			if(DB::isError($result3)){ trigger_error($query." : ".DB::errorMessage($result3), E_USER_ERROR); }
			
			$row3 = $result3->fetchRow(DB_FETCHMODE_ASSOC);
			#print $query;
			*/
			$query = "SELECT group.g_title, group.g_group_id  FROM `group`,`log` WHERE log.l_logid=".$row['s_logid']." AND log.l_groupid=group.g_group_id";
			$result4 = $dbh->query($query);
			if(DB::isError($result4)){ trigger_error($query." : ".DB::errorMessage($result4), E_USER_ERROR); }
			
			$row4 = $result4->fetchRow(DB_FETCHMODE_ASSOC);
			
			
			
			array_push($data,
				array(
					's_id'       =>$row['s_id'],
					's_logid'    =>$row['s_logid'],
					's_status'   =>$row['s_status'],
					's_start'    =>$row['s_start'],
					's_schedule' =>$row['s_schedule'],
					's_end'      =>$row['s_end'],
					#'sent'       =>$row3['num'],
					#'yet_sent'   =>$row2['num'],
					'g_title'    =>$row4['g_title'],
					'g_group_id' =>$row4['g_group_id'],
				)
			);
		}
		
		
		return $data;
	}
}


?>
