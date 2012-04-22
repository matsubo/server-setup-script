<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */

require_once("config.inc");
require_once("classes/DeleteInvalid.php");




class InvalidAction{

	var $bean;

	function InvalidAction($bean){
	
		$this->bean = $bean;
	}

	function execute(){
		
		
		
		# read a file
		$fp = fopen($this->bean->getPath(), "r");
		
		while (!feof ($fp)) {
			# Read
			$buffer = fgets($fp, 4096);
			$buffer = trim($buffer);
			
			if($buffer == '')
				break;
			
			$action = new DeleteInvalid($buffer);
			$action->execute();
			
		}


		fclose ($fp); 

		return true;
	}
}


?>
