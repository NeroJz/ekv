<?php

/**************************************************************************************************
* File Name        : audit.php
* Description      : This File contain process of database auditing.
* 					 This function only execute when sql update, insert and delete is execute. 
* 					 The session of user must have to audit the trail.
* Author           : Nabihah Abkarim
* Date             : 2 April 2014
* Version          : -
* Modification Log : -
* Function List	   : 
**************************************************************************************************/
	
    class Audit
    {
    	const INSERT = 'insert';
    	const UPDATE = 'update';
    	const DELETE = 'delete';
		
		 public function __construct()
    {
        $this->_cd =& get_instance();
		
    }
	
	/**********************************************************************************************
	* Description		: this function to record the audit for insert, insert_batch, update, and delete
	* 					  
	* input				: 
	* author			: Nabihah
	* Date				: 02 April 2014
	* Modification Log	: -
	**********************************************************************************************/
    	public function record($table, $sql, $type)
	{
		
			$audit_table = str_replace('`', '', $table);
			$staff_id = 0;
			$ip_address = 0;
			
			
        	if (isset($this->_cd->session->userdata['user_id'])) 
        	{
            	
            	$user_id = $this->_cd->session->userdata['user_id'];
			
        	}
			
			
			if (isset($this->_cd->session->userdata['ip_address'])) 
        	{
            	
            	$ip_address = $this->_cd->session->userdata['ip_address'];
			
        	}
			
			
			if(isset($user_id) && $user_id != 0)
			{
				 $log_data = array('trail_operation' => $type,
				'trail_date' => time(),
				'trail_sql' => $sql,
				'trail_table' => $audit_table,
				'trail_address' => $ip_address,
				'staff_id' => $user_id);
			
				$tod = $this -> _cd -> db;
				$tod -> insert_audit('audit_trail', $log_data);
			}
		
		
		
	}
	/**********************************************************************************************
	* Description		: this function to check data update, if nothing to update, then no audit
	* 					  
	* input				: 
	* author			: Nabihah
	* Date				: 02 April 2014
	* Modification Log	: -
	**********************************************************************************************/
	public function check_data($table='', $values=array(), $where=array(), $orderby=array(), $limit=FALSE, $like=array())
	{
		
		
		
		foreach($where as $key => $value)
		{
			print_r($key);
			print_r($value);
		}
			if(isset($table))
		{
				$tod = $this -> _cd -> db;
				$tod->select('*');
				$tod->from($table);
				
				$query = $tod->get();
				
				if($query->num_rows() > 0)
				{
					
					$row = $query->result();
				}
				
				print_r($row);
		
			
		}
		
			
		
		
	}
	
    }
?>