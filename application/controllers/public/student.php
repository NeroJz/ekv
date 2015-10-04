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
class Student extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();

		$this->load->model('m_result');
	}
	
	function result($param=""){
		$this->load->library('encryption');
		$dataParam = $this->encryption->decode($param);
		
		$aParam = explode("_",$dataParam);
		$codeCenter= $this->input->post('kodpusat');
		$course = $this->input->post('slct_kursus');
		$year = $aParam[2];
		$semester = $aParam[1];
		$student = $aParam[0];	
		$status = $this->input->post('status');	
		$data['status'] =$status;
		$cC=explode("-", $codeCenter);
		if(!empty($student) || !empty($status)){
			$data['result'] = $this->m_result->student_result($cC[0],$course,$year,$semester,$student,$status);
			$this->load->view('laporan/v_cetak_result', $data);
		}else{
			redirect('report/result/result_student');
		}
	}
}
?>
