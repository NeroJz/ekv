<?php

class M_ext_module extends MY_Model{
	protected $_table_name = 'module';
	protected $_primary_key = 'mod_id';
	
	/****************************************************************************
	 	* Description		: this function return new mod_id after insert into Module
	 	* input				: $data - array data to be insert
	 	* author			: Jz
	 	* Date				: 07-04-2014
	 	* Modification Log	:
	 	*****************************************************************************/
	function return_insert_id($data){
		$result = $this->insert($data);
		
		if($result){
			return $this->db->insert_id();
		}else{
			return false;
		}
	}
}
