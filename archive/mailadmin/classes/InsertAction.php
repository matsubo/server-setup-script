<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

require_once("DB.php");
require_once("config.inc");




class InsertAction{

	var $bean;

	function InsertAction($bean){
	
		$this->bean = $bean;
	}

	function execute(){
		global $cfg;
		
		
		## Connect to DB
		$dbh = DB::connect($cfg['dsn']);
		if (DB::isError($dbh)) { trigger_error("Cannot connect: ".DB::errorMessage($dbh), E_USER_ERROR); }
		
		
		## Num of address
		$counter = 0;
		$prefix  = 0;
		
		
		# read a file
		$fp = fopen($this->bean->getPath(), "r");
		
		
		
		$id = 0;
		
		while (!feof ($fp)) {
			
			# Read
			$buffer = fgets($fp, 4096);
			$buffer = trim($buffer);
			
			if($buffer == '')
				break;
			
			
			## To deny nifty domain
			for($i=0; $i<count($cfg['except']); $i++){
				if(eregi($cfg['except'][$i], $buffer)){
					continue 2;
				}
			}


			
			## Make a group with prefix
			if(($counter%$cfg['separate_num'] == 0) || ($counter == 0)){
				
				
				# INSERT into DB
				$query = "INSERT INTO `group` (g_title, g_timestamp) VALUES('".$this->bean->getTitle()."_".++$prefix."',NOW())";
				$result = $dbh->query($query);
				if(DB::isError($result)){ trigger_error($query." : ".DB::errorMessage($result), E_USER_ERROR); }
				
				
				
				## Get the lastest index number
				
				$query = 'SELECT g_group_id  FROM `group` ORDER BY g_group_id DESC LIMIT 1';
				$result = $dbh->query($query);
				if(DB::isError($result)){ trigger_error($query." : ".DB::errorMessage($result), E_USER_ERROR); }
				
				
				$row = $result->fetchRow(DB_FETCHMODE_ASSOC);
				
				## Group ID
				$id = $row['g_group_id'];
				
			}
			
			
			# INSERT to DB
			$query = "INSERT INTO record (r_group_id, r_address) VALUES('".$id."','".$buffer."')";
			#print $query."<br>\n";
			$result = $dbh->query($query);

			## Comment out if want to display errors.
			#if(DB::isError($result)){ trigger_error($query." : ".DB::errorMessage($result), E_USER_ERROR); }
			#if(DB::isError($result)){ trigger_error($query." : ".DB::errorMessage($result), E_USER_NOTICE); }


			$counter++;

		}


		fclose ($fp); 

		return true;
	}
}


?>
