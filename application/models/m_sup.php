<?php
/**************************************************************************************************
* File Name        : m_sup.php
* Description      : This file for sql query that use at sup
* Author           : Mior Mohd Hanif
* Date             : 10 Jun 2013
* Version          : 0.1
* Modification Log : 
* Function List	   : get_subject_list(), get_subject_staff_reserve(), get_subject_staff(), get_mark_list(),
 * 					get_lecturer(),staff_detail_search(),update_subject_lecturer(),get_student_by_course(),
 * 					get_detail_kv(),lect_submit_mark(),pfnColumnToField()
**************************************************************************************************/

class M_sup extends CI_Model
{
	/**
	* function ni digunakan untuk dapatkan senarai subjek mengikut kursus
	* input: $course_id
	* author: Mior Mohd Hanif
	* Date: 10 Jun 2013
	* Modification Log: 
	*/
    function get_subject_list($course_id)
    {
        $this->db->select('sm.subjek_id,sm.nama_subjek_modul,sm.kod_subjek_modul');
        $this->db->from('subjek_modul sm');
		$this->db->join('kursus_subjek_modul ksm', 'ksm.subjek_id = sm.subjek_id', 'left');
        $this->db->where('ksm.kursus_id',$course_id);
        $this->db->order_by('sm.nama_subjek_modul');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }
	
	/**
	* function ni digunakan untuk dapatkan subjek pensyarah yang id 0
	* input: $course_id,$subject_id,$sesi,$semester
	* author: Mior Mohd Hanif
	* Date: 11 Jun 2013
	* Modification Log: 
	*/
    function get_subject_staff_reserve($course_id,$subject_id,$sesi,$semester)
    {
    	$this->db->select('ksm_id');
        $this->db->from('kursus_subjek_modul');
        $this->db->where('kursus_id', $course_id);
        $this->db->where('subjek_id', $subject_id);
        $query = $this->db->get();
        $ksm_id = $query->row('ksm_id');
        
        $this->db->select('user_id');
        $this->db->from('subjek_pensyarah');
        $this->db->where('ksm_id',$ksm_id);
		$this->db->where('sp_sesi',$sesi);
		$this->db->where('sp_semester',$semester);
        $this->db->where('user_id = 0');
        $query = $this->db->get();
        return $query->num_rows();
	}

	/**
	* function ni digunakan untuk dapatkan data subjek pensyarah
	* input: $course_id,$subject_id,$sesi,$semester,$idInstitut
	* author: Mior Mohd Hanif
	* Date: 11 Jun 2013
	* Modification Log: 
	*/
	function get_subject_staff($course_id,$subject_id,$sesi,$semester,$idInstitut) 
	{
        $this->db->select('ksm_id');
        $this->db->from('kursus_subjek_modul');
        $this->db->where('kursus_id', $course_id);
        $this->db->where('subjek_id', $subject_id);
        $query = $this->db->get();
        $ksm_id = $query->row('ksm_id');
        
        $this->db->select('u.id,u.first_name,u.last_name,u.email,i.kod_pusat,i.nama_institusi');
        $this->db->from('users u,institusi_kv i,subjek_pensyarah sp');
        $this->db->where('sp.ksm_id',$ksm_id);
		$this->db->where('sp.sp_sesi',$sesi);
		$this->db->where('sp.sp_semester',$semester);
        $this->db->where('u.id = sp.user_id');
        $this->db->where('u.company = i.kv_id');
		$this->db->where('u.company',$idInstitut);
        $query = $this->db->get();
        
        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }
	
	/**
	* function ni digunakan untuk dapatkan peratusan markah subjek pensyarah
	* input: $subject_id, $course_id,$idInstitut
	* author: Mior Mohd Hanif
	* Date: 12 Jun 2013
	* Modification Log: 14 Jun 2013 by Mior - close this function because sup not required to fill mark for pusat and sekolah
	*/
	function get_mark_list($subject_id, $course_id,$idInstitut) 
	{
        $this->db->select('sp.sp_id, ksm.ksm_id, sp.sp_markah_pusat, sp.sp_markah_sekolah');
        $this->db->from('subjek_pensyarah sp');
		$this->db->join('kursus_subjek_modul ksm', 'ksm.ksm_id = sp.ksm_id', 'left');
		$this->db->join('users u', 'u.id = sp.user_id', 'left');
		$this->db->where('ksm.subjek_id' , $subject_id);
        $this->db->where('ksm.kursus_id',$course_id);
		$this->db->where('u.company',$idInstitut);
       // $this->db->order_by('s.subject_name');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }
	
	/**
	* function ni digunakan untuk dapatkan senarai pensyarah mengikut kv
	* input: $idInstitut
	* author: Mior Mohd Hanif
	* Date: 12 Jun 2013
	* Modification Log: 
	*/
	function get_lecturer($idInstitut)
	{
		$this->db->select('u.first_name,u.last_name');
		$this->db->from('users u');
		$this->db->where('u.company',$idInstitut);
		
		$query = $this->db->get();
		if($query->num_rows() > 0) 
		{
			$data = $query->result();
            $sbj = '';
            foreach($data as $s)
			{
				$sbj .= '"';
				$sbj .= $s->first_name;
				$sbj .= ' ';
				$sbj .= $s->last_name;
				$sbj .= '",';
			}
			return $sbj;
        }
	}
	
	/**
	* function ni digunakan untuk dapatkan pensyarah menggunakan carian
	* input: $queryString,$idInstitut
	* author: Mior Mohd Hanif
	* Date: 12 Jun 2013
	* Modification Log: 
	*/
	function staff_detail_search($queryString,$idInstitut) 
	{
		$query = "u.id,u.first_name,u.last_name,u.email FROM users u WHERE username = 'Pensyarah' AND ".
				 " u.company = '".$idInstitut."' AND (".
				 " u.last_name LIKE '%".$queryString."%' ".
				 " OR u.first_name LIKE '%".$queryString."%' ".
				 " OR u.email LIKE '%".$queryString."%')";

		$this->db->select($query, FALSE);

		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	/**
	* function ni digunakan untuk insert dan update subjek pensyarah
	* input: $arr,$idInstitut
	* author: Mior Mohd Hanif
	* Date: 13 Jun 2013
	* Modification Log: 14 Jun 2013 by Mior - update query for fix bug
	*/
	 function update_subject_lecturer($arr,$idInstitut)
	 {
    	
        $this->db->select('ksm_id');
        $this->db->from('kursus_subjek_modul');
        $this->db->where('kursus_id', $arr['course_id']);
        $this->db->where('subjek_id', $arr['subject_id']);
        $query = $this->db->get();
        $ksm_id = $query->row('ksm_id');
        
        
        foreach($arr['staffList'] as $staff_id)
        {
            $user_id = ($staff_id == '-') ? 0 : $staff_id;

            $data = array(
            	'user_id'=>$user_id,
            	'ksm_id'=> $ksm_id,
            	'sp_semester'=>$arr['semester'],
            	'sp_sesi'=>$arr['sesi']
            	//'sp_markah_pusat'=>$arr['course_work'],
            	//'sp_markah_sekolah'=>$arr['final']
			);

		 	if($user_id==0) //kalau tiada pensyarah yang diassign guna query ini
		 	{
	            $this->db->select('sp.sp_id');
		        $this->db->from('subjek_pensyarah sp');
				$this->db->join('users u', 'u.id = sp.user_id', 'left');
		        $this->db->where('sp.ksm_id', $ksm_id);
				$this->db->where('sp.sp_sesi', $arr['sesi']);
				$this->db->where('sp.sp_semester', $arr['semester']);
		        $this->db->where('u.company', $idInstitut);
		        $querySpId = $this->db->get();
		        $SpId = $querySpId->row('sp_id');
		   	}
		   else //kalau ada pensyarah yang diassign guna query ini
		   	{
		   		$this->db->select('sp.sp_id');
		        $this->db->from('subjek_pensyarah sp');
		        $this->db->where('sp.ksm_id', $ksm_id);
				$this->db->where('sp.sp_sesi', $arr['sesi']);
				$this->db->where('sp.sp_semester', $arr['semester']);
		        $querySpId = $this->db->get();
		        $SpId = $querySpId->row('sp_id');
			}
			
			if($querySpId->num_rows() > 0) //klau row yang diselect lebih dari 0
			{
        		$this->db->where('sp_id',$SpId);
				$this->db->update('subjek_pensyarah', $data);
			}
			
			else //kalau tiada row yang di select
			{
				$this->db->insert('subjek_pensyarah', $data);
				$i = $this->db->insert_id();
			}
        }
        
        if (isset($i)) {
            return 1;
        } else {
            return 0;
        }
    }

	/**
	* function ni digunakan untuk dapatkan senarai pelajar mengikut kursus,sesi dan semester
	* input: $course_id,$sesi,$semester,$id_pusat
	* author: Mior Mohd Hanif
	* Date: 14 Jun 2013
	* Modification Log: 17 Jun 2013 by Mior - buat query select student by kv,kursus,sesi dan semester
	*/
    function get_student_by_course($course_id,$sesi,$semester,$id_pusat)
    {
    	$this->db->select('p.nama_pelajar,p.no_kp,p.angka_giliran');
        $this->db->from('level l');
		$this->db->join('pelajar p', 'p.id_pelajar = l.id_pelajar', 'left');
		//$this->db->join('institusi_kv kv', 'kv.kv_id = p.id_pusat', 'left');
		$this->db->where('p.id_pusat',$id_pusat);
        $this->db->where('l.level_status',1);
		$this->db->where('l.level_semester',$semester);
		$this->db->where('l.tahun',$sesi);
		$this->db->where('l.kursus_id',$course_id);
        $this->db->order_by('p.nama_pelajar');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
	}
	
	
	/**
	* function ni digunakan untuk dapatkan maklumat kv berdasarkan id pusat sup login
	* input: $id_pusat
	* author: Mior Mohd Hanif
	* Date: 14 Jun 2013
	* Modification Log: 
	*/
    function get_detail_kv($id_pusat)
    {
    	$this->db->select('*');
		$this->db->from('institusi_kv');
		$this->db->where('kv_id',$id_pusat);
		$query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row();
        }
	}
	
	/**************************************************************************************************
	* Description		: This function to query check status lecturer already submit or not mark student
	* Author			: Mior Mohd Hanif
	* Date				: 18 Jun 2013
	* Input Parameter	: 
	* Modification Log	: 19 Jun 2013 by Mior - buat query
	 * 					  20 Jun 2013 by Mior - modified query
	 * 					  21 Jun 2013 by Mior - modified query
	 * 					  15 Julai 2013 by Mior - modify query
	 * 					  24 Julai 2013 by Mior - modify query
	**************************************************************************************************/
	function lect_submit_mark() 
	{
		$arr_d = array();
        $sOrder = "";
	 	$dt_search = $_POST['search'];	
      	$search = explode("|", $dt_search);
   		$tahun = $search[0];
		$semester = $search[1];
	 	$status = $search[2];
		$id_pusat = $search[3];
		$pengurusan = $search[4];

		$queryModId = 	" cm.cm_id FROM marks AS m".
						" LEFT JOIN module_taken AS mt ON mt.md_id = m.md_id".
						" LEFT JOIN student AS s ON s.stu_id = mt.stu_id".
						" LEFT JOIN college_course AS cc ON cc.cc_id = s.cc_id".
						" LEFT JOIN course_module AS cm ON cm.cou_id = cc.cou_id".
						" WHERE cm.mod_id = mt.mod_id AND cm.cm_semester = mt.mt_semester AND mt.mt_year = $tahun";
		
		//kalau semester tak empty
		if (!empty($semester)) {
			$queryModId .= 	" AND mt.mt_semester = $semester";
		}
		
		
		
		$this->db->select($queryModId);
		$rResultModId = $this->db->get();

		$aModId =  $rResultModId->result_array();

		$a_mod_id = array();	//create array variable
		
		for($i=0;$i<sizeof($aModId);$i++)
		{
			array_push($a_mod_id,$aModId[$i]['cm_id']); //masukkan data ke dalam array
		}
		//print_r($a_mod_id);
		//die();
		$this->db->select('u.user_name,mm.mod_name,c.cou_name,cm.cm_semester');
		$this->db->from('user AS u');
		$this->db->join('lecturer_assign AS la', 'la.user_id = u.user_id', 'left');
		$this->db->join('course_module AS cm', 'cm.cm_id = la.cm_id', 'left');
		//$this->db->join('module_taken AS mt', 'mt.mod_id = cm.mod_id', 'left');
		$this->db->join('course AS c', 'c.cou_id = cm.cou_id', 'left');
		$this->db->join('module AS mm', 'mm.mod_id = cm.mod_id', 'left');
		$this->db->where('u.col_id',$id_pusat);
		$this->db->where('la.la_current_year',$tahun);
		
		//kalau semester tak empty
		if (!empty($semester)) {
			$this->db->where('cm.cm_semester',$semester);
		}
		
		//kalau pengurusan tak empty
		if (!empty($pengurusan)) {
			$this->db->like('mm.mod_type',$pengurusan);
		}
		
		if(!empty($status))//kalau ruang carian status tak kosong
		{
			if(1==$status)//status kalau pensyarah dah hantar markah
			{
				if(null!=$a_mod_id) //kalau array tak null
				{
					$this->db->where_in('cm.cm_id',$a_mod_id);
					//$this->db->where('mt.mt_year',$tahun);
					//$this->db->where('u.col_id',$id_pusat);

				}
				else
				{
					$this->db->where('cm.cm_id',0);
				}
			}
			if(2==$status)//status kalau pensyarah belum dah hantar markah
			{
				if(null!=$a_mod_id) //kalau array tak null
				{
					$this->db->where_not_in('cm.cm_id',$a_mod_id);
					//$this->db->where('mt.mt_year',$tahun);
					//$this->db->where('u.col_id',$id_pusat);

				}
				/*else
				{
					$this->db->where('cm.cm_id',0);
				}*/
			}
		}

		//$this->db->group_by('mt.mod_id');

        $sWhere = "";
		
		if (isset($_POST['sSearch']) && $_POST['sSearch'] != "") //kalau ruang carian di datatable di isi
		{	
			$this->db->where("(u.user_name LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%'
			OR mm.mod_name LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%'
			  OR c.cou_name LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%'
			   OR cm.cm_semester LIKE '%" . mysql_real_escape_string($_POST['sSearch']) . "%' )");
        }
		
		/* Ordering */
        if (isset($_POST['iSortCol_0'])) //kalau plug in sorting datatable di isi
        {
            $sOrder = "ORDER BY ";
            for ($i = 0; $i < ($_POST['iSortingCols'] ); $i++) 
            {
                $this->db->order_by($this->pfnColumnToField($_POST['iSortCol_' . $i]), $_POST['sSortDir_' . $i]);
            }
        }

        $rResult1 = $this->db->get();
        $iFilteredTotal = $rResult1->num_rows();

        $db_query = $this->db->last_query();

        /* Paging */
        $sLimit = "";

        if (isset($_POST['iDisplayStart']) && $_POST['iDisplayLength'] != '-1') //untuk paparkan mngikut limit
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
		
		
        if (!empty($iTotal)) //kalau result query tak empty
        {
			foreach ($rResult->result() as $st) 
            {
				$bil++;
						
		        $arr_d["aaData"][] = array(
					"<center>". $bil."</center>",
		          	"<center><span>". strtoupper($st->user_name)."</span></center>" ,
		          	"<center><span>". strtoupper($st->mod_name)."</span></center>" ,
		          	"<center><span>". strtoupper($st->cou_name)."</span></center>" ,
		          	"<center><span>". strtoupper($st->cm_semester)."</span></center>" ,
				);
            }
        }
		else 
		{
            $arr_d["aaData"] = array();
        }
		
        return $arr_d;
	}
	
	/**************************************************************************************************
	* Description		: This function to display data at pagination
	* Author			: Mior Mohd Hanif
	* Date				: 18 Jun 2013
	* Input Parameter	: -
	* Modification Log	: 19 Jun 2013 by Mior - buat query
	 * 					  15 Julai 2013 by Mior - modify query
	 * 					  24 Julai 2013 by Mior - modify query
	**************************************************************************************************/
	function pfnColumnToField($i) 
	{
        if ($i == 1)
            return "u.user_name";
        else if($i == 2)
			return "mm.mod_name";
		else if ($i == 3)
            return "c.cou_name";
		else if($i == 4)
			return "cm.cm_semester";
    }
	
} // End of class

/**************************************************************************************************
* End of m_sup.php
**************************************************************************************************/
?>