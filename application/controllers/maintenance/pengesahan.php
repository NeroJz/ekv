<?php
/**************************************************************************************************
 * Description		: Class for Pengesahan. All operations involving Pengesahan will be
 * 					  done here.
 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
 * Date				: 13 November 2013
 * Input Parameter	: -
 * Modification Log	: -
 **************************************************************************************************/
class Pengesahan extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('m_announcement');
		$this -> load -> library('grocery_CRUD');
		$this -> load -> library('table');
	}

	function _main_output($output = null, $header = null) {
		if($header!=null){
			$output -> output = $header . $output -> output;
		}
		$this -> load -> view('main.php', $output);
	}

	/**************************************************************************************************
	* Description		: Index function to direct users to a specific function
	* Author			: Ku Ahmad Mudrikah
	* Date				: 13 November 2013
	* Input Parameter	: -
	* Modification Log	: -
	**************************************************************************************************/
	function index() {
		$output=new stdClass;
		$exist=$this->input->get('exist');

		$tmpl['table_open']="<table class='table table-bordered table-striped'>";
		$this->table->set_template($tmpl);
		$this->table->set_heading('Tahun','Sesi','Tarikh','Tindakan');

		$this->db->select('*');
		$this->db->from('register_schedule');
		$this->db->order_by("rs_id", "desc");
		$this->db->limit(10);
		$query=$this->db->get();
		$result=$query->result();

		if($query->num_rows()>0){
			foreach ($result as $key) {
				$delete='<a href="'.site_url('/maintenance/pengesahan/delete/'.$key->rs_id).'"><i class="icon-trash"></i></>';
				$this->table->add_row($key->rs_tahun,$key->rs_sesi,date_format_toggle($key->rs_close_date),$delete);
			}
		}else{
			$cell = array('data' => '<center>Tiada Data</center>','colspan' => 4);
			$this->table->add_row($cell);
		}

		$data['table']=$this->table->generate();
		$output->output=$this->load->view("maintenance/v_pengesahan",$data,true);
		if($exist=='true'){
			$output->output.=$this->load->view("maintenance/v_data_existed",'',true);
		}
		$this->_main_output($output);
	}

	function simpan(){
		$data=array(
			'rs_tahun'=>$this->input->post('tahun'),
			'rs_sesi'=>$this->input->post('sesi'),
			'rs_close_date'=>date_format_toggle($this->input->post('tarikh'))
		);

		$this->db->from('register_schedule');
		$this->db->where('rs_sesi',$data['rs_sesi']);
		$this->db->where('rs_tahun',$data['rs_tahun']);
		$query=$this->db->get();
		// echo $this->db->last_query();

		if($query->num_rows()>0){
			redirect(site_url('/maintenance/pengesahan?exist=true'),'refresh');
		}else{
			$this->db->insert('register_schedule',$data);

			$title='Tarikh Tutup Pengesahan Pendaftaran';
			$content='Tarikh tutup bagi Pengesahan Pendaftaran Murid bagi sesi '.$data['rs_sesi'].' tahun '.$data['rs_tahun'].' ialah pada '.date_format_toggle($data['rs_close_date']).'.';
			$open_date=date('Y-m-d');
			$close_date=date('Y-m-d',strtotime('+10 days'));
			$status=1;
			$kv_id=array(0);
			add_announcement($title,$content,$open_date,$close_date,$status,$kv_id);
		}

		redirect(site_url('/maintenance/pengesahan'),'refresh');
	}

	function delete($id){
		$this->db->where('rs_id', $id);
		$this->db->delete('register_schedule');
		redirect(site_url('/maintenance/pengesahan'),'refresh');
	}
}
?>