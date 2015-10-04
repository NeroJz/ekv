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

class M_resultrv2 extends CI_Model
{
	

	/**
	* function ni digunakan untuk dapatkan senarai subjek mengikut kursus
	* input: $course_id
	* author: sukor
	* Date: 10 Jun 2013
	* Modification Log:  GROUP_CONCAT(coalesce(g.gred_type),SPACE(1),coalesce(sd.id_diambil)) as gred,
	*/
    function student_result($kvid,$tahun,$sem,$pelajar)
    {
        $p='GROUP_CONCAT(sm.nama_subjek_modul) as subjek,
        GROUP_CONCAT(sm.kod_subjek_modul) as kod_subjek,
        GROUP_CONCAT(CAST(sm.subjek_jam_kreadit AS char(9)) ) as kredit,
         GROUP_CONCAT(CONCAT(IFNULL(g.gred_type,0))) as gred,
         GROUP_CONCAT(CONCAT(IFNULL(g.nilai_gred,0))) as nilaigred,
         GROUP_CONCAT(CONCAT(IFNULL(g.level_gred,0))) as level_gred,
        l.level_id,p.id_pelajar,p.nama_pelajar,p.no_kp,p.angka_giliran,k.jenis_kursus,
        k.kursus_kluster,ikv.nama_institusi,l.level_semester,l.tahun';
		 $this->db->select($p,FALSE);
        $this->db->from('level l');
		$this->db->join('pelajar p','p.id_pelajar=l.id_pelajar','left');
		$this->db->join('institusi_kv ikv','ikv.kv_id=p.id_pusat','left');
		$this->db->join('kursus k','k.kursus_id=l.kursus_id','left');
		$this->db->join('subjek_diambil sd ','sd.level_id=p.id_pelajar and  sd.semester_diambil=l.level_semester and sd.tahun_diambil=l.tahun','left');
	    $this->db->join('subjek_modul sm','sm.subjek_id=sd.subjek_id','left');
		$this->db->join('gred g','g.gred_id=sd.gred','left');
		if(!empty($tahun)){
			$this->db->where('l.tahun',$tahun);
		}
		if(!empty($sem)){
			$this->db->where('l.level_semester',$sem);
		}
	   
		   $this->db->where('sd.status_diambil',1);
		   
	if(!empty($idcompy)){
			$this->db->where('p.id_pusat',$idcompy);
		}
		
		if(!empty($kvid)){
			$this->db->where('l.kursus_id',$kvid);
		}
		if(!empty($pelajar)){
			$this->db->where('p.angka_giliran',$pelajar);
		}
		$this->db->group_by('level_id');
        $this->db->order_by('p.angka_giliran');
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->result();
        }
    }
	
	
	
	
	
	
} // End of class

/**************************************************************************************************
* End of m_sup.php
**************************************************************************************************/
?>