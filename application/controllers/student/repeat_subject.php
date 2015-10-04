<?php

/**************************************************************************************************
 * File Name        : repeat_subject.php
 * Description      : This File contain Report module.
 * Author           : sukor
 * Date             : 25 july 2013 
 * Version          : -
 * Modification Log : -
 * Function List       : __construct(),
 **************************************************************************************************/
class Repeat_subject extends MY_Controller {

    /**************************************************************************************************
     * Description      : Constructor: It loads the required model and libraries.
     * Author           : sukor
     * Date             : 26 July 2013
     * Input Parameter  : -
     * Modification Log : -
     **************************************************************************************************/
    function __construct() {
        parent::__construct();
        $this -> load -> model('m_repeatsubject');
        $this -> load -> model('m_result');
        $this -> load -> model('m_report');
        
    }

    /**************************************************************************************************
     * Description      : view to add subject
     * Author           : sukor
     * Date             : 25 July 2013
     * Input Parameter  : -
     * Modification Log : -
     **************************************************************************************************/
    function repeat_subject_view($couId='',$colId='') {
        
     $user_login = $this->ion_auth->user()->row();
        $colid = $user_login->col_id;
        $userId = $user_login->user_id;
        $state_id= $user_login->state_id;

          $user_groups = $this->ion_auth->get_users_groups($userId)->row();  
          $ul_type= $user_groups->ul_type;
          
        if($ul_type=="KV"){
            $col=get_user_collegehelp($userId);
            $data['colname']=$col[0]->col_name.'-'.$colid;
        }
        
        if($ul_type=="JPN"){
            $data['centrecode'] = $this -> m_result -> get_institusi($state_id);
        }else{
            $data['centrecode'] = $this -> m_result -> get_institusi();
        }
        
        
        
        $data['year'] = $this -> m_result -> list_year_mt();
        $data['courses'] = $this -> m_result -> list_course();
        //$data['state'] = $this -> m_report -> list_state();
        $centreCode = $this -> input -> post('kodpusat');
        if(empty($colId) && !empty($centreCode)){
             $cC=explode("-", $centreCode); 
            $ccId=$cC[0];
        }elseif(!empty($colId) && empty($centreCode)){
            
            $collage= $this ->m_repeatsubject->get_colname($colId);
            $data['da'] = 'ada';
            $ccId=$collage[0]->col_name;
        }else{
            
            $ccId='';
        }

        
        
        $year = $this -> input -> post('mt_year');
        $course = $this -> input -> post('slct_kursus');
        $semester = $this -> input -> post('semester');
        $matric = $this -> input -> post('matric');
        
    if(empty($couId) && !empty($course)){
             $courseid=$course;
        }elseif(!empty($couId) && empty($course)){
            
            $data['da'] = 'ada';
            $courseid=$couId;
        }else{
            
            $courseid='';
        }   
         
        $data['search'] = $ccId."|".$courseid."|".$semester."|".$year."|".$matric;

        if($ul_type == "LP"){
            $data['output'] = $this -> load -> view('student/v_repeat_students_list', $data, true);
        }
        else {
            $data['output'] = $this -> load -> view('student/v_repeat_subject', $data, true);
        }
        $this -> load -> view('main', $data);   
    }

/**********************************************************************************************
 * Description      : this function get student
 * input            : 
 * author           : sukor
 * Date             : 25 July 2013
 * Modification Log : -
**********************************************************************************************/

    function repatsub_ajax() {
        $arr_data = $this -> m_repeatsubject -> list_repeatsub_ajax();

        if (sizeof($arr_data) > 0)
            echo json_encode($arr_data);
    }
    
    
/**********************************************************************************************
 * Description      : this function to get subject
 * input            : 
 * author           : sukor
 * Date             : 25 July 2013
 * Modification Log : -
**********************************************************************************************/

    function reg_repeat_subject($stuid,$status='') {
        
        $student= $this -> m_repeatsubject->get_student($stuid);
		$sem_cur=$student[0]->stu_current_sem;
		$couID=$student[0]->cou_id;
	//$sem_cur=4;
	//untuk dapatkan sem yang boleh repeat
	$semcan=array();
	   $rod=ceil($sem_cur/2);
		$semicc=$sem_cur;
		$r=array();
		for ($i=1; $i <$rod ; $i++) {
			
			$semicc=$semicc-2;
		
			array_push($semcan,$semicc);
		}
		
		
	
        $data['student'] = $this -> m_repeatsubject->get_student($stuid);
        $data['subject_fail'] = $this -> m_repeatsubject->get_student_repeat($stuid,$fail="fail");
      
        $data['canrepeat'] = $this -> m_repeatsubject->get_modulecan($stuid,$semcan,$couID);
	  
        $data['subject_repat'] = $this -> m_repeatsubject->get_student_repeat($stuid,$repeat='repeat');
        $year= $this -> m_result -> list_year_mt();
        $data['status'] = $status;
        $temp=array();
        foreach($year as $row){
            
            array_push($temp,$row->mt_year);
            
        }
        
        array_push($temp,date('Y'));
        $years=array_unique($temp); 
        $data['year'] = $years;
        
        $data['output'] = $this -> load -> view('student/v_regsubject_repeat', $data, true);
        $this -> load -> view('main', $data);   
        
    }
        
    /**********************************************************************************************
 * Description      : this function to get subject
 * input            : 
 * author           : sukor
 * Date             : 26 July 2013
 * Modification Log : -
**********************************************************************************************/

    function add_repeat_subject() {
    
        
              $add_subject = array_values( array_filter($this->input->post('add_subject')));
              $add_semester = array_values( array_filter($this->input->post('add_semester')));
              $add_year = array_values( array_filter($this->input->post('add_year')));
              $stu_id= $this->input->post('stu_id');
        /*      
        print_r($add_subject);
        echo "</br>";
        print_r($add_semester);
        echo "</br>";
        print_r($add_year);
        echo "</br>";
        die();
        */
          foreach ($add_subject as $key=>$subject_id) {
            $modul= explode("|", $subject_id);
             
        if($modul[0]!="" && $modul[0]!=0){
       
           $exist= $this->m_repeatsubject->check_exist_subject($modul[0],$add_semester[$key],
                               $add_year[$key],$stu_id);
        
    if($exist){
       $this->session->set_flashdata("alertContent", "Telah Ada Modul Didaftarkan");
         $this->session->set_flashdata("alertHeader", "PENDAFTARAN GAGAL");
        redirect('/student/repeat_subject/reg_repeat_subject/'.$stu_id);
    }else{
        
       
        
        
            $temp = array(
              'mod_id' => $modul[0],
              'mt_semester' => $add_semester[$key],
              'stu_id' => $stu_id,
              'mt_year'=>$add_year[$key],
              'mt_status' => 1,
              'exam_status'=> 2
                        );
       

$in= $this->db->insert('module_taken', $temp);  
$newmdid=$this->db->insert_id();
                      
  $dataup = array(
               'mt_status' => 2,
              
            );
            
        /**FDPO - Safe to be deleted**/
        //echo('<pre>');print_r($newmdid);echo('</pre>');
        //die();
        
$this->db->where('md_id', $modul[1]);
$this->db->update('module_taken', $dataup);                     
                      
        //get marks           
         $mdidd= $this->m_repeatsubject->get_marks($modul[1]);
        
        if($mdidd != null)
        {
            foreach ($mdidd as $md) {
                            
                      
                        if($md->marks_assess_type=='AK'){
               
                    if($md->mark_category=="P"){
                        $total_mark=0;
                    }else{
                        $total_mark=$md->marks_value;
                    }
					
							}elseif($md->marks_assess_type=='VK'){
								
								if($md->mark_category=="S"){
                        $total_mark=0;
                    }else{
                    	
						
                    $total_markpoint=   ($md->marks_value/$md->marks_total_mark)*100;
					   
					    $total_mark=round($total_markpoint,2);
                    }
										
							}
                
            $tempmarks=array(
                 'marks_assess_type' => $md->marks_assess_type,
                 'mark_category' => $md->mark_category,
                 'marks_total_mark' => $md->marks_total_mark,
                 'marks_value' =>$total_mark, 
                 'md_id' => $newmdid
            );
            
            /*   
            $md->marks_assess_type;
            $md->mark_category;
            $md->marks_total_mark;
            $md->marks_value;    
            */      
            
            $in= $this->db->insert('marks', $tempmarks);  
        }
        
        }
        else {
            $this->session->set_flashdata("alertContent", "Modul Telah Berjaya Didaftarkan Tanpa Markah Terdahulu");
            $this->session->set_flashdata("alertHeader", "PENDAFTARAN");
            redirect('/student/repeat_subject/reg_repeat_subject/'.$stu_id);
        }
                  
                      
    }
        }else{
            
              $this->session->set_flashdata("alertContent", "Tiada Modul Yang Dipilih ");
         $this->session->set_flashdata("alertHeader", "PENDAFTARAN GAGAL");
        redirect('/student/repeat_subject/reg_repeat_subject/'.$stu_id);
            
        }
       }
     
    
  
    if($in){
        $this->session->set_flashdata("alertContent", "Modul Telah Berjaya Didaftarkan");
         $this->session->set_flashdata("alertHeader", "PENDAFTARAN");
         redirect('/student/repeat_subject/reg_repeat_subject/'.$stu_id);
    }
        
    }


/**********************************************************************************************
 * Description      : this function to get subject
 * input            : 
 * author           : sukor
 * Date             : 27 July 2013
 * Modification Log : -
**********************************************************************************************/

    function delete_repeat_subject($mdId,$stuId) {
    
    
        
        $this->db->where('md_id', $mdId);
        $this->db->where('stu_id', $stuId);
     $del=   $this->db->delete('module_taken'); 
     if($del){
        
         
         $this->session->set_flashdata("alertContent", "Modul Telah Berjaya Dibatalkan");
         $this->session->set_flashdata("alertHeader", "PEMBATALAN");
         
        redirect('/student/repeat_subject/reg_repeat_subject/'.$stuId);
        
     }

        
    }

    
    
    /**********************************************************************************************
 * Description      : this function to get subject
 * input            : 
 * author           : sukor
 * Date             : 27 July 2013
 * Modification Log : -
**********************************************************************************************/

    function make_data() {
    
    
        
    $ccId=1;
        $student = $this -> m_repeatsubject->make_studet($ccId);
        
        foreach ($student as  $value) {
            $tem=array();
            for ($i=2; $i <3 ; $i++) { 
                $module = $this -> m_repeatsubject->getmodule($value->cou_id,$i);
                
                
                $year=date('Y')+$i-1;
                foreach ($module as $row) {
                    
                    if($row->mod_type=="AK"){
                        $gradeid=7;
                    }else{
                        $gradeid=18;
                    }
                    if($row->mod_code!="A07"){
                        
                    
                    
                    $temp=array(
                    "mt_semester"=>$i,
                    "mt_year"=>$year,
                    "mt_status"=>1,
                    "stu_id"=>$value->stu_id,
                    "mod_id"=>$row->mod_id,
                    "exam_status"=>1,
                    "mt_full_mark"=>"",
                    "grade_id"=>""
                    );
                $this->db->insert('module_taken', $temp); 
                    //array_push($tem,$temp);
                    }
                }
                //$this->db->insert('module_taken', $tem); 
                
                
                $data=array(
                    "semester_count"=>$i,
                    "current_year"=>$year,
                    "pngv"=>1,
                    "pngkv"=>$value->stu_id,
                    "pngk"=>$row->mod_id,
                    "pngkk"=>1,
                    "stu_id"=>$value->stu_id
                    );
                
            //  $this->db->insert('result', $data); 
                
                
            }
            

        }
        


        
    }
    
    
    
    
}

/**************************************************************************************************
 * End of Repeat_subject.php
 **************************************************************************************************/
?>