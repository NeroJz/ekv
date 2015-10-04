<?php
/**************************************************************************************************
 * File Name        : confirmation.php
 * Description      : This File contain Form module.
 * Author           : fakhruz
 * Date             : 1 Oktober 2013
 * Version          : -
 * Modification Log : -
 * Function List	   : __construct(),
 **************************************************************************************************/
class Confirmation extends MY_Controller {

	function __construct() {
		parent::__construct();

		$this -> load -> model('m_form','mf');
		$this -> load -> model('m_report');
	}
	
	
/**********************************************************************************************
 * Description		: this function to confirm student information
 * input			: 
 * author			: fakhruz
 * Date				: 02 October 2013
 * Modification Log	: -
**********************************************************************************************/

	function student_information() {
        $user_login = $this->ion_auth->user()->row();
		$colid = $user_login->col_id;
		$userId = $user_login->user_id;
		$state_id= $user_login->state_id;

		  $user_groups = $this->ion_auth->get_users_groups($userId)->row();  
		  $ul_type= $user_groups->ul_type;
		
		if($ul_type=="KV"){
			$col=get_user_collegehelp($userId);
			$data['colname']=$col[0]->col_name.'-'.$colid;
		}
		
		if($ul_type=="JPN"){
			$data['centrecode'] = $this -> mf -> get_institusi($state_id);
		}else{
			$data['centrecode'] = $this -> mf -> get_institusi();
		}
		
		
		
		$data['year'] = $this -> mf -> list_year_mt();
		//$data['courses'] = $this -> mf -> list_course();
		$data['courses'] = $this -> mf -> list_course_byCol($colid);
		//$data['state'] = $this -> m_report -> list_state();

		$centreCode = $this -> input -> post('kodpusat');
		$year = $this -> input -> post('mt_year');
		$course = $this -> input -> post('slct_kursus');
		$semester = $this -> input -> post('semester');
        $status = $this -> input -> post('status');
		
		 $cC=explode("-", $centreCode); 
		 
		//print_r($_POST); FDP
		 
		$data['search'] = $cC[0]."|".$course."|".$semester."|".$year."|".$status;



		$data['output'] = $this -> load -> view('form/v_register_confirm', $data, true);
		$this -> load -> view('main', $data);
	}

	function print_student_information()
	{
		$centreCode = $this -> input -> post('kodpusat');
		$year = $this -> input -> post('mt_year');
		$course = $this -> input -> post('slct_kursus');
		$semester = $this -> input -> post('semester');
        $status = $this -> input -> post('status');
		$cC=explode("-", $centreCode); 
		
		$search = $cC[0]."|".$course."|".$semester."|".$year."|".$status;
		
		$listStudent = $this->mf->list_student_confirm($search);
		
		$data["search"] = $search;
		$data["student"] = $listStudent;
		
		$this->load->view('form/v_print_student_information', $data, '');
	}

}
	
?>