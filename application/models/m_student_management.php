<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
/**************************************************************************************************
 * File Name        : m_student_management.php
 * Description      : This File contain model for general.
 * Author           : Ku Ahmad Mudrikah
 * Date             : 2 July 2013
 * Version          : 0.1
 * Modification Log :
 * Function List	   :
 **************************************************************************************************/
class M_student_management extends CI_Model {
	/******************************************************************************************
	 * Description		: this function to get data from collge_course which joins 3 table (course, college, student)
	 * input				: -
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: -
	 ******************************************************************************************/
	function get_college_course($kv_id, $sem, $gender, $race, $status, $state) {
		$this -> db -> from('student');
		if ($kv_id != null) {
			$this -> db -> where('college_course.col_id', $kv_id);
		}
		if ($sem != null) {
			$this -> db -> where('student.stu_current_sem', $sem);
		}
		if ($gender != null) {
			$this -> db -> where('student.stu_gender', $gender);
		}
		if ($race != null) {
			$this -> db -> where('student.stu_race', $race);
		}
		if ($status != null) {
			$this -> db -> where('student.stat_id', $status);
		}
		if ($state != null) {
			$this -> db -> where('student.state_id', $state);
		}
		$this -> db -> join('college_course', 'college_course.cc_id = student.cc_id');
		$this -> db -> join('course', 'course.cou_id = college_course.cou_id');
		$this -> db -> join('college', 'college.col_id = college_course.col_id');
		return $this -> db -> get();
	}

	/******************************************************************************************
	 * Description		: this function to get data from collge_course which joins 3 table (course, college, student)
	 * input				: -
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: -
	 ******************************************************************************************/
	function get_college_by_course($cou_id) {
		$this -> db -> from('college_course');
		if ($cou_id != null) {
			$this -> db -> where('college_course.cou_id', $cou_id);
		}
		$this -> db -> join('course', 'course.cou_id = college_course.cou_id');
		$this -> db -> join('college', 'college.col_id = college_course.col_id');
		return $this -> db -> get();
	}
	/******************************************************************************************
	 * Description		: this function to get data from collge_course which joins 3 table (course, college, student)
	 * input				: -
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: -
	 ******************************************************************************************/
	function get_college_by_cc_id($cc_id) {
		$this -> db -> from('college_course');
		if ($cc_id != null) {
			$this -> db -> where('college_course.cc_id', $cc_id);
		}
		$this -> db -> join('course', 'course.cou_id = college_course.cou_id');
		$this -> db -> join('college', 'college.col_id = college_course.col_id');
		return $this -> db -> get() -> result();
	}

	/******************************************************************************************
	 * Description		: this function to get data from collge_course which joins 3 table (course, college, student)
	 * input			: -
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 3 December 2013
	 * Modification Log	: -
	 ******************************************************************************************/
	function get_state_by_state($state=null) {
		$this -> db -> from('state');
		if ($state != null) {
			$this -> db -> where('state', $state);
		}
		$result=$this -> db -> get() -> result();
		
		foreach ($result as $key) {
			return $key->state_id;
		}
	}


	/******************************************************************************************
	 * Description		: this function to get data from collge_course which joins 3 table (course, college, student)
	 * input				: -
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: -
	 ******************************************************************************************/
	function get_college_by_cc_id_arr($cc_id) {
		$this -> db -> from('college_course');
		if ($cc_id != null) {
			$this -> db -> where('college_course.cc_id', $cc_id);
		}
		$this -> db -> join('course', 'course.cou_id = college_course.cou_id');
		$this -> db -> join('college', 'college.col_id = college_course.col_id');
		return $this -> db -> get() -> result_array();
	}

	/******************************************************************************************
	 * Description		: this function to get data from collge_course which joins 3 table (course, college, student)
	 * input				: -
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: -
	 ******************************************************************************************/
	function get_register_schedule($sesi,$tahun) {
		$this->db->from('register_schedule');
		$this->db->where('rs_sesi',$sesi);
		$this->db->where('rs_tahun',$tahun);
		return $this->db->get();
	}

	/******************************************************************************************
	 * Description		: this function to get data from collge_course which joins 3 table (course, college, student)
	 * input				: -
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: -
	 ******************************************************************************************/
	function change_student_status($stu_id, $stat_id) {
		$data = array('stat_id' => $stat_id);

		$this -> db -> where('stu_id', $stu_id);
		$this -> db -> update('student', $data);
	}

	/******************************************************************************************
	 * Description		: this function to get data from collge_course which joins 3 table (course, college, student)
	 * input				: -
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: -
	 ******************************************************************************************/
	function change_student_temp_cc_id($stu_id, $temp_cc_id) {
		$data = array('temp_cc_id' => $temp_cc_id);

		$this -> db -> where('stu_id', $stu_id);
		$this -> db -> update('student', $data);
	}

	/******************************************************************************************
	 * Description		: this function to get data from collge_course which joins 3 table (course, college, student)
	 * input				: -
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: BLOM SIAP
	 ******************************************************************************************/
	function get_stu_detail($id) {
		$this -> db -> from('student');
		if ($id != null) {
			$this -> db -> where('college_course.col_id', $id);
		}
		$this -> db -> join('college_course', 'college_course.cc_id = student.cc_id');
		$this -> db -> join('course', 'course.cou_id = college_course.cou_id');
		$this -> db -> join('college', 'college.col_id = college_course.col_id');
		return $this -> db -> get();
	}

	/******************************************************************************************
	 * Description		: this function to get data from collge_course which joins 3 table (course, college, student)
	 * input				: -
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: BLOM SIAP
	 ******************************************************************************************/
	function get_stu_detail_by_stuid($id) {
		$this -> db -> from('student');
		if ($id != null) {
			$this -> db -> where('student.stu_id', $id);
		}
		$this -> db -> join('college_course', 'college_course.cc_id = student.cc_id');
		$this -> db -> join('course', 'course.cou_id = college_course.cou_id');
		$this -> db -> join('college', 'college.col_id = college_course.col_id');
		return $this -> db -> get();
	}

	/******************************************************************************************
	 * Description		: this function to get the last row cc_id from the college_course table
	 * input				: -
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: -
	 ******************************************************************************************/
	function get_last_cc_id() {
		$this -> db -> select('cc_id');
		$query = $this -> db -> get('college_course');
		foreach ($query->result() as $row) {
			return $query -> last_row('array');
		}
	}

	/******************************************************************************************
	 * Description		: this function to get the last row cc_id from the college_course table
	 * input				: -
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: -
	 ******************************************************************************************/
	function get_cc_id($col_id, $cou_id) {
		$this -> db -> select('*');
		$this -> db -> where('col_id', $col_id);
		$this -> db -> where('cou_id', $cou_id);
		$query = $this -> db -> get('college_course');
		return $query -> result();
	}

	/******************************************************************************************
	 * Description		: this function to get the last row cc_id from the college_course table
	 * input				: -
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: -
	 ******************************************************************************************/
	function get_cc_id_by_col_id($col_id) {
		$this -> db -> select('*');
		$this -> db -> where('col_id', $col_id);
		$query = $this -> db -> get('college_course');
		return $query -> result();
	}

	/******************************************************************************************
	 * Description		: This function is to insert data into college_course table
	 * input				: $data = array() -> column name
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: -
	 ******************************************************************************************/
	function insert_college_course($data) {
		$this -> db -> insert('college_course', $data);
	}

	/******************************************************************************************
	 * Description		: This function is to insert data into student table
	 * input			: $data = array() -> column name
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: -
	 ******************************************************************************************/
	function insert_student($data) {
		$this -> db -> select('stu_mykad');
		$this -> db -> where('stu_mykad', $data["stu_mykad"]);
		$query = $this -> db -> get('student');

		if($query->num_rows() > 0){
			return false;
		}else{
			return $this -> db -> insert('student', $data);
		}
	}

	/******************************************************************************************
	 * Description		: This function is to insert data into student table
	 * input			: $data = array() -> column name
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: -
	 ******************************************************************************************/
	function insert_college_history($data) {
		$this -> db -> insert('college_history', $data);
	}

	/******************************************************************************************
	 * Description		: This function is to insert data into module_taken table
	 * input			: $stu_id = ""; -> string
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: BLOM SIAP
	 ******************************************************************************************/
	function get_mod_id_by_stu_id($stu_id) {
		$query = $this -> get_student_by_id($stu_id);
		foreach ($query as $row) {
			$mt_semester = $row['stu_current_sem'];
			$cc_id = $row['cc_id'];
		}

		$query = $this -> get_college_course_by_cc_id($cc_id);
		foreach ($query as $row) {
			$cou_id = $row['cou_id'];
		}
		return $query = $this -> get_course_module_by_cou_id($cou_id, $mt_semester);
	}

	/******************************************************************************************
	 * Description		: This function is to insert data into module_taken table
	 * input			: $stu_id = ""; -> string
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: BLOM SIAP
	 ******************************************************************************************/
	function insert_module_taken($data) {
		$sta = $this -> db -> insert('module_taken', $data);
		return $sta;
		
	}

	/******************************************************************************************
	 * Description		: This function is to get table STUDENT
	 * input			: $stu_id = ""; -> string
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: - siti umairah - 20 december 2013, nabihah 16012014
	 ******************************************************************************************/
	function get_student_by_id($stu_id) 
	{
		$this -> db -> select('s.*,c.class_name');
		$this -> db -> from('student s');
		$this -> db -> join('class as c', 's.stu_group = c.class_id', 'left');
		$this -> db -> where('stu_id', $stu_id);
		return $this -> db -> get() -> result_array();
	}

	/******************************************************************************************
	 * Description		: This function is to get table STUDENT
	 * input			: $stu_id = ""; -> string
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: -
	 ******************************************************************************************/
	function get_student_by_matric_no($matric_no) {
		$this -> db -> select('*');
		$this -> db -> from('student');
		$this -> db -> where('stu_matric_no', $matric_no);
		return $this -> db -> get() -> result_array();
	}

	/******************************************************************************************
	 * Description		: This function is to get table STUDENT
	 * input			: $stu_id = ""; -> string
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: -
	 ******************************************************************************************/
	function get_college_course_by_cc_id($cc_id) {
		$this -> db -> select('*');
		$this -> db -> from('college_course');
		$this -> db -> where('cc_id', $cc_id);
		return $this -> db -> get() -> result_array();
	}

	/******************************************************************************************
	 * Description		: This function is to get table STUDENT
	 * input			: $stu_id = ""; -> string
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: -
	 ******************************************************************************************/
	function get_course_module_by_cou_id($cou_id, $mt_semester) {
		$this -> db -> select('*');
		$this -> db -> from('course_module');
		$this -> db -> join('module', 'module.mod_id = course_module.mod_id');
		$this -> db -> where('cou_id', $cou_id);
		$this -> db -> where('cm_semester', $mt_semester);
		$this -> db -> where('stat_mod', 1);

		//print_r($this -> db -> get());
		return $this -> db -> get() -> result_array();
	}

	/******************************************************************************************
	 * Description		: This function is to get table STUDENT
	 * input			: $stu_id = ""; -> string
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: -
	 ******************************************************************************************/
	function update_student($stu_id, $data) {
		$this -> db -> where('stu_id', $stu_id);
		$this -> db -> update('student', $data);
	}

	/******************************************************************************************
	 * Description		: This function is to get table STUDENT
	 * input			: $stu_id = ""; -> string
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: -
	 ******************************************************************************************/
	function update_college_course($cc_id, $data) {
		$this -> db -> where('cc_id', $cc_id);
		$this -> db -> update('college_course', $data);
	}

	/******************************************************************************************
	 * Description		: This function is to get table STUDENT
	 * input			: $stu_id = ""; -> string
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: -
	 ******************************************************************************************/
	function get_ccid($cou_id, $col_id) {
		$this -> db -> select('*');
		$this -> db -> from('college_course');
		$this -> db -> where('col_id', $col_id);
		$this -> db -> where('cou_id', $cou_id);
		return $result = $this -> db -> get() -> result_array();
	}

	/******************************************************************************************
	 * Description		: This function is to get table STUDENT
	 * input			: $stu_id = ""; -> string
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: -
	 ******************************************************************************************/
	function search_student1($nama, $matrix, $mykad, $course) {
		$this -> db -> select('*');
		$this -> db -> from('student');
		$this -> db -> or_where('stu_name', $nama);
		$this -> db -> or_where('stu_matric_no', $matrix);
		$this -> db -> or_where('stu_mykad', $mykad);
		// $this->db->or_where('cou_id', $course);
		return $result = $this -> db -> get() -> result_array();
	}

	/******************************************************************************************
	 * Description		: This function is to get table STUDENT
	 * input			: $stu_id = ""; -> string
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 10 June 2013
	 * Modification Log	: -
	 ******************************************************************************************/
	function search_student_kupp($nama, $matrix, $mykad, $course, $col_id) {
		$this -> db -> select('stu_id,stu_name,stu_matric_no,stu_mykad,cou_id');
		// $this -> db -> select('*');
		$this -> db -> from('student');
		$this -> db -> where('college_course.col_id', $col_id);
		if ($nama != '' || $matrix != '' || $course != '' || $mykad != '') {
			$this -> db -> where("
				(
					`stu_name` LIKE '%$nama%' 
					OR `stu_matric_no` LIKE '%$matrix%' 
					OR `cou_id` LIKE '%$course%' 
					OR `stu_mykad` LIKE '%$mykad%'
				)", NULL, FALSE);
			// $this -> db -> where('(stu_name', $nama);
			// $this -> db -> like('stu_name', $nama);
			// $this -> db -> or_like('stu_matric_no', $matrix);
			// $this -> db -> or_like('cou_id', $course);
			// $this -> db -> or_like('stu_mykad', $mykad);
		}
		$this -> db -> join('college_course', 'college_course.cc_id=student.cc_id');
		$this -> db -> group_by('stu_id');
		return $result = $this -> db -> get() -> result();
	}
	
	function pindah_table_ajax(){
		$this -> db -> select('stu_id,stu_name,stu_matric_no,stu_mykad,cou_id');
		// $this -> db -> select('*');
		$this -> db -> from('student');
		$this -> db -> where('college_course.col_id', $col_id);
		if ($nama != '' || $matrix != '' || $course != '' || $mykad != '') {
			$this -> db -> where("
				(
					`stu_name` LIKE '%$nama%' 
					OR `stu_matric_no` LIKE '%$matrix%' 
					OR `cou_id` LIKE '%$course%' 
					OR `stu_mykad` LIKE '%$mykad%'
				)", NULL, FALSE);
			// $this -> db -> where('(stu_name', $nama);
			// $this -> db -> like('stu_name', $nama);
			// $this -> db -> or_like('stu_matric_no', $matrix);
			// $this -> db -> or_like('cou_id', $course);
			// $this -> db -> or_like('stu_mykad', $mykad);
		}
		$this -> db -> join('college_course', 'college_course.cc_id=student.cc_id');
		$this -> db -> group_by('stu_id');
		$this -> db -> limit(10);
		return $result = $this -> db -> get() -> result();
	}
	
	/******************************************************************************************
	* Description		: This function is to get table STUDENT
	* input			: col_id,aoData,sSearch
	* author			: Ku Ahmad Mudrikah
	* Date				: 29 October 2013
	* Modification Log	: -
	******************************************************************************************/
	function transfer_list($colid,$aoData,$sSearch){
		$this->db->select('stu_id,stu_name,stu_matric_no,stu_mykad,stu_current_sem');
		$this->db->from('student');
		$this->db->where('college_course.col_id', $colid);
		$this->db->group_by('stu_id');
		$this->db->join('college_course', 'college_course.cc_id=student.cc_id');
		
		if($sSearch['sNama']!=""){
			$this->db->like("stu_name",$sSearch['sNama']);
		}
		if($sSearch['sAngkaGiliran']!=""){
			$this->db->like("stu_matric_no",$sSearch['sAngkaGiliran']);
		}
		if($sSearch['sMykad']!=""){
			$this->db->like("stu_mykad",$sSearch['sMykad']);
		}
		
		if($sSearch['sSem']!=""){
			if($sSearch['sSem']==0){}else{
				$this->db->like("stu_current_sem",$sSearch['sSem']);
			}
		}
		
		// Ordering 
        if (isset($_POST['iSortCol_0'])) {
            for ($i = 0; $i < ($_POST['iSortingCols'] ); $i++) {
                $this->db->order_by($this->pfnColumnToField2($_POST['iSortCol_' . $i]), $_POST['sSortDir_' . $i]);
            }
        }

		// Search
        if (isset($_POST['sSearch']) && $_POST['sSearch'] != "")
		{
			$this->db->where(
				"(student.stu_matric_no LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . 
				"%' OR student.stu_name LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . 
				"%' OR student.stu_current_sem LIKE '%" . mysql_real_escape_string($_POST['sSearch']) .
				"%' OR student.stu_mykad LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%' )"
			);
        }
        
		$result=$this->db->get();
		$result1['iFilteredTotal']=$result->num_rows();
		$db_query=$this->db->last_query();
		
		if (isset($_POST['iDisplayStart']) && $_POST['iDisplayLength'] != '-1') {
           $db_query .= " LIMIT " . mysql_real_escape_string($_POST['iDisplayStart']) . ', ' . mysql_real_escape_string($_POST['iDisplayLength']);

            $bil = $aoData['iDisplayStart'];
        }
		else
            $bil = 0;
		
		// print_r($_POST);
		// echo $db_query;
		
		// $db_query .= " LIMIT ".$aoData['iDisplayStart'].",".$aoData['iDisplayLength'];
		$result1['query']=$this->db->query($db_query);
		return $result1;
	}
	
	
	/******************************************************************************************
	* Description		: This function is to get table STUDENT
	* input				: col_id,aoData,sSearch
	* author			: Ku Ahmad Mudrikah
	* Date				: 29 October 2013
	* Modification Log	: -
	******************************************************************************************/
	function ajax_student_list($colid,$aoData,$sSearch){//SAMBUNG
		$this->db->select('*');//OPTIMIZE!!
		//$this->db->from('student');
		$this->db->group_by('stu_id');
		$this->db->join('college_course', 'college_course.cc_id=student.cc_id');
		$this->db->join('college', 'college.col_id=college_course.col_id');
		$this->db->join('course', 'course.cou_id=college_course.cou_id');
		
		if($sSearch['sNama']!=""){
			$this->db->like("stu_name",$sSearch['sNama']);
		}
		if($sSearch['sSlct_kv']!=""){
			$this->db->like("college.col_name",$sSearch['sSlct_kv']);
		}
		if($sSearch['sSlct_sem']!=""){
			$this->db->where("student.stu_current_sem",$sSearch['sSlct_sem']);
		}
		if($sSearch['sSlct_course']!=""){
			$this->db->where("course.cou_name",$sSearch['sSlct_course']);
		}
		
		$this -> db -> where('stat_id', 1);
		
		// Ordering 
        if (isset($_POST['iSortCol_0'])) {
            for ($i = 0; $i < ($_POST['iSortingCols'] ); $i++) {
                $this->db->order_by($this->pfnColumnToField($_POST['iSortCol_' . $i]), $_POST['sSortDir_' . $i]);
            }
        }else{
        	$this->db->order_by("college.col_name","asc");
        	$this->db->order_by("course.cou_name","asc");
        	$this->db->order_by("student.stu_current_sem","asc");
        }

		// Search
        if (isset($_POST['sSearch']) && $_POST['sSearch'] != "")
		{
			$this->db->where(
				"(student.stu_matric_no LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . 
				"%' OR student.stu_name LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . 
				"%' OR student.stu_matric_no LIKE '%" . mysql_real_escape_string($_POST['sSearch']) .
				"%' OR student.stu_current_sem LIKE '%" . mysql_real_escape_string($_POST['sSearch']) .
				"%' OR college.col_name LIKE '%" . mysql_real_escape_string($_POST['sSearch']) .
				"%' OR course.cou_name LIKE '%" . mysql_real_escape_string($_POST['sSearch']) .
				"%' OR student.stu_mykad LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%' )"
			);
        }
		
		$result=$this->db->get('student');
		$result1['iFilteredTotal']=$result->num_rows();
		$db_query=$this->db->last_query();
		
		//$db_query .= " LIMIT ".$aoData['iDisplayStart'].",".$aoData['iDisplayLength'];//SAMBUNG
		
		if (isset($_POST['iDisplayStart']) && $_POST['iDisplayLength'] != '-1') {
           $db_query .= " LIMIT " . mysql_real_escape_string($_POST['iDisplayStart']) . ', ' . mysql_real_escape_string($_POST['iDisplayLength']);

            $bil = $aoData['iDisplayStart'];
        }
		else
            $bil = 0;
		
		//$db_query.=" ORDER BY college.col_name,course.cou_name, student.stu_current_sem ASC";
		//die($db_query);
		$result1['query']=$this->db->query($db_query);
		return $result1;
	}
	
	/******************************************************************************************
	* Description		: This function is to get table STUDENT
	* input				: col_id,aoData,sSearch
	* author			: Ku Ahmad Mudrikah
	* Date				: 29 October 2013
	* Modification Log	: -
	******************************************************************************************/
	function autosuggest_student($id="") {

		$this -> db -> select('*');
		$this -> db -> from('student');
	//	$this -> db -> where('stat_id', 1);
		
        if (!empty($state)) {
			$this -> db -> where('stu_id', $id);
		}
		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			$data = $query -> result();
			$student = '';
			foreach ($data as $row) {
				$student .= '"';
				$student .= $row -> stu_name." - ".$row->stu_matric_no;

				$student .= '",';
			}
			return $student;
		}
	}

	function pfnColumnToField($i) {
        if ($i == 0)
			return "student.stu_name";
		else if($i == 1)
			return "student.stu_mykad";
		else if ($i == 2)
			return "student.stu_matric_no";
		else if ($i == 3)
			return "student.stu_current_sem";
		else if ($i == 4)
			return "college.col_name";
	}

	function pfnColumnToField2($i) {
        if ($i == 0)
			return "student.stu_name";
		else if($i == 1)
			return "student.stu_mykad";
		else if ($i == 2)
			return "student.stu_matric_no";
	}
}


/**************************************************************************************************
 * End of m_student_management.php
 **************************************************************************************************/
?>