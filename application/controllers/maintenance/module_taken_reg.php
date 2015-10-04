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
class Module_taken_reg extends MY_Controller
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
		$this -> load -> model('m_module_taken');
		$this -> load -> model('m_general');
		$this -> load -> model('m_options');
		$this -> load -> model('m_student_management');
		$this -> load -> library('grocery_CRUD');
		$this -> load -> library('table');
	}

	function index()
	{
		$this->view_module_taken();
	}
	/**********************************************************************************************
	* Description	 : to load 1st view.
	* input	 : - 
	* author	 : Nabihah
	* Date	 : 19 March 2014
	* Modification Log	: -
	***********************************************************************************************/
	function view_module_taken()
	{
				$this->load->model('m_result');
                $user_login = $this -> ion_auth -> user() -> row();
                $colid = $user_login -> col_id;
                $userId = $user_login -> user_id;
                $state_id = $user_login -> state_id;
                $user_groups = $this -> ion_auth -> get_users_groups($userId) -> row();
                $ul_type = $user_groups -> ul_type;

                $this->load->library("datatables_amtis");
                $dtAmt = $this->datatables_amtis;
                
                $dtAmt->set_heading(array('Nama Murid','No MyKad','Angka Giliran','Status','Semester','Kursus','Kolej','Tindakan'));
                
                $aConfigDt['aoColumnDefs'] = '[
                                     { "sWidth": "25%", "aTargets": [ 0 ] },
                                     { "sWidth": "8%", "aTargets": [ 1 ] },
                                     { "sWidth": "8%", "aTargets": [ 2 ] },
                                     { "sWidth": "5%", "aTargets": [ 3 ] },
                                     { "sWidth": "7%", "aTargets": [ 4 ] },
                                     { "sWidth": "15%", "aTargets": [ 5 ] },
                                     { "sWidth": "15%", "aTargets": [ 6 ] },
                                     { "sWidth": "8%", "aTargets": [ 7 ] }
                            ]';
            $aConfigDt['bSort'] = 'true';
            $aConfigDt['aaSorting'] = '[[ 6, "asc"],[ 4, "asc"],[ 5, "asc"],[ 0, "asc"]]';
			
		//	$aConfigDt['']
                
                $dtAmt->setConfig($aConfigDt);
                $dtAmt->setAoData('nama','sName',false);
                $dtAmt->setAoData('sSlct_kv','sSlct_kv',false);
                $dtAmt->setAoData('sSlct_sem','sSlct_sem',false);
                $dtAmt->setAoData('sSlct_course','sSlct_course',false);
				
				
                $aDatatable = $dtAmt->generateView(site_url('maintenance/module_taken_reg/ajaxdata_search_student'),'tblStudent',true);

                $data = $aDatatable;

                $data['kv_list']=$this->m_general->kv_list();
                $data['state_list']=$this->m_general->state_list();
                $data['colid']=$colid;
                $data['centrecode']=$this->m_result->get_institusi();
                $data['kursuscode']=$this->m_result->get_kursus();
                $output['output']=$this->load->view('maintenance/v_module_student',$data,true);
                $this->_main_output($output);
	}


/**************************************************************************************************
	 * Description		: Function: to manage the view for each function
	 * Author			: Nabihah Ab.Karim, Refer to En.fakhruz for details
	 * Date				: 19 March 2014
	 * Input Parameter	: $output, $header
	 * Modification Log	: -
	 **************************************************************************************************/
	function _main_output($output = null, $header = '') {
		$this -> load -> view('main.php', $output);
	}

/**************************************************************************************************
	 * Description		: Function: generate suggestion of student name based on college id
	 * Author			: Nabihah Ab.Karim, Refer to En.fakhruz for details
	 * Date				: 20 March 2014
	 * Input Parameter	: $output, $header
	 * Modification Log	: -
	 **************************************************************************************************/	
	function ajax_student_autosuggest($colid=null){
		$term=$this->input->get('term');
		// $colid=$this->input->get('colid');
		$this->db->select('*');
		$this->db->from('student');
		$this->db->like('stu_name',$term);
		$this -> db -> join('college_course', 'college_course.cc_id=student.cc_id');
		
		if($colid!=null){
			$this->db->where('college_course.col_id',$colid);
		}
		
		$this->db->limit(10);
		$result=$this->db->get()->result();
		
		$respond=array();
		foreach ($result as $key) {
			$respond[] = strcap($key->stu_name);
		}
		
		echo json_encode($respond);
	}
/**************************************************************************************************
	 * Description		: Function: generate result of searching
	 * Author			: Nabihah Ab.Karim, Refer to En.fakhruz for details
	 * Date				: 20 March 2014
	 * Input Parameter	: $output, $header
	 * Modification Log	: -
	 **************************************************************************************************/		
	 function ajaxdata_search_student(){
                $this->load->library("datatables_amtis");

                $pName                         = $this->input->post('nama');
                $sSlct_kv                 = $this->input->post('sSlct_kv');
                $cC                         = explode("-", $sSlct_kv);
                $sSlct_kv                 = trim($cC[0]);
                $sSlct_sem                 = $this->input->post('sSlct_sem');
                $sSlct_course   = $this->input->post('sSlct_course');
                $sSearchCourse = "";

                if($sSlct_course != ""){
                	$aCourse = explode("-", $sSlct_course);
                	$sSearchCourse = trim($aCourse[1]);
                }

                $dtAmt = $this->datatables_amtis;
                
                if($pName != ""){ $dtAmt->like("student.stu_name", $pName, 'both');}

                if($sSlct_kv != ""){$dtAmt->like("college.col_name", $sSlct_kv, 'both');}

                if($sSlct_sem != ""){$dtAmt->like("student.stu_current_sem", $sSlct_sem, 'both');}

                if($sSearchCourse != ""){$dtAmt->like("course.cou_name", $sSearchCourse, 'both');}
                
                $dtAmt
                ->select('stu_id, stu_name, stu_mykad, stu_matric_no, stat_id, stu_current_sem, cou_name, col_name',FALSE)
                ->from('student')
                ->join('college_course','college_course.cc_id = student.cc_id')
                ->join('college','college.col_id=college_course.col_id')
                ->join('course','course.cou_id=college_course.cou_id')
                ->add_column('Tindakkan', '$1',"checkAction('maintenance/module_taken_reg/display_student_module/', stu_id)");

                $dtAmt->edit_column('stu_name', '$1',"formatName(stu_name)");
                $dtAmt->edit_column('stat_id', '$1',"formatNumber(stat_id)");
                $dtAmt->edit_column('stu_current_sem', '$1',"formatNumber(stu_current_sem)");

                $dtAmt->unset_column('stu_id');

                echo $dtAmt->generate();
        }


/**************************************************************************************************
	 * Description		: Function: Display module taken of student
	 * Author			: Nabihah Ab.Karim, Refer to En.fakhruz for details
	 * Date				: 21 March 2014
	 * Input Parameter	: $output, $header
	 * Modification Log	: -
	 **************************************************************************************************/		
	 function display_student_module($id=""){
	 		
			$data['student'] = $this->m_module_taken->get_student_detail($id);
			
			$data['module_taken'] = $this->m_module_taken->get_module_student($id, $data['student']->stu_current_sem);
			$cou = $this->m_module_taken->get_cou_id($id);
			//echo $cou->cou_id;
			$module = $this->m_module_taken->get_course_module($cou->cou_id, $data['student']->stu_current_sem);
			$course_module=array();
			
		//	echo  $data['student']->stu_current_sem;

			
			if(!empty($module))
			{
			foreach ($module as $key) {
				
				if ($data['student']->stu_religion == "ISLAM" || $data['student']->stu_religion == "islam" || $data['student']->stu_religion == "Islam") 
				{
					if ($key->mod_code != 'A07') 
					{
					
						array_push($course_module, $key);
					}

				} 
				else 
				{
					if ($key->mod_code != 'A06') 
					{
						array_push($course_module, $key);
					}
				}
				}
			}
			$data['course_module']= $course_module;
			$output['output'] = $this->load->view('maintenance/v_module_taken_reg',$data,true);
			$this -> _main_output($output);
	 	
        }
/**************************************************************************************************
	 * Description		: Function: Save Module
	 * Author			: Nabihah Ab.Karim, Refer to En.fakhruz for details
	 * Date				: 24 March 2014
	 * Input Parameter	: $output, $header
	 * Modification Log	: -
	 **************************************************************************************************/			 
	 function save_module()
	 {
	 	//$mod = $this->input->post('module');
	 	$ins_batch=array();
		$stu_id = $this->input->post('student');
		$sem = $this->input->post('semester');
		if(isset($_POST['module'])){
		if (is_array($_POST['module'])) {
    	foreach($_POST['module'] as $value){
      		$data_module_taken = array('mt_semester' => $sem, 'mt_year' => $this -> session -> userdata["tahun"], 'mt_full_mark' => '', 'mt_status' => '1', 'stu_id' => $stu_id, 'mod_id' => $value, 'grade_id' => null, 'exam_status' => '1');
			array_push($ins_batch, $data_module_taken);
    		}
			}
  		}
		
		$sta = $this->m_module_taken->insert_module($ins_batch);
		echo $sta;
		
	
		
	 }
	
}