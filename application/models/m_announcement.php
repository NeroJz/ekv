<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**************************************************************************************************
* File Name        : m_general.php
* Description      : This File contain model for general.
* Author           : Fakhruz
* Date             : 29 June 2013
* Version          : 0.1
* Modification Log : 
* Function List	   : 
**************************************************************************************************/
class M_announcement extends CI_Model 
{
	function get_announcement_details(){
		$date=date('Y-m-d',time());
		$time = strtotime($date);
		
		$this->db->select('*');
		$this->db->from('announcement');
		$this->db->where('ann_status',1);
		$this->db->where('UNIX_TIMESTAMP(ann_open_date) <=',$time);
		$this->db->where('UNIX_TIMESTAMP(ann_close_date) >=',$time);
		return $query=$this->db->get()->result_array();
	}
	
	function get_announcement_by_kv($col_id){
		$date=date('Y-m-d',time());
		$time = strtotime($date);
		
		$this->db->select('*');
		$this->db->from('announcement');
		$this->db->join('announcement_college', 'announcement_college.ann_id = announcement.ann_id');
		$this->db->where('announcement.ann_status',1);
		$this->db->where('UNIX_TIMESTAMP(ann_open_date) <=',$time);
		$this->db->where('UNIX_TIMESTAMP(ann_close_date) >=',$time);
		$this->db->where('announcement_college.col_id',$col_id);
		$this->db->or_where('announcement_college.col_id',0);
		
		return $query=$this->db->get()->result_array();
	}
	
	function add_announcement($data){
		$this->db->insert('announcement', $data); 
	}
	
	function add_announcement_college($data){
		$this->db->insert('announcement_college', $data);
	}
	
	function get_last_row(){
		$query=$this->db->get('announcement');
		return $row = $query->last_row();
	}
	
	function get_announcement_by_id($ann_id){
		$this->db->select('*');
		$this->db->from('announcement');
		$this->db->where('ann_id',$ann_id);
		return $query=$this->db->get()->result_array();
	}
	
	function insert_announcement($aDetails,$aCol_id){
		$ann_id=null;
		//insert into `announcement`
		$data = array(
			'ann_title' => $aDetails['title'],
			'ann_content' => $aDetails['content'],
			'ann_open_date' => $aDetails['open_date'],
			'ann_close_date' => $aDetails['close_date'],
			'ann_status' => $aDetails['status'],
			'user_id' => $aDetails['user_id']
		);

		$this->db->insert('announcement', $data);
		
		//get ann_id
		$this->db->select('ann_id');
		$this->db->from('announcement');
		$result=$this->db->get()->result();
		
		foreach ($result as $key) {
			$ann_id=$key->ann_id;
		}
		
		//insert into `announcement_college`
		foreach ($aCol_id as $key1) {
			$data1=array(
				'col_id'=>$key1,
				'ann_id'=>$ann_id
			);
			$this->db->insert('announcement_college',$data1);
		}
	}

	function get_ann_table($colid=''){
		$this->db->select("a.ann_title, a.ann_content, a.ann_open_date, a.ann_close_date, a.user_id, a.ann_status");
		$this->db->from('announcement a');
		if($colid!='')
			$this->db->where('ac.col_id',$colid);
		$this->db->join('announcement_college ac','ac.ann_id = a.ann_id','left');
		$this->db->group_by('a.ann_id');
		return $this->db->get();
	}
    
     /**********************************************************************************************
     * Description      : 
     * input                : 
     * author           : sukor
     * Date             : 24 januari 2014
     * Modification Log : -
     **********************************************************************************************/ 
    
    function get_announcement_id($ann_id,$colid,$open_date){
   
        $this->db->select('a.*,GROUP_CONCAT(ac.col_id) as col_ids');
        $this->db->from('announcement a');  
        $this->db->join('announcement_college ac', 'ac.ann_id = a.ann_id','left');   
        $this->db->where('a.ann_status',1);
       
        $this->db->where('a.ann_id',$ann_id);
        $this->db->where('a.ann_open_date',$open_date);
         $this->db->where('a.ann_status',1);
       $this -> db -> group_by('a.ann_id');
        
        return $query=$this->db->get()->result_array();
    }
    
 /**********************************************************************************************
     * Description      : 
     * input                : 
     * author           : sukor
     * Date             : 24 januari 2014
     * Modification Log : -
     **********************************************************************************************/ 
   function get_user_email($col)
    {
 
        $this -> db -> select("u.user_email");
        $this -> db -> from('user u');
        if(!empty($col)){
          $this->db->where_in('u.col_id',$col);   
        }
        $this->db->where_in('u.active',1); 
       
        $query = $this -> db -> get();

        if ($query -> num_rows() > 0) {
            return $query -> result();
        }

    }
    
 /**********************************************************************************************
     * Description      : 
     * input                : 
     * author           : sukor
     * Date             : 24 januari 2014
     * Modification Log : -
     **********************************************************************************************/ 
      function get_announcement_byopen($open_date){
   
        $this->db->select('a.*,GROUP_CONCAT(ac.col_id) as col_ids,u.user_email');
        $this->db->from('announcement a');  
        $this->db->join('announcement_college ac', 'ac.ann_id = a.ann_id','left'); 
         $this->db->join('user u', 'u.user_id = a.user_id','left');     
        $this->db->where('a.ann_status',1);
       
        //$this->db->where('a.ann_id',$ann_id);
        $this->db->where('a.ann_open_date',$open_date);
         $this->db->where('a.ann_status',1);
          $this->db->where('a.ann_status_push',1);
         
       $this -> db -> group_by('a.ann_id');
        
       $query = $this -> db -> get();

        if ($query -> num_rows() > 0) {
            return $query -> result();
        }
    }
    
    
}
/**************************************************************************************************
* End of m_announcement.php
**************************************************************************************************/
?>