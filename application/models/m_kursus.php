<?php
/**************************************************************************************************
* File Name        : m_kursus.php
* Description      : This File contain function for course
* Author           : Norafiq Bin Mohd Azman Chew
* Date             : 11 June 2013
* Version          : -
* Modification Log : -
* Function List	   : -
**************************************************************************************************/
class M_kursus extends CI_Model 
{
	/**********************************************************************************************
	* Description		: To list all course
	* input				: - 
	* author			: Norafiq Azman
	* Date				: 11 June 2013
	* Modification Log	: -
	**********************************************************************************************/
	function kursus_list()
	{
		$this->db->select('ks.*');
		$this->db->from('course ks');
		$this->db->order_by("ks.cou_code");
		$this->db->group_by("cou_code");

		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	/**********************************************************************************************
	* Description		: To list the course by selected
	* input				: $kursus_id 
	* author			: Norafiq Azman
	* Date				: 11 June 2013
	* Modification Log	: -
	**********************************************************************************************/
	function kursus_dipilih($kursus_id)
	{
		$this->db->select('ks.*');
		$this->db->from('course ks');
		$this->db->where('ks.cou_id',$kursus_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
	}

	/**********************************************************************************************
	* Description		: To list the course by lecturer login
	* input				: $userid
	* author			: Norafiq Azman
	* Date				: 11 June 2013
	* Modification Log	: umairah - where la_status
	**********************************************************************************************/	
	function login_course($userid, $year)
	{
		$userSesi = $this->session->userdata["sesi"];
		
		$this->db->select('distinct(cm.cou_id), c.cou_course_code, c.cou_name');
		$this->db->from('course c, lecturer_assign la, course_module cm, user u');
		$this->db->where('u.user_id', $userid);
		$this->db->where('u.user_id = la.user_id');
		$this->db->where('la.la_current_year', $year);
		$this->db->where('la.la_current_session', $userSesi);
		$this->db->where('cm.cm_id = la.cm_id');
		$this->db->where('cm.cou_id = c.cou_id');
		$this->db->where('la.la_status',1);

		$query = $this->db->get();		

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}

	/**********************************************************************************************
	* Description		: To list the course by lecturer login without distinct
	* input				: $userid
	* author			: Fakhruz
	* Date				: 11 April 2014
	* Modification Log	: umairah - where la_status
	**********************************************************************************************/	
	function login_courseByUsr($userid, $year)
	{
		$userSesi = $this->session->userdata["sesi"];

		$this->db->select('cm.cm_id, cm.cou_id, cm.cm_semester, c.cou_course_code, c.cou_name, m.mod_name, m.mod_id, m.mod_code, m.mod_type, cc.class_name, cc.class_id');
		$this->db->from('course c, lecturer_assign la, course_module cm, user u, module m, class cc');
		$this->db->where('u.user_id', $userid);
		$this->db->where('u.user_id = la.user_id');
		$this->db->where('la.la_current_year', $year);
		$this->db->where('la.la_current_session', $userSesi);
		$this->db->where('cm.cm_id = la.cm_id');
		$this->db->where('cm.cou_id = c.cou_id');
		$this->db->where('m.mod_id = cm.mod_id');
		$this->db->where('la.la_group = cc.class_id');
		$this->db->where('la.la_status',1);

		$query = $this->db->get();		

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	/**********************************************************************************************
	* Description		: To list the course by col_id for repeat paper
	* input				: $userid
	* author			: Norafiq Azman
	* Date				: 16 August 2013
	* Modification Log	: umairah - get cos by user login
	**********************************************************************************************/	
	function repeat_course($col_id,$user_id)
	{
		$this->db->select('c.cou_id,c.cou_name,c.cou_course_code, u.user_id,u.user_name');
        $this->db->from('lecturer_assign la');
        $this->db->join('user u', 'la.user_id = u.user_id', 'left');
        $this->db->join('course_module cm', 'cm.cm_id = la.cm_id', 'left');
        $this->db->join('course c', 'cm.cou_id = c.cou_id', 'left');       
        $this->db->where('u.col_id', $col_id);	
        $this->db->where('la.user_id', $user_id);
        $this->db->where('la.la_status', 2);
        
		$this->db->order_by("cm.cm_id", "DESC");
		$this->db->group_by("u.user_id");
		$query = $this->db->get();		

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
}// end of Class
/**************************************************************************************************
* End of m_kursus.php
**************************************************************************************************/

?>