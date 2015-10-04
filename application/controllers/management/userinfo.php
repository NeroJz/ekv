<?php
/**************************************************************************************************
 * File Name        : report.php
 * Description      : This File contain Report module.
 * Author           : sukor
 * Date             : 9 july 2013
 * Version          : -
 * Modification Log : -
 * Function List	   : __construct(),
 **************************************************************************************************/
class Userinfo extends CI_Controller {

	function __construct() {
		parent::__construct();

		$this -> load -> model('m_userinfo');
		
	}
	
	
	
/***************************************************************************************************
* Description		: this function to report tak ajax.tak guna
* input			: 
* author			: sukor
* Date				: 11 july 2013
* Modification Log	: -
***************************************************************************************************/


	function userdetail() {
        $user_login = $this->ion_auth->user()->row();
		$centreCode = $user_login->col_id;
		$userId = $user_login->user_id;
		$state_id= $user_login->state_id;

		  $user_groups = $this->ion_auth->get_users_groups($userId)->row();  
		  $ul_type= $user_groups->ul_type;
		
$data['userinfo'] = $this -> m_userinfo ->get_detailuser($userId);


		$data['output'] = $this -> load -> view('userinfo/v_userdetail', $data, true);
		$this -> load -> view('main', $data);
	}
	
	
/***************************************************************************************************
* Description		: this function to update password
* input				: 
* author			: Fred
* Date				: 12 February 2014
* Modification Log	: -
***************************************************************************************************/
function update_password()
{
	$user_login = $this->ion_auth->user()->row();
	$userId = $user_login->user_id;
	$user_password = $this->input->post('user_password');
	$salt = $this->ion_auth_model->salt();
	
	//echo $userId;
	
	$data = array(
			'user_password' => $this->ion_auth_model->hash_password($user_password,$salt),
			'salt' => $salt
		);
	
	$data_pass = $this -> m_userinfo ->update_pass($userId,$data);
	
	//print_r ($data);
	//die();
	return 1;
	
}
	
}
	?>