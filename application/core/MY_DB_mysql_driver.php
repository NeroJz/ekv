<?php
/**************************************************************************************************
* File Name        : audit.php
* Description      : This File contain my sql driver.
* 					 Extend the CI_DB_mysql_driver here
* Author           : Nabihah Abkarim
* Date             : 2 April 2014
* Version          : -
* Modification Log : -
* Function List	   :
**************************************************************************************************/
class MY_DB_mysql_driver extends CI_DB_mysql_driver
{
	
	const INSERT = 'insert';
    const UPDATE = 'update';
    const DELETE = 'delete';
	
	  public function __construct($params)
    {
        parent::__construct($params);
		$this->_au =& get_instance();
		//echo 
		log_message('debug', 'Extended DB driver class do not work');
		$this-> _au->load -> library('audit');
		
    }
	
	/**********************************************************************************************
	* Description		: this function to xecute this child before go the parent (insert)
	* 					  
	* input				: 
	* author			: Nabihah
	* Date				: 02 April 2014
	* Modification Log	: -
	**********************************************************************************************/
	public function _insert($table, $keys, $values)
	{
		
		$sql = parent::_insert($table, $keys, $values);
		
		// Push variables
        $ar_set = $this->ar_set;
        $this->ar_set = array();
		//echo self::INSERT;	
		$this->_create_audit($table, $sql, self::INSERT);
		
		// Pop variables to execute insert
        $this->ar_set = $ar_set;
		
		return $sql;
	}
	/**********************************************************************************************
	* Description		: this function to xecute this child before go the parent (insert_batch)
	* 					  
	* input				: 
	* author			: Nabihah
	* Date				: 02 April 2014
	* Modification Log	: -
	**********************************************************************************************/
	function _insert_batch($table, $keys, $values)
    {
    		$sql = parent::_insert_batch($table, $keys, $values);
			// Push variables
        	$ar_set = $this->ar_set;
        	$this->ar_set = array();
		//echo self::INSERT;	
			$this->_create_audit($table, $sql, self::INSERT);
		//echo $sql;
		// Pop variables to execute insert
        	$this->ar_set = $ar_set;
		//print_r($this->ar_set);
		//die();
		return $sql;
                //return "INSERT INTO ".$table." (".implode(', ', $keys).") VALUES ".implode(', ', $values);
    }
	
/**********************************************************************************************
	* Description		: this function to xecute this child before go the parent (update)
	* 					  
	* input				: 
	* author			: Nabihah
	* Date				: 02 April 2014
	* Modification Log	: -
	**********************************************************************************************/	
	public function _update($table, $values, $where=array(), $orderby = array(), $limit = FALSE, $like = array())
	{
		
		$sql =  parent::_update($table, $values, $where, $orderby, $limit, $like);
		$sta = parent::affected_rows();
		
		//$this->_check_data($table, $values, $where, $orderby, $limit, $like);
		// Push variables
        $ar_set = $this->ar_set;
        $this->ar_set = array();
		if(1 == $sta)
		{
			$this->_create_audit($table, $sql, self::UPDATE);
		}
		
		// Pop variables
        $this->ar_set = $ar_set;
		
		return $sql;
	}
/**********************************************************************************************
	* Description		: this function to xecute this child before go the parent (update)
	* 					  
	* input				: 
	* author			: Nabihah
	* Date				: 02 April 2014
	* Modification Log	: -
	**********************************************************************************************/	
	public function _delete($table, $where = array(), $like = array(), $limit = FALSE)
	{
		
	   	$sql =  parent::_delete($table, $where, $like, $limit);
		
		  // Push variables
      	$ar_where = $this->ar_where;
       	$ar_like = $this->ar_like;
		
		$this->_create_audit($table, $sql, self::DELETE);
		//$this->query($sql);
		    // Pop variables
        $this->ar_where = $ar_where;
        $this->ar_like = $ar_like;
		
		return $sql;
	}
	
	/**********************************************************************************************
	* Description		: this function to create sql of audit to save in audit_trail table
	* 					  
	* input				: 
	* author			: Nabihah
	* Date				: 02 April 2014
	* Modification Log	: -
	**********************************************************************************************/
	 public function _create_audit($table, $sql, $type)
    {
    	
        // Send this to the library (AUDIT)
        //to record in table audit
       // echo "masuk func";
        $this->_au->audit->record($table, $sql, $type);
        
    }
	
	/**********************************************************************************************
	* Description		: this function to execute the created sql by function _create_audit
	* 					  
	* input				: 
	* author			: Nabihah
	* Date				: 02 April 2014
	* Modification Log	: -
	**********************************************************************************************/
	public function insert_audit($table='', $record=NULL)
	{
		
		$this->_reset_write();
		
		if ( ! is_null($record))
		{
			$this->set($record);
		}
		//print_r(array_keys($this->ar_set));
		
 
		if (count($this->ar_set) == 0)
		{
			if ($this->db_debug)
			{
				return $this->display_error('db_must_use_set');
			}
			return FALSE;
		}
 
		if ($table == '')
		{
			if ( ! isset($this->ar_from[0]))
			{
				if ($this->db_debug)
				{
					return $this->display_error('db_must_set_table');
				}
				
				return FALSE;
			}
 
			$table = $this->ar_from[0];
		}
		 //execute parent sql
		$sql = parent::_insert($table, array_keys($this->ar_set), array_values($this->ar_set));
 		
		$this->_reset_write();
	
		return $this->query($sql);
	}
	
	
	
	
}
	