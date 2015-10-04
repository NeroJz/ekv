<?php

/**************************************************************************************************
* File Name        : m_weightage.php
* Description      : This File contain function for weightage configuration
* Author           : Freddy Ajang Tony
* Date             : 21 June 2013
* Version          : -
* Modification Log : -
* Function List	   : -
**************************************************************************************************/

class M_weightage extends CI_Model 
{
	
	/******************************************************************************************
	* Description		: this function to get weightage configuration that has been
	*					: set. 
	* input				: $queryString = module type : AK or VK
	* author			: Freddy Ajang Tony
	* Date				: 21 June 2013
	* Modification Log	: -
	******************************************************************************************/
	function module_list($queryString)
	{
		$this->db->select('m.mod_id,m.mod_code,m.mod_name,m.mod_paper,m.mod_paper_one,m.mod_type,');
		$this->db->from('module m');
		$this->db->where('m.mod_type',$queryString);
		$this->db->where('m.stat_mod',1);
		$this->db->order_by("m.mod_name", "asc");
		
		$query = $this->db->get();

    	if ($query->num_rows() > 0)
        	return $query->result();
	}
	
	
	/******************************************************************************************
	* Description		: this function to get module detail 
	* input				: $queryString
	* author			: Freddy Ajang Tony
	* Date				: 01 July 2013
	* Modification Log	: -
	******************************************************************************************/
	function get_module_weightage($queryString,$modType)
	{
		
		$this->db->select('m.*,cm.cm_semester');
		$this->db->from('module m');
		$this->db->join('course_module cm','cm.mod_id = m.mod_id','left');
		$this->db->where('m.mod_id',$queryString);
		
		$query = $this->db->get();

    	if ($query->num_rows() > 0)
		{
			$result = $query->row();
			
			if($modType == "VK")
			{
				//Wajaran untuk VK (Vokasional)
				$result->module_pt = $this->get_module_pt($queryString);
			}
			else 
			{
				$avData;
				$this -> modul_paper_ak($avData, $aOpt='', $queryString);
				
				if($avData != null)
					$queryString = $queryString.','.$avData;
				
				//Wajaran untuk AK (Akademik)
				$result->module_ppr = $this->get_module_ppr($queryString);
			}
			
			return $result;
		}
	}
	
	
	/******************************************************************************************
	* Description		: this function to get module pt
	* input				: 
	* author			: Freddy Ajang Tony
	* Date				: 07 July 2013
	* Modification Log	: -
	******************************************************************************************/
	function get_module_pt($mod_id) 
	{
		$this->db->select('mp.*');
		$this->db->from('module_pt mp');
		$this->db->where('mp.mod_id',$mod_id);
		$this->db->group_by('pt_category');
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return null;
	}
	
	
	/******************************************************************************************
	* Description		: this function save update assessment configuration
	* input				: $data
	* author			: Freddy Ajang Tony
	* Date				: 08 July 2013
	* Modification Log	: -
	******************************************************************************************/
	function save_update_weightage_conf($data)
	{
		$this->db->where('mod_id', $data['mod_id']);
		$this->db->update('module', $data);
	}
	
	
	/******************************************************************************************
	* Description		: this function to save module_pt
	* input				: $data
	* author			: Freddy Ajang Tony
	* Date				: 08 July 2013
	* Modification Log	: -
	******************************************************************************************/
	function save_update_module_configuration($data)
	{
		if(count($data)>0)
			$this->db->update_batch('module_pt', $data,'pt_id'); 
	}
	
	
	/******************************************************************************************
	* Description		: this function to save module_ppr
	* input				: $data
	* author			: Freddy Ajang Tony
	* Date				: 23 July 2013
	* Modification Log	: -
	******************************************************************************************/
	function save_update_paper_configuration($data)
	{
		if(count($data)>0)
			$this->db->update_batch('module_ppr', $data,'ppr_id'); 
	}
	
	
	/******************************************************************************************
	* Description		: this function to get paper id for Academic module
	* input				: $data
	* author			: Freddy Ajang Tony
	* Date				: 18 July 2013
	* Modification Log	: -
	******************************************************************************************/
	function modul_paper_ak(&$avData, $opt = null, $parent = null) {

		$this -> db -> select('*', FALSE);
		$this -> db -> where("mod_paper_one IN(".$parent.")");
		$this -> db -> order_by("m.mod_code", "asc");
		$q = $this -> db -> get("module m");

		$i = 0;
		foreach ($q->result() as $r) {
			
			if($i!=0)
			 $avData += ',';
			
			$avData += $r->mod_id;
			
			$this -> modul_paper_ak($avData, $opt, $r -> mod_id);
			$i++;
		}
	}
	
	
	/******************************************************************************************
	* Description		: this function to get module ppr
	* input				: 
	* author			: Freddy Ajang Tony
	* Date				: 22 July 2013
	* Modification Log	: -
	******************************************************************************************/
	function get_module_ppr($mod_id) 
	{
		$this->db->select('mppr.*');
		$this->db->from('module_ppr mppr');
		$this->db->where('mppr.mod_id IN('.$mod_id.')');
		//$this->db->group_by('ppr_category');
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
		return null;
	}

	
}// end of Class
/**************************************************************************************************
* End of m_weightage.php
**************************************************************************************************/
?>
