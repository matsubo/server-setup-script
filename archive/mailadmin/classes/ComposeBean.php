<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */


class ComposeBean{

	var $g_group_id;


	function ComposeBean(){}

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
		if($this->g_group_id == null)  trigger_error('Invalid access', E_USER_ERROR);
	}
}


?>