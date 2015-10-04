<?php
class Test extends CI_Controller{
	//function ini digunakan untuk pre import collage..untuk guna, sila buang __. ini untuk keselamatan
	function __importkv()
	{
		$this -> load -> library('excel_reader');
		$this -> excel_reader -> importKv();
		$this->load->library("ion_auth");		
	}
	
	function getUser()
	{
		$user = $this->session->userdata;
		
		$angkaGiliran = $this->func->generateMatricNo(1, 1);
		
		print_r($user);
		br();
		echo $user_groups = $this->ion_auth->user()->row()->col_id;	
	}
	
	function testFunc()
	{
		//parameter 1 = collage_id, 2 = course_id
		echo generateMatricNo(1,2);
	}
	
	function test_json()
	{
		$aData = array();
		$aData["ali"] = array("x" => 90);
		$aData["abu"] = array("x" => 80);
		$aData["ahmad"] = array("x" => 70);
		
		$aJsonData = json_encode($aData);
		
		print_r($aJsonData);
		
		$data["json"] = $aJsonData;
		
		$content['output'] = $this->load->view("test/json",$data,true);
		$this->load->view("main",$content);
		
	}
	
	function get_module()
	{
		$this -> load -> model('m_fakhruz');
		$avData = array();
		
		$aOpt = array("mod_id" => 1);

		$this->m_fakhruz->getCourse($avData);
		
		echo("<br><pre>");
		print_r($avData);
		echo("</pre><br>");
		
	}
	
	function sendAlert()
	{
		//ni untuk message ye
		$this->session->set_flashdata("alertContent", "selamat berbuka ku mudrikah");
		
		//optional untuk header
		$this->session->set_flashdata("alertHeader", "Ucapan");
		
		redirect("test/getAlert");
	}
	
	function getAlert()
	{
		$aData = array();
		$aData["ali"] = array("x" => 90);
		$aData["abu"] = array("x" => 80);
		$aData["ahmad"] = array("x" => 70);
		
		$aJsonData = json_encode($aData);
		
		$data["json"] = $aJsonData;
		
		$content['output'] = $this->load->view("test/json",$data,true);
		$this->load->view("main",$content);
		
	}
	
	function encodeviaurl()
	{
		$this->load->view("test/encode.php");
	}
	
	function insert_sem_module()
	{
			$this -> load -> model('m_semester');
			
			$arr = $this->m_semester->get_sem_module('AK');
			print_r($arr);
			foreach($arr as $row)
			{
				$sem = substr($row->mod_paper, -3, 1);
				echo "<br>".$row->mod_paper."--->".$sem."</br>";
				$data= array('mod_sem' => $sem);
				$this->m_semester->ins_sem_mod($data, $row->mod_id);
			}
	}

	function encryption_base64(){
		$this->load->view('test');
	}
	/*function test_func()
	{
		//print_r($this->session->all_userdata());
		$semester = $this->func->get_semester();
		if($semester)
		{
			$this->func->update_semester($semester);
		}
		if($semester)
		{
			echo "<pre>";
			print_r($semester);
			echo "</pre>";
			$sta = update_semester($semester);
		}
		
		
	}*/
	
	function test_query()
	{
		$this -> load -> model('m_semester');
			
			$arr = $this->m_semester->m_ida();
			echo "<pre>";
			print_r($arr);
			
	}
	
}

// end of Class
/**************************************************************************************************
* End of test.php
**************************************************************************************************/
?>