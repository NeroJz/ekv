<?php

class M_ext_module_pt extends MY_Model{
	protected $_table_name = 'module_pt';
	protected $_primary_key = 'pt_id';
	
	/************************************************************************************
 	* Description		: this function is use to return the percentage of VK call from helper
 	* input				: $filters - filter variable ppr_categor, mod_id
 	* author			: Jz
 	* Date				: 11-04-2014
 	* Modification Log	:
 	*************************************************************************************/
	public function get_by_filter($filters){
		
		$this->db->select('pt_teori, pt_amali');
		$this->db->from($this->_table_name);
		$this->db->where($filters);
		
		$result = $this->db->get();
		
		if($result->num_rows()>0){
			$result = $result->result_array();
			return $result[0]['pt_teori']."-".$result[0]['pt_amali'];
			
		}else{
			return null;
		}
	}
	/************************************************************************************
 	* Description		: this function is use to insert multiplte object on Module_pt
 	* input				: $data = object to be insert
 	* author			: Jz
 	* Date				: 11-04-2014
 	* Modification Log	:
 	*************************************************************************************/
	public function insert_by_batch($data){
		$this->db->insert_batch($this->_table_name,$data);
		if($this->db->affected_rows() > 0){
			return TRUE;
		}
	}
}
