<?php

/**************************************************************************************************
 * File Name        : m_report.php
 * Description      : This File contain Report module.
 * Author           : sukor
 * Date             : 9 july 2013 
 * Version          : -
 * Modification Log : -
 * Function List	   : __construct(),
 **************************************************************************************************/

class M_report extends CI_Model {
	/**********************************************************************************************
	 * Description		: this function to display result student
	 * input				: $centrecode
	 * author			: sukor
	 * Date				: 25 June 2013
	 * Modification Log	: -
	 **********************************************************************************************/


	function get_result_by_id($centrecode, $semester, $year, $course) {


		$p = 'GROUP_CONCAT(m.mod_name ORDER BY m.mod_paper ASC) as subjek,
       		GROUP_CONCAT(m.mod_paper ORDER BY m.mod_paper ASC) as kod_subjek,
        	GROUP_CONCAT(CONCAT(IFNULL(g.grade_type,0))ORDER BY m.mod_paper ASC) as greds,
         	GROUP_CONCAT(CONCAT(IFNULL(g.grade_value,0))ORDER BY m.mod_paper ASC) as nilaigred,
        	GROUP_CONCAT(CONCAT(IFNULL(g.grade_level,0))ORDER BY m.mod_paper ASC) as level_gred,
       		s.stu_id,s.stu_gender,count(mt.mod_id) as count_subj,s.stu_name,s.stu_mykad,s.stu_matric_no,
       		c.col_name,c.col_code,mt.mt_semester,mt.mt_year,col_type,col_code,m.mod_name,c.col_id';

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
		if (!empty($semester)) {
			$this -> db -> where('mt.mt_semester', $semester);
		}
		
			$this -> db -> where('mt.mt_year', $year);
		
		if (!empty($course)) {
			$this -> db -> where('cc.cou_id', $course);
		}

		$this -> db -> where('mt.mt_status', 1);
		$this -> db -> group_by('s.stu_id');
		$this -> db -> order_by("s.stu_name", "asc");

		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}

	}

/**********************************************************************************************
	 * Description		: this function to state
	 * input				: 
	 * author			: sukor
	 * Date				: 8 july 2013
	 * Modification Log	: -
	 **********************************************************************************************/

	function list_state() {
		$this -> db -> select('s.*');
		$this -> db -> from('state s');
		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}
	}

	


/**********************************************************************************************
	 * Description		: this function to display fin
	 * input				: 
	 * author			: sukor
	 * Date				: 15 july 2013
	 * Modification Log	: -
**********************************************************************************************/	
	
	function list_fin_ajax() {
	  
	$arr_d = array();
        $sOrder = "";
	
	$dt_search = $_POST['search'];	
		//$dt_search = 'KV MELAKA TENGAH |2|1|2013|1';
	
		$search=explode("|", $dt_search);
		$col_name= $search[0];
		$cou_id = $search[1];
		$current_sem= $search[2];
	    $current_year = $search[3];
		$status_stu = $search[4];
	

        /* Ordering 
        if (isset($_POST['iSortCol_0'])) {
            $sOrder = "ORDER BY ";
            for ($i = 0; $i < ($_POST['iSortingCols'] ); $i++) {
                $this->db->order_by($this->pfnColumnToField($_POST['iSortCol_' . $i]), $_POST['sSortDir_' . $i]);
            }
        }
*/
        $sWhere = "";
		
        if (isset($_POST['sSearch']) && $_POST['sSearch'] != "")
		{
		
/*
			$this->db->where("(al.level_matric_no LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . 
			"%' OR s.student_name LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . 
			"%' OR s.student_mykad '%" . mysql_real_escape_string($_POST['sSearch']) . "%')");*/
			
			$this->db->where("(s.stu_matric_no LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%' 
			OR s.stu_name LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%' 
			OR s.stu_mykad LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%' )");
	
        }

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
		if (!empty($cou_id)) {
			$this -> db -> where('cc.cou_id', $cou_id);
		}
		
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

$tempCC="";
	$tempC="";		
            foreach ($rResult->result() as $st) {
            	if(!empty($col_name)){
		   if($tempCC !=$st->cou_id && $tempCC!="")
					   {
					   	$bil = 0;
					   }
					   
				}elseif(empty($col_name)){
					
					if($tempC !=$st->col_id && $tempC!="")
					   {
					   	$bil = 0;
					   }
				}	   
					  $course= $st->cou_course_code;
					   
                 $bil++;
				 
				 $graf[$st->cou_course_code]=$bil;
				
             preg_match("/^islam/i",$st->stu_religion,$matc);
                
				if(!empty($matc[0])){
					$stu_religion=$st->stu_religion;
                    
				}else{
				    
                    $stu_religion="Bukan Islam";
                    
				}

				 $arr_d["aaData"][] = array(
				 	"<center><input type='hidden' name='".$st->cou_course_code."[]' value='".$bil."' >". $bil."</center>",
				 	"<span>".ucwords(strtolower($st->stu_name))."</center>" ,
				 	"<span>".$st->stu_mykad."</span>" ,
				 	"<span>". $st->stu_matric_no."</span>" ,
				 	"<span>". $st->cou_course_code."</span>" ,
				 	"<span>".ucwords(strtolower( $st->stu_gender))."</span>" ,
				 	"<span>".ucwords(strtolower($st->stu_race))."</span>" ,
				 	"<center>".ucwords(strtolower($stu_religion))."</center>",
				 	"<center>".strtoupper($st->stat_id)."</center>"
				 	);  
		             
                      
					 $tempCC = $st->cou_id;
					     $tempC = $st->col_id;
            }
			
			
		             
        }
		else {
            $arr_d["aaData"] = array();
        }

        return $arr_d;
    }
	
	
	
	 function pfnColumnToField($i) 
	 {
        if ($i == 1)
            return "s.stu_name";
		else if($i == 2)
			return "s.stu_mykad";
        else if ($i == 3)
            return "s.stu_gender";
   
    }
	
    /**********************************************************************************************
    * Description		: this function to get value of FIN detail
    * input				: $col_name, $cou_id, $current_sem, $current_year, $status_stu
    * author			: Norafiq Daniel
    * Date				: 9 October 2013
    * Modification Log	: -
    **********************************************************************************************/
    function get_fin_detail($col_name, $cou_id, $current_sem, $current_year, $status_stu)
    {
    	$p ='s.stu_name, s.stu_mykad, s.stu_matric_no, cou.cou_course_code, s.stu_gender, s.stu_race, s.stu_religion, s.* ,c.*,cou.*';
    	
    	$this -> db -> select($p, FALSE);
    	$this -> db -> from('student s');
    	$this -> db -> join('college_course cc', 'cc.cc_id=s.cc_id', 'left');
    	$this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
    	$this -> db -> join('course cou', 'cou.cou_id=cc.cou_id', 'left');
    	$this -> db -> join('module_taken mt', "mt.stu_id=s.stu_id and mt.mt_semester=$current_sem", 'left');
    	
    	
    	if (!empty($col_name))
    	{
    		$this -> db -> where('c.col_name', $col_name);
    	}
    	if (!empty($cou_id))
    	{
    		$this -> db -> where('cc.cou_id', $cou_id);
    	}    	
    	if (!empty($current_sem))
    	{
    		$this -> db -> where('s.stu_current_sem', $current_sem);
    	}
    	if (!empty($current_year))
    	{
    		$this -> db -> where('s.stu_current_year', $current_year);
    	}
    	if (!empty($status_stu))
    	{
    		$this -> db -> where('mt.exam_status', $status_stu);
    	}
    	
    	$this -> db -> where('s.stat_id', 1);
    	
    	if(!empty($col_name))
    	{
    		$this -> db -> order_by("cou.cou_course_code", "asc");
    	}
    	else
    	{
    		$this -> db -> order_by("c.col_id", "asc");
    		$this -> db -> order_by("cou.cou_course_code", "asc");
    	}
    	
    	$this -> db -> order_by("s.stu_name", "asc");
    	$this -> db -> group_by("s.stu_id");
    	
    	$query = $this -> db -> get();
    	
    	if ($query -> num_rows() > 0)
    	{
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


	function get_fin($col_name, $cou_id, $current_sem, $current_year) {


		$p ='s.*,c.*,cou.*,cou.cou_course_code';

		$this -> db -> select($p, FALSE);
		$this -> db -> from('student s');
		$this -> db -> join('college_course cc', 'cc.cc_id=s.cc_id', 'left');
		$this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
		$this -> db -> join('course cou', 'cou.cou_id=cc.cou_id', 'left');
		
		if (!empty($col_name)) {
			$this -> db -> where('c.col_name', $col_name);
		}
		if (!empty($cou_id)) {
			$this -> db -> where('cc.cou_id', $cou_id);
		}
		
		if (!empty($current_sem)) {
			$this -> db -> where('s.stu_current_sem', $current_sem);
		}
		if (!empty($current_year)) {
			$this -> db -> where('s.stu_current_year', $current_year);
		}
		
		
		$this -> db -> where('s.stat_id', 1);
		
         $this -> db -> order_by("cou.cou_course_code", "asc");
         $this -> db -> order_by("s.stu_name", "asc");
		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}

	}
	 
	/**********************************************************************************************
	 * Description		: this function get student by course
	 * input			: 
	 * author			: sukor
	 * Date				: 12 july 2013
	 * Modification Log	: -
	 **********************************************************************************************/


	function get_student_course($semester, $year, $state) {


		$p = 'GROUP_CONCAT(m.mod_name ORDER BY m.mod_paper ASC) as subjek,
       		GROUP_CONCAT(m.mod_paper ORDER BY m.mod_paper ASC) as kod_subjek,
        	GROUP_CONCAT(CONCAT(IFNULL(g.grade_type,0))ORDER BY m.mod_paper ASC) as greds,
         	GROUP_CONCAT(CONCAT(IFNULL(g.grade_value,0))ORDER BY m.mod_paper ASC) as nilaigred,
        	GROUP_CONCAT(CONCAT(IFNULL(g.grade_level,0))ORDER BY m.mod_paper ASC) as level_gred,
       		s.stu_id,s.stu_gender,count(mt.mod_id) as count_subj,s.stu_name,s.stu_mykad,s.stu_matric_no,
       		c.col_name,c.col_code,mt.mt_semester,mt.mt_year,col_type,col_code,m.mod_name,c.col_id';


         $q="count(stu_id) as total ,
         c.col_name";
		$this -> db -> select($q, FALSE);


		$this -> db -> from('course cou');
		$this -> db -> join('college_course cc', 'cc.cc_id=cou.cou_id', 'left');
		$this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
        $this -> db -> join('state ss', 'ss.state_id=c.state_id', 'left');
	    $this -> db -> join('student s', 's.cc_id=cc.cc_id', 'left');
	/*
	$this -> db -> from('student s');
		$this -> db -> join('college_course cc', 'cc.cc_id=s.cc_id', 'left');
		$this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
		$this -> db -> join('course cou', 'cou.cou_id=cc.cou_id', 'left');
	 */
	
	
		//if (!empty($semester)) {
		//	$this -> db -> where('s.stu_current_sem', $semester);
	//	}
		
	//		$this -> db -> where('s.stu_current_year', $year);
		
		//if (!empty($state)) {
		//	$this -> db -> where('ss.state_id', $state);
		//}

		//$this -> db -> where('s.stat_id', 1);
		$this -> db -> group_by('cou.cou_id');
		//$this -> db -> order_by("s.stu_name", "asc");

		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}

	}



/**********************************************************************************************
	* Description		: this function to get student by course
	* 					  
	* input				: 
	* author			: sukor
	* Date				: 17 June 2013
	* Modification Log	: -
	**********************************************************************************************/
	function course_student_kv($semester,$state,$year,$colid)
	{
		$this->db->select('ce.cou_name,ce.cou_course_code,ce.cou_id');
		/*
		$this->db->from('course ce');
		$this -> db -> join('college_course ccx', 'ccx.cou_id=ce.cou_id', 'left');
		$this -> db -> join('college cx', 'cx.col_id=ccx.col_id', 'left');
        $this -> db -> join('state ssx', 'ssx.state_id=cx.state_id', 'left');
		 */
		 $this->db->from('college cx');
		$this -> db -> join('college_course ccx', 'ccx.col_id=cx.col_id', 'left');
		$this -> db -> join('course ce', 'ce.cou_id=ccx.cou_id', 'left');
		 if(!empty($state)){
			$this->db->where('cx.state_id',$state);
		   }
		 if(!empty($colid)){
			$this->db->where('cx.col_id',$colid);
		   }
        $this -> db -> order_by("ce.cou_course_code", "asc");
		$this -> db -> group_by('ccx.cou_id');
		$q = $this->db->get();
		
		if($q->num_rows() > 0)
		{
			foreach($q->result() as $r)
			{
				$module = $this->totalstudent($r->cou_id,$semester,$state,$year,$colid);
				
				if(!empty($module))
				{
					$r->totalstu = $module;
				}
				
				$d[] = $r;
			}
			
			return $d;
		}
	}
	/**********************************************************************************************
	 * Description		: this function to display result student
	 * input				: $centrecode
	 * author			: sukor
	 * Date				: 25 June 2013
	 * Modification Log	: -
	 **********************************************************************************************/	
	function totalstudent($cou_id,$semester,$state,$year,$colid)
	{
		$this->db->select('count(stu_id) as total,c.col_id,c.col_type,c.col_code');
		$this -> db -> from('course cou');
		$this -> db -> join('college_course cc', 'cc.cou_id=cou.cou_id', 'left');
		$this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
        $this -> db -> join('state ss', 'ss.state_id=c.state_id', 'left');
	    $this -> db -> join('student s', 's.cc_id=cc.cc_id', 'left');
		$this->db->where('cou.cou_id',$cou_id);
		if(!empty($semester)){
			$this->db->where('s.stu_current_sem',$semester);
		}
		if(!empty($year)){
			$this->db->where('s.stu_current_year',$year);
		}
           if(!empty($state)){
			$this->db->where('c.state_id',$state);
		   }
		   	 
			 if(!empty($colid)){
			$this->db->where('c.col_id',$colid);
		   }
		 
	    $this -> db -> order_by("c.col_type", "asc");
		 $this -> db -> order_by("c.col_code", "asc");
		$this -> db -> group_by('c.col_id');
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
	 * Description		: this function to coursekv
	 * input				: 
	 * author			: sukor
	 * Date				: 13 july 2013
	 * Modification Log	: -
	 **********************************************************************************************/

	function college($state) {
		$this -> db -> select('c.*');
		$this -> db -> from('college c');
		if(!empty($state)){
		$this->db->where('c.state_id',$state);	
		}
		    $this -> db -> order_by("c.col_type", "asc");
		 $this -> db -> order_by("c.col_code", "asc");
		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}
	}

	
function get_user_collegehelp($userid) {
		
		$this -> db -> select('u.*,c.*');
		$this -> db -> from('user u');
		$this -> db -> join('college c', 'c.col_id=u.col_id', 'left');
		if(!empty($userid)){
			$this->db->where('u.user_id',$userid);	
		}
		
		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}
		 
		 
	}


	 /**********************************************************************************************
	 * Description		: this function to fik
	 * input				: 
	 * author			: sukor
	 * Date				: 19 july 2013
	 * Modification Log	: -
	 **********************************************************************************************/


	function get_fik($col_name, $cou_id, $current_sem, $current_year) {
 
 
              $p = 'GROUP_CONCAT(m.mod_name ORDER BY m.mod_paper ASC) as subjek,
                     GROUP_CONCAT(m.mod_paper ORDER BY m.mod_paper ASC) as kod_subjek,
              GROUP_CONCAT(CONCAT(IFNULL(g.grade_type,0))ORDER BY m.mod_paper ASC) as greds,
              GROUP_CONCAT(CONCAT(IFNULL(g.grade_value,0))ORDER BY m.mod_paper ASC) as nilaigred,
              GROUP_CONCAT(CONCAT(IFNULL(g.grade_level,0))ORDER BY m.mod_paper ASC) as level_gred,
              GROUP_CONCAT(CONCAT(IFNULL(CAST(m.mod_credit_hour AS char(9)),0))ORDER BY m.mod_paper ASC) as kredit,
                     s.stu_id,s.stu_gender,count(mt.mod_id) as count_subj,s.stu_name,s.stu_mykad,s.stu_matric_no,
                     c.col_name,c.col_code,mt.mt_semester,mt.mt_year,col_type,col_code,m.mod_name,
                     c.col_id,cou.cou_cluster,cou.cou_name,r.*,cou.cou_course_code,
                     s.stu_race,s.stu_religion,cou.cou_id,sum(m.mod_credit_hour) as sumcredit';
			
              $this -> db -> select($p, FALSE);
              $this -> db -> from('student s');
              $this -> db -> join('college_course cc', 'cc.cc_id=s.cc_id', 'left');
              $this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
              $this -> db -> join('course cou', 'cou.cou_id=cc.cou_id', 'left');
 
              $this -> db -> join('module_taken mt', 'mt.stu_id=s.stu_id', 'left');
              $this -> db -> join('module m', 'm.mod_id=mt.mod_id', 'left');
              $this -> db -> join('grade g', 'g.grade_id=mt.grade_id');
              $this -> db -> join('result r', 'r.stu_id=s.stu_id', 'left');
             
              if (!empty($col_name)) {
                     $this -> db -> where('c.col_name', $col_name);
              }
              if (!empty($cou_id)) {
                     $this -> db -> where('cc.cou_id', $cou_id);
              }
             
              if (!empty($current_sem)) {
                     $this -> db -> where('mt.mt_semester', $current_sem);
				  $this -> db -> where('r.semester_count', $current_sem);
              }
              if (!empty($current_year)) {
                     $this -> db -> where('mt.mt_year', $current_year);
					 $this -> db -> where('r.current_year', $current_year);
              }
			  
			  
             
             
              
              $this -> db -> where('s.stat_id', 1);
              $this -> db -> group_by('s.stu_id');
			// $this -> db -> order_by("mt.exam_status","desc");
         $this -> db -> order_by("cou.cou_course_code", "asc");
         $this -> db -> order_by("s.stu_name", "asc");
		  
 
              $query = $this -> db -> get();
 
              if ($query -> num_rows() > 0) {
                     return $query -> result();
              }
 
       }

	/**********************************************************************************************
	* Description		: this function to get value of FIK detail
    * input				: $col_name, $cou_id, $current_sem, $current_year
    * author			: Norafiq Daniel
    * Date				: 9 October 2013
    * Modification Log	: -
    **********************************************************************************************/
    function get_fiK_detail($col_name, $cou_id, $current_sem, $current_year)
    {
    	$p = 	's.stu_name, s.stu_mykad, s.stu_matric_no, cou.cou_course_code, s.stu_gender,
    			s.stu_race,s.stu_religion, s.stu_id, count(mt.mod_id) as count_subj,
    			GROUP_CONCAT(m.mod_paper ORDER BY m.mod_paper ASC) as kod_subjek,
    			GROUP_CONCAT(m.mod_name ORDER BY m.mod_paper ASC) as subjek, 
    			GROUP_CONCAT(CONCAT(IFNULL(CAST(m.mod_credit_hour AS char(9)),0))ORDER BY m.mod_paper ASC) as kredit,
    			GROUP_CONCAT(CONCAT(IFNULL(g.grade_type,0))ORDER BY m.mod_paper ASC) as greds,
    			GROUP_CONCAT(CONCAT(IFNULL(g.grade_value,0))ORDER BY m.mod_paper ASC) as nilaigred,
    			GROUP_CONCAT(CONCAT(IFNULL(g.grade_level,0))ORDER BY m.mod_paper ASC) as level_gred,              
    			c.col_name,c.col_code,mt.mt_semester,mt.mt_year,col_type,col_code,m.mod_name,
                c.col_id,cou.cou_cluster,cou.cou_name,r.*,cou.cou_id,sum(m.mod_credit_hour) as sumcredit';
    		
    	$this -> db -> select($p, FALSE);
    	$this -> db -> from('student s');
    	$this -> db -> join('college_course cc', 'cc.cc_id=s.cc_id', 'left');
    	$this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
    	$this -> db -> join('course cou', 'cou.cou_id=cc.cou_id', 'left');
    	
    	$this -> db -> join('module_taken mt', 'mt.stu_id=s.stu_id', 'left');
    	$this -> db -> join('module m', 'm.mod_id=mt.mod_id', 'left');
    	$this -> db -> join('grade g', 'g.grade_id=mt.grade_id');
    	$this -> db -> join('result r', 'r.stu_id=s.stu_id', 'left');
    	 
    	if (!empty($col_name))
    	{
    		$this -> db -> where('c.col_name', $col_name);
    	}
    	if (!empty($cou_id))
    	{
    		$this -> db -> where('cc.cou_id', $cou_id);
    	}    	 
    	if (!empty($current_sem))
    	{
    		$this -> db -> where('mt.mt_semester', $current_sem);
    		$this -> db -> where('r.semester_count', $current_sem);
    	}
    	if (!empty($current_year))
    	{
    		$this -> db -> where('mt.mt_year', $current_year);
    		$this -> db -> where('r.current_year', $current_year);
    	}
    	
    	$this -> db -> where('s.stat_id', 1);
    	$this -> db -> group_by('s.stu_id');
    	$this -> db -> order_by("cou.cou_course_code", "asc");
    	$this -> db -> order_by("s.stu_name", "asc");    	
    	
    	$query = $this -> db -> get();
    	
    	if ($query -> num_rows() > 0)
    	{
    		return $query -> result();
    	}
    }	




	/**********************************************************************************************
	* Description		: this function to get student by course
	* 					  
	* input				: 
	* author			: sukor
	* Date				: 09 oktober 2013
	* Modification Log	: -
	**********************************************************************************************/
	function result_fik($col_name, $cou_id, $current_sem, $current_year)
	{		
		$this->db->select('s.stu_name,s.stu_mykad,cou.cou_course_code, s.stu_gender, s.stu_matric_no,
						s.stu_race, s.stat_id, s.stu_religion, s.stu_id, r.pngk, r.pngkk, c.col_name, c.col_code,
						col_type, col_code, c.col_id, cou.cou_id, r.pnga, r.pngka, r.pngv, r.pngkv');
		$this -> db -> from('student s');
		$this -> db -> join('college_course cc', 'cc.cc_id=s.cc_id', 'left');
		$this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
		$this -> db -> join('course cou', 'cou.cou_id=cc.cou_id', 'left');
		$this -> db -> join('result r', 'r.stu_id=s.stu_id', 'left');
		
		if (!empty($current_sem)) {
			$this -> db -> where('r.semester_count', $current_sem);
		}
			$this -> db -> where('r.current_year', $current_year);
			if (!empty($cou_id)) {
			$this -> db -> where('cc.cou_id', $cou_id);
		}
			if (!empty($col_name)) {
			$this -> db -> where('c.col_name', $col_name);
		}
            $this -> db -> order_by('s.stu_name', 'asc');
		
		$q = $this->db->get();
		
		if($q->num_rows() > 0)
		{
			foreach($q->result() as $r)
			{
				$module = $this->fik($r->stu_id,$current_sem,$current_year);
				
				if(!empty($module))
				{
					$r->moduletaken = $module;
				}
				
				$d[] = $r;
			}
			
			return $d;
		}
	}



	/**********************************************************************************************
	 * Description		: this function to display result student
	 * input				: $centrecode
	 * author			: sukor
	 * Date				: 09 oktober 2013
	 * Modification Log	: -
	 **********************************************************************************************/	
	function fik($stu_id,$semester,$year)
	{
		$this->db->select('m.mod_paper, m.mod_name, m.mod_credit_hour, g.grade_type, g.grade_value,
						g.grade_level, mt.mt_semester, mt.mt_year');
		$this -> db -> from('module_taken mt');
		$this -> db -> join('module m', 'm.mod_id=mt.mod_id', 'left');
		$this -> db -> join('grade g', 'g.grade_id=mt.grade_id', 'left');
		
		if (!empty($semester)) {
			$this -> db -> where('mt.mt_semester', $semester);
		}
		
		$this -> db -> where('mt.mt_year', $year);
		$this -> db -> where('mt.mt_status', 1);
		$this -> db -> where('mt.stu_id', $stu_id);
		$this -> db -> order_by('m.mod_paper', 'asc');
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
	 * Description		: this function to coursekv
	 * input				: 
	 * author			: sukor
	 * Date				: 4 11 2013
	 * Modification Log	: -
	 **********************************************************************************************/

	function college_analysis($colid) {
		$this -> db -> select('c.*');
		$this -> db -> from('college c');
		if(!empty($colid)){
		$this->db->where('c.col_id',$colid);	
		}
		    $this -> db -> order_by("c.col_type", "asc");
		 $this -> db -> order_by("c.col_code", "asc");
		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}
	}

/**********************************************************************************************
    * Description       : This function get student data (version 2)
    *                     
    * input             : 
    * author            : Nabihah
    * Date              : 09 oktober 2013
    * Modification Log  : -
    **********************************************************************************************/
    function result_fik_v2($col_name, $cou_id, $current_sem, $current_year)
    {       
        $this->db->select('s.stu_name,s.stu_mykad,cou.cou_course_code, s.stu_gender, s.stu_matric_no,
                        s.stu_race, s.stat_id, s.stu_religion, s.stu_id, r.pngk, r.pngkk, c.col_name, c.col_code,
                        col_type, col_code, c.col_id, cou.cou_id, r.pnga, r.pngka, r.pngv, r.pngkv');
        $this -> db -> from('student s');
        $this -> db -> join('college_course cc', 'cc.cc_id=s.cc_id', 'left');
        $this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
        $this -> db -> join('course cou', 'cou.cou_id=cc.cou_id', 'left');
        $this -> db -> join('result r', 'r.stu_id=s.stu_id', 'left');
        
        if (!empty($current_sem)) 
        {
            $this -> db -> where('r.semester_count', $current_sem);
        }
            $this -> db -> where('r.current_year', $current_year);
            if (!empty($cou_id)) 
        {
            $this -> db -> where('cc.cou_id', $cou_id);
        }
            if (!empty($col_name)) {
            $this -> db -> where('c.col_name', $col_name);
        }
            $this -> db -> order_by('s.stu_name', 'asc');
			$this -> db -> group_by('s.stu_id');
        
        $q = $this->db->get();
        
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $r)
            {
                $module = $this->fik_ak($r->stu_id,$current_sem,$current_year);
                $modulevk = $this->fik_vk($r->stu_id,$current_sem,$current_year);
                
                if(!empty($module))
                {
                    $r->moduletaken_AK = $module;
                }
                
                if(!empty($modulevk))
                {
                    $r->moduletaken_VK = $modulevk;
                }
                
                $d[] = $r;
            }
            
            return $d;
        }
    }

/**********************************************************************************************
     * Description      : this function to display academic modula based on id
     * input            : $centrecode
     * author           : Nabihah 
     * Date             : 21 Februari 2014
     * Modification Log : -
     **********************************************************************************************/    
    function fik_ak($stu_id,$semester,$year)
    {
        $this->db->select('mt.md_id,mt.mod_id,m.mod_paper, m.mod_name, m.mod_credit_hour, g.grade_type, g.grade_value,
                        g.grade_level, mt.mt_semester, mt.mt_year, mt.mt_full_mark');
        $this -> db -> from('module_taken mt');
        $this -> db -> join('module m', 'm.mod_id=mt.mod_id', 'left');
        $this -> db -> join('grade g', 'g.grade_id=mt.grade_id', 'left');
        
        if (!empty($semester)) 
        {
            $this -> db -> where('mt.mt_semester', $semester);
        }
        
        $this -> db -> where('mt.mt_year', $year);
		 $this -> db -> where_not_in('mt.mt_status', 0);
        $this -> db -> where('mt.stu_id', $stu_id);
        $this -> db -> where('m.mod_type', 'AK');
        $this -> db -> order_by('m.mod_paper', 'asc');
        $q = $this->db->get();
        
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $r)
            {
                
                $module = $this->get_mark($stu_id,$semester,$year,$r->md_id);
                $mteori = $this->get_paper2($stu_id,$semester,$year,$r->md_id,$r->mod_id);
                
                if(!empty($module))
                {
                    $r->mark_ass = $module;
                }
                 if(!empty($mteori))
                {
                    $r->mark_teori = $mteori;
                }
                $d[] = $r;
            }
            
  
            return $d;
        }
    }
    
    /**********************************************************************************************
     * Description      : this function to display vokasional module based on student id
     * input            : $centrecode
     * author           : Nabihah 
     * Date             : 21 Februari 2014
     * Modification Log : -
     **********************************************************************************************/    
    function fik_vk($stu_id,$semester,$year)
    {
        $this->db->select('mt.mod_id,mt.md_id,m.mod_paper, m.mod_name, m.mod_credit_hour, g.grade_type, g.grade_value,
                        g.grade_level, mt.mt_semester, mt.mt_year,mt.mt_full_mark');
        $this -> db -> from('module_taken mt');
        $this -> db -> join('module m', 'm.mod_id=mt.mod_id', 'left');
        $this -> db -> join('grade g', 'g.grade_id=mt.grade_id', 'left');
        
        if (!empty($semester)) {
            $this -> db -> where('mt.mt_semester', $semester);
        }
        
        $this -> db -> where('mt.mt_year', $year);
        $this -> db -> where_not_in('mt.mt_status', 0);
        $this -> db -> where('mt.stu_id', $stu_id);
        $this -> db -> where('m.mod_type', 'VK');
        $this -> db -> order_by('m.mod_paper', 'asc');
        $q = $this->db->get();
        
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $r)
            {
                
                $module = $this->get_mark($stu_id,$semester,$year,$r->md_id);
                $mteori = $this->get_mpt($stu_id,$semester,$year,$r->md_id,$r->mod_id);
                
                if(!empty($module))
                {
                    $r->mark_ass = $module;
                }
                
                 if(!empty($mteori))
                {
                    $r->mark_teori = $mteori;
                }
                
                $d[] = $r;
            }
            
            
            return $d;
        }
    }

    
    /**********************************************************************************************
     * Description      : this function to display academic modula based on id
     * input            : $centrecode
     * author           : sukor 
     * Date             : 25 Februari 2014
     * Modification Log : -
     **********************************************************************************************/    
    function get_mark_sub($stu_id,$semester,$year,$mdId)
    {
        $this->db->select('*');
        $this -> db -> from('course_module cm');
        $this -> db -> join('lecturer_assign lc', 'lc.cm_id=cm.cm_id', 'left');
        $this -> db -> join('lecturer_module_configuration lmc', 'lmc.la_id=lc.la_id', 'left');
        $this -> db -> join('lecturer_module_mark lm', 'lm.assgmnt_id=lmc.assgmnt_id', 'left');
        
    
       $this -> db -> where('lc.la_current_year', $year);
      $this -> db -> where('cm.cm_semester', $semester);
      $this -> db -> where('cm.mod_id', $modId);
        $this -> db -> where('lm.stu_id', $stu_id);
        $this -> db -> group_by('lc.la_id', 'asc');
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
     * Description      : this function to display academic modula based on id
     * input            : $centrecode
     * author           : sukor 
     * Date             : 25 Februari 2014
     * Modification Log : -
     **********************************************************************************************/    
    function get_mark($stu_id,$semester,$year,$mdId)
    {
        $this->db->select('*');
        $this -> db -> from('marks m');
       
        
    
  
      $this -> db -> where('m.md_id', $mdId);
      $this -> db -> order_by('m.mark_category', "DESC");
       
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
     * Description      : this function to display academic modula based on id
     * input            : $centrecode
     * author           : sukor 
     * Date             : 25 Februari 2014
     * Modification Log : -
     **********************************************************************************************/    
    function get_teori($stu_id,$semester,$year,$mdId,$modId)
    {
         $this->db->select('lm.*,lmc.*,lc.*');
        $this -> db -> from('course_module cm,module_pt mpt');
        $this -> db -> join('lecturer_assign lc', 'lc.cm_id=cm.cm_id', 'left');
        $this -> db -> join('lecturer_module_configuration lmc', 'lmc.la_id=lc.la_id', 'left');
        $this -> db -> join('lecturer_module_mark lm', 'lm.assgmnt_id=lmc.assgmnt_id', 'left');
       
    
        $this -> db -> where('lc.la_current_year', $year);
        $this -> db -> where('cm.cm_semester', $semester);
        $this -> db -> where('cm.mod_id', $modId);
        $this -> db -> where('lm.stu_id', $stu_id);
 
        $this -> db -> group_by('lm.lmm_id', 'asc');
        $q = $this->db->get();
        
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $r)
            {
                 $mteori = $this->get_mpt($r->pt_id);
                 
                 if(!empty($mteori))
                {
                    $r->teori = $mteori;
                }
                $d[] = $r;
                
                
                
            }
  
            return $d;
        }else{
            
            $d[] = array("tes"=>1);
            return $d;
        }
        
    }

/**********************************************************************************************
     * Description      : this function to display academic modula based on id
     * input            : $centrecode
     * author           : sukor 
     * Date             : 25 Februari 2014
     * Modification Log : -
     **********************************************************************************************/    
    function get_pt($ptId)
    {
        $this->db->select('*');
        $this -> db -> from('module_pt mpt');
 
      $this -> db -> where('mpt.pt_id', $ptId);
     
       
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
     * Description      : this function to display academic modula based on id
     * input            : $centrecode
     * author           : sukor 
     * Date             : 25 Februari 2014
     * Modification Log : -
     **********************************************************************************************/    
    function get_mpt($stu_id,$semester,$year,$mdId,$modId)
    {
         $this->db->select('mpt.*,lm.mark,lmc.assgmnt_name,lmc.assgmnt_total,
         lmc.assgmnt_score_selection');
        $this -> db -> from('module_pt mpt');
        $this -> db -> join('lecturer_module_configuration lmc', 'lmc.pt_id=mpt.pt_id', 'left');
        $this -> db -> join('lecturer_module_mark lm', 'lm.assgmnt_id=lmc.assgmnt_id', 'left');
        $this -> db -> join('lecturer_assign lc', 'lc.la_id=lmc.la_id', 'left');
        $this -> db -> join('course_module cm', 'cm.cm_id=lc.cm_id', 'left');
     
    
        $this -> db -> where('lc.la_current_year', $year);
        $this -> db -> where('cm.cm_semester', $semester);
        $this -> db -> where('cm.mod_id', $modId);
        $this -> db -> where('lm.stu_id', $stu_id);

        $this -> db -> order_by('mpt.pt_category', 'asc');
        $q = $this->db->get();
        
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $r)
            {
              
                $d[] = $r;
  
            }

            return $d;
        }else{
    
            $d = NULL;
 
            return $d;
        }
        
    }
 
        /**********************************************************************************************
     * Description      : this function to display academic modula based on id
     * input            : $centrecode
     * author           : sukor 
     * Date             : 25 Februari 2014
     * Modification Log : -
     **********************************************************************************************/    
    function get_paper2($stu_id,$semester,$year,$mdId,$modId)
    {
         $this->db->select('ppr.*,lm.mark,lmc.assgmnt_name,lmc.assgmnt_total,
         lmc.assgmnt_score_selection');
        $this -> db -> from('module_ppr ppr');
        $this -> db -> join('lecturer_module_configuration lmc', 'lmc.ppr_id=ppr.ppr_id', 'left');
        $this -> db -> join('lecturer_module_mark lm', 'lm.assgmnt_id=lmc.assgmnt_id', 'left');
        $this -> db -> join('lecturer_assign lc', 'lc.la_id=lmc.la_id', 'left');
        $this -> db -> join('course_module cm', 'cm.cm_id=lc.cm_id', 'left');
       
        $this -> db -> where('lc.la_current_year', $year);
        $this -> db -> where('cm.cm_semester', $semester);
        $this -> db -> where('cm.mod_id', $modId);
        $this -> db -> where('lm.stu_id', $stu_id);
 
        $this -> db -> order_by('ppr.ppr_category', 'asc');
        $q = $this->db->get();
        
        if($q->num_rows() > 0)
        {
            foreach($q->result() as $r)
            {
              
                $d[] = $r;
                
                
                
            }
            

            return $d;
        }else{
            
            
            
            $d = NULL;
            return $d;
        }
        
    }


  /**********************************************************************************************
     * Description      : this function to display academic modula based on id
     * input            : $centrecode
     * author           : sukor 
     * Date             : 25 Februari 2014
     * Modification Log : -
     **********************************************************************************************/    
    function get_mark_sub_loop($semester,$year)
    {
        $this->db->select('*');
        $this -> db -> from('module_taken mt');
        $this -> db -> join('marks m', 'm.md_id=mt.md_id', 'left');
        
        //$this -> db -> join('college_course lm', 'lm.assgmnt_id=lmc.assgmnt_id', 'left');
        
    
       $this -> db -> where('mt.mt_year', $year);
      $this -> db -> where('mt.mt_semester', $semester);
      $this -> db -> where('mt.mt_status', 1);
     $this -> db -> where('m.marks_value', 0);
     $this -> db -> where('m.mark_category', "S");
     
     // $this -> db -> where('s.mt_status', 1);
        //$this -> db -> where('s.stu_id', $stu_id);
       $this -> db -> limit('2000');
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
     * Description      : this function to display academic modula based on id
     * input            : $centrecode
     * author           : sukor 
     * Date             : 25 Februari 2014
     * Modification Log : -
     **********************************************************************************************/    
    function get_loop($stu,$md_id)
    {
        $this->db->select('*');
        $this -> db -> from('module_taken mt');
        $this -> db -> join('marks m', 'm.md_id=mt.md_id', 'left');
        
        //$this -> db -> join('college_course lm', 'lm.assgmnt_id=lmc.assgmnt_id', 'left');
        
    
      // $this -> db -> where('mt.mt_year', $year);
     // $this -> db -> where('mt.mt_semester', $semester);
      $this -> db -> where('mt.mt_status', 1);
    $this -> db -> where('m.md_id',$md_id);
      $this -> db -> where('mt.stu_id',$stu);
        //$this -> db -> where('s.stu_id', $stu_id);
     //   $this -> db -> group_by('lc.la_id', 'asc');
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
    
    

}
?>
