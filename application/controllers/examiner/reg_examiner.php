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
	 
class Reg_examiner extends MY_Controller {
	 	
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
    function daftar_pemeriksa() {
    	
    	
    	$data['state'] = $this->m_reg_examiner->get_state();
    	$data['level'] = $this->m_reg_examiner->get_level();
    	
        $data['output'] = $this->load->view('examiner/v_examiner_register', $data, true);
        $this->load->view('main', $data);
               
    }
        
    //assign pemeriksa kepada kv
    function assign_pemeriksa() {
    	
    	$data['kv'] = $this->m_reg_examiner->get_kv_list();
    	$data['pemeriksa'] = $this->m_reg_examiner->get_pemeriksa();
    	$data['details_pemeriksa'] = $this->m_reg_examiner->get_detail_pemeriksa();
        	 
        $data['output'] = $this->load->view('examiner/v_assign_college', $data, true);
        $this->load->view('main', $data);
        	 
    } 

    function get_detail_examiner() {    	 
    	
    	$data['details_pemeriksa'] = $this->m_reg_examiner->get_detail_pemeriksa();
    	echo json_encode($data);
    
    }

    function assign_kv(){
    	
    	
    	$sesi = $this->session->userdata["sesi"]. " / " .$this->session->userdata["tahun"];
    	
    	$pemeriksa = $this->input->post('pemeriksa');
    	$kolej = $this->input->post('kolej');
 	  	
    	$examiner1 = $this->m_reg_examiner->add_id_examiner($pemeriksa);
    	$examiner2 = $examiner1[0]->user_id; 
    	
    	$kolej1 = $this->m_reg_examiner->add_id_kolej($kolej);
 	  	$kolej2 = $kolej1[0]->col_id;
 	  
 	  	//print_r($data['details_pemeriksa']);
 	  //	die();
 	  	
 	  	$exam_reg = array();
 	  	
 	  	foreach ($kolej1 as $row)
 	  	{
    		$data = array(
    				
    				'user_id'=>$examiner2,
    				'col_id'=>$row->col_id,	
    				'exam_session' => $sesi,
    		);
    		
    		array_push($exam_reg,$data);
 	  	}
 	  	
    		$this->m_reg_examiner->insert_examiner($exam_reg);   		
    	
    		echo json_encode($exam_reg);
    		
    		
    	
    }
    
   
       
    }
	