<?php
session_start();
class General_marking extends MY_Controller {
	
	function __construct() 
	{
		parent::__construct();
		$this->load->model('m_kursus');
		$this->load->model('m_pelajar');
		$this->load->model('m_result');
		$this->load->model('m_process_marking');
		
	}

	function index() 
	{
		$user_login = $this->ion_auth->user()->row();
		$colid = $user_login->col_id;
		$userId = $user_login->user_id;
		$state_id= $user_login->state_id;

		$user_groups = $this->ion_auth->get_users_groups($userId)->row();  
		$ul_type= $user_groups->ul_type;
		  
		if($ul_type=="KV"){
			$col=get_user_collegehelp($userId);
			$data['colname']=$col[0]->col_name.' - '.$col[0]->col_type.$col[0]->col_code;
		}
		
		$data['ul_type'] =$ul_type;
		$data['year'] =$this->m_result->list_year_mt();
		$data['centrecode'] = $this->m_result->get_institusi();
		$pengurusan = $this->input->post('pengurusan');
		$pentaksiran = $this->input->post('pentaksiran');
		$data['pilihan'] = $pengurusan;
		$data['pentaksiran'] = $pentaksiran;
		
		$data['kursus'] = $this->m_kursus->kursus_list();
        $data['output'] = $this->load->view('marking/v_general_marking', $data, true);
		
		$this->load->view('main', $data);
	}
	
	function view_list()
	{
		$user_login = $this->ion_auth->user()->row();
		$colid = $user_login->col_id;
		$userId = $user_login->user_id;
		$state_id= $user_login->state_id;

		  $user_groups = $this->ion_auth->get_users_groups($userId)->row();  
		  $ul_type= $user_groups->ul_type;
		  
		if($ul_type=="KV"){
			$col=get_user_collegehelp($userId);
			$data['colname']=$col[0]->col_name.' - '.$col[0]->col_type.$col[0]->col_code;
		}
		
		$data['ul_type'] =$ul_type;
		$data['year'] =$this->m_result->list_year_mt();
		$data['centrecode'] = $this->m_result->get_institusi();
		$pengurusan = $this->input->post('pengurusan');
		$pentaksiran = $this->input->post('pentaksiran');
		$tmpKursus = $this->input->post('slct_kursus');
		$semester = $this->input->post('semester');
		$year = $this->input->post('slct_tahun');
		$slct_kursus = (empty($tmpKursus))?10:$this->input->post('slct_kursus');
		
		//$modList = $this->m_pelajar->subjek_list($tmpKursus, $semester,"AK");
		
		//print_r($modList);
		$assessment = substr($pentaksiran, 1);
		
		$data['kursus'] = $this->m_kursus->kursus_list();
		$data['subjek_akademik'] = $this->m_pelajar->subjek_list($tmpKursus, $semester, strtoupper($pengurusan));
		$data['pelajar_akademik'] = $this->m_pelajar->pelajar_generalMarking_list($tmpKursus, $semester, $year, strtoupper($pengurusan), strtoupper($assessment));
		$data['subjek_kv'] = $this->m_pelajar->subjek_kv_list($tmpKursus, $semester);
		$data['pilihan'] = $pengurusan;
		$data['pentaksiran'] = $pentaksiran;
		$data['output'] = $this->load->view('marking/v_general_marking', $data, true);
		$this->load->view('main', $data);
	}
	
	function view_kursus_by_kod(){
		$colID = $this->input->post("colID")!=""?$this->input->post("colID"):'';
		$ccID = $this->input->post("ccID")!=""?$this->input->post("ccID"):'';
		
		$colType = substr($colID, 0, 1);
		$colCode = substr($colID, 1, 2);
		
		$aCourse = $this->m_process_marking->getCourseByCodeNType($colType, $colCode);
		
		echo '<option value="">-- Sila Pilih --</option>';
		
		if(!empty($aCourse))
		{
			foreach($aCourse as $rc){
				echo '<option value="'.$rc->cc_id.'" '.($ccID!=$rc->cc_id?'':'selected="selected"').'>'.$rc->cou_name.'</option>';
			}
		}
	}
	
	function process_marking()
	{
		$urlRedirect = 'examination/general_marking/view_list';
		
		$curAssessment = $this->input->post('curAssessment');
		$curSemester = $this->input->post('curSemester');
		$curYear = $this->input->post('curYear');
		$curModType = $this->input->post('curModType'); //VK or AK
		$curCourse = $this->input->post('curCourse');
		
		$assessment = substr($curAssessment, 1); //P OR S
		
		$studentWithCurSubject = $this->m_pelajar->pelajar_generalMarkingProcess_list($curCourse, $curSemester, $curYear, strtoupper($curModType), strtoupper($assessment));
		
		if(!empty($studentWithCurSubject))
		{
			$modInsert = array();
			$modUpdate = array();
			foreach($studentWithCurSubject as $rStud)
			{
				
				if(!empty($rStud->listModuleTakenMarksAk))
				{
					$listMod = $rStud->listModuleTakenMarksAk;
					foreach($listMod as $rMod){
						//total mark untuk per 100	
						$curMarkA = $this->input->post("sub_".$rMod['md_id']."_".$rStud->stu_id);
						$curMarkB = $this->input->post("mark_".$rMod['md_id']."_".$rStud->stu_id);
						$totalMark = $this->input->post("totalMark_".$rMod['md_id']."_".$rStud->stu_id);
						$markStatus = $this->input->post("markStatus_".$rMod['md_id']."_".$rStud->stu_id);
						
						$curTotalMark = $curModType == "ak" ? 100 : $totalMark;
						$curMark = $curModType == "ak" ? $curMarkA : $curMarkB;
						
						if(empty($markStatus))
						{
							if($curMark != 0 || $curMark == "T"){
								
								if($curMark == "T"){
									$curMark = -99.99;
								}
								
								$modCurrent = array(
										  	"marks_assess_type" => strtoupper($curModType),
										  	"mark_category" => strtoupper($assessment),
										  	"marks_total_mark" => $curTotalMark,
										  	"marks_value" => $curMark,
										  	"md_id" => $rMod['md_id']
										 );
								array_push($modInsert, $modCurrent);
							}
						}
						else {
							if($curMark != 0 || $curMark == "T"){
								if($curMark == "T"){
									$curMark = -99.99;
								}
								
								$modCurrent = array(
										  	"marks_id" => $markStatus,
											"marks_value" => $curMark,
										  	"md_id" => $rMod['md_id']
										  );
								array_push($modUpdate, $modCurrent);
							}
						}
					}
				}
			}

			if(sizeof($modInsert) > 0){
				//insert to database via batch
				$this->m_pelajar->batch_insert_marks($modInsert);		
			}
			
			if(sizeof($modUpdate) > 0){
				//update to database via batch
				$this->m_pelajar->batch_update_marks($modUpdate);	
			}
			
			echo 1;
		}
		else {
			echo 0;
		}
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