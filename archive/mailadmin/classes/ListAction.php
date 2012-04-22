<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

require_once("DB.php");
require_once("config.inc");




class ListAction{

	function ListAction(){
	}

	function execute(){
		global $cfg;
		$data = array();
		
		## Connect to DB
		$dbh = DB::connect($cfg['dsn']);
		if (DB::isError($dbh)) { trigger_error("Cannot connect: ".DB::errorMessage($dbh), E_USER_ERROR); }
		
		
		
		## Get data
		$query = "SELECT g_group_id,g_title,g_timestamp FROM `group` ORDER BY g_timestamp DESC";
		$result = $dbh->query($query);
		if(DB::isError($result)){ trigger_error($query." : ".DB::errorMessage($result), E_USER_ERROR); }
		
		
		
		## Make data
		while ($row = $result->fetchRow( DB_FETCHMODE_ASSOC ) ) {
		/*	
			$query = "SELECT COUNT(r_id) as num  FROM `record` WHERE r_group_id=".$row['g_group_id'];
			$result2 = $dbh->query($query);
			if(DB::isError($result2)){ trigger_error($query." : ".DB::errorMessage($result2), E_USER_ERROR); }
			
			$row2 = $result2->fetchRow(DB_FETCHMODE_ASSOC);
		*/
			
			array_push($data,
				array(
					'g_group_id' =>$row['g_group_id'],
					'g_title'    =>$row['g_title'],
					'g_timestamp'=>$row['g_timestamp'],
	#				'count'      =>$row2['num'],
				)
			);
		}
		
		
		return $data;
	}
}


?>
