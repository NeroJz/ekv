<?php

/**************************************************************************************************
* File Name        : divide_student.php
* Description      : This File contain divide student by course, sem, and year 
* 					 and change student class
* Author           : siti umairah
* Date             : 24 october 2013 
* Version          : -
* Modification Log : -
* Function List	   : __construct(), groupbycourse(), create_new_group(), coursegroupstatus(), 
* 					 changeclass(), changeClassView()
**************************************************************************************************/   
	 
class Modul_examiner extends MY_Controller {
	 	
	/**********************************************************************************************
	* Description		: Constructor = load model
	* input				: -
	* author			: siti umairah
	* Date				: 24 october 2013
	* Modification Log	: -
	**********************************************************************************************/
    function __construct() {
    	
    	parent::__construct();
        $this->load->model('m_reg_examiner');
	}
	
    
	/**********************************************************************************************
	* Description		: Constructor = load model
	* input				: -
	* author			: siti umairah
	* Date				: 24 october 2013
	* Modification Log	: -
	**********************************************************************************************/
    function check_modul() {   
    	
    	$data['kolej_list'] = $this->m_reg_examiner->get_college();    	 
        $data['output'] = $this->load->view('examiner/v_modul_examiner', $data, true);
        $this->load->view('main', $data);
    	  
    }
    
    function course_list()
    {
    	$kolej = $this->input->post('kolej1');   
    	$data['course_list'] = $this->m_reg_examiner->get_course($kolej);    	
    	
    	echo json_encode($data);
    }
    
    
   function modul_list()
    {
    	    	
    	$course = $this->input->post('course1');   
    	$data['modul'] = $this->m_reg_examiner->get_modul($course);
    	
    	echo json_encode($data);
   	    	
    }
        
    
    function student_data()
    {       	 
    	$kolej = $this->input->post('kolej1');
    	$course = $this->input->post('course1');
    	$modul = $this->input->post('modul1');
   
    	$cc_id = $this->m_reg_examiner->get_cc_id($course);
    	$course_id = $this->m_reg_examiner->get_cou_id($kolej,$course);
    	$course_id2 = $course_id[0]->cou_id;
    	
    	$data['student_data'] = $this->m_reg_examiner->get_modul_information($course,$modul);
    	
    	echo json_encode($data);
    	
    }
    
    
    
    function save_gred() 
    {   	
    	
    	$grade_id = $this->input->post('grade_id'); 
    	$stu_id = $this->input->post('stu_id1');
    	$this->m_reg_examiner->save_gred_modul($stu_id,$grade_id);
    
    	
    }
    
    
 /*   function semak_modul(){
    	
    	
    	$user_login = $this->ion_auth->user()->row();
    	$col_id = $user_login->col_id;
    	
    	
    		$course = $this->input->post('course');
    		$modul = $this->input->post('modul');
    		
    		//print_r($course);
    		//print_r($modul);
    		//$cc_id = $this->m_class->get_cc_id($course_id);
    		//echo $year;
    		//die();
    		$data['modul_data'] = $this->m_reg_examiner->get_modul_information($course,$modul);
    		//print_r($data['modul_data']);		
    	
    		echo json_encode($data);
    }*/

}