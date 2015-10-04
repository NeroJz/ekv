<?php
session_start();
class Combine_repeat extends MY_Controller {
	
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('m_kursus');
		$this->load->model('m_pelajar');
		$this->load->model('m_result');
		$this->load->model('m_process_marking');
		$this->load->model('m_combinerepeat');
		
	}

	function index() 
	{
		$data['year'] =$this->m_result->list_year_mt();
		$data['centrecode'] = $this->m_result->get_institusi();
		$pengurusan = $this->input->post('pengurusan');
		$pentaksiran = $this->input->post('pentaksiran');
		$data['pilihan'] = $pengurusan;
		$data['pentaksiran'] = $pentaksiran;
		
		$data['kursus'] = $this->m_kursus->kursus_list();
        $data['output'] = $this->load->view('marking/v_combinerepeat', $data, true);
		$this->load->view('main', $data);
	}
	
	function view_list()
	{
	
		$data['year'] =$this->m_result->list_year_mt();
		$data['centrecode'] = $this->m_result->get_institusi();
		$pengurusan = $this->input->post('pengurusan');
	//	$pengurusan = 'ak';
		$pentaksiran = $this->input->post('pentaksiran');
		$tmpKursus = $this->input->post('slct_kursus');
		$semester = $this->input->post('semester');
		$year = $this->input->post('slct_tahun');
		$kodpusat = $this->input->post('kodpusat');
		
		$cC=explode('-', $kodpusat);
		
		$slct_kursus = (empty($tmpKursus))?10:$this->input->post('slct_kursus');
		
		$data['kursus'] = $this->m_kursus->kursus_list();
		$data['subjek_akademik'] = $this->m_combinerepeat->subjek_akademik_list($cC[0], $semester,$year,$tmpKursus);
		
		$data['pelajar_akademik'] = $this->m_combinerepeat->pelajar_akademik_list($tmpKursus, $semester, $year, strtoupper($pengurusan));
		$data['subjek_kv'] = $this->m_combinerepeat->subjek_kv_list($cC[0], $semester,$year,$tmpKursus);
	
	//print_r($data['pelajar_akademik']);
	
		$data['pilihan'] = $pengurusan;
		$data['pentaksiran'] = 'cc';
		$data['output'] = $this->load->view('marking/v_combinerepeat', $data, true);
		$this->load->view('main', $data);
	}
	
	function view_kursus_by_kod(){
		$colID = $this->input->post("colID")!=""?$this->input->post("colID"):'K36';
		
		$colType = substr($colID, 0, 1);
		$colCode = substr($colID, 1, 2);
		
		$aCourse = $this->m_process_marking->getCourseByCodeNType($colType, $colCode);
		
		echo '<option value="">-- Sila Pilih --</option>';
		
		if(!empty($aCourse))
		{
			foreach($aCourse as $rc){
				echo '<option value="'.$rc->cc_id.'">'.$rc->cou_name.'</option>';
			}
		}
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