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
	 
class divide_student extends MY_Controller {
	 	
	/**********************************************************************************************
	* Description		: Constructor = load model
	* input				: -
	* author			: siti umairah
	* Date				: 24 october 2013
	* Modification Log	: -
	**********************************************************************************************/
    function __construct() {
    	
    	parent::__construct();
        $this->load->model('m_class');
	}
	
    
	/**********************************************************************************************
	* Description		: Constructor = load model
	* input				: -
	* author			: siti umairah
	* Date				: 24 october 2013
	* Modification Log	: -
	**********************************************************************************************/
    function groupbycourse() {
    	
        if (isset($_POST['submit']) && $_POST['submit'] != '') 
        {
            $course_id = $_POST['cou_id'];
            $semester = $_POST['semester'];
			$session = $_POST['session'];
            $method = $_POST['method'];
            $max = $_POST['max'];
			

            if ($method == 'kelas') 
            {
                $this->m_class->create_group($course_id, $semester, $max, $session);
            } 
            else 
            {
                $this->m_class->create_group_by_students($course_id, $semester, $max, $session);
            }
				
				$user_login = $this->ion_auth->user()->row();
				$col_id = $user_login->col_id;
				$course_id = $this->input->post('cou_id');
				$semester = $this->input->post('semester');

	            $data['course_list'] = $this->m_class->get_student_by_course($col_id,$course_id,$semester);
	            $data['output'] = $this->load->view('class/v_divide_student_by_class', $data, true);
	            $this->load->view('main', $data);
        	} 
        	else 
        	{
        		$user_login = $this->ion_auth->user()->row();
				$col_id = $user_login->col_id;
				$course_id = $this->input->post('cou_id');
				$semester = $this->input->post('semester');
					
	            $data['headline'] = 'Pembahagian Kelas';
	            $data['course_list'] = $this->m_class->get_course($col_id);
	          	$data['year'] = $this->m_class->get_year();	          	
	            $data['output'] = $this->load->view('class/v_divide_student_by_class', $data, true);
	            $this->load->view('main', $data);
	            	           
        }
    }
	

    /**********************************************************************************************
    * Description		: this function is to create new group for student and create new group for
    * 					  student yang tiada kelas
    * input				: -
    * author			: siti umairah
    * Date				: 26 october 2013
    * Modification Log	: -
    **********************************************************************************************/
    function create_new_group()
    
    {
    	$course_id = $_POST['course_id'];
    	$semester = $_POST['semester'];
    //	$year = $_POST['year'];
    	$bilClass = $_POST['class'];
    	$totalGroup = $_POST['totalStudent'];
    	$total_kelas = 0;
    	$method = $_POST['method'];
    	//print_r($bilClass);
    	//die();
    
    	/*echo('<pre>');print_r($course_id);echo('</pre>');
    	echo('<pre>');print_r($semester);echo('</pre>');
    	//echo('<pre>');print_r($session);echo('</pre>');
    	echo('<pre>');print_r($method);echo('</pre>');
    	//echo('<pre>');print_r($max);echo('</pre>');
    	//echo('<pre>');print_r($year);echo('</pre>');
    	echo('<pre>');print_r($bilClass);echo('</pre>');
    	echo('<pre>');print_r($totalGroup);echo('</pre>');
    	//echo('<pre>');print_r($bilClass);echo('</pre>');
    	//die();*/
    	
    	if ($method == 'kelas')
    	{
    		list($total_kelas,$str) = explode(' ', $bilClass);
    		//list($totalGroup,$str) = explode(' ', $bilClass);
    		//print_r($total_kelas);
    		//die();
    		$this->m_class->create_group($course_id,$semester,$total_kelas);
    		echo 1;
    	}
    	else
    	{
    		$max = $_POST['max'];
    		
    		if($max > $totalGroup)
    		{
    			echo 0;
    			
    		}
    		else
    		{
    			//echo('<pre>');print_r($max);echo('</pre>');
    			//die();
    			$this->m_class->create_group_by_students($course_id,$semester,$max,$totalGroup);
    			echo 1;
    		}
    	}
    	
    	
    	

    	 
    }
    	 

    /**********************************************************************************************
    * Description		: this function is to check total number of student in course,semester,year 
    * 					  and to check total number of class and total number of student does not 
    * 					  have class
    * input				: -
    * author			: siti umairah
    * Date				: 01 november 2013
    * Modification Log	: -
    **********************************************************************************************/
    //JSON responder
    function coursegroupstatus() 
    {
    	$sesi = $this->session->userdata["sesi"]. " " .$this->session->userdata["tahun"];
        $course_id = $this->uri->segment(4);
        $semester = $this->uri->segment(5);
      //  $year = $this->uri->segment(6);
        
        $user_login = $this->ion_auth->user()->row();
        $col_id = $user_login->col_id;
     
		$cc_id = $this->m_class->get_cc_id($course_id);
        $totalStudent = $this->m_class->get_all_student_by_course($cc_id, $semester);
        $nullGroup = $this->m_class->get_null_student_group($cc_id, $semester);
        $maxClass = $this->m_class->get_max_class($cc_id, $semester);
        $stuClass = $this->m_class->get_stu_class($cc_id, $semester, $col_id);
        $list_student = $this->m_class->get_list_student($cc_id, $semester); 
        //print_r($list_student);
       // die();
       	$arr = array('totalStudent' => $totalStudent, 'nullGroup' => $nullGroup, 'maxClass' => $maxClass, 'stuClass' => $stuClass);
       	echo json_encode($arr);
    }

    
    /**********************************************************************************************
    * Description		: this function is to update class for student by course, semester and year
    * input				: -
    * author			: siti umairah
    * Date				: 31 october 2013
    * Modification Log	: -
    **********************************************************************************************/
	 // JSON responder
    function changeclass() 
    {
      
    	$stu_id = $this->uri->segment(4);
    	$stu_group = $this->uri->segment(5);    	
    	$status = $this->m_class->update_student_group($stu_id,$stu_group);
		
    }	
    
    
    /**********************************************************************************************
    * Description		: this function is to get student from class by course, semester and year
    * input				: -
    * author			: siti umairah
    * Date				: 31 october 2013
    * Modification Log	: -
    **********************************************************************************************/
    function changeClassView()
    {
    	//$sesi = $this->session->userdata["sesi"]. " " .$this->session->userdata["tahun"];
    	$user_login = $this->ion_auth->user()->row();
		$col_id = $user_login->col_id;				

		if (isset($_POST['submit']) && $_POST['submit'] != '') 
				
		{
				
			$course_id = $this->input->post('course_id');
			$semester = $this->input->post('semester');
			//$year = $this->input->post('year');					
			$cc_id = $this->m_class->get_cc_id($course_id);
			
			//if($course_id == "" && $semester == "" && $year == "" && $cc_id == "")
			//{
				
				$data['student_data'] = $this->m_class->get_student_information($cc_id,$semester,$col_id);
				$data['max']= $this->m_class->get_classes($cc_id, $semester,$col_id);
				//print_r($data['student_data']);
				//die();
				
			//}
			//else
			//{
				
			//	$data['student_data'] = NULL;
			//	$data['max'] = NULL;
				
			//}
			
					
		}
					
	       $data['headline'] = 'Pembahagian Kelas';
	       $data['course_list'] = $this->m_class->get_course($col_id);
	       
	       $data['year'] = $this->m_class->get_year();	       	
	       $data['output'] = $this->load->view('class/v_change_class', $data, true);
	       $this->load->view('main', $data);    	
    	
    }
	
    
    
    /**********************************************************************************************
     * Description		: this function is to manage class . first load display list of all class
    * input				: -
    * author			: siti umairah
    * Date				: 08 november 2013
    * Modification Log	: -
    **********************************************************************************************/
    function manage_class()
    {

    		$user_login = $this->ion_auth->user()->row();
    		$col_id = $user_login->col_id;
    		
	    	$course_id = $this->input->post('course_id');
	    	$semester = $this->input->post('semester');
	    	//$year = $this->input->post('year');
	    		
	    	$cc_id = $this->m_class->get_cc_id($course_id);
	    	$data['course_list'] = $this->m_class->get_course($col_id);

	    	
	    	
	    	//$data['year'] = $this->m_class->get_year_add_class();
		   	$data['class_data'] = $this->m_class->get_class_information($col_id);
		   	
		   	/**FDPO - Safe to be deleted**/
		   //	echo('<pre>');print_r($data);echo('</pre>');
		   //	die();
		   	
		   	
	       	$data['output'] = $this->load->view('class/v_manage_class', $data, true);
	       	$this->load->view('main', $data);    	
    	
    }
 
    
    /**********************************************************************************************
     * Description		: this function is to get class information after success add new class
    * input				: -
    * author			: siti umairah
    * Date				: 08 november 2013
    * Modification Log	: -
    **********************************************************************************************/
    function get_class()
    {
    	
    	$user_login = $this->ion_auth->user()->row();
    	$col_id = $user_login->col_id; 	
    	$data['class_data'] = $this->m_class->get_class_information($col_id); 	
    	
    	$this->load->view('class/v_manage_class_ajax', $data);
    	  	
    	 
    }
    
    
    
    
    /**********************************************************************************************
     * Description		: this function is to insert new class into database
    * input				: -
    * author			: siti umairah
    * Date				: 08 november 2013
    * Modification Log	: -
    **********************************************************************************************/
    function insert_class()
    {
    	
    	$sesi = $this->session->userdata["sesi"]. " " .$this->session->userdata["tahun"];
    	$user_login = $this->ion_auth->user()->row();
    	$col_id = $user_login->col_id;
    		
	    $course_id = $this->input->post('course_id');
	    $semester = $this->input->post('semester');
	   // $year = $this->input->post('year');
	    $class_name = $this->input->post('class_name');
	    
	    $cc_id = $this->m_class->get_cc_id($course_id);
	    	
	    $check = $this->m_class->check_class_name($class_name,$col_id,$course_id,$semester);
	    	
	    if($check != 1)
	    {
	    
	    	$data = array(
	    			
	    			'cc_id'=>$cc_id,
	    			'class_sem'=>$semester,
	    			'class_session' =>$sesi,
	    			'class_name' =>$class_name
	    			
	    			
	    			
	    	);
			
	    	/**FDPO - Safe to be deleted**/
	    	//echo('<pre>');print_r($data);echo('</pre>');
	    	//die();
	    	
	    	$this->m_class->insert_class($data);
	    	echo 0;
	    	}
	    	else
	    	{
	    		echo 1;
	    		
	    	}
	    	//$data['course_list'] = $this->m_class->get_course($col_id);
	    	//$data['class_data'] = $this->m_class->get_class_information();
	    	//$data['output'] = $this->load->view('class/v_manage_class', $data, true);
	    	//$this->load->view('main', $data);
    	
    }
    
    
    
    /**********************************************************************************************
     * Description		: this function is to edit class name
    * input				: -
    * author			: siti umairah
    * Date				: 11 november 2013
    * Modification Log	: - modification log 13 november 2013
    **********************************************************************************************/
    function edit_class()
    {
    	$user_login = $this->ion_auth->user()->row();
    	$col_id = $user_login->col_id;
    	//$course_id =  $this->m_class->get_cc_id($course_id);
    	$cou_id = $this->input->post('cou_id');
    	$class_id = $this->input->post('class_id');
    	$class_name = $this->input->post('class_name');
    	$semester = $this->input->post('sem');
    	//$cc_id = $this->m_class->get_cc_id($course_id);
    	
    	
    	$check = $this->m_class->check_class_name($class_name,$col_id,$cou_id,$semester);
    	
    	if($check != 1)
    	{
	    	$data = array(
	    			'class_id' =>$class_id,
	    			'class_name' =>$class_name
	    	);
	    	
	    	$this->m_class->edit_class($data);
	    	echo 0;
    	}
    	else
    	{
    		
    		echo 1;
    		
    	}
    	
    	
    	
    }
    
    
    /**********************************************************************************************
     * Description		: this function is to delete class
    * input				: -
    * author			: siti umairah
    * Date				: 11 november 2013
    * Modification Log	: -
    **********************************************************************************************/
    function delete_kelas()
    {
    	$class_id = $this->input->post('class_id');
    
    	$check = $this->m_class->check_kelas($class_id);
    	
    	if($check == 0)
    	{
    		
    		echo($this->m_class->delete_kelas($class_id));
    		
    	}
    	else
    	{
    		
    		echo 0;
    		
    	}
    	//echo($this->m_class->delete_kelas($class_id));
    	/**FDPO - Safe to be deleted**/
    	//echo('<pre>');print_r($check);echo('</pre>');
    	//die();
    
    }
    
    
    
   /* function bahagi_lebih_number()
    {
    	$course_id = $this->uri->segment(4);
    	$semester = $this->uri->segment(5);
    	$max = $this->input->post('max');
    	
    	$cc_id = $this->m_class->get_cc_id($course_id);
    	$totalStudent = $this->m_class->get_all_student_by_course($cc_id, $semester);
    	
    	$jumlah = $max/$totalStudent;
    	$arr = array('jumlah' => $jumlah);
    	echo json_encode($arr);
    }*/
    
    
}

/**************************************************************************************************
 * End of divide_student.php
**************************************************************************************************/
?>