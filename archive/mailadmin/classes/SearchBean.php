<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */


class SearchBean{

	var $start = 0;

	var $address;
	var $addressR;

	var $title;
	var $titleR;

	var $sentnum;
	var $sentnumR;

	var $validity;
	var $validityR;
	
	var $noerror;
	var $noerrorR;

	var $page;




	function SearchBean(){}
	
	## LIMIT
	function setStart($start){
		$this->start = $start;
	}
	
	function getStart(){
		return $this->start;
	}
	
	
	## Address
	function setAddress($address){
		$this->address = $address;
	}
	
	function getAddress(){
		return $this->address;
	}
	
	function setAddressR($addressR){
		$this->addressR = $addressR;
	}
	function getAddressR(){
		return $this->addressR;
	}
	
	
	## Title
	function setTitle($title){
		$this->title = $title;
	}
	
	function getTitle(){
		return $this->title;
	}
	
	function setTitleR($titleR){
		$this->titleR = $titleR;
	}
	function getTitleR(){
		return $this->titleR;
	}
	
	
	## sent_num
	function setSent_num($sent_num){
		$this->sent_num = $sent_num;
	}
	
	function getSent_num(){
		return $this->sent_num;
	}
	
	function setSent_numR($sent_numR){
		$this->sent_numR = $sent_numR;
	}
	function getSent_numR(){
		return $this->sent_numR;
	}
	
	
	## validity
	function setValidity($validity){
		$this->validity = $validity;
	}
	
	function getValidity(){
		return $this->validity;
	}
	
	function setValidityR($validityR){
		$this->validityR = $validityR;
	}
	function getValidityR(){
		return $this->validityR;
	}
	
	
	
	## noerror
	function setNoerror($noerror){
		$this->noerror = $noerror;
	}
	
	function getNoerror(){
		return $this->noerror;
	}
	
	function setNoerrorR($noerrorR){
		$this->noerrorR = $noerrorR;
	}
	function getNoerrorR(){
		return $this->noerrorR;
	}
	
	## member
	function setMember($member){
		$this->member = $member;
	}
	
	function getMember(){
		return $this->member;
	}
	
	function setMemberR($memberR){
		$this->memberR = $memberR;
	}
	function getMemberR(){
		return $this->memberR;
	}
	
	## page
	function setPage($page){
		if($page != null)
			$this->page = $page;
		else
			$this->page = 0;
	}
	
	function getPage(){
		return $this->page;
	}
	
	
	/**
	 * Validation of parameters
	 */
	function validate(){
#		if(!$this->g_group_id)  trigger_error('Invalid access', E_USER_ERROR);
	}
}


?>