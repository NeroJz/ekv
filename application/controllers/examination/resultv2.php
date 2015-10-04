<?php
session_start();
class Resultv2 extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('m_kursus');
		$this->load->model('m_pelajar');
		$this->load->model('m_resultrv2');
		$this->load->model('m_ticket');
	}

	function index() 
	{
		$data['tahun'] = $this->m_ticket->list_tahun();
		$data['kursus'] = $this->m_kursus->kursus_list();
        $data['view_content'] = $this->load->view('laporan/v_pentaksiran_result', $data, true);
		$this->load->view('welcome_message', $data);
	}
	
	function paparresult()
	{
		$kvid = $this->input->post('slct_kursus');
		$tahun = $this->input->post('slct_tahun');
		$pelajar = $this->input->post('angka_giliran');
		//print_r($expression);
		//die();
		$data['tahun'] = $tahun;
		$data['result'] = $this->m_resultrv2->student_result($kvid,$tahun,$sem='',$pelajar='');
			
			$this->load->view('laporan/v_cetak_result', $data);
		
	}
	
}
	