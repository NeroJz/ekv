<?php

/**************************************************************************************************
* File Name        : markings.php
* Description      : This File contain Examination module for Pusat.
* Author           : Norafiq Bin Mohd Azman Chew
* Date             : 3 July 2013
* Version          : -
* Modification Log : -
* Function List	   : __construct(), index, select_configuration, spsubject, save_configurations,
*					 load_configurations, get_swb, get_assignment, assignmentToDelete,
*					 save_assignment, get_ak_swb, _main_output
**************************************************************************************************/

	class Markings_v3 extends MY_Controller 
	{
		/******************************************************************************************
		* Description		: Constructor = load model
		* input				: - 
		* author			: Norafiq Azman
		* Date				: 3 July 2013
		* Modification Log	: -
		******************************************************************************************/
		function __construct() 
		{
			parent::__construct();
			$this->load->model('m_kursus');
			$this->load->model('m_pelajar');
			$this->load->model('m_subject');
			$this->load->library('grocery_CRUD');
		}
		
		/******************************************************************************************
		* Description		: Index. $userid = on session for pensyarah login. for others user
		* 					  create new function :)
		* input				: - 
		* author			: Norafiq Azman
		* Date				: 3 July 2013
		* Modification Log	: -
		******************************************************************************************/
		function index() 
		{
			$user = $this->ion_auth->user()->row();
			$userid = $user->id;
			
			$year = $this->session->userdata["tahun"];
			
			
			$data['kursus'] = $this->m_kursus->login_course($userid, $year);
			$listKursus = $this->m_kursus->login_courseByUsr($userid, $year);

			$optPentaksir = array();

			if(!empty($listKursus)){
				foreach($listKursus as $rw){
					$optPentaksir[$rw->cou_id."_".$rw->cm_semester]["cou_code"] = $rw->cou_course_code;
					$optPentaksir[$rw->cou_id."_".$rw->cm_semester]["cou_name"] = $rw->cou_name;
					$optPentaksir[$rw->cou_id."_".$rw->cm_semester]["cou_modul"][$rw->mod_id]['mod_id'] = $rw->mod_id; 
					$optPentaksir[$rw->cou_id."_".$rw->cm_semester]["cou_modul"][$rw->mod_id]['mod_name'] = $rw->mod_name;
					$optPentaksir[$rw->cou_id."_".$rw->cm_semester]["cou_modul"][$rw->mod_id]['mod_type'] = $rw->mod_type; 
					$optPentaksir[$rw->cou_id."_".$rw->cm_semester]["cou_modul"][$rw->mod_id]['cm_id'] = $rw->cm_id;
					$optPentaksir[$rw->cou_id."_".$rw->cm_semester]["cou_modul"][$rw->mod_id]['mod_code'] = $rw->mod_code;
					$optPentaksir[$rw->cou_id."_".$rw->cm_semester]["cou_modul"][$rw->mod_id]['modul_kelas'][$rw->class_id] = $rw->class_name;	  
				}
			}

			$data["optPentaksir"] = json_encode($optPentaksir);

			//send user id to  view
			$data["currentKVUser"] = $userid;

	        $output['output'] = $this->load->view('marking/v_evaluation_form_sekolah_v3', $data, true);
			$this->load->view('mainOffline.php', $output);
		}
		
		/******************************************************************************************
		* Description		: this function to get list of student from kursus yang diajar
		* input				: -
		* author			: Norafiq Azman
		* Date				: 3 July 2013
		* Modification Log	: -
		******************************************************************************************/
		function select_configuration()
		{
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
			
			$output['output'] = $this->load->view('marking/v_evaluation_form_sekolah_v3', $data, true);
			$this->load->view('main.php', $output);
		}
		
		/******************************************************************************************
		* Description		: this function to get lecture subject in course teaching
		* 					  json responder
		* input				: -
		* author			: Norafiq Azman
		* Date				: 3 July 2013
		* Modification Log	: -
		******************************************************************************************/
		function spsubject()
		{
			$courselect = $this->input->post("course_id");
			$semester = $this->input->post("semes_ter");
			
			//echo "<pre>";					//FDP
			//print_r ($courselect);
			//echo "</pre>";
			////die();
						
			$data = $this->m_subject->subject_by_spid($courselect, $semester);
			$response = array('subjek' => $data);
			
			echo(json_encode($response));

		}
		
	
		/******************************************************************************************
		* Description		: this function to get class by lecture assign and modul
		* 					  json responder
		* input				: -
		* author			: UMAIRAH
		* Date				: 14 MARCH 2014
		* Modification Log	: -
		******************************************************************************************/
		function spsubject_kelas()
		{
			$courselect = $this->input->post("course_id");
			$semester = $this->input->post("semes_ter");
			$cm_id_modul = $this->input->post("slct_jubject");
		
			//print_r($courselect);
			//print_r($semester);
			//print_r($cm_id_modul);
			//die();
			$class_data = $this->m_subject->get_classes($courselect, $semester, $cm_id_modul);
				
			$response = array('class_data'=> $class_data);
		
			echo(json_encode($response));
		
		}
		
		/******************************************************************************************
		* Description		: this function get subject configuration detail
		* input				: -
		* author			: Norafiq Azman
		* Date				: 3 July 2013
		* Modification Log	: umairah - class
		******************************************************************************************/
		function save_configurations()
		{
			$user = $this->ion_auth->user()->row();
			$userid = $user->id;
			
			$dataAK = $this->input->post();
			
			$year = $this->session->userdata["tahun"];
							
			$cmID = $this->input->post("ksmid2");
			
			$courselect = $this->input->post("kursusid");
			$subselect = $this->input->post("subjectid");
			$semselect = $this->input->post("semesterP");
			$pentaksiran = $this->input->post("pentaksiran");
			$mptid = $this->input->post("mptID");
			$kelas = $this->input->post("kelas");
			$tempcategory = $this->input->post("tempKAt2"); //temp buang lepas wujud fucntion AK
						
			//echo ('cmID = '.$cmID.'<br>'); //FDP
			
			$tgsid = $this->input->post("tgsid0");
			$tugasan = $this->input->post("tugasan0");
			$peratusan = $this->input->post("peratusan0");
			$jmltugasan = $this->input->post("jmlhtugsan0");
			$tugasanterbaik = $this->input->post("tugasanterbaik0");
			
			$tgsid1 = $this->input->post("tgsid1");
			$tugasan1 = $this->input->post("tugasan1");
			$peratusan1 = $this->input->post("peratusan1");
			$jmltugasan1 = $this->input->post("jmlhtugsan1");
			$tugasanterbaik1 = $this->input->post("tugasanterbaik1");
			
			$la = $this->m_subject->get_laID($cmID,$kelas);
			
			$configuration = $this->m_subject->subject_configuratian($pentaksiran, $cmID, $tempcategory,$kelas);
			//print_r($tempcategory);
			//die();
							
			if(null == $configuration && empty($configuration))
			{
				if($tempcategory == 'VK')
				{
					if(isset($tgsid) && "" == $tgsid)
					{				
						if($tempcategory == 'VK')
						{
							$dataconfigur = array(
							    'assgmnt_name' => $tugasan ,
							  	'assgmnt_mark' => $peratusan ,
							  	'assgmnt_total' => $jmltugasan,
							  	'assgmnt_score_selection' => $tugasanterbaik,
							  	'la_id' => $la->la_id,
							  	'pt_id' => $mptid
							);
						}
						else if($tempcategory == 'AK')
						{
							
							$dataconfigur = array(
							    'assgmnt_name' => $tugasan ,
							  	'assgmnt_mark' => $peratusan ,
							  	'assgmnt_total' => $jmltugasan,
							  	'assgmnt_score_selection' => $tugasanterbaik,
							  	'la_id' => $la->la_id,
							  	'ppr_id' => $mptid
							);
						}
						
						$this->m_subject->save_configur_subject($dataconfigur);
					}
					
					if(isset($tgsid1) && "" == $tgsid1)
					{
						if("" != $tugasan1)	
						{
							if($tempcategory == 'VK')
							{	
								$dataconfigur = array(
								    	'assgmnt_name' => $tugasan1 ,
									  	'assgmnt_mark' => $peratusan1 ,
									  	'assgmnt_total' => $jmltugasan1 ,
									  	'assgmnt_score_selection' => $tugasanterbaik1 ,
									  	'la_id' => $la->la_id,
									  	'pt_id' => $mptid
								);
							}
							else if($tempcategory == 'AK')
							{
								$dataconfigur = array(
								    	'assgmnt_name' => $tugasan1 ,
									  	'assgmnt_mark' => $peratusan1 ,
									  	'assgmnt_total' => $jmltugasan1 ,
									  	'assgmnt_score_selection' => $tugasanterbaik1 ,
									  	'la_id' => $la->la_id,
									  	'ppr_id' => $mptid
								);
							}
							
							$this->m_subject->save_configur_subject($dataconfigur);
						}
					}
		
				}			
				
			}
			else 
			{
				if($tempcategory == 'VK')
				{
					if(isset($tgsid) && "" != $tgsid)
					{
						$dataconfigur = array(
								    'assgmnt_name' => $tugasan ,
								  	'assgmnt_mark' => $peratusan ,
								  	'assgmnt_total' => $jmltugasan,
								  	'assgmnt_score_selection' => $tugasanterbaik,
								  	'la_id' => $la->la_id
						);
							
						$this->m_subject->update_configur_subject($dataconfigur, $tgsid);
					}
					else
					{
						$dataconfigur = array(
						    'assgmnt_name' => $tugasan ,
						  	'assgmnt_mark' => $peratusan ,
						  	'assgmnt_total' => $jmltugasan,
						  	'assgmnt_score_selection' => $tugasanterbaik,
						  	'la_id' => $la->la_id,
						  	'pt_id' => $mptid
						);

						$this->m_subject->save_configur_subject($dataconfigur);
					}
					
					if(isset($tgsid1) && "" != $tgsid1)
					{
						$dataconfigur = array(
									'assgmnt_name' => $tugasan1 ,
								  	'assgmnt_mark' => $peratusan1 ,
								  	'assgmnt_total' => $jmltugasan1 ,
								  	'assgmnt_score_selection' => $tugasanterbaik1 ,
								  	'la_id' => $la->la_id
						);
							
						$this->m_subject->update_configur_subject($dataconfigur, $tgsid1);
					}
					else
					{
						$dataconfigur = array(
						    	'assgmnt_name' => $tugasan1 ,
							  	'assgmnt_mark' => $peratusan1 ,
							  	'assgmnt_total' => $jmltugasan1 ,
							  	'assgmnt_score_selection' => $tugasanterbaik1 ,
							  	'la_id' => $la->la_id,
							  	'pt_id' => $mptid
						);

						$this->m_subject->save_configur_subject($dataconfigur);
					}
				}
				
						
				
			}


			if($tempcategory == 'AK')
			{
				//New AK save/update (V3)
				if(!empty($dataAK))
				{
					foreach($dataAK as $keys => $values)
					{
						if(strpos($keys,'tugasan') !== false)
						{
							$assgmnt_id = $values['assgmnt_id'];
							$assgmnt_name = $values['assgmnt_name'];
							$assgmnt_mark = $values['assgmnt_mark'];
							$assgmnt_total = $values['assgmnt_total'];
							$assgmnt_score_selection = $values['assgmnt_score_selection'];
							
							
							if($assgmnt_id > 0)
							{
								$dataconfigur = array(
								    	'assgmnt_name' => $assgmnt_name ,
									  	'assgmnt_mark' => $assgmnt_mark ,
									  	'assgmnt_total' => $assgmnt_total ,
									  	'assgmnt_score_selection' => $assgmnt_score_selection ,
									  	'la_id' => $la->la_id
								);
								
								$this->m_subject->update_configur_subject($dataconfigur, $assgmnt_id);
							}
							else
							{
								$dataconfigur = array(
								    	'assgmnt_name' => $assgmnt_name ,
									  	'assgmnt_mark' => $assgmnt_mark ,
									  	'assgmnt_total' => $assgmnt_total ,
									  	'assgmnt_score_selection' => $assgmnt_score_selection ,
									  	'la_id' => $la->la_id,
									  	'ppr_id' => $mptid
								);
								
								$this->m_subject->save_configur_subject($dataconfigur);
							}
							
						}
					}
					
					//echo "<pre>";					//FDP
					//print_r ($dataconfigur);
					//echo "</pre>";
					//die();
				}
			}	
			
			
			$data['subjekconfigur'] = $this->m_subject->subject_configuratian($pentaksiran, $cmID, $tempcategory,$kelas);
			$data['idParent'] = $this->m_subject->getIdParent($userid, $cmID);
			//check tarikh buka utk teori dan amali
			//$amaliOpen = $this->m_subject->isMarkingOpen("SA", $semselect);
			//$teoriOpen = $this->m_subject->isMarkingOpen("ST", $semselect);
			//$academikOpen = $this->m_subject->isMarkingOpen("SAK", $semselect);
			
			//$data['academikOpen'] = $academikOpen;
			//$data['amaliOpen'] = $amaliOpen;
			//$data['teoriOpen'] = $teoriOpen;
			
			$pelajar = $this->m_pelajar->student_marking($cmID, $semselect,$kelas);
			
			//if($academikOpen || $amaliOpen || $teoriOpen) // salah satu open, so load detail pelajar
			//{
				if(isset($pelajar) && isset($data['subjekconfigur']))	
				{
					foreach($pelajar as $p)
					{
						$aMarkah = array();
						
						foreach($data['subjekconfigur'] as $sbc)
						{
							$m = $this->m_subject->
							    getStudentMarkForAssignment($p->stu_id, $sbc->assgmnt_id, 
							    $sbc->assgmnt_score_selection, $sbc->assgmnt_mark);
							
							array_push($aMarkah, $m);
						}
						
						$p->markah = $aMarkah;
					}
				}
				
				//$data['senaraipelajar'] = $pelajar;
			//}
			//else if(!$amaliOpen && !$teoriOpen) //amali ngan teori tak buka, tak perlu load senarai pelajar
			//{
			//	$data['noopen'] = true;
			//}
			
			$data['senaraipelajar'] = $pelajar;			

			$data['kursus'] = $this->m_kursus->login_course($userid, $year);
			$data['kursusID'] = $courselect;
			$data['subjek'] = $this->m_subject->subject_by_spid($courselect, $semselect);
						
			$data['subjectID'] = $subselect;
			$data['semesterP'] = $semselect;
			$data['assessType'] = $tempcategory;
			$data['kelasID'] = $kelas;
			$data['kelas'] = $this->m_subject->get_classes($courselect, $semselect, $cmID);
				
			//echo "<pre>";					//FDP
			//print_r ($data);
			//echo "</pre>";
			//die();
			
			$output['output'] = $this->load->view('marking/v_evaluation_form_sekolah_v3', $data, true);
			$this->load->view('main.php', $output);
		}
		
		/******************************************************************************************
		* Description		: this function to load form loadstudent
		* input				: -
		* author			: Norafiq Azman
		* Date				: 3 July 2013
		* Modification Log	: umairah - class
		******************************************************************************************/
		function load_configurations()
		{
			$user = $this->ion_auth->user()->row();
			$userid = $user->id;
			
			$year = $this->session->userdata["tahun"];
							
			$cmID = $this->input->post("ksmid3");
			
			$courselect = $this->input->post("kursusid3");
			$subselect = $this->input->post("subjectid3");
			$semselect = $this->input->post("semesterP3");
			$pentaksiran = $this->input->post("pentaksiran3");
			$kelas = $this->input->post("kelas3");
			$tempcategory = $this->input->post("tempKAt");

			$data['subjekconfigur'] = $this->m_subject->subject_configuratian($pentaksiran, $cmID, $tempcategory,$kelas);
			$data['idParent'] = $this->m_subject->getIdParent($userid, $cmID);
			
			//check tarikh buka utk teori dan amali
			//$amaliOpen = $this->m_subject->isMarkingOpen("SA", $semselect);
			//$teoriOpen = $this->m_subject->isMarkingOpen("ST", $semselect);
			//$academikOpen = $this->m_subject->isMarkingOpen("SAK", $semselect);
			
			//$data['academikOpen'] = $academikOpen;
			//$data['amaliOpen'] = $amaliOpen;
			//$data['teoriOpen'] = $teoriOpen;
			
			$pelajar = $this->m_pelajar->student_marking($cmID, $semselect,$kelas);
			
			//if($academikOpen || $amaliOpen || $teoriOpen) // salah satu open, so load detail pelajar
			//{
				if(isset($pelajar) && isset($data['subjekconfigur']))	
				{
					foreach($pelajar as $p)
					{
						$aMarkah = array();
						
						foreach($data['subjekconfigur'] as $sbc)
						{
							$m = $this->m_subject->
								getStudentMarkForAssignment($p->stu_id, $sbc->assgmnt_id, 
								$sbc->assgmnt_score_selection, $sbc->assgmnt_mark);
							
							array_push($aMarkah, $m);
						}
						
						$p->markah = $aMarkah;
					}
				}
			
				//$data['senaraipelajar'] = $pelajar;
			//}
			//else if(!$amaliOpen && !$teoriOpen) //amali ngan teori tak buka, tak perlu load senarai pelajar
			//{
			//	$data['noopen'] = true;
			//}
			
			$data['senaraipelajar'] = $pelajar;

			$jsonData = array();
			$jsonData['subjekconfigur'] = $data['subjekconfigur'];
			$jsonData['pelajar'] = $pelajar;
			$data['jsonPelajar'] = json_encode($jsonData);

			$data['kursus'] = $this->m_kursus->login_course($userid, $year);
			$data['kursusID'] = $courselect;
			$data['subjek'] = $this->m_subject->subject_by_spid($courselect, $semselect);
						
			$data['subjectID'] = $subselect;
			$data['semesterP'] = $semselect;
			$data['assessType'] = $tempcategory;
			$data['kelasID'] = $kelas;
			$data['kelas'] = $this->m_subject->get_classes($courselect, $semselect, $cmID);
				
			/*echo "<pre>";					//FDP
			print_r ($data);
			echo "</pre>";
			die();*/
			
			$output['output'] = $this->load->view('marking/v_evaluation_form_sekolah_v3', $data, true);
			$this->load->view('mainOffline.php', $output);
		}
		
		/******************************************************************************************
		* Description		: this function is json responder to get subject detail
		* input				: -
		* author			: Norafiq Azman
		* Date				: 3 July 2013
		* Modification Log	: umairah - class
		******************************************************************************************/
		function get_swb()
		{
			$cm_id 		 = $this->input->post("cmID");
			$pentaksiran = $this->input->post("pntksrn");		
			$type		 = $this->input->post("type");
			$kelas       = $this->input->post("slct_kelas");
			
			$data['weightage'] 		= $this->m_subject->subject_weightage($pentaksiran, $cm_id);
			$data['configuration']  = $this->m_subject->subject_configuratian($pentaksiran, $cm_id, $type,$kelas);
			
			$aJson= array("weightage" => $data['weightage'], "configuration" => $data['configuration']);
			echo(json_encode($aJson));
		}
		
		/******************************************************************************************
		* Description		: this function call to select assignment detail
		* 					  nak popup modal yang ada assignment number
		* input				: -
		* author			: Norafiq Azman
		* Date				: 3 July 2013
		* Modification Log	: umairah - class
		******************************************************************************************/
		function get_assignment()
		{
			$assmnt_id = $this->input->post("assgmnt_ID");
			$semselect = $this->input->post("semesterP");
			$cmID = $this->input->post("ksmid2");
			$kelas = $this->input->post("slct_kelas");
			$data['senaraipelajar'] = $this->m_pelajar->student_by_assmnt($cmID, $assmnt_id, $semselect,$kelas);			
			
			//echo "<pre>";
			//print_r ("assID:".$assmnt_id);				//FDP
			//print_r ("sems:".$semselect);
			//print_r ("cmid:".$cmID);
			//print_r ($data['senaraipelajar']);
			//echo "</pre>";
			//die();
			
			
			$data['subjekconfigur'] = $this->m_subject->subject_configuratian_assgmnt($assmnt_id);
			
			//echo('<pre>hello saya');//FDP
			//echo('</pre>');
			//die();
			
			$aJson= array("pelajar" => $data['senaraipelajar'], "subjek" => $data['subjekconfigur']);			
			echo(json_encode($aJson));
		}
		
		/******************************************************************************************
		* Description		: this function is json responder to delete assignment id
		* input				: -
		* author			: Norafiq Azman
		* Date				: 3 July 2013
		* Modification Log	: -
		******************************************************************************************/
		function assignmentToDelete()
		{
			$tugasanID = $this->input->post("tugasanID");			
			$data = $this->m_subject->deleteAssigment($tugasanID);
		}
		
		/******************************************************************************************
		* Description		: this function is json to save assignment marks
		* input				: -
		* author			: Norafiq Azman
		* Date				: 3 July 2013
		* Modification Log	: umairah - class
		******************************************************************************************/
		function save_assignment()
		{			
			$post_values = $this->input->post();
			$mark_list = array();
			$pentaksiran = $this->input->post("pentaksiran");
			$cmid = $this->input->post("cmid");
			$semester = $this->input->post("sem");
			$tempcategory = $this->input->post("cat");
			$kelas = $this->input->post("kelas4");

			
			foreach($post_values as $key => $value)
			{
				//key = subject_student_coursework_mark_id, value = mark 
				$values = $value;
				
				if($values =='T')
				{
					$values = -99.99;
				}
					
				//elseif($values == "")  //TODO
				//	$values = -99.99;
								
				$pos = strrpos($key, "_");
				
				if ($pos === false)
				{ 
				    // not found...
				}
				else
			    {
					$ids = explode("_",$key);
					$student_id = $ids[0];
					$assgnmt_id = $ids[1];
					$assgnmt_num = $ids[2];
					
					$data = array(
						'assgmnt_id' => $assgnmt_id,
						'stu_id' => $student_id,
						'assigmnt_number' => $assgnmt_num,
						'mark' => $values,
						'category' => "S"
					);
					
					$mark_list[] = $data;
				}				
			}
		
			//echo "<pre>";					//FDP
			//print_r ($post_values);
			//echo "</pre>";
			//die();
		
			$data = $this->m_subject->update_assigmnt_mark($mark_list);
			
			//update markah
			$subjekconfigur = $this->m_subject->subject_configuratian($pentaksiran, $cmid, $tempcategory,$kelas);
			
			$pelajar = $this->m_pelajar->student_marking($cmid, $semester,$kelas);
			
			if(isset($pelajar) && isset($subjekconfigur))	
			{
				$aMarkah = array();
				
				foreach($pelajar as $p)
				{
					$totalMark = 0.00;
					$totalMarkAssgmnt = 0.00;
					$mAvg = 0.00;
					$i = 0;
											
					foreach($subjekconfigur as $sbc)
					{						
						$markah = $this->m_subject->
						    getStudentMarkForAssignmentMark($p->stu_id, $sbc->assgmnt_id, 
						    $sbc->assgmnt_score_selection, $sbc->assgmnt_mark);
							
						if($tempcategory == "VK")
						{
							$category = $sbc->pt_category;
							$totalMarkAssgmnt += $sbc->assgmnt_mark;
						}
						else if($tempcategory == "AK")
						{
							$category = $sbc->ppr_category;						
							$mod_id = $sbc->mod_id;					
							
							$totalMarkAssgmnt = $this->m_subject->getModuleMark($mod_id, $category);
						}
						
						if($markah < 0)
						{
							$totalMark += 0;
							$mAvg += $markah;
						}
						else
						{
							$totalMark += $markah;
						}
						
						$i++;
						
						//echo("stud :".$p->stu_id." assg : ".$sbc->assgmnt_id." mark : ".$sbc->assgmnt_mark."<br>");
					}
				
					if(($mAvg/$i) == -99.99)
					{
						$totalMark = -99.99;
					}
					
					$data = array(
						'marks_assess_type' => $tempcategory,
						'mark_category' => $category,
						'marks_total_mark' => $totalMarkAssgmnt,
						'marks_value' => $totalMark,
						'md_id' => $p->md_id
					);						
					
					array_push($aMarkah, $data);
				}
				
				$this->m_subject->save_marks($aMarkah);
				//save ke dalam table marks utk setiap pelajar
				//echo ('<pre>');
				//print_r($aMarkah);
				//echo ('</pre>');
				//die();
			}
		}

		/******************************************************************************************
		* Description		: this function is json to select model catagory AK
		* input				: -
		* author			: Norafiq Azman
		* Date				: 3 July 2013
		* Modification Log	: umairah -class
		******************************************************************************************/
		function get_ak_swb()
		{
			$cm_id 		 = $this->input->post("cmID");
			$pentaksiran = $this->input->post("pntksrn");
			$type		 = $this->input->post("type");
			$user 		 = $this->ion_auth->user()->row();
			$kelas       = $this->input->post("slct_kelas");

			$data['weightage'] =  $this->m_subject->get_all_paper($cm_id, $pentaksiran ,$type);
			$data['configuration'] = $this->m_subject->subject_configuratian($pentaksiran, $cm_id, $type,$kelas);
			$data['user']= $user->id;
			$aJson= array("weightage" => $data['weightage'], "configuration" => $data['configuration'], "user"=>$data['user']);
			echo(json_encode($aJson));
		}

		/******************************************************************************************
		* Description		: this function to display Crud table in main.php
		* input				: $output = null, $header = '' 
		* author			: Norafiq Azman
		* Date				: 3 July 2013
		* Modification Log	: -
		******************************************************************************************/
		function _main_output($output = null, $header = '')
		{
			$output->output = $header . $output->output;
			$this->load->view('main.php', $output);	
		}
		
		
		/******************************************************************************************
		* Description		: this function get save configuration for academic (AK)
		* input				: -
		* author			: Freddy Ajang Tony													
		* Date				: 03 February 2014
		* Modification Log	: umairah - class
		******************************************************************************************/
		function save_configurations_AK()
		{
			$user = $this->ion_auth->user()->row();
			$userid = $user->id;
			
			$year = $this->session->userdata["tahun"];
							
			$cmID = $this->input->post("ksmid2");
			
			$courselect = $this->input->post("kursusid");
			$subselect = $this->input->post("subjectid");
			$semselect = $this->input->post("semesterP");
			$pentaksiran = $this->input->post("pentaksiran");
			$mptid = $this->input->post("mptID");
			$kelas = $this->input->post("kelas3");
			
			$tempcategory = $this->input->post("tempKAt2"); //temp buang lepas wujud fucntion AK
						
			//echo ('cmID = '.$cmID.'<br>'); //FDP
			
			$tgsid = $this->input->post("tgsid0");
			$tugasan = $this->input->post("tugasan0");
			$peratusan = $this->input->post("peratusan0");
			$jmltugasan = $this->input->post("jmlhtugsan0");
			$tugasanterbaik = $this->input->post("tugasanterbaik0");
			
			$tgsid1 = $this->input->post("tgsid1");
			$tugasan1 = $this->input->post("tugasan1");
			$peratusan1 = $this->input->post("peratusan1");
			$jmltugasan1 = $this->input->post("jmlhtugsan1");
			$tugasanterbaik1 = $this->input->post("tugasanterbaik1");
			
			$la = $this->m_subject->get_laID($cmID,$kelas);
			
			$configuration = $this->m_subject->subject_configuratian($pentaksiran, $cmID, $tempcategory,$kelas);
			//print_r($configuration);
			//die();
				
			if(null == $configuration && empty($configuration))
			{
				if(isset($tgsid) && "" == $tgsid)
				{				
					if($tempcategory == 'VK')
					{
						$dataconfigur = array(
						    'assgmnt_name' => $tugasan ,
						  	'assgmnt_mark' => $peratusan ,
						  	'assgmnt_total' => $jmltugasan,
						  	'assgmnt_score_selection' => $tugasanterbaik,
						  	'la_id' => $la->la_id,
						  	'pt_id' => $mptid
						);
					}
					else if($tempcategory == 'AK')
					{
						$dataconfigur = array(
						    'assgmnt_name' => $tugasan ,
						  	'assgmnt_mark' => $peratusan ,
						  	'assgmnt_total' => $jmltugasan,
						  	'assgmnt_score_selection' => $tugasanterbaik,
						  	'la_id' => $la->la_id,
						  	'ppr_id' => $mptid
						);
					}
					
					$this->m_subject->save_configur_subject($dataconfigur);
				}
				
				if(isset($tgsid1) && "" == $tgsid1)
				{
					if("" != $tugasan1)	
					{
						if($tempcategory == 'VK')
						{	
							$dataconfigur = array(
							    	'assgmnt_name' => $tugasan1 ,
								  	'assgmnt_mark' => $peratusan1 ,
								  	'assgmnt_total' => $jmltugasan1 ,
								  	'assgmnt_score_selection' => $tugasanterbaik1 ,
								  	'la_id' => $la->la_id,
								  	'pt_id' => $mptid
							);
						}
						else if($tempcategory == 'AK')
						{
							$dataconfigur = array(
							    	'assgmnt_name' => $tugasan1 ,
								  	'assgmnt_mark' => $peratusan1 ,
								  	'assgmnt_total' => $jmltugasan1 ,
								  	'assgmnt_score_selection' => $tugasanterbaik1 ,
								  	'la_id' => $la->la_id,
								  	'ppr_id' => $mptid
							);
						}
						
						$this->m_subject->save_configur_subject($dataconfigur);
					}
				}
			}
			else 
			{			
				if(isset($tgsid) && "" != $tgsid)
				{
					$dataconfigur = array(
							    'assgmnt_name' => $tugasan ,
							  	'assgmnt_mark' => $peratusan ,
							  	'assgmnt_total' => $jmltugasan,
							  	'assgmnt_score_selection' => $tugasanterbaik,
							  	'la_id' => $la->la_id
					);
						
					$this->m_subject->update_configur_subject($dataconfigur, $tgsid);
				}
				
				if(isset($tgsid1) && "" != $tgsid1)
				{
					$dataconfigur = array(
								'assgmnt_id' => $tgsid1,
								'assgmnt_name' => $tugasan1 ,
							  	'assgmnt_mark' => $peratusan1 ,
							  	'assgmnt_total' => $jmltugasan1 ,
							  	'assgmnt_score_selection' => $tugasanterbaik1 ,
							  	'la_id' => $la->la_id
					);
						
					$this->m_subject->update_configur_subject($dataconfigur, $tgsid1);
				}
			}
			
			$data['subjekconfigur'] = $this->m_subject->subject_configuratian($pentaksiran, $cmID, $tempcategory,$kelas);
			
			//check tarikh buka utk teori dan amali
			//$amaliOpen = $this->m_subject->isMarkingOpen("SA", $semselect);
			//$teoriOpen = $this->m_subject->isMarkingOpen("ST", $semselect);
			//$academikOpen = $this->m_subject->isMarkingOpen("SAK", $semselect);
			
			//$data['academikOpen'] = $academikOpen;
			//$data['amaliOpen'] = $amaliOpen;
			//$data['teoriOpen'] = $teoriOpen;
			
			$pelajar = $this->m_pelajar->student_marking($cmID, $semselect, $kelas);
			
			//if($academikOpen || $amaliOpen || $teoriOpen) // salah satu open, so load detail pelajar
			//{
				if(isset($pelajar) && isset($data['subjekconfigur']))	
				{
					foreach($pelajar as $p)
					{
						$aMarkah = array();
						
						foreach($data['subjekconfigur'] as $sbc)
						{
							$m = $this->m_subject->
							    getStudentMarkForAssignment($p->stu_id, $sbc->assgmnt_id, 
							    $sbc->assgmnt_score_selection, $sbc->assgmnt_mark);
							
							array_push($aMarkah, $m);
						}
						
						$p->markah = $aMarkah;
					}
				}
				
				//$data['senaraipelajar'] = $pelajar;
			//}
			//else if(!$amaliOpen && !$teoriOpen) //amali ngan teori tak buka, tak perlu load senarai pelajar
			//{
			//	$data['noopen'] = true;
			//}
			
			$data['senaraipelajar'] = $pelajar;			

			$data['kursus'] = $this->m_kursus->login_course($userid, $year);
			$data['kursusID'] = $courselect;
			$data['subjek'] = $this->m_subject->subject_by_spid($courselect, $semselect);
						
			$data['subjectID'] = $subselect;
			$data['semesterP'] = $semselect;
			$data['assessType'] = $tempcategory;
			$data['kelasID'] = $kelas;
			$data['kelas'] = $this->m_subject->get_classes($courselect, $semselect, $cmID);
				
			//echo "<pre>";					//FDP
			//print_r ($data);
			//echo "</pre>";
			//die();
			
			$output['output'] = $this->load->view('marking/v_evaluation_form_sekolah_v3', $data, true);
			$this->load->view('main.php', $output);
		}

		/******************************************************************************************
		* Description		: this function process upload excel and extract 
		* input				: -
		* author			: Fakhruz
		* Date				: 17 Feb 2014
		* Modification Log	: -
		******************************************************************************************/
		function upload_from_excel(){

			$config['upload_path'] = './uploaded/excellkv/';
			$config['allowed_types'] = '*';
			$config['max_size']	= '2000000';
			

			$this->load->library('upload', $config);

			if ( ! $this->upload->do_upload())
			{
				$error = array('error' => $this->upload->display_errors());
				echo json_encode($error);
			}
			else
			{
				
				$data = array('upload_data' => $this->upload->data());
				$file = $this->upload->data();
				$thumbnail = $file['raw_name'].$file['file_ext'];
				
				$this->load->library('excel_reader');
				echo $this->excel_reader->import_with_pemarkahan_berterusan($thumbnail);

				unlink($config['upload_path'].$thumbnail);
			}
		}// end of function upload_from_excel

		
		/******************************************************************************************
		 * Description		: this function to donlod excel
		* input				: -
		* author			: 
		* Date				: 
		* Modification Log	: -umairah - 22/3/2014
		******************************************************************************************/
		
		function export_xls_markahStudent(){

			$abc = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
			     'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
			     'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ',
			     'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY', 'CZ', 
			     'DA', 'DB', 'DC', 'DD', 'DE', 'DF','DG','DH', 'DI', 'DJ', 'DK', 'DL');

			$mark = array();

			for($i = 0; $i <=100; $i++){
				array_push($mark, $i);
			}

			$assmnt_id = $this->input->get("assgmnt_ID");
			$semselect = $this->input->get("semesterP");
			$cmID = $this->input->get("ksmid2");
			$kelas = $this->input->get("slct_kelas");
			
			$data['senaraipelajar'] = $this->m_pelajar->student_by_assmnt($cmID, $assmnt_id, $semselect, $kelas);					
			
			$data['subjekconfigur'] = $this->m_subject->subject_configuratian_assgmnt($assmnt_id);
			
			$aJson= array("pelajar" => $data['senaraipelajar'], "subjek" => $data['subjekconfigur']);			

			$index = sizeof($data['senaraipelajar']);

			//load our new PHPExcel library
			$this->load->library('excel');
				
			//activate worksheet number 1
			$this->excel->setActiveSheetIndex(0);
				
			
			//name the worksheet
			$this->excel->getActiveSheet()->setTitle("Pemarkahan mengikut semester dan modul");

			$highlightCells = array();
		
			//header
			$excel_header = array('BIL','NAMA','ANGKA GILIRAN');
			$excel_assignment = array();

			$totalAssignment = $data['subjekconfigur']->assgmnt_total;

			foreach ($data['subjekconfigur'] as $rsCol => $rsVal) {

				if($rsCol == 'assgmnt_name' && $rsVal != ""){
					for($indexAssign = 0; $indexAssign < $totalAssignment; $indexAssign++){
						$assgmnt_header_name = strtoupper($rsVal);
						if(sizeof($totalAssignment > 1)){
							$assgmnt_header_name = strtoupper($rsVal)." ".($indexAssign+1);
						}
							array_push($excel_header, $assgmnt_header_name);
					}
						$assgmnt_name = strtoupper($rsVal);
				}
				if($rsCol == 'assgmnt_id' && $rsVal != ""){
					for($indexAssign = 0; $indexAssign < $totalAssignment; $indexAssign++){
						array_push($excel_assignment, strtoupper($rsVal));
					}
				}
			}

			$filename='Markah_pelajar_sem_'.$semselect.'_modul_'.$assgmnt_name.'.xls'; //save our workbook as this file name

			//load the header into position A1
			$this->excel->getActiveSheet()->fromArray( $excel_header, NULL, 'A1' );		
			
			$ttl = 0;
			$columnCount = 65;
			
			//masukkkan markah disini
			$index = 1;
			$excel_data = array();
				$j = 0;
			foreach($data['senaraipelajar'] as $rowData)
			{
				$r = array();
				array_push($r, $index);
				foreach($rowData as $rsCol => $rsVal)  //loop each column and push inside array
				{

					switch($rsCol){
						case "stu_name" :
							array_push($r, " ".strval(name_strtoupper($rsVal)));
						break;
						case "stu_matric_no" :
							array_push($r, " ".strval(name_strtoupper($rsVal)));
						break;
						case "marks" :
$j++;
							for($i = 0; $i < sizeof($rsVal); $i++){
								
								$rsA = $rsVal[$i];
								$bData = false;
								if(isset($rsA['data'])){
										$rsAD = $rsA['data'];
										$bData = true;
										if($excel_assignment[$i] == $rsAD->assgmnt_id){
										if($rsAD->mark != "")
											{												
												//echo "nilai ada: $j $i |";
												if($rsAD->mark != -99.99)
												{
													array_push($r, $rsAD->mark);
												}
												else 
												{
													array_push($r, 'T');
												}
											}	
																				
											else
											{												
												array_push($r, 1);
											}
										}
									
								}
								if(!($bData)){
									array_push($r, 1);
									//echo "nilai : $j $i |";
								}		
							}
							//echo "<br>";
						break;
					}
				}

				array_push($excel_data, $r);
			
				$index++;
			}

			//print_r($excel_data);


			//load the data into position C4
			$this->excel->getActiveSheet()->fromArray( $excel_data, NULL, 'A2' );
			
			//border fill color for header
			$style_header = array( 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
								   				   'color' => array('rgb'=>'FFC000')),
								   'font' => array('bold' => true)
								 );

			$this->excel->getActiveSheet()->getStyle('A1:'.$abc[(sizeof($excel_header)-1)].'1')->applyFromArray( $style_header ); //apply the border fill
		 
			//style to set border
			$borderStyleArray = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
			        									  'inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
			    					  					)
									 );
		
			$this->excel->getActiveSheet()->getStyle('A1:'.$abc[(sizeof($excel_header)-1)].($index))->applyFromArray($borderStyleArray);
			
			//ni untuk on filter
			//$this->excel->getActiveSheet()->setAutoFilter('A1:'.$abc[(sizeof($excel_header)-1)].($index)); 

			//$this->excel->getActiveSheet()->getCell('A1:'.$abc[(sizeof($excel_header)-1)].'1')->setAutoSize( true ); //apply the border fill
		 	
			$this->excel->getActiveSheet()->getStyle('D2:D'.($index))->
				getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
			
			//set auto resize for all the columns
			for ($col=0; $col<=(sizeof($excel_header)-1); $col++) 
			{
				$this->excel->getActiveSheet()->getColumnDimension($abc[$col])->setAutoSize(true);
			}

			$blocksList = implode (", ", $mark);

			$objValidation = $this->excel->getActiveSheet()->getCell('D2')->getDataValidation();
			/*$objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_DECIMAL);
    		$objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
    		$objValidation->setOperator( PHPExcel_Cell_DataValidation::OPERATOR_LESSTHANOREQUAL);
			$objValidation->setAllowBlank(true);
			$objValidation->setShowInputMessage(true);
			$objValidation->setShowErrorMessage(true);
			$objValidation->setErrorTitle('Input error');
			$objValidation->setError('Only Number is permitted!');
			$objValidation->setPromptTitle('Allowed input');
			$objValidation->setPrompt('Only numbers between 1.0 and 100.0 are allowed.');
			$objValidation->setFormula1(1.0);
			$objValidation->setFormula2(100.0);*/



			$this->excel->getActiveSheet()->removeColumn($abc[(sizeof($excel_header)+1)],1);
			$this->excel->getActiveSheet()->removeColumn($abc[(sizeof($excel_header)+2)],1);
			
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
			header('Cache-Control: max-age=0'); //no cache
			
			//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension)
			//if you want to save it as .XLSX Excel 2007 format
			$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
			//force user to download the Excel file without writing it to server's HD
			$objWriter->save('php://output');
		}
		
		
		/******************************************************************************************
		 * Description		: eksport excell
		* input				: -
		* author			: umairah
		* Date				: 22/3/2014
		* Modification Log	: -
		******************************************************************************************/
		
		//untuk eksport excell markah murid secara keseluruhan
		function export_xls_markahStudent_keseluruhan(){
		
			$abc = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
					'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
					'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ',
					'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY', 'CZ',
					'DA', 'DB', 'DC', 'DD', 'DE', 'DF','DG','DH', 'DI', 'DJ', 'DK', 'DL');
		
			$mark = array();
		
			for($i = 0; $i <=100; $i++){
				array_push($mark, $i);
			}
		
			$user = $this->ion_auth->user()->row();
			$userid = $user->id;
				
			$year = $this->session->userdata["tahun"];
				
			$cmID = $this->input->get("ksmid3");
				
			$courselect = $this->input->get("kursusid3");
			$subselect = $this->input->get("subjectid3");
			$semselect = $this->input->get("semesterP3");
			$pentaksiran = $this->input->get("pentaksiran3");
				
			$tempcategory = $this->input->get("tempKAt");
		
			$kelas = $this->input->get("kelas3");
				
			$mod_id = explode(":", $subselect);
			/*echo $kelas;
			 echo "<br>";
			echo $tempcategory;
			echo "<br>";
			echo $pentaksiran;
			echo "<br>";
			echo $semselect;
			echo "<br>";
			echo $subselect;
			echo "<br>";
			echo $courselect;
			echo "<br>";
			echo $cmID;
			echo "</pre>";*/
				
			$data['nama_kelas'] = $this->m_subject->ambik_nama_kelas($kelas);
			$data['nama_kursus'] = $this->m_subject->ambik_nama_kursus($courselect);
			$data['nama_modul'] = $this->m_subject->ambik_nama_modul($mod_id[0]);
				
			$data['subjekconfigur'] = $this->m_subject->subject_configuratian($pentaksiran, $cmID, $tempcategory, $kelas);
			//echo "<pre>";
			//print_r($data['subjekconfigur']);
			//echo "</pre>";
			//die();
			$data['idParent'] = $this->m_subject->getIdParent($userid, $cmID);
				
			$pelajar = $this->m_pelajar->student_marking($cmID, $semselect, $kelas);
			//echo "<pre>";
			//print_r($data['subjekconfigur']);
			//echo "</pre>";
			//print_r($pelajar)
				
			$data['senaraipelajar'] = $pelajar;
		
			$data['kursus'] = $this->m_kursus->login_course($userid, $year);
			$data['kursusID'] = $courselect;
			$data['subjek'] = $this->m_subject->subject_by_spid($courselect, $semselect);
		
			$data['subjectID'] = $subselect;
			$data['semesterP'] = $semselect;
			$data['assessType'] = $tempcategory;
			$data['kelasID'] = $kelas;
			$data['kelas'] = $this->m_subject->get_classes($courselect, $semselect, $cmID);
				
				
			$index = sizeof($data['senaraipelajar']);
				
		
			//load our new PHPExcel library
			$this->load->library('excel');
		
			//activate worksheet number 1
			$this->excel->setActiveSheetIndex(0);
		
		
			//name the worksheet
			$this->excel->getActiveSheet()->setTitle("Pemarkahan mengikut semester, kelas dan modul");
		
			//$highlightCells = array();
				
			//header
			$excel_header = array('BIL','NAMA','ANGKA GILIRAN');
				
			$excel_assignment = array();
			//ini
			//	$totalAssignment = $data['subjekconfigur'][0]->assgmnt_total;
		
			foreach ($data['subjekconfigur']as $rsCol) {
				//echo "<pre>";
				//print_r($rsCol);
				//echo "</pre>";
				foreach($rsCol as $rsHeader => $rsVal){
						
					if($rsHeader == 'assgmnt_name' && $rsVal != ""){
						$assgmnt_header_name = strtoupper($rsVal);
						//echo $assgmnt_header_name;
						array_push($excel_header, $assgmnt_header_name);
		
						$assgmnt_name = strtoupper($rsVal);
					}
						
					if($rsHeader == 'assgmnt_id' && $rsVal != ""){
							
						array_push($excel_assignment,$rsVal);
		
					}
				}
					
					
			}
		
			array_push($excel_header, "JUMLAH");
				
			$filename='Markah_pelajar_sem_'.$semselect.'_kelas_'.$data['nama_kelas']->class_name.'.xls'; //save our workbook as this file name
		
			//load the header into position A1
			$this->excel->getActiveSheet()->fromArray( $excel_header, NULL, 'A7' );
			//	die();
			$ttl = 0;
			$columnCount = 65;
		
			//masukkkan markah disini
			$index = 1;
			$excel_data = array();
			$j = 0;
		
			if(isset($pelajar) && isset($data['subjekconfigur']))
			{
		
				//array_push($r, $index);
		
				foreach($pelajar as $p)
				{
					$aMarkah = array();
					$indexMarks = 1;
					$total = 0;
		
					$r = array();
					array_push($r,$index);
					array_push($r,$p->stu_name);
					array_push($r,$p->stu_matric_no);
		
		
					foreach($data['subjekconfigur'] as $sbc)
					{
						$m = $this->m_subject->getStudentMarkForAssignment($p->stu_id, $sbc->assgmnt_id,
								$sbc->assgmnt_score_selection, $sbc->assgmnt_mark);
		
						if($m != "T")
						{
							$cMark = ceil($m);
							$total +=$cMark;
						}
						else
						{
								
							$cMark = $m;
							$total +=$cMark;
								
						}
		
						/*if($m == -100)
						 {
						$cMark = "T";
						$total +=$cMark;
						}*/
		
						//$indexJum = "markah"+$indexMarks;
						array_push($aMarkah, $cMark);
						$r[] = $cMark;
						//	$p++;
						$indexMarks++;
					}
						
					//$senaraiPelajar = get_object_vars($r);
					$r[] = $total;
					array_push($excel_data, $r);
					$index++;
		
						
				}
					
					
					
			}
		
			//echo "<pre>";
			//print_r($excel_data);
			//echo "</pre>";
			//die();
		
			//load the data into position C4
			$this->excel->getActiveSheet()->fromArray( $excel_data, NULL, 'A8' );
				
			//set the informations
			$this->excel->getActiveSheet()->setCellValue('A1', 'Markah Pentaksiran Berterusan Pelajar');
			$this->excel->getActiveSheet()->mergeCells('A1:Z1');
			$this->excel->getActiveSheet()->setCellValue('A2', 'Kursus    :    '.$data['nama_kursus']->cou_name);
			$this->excel->getActiveSheet()->mergeCells('A2:Z2');
			$this->excel->getActiveSheet()->setCellValue('A3', 'Semester     :   '.$semselect);
			$this->excel->getActiveSheet()->mergeCells('A3:Z3');
			$this->excel->getActiveSheet()->setCellValue('A4', 'Modul/Mata Pelajaran      :     '.$data['nama_modul']->mod_name);
			$this->excel->getActiveSheet()->mergeCells('A4:Z4');
			$this->excel->getActiveSheet()->setCellValue('A5', 'Kelas   :   '.$data['nama_kelas']->class_name);
			$this->excel->getActiveSheet()->mergeCells('A5:Z5');
				
				
			//style for the above information
			$styleArray = array(
					'font' => array('bold' => true),
					'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
			);
			$this->excel->getActiveSheet()->getStyle('A1:A7')->applyFromArray($styleArray); //apply thee style to the cells
				
				
		
			//border fill color for header
			$style_header = array(
					'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb'=>'FFC000')),
					'font' => array('bold' => true)
			);
		
			$this->excel->getActiveSheet()->getStyle('A7:'.$abc[(sizeof($excel_header)-1)].'7')->applyFromArray($style_header); //apply the border fill
		
			//style to set border
			$borderStyleArray = array(
					'borders' => array(
							'outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
							'inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
					)
			);
		
			$this->excel->getActiveSheet()->getStyle('A7:'.$abc[(sizeof($excel_header)-1)].(6+$index))->applyFromArray($borderStyleArray);
		
			//style for data even row, we will set color for even rows of data
			$style_even_row = array(
					'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb'=>'FDE9D9'))
			);
			for($i=2; $i<$index; $i++)
			{
			if($i%2==0)
			{
			$this->excel->getActiveSheet()->getStyle('A'.($i+6).':'.$abc[(sizeof($excel_header)-1)].(6+$i))->applyFromArray($style_even_row);
			}
			}
				
			//ni untuk on filter
			//$this->excel->getActiveSheet()->setAutoFilter('A1:'.$abc[(sizeof($excel_header)-1)].($index));
		
			//$this->excel->getActiveSheet()->getCell('A1:'.$abc[(sizeof($excel_header)-1)].'1')->setAutoSize( true ); //apply the border fill
		
			//$this->excel->getActiveSheet()->getStyle(''.($index))->
			//getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
		
			//set auto resize for all the columns
			for ($col=0; $col<=(sizeof($excel_header)-1); $col++)
			{
			$this->excel->getActiveSheet()->getColumnDimension($abc[$col])->setAutoSize(true);
			}
		
			$blocksList = implode (", ", $mark);
		
			$objValidation = $this->excel->getActiveSheet()->getCell('K1')->getDataValidation();
			/*$objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_DECIMAL);
			$objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
			$objValidation->setOperator( PHPExcel_Cell_DataValidation::OPERATOR_LESSTHANOREQUAL);
			$objValidation->setAllowBlank(true);
			$objValidation->setShowInputMessage(true);
			$objValidation->setShowErrorMessage(true);
			$objValidation->setErrorTitle('Input error');
			$objValidation->setError('Only Number is permitted!');
			$objValidation->setPromptTitle('Allowed input');
			$objValidation->setPrompt('Only numbers between 1.0 and 100.0 are allowed.');
			$objValidation->setFormula1(1.0);
			$objValidation->setFormula2(100.0);*/
		
		
		
			$this->excel->getActiveSheet()->removeColumn($abc[(sizeof($excel_header)+1)],1);
			$this->excel->getActiveSheet()->removeColumn($abc[(sizeof($excel_header)+2)],1);
		
			header('Content-Type: application/vnd.ms-excel'); //mime type
			header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
					header('Cache-Control: max-age=0'); //no cache
		
							//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension)
							//if you want to save it as .XLSX Excel 2007 format
							$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
							//force user to download the Excel file without writing it to server's HD
							$objWriter->save('php://output');
		}
		
		
		/******************************************************************************************
		* Description		: this function is to save status competent
		* input				: -
		* author			: Freddy Ajang Tony
		* Date				: 16 April 2014
		* Modification Log	: -
		******************************************************************************************/
		function save_status_competent()
		{			
			$post_values = $this->input->post();
			$mark_list = array();
			$pentaksiran = $this->input->post("pentaksiran");
			$cmid = $this->input->post("cmid");
			$semester = $this->input->post("sem");
			$tempcategory = $this->input->post("cat");
			$kelas = $this->input->post("kelas4");

			
			
			if(isset($post_values))	
			{
				$aMarkah = array();
				
				foreach($post_values as $key => $value)
				{
					$pos = strrpos($key, "_");

					if ($pos === false)
					{ 
					    // not found...
					}
					else
				    {
				    	$md_id = explode('_', $key);

						$data = array(
							'marks_assess_type' => $tempcategory,
							'mark_category' => $md_id[1],
							'md_id' => $md_id[2],
							'status_competent' => $value
						);						
						
						array_push($aMarkah, $data);
					}				
				}

				//FDP
				//echo "<pre>";
				//print_r($aMarkah);
				//echo "</pre>";
				//die();
				$this->m_subject->save_marks($aMarkah);
			}
		}
		
		
	}// end of Class
/**************************************************************************************************
* End of markings.php
**************************************************************************************************/
?>