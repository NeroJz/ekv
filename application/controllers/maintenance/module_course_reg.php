<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**************************************************************************************************
* File Name        : module_course_reg.php
* Description      : This File contain module course registration for AdminLP.
* Author           : Freddy Ajang Tony
* Date             : 16 December 2013 
* Version          : -
* Modification Log : -
* Function List	   : __construct(), 
**************************************************************************************************/ 
class Module_course_reg extends MY_Controller
{
	/**********************************************************************************************
	* Description	 : Constructor = load model
	* input	 : - 
	* author	 : Freddy Ajang Tony
	* Date	 : 16 December 2013
	* Modification Log	: -
	***********************************************************************************************/
	function __construct() 
	{
		parent::__construct();
		$this->load->model('m_module_course_reg');
	}


	/**********************************************************************************************
	* Description	 : to load 1st view.
	* input	 : - 
	* author	 : Freddy Ajang Tony
	* Date	 : 16 December 2013
	* Modification Log	: -
	***********************************************************************************************/
	function get_view_course()
	{
		$user = $this->ion_auth->user()->row();
		$userid = $user->id;
	
		$data['get_course'] = $this->m_module_course_reg->get_course();
		/**FDPO - Safe to be deleted**/
		//echo('<pre>');print_r($data);echo('</pre>');
		//die();
		
		$output['output'] = $this->load->view('maintenance/v_module_course_reg', $data, true);
		$this->load->view('main.php', $output);
	}


	/**********************************************************************************************
	* Description	 : to get module for the module.
	* input	 : - 
	* author	 : Freddy Ajang Tony
	* Date	 : 16 December 2013
	* Modification Log	: -
	***********************************************************************************************/
	function get_module()
	{
		$course_id = $this->input->post('course_id');
		$course_code = $this->input->post('course');
		$semester = $this->input->post('semester');
		
		$data['check_module'] = $this->m_module_course_reg->check_module_availability_by_course($course_id,$semester);
		$data['module_ak'] = $this->m_module_course_reg->get_module_ak($semester);
		$data['module_vk'] = $this->m_module_course_reg->get_module_vk($course_code,$semester);
		$data['module_list'] = $this->m_module_course_reg->get_module_list($course_code,$semester);
		$data['module_course_ak'] = $this->m_module_course_reg->get_module_course($course_id,$semester,'AK');
		$data['module_course_vk'] = $this->m_module_course_reg->get_module_course($course_id,$semester,'VK');
		
		/**FDPO - Safe to be deleted**/
		//echo('<pre>');
		//print_r($data['module_course_ak']);
		//echo('</pre>');
		//die();
		
		$a_data = array(
			'check_module' => $data['check_module'],
			'module_ak' => $data['module_ak'],
			'module_vk' => $data['module_vk'],
			'module_list' => $data['module_list'],
			'module_course_ak' => $data['module_course_ak'],
			'module_course_vk' => $data['module_course_vk'],
		);
		
		//Ajax json
		echo(json_encode($a_data));
	}


	/**********************************************************************************************
	* Description	 : to save course module.
	* input	 : -
	* author	 : Freddy Ajang Tony
	* Date	 : 16 December 2013
	* Modification Log	: -
	***********************************************************************************************/
	function save_module_course()
	{
		$module_reg = array();
		$user_login = $this->ion_auth->user()->row();
		$userId = $user_login->user_id;
		$col = get_user_collegehelp($userId);
		$data = $this->input->post();
						
		//Check module availability	
		$check_module = $this->m_module_course_reg->check_module_availability_by_course($data['kod_kursus'],$data['hide_semester']);
		
		/**FDPO - Safe to be deleted**/
		//echo('<pre>');print_r($data);echo('</pre>');
		//die();
		
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
		
			$this->m_module_course_reg->save_module($module_reg);
		}
		//edit by nabihah 28/02/2013
		else
		{
			$arr_cou_mod = array();
			$arr_cou_mod = $this->m_module_course_reg->get_cou_mod($data['kod_kursus'],$data['hide_semester']);
			$sta = $this->get_course_module($arr_cou_mod, $data['chk_module'],$data['hide_semester'], $data['kod_kursus']);
			if($sta)
			$check_module = 2;
			//echo "kursus:$data['kod_kursus']";
			//echo "cou_mod";
			//print_r ($arr_cou_mod);
			
			//die();

		}
		echo $check_module;
	
	}
	
	/**********************************************************************************************
	* Description	 : get data course module based on course id and semester
	* input	 : -
	* author	 : Nabihah
	* Date	 : 16 December 2013
	* Modification Log	: -
	***********************************************************************************************/
	function get_course_module($arr_cou_mod=array(), $arr_mod=array(), $sem="", $cou="")
	{
		$modIdTobeInsert = array();
		//$cmIdTobeDelete = array();
		$sta_ins="";
		$sta_del="";

		/*echo "mod insert";
		print_r($arr_mod);
		echo "course_module";
		print_r($arr_cou_mod);
		*/
	
		foreach($arr_mod as $mod)
		{
			$index=0;
			$check_ins = 1;
				foreach($arr_cou_mod as $cou_mod)
				{
					if($mod == $cou_mod->mod_id)
					{
						
						//$modIdTobeInsert = array_push($modIdTobeInsert, $mod);
						//if(in_array($cou_mod->cm_id, $cmIdTobeDelete))
						//unset($arr_cou_mod[$index]);
						//echo "push mod_id:$cou_mod->mod_id";
						//unset($arr_cou_mod[$index]);
						array_splice($arr_cou_mod, $index, 1);
						//echo "index:$index";
						//print_r($arr_cou_mod);
						$check_ins=0;
						break;
					}
					
					$index++;

				}
				if($check_ins == 1)
				{
					
					$module = array(
								'cm_semester' => $sem,
								'cou_id' => $cou,
								'mod_id' => $mod,
								);
	
					array_push($modIdTobeInsert,$module);
				}
		}
		/*	echo "modinsert:";
		print_r($modIdTobeInsert);
		echo "moddelete";
		print_r($arr_cou_mod);*/
		if(!empty($modIdTobeInsert))
		$sta_ins = $this->m_module_course_reg->save_module($modIdTobeInsert);
		
		if(!empty($arr_cou_mod))
		{
			foreach($arr_cou_mod as $cm_id)
			{
				$sta_del=$this->m_module_course_reg->delete_module($cm_id->cm_id);
			}
		}
		
		if($sta_ins || $sta_del)
		
			return 1;
		
		else 
			return 0;
				
			
	}


}// end of Class
/**************************************************************************************************
* End of module_course_reg.php
**************************************************************************************************/