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
class m_class extends CI_Model {
	
	
	/**********************************************************************************************
	* Description		: this function is to get student by course
	* input				: col_id, course_id, semester
	* author			: siti umairah
	* Date				: 27 october 2013
	* Modification Log	: -
	**********************************************************************************************/
	function get_student_by_course($col_id,$course_id,$semester) 
	{
		
		$this->db->select('s.stu_id,s.stu_name,s.stu_mykad,s.stu_matric_no');
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
			
		}
    }
	
	
	
    /**********************************************************************************************
    * Description		: this function is to divide student based on number of group
    * input				: course_id, semester, year, totalGroup
    * author			: siti umairah
    * Date				: 4 november 2013
    * Modification Log	: -
    **********************************************************************************************/
	 function create_group($course_id, $semester, $total_kelas) 
    {
    	
    	$cc_id = $this->get_cc_id($course_id);
        $totalStudent = ceil($this->get_list_student($cc_id, $semester) / $total_kelas);
        $checking = $this->get_list_student($cc_id, $semester) % $total_kelas;
		
        //$total = $totalStudent;
        $class_id= $this->get_class_id_v2($semester,$cc_id);
		$total_class = count($class_id);
		//echo "<pre>";
      	//print_r($totalStudent);
		//echo "</pre>";
        //die();
        $this->db->select('s.stu_id');
        $this->db->from('student s');
        $this->db->where('s.cc_id', $cc_id);
		//$this->db->where('s.stu_current_year', $year);
		$this->db->where('s.stu_current_sem', $semester);
		//$this->db->where('s.stat_id',1);
        //$this->db->where('s.stu_group = 0');
		$this->db->where('(s.stat_id = 1 OR s.stat_id = 4)');
		$this->db->where('(s.stu_group IS NULL OR s.stu_group = 0)');
		$this->db->group_by('s.stu_matric_no ASC');
        $query = $this->db->get();
      
        if ($query->num_rows() > 0) {
        	
        	$count = 0;
        	//$bilMurid = 0;
        	if($checking == 0)
        	{
        		$bilMurid = $class_id[$count][1];
        	}else
        	{
        		$bilMurid = $class_id[$count][1];
        	}
			
        	//$bilPelajar = 1;
            foreach ($query->result() as $row) {	
                
                if ($bilMurid == $totalStudent) 
                {
                    $count++;
					if($count < $total_class)
					{
						$bilMurid=$class_id[$count][1];
					}
					/*else if($count == $total_class)
					{
						$count = 0;
						$totalStudent++;
					}*/
					
					$data = array('stu_group' => $class_id[$count][0]);
	                $this->db->where('stu_id', $row->stu_id);
	               // $this->db->where('stat_id', 1);
	              //  $this->db->where('(s.stat_id = 1 OR s.stat_id = 4)');
	                $result = $this->db->update('student', $data);
                    
                }
				else
				{
					$data = array('stu_group' => $class_id[$count][0]);
	                $this->db->where('stu_id', $row->stu_id);
	                //$this->db->where('stat_id', 1);
	               // $this->db->where('(s.stat_id = 1 OR s.stat_id = 4)');
	                $result = $this->db->update('student', $data);
				}
				$bilMurid++;
            }
        }
    }

    
    /**********************************************************************************************
     * Description		: this function is to divide student based on number of students
    * input				: course_id, semester, year, totalGroup
    * author			: siti umairah
    * Date				: 22 november 2013
    * Modification Log	: -
    **********************************************************************************************/
    function create_group_by_students($course_id, $semester,$max, $totalGroup) {
    	
    	$cc_id = $this->get_cc_id($course_id);
    	$totalGroup = ceil($this->get_list_student($cc_id, $semester) / $max);
        	
    	$class_id= $this->get_class_id_v2($semester,$cc_id);
		$total_class = count($class_id);
		
		$count = 0;	
        $bilMurid = $class_id[$count][1];
    	
        $this->db->select('s.stu_id');
        $this->db->from('student s');
        $this->db->where('s.cc_id', $cc_id);
		//$this->db->where('s.stu_current_year', $year);
		$this->db->where('s.stu_current_sem', $semester);
		//$this->db->where('s.stat_id', 1);
		$this->db->where('(s.stat_id = 1 OR s.stat_id = 4)');
		//$this->db->where('s.stu_group = 0');
		$this->db->where('(s.stu_group IS NULL OR s.stu_group = 0)');
		$this->db->group_by('s.stu_matric_no ASC');
    	$query = $this->db->get();
      
        if ($query->num_rows() > 0) {
        foreach ($query->result() as $row) {
        			
                if ($bilMurid == $max) {
                    $count++;
					if($count < $total_class)
					{
						$bilMurid=$class_id[$count][1];
					}
					else if($count == $total_class)
					{
						//$count = 0;
						break;
					}
                    
					$data = array('stu_group' => $class_id[$count][0]);
	                $this->db->where('stu_id', $row->stu_id);
	               // $this->db->where('stat_id', 1);
	              //  $this->db->where('(s.stat_id = 1 OR s.stat_id = 4)');
	                $result = $this->db->update('student', $data);
                }
				else
				{
					$data = array('stu_group' => $class_id[$count][0]);
	                $this->db->where('stu_id', $row->stu_id);
	                //$this->db->where('stat_id', 1);
	             //   $this->db->where('(s.stat_id = 1 OR s.stat_id = 4)');
	                $result = $this->db->update('student', $data);
				}
                $bilMurid++;
            }
    	}
    }
    
    
    /**********************************************************************************************
    * Description		: this function is to get class_id from class
    * input				: semester, cc_id
    * author			: siti umairah
    * Date				: 5 november 2013
    * Modification Log	: -
    **********************************************************************************************/
    function get_class_id($semester,$cc_id)
    {	
    	$array=array();
    	$this->db->select('class_id');
    	$this->db->from('class c');   	
    	$this->db->where('c.class_sem',$semester);
    	$this->db->where('c.cc_id', $cc_id);
      	//$this->db->where('c.class_session', $year);
    	$this->db->where('c.class_status',1);
    	
    	$query = $this->db->get();
    	
    	if($query->num_rows() > 0)
    	{	
    		$i=0;
    		
    		foreach($query->result() as $row)
    			{
		    		$array[$i] = $row->class_id;
		    		$i++;
    			}
    	}
    		return $array;
    	
    }
    
	
	/**********************************************************************************************
    * Description		: this function is to get class_id from class
    * input				: semester, cc_id
    * author			: siti umairah
    * Date				: 10 march 2014
    * Modification Log	: -
    **********************************************************************************************/
    function get_class_id_v2($semester,$cc_id)
    {	
    	$array=array();
    	$this->db->select('class_id,(SELECT COUNT(*) FROM student st WHERE st.stu_group = c.class_id) AS bil');
    	$this->db->from('class c');   	
    	$this->db->where('c.class_sem',$semester);
    	$this->db->where('c.cc_id', $cc_id);
      	//$this->db->where('c.class_session', $year);
    	$this->db->where('c.class_status',1);
    	
    	$query = $this->db->get();
    	
    	if($query->num_rows() > 0)
    	{	
    		$i=0;
			$j = 0;
    		
    		foreach($query->result() as $row)
			{
				$j = 0;
				
	    		$array[$i][$j] = $row->class_id;
				$j++;
				$array[$i][$j] = $row->bil;
	    		$i++;
			}
    	}
    		return $array;
    	
    }
	
	
    /**********************************************************************************************
    * Description		: this function is to get all student group
    * input				: cc_id, semester, year
    * author			: siti umairah
    * Date				: 5 november 2013
    * Modification Log	: -
    **********************************************************************************************/
	function get_all_student_by_course($cc_id, $semester) 
	{
		
        $this->db->select('count(*) as cnt');
        $this->db->from('student s , course c , college_course cc');   
        $this->db->where('c.cou_id = cc.cou_id');
        $this->db->where('cc.cc_id = s.cc_id');
        //$this->db->where('s.stu_current_year',$year);
       // $this->db->where('s.stu_intake_session',$sesi);
        $this->db->where('s.stu_current_sem',$semester);
        //$this->db->where('s.stat_id', 1);
        $this->db->where('(s.stat_id = 1 OR s.stat_id = 4)');
        $this->db->where('s.cc_id', $cc_id);
       // $this->db->where('s.stu_group',0);
       
        $query = $this->db->get();
        return $query->row('cnt');
    }
    
    
    
    /**********************************************************************************************
     * Description		: this function is to get all student group
    * input				: cc_id, semester, year
    * author			: siti umairah
    * Date				: 5 november 2013
    * Modification Log	: -
    **********************************************************************************************/
    function get_list_student($cc_id, $semester)
    {
    
    	$this->db->select('count(*) as cnt');
    	$this->db->from('student s , course c , college_course cc');
    	$this->db->where('c.cou_id = cc.cou_id');
    	$this->db->where('cc.cc_id = s.cc_id');
    	//$this->db->where('s.stu_current_year',$year);
    	// $this->db->where('s.stu_intake_session',$sesi);
    	$this->db->where('s.stu_current_sem',$semester);
    	//$this->db->where('s.stat_id', 1);
    	$this->db->where('(s.stat_id = 1 OR s.stat_id = 4)');
    	$this->db->where('s.cc_id', $cc_id);
    	//$this->db->where('s.stu_group',0);
    	//$this->db->where('(s.stu_group IS NULL OR s.stu_group = 0)');
    	
    	$query = $this->db->get();
    	return $query->row('cnt');
    }
    
    
    /**********************************************************************************************
     * Description		: this function is to get all student group
    * input				: course_id
    * author			: siti umairah
    * Date				: 5 november 2013
    * Modification Log	: -
    **********************************************************************************************/
    function get_cc_id($course_id="") 	
    {
    	$this->db->select('u.col_id');
    	$this->db->from('user u');
    	$this->db->where('u.user_id', $this->session->userdata('user_id'));
    			
    	$query = $this->db->get();
    			
    	if ($query -> num_rows() > 0)
    	{
    		$college_id = $query->row();
    	}
    		$this->db->select('cc.cc_id');
    		$this->db->from('college_course cc');
    		$this->db->where('cc.cou_id', $course_id);
    		//$this->db->where('cc.col_id', $col_id);
    		$this->db->where('cc.col_id', $college_id->col_id);
    			
    		$query = $this->db->get();
    			
    	if ($query -> num_rows() > 0)
    	{
    		$cc_id = $query->row();
    		return $cc_id->cc_id;
    	}
    				
    }
    
	
    
    function insert_class($data)
    {
    	$this->db->insert('class', $data); 	
   		
    }
    
    
    /**********************************************************************************************
    * Description		: this function is to get student that dont have group
    * input				: cc_id, semester, year
    * author			: siti umairah
    * Date				: 5 november 2013
    * Modification Log	: -
    **********************************************************************************************/
    function get_null_student_group($cc_id, $semester) 
    {   
        $this->db->select('count(*) as cnt');
        $this->db->from('student s');   
       // $this->db->where('s.stu_current_year', $year);
        $this->db->where('s.cc_id', $cc_id);
       	$this->db->where('s.stu_current_sem', $semester);
      // 	$this->db->where('s.stu_intake_session', $sesi);
       	//$this->db->where('s.stat_id', 1);
       	$this->db->where('(s.stat_id = 1 OR s.stat_id = 4)');
       	$this->db->where('(s.stu_group IS NULL OR s.stu_group = 0)');
        $query = $this->db->get();
        return $query->row('cnt');
    }
    
    
    /**********************************************************************************************
    * Description		: this function is to get total number of class by courses
    * input				: cc_id, semester, year
    * author			: siti umairah
    * Date				: 1 november 2013
    * Modification Log	: -
    **********************************************************************************************/
 	//sambung di sini ya
 	function get_max_class($cc_id,$semester) 
 	{
       // $this->db->select('s.stu_group, c.*,(SELECT COUNT (st.*) AS maximum FROM student st WHERE st.stu_group=s.stu_group) AS bil_stu');
 		$this->db->select('COUNT(DISTINCT c.class_id) AS cnt');
        $this->db->from('student s, class c');
        $this->db->where('c.cc_id = s.cc_id');
       // $this->db->where('s.stu_current_year', $year);
		//$this->db->where('s.stu_current_sem', $semester);
		$this->db->where('c.class_sem', $semester);
		//$this->db->where('c.class_session',$year);
		
		$this->db->where('s.cc_id', $cc_id);
		$this->db->where('c.class_status',1);
		//$this->db->where('s.stu_group > 0');
		//$this->db->group_by('s.stu_group');
        $query = $this->db->get();
        return $query->row('cnt');
    }
    
    
    
    /**********************************************************************************************
     * Description		: this function is to get total class and count murid
    * input				: cc_id, semester,year
    * author			: siti umairah
    * Date				: 5 november 2013
    * Modification Log	: -
    **********************************************************************************************/
  	function get_stu_class($cc_id,$semester,$col_id)
  	{
  		$this->db->select('c.*,s.stu_group,s.stu_current_year, s.stu_current_sem, s.cc_id, (SELECT COUNT(*) FROM student st WHERE st.stu_group = c.class_id) AS bil');        

        $this->db->from('class c,student s');
        $this->db->where('c.cc_id = s.cc_id');
       // $this->db->where('s.stu_current_year', $year);
       // $this->db->where('s.stu_intake_session', $sesi);
        $this->db->where('c.cc_id', $cc_id);
        $this->db->where('s.stu_current_sem', $semester);
        $this->db->where('c.class_sem', $semester);
        $this->db->where('c.class_status', 1);
      //  $this->db->where('s.stat_id', 1);
        $this->db->where('(s.stat_id = 1 OR s.stat_id = 4)');
        $this->db->group_by('c.class_id');
               
        $query = $this->db->get();
        return $query->result();               
		
  	}
    
    
  	
  	
  	/**********************************************************************************************
  	 * Description		: this function is to get class dalam course tu in penukaran class
  	* input				: cc_id, semester,year
  	* author			: siti umairah
  	* Date				: 15 januari 2014
  	* Modification Log	: -
  	**********************************************************************************************/
  	function get_classes($cc_id,$semester,$col_id)
  	{
  		$this->db->select('c.*,s.stu_group,s.stu_current_year, s.stu_current_sem, s.cc_id');
  	
  		$this->db->from('class c,student s');
  		$this->db->where('c.cc_id = s.cc_id');
  		$this->db->where('c.class_sem', $semester);
  		$this->db->where('s.stu_current_sem', $semester);
  		//$this->db->where('s.stu_current_year', $year);
  		//$this->db->where('s.stu_intake_session', $sesi);
  		$this->db->where('c.cc_id', $cc_id);  		
  		$this->db->where('c.class_status', 1);
  		$this->db->group_by('c.class_id');
  		
  		//if($semester != null || $semester !=""){
  			
  			//$this->db->where('c.class_sem', $semester);
  			//$this->db->where('c.class_sem', $semester);
  		//}
  		  		 
  		$query = $this->db->get();
  		return $query->result();
  	
  	}
  	
  	
  	/**********************************************************************************************
  	* Description		: this function is to get student information
  	* input				: cc_id, semester, year
  	* author			: siti umairah
  	* Date				: 5 november 2013
  	* Modification Log	: -
  	**********************************************************************************************/
	function get_student_information($cc_id="",$semester="",$col_id="")
	{
		
		$this->db->select('s.stu_id,s.stu_matric_no,s.stu_name,s.stu_current_sem,s.stu_group, co.cou_name');
		$this->db->from('student s, course co, college_course cc');
		$this->db->where('s.cc_id = cc.cc_id');
		$this->db->where('cc.cou_id = co.cou_id');
		$this->db->where('cc.col_id',$col_id);
		//$this->db->where('s.stat_id',1);
		$this->db->where('(s.stat_id = 1 OR s.stat_id = 4)');
		$this->db->where('s.cc_id',$cc_id);
		$this->db->where('s.stu_current_sem',$semester);
		
		$query = $this->db->get();
		
		if ($query->num_rows()>0) 
		{
			
			$sub = $query->result();
			
			foreach($sub as $row)
			{
				$this->db->select('class_name');
				$this->db->from('class');
				$this->db->where('class_id',$row->stu_group);
				
				$query = $this->db->get();
				if ($query->num_rows()>0)
				{
					$sub_query = $query->row_array();
					$row->class_name = $sub_query['class_name'];
				
				}
				else 
				{
					$row->class_name = "Tiada Kelas";
					
				}
			}
			
			return $sub;
		}
	}
	
	
	
	/**********************************************************************************************
	 * Description		: this function is to get class information
	* input				: cc_id, semester, year
	* author			: siti umairah
	* Date				: 7 november 2013
	* Modification Log	: -
	**********************************************************************************************/
	function get_class_information($col_id)
	{
		//$sesi = $this->session->userdata["sesi"]. " " .$this->session->userdata["tahun"];
		
		$this->db->select('c.class_id,co.cou_name,c.class_name,c.class_sem,co.cou_id');
		$this->db->from('class c, college_course cc, course co');
		$this->db->where('cc.cc_id = c.cc_id');
		$this->db->where('cc.cou_id = co.cou_id');
		$this->db->where('c.class_status',1);
    	$this->db->where('cc.col_id',$col_id);
    	//$this->db->where('c.class_session',$sesi);
    	
    	$query = $this->db->get();
    	
    	if ($query->num_rows() > 0) 
    	{
    		return $query->result();
    	}
	}
	
	
	
	/**********************************************************************************************
	* Description		: this function is to get course
	* input				: col_id
	* author			: siti umairah
	* Date				: 5 november 2013
	* Modification Log	: -
	**********************************************************************************************/
	function get_course($col_id)
	{
		$this->db->select('*');
        $this->db->from('course c, college_course cc');      
        $this->db->where('cc.cou_id = c.cou_id');
	    $this->db->where('cc.col_id',$col_id);
	    $this->db->where('cc.cc_status',1);
	    
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) 
        {
            return $query->result();
        }
        
	}
	
	
	/**********************************************************************************************
	* Description		: this function is to get user college
	* input				: col_id
	* author			: siti umairah
	* Date				: 5 november 2013
	* Modification Log	: -
	**********************************************************************************************/
	function get_user_college($col_id)
	{
		$this->db->select('col.col_type,col.col_code,col.col_name');
		$this->db->from('college col');
		$this->db->where('col.col_id',$col_id);
		
		$query = $this->db->get();
		
		if ($query->num_rows()>0) 
		{
			return $query->row();
		}
	}
	
	
	/**********************************************************************************************
	* Description		: this function is to update change group for student
	* input				: stu_id, stu_group
	* author			: siti umairah
	* Date				: 5 november 2013
	* Modification Log	: -
	***********************************************************************************************/
	function update_student_group($stu_id, $stu_group) 
	{
        $data = array('stu_group' => $stu_group);
        
        $this->db->where('stu_id', $stu_id);
        $result = $this->db->update('student', $data);

        return $result;
    }
	
    
    /**********************************************************************************************
    * Description		: this function is to get year
    * input				: -
    * author			: siti umairah
    * Date				: 5 november 2013
    * Modification Log	: -
    **********************************************************************************************/
    function get_year(){
    	
    	$sesi = $this->session->userdata["sesi"]. " " .$this->session->userdata["tahun"];
    	
    	$this->db->select('s.stu_current_year');
    	$this->db->from('student s');
    	$this->db->where('s.stu_intake_session', $sesi);
    	$this->db->order_by('s.stu_current_year', 'ASC');
    	$this->db->group_by('s.stu_current_year','ASC');
    	
    	$query = $this->db->get();
    	
    	if ($query->num_rows() > 0) 
    	{
    		return $query->result();
    	}
    	
    	
    }
    
    
    
    //get year tambah kelas
    function get_year_add_class(){
    	 
    	//$sesi = $this->session->userdata["sesi"]. " " .$this->session->userdata["tahun"];
    	 
    	$this->db->select('s.stu_current_year');
    	$this->db->from('student s');
    	$this->db->order_by('s.stu_current_year', 'ASC');
    	$this->db->group_by('s.stu_current_year','ASC');
    	 
    	$query = $this->db->get();
    	 
    	if ($query->num_rows() > 0)
    	{
    		return $query->result();
    	}
    	 
    	 
    }
    
    /**********************************************************************************************
     * Description		: this function is to update name of class
    * input				: data
    * author			: siti umairah
    * Date				: 11 november 2013
    * Modification Log	: -
    **********************************************************************************************/
    function edit_class($data)
    {
   		$this->db->where('class_id',$data['class_id']);
    	$this->db->update('class', $data);     		
    	
    }
    

    /**********************************************************************************************
     * Description		: this function is to delete class
    * input				: class_id
    * author			: siti umairah
    * Date				: 11 november 2013
    * Modification Log	: -
    **********************************************************************************************/
    function delete_kelas($class_id)
    {
    	
    	$this->db->where('class_id',$class_id);
    	$this->db->update('class','class_status',0);
    	
    	return $this->db->affected_rows();
    	
    }
    
    
    /**********************************************************************************************
    * Description		: this function is to check class for delete class whether have student or not
    * input				: class_id
    * author			: siti umairah
    * Date				: 11 november 2013
    * Modification Log	: -
    **********************************************************************************************/
    function check_kelas($class_id)
    {
    	 
    	$this->db->select('class_id','cc_id');
    	$this->db->from('class c , college_course cc, student s');
    	
    	$this->db->where('cc.cc_id = s.cc_id');
    	$this->db->where('c.class_id = s.stu_group');
    	$this->db->where('c.class_sem = s.stu_current_sem');
    	$this->db->where('c.class_session = s.stu_intake_session');
    	$this->db->where('c.class_id',$class_id);
    	$query = $this->db->get();
    	
    	if ($query->num_rows() > 0)
    	{
    		return 1;
    		
    	}
    	else
    	{
    		
    		return 0;
    	}
    	
    }
    
    
    /**********************************************************************************************
    * Description		: this function is to check class name equal or not
    * input				: class_name
    * author			: siti umairah
    * Date				: 13 november 2013
    * Modification Log	: -
    **********************************************************************************************/
    function check_class_name($class_name,$col_id,$course_id,$semester)
    {
    	
    	$this->db->select('c.class_name,c.cc_id');
    	$this->db->from('class c, college_course cc, course co');
    	$this->db->where('c.class_name',$class_name);
    	$this->db->where('cc.col_id',$col_id);
    	//$this->db->where('c.class_sem',$sem);
    	$this->db->where('co.cou_id',$course_id);
    	$this->db->where('c.class_sem',$semester);
    	$this->db->where('cc.cc_id = c.cc_id');
    	$this->db->where('co.cou_id = cc.cou_id');
    	$this->db->where('c.class_status',1);

    	$query = $this->db->get();
    	
    	if ($query->num_rows() > 0)
    	{
    		return 1;
    	
    	}
    	else
    	{
    	
    		return 0;
    	}
    	
    }
    
    
    
    
   /* function get_course_id($class_id)
    {
   
    	$this->db->select('course_id');
    	$this->db->from('course c, college_course cc');
    	$this->db->where('c.class_id',$class_id);
    	$this->db->where('cc.cc_id = c.cc_id');
    	    	 
    	$query = $this->db->get();
    	
    	if ($query->num_rows() > 0) 
    	{
    		return $query->result();
    	}
    
    }*/
     
}

/**************************************************************************************************
* End of m_class.php
**************************************************************************************************/
?>
