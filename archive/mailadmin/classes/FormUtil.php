<?php
/*
 ** Mail address register
 *
 * 2004/8/8 matsu@ht.sfc.keio.ac.jp
 */


class FormUtil{

	/** Type of form object (text|select) */
	var $type;
	var $name;
	var $value;
	var $selected;

	function FormUtil($type='',$name='', $value='', $selected=''){
		
		$this->type  = $type;
		$this->name  = $name;
		$this->value = $value;
		$this->selected = $selected;
		
	}
	
	
	
	
	/**
	 * Validation of parameters
	 */
	function show(){
		
		/** Error check */
		if(!$this->type)   trigger_error('Form "type" is not set',   E_USER_ERROR);
		if(!$this->name)   trigger_error('Form "name" is not set',  E_USER_ERROR);
		
		
		/** Return text fireld HTML string */
		if($this->type == 'text'){
			
			return '<input type="text" value="$this->value" />';
			
		/** Return select box HTML string */
		}else if($this->type == 'select'){
			
			## check
			if(!is_array($this->value))  trigger_error('Values are not array ',   E_USER_ERROR);
			
			$text = '';
			
			$text .= '<select name="'.$this->name.'">';
			
			foreach($this->value as $value){
				if($this->selected == $value){
					$text .= '<option value="'.$value.'" selected="selecetd">'.$value.'</option>';
				}else{
					$text .= '<option value="'.$value.'">'.$value.'</option>';
				}
			}
			
			
			$text .= '</select>';
			
			return $text;
			
		}
		
	}
	
	
	
	/**
	 * Returns filled array by TO to FROM
	 * Ex: makeSimpleArray(5-8);  = array(5,6,7,8)
	 */
	function makeSimpleArray($from, $to){
		
		if($from > $to) trigger_error('Parameter is from,to ',   E_USER_ERROR);
		
		
		$array = array();
		
		for($i=$from;$i<=$to;$i++) array_push($array, $i);
		
		return $array;
	}
	
}


?>