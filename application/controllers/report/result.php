<?php
/**************************************************************************************************
 * File Name        : Result.php
 * Description      : This File contain Result module.
 * Author           : sukor
 * Date             : 1 july 2013
 * Version          : -
 * Modification Log : -
 * Function List	   : __construct(),
 **************************************************************************************************/
class Result extends MY_Controller {
	
	function __construct() 
	{
		parent::__construct();

		$this->load->model('m_result');
	}


	
/**********************************************************************************************
 * Description		: this function to report roster
 * input			: 
 * author			: sukor
 * Date				: 1 july 2013
 * Modification Log	: -
**********************************************************************************************/
	
	function roster()
	{
		//$data['test'] = 0;
		//$data['centrecode'] = $this->m_result->get_institusi();
		$data['year'] =$this->m_result->list_year_mt();
		//$data['courses'] = $this->m_result->list_course();
        
        
        $user_login = $this->ion_auth->user()->row();
        $centreCode = $user_login->col_id;
        $userId = $user_login->user_id;
        $state_id= $user_login->state_id;
    
          $user_groups = $this->ion_auth->get_users_groups($userId)->row();  
          $ul_type= $user_groups->ul_type;
          
        if($ul_type=="KV"){
            $col=get_user_collegehelp($userId);
            $data['colname']=$col[0]->col_name.'-'.$col[0]->col_type.''.$col[0]->col_code;
        }
            if($ul_type=="JPN"){
            $data['centrecode'] = $this -> m_result -> get_institusi($state_id);
        }else{
            $data['centrecode'] = $this -> m_result -> get_institusi();
        }
        
		
		$data['output'] = $this->load->view('laporan/v_laporan_roster', $data, true);
		$this->load->view('main', $data);
	}
	
	
	
/**********************************************************************************************
 * Description		: this function to print resultroster
 * input			: 
 * author			: sukor
 * Date				: 1 july 2013
 * Modification Log	: -
**********************************************************************************************/
	
	
	function resultRoster()
	{
		$centreCode = $this->input->post('kodpusat');
		$semester = $this->input->post('semester');
		$year = $this->input->post('mt_year');
		$course = $this->input->post('slct_kursus');
		$statusID = $this->input->post('statusID');
		$angkagiliran = $this->input->post('angka_giliran');
		
		$cC = explode("-", $centreCode);
	
		//$data['student'] = $this->m_result->get_result_by_id($cC[0], $semester,$year,$course);
		$data['student'] = $this->m_result->result_student_roster($cC[0], $semester, $year, $course, $statusID, $angkagiliran);
		$data['stat_subj'] = $statusID;
		
		//print_r($data['student']);
		$this->load->view('laporan/v_rosterv2', $data, '');
		//$this->load->view('laporan/v_roster', $data, '');
	}
	
/**********************************************************************************************
 * Description		: this function to report attendance_exam
 * input			: 
 * author			: sukor
 * Date				: 2 july 2013
 * Modification Log	: -
**********************************************************************************************/


	function attendance_exam()
	{
		$user_login = $this->ion_auth->user()->row();
		$centreCode = $user_login->col_id;
		$userId = $user_login->user_id;
		$state_id= $user_login->state_id;

		  $user_groups = $this->ion_auth->get_users_groups($userId)->row();  
		  $ul_type= $user_groups->ul_type;
		  
		if($ul_type=="KV"){
			$col=get_user_collegehelp($userId);
			$data['colname']=$col[0]->col_name.'-'.$centreCode;
		}
			if($ul_type=="JPN"){
			$data['centrecode'] = $this -> m_result -> get_institusi($state_id);
		}else{
			$data['centrecode'] = $this -> m_result -> get_institusi();
		}
		
		$data['courses'] = $this->m_result->list_course();
		$data['year'] =$this->m_result->list_year_mt();
		//print_r($data['centrecode']);
		//die();
		$data['output'] = $this->load->view('laporan/v_attendance_exam', $data, true);
		$this->load->view('main', $data);
	}


/**********************************************************************************************
 * Description		: this function to print attendance_exam
 * input			: 
 * author			: sukor
 * Date				: 2 july 2013
 * Modification Log	: -
**********************************************************************************************/
function attendance_exam_print()
	{
		$centreCode = $this->input->post('kodpusat');
		$semester = $this->input->post('semester');
		$year = $this->input->post('mt_year');
		$course = $this->input->post('slct_kursus');
		 $status = $this -> input -> post('status');
		$cC=explode("-", $centreCode);
		$data['student'] = $this->m_result->get_module_taken($cC[0], $semester,$year,$course,$status,$module="");
	//print_r($data['student'] );
	//die();
		$this->load->view('laporan/v_attendance_exam_print', $data, '');
	}
	
	
	/**********************************************************************************************
 * Description		: this function to report analysis_results
 * input			: 
 * author			: sukor
 * Date				: 4 july 2013
 * Modification Log	: 10 december 2013 - siti umairah
**********************************************************************************************/
	
	function analysis_results()
	{
		$data['module_code'] = $this->m_result->list_module();
		$data['centrecode'] = $this->m_result->get_institusi();
		$data['courses'] = $this->m_result->list_course();
		$data['year'] =$this->m_result->list_year_mt();
		
		$centreCode = $this->input->post('kodpusat');
		$course = $this->input->post('slct_kursus');
		$module = $this->input->post('module');
		$status = $this -> input -> post('status');
		$cC=explode("-", $centreCode);
		//$data['serach'] = $cC."|".$course."|".$module;
			if(!empty($module)){
				$data['student'] = $this->m_result->get_analysis_result($cC[0],$course,$module,$status);
			}
		
		
		$data['output'] = $this->load->view('laporan/v_analysis_results', $data, true);
		$this->load->view('main', $data);
	}
	
	function analysis_results_s()
	{
		$data['module_code'] = $this->m_result->list_module();
		$data['centrecode'] = $this->m_result->get_institusi();
		$data['courses'] = $this->m_result->list_course();
		$data['year'] =$this->m_result->list_year_mt();
	
		$centreCode = $this->input->post('kodpusat');
		$course = $this->input->post('slct_kursus');
		$module = $this->input->post('module');
		$status = $this -> input -> post('status');
		$cC=explode("-", $centreCode);
		//$data['serach'] = $cC."|".$course."|".$module;
			if($module){
		$data['student'] = $this->m_result->get_analysis_result($cC[0],$course,$module,$status);
			}
		$this->load->view('laporan/v_analysis_result_print', $data);
		//$this->load->view($data);
	}

	
	/**********************************************************************************************
 * Description		: this function to report fin
 * input			: 
 * author			: sukor
 * Date				: 4 july 2013
 * Modification Log	: -
**********************************************************************************************/
	
function view_analysis_results($approved) {

		//$course = $this->list_student_fee($course_id);
		$arr_data = $this -> m_result -> get_analysis_results_ajax($approved);

		if (sizeof($arr_data) > 0)
			echo json_encode($arr_data);
	}
	
	/**********************************************************************************************
 * Description		: this function to report fin
 * input			: 
 * author			: sukor
 * Date				: 4 july 2013
 * Modification Log	: -
**********************************************************************************************/
	
function view_analysis() {

		//$course = $this->list_student_fee($course_id);
	
          $arr_data = $this->m_result->get_analysis_resultv2($ppp='',$rp='',$tp='');
         $anlysis = array(
		'ana' => $arr_data
	);

		if (sizeof($arr_data) > 0)
			echo json_encode($arr_data);

	}


/**********************************************************************************************
 * Description		: this function to get anlaysis view
 * input			: 
 * author			: sukor
 * Date				: 8 july 2013
 * Modification Log	: -
**********************************************************************************************/
	function analysis_results_view()
	{
		$data['module'] = $this->m_result->list_module();
		$data['centrecode'] = $this->m_result->get_institusi();
		$data['courses'] = $this->m_result->list_course();
		$data['year'] =$this->m_result->list_year_mt();
		$data['output'] = $this->load->view('laporan/v_analysis_results', $data, true);
		$this->load->view('main', $data);
	}



/**********************************************************************************************
 * Description		: this function to report fin
 * input			: 
 * author			: sukor
 * Date				: 8 july 2013
 * Modification Log	: -
**********************************************************************************************/
	function analysis_result_print()
	{
		
		
		$centreCode = $this->input->post('kodpusat');
		$course = $this->input->post('slct_kursus');
		$module = $this->input->post('module');
		$cC=explode("|", $centreCode);
		$data['student'] = $this->m_result->get_analysis_result($cC[0],$course,$module);
		$data['module'] = $this->m_result->get_analysis_module($cC[0],$course,$module);
		$this->load->view('laporan/v_analysis_result_print', $data);
	}
	
	
	
	
/**********************************************************************************************
 * Description		: this function to get result
 * input			: 
 * author			: sukor
 * Date				: 10 july 2013
 * Modification Log	: -
**********************************************************************************************/	
	function result_student() 
	{
		
		
		$user_login = $this->ion_auth->user()->row();
        $centreCode = $user_login->col_id;
        $userId = $user_login->user_id;
        $state_id= $user_login->state_id;
    
          $user_groups = $this->ion_auth->get_users_groups($userId)->row();  
          $ul_type= $user_groups->ul_type;
          
        if($ul_type=="KV"){
            $col=get_user_collegehelp($userId);
            $data['colname']=$col[0]->col_name.'-'.$col[0]->col_type.''.$col[0]->col_code;
        }
            if($ul_type=="JPN"){
            $data['centrecode'] = $this -> m_result -> get_institusi($state_id);
        }else{
            $data['centrecode'] = $this -> m_result -> get_institusi();
        }
		
		
		$data['year'] =$this->m_result->list_year_mt();
		$data['courses'] = $this->m_result->list_course();
        $data['output'] = $this->load->view('laporan/v_result_student', $data, true);
		$this->load->view('main', $data);
		
	}
/**********************************************************************************************
 * Description		: this function to print result
 * input			: 
 * author			: sukor
 * Date				: 10 july 2013
 * Modification Log	: -
**********************************************************************************************/	
	function print_result_student()
	{
		$this->load->library('ciqrcode');
		$this->load->library('encryption');
		
		$codeCenter= $this->input->post('kodpusat');
		$course = $this->input->post('slct_kursus');
		$year = $this->input->post('mt_year');
		$semester = $this->input->post('semester');
		$student = $this->input->post('angka_giliran');	
		$status = $this->input->post('status');	
		$data['status'] =$status;
		$cC=explode("-", $codeCenter);
		if(!empty($student) || !empty($status)){
			if($status==1){
				$data['result'] = $this->m_result->student_result($cC[0],$course,$year,$semester,$student,$status);
				
				$this->load->view('laporan/v_cetak_result', $data);
			}else{
				$data['result'] = $this->m_result->student_result_repeat($cC[0],$course,$year,$semester,$student,$status);
			$this->load->view('laporan/v_cetak_result_repeat', $data);
			}
	
			
		}else{
			redirect('report/result/result_student');
		}

			
		
	}
	
	
/**********************************************************************************************
 * Description		: this function to report fin
 * input			: 
 * author			: sukor
 * Date				: 22 july 2013
 * Modification Log	: -
**********************************************************************************************/	
	function transkrip() 
	{

			
             $user_login = $this->ion_auth->user()->row();
        $centreCode = $user_login->col_id;
        $userId = $user_login->user_id;
        $state_id= $user_login->state_id;
    
          $user_groups = $this->ion_auth->get_users_groups($userId)->row();  
          $ul_type= $user_groups->ul_type;
          
        if($ul_type=="KV"){
            $col=get_user_collegehelp($userId);
            $data['colname']=$col[0]->col_name.'-'.$col[0]->col_type.''.$col[0]->col_code;
        }
            if($ul_type=="JPN"){
            $data['centrecode'] = $this -> m_result -> get_institusi($state_id);
        }else{
            $data['centrecode'] = $this -> m_result -> get_institusi();
        }
            
	//	$data['centrecode'] = $this -> m_result -> get_institusi();
		$data['year'] =$this->m_result->list_intake();
	//	$data['courses'] = $this->m_result->list_course();
        $data['output'] = $this->load->view('laporan/v_transkrip', $data, true);
		$this->load->view('main', $data);
		
	}

/**********************************************************************************************
 * Description		: this function to report fin
 * input			: 
 * author			: sukor
 * Date				: 22 july 2013
 * Modification Log	: -
**********************************************************************************************/
function print_transkrip()
{
	$codeCenter= $this->input->post('kodpusat');
	$course = $this->input->post('slct_kursus');
	$year = $this->input->post('mt_year');
	//$semester = $this->input->post('semester');
	$student = $this->input->post('angka_giliran');	
		
	$cC=explode("-", $codeCenter);
	
	$data['resultS'] = $this->m_result->get_transkrip($cC[0],$course,$year,$student);

	$this->load->view('laporan/v_print_transkrip', $data);
}

/**********************************************************************************************
 * Description		: this function to report attendance_exam
 * input			: 
 * author			: sukor
 * Date				: 2 july 2013
 * Modification Log	: -
**********************************************************************************************/


	function attendance_exam_check()
	{
			$user_login = $this->ion_auth->user()->row();
		$centreCode = $user_login->col_id;
		$userId = $user_login->user_id;
		$state_id= $user_login->state_id;

		  $user_groups = $this->ion_auth->get_users_groups($userId)->row();  
		  $ul_type= $user_groups->ul_type;
		  
		if($ul_type=="KV"){
			$col=get_user_collegehelp($userId);
			$data['colname']=$col[0]->col_name.'-'.$centreCode;
		}
			if($ul_type=="JPN"){
			$data['centrecode'] = $this -> m_result -> get_institusi($state_id);
		}else{
			$data['centrecode'] = $this -> m_result -> get_institusi();
		}
		
		$data['courses'] = $this->m_result->list_course();
		$data['year'] =$this->m_result->list_year_mt();
		//print_r($data['centrecode']);
		//die();
		$data['output'] = $this->load->view('laporan/v_attendance_exam_check', $data, true);
		$this->load->view('main', $data);
	}


/**********************************************************************************************
 * Description		: this function to print attendance_exam
 * input			: 
 * author			: sukor
 * Date				: 2 july 2013
 * Modification Log	: -
**********************************************************************************************/
function attendance_exam_print_check()
	{
		$centreCode = $this->input->post('kodpusat');
		$semester = $this->input->post('semester');
		$year = $this->input->post('mt_year');
		$course = $this->input->post('slct_kursus');
		 $status = $this -> input -> post('status');
		$cC=explode("-", $centreCode);
		$data['student'] = $this->m_result->get_module_taken($cC[0], $semester,$year,$course,$status,$module="");
	//print_r($data['student'] );
	//die();
		$this->load->view('laporan/v_attendance_exam_print_check', $data, '');
	}



function attendance_ok()
	{
       /*$data['test']='test';
		$data['output'] = $this->load->view('laporan/v_attendance_ok', $data, true);
		$this->load->view('main', $data);*/
	}	

function re_calculate_png()
	{
       $sem = 2;
	   $resulttudent=$this->m_result->get_result_by_sem($sem);
	   foreach($resulttudent as $row)
	   {
	   		if($semester_count == $sem)
			{
				$resulttudent=$this->m_result->get_result_by_sem($sem);
			}
	   }
	   
	}
    
        
    /**********************************************************************************************
 * Description      : this function to report analysis_results_vk
 * input            : 
 * author           : sukor
 * Date             : 9 januari 2014
 * Modification Log : 
**********************************************************************************************/
    
    function analysis_results_vk()
    {
       // $data['module_code'] = $this->m_result->list_module();
        $data['centrecode'] = $this->m_result->get_institusi();
        $data['courses'] = $this->m_result->list_course();
        $data['year'] =$this->m_result->list_year_mt();
        
        $centreCode = $this->input->post('kodpusat');
        $course = $this->input->post('slct_kursus');
        $module = $this->input->post('module');
        $status = $this -> input -> post('status');
        $cC=explode("-", $centreCode);
     
        
        $data['output'] = $this->load->view('laporan/v_analysis_results_vk', $data, true);
        $this->load->view('main', $data);
    }
    
    function analysis_results_print_vk()
    {
        
        $centreCode = $this->input->post('kodpusat');
        $course = $this->input->post('slct_kursus');
      //  $module = $this->input->post('module');
        $status = $this -> input -> post('status');
        $cC=explode("-", $centreCode);
        //$data['serach'] = $cC."|".$course."|".$module;
            if($course){
        $data['student'] = $this->m_result->get_analysis_result_vk2($cC[0],$course,$status);
            }

        $this->load->view('laporan/v_analysis_result_print_vk', $data);
        //$this->load->view($data);
    }
    
   
   
   
   
   /**********************************************************************************************
 * Description      : this function to get result
 * input            : 
 * author           : sukor
 * Date             : 10 july 2013
 * Modification Log : -
**********************************************************************************************/ 
    function calculate_result_student() 
    {
        
       
        $user_login = $this->ion_auth->user()->row();
        $centreCode = $user_login->col_id;
        $userId = $user_login->user_id;
        $state_id= $user_login->state_id;
    
          $user_groups = $this->ion_auth->get_users_groups($userId)->row();  
          $ul_type= $user_groups->ul_type;
          
        if($ul_type=="KV"){
            $col=get_user_collegehelp($userId);
            $data['colname']=$col[0]->col_name.'-'.$col[0]->col_type.''.$col[0]->col_code;
        }
            if($ul_type=="JPN"){
            $data['centrecode'] = $this -> m_result -> get_institusi($state_id);
        }else{
            $data['centrecode'] = $this -> m_result -> get_institusi();
        }
        
        
        $data['year'] =$this->m_result->list_year_mt();
        $data['courses'] = $this->m_result->list_course();
        
        
        if(isset($_POST['btn_papar_kira'])){
            
             $var=array();
 
        
        $codeCenter= $this->input->post('kodpusat');
        $course = $this->input->post('slct_kursus');
        $year = $this->input->post('mt_year');
        $semester = $this->input->post('semester');
        $student = $this->input->post('angka_giliran'); 
        //$status = $this->input->post('status'); 
       // $data['status'] =$status;
       
        $cC=explode("-", $codeCenter);
        if(!empty($student) || !empty($semester)|| !empty($year)){
            
            $dataresult = $this->m_result->student_result($cC[0],$course,$year,$semester,$student,$status='');

    }
		
   foreach ( $dataresult as  $value) {     
        
     
     
     
           $gred=explode(',',$value->greds);
             $subjek=explode(',',$value->subjek);
              $kod_subjek=explode(',',$value->kod_subjek);
              $kredit=explode(',',$value->kredit);
             $nilaigred=explode(',',$value->nilaigred);
             $level_gred=explode(',',$value->level_gred);
             $aStudentId=explode(',',$value->student_id);
			 $examStatus=explode(',',$value->examstatus);
			 $modType=explode(',',$value->modtype);
			 
             
             $aNilaiMata = array();
             $aNilaiMataKv = array();
             $aJumJamKv = array();
             $aJumJam = array();
             //akademik
              $aNilaiMataKa = array();
             $aJumJamKa = array();
			 $aMataKvall= array();
              $aMataKaall= array();
			  $aNilaiMataKeselurahan= array();
			  $kreditolak= array();
			  $kreditolakVK=array();
			  $kreditolakAK=array();
             $studentId = '';
              
                    foreach ($kod_subjek as $key => $row) {
                        
						//if($examStatus[$key]!=2){
						
                $gd_id=($gred[$key]=="0"?'-':$gred[$key]);  
                $ng=($nilaigred[$key]=="0"?'-':$nilaigred[$key]);   
                $lvgd=($level_gred[$key]=="0"?'-':$level_gred[$key]);   
                
                $studentId = $aStudentId[$key];
                
                $nilaMata=$kredit[$key]*$ng;
                //tambah nilai mata
                if($examStatus[$key]!=2){
                
                $aNilaiMata[] = $nilaMata;
                $aJumJam[] = $kredit[$key];
				
				 $aNilaiMataKeselurahan[] = $nilaMata;
				
				
                
                if($modType[$key] == 'VK')
                {
                    $aNilaiMataKv[] = $nilaMata;
                    $aJumJamKv[] = $kredit[$key];
					 $aMataKvall[]= $nilaMata;
                }else{
                    
                    $aNilaiMataKa[] = $nilaMata;
                    $aJumJamKa[] = $kredit[$key];
					 $aMataKaall[] = $nilaMata;
                }
				
				
				
                
				}else{
			
		        $subPast= $this->m_result->get_repeat_subject_past($studentId,$row);
				
					if( $nilaigred[$key] > $subPast[0]->grade_value){
							
						$nilaMata_old=$subPast[0]->mod_credit_hour*$subPast[0]->grade_value;
						
						 $aNilaiMataKeselurahan[] = $nilaMata-$nilaMata_old;
						 $kreditolak[]=-$subPast[0]->mod_credit_hour;
						 
			  if($modType[$key] == 'VK')
                {
                	
                    $aMataKvall[] = $nilaMata-$nilaMata_old;
					 $kreditolakVK[]=-$subPast[0]->mod_credit_hour;
                    
                }else{
                    
                    $aMataKaall[] = $nilaMata-$nilaMata_old;
					 $kreditolakAK[]=-$subPast[0]->mod_credit_hour;
                 
                }
				
	
					}	
				}
   
      } 
     
 
    $pevsem=$value->mt_semester-1;
   
    $curResult = $this->m_result->resultBySemYearStudent($value->mt_semester, $value->mt_year, $studentId);
    $Resultsem = $this->m_result->resultBySemYearStudent($pevsem, $year='',$studentId);
   // $Resultsem = $this->m_result->get_kredit($studentId);
  

    
    $stuId = $value->stu_id;
	
//print_r($kreditolak);
 
      //  if($status!=2){
      	//untuk semasa 
        $jumMata = array_sum($aNilaiMata);
        $jumJam = array_sum($aJumJam);
		
		//utk kesluruhan
		$jumMatarepeat= array_sum($aNilaiMataKeselurahan);
        
        $curGpa = sprintf("%.2f",$jumMata/$jumJam);
        
		//untuk kesluruhan
		$jumMataKvtotal=array_sum($aMataKvall);
		//untuk semasa
        $jumMataKv = array_sum($aNilaiMataKv);
        $jumJamKv = array_sum($aJumJamKv);
        
        $curGpaKv = sprintf("%.2f",$jumMataKv/$jumJamKv);
        
        //akdemik
        //unruk all
        
        $jumMataKatotal = array_sum($aMataKaall);
        //untuk semasa
        $jumMataKa = array_sum($aNilaiMataKa);
        $jumJamKa = array_sum($aJumJamKa);
        
        
        
        $curGpaKaa = sprintf("%.2f",$jumMataKa/$jumJamKa);
        
        $pngv = $curGpaKv;
        $pngkv = $curGpaKv;
        $pngk = $curGpa;
        $pngkk = $curGpa;
        $pnga = $curGpaKaa;
        $pngka = $curGpaKaa;
         $pointavk =$jumMataKv;
         $pointaak = $jumMataKa;
         $pointav = $jumMata;
        
        if(!empty($Resultsem)){
           
            
        $pointer_ak = $Resultsem[0]->pointer_ak;
        $pointer_vk = $Resultsem[0]->pointer_vk;
        $pointer_value = $Resultsem[0]->pointer_value;
       
       $pointavk =$jumMataKvtotal+$pointer_vk;
       $pointaak = $jumMataKatotal+$pointer_ak;
       $pointav = $jumMatarepeat+$pointer_value;
       
      // kredit all termasuk mengulan
        $kredit_ak= $this->m_result->get_kredit($studentId,$modtype="AK",$value->mt_semester);
        $kredit_vk= $this->m_result->get_kredit($studentId,$modtype="VK",$value->mt_semester);
        $kredit_all= $this->m_result->get_kredit($studentId,$modtype="",$value->mt_semester);
  
   
      //kredit all tolak denga kredit mengulan
      
      $clearkreditAll=$kredit_all[0]->kreditot + array_sum($kreditolak);
      
	   $clearkreditAK=$kredit_ak[0]->kreditot  +array_sum($kreditolakAK);
      
      $clearkreditVK= $kredit_vk[0]->kreditot  +array_sum($kreditolakVK);
      
       $pngkk=round($pointav/$clearkreditAll,2);
       $pngka=round($pointaak/$clearkreditAK,2);
       $pngkv=round($pointavk/$clearkreditVK,2);
      
        }
        
        $dataResult = array(
                        "semester_count" => $value->mt_semester,
                        "current_year" => $value->mt_year,
                        "pngv" => $pngv,
                        "pngkv" => $pngkv,
                        "pngk" => $pngk,
                        "pngkk" => $pngkk,
                        "stu_id" => $studentId,
                        "pnga" => $pnga,
                        "pngka" => $pngka,
                        "pointer_ak"=>$pointaak,
                        "pointer_vk"=>$pointavk,
                        "pointer_value"=>$pointav
                      );
                    /*   
                      echo "<pre>";
					  echo '$clearkreditAll=';
                      print_r(array_sum($kreditolak));
					  echo '$clearkreditAK=';
                      print_r($kredit_all[0]->kreditot);
                      echo "</pre>";
                      echo "<pre>";
                      print_r($value->stu_name);
                      echo "</pre>";
		  echo "vk".'<br/>';
	   echo '$pointavk=' .$pointavk .'<br/>';
	   echo '$jumMataKvtotal=' .$jumMataKvtotal .'<br/>';
	    echo '$pointer_vk=' .$pointer_vk .'<br/>';			  
	    echo '$kredit_vk[0]->kreditot=' .$kredit_vk[0]->kreditot .'<br/>';
	    echo '$pngkv=' .$pngkv .'<br/>';
		
	   echo "ak".'<br/>';
	   echo '$pointaak=' .$pointaak .'<br/>';
	   echo '$jumMataKatotal=' .$jumMataKatotal .'<br/>';
	    echo '$pointer_ak=' .$pointer_ak .'<br/>';
		echo '$kredit_ak[0]->kreditot=' .$kredit_ak[0]->kreditot .'<br/>';
		 echo '$pngka=' .$pngka .'<br/>';
		 
      echo "all".'<br/>';
	     echo '$pointav=' .$pointav .'<br/>';
	   echo '$jumMatarepeat=' .$jumMatarepeat .'<br/>';
	    echo '$pointer_value=' .$pointer_value .'<br/>';
      echo '$kredit_all[0]->kreditot=' .$kredit_all[0]->kreditot .'<br/>';
      echo '$pngkk=' .$pngkk .'<br/>';
	  echo "<pre>";
	  print_r( $kreditolak).'<br/>';
	  echo "</pre>";
	  print_r( array_sum($kreditolak));
                    
                      echo "<pre>";
                       
                      print_r($dataResult);
                      echo "</pre>";
                        echo "<pre>";
  print_r($curResult);
  echo "</pre>";
  */
  
  if(!empty($curResult)){
         $update = $this->m_result->updateResult($dataResult,$curResult[0]->result_id,$value->mt_semester,$value->mt_year,$studentId);
     
     
           //if($update==1){
         $dataarray = array(
               'nama' => $value->stu_name,
               'no_matrix' => $value->stu_matric_no,
               'sem' => $value->mt_semester,
               'pngkk' => $pngkk
            ); 
             array_push($var,$dataarray);
//}
          
    
         
      
      
  }else{
     $add = $this->m_result->addResult($dataResult); 
     
   //   if($add){
              $dataarray = array(
               'nama' => $value->stu_name,
               'no_matrix' => $value->stu_matric_no,
               'sem' => $value->mt_semester,
               'pngkk' => $pngkk
            ); 
          
      array_push($var,$dataarray);
         
    //  }       
      
  }
    
     
      
      
     //   }
   
        
       
        }
             $data['result']= $var;
        }
        
        
        
        $data['output'] = $this->load->view('laporan/v_cal_result_student', $data, true);
        $this->load->view('main', $data);
        
    }
    
    
    
    /**********************************************************************************************
 * Description      : this function to print result
 * input            : 
 * author           : sukor
 * Date             : 10 july 2013
 * Modification Log : -
**********************************************************************************************/ 
    function calculate_result()
    {
        $var=array();
 
        
        $codeCenter= $this->input->post('kodpusat');
        $course = $this->input->post('slct_kursus');
        $year = $this->input->post('mt_year');
        $semester = $this->input->post('semester');
        $student = $this->input->post('angka_giliran'); 
        $status = $this->input->post('status'); 
        $data['status'] =$status;
        $cC=explode("-", $codeCenter);
        if(!empty($student) || !empty($status)){
            
            $dataresult = $this->m_result->student_result($cC[0],$course,$year,$semester,$student,$status);
     
    }
        
   foreach ( $dataresult as  $value) {     
        

           $gred=explode(',',$value->greds);
             $subjek=explode(',',$value->subjek);
              $kod_subjek=explode(',',$value->kod_subjek);
              $kredit=explode(',',$value->kredit);
             $nilaigred=explode(',',$value->nilaigred);
             $level_gred=explode(',',$value->level_gred);
             $aStudentId=explode(',',$value->student_id);
             
             $aNilaiMata = array();
             $aNilaiMataKv = array();
             $aJumJamKv = array();
             $aJumJam = array();
             //akademik
              $aNilaiMataKa = array();
             $aJumJamKa = array();
             
             $studentId = '';
              
                    foreach ($kod_subjek as $key => $row) {
                        
                $gd_id=($gred[$key]=="0"?'-':$gred[$key]);  
                $ng=($nilaigred[$key]=="0"?'-':$nilaigred[$key]);   
                $lvgd=($level_gred[$key]=="0"?'-':$level_gred[$key]);   
                
                $studentId = $aStudentId[$key];
                
                $nilaMata=$kredit[$key]*$ng;
                //tambah nilai mata
                $aNilaiMata[] = $nilaMata;
                $aJumJam[] = $kredit[$key];
                
                
                
                $tempKodSub = substr($kod_subjek[$key], 0, 1);
                
                if($tempKodSub != 'A')
                {
                    $aNilaiMataKv[] = $nilaMata;
                    $aJumJamKv[] = $kredit[$key];
                }else{
                    
                    $aNilaiMataKa[] = $nilaMata;
                    $aJumJamKa[] = $kredit[$key];
                }
     
     
     
      } 
     
     
     
    $pevsem=$value->mt_semester-1;
   
    $curResult = $this->m_result->resultBySemYearStudent($value->mt_semester, $value->mt_year, $studentId);
    $Resultsem = $this->m_result->resultBySemYearStudent($pevsem, $year='',$studentId);
   // $Resultsem = $this->m_result->get_kredit($studentId);
  

    
    $stuId = $value->stu_id;

 
        if($status!=2){ 
        $jumMata = array_sum($aNilaiMata);
        $jumJam = array_sum($aJumJam);
        
        $curGpa = sprintf("%.2f",$jumMata/$jumJam);
        
        $jumMataKv = array_sum($aNilaiMataKv);
        $jumJamKv = array_sum($aJumJamKv);
        
        $curGpaKv = sprintf("%.2f",$jumMataKv/$jumJamKv);
        
        //akdemik
        $jumMataKa = array_sum($aNilaiMataKa);
        $jumJamKa = array_sum($aJumJamKa);
        
        
        
        $curGpaKaa = sprintf("%.2f",$jumMataKa/$jumJamKa);
        
        $pngv = $curGpaKv;
        $pngkv = $curGpaKv;
        $pngk = $curGpa;
        $pngkk = $curGpa;
        $pnga = $curGpaKaa;
        $pngka = $curGpaKaa;
         $pointavk =$jumMataKv;
         $pointaak = $jumMataKa;
         $pointav = $jumMata;
        
        if(!empty($Resultsem)){
           
            
        $pointer_ak = $Resultsem[0]->pointer_ak;
        $pointer_vk = $Resultsem[0]->pointer_vk;
        $pointer_value = $Resultsem[0]->pointer_value;
       
       $pointavk =$jumMataKv+$pointer_vk;
       $pointaak = $jumMataKa+$pointer_ak;
       $pointav = $jumMata+$pointer_value;
       
      // $kreditbm = $this->m_result->get_png_bm($value->stu_matric_no,$value->mt_semester);
      // $kreditkbm = $this->m_result->get_pngk_bm($value->stu_matric_no,$value->mt_semester);
        $kredit_ak= $this->m_result->get_kredit($studentId,$modtype="AK",$value->mt_semester);
        $kredit_vk= $this->m_result->get_kredit($studentId,$modtype="VK",$value->mt_semester);
        $kredit_all= $this->m_result->get_kredit($studentId,$modtype="",$value->mt_semester);
        
      // $pngbm = round($kreditbm,2);
      // $pngkbm = round($kreditbm/$kreditkbm[0]->kreditot,2);
       $pngkk=round($pointav/$kredit_all[0]->kreditot,2);
       $pngka=round($pointaak/$kredit_ak[0]->kreditot,2);
       $pngkv=round($pointavk/$kredit_vk[0]->kreditot,2);
      
        }
        
        $dataResult = array(
                        "semester_count" => $value->mt_semester,
                        "current_year" => $value->mt_year,
                        "pngv" => $pngv,
                        "pngkv" => $pngkv,
                        "pngk" => $pngk,
                        "pngkk" => $pngkk,
                        "stu_id" => $studentId,
                        "pnga" => $pnga,
                        "pngka" => $pngka,
                        "pointer_ak"=>$pointaak,
                        "pointer_vk"=>$pointavk,
                        "pointer_value"=>$pointav
                      );
                   /*   
                      echo "<pre>";
                      print_r($value->stu_name);
                      echo "</pre>";
                     
                      echo "<pre>";
                       
                      print_r($dataResult);
                      echo "</pre>";
                        echo "<pre>";
  print_r($curResult);
  echo "</pre>";
  */
  if(!empty($curResult)){
         $update = $this->m_result->updateResult($dataResult,$curResult[0]->result_id,$value->mt_semester,$value->mt_year,$studentId);
     
     
           //if($update==1){
         $dataarray = array(
               'nama' => $value->stu_name,
               'no_matrix' => $value->stu_matric_no,
               'sem' => $value->mt_semester,
               'pngkk' => $pngkk
            ); 
             array_push($var,$dataarray);
//}
          
    
         
      
      
  }else{
     $add = $this->m_result->addResult($dataResult); 
     
   //   if($add){
              $dataarray = array(
               'nama' => $value->stu_name,
               'no_matrix' => $value->stu_matric_no,
               'sem' => $value->mt_semester,
               'pngkk' => $pngkk
            ); 
          
      array_push($var,$dataarray);
         
    //  }       
      
  }
    
     
      
      
        }
   
        
       
        }


     $data['result']= $var;
       $data['output'] = $this->load->view('laporan/v_result_cal', $data, true);
        $this->load->view('main', $data);
        
    }



    
    
}



?>