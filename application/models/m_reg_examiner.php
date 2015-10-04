<?php

/**************************************************************************************************
* File Name        : m_class.php
* Description      : This function is to determine the student class by course,semester,year
* Author           : siti umairah
* Date             : 24 October 2013
* Version          : 0.1
* Modification Log : -
* Function List	   : 
**************************************************************************************************/
class m_reg_examiner extends CI_Model {
	
	function insert_pemeriksa($data){
		
		$this->db->insert('user', $data);
		
		
	}
	
	
	function insert_pemeriksa_jawatan($data1){
	
		$this->db->insert('user_group', $data1);
	
	
	}
	
	
	function get_state_id($negeri){
		
		$this->db->select('u.state_id');
		$this->db->from('state s, user u');
		$this->db->where('u.state_id', $negeri);
		
		$query = $this->db->get();
		
		if ($query->num_rows()>0) 
		{
			
			return $query->result();
			
		}
		
	}
	
	
	function get_state(){
		
	$this -> db -> select('s.*');
		$this -> db -> from('state s');
		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}
		
	}
	
	
	function get_level(){
	
		$this -> db -> select('l.*');
		$this -> db -> from('user_level l');
		$query = $this -> db -> get();
	
		if ($query -> num_rows() > 0) {
			return $query -> result();
		}
	
	}
	
	
	function get_user_id($user_id1)
	{
		 
		$this->db->select('u.user_id');
		$this->db->from('user u');
		$this->db->where('u.user_id',$user_id1);
		//$this->db->where('u.user_id = ug.user_id');
		 
		$query = $this->db->get();
		 
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	
	}
	
	
	function get_level_id($ul_id)
	{
			
		$this->db->select('ul.ul_id');
		$this->db->from('user_level ul, user_group ug');
		$this->db->where('ul.ul_id',$ul_id);
		$this->db->where('ul.ul_id = ug.ul_id');
			
		$query = $this->db->get();
			
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	
	}
	
	
	function get_kv_list(){
		
		$this -> db -> select('c.*');
		$this -> db -> from('college c');
		$query = $this -> db -> get();
		
		if ($query -> num_rows() > 0) {
			return $query -> result();
		}
	}
	
	
	
	
	function get_modul($course){	
	
		$this->db->select('cm.cm_id,m.mod_id,m.mod_name,m.mod_paper');
		$this->db->from('course_module cm, module m, course c, college_course cc, college col');
		$this->db->where('col.col_id = cc.col_id');
		$this->db->where('c.cou_id = cc.cou_id');
		$this->db->where('c.cou_id = cm.cou_id');
		$this->db->where('cm.mod_id = m.mod_id');
		$this->db->where('cc.cc_id',$course);
		$st="(m.mod_paper='1104/1' OR m.mod_paper='1104/2' OR m.mod_paper='1104/3')";
		//$at="(m.mod_paper_one='29' OR m.mod_paper_one='30')";
		$this->db->where($st, NULL, FALSE);
		//$this->db->where($at, NULL, FALSE);

		
		$this->db->where('m.mod_sem',4);
				
		$query = $this->db->get();
	
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}		
	
	}
	
	
	function get_course($kolej)
	{
		$this->db->distinct();
		$this->db->select('cc.cc_id,c.*');
		$this->db->from('course c, college_course cc, course_module cm, module m , college col');
		$this->db->where('cc.cou_id = c.cou_id');
		$this->db->where('cc.cou_id = cm.cou_id');		
		$this->db->where('cm.mod_id = m.mod_id');
		$this->db->where('col.col_id = cc.col_id');
		
		//$st="(m.mod_paper='1104/2' OR m.mod_paper='1104/3')";
		//$at="(m.mod_paper_one='29' OR m.mod_paper_one='30')";
		//$this->db->where($st, NULL, FALSE);
		//$this->db->where($at, NULL, FALSE);
		$this->db->where('cm.cm_semester ', 4);
		$st="(m.mod_paper='1104/1' OR m.mod_paper='1104/2' OR m.mod_paper='1104/3')";
	//	$at="(m.mod_paper_one='29' OR m.mod_paper_one='30')";
		$this->db->where($st, NULL, FALSE);
		//$this->db->where($at, NULL, FALSE);
		
		//$this->db->where('m.mod_paper',"1104/2");
		
		
		$this->db->where('cc.col_id',$kolej);
		 
		$query = $this->db->get();
	
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	

	function get_col_id()
	{
		$this->db->select('*');
		$this->db->from('college');
		
			
		$query = $this->db->get();
	
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	
	
	function get_modul_information($course_id,$modul_id)
	{		
		
		$this->db->select('s.stu_id,s.stu_matric_no,s.stu_mykad');
		$this->db->from('student s');
		$this->db->join('college_course cc', 'cc.cc_id = s.cc_id', 'left');
		$this->db->join('module_taken mt', 'mt.stu_id = s.stu_id', 'left');
		$this->db->join('course_module cm', 'cm.cm_semester = s.stu_current_sem AND cm.mod_id = mt.mod_id', 'left');	
		$this->db->group_by('s.stu_matric_no ASC');
				
		$this->db->where('cc.cc_id',$course_id);		
		$this->db->where('cm.cm_id',$modul_id);
		
		$query = $this->db->get();
	
		if ($query->num_rows()>0)
		{
				
			return $query->result();
				
		}
	}
	
	
	function get_cou_id($kolej,$course)
	{
		
		$this->db->select('c.cou_id');
		$this->db->from('course c, college_course cc');
		$this->db->where('c.cou_id = cc.cou_id');
		$this->db->where('cc.col_id',$kolej);
		$this->db->where('cc.cc_id',$course);
			
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
		
		
	}
	
	
	function get_cc_id($course)
	{
	
		$this->db->select('cc.cc_id,c.cou_name');
		$this->db->from('college_course cc, course c');		
		$this->db->where('c.cou_id = cc.cou_id');
		$this->db->where('cc.cc_id', $course);//$this->db->where('cc.col_id', $college_id->col_id);
		 
		$query = $this->db->get();
		 
		if ($query -> num_rows() > 0)
		{
			$cc_id = $query->row();
			return $cc_id->cc_id;
		}
	
	}
	
	//get examiner
	function get_pemeriksa()
	{
		$this->db->select('u.user_id,u.user_name');
		$this->db->from('user u, user_group ug');
		$this->db->where('u.user_id = ug.user_id');
		$this->db->where('ug.ul_id',12);
			
		$query = $this->db->get();
		if($query->num_rows() > 0) {
			return $query->result();
	
		}
	
	}
	
	
	function insert_examiner($exam_reg){
		
			 $this->db->insert_batch('examiner_assign', $exam_reg);	
	
		
	}
	
	function add_id_examiner($pemeriksa) {
		$this->db->select('user_id');
		$this->db->from('user');
		$this->db->where('user_name', $pemeriksa);
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query->result();
	
		}
	}
	
	
	function add_id_kolej($kolej){
		
		$this->db->select('col_id');
		$this->db->from('college');
		$this->db->where_in('col_id', $kolej);	
		
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0) {
			return $query->result();
		
		}
		
	}
	
	
	function get_mod_id() {
		
		$this->db->select('m.mod_id');
		$this->db->from('module m');		
		$this->db->where('m.mod_sem',4);
		$this->db->where('m.mod_paper',"A01401");
		$query = $this->db->get();
		
		if($query->num_rows() > 0) 
		{
			return $query->result();
		}
	}
	
	
	function get_stu_id() {
	
		$this->db->select('s.stu_id');
		$this->db->from('student s, module_taken mt, module m');
		$this->db->where('s.stu_id = mt.stu_id');
		$this->db->where('m.mod_id = mt.mod_id');
		$this->db->where('m.mod_sem',4);
		$this->db->where('m.mod_paper',"A01401");
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
	
	}
	
	function get_mt_semester() {
	
		$this->db->select('mt.mt_semester');
		$this->db->from('student s, module_taken mt, module m');
		$this->db->where('s.stu_id = mt.stu_id');
		$this->db->where('m.mod_id = mt.mod_id');
		$this->db->where('m.mod_sem',4);
		$this->db->where('m.mod_paper',"A01401");
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
	
	}
	
	function get_mt_year() {
	
		$this->db->select('mt.mt_year');
		$this->db->from('student s, module_taken mt, module m');
		$this->db->where('s.stu_id = mt.stu_id');
		$this->db->where('m.mod_id = mt.mod_id');
		$this->db->where('m.mod_sem',4);
		$this->db->where('m.mod_paper',"A01401");
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		
	
	}
	
	function get_mt_full_mark($grade_id) {
	
		$this->db->select('max_mark');
		$this->db->from('grade');
		$this->db->where('grade_id',$grade_id);
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		
	}
	
	
	function get_grade_id($grade_id) {
	
		$this->db->select('grade_id');
		$this->db->from('grade');
		$this->db->where('grade_id',$grade_id);
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		
	}
	
	
	function save_gred_modul($stu_id,$grade_id) {		
		
		$data = array('grade_id' => $grade_id);		
		$this->db->where('stu_id', $stu_id);
		$result = $this->db->update('module_taken', $data);		
		return $result;
		
		
		
	}
	
	
	function get_detail_pemeriksa()
	{
		
		$this->db->select('ea.exam_id, u.user_name, c.col_name');
		$this->db->from('user u, college c, examiner_assign ea, user_group ug');
		$this->db->where('ea.user_id = u.user_id');
		$this->db->where('ea.col_id = c.col_id');
		$this->db->where('u.user_id = ug.user_id');
		$this->db->where('ug.ul_id',12);
		//$this->db->where('m.mod_sem',4);
		//$this->db->where('m.mod_paper',"A01401");
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		
		
	}
	
	
	function get_college()
	{
		$this->db->select('ea.exam_id,c.col_type,c.col_id,c.col_code,c.col_name,ea.user_id');
		$this->db->from('college c, user u, examiner_assign ea');
		$this->db->where('ea.user_id = u.user_id');
		$this->db->where('ea.col_id = c.col_id');	
		$this->db->where('u.user_id', $this->session->userdata('user_id'));
		//$this->db->where('ea.user_id',83);
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}	
		
	}
	
}