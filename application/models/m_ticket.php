<?php
/**************************************************************************************************
* File Name        : m_ticket.php
* Description      : This file for sql query that use at sup
* Author           : Sukor
* Date             : 10 Jun 2013
* Version          : 0.1
* Modification Log : 
* Function List	   : 
**************************************************************************************************/

class M_ticket extends CI_Model
{
	
	
	
	
	
	/**
	* function ni digunakan untuk dapatkan senarai subjek mengikut kursus
	* input: $course_id
	* author: sukor
	* Date: 10 Jun 2013
	* Modification Log: 
	*/
    function student_ticket($centreCode,$course,$year,$semester,$student)
    {
       //GROUP_CONCAT(CAST(mt.mod_id AS char(9)) )
		$p = 'GROUP_CONCAT(m.mod_name ORDER BY m.mod_paper ASC) as subjek_ids,
       		GROUP_CONCAT(m.mod_paper ORDER BY m.mod_paper ASC) as kod_subjek,
       		GROUP_CONCAT(CONCAT(IFNULL(m.mod_type,0))ORDER BY m.mod_paper ASC) as type,
       		GROUP_CONCAT(CONCAT(IFNULL(mt.md_id=na.md_id,0))ORDER BY m.mod_paper ASC) as notattd,
       		GROUP_CONCAT(CONCAT(IFNULL(CAST(mt.mod_id AS char(9)),0))ORDER BY m.mod_paper ASC) as mod_ids,
       		GROUP_CONCAT(CONCAT(IFNULL(CAST(m.mod_credit_hour AS char(9)),0))ORDER BY m.mod_paper ASC) as kredit,
       		s.stu_id,s.stu_gender,count(mt.mod_id) as count_subj,s.stu_name,s.stu_mykad,s.stu_matric_no,
       		c.col_name,c.col_code,mt.mt_semester,mt.mt_year,cou_cluster,cou_name';
		$this -> db -> select($p, FALSE);
		$this -> db -> from('student s');
		$this -> db -> join('college_course cc', 'cc.cc_id=s.cc_id', 'left');
		$this -> db -> join('college c', 'c.col_id=cc.col_id', 'left');
		$this -> db -> join('course cou', 'cou.cou_id=cc.cou_id', 'left');
		$this -> db -> join('module_taken mt', 'mt.stu_id=s.stu_id', 'left');
		$this -> db -> join('module m', 'm.mod_id=mt.mod_id', 'left');
		$this -> db -> join('not_attendance_exam na', 'na.md_id=mt.md_id', 'left');
		if (!empty($centreCode)) {
			$this -> db -> where('c.col_name', $centreCode);
		}
		if (!empty($semester)) {
			$this -> db -> where('mt.mt_semester', $semester);
		}
		if (!empty($year)) {
			$this -> db -> where('mt.mt_year', $year);
		}
		if (!empty($course)) {
			$this -> db -> where('cc.cou_id', $course);
		}
        
		if (!empty($student)) {
			$this -> db -> where('s.stu_matric_no', $student);
		}

		$this -> db -> where('mt.mt_status', 1);

		$this -> db -> group_by('s.stu_id');

		$this -> db -> order_by("s.stu_name", "asc");

		$query = $this -> db -> get();

		if ($query -> num_rows() > 0) {
			return $query -> result();
		}
    }
	
	
	
	
	
	
} // End of class

/**************************************************************************************************
* End of m_sup.php
**************************************************************************************************/
?>