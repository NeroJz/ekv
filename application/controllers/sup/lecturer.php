<?php
/**************************************************************************************************
* File Name        : lecturer.php
* Description      : Fail ini digunakan oleh sup untuk urus berkaitan pensyarah
* Author           : Mior Mohd Hanif
* Date             : 18 Jun 2013
* Version          : 0.1
* Modification Log : 
* Function List	   : __construct(), index(),lect_submit_mark_ajax()
**************************************************************************************************/

class Lecturer extends MY_Controller 
{
	/**
	* function ni digunakan untuk load model query
	* input: -
	* author: Mior Mohd Hanif
	* Date: 18 Jun 2013
	* Modification Log: 
	*/
	function __construct() 
	{
		parent::__construct();
		$this->load->model('m_sup');
		//$this->load->model('m_kursus');
	}
	
	/**
	* function ni digunakan untuk paparkan laman senarai pensyarah yang dah hantar dan belum hantar markah
	* input: -
	* author: Mior Mohd Hanif
	* Date: 18 Jun 2013
	* Modification Log: 19 Jun 2013 by Mior - buat operasi load and send search post
	 * 					15 Julai 2013 by Mior - modify balik
	 * 					24 Julai 2013 by Mior - modify tambah pengurusan
	*/
	function index()
	{
		$user_login = $this->ion_auth->user()->row();
		$id_pusat = $user_login->col_id;
		//$kursus_id = $this->input->post('kursus_id');
		$current_year = $this->session->userdata["tahun"];
		$semester = $this->input->post('semester');
		$status = $this->input->post('status');
		$pengurusan = $this->input->post('pengurusan');
		
		$ar_search = $current_year . "|" . $semester . "|". $status . "|". $id_pusat . "|". $pengurusan;
		$data['search'] = $ar_search;
		//$data['kursus'] = $this->m_kursus->kursus_list();
        $data['output'] = $this->load->view('sup/v_list_lecturer_submit_mark', $data, true);
		$this->load->view('main', $data);
		
		
	}
	
	/**
	* Description		: This function is to load function that query data for datatable
	* Author			: Mior Mohd Hanif
	* Date				: 18 Jun 2013
	* Input Parameter	: -
	* Modification Log	:
	*/
	function lect_submit_mark_ajax() 
	{
		$arr_data = $this->m_sup->lect_submit_mark();

		if (sizeof($arr_data) > 0)
			echo json_encode($arr_data);
	}
}

/**************************************************************************************************
* End of lecturer.php
**************************************************************************************************/
?>