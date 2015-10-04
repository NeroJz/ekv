<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**************************************************************************************************
* File Name        : m_general.php
* Description      : This File contain model for general.
* Author           : Fakhruz
* Date             : 29 June 2013
* Version          : 0.1
* Modification Log : 
* Function List	   : 
**************************************************************************************************/
class M_general extends CI_Model 
{
	function kursus_list($cou_id = null)
	{
		$this->db->select('cou.*');
		$this->db->from('course cou');
		$this->db->order_by("cou.cou_course_code");
		
		if(!empty($cou_id))
		{
			$this->db->where("cou_id", $cou_id);
		}
		
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	function state_list($state_id = null)
	{
		$this->db->select('sta.*');
		$this->db->from('state sta');
		$this->db->order_by("sta.state_id");
		
		if(!empty($state_id))
		{
			$this->db->where("state_id", $state_id);
		}
		
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	function kv_list($col_id="")
	{
		$this->db->select('*');
		$this->db->from('college');
		$this->db->order_by("col_name");
		
		if(!empty($col_id))
		 $this->db->where("col_id",$col_id);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	function kursus_list_by_kv($col_id)
	{
		$this->db->select('cou.*, college_course.cc_id');
		$this->db->from('course cou');
		$this->db->join('college_course', 'college_course.cou_id = cou.cou_id');
		$this->db->order_by("cou.cou_code");
		
		if(!empty($col_id))
		{
			$this->db->where("college_course.col_id", $col_id);
		}
		
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	
	//get class from kv under the course// umairah - update 24/1/14
	function get_class($col_id,$cc_id)
	{		
		$this->db->select('c.*');		 
		$this->db->from('class c, college_course cc');		
		$this->db->where('cc.cc_id = c.cc_id');
		$this->db->where('c.cc_id', $cc_id);
		$this->db->where('cc.col_id', $col_id);
		$this->db->where('c.class_sem', 1);
		$this->db->where('c.class_status', 1);
		//$this->db->group_by('c.class_id');
		
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	
	//get cc_id // umairah - update 24/1/14
	function get_cc_id($course_id="")
	{
		$this->db->select('u.col_id');
		$this->db->from('user u');
		$this->db->where('u.user_id', $this->session->userdata('user_id'));
		 
		$query = $this->db->get();
		 
		if ($query -> num_rows() > 0)
		{
			$college_id = $query->row();
		}
		$this->db->select('cc.cc_id');
		$this->db->from('college_course cc');
		$this->db->where('cc.cou_id', $course_id);
		//$this->db->where('cc.col_id', $col_id);
		$this->db->where('cc.col_id', $college_id->col_id);
		 
		$query = $this->db->get();
		 
		if ($query -> num_rows() > 0)
		{
			$cc_id = $query->row();
			return $cc_id->cc_id;
		}
	
	}
	
	
	function getNextMatricNo($prefixMatricNo){
		$prefixMatricNoLength = $this->config->item("prefixMatricNoLength");
		$MatricNoSeriesLength = $this->config->item("MatricNoSeriesLength");
		
		$this->db->select("SUBSTRING(stu_matric_no,".($prefixMatricNoLength+1).",".$MatricNoSeriesLength.") AS curMatricNo",FALSE);
		$this->db->where("stat_id", 1);
		$this->db->like('stu_matric_no', $prefixMatricNo, 'after');
		
		// set this to false so that _protect_identifiers skips escaping:
		$this->db->_protect_identifiers = FALSE;
		$this->db->order_by("CAST(SUBSTRING(stu_matric_no,".($prefixMatricNoLength+1).",".$MatricNoSeriesLength.") AS UNSIGNED)", "desc");
		
		$query = $this->db->get("student");
		
		 // important to set this back to TRUE or ALL of your queries from now on will be non-escaped:
		$this->db->_protect_identifiers = TRUE;
		
		if ($query->num_rows() > 0)
		{
			foreach ($query->result() as $key => $rw) {
				return $rw->curMatricNo;
			}
		}  
		
		return null;
		
	}
	
	public function get_course_list(){
		$this->db->select('cou_name');
		$query=$this->db->get('course');
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	/**
	* This function used to query all college that contain same state with user login
	* input: -
	* author: Mior Mohd Hanif
	* Date: 9 Julai 2013
	* Modification Log: 
	*/
	function kv_list_by_state($state_id)
	{
		$this->db->select('*');
		$this->db->from('college');
		$this->db->order_by("col_name");
		
		$this->db->where("state_id",$state_id);
		$this->db->where("col_type","K");
		
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	/**
	* This function used to get all college that col_type not equal to K
	* input: -
	* author: Mior Mohd Hanif
	* Date: 15 Julai 2013
	* Modification Log: 
	*/
	function kv_list_for_bptv()
	{
		$this->db->select('*');
		$this->db->from('college');
		$this->db->order_by("col_name");
		$this->db->where("col_type !=","K");
		
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	function get_stu_by_status($stat_id){
		$this->db->where('stat_id',$stat_id);
		return $query=$this->db->get('student');
	}
}
/**************************************************************************************************
* End of m_general.php
**************************************************************************************************/
?>