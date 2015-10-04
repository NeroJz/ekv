<?php
/**************************************************************************************************
* File Name        : Student_ticket.php
* Description      : This is old file on 2012, some fucntion don't have function header. 
*					 This File will display for student result and related with pemarkahan module.
* Author           : sukor
* Date             : 20 june 2013
* Version          : 0.1
* Modification Log :
* Function List	   : 				 
**************************************************************************************************/

class Student_ticket extends MY_Controller
{	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('m_result');
		$this->load->model('m_ticket');
	}
	function index() 
	{
		
		$user_login = $this->ion_auth->user()->row();
        $centreCode = $user_login->col_id;
        $userId = $user_login->user_id;
        $state_id= $user_login->state_id;
    
          $user_groups = $this->ion_auth->get_users_groups($userId)->row();  
          $ul_type= $user_groups->ul_type;
          
        if($ul_type=="KV"){
            $col=get_user_collegehelp($userId);
            $data['colname']=$col[0]->col_name.'-'.$col[0]->col_type.''.$col[0]->col_code;
        }
            if($ul_type=="JPN"){
            $data['centrecode'] = $this -> m_result -> get_institusi($state_id);
        }else{
            $data['centrecode'] = $this -> m_result -> get_institusi();
        }
		$data['year'] =$this->m_result->list_year_mt();
        $data['output'] = $this->load->view('ticket/v_ticket_hall', $data, true);
		$this->load->view('main', $data);
	}
	
	function papar_ticket()
	{
		
	    $centreCode = $this->input->post('kodpusat');
		$semester = $this->input->post('semester');
		$year = $this->input->post('mt_year');
		$course = $this->input->post('slct_kursus');
		$student = $this->input->post('angka_giliran');	
		
		$cC=explode("-", $centreCode);
		$data['ticket'] = $this->m_ticket->student_ticket($cC[0],$course,$year,$semester,$student);

		if(empty($student) && empty($semester)){
	$this->index();
}else{
	
	$this->load->view('ticket/v_cetak_ticket', $data, '');
}
		
		
	
		
	}
	
	
	
	
	
	
}// end of class
/**************************************************************************************************
* End of student-ticket.php
**************************************************************************************************/
?>