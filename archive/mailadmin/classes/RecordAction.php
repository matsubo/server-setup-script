<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

require_once("DB.php");
require_once("config.inc");




class RecordAction{
	
	var $bean;
	var $rows;
	
	function RecordAction($bean){
		$this->bean = $bean;
	}
	
	function execute(){
		global $cfg;
		$data = array();
		
		## Connect to DB
		$dbh = DB::connect($cfg['dsn']);
		if (DB::isError($dbh)) { trigger_error("Cannot connect: ".DB::errorMessage($dbh), E_USER_ERROR); }
		
		
		$query = "SELECT r_address, r_validity, r_noerror, r_member, r_sentnum  FROM `record` WHERE r_group_id=".$this->bean->getGroupID()." LIMIT ".$this->bean->getStart().",".$cfg['record_count'];
		#print $query;
		$result = $dbh->query($query);
		if(DB::isError($result)){ trigger_error($query." : ".DB::errorMessage($result), E_USER_ERROR); }
		
		$query2 = "SELECT r_id  FROM `record` WHERE r_group_id=".$this->bean->getGroupID();
		#print $query;
		$result2 = $dbh->query($query2);
		if(DB::isError($result2)){ trigger_error($query2." : ".DB::errorMessage($result2), E_USER_ERROR); }
		
		
		$this->rows = $result2->numRows();
		
		## Make data
		while ($row = $result->fetchRow( DB_FETCHMODE_ASSOC ) ) {
			array_push($data,
				array(
					'r_address'     =>$row['r_address'],
					'r_validity'    =>$row['r_validity'],
					'r_noerror'     =>$row['r_noerror'],
					'r_member'      =>$row['r_member'],
					'r_sentnum'     =>$row['r_sentnum'],
				)
			);
		}
		
		
		return $data;
	}
	
	function getRows(){
		
		return $this->rows;
		
	}
}


?>
