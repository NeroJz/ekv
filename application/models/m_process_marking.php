<?php
/**************************************************************************************************
* File Name        : m_process_marking.php
* Description      : This File contain all about students function include evaluation and other
* Author           : Fakhruz
* Date             : 9 Julai 2013
* Version          : -
* Modification Log : -
* Function List	   : -
**************************************************************************************************/
class M_process_marking extends CI_Model 
{
	function getCourseByCodeNType($colType, $colCode){
		$this->db->select("cou.cou_name, cc.cc_id");
		$this->db->join("college_course cc","cc.col_id=c.col_id","inner");
		$this->db->join("course cou","cou.cou_id=cc.cou_id","inner");
		$this->db->where("col_type",$colType);
		$this->db->where("col_code",$colCode);
		$this->db->from("college c");
		
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
}// end of Class
/**************************************************************************************************
* End of m_process_marking.php
**************************************************************************************************/

?>