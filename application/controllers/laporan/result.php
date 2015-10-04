<?php
session_start();
class Result extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();

		$this->load->model('m_result');
	}


	
	
	function roster()
	{
		$data['test'] = 0;
		$data['centrecode'] = $this->m_result->get_institusi();
		$data['year'] =$this->m_result->list_year_mt();
		//print_r($data['centrecode']);
		//die();
		$data['view_content'] = $this->load->view('laporan/v_laporan_roster', $data, true);
		$this->load->view('welcome_message', $data);
	}
	
	function resultRoster()
	{
		$centreCode = $this->input->post('kodpusat');
		$semester = $this->input->post('semester');
		$year = $this->input->post('mt_year');
		
		//$data['centrecode'] = $this->m_result->get_institusi_by_id($centreCode);
		$data['student'] = $this->m_result->get_result_by_id($centreCode, $semester,$year);
		$this->load->view('laporan/v_roster', $data, '');
	}
	
	function allgred()
	{
		$data['kursus'] = $this->m_kursus->kursus_list();
		$data['view_content'] = $this->load->view('laporan/v_gred_keseluruhan', $data, true);
		$this->load->view('welcome_message', $data);
	}
	
	function resultkeseluruhan()
	{
		$tmpKursus = $this->input->post('slct_kursus');
		$slct_kursus = (empty($tmpKursus))?10:$this->input->post('slct_kursus');
		
		$data['kursusdipilih'] = $this->m_kursus->kursus_dipilih($slct_kursus);
		$data['pelajar_akademik'] = $this->m_pelajar->pelajar_akademik_list($slct_kursus);
		$data['subjek_akademik'] = $this->m_pelajar->subjek_akademik_list();
		$data['subjek_kv'] = $this->m_pelajar->subjek_kv_list($slct_kursus);
		
		$this->load->view('laporan/v_result_gred', $data);
	}
	
	
	function attendance_exam()
	{
		
		$data['centrecode'] = $this->m_result->get_institusi();
		$data['courses'] = $this->m_result->list_course();
		$data['year'] =$this->m_result->list_year_mt();
		//print_r($data['centrecode']);
		//die();
		$data['view_content'] = $this->load->view('laporan/v_attendance_exam', $data, true);
		$this->load->view('welcome_message', $data);
	}



function attendance_exam_print()
	{
		$centreCode = $this->input->post('kodpusat');
		$semester = $this->input->post('semester');
		$year = $this->input->post('mt_year');
		$course = $this->input->post('slct_kursus');
		//$data['centrecode'] = $this->m_result->get_institusi_by_id($centreCode);
		$data['student'] = $this->m_result->get_module_taken($centreCode, $semester,$year,$course);
		//print_r($data['student']);
		//die();
		$this->load->view('laporan/v_attendance_exam_print', $data, '');
	}
	
}
?>