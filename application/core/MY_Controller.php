<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public $site_data;

   function __construct()
    {
        parent::__construct();

        // Ku Ahmad Mudrikah : menu code
		$user_login = $this->ion_auth->user()->row();
		$userId = $user_login->user_id;

		$user_groups = $this->ion_auth->get_users_groups($userId)->row();  
		$id= $user_groups->id;

		get_menu($menu,$id);

		//$this->data['menu']=$menu;
		$global_data = array('menu' => $menu);
		$this->load->vars($global_data);
        // end menu code
		
		$avoid_checkRedirect = array('auth','login', 'logout');

		if (!$this->ion_auth->logged_in())
		{
			if(!in_array(strtolower(get_class($this)), $avoid_checkRedirect))
						$this->session->set_userdata('redirect_url',$this->uri->uri_string());
			redirect('auth/login');
		}
    }

}