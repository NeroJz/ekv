<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**************************************************************************************************
* File Name        : weightage.php
* Description      : This File contain assessment configuration module.
* Author           : Freddy Ajang Tony
* Date             : 20 June 2013 
* Version          : -
* Modification Log : -
* Function List	   : __construct(), 
**************************************************************************************************/
	
	class Weightage extends MY_Controller
	{
		/******************************************************************************************
		* Description		: Constructor = load model
		* input				: - 
		* author			: Freddy Ajang Tony
		* Date				: 20 June 2013
		* Modification Log	: -
		******************************************************************************************/
		function __construct() 
		{
			parent::__construct();
			$this->load->model('m_weightage');
		}
		
		
		/******************************************************************************************
		* Description		: Index.
		* input				: - 
		* author			: Freddy Ajang Tony
		* Date				: 20 June 2013
		* Modification Log	: -
		******************************************************************************************/
		function index() 
		{
			$user = $this->ion_auth->user()->row();
			$userid = $user->id;
			$current_session = $this->session->userdata["sesi"];
			$current_year = $this->session->userdata["tahun"];
			
			//$data['configuration'] = $this->m_assessment->get_assessment_configuration($current_session);
			//$data['manual_configuration'] = $this->m_assessment->get_manual_assessment_configuration($current_session);
			/**FDPO - Safe to be deleted**/
			//echo('<pre>');var_dump($data);echo('</pre>');
			//die();
			
	        $output['output'] = $this->load->view('marking/v_set_weightage', null,true);
			$this->load->view('main.php', $output);
		}
		
		
		/******************************************************************************************
		* Description		: Function to get list module
		* input				: - 
		* author			: Freddy Ajang Tony
		* Date				: 21 June 2013
		* Modification Log	: -
		******************************************************************************************/
		function get_module_list() 
		{
			$queryString = $this->input->post("rdmodType");
						
			$data['module_list'] = $this->m_weightage->module_list($queryString);

			//$data['get'] = 1;
			//$data['queryString'] = $queryString;
			/**FDPO - Safe to be deleted**/
			//echo('<pre>');var_dump($data);echo('</pre>');
			//die();
			
			$this->load->view('marking/v_set_weightage_ajax', $data);
		}
		
		
		/******************************************************************************************
		* Description		: Function to get module configuration
		* input				: - 
		* author			: Freddy Ajang Tony
		* Date				: 01 July 2013
		* Modification Log	: -
		******************************************************************************************/
		function get_module_weightage() 
		{
			$queryString = $this->input->post("mod_id");
			$modType = $this->input->post("mod_type");
						
			$data['module_detail'] = $this->m_weightage->get_module_weightage($queryString,$modType);
			
			/**FDPO - Safe to be deleted**/
			//echo('<pre>');var_dump($data);echo('</pre>');
			//die();
			
			$this->load->view('marking/v_set_weightage_ajax', $data);
		}
		
		
		/******************************************************************************************
		* Description		: Function to save update weightage configuration
		* input				: formConfig 
		* author			: Freddy Ajang Tony
		* Date				: 08 July 2013
		* Modification Log	: -
		******************************************************************************************/
		function save_update_weightage_configuration() 
		{
			$data = $this->input->post();
			
			$pt_data = array();
			$ppr_data = array();
			/**FDPO - Safe to be deleted**/
			//echo('<pre>');print_r($ppr_data);echo('</pre>');
			//die();
			
			if(!empty($data))
			{
					foreach($data as $key => $value)
					{
						(strpos($key,'category')!== false) ? $mod_category = $value : 0 ;
						(strpos($key,'mod_id')!== false) ? $mod_id = $value : 0 ;
						
						if($mod_category != "AK")
						{
							(strpos($key,'p_id')!== false) ? $p_id = $value : 0 ;
							(strpos($key,'s_id')!== false) ? $s_id = $value : 0 ;
							(strpos($key,'txtPamali')!== false) ? $pt_p_amali = $value : 0 ;
							(strpos($key,'txtPteori')!== false) ? $pt_p_teori = $value : 0 ;
							(strpos($key,'txtSamali')!== false) ? $pt_s_amali = $value : 0 ;
							(strpos($key,'txtSteori')!== false) ? $pt_s_teori = $value : 0 ;
						}
						else 
						{
							if(strpos($key,'txtPaper')!== false)
							{
								$v = explode('_',$key);
								
								$pp_data = array(
									'ppr_id' => $v[1],
									'ppr_percentage' => $value,
								);
								
								array_push($ppr_data,$pp_data);
							} 
						}
						
						(strpos($key,'txtPusat')!== false) ? $mod_mark_centre = $value : 0 ;
						(strpos($key,'txtSekolah')!== false) ? $mod_mark_school = $value : 0 ;
						
					}
					
					$m_data = array(
						'mod_id' => $mod_id,
						'mod_mark_centre' => $mod_mark_centre,
						'mod_mark_school' => $mod_mark_school,
					);
					
					/**FDPO - Safe to be deleted**/
					//echo('<pre>');print_r($ppr_data);echo('</pre>');
					//die();
					
					$this->m_weightage->save_update_weightage_conf($m_data);
					
					if($mod_category != "AK")
					{
						$p_data = array(
							'pt_id' => $p_id,
							'pt_teori' => $pt_p_teori,
							'pt_amali' => $pt_p_amali,
							'mod_id' => $mod_id,
						);
						array_push($pt_data,$p_data);
						
						$p_data = array(
							'pt_id' => $s_id,
							'pt_teori' => $pt_s_teori,
							'pt_amali' => $pt_s_amali,
							'mod_id' => $mod_id,
						);
						array_push($pt_data,$p_data);
						
						$this->m_weightage->save_update_module_configuration($pt_data);
						
						echo '1';
					}
					else 
					{
						$this->m_weightage->save_update_paper_configuration($ppr_data);
						
						echo '1';
					}
					
			}
			else
			{
				echo '0';
			}
			
		}
		
	}// end of Class
/**************************************************************************************************
* End of weightage.php
**************************************************************************************************/
?>
