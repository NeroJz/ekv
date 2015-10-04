<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_kv extends CI_Model 
{
	function kv_list()
	{
		$this->db->select('kv.*, n.negeri');
		$this->db->from('institusi_kv kv, negeri n');
		$this->db->where("kv.negeri = n.id_negeri");
		$this->db->order_by("n.id_negeri");

		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	function choose_kv($kvid)
	{
		$this->db->select('kv.*, n.negeri');
		$this->db->from('institusi_kv kv, negeri n');
		$this->db->where('kv.kv_id', $kvid);
		$this->db->where("kv.negeri = n.id_negeri");
		$this->db->order_by("n.id_negeri");
		
		$query = $this->db->get();

    	if ($query->num_rows() > 0)
		{
        	return $query->row();
		}
	}
	
	function jumlah_murid($kvid)
	{
		$this->db->select('p.id_pusat');
		$this->db->from('pelajar p, institusi_kv kv');
		$this->db->where('kv.kv_id', $kvid);
		$this->db->where("kv.kv_id = p.id_pusat");
		
		$query = $this->db->get();

    	if ($query->num_rows() > 0)
		{
        	return $query->result();
		}
	}
	
	/**
	* function ni digunakan untuk load model query yang digunakan pada modul jadual peperiksaan
	* input: -
	* author: Mior Mohd Hanif
	* Date: 3 Sept 2013
	* Modification Log: 24 Sept 2013 by Mior - asingkan peperiksaan rasmi dan mengulang
	*/
	function get_exam_schedule_rasmi($sesi)
	{
		/* SELECT *, FROM_UNIXTIME(es.schedule_date, '%d-%m-%Y') AS masa
		FROM (`exam_schedule` es, `course_module` cm, `module` m, `course` c)
		WHERE `es`.`cm_id` = cm.cm_id
		AND `cm`.`mod_id` = m.mod_id
		AND `cm`.`cou_id` = c.cou_id
		AND `es`.`session` = '1 2013'
		AND `es`.`schedule_type` = 1
		AND FROM_UNIXTIME(es.schedule_date, '%Y-%m-%d') >= curdate()
		ORDER BY `masa` asc */
		
		$slct = "*,FROM_UNIXTIME(es.schedule_date,'%d-%m-%Y') AS masa";
		
		$this->db->select($slct,FALSE);
		//$this->db->select('*,FROM_UNIXTIME(es.schedule_date,"%d-%m-%Y") AS masa');
        //$this->db->from('exam_schedule es,exam_hall eh,lecturer_assign la,user u,course_module cm,module m,course c');
		 $this->db->from('exam_schedule es,course_module cm,module m,course c');
		//$this->db->where('es.hall_id = eh.hall_id');
		$this->db->where('es.cm_id = cm.cm_id');
		//$this->db->where('la.user_id = u.user_id');
		//$this->db->where('la.cm_id = cm.cm_id');
		$this->db->where('cm.mod_id = m.mod_id');
		$this->db->where('cm.cou_id = c.cou_id');
        $this->db->where('es.session', $sesi);
		$this->db->where('es.schedule_type',1);
		$this->db->where("FROM_UNIXTIME(es.schedule_date, '%Y-%m-%d') >= curdate()");
		$this->db->order_by('masa', 'asc');
	   
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
	}
	
	/**
	* function ni digunakan untuk dapatkan senarai kursus subjek mengikut sesi
	* input: -
	* author: Mior Mohd Hanif
	* Date: 4 Sept 2013
	* Modification Log: 
	*/
	function get_course()
	{
		$this->db->select('*');
        $this->db->from('course');
	   
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
	}

	/**
	* function ni digunakan untuk dapatkan senarai kursus subjek mengikut sesi
	* input: -
	* author: Mior Mohd Hanif
	* Date: 4 Sept 2013
	* Modification Log: 
	*/
	function get_subject()
	{
		$this->db->select('*');
        $this->db->from('module');
        $this->db->where('stat_mod',1);
	   
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
	}
	
	/**
	* function ni digunakan untuk dapatkan senarai dewan exam
	* input: -
	* author: Mior Mohd Hanif
	* Date: 4 Sept 2013
	* Modification Log: 
	*/
	function get_exam_hall()
	{
		$this->db->select('*');
        $this->db->from('exam_hall');
	   
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        }
	}
	
	function get_cm_id($cou_id,$mod_id)
	{
		$this->db->select('cm_id');
        $this->db->from('course_module');
		$this->db->where('cou_id',$cou_id);
		$this->db->where('mod_id',$mod_id);
	   
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->row();
        }
	}
	
	
	/**********************************************************************************************
	* Description		: this function to get student by kv
	* input				: $col_id,$course_id,$semester
	* author			: Freddy Ajang Tony
	* Date				: 08 October 2013
	* Modification Log	: -
	**********************************************************************************************/
	function get_student_by_kv($col_id,$course_id,$semester)
	{
		/* $slct = "*,count(mt.md_id) as jumlah,GROUP_CONCAT(' ',m.mod_name ORDER BY mt.md_id ASC) as subjek,
				 GROUP_CONCAT(eh.hall_name ORDER BY mt.md_id ASC) as tempat,
						  GROUP_CONCAT((CAST(es.schedule_time_start AS char(12))) ORDER BY mt.md_id ASC) as masa,
						  GROUP_CONCAT((CAST(es.schedule_date AS char(20))) ORDER BY mt.md_id ASC) as tarikh";
		
		$this->db->select($slct,FALSE);
		$this->db->from('student s,college_course cc,college col,course c,module_taken mt,module m,course_module cm,exam_schedule es,exam_hall eh');
		$this->db->where('s.cc_id = cc.cc_id');
		$this->db->where('cc.col_id = col.col_id');
		$this->db->where('cc.cou_id = c.cou_id');
		$this->db->where('s.stu_id = mt.stu_id');
		$this->db->where('s.stu_current_sem = mt.mt_semester');
		$this->db->where('s.stu_current_year = mt.mt_year');
		$this->db->where('mt.mod_id = m.mod_id');
		$this->db->where('mt.mod_id = cm.mod_id');
		$this->db->where('mt.mt_semester = cm.cm_semester');
		$this->db->where('cm.cm_id = es.cm_id');
		$this->db->where('es.hall_id = eh.hall_id');
		$this->db->where('cc.col_id',$col_id);
		$this->db->group_by('mt.stu_id');
		$query = $this->db->get(); */
		
		$this->db->select('s.stu_id,s.stu_name,s.stu_mykad,s.stu_matric_no,s.stu_gender,stu_race,
								stu_religion');
		$this->db->from('student s');
		$this->db->join('college_course cc','cc.cc_id = s.cc_id','left');
		$this->db->join('college col','col.col_id = cc.col_id','left');
		$this->db->join('course c','c.cou_id = cc.cou_id','left');
		$this->db->where('cc.col_id',$col_id);
		$this->db->where('c.cou_id',$course_id);
		$this->db->where('s.stu_current_sem',$semester);
		
		$query = $this->db->get();
		
		
		if ($query->num_rows()>0) {
			
			$result = $query->result();
			
			foreach($result as $r)
			{
				if($r->stu_id != null)
				{
					$r->stu_module_exam = $this->get_student_module_exam($r->stu_id,$course_id,$semester);
				}
			}
			
			return $query->result();
		}
	}
	
	
	/**********************************************************************************************
	* Description		: this function to get student module exam by student id
	* input				: $stu_id,$course_id,$semester
	* author			: Freddy Ajang Tony
	* Date				: 08 October 2013
	* Modification Log	: -
	**********************************************************************************************/
	function get_student_module_exam($stu_id,$course_id,$semester)
	{
		/* SELECT m.mod_id,m.mod_code,m.mod_paper,m.mod_name,m.mod_type,m.mod_paper_one,
				es.schedule_date,es.schedule_time_start,es.schedule_time_end
		FROM module m
		LEFT JOIN module_taken mt ON mt.mod_id = m.mod_id
		LEFT JOIN course_module cm ON cm.mod_id = m.mod_id
		LEFT JOIN exam_schedule es ON es.cm_id = cm.cm_id
		WHERE mt.stu_id = 1219
		AND mt.mt_semester = 3
		AND cm.cou_id = 2
		AND m.stat_mod = 1
		ORDER BY es.schedule_date asc,m.mod_code */
		
		$this->db->select('m.mod_id,m.mod_code,m.mod_paper,m.mod_name,m.mod_type,m.mod_paper_one,
							es.schedule_date,es.schedule_time_start,es.schedule_time_end');
		$this->db->from('module m');
		$this->db->join('module_taken mt','mt.mod_id = m.mod_id','left');
		$this->db->join('course_module cm','cm.mod_id = m.mod_id','left');
		$this->db->join('exam_schedule es','es.cm_id = cm.cm_id','left');
		$this->db->where('mt.stu_id',$stu_id);
		$this->db->where('mt.mt_semester',$semester);
		$this->db->where('cm.cou_id',$course_id);
		$this->db->where('es.schedule_type',1);
		//$this->db->where('m.stat_mod',1);
		$this->db->order_by('es.schedule_date asc,m.mod_code');
		
		$query = $this->db->get();
		
		if ($query->num_rows()>0) {
			return $query->result();
		}
	}
	
	
	/**********************************************************************************************
	* Description		: this function to get college code and name
	* input			:
	* author			: Freddy Ajang Tony
	* Date				: 08 october 2013
	* Modification Log	: -
	**********************************************************************************************/
	function get_user_college($col_id)
	{
		$this->db->select('col.col_type,col.col_code,col.col_name');
		$this->db->from('college col');
		$this->db->where('col.col_id',$col_id);
		
		$query = $this->db->get();
		
		if ($query->num_rows()>0) {
			return $query->row();
		}
	}
	
	
	/**********************************************************************************************
	* Description		: this function to save edit schedule
	* input				: $schedule_id,$data
	* author			: Freddy Ajang Tony
	* Date				: 11 October 2013
	* Modification Log	: -
	**********************************************************************************************/
	function save_edit_schedule($schedule_id,$data)
	{
		$this->db->where('schedule_id', $schedule_id);
		$this->db->update('exam_schedule', $data);
		
		return $schedule_id;
	}
	
	
	/**********************************************************************************************
	* Description		: this function to delete schedule
	* input				: $schedule_id
	* author			: Freddy Ajang Tony
	* Date				: 16 October 2013
	* Modification Log	: -
	**********************************************************************************************/
	function delete_exam_schedule($schedule_id)
	{
		$this->db->where('schedule_id', $schedule_id);
		$this->db->delete('exam_schedule');
	
		return $this->db->affected_rows();
	}
	
}

?>