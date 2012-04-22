<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

require_once("DB.php");
require_once("config.inc");




class MemberAction{

	var $bean;

	function MemberAction($bean){
	
		$this->bean = $bean;
	}

	function execute(){
		global $cfg;
		
		
		## Connect to DB
		$dbh = DB::connect($cfg['dsn']);
		if (DB::isError($dbh)) { trigger_error("Cannot connect: ".DB::errorMessage($dbh), E_USER_ERROR); }
		
		
		
		
		
		# read a file
		$fp = fopen($this->bean->getPath(), "r");
		
		while (!feof ($fp)) {
			# Read
			$buffer = fgets($fp, 4096);
			$buffer = trim($buffer);
			
			if($buffer == '')
				break;
			
			# DELETE FROM DB
			#$query = "DELETE FROM record WHERE r_address = '".$buffer."'";
			$query = "UPDATE record SET r_member=1 WHERE r_address = '".$buffer."'";
			$result = $dbh->query($query);

			if(DB::isError($result)){ trigger_error($query." : ".DB::errorMessage($result), E_USER_ERROR); }

		}


		fclose ($fp); 

		return true;
	}
}


?>
