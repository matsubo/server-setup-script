<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */


class LogBean{

	var $s_logid;


	function LogBean(){}
	
	function setS_logid($s_logid){
		$this->s_logid = $s_logid;
	}
	
	function getS_logid(){
		return $this->s_logid;
	}
	
	/**
	 * Validation of parameters
	 */
	function validate(){
		if(!$this->s_logid)  trigger_error('Invalid access', E_USER_ERROR);
	}
}


?>