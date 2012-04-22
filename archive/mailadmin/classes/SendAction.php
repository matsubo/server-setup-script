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




class SendAction{

	var $bean;

	function SendAction($bean){
	
		$this->bean = $bean;
	}

	function execute(){
		
		global $cfg;
		
		
		## Connect to DB
		$dbh = DB::connect($cfg['dsn']);
		if (DB::isError($dbh)) { trigger_error("Cannot connect: ".DB::errorMessage($dbh), E_USER_ERROR); }
		
		
		
		
		## Get the lastest index number
		$query = 'SELECT r_id,r_address,r_sentnum  FROM `record` WHERE r_validity=1 AND r_member=0 AND r_noerror=1 AND r_group_id='.$this->bean->getGroupID();
		$result = $dbh->query($query);
		if(DB::isError($result)){ trigger_error($query." : ".DB::errorMessage($result), E_USER_ERROR); }
		
		
		
		## Mail processor
		while($row = $result->fetchRow(DB_FETCHMODE_ASSOC)){
			## Replace string
			
			## __c0__
			#$body = str_replace('__c0__', $this->transform($row['r_address']), $this->bean->getBody());
			$body = $this->bean->getBody();
			
			
			## Send
			$subject = $this->bean->getSubject();
			$subject = mb_convert_encoding($subject, "ISO-2022-JP","AUTO");
			$subject = mb_encode_mimeheader($subject);

			$from = $this->bean->getFrom();
			$from = mb_convert_encoding($from, "ISO-2022-JP","AUTO");
			$from = mb_encode_mimeheader($from);
			
			
			#mb_send_
			mail($row['r_address'], $subject, mb_convert_encoding($body,"JIS","AUTO"),
					'From: '.$from."\r\nReturn-Path: ". $cfg['return-path'] );
			
			# test
			#mail('matsu@dsci.sfc.keio.ac.jp', $subject, mb_convert_encoding($body,"JIS","AUTO"), 'From: '.$this->bean->getFrom()."\r\nReturn-Path: ". $cfg['return-path'] );
			#$data = $row['r_address'] . $subject . mb_convert_encoding($body,"JIS","AUTO") . 'From: '.$this->bean->getFrom();
			
			# log
			$query2 = 'UPDATE `record` SET r_sentnum='.($row['r_sentnum']+1).', r_lastsent=NOW() WHERE r_id='.$row['r_id'];
			$result2 = $dbh->query($query2);
			if(DB::isError($result2)){ trigger_error($query2." : ".DB::errorMessage($result2), E_USER_ERROR); }
			
			# Output sending address
			#print $row['r_address']."\n";
		}
		
		
		
		
		$result->free();
		
		## Inform finishing
		for($i=0;$i<count($cfg['confirm_insert'] );$i++){
			#mail('matsu@dsci.sfc.keio.ac.jp', "Done a sending schedule.", mb_convert_encoding("送信を完了しました．","JIS","AUTO"), "From: mailadmin\r\nReturn-Path: ". $cfg['return-path']);
			mail($cfg['confirm_insert'][$i], "Done a sending schedule.", mb_convert_encoding("送信を完了しました．","JIS","AUTO"), "From: mailadmin@".$cfg['domain']."\r\nReturn-Path: ". $cfg['return-path']);
		}
		
		
	}
	
	
	
	
	/**
	 * Transform string
	 */
	function transform($address){
		$trans = new TransformTable();
		$transformed_mail = base64_encode($trans->convert($address));
#		$transformed_mail = pg_escape_string($transformed_mail);
		
		return $transformed_mail;
	}
}

?>
