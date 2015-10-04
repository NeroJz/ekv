
<?php

class M_assignsubject extends CI_Model 
{
	function course_list($col_id)
	{
		$this->db->select('c.*');
		$this->db->from('course c, college_course cc, user u');
		$this->db->where("c.cou_id = cc.cou_id");
		
		$this->db->where('cc.col_id', $col_id);
		//$this->db->where('cc.col_id', 49);
		$this->db->order_by("c.cou_code");
		$this->db->group_by("cou_code");

		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	/******************************************************************************************
		* Description		: Get course list based on user_id
		* input				: - 
		* author			: Nabihah Ab.Karim
		* Date				: 23 July 2013
		* Modification Log	: -
		******************************************************************************************/
	
	function course_list_user($col_id="")
	{
		$this->db->select('c.*');
		$this->db->from('course c, college_course cc, user u');
		$this->db->where("c.cou_id = cc.cou_id");
		$this->db->where("u.col_id = cc.col_id");
		
		$this->db->where('cc.col_id', $col_id);
		//$this->db->where('cc.col_id', 49);
		$this->db->order_by("c.cou_code ASC");
		$this->db->group_by("c.cou_code ASC");

		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	/******************************************************************************************
		* Description		: Get subject list by semester
		* input				: - 
		* author			: Nabihah Ab.Karim
		* Date				: 03 July 2013
		* Modification Log	: -
		******************************************************************************************/
	
	 function get_subject_list_bysem($course_id="", $semester="") 
	 {
        $this->db->select('distinct(cm.cm_id),m.*');
        $this->db->from('module m, course_module cm');
		$this->db->where('cm.mod_id = m.mod_id');
        $this->db->where('cm.cou_id',$course_id);
		$this->db->where('cm.cm_semester', $semester);
		$this->db->where('m.stat_mod', 1);
       
        $this->db->order_by('m.mod_code ASC');
        $this->db->group_by('m.mod_id');
        $query = $this->db->get();

        if ($query->num_rows() > 0) 
        {
            return $query->result();
        }
    }
	 
	 	/******************************************************************************************
		* Description		: Get subject list
		* input				: - 
		* author			: Nabihah Ab.Karim
		* Date				: 12 September 2013
		* Modification Log	: - siti umairah - 6 november 2013
		******************************************************************************************/
	
	 function get_subject_list($course_id="",$semester="") 
	 {
        $this->db->select('distinct(cm.cm_id),m.*');
        $this->db->from('module m,course_module cm');
		$this->db->where('cm.mod_id = m.mod_id');
		$this->db->where('cm.cm_semester',$semester);
        $this->db->where('cm.cou_id',$course_id);
		$this->db->where('m.stat_mod', 1);
       
        $this->db->order_by('m.mod_code ASC');
		$this->db->group_by('m.mod_code');
		
        $query = $this->db->get();

        if ($query->num_rows() > 0) 
        {
            return $query->result();
        }
    }
	 
 

	  function get_group($course_id, $col_id, $semester) 
	 {
        $this->db->select('distinct(c.class_id),c.class_name');
        $this->db->from('college_course cc, class c');
		$this->db->where('c.class_status', 1);
        //$this->db->where('c.class_id = st.stu_group');
		//$this->db->where('cm.mod_id = m.mod_id');
       // $this->db->where('st.cc_id = cc.cc_id');
		$this->db->where('cc.col_id', $col_id);
		$this->db->where('cc.cou_id', $course_id);
		$this->db->where('c.class_sem', $semester);
		$this->db->where('cc.cc_id = c.cc_id');
		$this->db->where('c.class_status',1);
		//$this->db->where('la.current_year = c.class_session');
       
      //  $this->db->order_by('m.mod_id');
        $query = $this->db->get();

        if ($query->num_rows() > 0) 
        {
            return $query->result();
        }
    }
	 
	 function staff_detail_search($queryString="", $col_id="") 
	{
		$query = "u.user_id, u.user_name , ul.ul_name FROM user u, user_group ug, user_level ul WHERE u.user_id = ug.user_id AND ug.ul_id = ul.ul_id AND ul.ul_id in(3) AND 
		u.col_id = ".$col_id." AND (u.user_name) LIKE '%".$queryString."%'";

		$this->db->select($query, FALSE);

		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	function get_course_module($course,$subject,$semester="")
	{
		$this->db->select('cm_id');
		$this->db->from('course_module');
     //   $this->db->where('cm_semester', $semester);
		$this->db->where('cou_id', $course);
		$this->db->where('mod_id', $subject);
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$getCmId = $query->row();
			
			return $getCmId->cm_id;
		}
		else
		{
			$courModule = array(
				'cm_semester'=>$semester,
				'cou_id'=>$course,
				'mod_id'=>$subject
			);
			
			$this->db->insert("course_module", $courModule);
			return $this->db->insert_id();
			
		}
	}

	function insert_subj_lect($data)
	{
		
		$this->db->insert("lecturer_assign", $data);
		return $this->db->insert_id();
			
	}
	
	/******************************************************************************************
		* Description		: Check Lecturer untk course module
		* input				: - 
		* author			: Nabihah Ab.Karim
		* Date				: 27 January 2014
		* Modification Log	: -
	******************************************************************************************/
			
	function check_lecturer($cm_id, $year, $group_no)
	{
		$this->db->select('la_id, user_id, la_id_parent');
		$this->db->from('lecturer_assign');
		$this->db->where('cm_id', $cm_id);
		$this->db->where('la_current_year', $year);
		$this->db->where('la_group',$group_no);
		$this->db->where('la_status',1);
		$this->db->order_by('la_id_parent ASC');
		$query = $this->db->get();
		
		 if ($query->num_rows() > 0) 
        {
			return $query->result();
		
			
		}
	}
	
	/******************************************************************************************
		* Description		: update la_id untuk assign user_id lain sebagai parent
		* input				: - 
		* author			: Nabihah Ab.Karim
		* Date				: 27 January 2014
		* Modification Log	: -
	******************************************************************************************/
			
	function update_subj_lect($data, $la_id)
	{
			$this->db->where('la_id', $la_id);
			$i = $this->db->update('lecturer_assign', $data); 
	}
	
	/******************************************************************************************
		* Description		: delete la_id (child)
		* input				: - 
		* author			: Nabihah Ab.Karim
		* Date				: 27 January 2014
		* Modification Log	: -
	******************************************************************************************/
			
	function delete_subj_lect($la_id)
	{
			$this->db->where('la_id', $la_id);
			$this->db->delete('lecturer_assign'); 
	}
		/******************************************************************************************
		* Description		: Get code id
		* input				: - 
		* author			: Nabihah Ab.Karim
		* Date				: 24 July 2013
		* Modification Log	: -
		******************************************************************************************/
			
	function code_college() 
	{
        $this->db->select(' * ');
        $this->db->from('college');

        $query = $this->db->get();

        if ($query->num_rows() > 0) 
        {
            $data = $query->result();
            $cod_col = '';
            foreach ($data as $row) 
            {
                $cod_col .= '"';
				$cod_col .= strtoupper($row->col_name);
				$cod_col .= '- ';
                $cod_col .= strtoupper($row->col_type);
				$cod_col .= strtoupper($row->col_code);
                $cod_col .= '",';
            }
            return $cod_col;
        }
    }
	/******************************************************************************************
		* Description		: Get course list based on colleg_id
		* input				: - 
		* author			: Nabihah Ab.Karim
		* Date				: 11 July 2013
		* Modification Log	: -
	******************************************************************************************/
	function get_course($college="")
	{
		$this->db->select('*');
		$this->db->from('college_course cc, college cl, course co');
		$this->db->where('cl.col_id = cc.col_id');
		$this->db->where('cc.cou_id = co.cou_id');
		
		$this->db->like('cl.col_name', $college);

		$query = $this->db->get();
		{
			return $query->result();
		}
	}
	
	/******************************************************************************************
		* Description		: Get courseid based on user id
		* input				: - 
		* author			: Nabihah Ab.Karim
		* Date				: 24 July 2013
		* Modification Log	: -
		******************************************************************************************/
	function get_college_id($user_id)
	{
		$this->db->select('u.col_id');
		$this->db->from('user u');
		$this->db->where('u.user_id', $user_id);
		
		$query = $this->db->get();
		
		 if ($query->num_rows() > 0) 
		{
			return $query->row();
		}
	}
	
	
	/******************************************************************************************
		* Description		: get lecturer name based on course, subject and group
		* input				: - 
		* author			: Nabihah Ab.Karim
		* Date				: 29 July 2013
		* Modification Log	: -
		******************************************************************************************/
	
	function get_lecturer_subjectgroup($cou_id="",$semester="", $mod_id="",$group_no="", $col_id="", $status="") 
	{
		$year = $this->session->userdata('tahun');
		$sesi = $this->session->userdata('sesi');
        $this->db->select('cm.cm_id');
        $this->db->from('course_module cm');
     //   $this->db->where('cm_semester', $semester);
        $this->db->where('cou_id', $cou_id);
        $this->db->where('mod_id', $mod_id);
		
        $query = $this->db->get();
		
        $cm_id = $query->row();
        
        $this->db->select('u.user_name, u.user_id, la.cm_id, la.la_group, ul.ul_name');
        $this->db->from('user u, lecturer_assign la, user_group ug, user_level ul');
       // $this->db->where('s.staff_id in ((select staff_id from staff_subject_group where course_subject_id='.$course_subject_id.' and level_group_no = '.$group_no.'))');
        $this->db->where('u.user_id = ug.user_id');
		$this->db->where('ul.ul_id = ug.ul_id');
        $this->db->where('la.cm_id', $cm_id->cm_id);
		//untuk repeat module yang tiada kelas
		if($group_no!=0 || $group_no!="")
        $this->db->where('la.la_group', $group_no);
		$this->db->where('la.user_id = u.user_id');
		$this->db->where('u.col_id', $col_id);
		$this->db->where('la.la_current_year', $year);
		$this->db->where('la.la_current_session', $sesi);
		$this->db->where('la.la_status', $status);
		
		$this->db->order_by('la.la_id_parent ASC');
		
    	$this->db->group_by("u.user_id");
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) 
        {
        	//return array();
            return $query->result();
        }
			
		
    }
	
	/******************************************************************************************
     * Description                : Display lecturer
     * input                                : - 
     * author                        : Nabihah Ab.Karim
     * Date                                : 17 July 2013
     * Modification Log        : - siti umairah 6 november 2013 & 13 november 2013
     ******************************************************************************************/
        
        function get_subject_lecturer_by_paging($col_id="")
        {
                $arr_d = array();
       			$sOrder = "";
                 
                $ar_search['c.cou_id']= $_POST['course'];
                $ar_search['m.mod_id'] = $_POST['subject'];
                $ar_search['u.user_name'] = $_POST['lecturer'];
                $ar_search['la.la_current_semester'] = $_POST['semester'];
				$ar_search['la.la_status'] = $_POST['status'];
				$ar_search['la.la_current_year'] = $this->session->userdata('tahun');
				$ar_search['la.la_current_session'] = $this->session->userdata('sesi');
                //$ar_search['la.la_group'] =$_POST['group'];                
                   
        /* Ordering */
        if (isset($_POST['iSortCol_0'])) 
        {
            $sOrsder = "ORDER BY ";
            for ($i = 0; $i < ($_POST['iSortingCols'] ); $i++) 
            {
                $this->db->order_by($this->fnColumnToField($_POST['iSortCol_' . $i]), $_POST['sSortDir_' . $i]);
            }
        }

        $sWhere = "";
                
                if (isset($_POST['sSearch']) && $_POST['sSearch'] != "")
                {        
                        $this->db->where("(u.user_name LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%'
                        OR m.mod_name LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%'
                        OR la.la_current_year LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%'
                        OR cm.cm_semester LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%' )");
        }
                
                $this->db->select('*');
                $this->db->from('lecturer_assign la');
        
                $this->db->join('user u', 'la.user_id = u.user_id', 'left');
                $this->db->join('course_module cm', 'cm.cm_id = la.cm_id', 'left');
                $this->db->join('course c', 'cm.cou_id = c.cou_id', 'left');
                $this->db->join('module m', 'cm.mod_id = m.mod_id', 'left');        
                $this->db->join('class cl', 'la.la_group = cl.class_id', 'left');        
              //  $this->db->where('cl.class_status', 1);
                $this->db->where('u.col_id', $col_id);
                
                if(sizeof($ar_search) > 0)
                {
                        foreach($ar_search as $p_name => $p_value)
                        {
                                if($p_name == "u.user_name")
                                {
                                
                                        $this->db->like($p_name, $p_value, 'both'); 
                                }
                                
                                else if($p_value != '')
                                {
                                
                                        $this->db->where($p_name, $p_value); 
                                }
                                
                                
                        }
                }
                
                $this->db->order_by("cm.cm_id", "DESC");
                $this->db->group_by("la.la_id");
        
                
        $rResult1 = $this->db->get();
        $iFilteredTotal = $rResult1->num_rows();

        $db_query = $this->db->last_query();

        /* Paging */
        $sLimit = "";

        if (isset($_POST['iDisplayStart']) && $_POST['iDisplayLength'] != '-1') 
        {
                    $db_query .= " LIMIT " . mysql_real_escape_string($_POST['iDisplayStart']) . ', ' . 
                    mysql_real_escape_string($_POST['iDisplayLength']);

                $bil = $_POST['iDisplayStart'];         
        }
                else
                {
                        $bil = 0;
                }
            

        $rResult = $this->db->query($db_query);

        $aResultTotal = $rResult->num_rows();

        $iTotal = $rResult->num_rows();

        $num = 0;
                
                if (isset($_POST['sEcho'])) 
        {
            $arr_d['sEcho'] = intval($_POST['sEcho']);
        }
        $arr_d['iTotalRecords'] = $iTotal;
        $arr_d['iTotalDisplayRecords'] = $iFilteredTotal;
                
                
        if (!empty($iTotal)) 
        {
                        foreach ($rResult->result() as $st) 
            {
                                //$nama = $st->first_name. " " .$st->last_name;
                                
                                $bil++;
                                                
                        $arr_d["aaData"][] = array(
                                     //   "<center>". $bil."</center>",
                                  "<span>". strcap($st->user_name)."</span>" ,
                            	  "<span>". strcap($st->mod_name)."</span>" ,
                                  "<span>". strcap($st->cou_name)."</span>" ,
                                  "<center><span>".$st->la_current_year."</span></center>" ,
                                  "<center><span>".$st->cm_semester."</span></center>" ,
                                  "<span>". strtoupper($st->class_name)."</span>" ,
                                  $st->la_status==1?"<span>Biasa</span>":"<span>Mengulang</span>" ,
                                );             
                        
            }
        }
                
                else 
                {
            $arr_d["aaData"] = array();
        }
                
        return $arr_d;
        }

        function fnColumnToField($i) 
        {
                
        if ($i == 1)
            return "u.user_name";
        else if($i == 2)
                        return "m.mod_name";
                else if ($i == 3)
            return "c.cou_name";
                else if($i == 4)
                        return "la.la_current_year";
        else if ($i == 5)
            return "cm.cm_semester";
        else if ($i == 6)
                return "la.la_group";
        
        
    }
	
/******************************************************************************************
 * Description		: Get subject repeat
 * input			: - 
 * author			: Nabihah Ab.Karim
 * Date				: 07 April 2014
 * Modification Log	: -
 ******************************************************************************************/
	
	 function get_subject_repeat($course_id="", $semester="", $col_id="") 
	 {
        $this->db->select('distinct(mt.mod_id),m.*');
        $this->db->from('module m, module_taken mt, college_course cc, student s');
		
		$this->db->where('s.cc_id = cc.cc_id');
		$this->db->where('cc.col_id', $col_id);
		$this->db->where('cc.cou_id',$course_id);
		$this->db->where('s.stu_id = mt.stu_id');
		$this->db->where('mt.mod_id = m.mod_id');
		$this->db->where('mt.mt_semester', $semester);
	
		$this->db->where('mt.exam_status', 2);
       
       
        $query = $this->db->get();

        if ($query->num_rows() > 0) 
        {
            return $query->result();
        }
    }    
    
	function query_update_fullmark()
	{
		
		$this->db->select('mt.grade_id, mt.md_id');
        $this->db->from('module_taken mt');
        $this->db->where('mt.grade_id !=', 'NULL');
        //$this->db->where('mt.mt_full_mark', ' ');
        $query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			$c = $query->result();
		}
		
		//print_r($c);
		//die();
		foreach($c as $row)
		{
			
			$this->db->select('g.min_mark');
        	$this->db->from('grade g');
        	$this->db->where('g.grade_id', $row->grade_id);
        //	$this->db->where('mt.mt_full_mark', ' ');
        	$query = $this->db->get();
			$mark = $query->row();
			
			$data = array(
               'mt_full_mark' => $mark->min_mark);

			$this->db->where('md_id', $row->md_id);
			$i = $this->db->update('module_taken', $data); 

			
		}
		//echo $i;
		
	}
	
/******************************************************************************************
 * Description		: Get lecturer list
 * input				: - 
 * author			: Nabihah Ab.Karim
 * Date				: 03 July 2013
 * Modification Log	: -
 ******************************************************************************************/	
	function get_lecturer()
	{		
			$this->db->select('u.user_name');
			$this->db->from('user u, user_group ug');
			$this->db->where('u.user_id = ug.user_id');
			$this->db->where('ug.ul_id',3);
			$query = $this->db->get();
			if($query->num_rows() > 0) {
				return $query->result();
		
			}
		
	}
	
/******************************************************************************************
* Description		: check lecturer yang mengajar sama module
* input				: - 
* author			: Nabihah Ab.Karim
* Date				: 8 April 2014
* Modification Log	: -
******************************************************************************************/
	
	function check_la($cm_id, $year, $col_id) 
	{
		$this->db->select('la.la_id');
		$this->db->from('lecturer_assign la, user u');
		$this->db->where('u.user_id = la.user_id');
		$this->db->where('la.cm_id', $cm_id);
		$this->db->where('la.la_current_year',$year);
		$this->db->where('u.col_id',$col_id);
		$this->db->where('la.la_status', 2);
		
		$query = $this->db->get();
		
			if($query->num_rows() > 0) 
			{
				return $query->row();
		
			}
	}

/******************************************************************************************
* Description		: update la_id untuk assign user_id lain 
* input				: - 
* author			: Nabihah Ab.Karim
* Date				: 08 April 2014
* Modification Log	: -
******************************************************************************************/
			
	function update_subjrepeat_lect($data, $la_id)
	{
			$this->db->where('la_id', $la_id);
			$i = $this->db->update('lecturer_assign', $data); 
	}		
				
}






?>
