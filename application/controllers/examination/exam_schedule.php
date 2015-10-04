<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Exam_schedule extends MY_Controller
{
	function __construct() 
	{
		parent::__construct();
		$this->load->model('m_kv');
		$this->load->model('m_result');
	}
	
	/**********************************************************************************************
	* function ni digunakan untuk modul calendar peperiksaan
	* input: -
	* author: Mior Mohd Hanif
	* Date: 3 Sept 2013
	* Modification Log: 24 Sept 2013 by Mior - asingkan peperiksaan rasmi dan mengulang
	**********************************************************************************************/
	function index()
	{
		
		
		if(isset($_POST["sesi"])) {
			$sesi = $this -> input -> post('sesi');
		} else {
			$sesi = $this->session->userdata["sesi"]. " " .$this->session->userdata["tahun"];
		}
		
		if (isset($_POST['submit']) && $_POST['submit'] != '') {
		
			$sesis = $this->input->post('sesi');
			$cou_id = $this->input->post('cou_id');
			$mod_id = $this->input->post('mod_id');
			$tarikh = strtotime($this->input->post('schedule_date'));
			$masa_mula = date('Hi',strtotime($this->input->post('schedule_time_start')));
			$masa_tamat = date('Hi',strtotime($this->input->post('schedule_time_end')));
			//$tempat_exam = $this->input->post('hall_id');
			
			$check = $this->m_kv->get_cm_id($cou_id,$mod_id);	
			
			{
				
				$data = array(
					'schedule_date' => $tarikh,
					'schedule_time_start' => $masa_mula,
					'schedule_time_end' => $masa_tamat,
					'schedule_type' => 1,
					'cm_id' => $check->cm_id,
					'session' => $sesis
				);
				
				$insert = $this->db->insert('exam_schedule',$data);
				
			if($insert)
			{
				$this->session->set_flashdata("action_msg", "Maklumat telah berjaya di dikemaskini");
				$this->session->set_flashdata('css_msg','MessageBarOk');
				
				$this->session->keep_flashdata('action_msg');
				$this->session->keep_flashdata('css_msg');
				
				$this->session->flashdata('action_msg');
				$this->session->flashdata('css_msg');
				
				redirect('/examination/exam_schedule');
				
				
				/**FDPO - Safe to be deleted**/
				//echo('<pre>');print_r("iNSERT");echo('</pre>');
				//die();
			}
			
				
				$data['headline'] = "Jadual Peperiksaan";
			}
			}
			$data['headline'] = "Jadual Peperiksaan";
			$data['cur_sesi'] = $sesi;
			$data['courses'] = $this->m_kv->get_course();
			//$data['subjects'] = $this->m_kv->get_subject();
			//$data['exam_hall'] = $this->m_kv->get_exam_hall();
			
			/**FDPO - Safe to be deleted**/
			//echo('<pre>');print_r($data['subjects']);echo('</pre>');
			//die();
			$data['exam_schedule_rasmi'] = $this->m_kv->get_exam_schedule_rasmi($sesi);
		$output['output'] = $this->load->view('peperiksaan/v_exam_schedule', $data, true);
		$this->load->view('main.php', $output);
	}
	
	
	/**********************************************************************************************
	* function ni digunakan untuk modul calendar peperiksaan
	* input: -
	* author: Mior Mohd Hanif
	* Date: 3 Sept 2013
	* Modification Log: -
	**********************************************************************************************/
	function add()
	{
		
		
			$sesi = $this->input->post('sesi');
			$cou_id = $this->input->post('cou_id');
			$mod_id = $this->input->post('mod_id');
			$tarikh = strtotime($this->input->post('schedule_date'));
			$masa_mula = date('Hi',strtotime($this->input->post('schedule_time_start')));
			$masa_tamat = date('Hi',strtotime($this->input->post('schedule_time_end')));
			//$tempat_exam = $this->input->post('hall_id');
			
			$check = $this->m_kv->get_cm_id($cou_id,$mod_id);	
			//echo $check->cm_id;
			//die();
			
			{
				
				$data22 = array(
					'schedule_date' => $tarikh,
					'schedule_time_start' => $masa_mula,
					'schedule_time_end' => $masa_tamat,
					'schedule_type' => 1,
					'cm_id' => $check->cm_id,
					'session' => $sesi
				);
				
				$this->db->insert('exam_schedule',$data22);
				$insert_id = $this->db->insert_id();
				
			}
			
			return $insert_id;
		
	}

	
	/**********************************************************************************************
	 * function ni digunakan untuk cetak jadual peperiksaan untuk pelajar
	 * input: -
	 * author: Mior Mohd Hanif
	 * Date: 30 Sept 2013
	 * Modification Log:
	 **********************************************************************************************/
	function subject_list()
	{
		$cou_id = $this->uri->segment(4);
		
		$arr = $this->m_aka->get_subject_list($cou_id);
        echo json_encode($arr);
	}
	
	
	/**********************************************************************************************
	* function ni digunakan untuk cetak jadual peperiksaan untuk pelajar
	* input: -
	* author: Mior Mohd Hanif
	* Date: 30 Sept 2013
	* Modification Log: 
	**********************************************************************************************/
	function print_student_exam_schedule()
	{
		$user_login = $this->ion_auth->user()->row();
		$col_id = $user_login->col_id;
		
		$data['student_details'] = $this->m_kv->get_student_by_kv($col_id);
		$data['courses'] = $this->m_kv->get_course();
		
		$output['output'] = $this->load->view('sup/v_student_exam_schedule', $data,true);
		$this->load->view('main.php', $output);
		
	}
	
	
	/**********************************************************************************************
	* function ni digunakan untuk megemaskini jadual.
	* input: -
	* author: Freddy Ajang Tony
	* Date: 03 Okt 2013
	* Modification Log: 
	**********************************************************************************************/
	function edit_exam_schedule()
	{
		$schedule_id = $this->input->post('schedule_id');
		$tarikh = strtotime($this->input->post('schedule_date_modal'));
		$masa_mula = date('Hi',strtotime($this->input->post('schedule_time_start_modal')));
		$masa_tamat = date('Hi',strtotime($this->input->post('schedule_time_end_modal')));
		
		$data = array(
			'schedule_date'=> $tarikh,
			'schedule_time_start' => $masa_mula,
			'schedule_time_end' => $masa_tamat
		);
		
		$edit = $this->m_kv->save_edit_schedule($schedule_id,$data);
		/**FDPO - Safe to be deleted**/
		//echo('<pre>');print_r($edit);echo('</pre>');
		//die();
		return 1;
	}
	
	
	/**********************************************************************************************
 	* Description		: this function to print exam_schedule for kv
 	* input			: 
 	* author			: siti umairah
	* Date				: 3 october 2013
 	* Modification Log	: 08/10/2013 -Fred- get exam schedule
	**********************************************************************************************/
	function print_exam_schedule_kv()
	{
		$user_login = $this->ion_auth->user()->row();
		$col_id = $user_login->col_id;
		
		$course_id = $this->input->post('cou_id');
		$semester = $this->input->post('semester');
		
		$data['college'] = $this->m_kv->get_user_college($col_id);
		
		$data['student_data'] = $this->m_kv->get_student_by_kv($col_id,$course_id,$semester);
		$data['semester'] = $semester;
		
		//$data['exam_schedule'] = $this->m_kv->get_exam_schedule_rasmi();
		
		/**FDPO - Safe to be deleted**/
		//echo('<pre>');print_r($data);echo('</pre>');
		//die();
		
		$this->load->view('peperiksaan/v_print_exam_schedule', $data, '');
	}
	

	/**********************************************************************************************
	* Description		: this function to display slip exam
	* input			: 
	* author			: siti umairah
	* Date				: 4 october 2013
	* Modification Log	: -
	**********************************************************************************************/
	function print_exam()
	{
		$user_login = $this->ion_auth->user()->row();
		$col_id = $user_login->col_id;

		
		$data['headline'] = "Cetak Jadual Peperiksaan";
		//$data['student_details'] = $this->m_kv->get_student_by_kv($col_id);
		$data['courses'] = $this->m_kv->get_course();
		
		$output['output'] = $this->load->view('peperiksaan/v_exam_schedule_secetary', $data, true);
		$this->load->view('main.php', $output);
	}
	
	
	/**********************************************************************************************
	* Description		:This function to get module from course.
	* input				: -
	* author			: Freddy Ajang Tony
	* Date				: 10 Okt 2013
	* Modification Log	:
	**********************************************************************************************/
	function get_module_by_course()
	{
		$course_id = $this->input->post('cou_id');
		
		$data['module'] = $this->m_result->get_module($course_id);
		
		/**FDPO - Safe to be deleted**/
		//echo('<pre>');print_r($data);echo('</pre>');
		//die();
		$this->load->view('peperiksaan/v_exam_schedule_ajax', $data);
	}
	
	
	/**********************************************************************************************
	* Description		:This function to delete schedule.
	* input				: -
	* author			: Freddy Ajang Tony
	* Date				: 16 Okt 2013
	* Modification Log	:
	**********************************************************************************************/
	function delete_schedule()
	{
		$schedule_id = $this->input->post('schedule_id');
		
		/**FDPO - Safe to be deleted**/
		//echo('<pre>');print_r($schedule_id);echo('</pre>');
		//die();
		echo($this->m_kv->delete_exam_schedule($schedule_id));
	
	}
	
	
	/**********************************************************************************************
	* Description		:This function to get exam schedule and repopulate it..
	* input				: -
	* author			: Freddy Ajang Tony
	* Date				: 16 Okt 2013
	* Modification Log	:
	**********************************************************************************************/
	function get_exam_schedule()
	{
		if(isset($_POST["sesi"])) {
			$sesi = $this -> input -> post('sesi');
		} else {
			$sesi = $this->session->userdata["sesi"]. " " .$this->session->userdata["tahun"];
		}
		
		$data['exam_schedule_rasmi'] = $this->m_kv->get_exam_schedule_rasmi($sesi);
		$data['get_data'] = 1;
		/**FDPO - Safe to be deleted**/
		//echo('<pre>');print_r($data);echo('</pre>');
		//die();
		
		$this->load->view('peperiksaan/v_exam_schedule_ajax', $data);
	}
}
?>
