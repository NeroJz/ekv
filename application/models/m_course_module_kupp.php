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

class M_course_module_kupp extends CI_Model 
{
	
	/**********************************************************************************************
	* Description		: this function to get list all course. 
	* input				: -
	* author			: Freddy Ajang Tony
	* Date				: 10 december 2013
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
	* Description		: this function to get list all vk module by course. 
	* input				: -
	* author			: Freddy Ajang Tony
	* Date				: 10 december 2013
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
	* Description		: this function to get list all ak module by course. 
	* input				: -
	* author			: Freddy Ajang Tony
	* Date				: 10 december 2013
	* Modification Log	: -
	**********************************************************************************************/
	function get_module_ak($semester)
	{	
	 	$this->db->select('m.mod_id,m.mod_paper,m.mod_name');
		$this->db->from('module m');
		$this->db->like('mod_code', 'A');
		$this->db->like('mod_sem', $semester);
		$this->db->where('mod_type', 'AK');
		$this->db->where('stat_mod', 1);
		$query = $this -> db -> get();
		
		if ($query -> num_rows() > 0) {
			return $query -> result();
		}
	}
	
	
	/**********************************************************************************************
	* Description		: this function to check availability of course in the kv.
	* input				: -
	* author			: Freddy Ajang Tony
	* Date				: 11 december 2013
	* Modification Log	: -
	**********************************************************************************************/
	function check_course_availability($col_id,$cou_id)
	{
		$this->db->select('cc.*');
		$this->db->from('college_course cc');
		$this->db->where('col_id', $col_id);
		$this->db->where('cou_id', $cou_id);
		$this->db->where('cc_status', 1);
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
	* Description		: this function to check availability of module in course.
	* input				: -
	* author			: Freddy Ajang Tony
	* Date				: 11 december 2013
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
	* Description		: this function to save course.
	* input				: -
	* author			: Freddy Ajang Tony
	* Date				: 11 december 2013
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
	* Description		: this function to save course.
	* input				: -
	* author			: Freddy Ajang Tony
	* Date				: 11 december 2013
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
	* Description		: this function to get list vk module other than course for searching.
	* input				: -
	* author			: Freddy Ajang Tony
	* Date				: 12 december 2013
	* Modification Log	: -
	**********************************************************************************************/
	function get_module_list($course_code,$semester)
	{
		$this->db->select('m.mod_id,m.mod_paper,m.mod_name');
		$this->db->from('module m');
		$this->db->where_not_in('mod_code', $course_code);
		$this->db->like('mod_sem', $semester);
		$this->db->where('mod_type', 'VK');
		$this->db->where('stat_mod', 1);
		$query = $this -> db -> get();
	
		if ($query -> num_rows() > 0) {
			return $query -> result();
		}
	}
	
	
	/**********************************************************************************************
	* Description		: this function to get course by kv.
	* input				: -
	* author			: Freddy Ajang Tony
	* Date				: 16 december 2013
	* Modification Log	: -
	**********************************************************************************************/
	function get_course_by_kv($col_id)
	{
		$this->db->select('cc.cc_id,cc.cou_id,cou.cou_name,cou.cou_course_code,cou.cou_cluster');
		$this->db->from('college_course cc');
		$this->db->join('course cou','cou.cou_id = cc.cou_id','left');
		$this->db->where('col_id', $col_id);
		$this->db->where('cc_status', 1);
		$query = $this -> db -> get();
	
		if ($query -> num_rows() > 0) {
			return $query -> result();
		}
	}
	
	
	/**********************************************************************************************
	* Description		: this function to delete course.
	* input				: -
	* author			: Freddy Ajang Tony
	* Date				: 16 december 2013
	* Modification Log	: -
	**********************************************************************************************/
	function delete_course($cc_id)
	{
		if(isset($cc_id))
		{
			$data = array( 'cc_status'=> 0);
			
			$this->db->where('cc_id', $cc_id);
			$this->db->delete('college_course');
			//$this->db->update('college_course', $data);
	
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
	
	/**********************************************************************************************
	* Description		: this function to check student under the course.
	* input				: -
	* author			: Freddy Ajang Tony
	* Date				: 16 december 2013
	* Modification Log	: -
	**********************************************************************************************/
	function check_student_course($cc_id)
	{
		$this->db->select('s.stu_matric_no');
		$this->db->from('student s');
		$this->db->where('cc_id', $cc_id);
		$query = $this -> db -> get();
		
		if ($query -> num_rows() > 0) {
			return 1;
		}
		else
		{
			return 0;
		}
	}
	
}// end of Class
/**************************************************************************************************
* End of m_course_module_kupp.php
**************************************************************************************************/
?>
