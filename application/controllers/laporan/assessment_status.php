<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**************************************************************************************************
* File Name        : assessment_status.php
* Description      : This File contain assessment status module.
* Author           : Freddy Ajang Tony
* Date             : 14 February 2014 
* Version          : -
* Modification Log : -
* Function List	   : __construct(), 
**************************************************************************************************/ 
class assessment_status extends MY_Controller
{
		/******************************************************************************************
		* Description		: Constructor = load model
		* input				: - 
		* author			: Freddy Ajang Tony
		* Date				: 14 February 2014
		* Modification Log	: -
		******************************************************************************************/
		function __construct() 
		{
			parent::__construct();
			$this->load->model('m_assessment_status');
		}
	

		/******************************************************************************************
		* Description		: this function to view status.
		* input				: - 
		* author			: Freddy Ajang Tony
		* Date				: 14 February 2014
		* Modification Log	: -
		******************************************************************************************/
		function view_status() 
		{
			$user = $this->ion_auth->user()->row();
			$userid = $user->id;
			$col_id = $user->col_id;
		
			
			$data['courses'] = $this->m_assessment_status->course_list($col_id);
			/**FDPO - Safe to be deleted**/
			//echo('<pre>');print_r($data);echo('</pre>');
			//die();
			
	        $output['output'] = $this->load->view('laporan/v_assessment_status', $data, true);
			$this->load->view('main.php', $output);
		}


		/******************************************************************************************
		* Description		: this function to get lecturer.
		* input				: - 
		* author			: Freddy Ajang Tony
		* Date				: 15 February 2014
		* Modification Log	: -
		******************************************************************************************/
		function get_lecturers() 
		{
			$user = $this->ion_auth->user()->row();
			$userid = $user->id;
			$col_id = $user->col_id;
			$cou_id = $this->input->post("cou_id");
			$semester = $this->input->post("sem");
			
			/**FDPO - Safe to be deleted**/
			//echo('<pre>');print_r($col_id);echo('</pre>');
			//die();
			
			$data['lecturer'] = $this->m_assessment_status->get_lecturer($col_id,$cou_id,$semester);
			
			$data_json = array(
				'lecturer' => $data['lecturer'],
			);
			
	        echo json_encode($data_json);
		}
		
		
		/******************************************************************************************
		* Description		: this function to get lecturer module in modal.
		* input				: - 
		* author			: Freddy Ajang Tony
		* Date				: 20 February 2014
		* Modification Log	: -
		******************************************************************************************/
		function get_lecturers_module() 
		{
			$user = $this->ion_auth->user()->row();
			$userid = $this->input->post("user_id");
			$col_id = $user->col_id;
			$cou_id = $this->input->post("cou_id");
			$semester = $this->input->post("sem");
		
			$data['module'] = $this->m_assessment_status->get_modules($userid,$cou_id,$semester,$col_id);
			
			/**FDPO - Safe to be deleted**/
			//echo('<pre>');print_r($data);echo('</pre>');
			//die();
			$data_json = array(
				'module' => $data['module'],
			);
			
	        echo json_encode($data_json);
		}
		
		
		/******************************************************************************************
		* Description		: this function to view status for adminlp.
		* input				: - 
		* author			: Freddy Ajang Tony
		* Date				: 24 February 2014
		* Modification Log	: -
		******************************************************************************************/
		function view_status_adminlp() 
		{
			$user = $this->ion_auth->user()->row();
			$userid = $user->id;
			$col_id = $user->col_id;
		
			
			//$data['courses'] = $this->m_assessment_status->course_list($col_id);
			$data['centrecode'] = $this -> m_assessment_status -> get_college();
			/**FDPO - Safe to be deleted**/
			//echo('<pre>');print_r($data);echo('</pre>');
			//die();
			
	        $output['output'] = $this->load->view('laporan/v_assessment_status_adminlp', $data, true);
			$this->load->view('main.php', $output);
		}


		/******************************************************************************************
		* Description		: this function to get course by kv
		* input				: 
		* author			: Freddy Ajang Tony
		* Date				: 30 september 2013
		* Modification Log	: -
		******************************************************************************************/
		function get_course_by_kv()
		{
			$code = $this->input->post('kodpusat');
			$course_type = substr(trim($code), 0,1);
			$course_code = substr(trim($code), 1);
			
			
			$data['course'] = $this->m_assessment_status->get_course($course_type,$course_code);
			
			/**FDPO - Safe to be deleted**/
			//echo('<pre>');print_r($data);echo('</pre>');
			//die();
			
			$this->load->view('laporan/v_attendance_system_ajax', $data);
				
		}


		/******************************************************************************************
		* Description		: this function to get kv for adminlp view.
		* input				: - 
		* author			: Freddy Ajang Tony
		* Date				: 25 February 2014
		* Modification Log	: -
		******************************************************************************************/
		function get_kvs() 
		{
			$user = $this->ion_auth->user()->row();
			$userid = $user->id;
			$col_id = "";
			$cou_id = $this->input->post("cou_id");
			$semester = $this->input->post("sem");
			$college = $this->input->post("college");
			$col_type = "";
			$col_code = "";
			
			if($college != null)
			{
				$col_data = explode('-', $college);
				
				$col_type = substr(trim($col_data[1]), 0,1);
				$col_code = substr(trim($col_data[1]), 1);
				
				$get_id = $this->m_assessment_status->get_col_id($col_type,$col_code);
				
				$col_id = $get_id['col_id'];
			}
			
			$data['kvs'] = $this->m_assessment_status->get_kv($col_type,$col_code,$cou_id,$semester);
			
			/**FDPO - Safe to be deleted**/
			//echo('<pre>');print_r($data);echo('</pre>');
			//die();
			
			$data_json = array(
				'kvs' => $data['kvs'],
			);
			
	        echo json_encode($data_json);
		}
		
		
		/******************************************************************************************
		* Description		: this function to get kv courses in modal.
		* input				: - 
		* author			: Freddy Ajang Tony
		* Date				: 26 February 2014
		* Modification Log	: -
		******************************************************************************************/
		function get_kv_courses() 
		{
			$user = $this->ion_auth->user()->row();
			$col_id = $this->input->post("col_id");
			$cou_id = $this->input->post("cou_id");
			$semester = $this->input->post("sem");
		
			$data['course'] = $this->m_assessment_status->get_col_course($col_id,$cou_id,$semester);
			
			/**FDPO - Safe to be deleted**/
			//echo('<pre>');print_r($data);echo('</pre>');
			//die();
			$data_json = array(
				'course' => $data['course'],
			);
			
	        echo json_encode($data_json);
		}

		
}// end of Class
/**************************************************************************************************
* End of assessment_status.php
**************************************************************************************************/

?>