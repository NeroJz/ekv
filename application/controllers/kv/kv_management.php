<?php
class Kv_management extends MY_Controller {
	
	function __construct() 
	{
		parent::__construct();
		
		$this->load->library('grocery_CRUD');
	}
	
	function index()
	{
				
		$crud = new grocery_CRUD();	

		$crud->set_theme('flexigrid');
		$crud->set_subject('Kolej Vokasional');
		$crud->set_table('college');
		
		//$crud->set_relation('id_pelajar','level','kursus_id','kursus','kursus_kluster');
		
		//$crud->set_relation_n_n('Kursus', 'level', 'kursus', 'id_pelajar', 'kursus_id', 'kursus_kluster');
		
		$output = $crud->render();

		$this->_main_output($output);
	}	
	
	function _main_output($output = null)
	{
		//$this->load->view('main.php',$output);
		
		$this->load->view('main.php', $output);	
	}
}

?>