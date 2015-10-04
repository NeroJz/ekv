<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**************************************************************************************************
* File Name        : m_general.php
* Description      : This File contain model for general.
* Author           : Ku Ahmad Mudrikah
* Date             : 29 June 2013
* Version          : 0.1
* Modification Log : 
* Function List	   : 
**************************************************************************************************/
class M_maintenance extends CI_Model 
{
	function get_course_custom(){
		$query="
			SELECT `course`.*, (
				SELECT GROUP_CONCAT(DISTINCT college.col_name) 
				FROM college 
				LEFT JOIN college_course 
				ON college_course.col_id = college.col_id 
				WHERE college_course.cou_id = `course`.cou_id 
				GROUP BY college_course.cou_id) 
			AS KV 
			FROM (`course`)";
		return $this->db->query($query);
	}
	
	function get_cc_id($col_id,$cou_id){
		$this->db->select('*');
		$this->db->from('college_course');
		$this->db->where('col_id',$col_id);
		$this->db->where('cou_id',$cou_id);
		return $this->db->get();
	}
	
	function remove_cc($cc_id){
		$this->db->where('cc_id', $cc_id);
		$this->db->delete('college_course');
	}
	
	function get_course($id=null){
		$this->db->select('*');
		$this->db->from('course');
		if($id!=null){
			$this->db->where('cou_id',$id);
		}
		return $this->db->get();
	}
	
	function get_course_detail($cou_id=null){
		$this->db->select('*');
		$this->db->from('college_course');
		$this->db->where('cou_id',$cou_id);
		$cc_result=$this->db->get()->result();
		$college=array();
		foreach ($cc_result as $key) {
			$this->db->select('*');
			$this->db->from('college');
			$this->db->where('col_id',$key->col_id);
			$college[]=$this->db->get()->result();
		}
		return $college;
	}
	
	function get_mod_id(){
		$this->db->select_max('mod_id');
		$query = $this->db->get('module')->result_array();
		return $query[0]['mod_id'];
	}
	
	function get_ppr_by_id($mod_id,$category){
		$this->db->select("*");
		$this->db->from("module_ppr");
		$this->db->where("mod_id",$mod_id);
		$this->db->where("ppr_category",$category);
		return $this->db->get();
	}
	
	function get_pt_by_id($mod_id,$category){
		$this->db->select("*");
		$this->db->from("module_pt");
		$this->db->where("mod_id",$mod_id);
		$this->db->where("pt_category",$category);
		return $this->db->get();
	}
	
	function insert_cc($col_id='',$cou_id=''){
		$data = array(
			'col_id' => $col_id,
			'cou_id' => $cou_id
		);

		$this->db->insert('college_course', $data); 
	}
	
	function insert_module($data){
		return $this->db->insert('module',$data);
	}

	function insert_module_ppr($data){
		return $this->db->insert_batch('module_ppr',$data);
	}

	function insert_module_pt($data){
		return $this->db->insert_batch('module_pt',$data);
	}
	
	function insert_course_module($data){
		return $this->db->insert_batch('course_module',$data);
	}
	
	function update_module($id,$data){
		$this->db->where('mod_id', $id);
		return $this->db->update('module', $data);
	}
	
	function update_module_pt($id,$category,$data){
		$this->db->where('mod_id', $id);
		$this->db->where('pt_category', $category);
		return $this->db->update('module_pt', $data);
	}
	
	function update_module_ppr($id,$category,$data){
		$this->db->where('mod_id', $id);
		$this->db->where('ppr_category', $category);
		return $this->db->update('module_ppr', $data);
	}
	
	function update_cou_code($id,$cou_code,$cou_course_code){
		$data = array(
				'cou_code' => $cou_code,
				'cou_course_code' => $cou_course_code,
				);

		$this->db->where('cou_id', $id);
		$this->db->update('course', $data);
		redirect(site_url()."/maintenance/crud_course");
	}
	
	function delete_course_module($id){
		$this->db->where('mod_id', $id);
		$this->db->delete('course_module'); 
	}

	function delete_cm($id){
		$this->db->where('cm_id', $id);
		return $this->db->delete('course_module'); 
	}

	function edit_cm($id){
		$this->db->where('cm_id', $id);
		return $this->db->update('course_module'); 
	}
	
	function activate_status($id){
		$data=array(
			'stat_mod'=>1
		);
		$this->db->where('mod_id', $id);
		$this->db->update('module',$data);
	}
	
	function deactivate_status($id){
		$data=array(
			'stat_mod'=>0
		);
		$this->db->where('mod_id', $id);
		$this->db->update('module',$data);
	}

	function get_course_autocomplete($cou_id="") {

		$this -> db -> select('c.*');
		$this -> db -> from('course c');
		
        if (!empty($cou_id)) {
			$this -> db -> where('c.cou_id', $cou_id);
		}
		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			$data = $query -> result();
			$course = '';
			foreach ($data as $row) {
				$course .= '['.$row->cou_id.',"';
				$course .= $row -> cou_name." - ".$row->cou_code;

				$course .= '"],';
			}
			return $course;
		}
	}
}
/**************************************************************************************************
* End of m_general.php
**************************************************************************************************/
?>