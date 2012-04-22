<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */


class CancelBean{

	var $mail;


	function CancelBean(){}

	function setMail($mail){
		$this->mail = $mail;
	}

	function getMail(){
		return $this->mail;
	}
	
	
	
	
	/**
	 * Validation of parameters
	 */
	function validate(){
		if($this->mail == null)  trigger_error('Invalid mail address', E_USER_ERROR);
	}
}


?>