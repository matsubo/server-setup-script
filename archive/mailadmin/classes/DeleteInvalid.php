<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

require_once("DB.php");
require_once("config.inc");




class DeleteInvalid{

	var $address;

	function DeleteInvalid($address){
	
		$this->address = $address;
	}

	function execute(){
		global $cfg;
		
		
		## Connect to DB
		$dbh = DB::connect($cfg['dsn']);
		if (DB::isError($dbh)) { trigger_error("Cannot connect: ".DB::errorMessage($dbh), E_USER_ERROR); }
		
		
		
		# DELETE FROM DB
		#$query = "DELETE FROM record WHERE r_address = '".$buffer."'";
		$query = "UPDATE record SET r_noerror=0 WHERE r_address = '".$this->address."'";
		$result = $dbh->query($query);
		
		#print $query;
		
		if(DB::isError($result)){ trigger_error($query." : ".DB::errorMessage($result), E_USER_ERROR); }
		
		return $dbh->affectedRows();
	}
}


?>
