<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

require_once("DB.php");
require_once("config.inc");




class SearchAction{
	
	var $bean;
	
	function SearchAction($bean){
		$this->bean = $bean;
	}
	
	function execute(){
		global $cfg;
		
		$data = array();
		
		## Connect to DB
		$dbh = DB::connect($cfg['dsn']);
		if (DB::isError($dbh)) { trigger_error("Cannot connect: ".DB::errorMessage($dbh), E_USER_ERROR); }
		
		
		## Process SQL
		
		## Add limitation to this variable
		$where;
		
		## Address
		if($this->bean->getAddressR() != null && $this->bean->getAddress() != null){
			$where .= " AND "."r_address ".$this->bean->getAddressR()." '".$this->bean->getAddress()."' ";
		}
		
		## Title
		if($this->bean->getTitleR()  != null && $this->bean->getTitle() != null){
			$where .= " AND "."g_title ".$this->bean->getTitleR()." '".$this->bean->getTitle()."' ";
		}
		
		## sent_num
		if($this->bean->getSent_numR() != null && $this->bean->getSent_num() != null){
			$where .= " AND "."r_sentnum ".$this->bean->getSent_numR()." ".$this->bean->getSent_num();
		}
		
		## validity
		if($this->bean->getValidityR() != null && $this->bean->getValidity() != null){
			$where .= " AND "."r_validity ".$this->bean->getValidityR()." ".$this->bean->getValidity();
		}
		
		## no_error
		if($this->bean->getNoerrorR() != null && $this->bean->getNoerror() != null){
			$where .= " AND "."r_noerror ".$this->bean->getNoerrorR()." ".$this->bean->getNoerror();
		}		
		## member
		if($this->bean->getMemberR() != null && $this->bean->getMember() != null){
			$where .= " AND "."r_member ".$this->bean->getMemberR()." ".$this->bean->getMember();
		}
		
		
		
		$query = "SELECT r_id, r_group_id, r_address, r_validity, r_noerror, r_member, r_sentnum, r_lastsent, group.g_title FROM `record`,`group` WHERE record.r_group_id=group.g_group_id " .    $where;
		
		## ヒット件数を求めるSQL
		// JOINする必要が有る場合
		if($this->bean->getTitleR()  != null && $this->bean->getTitle() != null){
			$query_nolimit = "SELECT COUNT(r_id) as numrows FROM `record`,`group` WHERE record.r_group_id=group.g_group_id " .    $where;
		}else{
			if($where != null){
				$query_nolimit = "SELECT COUNT(r_id) as numrows FROM `record` WHERE 1 " . $where;
			}else{
				$query_nolimit = "SELECT COUNT(r_id) as numrows FROM `record` ";
			}
		}
		
		$query = $query. " LIMIT ".$this->bean->getPage().",".$cfg['record_count'];
		
		#print($query);
		
		## /Process SQL
		
		
		
		## Get all rows
		$result = $dbh->query($query_nolimit);
		if(DB::isError($result)){ trigger_error($query_nolimit." : ".DB::errorMessage($result), E_USER_ERROR); }
		
		$row = $result->fetchRow( DB_FETCHMODE_ASSOC ) ;
		$numrows = $row['numrows'];
		
		
		## Get rows with limit
		$result = $dbh->query($query);
		if(DB::isError($result)){ trigger_error($query." : ".DB::errorMessage($result), E_USER_ERROR); }
		
		
		
		## Make data
		while ($row = $result->fetchRow( DB_FETCHMODE_ASSOC ) ) {
			
			array_push($data,
				array(
					'r_address'     =>$row['r_address'],
					'r_group_id'    =>$row['r_group_id'],
					'g_title'       =>$row['g_title'],
					'r_validity'    =>$row['r_validity'],
					'r_noerror'     =>$row['r_noerror'],
					'r_member'      =>$row['r_member'],
					'r_sentnum'     =>$row['r_sentnum'],
					'r_lastsent'    =>$row['r_lastsent'],
					'r_lastsent'    =>$row['r_lastsent'],
				)
			);
		}
		
		$_SESSION['count_all'] = $numrows;
		
		
		return $data;
	}
}


?>
