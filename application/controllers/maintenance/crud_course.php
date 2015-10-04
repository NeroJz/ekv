<?php

class Crud_course extends MY_Controller{
	function __construct(){
		parent::__construct();
		
		$this->load->model('m_extkursus');
	}
	function _main_output($output = null, $header = ''){
		$this -> load -> view('main.php', $output);
	}
	function index(){
		$user_login = $this->ion_auth->user()->row();
		$heading = array(
			'Cou Code',
			'Kod Kursus',
			'Nama Kursus',
			'Kluster Kursus',
			'Tindakan'
		);
		
		//load datatable amtis
		$this->load->library("datatables_amtis");
		$dtAmt = $this->datatables_amtis;
		$dtAmt->set_heading($heading);
		
		$aConfigDt['aoColumnDefs'] = '[
			{ "sWidth": "5%", "aTargets": [ 0 ] },
			{ "sWidth": "5%", "aTargets": [ 1 ] },
            { "sWidth": "20%", "aTargets": [ 2 ] },
            { "sWidth": "20%", "aTargets": [ 3 ] },
            { "sWidth": "10%", "aTargets": [ 4 ] }                     
        ]';
		$aConfigDt['bSort'] = 'true';
		$aConfigDt['aaSorting'] = '[[ 3, "asc"]]';
		$dtAmt->setConfig($aConfigDt);
		$data['datatable'] = $dtAmt->generateView(site_url('maintenance/crud_course/ajaxdata_search_pengguna'),'tblKursus');
		
		
		$output['output'] = $this -> load -> view('maintenance/v_course_content', $data, true);
		$this -> _main_output($output, null);
	}
	
	function ajaxdata_search_pengguna(){
		// load datatable amtis
		$this->load->library("datatables_amtis");
		$dtAmt = $this->datatables_amtis;
		$dtAmt
		->select('cou_id, cou_code, cou_course_code, cou_name, cou_cluster')
        ->from('course');
		$dtAmt->add_column('Tindakkan', '$1',"checkOptions(Kursus, cou_id)");
		
		
		$dtAmt->unset_column('cou_id');
		//$dtAmt->unset_column('cou_code');
		
		echo $dtAmt->generate();
	}
	
	function view($id){
		$data['result'] = $this->m_extkursus->get($id);
		
		var_dump($data['result']);
	}

	function insert(){
		$cou_code = $this->input->post('cou_code');
		$cou_course_code = $this->input->post('cou_course_code');
		$cou_name = $this->input->post('cou_name');
		$cou_cluster = $this->input->post('cou_cluster');
		
		$data = array(
			'cou_code' => $cou_code,
			'cou_course_code' => $cou_course_code,
			'cou_name' => $cou_name,
			'cou_cluster' => $cou_cluster
		);
		
		$result = $this->m_extkursus->insert($data);
		echo $result;
	}
	
	function update(){
		$cou_code = $this->input->post('cou_code');
		$cou_course_code = $this->input->post('cou_course_code');
		$cou_name = $this->input->post('cou_name');
		$cou_cluster = $this->input->post('cou_cluster');
		
		$data = array(
			'cou_code' => $cou_code,
			'cou_course_code' => $cou_course_code,
			'cou_name' => $cou_name,
			'cou_cluster' => $cou_cluster
		);
		
		$id = $this->input->post('cou_id');
		
		$result = $this->m_extkursus->update($data, $id);
		
		echo $result;
		
	}
	
	function delete(){
		$id = $this->input->post('cou_id');
		$result = $this->m_extkursus->delete($id);
		echo $result;
	}
}
