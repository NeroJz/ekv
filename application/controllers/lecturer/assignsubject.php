<?php

/**************************************************************************************************
* File Name        : assignsubject.php
* Description      : This File contain assignation subject.
* Author           : Nabihah Ab.Karim
* Date             : 03 Julai 2013 
* Version          : -
* Modification Log : -
* Function List	   : __construct(), index()
**************************************************************************************************/   

	class Assignsubject extends MY_Controller
	{
		/******************************************************************************************
		* Description		: Constructor = load model
		* input				: - 
		* author			: Nabihah Ab.Karim
		* Date				: 3 Julai 2013
		* Modification Log	: -
		******************************************************************************************/
		function __construct() 
		{
			parent::__construct();
			$this->load->model('m_assignsubject','ma');
		}
		
		
		/******************************************************************************************
		* Description		: Index.
		* input				: - 
		* author			: Nabihah Ab.Karim
		* Date				: 03 July 2013
		* Modification Log	: 10/10/2013
		******************************************************************************************/
		function index() 
		{
			$col = $this->ma->get_college_id($this->session->userdata('user_id'));	
			//echo $col->col_id;
			//print_r($col);
			//echo $this->session->userdata('user_id');
			//die();
			$data['course'] = $this->ma->course_list_user($col->col_id);
			$data['college'] = $this->ma->code_college();
			$data['title'] = "Pembahagian Modul Kepada Pensyarah";
			$data['output'] = $this->load->view('lecturer/v_assignsubject',$data,TRUE);
			$this -> load -> view('main.php', $data, '');
		}
		
		/******************************************************************************************
		* Description		: Json Responder.
		* input				: - 
		* author			: Nabihah Ab.Karim
		* Date				: 07 July 2013
		* Modification Log	: -
		******************************************************************************************/
		
		
    	function subject_list_bysem() 
   		{
        	$course_id = $this->uri->segment(4);
			$semester = $this->uri->segment(5);

        	$arr = $this->ma->get_subject_list_bysem($course_id, $semester);
        	echo json_encode($arr);
    	}
		
		/******************************************************************************************
		* Description		: Json Responder.
		* input				: - 
		* author			: Nabihah Ab.Karim
		* Date				: 12 Septemeber 2013
		* Modification Log	: -
		******************************************************************************************/
		
		
    	function subject_list() 
   		{
        	$course_id = $this->uri->segment(4);
        	$semester = $this->uri->segment(5);

        	$arr = $this->ma->get_subject_list($course_id,$semester);
        	echo json_encode($arr);
    	}
		
		/******************************************************************************************
		* Description		: Json Responder.
		* input				: - 
		* author			: Nabihah Ab.Karim
		* Date				: 08 July 2013
		* Modification Log	: -
		******************************************************************************************/
		
		
    	function group_no() 
   		{
        	$course_id = $this->uri->segment(4);
        	$semester = $this->uri->segment(5);
        	//$semester = 3;
			$col = $this->ma->get_college_id($this->session->userdata('user_id'));	
        	$arr = $this->ma->get_group($course_id, $col->col_id, $semester);
        	echo json_encode($arr);
    	}
		
		/******************************************************************************************
		* Description		: Json Responder.
		* input				: - 
		* author			: Nabihah Ab.Karim
		* Date				: 08 July 2013
		* Modification Log	: -
		******************************************************************************************/
		function search_staff_details()
		{
			$queryString = $this->input->post("cStaff");
			
			$col = $this->ma->get_college_id($this->session->userdata('user_id'));	
			
			$college_id = intval($col->col_id);
			
			
			$result = $this->ma->staff_detail_search($queryString, $college_id);

			$search = 1;
			//$queryString = $queryString;
			
			if(isset($search) && $search==1)
			{
				$staff = array('staffs' => $result);
						
				echo(json_encode($staff));
			}
			
		}
		
		/******************************************************************************************
		* Description		: Json Responder.
		* input				: - 
		* author			: Nabihah Ab.Karim
		* Date				: 10 July 2013
		* Modification Log	: -
		******************************************************************************************/	
		function assign_subj_lect()
		{
			

			$cur_year = $this->session->userdata('tahun');
			$cur_session = $this->session->userdata('sesi');
			/*$course = 2;
			$semester = 1;
			$subject = 1;
			$group_no = 54;
			$staff_id = "80;3";
              
			 */
			$course = $this->input->post('course');
			$semester = $this->input->post('semester');
			$subject = $this->input->post('subject');
			$group_no = $this->input->post('group');
			$staff_id = $this->input->post('txtStaffList');
			
			$cm_id = $this->ma->get_course_module($course,$subject);
			
			$staffList = explode(";", $staff_id);
			
			//$data =array();
			//$la_id = $this->ma->get
			$tempArrId = array();
			$idToBeinsert = array();
			$parentId = $staffList[0];
			
			$check_la_id = $this->ma->check_lecturer($cm_id, $cur_year, $group_no);
			
			/* echo "check_la_id";
			echo "<pre>";
			print_r($check_la_id);
			echo "<br/>";
			*/
			
			if(isset($check_la_id) && !empty($check_la_id))
			{
				
				
				foreach($check_la_id as $row)
				{
					array_push($tempArrId, $row->user_id);
					if(NULL == $row->la_id_parent || "" == $row->la_id_parent || 0 == $row->la_id_parent)
					{
						$u_id_parent = $row->user_id;
						$la_id_parent = $row->la_id;
					}
				}
			
			}
			
			//echo $u_id_parent;
			
			/*echo "staff:<pre>";
			print_r($staffList);
			echo "</pre>";*/
			
			foreach($staffList as $staff)
			{
				$status_id = 0;
				if(isset($tempArrId) && !empty($tempArrId))
				{
					
							if(in_array($staff, $tempArrId) && $staff != $u_id_parent)
							{
								unset($tempArrId[array_search($staff,$tempArrId)]);
								$status_id = 1;
								//echo "pass1";
								
							}
							
							else if ($staff == $parentId)
							{
								$status_id = 1;
								//echo "pass2";
							}
					
				}
				
				if($status_id == 0)
				{
					array_push($idToBeinsert, $staff);
											
				}

			
			}
			
			//print_r($check_la_id);
			/*echo "tempArrId: ";
			echo "<pre>";
			print_r($tempArrId);
			echo "<br/>";*/
			//print_r($idToBeinsert);
			
			
			if(isset($check_la_id) && !empty($check_la_id))
			{
			foreach($check_la_id as $row)
			{
				//echo $row->user_id."<br/>";
				
				if(isset($tempArrId) && !empty($tempArrId))
				{
					
					foreach($tempArrId as $id)
				{
					//echo $row->user_id. "w=".$id ;
					//echo "<br/>";
					if($row->user_id == $u_id_parent)
					{
						
						 $data= array('la_group' =>$group_no,
						 'user_id'=>$parentId,
						 'cm_id'=> $cm_id,
						 'la_current_year'=>$cur_year,
						 'la_current_semester'=>$semester,
						 'la_current_session'=>$cur_session);
						 
						 $this->ma->update_subj_lect($data,$row->la_id);
						
						//echo $row->user_id." :Updated";
						
						//break;
						
					}
					
					else if($row->user_id == $id &&($row->la_id_parent != NULL || $row->la_id_parent!=0 || $row->la_id_parent!= ""))
					{
							$this->ma->delete_subj_lect($row->la_id);
							//echo $row->user_id." :deleted";
							break;
					}
					
					
				}
				}
				
				
					//untuk delete child data apabila child bertukar menjadi parent (delete & update)
					if($row->user_id == $parentId && ($row->la_id_parent != NULL || $row->la_id_parent !=0 || $row->la_id_parent!= ""))
					{
						$this->ma->delete_subj_lect($row->la_id);
						//echo $row->user_id." :deleted";
						
					}
				
			}
			
			}
			
			/*
			echo "Id to be inserted";
			print_r($idToBeinsert);
			echo "<br/>";
			*/
			
			foreach($idToBeinsert as $id)
			{
				if($id == $parentId)
				{
					
					$data= array('la_group' =>$group_no,
						 'user_id'=>$id,
						 'cm_id'=> $cm_id,
						 'la_current_year'=>$cur_year,
						 'la_current_semester'=>$semester,
						 'la_current_session'=>$cur_session,
						 'la_status' => 1);
						 
					$la_id_parent = $this->ma->insert_subj_lect($data);
					//echo $id." : insert parent";
				}
				
				else
				{
						$data= array('la_group' =>$group_no,
						 'user_id'=>$id,
						 'cm_id'=> $cm_id,
						 'la_current_year'=>$cur_year,
						 'la_current_semester'=>$semester,
						 'la_current_session'=>$cur_session,
						 'la_id_parent' => $la_id_parent,
						 'la_status' => 1);
						 
						$id = $this->ma->insert_subj_lect($data);
						//echo $id." : insert child";
						
						
				}
			}
			

		
						
			
		}
			//if($status)
			
		/******************************************************************************************
		* Description		: Json Responder.
		* input				: college ID (col_id)
		* author			: Nabihah Ab.Karim
		* Date				: 11 July 2013
		* Modification Log	: -
		******************************************************************************************/	
		function get_course_college()
		{
			
			$col_name = $this->input->post("college");
			$college = explode("-", $col_name);
			
			$arr = $this->ma->get_course($college[0]);
        	echo json_encode($arr);
        	//echo $college[0];
		}
		
		/******************************************************************************************
		* Description		: Paparan pensyarah kepada subjek.
		* input				: 
		* author			: Nabihah Ab.Karim
		* Date				: 12 July 2013
		* Modification Log	: -
		******************************************************************************************/	
		function subject_lecturer()
		{
			$col_id = $this->ma->get_college_id($this->session->userdata('user_id'));
			$data['title'] = "Paparan Pensyarah";
			$data['course'] = $this->ma->course_list($col_id->col_id);
			//print_r($this->session->all_userdata());
			//die();
			$data['lecturer'] = $this->ma->get_lecturer();
			
			$data['output'] = $this->load->view('lecturer/v_subjectlecturer',$data,TRUE);
			$this->load->view('main.php', $data, '');
		}
		
		/******************************************************************************************
		* Description		: Paparan pensyarah kepada subjek (Ajax)
		* input				: 
		* author			: Nabihah Ab.Karim
		* Date				: 17 July 2013
		* Modification Log	: -
		******************************************************************************************/
		
		function ajax_subject_lecturer()
		{
			$col_id = $this->ma->get_college_id($this->session->userdata('user_id'));
			$arr_data = $this->ma->get_subject_lecturer_by_paging($col_id->col_id);
		
			
			if (sizeof($arr_data) > 0)
			echo json_encode($arr_data);
		}
		
		
		/******************************************************************************************
		* Description		: Dapatkan pensyarah mengikut subjek, kelas dan kursus
		* input				: 
		* author			: Nabihah Ab.Karim
		* Date				: 29 July 2013
		* Modification Log	: -
		******************************************************************************************/
		
		function get_ajax_lecturer_subjectgroup() 
		
	{
        $course_id = $this->uri->segment(4);
        $semester = $this->uri->segment(5);
        $subject_id = $this->uri->segment(6);
        $group = $this->uri->segment(8);
		$status = $this->uri->segment(7);
		$col = $this->ma->get_college_id($this->session->userdata('user_id'));
        
        $arr = $this->ma->get_lecturer_subjectgroup($course_id,$semester,$subject_id,$group, $col->col_id, $status);
	    // $arr;
	    //print_r($arr);
        echo json_encode($arr);
    }
	
	/******************************************************************************************
		* Description		: Function untuk update full mark berdasarkan grade_id dalam table module_taken(by manual)
		* input				: 
		* author			: Nabihah Ab.Karim
		* Date				: 29 July 2013
		* Modification Log	: -
		******************************************************************************************/
		function query_update_fullmark() 
		
	{
       
        $arr = $this->ma->query_update_fullmark();
		echo $arr;
	   
    }

		
	function lecturer_auto()
	{
		
		$data['lecturer'] = $this->ma->get_lecturer();
		$this->load->view('main.php', $data, '');
	}
	
/******************************************************************************************
* Description		: Assign lecturer to module repeat
* input				: - 
* author			: Nabihah Ab.Karim
* Date				: 07 April 2014
* Modification Log	: 
******************************************************************************************/
	function assign_subj_repeat() 
		{
			$col = $this->ma->get_college_id($this->session->userdata('user_id'));	
	
			$data['course'] = $this->ma->course_list_user($col->col_id);
			$data['college'] = $this->ma->code_college();
			$data['title'] = "Pembahagian Modul Berulang Kepada Pensyarah";
			$data['output'] = $this->load->view('lecturer/v_assignsubject_repeat',$data,TRUE);
			$this -> load -> view('main.php', $data, '');
		}		

/******************************************************************************************
* Description		: Json Responder.
* input				: - 
* author			: Nabihah Ab.Karim
* Date				: 07 July 2013
* Modification Log	: -
******************************************************************************************/
		
		
    	function subject_repeat() 
   		{
   			$col = $this->ma->get_college_id($this->session->userdata('user_id'));
			
        	$course_id = $this->uri->segment(4);
			$semester = $this->uri->segment(5);

        	$arr = $this->ma->get_subject_repeat($course_id, $semester, $col->col_id);
        	echo json_encode($arr);
    	}
		
				
/******************************************************************************************
* Description		: Insert lecturer, modul, and course for repeat paper
* input				: - 
* author			: Nabihah Ab.Karim
* Date				: 8 April 2014
* Modification Log	: -
******************************************************************************************/	
		function assign_subjrepeat_lect()
		{
			$cur_year = $this->session->userdata('tahun');
			$cur_session = $this->session->userdata('sesi');
			$semester = $this->input->post('semester');
			$course = $this->input->post('course');
			$subject = $this->input->post('subject');
			$staff_id = $this->input->post('txtStaffList');
			
			$cm_id = $this->ma->get_course_module($course,$subject);
			$col = $this->ma->get_college_id($this->session->userdata('user_id'));
			
			$data= array('user_id'=>$staff_id,
						 'cm_id'=> $cm_id,
						 'la_current_year'=>$cur_year,
						 'la_current_session'=>$cur_session,
						 'la_current_semester'=>$semester,
						 'la_status'=>2);
			
			$la_id = $this->ma->check_la($cm_id, $cur_year, $col->col_id);	
			if(empty($la_id))
			{
					$this->ma->insert_subj_lect($data);
			}
			else {
				$this->ma->update_subjrepeat_lect($data, $la_id->la_id);
			}			
		
		}
	
	
	/******************************************************************************************
		* Description		: Json Responder.
		* input				: - 
		* author			: Nabihah Ab.Karim
		* Date				: 09 April 2014
		* Modification Log	: -
		******************************************************************************************/
		
		
    	function subjectrepeat_list() 
   		{
        	$course_id = $this->uri->segment(4);
        	$semester = $this->uri->segment(5);

        	$arr = $this->ma->get_subjectrepeat_list($course_id,$semester);
        	echo json_encode($arr);
    	}	
		
		
		
			function test() 
   		{
        	$data['output'] = $this->load->view('lecturer/test','',TRUE);
			$this -> load -> view('main.php', $data, '');
    	}	
		
}

?>