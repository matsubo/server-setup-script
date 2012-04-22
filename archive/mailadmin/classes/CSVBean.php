<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */


class CSVBean{

	var $g_group_id;


	function setGroupID($id){
		$this->g_group_id = $id;
	}
	function getGroupID(){
		return $this->g_group_id;
	}
	
	
	/**
	 * Validation of parameters
	 */
	function validate(){
		if($this->g_group_id == null)  trigger_error('Fill g_group_id', E_USER_ERROR);
	}
}


?>