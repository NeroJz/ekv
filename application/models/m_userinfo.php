<?php

/**************************************************************************************************
 * File Name        : m_userinfo.php
 * Description      : This File contain Report module.
 * Author           : sukor
 * Date             : 15 july 2013 
 * Version          : -
 * Modification Log : -
 * Function List	   : __construct(),
 **************************************************************************************************/

class M_userinfo extends CI_Model {


/**********************************************************************************************
	 * Description		: this function to get user detail use help
	 * input				: 
	 * author			: sukor
	 * Date				: 15 july 2013
	 * Modification Log	: -
	 **********************************************************************************************/

	function get_user_collegehelp($userId) {
		$this -> db -> select('u.*,c.*');
		$this -> db -> from('user u');
		$this -> db -> join('college c', 'c.col_id=u.col_id', 'left');
		$this->db->where('u.user_id',$userId);
		
		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}
	}
	
	
	
	
	 /**********************************************************************************************
	 * Description		: this function to get user detail 
	 * input				: 
	 * author			: sukor
	 * Date				: 16 july 2013
	 * Modification Log	: -
	 **********************************************************************************************/

	function get_detailuser($userId) {
		$this -> db -> select('u.*,c.*,ul.*');
		$this -> db -> from('user u');
		$this -> db -> join('college c', 'c.col_id=u.col_id', 'left');
		$this -> db -> join('user_group ug', 'ug.user_id=u.user_id', 'left');
		$this -> db -> join('user_level ul', 'ul.ul_id=ug.ul_id', 'left');
		$this->db->where('u.user_id',$userId);
		
		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}
	}


	 /**********************************************************************************************
	 * Description		: this function to update user password
	 * input			: 
	 * author			: Fred
	 * Date				: 12 February 2014
	 * Modification Log	: -
	 **********************************************************************************************/

	function update_pass($userId,$data) {
		
		$this->db->where('user_id', $userId);
		$this->db->update('user', $data);
		
	}
	
}