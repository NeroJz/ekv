<?php

/**************************************************************************************************
 * File Name        : m_form.php
 * Description      : This File contain Form module.
 * Author           : fakhruz
 * Date             : 02 Oct 2013s
 * Version          : -
 * Modification Log : -
 * Function List	   : __construct(),
 **************************************************************************************************/

class M_form extends CI_Model {
	/**********************************************************************************************
	 * Description		: this function to display result student
	 * input				: $centrecode
	 * author			: sukor
	 * Date				: 25 June 2013
	 * Modification Log	: -
	 **********************************************************************************************/
	function get_institusi($state="") {

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
	 * Description		: this function to get roster
	 * input				: 
	 * author			: sukor
	 * Date				: 1 july 2013,
	 * Modification Log	: 
	 **********************************************************************************************/
	function get_result_by_id($centrecode, $semester, $year, $course) {


		$p = 'GROUP_CONCAT(m.mod_name ORDER BY m.mod_paper ASC) as subjek,
       		GROUP_CONCAT(m.mod_paper ORDER BY m.mod_paper ASC) as kod_subjek,
        	GROUP_CONCAT(CONCAT(IFNULL(g.grade_type,0))ORDER BY m.mod_paper ASC) as greds,
         	GROUP_CONCAT(CONCAT(IFNULL(g.grade_value,0))ORDER BY m.mod_paper ASC) as nilaigred,
        	GROUP_CONCAT(CONCAT(IFNULL(g.grade_level,0))ORDER BY m.mod_paper ASC) as level_gred,
       		s.stu_id,s.stu_gender,count(mt.mod_id) as count_subj,s.stu_name,s.stu_mykad,s.stu_matric_no,
       		c.col_name,c.col_code,mt.mt_semester,mt.mt_year,col_type,col_code,m.mod_name,c.col_id,
       		r.pngk';

		$this -> db -> select($p, FALSE);
		$this -> db -> from('student s');
		$this -> db -> join('college_course cc', 'cc.cc_id=s.cc_id', 'left');
		$this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
		$this -> db -> join('course cou', 'cou.cou_id=cc.cou_id', 'left');

		$this -> db -> join('module_taken mt', 'mt.stu_id=s.stu_id', 'left');
		$this -> db -> join('module m', 'm.mod_id=mt.mod_id', 'left');
		$this -> db -> join('grade g', 'g.grade_id=mt.grade_id', 'left');
		$this -> db -> join('result r', 'r.stu_id=s.stu_id', 'left');
		if (!empty($centrecode)) {
			$this -> db -> where('c.col_name', $centrecode);
		}
		if (!empty($semester)) {
			$this -> db -> where('mt.mt_semester', $semester);
			$this -> db -> where('r.semester_count', $semester);
		}
		
			$this -> db -> where('mt.mt_year', $year);
			$this -> db -> where('r.current_year', $year);
		
		if (!empty($course)) {
			$this -> db -> where('cc.cou_id', $course);
		}



		//$this -> db -> where('mt.mt_status', 1);
		$this -> db -> group_by('s.stu_id');
		$this -> db -> order_by("s.stu_name", "asc");

		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}

	}
	/**********************************************************************************************
	 * Description		: this function to display result student
	 * input				: $centrecode
	 * author			: sukor
	 * Date				: 25 June 2013
	 * Modification Log	: -
	 **********************************************************************************************/
	function list_year_mt() {
		$this -> db -> select('mt.mt_year');
		$this -> db -> from('module_taken mt');
		$this -> db -> group_by('mt.mt_year');
		$this -> db -> order_by('mt.mt_year');
		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}
	}
	/**********************************************************************************************
	 * Description		: this function to display result student
	 * input				: $centrecode
	 * author			: sukor
	 * Date				: 25 June 2013
	 * Modification Log	: -
	 **********************************************************************************************/
	function list_course() {
		$this -> db -> select('c.*');
		$this -> db -> from('course c');
		$this -> db -> order_by("c.cou_code", "asc");
		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}
	}
	
	/**********************************************************************************************
	 * Description		: this function to display result student
	 * input			: $centrecode
	 * author			: sukor
	 * Date				: 25 June 2013
	 * Modification Log	: -
	 **********************************************************************************************/
	function list_course_byCol($colId) {
		$this -> db -> select('c.*');
		$this -> db -> from('course c');
		$this -> db -> join('college_course cc','cc.cou_id=c.cou_id','inner');
		$this -> db -> where("cc.col_id", $colId);
		$this -> db -> order_by("c.cou_code", "asc");
		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}
	}
	
	function list_student_confirm($dt_search)
	{
		$search=explode("|", $dt_search);
		$col_name= $search[0];
		//$cou_id = $search[1];
		$current_sem= $search[2];
	    $current_year = $search[3];
		$status_stu = $search[4];
		
		$p ='s.*,c.*,cou.*,cou.cou_course_code';

		$this -> db -> select($p, FALSE);
		$this -> db -> from('student s');
		$this -> db -> join('college_course cc', 'cc.cc_id=s.cc_id', 'left');
		$this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
		$this -> db -> join('course cou', 'cou.cou_id=cc.cou_id', 'left');
		$this -> db -> join('module_taken mt', "mt.stu_id=s.stu_id and mt.mt_semester=$current_sem", 'left');
		
		
		if (!empty($col_name)) {
			$this -> db -> where('c.col_name', $col_name);
		}
		
		/*if (!empty($cou_id)) {
			$this -> db -> where('cc.cou_id', $cou_id);
		}*/
		
		if (!empty($current_sem)) {
			$this -> db -> where('s.stu_current_sem', $current_sem);
		}
		if (!empty($current_year)) {
			$this -> db -> where('s.stu_current_year', $current_year);
		}
		if (!empty($status_stu)) {
			$this -> db -> where('mt.exam_status', $status_stu);
		}
		
		
		
		$this -> db -> where('s.stat_id', 1);
		if(!empty($col_name)){
			 $this -> db -> order_by("cou.cou_course_code", "asc");
		}else{
			$this -> db -> order_by("c.col_id", "asc");
			$this -> db -> order_by("cou.cou_course_code", "asc");
		}
        
	     $this -> db -> order_by("s.stu_name", "asc");
		 $this -> db -> group_by("s.stu_id");
	     $query = $this->db->get();
		 
		 if ($query -> num_rows() > 0) {
			return $query -> result();
		}
	}
	
	
	/**********************************************************************************************
	 * Description		: this function to get module take
	 * input			: 
	 * author			: sukor
	 * Date				: 2 july 2013
	 * Modification Log	: -3 july 2013
	 * 					  -01 October 2013 - Add $module
	 **********************************************************************************************/
	function get_module_taken($centrecode, $semester, $year, $course,$status_stu,$module) {
		
		/*GROUP_CONCAT(CONCAT(IFNULL(mt.mod_id, 0))ORDER BY m.mod_paper ASC) as mod_ids, s.stu_id, s.stu_gender, count(mt.mod_id) as count_subj, s.stu_name, s.stu_mykad, s.stu_matric_no, c.col_name, c.col_code, mt.mt_semester, mt.mt_year, col_type, col_code, m.mod_name, c.col_id, cou.cou_name 
		FROM (`student` s) 
		LEFT JOIN `college_course` cc ON `cc`.`cc_id`=`s`.`cc_id` 
		LEFT JOIN `college` c ON `c`.`col_id`=`cc`.`col_id` 
		LEFT JOIN `course` cou ON `cou`.`cou_id`=`cc`.`cou_id` 
		LEFT JOIN `module_taken` mt ON `mt`.`stu_id`=`s`.`stu_id` 
		LEFT JOIN `module` m ON `m`.`mod_id`=`mt`.`mod_id` 
		LEFT JOIN `not_attendance_exam` na ON `na`.`md_id`=`mt`.`md_id` 
		WHERE `mt`.`mt_semester` = '1'
		AND m.mod_code = 'A01'
		AND `mt`.`mt_year` = '2013' 
		AND `cc`.`cou_id` = '2' AND `mt`.`exam_status` = '1' 
		AND `s`.`stat_id` = 1 
		GROUP BY `s`.`stu_id` ORDER BY `s`.`stu_name` asc*/

		$p = 'GROUP_CONCAT(m.mod_paper ORDER BY m.mod_paper ASC) as kod_subjek,
       		GROUP_CONCAT(CONCAT(IFNULL(m.mod_type,0))ORDER BY m.mod_paper ASC) as type,
       		GROUP_CONCAT(CONCAT(IFNULL(mt.md_id=na.md_id,0))ORDER BY m.mod_code ASC) as notattd,
       		GROUP_CONCAT(CONCAT(IFNULL(mt.mod_id,0))ORDER BY m.mod_paper ASC) as mod_ids,
       		s.stu_id,s.stu_gender,count(mt.mod_id) as count_subj,s.stu_name,s.stu_mykad,s.stu_matric_no,
       		c.col_name,c.col_code,mt.mt_semester,mt.mt_year,col_type,col_code,m.mod_name,c.col_id,
       		cou.cou_name';
		$this -> db -> select($p, FALSE);
		$this -> db -> from('student s');
		$this -> db -> join('college_course cc', 'cc.cc_id=s.cc_id', 'left');
		$this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
		$this -> db -> join('course cou', 'cou.cou_id=cc.cou_id', 'left');
		$this -> db -> join('module_taken mt', 'mt.stu_id=s.stu_id', 'left');
		$this -> db -> join('module m', 'm.mod_id=mt.mod_id', 'left');
		$this -> db -> join('not_attendance_exam na', 'na.md_id=mt.md_id', 'left');
		if (!empty($centrecode)) {
			$this -> db -> where('c.col_name', $centrecode);
		}
		if (!empty($module)) {
			$this -> db -> where('m.mod_code', $module);
		}
		if (!empty($semester)) {
			$this -> db -> where('mt.mt_semester', $semester);
		}
		
			$this -> db -> where('mt.mt_year', $year);
		
		if (!empty($course)) {
			$this -> db -> where('cc.cou_id', $course);
		}
       if (!empty($status_stu)) {
			$this -> db -> where('mt.exam_status', $status_stu);
		}

		$this -> db -> where('s.stat_id', 1);

		$this -> db -> group_by('s.stu_id');

		$this -> db -> order_by("s.stu_name", "asc");

		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}

	}
	/**********************************************************************************************
	 * Description		: this function to display result student
	 * input				: $centrecode
	 * author			: sukor
	 * Date				: 25 June 2013
	 * Modification Log	: -
	 **********************************************************************************************/
	function modul_paper(&$avData, $opt = null, $parent = null, $count = 1) {

		$this -> db -> select('*', FALSE);
		$this -> db -> join('course_module cm', 'cm.mod_id=m.mod_id', 'left');
		// $this->db->join('not_attendance_exam na','na.md_id=mt.md_id','left');

		$this -> db -> where('cm.cm_semester', $opt['cm_semester']);
		$this -> db -> where('cm.cou_id', $opt['cou_id']);
		$this -> db -> where("mod_paper_one", $parent);

		$this -> db -> order_by("m.mod_code", "asc");

		$q = $this -> db -> get("module m");

		foreach ($q->result() as $r) {
			$r -> mod_paper_num = $count;
			$avData[] = $r;
			$count++;
			if ($r -> mod_type == "VK") {
				$this -> modul_paper_ak($avData, $opt, $r -> mod_id, $count);
			}

			$count = 1;
		}
	}
	/**********************************************************************************************
	 * Description		: this function to display result student
	 * input				: $centrecode
	 * author			: sukor
	 * Date				: 25 June 2013
	 * Modification Log	: -
	 **********************************************************************************************/
	function modul_paper_ak(&$avData, $opt = null, $parent = null, $count = 2) {

		$this -> db -> select('*', FALSE);
		$this -> db -> where("mod_paper_one", $parent);
		$this -> db -> order_by("m.mod_code", "asc");
		$q = $this -> db -> get("module m");

		foreach ($q->result() as $r) {
			$r -> mod_paper_num = $count;
			$avData[] = $r;
			$count++;

			$this -> modul_paper_ak($avData, $opt, $r -> mod_id, $count);

			$count = 2;
		}
	}

	/**********************************************************************************************
	 * Description		: this function to display result student
	 * input				: $centrecode
	 * author			: sukor
	 * Date				: 25 June 2013
	 * Modification Log	: -
	 **********************************************************************************************/
	function list_module() {
		$this -> db -> select('m.*');
		$this -> db -> from('module m');
			$this -> db -> where("mod_paper_one", NULL);
			$this -> db -> where("mod_type", "AK");
			$this -> db -> order_by("m.mod_code", "asc");
		$this -> db -> group_by("m.mod_code", "asc");
		
		
		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}
	}
	
	
	/**********************************************************************************************
	 * Description		: this function to display result student
	 * input				: $centrecode
	 * author			: sukor
	 * Date				: 8 july 2013
	 * Modification Log	: -
	 **********************************************************************************************/
	function get_analysis_result($centrecode,$course,$module) {

		$p = 'GROUP_CONCAT(m.mod_name ORDER BY m.mod_paper ASC) as subjek,
       		GROUP_CONCAT(m.mod_paper ORDER BY m.mod_paper ASC) as kod_subjek,
       		GROUP_CONCAT(CONCAT(IFNULL(mt.mt_semester,0))ORDER BY m.mod_paper ASC) as semester,
        	GROUP_CONCAT(CONCAT(IFNULL(g.grade_type,0))ORDER BY m.mod_paper ASC) as greds,
         	GROUP_CONCAT(CONCAT(IFNULL(g.grade_value,0))ORDER BY m.mod_paper ASC) as nilaigred,
        	GROUP_CONCAT(CONCAT(IFNULL(g.grade_level,0))ORDER BY m.mod_paper ASC) as level_gred,
        	GROUP_CONCAT(CONCAT(IFNULL(mt.mt_year,0))ORDER BY m.mod_paper ASC) as year,
        	GROUP_CONCAT(CONCAT(IFNULL(m.mod_credit_hour,0))ORDER BY m.mod_paper ASC) as kredit,
       		s.stu_id,count(mt.mod_id) as count_subj,s.stu_name,s.stu_mykad,s.stu_matric_no,
       		c.col_name,c.col_code,mt.mt_semester,col_type,col_code,sum(g.grade_value) as total,
       		sum(m.mod_credit_hour) as totalcredit,cou.cou_name,m.mod_name,c.col_id,m.mod_code,cou.cou_id';

		$this -> db -> select($p, FALSE);
		$this -> db -> from('student s');
		$this -> db -> join('college_course cc', 'cc.cc_id=s.cc_id', 'left');
		$this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
		$this -> db -> join('course cou', 'cou.cou_id=cc.cou_id', 'left');

		$this -> db -> join('module_taken mt', 'mt.stu_id=s.stu_id', 'left');
		$this -> db -> join('module m', 'm.mod_id=mt.mod_id', 'left');
		$this -> db -> join('grade g', 'g.grade_id=mt.grade_id', 'left');
		if (!empty($centrecode)) {
			$this -> db -> where('c.col_name', $centrecode);
		}
		if (!empty($course)) {
			$this -> db -> where('cc.cou_id', $course);
		}

        $this -> db -> where('m.mod_code', $module);

		$this -> db -> where('mt.mt_status', 1);
		$this -> db -> group_by('s.stu_id');
		$this -> db -> order_by("s.stu_name", "asc");

		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}

	}
	/**********************************************************************************************
	 * Description		: this function to display result student
	 * input				: $centrecode
	 * author			: sukor
	 * Date				: 25 June 2013
	 * Modification Log	: -
	 **********************************************************************************************/
function get_analysis_module($centrecode,$course,$module) {
	
		$this -> db -> select('m.*');
		$this -> db -> from('module m');
		$this -> db -> where("mod_paper_one", NULL);
		$this -> db -> where("mod_type", "AK");
        $this -> db -> where('m.mod_code', $module);
		$this -> db -> order_by("m.mod_paper", "asc");
		
	
		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}
	}
	
	/**********************************************************************************************
	 * Description		: this function to get analysis subject
	 * input				: 
	 * author			: sukor
	 * Date				: 4 july 2013
	 * Modification Log	: -
	 **********************************************************************************************/	
	 function get_analysis_results_ajax($analysis) {
	 
		
		$an=explode('|',$analysis);
		
		$Cc=$an[0];
		$course=$an[1];
		$moduleCode=$an[2];
		
		
        $arr_d = array();
        $sOrder = "";
		
        /* Ordering */
        if (isset($_POST['iSortCol_0'])) {
            $sOrder = "ORDER BY ";
            for ($i = 0; $i < ($_POST['iSortingCols'] ); $i++) {
                $this->db->order_by($this->zfnColumnToField($_POST['iSortCol_' . $i]), $_POST['sSortDir_' . $i]);
            }
        }

        $sWhere = "";
		
        if (isset($_POST['sSearch']) && $_POST['sSearch'] != "")
		{
		
			$this->db->where("(m.mod_codeLIKE '%" . mysql_real_escape_string($_POST['sSearch']) . 
			"%' OR m.mod_code LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%' OR m.mod_code LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%' OR s.subject_name LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%' OR g.grade_symbol LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%' OR sk.taken_semester LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%' OR c.course_acronym LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%' OR d.department_acronym LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%')");
			

			
        }

						   
         $p = 'GROUP_CONCAT(m.mod_name ORDER BY m.mod_paper ASC) as subjek,
       		GROUP_CONCAT(m.mod_paper ORDER BY m.mod_paper ASC) as kod_subjek,
       		GROUP_CONCAT(CONCAT(IFNULL(mt.mt_semester,0))ORDER BY m.mod_paper ASC) as semester,
        	GROUP_CONCAT(CONCAT(IFNULL(g.grade_type,0))ORDER BY m.mod_paper ASC) as greds,
         	GROUP_CONCAT(CONCAT(IFNULL(g.grade_value,0))ORDER BY m.mod_paper ASC) as nilaigred,
        	GROUP_CONCAT(CONCAT(IFNULL(g.grade_level,0))ORDER BY m.mod_paper ASC) as level_gred,
        	GROUP_CONCAT(CONCAT(IFNULL(mt.mt_year,0))ORDER BY m.mod_paper ASC) as year,
        	GROUP_CONCAT(CONCAT(IFNULL(m.mod_credit_hour,0))ORDER BY m.mod_paper ASC) as kredit,
       		s.stu_id,count(mt.mod_id) as count_subj,s.stu_name,s.stu_mykad,s.stu_matric_no,
       		c.col_name,c.col_code,mt.mt_semester,col_type,col_code,sum(g.grade_value) as total,
       		sum(m.mod_credit_hour) as totalcredit';

		$this -> db -> select($p, FALSE);
		$this -> db -> from('student s');
		$this -> db -> join('college_course cc', 'cc.cc_id=s.cc_id', 'left');
		$this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
		$this -> db -> join('course cou', 'cou.cou_id=cc.cou_id', 'left');

		$this -> db -> join('module_taken mt', 'mt.stu_id=s.stu_id', 'left');
		$this -> db -> join('module m', 'm.mod_id=mt.mod_id', 'left');
		$this -> db -> join('grade g', 'g.grade_id=mt.grade_id', 'left');
		if (!empty($centrecode)) {
			$this -> db -> where('c.col_name', $centrecode);
		}
		if (!empty($course)) {
			$this -> db -> where('cc.cou_id', $course);
		}
    $this -> db -> where('c.col_name', "KV ARAU");
      $this -> db -> where('cc.col_id', 1);

        $this -> db -> where('m.mod_code', "A01");

		$this -> db -> where('mt.mt_status', 1);
		$this -> db -> group_by('s.stu_id');
		$this -> db -> order_by("s.stu_name", "asc");

		
        $rResult1 = $this->db->get();
        $iFilteredTotal = $rResult1->num_rows();

        $db_query = $this->db->last_query();

        /* Paging */
        $sLimit = "";

        if (isset($_POST['iDisplayStart']) && $_POST['iDisplayLength'] != '-1') {
            /* $this->db->limit(mysql_real_escape_string( $_POST['iDisplayLength'] ),
              mysql_real_escape_string( $_POST['iDisplayStart'] )); */

            $db_query .= " LIMIT " . mysql_real_escape_string($_POST['iDisplayStart']) . ', ' . mysql_real_escape_string($_POST['iDisplayLength']);

            $bil = $_POST['iDisplayStart'];
        }
		else
            $bil = 0;

        $rResult = $this->db->query($db_query);

        $aResultTotal = $rResult->num_rows();

        $iTotal = $rResult->num_rows();


        $num = 0;

        if (isset($_POST['sEcho'])) {
            $arr_d['sEcho'] = intval($_POST['sEcho']);
        }
        $arr_d['iTotalRecords'] = $iTotal;
        $arr_d['iTotalDisplayRecords'] = $iFilteredTotal;
		
        if ($iTotal > 0) {


            foreach ($rResult->result() as $st) {
                

				
                 $bil++;
               
                           $arr_d["aaData"][] = array( "<center>".$bil."</center>"
                           
                           
                   );  
               
            }
        }
		else {
            $arr_d["aaData"] = array();
        }

        return $arr_d;
    }
    
	
	 function zfnColumnToField($i) 
	 {
        if ($i == 1)
            return "m.mod_code";
		else if($i == 2)
			return "m.mod_code";
                    else if ($i == 3)
            return "m.mod_code";
        else if ($i == 4)
            return "m.mod_code";
        else if ($i == 5)
            return "m.mod_code";
        else if ($i == 6)
            return "m.mod_code";
	
		
		
    }
	
	/**********************************************************************************************
	 * Description		: this function to display result student
	 * input				: $centrecode
	 * author			: sukor
	 * Date				: 25 June 2013
	 * Modification Log	: -
	 **********************************************************************************************/	
	function get_analysis_resultv2($centrecode,$course,$module) {

		$p = 'GROUP_CONCAT(m.mod_name ORDER BY m.mod_paper ASC) as subjek,
       		GROUP_CONCAT(m.mod_paper ORDER BY m.mod_paper ASC) as kod_subjek,
       		GROUP_CONCAT(CONCAT(IFNULL(mt.mt_semester,0))ORDER BY m.mod_paper ASC) as semester,
        	GROUP_CONCAT(CONCAT(IFNULL(g.grade_type,0))ORDER BY m.mod_paper ASC) as greds,
         	GROUP_CONCAT(CONCAT(IFNULL(g.grade_value,0))ORDER BY m.mod_paper ASC) as nilaigred,
        	GROUP_CONCAT(CONCAT(IFNULL(g.grade_level,0))ORDER BY m.mod_paper ASC) as level_gred,
        	GROUP_CONCAT(CONCAT(IFNULL(mt.mt_year,0))ORDER BY m.mod_paper ASC) as year,
        	GROUP_CONCAT(CONCAT(IFNULL(m.mod_credit_hour,0))ORDER BY m.mod_paper ASC) as kredit,
       		count(mt.mod_id) as count_subj, s.stu_id,s.stu_name,s.stu_mykad,s.stu_matric_no,
       		c.col_name,c.col_code,mt.mt_semester,col_type,col_code,sum(g.grade_value) as total,
       		sum(m.mod_credit_hour) as totalcredit,cou.cou_name';

		$this -> db -> select($p, FALSE);
		$this -> db -> from('student s');
		$this -> db -> join('college_course cc', 'cc.cc_id=s.cc_id', 'left');
		$this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
		$this -> db -> join('course cou', 'cou.cou_id=cc.cou_id', 'left');

		$this -> db -> join('module_taken mt', 'mt.stu_id=s.stu_id', 'left');
		$this -> db -> join('module m', 'm.mod_id=mt.mod_id', 'left');
		$this -> db -> join('grade g', 'g.grade_id=mt.grade_id', 'left');
		 $this -> db -> where('c.col_name', "KV ARAU");
      $this -> db -> where('cc.cou_id', 1);

        $this -> db -> where('m.mod_code', "A01");


		$this -> db -> where('mt.mt_status', 1);
		$this -> db -> group_by('s.stu_id');
		$this -> db -> order_by("s.stu_name", "asc");

		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}

	}


	/**********************************************************************************************
	 * Description		: this function to display result student
	 * input				: 
	 * author			: sukor
	 * Date				: 10 july 2013
	 * Modification Log	: -
	 **********************************************************************************************/
 function student_result($centreCode,$course,$year,$semester,$student,$examStatus)
    {
       
		
		$p = 'GROUP_CONCAT(s.stu_id ORDER BY s.stu_id ASC) as student_id,
			GROUP_CONCAT(m.mod_name ORDER BY m.mod_paper ASC) as subjek,
       		GROUP_CONCAT(m.mod_paper ORDER BY m.mod_paper ASC) as kod_subjek,
        	GROUP_CONCAT(CONCAT(IFNULL(g.grade_type,0))ORDER BY m.mod_paper ASC) as greds,
         	GROUP_CONCAT(CONCAT(IFNULL(g.grade_value,0))ORDER BY m.mod_paper ASC) as nilaigred,
        	GROUP_CONCAT(CONCAT(IFNULL(g.grade_level,0))ORDER BY m.mod_paper ASC) as level_gred,
        	GROUP_CONCAT(CONCAT(IFNULL(CAST(m.mod_credit_hour AS char(9)),0))ORDER BY m.mod_paper ASC) as kredit,
       		s.stu_id,s.stu_gender,count(mt.mod_id) as count_subj,s.stu_name,s.stu_mykad,s.stu_matric_no,
       		c.col_name,c.col_code,mt.mt_semester,mt.mt_year,col_type,col_code,m.mod_name,
       		c.col_id,cou.cou_cluster,cou.cou_name';

		$this -> db -> select($p, FALSE);
		$this -> db -> from('student s');
		$this -> db -> join('college_course cc', 'cc.cc_id=s.cc_id', 'left');
		$this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
		$this -> db -> join('course cou', 'cou.cou_id=cc.cou_id', 'left');

		$this -> db -> join('module_taken mt', 'mt.stu_id=s.stu_id', 'left');
		$this -> db -> join('module m', 'm.mod_id=mt.mod_id', 'left');
		$this -> db -> join('grade g', 'g.grade_id=mt.grade_id', 'left');
		//$this -> db -> join('result r', 'r.stu_id=s.stu_id', 'left');
		if (!empty($centreCode)) {
			$this -> db -> where('c.col_name', $centreCode);
		}
		if (!empty($semester)) {
			$this -> db -> where('mt.mt_semester', $semester);
			//  $this -> db -> where('r.semester_count', $semester);
		}
		if (!empty($year)) {
			$this -> db -> where('mt.mt_year', $year);
		//	$this -> db -> where('r.current_year', $year);
			}
		if (!empty($course)) {
			$this -> db -> where('cc.cou_id', $course);
		}

		 if (!empty($examStatus)) {
		 	if($examStatus==2){
		 		$this -> db -> where('mt.exam_status', $examStatus);
				
		 	}
					
				}

    if (!empty($student)) {
			$this -> db -> where('s.stu_matric_no', $student);
		}

		
		$this -> db -> group_by('s.stu_id');
		$this -> db -> order_by("s.stu_name", "asc");

		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}

    }

	/**********************************************************************************************
	 * Description		: this function to display result student
	 * input				: $centrecode
	 * author			: sukor
	 * Date				: 25 June 2013
	 * Modification Log	: -
	 **********************************************************************************************/
function resultBySemYearStudent($sem, $year, $student){
	$this -> db -> select("*");
	$this -> db -> from('result');
	$this -> db -> where("semester_count",$sem);
	$this -> db -> where("current_year", $year);
	$this -> db -> where("stu_id", $student);
	$query = $this -> db -> get();

	if ($query -> num_rows() > 0) {
		return $query -> result();
	}
}

//function store gred
function addResult($data){
	$this->db->insert('result', $data); 
}

/**********************************************************************************************
	 * Description		: this function to display result student
	 * input				: 
	 * author			: sukor
	 * Date				: 8 july 2013
	 * Modification Log	: -
	 **********************************************************************************************/

function statisticStudent($state)
    {
 
		$p = 'count(s.stu_id) as totalstudent,c.col_name,c.col_code,c.col_type';

		$this -> db -> select($p, FALSE);
		$this -> db -> from('student s');
		$this -> db -> join('college_course cc', 'cc.cc_id=s.cc_id', 'left');
		$this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
		$this -> db -> join('course cou', 'cou.cou_id=cc.cou_id', 'left');

		if (!empty($state)) {
			$this -> db -> where('c.state_id', $state);
		}
		$this -> db -> where('s.stat_id', 1);
		$this -> db -> group_by('cc.col_id');
		$this -> db -> order_by("totalstudent", "desc");
		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}

    }
	
	/**********************************************************************************************
	 * Description		: this function to get user_level
	 * input				: 
	 * author			: sukor
	 * Date				: 9 july 2013
	 * Modification Log	: -
	 **********************************************************************************************/
	
function get_user_level($ulName)
    {
 
		$this -> db -> select("ul.*");
		$this -> db -> from('user_level ul');
		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}

    }

/**********************************************************************************************
	 * Description		: this function to display result student
	 * input				: 
	 * author			: sukor
	 * Date				: 8 july 2013
	 * Modification Log	: -
	 **********************************************************************************************/

function statisticStudentbyKv($centreCode)
    {
 
		$p = 'count(s.stu_id) as totalstudent,c.col_name,c.col_code,c.col_type,cou.cou_name,
		cou.cou_code,cou.cou_course_code';

		$this -> db -> select($p, FALSE);
		$this -> db -> from('student s');
		$this -> db -> join('college_course cc', 'cc.cc_id=s.cc_id', 'left');
		$this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
		$this -> db -> join('course cou', 'cou.cou_id=cc.cou_id', 'left');

		if (!empty($centreCode)) {
			$this -> db -> where('c.col_id', $centreCode);
		}
		$this -> db -> where('s.stat_id', 1);
		$this -> db -> group_by('cc.cou_id');
		$this -> db -> order_by("totalstudent", "desc");
		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}

    }
	
/**********************************************************************************************
	 * Description		: this function to display transkrip
	 * input				: 
	 * author			: sukor
	 * Date				: 22 july 2013
	 * Modification Log	: -
	 **********************************************************************************************/


    function get_transkrip($centreCode,$course,$year,$student)
	{
		$this->db->select('s.*,c.col_name,cou.cou_course_code,cou.cou_cluster,cou.cou_name');
		$this->db->from('student s');
			$this -> db -> join('college_course cc', 'cc.cc_id=s.cc_id', 'left');
		$this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
		$this -> db -> join('course cou', 'cou.cou_id=cc.cou_id', 'left');
		if(!empty($year)){
			$this -> db -> where('stu_intake_session', $year);
		}
		if(!empty($course)){
			$this -> db -> where('cou.cou_id', $course);
		}
       if(!empty($centreCode)){
			$this -> db -> where('c.col_name', $centreCode);
		}
		
		 if(!empty($student)){
			$this -> db -> where('s.stu_matric_no', $student);
		}
		
       
		$q = $this->db->get();
		
		if($q->num_rows() > 0)
		{
			foreach($q->result() as $r)
			{
				$module = $this->get_mt($r->stu_id);
				
				if(!empty($module))
				{
					$r->mtaken = $module;
				}
				$results = $this->get_resul_transkrip($r->stu_id);
				
				if(!empty($results))
				{
					$r->results = $results;
				}
				
				
				$d[] = $r;
			}
			
			return $d;
		}
	}
	
	
/**********************************************************************************************
	 * Description		: this function to get module_taken for transkrip
	 * input				: 
	 * author			: sukor
	 * Date				: 19 july 2013
	 * Modification Log	: -
	 **********************************************************************************************/	
	
	function get_mt($stuid)
	{
		
		
		$this->db->select('mt.mt_semester,mt.mt_year,m.mod_paper,m.mod_name,m.mod_credit_hour,
		g.grade_level,g.grade_value,g.grade_type');
		$this->db->from('module_taken mt');
		$this -> db -> join('module m', 'm.mod_id=mt.mod_id', 'left');
		$this -> db -> join('grade g', 'g.grade_id=mt.grade_id', 'left');
		$this -> db -> where('mt.stu_id', $stuid);
		 $this -> db -> order_by("mt.mt_semester", "asc");
		$this -> db -> order_by("m.mod_code", "asc");
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
	 * Description		: this function to get result
	 * input				: 
	 * author			: sukor
	 * Date				: 19 july 2013
	 * Modification Log	: -
	 **********************************************************************************************/
function get_resul_transkrip($stuid)
	{
		
		
		$this->db->select('r.*');
		$this->db->from('result r');
		$this -> db -> where('r.stu_id', $stuid);
		 $this -> db -> order_by("r.semester_count", "asc");

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
	 * Description		: this function to get list intake student
	 * input				: 
	 * author			: sukor
	 * Date				: 19 july 2013
	 * Modification Log	: -
	 **********************************************************************************************/	
	
	function list_intake() {
		/*
		$this -> db -> select('r.current_year');
		$this -> db -> from('result r');
		$this -> db -> group_by('r.current_year');
		$this -> db -> order_by('r.current_year','asc');
		*/
		$this -> db -> select('s.stu_intake_session');
		$this -> db -> from('student s');
		$this -> db -> group_by('s.stu_intake_session');
		$this -> db -> order_by('s.stu_intake_session','asc');
		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}
	}
	
	
	 /**********************************************************************************************
	 * Description		: this function to get list module by course id
	 * input			: $course_id
	 * author			: Freddy Ajang Tony
	 * Date				: 30 september 2013
	 * Modification Log	: -
	 **********************************************************************************************/
	 function get_module($course_id)
	 {
	 	/*SELECT cm.cm_id,cm.mod_id,mdl.mod_code,mdl.mod_name,mdl.mod_type 
		FROM (course_module cm) LEFT JOIN module mdl ON mdl.mod_id = cm.mod_id 
		WHERE cm.cou_id = '2'*/
		
	 	$this->db->select('cm.cm_id,cm.mod_id,mdl.mod_code,mdl.mod_name,mdl.mod_type');
		$this->db->from('course_module cm');
		$this->db->join('module mdl','mdl.mod_id = cm.mod_id','left');
		$this->db->where('cm.cou_id',$course_id);
		$query = $this -> db -> get();
		
		if ($query -> num_rows() > 0) {
			return $query -> result();
		}
	 }
	 
	 
	 /**********************************************************************************************
	 * Description		: this function to get list course by kv type and code
	 * input			: $course_type,$course_code
	 * author			: Freddy Ajang Tony
	 * Date				: 30 september 2013
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
}
?>
