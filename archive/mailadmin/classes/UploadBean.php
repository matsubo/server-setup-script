<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */


class UploadBean{

	var $path;
	var $title;


	function UploadBean(){}

	function setPath($path){
		$this->path = $path;
	}

	function getPath(){
		return $this->path;
	}
	
	
	
	
	function setTitle($title){
		$this->title = $title;
	}
	
	function getTitle(){
		return $this->title;
	}
	
	
	/**
	 * Validation of parameters
	 */
	function validate(){
		if(!$this->path)   trigger_error('File is not set',   E_USER_ERROR);
		if(!$this->title)  trigger_error('Title is not set',  E_USER_ERROR);
	}
}


?>