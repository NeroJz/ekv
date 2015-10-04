<?php
/**************************************************************************************************
	 * Description		: A class that contain methods to add student
	 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
	 * Date				: 10 July 2013
	 * Input Parameter	: -
	 * Modification Log	: -
**************************************************************************************************/
class Add_student extends CI_Controller {
	function index(){
		echo "";
	}
	function add() {
		$this->load->model('m_student_management');
		//$userSesi = $this -> session -> userdata["sesi"];//problem
		//$userYear = $this -> session -> userdata["tahun"];//problem

		$userSesi = $this -> input -> post('sesi');
		$userYear = $this -> input -> post('year');
		$no_kp = $this -> input -> post('no_kp');
		$no_kp = str_replace('-', null, $no_kp);
		$nama = $this -> input -> post('nama');
		$gender = $this -> input -> post('jantina');
		$cur_sem = $this -> input -> post('semester');
		$cur_year = $userYear;
		$intake_sess = $userSesi." ".date('Y');
		$group = $this -> input -> post('group');
		$cc_id = $this -> input -> post('cc_id');
		$race = $this -> input -> post('bangsa');
		$religion = $this -> input -> post('agama');
		$semester = $this -> input -> post('semester');
		return $kv = $this -> input -> post('kv');
		$cou = $this -> input -> post('course');
		$status = $this -> input -> post('status');
		$matrik = generateMatricNo($kv, $cou);

		$data_cc = array('col_id' => $kv, 'cou_id' => $cou);
		//$this -> m_student_management -> insert_college_course($data_cc); //FOR DEBUGGING PURPOSE

		$raw_cc_id = $this -> m_student_management -> get_ccid($cou, $kv);
		$cc_id = $raw_cc_id[0];

		$data_stu = array('stu_mykad' => $no_kp, 'stu_matric_no' => $matrik, 'stu_name' => $nama, 'stu_gender' => $gender, 'stu_current_sem' => $cur_sem, 'stu_current_year' => $cur_year, 'stu_intake_session' => $intake_sess, 'stu_group' => $group, 'cc_id' => $cc_id['cc_id'], 'stu_race' => $race, 'stu_religion' => $religion, 'stat_id' => $status);
		$this -> m_student_management -> insert_student($data_stu);

		$query = $this -> m_student_management -> get_student_by_matric_no($matrik);
		foreach ($query as $row) {
			$stu_id = $row['stu_id'];
		}
		// $mod_id = $this -> m_student_management -> get_mod_id_by_stu_id($stu_id);
		$mod_id = $this -> m_student_management -> get_course_module_by_cou_id($cou,$semester);
		
		
		//edit by sukor and mior....this is for temporary

		foreach ($mod_id as $key) {
			if($religion=="ISLAM" || $religion=="islam" || $religion=="Islam"){
				if($key['mod_code']!='A07'){
				
				$data_module_taken = array(
					'mt_semester' => $cur_sem,
					'mt_year' => $this -> session -> userdata["tahun"],
					'mt_full_mark' => '',
					'mt_status' => '1',
					'stu_id' => $stu_id,
					'mod_id' => $key['mod_id'],
					'grade_id' => null,
					'exam_status' => '1'
				);
				$this -> m_student_management -> insert_module_taken($data_module_taken);
				}
				
			}else{
			
			if($key['mod_code']!='A06'){
				
			
			$data_module_taken = array('mt_semester' => $cur_sem, 'mt_year' => $this -> session -> userdata["tahun"], 'mt_full_mark' => '', 'mt_status' => '1', 'stu_id' => $stu_id, 'mod_id' => $key['mod_id'], 'grade_id' => null, 'exam_status' => '1');
			$this -> m_student_management -> insert_module_taken($data_module_taken);
			}
		}
		}
		//redirect(site_url() . '/student/student_management', 'refresh');
		return "hello";
	}
}