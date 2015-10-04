<?php
	class M_fakhruz extends CI_Model
	{
		function getCourse(&$avData, $opt = null, $parent = null, $count = 1)
		{
			$this->db->select("mod_id, mod_code");
			$this->db->where("mod_paper_one",$parent);
			$q = $this->db->get("module");
			
			foreach($q->result() as $r)
			{	
				$r->mod_paper_num = $count;
				$avData[] = $r;
				 
				$count++;
				$this->getCourse($avData,$opt, $r->mod_id,$count);
				$count = 1;
			}
		}
	}
?>