<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */


class ScheduleDeleteBean{

	var $s_id;


	function ScheduleDeleteBean(){}

	function setS_ID($s_id){
		$this->s_id = $s_id;
	}

	function getS_ID(){
		return $this->s_id;
	}
	
	
	/**
	 * Validation of parameters
	 */
	function validate(){
		if(!$this->s_id)  trigger_error('Invalid access', E_USER_ERROR);
	}
}


?>