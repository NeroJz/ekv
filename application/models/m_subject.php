<?php

/**************************************************************************************************
* File Name        : m_subject.php
* Description      : This File contain Examination module.
* Author           : Norafiq Bin Mohd Azman Chew
* Date             : 10 June 2013 = 1 Syaban
* Version          : -
* Modification Log : -
* Function List	   : __construct(), subject_by_spid, save_configur_subject, subject_configuratian
* 					 get_laID, subject_configuratian_assgmnt, check_configur_subject, 
* 					 update_configur_subject, get_max_assignmt_number, update_assigmnt_mark
* 					 deleteAssigment, getStudentMarkForAssignment, getStudentMarkForAssignmentMark
* 					 save_marks, isMarkingOpen, get_all_paper, get_mod_ids, getModuleMark
**************************************************************************************************/

class M_subject extends CI_Model
{
	/**********************************************************************************************
	* Description		: this function to select lecturer subjek
	* input				: $courselect, $cmID
	* author			: Norafiq Azman
	* Date				: 10 June 2013
	* Modification Log	: -
	**********************************************************************************************/
	function subject_by_spid($courselect, $semester)
	{		
		$user = $this->ion_auth->user()->row();
		$userid = $user->id;
		
		$userSesi = $this->session->userdata["sesi"];
		$userYear = $this->session->userdata["tahun"];
		
		$this->db->select('distinct(cm.cm_id), m.*');
		$this->db->from('module m, course_module cm, lecturer_assign la');
		$this->db->where('la.user_id', $userid);
		$this->db->where('la.la_current_year', $userYear);
		$this->db->where('la.la_current_session', $userSesi);
		$this->db->where('cm.cou_id', $courselect);
		$this->db->where('cm.cm_semester', $semester);
		$this->db->where('cm.cm_id = la.cm_id');
		$this->db->where('m.mod_id = cm.mod_id');
		$this->db->order_by("m.mod_code", "asc"); 

		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else 
		{
			//echo "empty";
			//echo $userid;
			//echo $courselect;
		}			
	}
	
	
	
	
	/**********************************************************************************************
	 * Description		: this function is to select modul yang diajaq oleh lecture tersebut
	* input				: $courselect, $semester
	* author			: siti umairah
	* Date				: 1 februari 2014
	* Modification Log	: -
	**********************************************************************************************/
	function subject_by_spid_get_category($courselect, $semester)
	{
		$user = $this->ion_auth->user()->row();
		$userid = $user->id;
	
		$userSesi = $this->session->userdata["sesi"];
		$userYear = $this->session->userdata["tahun"];
	
		$this->db->select('distinct(cm.cm_id), m.*');
		$this->db->from('module m, course_module cm, lecturer_assign la, module_ppr mppr');
		$this->db->where('la.user_id', $userid);
		$this->db->where('la.la_current_year', $userYear);
		$this->db->where('la.la_current_session', $userSesi);
		$this->db->where('cm.cou_id', $courselect);
		$this->db->where('cm.cm_semester', $semester);
		$this->db->where('cm.cm_id = la.cm_id');
		$this->db->where('m.mod_id = cm.mod_id');
		//$this->db->where('m.mod_id = mppr.mod_id');
	//	$this->db->where('mppr.ppr_category', "S");
		$this->db->order_by("m.mod_code", "asc");
	
		$query = $this->db->get();
	
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		else
		{
			echo "empty";
			echo $userid;
			echo $courselect;
		}
	}
	
	
	//sambung sini
	/**********************************************************************************************
	 * Description		: this function is to get class dalam course, modul,semester tu
	* input				: courseid,semester,cmid
	* author			: siti umairah
	* Date				: 11 march 2014
	* Modification Log	: -
	**********************************************************************************************/
	function get_classes($courselect, $semester, $cm_id_modul)
	{
		$user = $this->ion_auth->user()->row();
		$userid = $user->id;
	
		$userSesi = $this->session->userdata["sesi"];
		$userYear = $this->session->userdata["tahun"];
	
		$this->db->select('c.class_name, c.class_id, c.class_name');
		$this->db->from('class c, lecturer_assign la, course_module cm');
		$this->db->where('cm.cm_id = la.cm_id');
		$this->db->where('la.la_group = c.class_id');
		$this->db->where('la.user_id', $userid);
		$this->db->where('la.la_current_year', $userYear);
		$this->db->where('la.la_current_session', $userSesi);
		$this->db->where('cm.cou_id', $courselect);
		$this->db->where('cm.cm_semester', $semester);
		$this->db->where('la.cm_id', $cm_id_modul);
		//$this->db->where('cm.cm_id = la.cm_id');
		//$this->db->where('m.mod_id = cm.mod_id');
		//$this->db->where('la.la_group = c.class_id');
	
		//$this->db->where('m.mod_id = mppr.mod_id');
		//	$this->db->where('mppr.ppr_category', "S");
		//	$this->db->order_by("m.mod_code", "asc");
	
		$query = $this->db->get();
	
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		 
	}
	
	
	/**********************************************************************************************
	 * Description		: this function is to get class dalam course, modul,semester tu untuk akhir
	* input				: courseid,semester,cmid
	* author			: siti umairah
	* Date				: 11 march 2014
	* Modification Log	: -
	**********************************************************************************************/
	function get_classes_akhir($courselect, $semester, $cm_id_modul)
	{
		$user = $this->ion_auth->user()->row();
		$userid = $user->id;
		 
		$userSesi = $this->session->userdata["sesi"];
		$userYear = $this->session->userdata["tahun"];
		 
		$this->db->select('c.class_name, c.class_id, c.class_name');
		$this->db->from('class c, lecturer_assign la, course_module cm');
		$this->db->where('cm.cm_id = la.cm_id');
		$this->db->where('la.la_group = c.class_id');
		$this->db->where('la.user_id', $userid);
		$this->db->where('la.la_current_year', $userYear);
		$this->db->where('la.la_current_session', $userSesi);
		$this->db->where('cm.cou_id', $courselect);
		$this->db->where('cm.cm_semester', $semester);
		$this->db->where('la.cm_id', $cm_id_modul);
		//$this->db->where('cm.cm_id = la.cm_id');
		//$this->db->where('m.mod_id = cm.mod_id');
		//$this->db->where('la.la_group = c.class_id');
		 
		//$this->db->where('m.mod_id = mppr.mod_id');
		//	$this->db->where('mppr.ppr_category', "S");
		//	$this->db->order_by("m.mod_code", "asc");
		 
		$query = $this->db->get();
		 
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
			
	}
	
	
	/**********************************************************************************************
	* Description		: this function save the configuration detail into 
	* 					  subjek_staff_konfigur table
	* input				: $data, $tempKat
	* author			: Norafiq Azman
	* Date				: 13 June 2013
	* Modification Log	: -
	**********************************************************************************************/
	function save_configur_subject($data)
	{
		$this->db->insert('lecturer_module_configuration', $data);
		$assgmnt_id = $this->db->insert_id();
		
		return $assgmnt_id; 		
	}

	/**********************************************************************************************
	* Description		: this function get subject weightage category in sekolah or pusat
	* input				: $pentaksiran, $cm_id
	* author			: Norafiq Azman
	* Date				: 14 June 2013
	* Modification Log	: -
	**********************************************************************************************/
	function subject_weightage($pentaksiran, $cm_id)
	{
		$this->db->select('pt.*, m.*, cm.*');
		$this->db->from('module_pt pt, module m, course_module cm');
		$this->db->where('cm.cm_id', $cm_id);
		$this->db->where('cm.mod_id = m.mod_id');
		$this->db->where('m.mod_id = pt.mod_id');
		$this->db->where('pt.pt_category', $pentaksiran);

		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
	}

	
	/**********************************************************************************************
	* Description		: this function get class name
	* input				: 
	* author			: umairah
	* Date				: 27 March 2014
	* Modification Log	: -
	**********************************************************************************************/
	function ambik_nama_kelas($kelas)
	{
	
		$this->db->select('c.class_name, c.class_id');
		$this->db->from('class c');
		$this->db->where('c.class_id', $kelas);
	
		$query = $this->db->get();
	
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
	}
	
	
	/**********************************************************************************************
	* Description		: this function get kursus name
	* input				: 
	* author			: umairah
	* Date				: 27 March 2014
	* Modification Log	: -
	**********************************************************************************************/
	function ambik_nama_kursus($courselect)
	{
		$this->db->select('c.cou_name, c.cou_id');
		$this->db->from('course c');
		$this->db->where('c.cou_id', $courselect);
	
		$query = $this->db->get();
	
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
	
	
	}
	
	
	/**********************************************************************************************
	* Description		: this function get module name
	* input				: 
	* author			: umairah
	* Date				: 27 March 2014
	* Modification Log	: -
	**********************************************************************************************/
	function ambik_nama_modul($mod_id)
	{
		$this->db->select('m.mod_name, m.mod_id');
		$this->db->from('module m');
		$this->db->where('m.mod_id', $mod_id);
	
		$query = $this->db->get();
	
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
	
	
	}
	
	/**********************************************************************************************
	* Description		: this function get subject configuration.
	* input				: $cm_id
	* author			: Norafiq Azman
	* Date				: 17 June 2013
	* Modification Log	: 27 January 2014 - Fred - Add query for sub_theory, umairah 24/3/2014- class
	**********************************************************************************************/	
	function subject_configuratian($pentaksiran, $cm_id, $type, $kelas="")
	{
		$user = $this->ion_auth->user()->row();
		$userid = $user->id;
		$idParent=0;
		
		$userSesi = $this->session->userdata["sesi"];
		$userYear = $this->session->userdata["tahun"];
		
		if("VK" == $type)
		{
			//$idParent ="";
			$this->db->select('la.la_id_parent, la.la_id');
			$this->db->from('lecturer_assign la');
			$this->db->where('la.cm_id', $cm_id);
			$this->db->where('la.user_id', $userid);
			$this->db->where('la.la_current_year', $userYear);
			$this->db->where('la.la_current_session', $userSesi);
			
			if($kelas != "")
			{
				$this->db->where('la.la_group', $kelas);
			}
			
			$query = $this->db->get();
			
			if ($query->num_rows() > 0)
			{
				$id= $query->row();
			
			
			if($id->la_id_parent != NULL || $id->la_id_parent !=0)
			{
				$idParent = $id->la_id_parent;
			}
			else {
				$idParent = $id->la_id;
			}
			}
			
			$this->db->select('lmc.*, pt.*, la.user_id, la.la_id_parent');
			$this->db->from('lecturer_module_configuration lmc, lecturer_assign la, module_pt pt');
			$this->db->where('la.la_id', $idParent);
			$this->db->where('lmc.pt_id = pt.pt_id');
			$this->db->where('la.la_id = lmc.la_id');
			$this->db->where('pt.pt_category', $pentaksiran);
			
			/*
			$this->db->select('lmc.*, pt.*,la.user_id');
			$this->db->from('lecturer_module_configuration lmc, lecturer_assign la, module_pt pt');
			$this->db->where('la.cm_id', $cm_id);
			$this->db->where('la.user_id', $userid);
			$this->db->where('la.la_current_year', $userYear);
			$this->db->where('la.la_current_session', $userSesi);
			$this->db->where('la.la_id = lmc.la_id');
			$this->db->where('lmc.pt_id = pt.pt_id');
			$this->db->where('pt.pt_category', $pentaksiran);
			*/
	
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
					
						$r->sub_theory = $this->get_sub_theory($assgnmnt_id);
					}
					
				}
				
	        	return $result;
			}
		}
		else if("AK" == $type)
		{
			
			//$idParent =1;
			$this->db->select('la.la_id_parent, la.la_id');
			$this->db->from('lecturer_assign la');
			$this->db->where('la.cm_id', $cm_id);
			$this->db->where('la.user_id', $userid);
			$this->db->where('la.la_current_year', $userYear);
			$this->db->where('la.la_current_session', $userSesi);
			
			if($kelas != "")
			{
				$this->db->where('la.la_group', $kelas);
			}
				
			
			
			$query = $this->db->get();
			
			if ($query->num_rows() > 0)
			{
				$id= $query->row();
			
			
			if($id->la_id_parent != NULL || $id->la_id_parent !=0)
			{
				$idParent = $id->la_id_parent;
			}
			else {
				$idParent = $id->la_id;
			}
			}
			
			//echo $idParent;
			
			$this->db->select('lmc.*, ppr.*, la.user_id, la.la_id_parent');
			$this->db->from('lecturer_module_configuration lmc, lecturer_assign la, module_ppr ppr');
			$this->db->where('la.la_id', $idParent);
			$this->db->where('la.la_id = lmc.la_id');
			$this->db->where('lmc.ppr_id = ppr.ppr_id');
			$this->db->where('ppr.ppr_category', $pentaksiran);
			
		
			/*$this->db->select('lmc.*, ppr.*');
			$this->db->from('lecturer_module_configuration lmc, lecturer_assign la, module_ppr ppr');
			$this->db->where('la.cm_id', $cm_id);
			$this->db->where('la.user_id', $userid);
			$this->db->where('la.la_current_year', $userYear);
			$this->db->where('la.la_current_session', $userSesi);
			$this->db->where('la.la_id = lmc.la_id');
			$this->db->where('lmc.ppr_id = ppr.ppr_id');
			$this->db->where('ppr.ppr_category', $pentaksiran);
			
	*/
	//echo $idParent;
			$query = $this->db->get();
			
			if ($query->num_rows() > 0)
			{
				return $query->result();
			}
			
			
		}

		
	}

	
	/**********************************************************************************************
	* Description		: this function get lecturer ID
	* input				: $cm_id
	* author			: Norafiq Azman
	* Date				: 29 June 2013
	* Modification Log	: -
	**********************************************************************************************/	
	function get_laID($cm_id, $kelas)
	{
		$user = $this->ion_auth->user()->row();
		$userid = $user->id;
		
		$userSesi = $this->session->userdata["sesi"];
		$userYear = $this->session->userdata["tahun"];
		
		$this->db->select('MIN(la.la_id) as la_id');
		$this->db->from('lecturer_assign la');
		$this->db->where('la.cm_id', $cm_id);
		$this->db->where('la.user_id', $userid);
		$this->db->where('la.la_current_year', $userYear);
		$this->db->where('la.la_current_session', $userSesi);
		$this->db->where('la.la_group', $kelas);

		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
	}
	
	/**********************************************************************************************
	* Description		: this function get lecturer subjek configuration
	* input				: $assmnt_id
	* author			: Norafiq Azman
	* Date				: 30 June 2013
	* Modification Log	: -
	**********************************************************************************************/
	function subject_configuratian_assgmnt($assmnt_id)
	{
		$this->db->select('*');
		$this->db->from('lecturer_module_configuration');
		$this->db->where('assgmnt_id', $assmnt_id);

		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			$r = $query->row();
			
			$assgnmnt_name = $r->assgmnt_name;
			
			if($assgnmnt_name == "Teori")
			{
				$assgnmnt_id = $r->assgmnt_id;
			
				$r->sub_theory = $this->get_sub_theory($assgnmnt_id);
			}
					
			return $r;
		}
	}
	
	/**********************************************************************************************
	* Description		: this function to check if subject configure have id or not
	* input				: $tgsid, $tgsid1
	* author			: Norafiq Azman
	* Date				: 18 June 2013
	* Modification Log	: -
	**********************************************************************************************/
	function check_configur_subject($tgsid, $tgsid1)
	{
		if(0 == $tgsid1)
		{
			//select * from lecturer_module_configuration where assgmnt_id = 5
			$this->db->select('ssc.*');
			$this->db->from('lecturer_module_configuration ssc');
			$this->db->where('ssc.assgmnt_id', $tgsid);
		
		}
		else
		{
			$this->db->select('ssc.*');
			$this->db->from('lecturer_module_configuration ssc');
			$this->db->where('ssc.assgmnt_id', $tgsid);
			$this->db->or_where('ssc.assgmnt_id', $tgsid1);
		}
	
		$query = $this->db->get();
	
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}

	/**********************************************************************************************
	* Description		: this function to update subject configuration
	* input				: $dataconfigur, $temptgsid
	* author			: Norafiq Azman
	* Date				: 18 June 2013
	* Modification Log	: -
	**********************************************************************************************/
	function update_configur_subject($dataconfigur, $temptgsid)
	{
		$this->db->where('assgmnt_id', $temptgsid);
		$this->db->update('lecturer_module_configuration', $dataconfigur);
		
		$current_session = $this->session->userdata["sesi"];
		$curr_assgmnt = $dataconfigur['assgmnt_total'];
		
		//lepas update kene update lecturer_module_mark
		//delete from lecturer_module_mark where `assgmnt_id`=26 and `assignmt_number`>3
		$this->db->where('assgmnt_id', $temptgsid);
		$this->db->where("assigmnt_number > $curr_assgmnt");
		$this->db->delete('lecturer_module_mark');
	}

	/**********************************************************************************************
	* Description		: this function to get maximun number of assigmnt
	* input				: $assgnmt_id
	* author			: Norafiq Azman
	* Date				: 20 June 2013
	* Modification Log	: -
	**********************************************************************************************/
	function get_max_assignmt_number($assgnmt_id)
	{
		$this->db->select('MAX(assigmnt_number) as maxtotal'); 
		$this->db->from('lecturer_module_mark');
		$this->db->where('assgmnt_id', $assgnmt_id);
		
		$query = $this->db->get();
		
   		$result = $query->row();

		if (isset($result->maxtotal))
		{
			return $result->maxtotal;
		}			
		else 
		{
			return 0;
		}
	}
	
	/**********************************************************************************************
	* Description		: this function to update or insert assignment marks
	* input				: $mark_list
	* author			: Norafiq Azman
	* Date				: 20 June 2013
	* Modification Log	: -
	**********************************************************************************************/
	function update_assigmnt_mark($mark_list)
	{
		foreach($mark_list as $row)
		{
			$this->db->select('smm.*');
			$this->db->from('lecturer_module_mark smm');
			$this->db->where('smm.stu_id', $row['stu_id']);
			$this->db->where('smm.assgmnt_id', $row['assgmnt_id']);
			$this->db->where('smm.assigmnt_number', $row['assigmnt_number']);
			$this->db->where('smm.category', $row['category']);
			
			$query = $this->db->get();
		
			if ($query->num_rows() > 0)
			{
				$lmm = $query->row();				
				$this->db->where('lmm_id', $lmm->lmm_id);
				$this->db->update('lecturer_module_mark', $row);
			}
			else
			{
				$this->db->insert('lecturer_module_mark', $row);
			}
		}		
	}
	
	/**********************************************************************************************
	* Description		: this function delete assignment id
	* input				: $sub_id, $ksm_id
	* author			: Norafiq Azman
	* Date				: 17 June 2013
	* Modification Log	: -
	**********************************************************************************************/
	function deleteAssigment($tugasanID)
	{
		$this->db->where('assgmnt_id', $tugasanID);
		$this->db->delete('lecturer_module_configuration'); 
	}

	/**********************************************************************************************
	* Description		: this function to get student assignment mark 
	* input				: $stu_id, $assgnmt_id, $assgmnt_selection, $totalMark
	* author			: Norafiq Azman
	* Date				: 30 June 2013
	* Modification Log	: -
	**********************************************************************************************/
	function getStudentMarkForAssignment($stu_id, $assgnmt_id, $assgmnt_selection, $totalMark)
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
	* Description		: this function to get student assignment mark 
	* input				: $stu_id, $assgnmt_id, $assgmnt_selection, $totalMark
	* author			: Norafiq Azman
	* Date				: 15 July 2013
	* Modification Log	: -
	**********************************************************************************************/
	function getStudentMarkForAssignmentMark($stu_id, $assgnmt_id, $assgmnt_selection, $totalMark)
	{
		$query = "IFNULL(sum(CASE  WHEN mark > 0 THEN mark else 0 END )/$assgmnt_selection*$totalMark/100, '0.00') as mark,
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
			{
				return -99.99;
			}		
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
			return 0.00;
		}

	}
	
	/**********************************************************************************************
	* Description		: this function to save mark into marks table. if(isset(mark)) = 0.00
	* input				: $stu_id, $assgnmt_id, $assgmnt_selection, $totalMark
	* author			: Norafiq Azman
	* Date				: 15 July 2013
	* Modification Log	: -
	**********************************************************************************************/
	function save_marks($aMarkah)
	{
		//loop through the marks, kalu dah ada update, kalu takde insert
		
		if(isset($aMarkah))
		{
			foreach($aMarkah as $row)
			{
				$this->db->select('marks_id');
				$this->db->from('marks');
				$this->db->where('marks_assess_type', $row['marks_assess_type']);
				$this->db->where('mark_category', $row['mark_category']);
				$this->db->where('md_id', $row['md_id']);
				
				$query = $this->db->get();
			
				if ($query->num_rows() > 0)
				{
					$marks= $query->row();	
					
					$row['marks_id'] = $marks->marks_id;
					
					/*echo("<br><pre>");
					print_r($marks->marks_id);
					print_r($row);
					echo("</pre>");*/ // FDP

					$this->db->update('marks', $row, array('marks_id' => $marks->marks_id));
				}
				else
				{
					//echo("<br><pre>");
					//print_r($row);
					//echo("</pre>"); //FDP
					if(array_key_exists("marks_total_mark",$row))
					{
						$this->db->insert('marks', $row);
					}
					else
					{
						//do nothing..
					}
				}
			}
		}			
	}
	
	/**********************************************************************************************
	* Description		: this function to check if configuration date is open or close
	* input				: $type
	* author			: Norafiq Azman
	* Date				: 15 July 2013
	* Modification Log	: -
	**********************************************************************************************/
	function isMarkingOpen($type, $semester)
	{		
		$user = $this->ion_auth->user()->row();
		$userid = $user->id;
		
		$user_groups = $this->ion_auth->get_users_groups($userid)->row();
		$ulevel_id = $user_groups->id;
	
		$year = $this->session->userdata["tahun"];
		$userSesi = $this->session->userdata["sesi"];
	
		$this->db->select('*');
		$this->db->from('submit_date_configuration');
		$this->db->where('sd_current_session', $userSesi);
		$this->db->where('sd_current_year', $year);
		$this->db->where('sd_current_semester', $semester);
		$this->db->where('sd_assessment_type', $type);
		$this->db->where('UNIX_TIMESTAMP() BETWEEN  sd_open_date AND sd_close_date');
	
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{				
			$result = $query->row();
		
			$this->db->select('UNIX_TIMESTAMP(end_date_user)');
			$this->db->from('user_level_manual_configuration');
			$this->db->where('sdconfig_id', $result->sdconfig_id);
			$this->db->where('ul_id', $ulevel_id);
		
			$query2 = $this->db->get();
			
			if ($query2->num_rows() > 0)
			{
				return true;
			}
		}
		else
		{
			$user = $this->ion_auth->user()->row();
			$userid = $user->id;
	
			$this->db->select('*');
			$this->db->from('submit_date_manual_configuration');
			$this->db->where('sdm_current_session', $userSesi);
			$this->db->where('sdm_current_year', $year);
			$this->db->where('sdm_assessment_type', $type);
			$this->db->where('UNIX_TIMESTAMP() BETWEEN  sdm_open_date AND sdm_close_date');
			$this->db->where("col_id = (select col_id from user where user_id = $userid)");
	
			$query = $this->db->get();
			
			if ($query->num_rows() > 0)
			{
				$result = $query->row();
			
				$this->db->select('UNIX_TIMESTAMP(end_date_user)');
				$this->db->from('user_level_manual_configuration');
				$this->db->where('sdmconfig_id', $result->sdmconfig_id);
				$this->db->where('ul_id', $ulevel_id);
			
				$query2 = $this->db->get();
				
				if ($query2->num_rows() > 0)
				{
					return true;
				}
			}
			else
			{
				return false;
			}
		}
	}
	
	/**********************************************************************************************
	* Description		: function to get lecturer close date
	* input				: -
	* author			: Norafiq Azman
	* Date				: 30 July 2013
	* Modification Log	: -
	**********************************************************************************************/
	function isLecturerClose()
	{
		//nak check user level manual cnfiguration
	}

	/**********************************************************************************************
	* Description		: function ni nak dapatkan percentage untuk setiap paper walaupun satu
	* 					  melalui recursive function -> get_mod_ids
	* input				: $cm_id, $category, $type
	* author			: Norafiq Azman
	* Date				: 19 July 2013
	* Modification Log	: -
	**********************************************************************************************/
	function get_all_paper($cm_id, $category, $type)
	{
		if("AK" == $type)
		{
			$inString =  $this->m_subject->get_mod_ids($cm_id);
				
			$this->db->select('m.*, ppr.*');
			$this->db->from('module m, module_ppr ppr');
			$this->db->where("m.mod_id in ($inString)");
			$this->db->where('ppr.mod_id = m.mod_id');
			$this->db->where('ppr.ppr_category', $category);
				
			$query = $this->db->get();
			
			if ($query->num_rows() > 0)
			{
				return $query->result();
			}
		}
		else if("VK" == $type)
		{
			$this->db->select('m.*, pt.*');
			$this->db->from('course_module cm, module m, module_pt pt');
			$this->db->where("cm.cm_id", $cm_id);
			$this->db->where('m.mod_id = cm.mod_id');
			$this->db->where('pt.mod_id = m.mod_id');
			$this->db->where('pt.pt_category', $category);
			
			$query = $this->db->get();
				
			if ($query->num_rows() > 0)
			{
				return $query->result();
			}
		}
	}

	/**********************************************************************************************
	* Description		: this function to get module id using recursive
	* input				: $cm_id
	* author			: Norafiq Azman
	* Date				: 19 July 2013
	* Modification Log	: -
	**********************************************************************************************/	
	function get_mod_ids($cm_id)
	{
		$this->db->select('*');
		$this->db->from('course_module');
		$this->db->where('cm_id', $cm_id);
			
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			$id =  $query->row()->mod_id;
				
			$ids = $id;
				
			//loop dan cari paper 1 dan yang seterusnya sampai habis
			while($id > 0)
			{
				$this->db->select("ifnull(min(m.mod_id),-1) as mid from module m where m.mod_paper_one = $id", false);
				
				$queryl = $this->db->get();
					
				if ($queryl->num_rows() > 0)
				{
					$id = $queryl->row()->mid;
						
					if($id > 0)
					{
						$ids = $ids.",".$id;
					}						
				}
				else
				{
					$id = -1;
				}
					
			}
				
			return $ids;
		}
		else
		{
			return 0;
		}			
	}
	
	/**********************************************************************************************
	* Description		: this function to get module data
	* input				: $subjectId
	* author			: Norafiq Azman
	* Date				: 26 July 2013
	* Modification Log	: -
	**********************************************************************************************/
	function subject_code($subjectId)
	{
		$this->db->select('m.mod_code');
		$this->db->from('module m');
		$this->db->where('m.mod_id', $subjectId);
			
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			return $query->row()->mod_code;
		}
	}
	
	/**********************************************************************************************
	* Description		: this function to get module mark centre or schools
	* input				: $mod_id, $category
	* author			: Norafiq Azman
	* Date				: 30 July 2013
	* Modification Log	: -
	**********************************************************************************************/
	function getModuleMark($mod_id, $category)
	{
		if("P" == $category)
		{
			$this->db->select('m.mod_mark_centre');
			$this->db->from('module m');
			$this->db->where('m.mod_id', $mod_id);
				
			$query = $this->db->get();
			
			if ($query->num_rows() > 0)
			{
				return $query->row()->mod_mark_centre;
			}
		}		
		else if("S" == $category)
		{
			$this->db->select('m.mod_mark_school');
			$this->db->from('module m');
			$this->db->where('m.mod_id', $mod_id);
				
			$query = $this->db->get();
			
			if ($query->num_rows() > 0)
			{
				return $query->row()->mod_mark_school;
			}
		}		
	}
	
	/**********************************************************************************************
	* Description		: this function to get module by md_id
	* input				: $mdid
	* author			: Norafiq Azman
	* Date				: 20 August 2013
	* Modification Log	: umairah - subjek vk - 11/4/2014
	**********************************************************************************************/
	function subject_by_mdid($mdid)
	{	
		$this->db->select('mrk.*, m.*');
		$this->db->from('marks mrk, module m, module_taken mt');	
		$this->db->where('mt.mod_id = m.mod_id');
		$this->db->where('mrk.md_id = mt.md_id');
		$this->db->where('mrk.md_id', $mdid);
		$query = $this->db->get();
		$ak = $query->row();		
				
		if($ak->mod_type == "AK" && $ak->mod_mark_centre == 70){
			
			$this->db->select('m.*,mrk.*');
			$this->db->from('module m, module_taken mt, marks mrk');
			$this->db->where('mt.md_id', $mdid);
			$this->db->where('m.mod_id = mt.mod_id');
			$this->db->where('mt.md_id = mrk.md_id');
			$this->db->where('mrk.marks_assess_type', "AK");
			$this->db->where('mrk.mark_category', "P");
			$this->db->where('mrk.marks_total_mark', 70);
			
		}
		
		else
		{
			$this->db->select('m.*, mrk.*');
			$this->db->from('module m, module_taken mt, marks mrk');
			$this->db->where('mt.md_id', $mdid);
			$this->db->where('m.mod_id = mt.mod_id');
			$this->db->where('mt.md_id = mrk.md_id');
			$this->db->where('mrk.marks_assess_type', "VK");
			$this->db->where('mrk.mark_category', "S");
			$this->db->where('mrk.marks_total_mark', 70);
			//$this->db->where('mrk.marks_assess_type', "VK");
			//$this->db->where('mrk.mark_category', "S");
			//$this->db->where('mrk.marks_assess_type', "VK");
			//$this->db->where('mrk.mark_category', "S");
		}
		
		$query = $this->db->get();
			
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
	}

	/**********************************************************************************************
	 * Description		: this function to select repeat mark from marks table
	* input				: $mdid = modul taken id
	* author			: Norafiq Azman
	* Date				: 4 December 2013
	* Modification Log	: umairah 10/4/2014
	**********************************************************************************************/
	/*function select_repeat_mark($mdid)
	{	
		$this->db->select('m.*');
		$this->db->from('module m, module_taken mt');
		$this->db->where('mt.mod_id = m.mod_id');	
		$this->db->where('mt.md_id', $mdid);
		$query = $this->db->get();
		$ak = $query->row();
	
		$this->db->select('mrk.*');
		$this->db->from('marks mrk, module m, module_taken mt');	
		$this->db->where('mt.mod_id = m.mod_id');
		$this->db->where('mrk.md_id = mt.md_id');
		$this->db->where('mt.md_id', $mdid);
		//$query = $this->db->get();
		
		if ($ak->mod_type == "AK")
		{
			$this->db->where('mrk.marks_assess_type', "AK");
			$this->db->where('mrk.mark_category', "P");
			//$this->db->where('mrk.marks_total_mark', 70);		
		}
		
		else
		{
			$this->db->where('mrk.marks_assess_type', "VK");
			$this->db->where('mrk.mark_category', "S");
			//$this->db->where('mrk.marks_total_mark', 70);		
		}
		
		$query = $this->db->get();
		
		
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
	}*/
	
	/**********************************************************************************************
	* Description		: this function to update or insert assignment marks
	* input				: $mark_list
	* author			: Norafiq Azman
	* Date				: 21 August 2013
	* Modification Log	: umairah - subjek ak and vk 10/4/2014
	**********************************************************************************************/
	function update_repeat_mark($mod_id, $ttlrmark, $mod_centre)//$mark_list
	{		

		$this->db->select('mrk.*');
		$this->db->from('marks mrk');	
		$this->db->where('mrk.md_id', $mod_id);
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			$mrks = $query->row();
		}
		
			if($mrks->marks_assess_type == "AK")
			{
				$this->db->select('mrk.*');
				$this->db->from('marks mrk');
				$this->db->where('mrk.mark_category', "P");
				$this->db->where('mrk.marks_total_mark', 70);
				$this->db->where('mrk.md_id', $mod_id);
				$query = $this->db->get();
				
				if ($query->num_rows() > 0)
				{
					$mrks = $query->row();
				}
				
					$data = array(
													
						'marks_value' => $ttlrmark,
						
					);
					
									
				$this->db->where('marks_id', $mrks->marks_id);
				$this->db->update('marks', $data);
				
				
			}
						
			else
			{
				$this->db->select('mrk.*');
				$this->db->from('marks mrk');
				$this->db->where('mrk.mark_category', "S");
				$this->db->where('mrk.marks_total_mark', 70);
				$this->db->where('mrk.md_id', $mod_id);
				$query = $this->db->get();
				
				if ($query->num_rows() > 0)
				{
					$mrks = $query->row();
				}
				
					$data = array(						
							'marks_value' => $ttlrmark,
								
					);
				
					
				$this->db->where('marks_id', $mrks->marks_id);		
				$this->db->update('marks', $data);
				
			}
			
	}
	
	/**********************************************************************************************
	* Description		: this function to get mark value if ada dalam table marks
	* input				: $mdid
	* author			: Norafiq Azman
	* Date				: 22 August 2013
	* Modification Log	: -
	**********************************************************************************************/
	function value_mark($mdid)
	{
		$this->db->select('mr.marks_value');
		$this->db->from('marks mr, module_taken mt');
		$this->db->where('mt.md_id', $mdid);
		$this->db->where('mr.md_id = mt.md_id');
		$this->db->where('mr.marks_assess_type', "AK");
		$this->db->where('mr.mark_category', "P");
				
		$query = $this->db->get();
			
		if ($query->num_rows() > 0)
		{
			return $query->row();
		}
	}


	/**********************************************************************************************
	* Description		: this function to get sub theory for theory module.
	* input				: $assgmnt_id
	* author			: Freddy Ajang Tony
	* Date				: 27 January 2014
	* Modification Log	: -
	**********************************************************************************************/
	function get_sub_theory($assgmnt_id)
	{
		$this->db->select('tc.*');
		$this->db->from('theory_configuration tc');
		$this->db->where('tc.assigmnt_id', $assgmnt_id);
				
		$query = $this->db->get();
			
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	
	/**********************************************************************************************
	* Description		: this function to update sub theory configuration.
	* input				: $dataSubTheory, $th_id
	* author			: Freddy Ajang Tony
	* Date				: 28 January 2014
	* Modification Log	: -
	**********************************************************************************************/
	function update_sub_theory($dataSubTheory, $th_id)
	{
		$this->db->where('th_id', $th_id);
		$this->db->update('theory_configuration', $dataSubTheory);
	}
	
	
	/**********************************************************************************************
	* Description		: this function to save sub theory configuration.
	* input				: $dataSubTheory
	* author			: Freddy Ajang Tony
	* Date				: 28 January 2014
	* Modification Log	: -
	**********************************************************************************************/
	function save_sub_theory($dataSubTheory)
	{
		$this->db->insert('theory_configuration', $dataSubTheory);
	}
	
	
	/**********************************************************************************************
	* Description		: this function to delete theory id
	* input				: $sub_id, $ksm_id
	* author			: Freddy Ajang Tony
	* Date				: 28 January 2014
	* Modification Log	: -
	**********************************************************************************************/
	function delete_Theory_Assigment($th_id)
	{
		$this->db->where('th_id', $th_id);
		$this->db->delete('theory_configuration'); 
	}
	
	
	/**********************************************************************************************
	 * Description		: this function to get ppr_id
	* input				: $subject
	* author			: siti umairah
	* Date				: 31 januari 2014
	* Modification Log	: -
	**********************************************************************************************/
	function get_ppr_id($subject)
	{
		$this->db->select('ppr_id');
		$this->db->from('module_ppr ppr');
		$this->db->where('ppr.mod_id', $subject);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query->result_array();
		
		}
				
	}
	
	
	
	/**********************************************************************************************
	 * Description		: this function to get total tugasan for akademik(sekolah) dan akhir(pusat)
	* input				: $userid,$year,$userSesi,$cmid,$ppr,$subject_type,$pilihan
	* author			: siti umairah
	* Date				: 30 januari 2014
	* Modification Log	: -
	**********************************************************************************************/
	function total_esaimen($userid,$year,$userSesi,$cmid,$ppr,$subject_type,$pilihan)
	{
			
		if($pilihan == 1 && $subject_type == "VK")
		{
			$this->db->select_sum('lmc.assgmnt_total');
			$this->db->from('lecturer_module_configuration lmc, lecturer_assign la, module_pt pt');
			$this->db->where('la.la_id = lmc.la_id');
			$this->db->where('lmc.pt_id = pt.pt_id');
			$this->db->where('la.cm_id', $cmid);
			$this->db->where('la.user_id', $userid);
			$this->db->where('la.la_current_year', $year);
			$this->db->where('la.la_current_session', $userSesi);
			$this->db->where('pt.pt_category', "P");
			//$this->db->where('la.la_current_session', $userSesi);
	
			$query = $this->db->get();
    		return $query->row();
    		
		}
		else if($pilihan == 1 && $subject_type == "AK")
		{
			$this->db->select_sum('lmc.assgmnt_total');
			$this->db->from('lecturer_module_configuration lmc, lecturer_assign la, module_ppr ppr');
			$this->db->where('la.la_id = lmc.la_id');
			$this->db->where('lmc.ppr_id = ppr.ppr_id');
			$this->db->where('la.cm_id', $cmid);
			$this->db->where('la.user_id', $userid);
			$this->db->where('la.la_current_year', $year);
			$this->db->where('la.la_current_session', $userSesi);
			$this->db->where('ppr.ppr_category', "S");
			//$this->db->where('la.la_current_session', $userSesi);
	
			$query = $this->db->get();
    		return $query->row();
		}
	
	}
	
	/**********************************************************************************************
	* Description		: this function get la_id_parent
	* input				: $cm_id
	* author			: Nabihah Ab Karim
	* Date				: 26 Februari 2014
	* Modification Log	: 
	**********************************************************************************************/	
	
	function getIdParent($userid, $cmID)
	{
		$userSesi = $this->session->userdata["sesi"];
		$userYear = $this->session->userdata["tahun"];
		
		$this->db->select('la.la_id_parent, la.la_id');
		$this->db->from('lecturer_assign la');
		$this->db->where('la.user_id', $userid);
		$this->db->where('la.cm_id', $cmID);
		$this->db->where('la.la_current_session', $userSesi);
		$this->db->where('la.la_current_year', $userYear);
		$query = $this->db->get();
    	return $query->row();
		
	}		
	
}// end of Class
/**************************************************************************************************
* End of m_subject.php
**************************************************************************************************/
?>