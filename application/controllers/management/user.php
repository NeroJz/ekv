<?php
/**************************************************************************************************
* File Name        : user.php
* Description      : This file is used for manage user
* Author           : Jz
* Date             : 14 March 2014
* Version          : 0.1
* Modification Log : 
* Function List	   : __construct(), index(), display_update_user(), update_info(), getDropMenu()
*					 _main_output(), user_register(), getCheckbox(), add_user(), delete_usergroup()
*                   update_usergroup(), add_usergroup()
**************************************************************************************************/
class User extends MY_Controller{
	
	function __construct(){
		parent::__construct();
		
		$this->load->model('m_user');
		$this->load->model('m_general');
		$this->load->helper('date');
		$this->load->model('m_management');
		$this->load->library('table');
	}
	
	function index(){
		$user_login = $this->ion_auth->user()->row();
		$id_pusat = $user_login->col_id;
		$id_negeri = $user_login->state_id;
		
		//table heading
		$tbl_heading = array(
			'Nama Pengguna',
			'Username',
			'Email',
			'Tarikh Daftar',
			'Tarikh Log Masuk',
			'Status',
			'Kolej',
			'No. Telefon',
			'Negeri',
			'Jawatan',
			'Tindakan'
		);
		
		//load datatable amtis
		$this->load->library("datatables_amtis");
		$dtAmt = $this->datatables_amtis;
		$dtAmt->set_heading($tbl_heading);
		
		 $aConfigDt['aoColumnDefs'] = '[
                                     { "sWidth": "20%", "aTargets": [ 0 ] },
                                     { "sWidth": "8%", "aTargets": [ 1 ] },
                                     { "sWidth": "8%", "aTargets": [ 2 ] },
                                     { "sWidth": "7%", "aTargets": [ 3 ] },
                                     { "sWidth": "7%", "aTargets": [ 4 ] },
                                     { "sWidth": "8%", "aTargets": [ 5 ] },
                                     { "sWidth": "8%", "aTargets": [ 6 ] },
                                     { "sWidth": "8%", "aTargets": [ 7 ] },
									 { "sWidth": "8%", "aTargets": [ 8 ] },
									 { "sWidth": "8%", "aTargets": [ 9 ] },
									 { "sWidth": "10%", "aTargets": [ 10 ] }
                            ]';
        $aConfigDt['bSort'] = 'true';
        $aConfigDt['aaSorting'] = '[[ 8, "asc"],[ 6, "asc"],[ 0, "asc"]]';
		$dtAmt->setConfig($aConfigDt);
		
		$data['datatable'] = $dtAmt->generateView(site_url('management/user/ajaxdata_search_pengguna'),'tblPengguna');
		
		$output['output']=$this->load->view('management/v_user_management2',$data,true);
		
		$this->_main_output($output);
	}

	function ajaxdata_search_pengguna(){
		$user_login = $this->ion_auth->user()->row();
		$id_pusat = $user_login->col_id;
		
		// load datatable amtis
		$this->load->library("datatables_amtis");
		$dtAmt = $this->datatables_amtis;
		$dtAmt
		->select('user.user_id, user.user_name, user.user_username, user.user_email, 
		user.created_on, user.last_login, user.active, college.col_name, user.phone, state.state, GROUP_CONCAT(user_level.ul_name) as ul_name')
        ->from('user')
        ->join('college','college.col_id = user.col_id')
        ->join('state','state.state_id = college.state_id')
        ->join('user_group','user_group.user_id = user.user_id')
		->join('user_level','user_level.ul_id = user_group.ul_id');
		
		if($id_pusat != 0){
			$dtAmt->where('user.col_id',$id_pusat);
		}

		$dtAmt->group_by('user.user_id');
		$dtAmt->add_column('Tindakkan', '$1',"checkAction('management/user/display_update_user/', user.user_id)");
		
		$dtAmt->edit_column('user.created_on','$1',"strtotime_convert_to_date(user.created_on)");
		$dtAmt->edit_column('user.last_login','$1',"strtotime_convert_to_date(user.last_login)");
		$dtAmt->edit_column('user.active', '$1',"formatUserStatus(user.active)");
		
		$dtAmt->unset_column('user.user_id');
		echo $dtAmt->generate();
	}
	
	/**
	* this function is go to display update page of user
	* author: Jz
	* input: $id - user_id
	* Date: 18 March 2014
	*/
	function display_update_user($id){
		$user_login = $this->ion_auth->user()->row();
		$user_id = $user_login->user_id;
		
		//check role of current login user
		$logged_user = $this->m_management->get_user_position($user_id,TRUE);
		$logged_user = $logged_user->result_array();
		$logged_user = $logged_user[0];
		$data['addDropbox'] = $this->getDropMenu($logged_user['ul_name'],$logged_user['ul_id']);
		
		$pengguna = $this->m_management->get_director_by_user_id($id);
		$pengguna = $pengguna->result_array();
		$pengguna = $pengguna[0];
		
		$state = $this->m_management->get_collge_state($pengguna['state_id']);
		$state = $state->result_array();
		$state = $state[0];
		
		$position = $this->m_management->get_user_position($id);
		$position = $position->result_array();
		
		$jawatan = array();
		foreach($position as $user){
			// print_r($user);
			$jawatan[] = array(
				'slct_box' => $this->getDropMenu($user['ul_name'],$user['ul_id'],$user['ug_id']),
				'ug_id' => $user['ug_id']
			);
		}
		
		$data['jawatan'] = $jawatan;
		$data['pengguna_id'] = $id;
		$data['pengguna_nama'] = strtoupper($pengguna['user_name']);
		$data['pengguna_unama'] = $pengguna['user_username'];
		$data['pengguna_email'] = $pengguna['user_email'];
		$data['pengguna_status'] = $pengguna['active'];
		$data['pengguna_telefon'] = $pengguna['phone'];
		$data['pengguna_state'] = $state['state'];
		$data['pengguna_id'] = $id;
		
		
		$output['output']=$this->load->view("management/v_edit_user",$data,true);
		$this->_main_output($output);
	}
	
	/**
	* this function is update the info of user
	* author: Jz
	* Date: 18 March 2014
	*/
	function update_info(){
		$pengguna_nama = $this->input->post('nama');
		$pengguna_unama = $this->input->post('u_nama');
		$pengguna_email = $this->input->post('email');
		$pengguna_status = $this->input->post('status');
		$pengguna_phone = $this->input->post('telefon');
		$pengguna_id = $this->input->post('user_id');
		
		$data_user = array(
			'user_name' => $pengguna_nama,
			'user_username' => $pengguna_unama,
			'user_email' => $pengguna_email,
			'active' => $pengguna_status,
			'phone' => $pengguna_phone
		);
		
		$this->m_management->update_user_info($pengguna_id,$data_user);
		
		redirect('/management/user');
	}
	
	/**
	* this function is get the drop menu assigned for the user according to position(jawatan)
	* input: $position - jawatan, $ul_id - position id, $ug_id - user_group id
	* author: Jz
	* Date: 18 March 2014
	*/
	function getDropMenu($position = NULL,$ul_id = NULL,$ug_id = NULL){
		$user_login = $this->ion_auth->user()->row();
		$colid = $user_login->col_id;
		$userId = $user_login->user_id;
		$state_id= $user_login->state_id;

		$user_groups = $this->ion_auth->get_users_groups($userId)->row();  
		$ul_name= $user_groups->ul_name;

		$options = array();
		switch ($ul_name) {
			case 'Admin LP':
				$options = array(
					''  => '-Sila Pilih-',
					'1' => 'Admin LP',
					'5' => 'Pengarah',
					'6' => 'Timbalan Pengarah',
					'7' => 'KJPP',
					'8' => 'KUPP',
					'3' => 'Pensyarah'
				);
				break;
			// case 'Pengarah':
			// 	$options = array(
			// 		''  => '-Sila Pilih-',
			// 		'5' => 'Pengarah',
			// 		'6' => 'Timbalan Pengarah',
			// 		'7' => 'KJPP',
			// 		'8' => 'KUPP',
			// 		'3' => 'Pensyarah'
			// 	);
			// 	break;
			// case 'Timbalan Pengarah':
			// 	$options = array(
			// 		''  => '-Sila Pilih-',
			// 		'5' => 'Pengarah',
			// 		'6' => 'Timbalan Pengarah',
			// 		'7' => 'KJPP',
			// 		'8' => 'KUPP',
			// 		'3' => 'Pensyarah'
			// 	);
			// 	break;
			case 'KJPP':
				$options = array(
					''  => '-Sila Pilih-',
					'5' => 'Pengarah',
					'6' => 'Timbalan Pengarah',
					'7' => 'KJPP',
					'8' => 'KUPP',
					'3' => 'Pensyarah'
				);
				break;
			case 'KUPP':
				$options = array(
					''  => '-Sila Pilih-',
					'5' => 'Pengarah',
					'6' => 'Timbalan Pengarah',
					'7' => 'KJPP',
					'8' => 'KUPP',
					'3' => 'Pensyarah'
				);
				break;
		}

		if($ug_id == null){
			$slct_user = "<select name='addNewRole' id='addNewRole'>";
			return form_dropdown('addNewRole', $options,null,"id='addNewRole'");
		}else{
			$slct_user = "<select name='".$ug_id."' id='".$ug_id."' onchange='upadateUserGroup(this);'>";
			return form_dropdown($ug_id, $options,$ul_id,"id='".$ug_id."addNewRole' onchange='upadateUserGroup(this);'");
		}
	}

	/**
	* this function is redirect to user registration page
	* input: -
	* author: Jz
	* Date: 19 March 2014
	*/
	function user_register($typeid = ""){
		$user_login = $this->ion_auth->user()->row();
		$id_negeri = $user_login->state_id;		

		//check user is admin lp
		$admin = $this->m_management->get_user_position($user_login->user_id);
		$admin = $admin->result_array();
		$admin = $admin[0];

		//if user is admin lp, get all the kolej list
		if($admin['ul_id'] == 1){
			$data['kolej'] = $this->m_management->get_all_college();
		}
		
		$user_id = $user_login->user_id;
		$position = $this->m_management->get_user_position($user_id);
		$position = $position->result_array();
		$position = $position[0];
		
		$state = $this -> m_general -> state_list($id_negeri);
		$data['state'] = $state[0]->state;
		$data['state_id'] = $state[0]->state_id;
		$data['col_id'] = $user_login->col_id;
		$data['checkbox'] = $this->getCheckbox($position['ul_name'],$position['ul_id'], $typeid);
		
		$output['output'] = $this->load->view('management/v_user_register',$data,true);
		$this -> load -> view('mainRegisterStudent.php', $output);
	}
	
	/**
	* this function is create user level checkbox for the user registration page
	* input: $position - jawatan, $ul_id - position id
	* author: Jz
	* Date: 19 March 2014
	*/
	function getCheckbox($position, $ul_id, $typeid){
		$chck_user="<span>";
		if("Admin LP"==$position) //kalau user_id sama dengan value
		{
			$chck_user .= "<input type='checkbox' name='user_level[]' value='5'/>Pengarah";
			$chck_user .= "<br/><input type='checkbox' name='user_level[]' class='validate[minCheckbox[1]]' value='7' checked='checked' />KJPP";
		}
		else if("KJPP"==$position) //kalau user_id sama dengan value
		{
			if($typeid == 5)
			{
				$chck_user .= "<input type='checkbox' name='user_level[]' id='chck_pengarah' onclick='disableCheckbox(this);' class='validate[minCheckbox[1]]' value='5' checked='checked'/>Pengarah";
				$chck_user .= "<br/><input type='checkbox' name='user_level[]' id='chck_tmb_pengarah' onclick='disableCheckbox(this);' value='6'/>Timbalan Pengarah";
				$chck_user .= "<br/><input type='checkbox' name='user_level[]' value='7' />KJPP";
				$chck_user .= "<br/><input type='checkbox' name='user_level[]' value='8'/>KUPP";
				$chck_user .= "<br/><input type='checkbox' name='user_level[]' value='3'/>Pensyarah";
			}
			elseif($typeid == 6)
			{
				$chck_user .= "<input type='checkbox' name='user_level[]' id='chck_pengarah' onclick='disableCheckbox(this);' value='5'/>Pengarah";
				$chck_user .= "<br/><input type='checkbox' name='user_level[]' id='chck_tmb_pengarah' onclick='disableCheckbox(this);' class='validate[minCheckbox[1]]' value='6' checked='checked'/>Timbalan Pengarah";
				$chck_user .= "<br/><input type='checkbox' name='user_level[]' value='7' />KJPP";
				$chck_user .= "<br/><input type='checkbox' name='user_level[]' value='8'/>KUPP";
				$chck_user .= "<br/><input type='checkbox' name='user_level[]' value='3'/>Pensyarah";
			}
			else
			{
				$chck_user .= "<input type='checkbox' name='user_level[]' id='chck_pengarah' onclick='disableCheckbox(this);' value='5'/>Pengarah";
				$chck_user .= "<br/><input type='checkbox' name='user_level[]' id='chck_tmb_pengarah' onclick='disableCheckbox(this);' value='6'/>Timbalan Pengarah";
				$chck_user .= "<br/><input type='checkbox' name='user_level[]' class='validate[minCheckbox[1]]' value='7' checked='checked' />KJPP";
				$chck_user .= "<br/><input type='checkbox' name='user_level[]' value='8'/>KUPP";
				$chck_user .= "<br/><input type='checkbox' name='user_level[]' value='3'/>Pensyarah";
			}
			
		}
		else if("KUPP"==$position) //kalau user_id sama dengan value
		{
			if($typeid == 5)
			{
				$chck_user .= "<input type='checkbox' id='chck_pengarah' name='user_level[]' onclick='disableCheckbox(this);' class='validate[minCheckbox[1]]' value='5' checked='checked'/>Pengarah";
				$chck_user .= "<br/><input type='checkbox' id='chck_tmb_pengarah' onclick='disableCheckbox(this);' name='user_level[]' value='6'/>Timbalan Pengarah";
				$chck_user .= "<br/><input type='checkbox' name='user_level[]' value='7' />KJPP";
				$chck_user .= "<br/><input type='checkbox' name='user_level[]' value='8'/>KUPP";
				$chck_user .= "<br/><input type='checkbox' name='user_level[]' value='3'/>Pensyarah";
			}
			elseif($typeid == 6)
			{
				$chck_user .= "<input type='checkbox' id='chck_pengarah' onclick='disableCheckbox(this);' name='user_level[]' value='5'/>Pengarah";
				$chck_user .= "<br/><input type='checkbox' id='chck_tmb_pengarah' onclick='disableCheckbox(this);' name='user_level[]' class='validate[minCheckbox[1]]' value='6' checked='checked'/>Timbalan Pengarah";
				$chck_user .= "<br/><input type='checkbox' name='user_level[]' value='7' />KJPP";
				$chck_user .= "<br/><input type='checkbox' name='user_level[]' value='8'/>KUPP";
				$chck_user .= "<br/><input type='checkbox' name='user_level[]' value='3'/>Pensyarah";
			}
			else
			{
				$chck_user .= "<input type='checkbox' id='chck_pengarah' onclick='disableCheckbox(this);' name='user_level[]' value='5'/>Pengarah";
				$chck_user .= "<br/><input type='checkbox' id='chck_tmb_pengarah' onclick='disableCheckbox(this);' name='user_level[]' value='6'/>Timbalan Pengarah";
				$chck_user .= "<br/><input type='checkbox' name='user_level[]' class='validate[minCheckbox[1]]' value='7' checked='checked' />KJPP";
				$chck_user .= "<br/><input type='checkbox' name='user_level[]' value='8'/>KUPP";
				$chck_user .= "<br/><input type='checkbox' name='user_level[]' value='3'/>Pensyarah";
			}
		}
		/*else if(null==$position) //kalau user_id sama dengan value
		{
			$chck_user .= "<input type='checkbox' name='user_level[]' class='validate[minCheckbox[1]]' value='3'/>Pensyarah";
			$chck_user .= "<br/><input type='checkbox' name='user_level[]' class='validate[minCheckbox[1]]' value='5'/>Pengarah";
			$chck_user .= "<br/><input type='checkbox' name='user_level[]' class='validate[minCheckbox[1]]' value='7'/>KJPP";
		}
		else
		{
			$chck_user .= "<input type='checkbox' name='user_level[]' class='validate[minCheckbox[1]]' checked='checked' value='".$ul_id."'/>".$position;
			$chck_user .= "<br/><input type='checkbox' name='user_level[]' class='validate[minCheckbox[1]]' value='3'/>Pensyarah";
			$chck_user .= "<br/><input type='checkbox' name='user_level[]' class='validate[minCheckbox[1]]' value='5'/>Pengarah";
			$chck_user .= "<br/><input type='checkbox' name='user_level[]' class='validate[minCheckbox[1]]' value='7'/>KJPP";
		}*/ // FDP
		$chck_user.="</span>";
		return $chck_user;
	}
	
	/**
	* this function is add user to table user and table user_group
	* input: -
	* author: Jz
	* Date: 19 March 2014
	*/
	function add_user(){
		$nama = $this->input->post('nama');
		$no_kp = $this->input->post('no_kp');
		$no_kp = str_replace('-', null, $no_kp);
		$date_of_birth = $this->input->post('date_of_birth');
		$address1      = $this -> input -> post('address1');
		$address2      = $this -> input -> post('address2');
		$address3      = $this -> input -> post('address3');
		$postcode      = $this -> input -> post('postcode');
		
		$state         = $this -> input -> post('state');
		$state         = $this -> m_management ->get_state_by_state($state);

		$nationality   = $this -> input -> post('nationality');
		$username      = $this -> input -> post('username');
		$status        = $this -> input -> post('status');
		$email         = $this -> input -> post('email');
		$telephone     = $this -> input -> post('telephone');
		$col_id        = $this -> input -> post('col_id');
		$user_password = '123abc';
		$user_level    = $this -> input -> post('user_level');
		
		$date = time();
		$created_on = $date;
		
		$salt = $this->ion_auth_model->salt();
		$user_password = $this->ion_auth_model->hash_password($user_password,$salt);
		
		$data_user = array(
			'user_name'        => $nama,
			'user_ic'          => $no_kp,
			'user_birth_date'  => $date_of_birth,
			'user_address1'    => $address1,
			'user_address2'    => $address2,
			'user_address3'    => $address3,
			'user_poscode'     => $postcode,
			'user_nationality' => $nationality,
			'user_username'    => $username,
			'user_password'    => $user_password,
			'user_email'	   => $email,
			'created_on'       => $created_on,
			'active'           => $status,
			'col_id'           => $col_id,
			'phone'            => $telephone,
			'state_id'         => $state
		);
		
		$statusInsertUser = $this -> m_management -> insert_user($data_user);
		if($statusInsertUser){
			$field = "user_id";
			$filter = array(
				"user_ic" => $no_kp
			);
			$result = $this-> m_management ->get_user_by_field($field,$filter);
			if(sizeof($result)>0){
				$result = $result[0];
				$user_id = $result->user_id;
				
				foreach($user_level as $user_role){
					$user_group = array(
						'ul_id' => $user_role,
						'user_id' => $user_id
					);
					$this -> m_management -> insert_user_group($user_group);
				}
			}
			echo 'insert';
		}else{
			echo 'error';
		}
	}
	
	/**
	* this function is delete user role from table user_group
	* input: -
	* author: Jz
	* Date: 19 March 2014
	*/
	function delete_usergroup(){
		$ug_id = $this->input->post('ug_id');
		$msg = $this -> m_management -> delete_user_group($ug_id);
		echo $msg;
	}
	
	/**
	* this function is update user role from table user_group
	* input: -
	* author: Jz
	* Date: 19 March 2014
	*/
	function update_usergroup(){
		$ug_id = $this -> input -> post('ug_id');
		$ul_id = $this -> input -> post('ul_id');
		$data = array(
			'ul_id' => $ul_id
		);
		$msg = $this -> m_management -> update_current_role($ug_id,$data);
		echo $msg;
	}
	/**
	* this function is add user role to table user_group
	* input: -
	* author: Jz
	* Date: 19 March 2014
	*/
	function add_usergroup(){
		$ul_id = $this -> input -> post('ul_id');
		$user_id = $this -> input -> post('user_id');
		$data = array(
			'ul_id'  => $ul_id,
			'user_id' => $user_id
		);
		$msg = $this -> m_management -> add_user_group($data);
		echo $msg;
	}
	
	function _main_output($output = null, $header = '') {
		$this -> load -> view('main.php', $output);
	}
}
