<?php

class M_import extends CI_Model 
{
	function addStudentTemp($data)
	{
		if($this->db->insert("pelajar_temp", $data))
		{
			return $this->db->insert_id();
		} 
		else 
		{
			return 0;
		}
	}
	
	function addLevelTemp($data)
	{
		if($this->db->insert("level_temp", $data))
		{
			return $this->db->insert_id();
		} 
		else 
		{
			return 0;
		}
	}
	
	function addCollage($data)
	{
		if($this->db->insert("college", $data))
		{
			return $this->db->insert_id();
		} 
		else 
		{
			return 0;
		}
	}
	
	function getKursusIdByKod($kodKursus){
		$this->db->where("kod_kursus",$kodKursus);
		$this->db->from("kursus");
		
		$q = $this->db->get();
		
		if($q->num_rows() > 0)
		{
			foreach($q->result() as $r)
			{
				return $r->kursus_id;
			}
		}
		
		return 0;
	}
	
	function getTemplateAngkaGiliran()
	{
		$this->db->where("opt_name","template_angka_giliran");
		$this->db->from("options");
		
		$q = $this->db->get();
		
		if($q->num_rows() > 0)
		{
			foreach($q->result() as $r)
			{
				return $r->opt_value;
			}
		}
		
		return 0;
	}
	
	function getKvByKodPusat($kodPusat)
	{
		$this->db->where("kod_pusat",$kodPusat);
		$this->db->from("institusi_kv");
		
		$q = $this->db->get();
		
		if($q->num_rows() > 0)
		{
			foreach($q->result() as $r)
			{
				$d[] = $r;
			}
			
			return $d;
		}
	}
	
	function getKvById($kvId)
	{
		$this->db->where("kv_id",$kvId);
		$this->db->from("institusi_kv");
		
		$q = $this->db->get();
		
		if($q->num_rows() > 0)
		{
			foreach($q->result() as $r)
			{
				$d[] = $r;
			}
			
			return $d;
		}
	}
	
	function addImportStudentLevel($student_data, $level_data, $student_id, $level_id)
	{
		$curStudentId = "";
		
		
		if($this->db->insert("pelajar", $student_data))
		{
			$curStudentId = $this->db->insert_id();
			
			if($curStudentId > 0)
			{
				$level_data["id_pelajar"] = $curStudentId;
				
				if($this->db->insert("level", $level_data))
				{
					$curLevelId = $this->db->insert_id();
					return $curLevelId;
				} 
			}
		}
		
		return 0;
		 
	}
	
	function updatePelajarTemp($id, $data)
	{
		$this->db->where('id_pelajar', $id);
		return $this->db->update('pelajar_temp', $data); 
	}
	
	function updateLevelTemp($id, $data)
	{
		$this->db->where('level_id', $id);
		return $this->db->update('level_temp', $data); 
	}
	
	
	
	
	 function check_s($student)
  {
      $this->db->select('*');
        $this->db->from('student');
        $this->db->like('student_id',$student);
        
        $query = $this->db->get();  
        if ($query->num_rows() > 0) {
            return $query->result();
        }
  }
  
  
   function checkcc_id($kod,$kv)
  {
        $this->db->select('*');
        $this->db->from('college_course as cc');
         $this->db->join('college as c', 'c.col_id  = cc.col_id', 'left');
         $this->db->join('course as cs', 'cs.cou_id  = cc.cou_id', 'left');
       
       $this->db->like('c.col_name',$kv);
       $this->db->like('cs.cou_course_code',$kod);
        
        $query = $this->db->get();  
        if ($query->num_rows() > 0) {
            return $query->result();
        }
  }
  
  
    function state($sat)
  {
        $this->db->select('*');
        $this->db->from(' state as s');

       $this->db->where('s.state',$sat);
        
        $query = $this->db->get();  
        if ($query->num_rows() > 0) {
            return $query->result();
        }
  }
  
  
     function col_id($sat)
  {
        $this->db->select('*');
        $this->db->from('college as s');

       $this->db->like('s.col_name',$sat);
        
        $query = $this->db->get();  
        if ($query->num_rows() > 0) {
            return $query->result();
        }
  }
  
  
     function kod_id($sat)
  {
        $this->db->select('*');
        $this->db->from('course as c');

       $this->db->where('c.cou_course_code',$sat);
        
        $query = $this->db->get();  
        if ($query->num_rows() > 0) {
            return $query->result();
        }
  }
  
  
  
    function get_student_id($sat)
  {
        $this->db->select('*');
        $this->db->from('student as s');

       $this->db->where('s.stu_mykad',$sat);
        
        $query = $this->db->get();  
        if ($query->num_rows() > 0) {
            return $query->result();
        }
  }

     function   get_mod_id($sat)
  {
        $this->db->select('*');
        $this->db->from('module as m');
       $this->db->where('m.mod_paper',$sat);
        
        $query = $this->db->get();  
        if ($query->num_rows() > 0) {
            return $query->result();
        }
  }
  
     function   get_grade_id($sat,$s)
  {
        $this->db->select('*');
        $this->db->from('grade as m');

       $this->db->where('m.grade_type',$sat);
        $this->db->where('m.category',$s);
        $this->db->where('m.grade_status','BIASA');
        $query = $this->db->get();  
        if ($query->num_rows() > 0) {
            return $query->result();
        }
  } 
  
  
  
      function   get_value_sem($sat,$getvaluesem)
  {
        $this->db->select('*');
        $this->db->from('result as r');

       $this->db->where('r.stu_id',$sat);
      $this->db->where('r.semester_count',$getvaluesem);
        
        $query = $this->db->get();  
        if ($query->num_rows() > 0) {
            return $query->result();
        }
  } 
  
  
  function get_checkexsit($mod_id,$student_id,$tahun,$sem){
    
     $this->db->select('*');
        $this->db->from('module_taken as mt');

       $this->db->where('mt.mod_id',$mod_id);
        $this->db->where('mt.stu_id',$student_id);
        $this->db->where('mt.mt_semester',$sem);
        $this->db->where('mt.mt_year',$tahun);
        $query = $this->db->get();  
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    
    
  }
 
  
    function  get_checkresult($student_id,$tahun,$sem){
    
     $this->db->select('*');
        $this->db->from('result as r');

      
        $this->db->where('r.stu_id',$student_id);
        $this->db->where('r.semester_count',$sem);
        $this->db->where('r.current_year',$tahun);
        $query = $this->db->get();  
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    
    
  }
  
  function check_course_module($mod,$cou){
    $this->db->select('*');
        $this->db->from('course_module as cm');

        $this->db->where('cm.cou_id',$cou);
        $this->db->where('cm.mod_id',$mod);
        $query = $this->db->get();  
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    
    
  }
  
  function get_studentallkv($sem){
    
        $this->db->select('s.stu_id,s.stu_mykad,mt.md_id,mt.mt_full_mark,mt.mod_id,m.mod_type,m.mod_paper,m.mod_name');
        $this->db->from('student as s');

      $this->db->join('module_taken as mt', 'mt.stu_id = s.stu_id', 'left');
       $this->db->join('module as m', 'm.mod_id = mt.mod_id', 'left');
       $this->db->where('mt.mt_semester',$sem);
        
        
        $query = $this->db->get();  
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    
  }
  
  
  function get_markmodule($md_id){
    
        $this->db->select('*');
        $this->db->from('marks as m');
       $this->db->where('m.md_id',$md_id);
        
        
        $query = $this->db->get();  
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    
  }
  
  /**********************************************************************************************
	 * Description		: this function to insert module
	 * input				: 
	 * author			: Nabihah
	 * Date				: 6 Disember 2013
	 * Modification Log	: -
	 **********************************************************************************************/
  function insert_module($module)
  {
  	$this->db->insert('module', $module);
	$mod_id = $this->db->insert_id();
	return $mod_id;
	
	
  }
  
  /**********************************************************************************************
	 * Description		: this function to insert module ppr
	 * input				: 
	 * author			: Nabihah
	 * Date				: 7 Disember 2013
	 * Modification Log	: -
	 **********************************************************************************************/
  function insert_module_ppr($mod_ppr)
  {
  	$this->db->insert('module_ppr', $mod_ppr);
	
  }
   /**********************************************************************************************
	 * Description		: this function to insert module pt
	 * input				: 
	 * author			: Nabihah
	 * Date				: 7 Disember 2013
	 * Modification Log	: -
	 **********************************************************************************************/
  function insert_module_pt($mod_pt)
  {
  	$this->db->insert('module_pt', $mod_pt);
	
  }
			
}

?>