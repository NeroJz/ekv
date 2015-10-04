<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**************************************************************************************************
* File Name        : m_module_course_reg.php
* Description      : This File contain function to register module course by AdminLP
* Author           : Freddy Ajang Tony
* Date             : 16 december 2013
* Version          : -
* Modification Log : -
* Function List	   : -
**************************************************************************************************/

class M_module_course_reg extends CI_Model 
{

	/**********************************************************************************************
	* Description	 : this function to get list all course. 
	* input	 : -
	* author	 : Freddy Ajang Tony
	* Date	 : 16 december 2013
	* Modification Log	: -
	**********************************************************************************************/
	function get_course()
	{	
		$this->db->select('cou.*');
		$this->db->from('course cou');
		$query = $this -> db -> get();
		
		if ($query -> num_rows() > 0) {
			return $query -> result();
		}
	}


	/**********************************************************************************************
	* Description	 : this function to get list all vk module by course. 
	* input	 : -
	* author	 : Freddy Ajang Tony
	* Date	 : 16 december 2013
	* Modification Log	: -
	**********************************************************************************************/
	function get_module_vk($course_code,$semester)
	{	
		$this->db->select('m.mod_id,m.mod_paper,m.mod_name');
		$this->db->from('module m');
		$this->db->like('mod_code', $course_code);
		$this->db->like('mod_sem', $semester);
		$this->db->where('mod_type', 'VK');
		$this->db->where('stat_mod', 1);
		$query = $this -> db -> get();
		
		if ($query -> num_rows() > 0) {
			return $query -> result();
		}
	}


	/**********************************************************************************************
	* Description	 : this function to get list all ak module by course. 
	* input	 : -
	* author	 : Freddy Ajang Tony
	* Date	 : 16 december 2013
	* Modification Log	: -
	**********************************************************************************************/
	function get_module_ak($semester)
	{	
		$this->db->select('m.mod_id,m.mod_paper,m.mod_name');
		$this->db->from('module m');
		$this->db->like('mod_sem', $semester);
		$this->db->where('mod_type', 'AK');
		$this->db->where('stat_mod', 1);
		$query = $this -> db -> get();
		
		if ($query -> num_rows() > 0) {
			return $query -> result();
		}
	}


	/**********************************************************************************************
	* Description	 : this function to check availability of module in course.
	* input	 : -
	* author	 : Freddy Ajang Tony
	* Date	 : 16 december 2013
	* Modification Log	: -
	**********************************************************************************************/
	function check_module_availability_by_course($cou_id,$semester)
	{
		$this->db->select('cm.*');
		$this->db->from('course_module cm');
		$this->db->where('cm_semester', $semester);
		$this->db->where('cou_id', $cou_id);
		$query = $this -> db -> get();
		
		if ($query -> num_rows() > 0) {
			return 1;
		}
		else
		{
			return 0;
		}
	}


	/**********************************************************************************************
	* Description	 : this function to save course.
	* input	 : -
	* author	 : Freddy Ajang Tony
	* Date	 : 16 december 2013
	* Modification Log	: -
	**********************************************************************************************/
	function save_course($data)
	{
		if(isset($data))
		{
			$this->db->insert('college_course',$data);
			$check = $this->db->insert_id();
		
			return $check;
		}
		else
		{
			return 0;
		}
	}


	/**********************************************************************************************
	* Description	 : this function to save course.
	* input	 : -
	* author	 : Freddy Ajang Tony
	* Date	 : 16 december 2013
	* Modification Log	: -
	**********************************************************************************************/
	function save_module($data)
	{
		if(isset($data))
		{
			$this->db->insert_batch('course_module', $data);
		
			return 1;
		}
		else
		{
			return 0;
		}
	}


	/**********************************************************************************************
	* Description	 : this function to get list vk module other than course for searching.
	* input	 : -
	* author	 : Freddy Ajang Tony
	* Date	 : 16 december 2013
	* Modification Log	: -
	**********************************************************************************************/
	function get_module_list($course_code,$semester)
	{
		$this->db->select('m.mod_id,m.mod_paper,m.mod_name');
		$this->db->from('module m');
		$this->db->not_like('mod_code', $course_code);
		$this->db->like('mod_sem', $semester);
		$this->db->where('mod_type', 'VK');
		$this->db->where('stat_mod', 1);
		$query = $this -> db -> get();
		
		if ($query -> num_rows() > 0) 
		{
			return $query -> result();
		}
	}
	
	/**********************************************************************************************
	* Description	 : Get course module by course id and semester
	* input	 : -
	* author	 : Nabihah
	* Date	 : 28 02 2013
	* Modification Log	: -
	**********************************************************************************************/
	function get_cou_mod($cou_id, $sem)
	{
		$this->db->select('cm.cm_id, cm.mod_id');
		$this->db->from('course_module cm, module m');
		$this->db->where('cm.mod_id = m.mod_id');
		$this->db->where('cm.cm_semester', $sem);
		$this->db->where('cm.cou_id', $cou_id);
		$this->db->where('m.stat_mod', 1);
		$query = $this -> db -> get();
		
		if ($query -> num_rows() > 0) 
		{
			return $query -> result();
		}
	}

	/**********************************************************************************************
	* Description	 : Get course module by course id and semester
	* input	 : -
	* author	 : Nabihah
	* Date	 : 1 03 2013
	* Modification Log	: -
	**********************************************************************************************/
	function delete_module($cm_id)
	{
		$this->db->where('cm_id', $cm_id);
		return $this->db->delete('course_module'); 
	}
	
	
	/**********************************************************************************************
	* Description	 : this function to get module for course ak.
	* input	 : -
	* author	 : Freddy Ajang Tony
	* Date	 : 12 March 2014
	* Modification Log	: -
	**********************************************************************************************/
	function get_module_course($cou_id,$sem,$mod_type)
	{
		$this->db->select('cm.cm_id, m.mod_id,m.mod_paper,m.mod_name');
		$this->db->from('course_module cm, module m');
		$this->db->where('cm.mod_id = m.mod_id');
		$this->db->where('cm.cm_semester', $sem);
		$this->db->where('cm.cou_id', $cou_id);
		$this->db->where('m.stat_mod', 1);
		$this->db->where('m.mod_type', $mod_type);
		$this->db->order_by("m.mod_paper", "asc");
		$query = $this -> db -> get();
		
		if ($query -> num_rows() > 0) 
		{
			return $query -> result();
		}
	}
	

}// end of Class
/**************************************************************************************************
* End of m_module_course_reg.php
**************************************************************************************************/
?>