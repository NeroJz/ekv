<?php
class Crud_module extends MY_Controller {

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
		$this -> search_module();
	}

	function search_module() {
		$crud = new grocery_CRUD();

		$crud -> set_theme('flexigrid');
		$crud -> set_subject('Module');

		$crud -> set_table('module');
		$crud->set_relation_n_n('Course','course_module','course','mod_id','cou_id','cou_name');
		//$crud->field_type('course','dropdown',array($this->callback_course()));
		$crud->callback_add_field('Course',array($this,'callback_course'));

		$output = $crud->render();
		
		$this->_main_output($output, null);
	}
	
	function callback_course(){
		$result=$this->m_general->get_course_list();
		
		/*FOR DEBUG PURPOSE
		echo "<pre>";
		print_r($result);
		echo "</pre>";
		 */
		 
		$select_cou="<select>";
		foreach ($result as $key) {
			$select_cou.="<option value='".$key->cou_name."'>".$key->cou_name."</option>";
		}
		
		$select_cou.="</select>";
		return $select_cou;
	}
}
?>