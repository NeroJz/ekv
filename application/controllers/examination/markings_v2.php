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

	class Markings_v2 extends MY_Controller 
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
	        $output['output'] = $this->load->view('marking/v_evaluation_form_sekolah_v2', $data, true);
			$this->load->view('main.php', $output);
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
			
			$output['output'] = $this->load->view('marking/v_evaluation_form_sekolah_v2', $data, true);
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
		* Description		: this function get subject configuration detail
		* input				: -
		* author			: Norafiq Azman
		* Date				: 3 July 2013
		* Modification Log	: -
		******************************************************************************************/
		function save_configurations()
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
			
			$teori_id = $this->input->post("theory_id");
			$teori_name = $this->input->post("theory_name");
			$teori_peratusan = $this->input->post("percentage");
			
			$la = $this->m_subject->get_laID($cmID);
			
			$configuration = $this->m_subject->subject_configuratian($pentaksiran, $cmID, $tempcategory);
			/*print_r($teori_id);
			print_r($teori_name);
			print_r($teori_peratusan);
			die();*/
				
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
					
					$assgmnt_id = $this->m_subject->save_configur_subject($dataconfigur);
					
					if($tempcategory == 'VK')
					{
						foreach($teori_id as $index => $value)
						{
							$data_subTheory = array(
								'th_sub_name' => $teori_name[$index] ,
								'th_percentage' => $teori_peratusan[$index],
								'assigmnt_id' => $assgmnt_id
							);
							
							$this->m_subject->save_sub_theory($data_subTheory);
							
						}
					}
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
					
					if($tempcategory == 'VK')
					{
						foreach($teori_id as $index => $value)
						{
							$data_subTheory = array(
								'th_sub_name' => $teori_name[$index] ,
								'th_percentage' => $teori_peratusan[$index],
								'assigmnt_id' => $tgsid
							);
							
							
							if(0 == $value)
							{
								$this->m_subject->save_sub_theory($data_subTheory);
							}
							else {
								$this->m_subject->update_sub_theory($data_subTheory,$value);
							}
							
							
						}
					}
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
			
			$data['subjekconfigur'] = $this->m_subject->subject_configuratian($pentaksiran, $cmID, $tempcategory);
			
			//check tarikh buka utk teori dan amali
			//$amaliOpen = $this->m_subject->isMarkingOpen("SA", $semselect);
			//$teoriOpen = $this->m_subject->isMarkingOpen("ST", $semselect);
			//$academikOpen = $this->m_subject->isMarkingOpen("SAK", $semselect);
			
			//$data['academikOpen'] = $academikOpen;
			//$data['amaliOpen'] = $amaliOpen;
			//$data['teoriOpen'] = $teoriOpen;
			
			$pelajar = $this->m_pelajar->student_marking($cmID, $semselect);
			
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
			
			//echo('<pre>');print_r($data);echo('</pre>');
			//die();		

			$data['kursus'] = $this->m_kursus->login_course($userid, $year);
			$data['kursusID'] = $courselect;
			$data['subjek'] = $this->m_subject->subject_by_spid($courselect, $semselect);
						
			$data['subjectID'] = $subselect;
			$data['semesterP'] = $semselect;
			$data['assessType'] = $tempcategory;
			
			$output['output'] = $this->load->view('marking/v_evaluation_form_sekolah_v2', $data, true);
			$this->load->view('main.php', $output);
		}
		
		/******************************************************************************************
		* Description		: this function to load form loadstudent
		* input				: -
		* author			: Norafiq Azman
		* Date				: 3 July 2013
		* Modification Log	: -
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
			
			$tempcategory = $this->input->post("tempKAt");

			$data['subjekconfigur'] = $this->m_subject->subject_configuratian($pentaksiran, $cmID, $tempcategory);
			
			//check tarikh buka utk teori dan amali
			//$amaliOpen = $this->m_subject->isMarkingOpen("SA", $semselect);
			//$teoriOpen = $this->m_subject->isMarkingOpen("ST", $semselect);
			//$academikOpen = $this->m_subject->isMarkingOpen("SAK", $semselect);
			
			//$data['academikOpen'] = $academikOpen;
			//$data['amaliOpen'] = $amaliOpen;
			//$data['teoriOpen'] = $teoriOpen;
			
			
			$pelajar = $this->m_pelajar->student_marking($cmID, $semselect);
			
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
			
			//FDP
			/*echo('<pre>');
			print_r($data);
			echo('</pre>');
			die();*/
			
			$output['output'] = $this->load->view('marking/v_evaluation_form_sekolah_v2', $data, true);
			$this->load->view('main.php', $output);
		}
		
		/******************************************************************************************
		* Description		: this function is json responder to get subject detail
		* input				: -
		* author			: Norafiq Azman
		* Date				: 3 July 2013
		* Modification Log	: -
		******************************************************************************************/
		function get_swb()
		{
			$cm_id 		 = $this->input->post("cmID");
			$pentaksiran = $this->input->post("pntksrn");		
			$type		 = $this->input->post("type");
			
			$data['weightage'] 		= $this->m_subject->subject_weightage($pentaksiran, $cm_id);
			$data['configuration']  = $this->m_subject->subject_configuratian($pentaksiran, $cm_id, $type);
			
			$aJson= array("weightage" => $data['weightage'], "configuration" => $data['configuration']);
			echo(json_encode($aJson));
		}
		
		/******************************************************************************************
		* Description		: this function call to select assignment detail
		* 					  nak popup modal yang ada assignment number
		* input				: -
		* author			: Norafiq Azman
		* Date				: 3 July 2013
		* Modification Log	: -
		******************************************************************************************/
		function get_assignment()
		{
			$assmnt_id = $this->input->post("assgmnt_ID");
			$semselect = $this->input->post("semesterP");
			$cmID = $this->input->post("ksmid2");
			
			$data['senaraipelajar'] = $this->m_pelajar->student_by_assmnt($cmID, $assmnt_id, $semselect);			
			
			//echo "<pre>";
			//print_r ("assID:".$assmnt_id);				//FDP
			//print_r ("sems:".$semselect);
			//print_r ("cmid:".$cmID);
			//print_r ($data['senaraipelajar']);
			//echo "</pre>";
			//die();
			
			
			$data['subjekconfigur'] = $this->m_subject->subject_configuratian_assgmnt($assmnt_id);
			
			//echo('<pre>');//FDP
			//print_r ($data['subjekconfigur']);
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
		* Modification Log	: -
		******************************************************************************************/
		function save_assignment()
		{			
			$post_values = $this->input->post();
			$mark_list = array();
			$pentaksiran = $this->input->post("pentaksiran");
			$cmid = $this->input->post("cmid");
			$semester = $this->input->post("sem");
			$tempcategory = $this->input->post("cat");

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
			$subjekconfigur = $this->m_subject->subject_configuratian($pentaksiran, $cmid, $tempcategory);
			
			$pelajar = $this->m_pelajar->student_marking($cmid, $semester);
			
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
		* Modification Log	: -
		******************************************************************************************/
		function get_ak_swb()
		{
			$cm_id 		 = $this->input->post("cmID");
			$pentaksiran = $this->input->post("pntksrn");
			$type		 = $this->input->post("type");
			
			$data['weightage'] =  $this->m_subject->get_all_paper($cm_id, $pentaksiran ,$type);
			$data['configuration'] = $this->m_subject->subject_configuratian($pentaksiran, $cm_id, $type);
			
			$aJson= array("weightage" => $data['weightage'], "configuration" => $data['configuration']);
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
		* Description		: this function is json responder to delete theory id
		* input				: -
		* author			: Freddy Ajang Tony
		* Date				: 27 January 2014
		* Modification Log	: -
		******************************************************************************************/
		function theory_assignment_delete()
		{
			$theoryID = $this->input->post("th_id");			
			$data = $this->m_subject->delete_Theory_Assigment($theoryID);
		}
		
	}// end of Class
/**************************************************************************************************
* End of markings.php
**************************************************************************************************/
?>