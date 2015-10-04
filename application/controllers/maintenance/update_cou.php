<?php
class Update_cou extends MY_Controller {
	function main(){
		$this->load->library('encryption');
		$dataSplit = explode('_',urldecode($this->encryption->decode($this->uri->segment(4))));
		$data["primary_key"] = $dataSplit[0];
		$data["cou_code"] = $dataSplit[1];
		$data["cou_course_code"] = $dataSplit[2];
		$data["output"]=$this->load->view("maintenance/v_update_cou",$data,true);
		$this->load->view("main",$data);
	}
	
	function update(){
		$this->load->model("m_maintenance");
		$id=$this->input->post('id', TRUE);
		$cou_code=$this->input->post('kod', TRUE);
		$cou_course_code=$this->input->post('kod_kursus', TRUE);
		$this->m_maintenance->update_cou_code($id,$cou_code,$cou_course_code);
	}
}
?>