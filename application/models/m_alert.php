<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**************************************************************************************************
* File Name        : m_alert.php
* Description      : This File contain model for general.
* Author           : Ku Ahmad Mudrikah
* Date             : 27 Sept 2013
* Version          : 0.1
* Modification Log : 
* Function List	   : 
**************************************************************************************************/
class M_alert extends CI_Model 
{
	function get_ulid_by_userid($user_id){
		$this->db->select('ul_id');
		$this->db->from('user_group');
		$this->db->where('user_id',$user_id);
		$resultObj=$this->db->get();
		if($resultObj->num_rows()==1){
			foreach ($resultObj->result() as $key) {
				return $key->ul_id;
			}
		}
	}
	
	function get_enddate($ul_id){
		$this->db->select('end_date_user');
		$this->db->from('user_level_manual_configuration');
		$this->db->where('ul_id',$ul_id);
		$this->db->group_by('end_date_user');
		return $resultObj=$this->db->get()->result_array();
	}
}