<?php
class Alert extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('m_alert');
		$this -> load -> library('grocery_CRUD');
	}

	function _main_output($output = null, $header = null) {
		//$this->load->view('main.php',$output);
		if($header!=null){
			$output -> output = $header . $output -> output;
		}
		//$this -> load -> view('CRUD/v_course.php', $output);
		$this -> load -> view('main.php', $output);
	}

	function index() {
		$this -> main();
	}
	
	function main(){
		$user_id=$this->session->userdata('user_id');
		$ul_id=$this->m_alert->get_ulid_by_userid($user_id);
		$end_date=$this->m_alert->get_enddate($ul_id);
		
		$data=array();
		//$result_check=array();
		$output=array();
		foreach ($end_date as $key) {
			$result_check=$this->check_notification($key['end_date_user']);
			if($result_check==1){
				$data["message"]="warning";
				$this->load->view("alert/v_alert",$data);
			}elseif($result_check==-1){
				$data["message"]="failed";
				$this->load->view("alert/v_alert",$data);
			}else{
				$data["message"]="normal";
				$this->load->view("alert/v_alert",$data);
			}
		}

		//$this->_main_output($output);
	}
		
	function check_notification($end_date){
		$oneday=24*60*60;
		$today=strtotime(date('Y-m-d'));
		$notification_start=($end_date-($oneday*2));
		$notification_stop=$end_date+$oneday;
		if($today>$notification_start && $today<$notification_stop){
			//display notification
			return 1;
		}elseif($today>($end_date+$oneday) && $today<($end_date+($oneday*2))){
			//dh lepas tarikh luput
			return -1;
		}else{
			return 0;
		}
	}
}
?>