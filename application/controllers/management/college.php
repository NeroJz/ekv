<?php

class College extends MY_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model('m_extkolej');
		$this->load->model('m_extstate');
		$this->load->model('m_user');
		$this -> load -> library('table');

	}
	
	function _main_output($output = null, $header = ''){
		$this -> load -> view('main.php', $output);
	}
	
	function index(){
		$heading = array(
			'Jenis Kolej',
			'Nama Kolej',
			'Kod Kolej',
			'Pengarah Kolej',
			'Timbalan Pengarah Kolej',
			'KJPP Kolej',
			'KUPP Kolej',
			'No. Telefon Kolej',
			'No. Telefon KUPP',
			'Email Kolej',
			'Negeri',
			'Tindakan'
		);
		//load datatable amtis
		$this->load->library("datatables_amtis");
		$dtAmt = $this->datatables_amtis;
		$dtAmt->set_heading($heading);
		
		$aConfigDt['aoColumnDefs'] = '[
			{ "sWidth": "5%", "aTargets": [ 0 ] },
			{ "sWidth": "20%", "aTargets": [ 1 ] },
            { "sWidth": "5%", "aTargets": [ 2 ] },
            { "sWidth": "10%", "aTargets": [ 3 ] },
            { "sWidth": "10%", "aTargets": [ 4 ] },
            { "sWidth": "10%", "aTargets": [ 5 ] },
            { "sWidth": "10%", "aTargets": [ 6 ] },
            { "sWidth": "5%", "aTargets": [ 7 ] },
            { "sWidth": "5%", "aTargets": [ 8 ] },
            { "sWidth": "5%", "aTargets": [ 9 ] },
            { "sWidth": "5%", "aTargets": [ 10 ] },
            { "sWidth": "10%", "aTargets": [ 11 ] }                     
        ]';
		$aConfigDt['bSort'] = 'true';
		$aConfigDt['aaSorting'] = '[[ 3, "asc"]]';
		$dtAmt->setConfig($aConfigDt);
		$data['datatable'] = $dtAmt->generateView(site_url('management/college/ajaxdata_search_pengguna'),'tblKolej');
		
		$data['state'] = $this->m_extstate->get();
		$data['col_type'] = $this->check_options_college_type();
		
		$output['output'] = $this -> load -> view('management/v_college_management', $data, true);
		$this -> _main_output($output, null);
	}
	
	function ajaxdata_search_pengguna(){
		// load datatable amtis
		$this->load->library("datatables_amtis");
		$dtAmt = $this->datatables_amtis;
		$dtAmt
		->select('col_id, col_type, col_name, col_code, col_director, col_dep_director, col_kjpp, col_kupp, col_phone, col_kupp_phone,
		col_email, state')
        ->from('college')
        ->join('state','state.state_id = college.state_id ');
		$dtAmt->add_column('Tindakkan', '$1',"checkOptions(Kolej, col_id)");
		
		
		$dtAmt->edit_column('col_director','$1',"getUserInfo(col_director)");
		$dtAmt->edit_column('col_dep_director','$1',"getUserInfo(col_dep_director)");
		$dtAmt->edit_column('col_kjpp','$1',"getUserInfo(col_kjpp)");
		$dtAmt->edit_column('col_kupp','$1',"getUserInfo(col_kupp)");
		
		$dtAmt->unset_column('col_id');
		//$dtAmt->unset_column('cou_code');
		
		
		
		echo $dtAmt->generate();
	}
	
	function check_options_college_type() 
	{
		if($this->ion_auth->in_group("JPN")) // kalau user login adalah JPN
		{
	  		$slct = '<input type="text" value="K" name="col_type" readonly="readonly">';
		}
		else if($this->ion_auth->in_group("BPTV")) // kalau user login adalah BPTV
		{
			$slct = "<select name='col_type' id='col_type' class='validate[required]'>";
			$slct .= "<option value=''>-Sila Pilih-</option>";
			$slct .= "<option value='A'>ILKA</option>";
			$slct .= "<option value='S'>ILPS</option>";
			$slct .="</select>";
		}
		else
		{
			$slct = "<select name='col_type' id='col_type' class='validate[required]'>";
			$slct .= "<option value=''>-Sila Pilih-</option>";
			$slct .= "<option value='K'>KPM</option>";
			$slct .= "<option value='A'>ILKA</option>";
			$slct .= "<option value='S'>ILPS</option>";
			$slct .="</select>";
		}
		return $slct;
	}
	
	function callback_edit_college_type()
	{
		$value = $this->input->post('col_type');
		
		if($this->ion_auth->in_group("JPN")) // kalau user login adalah JPN
		{
	  		$slct = '<input type="text" value="'.$value.'" name="col_type" readonly="readonly">';
		}
		else if($this->ion_auth->in_group("BPTV")) // kalau user login adalah BPTV
		{
			$slct = "<select name='col_type' id='col_type' class='validate[required]'>";
			$slct .= "<option value=''>-Sila Pilih-</option>";
			
			if("A"==$value) //kalau value sama dgn A
			{
				$slct .= "<option value='A' selected='selected'>ILKA</option>";
				$slct .= "<option value='S'>ILPS</option>";
			}
			if("S"==$value) //kalau value sama dgn S
			{
				$slct .= "<option value='A'>ILKA</option>";
				$slct .= "<option value='S' selected='selected'>ILPS</option>";
			}
			$slct .="</select>"; 	
		}
		else
		{
			$slct = "<select name='col_type' id='col_type' class='validate[required]'>";
			$slct .= "<option value=''>-Sila Pilih-</option>";
			
			if("A"==$value) //kalau value sama dgn A
			{
				$slct .= "<option value='K'>KPM</option>";
				$slct .= "<option value='A' selected='selected'>ILKA</option>";
				$slct .= "<option value='S'>ILPS</option>";
			}
			if("S"==$value) //kalau value sama dgn S
			{
				$slct .= "<option value='K'>KPM</option>";
				$slct .= "<option value='A'>ILKA</option>";
				$slct .= "<option value='S' selected='selected'>ILPS</option>";
			}
			if("K"==$value) //kalau value sama dgn K
			{
				$slct .= "<option value='K' selected='selected'>KPM</option>";
				$slct .= "<option value='A'>ILKA</option>";
				$slct .= "<option value='S'>ILPS</option>";
			}
			$slct .="</select>"; 
		}
		echo $slct;
	}
	
	function callback_edit_user_type()
	{
		$col_id 	= $this->input->post('col_id');
		$field_name = $this->input->post('field_name');
		$value		= $this->input->post('user_name');
		
	    $data['user'] = $this->m_user->get_user($col_id);
		
		
		if(empty($data['user'])){
			$slct_user = "<input type='text' disabled='disabled'value='Tiada rekod untuk kolej ini'></input>";
		}else{
			$slct_user = "<select name='".$field_name."' id='".$field_name."' class='validate[required]'>";
			$slct_user .= "<option value=''>-Sila Pilih-</option>";
			
			foreach($data['user'] as $usr)
			{
				if($value==$usr->user_name) //kalau user_id sama dengan value
				{
					$slct_user .= "<option value='".$usr->user_id."' selected='selected'>".$usr->user_name."</option>";	
				}
				else
				{
					$slct_user .= "<option value='".$usr->user_id."'>".$usr->user_name."</option>";
				}
			}
			$slct_user .="</select>";
		}
		
	 	echo $slct_user;
	}
	
	function callback_edit_state(){
		$state_name = $this->input->post('state');
		$all_state = $this->m_extstate->get();
		$slct = "<select name='state_id' id='state_id'>";
		foreach($all_state as $state){
			if($state->state == $state_name){
				$slct .= "<option value='".$state->state_id."' selected='selected'>".$state->state_code."&nbsp-&nbsp".$state->state."</option>";	
			}else{
				$slct .= "<option value='".$state->state_id."'>".$state->state_code."&nbsp-&nbsp".$state->state."</option>";
			}
		}
		$slct .= "</select>";
		echo $slct;
	}
	
	function insert(){
		$col_type 		= $this->input->post('col_type');
		$col_name 		= $this->input->post('col_name');
		$col_code 		= $this->input->post('col_code');
		$col_phone 		= $this->input->post('col_phone');
		$col_kupp_phone = $this->input->post('col_kupp_phone');
		$col_email 		= $this->input->post('col_email');
		$state_id  		= $this->input->post('state_id');
		
		$data = array(
			'col_type' => $col_type,
			'col_name' => $col_name,
			'col_code' => $col_code,
			'col_phone' => $col_phone,
			'col_kupp_phone' => $col_kupp_phone,
			'col_email' => $col_email,
			'state_id' =>$state_id
		);
		
		$result = $this->m_extkolej->insert($data);
		echo $result;
	}
	function update(){
		$col_type 		  = $this->input->post('col_type');
		$col_name 		  = $this->input->post('col_name');
		$col_code 		  = $this->input->post('col_code');
		$col_director 	  = $this->input->post('col_director');
		$col_dep_director = $this->input->post('col_dep_director');
		$col_kjpp 		  = $this->input->post('col_kjpp');
		$col_kupp 		  = $this->input->post('col_kupp');
		$col_phone 		  = $this->input->post('col_phone');
		$col_kupp_phone	  = $this->input->post('col_kupp_phone');
		$col_email 		  = $this->input->post('col_email');
		$state_id		  = $this->input->post('state_id');
		
		
		$col_director 	  = (empty($col_director) ? NULL : $col_director);
		$col_dep_director = (empty($col_dep_director) ? NULL : $col_dep_director);
		$col_kjpp 		  = (empty($col_kjpp) ? NULL : $col_kjpp);
		$col_kupp = (empty($col_kupp) ? NULL : $col_kupp);
		$col_phone = (empty($col_phone) ? NULL : $col_phone);
		$col_kupp_phone = (empty($col_kupp_phone) ? NULL : $col_kupp_phone);
		$col_email = (empty($col_email) ? NULL : $col_email);
		
		
		$data = array(
			'col_type' => $col_type,
			'col_name' => $col_name,
			'col_code' => $col_code,
			'col_director' => $col_director,
			'col_dep_director' => $col_dep_director,
			'col_kjpp' => $col_kjpp,
			'col_kupp' => $col_kupp,
			'col_phone' => $col_phone,
			'col_kupp_phone' => $col_kupp_phone,
			'col_email' => $col_email,
			'state_id' => $state_id
		);
		
		$id = $this->input->post('col_id');
		
		$result = $this->m_extkolej->update($data, $id);
		
		echo $result;
	}

	/*
	* this function is to display college info 
	* input: -
	* author: Nursyahira Adlin
	* Date: 10 April 2014
	* Modification Log:
	*/

	function display_update_kolej() {
		
		$user = $this->ion_auth->user()->row();
		$userid = $user->id;

		$college_id		= $this->m_user->get_college_by_user_id($userid);

		//$code 			= $this->m_user->get_college_by_col_id($college->col_id);
		//$get_c_name 	= $this->m_user->get_college_name_info($code->col_name);
		//$get_c_phone 	= $this->m_user->get_college_phone_info($code->col_phone);
		//$get_c_email 	= $this->m_user->get_college_email_info($code->col_email);

		$data['kvinfo']	= $this->m_user->get_college_by_col_id($college_id->col_id);
		$data['kvuser']	= $this->m_user->get_user_by_col_id($college_id->col_id);

		//$data['director'] 		= $this->m_user->get_director_by_id($code->col_director);		
		//$data['college'] 		= $code;
		//$data['get_col_name'] 	= $get_c_name;
		//$data['get_col_phone']	= $get_c_phone;
		//$data['get_col_email'] 	= $get_c_email;
		//$data['get_dep_dir'] 	= $this->m_user->get_dep_director_by_id($code->col_dep_director);
		//$data['get_col_kjpp']	= $this->m_user->get_kjpp_by_id($code->col_kjpp);
		
		//echo ('<pre>');
		//print_r($data);
		//echo('</pre>');
		//die();

		$output['output'] = $this -> load -> view('management/v_college_info_management', $data, true);		
		$this->load->view('main.php', $output);
		//$this -> _main_output($output);
	}

	/*
	* this function is to update college info
	* input: -
	* author: Nursyahira Adlin
	* Modification Log:
	*/
	function update_college_info() {
		
		$user_login = $this->ion_auth->user()->row();
		
		$directorkv = $this->input->post('directorkv');
		$directoridkv = $this->input->post('directoridkv');
		$timdirectorkv = $this->input->post('timdirectorkv');
		$timdirectoridkv = $this->input->post('timdirectoridkv');
		$phonekv = $this->input->post('phonekv');
		$emailkv = $this->input->post('emailkv');
		$kolej_idkv = $this->input->post('dir_col_idkv');

		//echo ('<pre>');
		//print_r($directorkv);
		//echo('</pre>');
		//die();

		if( "" != $directorkv && "" != $directoridkv)
		{
			$data_user = array( 'user_name' => $directorkv );
			$this->m_user->update_user_info1($directoridkv, $kolej_idkv, $data_user);
		}

		if( "" != $timdirectorkv && "" != $timdirectoridkv)
		{
			$data_user = array( 'user_name' => $timdirectorkv );
			$this->m_user->update_user_info1($timdirectoridkv, $kolej_idkv, $data_user);
		}
		
		$data_user2 = array( 'col_phone' => $phonekv, 'col_email' => $emailkv );
		$this->m_user->update_college_info2($kolej_idkv, $data_user2);

		//redirect('/management/college/display_update_kolej');
	}
	
	/*
	* function ini adalah untuk paparkan page bagi upload logo dan cop kolej
	* input: -
	* author: Nursyahira Adlin
	* Date: 11 April 2014
	* Modification Log:
	*/
	function view_upload_image() {
		$user = $this->ion_auth->user()->row();
		$userid = $user->id;
		$data['status'] = 0;

		$output['output'] = $this -> load -> view('kv/v_kv_upload', $data, true);
		$this->load->view('main.php', $output);
		//$this -> _main_output($output);
		
	}

	/*
	* this function is to upload college logo
	* input: -
	* author: Nursyahira Adlin
	* Date: 11 April 2014
	* Modification Log:
	*/
	function upload_logo()
	{
		//$data['status'] = 0;
		$userid=$this->session->userdata('user_id');
		$college_id		= $this->m_user->get_college_by_user_id($userid);
		
		$config['upload_path'] 		= './uploaded/kvinfo/';
		$config['allowed_types'] 	= 'jpg|png';
		$config['file_name']		= 'Logokolej_'.$college_id->col_id;
		$config['overwrite']		= TRUE;
		$config['max_size']			= '2000000';
			
		$this->load->library('upload', $config);
				
		
		if ( ! $this->upload->do_upload())
		{
			$data['status'] = 2;

			$error = array('error' => $this->upload->display_errors());
			//echo json_encode($error);
			$data['img']=$this->m_user->get_img($college_id->col_id);
			$data['stmp']=$this->m_user->get_stamp($college_id->col_id);
			$output['output'] = $this -> load -> view('kv/v_kv_upload', $data, true);
			$this->load->view('main.php', $output);
		}
		else
		{
			 $img = $this->upload->data();	
			if(file_exists("./uploaded/kvinfo/Logokolej.png"))
			{
				$image = imagecreatefrompng('./uploaded/kvinfo/Logokolej.png');
				imagejpeg($image, './uploaded/kvinfo/Logokolej.jpg');
				imagedestroy($image);

				$file = "./uploaded/kvinfo/Logokolej.png";
				
				unlink($file); 
			}

		/*	$imgconfig = array();
			$this->load->library('image_lib');

			$imgconfig['image_library'] = 'gd2';
			$imgconfig['source_image']	= './uploaded/kvinfo/Logokolej.jpg';
			$imgconfig['create_thumb'] = TRUE;
			$imgconfig['maintain_ratio'] = TRUE;				
			$imgconfig['width']	 = 160;
			$imgconfig['height'] = 70;
			$imgconfig['thumb_marker'] = "_small";
			

			$this->image_lib->initialize($imgconfig);

			if(! $this->image_lib->resize())
			{
				$this->image_lib->display_errors('<p>', '</p>');
			}

			$this->image_lib->clear();				
			
			$imgconfig['image_library'] = 'gd2';
			$imgconfig['source_image']	= './uploaded/kvinfo/Logokolej.jpg';
			$imgconfig['create_thumb'] = TRUE;
			$imgconfig['maintain_ratio'] = TRUE;				
			$imgconfig['width']	 = 260;
			$imgconfig['height'] = 127;
			$imgconfig['thumb_marker'] = "_medium";

			$this->image_lib->initialize($imgconfig);

			if(! $this->image_lib->resize())
			{
				$this->image_lib->display_errors('<p>', '</p>');
			}

			$this->image_lib->clear();

			$imgconfig['image_library'] = 'gd2';
			$imgconfig['source_image']	= './uploaded/kvinfo/Logokolej.jpg';
			$imgconfig['create_thumb'] = TRUE;
			$imgconfig['maintain_ratio'] = TRUE;				
			$imgconfig['width']	 = 445;
			$imgconfig['height'] = 284;
			$imgconfig['thumb_marker'] = "_big";

			$this->image_lib->initialize($imgconfig);

			if(! $this->image_lib->resize())
			{
				$this->image_lib->display_errors('<p>', '</p>');
			}

			$this->image_lib->clear();	*/	
			
			
			
			
			
			$info = array('col_image' => $config['upload_path'].$img['file_name']);
			$this->m_user->insert_path_image($info, $college_id->col_id);
			$data['status'] = 1;
			$data['img']=$this->m_user->get_img($college_id->col_id);
			$data['stmp']=$this->m_user->get_stamp($college_id->col_id);
			$output['output'] = $this -> load -> view('kv/v_kv_upload', $data, true);
			$this->load->view('main.php', $output);      
		}
	}

	/*
	* function ini adalah untuk upload cop kolej
	* input: -
	* author: Nursyahira Adlin
	* Date: 16 April 2014
	* Modification Log:
	*/
	function upload_cop()
	{
		
		$userid=$this->session->userdata('user_id');
		$college_id		= $this->m_user->get_college_by_user_id($userid);
		
		$config['upload_path']	 = './uploaded/kvinfo/';
		$config['allowed_types'] = 'png';
		$config['file_name']	 = 'Copkolej_'. $college_id->col_id;
		$config['overwrite']	 = TRUE;
		$config['max_size']		 = '2000000';
			
		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
			{
				$data['status'] = 3;
				$error = array('error' => $this->upload->display_errors());
				//echo json_encode($error);
				$data['img']=$this->m_user->get_img($college_id->col_id);
				$data['stmp']=$this->m_user->get_stamp($college_id->col_id);
				$output['output'] = $this -> load -> view('kv/v_kv_upload', $data, true);
				$this -> _main_output($output);
			}
			else
			{
				$img = $this->upload->data();	
				$info = array('col_stamp' => $config['upload_path'].$img['file_name']);
				$this->m_user->insert_path_image($info, $college_id->col_id);
				/*$imgconfig = array();
				$this->load->library('image_lib');

				$imgconfig['image_library'] = 'gd2';
				$imgconfig['source_image']	= './uploaded/kvinfo/Copkolej.png';
				$imgconfig['create_thumb'] = TRUE;
				$imgconfig['maintain_ratio'] = TRUE;				
				$imgconfig['width']	 = 160;
				$imgconfig['height'] = 70;
				$imgconfig['thumb_marker'] = "_small";

				$this->image_lib->initialize($imgconfig);

				if(! $this->image_lib->resize())
				{
					$this->image_lib->display_errors('<p>', '</p>');
				}

				$this->image_lib->clear();				

				$imgconfig['image_library'] = 'gd2';
				$imgconfig['source_image']	= './uploaded/kvinfo/Copkolej.png';
				$imgconfig['create_thumb'] = TRUE;
				$imgconfig['maintain_ratio'] = TRUE;				
				$imgconfig['width']	 = 260;
				$imgconfig['height'] = 127;
				$imgconfig['thumb_marker'] = "_medium";

				$this->image_lib->initialize($imgconfig);

				if(! $this->image_lib->resize())
				{
					$this->image_lib->display_errors('<p>', '</p>');
				}

				$this->image_lib->clear();
				/*

				$imgconfig['image_library'] = 'gd2';
				$imgconfig['source_image']	= './uploaded/kvinfo/Copkolej.jpg';
				$imgconfig['create_thumb'] = TRUE;
				$imgconfig['maintain_ratio'] = TRUE;				
				$imgconfig['width']	 = 445;
				$imgconfig['height'] = 284;
				$imgconfig['thumb_marker'] = "_big";

				$this->image_lib->initialize($imgconfig);

				if(! $this->image_lib->resize())
				{
					$this->image_lib->display_errors('<p>', '</p>');
				}

				$this->image_lib->clear();
				*/

				$data['status'] = 1;
				$data['img']=$this->m_user->get_img($college_id->col_id);
				$data['stmp']=$this->m_user->get_stamp($college_id->col_id);
				$output['output'] = $this -> load -> view('kv/v_kv_upload', $data, true);
				$this -> _main_output($output);
          
			}
	}
}
/**************************************************************************************************
* End of college.php
**************************************************************************************************/
?>
