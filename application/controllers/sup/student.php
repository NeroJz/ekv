<?php
/**************************************************************************************************
* File Name        : student.php
* Description      : Fail ini digunakan oleh sup untuk urus berkaitan pelajar
* Author           : Mior Mohd Hanif
* Date             : 14 Jun 2013
* Version          : 0.1
* Modification Log : 
* Function List	   : __construct(), index(),paparsenarai()
**************************************************************************************************/

class Student extends MY_Controller 
{
	/**
	* function ni digunakan untuk load model query
	* input: -
	* author: Mior Mohd Hanif
	* Date: 14 Jun 2013
	* Modification Log: 
	*/
	function __construct() 
	{
		parent::__construct();
		$this->load->model('m_kursus');
		$this->load->model('m_sup');
	}
	
	/**
	* function ni digunakan untuk paparkan laman pilihan kursus
	* input: -
	* author: Mior Mohd Hanif
	* Date: 14 Jun 2013
	* Modification Log: 
	*/
	function index()
	{
		$data['kursus'] = $this->m_kursus->kursus_list();
        $data['output'] = $this->load->view('sup/v_form_list_student_by_course', $data, true);
		$this->load->view('main', $data);
	}
	
	/**
	* function ni digunakan untuk paparkan senarai pelajar
	* input: -
	* author: Mior Mohd Hanif
	* Date: 14 Jun 2013
	* Modification Log: 17 Jun 2013 by Mior - buat operation terima data dari model
	*/
	function show_list()
	{
		$user_login = $this->ion_auth->user()->row();
		$id_pusat = $user_login->company;
				
		$kursus_id = $this->input->post('slct_kursus');
		$sesi = $this->input->post('slct_tahun');
		$semester = $this->input->post('slct_semester');
		
		$data = array(
			'semester' => $semester,
			'sesi' => $sesi
		);
		
		$data['kursus'] = $this->m_kursus->kursus_dipilih($kursus_id);
		$data['kv'] = $this->m_sup->get_detail_kv($id_pusat);
		$data['senarai'] = $this->m_sup->get_student_by_course($kursus_id,$sesi,$semester,$id_pusat);
		
		$this->load->view('sup/v_list_student_by_course.php', $data);
	}	
}

/**************************************************************************************************
* End of student.php
**************************************************************************************************/
?>