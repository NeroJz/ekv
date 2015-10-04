<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**************************************************************************************************
* File Name        : assessment.php
* Description      : This File contain assessment configuration module.
* Author           : Freddy Ajang Tony
* Date             : 18 June 2013 
* Version          : -
* Modification Log : -
* Function List	   : __construct(), 
**************************************************************************************************/   

	class Assessment extends MY_Controller
	{
		/******************************************************************************************
		* Description		: Constructor = load model
		* input				: - 
		* author			: Freddy Ajang Tony
		* Date				: 18 June 2013
		* Modification Log	: -
		******************************************************************************************/
		function __construct() 
		{
			parent::__construct();
			$this->load->model('m_assessment');
		}
		
		
		/******************************************************************************************
		* Description		: Index.
		* input				: - 
		* author			: Freddy Ajang Tony
		* Date				: 18 June 2013
		* Modification Log	: -
		******************************************************************************************/
		function index() 
		{
			$user = $this->ion_auth->user()->row();
			$userid = $user->id;
		
			$current_session = $this->session->userdata["sesi"];
			$current_year = $this->session->userdata["tahun"];
			
			
			$data['configuration'] = $this->m_assessment->get_assessment_configuration($current_session,$current_year);
			$data['manual_configuration'] = $this->m_assessment->get_manual_assessment_configuration($current_session,$current_year);
			/**FDPO - Safe to be deleted**/
			//echo('<pre>');print_r($data['manual_configuration']);echo('</pre>');
			//die();
			
	        $output['output'] = $this->load->view('marking/v_assessment_configuration', $data, true);
			$this->load->view('main.php', $output);
		}
		
		
		/******************************************************************************************
		* Description		: this function to search the kv by input insert.
		* input				: - 
		* author			: Freddy Ajang Tony
		* Date				: 19 June 2013
		* Modification Log	: -
		******************************************************************************************/
		function search_kv_details()
		{
			$queryString = $this->input->post("str");
						
			$data['result'] = $this->m_assessment->kv_detail_search($queryString);

			$data['search'] = 1;
			$data['queryString'] = $queryString;
			/**FDPO - Safe to be deleted**/
			//echo('<pre>');var_dump($data);echo('</pre>');
			//die();
			$this->load->view('marking/v_assessment_configuration_ajax', $data);
			
		}
		
		/******************************************************************************************
		* Description		: this function initializes and load the v_assessment_configuration
		*  					  view 
		* input				: - 
		* author			: Freddy Ajang Tony
		* Date				: 18 June 2013
		* Modification Log	: -
		******************************************************************************************/
		function assessment_config()
		{
			$user = $this->ion_auth->user()->row();
			$userid = $user->id;
			//$current_session = $this->session->userdata["sesi"];
			//$current_year = $this->session->userdata["tahun"];
			$datatry = $this->input->post("sesi");
			
			$session_year = explode(':',$datatry);
			
			/**FDPO - Safe to be deleted**/
			//echo('<pre>');print_r($datatry);echo('</pre>');
			//die();
			
			$data['configuration'] = $this->m_assessment->get_assessment_configuration($session_year[0],$session_year[1]);
			$data['manual_configuration'] = $this->m_assessment->get_manual_assessment_configuration($session_year[0],$session_year[1]);
			
			/**FDPO - Safe to be deleted**/
			//echo('<pre>');print_r($data['manual_configuration']);echo('</pre>');
			//die();
			
	        $this->load->view('marking/v_assessment_configuration_ajax', $data);
			
		}
		
		
		/******************************************************************************************
		* Description		: this function to save assessment configuration 
		* input				: - 
		* author			: Freddy Ajang Tony
		* Date				: 20 June 2013
		* Modification Log	: -
		******************************************************************************************/
		function save_assessment_configuration()
		{
			$datatry = $this->input->post();
			$open_date = 0;
			$close_date = 0;
			$ul_id = 0;
			$start_date_user = 0;
			$end_date_user = 0;
			$session = "";
			$submit_date = "A";
			$data = array();
			$data_user = array();
			$user_data = array();
			$data_sem = array();
			$val_sdconfig_id = array();
			
			/**FDPO - Safe to be deleted**/
			//echo('<pre>');print_r($datatry);echo('</pre>');
			//die();
			
			if(!empty($datatry))
			{	$i = -1;
				foreach($datatry as $keys => $values)
				{
					if(strpos($keys,'slctsesi') !== false)
					{
						$session = explode(':', $values);
					}	
										
					if(strpos($keys,'sdctype') !== false)
					{	
							foreach($values as $key => $value)
							{
								if(strpos($key,'sdconfig_id')!== false)
								{
									if(strlen($value) > 1)
									{
										$val = explode(',', $value);
										$sdconfig_id = $val[0];
									}
									else {
										$sdconfig_id = $value;
										$val = explode(',', $value);
									}
									
								} 
								(strpos($key,'sd_open_date')!== false) ? $sd_open_date = $value : null ;
								(strpos($key,'sd_close_date')!== false) ? $sd_close_date = $value : null ;
								(strpos($key,'sd_assessment_type')!== false) ? $sd_assessment_type = $value : null ;	
							}	
							
							//make sure all date is valid then only proceed
							$pattern = "/^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/";
							if (preg_match($pattern, $sd_open_date) && preg_match($pattern, $sd_close_date))
							{	
								$a_data = array(
								'sdconfig_id' => $sdconfig_id,
								'sd_current_session' => $session[0],
								'sd_current_year' => $session[1],
								'sd_current_semester' => 0,
								'sd_open_date' => strtotime($sd_open_date),
								'sd_close_date' => strtotime($sd_close_date),
								'sd_assessment_type' => $sd_assessment_type,
								);
								array_push($data, $a_data);
								array_push($val_sdconfig_id,$val);
							}	
					}
					
					if(strpos($keys,'usersdconfig') !== false)
					{
							$ulm_sdconfig_id = $values;
					}
					
					
					if(strpos($keys,'userconfig') !== false)
					{
						foreach($values as $key2 => $value2)
						{
							if(strpos($key2,'ulmconfig_id')!== false)
							{
								$ulmconf_id = array(0,0,0);
								if(strlen($value2) > 1)
								{
									$ulmconf_id = explode(',', $value2);
								 	$ulmconfig_id = $ulmconf_id[0];
								}
								else
								{
									$ulmconfig_id = $value2;
								}
								 
							}
							
							(strpos($key2,'end_date_user')!== false) ? $end_date_user = $value2 : null ;
							
							if(strpos($key2,'ul_id')!== false)
							{
								if(strlen($value2) > 1)
								{
									$ulid = explode(',', $value2);
								 	$ul_id = $ulid[0]; 
								}
								else
								{
									$ul_id = $value2;
								}
							}
						}
						
						//make sure all date is valid then only proceed
						$pattern = "/^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/";
						if (preg_match($pattern, $end_date_user))
						{
							//For status in query 1=update 0=insert
							($ulmconfig_id ==! 0) ? $status = 1 : $status = 0 ;
								
							$u_data = array(
							'ulmconfig_id' => $ulmconfig_id,
							'sdconfig_id' => $ulm_sdconfig_id,
							'end_date_user' => strtotime($end_date_user),
							'ul_id' => $ul_id,
							);
							
							array_push($data_user, $u_data);
							
							$i++;
							
							if($i == 2 || $i == 5 || $i == 8 || $i == 11)
							{
								$index = 0;
								$i == 2 ?  $index = $i+0 : null;
								$i == 5 ?  $index = $i+2 : null;
								$i == 8 ?  $index = $i+4 : null;
								$i == 11 ?  $index = $i+6 : null;
								
								$valid_7 = array('ul_id' => $ulid[1],'ulmconfig_id' => $ulmconf_id[1]);
								$ulid_7 = array_merge($data_user[$index],$valid_7);    // replace only the wanted keys
								
								$valid_8 = array('ul_id' => $ulid[2],'ulmconfig_id' => $ulmconf_id[2]);
								$ulid_8 = array_merge($data_user[$index],$valid_8);    // replace only the wanted keys
								
								array_push($data_user, $ulid_7);
								array_push($data_user, $ulid_8);
							}
						}	
					}		
				}
				
				/**FDPO - Safe to be deleted**/
				//echo('<pre>');print_r($data);echo('</pre>');
				//die();
				
				//Insert semester to data
				foreach ($datatry['chksem'] as $key => $value) {
					$semdata = array('sd_current_semester' => $value);
					
					foreach ($data as $key2 => $value) {
						
						if(sizeof($val_sdconfig_id[$key2]) > 1)
						{
							if($val_sdconfig_id[$key2][$key] == 0)
							{
								$semdata_sd = array('sdconfig_id' => 0);
							}else{
								$semdata_sd = array('sdconfig_id' => $val_sdconfig_id[$key2][$key]);
							}
						}
						else 
						{
							if($val_sdconfig_id[$key2][0] == 0)
							{
								$semdata_sd = array('sdconfig_id' => 0);
							}else{
								$semdata_sd = array('sdconfig_id' => $val_sdconfig_id[$key2][0]);
							}
						}
						
						
						$semdata = array_merge($semdata,$semdata_sd);
						$datamerge = array_merge($value,$semdata);
						
						array_push($data_sem, $datamerge);
						
					}
					
					/**FDPO - Safe to be deleted**/
					/*echo('<pre>');print_r($val_sdconfig_id);echo('</pre>');
					echo('<pre>');print_r($datatry['chksem']);echo('</pre>');
					echo('<pre>');print_r($data_sem);echo('</pre>');
					die();*/
					
					//Save to submit_date_configuration
					$sdconfig_ids = $this->m_assessment->save_update_assessment_configuration($data_sem);
					
					$data_sem = array(); //Reset array after save for other data
					
					$count = 1;
					$arrindex = 0;
					foreach($data_user as $user)
					{
						$sdconf_insert = array('sdconfig_id' => $sdconfig_ids[$arrindex]);
						$user = array_merge($user,$sdconf_insert);    // replace only the wanted keys
						
						array_push($user_data, $user);
						
						if($count % 5 == 0 )
						{
							$arrindex++;
						}
						$count++;
					}
					
					/**FDPO - Safe to be deleted**/
					//echo('<pre>');print_r($user_data);echo('</pre>');
					//die();
					
					//Save to user_level_manual_configuration
					$this->m_assessment->save_update_user_level_configuration($user_data,$status,$submit_date);
					
					$user_data = array(); //Reset array after save for other data
				}
				
				echo "1";
			}		
			else
			{
				echo "0";
			}
				
		}


		/******************************************************************************************
		* Description		: this function to save assessment configuration manual
		* input				: - 
		* author			: Freddy Ajang Tony
		* Date				: 20 June 2013
		* Modification Log	: -
		******************************************************************************************/
		function save_assessment_configuration_manual()
		{
			$current_session = $this->session->userdata["sesi"];
			$current_year = $this->session->userdata["tahun"];
			//$start_date = $this->input->post("mdatefrom");
			//$end_date = $this->input->post("mdateto");
			//$kv_list = $this->input->post("txtKvList");
			
			$datatry = $this->input->post();
			$start_date = 0;
			$end_date = 0;
			$kv_list = 0;
			$status = 0;
			$submit_date = "M";
			$ulmid_5 = array('sdmconfig_id'=> 0);
			$ulmid_6 = array('sdmconfig_id'=> 0);
			$ulmid_3_7_8 = array('sdmconfig_id'=> 0);
			$userlvmid = array();
			$data = array();
			$data_user = array();
			$user_data = array();
			$data_msem = array();
			$cp_user_data = array();
			$session = "";
			
			/**FDPO - Safe to be deleted**/
			//echo('<pre>');print_r($datatry);echo('</pre>');
			//die();
			
			if(isset($datatry))
			{
				$i = -1;
				$kv_list = $datatry['txtKvList'];
				$kvids = explode(';', $kv_list);
				
				foreach($datatry as $keys => $values)
				{
					if(strpos($keys,'slctsesi') !== false)
					{
						$session = explode(':', $values);
					}
					
					
					if(strpos($keys,'sdmctype') !== false)
					{
						
						
							foreach($values as $key => $value)
							{
								(strpos($key,'sdmconfig_id')!== false) ? $sdmconfig_id = $value : 0 ;
								(strpos($key,'sdm_open_date')!== false) ? $sdm_open_date = $value : null ;
								(strpos($key,'sdm_close_date')!== false) ? $sdm_close_date = $value : null ;
								(strpos($key,'sdm_assessment_type')!== false) ? $sdm_assessment_type = $value : null ;	
							}																				
			
							//make sure all date is valid then only proceed
							$pattern = "/^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/";
							if (preg_match($pattern, $sdm_open_date) && preg_match($pattern, $sdm_close_date))
							{	
								$a_data = array(
								'sdmconfig_id' => $sdmconfig_id,
								'sdm_current_session' => $session[0],
								'sdm_current_year' => $session[1],
								'sdm_current_semester' => 0,
								'sdm_open_date' => strtotime($sdm_open_date),
								'sdm_close_date' => strtotime($sdm_close_date),
								'sdm_assessment_type' => $sdm_assessment_type,
								'col_id' => 0,
								);
								array_push($data, $a_data);
							}
							
								
					} 
					
					if(strpos($keys,'usersdmconfig') !== false)
					{
							$ulm_sdmconfig_id = $values;
					}
					
					
					if(strpos($keys,'usermconfig') !== false)
					{
						foreach($values as $key2 => $value2)
						{
							if(strpos($key2,'ulmconfig_id')!== false)
							{
								$ulmconf_id = array(0,0,0);
								if(strlen($value2) > 1)
								{
									$ulmconf_id = explode(',', $value2);
								 	$ulmconfig_id = $ulmconf_id[0];
								}
								else
								{
									$ulmconfig_id = $value2;
								}
								 
							}
							
							(strpos($key2,'end_date_user')!== false) ? $end_date_user = $value2 : null ;
							
							if(strpos($key2,'ul_id')!== false)
							{
								if(strlen($value2) > 1)
								{
									$ulid = explode(',', $value2);
								 	$ul_id = $ulid[0]; 
								}
								else
								{
									$ul_id = $value2;
								}
							}
						}
						
						
						//make sure all date is valid then only proceed
						$pattern = "/^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/";
						if (preg_match($pattern, $end_date_user))
						{
							//For status in query 1=update 0=insert
							($ulmconfig_id ==! 0) ? $status = 1 : $status = 0 ;
								
							$u_data = array(
							'ulmconfig_id' => $ulmconfig_id,
							'sdmconfig_id' => $ulm_sdmconfig_id,
							'end_date_user' => strtotime($end_date_user),
							'ul_id' => $ul_id,
							);
							
							array_push($data_user, $u_data);
							
							$i++;
							
							if($i == 2 || $i == 5 || $i == 8 || $i == 11)
							{
								$index = 0;
								$i == 2 ?  $index = $i+0 : null;
								$i == 5 ?  $index = $i+2 : null;
								$i == 8 ?  $index = $i+4 : null;
								$i == 11 ?  $index = $i+6 : null;
								
								$valid_7 = array('ul_id' => $ulid[1],'ulmconfig_id' => $ulmconf_id[1]);
								$ulid_7 = array_merge($data_user[$index],$valid_7);    // replace only the wanted keys
								
								$valid_8 = array('ul_id' => $ulid[2],'ulmconfig_id' => $ulmconf_id[2]);
								$ulid_8 = array_merge($data_user[$index],$valid_8);    // replace only the wanted keys
								
								array_push($data_user, $ulid_7);
								array_push($data_user, $ulid_8);
							}
						}
						
					 
					}
					}
					
 					$cp_data_user = array("test");
					//Create user data for each kv.
					foreach($kvids as $kvid)
					{
						$kv_id = array('col_id' => $kvid);
						
						foreach ($datatry['chksem'] as $key => $value) 
						{
							$semdata = array('sdm_current_semester' => $value);
							
							foreach($data as $key2 => $value)
							{
								$kv_id = array_merge($kv_id,$semdata);
								$datamerge = array_merge($value,$kv_id);
								
								array_push($data_msem, $datamerge);
							}
							
							$cp_data_user = array_merge_recursive($cp_data_user,$data_user);
						}
						//$data_user += $data_user + $data_user;
						//$cp_data_user[] = $data_user;
						
					}
					
					array_shift($cp_data_user);
					
					$sdmconfig_ids = $this->m_assessment->save_assessment_manual_configuration($data_msem);
					
					/**FDPO - Safe to be deleted**/
					//echo('<pre>');print_r($data_msem);echo('</pre>');
					//echo('<pre>');print_r($sdmconfig_ids);echo('</pre>');
					//die();		
					
					if(isset($sdmconfig_ids) && $sdmconfig_ids>0)
					{
						$count = 1;
						$arrindex = 0;
						foreach($cp_data_user as $user)
						{
							$sdconf_insert = array('sdmconfig_id' => $sdmconfig_ids[$arrindex]);
							
							$user = array_merge($user,$sdconf_insert);    // replace only the wanted keys
						
							array_push($user_data, $user);
							
							if($count % 5 == 0 )
							{
								$arrindex++;
							}
							$count++;
						}
					}

					/**FDPO - Safe to be deleted**/
					//echo('<pre>');print_r($user_data);echo('</pre>');
					//die();
					
					$this->m_assessment->save_update_user_level_configuration($user_data,$status,$submit_date);

					//redirect('/examination/assessment','refresh');

					echo "1"; //done?
				}
				else 
				{
					echo "0";
				}
		}


		/******************************************************************************************
		* Description		: this function to delete assessment configuration manual
		* input				: - 
		* author			: Freddy Ajang Tony
		* Date				: 20 June 2013
		* Modification Log	: -
		******************************************************************************************/
		function delete_manual_configuration()
		{
			$id = $this->input->post("fid");
			$sesi = $this->input->post("sesi");
			
			$sesi_tahun = explode(':', $sesi);
			
			echo($this->m_assessment->delete_assessment_manual_configuration($id,$sesi_tahun[0],$sesi_tahun[1]));
		}
		
		
		/******************************************************************************************
		* Description		: this function to get assessment configuration by semester. 
		* input				: - 
		* author			: Freddy Ajang Tony
		* Date				: 24 July 2013
		* Modification Log	: -
		******************************************************************************************/
		function assessment_config_by_semester()
		{
			$user = $this->ion_auth->user()->row();
			$userid = $user->id;
			$current_session = $this->input->post("sesi");
			$current_year = $this->input->post("tahun");
			$semester = $this->input->post("semester");
			$type = $this->input->post("type");
			
			$data['semester_config'] = $this->m_assessment->get_assessment_config_by_semester($current_session,$current_year,$semester,$type);
			//$data['manual_semester_config'] = $this->m_assessment->get_manual_assessment_configuration($current_session,$current_year);
			/**FDPO - Safe to be deleted**/
			//echo('<pre>');print_r($data);echo('</pre>');
			//die();
			
	        $this->load->view('marking/v_assessment_configuration_ajax', $data);
			
		}
		
		
		/******************************************************************************************
		* Description		: this function to get group semester by session for vocasional. 
		* input				: - 
		* author			: Freddy Ajang Tony
		* Date				: 15 Aug 2013
		* Modification Log	: -
		******************************************************************************************/
		function get_group_semester_by_session_vk()
		{
			$user = $this->ion_auth->user()->row();
			$userid = $user->id;
			$datatry = $this->input->post("sesi");
			
			$session = explode(':',$datatry);
			
			$data['group_semester_vk'] = $this->m_assessment->get_group_semester($session[0],$session[1],'vk');
			
			/**FDPO - Safe to be deleted**/
			//echo('<pre>');print_r($data);echo('</pre>');
			//die();
			
			$this->load->view('marking/v_assessment_configuration_ajax', $data);
		}
		
		
		/******************************************************************************************
		* Description		: this function to get group semester by session for academic. 
		* input				: - 
		* author			: Freddy Ajang Tony
		* Date				: 23 Aug 2013
		* Modification Log	: -
		******************************************************************************************/
		function get_group_semester_by_session_ak()
		{
			$user = $this->ion_auth->user()->row();
			$userid = $user->id;
			$datatry = $this->input->post("sesi");
			
			$session = explode(':',$datatry);
			
			$data['group_semester_ak'] = $this->m_assessment->get_group_semester($session[0],$session[1],'ak');
			
			/**FDPO - Safe to be deleted**/
			//echo('<pre>');print_r($data);echo('</pre>');
			//die();
			
			$this->load->view('marking/v_assessment_configuration_ajax', $data);
		}

	}// end of Class
/**************************************************************************************************
* End of assessment.php
**************************************************************************************************/

?>