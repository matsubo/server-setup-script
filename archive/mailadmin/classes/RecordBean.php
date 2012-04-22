<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */


class RecordBean{

	var $g_group_id;
	var $start = 0;


	function RecordBean(){}
	
	function setGroupID($id){
		$this->g_group_id = $id;
	}
	
	function getGroupID(){
		return $this->g_group_id;
	}
	
	
	function setStart($start){
		$this->start = $start;
	}
	
	function getStart(){
		return $this->start;
	}
	
	
	
	
	
	/**
	 * Validation of parameters
	 */
	function validate(){
		if(!$this->g_group_id)  trigger_error('Invalid access', E_USER_ERROR);
	}
}


?>