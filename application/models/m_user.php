<?php
/**************************************************************************************************
* File Name        : m_user.php
* Description      : This file is used for query database user
* Author           : Mior Mohd Hanif
* Date             : 26 Jun 2013
* Version          : 0.1
* Modification Log : 
* Function List	   : get_user(), get_user_by_id(), get_course_by_id(), get_user_level(), 
 * 					get_user_level_id_ul_id(), get_user_level_by_ul_name(), get_user_group(),
 * 					get_state(), get_college(), get_user_level_id()
**************************************************************************************************/

class M_user extends CI_Model
{
	/**
	* function ni digunakan untuk dapat senarai pengguna by college id
	* input: -
	* author: Mior Mohd Hanif
	* Date: 26 Jun 2013
	* Modification Log:
	*/
	function get_user($primary_key)
	{
		$this->db->select('user_id,user_name');	
		$this->db->from('user');
		$this->db->where('user_name !=',"");
		$this->db->where('col_id',$primary_key);
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	/**
	* function ni digunakan untuk dapat senarai pengguna by user id
	* input: -
	* author: Mior Mohd Hanif
	* Date: 26 Jun 2013
	* Modification Log:
	*/
	function get_user_by_id($value)
	{
		$this->db->select('user_name');	
		$this->db->from('user');
		$this->db->where('user_id',$value);
		$query = $this->db->get();

    	if ($query->num_rows() > 0)
		{
        	return $query->row();
		}
	}
	
	/**
	* function ni digunakan untuk dapat senarai course by college_cours_id
	* input: -
	* author: Mior Mohd Hanif
	* Date: 28 Jun 2013
	* Modification Log:
	*/
	function get_course_by_id($value)
	{
		$this->db->select('c.*');	
		$this->db->from('college_course as cc');
		$this->db->join('course as c','c.cou_id = cc.cou_id','left');
		$this->db->where('cc.cc_id',$value);
		$query = $this->db->get();

    	if ($query->num_rows() > 0)
		{
        	return $query->row();
		}
	}
	
	/**
	* function ni digunakan untuk dapat senarai user level
	* input: -
	* author: Mior Mohd Hanif
	* Date: 2 Julai 2013
	* Modification Log:
	*/
	function get_user_level()
	{
		$this->db->select('*');	
		$this->db->from('user_level');
		$query = $this->db->get();

    	if ($query->num_rows() > 0)
		{
        	return $query->result();
		}
	}
	
	/**
	* function ni digunakan untuk dapat user level id
	* input: -
	* author: Mior Mohd Hanif
	* Date: 2 Julai 2013
	* Modification Log:
	*/
	function get_user_level_id_ul_id($value, $primary_key)
	{
		$this->db->select('ul.ul_id,ul.ul_name');	
		$this->db->from('user_group as ug');
		$this->db->join('user_level as ul','ul.ul_id = ug.ul_id','left');
		$this->db->where('ug.ul_id',$value);
		$this->db->where('ug.user_id',$primary_key);
		$query = $this->db->get();

    	if ($query->num_rows() > 0)
		{
        	return $query->result();
		}
	}
	
	
	/**
	* function ni digunakan untuk dapat user level id
	* input: -
	* author: Mior Mohd Hanif
	* Date: 2 Julai 2013
	* Modification Log:
	*/
	function get_user_level_by_ul_name($value,$primary_key)
	{
		$this->db->select('ul.ul_type,ul.ul_name');	
		$this->db->from('user_level as ul');
		$this->db->where('ul.ul_id',$value);
		$query = $this->db->get();

    	if ($query->num_rows() > 0)
		{
        	return $query->row();
		}
	}
	
	/**
	* function ni digunakan untuk dapat user group id
	* input: -
	* author: Mior Mohd Hanif
	* Date: 3 Julai 2013
	* Modification Log:
	*/
	function get_user_group($primary_key)
	{
		$this->db->select('ug.ug_id');	
		$this->db->from('user_group as ug');
		$this->db->where('ug.user_id',$primary_key);
		$query = $this->db->get();

    	if ($query->num_rows() > 0)
		{
        	return $query->row();
		}
		
	}
	
	/**
	* function ni digunakan untuk dapatkan negeri
	* input: -
	* author: Mior Mohd Hanif
	* Date: 9 Julai 2013
	* Modification Log:
	*/
	function get_state($value)
	{
		$this->db->select('state');	
		$this->db->from('state');
		$this->db->where('state_id',$value);
		$query = $this->db->get();

    	if ($query->num_rows() > 0)
		{
        	return $query->row();
		}
	}

	/**
	* function ni digunakan untuk dapatkan kolej
	* input: -
	* author: Mior Mohd Hanif
	* Date: 9 Julai 2013
	* Modification Log:
	*/
	function get_college($value="")
	{
		$this->db->select('col_id,col_name');	
		$this->db->from('college');
		$this->db->where('state_id',$value);
		$this->db->where('col_type',"K");
		$query = $this->db->get();

    	if ($query->num_rows() > 0)
		{
        	return $query->result();
		}
	}
	
	/**
	* function ni digunakan untuk dapat user level id
	* input: -
	* author: Mior Mohd Hanif
	* Date: 11 Julai 2013
	* Modification Log:
	*/
	function get_user_level_id($value)
	{
		$this->db->select('ul_id');	
		$this->db->from('user_level');
		$this->db->where('ul_name',$value);
		$query = $this->db->get();

    	if ($query->num_rows() > 0)
		{
        	return $query->row();
		}
	}
	
	/**
	* function ni digunakan untuk dapatkan kolej awam dan swasta
	* input: -
	* author: Mior Mohd Hanif
	* Date: 15 Julai 2013
	* Modification Log:
	*/
	function get_college_for_bptv()
	{
		$this->db->select('col_id,col_name');	
		$this->db->from('college');
		$this->db->where('col_type !=',"K");
		$query = $this->db->get();

    	if ($query->num_rows() > 0)
		{
        	return $query->result();
		}
	}
	
	/**
	* function ni digunakan untuk dapatkan kolej awam dan swasta
	* input: -
	* author: Nabihah
	* Date: 11 disember  2013
	* Modification Log:
	*/
	function get_all_college()
	{
		$this->db->select('col_id,col_name');	
		$this->db->from('college');
		
		$query = $this->db->get();

    	if ($query->num_rows() > 0)
		{
        	return $query->result();
		}
	}

	/*
	* function ini digunakan untuk dapatkan col_id bagi kolej bila user login
	* input: -
	* author: Nursyahira Adlin
	* Date: 10 April 2014
	* Modification Log:
	*/
	function get_college_by_user_id($user_id)
	{
		$this->db->select('col_id');	
		$this->db->from('user');
		$this->db->where('user_id', $user_id);

		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
        	return $query->row();
		}
	}

	/*function ini digunakan untuk dapatkan maklumat kolej mangikut col_id
	* input: -
	* author: Nursyahira Adlin
	* Date: 10 April 2014
	* Modification Log: 34/4/2014 - edit query by Norafiq
	*/
	function get_college_by_col_id($col_id)
	{
		$this->db->select('col.*');	
		$this->db->from('college col');
		$this->db->where('col.col_id',$col_id);

		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
        	return $query->row();
		}
	}

	/*function ini digunakan untuk dapatkan nama pengarah kolej
	* input: -
	* author: Nursyahira Adlin
	* Date: 10 April 2014
	* Modification Log:
	*/
	function get_user_by_col_id($col_id)
	{
		$this->db->select('col.*, u.*, ug.*, ul.*');	
		$this->db->from('college col, user u, user_group ug, user_level ul');
		$this->db->where('col.col_id',$col_id);
		$this->db->where('u.col_id = col.col_id');
		$this->db->where('ug.user_id = u.user_id');
		$this->db->where('ul.ul_id = ug.ul_id');
		$this->db->where("ul.ul_id in (5, 6)");

		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
        	return $query->result();
		}
	}

	/*function ini digunakan untuk kemaskini maklumat bagi nama pengarah kolej
	* input: -
	* author: Nursyahira Adlin
	* Date: 11 April 2014
	* Modification Log:
	*/
	function update_user_info1($user_id, $col_id, $data_user1)
	{
		$this->db->where('user_id', $user_id);
		$this->db->where('col_id', $col_id);
		$this->db->update('user', $data_user1);
	}

	/*function ini digunakan untuk kemaskini maklumat no tel kolej dan email
	* input: -
	* author: Nursyahira Adlin
	* Date: 11 April 2014
	* Modification Log:
	*/
	function update_college_info2($col_id, $data_user2)
	{
		$this->db->where('col_id',$col_id);
		$this->db->update('college',$data_user2);
	}

	/*function ini digunakan untuk paparkan nama kolej
	* input: -
	* author: Nursyahira Adlin
	* Date: 11 April 2014
	* Modification Log:
	*/
	function get_college_name_info($col_name)
	{
		$this->db->select('*');	
		$this->db->from('college');
		$this->db->where('col_name',$col_name);
		
		$query = $this->db->get();

    	if ($query->num_rows() > 0)
		{
        	return $query->result();
		}
	}

	/*function ini digunakan untuk paparkan no telefon kolej
	* input: -
	* author: Nursyahira Adlin
	* Date: 13 April 2014
	* Modification Log:
	*/
	function get_college_phone_info($col_phone)
	{
		$this->db->select('*');	
		$this->db->from('college');
		$this->db->where('col_phone',$col_phone);
		
		$query = $this->db->get();

    	if ($query->num_rows() > 0)
		{
        	return $query->result();
		}
	}

	/*function ini digunakan untuk paparkan email kolej
	* input: -
	* author: Nursyahira Adlin
	* Date: 13 April 2014
	* Modification Log:
	*/
	function get_college_email_info($col_email)
	{
		$this->db->select('*');	
		$this->db->from('college');
		$this->db->where('col_email',$col_email);
		
		$query = $this->db->get();

    	if ($query->num_rows() > 0)
		{
        	return $query->result();
		}
	}

	/*function ini digunakan untuk paparkan timbalan pengarah kolej
	* input: -
	* author: Nursyahira Adlin
	* Date: 14 April 2014
	* Modification Log:
	*/
	function get_dep_director_by_id($col_dep_director){
		$this->db->select('*');	
		$this->db->from('user');
		$this->db->where('user_id',$col_dep_director);

		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
        	return $query->row();
		}
	}

	/*function ini digunakan untuk paparkan kjpp kolej
	* input: -
	* author: Nursyahira Adlin
	* Date: 14 April 2014
	* Modification Log:
	*/
	function get_kjpp_by_id($col_kjpp){
		$this->db->select('*');	
		$this->db->from('user');
		$this->db->where('user_id',$col_kjpp);

		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
        	return $query->row();
		}
	}

	/************************************************************************************
 	* Description		: this function is use to return the user_name call from helper
 	* input				: -
 	* author			: Jz
 	* Date				: 07-04-2014
 	* Modification Log	:
 	*************************************************************************************/
 	function return_user_name($user_id){
 		$this->db->select('user_name');
		$this->db->from('user');
		$this->db->where('user_id',$user_id);
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$result = $query->result_array();
			return $result[0]['user_name'];
		}
 	}
	/************************************************************************************
 	* Description		: this function update image path
 	* input				: -
 	* author			: Nabihah
 	* Date				: 28042014
 	* Modification Log	:
 	*************************************************************************************/
	
	function insert_path_image($data, $col_id)
	{
		$this->db->where('col_id', $col_id);
		$this->db->update('college', $data);
	}
	
	/************************************************************************************
 	* Description		: this function get image path
 	* input				: -
 	* author			: Nabihah
 	* Date				: 29042014
 	* Modification Log	:
 	*************************************************************************************/
	
	function get_img($col_id)
	{
		$this->db->select('c.col_image');	
		$this->db->from('college c');
		$this->db->where('c.col_id',$col_id);

		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
        	return $query->row();
		}
	}
	
	/************************************************************************************
 	* Description		: this function update stamp path
 	* input				: -
 	* author			: Nabihah
 	* Date				: 29042014
 	* Modification Log	:
 	*************************************************************************************/
	
	function get_stamp($col_id)
	{
		$this->db->select('c.col_stamp');	
		$this->db->from('college c');
		$this->db->where('c.col_id',$col_id);

		$query = $this->db->get();
		if ($query->num_rows() > 0)
		{
        	return $query->row();
		}
	}
	
	
}

/**************************************************************************************************
* End of m_user.php
**************************************************************************************************/
?>