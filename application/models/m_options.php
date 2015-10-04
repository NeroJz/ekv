<?php

class M_options extends CI_Model 
{
	function update_template_ag($data)
	{
		$this->db->where('opt_name', "template_angka_giliran");
		return $this->db->update('options', $data); 

	}
}

?>