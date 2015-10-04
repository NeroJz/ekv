<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**************************************************************************************************
* File Name        : m_course_module.php
* Description      : This File contain model for general.
* Author           : Ku Ahmad Mudrikah
* Date             : 21 October 2013
* Version          : 0.1
* Modification Log : 
* Function List	   : 
**************************************************************************************************/
class M_course_module extends CI_Model 
{
	function get_module_details($id){
		$this->db->select('*');
		$this->db->from('module');
		$this->db->where('mod_id',$id);
		return $this->db->get()->result();
	}
	
	function get_semester($cou_id,$mod_id){
		$this->db->select('*');
		$this->db->from('course_module');
		$this->db->where('cou_id',$cou_id);
		$this->db->where('mod_id',$mod_id);
		
		return $this_->db->get();
	}
	
	function get_course_details($mod_id){
		$this->db->select('*');
		$this->db->from('course_module');
		$this->db->join('course','course.cou_id = course_module.cou_id');
		$this->db->where('mod_id',$mod_id);
		return $this->db->get()->result();
	}
}
/**************************************************************************************************
* End of m_general.php
**************************************************************************************************/
?>