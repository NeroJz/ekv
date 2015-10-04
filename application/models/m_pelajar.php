<?php
/**************************************************************************************************
* File Name        : m_pelajar.php
* Description      : This File contain all about students function include evaluation and other
* Author           : Norafiq Bin Mohd Azman Chew
* Date             : 13 June 2013
* Version          : -
* Modification Log : -
* Function List	   : add, add_level, add_subjek, edit, delete, getSubjectById,
*				 	 subjeck_akademik_list, subjek_kv_list, pelajar_akademik_list,
*				 	 ModuleTakenMarks, gradeList, storeMarkAndSetGrade,
*				 	 student_marking, student_by_assmnt
**************************************************************************************************/
class M_pelajar extends CI_Model 
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
	function subjek_akademik_list($cc_id, $cm_semester)
	{
		$this->db->select('*');
		$this->db->join('course_module cm','cm.mod_id = m.mod_id','inner');
		$this->db->join('course c','c.cou_id=cm.cou_id','inner');
		$this->db->join('college_course cc','cc.cou_id=c.cou_id','inner');
		$this->db->from('module m');
		$this->db->where('cm_semester', $cm_semester);
		$this->db->where('cc_id', $cc_id);
		$this->db->where("m.mod_type","AK");
        $this->db->where("m.stat_mod",1);

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
	* Description		: this function to select all subject in kolej Vokasianal
	* 					  Refer To En Fakhruz for more detail.
	* input				: $cc_id, $cm_semester
	* author			: Norafiq Azman
	* Date				: 13 June 2013
	* Modification Log	: -
	**********************************************************************************************/ 
	function subjek_kv_list($cc_id, $cm_semester)
	{
		$this->db->select('*');
		$this->db->join('course_module cm','cm.mod_id = m.mod_id','inner');
		$this->db->join('course c','c.cou_id=cm.cou_id','inner');
		$this->db->join('college_course cc','cc.cou_id=c.cou_id','inner');
		$this->db->from('module m');
		$this->db->where('cm_semester', $cm_semester);
		$this->db->where('cc_id', $cc_id);
		$this->db->where("m.mod_type","VK");
         $this->db->where("m.stat_mod",1);
	
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
	* Description		: this function to select all student by selected course
	* 					  Refer To En Fakhruz for more detail.
	* input				: $cc_id, $curSemester, $curYear
	* author			: Norafiq Azman
	* Date				: 13 June 2013
	* Modification Log	: -
	**********************************************************************************************/
	function pelajar_akademik_list($cc_id, $curSemester, $curYear, $modType = 'AK')
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
				$module = $this->ModuleTakenMarks($r->stu_id,$r->stu_current_sem, $r->stu_current_year, $modType);
				
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
	function ModuleTakenMarks($stuId, $curSemester='1', $curYear="2013",$modType='AK')
	{
		$this->db->select('mt.*, m.*');
		$this->db->from('module_taken mt');
		$this->db->join('student s','s.stu_id=mt.stu_id','inner');
		$this->db->join('marks m','m.md_id=mt.md_id','inner');
		$this->db->join('module mo','mo.mod_id=mt.mod_id','inner');
		$this->db->where('s.stu_id',$stuId);
		$this->db->where('mo.mod_type',$modType);
		$this->db->where('mt.mt_semester',$curSemester);
		
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
	function pelajar_generalMarking_list($cc_id, $curSemester, $curYear, $modType = 'AK', $asType = 'P')
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
		$this->db->select('mt.*, m.marks_assess_type, m.mark_category, m.marks_id, m.marks_total_mark, m.marks_value');
		$this->db->from('module_taken mt');
		$this->db->join('marks m','m.md_id = mt.md_id OR m.md_id IS NULL','left');
		$this->db->join('student s','s.stu_id=mt.stu_id','inner');
		$this->db->join('module mo','mo.mod_id=mt.mod_id','inner');
		$this->db->where('s.stu_id',$stuId);
		$this->db->where('mo.mod_type',$modType);
		$this->db->where('mt.mt_semester',$curSemester);
		$this->db->where("(m.mark_category IS NULL OR m.mark_category = '$asType')");
		//$this->db->or_where('m.mark_category',null);
		
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
	* Description		: this function to select all student by selected course
	* 					  Refer To En Fakhruz for more detail.
	* input				: $cc_id, $curSemester, $curYear
	* author			: Norafiq Azman
	* Date				: 29 July 2013
	* Modification Log	: -
	**********************************************************************************************/
	function pelajar_generalMarkingProcess_list($cc_id, $curSemester, $curYear, $modType = 'AK', $asType = 'P')
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
				$module = $this->ModuleTakenGeneralMarkingProcess($r->stu_id,$r->stu_current_sem, $r->stu_current_year, $modType, $asType);
				
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
	function ModuleTakenGeneralMarkingProcess($stuId, $curSemester='1', $curYear="2013",$modType='AK', $asType = 'P')
	{
		$this->db->select('mt.*');
		$this->db->from('module_taken mt');
		$this->db->join('student s','s.stu_id=mt.stu_id','inner');
		$this->db->join('module mo','mo.mod_id=mt.mod_id','inner');
		$this->db->where('s.stu_id',$stuId);
		$this->db->where('mo.mod_type',$modType);
		$this->db->where('mt.mt_semester',$curSemester);
		
		$q = $this->db->get();
		
		if($q->num_rows() > 0)
		{
			foreach($q->result_array() as $r)
			{
				$d[$stuId.$r['md_id']] = $r;
			}
			
			return $d;
		}
	}
	
	/******************************************************************************************
	* Description		: this function to insert marks
	* input				: $data
	* author			: Fakhruz
	* Date				: 31 July 2013
	* Modification Log	: -
	******************************************************************************************/
	function batch_insert_marks($data)
	{
		if(count($data)>0)
			$this->db->insert_batch('marks', $data); 
	}
	
	/******************************************************************************************
	* Description		: this function to update marks
	* input				: $data
	* author			: Fakhruz
	* Date				: 31 July 2013
	* Modification Log	: -
	******************************************************************************************/
	function batch_update_marks($data)
	{
		if(count($data)>0)
			$this->db->update_batch('marks', $data,'marks_id'); 
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
	function student_marking($cmID, $semester, $kelas)
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
		$this->db->where("s.stu_group in (select la_group from lecturer_assign where user_id = $userid and cm_id = $cmID and la_current_year = $year and la_current_session = $userSesi and la_group = $kelas)");
		$this->db->where('s.stat_id IN (1, 10)');
		$this->db->where('mt.mt_status = 1');
		$this->db->where('mt.mt_year', $year);

		$this->db->order_by("s.stu_name");
		//$this->db->where('mt.mt_semester', $semester);
		
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	
	/**********************************************************************************************
	 * Description		: this function to select student with configuration module and subject
	* input				: $cmID, $semester
	* author			: Norafiq Azman
	* Date				: 13 June 2013
	* Modification Log	: 18 July 2013 - Edit By Afiq - tukar relation col_id - edit by umairah 14/3/2014/select kelas
	**********************************************************************************************/
	function student_marking1($cmID, $semester, $kelas)
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
		//$this->db->where('la.la_group = s.stu_group');
		$this->db->where("s.stu_group in (select la_group from lecturer_assign where user_id = $userid and cm_id = $cmID and la_current_year = $year and la_current_session = $userSesi and la_group = $kelas)");
		$this->db->where('s.stat_id IN (1, 10)');
		$this->db->where('mt.mt_status = 1');
		$this->db->where('mt.mt_year', $year);
		//$this->db->where('s.stu_group', $kelas);
		//$this->db->where('mt.mt_semester', $semester);
	
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
	function student_by_assmnt($cmID, $assmnt_id, $semester, $kelas)
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
				
		$this->db->select('s.stu_id, s.stu_name, s.stu_mykad, s.stu_matric_no, cl.col_code, mt.md_id');
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
		$this->db->where("s.stu_group in (select la_group from lecturer_assign where user_id = $userid and cm_id = $cmID and la_current_year = $year and la_current_session = $userSesi and la_group = $kelas)");
		$this->db->where('s.stat_id IN (1, 10)');
		$this->db->where('mt.mt_status = 1');
		$this->db->where('mt.mt_year', $year);
		$this->db->where('mt.mt_semester', $semester);
		


		$this->db->order_by('s.stu_name','ASC');
		
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			$student = $query->result();
			
			//kat sini kene loop utk setiap pelajar dan dapatkan markah mereka
			foreach($student as $s) 
			{
				$marksTTl = "";
				$status_competent = 1;
				
				$student_mark = array();
				
				for($i=1; $i<=$assgnmt->assgmnt_total; $i++)
				{
					$mark = array();
					$mark['assignment_num'] = $i;
					$mark['assignment_id'] = $assmnt_id;
					
					//select markah utk assignment
					$this->db->select('smm.*');
					$this->db->from('lecturer_module_mark smm');
					$this->db->where('smm.assigmnt_number', $i);
					$this->db->where('smm.stu_id', $s->stu_id);
					$this->db->where('smm.assgmnt_id', $assmnt_id);

					$this->db->order_by('smm.assgmnt_id','ASC');
					
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
				
				//Checking marks status competent
				$this->db->select('mrk.status_competent');
				$this->db->from('marks mrk');
				$this->db->where('mrk.md_id', $s->md_id);
				$this->db->where('mrk.mark_category', 'S');

				$query5 = $this->db->get();

				if($query5->num_rows()>0)
				{ 
					$status_competent = $query5->row();
					$s->status_competent = $status_competent->status_competent;
				}
				else
				{
					$s->status_competent = $status_competent;
				}

				//$s->status_competent = $status_competent;
				$s->marks = $student_mark;
				$s->ttlMark = $marksTTl;
			}

			return $student;
		}
	}
	
	/**********************************************************************************************
	* Description		: this function to select repeat student search by semester and course
	* input				: $kursus, $semester
	* author			: Norafiq Azman
	* Date				: 16 August 2013
	* Modification Log	: - ragu2
	**********************************************************************************************/
/*	function stdrepeat_srch_corse($kursus, $semester)
	{
		$user = $this->ion_auth->user()->row();
		$col_id = $user->col_id;
		
		$year = $this->session->userdata["tahun"];	
		
		$this->db->select('st.stu_name, st.stu_matric_no, m.mod_paper, m.mod_name, mt.md_id, mt.mt_semester');
		$this->db->from('student st, module_taken mt, module m, course c, college col, college_course cc');
		$this->db->where('col.col_id', $col_id);
		$this->db->where('c.cou_id', $kursus);
		$this->db->where('col.col_id = cc.col_id');
		$this->db->where('c.cou_id = cc.cou_id');
		$this->db->where('st.cc_id = cc.cc_id');
		$this->db->where('st.stat_id = 1');
		$this->db->where('mt.stu_id = st.stu_id');
		$this->db->where('mt.mt_semester', $semester);
		$this->db->where('mt.mt_year', $year);
		$this->db->where('mt.exam_status = 2');
		$this->db->where('mt.mod_id = m.mod_id');
		
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}*/
	
	/**********************************************************************************************
	* Description		: this function to select repeat student search by matric number
	* input				: $noMatrik
	* author			: Norafiq Azman
	* Date				: 19 August 2013
	* Modification Log	: -
	**********************************************************************************************/
	/*function stdrepeat_srch_mtrc($noMatrik)
	{		
		$year = $this->session->userdata["tahun"];	
		
		$this->db->select('st.stu_name, st.stu_matric_no, m.mod_paper, m.mod_name, mt.md_id, mt.mt_semester');
		$this->db->from('student st, module_taken mt, module m');
		$this->db->where('st.stu_matric_no', $noMatrik);
		$this->db->where('st.stat_id = 1');
		$this->db->where('mt.stu_id = st.stu_id');
		$this->db->where('mt.mt_year', $year);
		$this->db->where('mt.exam_status = 2');
		$this->db->where('mt.mod_id = m.mod_id');
		
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}*/
	
	/**********************************************************************************************
	* Description		: this function to select repeat student search by nothing input
	* input				: -
	* author			: Norafiq Azman
	* Date				: 20 August 2013
	* Modification Log	: umairah - 9/4/2014
	**********************************************************************************************/
	function stdrepeat_srch_nthg($kursus="",$semester="",$noMatrik="")
	{
		$user = $this->ion_auth->user()->row();
		$userid = $user->id;
		
		$this->db->select('c.cou_name, la.user_id,st.stu_name, st.stu_matric_no, m.mod_paper, m.mod_name, mt.md_id, mt.mt_semester');
		$this->db->from('student st, module_taken mt, module m, college_course cc, course_module cm, lecturer_assign la, course c');
	
		$this->db->where('cc.cc_id = st.cc_id');
		$this->db->where('c.cou_id = cc.cou_id');
		$this->db->where('st.stu_id = mt.stu_id');
		$this->db->where('la.cm_id = cm.cm_id');
		$this->db->where('cm.mod_id = mt.mod_id');
		$this->db->where('st.stat_id = 1');
		$this->db->where('mt.mod_id = m.mod_id');
		$this->db->where('la.user_id', $userid);
		$this->db->where('mt.exam_status = 2');
		$this->db->where('la.la_status = 2');
		
		if($kursus != "")
		{
			$this->db->where('cc.cou_id', $kursus);
		}
		
		if($semester != "")
		{
			$this->db->where('mt.mt_semester', $semester);
		}
		
		if($noMatrik != "")
		{
			$this->db->where('st.stu_matric_no', $noMatrik);
		}
		
		
		
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	
}// end of Class
/**************************************************************************************************
* End of m_pelajar.php
**************************************************************************************************/
?>