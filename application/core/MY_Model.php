<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');


/**************************************************************************************************
* Description		: This class is a parent class for the CRUD model
* Author			: JZ
* Date				: 01-04-2014
* Attributes		: $_table_name = table used in database, $_primary_key = primary_key_field,
* 					  $_filter = filter_inputs, $_order_by = order_fields_by, $_rules = filter_array
* Properties		: __construct(), insert(), get(), delete(), update()
* Input Parameter	: -
* Modification Log	: -
**************************************************************************************************/

class MY_Model extends CI_Model{
	
	protected $_table_name = '';
	protected $_primary_key = '';
	protected $_filter = '';
	protected $_order_by = '';
	protected $_rules = array();
	
	function __construct(){
		parent::__construct();
	}
/**************************************************************************************************
* Description		: This function use to insert new data into table
* Author			: JZ
* Date				: 01-04-2014
* Input Parameter	: $data = array data to be insert
* Modification Log	: -
**************************************************************************************************/
	public function insert($data){
		$this->db->insert($this->_table_name,$data);
		if($this->db->affected_rows() > 0){
			return TRUE;
		}else{
			return FALSE;
		}
	}
/**************************************************************************************************
* Description		: This function use to select data into table
* Author			: JZ
* Date				: 01-04-2014
* Input Parameter	: $id = value of primary key, if not set all records will be returned
* Modification Log	: -
**************************************************************************************************/
	public function get($id = NULL){
		if($id != NULL){
			$this->db->from($this->_table_name)->where($this->_primary_key,$id);
		}else{
			$this->db->from($this->_table_name);
		}
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result();
		}
	}
/**************************************************************************************************
* Description		: This function use to update a single record into table
* Author			: JZ
* Date				: 01-04-2014
* Input Parameter	: $filters = array object to be filter, $fields = string query
* Modification Log	: -
**************************************************************************************************/
	function get_filters($filters,$fields=null){
		if($fields != null){
			$this->db->select($fields)->from($this->_table_name)->where($filters);
		}else{
			$this->db->select('*')->from($this->_table_name)->where($filters);
		}
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return FALSE;
		}
	}
/**************************************************************************************************
* Description		: This function use to delete data into table
* Author			: JZ
* Date				: 01-04-2014
* Input Parameter	: $id = value of primary key, if not set operation will stop
* Modification Log	: -
**************************************************************************************************/
	
	public function delete($id = NULL){
		if($id != NULL){
			$result = $this->get($id);
			
			if(sizeof($result) > 0){
				$this->db->where($this->_primary_key,$id)->delete($this->_table_name);
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return;
		}
	}
	
/**************************************************************************************************
* Description		: This function use to delete data into table base on supplied filters
* Author			: JZ
* Date				: 01-04-2014
* Input Parameter	: $filters = array object filters
* Modification Log	: -
**************************************************************************************************/
	public function delete_filters($filters){
		$this->db->where($filters)->delete($this->_table_name);
		return TRUE;
	}

/**************************************************************************************************
* Description		: This function use to update a single record into table
* Author			: JZ
* Date				: 01-04-2014
* Input Parameter	: $id = value of primary key, if not set operation will stop
* 					  $data = array data to be updated into fields
* Modification Log	: -
**************************************************************************************************/
	
	function update($data, $id = NULL){
		$result = $this->get($id);
		if(sizeof($result) > 0){
			$this->db->where($this->_primary_key, $id);
			$this->db->update($this->_table_name,$data);
				
			if($this->db->affected_rows() > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}
/**************************************************************************************************
* Description		: This function use to update a single record into table based on the filters
* Author			: JZ
* Date				: 01-04-2014
* Input Parameter	: $id = value of primary key, if not set operation will stop
* 					  $data = array data to be updated into fields
* Modification Log	: -
**************************************************************************************************/
	
	function update_filters($data, $filters){
		$result = $this->get_filters($filters);
		if(sizeof($result) > 0){
			$this->db->where($filters);
			$this->db->update($this->_table_name,$data);
				
			if($this->db->affected_rows() > 0){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}

}
