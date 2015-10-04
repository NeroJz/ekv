<?php
/**************************************************************************************************
* File Name        : m_management.php
* Description      : This file is used for manage user
* Author           : Mior Mohd Hanif
* Date             : 3 Julai 2013
* Version          : 0.1
* Modification Log : 
* Function List	   : get_user(), get_director_by_user_id(), get_kupp_user(), get_user_by_col_id(),
 * 					check_user_group(), check_college_course()
**************************************************************************************************/

class M_management extends CI_Model
{
	/**
	* function ni digunakan untuk penyelenggaraan pengguna pada crud
	* input: -
	* author: Mior Mohd Hanif
	* Date: 3 Julai 2013
	* Modification Log: 
	*/
	function get_user()
	{
		$this -> db -> from('user as u');
		
		$this -> db -> join('college as c', 'c.col_id = u.col_id');
		$this -> db -> join('user_group as ug', 'ug.user_id = u.user_id');
		$this -> db -> join('user_level as ul', 'ul.ul_id = ug.ul_id');
		//$this -> db -> where('ul.ul_name', "Pengarah");
		
		return $this -> db -> get();
	}
	
	/**
	* function ni digunakan untuk penyelenggaraan pengguna pada crud
	* input: -
	* author: Mior Mohd Hanif
	* Date: 3 Julai 2013
	* Modification Log: 
	*/
	function get_director_by_user_id($user_id)
	{
		$this -> db -> from('user as u');
		
		$this -> db -> join('college as c', 'c.col_id = u.col_id');
		$this -> db -> join('user_group as ug', 'ug.user_id = u.user_id');
		$this -> db -> join('user_level as ul', 'ul.ul_id = ug.ul_id');
		$this -> db -> where('u.user_id', $user_id);
		
		return $this -> db -> get();
	}
	
	/**
	* function ni digunakan untuk penyelenggaraan pengguna pada crud
	* input: -
	* author: Mior Mohd Hanif
	* Date: 3 Julai 2013
	* Modification Log: 
	*/
	function get_kupp_user()
	{
		$this -> db -> from('user as u');
		
		$this -> db -> join('college as c', 'c.col_id = u.col_id');
		$this -> db -> join('user_group as ug', 'ug.user_id = u.user_id');
		$this -> db -> join('user_level as ul', 'ul.ul_id = ug.ul_id');
		$this -> db -> where('ul.ul_name', "KUPP");
		
		return $this -> db -> get();
	}
	
	/**
	* function ni digunakan untuk penyelenggaraan pengguna pada crud
	* input: -
	* author: Mior Mohd Hanif
	* Date: 3 Julai 2013
	* Modification Log: 
	*/
	function get_user_by_col_id($id_pusat)
	{
		$this -> db -> from('user as u');
		
		$this -> db -> join('college as c', 'c.col_id = u.col_id');
		$this -> db -> join('user_group as ug', 'ug.user_id = u.user_id');
		$this -> db -> join('user_level as ul', 'ul.ul_id = ug.ul_id');
		$this -> db -> where('u.col_id', $id_pusat);
		
		return $this -> db -> get();
	}
	
	/**
	* function ni digunakan untuk check user group
	* input: -
	* author: Mior Mohd Hanif
	* Date: 8 Julai 2013
	* Modification Log: 
	*/
	function check_user_group($id_pusat,$ul_id)
	{
		$this -> db -> select('u.user_id');
		$this -> db -> from('user as u');
		$this -> db -> join('college as c', 'c.col_id = u.col_id');
		$this -> db -> join('user_group as ug', 'ug.user_id = u.user_id');
		$this -> db -> join('user_level as ul', 'ul.ul_id = ug.ul_id');
		$this -> db -> where('u.col_id', $id_pusat);
		$this -> db -> where('ug.ul_id', $ul_id);
		$query = $this->db->get();

    	if ($query->num_rows() > 0)
		{
        	return $query->row();
		}
	}
	
	/**
	* function ni digunakan untuk check college course
	* input: -
	* author: Mior Mohd Hanif
	* Date: 18 Julai 2013
	* Modification Log: 
	*/
	function check_college_course($id_pusat,$cou_id)
	{
		$this -> db -> select('cc.cc_id');
		$this -> db -> from('college_course as cc');
		$this -> db -> where('cc.col_id', $id_pusat);
		$this -> db -> where('cc.cou_id', $cou_id);
		$query = $this->db->get();

    	if ($query->num_rows() > 0)
		{
        	return $query->row();
		}
	}

	/**********************************************************************************************
	 * Description: add new function in m_management
	 * Author: Jz
	 * Date: 18-03-2014
	 * function: get_collge_state(),get_user_position(), update_user_info(),update_user_level()
	 * *******************************************************************************************/
	
	/**
	 * this function is use to get the college state of user
	 * author: Jz
	 * Modify Date: 18-03-2014
	 */
	 function get_collge_state($pusat_id){
	 	$this->db->from('state st');
		$this->db->join('college cl','cl.state_id = st.state_id');
		$this->db->where('st.state_id',$pusat_id);
		
		return $this -> db -> get();
	 }
	 /**
	* this function gets the position(jawatan) of the user
	* input: $id - user_id, $max - bool(true) or bool(false)
	* author: Jz
	* Date: 18 March 2014
	* Modification Log:
	*/
	function get_user_position($id, $max = FALSE){
		
		if($max){
			$this->db->select('MAX(ul.ul_id) as ul_id, ul.ul_name, ug.ug_id');
		}else{
			$this->db->select('ul.ul_id, ul.ul_name, ug.ug_id');
		}
		$this->db->from('user_level ul');
		$this->db->join('user_group ug', 'ug.ul_id = ul.ul_id');
		$this->db->where('ug.user_id',$id);
		$this->db->group_by('ul.ul_id');
		
		return $this->db->get();
		
	}
	
	 /**
	* this function update the user info
	* input: $id - user_id, $data - update field and values
	* author: Jz
	* Date: 18 March 2014
	* Modification Log:
	*/
	function update_user_info($id,$data){
		$this->db->where('user_id',$id);
		$this->db->update('user',$data);
	}
	/**
	* this function update the user level
	* input: $id - user_id, $data - update field and values
	* author: Jz
	* Date: 18 March 2014
	* Modification Log:
	*/
	function update_user_level($id,$data){
		$this->db->where('user_id',$id);
		$this->db->update('user_group',$data);
	}
	/**
	* this function insert the new user
	* input: $data_user - data enter from form
	* author: Jz
	* Date: 19 March 2014
	* Modification Log:
	*/
	function insert_user($data_user){
		$this -> db -> select('user_ic');
		$this -> db -> where('user_ic', $data_user['user_ic']);
		$query = $this -> db ->get('user');
		
		if($query->num_rows() > 0){
			return false;
		}else{
			return $this -> db ->insert('user',$data_user);
		}
	}
	/**
	* this function get the user info according to filter
	* input: $fields- column of the table, $filters - filters
	* author: Jz
	* Date: 19 March 2014
	* Modification Log:
	*/
	function get_user_by_field($fields, $filters){
		$this -> db -> select($fields);
		$this -> db -> where($filters);
		$query = $this -> db -> get('user');
		if($query->num_rows() > 0){
			return $query->result();
		}
	}
	/**
	* this function insert the user role into user_group
	* input: $data = array contain user_id and user_level
	* author: Jz
	* Date: 19 March 2014
	* Modification Log:
	*/
	function insert_user_group($data){
		$this -> db -> insert('user_group',$data);
	}
	/**
	* this function delete the user role into user_group
	* input: $ug_id = user_group id
	* author: Jz
	* Date: 19 March 2014
	* Modification Log:
	*/
	function delete_user_group($ug_id){
		$this -> db -> select('ug_id');
		$this -> db -> where('ug_id',$ug_id);
		$query = $this -> db ->get('user_group');
		
		if($query->num_rows() > 0){
			$this -> db -> where('ug_id',$ug_id);
			$this ->db ->delete('user_group');
			return TRUE;
		}else{
			return FALSE;
		}
		
	}
	/**
	* this function delete the user role into user_group
	* input: $ug_id = user_group id, $data = user_level id
	* author: Jz
	* Date: 19 March 2014
	* Modification Log:
	*/
	function update_current_role($ug_id, $data){
		$this -> db -> select('ug_id');
		$this -> db -> where('ug_id',$ug_id);
		$query = $this -> db ->get('user_group');
		
		if($query->num_rows() > 0){
			$this -> db -> where('ug_id',$ug_id);
			$this ->db -> update('user_group',$data);
			return TRUE;
		}else{
			return FALSE;
		}
	}
	/**
	* this function add the user role into user_group
	* input: $data = user info
	* author: Jz
	* Date: 19 March 2014
	* Modification Log:
	*/
	function add_user_group($data){
		$this -> db -> select('user_id');
		$this -> db -> where('user_id',$data['user_id']);
		$query = $this -> db ->get('user');
		
		if($query->num_rows() > 0){
			$this -> db -> insert('user_group',$data);
			return TRUE;
		}else{
			return FALSE;
		}
	}
	/******************************************************************************************
	 * Description		: this function state the user living
	 * input			: -
	 * author			: Jz
	 * Date				: 3 APRIL 2014
	 * Modification Log	: -
	 ******************************************************************************************/
	function get_state_by_state($state=null) {
		$this -> db -> from('state');
		if ($state != null) {
			$this -> db -> where('state', $state);
		}
		$result=$this -> db -> get() -> result();
		
		foreach ($result as $key) {
			return $key->state_id;
		}
	}
	/*******************************************************************************************
	 * Description 		: this function get all the college from table college
	 * author 			: Jz
	 * Date 			: 3 APRIL 2014
	*******************************************************************************************/
	function get_all_college(){
		$this->db->select('col_id, col_name');
		$this->db->from('college');

		$query = $this->db->get();

		if($query->num_rows()	>	0){
			return $query->result();
		}
	}
}

/**************************************************************************************************
* End of m_management.php
**************************************************************************************************/
?>