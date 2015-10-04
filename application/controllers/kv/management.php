<?php
/**************************************************************************************************
* File Name        : management.php
* Description      : This file is used by kv to manage user and course
* Author           : Mior Mohd Hanif
* Date             : 28 Jun 2013
* Version          : 0.1
* Modification Log : 
* Function List	   : __construct(), user_management(), college_course_management(), 
 * 					callback_for_time_and_encrypt_password(), strtotime_convert_to_date(), 
 * 					_callback_cou_course_code(), _callback_cou_name(), _callback_cou_cluster(), 
 * 					callback_col_id(), _main_output()
**************************************************************************************************/

class Management extends MY_Controller 
{
	function __construct() 
	{
		parent::__construct();
		
		$this->load->library('grocery_CRUD');
		$this->load->helper('date');
		$this->load->model('m_user');
		$this->load->model('m_management');
	}
	
	/**
	* function ni digunakan untuk kv urus maklumat pengguna pada crud
	* input: -
	* author: Mior Mohd Hanif
	* Date: 28 Jun 2013
	* Modification Log:
	*/
	function user_management()
	{
		$user_login = $this->ion_auth->user()->row();
		$col_id = $user_login->col_id;
				
		$crud = new grocery_CRUD();
		
		$crud->where('user.col_id',$col_id);	

		$crud->set_theme('flexigrid');
		$crud->set_subject('Pengguna');
		$crud->set_table('user');
		
		$crud->display_as('user_name','Nama Pengguna')
				->display_as('user_username','Katanama')
				->display_as('user_password','Katalaluan')
				->display_as('user_email','Email')
				->display_as('col_id','Kolej')
				->display_as('created_on','Tarikh Daftar')
				->display_as('last_login','Tarikh Log Masuk')
				->display_as('active','Status')
				->display_as('phone','No. Telefon');
		
		$crud->set_relation('col_id','college','col_name');
		$crud->required_fields('user_name','user_username','user_password','user_email','active','phone');
		$crud->set_rules('user_username','Katanama','trim|required');
		$crud->set_rules('phone','No. Telefon','trim|required|numeric');
		$crud->set_rules('user_email','Email','trim|required|valid_email');
		$crud->unset_columns('ip_address','user_password','salt','activation_code','forgotten_password_code','forgotten_password_time','remember_code');
		$crud->unset_fields('ip_address','activation_code','forgotten_password_code','forgotten_password_time','remember_code','last_login');
		$crud->change_field_type('user_password', 'password');
		$crud->change_field_type('created_on','invisible');
		$crud->change_field_type('salt','invisible');
		$crud->change_field_type('col_id','invisible');
		$crud->callback_before_insert(array($this,'callback_for_time_and_encrypt_password'));
		$crud->callback_column('created_on',array($this,'strtotime_convert_to_date'));
		$crud->callback_column('last_login',array($this,'strtotime_convert_to_date'));
		
		$output = $crud->render();

		$header="<legend><h4>Penyelenggaraan Pengguna</h4></legend>";

		$this -> _main_output($output, $header);
	}

	/**
	* function ni digunakan untuk kv urus maklumat kursus kolej pada crud
	* input: -
	* author: Mior Mohd Hanif
	* Date: 28 Jun 2013
	* Modification Log: 4 Julai 2013 by Mior - fixed bug insert
	 * 					18 Julai 2013 by Mior - fixed bug before insert and update
	*/					
	function college_course_management()
	{
		
		$user_login = $this->ion_auth->user()->row();
		$col_id = $user_login->col_id;
		
		$crud = new grocery_CRUD();	

		$crud->set_theme('flexigrid');
		$crud->set_subject('Kursus Kolej');
		$crud->set_table('college_course');
		$crud->set_relation('cou_id','course','{cou_course_code} - {cou_name}');
		$crud->columns('cou_course_code','cou_name','cou_cluster');
		$crud->callback_column('cou_course_code',array($this,'_callback_cou_course_code'));
		$crud->callback_column('cou_name',array($this,'_callback_cou_name'));
		$crud->callback_column('cou_cluster',array($this,'_callback_cou_cluster'));
		$crud->display_as('cou_id','Kursus')
				->display_as('cou_course_code','Kod Kursus')
				->display_as('cou_name','Nama Kursus')
				->display_as('cou_cluster','Kluster');
		$crud->required_fields('cou_id');
		$crud->field_type('col_id','invisible');
		$crud->callback_before_insert(array($this,'callback_col_id'));
		$crud->callback_before_update(array($this,'callback_col_id'));
		$crud->where('col_id',$col_id);
		
		$output = $crud->render();

		$header="<legend><h4>Penyelenggaraan Kursus Kolej</h4></legend>";

		$this -> _main_output($output, $header);
		
	}
	
	/**
	* function ni digunakan untuk mendapatkan time sekarang,salt dan encryption password
	* input: -
	* author: Mior Mohd Hanif
	* Date: 28 Jun 2013
	* Modification Log: 
	*/
	function callback_for_time_and_encrypt_password($post_array) 
	{
		$user_login = $this->ion_auth->user()->row();
		$col_id = $user_login->col_id;
		
	  	$date = time();
	  	$post_array['created_on'] = $date;
	  	$post_array['salt'] = $this->ion_auth_model->salt();
		$post_array['user_password'] = $this->ion_auth_model->hash_password($post_array['user_password'],$post_array['salt']);
		$post_array['col_id'] = $col_id;
	  
	  	return $post_array;
	}

	/**
	* function ni digunakan untuk tukarkan data kedalam bentuk tarikh
	* input: -
	* author: Mior Mohd Hanif
	* Date: 28 Jun 2013
	* Modification Log: 
	*/
	public function strtotime_convert_to_date($value)
	{
		if(null!=$value)//kalau value tak sama null
		{
			$date = date("d-m-Y",$value);
		}
		else
		{
			$date = "-";
		}
		
	  return $date;
	}
	
	/**
	* function ni digunakan untuk dapatkan maklumat terperinci kursus
	* input: -
	* author: Mior Mohd Hanif
	* Date: 28 Jun 2013
	* Modification Log:
	*/
	function _callback_cou_course_code($value, $row)
	{
		$data['cc'] = $this->m_user->get_course_by_id($row->cc_id);

		return $data['cc']->cou_course_code;		
	}
	
	/**
	* function ni digunakan untuk dapatkan maklumat terperinci kursus
	* input: -
	* author: Mior Mohd Hanif
	* Date: 28 Jun 2013
	* Modification Log:
	*/
	function _callback_cou_name($value, $row)
	{
		$data['cc'] = $this->m_user->get_course_by_id($row->cc_id);

		return $data['cc']->cou_name;		
	}
	
	/**
	* function ni digunakan untuk dapatkan maklumat terperinci kursus
	* input: -
	* author: Mior Mohd Hanif
	* Date: 28 Jun 2013
	* Modification Log:
	*/
	function _callback_cou_cluster($value, $row)
	{
		$data['cc'] = $this->m_user->get_course_by_id($row->cc_id);

		return $data['cc']->cou_cluster;		
	}
	
	/**
	* function ni digunakan untuk assign col_id to post
	* input: -
	* author: Mior Mohd Hanif
	* Date: 4 Julai 2013
	* Modification Log: 18 Julai 2013 by Mior - fixed bug before insert and update 
	*/
	function callback_col_id($post_array)
	{
		$user_login = $this->ion_auth->user()->row();
		$col_id = $user_login->col_id;
		$post_array['col_id'] = $col_id;
		
		$check = $this->m_management->check_college_course($post_array['col_id'],$post_array['cou_id']);
		
		if(null==$check)
		{
			return $post_array;
		}
		else {
			return false;
		}
		
	}
	
	function _main_output($output = null, $header = '') 
	{
		$output -> output = $header . $output -> output;
		$this -> load -> view('main.php', $output);
	}
}

/**************************************************************************************************
* End of management.php
**************************************************************************************************/
?>