<?php

class M_ext_announcement extends MY_Model{
	protected $_table_name = 'announcement';
	protected $_primary_key = 'ann_id';
	
	/****************************************************************************
	 	* Description		: this function return new ann_id after insert into announcement
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
