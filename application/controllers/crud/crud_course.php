<?php
class Crud_course extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('m_general');
		$this -> load -> model('m_options');
		$this -> load -> library('grocery_CRUD');
	}

	function _main_output($output = null, $header = '') {
		//$this->load->view('main.php',$output);
		$output -> output = $header . $output -> output;
		//$this -> load -> view('CRUD/v_course.php', $output);
		$this -> load -> view('main.php', $output);
		
	}

	function index() {
		$this -> search_course();
	}

	function search_course($cou_id = '') {
		$crud = new grocery_CRUD();

		$crud -> set_theme('flexigrid');
		$crud -> set_subject('Course');
		
		$crud->set_rules('cou_name','Code code','trim|required|exact_length[1]|alpha');
		$crud->set_rules('cou_code','Course Code','trim|required|exact_length[3]|alpha|is_unique[course.cou_code]');
		$crud->set_rules('cou_type','Course Type','trim|required|is_unique[course.cou_type]');
		$crud->set_rules('cou_cluster','Course Cluster','trim|required');
		
		$crud->display_as('cou_name','Code code');
		$crud->display_as('cou_code','Course Code');
		$crud->display_as('cou_type','Course Type');
		$crud->display_as('cou_cluster','Course Clustear');

		$crud -> set_table('course');

		$output = $crud->render();
		
		$this->_main_output($output, null);
	}
}
?>