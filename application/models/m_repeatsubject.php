<?php

/**************************************************************************************************
 * File Name        : m_repeatsubject.php
 * Description      : This File contain Report module.
 * Author           : sukor
 * Date             : 25 july 2013 
 * Version          : -
 * Modification Log : -
 * Function List       : __construct(),
 **************************************************************************************************/

class M_repeatsubject extends CI_Model {


/**********************************************************************************************
     * Description      : this function to display fin
     * input                : 
     * author           : sukor
     * Date             : 25 july 2013
     * Modification Log : umairah - where VK subjek, umairah - 15 may 2014 - select only fail student only
**********************************************************************************************/ 
    
    function list_repeatsub_ajax() {
      
    	$arr_d = array();
        $sOrder = "";
    
    	$dt_search = $_POST['search'];  
        //$dt_search = 'KV MELAKA TENGAH ||1|';
    
        $search=explode("|", $dt_search);
        $col_name= $search[0];
        $cou_id = $search[1];
        $current_sem= $search[2];
        $current_year = $search[3];
        $matrix = $search[4];
        //$mt_semester = "";
        //$col_name="KV MELAKA TENGAH";
        //$cou_id = 2;
        //$current_sem= 1;
        //$current_year = "2013";

        /* Ordering 
        if (isset($_POST['iSortCol_0'])) {
            $sOrder = "ORDER BY ";
            for ($i = 0; $i < ($_POST['iSortingCols'] ); $i++) {
                $this->db->order_by($this->pfnColumnToField($_POST['iSortCol_' . $i]), $_POST['sSortDir_' . $i]);
            }
        }
		*/		
		
        /* function get_mt_semester($current_sem){
        		
        	$this->db->select('mt.*,s.*');
        	$this->db->from('studdent s , module_taken mt');
        	$this->db->where('s.stu_id = mt.stu_id');
        	$this->db->where('s.stu_current_sem', $current_sem);
        	$this->db->where('mt.mt_status',2);
        		
        	$query = $this->db->get();
        		
        	if ($query->num_rows() > 0)
        	{
        		return $query->row();
        	}
        		
        		
        }*/
      
        
       // $mt_semester= $this->get_mt_semester($current_sem);
        
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

       //matching sem biasa dengan sem yang boleh mengulang
         if($current_sem == 3)
       {      	
       		$am = 1;
       }
       elseif ($current_sem == 4)	
       {
       		$am = 2;
       }
       elseif ($current_sem == 5)
       {
       		$am = 1;
       		$am = 3;
       }
       elseif ($current_sem == 6)
       {
       		$am = 2;
       		$am = 4;
       		
       }   
       
       
       
       
       
       /*$this->db->select('mt.*,s.*');
       	$this->db->from('student s , module_taken mt');
       	$this->db->where('s.stu_id = mt.stu_id');
       	$this->db->where('s.stu_current_sem', $current_sem);
       	$this->db->where('mt.mt_status',2);    	
       	$query = $this->db->get();
        $ak = $query->row()->mt_semester;*/	
       	
       	$p ='s.*,c.*,cou.*,cou.cou_course_code';
   	 
        $this -> db -> select($p, FALSE);
        $this -> db -> from('student s');
        $this -> db -> join('college_course cc', 'cc.cc_id=s.cc_id', 'left');
        $this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
        $this -> db -> join('course cou', 'cou.cou_id=cc.cou_id', 'left');
        $this -> db -> join('module_taken mt', "s.stu_id=mt.stu_id ", 'left');   
             
        $arr_sem = array(1,2);  
        $this->db->where_not_in('s.stu_current_sem', $arr_sem);
        
        $this->db->where('mt.mt_semester = 1');
        $this->db->where_not_in('mt.mt_semester = 2');
        
        $sqle='(mt.grade_id < 5 OR (mt.grade_id >= 12 AND mt.grade_id <= 16))';
        $this -> db -> where($sqle);
        
        
        if (!empty($col_name)) {
            $this -> db -> where('c.col_name', $col_name);
        }
        if (!empty($cou_id)) {
            $this -> db -> where('cc.cou_id', $cou_id);
        }
        
        if (!empty($current_sem)) {
            $this->db->where('s.stu_current_sem', $current_sem);
            $this -> db -> where_in('mt.mt_semester',$am);
            //$this -> db -> where('mt.mt_status',2);
        }
        if (!empty($current_year)) {
            $this -> db -> where('s.stu_current_year', $current_year);
        }
        if (!empty($matrix)) {
            $this -> db -> where('s.stu_matric_no', $matrix);
        }
		
	
        //   $sqle='(mt.grade_id < 5 OR (mt.grade_id >= 12 AND mt.grade_id <= 16))';
            
            
       //   $this -> db -> where($sqle);
        
        
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
                
                $arr_d["aaData"][] = array(
               "<center><input type='hidden' name='".$st->cou_course_code."[]' value='".$bil."' >". $bil."</center>",
              "<span>".ucwords(strtolower($st->stu_name))."</span>" ,
                   "<span>".$st->stu_mykad."</span>" ,
                   "<span>". $st->stu_matric_no."</span>" ,
                    "<span>". $st->cou_course_code."</span>" ,
                     "<span><center>". $st->stu_current_sem."</center></span>" ,
                      "<span><div align='center'><a data-placement='bottom' data-original-title='Daftar' class='btn btn-edit-custom btn-mini btn-rounded' href='".site_url('student/repeat_subject/reg_repeat_subject/'.$st->stu_id)."'><i class='icon-ok icon-white'></i></a></div></span>");  
                     
                      
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
* Description       : this function to state
* input             : 
* author            : sukor
* Date              : 25 july 2013
* Modification Log  : -
**********************************************************************************************/

    function get_student_repeat($stuid,$status) {
        
        $q='m.mod_name,m.mod_code,m.mod_paper,m.mod_credit_hour,mt.mt_semester,mt.mt_year
        ,mt.mt_full_mark,g.grade_type,m.mod_id,mt.md_id,s.stu_id';
        $this -> db -> select($q, FALSE);
        $this -> db -> from('student s');
        $this -> db -> join('module_taken mt', 'mt.stu_id=s.stu_id', 'left');
        $this -> db -> join('module m', 'm.mod_id=mt.mod_id', 'left');
        $this -> db -> join('grade g', 'g.grade_id=mt.grade_id', 'left');
        $this -> db -> where('s.stu_id',$stuid);
        if($status=='fail'){
          //  $this -> db -> where('m.mod_type',"AK");
            $this -> db -> where('mt.grade_id is not null');
            $this -> db -> where('mt.mt_full_mark <',50);
            $this -> db -> where('mt.exam_status',1);
        }elseif($status=='repeat'){
          //  $this -> db -> where('m.mod_type',"AK");
            $this -> db -> where('mt.exam_status',2);
        }
            
        $query = $this -> db -> get();

        if ($query -> num_rows() > 0) {
            return $query -> result();
        }
    }
     
     
     /**********************************************************************************************
* Description       : this function to state
* input             : 
* author            : sukor
* Date              : 25 july 2013
* Modification Log  : -
**********************************************************************************************/

    function get_student($stuid) {
        
        $q='s.*,cou.cou_name,c.col_name,cou.cou_id,c.col_id';
        $this -> db -> select($q, FALSE);
        $this -> db -> from('student s');
        $this -> db -> join('college_course cc', 'cc.cc_id=s.cc_id', 'left');
        $this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
        $this -> db -> join('course cou', 'cou.cou_id=cc.cou_id', 'left');
        $this -> db -> where('s.stu_id',$stuid);
        
        $query = $this -> db -> get();

        if ($query -> num_rows() > 0) {
            return $query -> result();
        }
    }
     /**********************************************************************************************
* Description       : this function to state
* input             : 
* author            : sukor
* Date              : 26 july 2013
* Modification Log  : -
**********************************************************************************************/

    function check_exist_subject($subject_id,$add_semester,$add_year,$stu_id) {
        
        $q='mt.md_id';
        $this -> db -> select($q, FALSE);
        $this -> db -> from('module_taken mt');
        $this -> db -> where('mod_id',$subject_id);
        $this -> db -> where('mt_semester',$add_semester);
        $this -> db -> where('mt_year',$add_year);
        $this -> db -> where('stu_id',$stu_id);
        $this -> db -> where('exam_status',2);
        $query = $this -> db -> get();

        if ($query -> num_rows() > 0) {
            return $query -> result();
        }
    }    
     
         /**********************************************************************************************
* Description       : this function to state
* input             : 
* author            : sukor
* Date              : 26 july 2013
* Modification Log  : -
**********************************************************************************************/

    function make_studet($ccId) {
        
       $q='s.*,cou.cou_name,c.col_name,cou.cou_id';
        $this -> db -> select($q, FALSE);
        $this -> db -> from('student s');
        $this -> db -> join('college_course cc', 'cc.cc_id=s.cc_id', 'left');
        $this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
        $this -> db -> join('course cou', 'cou.cou_id=cc.cou_id', 'left');
        
        $this -> db -> where('s.cc_id',$ccId);
        
        $query = $this -> db -> get();

        if ($query -> num_rows() > 0) {
            return $query -> result();
        }
    }
    
    
    function getmodule($cou,$sem) {
        
       $q='m.*';
        $this -> db -> select($q, FALSE);
            $this -> db -> from('course_module cm');
        $this -> db -> join('module m', 'm.mod_id=cm.mod_id', 'left');
        $this -> db -> where('cm.cou_id',$cou);
        $this -> db -> where('cm.cm_semester',$sem);
        $query = $this -> db -> get();

        if ($query -> num_rows() > 0) {
            return $query -> result();
        }
    }
    



function get_colname($colid) {
        
        $q='c.col_name';
        $this -> db -> select($q, FALSE);
        $this -> db -> from('college c');
        $this -> db -> where('c.col_id',$colid);
        
        $query = $this -> db -> get();

        if ($query -> num_rows() > 0) {
            return $query -> result();
        }
        
}   

function get_marks($mdId) {
        
        $q='m.*';
        $this -> db -> select($q, FALSE);
        $this -> db -> from('marks m');
        $this -> db -> where('m.md_id',$mdId);
        
        $query = $this -> db -> get();

        if ($query -> num_rows() > 0) {
            return $query -> result();
        }
    }


   
	
	
	/**********************************************************************************************
* Description       : this function to state
* input             : 
* author            : sukor
* Date              : 25 july 2013
* Modification Log  : -
**********************************************************************************************/

    function get_modulecan($stuid,$semc,$couID) {
        //$q='m.mod_name,m.mod_code,m.mod_paper,m.mod_credit_hour,mt.mt_semester,mt.mt_year
       
      if(!empty($semc)){
        $this -> db -> select('*', FALSE);
        $this -> db -> from('module_taken mt');
        $this -> db -> join('course_module cm', "cm.mod_id=mt.mod_id and cm.cou_id=$couID", 'left');
        $this -> db -> join('module m', 'm.mod_id=mt.mod_id', 'left');
        
	
        $this -> db -> where('mt.stu_id',$stuid);
		$this -> db -> where_in('cm.cm_semester',$semc);
      
          $this -> db -> where('mt.mt_full_mark <',50);
            $this -> db -> where('mt.exam_status',1);
			   
        $query = $this -> db -> get();

        if ($query -> num_rows() > 0) {
            return $query -> result();
        }
	  }else{
	  	 return 0;
		
	  }
    
    }
     
	


    }
/**************************************************************************************************
 * End of Repeat_subject.php
 **************************************************************************************************/
?>