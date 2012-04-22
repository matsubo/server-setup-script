<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */


class ConfirmBean{

	var $g_group_id;
	var $from;
	var $subject;
	var $code;
	var $body;

	var $year;
	var $month;
	var $day;
	var $hour;
	var $minute;

	function ConfirmBean(){}

	function setGroupID($id){
		$this->g_group_id = $id;
	}
	function getGroupID(){
		return $this->g_group_id;
	}
	
	
	function setFrom($from){
		$this->from = $from;
	}
	function getFrom(){
		return $this->from;
	}
	
	
	function setSubject($subject){
		$this->subject = $subject;
	}
	function getSubject(){
		return $this->subject;
	}
	
	
	function setBody($body){
		
		$body = str_replace('__baitai__', $this->code, $body);

		
		$this->body = $body;
	}
	function getBody(){
		return $this->body;
	}
	

	function setCode($code){
		$this->code = $code;
	}

	function getCode(){
		return $this->code;
	}
	
	
	
	
	function setYear($year){
		$this->year = $year;
	}
	function getYear(){
		return $this->year;
	}
	
	function setMonth($month){
		$this->month = $month;
	}
	function getMonth(){
		return $this->month;
	}
	
	
	function setDay($day){
		$this->day = $day;
	}
	function getDay(){
		return $this->day;
	}
	
	function setHour($hour){
		$this->hour = $hour;
	}
	function getHour(){
		return $this->hour;
	}
	
	function setMinute($minute){
		$this->minute = $minute;
	}
	function getMinute(){
		return $this->minute;
	}
	
	
	
	
	
	
	
	
	
	/**
	 * Validation of parameters
	 */
	function validate(){
		if($this->g_group_id == null)  trigger_error('Invalid access', E_USER_ERROR);
		if($this->from == null)        trigger_error('Fill mail from', E_USER_ERROR);
		if($this->subject == null)     trigger_error('Fill mail subject', E_USER_ERROR);
#		if($this->code == null)     trigger_error('Fill code', E_USER_ERROR);
		if($this->body == null)        trigger_error('Fill mail body', E_USER_ERROR);
	}
}


?>