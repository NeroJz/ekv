<?php

/**************************************************************************************************
* File Name        : m_class.php
* Description      : This function is to determine the student class by course,semester,year
* Author           : Nabihah
* Date             : 25 November 2013
* Version          : 0.1
* Modification Log : -
* Function List	   : 
**************************************************************************************************/
class m_semester extends CI_Model {
	
	/**********************************************************************************************
	* Description		: this function to select student session 
	* input				: -
	* author			: NABIHAH ABKARIM
	* Date				: 25 NOVEMBER 2013
	* Modification Log	: -
	**********************************************************************************************/
	function get_session($sesi, $year)
	{
		$session=$sesi." ".$year;
		
		$col_id =0;
		$u_id =$this->session->userdata('user_id');
		
		
		if($u_id)
		{
			$this->db->select('u.col_id');
			$this->db->from('user u, user_group ug');
			$this->db->where('u.user_id', $u_id);
			$this->db->where('u.user_id = ug.user_id');
			$this->db->where('ug.ul_id', 8);
			$query = $this->db->get();
		
			if ($query->num_rows() > 0)
			{
				$temp_col = $query->row();
				$col_id = $temp_col->col_id;
			}
		}
		
		

		if($col_id != 0)
		{
			$this->db->select('s.stu_intake_session');
			$this->db->from('student s, college_course cc');
			$this->db->where('s.cc_id = cc.cc_id');
			
			
			$this->db->where('cc.col_id', $col_id);
			$this->db->where_not_in('s.stu_intake_session', $session);
		
			$this->db->group_by('s.stu_intake_session');
			$this->db->order_by('s.stu_intake_session');
		
			$query2 = $this->db->get();

			if ($query2->num_rows() > 0)
			{
				return $query2->result();
			}
		}
		
		
	}
	
	/**********************************************************************************************
	* Description		: this function to select student id based on session
	* input				: -
	* author			: NABIHAH ABKARIM
	* Date				: 27 NOVEMBER 2013
	* Modification Log	: -
	**********************************************************************************************/
	
	function get_student_id($session)
	{
		$this->db->select('stu_id, stu_religion, stu_current_sem, stu_intake_session, cc_id');
		$this->db->from('student');
		$this->db->where('stu_intake_session', $session);
		$query = $this->db->get();
		
		if($query->num_rows() >0)
		{
			return $query->result();
		}
		
	}
/**********************************************************************************************
	* Description		: this function to select module by cc_id and semester
	* input				: -
	* author			: NABIHAH ABKARIM
	* Date				: 27 NOVEMBER 2013
	* Modification Log	: -
	**********************************************************************************************/
	
	function get_module($cc_id, $sem)
	{
		$this->db->select('m.mod_id, cm.cou_id, cm.cm_semester, m.mod_name, m.mod_paper, m.mod_code');
		
		$this->db->from('college_course cc, course_module cm, module m');
		$this->db->where('cc.cou_id = cm.cou_id');
		$this->db->where('cm.mod_id = m.mod_id');
		$this->db->where('cm.cm_semester', $sem);
		$this->db->where('cc.cc_id', $cc_id);
		$query = $this->db->get();
		
		if($query->num_rows() >0)
		{
			return $query->result();
		}
		
	}

	/**********************************************************************************************
	* Description		: this function to update semester
	* input				: -
	* author			: NABIHAH ABKARIM
	* Date				: 27 NOVEMBER 2013
	* Modification Log	: -
	**********************************************************************************************/
	
	function update_sem_by_stu($data, $stu_id)
	{
		//$arr = array('stu_current_sem'=>8);
		$this->db->where('stu_id', $stu_id);
		$this->db->update('student', $data);
		return $this->db->affected_rows();
		
		//$this->db->affected_row
		
		
	}
	
	/**********************************************************************************************
	* Description		: this function to insert module
	* input				: -
	* author			: NABIHAH ABKARIM
	* Date				: 27 NOVEMBER 2013
	* Modification Log	: -
	**********************************************************************************************/
	
	function insert_module($module)
	{
		$this->db->insert('module_taken', $module);
		
	}
	
	/**********************************************************************************************
	* Description		: this function to insert status_semester if no data in course_module
	* input				: -
	* author			: NABIHAH ABKARIM
	* Date				: 28 NOVEMBER 2013
	* Modification Log	: -
	**********************************************************************************************/
	
	function insert_status_sem($stu_id, $sem, $sta)
	{
		$this->db->select('ss_id, ss_status');
		$this->db->from('status_semester');
		$this->db->where('ss_sem', $sem);
		$this->db->where('stu_id', $stu_id);
		$query = $this->db->get(); 
		
		if($query->num_rows() > 0)
		{
			$ss = $query->row();
			
		}
		
		if(!isset($ss))
		{
			$dataSem = array('stu_id'=>$stu_id,
								'ss_sem' =>$sem,
								'ss_status' => $sta);
								
			$this->db->insert('status_semester', $dataSem);
		}
		
		else
		{
			$this->db->where('ss_id', $ss->ss_id);
			$this->db->update('status_semester', array('ss_status' =>  $sta));
		}
	}
	
	//nabihah untuk insert module
	function get_sem_module($type)
	{
		$this->db->select('mod_paper, mod_id');
		$this->db->from('module');
		$this->db->where('mod_type' , $type);
		$query = $this->db->get();
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		
	}
	
	function ins_sem_mod($data, $id)
	{
		$this->db->where('mod_id', $id);
		$this->db->update('module', $data);
	
	}
	
	
	
}