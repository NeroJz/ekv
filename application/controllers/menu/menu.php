<?php

class Menu extends MY_Controller{
	
	function __construct(){
		parent::__construct();
	}
	
	function index(){
		$this->load->library("table");
		$user_login = $this->ion_auth->user()->row();
		$colid = $user_login->col_id;
		$userId = $user_login->user_id;
		$state_id= $user_login->state_id;

		$user_groups = $this->ion_auth->get_users_groups($userId)->row();  
		$id= $user_groups->id;

		$data['ul']=$this->db
		->select('*')
		->from('user_level')->get()->result();

		$menuData=array();
		foreach ($data['ul'] as $key) {
			$this->get_menu($menuData[$key->ul_id],$key->ul_id);
		}
		$data['menuData']=$menuData;

		$this->get_menu($menu,$id);
		$data['menu']=$menu;

		// print_r($menu);

		$output['output']=$this -> load -> view('menu/menu.php',$data,true);
		$this -> load -> view('main.php',$output);
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

	function editMenu(){
		//print_r($_POST);
		$value=$this->input->post('value');
		$pk=$this->input->post('pk');
		$data=array(
			'menu_item'=>$this->input->post('value')
			);
		$this->db->where('menu_id',$pk);
		$this->db->update('menu',$data);

		$this->db->select('menu_item');
		$this->db->where('menu_id',$pk);
		$query=$this->db->get('menu')->result();
		foreach ($query as $key) {
			//print_r($key->menu_item);
		}
		return;
	}
	function editMenuPath(){
		$value=$this->input->post('value');
		$pk=$this->input->post('pk');
		$data=array(
			'menu_path'=>$this->input->post('value')
			);
		$this->db->where('menu_id',$pk);
		$this->db->update('menu',$data);

		$this->db->select('menu_path');
		$this->db->where('menu_id',$pk);
		$query=$this->db->get('menu')->result();
		foreach ($query as $key) {
			//print_r($key->menu_path);
		}
		return;
	}

	function add(){
		// print_r($_POST);
		if($this->input->post('parent')==0)
			$parent=null;
		else
			$parent=$this->input->post('parent');
		$data=array(
			'menu_id'=>'',
			'menu_item'=>$this->input->post('menu'),
			'menu_path'=>$this->input->post('path'),
			'parent_id'=>$parent,
			'menu_order'=>$this->input->post('order')
			);
		$this->db->insert('menu',$data);

		$data_menu_ul = array(
			'menu_ul_id'=>'',
			'menu_id'=>$this->db->insert_id(),
			'ul_id'=>$this->input->post('ul_id')
			);
		$this->db->insert('menu_ul',$data_menu_ul);
		header('Location: '.site_url('/menu/menu/'));
		return;
	}

	function delete($id){
		// $id = $this->input->post('menu_id');
		$this->db->delete('menu', array('menu_id' => $id)); 
		$this->db->delete('menu_ul', array('menu_id' => $id)); 
		header('Location: '.site_url('/menu/menu/'));
		return;
	}
}
/**************************************************************************************************
* End of college.php
**************************************************************************************************/
?>
