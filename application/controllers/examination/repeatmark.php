<?php

/**************************************************************************************************
* File Name        : repeatmark.php
* Description      : This File contain Examination module for Repeat Paper.
* Author           : Norafiq Bin Mohd Azman Chew
* Date             : 16 August 2013
* Version          : -
* Modification Log : -
* Function List	   : __construct(), index, 
**************************************************************************************************/

	class Repeatmark extends MY_Controller 
	{
		/******************************************************************************************
		* Description		: Constructor = load model
		* input				: - 
		* author			: Norafiq Azman
		* Date				: 16 August 2013
		* Modification Log	: -
		******************************************************************************************/
		function __construct() 
		{
			parent::__construct();
			$this->load->model('m_kursus');
			$this->load->model('m_pelajar');
			$this->load->model('m_subject');
			$this->load->library('grocery_CRUD');
		}
		
		/******************************************************************************************
		* Description		: Index. to view/display page insert repeat marks
		* input				: - 
		* author			: Norafiq Azman
		* Date				: 16 August 2013
		* Modification Log	: -
		******************************************************************************************/
		function index() 
		{
			//print_r($this->session->all_userdata());
			//die();
			
			$user = $this->ion_auth->user()->row();
			$userid = $user->id;
			$user_login = $this->ion_auth->user()->row();
			$col_id = $user_login->col_id;
			
			$data['kursus'] = $this->m_kursus->repeat_course($col_id,$userid);
			$data['repeatstd'] = $this->m_pelajar->stdrepeat_srch_nthg();
	        $output['output'] = $this->load->view('marking/v_evaluation_repeat', $data, true);
			$this->load->view('main.php', $output);
		}
		
		/******************************************************************************************
		* Description		: this function to get students by course and semester
		* input				: -
		* author			: Norafiq Azman
		* Date				: 16 August 2013
		* Modification Log	: -
		******************************************************************************************/
		function getstu_by()
		{
			$user = $this->ion_auth->user()->row();
			$userid = $user->id;
			
			$user_login = $this->ion_auth->user()->row();
			$col_id = $user_login->col_id;
			
			$kursus = $this->input->post('slct_kursus');
			$semester = $this->input->post('slct_sem');
			$noMatrik = $this->input->post('nomatrik');
			
			
			if("" != $kursus && "" != $semester)
			{
				if("" != $noMatrik)
				{
					$data['repeatstd'] = $this->m_pelajar->stdrepeat_srch_nthg($kursus="",$semester="",$noMatrik);
					$data['enomatric'] = $noMatrik;
				}
				else
				{
					//$data['repeatstd'] = $this->m_pelajar->stdrepeat_srch_corse($kursus, $semester);
					$data['repeatstd'] = $this->m_pelajar->stdrepeat_srch_nthg($kursus,$semester,$noMatrik);
				}
			}
			else
			{
				if("" != $noMatrik)
				{
					$data['repeatstd'] = $this->m_pelajar->stdrepeat_srch_nthg($kursus="",$semester="",$noMatrik);
					$data['nomatric'] = $noMatrik;
				}
				else
				{
					$data['repeatstd'] = $this->m_pelajar->stdrepeat_srch_nthg();
				}
			}
			
			$data['kursus'] = $this->m_kursus->repeat_course($col_id,$userid);
			$data['kursusID'] = $kursus;
			$data['semester'] = $semester;
			
			
			$output['output'] = $this->load->view('marking/v_evaluation_repeat', $data, true);
			$this->load->view('main.php', $output);
		}
		
		/******************************************************************************************
		* Description		: this function display subject
		* 					  json responder
		* input				: -
		* author			: Norafiq Azman
		* Date				: 20 August 2013
		* Modification Log	: -
		******************************************************************************************/
		function get_sbj()
		{
			$mdid = $this->input->post("takenid");
			
			$data = $this->m_subject->subject_by_mdid($mdid);
			
			$response = array("subjek" => $data);
			
			echo(json_encode($response));
		}
		
		/******************************************************************************************
		* Description		: this function tu get value marks if ada
		* 					  json responder
		* input				: -
		* author			: Norafiq Azman
		* Date				: 22 August 2013
		* Modification Log	: -
		******************************************************************************************/
		function get_mrkv()
		{
			$mdid = $this->input->post("takenid");
			
			$data = $this->m_subject->value_mark($mdid);
			
			$response = array("markvalue" => $data);
			
			echo(json_encode($response));
		}
		
		/******************************************************************************************
		* Description		: this function is json to save repeat mark
		* input				: -
		* author			: Norafiq Azman
		* Date				: 21 August 2013
		* Modification Log	: -
		******************************************************************************************/
		function save_repeatmark()
		{
			$mod_id = $this->input->post("takenid");
			$ttlrmark = $this->input->post("rptmark");
			$mod_centre = $this->input->post("modcentre");	
			//$ttl_vk = $this->input->post("jrmarkah");
			//print_r($mod_id);
			//print_r($ttlrmark);
			//print_r($mod_centre);
			//die();
			if($ttlrmark == "T")
			{
				$ttlrmark = -99.99;
			}
			elseif ($ttlrmark == "")
			{
				$ttlrmark = 0;
			}
	
			//echo "<pre>";					//FDP
			//print_r ($mark_list);
			//echo "</pre>";
			//die();
			
			$data = $this->m_subject->update_repeat_mark($mod_id, $ttlrmark, $mod_centre);
		}
		
		/******************************************************************************************
		* Description		: this function to check repeat value if exist
		* input				: 
		* author			: Norafiq Azman
		* Date				: 4 December 2013
		* Modification Log	: -
		******************************************************************************************/
		/*function select_mark()
		{
			$mdid = $this->input->post("takenid");			
			
			$data = $this->m_subject->select_repeat_mark($mdid);
											
			$response = array("repeatvalue" => $data);
			
			echo(json_encode($response));
			
		}*/
		
		/******************************************************************************************
		* Description		: this function copy from other file to display Crud table in main.php
		* input				: $output = null, $header = '' 
		* author			: Norafiq Azman
		* Date				: 16 August 2013
		* Modification Log	: -
		******************************************************************************************/
		function _main_output($output = null, $header = '')
		{
			$output->output = $header . $output->output;
			$this->load->view('main.php', $output);	
		}		
	}// end of Class
/**************************************************************************************************
* End of repeatmark.php
**************************************************************************************************/
?>