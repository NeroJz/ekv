<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**************************************************************************************************
* File Name        : course_module.php
* Description      : This File contain course module management for KUPP.
* Author           : Freddy Ajang Tony
* Date             : 10 December 2013 
* Version          : -
* Modification Log : -
* Function List	   : __construct(), 
**************************************************************************************************/ 
class Course_module extends MY_Controller
{
	/**********************************************************************************************
	* Description		: Constructor = load model
	* input				: - 
	* author			: Freddy Ajang Tony
	* Date				: 10 December 2013
	* Modification Log	: -
	***********************************************************************************************/
	function __construct() 
	{
		parent::__construct();
		$this->load->model('m_course_module_kupp');
	}


	/**********************************************************************************************
	* Description		: to load 1st view.
	* input				: - 
	* author			: Freddy Ajang Tony
	* Date				: 10 December 2013
	* Modification Log	: -
	***********************************************************************************************/
	function get_view_course()
	{
		$user = $this->ion_auth->user()->row();
		$userid = $user->id;
		$col_id = $user->col_id;
			
		$data['get_course'] = $this->m_course_module_kupp->get_course();
		$data['list_course_kv'] = $this->m_course_module_kupp->get_course_by_kv($col_id);
		/**FDPO - Safe to be deleted**/
		//echo('<pre>');print_r($data);echo('</pre>');
		//die();
		
        $output['output'] = $this->load->view('maintenance/v_course_module', $data, true);
		$this->load->view('main.php', $output);
	}
	
	
	/**********************************************************************************************
	* Description		: to get module for the module.
	* input				: - 
	* author			: Freddy Ajang Tony
	* Date				: 10 December 2013
	* Modification Log	: -
	***********************************************************************************************/
	function get_module()
	{
		$course_code = $this->input->post('course');
		$semester = $this->input->post('semester');
		
		$data['module_ak'] = $this->m_course_module_kupp->get_module_ak($semester);
		$data['module_vk'] = $this->m_course_module_kupp->get_module_vk($course_code,$semester);
		$data['module_list'] = $this->m_course_module_kupp->get_module_list($course_code,$semester);
		
		/**FDPO - Safe to be deleted**/
		//echo('<pre>');print_r($data['module_list']);echo('</pre>');
		//die();
		$a_data = array(
			'module_ak' => $data['module_ak'],
			'module_vk' => $data['module_vk'],
			'module_list' => $data['module_list'],
		);
		
		//Ajax json
		echo(json_encode($a_data));
	}
	
	
	/**********************************************************************************************
	* Description		: to save course module.
	* input				: -
	* author			: Freddy Ajang Tony
	* Date				: 11 December 2013
	* Modification Log	: -
	***********************************************************************************************/
	function save_course_module()
	{
		$module_reg = array();
		$user_login = $this->ion_auth->user()->row();
		$userId = $user_login->user_id;
		$col = get_user_collegehelp($userId);
		$data = $this->input->post();
		
		//Check course availability		
		$check_course = $this->m_course_module_kupp->check_course_availability($col[0]->col_id,$data['kod_kursus']);
		
		if($check_course == 0)
		{
			$course_reg = array(
					'col_id' => $col[0]->col_id,
					'cou_id' => $data['kod_kursus'],
					'cc_status' => 1,
			);
			
			$course_insert_id = $this->m_course_module_kupp->save_course($course_reg);
		}
		
		//Check module availability	
		$check_module = $this->m_course_module_kupp->check_module_availability_by_course($data['kod_kursus'],$data['hide_semester']);
		
		if($check_module == 0)
		{
			foreach ($data['chk_module'] as $key => $value)
			{
				$module = array(
					'cm_semester' => $data['hide_semester'],
					'cou_id' => $data['kod_kursus'],
					'mod_id' => $value,
				);
				
				array_push($module_reg,$module);
			}
			
			$this->m_course_module_kupp->save_module($module_reg);
		}
		
		/**FDPO - Safe to be deleted**/
		//echo('<pre>');print_r($module_reg);echo('</pre>');
		//echo('<pre>');print_r($check_course);echo('</pre>');
		//echo('<pre>');print_r($check_module);echo('</pre>');
		//die();
		
		echo $check_course+$check_module;
	
	}
	
	
	/**********************************************************************************************
	* Description		: to save course module.
	* input				: -
	* author			: Freddy Ajang Tony
	* Date				: 16 December 2013
	* Modification Log	: -
	***********************************************************************************************/
	function save_course()
	{
		$cou_id = $this->input->post('course_id');
		$user = $this->ion_auth->user()->row();
		$col_id = $user->col_id;
		
		//Check course availability
		$check_course = $this->m_course_module_kupp->check_course_availability($col_id,$cou_id);
		
		if($check_course == 0)
		{
			$course_reg = array(
					'col_id' => $col_id,
					'cou_id' => $cou_id,
					'cc_status' => 1,
			);
				
			$course_insert_id = $this->m_course_module_kupp->save_course($course_reg);
			
			echo $course_insert_id;
		}else{
			echo 0;
		}
	}
	
	
	/**********************************************************************************************
	* Description		: to delete course module.
	* input				: -
	* author			: Freddy Ajang Tony
	* Date				: 16 December 2013
	* Modification Log	: -
	***********************************************************************************************/
	function delete_course()
	{
		$cc_id = $this->input->post('cc_id');
		$user = $this->ion_auth->user()->row();
		$col_id = $user->col_id;
	
		//Check course availability
		$check_course = $this->m_course_module_kupp->check_student_course($cc_id);
	
		if($check_course == 0)
		{
			$delete_course = $this->m_course_module_kupp->delete_course($cc_id);
				
			echo $delete_course;
		}else{
			echo 0;
		}
	}
	
	
	/**********************************************************************************************
	* Description		: to get course by ajax.
	* input				: -
	* author			: Freddy Ajang Tony
	* Date				: 16 December 2013
	* Modification Log	: -
	***********************************************************************************************/
	function get_course_ajax()
	{
		$user = $this->ion_auth->user()->row();
		$userid = $user->id;
		$col_id = $user->col_id;
			
		$data['list_course_kv'] = $this->m_course_module_kupp->get_course_by_kv($col_id);
		/**FDPO - Safe to be deleted**/
		//echo('<pre>');print_r($data);echo('</pre>');
		//die();
		
		//Ajax json
		echo(json_encode($data));
	}
	
}// end of Class
/**************************************************************************************************
* End of course_module.php
**************************************************************************************************/