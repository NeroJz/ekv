<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends MY_Controller {

	function __construct() 
	{
		parent::__construct();
		$this->load->model('m_kv');
		$this->load->model('m_result');
		$this->load->library('grocery_CRUD');
	}
	
	function index()
	{
		$this->load->library("table");
		$user_login = $this->ion_auth->user()->row();
		$colid = $user_login->col_id;
		$userId = $user_login->user_id;
		$state_id= $user_login->state_id;

		$user_groups = $this->ion_auth->get_users_groups($userId)->row();  
		$id= $user_groups->id;

		$this->get_menu($menu,$id);
		// echo "<pre>";
		// print_r($menu);
		// echo "</pre>";
		$data['menu']=$menu;

		$dashboard['data']=display_announcement();
				
		$data['output'] = $this->load->view('dashboard/v_index', $dashboard, true);
		//$data['output'] = $this->load->view('report/example', '', true);
		$this->load->view('main.php', $data);	
		//$this->_main_output((object)array('output' => '' , 'js_files' => array() , 'css_files' => array()));
	}

	function check_online(){
		echo "online";
	}	
	
	function _main_output($output = null)
	{
		//$this->load->view('main.php',$output);
		
		$this->load->view('main.php', $output);	
	}
	
	function _statisticStudent()
	{
		$dataStatistic = array();
		return $this->load->view('dashboard/v_statisticStudent', $dataStatistic, true);
	}
	
	function statisticStudent()
	{
	
		$user_login = $this->ion_auth->user()->row();
		$centreCode = $user_login->col_id;
		$userId = $user_login->user_id;
		$state_id= $user_login->state_id;

		  $user_groups = $this->ion_auth->get_users_groups($userId)->row();  
		  $ul_type= $user_groups->ul_type;
		  
		  
		if($ul_type=="LP"){
			
		$data['dataStatistic'] = $this->m_result->statisticStudent($centreCode='');
		$this->load->view('dashboard/v_statisticStudent', $data);
		
		 }elseif($ul_type=="KV"){
			 $data['dataStatistic'] = $this->m_result->statisticStudentbyKvsem($centreCode);
		    $this->load->view('dashboard/v_statisticStudentbyKv', $data);
			
		   }elseif($ul_type=="JPN"){
		   	
			 $data['dataStatistic'] = $this->m_result->statisticStudent($state_id);
		    $this->load->view('dashboard/v_statisticStudent', $data);
			
		}else{
			$data['dataStatistic'] = $this->m_result->statisticStudent($centreCode='');
		    $this->load->view('dashboard/v_statisticStudent', $data);
		}
	}
	
	function paparan()
	{
		$this->session->sess_destroy();
		
		$user = $this->input->post('input01');
		$pass = $this->input->post('input02');
		
		if($user == "akademik" && $pass == "12345")
		{
			$data['kolejvokasional'] = $this->m_kv->kv_list();
			
			$data['view_content'] = $this->load->view('kv/v_kv_info', $data, true);
			$this->load->view('welcome_message', $data);
		}
		elseif($user == "gurubiasa" && $pass == "12345")
		{
			$data['kolejvokasional'] = $this->m_kv->kv_list();
			
			$data['view_content'] = $this->load->view('peperiksaan/lecturesatu', $data, true);
			$this->load->view('welcome_message2', $data);
		}
		else
		{
			$this->load->view('v_login');
		}
	}
	
	function kv_info()
	{
		$kvid = $this->input->post('slct_nama');
		
		$data['kolejvokasional'] = $this->m_kv->kv_list();
		$data['plh_kolej'] = $this->m_kv->choose_kv($kvid);
		$data['jumlahmurid'] = $this->m_kv->jumlah_murid($kvid);
        $data['view_content'] = $this->load->view('kv/v_kv_info', $data, true);
        $this->load->view('welcome_message', $data);
	}

	function get_menu(&$menu,$ul_id,$parent_id=null){
		$this->db->select('*');
		$this->db->from('menu_ul');
		$this->db->join('menu','menu_ul.menu_id = menu.menu_id');
		$this->db->where('menu.parent_id',$parent_id);
		if($ul_id>-1){
			$this->db->where('menu_ul.ul_id',$ul_id);
		}
		$this->db->group_by('menu.menu_item');
		$this->db->order_by('menu.menu_order','asc');
		$data = $this->db->get();

		if($data->num_rows()>0){
			foreach ($data->result() as $row) {
				//print_r($row);
				$menu[$row->menu_id]=$row;
				$menu[$row->menu_id]->children=array();
				$this->get_menu($menu[$row->menu_id]->children,$ul_id,$row->menu_id);
			}
		}
	}
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */