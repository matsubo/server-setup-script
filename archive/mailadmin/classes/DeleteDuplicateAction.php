<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

$old_path=ini_get('include_path');
ini_set('include_path', $old_path.':.:/var/www/admin/mailadmin');


require_once("DB.php");
require_once("config.inc");
require_once("classes/TransformTable.php");
require_once("classes/ConfirmBean.php");




class DeleteDuplicateAction{

	function DeleteDuplicateAction(){}

	function execute(){
		global $cfg;
		
		
		## Connect to DB
		$dbh = DB::connect($cfg['dsn']);
		if (DB::isError($dbh)) { trigger_error("Cannot connect: ".DB::errorMessage($dbh), E_USER_ERROR); }
		
		
		## Select all record    ORDER BY mailaddress and registed date
		$query = 'SELECT r_id,r_address, g_timestamp FROM  record, `group` WHERE r_group_id=g_group_id ORDER BY r_address,g_timestamp';
		$result = $dbh->query($query);
		if(DB::isError($result)){ trigger_error($query." : ".DB::errorMessage($result), E_USER_ERROR); }
		
		
		
		$previous_id;
		$current_id;
		
		$previous_address;
		$current_address;
		
		$counter = 0;
		
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
			
			$current_id      = $row['r_id'];
			$current_address = $row['r_address'];
			
			
			if($current_address == $previous_address){
				## DELETE current entry
				
				$query = 'DELETE FROM `record` WHERE r_id ='.$current_id;
				$result2 = $dbh->query($query);
				if(DB::isError($result2)){ trigger_error($query." : ".DB::errorMessage($result2), E_USER_ERROR); }
				
				$counter++;
				
				print "$counter deleted: $current_id   $current_addres and $previous_address \n";
				
			}
			
			
			$previous_id      = $current_id;
			$previous_address = $current_address;

			
			
		}
		
		print "Deleted: ".$counter."\n";
		
	}
}


## Execute from web
if($_SERVER["SERVER_ADDR"]){
	$action = new DeleteDuplicateAction();
	$action->execute();
}

?>
