<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**************************************************************************************************
* File Name        : m_course_module_kupp.php
* Description      : This File contain function for course module for kupp
* Author           : Freddy Ajang Tony
* Date             : 10 december 2013
* Version          : -
* Modification Log : -
* Function List	   : -
**************************************************************************************************/

class M_module_taken extends CI_Model 
{
	
	/**********************************************************************************************
	* Description		: this function to get list all course. 
	* input				: -
	* author			: Nabihah Ab.KArim
	* Date				: 19 Mac 2014
	* Modification Log	: -
	**********************************************************************************************/
	function get_course($col_id="")
	{
		
		$this->db->select('c.*');
		$this->db->from('course c, college_course cc');
		$this->db->where('cc.cou_id = c.cou_id');
		$this->db->where('cc.col_id', $col_id);
		$query = $this -> db -> get();
		
		if ($query -> num_rows() > 0) 
		{
			return $query -> result();
		}
	}
	/**********************************************************************************************
	* Description		: this function to get list all course. 
	* input				: -
	* author			: Nabihah Ab.KArim
	* Date				: 24 Mac 2014
	* Modification Log	: -
	**********************************************************************************************/
	function get_student_detail($id="")
	{
		
		$this->db->select('s.*, c.cou_name, co.col_name');
		$this->db->from('student s, college_course cc, college co, course c');
		$this->db->where('s.stu_id', $id);
		$this->db->where('s.cc_id = cc.cc_id');
		$this->db->where('cc.col_id = co.col_id');
		$this->db->where('cc.cou_id = c.cou_id');
		$query = $this -> db -> get();
		
		if ($query -> num_rows() > 0) 
		{
			return $query -> row();
		}
	}
	
	/**********************************************************************************************
	* Description		: this function to get list all course. 
	* input				: -
	* author			: Nabihah Ab.KArim
	* Date				: 21 Mac 2014
	* Modification Log	: -
	**********************************************************************************************/
	function get_module_student($id="", $sem)
	{
		
		$this->db->select('mt.*, m.*');
		$this->db->from('module_taken mt, module m');
		$this->db->where('mt.stu_id', $id);
		$this->db->where('mt.mt_semester', $sem);
		$this->db->where('m.mod_id = mt.mod_id');
		$query = $this -> db -> get();
		
		if ($query -> num_rows() > 0) 
		{
			return $query -> result();
		}
	}
	
	/**********************************************************************************************
	* Description		: this function to get college_id. 
	* input				: -
	* author			: Nabihah Ab.KArim
	* Date				: 21 Mac 2014
	* Modification Log	: -
	**********************************************************************************************/
	function get_cou_id($id="")
	{
		
		$this->db->select('cc.cou_id');
		$this->db->from('college_course cc, student s');
		$this->db->where('s.cc_id = cc.cc_id');
		$this->db->where('s.stu_id', $id);
		$query = $this -> db -> get();
		
		if ($query -> num_rows() > 0) 
		{
			return $query -> row();
		}
	}
	
	/**********************************************************************************************
	* Description		: this function to get course module. 
	* input				: -
	* author			: Nabihah Ab.KArim
	* Date				: 21 Mac 2014
	* Modification Log	: -
	**********************************************************************************************/
	function get_course_module($cou_id="", $sem="")
	{
		
		$this->db->select('m.*');
		$this->db->from('course_module cm, module m');
	//	$this->db->join('module_taken mt', 'mt.mod_id = m.mod_id', 'right outer');
		$this->db->where('m.mod_id = cm.mod_id');
		$this->db->where('m.mod_id = cm.mod_id');
		$this->db->where('m.stat_mod', 1);
		$this->db->where('cm.cou_id', $cou_id);
		$this->db->where('cm.cm_semester', $sem);
		
		$query = $this -> db -> get();
		
		if ($query -> num_rows() > 0) 
		{
			return $query -> result();
		}
	}
	
	/**********************************************************************************************
	* Description		: this function to save module. 
	* input				: -
	* author			: Nabihah Ab.KArim
	* Date				: 25 Mac 2014
	* Modification Log	: -
	**********************************************************************************************/
	function insert_module($module)
	{
		
		$sta=$this->db->insert_batch('module_taken', $module); 
		return $sta;
	}
	
}	