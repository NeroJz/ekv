<?php
/**************************************************************************************************
* File Name        : writtenform.php
* Description      : This File contain Examination module. Used for Print "Borang K15"
* Author           : Norafiq Bin Mohd Azman Chew
* Date             : 25 July 2013
* Version          : -
* Modification Log : -
* Function List	   : __construct(), 
**************************************************************************************************/
class Writtenform extends MY_Controller
{
	/**********************************************************************************************
	* Description		: Constructor = load model
	* input				: - 
	* author			: Norafiq Azman
	* Date				: 25 July 2013
	* Modification Log	: -
	**********************************************************************************************/
	function __construct() 
	{
		parent::__construct();
		$this->load->model('m_kursus');
		$this->load->model('m_pelajar');
		$this->load->model('m_subject');
		$this->load->library('grocery_CRUD');
	}
	
	/**********************************************************************************************
	* Description		: Index. $userid = on session for pensyarah login. for others user
	* 					  create new function :)
	* input				: - 
	* author			: Norafiq Azman
	* Date				: 25 July 2013
	* Modification Log	: -
	**********************************************************************************************/
	function index() 
	{
		$user = $this->ion_auth->user()->row();
		$userid = $user->id;
		
		$year = $this->session->userdata["tahun"];
		
		$data['kursus'] = $this->m_kursus->login_course($userid, $year);
        $output['output'] = $this->load->view('marking/v_writtenform', $data, true);
		$this->load->view('main.php', $output);
	}
	
	/**********************************************************************************************
	* Description		: this function to get lecture subject in course teaching
	* 					  json responder
	* input				: -
	* author			: Norafiq Azman
	* Date				: 25 July 2013
	* Modification Log	: siti umairah - subject_by_spid_get_category
	**********************************************************************************************/
	function spsubject()
	{
		$courselect = $this->input->post("course_id");
		$semester = $this->input->post("semes_ter");
					
		$data = $this->m_subject->subject_by_spid_get_category($courselect, $semester);
		$response = array('subjek' => $data);
		
		echo(json_encode($response));
	//	print_r($response);
		
		
	}
	
	
	//spsubject_kelas
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
	
	
	/**********************************************************************************************
	* Description		: this function to get students json responder
	* input				: -
	* author			: Norafiq Azman
	* Date				: 25 July 2013
	* Modification Log	: siti umairah - 30 januari 2014 - get total esaimen untuk borang k 15
	**********************************************************************************************/
	function get_students()
	{
		
		$user = $this->ion_auth->user()->row();
		$userid = $user->id;
				
		$year = $this->session->userdata["tahun"];		
		$userSesi = $this->session->userdata["sesi"];
		
				
		$cmid 		= $this->input->post("cmId");
		$semester 	= $this->input->post("semester");
		$subject 	= $this->input->post("subjectId");//mod_id
		$pilihan	= $this->input->post("slct_pengisian");
		$tot_subject = $this->input->post("slct_jubject");
		//$type_pentaksiran = $this->input->post("pentaksiran");
		//$tempcategory = $this->input->post("tempKAt");		
		$data_subject = explode(':', $tot_subject);	
		$ppr = $this->m_subject->get_ppr_id($subject);
		$kelas = $this->input->post("slct_kelas");
		//$ppr2 = $ppr[0]->ppr_id;
		
		/* echo "<pre>".$cmid."</pre>";
		echo "<pre>".$semester."</pre>";
		echo "<pre>".$subject."</pre>";
		echo "<pre>".$pilihan."</pre>";
		die(); */
		
		$data['senaraipelajar'] = $this->m_pelajar->student_marking($cmid, $semester, $kelas);
		$data['semester']		= $semester;
		$data['subjectkod']		= $this->m_subject->subject_code($subject);
		$data['tahun']			= $year;
		$data['pengisian']		= $pilihan;
		$data['total_assignment'] = $this->m_subject->total_esaimen($userid,$year,$userSesi,$cmid,$ppr,$data_subject[1],$pilihan);
		
		/*echo "<pre>";
		print_r($data);
		echo"</pre>";
		
		die();*/
		
		$this->load->view('marking/v_print_writtenform', $data);
		
		
		//$data = $this->m_pelajar->student_marking($cmid, $semester);
		//$response = array('pelajar' => $data);
		
		//echo(json_encode($response));
	}
	
}// end of class
/**************************************************************************************************
* End of writtenform.php
**************************************************************************************************/
?>