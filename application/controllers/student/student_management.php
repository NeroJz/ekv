<?php
/**************************************************************************************************
 * Description		: Class for student management module. This class will perform the needed
 *					: operation for the module to work
 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
 * Date				: 10 July 2013
 * Input Parameter	: -
 * Modification Log	: -
 **************************************************************************************************/
class Student_management extends MY_Controller {

	/**************************************************************************************************
	 * Description		: Constructor: It loads the required model and libraries.
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: -
	 * Modification Log	: -
	 **************************************************************************************************/
	function __construct() {
		parent::__construct();
		$this -> load -> model('m_general');
		$this -> load -> model('m_options');
		$this -> load -> model('m_student_management');
		$this -> load -> library('grocery_CRUD');
		$this -> load -> library('table');
	}

	/**************************************************************************************************
	 * Description		: Function: to manage the view for each function
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: $output, $header
	 * Modification Log	: -
	 **************************************************************************************************/
	function _main_output($output = null, $header = '') {
		$this -> load -> view('main.php', $output);
	}

	/**************************************************************************************************
	 * Description		: Function: to manage the view for each function
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: $output, $header
	 * Modification Log	: -
	 **************************************************************************************************/
	function _empty_output($output = null, $header = '') {
		$this -> load -> view('student/v_table.php', $output);
	}

	/**************************************************************************************************
	 * Description		: Index of the class where it first load the code
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: -
	 * Modification Log	: -
	 **************************************************************************************************/
	function index() {
		$this -> search_student2();
	}

	/**************************************************************************************************
	 * Description		: Function which uses Grocery CRUD to list add the informations in the student table
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: -
	 * Modification Log	: -
	 **************************************************************************************************/
	function list_all() {
		$crud = new grocery_CRUD();
		$crud -> set_table('student');
		$crud -> set_subject('Student');
		$crud -> unset_fields('cc_id', 'stu_group');
		$crud -> columns('stu_name', 'stu_mykad', 'stu_matric_no', 'callback_course', 'stu_gender', 'stu_race', 'stu_religion');
		$crud -> callback_column('callback_course', array($this, 'fcallback_course'));
		$crud -> display_as('callback_course', 'Course');

		$output = $crud -> render();
		$this -> _main_output($output, null);
	}

	/**************************************************************************************************
	 * Description		: Function callback to be used in the list_all function
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: $stu_mykad, $row
	 * Modification Log	: -
	 **************************************************************************************************/
	function fcallback_course($stu_mykad, $row) {
		echo $stu_mykad;
		$html = '';
		$positions = $this -> db -> get_where('college_course', array('cc_id' => $row -> cc_id)) -> result_array();
		if ($positions) {
			foreach ($positions as $items2) {
				$positions2 = $this -> db -> get_where('course', array('cou_id' => $items2['cou_id'])) -> result_array();
				foreach ($positions2 as $items2) {
					$html .= $items2['cou_course_code'] . ' (' . $items2['cou_name'] . ')';
				}
			}
		}
		return $html;
	}

	/**************************************************************************************************
	 * Description		: FOR DEBUGGING PURPOSE ONLY
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: -
	 * Modification Log	: -
	 **************************************************************************************************/
	function callback_add_course() {
		return "<select><option>hello</option></select>";
	}

	/**************************************************************************************************
	 * Description		: FOR DEBUGGING PURPOSE ONLY
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: -
	 * Modification Log	: 6 Sept 2013 by Mior - Buat paparan kv dan kursus ikut user login
	 **************************************************************************************************/
	function add() { //temporary solution before fix guna AjaxForm
		$user_login = $this -> ion_auth -> user() -> row();		
		$data['id_pusat'] = $user_login -> col_id;
		$data['option'] = $this -> m_general -> kv_list();
		$data['cou_list_for_kupp'] = $this -> m_general -> kursus_list_by_kv($user_login -> col_id);	
		$output['output'] = $this -> load -> view('student/v_student_tambah_pelajar', $data, true);
		$this -> load -> view('mainRegisterStudent.php', $output);
	}

	//// umairah - update 24/1/14 //get class for registration kv
	function get_kelas()
	{
		$user_login = $this->ion_auth->user()->row();
		$col_id = $user_login->col_id;
			
		$course_id = $this->input->post('course_kv');
		$cc_id = $this->m_general->get_cc_id($course_id);
		//print_r($course_id);
		//print_r($cc_id);
		//die();	
		$data['kelas'] = $this->m_general->get_class($col_id,$cc_id);
		//echo('<pre>');print_r($data);echo('</pre>');
		//die();
		echo json_encode($data);
	}
	
	/**************************************************************************************************
	 * Description		: Function to display the complete information about student, their course,
	 *					: and the KV they are in.
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: $kv_i
	 * Modification Log	: -
	 **************************************************************************************************/
	function search_student($kv_id = null, $sem = null, $gender = null, $race = null, $status = null, $state = null) {
		$this -> load -> library('table');
		$slct_kv = $this -> input -> post('slct_kv');
		$slct_sem = $this -> input -> post('slct_sem');
		$slct_gender = $this -> input -> post('slct_gender');
		$slct_race = $this -> input -> post('slct_race');
		$slct_status = $this -> input -> post('slct_status');
		$slct_state = $this -> input -> post('slct_state');
		$user_login = $this -> ion_auth -> user() -> row();
		$colid = $user_login -> col_id;
		$userId = $user_login -> user_id;
		$state_id = $user_login -> state_id;

		$user_groups = $this -> ion_auth -> get_users_groups($userId) -> row();
		$ul_type = $user_groups -> ul_type;

		$this -> db -> from('student');
		if ($slct_kv != null) {
			$this -> db -> where('college_course.col_id', $slct_kv);
		}
		if ($slct_sem != null) {
			$this -> db -> where('student.stu_current_sem', $slct_sem);
		}
		if ($slct_gender != null) {
			$this -> db -> where('student.stu_gender', $slct_gender);
		}
		if ($slct_race != null) {
			$this -> db -> where('student.stu_race', $slct_race);
		}
		if ($slct_status != null) {
			$this -> db -> where('student.stat_id', $slct_status);
		}
		if ($slct_state != null) {
			$this -> db -> where('student.state_id', $slct_state);
		}
		$this -> db -> join('college_course', 'college_course.cc_id = student.cc_id');
		$this -> db -> join('course', 'course.cou_id = college_course.cou_id');
		$this -> db -> join('college', 'college.col_id = college_course.col_id');
		$query = $this -> db -> get() -> result_array();

		$data['kursus'] = $this -> m_general -> kursus_list();
		$data['state_list'] = $this -> m_general -> state_list();
		$data['kv_list'] = $this -> m_general -> kv_list();
		$data['current_kv'] = $kv_id;
		$data['query'] = $query;
		$kv_list = $this -> m_general -> kv_list();

		$option = '';
		if ($colid == "" || $colid == NULL || $colid == '0') {
			$option .= "<option value=''>Sila Pilih</option>";
			foreach ($kv_list as $row) {
				$option .= "<option value=$row->col_id>$row->col_name</option>";
			}
			$data['kv_list_option'] = $option;
		} else {
			foreach ($kv_list as $row) {
				if ($row -> col_id == $colid) {
					$option = "<option value=$row->col_id>$row->col_name</option selected>";
				}
			}
			$data['kv_list_option'] = $option;
		}

		$output['output'] = $this -> load -> view('student/v_student_management', $data, true);
		$this -> _main_output($output);
	}

	/**************************************************************************************************
	 * Description		: Function to let the user choose the course for the newly registered student.
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: -
	 * Modification Log	: -
	 **************************************************************************************************/
	function search_student2(){
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
                
                $dtAmt->setConfig($aConfigDt);
                $dtAmt->setAoData('nama','sName',false);
                $dtAmt->setAoData('sSlct_kv','sSlct_kv',false);
                $dtAmt->setAoData('sSlct_sem','sSlct_sem',false);
                $dtAmt->setAoData('sSlct_course','sSlct_course',false);
                $aDatatable = $dtAmt->generateView(site_url('student/student_management/ajaxdata_search_student'),'tblStudent',true);

                $data = $aDatatable;

                $data['kv_list']=$this->m_general->kv_list();
                $data['state_list']=$this->m_general->state_list();
                $data['colid']=$colid;
                $data['centrecode']=$this->m_result->get_institusi();
                $data['kursuscode']=$this->m_result->get_kursus();
                $data['student_autosuggest']=$this->m_student_management->autosuggest_student();
                $output['output']=$this->load->view('student/v_student_management2',$data,true);
                $this->_main_output($output);
	}
	
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
                ->add_column('Tindakkan', '$1',"checkAction('student/student_management/display_update_student/', stu_id)");

                $dtAmt->edit_column('stu_name', '$1',"formatName(stu_name)");
                $dtAmt->edit_column('stat_id', '$1',"formatNumber(stat_id)");
                $dtAmt->edit_column('stu_current_sem', '$1',"formatNumber(stu_current_sem)");

                $dtAmt->unset_column('stu_id');

                echo $dtAmt->generate();
        }

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
			$respond[] = $key->stu_name;
		}
		
		echo json_encode($respond);
	}
	
	function ajax_kv_autosuggest($colid=null){
		$term=$this->input->get('term');
		// $colid=$this->input->get('colid');
		$this->db->select('*');
		$this->db->from('college');
		$this->db->like('col_name',$term);
		$this->db->limit(10);
		$result=$this->db->get()->result();
		
		$respond=array();
		foreach ($result as $key) {
			$respond[] = $key->col_name;
		}
		
		echo json_encode($respond);
	}
	
	function ajax_student_matric_autossuggest($colid=null){
		$term=$this->input->get('term');
		$term=$this->input->get('colid');
		$this->db->select('stu_matric_no,college_course.col_id');
		$this->db->from('student');
		$this->db->like('stu_matric_no',$term);
		$this->db->where('college_course.col_id',$colid);
		$this -> db -> join('college_course', 'college_course.cc_id=student.cc_id');
		$this->db->limit(10);
		$result=$this->db->get()->result();
		
		$respond=array();
		foreach ($result as $key) {
			$respond[] = $key->stu_matric_no;
		}
		
		echo json_encode($respond);
	}
	 
	/**************************************************************************************************
	 * Description		: Function to let the user choose the course for the newly registered student.
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: -
	 * Modification Log	: -
	 **************************************************************************************************/
	function choose_course() {
		$data['hidden'] = array('no_kp' => $this -> input -> post('no_kp'), 'nama' => $this -> input -> post('nama'), 'gender' => $this -> input -> post('jantina'), 'cur_sem' => $this -> input -> post('cur_sem'), 'cur_year' => $this -> input -> post('cur_year'), 'intake_sess' => $this -> input -> post('intake_sess'), 'group' => $this -> input -> post('group'), 'cc_id' => $this -> input -> post('cc_id'), 'race' => $this -> input -> post('bangsa'), 'religion' => $this -> input -> post('agama'), 'stat_id' => $this -> input -> post('stat_id'), 'group' => $this -> input -> post('group'), 'semester' => $this -> input -> post('semester'), 'kv' => $this -> input -> post('kv'), 'status' => $this -> input -> post('status'));

		$data['list_course'] = $this -> m_general -> kursus_list_by_kv($this -> input -> post('kv'));
		$kv_list = $this -> m_general -> kv_list($this -> input -> post('kv'));
		foreach ($kv_list as $row) {
			$data['kv_name'] = $row -> col_name;
		}

		$output['output'] = $this -> load -> view('student/v_student_choose_course', $data, true);

		$this -> _main_output($output);
	}

	/**************************************************************************************************
	 * Description		: Function to let the user choose the course for the newly registered student.
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: -
	 * Modification Log	: -
	 **************************************************************************************************/
	function choose_course_ajax() {
		$cou_list = $this -> m_general -> kursus_list_by_kv($this -> input -> post('kv'));
		
		foreach ($cou_list as $row) {
			echo "<option value=" . $row -> cou_id . ">" . $row -> cou_name . "</option>";
		}
	}

	/**************************************************************************************************
	 * Description		: Function to add new student with complete information on course, module,
	 *					: module taken, and KV.
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: -
	 * Modification Log	: -
	 **************************************************************************************************/
	function add_student() {
		$userSesi      = $this -> session -> userdata["sesi"];
		$userYear      = $this -> session -> userdata["tahun"];
		
		$no_kp         = $this -> input -> post('no_kp');
		$no_kp         = str_replace('-', null, $no_kp);
		$nama          = $this -> input -> post('nama');
		$gender        = $this -> input -> post('jantina');
		$cur_sem       = $this -> input -> post('semester');
		$cur_year      = $userYear;
		$intake_sess   = $userSesi . " " . date('Y');
		$group         = $this -> input -> post('kelas');
		$cc_id         = $this -> input -> post('cc_id');
		$race          = $this -> input -> post('bangsa');
		$religion      = $this -> input -> post('agama');
		$semester      = $this -> input -> post('semester');
		$kv            = $this -> input -> post('kv');
		$cou           = $this -> input -> post('course');
		$status        = $this -> input -> post('status');
		$date_of_birth = $this -> input -> post('date_of_birth');
		$address1      = $this -> input -> post('address1');
		$address2      = $this -> input -> post('address2');
		$address3      = $this -> input -> post('address3');
		$postcode      = $this -> input -> post('postcode');
		$city          = $this -> input -> post('city');
		$state         = $this -> input -> post('state');
		$nationality   = $this -> input -> post('nationality');
		$matrik        = generateMatricNo($kv, $cou);

		$base64Img	   = $this -> input -> post("rawPhoto");
		
		$state_id      = $this->m_student_management->get_state_by_state($state);
		
		$data_cc       = array('col_id' => $kv, 'cou_id' => $cou);
		//$this -> m_student_management -> insert_college_course($data_cc); //FOR DEBUGGING PURPOSE
		
		$raw_cc_id     = $this -> m_student_management -> get_ccid($cou, $kv);
		$cc_id         = $raw_cc_id[0];
		
		$data_stu      = array(
			'stu_mykad'          => $no_kp,
			'stu_matric_no'      => $matrik,
			'stu_name'           => $nama,
			'stu_gender'         => $gender,
			'stu_current_sem'    => $cur_sem,
			'stu_current_year'   => $cur_year,
			'stu_intake_session' => $intake_sess,
			'stu_group'          => $group,
			'cc_id'              => $cc_id['cc_id'],
			'stu_race'           => $race,
			'stu_religion'       => $religion,
			'stat_id'            => $status,
			'stu_birth_date'     => $date_of_birth,
			'stu_address1'       => $address1,
			'stu_address2'       => $address2,
			'stu_address3'       => $address3,
			'stu_poscode'        => $postcode,
			'stu_nationality'    => $nationality,
			'state_id'			 => $state_id
			);

		if(!empty($base64Img)){
			$data_stu["stu_photo"] = $base64Img;
		}
			
		$arr_sta = array();
		$statusInsertStudent = $this -> m_student_management -> insert_student($data_stu);
		if($statusInsertStudent){
			$query = $this -> m_student_management -> get_student_by_matric_no($matrik);
			foreach ($query as $row) {
				$stu_id = $row['stu_id'];
			}
			// $mod_id = $this -> m_student_management -> get_mod_id_by_stu_id($stu_id);
			$mod_id = $this -> m_student_management -> get_course_module_by_cou_id($cou, $semester);
			
			//edit by sukor and mior....this is for temporary
			if(!empty($mod_id))
			{
				//print_r($mod_id);	
			foreach ($mod_id as $key) {
				
				if ($religion == "ISLAM" || $religion == "islam" || $religion == "Islam") 
				{
					if ($key['mod_code'] != 'A07') 
					{
						$data_module_taken = array('mt_semester' => $cur_sem, 'mt_year' => $this -> session -> userdata["tahun"], 'mt_full_mark' => '', 'mt_status' => '1', 'stu_id' => $stu_id, 'mod_id' => $key['mod_id'], 'grade_id' => null, 'exam_status' => '1');
						$sta =$this -> m_student_management -> insert_module_taken($data_module_taken);
						array_push($arr_sta, $sta);
					}

				} 
				else 
				{
					if ($key['mod_code'] != 'A06') 
					{
						$data_module_taken = array('mt_semester' => $cur_sem, 'mt_year' => $this -> session -> userdata["tahun"], 'mt_full_mark' => '', 'mt_status' => '1', 'stu_id' => $stu_id, 'mod_id' => $key['mod_id'], 'grade_id' => null, 'exam_status' => '1');
						$sta = $this -> m_student_management -> insert_module_taken($data_module_taken);
						array_push($arr_sta, $sta);
					}
				}
				
				
			}
			
				//echo 'insert';
			}
		//print_r($arr_sta);
		if(empty($arr_sta) || in_array(0, $arr_sta))
		{
			echo 'errormodule';
		}
		
		//else if($arr_sta)
		
		else
		{
			echo 'insert';
		}
			/*else 
			{
				echo 'errormodule';	
			}*/
			
		}
		else
		{
			echo 'error';
		}
		//redirect('/student/student_management/add/');
	}

	/**************************************************************************************************
	 * Description		: Function to add new student with complete information on course, module,
	 *					: module taken, and KV using offline method.
	 * Author			: Fakhruz
	 * Date				: 9 Mar 2014
	 * Input Parameter	: -
	 * Modification Log	: -
	 **************************************************************************************************/
	function add_student_offline() {

		$userSesi      = $this -> session -> userdata["sesi"];
		$userYear      = $this -> session -> userdata["tahun"];
		
		$no_kp         = $this -> input -> post('no_kp');
		$no_kp         = str_replace('-', null, $no_kp);
		$nama          = $this -> input -> post('nama');
		$gender        = $this -> input -> post('jantina');
		$cur_sem       = $this -> input -> post('semester');
		$cur_year      = $userYear;
		$intake_sess   = $userSesi . " " . date('Y');
		$group         = $this -> input -> post('kelas');
		$cc_id         = $this -> input -> post('cc_id');
		$race          = $this -> input -> post('bangsa');
		$religion      = $this -> input -> post('agama');
		$semester      = $this -> input -> post('semester');
		$kv            = $this -> input -> post('kv');
		$cou           = $this -> input -> post('course');
		$status        = $this -> input -> post('status');
		$date_of_birth = $this -> input -> post('date_of_birth');
		$address1      = $this -> input -> post('address1');
		$address2      = $this -> input -> post('address2');
		$address3      = $this -> input -> post('address3');
		$postcode      = $this -> input -> post('postcode');
		$city          = $this -> input -> post('city');
		$state         = $this -> input -> post('state');
		$nationality   = $this -> input -> post('nationality');
		$matrik        = generateMatricNo($kv, $cou);
		
		$state_id      = $this->m_student_management->get_state_by_state($state);
		
		$data_cc       = array('col_id' => $kv, 'cou_id' => $cou);
		//$this -> m_student_management -> insert_college_course($data_cc); //FOR DEBUGGING PURPOSE
		
		$raw_cc_id     = $this -> m_student_management -> get_ccid($cou, $kv);
		$cc_id         = $raw_cc_id[0];
		
		$data_stu      = array(
			'stu_mykad'          => $no_kp,
			'stu_matric_no'      => $matrik,
			'stu_name'           => $nama,
			'stu_gender'         => $gender,
			'stu_current_sem'    => $cur_sem,
			'stu_current_year'   => $cur_year,
			'stu_intake_session' => $intake_sess,
			'stu_group'          => $group,
			'cc_id'              => $cc_id['cc_id'],
			'stu_race'           => $race,
			'stu_religion'       => $religion,
			'stat_id'            => $status,
			'stu_birth_date'     => $date_of_birth,
			'stu_address1'       => $address1,
			'stu_address2'       => $address2,
			'stu_address3'       => $address3,
			'stu_poscode'        => $postcode,
			'stu_nationality'    => $nationality,
			'state_id'			 => $state_id
			);
		$statusInsertStudent = $this -> m_student_management -> insert_student($data_stu);
		if($statusInsertStudent){
			$query = $this -> m_student_management -> get_student_by_matric_no($matrik);
			foreach ($query as $row) {
				$stu_id = $row['stu_id'];
			}
			// $mod_id = $this -> m_student_management -> get_mod_id_by_stu_id($stu_id);
			$mod_id = $this -> m_student_management -> get_course_module_by_cou_id($cou, $semester);

			//edit by sukor and mior....this is for temporary

			foreach ($mod_id as $key) {
				if ($religion == "ISLAM" || $religion == "islam" || $religion == "Islam") {
					if ($key['mod_code'] != 'A07') {

						$data_module_taken = array('mt_semester' => $cur_sem, 'mt_year' => $this -> session -> userdata["tahun"], 'mt_full_mark' => '', 'mt_status' => '1', 'stu_id' => $stu_id, 'mod_id' => $key['mod_id'], 'grade_id' => null, 'exam_status' => '1');
						$this -> m_student_management -> insert_module_taken($data_module_taken);
					}

				} else {
					if ($key['mod_code'] != 'A06') {
						$data_module_taken = array('mt_semester' => $cur_sem, 'mt_year' => $this -> session -> userdata["tahun"], 'mt_full_mark' => '', 'mt_status' => '1', 'stu_id' => $stu_id, 'mod_id' => $key['mod_id'], 'grade_id' => null, 'exam_status' => '1');
						$this -> m_student_management -> insert_module_taken($data_module_taken);
					}
				}
			}
			print_r($data_stu);
			echo 'insert';
		}
		else
		{
			echo 'error';
		}
		//redirect('/student/student_management/add/');
	}

	/**************************************************************************************************
	 * Description		: Function to display the interface to update the student's information
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: $id - student.stu_id
	 * Modification Log	: - siti umairah - 20 december 2013
	 **************************************************************************************************/
	function display_update_student($id) {
		$session=$this->session->all_userdata();

		$student = $this -> m_student_management -> get_student_by_id($id);
		//print_r($student);  //FDP
		$student = $student[0];
		// print_r($student);  //FDP
		$cc = $this -> m_student_management -> get_college_course_by_cc_id($student['cc_id']);
		$cc = $cc[0];

		$data['stu_id'] = $id;
		$data['cc_id'] = $student['cc_id'];
		$data['nama'] = $student['stu_name'];
		$data['no_kp'] = $student['stu_mykad'];
		$data['jantina'] = $student['stu_gender'];
		$data['bangsa'] = $student['stu_race'];
		$data['agama'] = $student['stu_religion'];
		$data['group'] = $student['class_name'];
		$data['semester'] = $student['stu_current_sem'];
		$data['kv'] = $cc['col_id'];
		$data['kursus_id'] = $cc['cou_id'];
		$data['stat_id'] = $student['stat_id'];
		$data["stu_photo"] = $student['stu_photo'];
		// print_r($data['stat_id']);   //FDP

		$explode=explode(" ",$student['stu_intake_session']);
		
		$query=$this->m_student_management->get_register_schedule($explode[0],$explode[1]);
		$result=$query->result();
		$today=date('Y-m-d');

		if($query->num_rows()>0){
			foreach ($result as $key) {
				if($today<$key->rs_close_date){
					$data['editable'] = 1;
				}else{
					$data['editable'] = 0;
				}
			}
		}else
			$data['editable'] = 0;

		$data['list_course'] = $this -> m_general -> kursus_list_by_kv($data['kv']);
		$kv_list = $this -> m_general -> kv_list($this -> input -> post('kv'));
		foreach ($kv_list as $row) {
			$data['kv_name'] = $row -> col_name;
		}
		$data['kursus'] = $this -> m_general -> kursus_list();
		$data['kv_list'] = $this -> m_general -> kv_list();
		$output['output'] = $this -> load -> view('student/v_student_update', $data, true);

		$this -> _main_output($output);
	}

	/**************************************************************************************************
	 * Description		: Function to perform the update operation from the data got from display_update_student
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: -
	 * Modification Log	: -
	 **************************************************************************************************/
	function update_student() {
		$cc_id = $this -> input -> post('cc_id');
		$stu_id = $this -> input -> post('stu_id');
		$nama = $this -> input -> post('nama');
		$no_kp = $this -> input -> post('no_kp');
		$jantina = $this -> input -> post('jantina');
		$bangsa = $this -> input -> post('bangsa');
		$agama = $this -> input -> post('agama');
		$group = $this -> input -> post('group');
		$semester = $this -> input -> post('semester');
		$kv = $this -> input -> post('kv');
		$kursus = $this -> input -> post('kursus');
		$status = $this -> input -> post('status');
		
		$no_kp=str_replace('-',null,$no_kp);
		
		$data = array('stu_mykad' => $no_kp, 'stu_name' => $nama, 'stu_gender' => $jantina, 'stu_current_sem' => $semester, 'stu_group' => $group, 'stu_race' => $bangsa, 'stu_religion' => $agama, 'stat_id' => $status,'cc_id'=>$kursus);
		$this -> m_student_management -> update_student($stu_id, $data);

		// $data_cc = array('col_id' => $kv, 'cou_id' => $kursus);
		// $this -> m_student_management -> update_college_course($cc_id, $data_cc);

		redirect(site_url() . '/student/student_management', 'refresh');
	}

	/**************************************************************************************************
	 * Description		: FOR DEBUGGING PURPOSE ONLY. Function to display the college_course table using the Grocery CRUD.
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: -
	 * Modification Log	: -
	 **************************************************************************************************/
	function info_college_course() {
		$crud = new grocery_CRUD();
		$crud -> set_theme('flexigrid');
		$crud -> set_subject('College');
		$crud -> set_table('college');
		$crud -> set_relation_n_n('College_Course', 'college_course', 'course', 'col_id', 'cou_id', 'cou_name');
		$output .= $crud -> render();
		$this -> _main_output($output, null);
	}

	/**************************************************************************************************
	 * Description		: Function to get the course list from the selected KV using the input parameter
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: $id - represent KV id
	 * Modification Log	: -
	 **************************************************************************************************/
	function dropdown_data($id) {
		$query = $this -> m_general -> kursus_list_by_kv($id);

		$result = '';
		foreach ($query as $key) {
			echo $result .= "<option value=" . $key -> cou_id . ">" . $key -> cou_name . "</option>";
		}
	}

	/**************************************************************************************************
	 * Description		: FOR DEBUGGING PURPOSE ONLY. Function which uses Grocery CRUD to list add the informations in the student table
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: -
	 * Modification Log	: -
	 **************************************************************************************************/
	function info_student() {
		$crud = new grocery_CRUD();
		$crud -> set_theme('flexigrid');
		$crud -> set_subject('College Course');
		$crud -> set_table('college_course');
		$crud -> set_relation('cc_id', 'student', 'stu_name');
		$crud -> set_relation('col_id', 'college', 'col_name');
		$crud -> set_relation('cou_id', 'course', 'cou_name');
		$output = $crud -> render();
		$this -> _main_output($output, null);
	}

	/**************************************************************************************************
	 * Description		: FOR DEBUGGING PURPOSE ONLY. Function which uses Grocery CRUD to list add the informations in the student table
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: -
	 * Modification Log	: -
	 **************************************************************************************************/
	function display_pindah($id) {//SAMBUNG
		$result = $this -> m_student_management -> get_stu_detail_by_stuid($id) -> result_array();
		$student = $result[0];
		$kv_list = $this -> m_student_management -> get_college_by_course($student['cou_id']) -> result_array();
		$student['kv_list'] = $kv_list;
		$data['output'] = $this -> load -> view('student/v_student_pindah_found', $student, true);
		$this -> load -> view('main', $data);
	}

	/**************************************************************************************************
	 * Description		: Function which uses Grocery CRUD to list add the informations in the student table
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: -
	 * Modification Log	: -
	 **************************************************************************************************/
	function pindah() {
		$user_login = $this -> ion_auth -> user() -> row();
		$colid = $user_login -> col_id;
		// print_r($user_login);

		// $output['output'] = $this -> load -> view('student/v_student_pindah_search', '', true);

		$form = $this -> input -> post('form_submit');
		$nama = $this -> input -> post('nama');
		$angka_giliran = $this -> input -> post('angka_giliran');
		$mykad = $this -> input -> post('mykad');
		$kursus = $this -> input -> post('kursus');
		$col_id = $this -> input -> post('colid');
		
		
		$result = $this -> m_student_management -> search_student_kupp($nama, $angka_giliran, $mykad, $kursus, $colid);
			
		foreach ($result as $row) {
			// $link_pindah="<center><a href='".site_url()."/student/student_management/display_pindah/$row->stu_id'>Pindah <i class='icon-chevron-right'></i></a></center>";
			// $this->table->add_row($row->stu_name,$row->stu_matric_no,$row->stu_mykad,$row->cou_id,$link_pindah);
		}
		
		$content['table'] = $result;
		$content['colid'] = $colid;
		$data['output'] = $this -> load -> view('student/v_student_pindah_search', $content, true);
		$output = $this -> load -> view('main', $data, true);

		$this -> _main_output($output);
	}

	/**************************************************************************************************
	 * Description		: FOR DEBUGGING PURPOSE ONLY. Function which uses Grocery CRUD to list add the informations in the student table
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: -
	 * Modification Log	: -
	 **************************************************************************************************/
	function display_transfer_student() {//SAMBUNG
		$user_login = $this -> ion_auth -> user() -> row();
		$colid = $user_login -> col_id;

		$cc_id = $this -> m_student_management -> get_cc_id_by_col_id($colid);
		$array_cc_id = "";
		foreach ($cc_id as $key) {
			$array_cc_id .= $key -> cc_id . ",";
		}
		$array_cc_id = substr($array_cc_id, 0, -1);

		$crud = new grocery_CRUD();
		$crud -> set_theme('flexigrid');
		$crud -> set_subject('Student');
		$crud -> set_table('student');
		$crud -> set_primary_key('cc_id', 'student');
		$crud -> set_relation_n_n('Course', 'college_course', 'course', 'cc_id', 'cou_id', 'cou_name');
		$crud -> set_relation_n_n('College', 'college_course', 'college', 'cc_id', 'col_id', 'col_name');
		$crud -> where('stat_id', 4);
		$query_where = "temp_cc_id IN ($array_cc_id)";
		$crud -> where($query_where);
		$crud -> callback_column('new_kv', array($this, 'new_kv_add_callback'));
		$crud -> callback_column('amount', array($this, 'amount_field_add_callback'));
		$crud -> fields('amount');
		$crud -> unset_add();
		$crud -> unset_delete();
		$crud -> unset_edit();

		$crud -> columns('stu_mykad', 'stu_name', 'stu_matric_no', 'College', 'new_kv', 'Course', 'stu_gender', 'stu_race', 'stu_religion', 'stu_current_sem', 'amount');

		$crud -> display_as('stu_mykad', 'MyKad') -> display_as('stu_name', 'Nama') -> display_as('stu_matric_no', 'Angka Giliran') -> display_as('Course', 'Kursus') -> display_as('College', 'KV') -> display_as('new_kv', 'KV Baru') -> display_as('stu_gender', 'Jantina') -> display_as('stu_race', 'Bangsa') -> display_as('stu_religion', 'Agama') -> display_as('stu_current_sem', 'Semester Sekarang') -> display_as('amount', 'Tindakan');

		$output = $crud -> render();
		$this -> _main_output($output, null);
	}

	function amount_field_add_callback($value = '', $row) {
		$js = '
		<script>
		$( function() {
		    $("button[data-href]").click( function() {
		        location.href = $(this).attr("data-href");
		    });
		});
		</script>
		';
		$button = '<button class="btn btn-success" data-href="' . site_url() . '/student/student_management/approve_transfer/' . $row -> stu_current_sem . '/' . $row -> temp_cc_id . '/' . $row -> stu_id . '/">Lulus</button>';
		$button .= "&nbsp;<button class='btn btn-danger' data-href='" . site_url() . "/student/student_management/batal_pemindahan/$row->stu_id/'>Batal</button>";
		return $js . $button;
	}

	function batal_pemindahan() {
		$id = $this -> uri -> segment(4);
		$data = array('stat_id' => 5);
		$this -> db -> where('stu_id', $id);
		$this -> db -> update('student', $data);
		redirect(site_url("student/student_management/pergerakkan"));
	}

	function new_kv_add_callback($value = '', $row) {
		$query = $this -> m_student_management -> get_college_by_cc_id($row -> temp_cc_id);
		foreach ($query as $key) {
			$kv_name = $key -> col_name;
		}
		return $kv_name;
	}

	/**************************************************************************************************
	 * Description		: FOR DEBUGGING PURPOSE ONLY. Function which uses Grocery CRUD to list add the informations in the student table
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: -
	 * Modification Log	: -
	 **************************************************************************************************/
	function change_status() {
		$cou_id = $this -> input -> post('cou_id');
		$stu_id = $this -> input -> post('stu_id');
		$temp_kv = $this -> input -> post('temp_kv');

		$result_cc_id = $this -> m_student_management -> get_cc_id($temp_kv, $cou_id);

		foreach ($result_cc_id as $row) {
			$temp_cc_id = $row -> cc_id;
		}

		$this -> m_student_management -> change_student_status($stu_id, 4);
		$this -> m_student_management -> change_student_temp_cc_id($stu_id, $temp_cc_id);
		echo "Status murid sedia untuk dipindahkan.";
	}

	/**************************************************************************************************
	 * Description		: FOR DEBUGGING PURPOSE ONLY. Function which uses Grocery CRUD to list add the informations in the student table
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: -
	 * Modification Log	: - umairah update stu_group - 26/1/14
	 **************************************************************************************************/
	function approve_transfer() {
		$this->load->model('m_announcement');
		$stu_current_sem	= $this -> uri -> segment(4, 0);
		$temp_cc_id 		= $this -> uri -> segment(5, 0);
		$stu_id 			= $this -> uri -> segment(6, 0);
		$kolej_asal			= $this -> uri -> segment(7, 0);
		$kolej_pindah		= $this -> uri -> segment(8, 0);
		$user_login = $this->ion_auth->user()->row();
		$colid = $user_login->col_id;
		$userId = $user_login->user_id;
		$state_id= $user_login->state_id;

		$user_groups = $this->ion_auth->get_users_groups($userId)->row();  
		$ul_type= $user_groups->ul_type;

		$results = $this -> m_student_management -> get_stu_detail_by_stuid($stu_id) -> result_array();
		$result = $results[0];
		$old_cc_id = $result['cc_id'];
		
		$old_col=$this->m_student_management->get_college_by_cc_id($old_cc_id);
		foreach ($old_col as $key_old) {
			$old_col_id=$key_old->col_id;
		}

		$ch_data = array(
			'ch_semester' => $stu_current_sem, 
			'ch_session' => $this -> session -> userdata('sesi'),
			'result_id' => null, 
			'md_id' => null, 
			'cc_id' => $old_cc_id, 
			'stu_id' => $stu_id, 
			'date_move_kv' => date("Y-m-d")
		);
		
		$aDetails['title']="Pemindahan Pelajar";
		$aDetails['content']=strcap($result['stu_name'])." telah dipindahkan dari ".urldecode($kolej_asal)." ke ".urldecode($kolej_pindah)." pada " 
			. $ch_data['date_move_kv'];
		$aDetails['open_date']=$ch_data['date_move_kv'];
		$aDetails['close_date']=date("Y-m-d",strtotime("+3 days"));
		$aDetails['status']=1;
		$aDetails['user_id']=$userId;

		$update_student = array('cc_id' => $temp_cc_id, 'stat_id' => 1,'temp_cc_id'=>null, 'stu_group' => "0");

		$this -> m_announcement -> insert_announcement($aDetails,array($colid,$old_col_id));
		$this -> m_student_management -> insert_college_history($ch_data);
		$this -> m_student_management -> update_student($stu_id, $update_student);
		redirect("student/student_management/pindah");
	}

	/**************************************************************************************************
	 * Description		: FOR DEBUGGING PURPOSE ONLY. Function which uses Grocery CRUD to list add the informations in the student table
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: -
	 * Modification Log	: -
	 **************************************************************************************************/
	public function search_student1() {
		$user_login = $this -> ion_auth -> user() -> row();
		$colid = $user_login -> col_id;

		$cc_id = $this -> m_student_management -> get_cc_id_by_col_id($colid);
		$array_cc_id = "";
		foreach ($cc_id as $key) {
			$array_cc_id .= $key -> cc_id . ",";
		}
		$array_cc_id = substr($array_cc_id, 0, -1);

		$nama = $this -> input -> get('name');
		$angka_giliran = $this -> input -> get('angka_giliran');
		$mykad = $this -> input -> get('mykad');
		$course = $this -> input -> get('kursus');
		$result = $this -> m_student_management -> search_student1($nama, $angka_giliran, $mykad, $course);

		$crud = new grocery_CRUD();

		$crud -> set_table('student');

		$crud -> set_primary_key('cc_id', 'student');
		$crud -> set_relation_n_n('Course', 'college_course', 'course', 'cc_id', 'cou_id', 'cou_name');
		$crud -> set_relation_n_n('College', 'college_course', 'college', 'cc_id', "col_ida=$colid", 'col_name');
		// $crud->where('college.col_id',$colid);
		$crud -> columns('stu_mykad', 'stu_name', 'stu_matric_no', 'College', 'Course', 'stu_current_sem');

		if ($nama != '') {
			$crud -> or_like('stu_name', $nama, 'both');
		} elseif ($angka_giliran != '') {
			$crud -> or_like('stu_matric_no', $angka_giliran, 'both');
		} elseif ($mykad != '') {
			$crud -> or_like('stu_mykad', $mykad, 'both');
		} elseif ($course != '') {
			$crud -> or_like('cou_name', $course, 'both');
		}

		//Modification Log : 27092013 by Mior - comment 2 line code below because searching not function
		//$query_where= "temp_cc_id IN ($array_cc_id)";
		//$crud -> where($query_where);

		$crud -> callback_column('stu_mykad', array($this, '_callback_webpage_url'));
		$crud -> callback_column('stu_name', array($this, '_callback_webpage_url'));
		$crud -> callback_column('stu_matric_no', array($this, '_callback_webpage_url'));

		$crud -> display_as('stu_mykad', 'MyKad') -> display_as('stu_name', 'Nama') -> display_as('stu_matric_no', 'Angka Giliran') -> display_as('Course', 'Kursus') -> display_as('College', 'KV')
		// ->  display_as('stu_gender','Jantina')
		// ->display_as('stu_race','Bangsa')
		// ->display_as('stu_religion','Agama')
		-> display_as('stu_current_sem', 'Semester Sekarang');

		$crud -> unset_add();
		$crud -> unset_edit();
		$crud -> unset_delete();
		$output = $crud -> render();

		echo $this -> _empty_output($output);
	}

	public function _callback_webpage_url($value, $row) {
		return "<a href='" . site_url('student/student_management/display_pindah/' . $row -> stu_id) . "'>$value</a>";
	}

	// En Fahkruz punye
	function import_student() {
		$data = array();
		$data['kv'] = $this -> m_general -> kv_list();

		$output['output'] = $this -> load -> view('student/v_student_import', $data, true);
		$this -> load -> view('main.php', $output);
	}

	function process_import() {
		echo "go go import";
	}

	/**************************************************************************************************
	 * Description		: upload file to import user into the system
	 *					: the content of the file will be inserted into the database
	 * Author			: Ku Ahmad Mudrikah
	 * Date				: 4 Nov 2013
	 * Input Parameter	:
	 * Modification Log	: umairah - strcap - 18/4/2014
	 **************************************************************************************************/
	function pergerakkan(){
		$user_login = $this->ion_auth->user()->row();
		$userId = $user_login->user_id;
		$colid = $user_login->col_id;
		$col=get_user_collegehelp($userId);
		
		$query=$this->db->query("
			SELECT s.stu_id, s.stu_name, s.stu_matric_no, s.stu_mykad, s.stat_id, s.stu_current_sem,
			(
			    SELECT college.col_name
			    FROM college_course
			    JOIN college ON college.col_id=college_course.col_id
			    WHERE college_course.cc_id=s.cc_id
			) AS kolej_asal,
			s.cc_id, 
			(
			    SELECT college.col_name
			    FROM college_course
			    JOIN college ON college.col_id=college_course.col_id
			    WHERE college_course.cc_id=s.temp_cc_id
			) AS kolej_pindah,
			s.temp_cc_id, cc.col_id AS col_id, cc_temp.col_id AS temp_col_id, ch.date_move_kv
			FROM student s
			LEFT JOIN college_course cc ON cc.cc_id=s.cc_id
			LEFT JOIN college_course cc_temp ON cc_temp.cc_id=s.temp_cc_id
			LEFT JOIN college c ON c.col_id=cc.col_id
			LEFT JOIN college c_temp ON c_temp.col_id=cc_temp.col_id
			LEFT JOIN college_history ch ON ch.stu_id=s.stu_id
			WHERE s.stat_id=5 OR s.stat_id=4 AND cc.col_id=$colid OR cc_temp.col_id=$colid
			GROUP BY s.stu_id
		");
		$result=$query->result();
		$num_rows=$query->num_rows();
		
		$this->db->select('*');
		$this->db->from('student s');
		$this->db->join('college_history ch','ch.stu_id=s.stu_id');
		$this->db->where('ch.ch_id is not NULL');
		$result_success=$this->db->get()->result();
		
		$query_success=$this->db->query("
			SELECT s.stu_id, s.stu_name, s.stu_matric_no, s.stu_mykad, s.stat_id, s.stu_current_sem,
			(
			   SELECT college.col_name
			   FROM college_course
			   JOIN college ON college.col_id=college_course.col_id
			   WHERE college_course.cc_id=s.cc_id
			) AS kolej_baru,
			s.cc_id, 
			(
				SELECT college.col_name
				FROM college_course
				JOIN college ON college.col_id=college_course.col_id
				JOIN college_history
				WHERE college_course.cc_id=college_history.cc_id
				AND college_history.stu_id=s.stu_id
				ORDER BY college_history.ch_id DESC
				LIMIT 1
			) AS kolej_asal,
			s.temp_cc_id
			FROM student s
			JOIN college_history ON college_history.stu_id=s.stu_id
			WHERE college_history.ch_id IS NOT NULL
			GROUP BY s.stu_id
		");
		
		$num_rows_success=$query_success->num_rows();
		$result_success=$query_success->result();
		
		$tmpl['table_open']="<table class='table table-striped table-bordered'>";
		$this->table->set_template($tmpl);
		$this->table->set_heading('Bil','Nama Murid','Angka Giliran','No MyKad','Status Pemindahan','Kolej Asal','Kolej Pindah','Tindakan');
		// if($num_rows_success>0){
			$i=1;
			foreach($result_success as $key_success){
				if($col[0]->col_name==$key_success->kolej_asal || $col[0]->col_name==$key_success->kolej_baru){
					if($key_success->stat_id==1){
						$status='Berjaya';
						$this->table->add_row(
							$i++,
							strcap($key_success->stu_name),
							$key_success->stu_matric_no,
							$key_success->stu_mykad,
							$status,
							$key_success->kolej_asal,
							$key_success->kolej_baru,
							""
						);
					}
				}
			}
			
			foreach ($result as $key) {
				if($col[0]->col_name==$key->kolej_asal || $col[0]->col_name==$key->kolej_pindah){
					if($key->stat_id==5){
						$status='Batal';
						if($key->col_id==$colid){
							$this->table->add_row(
								$i++,
								strcap($key->stu_name),
								$key->stu_matric_no,
								$key->stu_mykad,
								$status,
								$key->kolej_asal,
								$key->kolej_pindah,
								"<center>
									<a class='btn btn-info btn-mini' href='".site_url('student/student_management/sahkan/'.$key->stu_id)."'>
										OK
									</a>
								</center>"
							);
						}else{
							$this->table->add_row(
								$i++,
								strcap($key->stu_name),
								$key->stu_matric_no,
								$key->stu_mykad,
								$status,
								$key->kolej_asal,
								$key->kolej_pindah,
								""
							);
						}
					}elseif($key->stat_id==4){
						$status='Sedang diproses';
						if($key->temp_col_id==$colid){
							$this->table->add_row(
								$i++,
								strcap($key->stu_name),
								$key->stu_matric_no,
								$key->stu_mykad,
								$status,
								$key->kolej_asal,
								$key->kolej_pindah,
								"<center>
									<a class='btn btn-info btn-mini' href='".site_url('student/student_management/approve_transfer/'.$key->stu_current_sem.'/'.$key->temp_cc_id.'/'.$key->stu_id.'/'.$key->kolej_asal.'/'.$key->kolej_pindah.'/')."'>
										Lulus
									</a>
									<a class='btn btn-danger btn-mini' href='".site_url('student/student_management/batal_pemindahan/'.$key->stu_id)."'>
										Batal
									</a>
								</center>"
							);
						}else{
							$this->table->add_row(
								$i++,
								strcap($key->stu_name),
								$key->stu_matric_no,
								$key->stu_mykad,
								$status,
								$key->kolej_asal,
								$key->kolej_pindah,
								""
							);
						}
					}
				}else{
					$cell = array('data' => 'Tiada Maklumat', 'class' => 'highlight', 'colspan' => 8);
					if($col[0]->col_name!=$key->kolej_asal || $col[0]->col_name!=$key->kolej_pindah){
						//do nothing
					}else{
						$this->table->add_row($cell);
					}
				}
			}
		// }else{
			// $cell = array('data' => 'Tiada Maklumat', 'class' => 'highlight', 'colspan' => 8);
			// $this->table->add_row($cell);
		// }
		
		$data['table'] = $this->table->generate();
			
		$output['output']=$this->load->view('student/v_pergerakkan',$data,true);
		$this->_main_output($output,null);
	}
	
	/**************************************************************************************************
	 * Description		: upload file to import user into the system
	 *					: the content of the file will be inserted into the database
	 * Author			: Ku Ahmad Mudrikah
	 * Date				: 4 Nov 2013
	 * Input Parameter	:
	 * Modification Log	:
	**************************************************************************************************/
	function sahkan($id){
		$data = array(
               'stat_id' => 1,
               'temp_cc_id' => null
            );

		$this->db->where('stu_id', $id);
		$this->db->update('student', $data);
		redirect(site_url("student/student_management/pergerakkan"));
	}
	 
	/**************************************************************************************************
	 * Description		: upload file to import user into the system
	 *					: the content of the file will be inserted into the database
	 * Author			: Tuan Mohd Fakhruzzaman Bin Tuan Ismail
	 * Date				: 14 Jun 2013
	 * Input Parameter	:
	 * Modification Log	:
	 **************************************************************************************************/
	function do_upload() {
		$ar['file'] = $_FILES['file_excel']['name'];
		$ar['kv_id'] = $this -> input -> post('slct_kv');

		$this -> load -> helper(array('form', 'url', 'file', 'html'));

		$uploadTime = time();

		$config['upload_path'] = './uploaded/';
		$config['allowed_types'] = 'xls|xlsx';
		$config['max_size'] = '10000';
		$config['max_width'] = '1024';
		$config['max_height'] = '768';
		$config['file_name'] = $uploadTime . '.xlsx';

		$this -> load -> library('upload', $config);

		if ($ar['kv_id'] == '') {
			$this -> session -> set_flashdata("alert_content", "Please select group name");
			$this -> session -> set_flashdata('alert_type', 'error');
			redirect('student/student_management/import_student');
		} else if (isset($_FILES['file_excel']) && !empty($_FILES['file_excel']['name'])) {

			if ($this -> upload -> do_upload('file_excel')) {
				$aUploadData = $this -> upload -> data();
				$ar['upload_data'] = $aUploadData;
				$ar['uploadTime'] = $uploadTime;
				$ar["slct_sesi"] = $this -> input -> post("slct_sesi");
				$ar["slct_sem"] = $this -> input -> post("slct_sem");
				$ar["slct_kv"] = $this -> input -> post("slct_kv");

				$ar["slct_sheet"] = $this -> input -> post("slct_sheet");
				$ar["slct_nama"] = $this -> input -> post("sel_nama");
				$ar["slct_noKp"] = $this -> input -> post("sel_noKp");
				$ar["slct_angkaGiliran"] = $this -> input -> post("sel_angkaGiliran");
				$ar["slct_kodKursus"] = $this -> input -> post("sel_kodKursus");
				$ar["slct_jantina"] = $this -> input -> post("sel_jantina");
				$ar["slct_kaum"] = $this -> input -> post("sel_kaum");
				$ar["slct_agama"] = $this -> input -> post("sel_agama");

				$ar["rImportType"] = $this -> input -> post("rImportType");

				$this -> session -> set_flashdata("alert_content", "Senarai Pelajar Berjaya di Import!");
				$this -> load -> library('excel_reader');
				$this -> excel_reader -> import_with_group_alumni($ar);

				unlink($aUploadData['full_path']);

				redirect('student/student_management/import_student');

			} else {
				$msg = $this -> upload -> display_errors('<p>', '</p>');
				$this -> session -> set_flashdata("alert_content", $msg);
				$this -> session -> set_flashdata('alert_type', 'MessageBarWarning');
				redirect('student/student_management/import_student');
			}
		} else {
			$msg = $this -> upload -> display_errors('<p>', '</p>');
			$this -> session -> set_flashdata("alert_content", "Please select file to upload");
			$this -> session -> set_flashdata('alert_type', 'MessageBarWarning');
			redirect('student/student_management/import_student');
		}
	}

	function template_angka_giliran() {
		$data = array();

		$txtTemplate = $this -> input -> post("txtTemplate");

		if (!empty($txtTemplate)) {
			$txtTemplate = str_replace(array("&lt;", "&gt;", '&amp;', '&#039;', '&quot;', '&LT;', '&GT;'), array("<", ">", '&', '\'', '"', '<', '>'), htmlspecialchars_decode($txtTemplate, ENT_NOQUOTES));

			$aTemplate = array("opt_value" => $txtTemplate);
			$status_up = $this -> m_options -> update_template_ag($aTemplate);

			if ($status_up) {
				$output["modalAlert"] = "<script>notify('Format Angka Giliran telah berjaya disimpan.','Maklumat Tindakan','success');</script>";
			} else {
				$output["modalAlert"] = "<script>notify('Format Angka Giliran tidak berjaya disimpan!!!','Maklumat Tindakan','error');</script>";
			}
		}

		$output['output'] = $this -> load -> view('student/v_template_angka_giliran', $data, true);
		$this -> load -> view('main.php', $output);
	}

	function get_ajax_ku(){
		$iDisplayStart = $this->input->get_post('iDisplayStart', true);
        $iDisplayLength = $this->input->get_post('iDisplayLength', true);
        $iSortCol_0 = $this->input->get_post('iSortCol_0', true);
        $iSortingCols = $this->input->get_post('iSortingCols', true);
        $sSearch = $this->input->get_post('sSearch', true);
        $sEcho = $this->input->get_post('sEcho', true);
		$result=$this->m_student_management->pindah_table_ajax();
		
		echo json_encode($result);
	}
	
	/**************************************************************************************************
	 * Description		: retrieve student data
	*					: 
	* Author			: 
	* Date				: 
	* Input Parameter	:
	* Modification Log	: siti umairah - 11 december 2013 - status student, umairah-strcap-18/4/2014
	**************************************************************************************************/
	
	function ajax_student_pindah_response(){
		$user_login = $this -> ion_auth -> user() -> row();
		$colid = $user_login -> col_id;
		
		$sSearch['sNama'] 			= $this->input->post('nama');
		$sSearch['sAngkaGiliran'] 	= $this->input->post('angka_giliran');
		$sSearch['sMykad'] 			= $this->input->post('mykad');
		$sSearch['sSem'] 			= $this->input->post('sem');
		$aoData['iDisplayStart'] 	= $this->input->post('iDisplayStart');
        $aoData['iDisplayLength'] 	= $this->input->post('iDisplayLength');
        $aoData['iSortCol_0'] 		= $this->input->post('iSortCol_0');
        $aoData['iSortingCols'] 	= $this->input->post('iSortingCols');
        $aoData['sSearch'] 			= $this->input->post('sSearch');
        $aoData['sEcho'] 			= $this->input->post('sEcho');
		
		$result1=$this->m_student_management->transfer_list($colid,$aoData,$sSearch);;
		$iTotal=$result1['query']->num_rows();
		
		$arr=array(
			'sEcho'=>$aoData['sEcho'] ,
			'iTotalRecords'=>$iTotal,
			'iTotalDisplayRecords'=>$result1['iFilteredTotal']
		);
		if($iTotal>0){
			foreach ($result1['query']->result() as $key) {
				$arr['aaData'][]=array(strcap($key->stu_name),$key->stu_mykad,$key->stu_matric_no,"<center>".$key->stu_current_sem."</center>",
					"<center><a class='btn btn-info btn-small' href='" . site_url('student/student_management/display_pindah/' . $key -> stu_id) . "'>Pindah</a></center>");
			}
		}else{
			$arr['aaData']=array();
		}
		
		echo json_encode($arr);
	}

	function repeatstudent()
	{
		$this -> load -> model('m_result');
		
		$user_login = $this->ion_auth->user()->row();
	//	$colid = $user_login->col_id;
		$userId = $user_login->user_id;
		$state_id= $user_login->state_id;

		$user_groups = $this->ion_auth->get_users_groups($userId)->row();  
		$ul_type = $user_groups->ul_type;
		  
		if($ul_type == "KV"){
			$col=get_user_collegehelp($userId);
			$data['colname']=$col[0]->col_name.'-'.$colid;
		}
		if($ul_type=="JPN")
		{
			$data['centrecode'] = $this -> m_result -> get_institusi($state_id);
		}else{
			$data['centrecode'] = $this -> m_result -> get_institusi();
		}		
		
		$data['year'] = $this -> m_result -> list_year_mt();
		$data['courses'] = $this -> m_result -> list_course();
		//$data['state'] = $this -> m_report -> list_state();
        $centreCode = $this -> input -> post('kodpusat');
        
        if(empty($colId) && !empty($centreCode))
        {
        	$cC=explode("-", $centreCode); 
			$ccId=$cC[0];
        }
        elseif(!empty($colId) && empty($centreCode))
        {       	
			$collage= $this ->m_repeatsubject->get_colname($colId);
			$data['da'] = 'ada';
			$ccId=$collage[0]->col_name;
        }
        else
        {        	
			$ccId='';
        }
		
		$year = $this -> input -> post('mt_year');
		$course = $this -> input -> post('slct_kursus');
		$semester = $this -> input -> post('semester');
        $matric = $this -> input -> post('matric');
		
		if(empty($couId) && !empty($course))
		{
        	 $courseid=$course;
        }
        elseif(!empty($couId) && empty($course))
        {        	
			$data['da'] = 'ada';
			$courseid=$couId;
        }
        else
        {        	
			$courseid='';
        }
	
		$data['search'] = $ccId."|".$courseid."|".$semester."|".$year."|".$matric;

		$data['output'] = $this -> load -> view('student/v_repeat_students_list', $data, true);
		$this -> load -> view('main', $data);	
	}

	function view_img(){
		$img_data = $this->input->post("binaryImage");
		//header('Content-Type: image/jpeg');
		 $binaryImg = hex2bin($img_data);
		echo base64_encode($binaryImg);
	}
}

/**************************************************************************************************
 * End of student_management.php
 **************************************************************************************************/
?>