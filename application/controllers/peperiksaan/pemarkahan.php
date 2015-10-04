<?php
session_start();
class Pemarkahan extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('m_kursus');
		$this->load->model('m_pelajar');
		$this->load->model('m_result');
	}

	function index() 
	{
		$data['centrecode'] = $this->m_result->get_institusi();
		$pengurusan = $this->input->post('pengurusan');
		$pentaksiran = $this->input->post('pentaksiran');
		$data['pilihan'] = $pengurusan;
		$data['pentaksiran'] = $pentaksiran;
		
		$data['kursus'] = $this->m_kursus->kursus_list();
        $data['view_content'] = $this->load->view('peperiksaan/pemarkahan', $data, true);
		$this->load->view('welcome_message', $data);
	}
	
	function pilihanpengurusan()
	{
		$data['centrecode'] = $this->m_result->get_institusi();
		$pengurusan = $this->input->post('pengurusan');
		$pentaksiran = $this->input->post('pentaksiran');
		$tmpKursus = $this->input->post('slct_kursus');
		$slct_kursus = (empty($tmpKursus))?10:$this->input->post('slct_kursus');
		
		
		$data['gred_akademik'] = $this->m_pelajar->gred_akademik_list();
		
		$data['kursus'] = $this->m_kursus->kursus_list();
		$data['subjek_akademik'] = $this->m_pelajar->subjek_akademik_list();
		$data['pelajar_akademik'] = $this->m_pelajar->pelajar_akademik_list($slct_kursus);
		$data['subjek_kv'] = $this->m_pelajar->subjek_kv_list($slct_kursus);
		$data['pilihan'] = $pengurusan;
		$data['pentaksiran'] = $pentaksiran;
		$data['view_content'] = $this->load->view('peperiksaan/pemarkahan', $data, true);
		$this->load->view('welcome_message', $data);
	}
	
	function proses_akademik()
	{
	 $penilaian = $this->input->post("penilaian");
	 $subjek_akademik = $this->m_pelajar->subjek_akademik_list();
	 $pelajar_akademik = $this->m_pelajar->pelajar_akademik_list();
	 
	 $arrPelajar  = array();
	 
	 for($i=0; $i < sizeof($pelajar_akademik); $i++)
	 {
		 $arrSubjek = array();
		 $rsp = $pelajar_akademik[$i];
		
		for($j=0; $j < sizeof($subjek_akademik); $j++)
		{
			$rsa = $subjek_akademik[$j];
			$mark = $_POST['sub_'.$rsa->subjek_id.'_'.$rsp->id_pelajar];
			$arrSubjek[$rsa->subjek_id] = ($mark=="")?0:$mark;
		}
		$arrPelajar[$rsp->id_pelajar] = $arrSubjek;
	 }
	  $json_pelajar = json_encode($arrPelajar);
	  
	  $_SESSION['aka_'.$penilaian] = $json_pelajar;
	  redirect("peperiksaan/pemarkahan/pilihanpengurusan");
	}
	
	function proses_kv()
	{
	 $penilaian = $this->input->post("penilaian");
	 $subjek_kv = $this->m_pelajar->subjek_kv_list();
	 $pelajar_akademik = $this->m_pelajar->pelajar_akademik_list();
	 
	 $arrPelajar  = array();
	 
	 for($i=0; $i < sizeof($pelajar_akademik); $i++)
	 {
		 $arrSubjek = array();
		 $rsp = $pelajar_akademik[$i];
		
		for($j=0; $j < sizeof($subjek_kv); $j++)
		{
			$rsa = $subjek_kv[$j];
			$mark = $_POST['sub_'.$rsa->subjek_id.'_'.$rsp->id_pelajar];
			$arrSubjek[$rsa->subjek_id] = ($mark=="")?0:$mark;
		}
		$arrPelajar[$rsp->id_pelajar] = $arrSubjek;
	 }
	  $json_pelajar = json_encode($arrPelajar);
	  
	  $_SESSION['kv_'.$penilaian] = $json_pelajar;
	  redirect("peperiksaan/pemarkahan/pilihanpengurusan");
	}
	
	function lecturesatu()
	{
		$data['kursus'] = $this->m_kursus->kursus_list();		
        $data['view_content'] = $this->load->view('peperiksaan/lecturesatu', $data, true);
		$this->load->view('welcome_message2', $data);
	}
	
	function pilihanpengurusan1()
	{
		$pengurusan = $this->input->post('pengurusan');
		$pentaksiran = $this->input->post('pentaksiran');
		
		$data['kursus'] = $this->m_kursus->kursus_list();
		$data['pilihan'] = $pengurusan;
		$data['view_content'] = $this->load->view('peperiksaan/lecturesatu', $data, true);
		$this->load->view('welcome_message2', $data);
	}
}
?>