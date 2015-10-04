<?php
/**************************************************************************************************
 * Description		: Class for announcement. All database operation involving announcement will be
 * 					  created here.
 *					: operation for the module to work
 * Author			: Ku Ahmad Mudrikah Ku Mukhtar
 * Date				: 10 July 2013
 * Input Parameter	: -
 * Modification Log	: -
 **************************************************************************************************/
class Announcement extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> model('m_announcement');
		$this -> load -> library('grocery_CRUD');
		$this -> load -> library('table');
		
		//adding new model - author: Jz
		$this->load->model('m_ext_announcement');
		$this->load->model('m_ext_announcement_college');
		$this->load->model('m_management');
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
		//Previous CRUD display
		#$this -> main();
		
		//Latest CRUD display
		$this->crud_display();
	}

	function main_datatable(){
		$user_login = $this->ion_auth->user()->row();
		$colid = $user_login->col_id;
		$userId = $user_login->user_id;
		$state_id= $user_login->state_id;

		$user_groups = $this->ion_auth->get_users_groups($userId)->row();
		$ul_type= $user_groups->ul_type;
		$user_id = $this->session->userdata('user_id');

		if($ul_type=='LP'){
			echo $ul_type;
			$query_result=$this->m_announcement->get_ann_table()->result();
		}elseif ($ul_type=='KV') {
			echo $ul_type;
			$query_result=$this->m_announcement->get_ann_table($colid)->result();
		}

		# old code...
		$output= new stdClass;
		$data=null;
		$i=1;
		// $query_result=$this->m_announcement->get_ann_table()->result();
		$tmpl['table_open']="<table id='table_ann' class=''>";
		$this->table->set_template($tmpl);
		$this->table->set_heading('Bil','Perkara','Pengumuman','Tarikh Mula','Tarikh Akhir','Status','Pengguna','Tindakan');
		foreach ($query_result as $key) {
			if(strlen($key->ann_content)>150){
				$ann_content='';
			}else{
				$ann_content=$key->ann_content;
			}

			$this->table->add_row(
				$i++,
				$key->ann_title,
				$ann_content,
				$key->ann_open_date,
				$key->ann_close_date,
				$key->user_id,
				$key->ann_status,
				"<a>Edit</a>"
			);
		}
		$data['table']=$this->table->generate();
		$output->output=$this->load->view("maintenance/v_announcement",$data,true);
		$this->_main_output($output);
	}
	
	function main(){
		$user_login = $this->ion_auth->user()->row();
		$colid = $user_login->col_id;
		$userId = $user_login->user_id;
		$state_id= $user_login->state_id;

		$user_groups = $this->ion_auth->get_users_groups($userId)->row();
		$ul_type= $user_groups->ul_type;
		$user_id = $this->session->userdata('user_id');
		
		
		$crud=new grocery_CRUD();
		$crud->set_table('announcement');
		$crud->set_subject('pengumuman');
		$crud->unset_delete();
		$crud->callback_delete(array($this,'delete_ann'));
		$crud->unset_columns('ann_status_push');
		
		if($ul_type=='KV'){
			$crud->set_primary_key('ann_id','announcement_college');
			$crud->set_relation('user_id', 'user', 'user_name');
			$crud->set_relation('ann_id', 'announcement_college', 'col_id');
			$crud->set_relation_n_n('Kolej', 'announcement_college', 'college', 'ann_id', 'col_id', 'col_name');
			// $crud->callback_add_field('Kolej',array($this,'add_field_kolej'));
			$crud->callback_after_insert(array($this, 'insert_announcement_college'));
			$crud->field_type('ann_open_date', 'date');
			$crud->field_type('ann_close_date', 'date');
			$crud->field_type('user_id', 'hidden',$userId);
            $crud->field_type('ann_status_push', 'hidden',1);
			$crud->field_type('ann_status','dropdown',
	            array('1' => 'Aktif', '0' => 'Tak Aktif'));
			
			$crud->display_as('ann_title','Perkara')
				->display_as('ann_id','Id')
				->display_as('ann_content','Pengumuman')
				->display_as('ann_open_date','Tarikh Mula')
				->display_as('ann_close_date','Tarikh Akhir')
				->display_as('ann_status','Status Pengumuman')
				->display_as('user_id','Pengguna')
				->display_as('college','Kolej Vokasional');
				
			// $crud->callback_field('ann_title',array($this,'fc_ann_tite')); - FDP
			// $crud->callback_field('ann_content',array($this,'fc_ann_content')); - FDP
			// $crud->callback_field('ann_open_date',array($this,'fc_ann_open_date')); - FDP
			// $crud->callback_field('ann_close_date',array($this,'fc_ann_close_date')); - FDP
			// $crud->callback_field('ann_status',array($this,'fc_ann_status')); - FDP
			// $crud->callback_field('college',array($this,'fc_college')); - FDP
			
			$crud->where('j7f822d59.col_id',$colid);
			$crud->unset_fields('Kolej');
			$crud->required_fields('ann_title','ann_content','ann_open_date','ann_close_date','ann_status');
		}elseif($ul_type=='LP'){
			$crud->set_relation('user_id', 'user', 'user_name');
			$crud->set_relation_n_n('Kolej', 'announcement_college', 'college', 'ann_id', 'col_id', 'col_name');
			$crud->callback_after_insert(array($this, 'insert_announcement_college'));
			$crud->field_type('ann_open_date', 'date');
			$crud->field_type('ann_close_date', 'date');
			$crud->field_type('user_id', 'hidden',$user_id);
            $crud->field_type('ann_status_push', 'hidden',1);
			$crud->field_type('ann_status','dropdown',
	            array('1' => 'Aktif', '0' => 'Tak Aktif'));
			
			$crud->display_as('ann_title','Perkara')
				->display_as('ann_content','Pengumuman')
				->display_as('ann_open_date','Tarikh Mula')
				->display_as('ann_close_date','Tarikh Akhir')
				->display_as('ann_status','Status Pengumuman')
				->display_as('user_id','Pengguna')
				->display_as('college','Kolej Vokasional');
			
			// $crud->callback_field('ann_title',array($this,'fc_ann_tite')); - FDP
			// $crud->callback_field('ann_content',array($this,'fc_ann_content')); - FDP
			// $crud->callback_field('ann_open_date',array($this,'fc_ann_open_date')); - FDP
			// $crud->callback_field('ann_close_date',array($this,'fc_ann_close_date')); - FDP
			// $crud->callback_field('ann_status',array($this,'fc_ann_status')); - FDP
			// $crud->callback_field('college',array($this,'fc_college')); - FDP
			
			$crud->required_fields('ann_title','ann_content','ann_open_date','ann_close_date','ann_status');
		}
		$output=$crud->render();
		$js='<script>$(document).ready(function() 
			{
				$("#addStudent").validationEngine();
			});</script>';
		$header=$js."<legend><h3>Penyenggaraan Pengumuman</h3></legend>";
		
		$this->_main_output($output,$header);
	}

	function delete_ann($primary_key){
		$tables = array('announcement_college', 'announcement');
		$this->db->where('ann_id', $primary_key);
		return $this->db->delete($tables);
	}

	function fc_ann_tite($value = '', $primary_key = null){
		return '<input id="field-ann_title" name="ann_title" type="text" value="" maxlength="200" class="validate[required] text-input">';
	}

	function fc_ann_content($value = '', $primary_key = null){
		return '<textarea id="field-ann_content" name="ann_content" class="texteditor validate[required] text-input" style="visibility: hidden; display: none;"></textarea>';
	}

	function fc_ann_open_date($value = '', $primary_key = null){
		return '<input id="field-ann_open_date" name="ann_open_date" type="date" value="" maxlength="10" class="datepicker-input hasDatepicker validate[required] text-input">';
	}

	function fc_ann_close_date($value = '', $primary_key = null){
		return '<input id="field-ann_close_date" name="ann_close_date" type="date" value="" maxlength="10" class="datepicker-input hasDatepicker validate[required] text-input">';
	}
	
	function fc_ann_status(){
		
	}
	
	function fc_college(){
		
	}

	function insert_announcement_college($post_array,$primary_key){
		$user_login = $this->ion_auth->user()->row();
		$colid = $user_login->col_id;
		
		if(isset($colid)){
		    $insert = array(
		        "col_id" => $colid,
		        "ann_id" => $primary_key
		    );
		}else{
		    $insert = array(
		        "col_id" => 0,
		        "ann_id" => $primary_key
		    );
		}
	 
	    $this->db->insert('announcement_college',$insert);
	 
	    return true;
	}

	function add_field_kolej(){
		$user_login = $this->ion_auth->user()->row();
		$colid = $user_login->col_id;
    	return '<input type="hidden" value="'.$colid.'" name="Kolej[]" readonly>';
	}
	
	function check_announcement(){//COMMENT OUT THIS FUNCTION (NOTE:KU)
		$user_id = $this->session->userdata('user_id');
		
		$result=$this->m_announcement->get_announcement_details($user_id);
		$this->load->view('announcement/v_announcement');
	}

	function test(){
		$datestring = "%Y-%m-%d";
		$time = time();
	
		$ku_date=mdate($datestring, $time);
		
		$this->db->select("*");
		$this->db->from("announcement");
		$query=$this->db->get();
		foreach ($query->result() as $row) {
			if($row->ann_open_date<$ku_date){
				echo "true<br>";
			}else echo "false<br>";
		}
		
		echo "<br>";
		echo "<br>";
	}
	
	function display_full(){
		$ann_id = $this->input->post("annId");
		$result=$this->m_announcement->get_announcement_by_id($ann_id);
		$data=$result[0];
		$this->load->view('announcement/v_announcement_full',$data);
	}
	
	/*********************************************************************
	 * Description		: 	Start adding new functions from here
	 * Author			: 	Jz
	 * Date				:	15-04-2013
	 * Functions		:	crud_display(),ajaxdata_generate_announcement()
	 * Modification-log	:	-
	 *********************************************************************/
	 function crud_display(){
	 	$user_login = $this->ion_auth->user()->row();
		$user_id = $user_login->user_id;
		$id_pusat = $user_login->col_id;
		
		//check user is admin lp
		$admin = $this->m_management->get_user_position($user_id);
		$admin = $admin->result_array();
		$admin = $admin[0];
		
	 	$heading = array(
			'Perkara',
			'Pengumuman',
			'Tarikh Mula',
			'Tarikh Akhir',
			'Status',
			'Pengguna',
			'Kolej',
			'Tindakan'
		);
		
		//load datatable amtis
		$this->load->library("datatables_amtis");
		$dtAMT = $this->datatables_amtis;
		$dtAMT->set_heading($heading);
		
		$aConfigDt['aoColumnDefs'] = '[
			{ "sWidth": "10%", "aTargets": [ 0 ] },
			{ "sWidth": "20%", "aTargets": [ 1 ] },
            { "sWidth": "10%", "aTargets": [ 2 ] },
            { "sWidth": "10%", "aTargets": [ 3 ] },
            { "sWidth": "8%", "aTargets": [ 4 ] },
            { "sWidth": "10%", "aTargets": [ 5 ] },
            { "sWidth": "10%", "aTargets": [ 6 ] },
            { "sWidth": "10%", "aTargets": [ 7 ] }                   
        ]';
		
		$aConfigDt['bSort'] = 'true';
		$aConfigDt['aaSorting'] = '[[ 2, "asc"]]';
		
		$dtAMT->setConfig($aConfigDt);
		
		$datatable = $dtAMT->generateView(site_url('maintenance/announcement/ajaxdata_generate_announcement'),'tblAnouncement',true);
		$data = $datatable;
		$data['col_id'] = $id_pusat;
		$data['user_id'] = $user_id;
		//if user is admin lp, get all the kolej list
		if($admin['ul_id'] == 1){
			$data['kolej'] = $this->m_management->get_all_college();
		}
	 	$output['output'] = $this->load->view('maintenance/v_announcement_maintenance.php',$data,true);
	 	$this->_main_output($output);
	 }
	/*********************************************************************
	 * Description		: 	This function use to generate datatable
	 * Author			: 	Jz
	 * Date				:	15-04-2013
	 * Modification-log	:	-
	 *********************************************************************/
	function ajaxdata_generate_announcement(){
		$user_login = $this->ion_auth->user()->row();
		$id_pusat = $user_login->col_id;
		
		
		$this->load->library("datatables_amtis");
		$dtAMT = $this->datatables_amtis;
		$dtAMT
		->select('announcement.ann_id, announcement.ann_title, announcement.ann_content, announcement.ann_open_date, 
		announcement.ann_close_date, announcement.ann_status, user.user_name, GROUP_CONCAT(college.col_name) as col_name')
		->from('announcement')
		->join('user','user.user_id = announcement.user_id')
		->join('announcement_college','announcement_college.ann_id = announcement.ann_id')
		->join('college','college.col_id = announcement_college.col_id','left');
		
		if($id_pusat != 0){
			$dtAMT->where('college.col_id',$id_pusat);
		}
		$dtAMT->group_by('announcement.ann_id');
		$dtAMT->edit_column('announcement.ann_content','$1',"formatNewsDisplay(announcement.ann_content)");
		$dtAMT->edit_column('announcement.ann_status','$1',"formatStatMod(announcement.ann_status)");
		$dtAMT->edit_column('college.col_name','$1','formatCollegeName(col_name)');
		
		$dtAMT->add_column('Tindakan', '$1',"checkOptions('Pengumuman', announcement.ann_id)");
		
		$dtAMT->unset_column('announcement.ann_id');
		echo $dtAMT->generate();
	}
	/*********************************************************************
	 * Description		: 	This function uses get the info from table
	 * 						announcement, announcement_college
	 * Author			: 	Jz
	 * Date				:	15-04-2013
	 * Functions		:	crud_display(),ajaxdata_generate_announcement()
	 * Modification-log	:	-
	 *********************************************************************/
	function callback_edit(){
		$user_login = $this->ion_auth->user()->row();
		$user_id = $user_login->user_id;
		$id_pusat = $user_login->col_id;
		
		//check user is admin lp
		$admin = $this->m_management->get_user_position($user_id);
		$admin = $admin->result_array();
		$admin = $admin[0];
		
		
		$ann_id = $this->input->post('ann_id');
		$filters = array(
			'ann_id' => $ann_id
		);
		
		$result_ann = $this->m_ext_announcement->get_filters($filters,'ann_content');
		$result_colID = $this->m_ext_announcement_college->get_filters($filters,'col_id');
		
		$colIDs = array();
		
		if(!empty($result_colID)){
			foreach($result_colID as $row){
				$colIDs[] = $row->col_id;
			}
		}
		
		if(!empty($result_ann)){
			$ann_content = $result_ann[0]->ann_content;
		}else{
			$ann_content = "";
		}
		
		$result['colIDs'] = $colIDs;
		$result['ann_content'] = $ann_content;
		$result['user_level'] = $admin['ul_id'];
		echo json_encode($result);
	}
	/*********************************************************************
	 * Description		: 	This function uses to add new record to table
	 * 						announcement, announcement_college
	 * Author			: 	Jz
	 * Date				:	15-04-2013
	 * Modification-log	:	-
	 *********************************************************************/
	function insert(){
		$user_login = $this->ion_auth->user()->row();
		$user_id = $user_login->user_id;
		$id_pusat = $user_login->col_id;
		
		//check user is admin lp
		$admin = $this->m_management->get_user_position($user_id);
		$admin = $admin->result_array();
		$admin = $admin[0];
		
		$ann_title = $this->input->post('ann_title');
		$ann_content = $this->input->post('ann_content');
		$ann_open_date = $this->input->post('ann_open_date');
		$ann_close_date = $this->input->post('ann_close_date');
		$ann_status = $this->input->post('ann_status');
		$user_id = $this->input->post('user_id');
		$ann_status_push = 1;
		
		
		$data =	array(
			'ann_title' => $ann_title,
			'ann_content' => $ann_content,
			'ann_open_date' => $ann_open_date,
			'ann_close_date' => $ann_close_date,
			'ann_status' => $ann_status,
			'user_id' => $user_id,
			'ann_status_push' => $ann_status_push
		);
		
		$ann_id = $this->m_ext_announcement->return_insert_id($data);
		
		if($ann_id){
			if($admin['ul_id'] == 1){
				$col_id = $this->input->post('colIDs');
				if(is_array($col_id)){
					foreach($col_id as $col){
						$data_ann_col = array(
							'ann_id' => $ann_id,
							'col_id' => $col
						);
						$result = $this->m_ext_announcement_college->insert($data_ann_col);
					}
					echo TRUE;
				}else{
					$data_ann_col = array(
						'ann_id' => $ann_id,
						'col_id' => 0
					);
					$result = $this->m_ext_announcement_college->insert($data_ann_col);
					echo TRUE;
				}
			}else{
				$col_id = $this->input->post('col_id');
				$data_ann_col = array(
					'ann_id' => $ann_id,
					'col_id' => $col_id
				);
				
				$result_ann_col = $this->m_ext_announcement_college->insert($data_ann_col);
				
				if($result_ann_col){
					echo TRUE;
				}else{
					echo FALSE;
				}
			}
			
		}else{
			echo FALSE;
		}
	}
	/*********************************************************************
	 * Description		: 	This function uses to update record in
	 * 						announcement, announcement_college
	 * Author			: 	Jz
	 * Date				:	15-04-2013
	 * Modification-log	:	-
	 *********************************************************************/
	function update(){
		$user_login = $this->ion_auth->user()->row();
		$user_id = $user_login->user_id;
		$id_pusat = $user_login->col_id;
		
		//check user is admin lp
		$admin = $this->m_management->get_user_position($user_id);
		$admin = $admin->result_array();
		$admin = $admin[0];
		
		//if the current login user is not adminlp update the table announcement
		$ann_id = $this->input->post('ann_id');
		$ann_title = $this->input->post('ann_title');
		$ann_content = $this->input->post('ann_content');
		$ann_open_date = $this->input->post('ann_open_date');
		$ann_close_date = $this->input->post('ann_close_date');
		$ann_status = $this->input->post('ann_status');
			
		$data = array(
			'ann_title' => $ann_title,
			'ann_content' => $ann_content,
			'ann_open_date' => $ann_open_date,
			'ann_close_date' => $ann_close_date,
			'ann_status' => $ann_status
		);
			
		$result = $this->m_ext_announcement->update($data,$ann_id);
		
		if($admin['ul_id'] == 1){
			$old_records = array(
				'ann_id' => $ann_id
			);
			
			$delete_ext_records = $this->m_ext_announcement_college->delete_filters($old_records);
			
			if($delete_ext_records){
				$col_id = $this->input->post('colIDs');
				if(is_array($col_id)){
					foreach($col_id as $col){
						$data_ann_col = array(
							'ann_id' => $ann_id,
							'col_id' => $col
						);
						$result = $this->m_ext_announcement_college->insert($data_ann_col);
					}
					echo TRUE;
				}else{
					$data_ann_col = array(
						'ann_id' => $ann_id,
						'col_id' => 0
					);
					$result = $this->m_ext_announcement_college->insert($data_ann_col);
					echo TRUE;
				}
			}
			
		}else{
			if($result){
				echo TRUE;
			}else{
				echo FALSE;
			}
		}
	}





}
?>