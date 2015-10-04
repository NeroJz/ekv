<?php
/**************************************************************************************************
 * File Name        : report.php
 * Description      : This File contain Report module.
 * Author           : sukor
 * Date             : 15 july 2013
 * Version          : -
 * Modification Log : -
 * Function List	   : __construct(),
 **************************************************************************************************/
class Import_excellkv extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		//$this -> load -> model('m_result');
		$this -> load -> model('m_import');
	}

function importExcell()
{
	
	$data['output'] = $this->load->view('import/v_upload_file', array('error' => ' ' ), true);
	$this -> load -> view('main.php', $data, '');
}


function upload_files()
{
	
		$config['upload_path'] = './uploaded/excellkv/';
		$config['allowed_types'] = 'xls';
		$config['max_size']	= '2000000';
		
		$semester =$this->input->post('semester');
		$tahun = $this->input->post('tahun');
		$sesi = $this->input->post('sesi');
		$bil_sub = $this->input->post('subjek');
		
		//die();
		

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$error = array('error' => $this->upload->display_errors());
			$data['output'] = $this->load->view('import/v_upload_file', $error, true);
			$this -> load -> view('main.php', $data, '');
		}
		else
		{
			
			$data = array('upload_data' => $this->upload->data());
			$file = $this->upload->data();
			$thumbnail = $file['raw_name'].$file['file_ext'];
			
			//print_r($thumbnail);
			$this->bacaKv($thumbnail, $semester,$tahun, $sesi, $bil_sub);
			$this->load->view('import/v_upload_success', $data);
		}
	
}


function bacaKv($file="", $sem="", $tahun="",  $tahun_intake="" , $bil_sub=""){
	
$this->load->library('excel_reader');
$feeno=	$this->excel_reader->import_with_kv($file, $bil_sub);


$bill=0;
$bil_res=0;
$bil_res_x=0;
//print_r($feeno);
foreach($feeno as $row){
 
//   echo $row['no'].$row['name'].'</br>';
 
 $cc = $this->m_import->checkcc_id($row['kod'],$row['kv']);
 //$state = $this->m_import->state($row['state']);
 $state = $this->m_import->state("Melaka");
 $studentexit = $this->m_import->get_student_id($row['ic']);
 
   if(empty($cc)){
$col_id = $this->m_import->col_id($row['kv']);

$kod_id = $this->m_import->kod_id($row['kod']);
//print_r($row);
//die();
$datacc=array(
   'col_id'=>$col_id[0]->col_id,
   'cou_id' => $kod_id[0]->cou_id
     
     );
//insert college course kalau tiada data
$this->db->insert('college_course', $datacc); 
 
  //hold cc_id value 
$cc = $this->m_import->checkcc_id($row['kod'],$row['kv']);
   }
   
   else{
$kod_id = $this->m_import->kod_id($row['kod']);
   }
   
  // $tahun=$;
  // $sem=2;
  // $tahun_intake="1 2012";
   
   $bill++;
   echo"<pre>";
   echo $bill.". ".$row['name'].'</br>';
   echo $row['ic'].'</br>';
   
   if(empty($studentexit)){
   	
echo"</pre>";
 $data = array(
     'stu_mykad' => $row['ic'],
    'stu_name' => $row['name'],
    'stu_matric_no' => $row['nomatric'],
    'stu_gender' => $row['gender'],
    'stu_race' => $row['race'],
    'stu_religion' => $row['rel'],
     'stu_current_sem' =>$sem,
     'stu_current_year'=>$tahun,
   'stu_intake_session' => $tahun_intake,
'cc_id' =>  $cc[0]->cc_id,
'state_id' => $state[0]->state_id);
 
 $tru=$this->db->insert('student', $data);
   }
   else
   {
  	$tru = 2;
	$data_sem = array(
	'stu_current_sem'=> $sem,
	'stu_current_year'=> $tahun,
  	'stu_matric_no' => $row['nomatric']);

   
   $this->db->where('stu_mykad', $row['ic']);
   $this->db->update('student', $data_sem);

   }

  if($tru)
{
   
      echo"<pre>";
      echo "Maklumat pelajar : Berjaya masuk dalam pangkalan</br>";
	  echo"</pre>";
}

else if($tru == 0)
{
   
      echo"<pre>";
      echo "Maklumat pelajar: Tidak berjaya masuk dalam pangkalan</br>";
	  echo"</pre>";
}

else if($tru == 2)
{
   
      echo"<pre>";
      echo "Maklumat pelajar : Data dikemaskini</br>";
	  echo"</pre>";
}
                                            
$student_id = $this->m_import->get_student_id($row['ic']);	
//kena tukar x	 
for ($x=1; $x<= $bil_sub; $x++)
   {
   
   if(isset($row["KOD_MP$x"])|| empty($row["KOD_MP$x"]) || empty($row["KOD_MP$x"])== NULL || empty($row["KOD_MP$x"])=="")
   {
		$kod_mp=empty($row["KOD_MP$x"])?"":$row["KOD_MP$x"];	   
		$gred_mp=empty($row["GRED_MP$x"])?"":$row["GRED_MP$x"];
		if(!empty($kod_mp) && $kod_mp!="NULL"){
   
   

if($sem!=1)
{
   $getvaluesem=$sem-1;
}
else
{
   $getvaluesem=0;
}

$mod_id = $this->m_import->get_mod_id($kod_mp);	

   
 if(empty($mod_id[0]->mod_id))
 {
  // print_r($row["KOD_MP$x"]);
	$id ="";
	$mod_paper = substr($row["KOD_MP$x"], 0, 3);
	$mod_type = substr($row["KOD_MP$x"], 0, 1);
	
	if($mod_type == 'A' || $mod_type == 'a')
	{
		$dModule = array('mod_code'=>$mod_paper,
							'mod_paper' => $row["KOD_MP$x"],
							'mod_name'=>$row["NAMA_MP$x"],
							'mod_type'=>'AK',
							'mod_mark_centre'=>30,
							'mod_mark_school'=>70,
							'mod_credit_hour' =>$row["JK_MP$x"],
							'stat_mod' => 0);
							
		$id = $this->m_import->insert_module($dModule);
		
		if($id)
		{
			$arr1 = array('ppr_percentage'=> 100,
							'ppr_category'=> 'P',
							'mod_id'=> $id);
							
			$arr2 = array('ppr_percentage'=> 100,
							'ppr_category'=> 'S',
							'mod_id'=> $id);
							
			$this->m_import->insert_module_ppr($arr1);
			$this->m_import->insert_module_ppr($arr2);
		}
		
		
	}
	
	else if($mod_type != 'A' || $mod_type != 'a')
	{
		$dModule = array('mod_code'=>$row["KOD_MP$x"],
							'mod_paper' => $row["KOD_MP$x"],
							'mod_name'=>$row["NAMA_MP$x"],
							'mod_type'=>'VK',
							'mod_mark_centre'=>30,
							'mod_mark_school'=>70,
							'mod_credit_hour' =>$row["JK_MP$x"],
							'stat_mod' => 0);
							
		$id = $this->m_import->insert_module($dModule);
		if($id)
		{
			$arr1 = array('pt_category'=> 'P',
							'pt_teori'=> 20,
							'pt_amali'=> 10,
							'mod_id'=> $id);
							
			$arr2 = array('pt_category'=> 'S',
							'pt_teori'=> 30,
							'pt_amali'=> 40,
							'mod_id'=> $id);
							
			$this->m_import->insert_module_pt($arr1);
			$this->m_import->insert_module_pt($arr2);
			
		}
		
	}
	
	echo "Modul baru dimasukkan: ".$kod_mp;
	//print_r($dModule);
	//echo $kod_mp;
	$mod_id = $this->m_import->get_mod_id($kod_mp);	
 
   
 }


$grade = $this->m_import->get_grade_id($gred_mp,$mod_id[0]->mod_type);
 
 	
 
 $data_mod = array(
    'mod_id' => $mod_id[0]->mod_id,
    'stu_id' => $student_id[0]->stu_id,
    'mt_semester' => $sem,
    'mt_year' => $tahun,
    'mt_full_mark' => $grade[0]->max_mark,
    'mt_status' => 1,
    'grade_id' => $grade[0]->grade_id,
    'exam_status' => 1);
   
 
 
 $courseModule= $this->m_import->check_course_module($mod_id[0]->mod_id,$kod_id[0]->cou_id);
  $cmse= 0;
 if(empty($courseModule)){
   $data_cm = array(
    'cm_semester' => $sem,
    'cou_id' => $kod_id[0]->cou_id,
    'mod_id' => $mod_id[0]->mod_id);
   
    $cmse=$this->db->insert('course_module', $data_cm);
   
 }
 
$md_check = $this->m_import->get_checkexsit($mod_id[0]->mod_id,$student_id[0]->stu_id,$tahun,$sem);	 


$mark_seccues = 0;
 if(empty($md_check))
 {
 	
   $this->db->insert('module_taken', $data_mod);
   $mod_idnew = $this->db->insert_id();
 	
   $data_marks = array(
   array(
     
	'marks_assess_type' => $mod_id[0]->mod_type,
	'mark_category ' =>"P",
	'marks_total_mark ' =>'70',
	'marks_value' =>(0.7 * $grade[0]->max_mark),
	'md_id' =>$mod_idnew ,
   ),
   array(
    
   'marks_assess_type' => $mod_id[0]->mod_type,
   'mark_category ' =>"S",
   'marks_total_mark ' =>"30",
   'marks_value' =>(0.3 * $grade[0]->max_mark),
   'md_id' =>$mod_idnew 
   )
);

	$mark_seccues=	$this->db->insert_batch('marks', $data_marks); 

   }
}	
}
 
//$sem_result= $this->m_import->get_value_sem($student_id[0]->stu_id,$getvaluesem);
//$pngkvs=empty($sem_result[0]->pngkv)?0:$sem_result[0]->pngkv;
//$pngkas=empty($sem_result[0]->pngka)?0:$sem_result[0]->pngka;
//$pngkk=empty($sem_result[0]->pngkk)?0:$sem_result[0]->pngkk;

/*echo "<pre>";
print_r($sem_result);
echo "</pre>";*/

/*$pngkv=$row["PNG_VOK"]+$pngkvs;
$pngka=$row["PNG_AKA"]+$pngkas;
$pngkk=$row["PNG"]+$pngkk;
$data_result= array(
'semester_count' =>$sem,	   
'current_year'	=>$tahun,
'pointer_value'=>$row["JUM_NM"],
//'grade_value'=>
'pngv'=>$row["PNG_VOK"],
'pngkv'=>$pngkv,
'pnga'=>$row["PNG_AKA"],
'pngka'=>$pngka,
'pngk'=>$row["PNG"],
'pngkk'=>$pngkk,
'stu_id'=>$student_id[0]->stu_id,
   );
 */  
//echo "<pre>";
//print_r($data_result);  
//echo "</pre>";
/*
$result_check = $this->m_import->get_checkresult($student_id[0]->stu_id,$tahun,$sem);	 
if(empty($result_check))
{
   $resuc=  $this->db->insert('result', $data_result);	
}
else
{
   //$resuc='';
  	
	$this->db->where('stu_id', $student_id[0]->stu_id);
	$resuc2 = $this->db->update('result', $data_result); 	
}
*/      
if($tru)
{
   
      //echo"<pre>";
     // echo "Maklumat ".$row['name']."-".$row['ic']."  masuk dalam pangkalan</br>";
	  //echo"</pre>";
}

if($mark_seccues)
{
	echo"<pre>";
	echo "Markah subjek ". $mod_id[0]->mod_code. " : Berjaya masuk dalam pangkalan";
	echo"</pre>";
}

if($cmse)
{
//echo "course_module masuk";
   
}
/*
if(!empty($resuc))
{
	$bil_res++;
   	echo "<pre>";
	print_r($data_result);  
	
   // echo .":"; 
    echo "Keputusan pelajar ". $row['ic']. "masuk dalam pangkalan</br>";
	echo "</pre>";
 
}
else
{
   	$bil_res_x++;

   	echo"<pre>";
	echo "Keputusan pelajar ". $row['ic']." tidak masuk dalam pangkalan</br>";
	echo"</pre>";
	
	if(isset($rescue2) && $rescue == 1)
		{
					echo "<pre>";
					print_r($data_result);  
				
				    echo "Keputusan pelajar ".$row['ic']. " dikemaskini</br>";
			
		}
	echo"</pre>";
   
}
 */
 
   
   } 



}
/*
echo"<pre>";
echo "Bilangan keputusan pelajar yang berjaya dimasukkan dalam pangkalan: " .$bil_res;
echo "<br/>";
echo "Bilangan keputusan pelajar yang tidak berjaya dimasukkan dalam pangkalan: ".$bil_res_x;
echo"</pre>";

 */
 
}
	

}
?>