<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**************************************************************************************************
* File Name        : m_assessment_status.php
* Description      : This File contain function for assessment configuration
* Author           : Freddy Ajang Tony
* Date             : 14 February 2014
* Version          : -
* Modification Log : -
* Function List	   : -
**************************************************************************************************/

class M_assessment_status extends CI_Model 
{
	/**********************************************************************************************
	* Description		: Get course list based on college id
	* input				: - 
	* author			: Freddy Ajang Tony
	* Date				: 15 February 2014
	* Modification Log	: -
	**********************************************************************************************/
	function course_list($col_id="")
	{
		$this->db->select('c.*');
		$this->db->from('course c, college_course cc, user u');
		$this->db->where("c.cou_id = cc.cou_id");
		$this->db->where("u.col_id = cc.col_id");
		
		$this->db->where('cc.col_id', $col_id);
		$this->db->where('cc.cc_status', 1);
		//$this->db->where('cc.col_id', 49);
		$this->db->order_by("c.cou_code ASC");
		$this->db->group_by("c.cou_code ASC");

		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	
	/**********************************************************************************************
	* Description		: Get kv
	* input				: - 
	* author			: Freddy Ajang Tony
	* Date				: 25 February 2014
	* Modification Log	: -
	**********************************************************************************************/
	function get_kv($col_type="",$col_code="",$cou_id="",$semester="")
	{
		$this->db->select('coll.col_id,coll.col_name');
		$this->db->from('college coll');
		
		if("" != $col_type)
		{
			$this->db->where('coll.col_type',$col_type);
		}
		
		if("" != $col_code)
		{
			$this->db->where('coll.col_code',$col_code);
		}
			
		$query = $this -> db -> get();
		
		if ($query -> num_rows() > 0) {
			
			$result = $query->result();
			
			foreach($result as $r)
			{
				if($r->col_id != null)
				{
					$r->course = $this->get_col_course($r->col_id,$cou_id,$semester);	
				}
			}
			
			return $result;
		}
	}
	
	
	/**********************************************************************************************
	* Description		: Get course
	* input				: - 
	* author			: Freddy Ajang Tony
	* Date				: 26 February 2014
	* Modification Log	: -
	**********************************************************************************************/
	function get_col_course($col_id="",$cou_id="",$semester="")
	{
		$this->db->select('cc.cou_id,c.cou_name');
		$this->db->from('college_course cc');
		$this->db->join('course c', 'cc.cou_id = c.cou_id', 'left');
		
		if("" != $col_id)
		{
			$this->db->where('cc.col_id',$col_id);
		}
		
		if("" != $cou_id)
		{
			$this->db->where('cc.cou_id',$cou_id);	
		}
		
		$this->db->where('cc.cc_status',1);
		
		$query = $this -> db -> get();
		
		if ($query -> num_rows() > 0) {
			
			$result = $query->result();
			
			foreach($result as $r)
			{
				if($r->cou_id != null)
				{
					$r->lecturer = $this->get_lecturer($col_id,$r -> cou_id,$semester);	
				}
			}
			
			return $result;
		}
	}
	
	
	/**********************************************************************************************
	* Description		: Get course list based on college id
	* input				: - 
	* author			: Freddy Ajang Tony
	* Date				: 15 February 2014
	* Modification Log	: Nabihah(17042014)
	**********************************************************************************************/
	function get_lecturer($col_id,$cou_id="",$semester="")
	{
		$this->db->select('u.user_id,u.user_name');
        $this->db->from('lecturer_assign la');
        $this->db->join('user u', 'la.user_id = u.user_id', 'left');
        $this->db->join('course_module cm', 'cm.cm_id = la.cm_id', 'left');
        $this->db->join('course c', 'cm.cou_id = c.cou_id', 'left');       
        $this->db->where('u.col_id', $col_id);
		
		if("" != $cou_id)
		{
			$this->db->where('c.cou_id', $cou_id);
		}
		if("" != $semester)
		{
			$this->db->where('cm.cm_semester', $semester);		
		}
		$this->db->order_by("cm.cm_id", "DESC");
        //$this->db->group_by("la.la_id");
		$this->db->group_by("u.user_id");

		$query = $this->db->get();
		
		

		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			
			foreach($result as $r)
			{
				
				if($r->user_id != null)
				{
					$r->module = $this->get_modules($r->user_id,$cou_id,$semester,$col_id);	
				}
			}
			
			return $result;
		}
	}


	/**********************************************************************************************
	* Description		: Get module for each lecturer
	* input				: - 
	* author			: Freddy Ajang Tony
	* Date				: 15 February 2014
	* Modification Log	: Nabihah-ubah semua jadi if
	**********************************************************************************************/
	function get_modules($user_id,$cou_id="",$semester="",$col_id="")
	{
		$this->db->select('la.la_id,la.la_group,cm.cm_id,cm.cou_id,cm.mod_id,c.cou_course_code,c.cou_name,
							cm.cm_semester,m.mod_paper,m.mod_name,m.mod_type');
        $this->db->from('lecturer_assign la');
        $this->db->join('user u', 'la.user_id = u.user_id', 'left');
        $this->db->join('course_module cm', 'cm.cm_id = la.cm_id', 'left');
        $this->db->join('course c', 'cm.cou_id = c.cou_id', 'left');
        $this->db->join('module m', 'cm.mod_id = m.mod_id', 'left');        
        $this->db->where('u.col_id', $col_id);
		$this->db->where('u.user_id', $user_id);
		
		if("" != $cou_id)
		{
			$this->db->where('c.cou_id', $cou_id);
		}
		if("" != $semester)
		{
			$this->db->where('cm.cm_semester', $semester);		
		}
		if("" != $user_id)
		{
			$this->db->where('u.user_id', $user_id);
		}
		
		
		$this->db->order_by("cm.cm_id", "DESC");
        $this->db->group_by("la.la_id");
		//$this->db->group_by("u.user_id");

		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			
			foreach($result as $r)
			{
				$pentaksiran = array('P','S');
				
				//foreach($pentaksiran as $p)
				//{
					if($r->la_group != null)
					{
						$r->data_configuration_P = $this->get_module_configuration("P",$r->cm_id,$r->mod_type,$user_id);
						$r->data_configuration_S = $this->get_module_configuration("S",$r->cm_id,$r->mod_type,$user_id);
						$r->student = $this->get_students($r->la_group,$r->cm_id,$r->la_id,$r->mod_type,$user_id);
						
						if($r->student != null)
						{
							foreach($r->student as $s)
							{
								$aMarkah_P = array();
								$aMarkah_S = array();
								
								if($r->data_configuration_P != null)
								{
									foreach($r->data_configuration_P as $dc_p)
									{
										if($s->stu_id != null)
										{
											//$r->markah = $this->get_students_marks($cm_id,$mod_type);
											$m = $this->get_students_marks($s->stu_id, $dc_p->assgmnt_id, 
												$dc_p->assgmnt_score_selection, $dc_p->assgmnt_mark);
											
											array_push($aMarkah_P, $m);	
										}
										
										$s->markah_p = $aMarkah_P;
									}
								}
								else {
									$s->markah_p = null;
								}
								
								if($r->data_configuration_S != null)
								{
									foreach($r->data_configuration_S as $dc_s)
									{
										if($s->stu_id != null)
										{
											//$r->markah = $this->get_students_marks($cm_id,$mod_type);
											$m = $this->get_students_marks($s->stu_id, $dc_s->assgmnt_id, 
												$dc_s->assgmnt_score_selection, $dc_s->assgmnt_mark);
											
											array_push($aMarkah_S, $m);	
										}
										
										$s->markah_s = $aMarkah_S;
									}
								}
								else {
									$s->markah_s = null;
								}
								
							}
						}	
					}
				//}
			}
			return $result;	
		}
	}


	/**********************************************************************************************
	* Description		: Get student list
	* input				: - 
	* author			: Freddy Ajang Tony
	* Date				: 16 February 2014
	* Modification Log	: -
	**********************************************************************************************/
	function get_students($la_group,$cm_id,$la_id,$mod_type,$user_id)
	{
		$this->db->select('s.stu_id,s.stu_name,s.stu_matric_no,s.stu_group');
		$this->db->from('student s');
		$this->db->join('lecturer_assign la', 'la.la_group = s.stu_group', 'left');
		$this->db->join('course_module cm', 'cm.cm_id = la.cm_id', 'left');
		$this->db->where('la.la_group', $la_group);
		$this->db->where('la.cm_id', $cm_id);
		$this->db->where('la.la_id', $la_id);
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			
			return $result;
		}
			
	}
	
	
	/**********************************************************************************************
	* Description		: Get module configuration
	* input				: - 
	* author			: Freddy Ajang Tony
	* Date				: 17 February 2014
	* Modification Log	: -
	**********************************************************************************************/
	function get_module_configuration($pentaksiran,$cm_id,$mod_type,$user_id)
	{
		$user = $this->ion_auth->user()->row();
		//$userid = $user->id;
		
		$userSesi = $this->session->userdata["sesi"];
		$userYear = $this->session->userdata["tahun"];
		
		if("VK" == $mod_type)
		{
			$this->db->select('lmc.*, pt.*');
			$this->db->from('lecturer_module_configuration lmc, lecturer_assign la, module_pt pt');
			$this->db->where('la.cm_id', $cm_id);
			$this->db->where('la.user_id', $user_id);
			$this->db->where('la.la_current_year', $userYear);
			$this->db->where('la.la_current_session', $userSesi);
			$this->db->where('la.la_id = lmc.la_id');
			$this->db->where('lmc.pt_id = pt.pt_id');
			$this->db->where('pt.pt_category', $pentaksiran);
	
			$query = $this->db->get();
			
			if ($query->num_rows() > 0)
			{
				$result = $query->result();
												
				foreach($result as $r)
				{
					$assgnmnt_name = $r->assgmnt_name;
					
					if($assgnmnt_name == "Teori")
					{
						$assgnmnt_id = $r->assgmnt_id;
					
						//$r->sub_theory = $this->get_sub_theory($assgnmnt_id);
					}
					
				}
				
	        	return $result;
			}
		}
		else if("AK" == $mod_type)
		{
			$this->db->select('lmc.*, ppr.*');
			$this->db->from('lecturer_module_configuration lmc, lecturer_assign la, module_ppr ppr');
			$this->db->where('la.cm_id', $cm_id);
			$this->db->where('la.user_id', $user_id);
			$this->db->where('la.la_current_year', $userYear);
			$this->db->where('la.la_current_session', $userSesi);
			$this->db->where('la.la_id = lmc.la_id');
			$this->db->where('lmc.ppr_id = ppr.ppr_id');
			$this->db->where('ppr.ppr_category', $pentaksiran);
	
			$query = $this->db->get();
			
			if ($query->num_rows() > 0)
			{
				return $query->result();
			}
		}
	}
	
	
	/**********************************************************************************************
	* Description		: Get student mark
	* input				: - 
	* author			: Freddy Ajang Tony
	* Date				: 17 February 2014
	* Modification Log	: -
	**********************************************************************************************/
	function get_students_marks($stu_id, $assgnmt_id, $assgmnt_selection, $totalMark)
	{
		/*
		* select sum(mark)/2*40/100 from (
		SELECT mark FROM lecturer_module_mark where assgmnt_id=4 and stu_id=17 order by mark desc limit 0, 2 ) T*/
		
		$query = "IFNULL(sum(CASE  WHEN mark > 0 THEN mark else 0 END )/$assgmnt_selection*$totalMark/100, '') as mark,
				  IFNULL(sum(mark)/$assgmnt_selection , 0) as average from (
				  SELECT mark FROM lecturer_module_mark
				  where assgmnt_id = $assgnmt_id
				  and stu_id = $stu_id
				  order by mark desc limit 0, $assgmnt_selection ) T";
		
		$this->db->select($query, false);
		
		$query2 = $this->db->get();
		
		if ($query2->num_rows() > 0)
		{
			//kalu average dapat -99.99 means semua tugasan TH
			if(isset($query2->row()->average) && $query2->row()->average == -99.99)
				return "T";
			
			else
			{
				if (is_numeric($query2->row()->mark))
					return number_format($query2->row()->mark, 2);
				
				else
					return $query2->row()->mark;
			}
		}
		else
		{
			return "";
		}
	}
	
	
	/**********************************************************************************************
	 * Description		: this function to get college
	 * input			: $centrecode
	 * author			: Freddy Ajang Tony
	 * Date				: 24 February 2014
	 * Modification Log	: -
	 **********************************************************************************************/
	function get_college($state="") {

		$this -> db -> select('c.*');
		$this -> db -> from('college c');
		
        if (!empty($state)) {
			$this -> db -> where('c.state_id', $state);
		}
		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			$data = $query -> result();
			$collge = '';
			foreach ($data as $row) {
				$collge .= '"';
				$collge .= $row -> col_name." - ".$row->col_type.$row->col_code;

				$collge .= '",';
			}
			return $collge;
		}
	}
	
	
	 /**********************************************************************************************
	 * Description		: this function to get list course by kv type and code
	 * input			: $course_type,$course_code
	 * author			: Freddy Ajang Tony
	 * Date				: 25 February 2014
	 * Modification Log	: -
	 **********************************************************************************************/
	 function get_course($course_type,$course_code)
	 {
	 	/*SELECT cou.* FROM (`college` coll)
		LEFT JOIN `college_course` ccou ON `ccou`.`col_id` = `coll`.`col_id`
		LEFT JOIN `course` cou ON `cou`.`cou_id` = `ccou`.`cou_id`
		WHERE `coll`.`col_type` = 'K' AND `coll`.`col_code` = '36'*/
		
	 	$this->db->select('cou.*');
		$this->db->from('college coll');
		$this->db->join('college_course ccou','ccou.col_id = coll.col_id','left');
		$this->db->join('course cou','cou.cou_id = ccou.cou_id','left');
		$this->db->where('coll.col_type',$course_type);
		$this->db->where('coll.col_code',$course_code);	
		$query = $this -> db -> get();
		
		if ($query -> num_rows() > 0) {
			return $query -> result();
		}
	 }
	 
	 
	 /**********************************************************************************************
	 * Description		: this function to get college id by kv type and code
	 * input			: $col_type,$col_code
	 * author			: Freddy Ajang Tony
	 * Date				: 25 February 2014
	 * Modification Log	: -
	 **********************************************************************************************/
	 function get_col_id($col_type,$col_code)
	 {
	 	$this->db->select('coll.col_id');
		$this->db->from('college coll');
		$this->db->where('coll.col_type',$col_type);
		$this->db->where('coll.col_code',$col_code);	
		$query = $this -> db -> get();
		
		if ($query -> num_rows() > 0) {
			return $query -> row_array();
		}
	 }
	
}// end of Class
/**************************************************************************************************
* End of m_assessment_status.php
**************************************************************************************************/
?>
	