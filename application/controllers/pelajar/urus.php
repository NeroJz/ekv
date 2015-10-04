<?php
class Urus extends CI_Controller {
	
	var $kod_pusat = "AB809";
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('m_pelajar');
		$this->load->model('m_kursus');
	}

	function index() 
	{
		$data = array();
		$data['kursus'] = $this->m_kursus->kursus_list();
        $data['view_content'] = $this->load->view('pelajar/v_daftar', $data, true);
		$this->load->view('welcome_message', $data);
	}
	
	function proses_daftar()
	{
		$arrPelajar = array(
						"id_pusat" => 1,
						"no_kp" => $this->input->post("no_kp"),
						"nama_pelajar" => $this->input->post("nama_pelajar"),
						"angka_giliran" => $this->input->post("angka_giliran"),
						"jantina" => $this->input->post("jantina"),
						"kaum" => $this->input->post("kaum"),
						"agama" => $this->input->post("agama")
					  );
					  
		$id_pelajar = $this->m_pelajar->add($arrPelajar);
		
		$arrLevel = array(
						"id_pelajar" => $id_pelajar,
						"level_status" => 1,
						"level_semester" => 1,
						"tahun" => date("Y"),
						"kursus_id" => $this->input->post("kursus")
					);
					
		$level_id = $this->m_pelajar->add_level($arrLevel);
		
		$lsSubject = $this->m_pelajar->getSubjectById($this->input->post("kursus"));
		
		foreach($lsSubject as $rs)
		{
			$arrSubject = array(
						  	"subjek_id" => $rs->subjek_id,
							"level_id" => $level_id,
							"semester_diambil" => 1,
							"tahun_diambil" => date("Y")	
						  );
			$this->m_pelajar->add_subjek($arrSubject);
		}
		
		for($i=1;$i <= 7; $i++)
		{
			$arrSubject = array(
						  	"subjek_id" => $i,
							"level_id" => $level_id,
							"semester_diambil" => 1,
							"tahun_diambil" => date("Y")	
						  );
			$this->m_pelajar->add_subjek($arrSubject);
		}
		
		if($level_id)
		{
			$this->session->set_flashdata("msg","success%Pelajar Telah berjaya didaftarkan");
		}
		else
		{
			$this->session->set_flashdata("msg","error%Pelajar tidak berjaya didaftarkan");
		}
		
		redirect("pelajar/urus");
	}

}//end of class