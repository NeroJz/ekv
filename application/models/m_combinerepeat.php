<?php
/**************************************************************************************************
* File Name        : M_combinerepeat.php
* Description      : 
* Author           : sukor
* Date             : 31 july 2013
* Version          : -
* Modification Log : -
* Function List	   : 
**************************************************************************************************/
class M_combinerepeat extends CI_Model 
{
	var $table = "pelajar";
	var $pk = "id_pelajar";
	
	/**********************************************************************************************
	* Description		: add student using crud. Refer To En Fakhruz for more detail
	* input				: $data
	* author			: Norafiq Azman
	* Date				: 13 June 2013
	* Modification Log	: -
	**********************************************************************************************/
	function add($data) 
	{
		if($this->db->insert($this->table, $data))
		{
			return $this->db->insert_id();
		} 
		else 
		{
			return 0;
		}
	}
	
	/**********************************************************************************************
	* Description		: add student level. Refer To En Fakhruz for more detail
	* input				: $data
	* author			: Norafiq Azman
	* Date				: 13 June 2013
	* Modification Log	: -
	**********************************************************************************************/
	function add_level($data)
	{
		if($this->db->insert("level", $data))
		{
			return $this->db->insert_id();
		}
		else
		{
			return 0;
		}
	}

	/**********************************************************************************************
	* Description		: add student subject. Refer To En Fakhruz for more detail
	* input				: $data
	* author			: Norafiq Azman
	* Date				: 13 June 2013
	* Modification Log	: -
	**********************************************************************************************/ 
	function add_subjek($data)
	{
		if($this->db->insert("subjek_diambil", $data))
		{
			return $this->db->insert_id();
		} 
		else 
		{
			return 0;
		}
	}
	
	/**********************************************************************************************
	* Description		: edit or updat student detail using crud.
	* 					  Refer To En Fakhruz for more detail.
	* input				: $data, $id
	* author			: Norafiq Azman
	* Date				: 13 June 2013
	* Modification Log	: -
	**********************************************************************************************/  
	function edit($id, $data) 
	{
		$this->db->where($this->pk, $id);
		return $this->db->update($this->table, $data);
	}

	/**********************************************************************************************
	* Description		: delete student. Refer To En Fakhruz for more detail
	* input				: $id
	* author			: Norafiq Azman
	* Date				: 13 June 2013
	* Modification Log	: -
	**********************************************************************************************/ 
	function delete($id)
	{
		$this->db->where($this->pk, $id);
		return $this->db->delete($this->table);
	}

	/**********************************************************************************************
	* Description		: this function to get subject by course id.
	* 					  Refer To En Fakhruz for more detail.
	* input				: $kursus_id=0
	* author			: Norafiq Azman
	* Date				: 13 June 2013
	* Modification Log	: -
	**********************************************************************************************/
	function getSubjectById($kursus_id=0)
	{
		$this->db->select('sm.*');
		$this->db->from('kursus_subjek_modul ksm');
		$this->db->join('subjek_modul sm', 'ksm.subjek_id = sm.subjek_id', 'inner');
		
		if($kursus_id != 0)
		{
			  $this->db->where('ksm.kursus_id', $kursus_id);
		}
		
		$q = $this->db->get();
		
		if($q->num_rows() > 0)
		{
			foreach($q->result() as $r)
			{
				$d[] = $r;
			}
			
			return $d;
		}
	}
	
	/**********************************************************************************************
	* Description		: this function to select all subject.
	* input				: cc_id, cm_semester, mod_type
	* author			: Fakhruz
	* Date				: 29 July 2013
	* Modification Log	: -
	**********************************************************************************************/
	function subjek_list($cc_id, $cm_semester, $mod_type = "AK")
	{
		$this->db->select('m.*');
		$this->db->join('course_module cm','cm.mod_id = m.mod_id','inner');
		$this->db->join('course c','c.cou_id=cm.cou_id','inner');
		$this->db->join('college_course cc','cc.cou_id=c.cou_id','inner');
		//$this->db->join('module_taken mt','mt.mod_id=m.mod_id','inner');
		$this->db->from('module m');
		$this->db->where('cm_semester', $cm_semester);
		$this->db->where('cc_id', $cc_id);
		$this->db->where("m.mod_type",$mod_type);
		//$this->db->group_by("mt.mod_id");

		$q = $this->db->get();
		
		if($q->num_rows() > 0)
		{
			foreach($q->result() as $r)
			{
				$d[] = $r;
			}
			
			return $d;
		}
	}
	
	/**********************************************************************************************
	* Description		: this function to select all subject in category AK
	* 					  Refer To En Fakhruz for more detail.
	* input				: -
	* author			: Norafiq Azman
	* Date				: 13 June 2013
	* Modification Log	: -
	**********************************************************************************************/
	function subjek_akademik_list($cC, $semester,$year,$tmpKursus)
	{
		$this -> db -> select("DISTINCT m.mod_paper,m.mod_id,m.mod_name", FALSE);
		$this -> db -> from('student s');
		$this -> db -> join('college_course cc', 'cc.cc_id=s.cc_id', 'left');
		$this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
		$this -> db -> join('course cou', 'cou.cou_id=cc.cou_id', 'left');
		$this -> db -> join('module_taken mt', 'mt.stu_id=s.stu_id', 'left');
		$this -> db -> join('module m', 'm.mod_id=mt.mod_id', 'left');
		$this->db->where("m.mod_type","AK");
		if (!empty($tmpKursus)) {
			$this -> db -> where('cc.cc_id', $tmpKursus);
		}
		if (!empty($semester)) {
			$this -> db -> where('mt.mt_semester', $semester);
		}
			$this -> db -> where('mt.mt_year', $year);
		
		if (!empty($course)) {
			$this -> db -> where('cc.cou_id', $course);
		}
   
			$this -> db -> where('mt.exam_status', 2);
		$this -> db -> where('mt.mt_status', 1);

		$q = $this -> db -> get();
		
		if($q->num_rows() > 0)
		{
			foreach($q->result() as $r)
			{
				$d[] = $r;
			}
			
			return $d;
		}
	}

	/**********************************************************************************************
	* Description		: this function to select all subject in kolej Vokasianal
	* 					  Refer To En Fakhruz for more detail.
	* input				: $cc_id, $cm_semester
	* author			: Norafiq Azman
	* Date				: 13 June 2013
	* Modification Log	: -
	**********************************************************************************************/ 
	function subjek_kv_list($cC, $semester,$year,$tmpKursus)
	{
		$this -> db -> select("DISTINCT m.mod_paper,m.mod_id,m.mod_name", FALSE);
		$this -> db -> from('student s');
		$this -> db -> join('college_course cc', 'cc.cc_id=s.cc_id', 'left');
		$this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
		$this -> db -> join('course cou', 'cou.cou_id=cc.cou_id', 'left');
		$this -> db -> join('module_taken mt', 'mt.stu_id=s.stu_id', 'left');
		$this -> db -> join('module m', 'm.mod_id=mt.mod_id', 'left');
		$this->db->where("m.mod_type","VK");
		if (!empty($tmpKursus)) {
			$this -> db -> where('cc.cc_id', $tmpKursus);
		}
		if (!empty($semester)) {
			$this -> db -> where('mt.mt_semester', $semester);
		}
			$this -> db -> where('mt.mt_year', $year);
		
		if (!empty($course)) {
			$this -> db -> where('cc.cou_id', $course);
		}
   
			$this -> db -> where('mt.exam_status', 2);
		$this -> db -> where('mt.mt_status', 1);

		$q = $this -> db -> get();
		
		if($q->num_rows() > 0)
		{
			foreach($q->result() as $r)
			{
				$d[] = $r;
			}
			
			return $d;
		}
	}

	/**********************************************************************************************
	* Description		: this function to select all student by selected course
	* 					  Refer To En Fakhruz for more detail.
	* input				: $cc_id, $curSemester, $curYear
	* author			: Norafiq Azman
	* Date				: 13 June 2013
	* Modification Log	: -
	**********************************************************************************************/
	function pelajar_akademik_list($cc_id, $curSemester, $curYear, $modType = '')
	{
		$this->db->select('s.*');
			$this -> db -> from('student s');
		$this -> db -> join('college_course cc', 'cc.cc_id=s.cc_id', 'left');
		$this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
		$this -> db -> join('course cou', 'cou.cou_id=cc.cou_id', 'left');
		$this -> db -> join('module_taken mt', 'mt.stu_id=s.stu_id', 'left');
		$this -> db -> join('module m', 'm.mod_id=mt.mod_id', 'left');
		
		$this->db->where("s.cc_id",$cc_id);
		$this->db->where("mt.mt_semester",$curSemester);
		$this->db->where("mt.mt_year",$curYear);
		$this -> db -> where('mt.exam_status', 2);
		$this->db->where('m.mod_type',$modType);
        $this -> db -> group_by('s.stu_id');
		$q = $this->db->get();
		
		if($q->num_rows() > 0)
		{
			foreach($q->result() as $r)
			{
				$module = $this->ModuleTakenMarks($r->stu_id,$curSemester,$curYear, $modType);
				
				if(!empty($module))
				{
					$r->listModuleTakenMarksAk = $module;
				}
				
				$d[] = $r;
			}
			
			return $d;
		}
	}
	
	/**********************************************************************************************
	* Description		: this function to select all module taken & marks
	* 		
	* input				: $stuId, $curSemester='1', $curYear="2013",$modType='AK'
	* author			: Fakhruz
	* Date				: 12 Julai 2013
	* Modification Log	: 4122013(sukor)
	**********************************************************************************************/
	function ModuleTakenMarks($stuId, $curSemester='', $curYear="",$modType='')
	{
		$this->db->select('mt.*, m.*');
		$this->db->from('module_taken mt');
		$this->db->join('student s','s.stu_id=mt.stu_id','inner');
		$this->db->join('marks m','m.md_id=mt.md_id','inner');
		$this->db->join('module mo','mo.mod_id=mt.mod_id','inner');
		$this->db->where('s.stu_id',$stuId);
		$this->db->where('mo.mod_type',$modType);
		$this->db->where('mt.mt_semester',$curSemester);
		$this -> db -> where('mt.exam_status', 2);
		$q = $this->db->get();
		
		if($q->num_rows() > 0)
		{
			foreach($q->result_array() as $r)
			{
				$d[$r['mod_id'].$r['mark_category']] = $r;
			}
			
			return $d;
		}
	}
	
	/**********************************************************************************************
	* Description		: this function to select all student by selected course
	* 					  Refer To En Fakhruz for more detail.
	* input				: $cc_id, $curSemester, $curYear
	* author			: Norafiq Azman
	* Date				: 29 July 2013
	* Modification Log	: -
	**********************************************************************************************/
	function pelajar_generalMarking_list($cc_id, $curSemester, $curYear, $modType = '', $asType = 'P')
	{
		$this->db->select('*');
		$this->db->from('student s');
		//$this->db->join('module_taken mt', 'mt.stu_id = s.stu_id', 'inner');
		$this->db->where("s.cc_id",$cc_id);
		$this->db->where("s.stu_current_sem",$curSemester);
		$this->db->where("s.stu_current_year",$curYear);
		

		$q = $this->db->get();
		
		if($q->num_rows() > 0)
		{
			foreach($q->result() as $r)
			{
				$module = $this->ModuleTakenGeneralMarking($r->stu_id,$r->stu_current_sem, $r->stu_current_year, $modType, $asType);
				
				if(!empty($module))
				{
					$r->listModuleTakenMarksAk = $module;
				}
				
				$d[] = $r;
			}
			
			return $d;
		}
	}
	/**********************************************************************************************
	* Description		: this function to select all module taken & marks
	* 		
	* input				: $stuId, $curSemester='1', $curYear="2013",$modType='AK'
	* author			: Fakhruz
	* Date				: 12 Julai 2013
	* Modification Log	: -
	**********************************************************************************************/
	function ModuleTakenGeneralMarking($stuId, $curSemester='1', $curYear="2013",$modType='AK', $asType = 'P')
	{
		$this->db->select('mt.md_id, mt.*, m.*');
		$this->db->from('module_taken mt');
		$this->db->join('student s','s.stu_id=mt.stu_id','inner');
		$this->db->join('module mo','mo.mod_id=mt.mod_id','inner');
		$this->db->join('marks m',"mt.md_id=m.md_id",'left');
		$this->db->where('s.stu_id',$stuId);
		$this->db->where('mo.mod_type',$modType);
		$this->db->where('mt.mt_semester',$curSemester);
		$this->db->where('m.mark_category',$asType);
		
		$q = $this->db->get();
		
		if($q->num_rows() > 0)
		{
			foreach($q->result_array() as $r)
			{
				$d[$stuId.$r['mod_id']] = $r;
			}
			
			return $d;
		}
	}

	/**********************************************************************************************
	* Description		: this function to select all exam grade based on category
	* 					  Refer To En Fakhruz for more detail.
	* input				: -
	* author			: Norafiq Azman
	* Date				: 13 June 2013
	* Modification Log	: -
	**********************************************************************************************/  
	function gradeList($category="AK")
	{
		$this->db->select('*');
		$this->db->from('grade');
		$this->db->where("category",$category);
	
		$q = $this->db->get();
		
		if($q->num_rows() > 0)
		{
			foreach($q->result() as $r)
			{
				$d[] = $r;
			}
			
			return $d;
		}
	}
	
	/**********************************************************************************************
	* Description		: this function to store mark and grade based on md_id
	* 					  Refer To En Fakhruz for more detail.
	* input				: -
	* author			: Fakhruz
	* Date				: 15 Julai 2013
	* Modification Log	: -
	**********************************************************************************************/ 
	function storeMarkAndSetGrade($mdId, $dataModuleTaken)
	{
		$this->db->where("md_id", $mdId);
		return $this->db->update("module_taken", $dataModuleTaken);
	}

	/**********************************************************************************************
	* Description		: this function to select student with configuration module and subject
	* input				: $cmID, $semester
	* author			: Norafiq Azman
	* Date				: 13 June 2013
	* Modification Log	: 18 July 2013 - Edit By Afiq - tukar relation col_id
	**********************************************************************************************/
	function student_marking($cmID, $semester)
	{
		$user = $this->ion_auth->user()->row();
		$userid = $user->id;
		
		$year = $this->session->userdata["tahun"];
		$userSesi = $this->session->userdata["sesi"];
				
		$this->db->select('s.stu_id, s.stu_name, s.stu_mykad, s.stu_matric_no, mt.md_id, cl.col_code');
		$this->db->from('course c, course_module cm, student s, college_course cc, college cl, user u, module_taken mt, module m');
		$this->db->where('cm.cm_id', $cmID);
		$this->db->where('cm.cou_id = c.cou_id');
		$this->db->where('cc.cou_id = c.cou_id');
		$this->db->where('cc.col_id = cl.col_id');
		$this->db->where('cl.col_id = u.col_id');
		$this->db->where('u.user_id', $userid);
		$this->db->where('s.cc_id = cc.cc_id');
		$this->db->where('s.stu_id = mt.stu_id');
		$this->db->where('m.mod_id = cm.mod_id');
		$this->db->where('m.mod_id = mt.mod_id');
		$this->db->where("s.stu_group in (select la_group from lecturer_assign where user_id = $userid and cm_id = $cmID and la_current_year = $year and la_current_session = $userSesi)");
		$this->db->where('s.stat_id IN (1, 10)');
		$this->db->where('mt.mt_status = 1');
		$this->db->where('mt.mt_year', $year);
		$this->db->where('mt.mt_semester', $semester);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	/**********************************************************************************************
	* Description		: this function to select student with assignment id
	* input				: $cmId, $assmnt_id
	* author			: Norafiq Azman
	* Date				: 19 June 2013
	* Modification Log	: 18 July 2013 - Edit By Afiq - tukar relation col_id
	**********************************************************************************************/
	function student_by_assmnt($cmID, $assmnt_id, $semester)
	{
		$this->db->select('ssc.*');
		$this->db->from('lecturer_module_configuration ssc');
		$this->db->where('ssc.assgmnt_id', $assmnt_id);
		
		$query2 = $this->db->get();
		
		if($query2->num_rows() > 0)
			$assgnmt = $query2->row();
		
		/*$this->db->select('p.id_pelajar, p.nama_pelajar, p.no_kp, l.level_id');
		$this->db->from('pelajar p, level l, kursus k, subjek_diambil d, subjek_modul sm');
		$this->db->where('p.id_pelajar = l.id_pelajar');
		$this->db->where('l.level_semester', $semselect);
		$this->db->where('l.level_status = 1');
		$this->db->where('l.tahun', $year);
		$this->db->where('l.kursus_id', $courselect);
		$this->db->where('l.kursus_id = k.kursus_id');
		$this->db->where('l.level_id = d.level_id');
		$this->db->where('d.subjek_id', $subselect);
		$this->db->where('d.subjek_id = sm.subjek_id');

		$query = $this->db->get();*/
		$user = $this->ion_auth->user()->row();
		$userid = $user->id;
		
		$year = $this->session->userdata["tahun"];
		$userSesi = $this->session->userdata["sesi"];
				
		$this->db->select('s.stu_id, s.stu_name, s.stu_mykad, s.stu_matric_no, cl.col_code');
		$this->db->from('course c, course_module cm, student s, college_course cc, college cl, user u, module_taken mt, module m');
		$this->db->where('cm.cm_id', $cmID);
		$this->db->where('cm.cou_id = c.cou_id');
		$this->db->where('cc.cou_id = c.cou_id');
		$this->db->where('cc.col_id = cl.col_id');
		$this->db->where('cl.col_id = u.col_id');
		$this->db->where('u.user_id', $userid);
		$this->db->where('s.cc_id = cc.cc_id');
		$this->db->where('s.stu_id = mt.stu_id');
		$this->db->where('m.mod_id = cm.mod_id');
		$this->db->where('m.mod_id = mt.mod_id');
		$this->db->where("s.stu_group in (select la_group from lecturer_assign where user_id = $userid and cm_id = $cmID and la_current_year = $year and la_current_session = $userSesi)");
		$this->db->where('s.stat_id IN (1, 10)');
		$this->db->where('mt.mt_status = 1');
		$this->db->where('mt.mt_year', $year);
		$this->db->where('mt.mt_semester', $semester);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			$student = $query->result();
			
			//kat sini kene loop utk setiap pelajar dan dapatkan markah mereka
			foreach($student as $s) 
			{
				$marksTTl = "";
				
				$student_mark = array();
				
				for($i=1; $i<=$assgnmt->assgmnt_total; $i++)
				{
					$mark = array();
					$mark['assignment_num'] = $i;
					
					//select markah utk assignment
					$this->db->select('smm.*');
					$this->db->from('lecturer_module_mark smm');
					$this->db->where('smm.assigmnt_number', $i);
					$this->db->where('smm.stu_id', $s->stu_id);
					$this->db->where('smm.assgmnt_id', $assmnt_id);
					
					$query3 = $this->db->get();
					
					if($query3->num_rows()>0)
					{
						$mark['data'] = $query3->row();
						
						$sql = " sum(a.mark) as s from (
							SELECT mark FROM lecturer_module_mark 
							WHERE assgmnt_id=$assmnt_id and stu_id = $s->stu_id order by mark desc
							limit $assgnmt->assgmnt_score_selection) a";
							
						$this->db->select($sql, false);
						
						$query4 = $this->db->get();
						
						if($query4->num_rows()>0)
						{
							$marksTTl =  (($query4->row()->s)/($assgnmt->assgmnt_score_selection))/100*$assgnmt->assgmnt_mark;
						}
					}
					
					array_push($student_mark, $mark);
				}	
				
				$s->marks = $student_mark;
				$s->ttlMark = $marksTTl;
			}

			return $student;
		}
	}


	/**********************************************************************************************
	* Description		: this function to select all exam grade based on category
	* 					  Refer To En Fakhruz for more detail.
	* input				: -
	* author			: sukor
	* Date				: 1 August 2013
	* Modification Log	: -
	 * 
	**********************************************************************************************/  
	function gradeListrRepeat($category)
	{
		$this->db->select('*');
		$this->db->from('grade');
		$this->db->where("category",$category);
	    $this->db->where("grade_status","ULANG");
		$q = $this->db->get();
		
		if($q->num_rows() > 0)
		{
			foreach($q->result() as $r)
			{
				$d[] = $r;
			}
			
			return $d;
		}
	}
	
	/**********************************************************************************************
	* Description		: this function to store mark and grade based on md_id repeat
	* 					  Refer To En Fakhruz for more detail.
	* input				: -
	* author			: sukor
	* Date				: 1 Agust 2013
	* Modification Log	: -
	**********************************************************************************************/ 
	function storeMarkAndSetGradeRepeat($mdId, $dataModuleTaken)
	{
		$this->db->where("md_id", $mdId);
		return $this->db->update("module_taken", $dataModuleTaken);
	}
	
}// end of Class
/**************************************************************************************************
* End of m_pelajar.php
**************************************************************************************************/
?>