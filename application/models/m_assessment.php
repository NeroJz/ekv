<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**************************************************************************************************
* File Name        : m_assessment.php
* Description      : This File contain function for assessment configuration
* Author           : Freddy Ajang Tony
* Date             : 18 June 2013
* Version          : -
* Modification Log : -
* Function List	   : -
**************************************************************************************************/

class M_assessment extends CI_Model 
{
	
	/**********************************************************************************************
	* Description		: this function to get list of assessment configuration that has been
	*					: set. 
	* input				: $session = date(year)
	* author			: Freddy Ajang Tony
	* Date				: 18 June 2013
	* Modification Log	: - 25 june 2013 - Fred - New version
	**********************************************************************************************/
	function get_assessment_configuration($session,$year)
	{
		$this->db->select('sdc.*');
		$this->db->from('submit_date_configuration sdc');
		$this->db->where('sdc.sd_current_session',$session);
		$this->db->where('sdc.sd_current_year',$year);
		$this->db->where("FROM_UNIXTIME(sdc.sd_close_date, '%Y-%m-%d') >= curdate()");
		$this->db->_protect_identifiers = FALSE;
		$this->db->order_by("sdc.sd_current_semester,
							FIELD(sdc.sd_assessment_type, 'PA', 'PT','PAK')");
		$this->db->_protect_identifiers = TRUE;
		//$this->db->order_by("sdc.sd_current_semester,sdc.sd_assessment_type");
		
		$query = $this->db->get();

    	if ($query->num_rows() > 0)
		{
			$result = $query->result();
			$tblfrom = 'sd';
			foreach($result as $r)
			{
				$config_id = $r->sdconfig_id;
				
				$r->userlist = $this->user_level_details_by_ids($config_id,$tblfrom);
			}
			
			
        	//return $result;
        	return $result;
		}
		
		return 0;
	}
	
	
	/**********************************************************************************************
	* Description		: this function to get list of assessment configuration that has been
	*					: set manually 
	* input				: $session = date(year)
	* author			: Freddy Ajang Tony
	* Date				: 18 June 2013
	* Modification Log	: - 25 june 2013 - Fred - New version
	**********************************************************************************************/
	function get_manual_assessment_configuration($session,$year)
	{
		/*$this->db->select('GROUP_CONCAT(CAST( sdm.sdmconfig_id AS CHAR )) AS sdmconfig_ids ,sdm.sdm_open_date ,sdm.sdm_close_date , sdm.sdm_assessment_type,
				GROUP_CONCAT( CAST( sdm.col_id AS CHAR )) AS col_ids,GROUP_CONCAT(CAST(col.col_code AS CHAR))AS col_codes,
				GROUP_CONCAT(CAST(col.col_name AS CHAR))AS col_names');
		$this->db->from('submit_date_manual_configuration sdm');
		$this->db->join('college col','col.col_id = sdm.col_id','left');
		$this->db->where('sdm_current_session',$session);
		$this->db->where('sdm_current_year',$year);
		$this->db->group_by('sdm_open_date, sdm_close_date');
		$this->db->order_by('sdm_assessment_type');*/
		$this->db->select('DISTINCT GROUP_CONCAT(DISTINCT(CAST( sdm.col_id AS CHAR ))ORDER BY sdm.col_id) AS col_ids',FALSE);
		$this->db->from('submit_date_manual_configuration sdm');
		$this->db->where('sdm_current_session',$session);
		$this->db->where('sdm_current_year',$year);
		$this->db->where("FROM_UNIXTIME(sdm.sdm_close_date, '%Y-%m-%d') >= curdate()");
		$this->db->group_by('sdm.sdm_current_session, sdm.sdm_current_year,sdm.sdm_open_date,sdm.sdm_close_date');
		
		$query = $this->db->get();

		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			
			foreach($result as $r)
			{
				if($r->col_ids != null)
				{
					$r->kvslist = $this->kv_detail_by_ids($r->col_ids);
				}
				
				$r->assessment_type = $this->get_detail_manual_assessment_configuration($session,$year,$r->col_ids);
			}
			
			return $result;
		}
    	
		return 0;
	}
	
	
	/**********************************************************************************************
	* Description		: this function to each assessment type manual configuration
	* input				: 
	* author			: Freddy Ajang Tony
	* Date				: 16 July 2013
	* Modification Log	: -
	**********************************************************************************************/
	function get_detail_manual_assessment_configuration($session,$year,$col_ids)
	{
		$this->db->select('GROUP_CONCAT(CAST(sdm.sdmconfig_id AS CHAR)ORDER BY sdm.sdmconfig_id)AS 
							sdmconfig_ids, 
							sdm.sdm_open_date, sdm.sdm_close_date, sdm.sdm_assessment_type,
							sdm.sdm_current_semester');
		$this->db->from('submit_date_manual_configuration sdm');
		$this->db->join('college col','col.col_id = sdm.col_id','left');
		$this->db->where('sdm_current_session',$session);
		$this->db->where('sdm_current_year',$year);
		$this->db->where('sdm.col_id IN ('.$col_ids.')');
		$this->db->group_by('sdm.sdm_current_semester,sdm.sdm_assessment_type');
		$this->db->_protect_identifiers = FALSE;
		$this->db->order_by("sdm.sdm_current_semester,
							FIELD(sdm.sdm_assessment_type, 'PA', 'PT','SA','ST','PAK','SAK')");
		$this->db->_protect_identifiers = TRUE;
		
		$query = $this->db->get();
		
		
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			$tblfrom = 'sdm';
			
			foreach($result as $r)
			{
				
				if($r->sdmconfig_ids != null)
				{
					//$mconfig_ids = explode(',', $r->sdmconfig_ids);
					//foreach($mconfig_ids as  $mconfig_id=>$value)
					//{
					$r->userlist = $this->user_level_details_by_ids($r->sdmconfig_ids,$tblfrom);	
						//$r->userlist
					//}		
				}
			}
			return $result;
		}
	}
	
	
	/**********************************************************************************************
	* Description		: this function to get kv details by id.
	* input				: $r->col_ids = $ids
	* author			: Freddy Ajang Tony
	* Date				: 18 June 2013
	* Modification Log	: -
	**********************************************************************************************/
	function kv_detail_by_ids($ids) 
	{
		$this->db->select('col.*');
		$this->db->from('college col');
		$this->db->where('col.col_id IN ('.$ids.')');
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$kv_detail = $query->result();
			return $kv_detail;
		}
		return null;
	}
	
	
	/**********************************************************************************************
	* Description		: this function to search kv details by string.
	* input				: $queryString
	* author			: Freddy Ajang Tony
	* Date				: 19 June 2013
	* Modification Log	: -
	**********************************************************************************************/
	function kv_detail_search($queryString) 
	{
		/*$query = "s.* , d.* FROM staff s, department d WHERE s.department_id = d.department_id AND s.staff_position in('Pensyarah', 'Pensyarah/p') AND (".
				 " UPPER( department_acronym ) = UPPER('".$queryString."') ".
				 " OR UPPER( staff_name ) LIKE UPPER('%".$queryString."%') ".
				// " OR UPPER( staff_position ) LIKE UPPER('%".$queryString."%') ".
				 " OR staff_number LIKE '".$queryString."%')";*/
		
		$this->db->select('col.*');
		$this->db->from('college col');
		$this->db->like('UPPER(col.col_code)',$queryString,'none');
		$this->db->or_like('UPPER(col.col_type)',$queryString);
		$this->db->or_like('UPPER(col.col_name)',$queryString);

		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			return $query->result();
		}
	}
	
	
	/**********************************************************************************************
	* Description		: this function save update assessment configuration
	* input				: $data
	* author			: Freddy Ajang Tony
	* Date				: 20 June 2013
	* Modification Log	: -
	**********************************************************************************************/
	function save_update_assessment_configuration($data)
	{
		if(isset($data))
		{
			$sdconfig_ids = array();
			foreach($data as $mdata => $value)
			{
				if($value['sdconfig_id'] == 0)
				{
					$this->db->insert('submit_date_configuration',$value);
					$sdconfig_id = $this->db->insert_id();
					
					if (isset($sdconfig_id))
					{
						array_push($sdconfig_ids,$sdconfig_id);
					}
					else
					{
						return 0;
					}
				}
				else
				{
					$this->db->where('sdconfig_id', $value['sdconfig_id']);
					$this->db->update('submit_date_configuration', $value);
					
					array_push($sdconfig_ids,$value['sdconfig_id']);
				}
			}
			
			return $sdconfig_ids;
		}
	}
	
	
	/**********************************************************************************************
	* Description		: this function save update assessment configuration manual
	* input				: $data
	* author			: Freddy Ajang Tony
	* Date				: 20 June 2013
	* Modification Log	: -
	**********************************************************************************************/
	function save_assessment_manual_configuration($data)
	{
		
		//$this->db->insert_batch('submit_date_manual_configuration ', $data); 
		if(count($data)>0)
		{
			$sdmconfig_ids = array();	
			foreach($data as $mdata)
			{
				$this->db->insert('submit_date_manual_configuration',$mdata);
				$sdmconfig_id = $this->db->insert_id();
				
				if (isset($sdmconfig_id))
				{
					array_push($sdmconfig_ids,$sdmconfig_id);
				}
				else
				{
					return 0;
				}
			}
			
			return $sdmconfig_ids;
		}
	}


	/**********************************************************************************************
	* Description		: this function delete assessment configuration manual by id
	* input				: $data
	* author			: Freddy Ajang Tony
	* Date				: 20 June 2013
	* Modification Log	: -
	**********************************************************************************************/
	function delete_assessment_manual_configuration($fid,$sesi,$tahun)
	{
		$this->db->select('sdm.sdmconfig_id, GROUP_CONCAT(CAST(ulm.ulmconfig_id AS CHAR))
							 AS ulmconfig_ids');
		$this->db->from('submit_date_manual_configuration sdm');
		$this->db->join('user_level_manual_configuration ulm',
							'ulm.sdmconfig_id = sdm.sdmconfig_id','left');
		$this->db->where('sdm.col_id', $fid);
		$this->db->where('sdm.sdm_current_session', $sesi);
		$this->db->where('sdm.sdm_current_year', $tahun);
		$this->db->group_by('sdmconfig_id');
		
		$query = $this->db->get();
		
		if ($query->num_rows() > 0)
		{
			$result = $query->result();
			
			foreach($result as $r)
			{
				$this->db->where('sdmconfig_id', $r->sdmconfig_id);
				$this->db->delete('submit_date_manual_configuration');
						
				$this->db->where_in('ulmconfig_id', $r->ulmconfig_ids);
				$this->db->delete('user_level_manual_configuration');
				
			}
			
			return $this->db->affected_rows();
		}
	}
	
	
	/**********************************************************************************************
	* Description		: this function to get list of user level configuration
	* input				: $sdconfig_id
	* author			: Freddy Ajang Tony
	* Date				: 26 June 2013
	* Modification Log	: - 
	**********************************************************************************************/
	function user_level_details_by_ids($config_id,$tblfrom)
	{
		$this->db->select('GROUP_CONCAT(DISTINCT(CAST(ulm.ulmconfig_id AS CHAR))
							ORDER BY ulm.ulmconfig_id)AS ulmconfig_ids,
							GROUP_CONCAT(DISTINCT(CAST(ulm.sdmconfig_id AS CHAR))
							ORDER BY ulm.sdconfig_id)AS sdmconfig_ids,
							GROUP_CONCAT(DISTINCT(CAST(ul.ul_id AS CHAR))
							ORDER BY ul.ul_id)AS ul_ids,
							GROUP_CONCAT(DISTINCT(CAST(ul.ul_name AS CHAR))
							ORDER BY ul.ul_name DESC)AS ul_names,
							ulm.end_date_user');
		$this->db->from('user_level_manual_configuration ulm');
		$this->db->join('user_level ul','ul.ul_id = ulm.ul_id','left');
		
		if('sd'== $tblfrom)
			$this->db->where('ulm.sdconfig_id IN ('.$config_id.')');
		
		if('sdm'== $tblfrom)
			$this->db->where('ulm.sdmconfig_id IN ('.$config_id.')');
		
		$this->db->group_by('end_date_user');
		$this->db->_protect_identifiers = FALSE;
		$this->db->order_by("FIELD(ul.ul_name, 'Pengarah', 'Timbalan Pengarah','Pensyarah','KJPP','KUPP')");
		$this->db->_protect_identifiers = TRUE;
		//$this->db->where('ulm.ul_id IN ('.$ids.')');
		
		$query = $this->db->get();
		
		if($query->num_rows() > 0)
		{
			$user_detail = $query->result_array();
			
			return $user_detail;
		}
		return null;
	}
	
	
	/**********************************************************************************************
	* Description		: this function to save/update user level date
	* input				: $ulm_data,$status
	* author			: Freddy Ajang Tony
	* Date				: 29 June 2013
	* Modification Log	: - 
	**********************************************************************************************/
	function save_update_user_level_configuration($ulm_data,$status,$submit_date)
	{
		if($submit_date == "M")
		{
			if($status>0)
			{
				$this->db->update_batch('user_level_manual_configuration',
												 $ulm_data,'ulmconfig_id');
			}
			else 
			{
				$this->db->insert_batch('user_level_manual_configuration', $ulm_data);
			}
		}
		else
		{
			foreach($ulm_data as $mdata => $value)
			{
				if($value['ulmconfig_id'] == 0)
				{
					$this->db->insert('user_level_manual_configuration',$value);
				}
				else
				{
					$this->db->where('ulmconfig_id', $value['ulmconfig_id']);
					$this->db->update('user_level_manual_configuration', $value);
				}
			}
		}
		
	}
	
	
	/**********************************************************************************************
	* Description		: this function to get list of assessment configuration that has been
	*					: set. 
	* input				: $session = date(year), $sem = semester
	* author			: Freddy Ajang Tony
	* Date				: 24 July 2013
	* Modification Log	: -
	**********************************************************************************************/
	function get_assessment_config_by_semester($session,$year,$semester,$type)
	{
		$this->db->select('GROUP_CONCAT(CAST(sdc.sdconfig_id AS CHAR)) AS sdconfig_id,
						sdc.sd_current_session,sdc.sd_current_year,
						GROUP_CONCAT(CAST(sdc.sd_current_semester AS CHAR)) AS sd_current_semester,
						sdc.sd_open_date,sdc.sd_close_date,sdc.sd_assessment_type');
		$this->db->from('submit_date_configuration sdc');
		$this->db->where('sdc.sd_current_session',$session);
		$this->db->where('sdc.sd_current_year',$year);
		$this->db->where('sdc.sd_current_semester IN ('.$semester.')');
		$this->db->where("FROM_UNIXTIME(sdc.sd_close_date, '%Y-%m-%d') >= curdate()");
				
		if("vk" == $type)
			$this->db->where('sdc.sd_assessment_type IN ("PA","PT","PAK")');
		
		if("ak" == $type)
			$this->db->where('sdc.sd_assessment_type IN ("PAK","SAK")');
		
		$this->db->group_by('sd_open_date, sd_close_date,sd_assessment_type');
		$this->db->_protect_identifiers = FALSE;
		$this->db->order_by("FIELD(sdc.sd_assessment_type, 'PA', 'PT','SA','ST','PAK','SAK')");
		$this->db->_protect_identifiers = TRUE;
		
		$query = $this->db->get();

    	if ($query->num_rows() > 0)
		{
			$result = $query->result();
			$tblfrom = 'sd';
			foreach($result as $r)
			{
				$config_id = $r->sdconfig_id;
				
				$r->userlist = $this->user_level_details_by_ids($config_id,$tblfrom);
			}
			
			
        	//return $result;
        	return $result;
		}
	}
	
	
	/**********************************************************************************************
	* Description		: this function to get group semester for link.
	* input				: $session = date(year)
	* author			: Freddy Ajang Tony
	* Date				: 29 July 2013
	* Modification Log	: -
	**********************************************************************************************/
	function get_group_semester($session,$year,$type)
	{
		$this->db->select('DISTINCT(sdc.sd_current_semester) AS semester');
		$this->db->from('submit_date_configuration sdc');
		$this->db->where('sdc.sd_current_session',$session);
		$this->db->where('sdc.sd_current_year',$year);
		$this->db->where("FROM_UNIXTIME(sdc.sd_close_date, '%Y-%m-%d') >= curdate()");
		
		if("vk" == $type)
			$this->db->where('sdc.sd_assessment_type IN ("PA","PT","PAK")');
		
		if("ak" == $type)
			$this->db->where('sdc.sd_assessment_type IN ("PAK","SAK")');
		
		$query = $this->db->get();

    	if ($query->num_rows() > 0)
		{
			$result = $query->result();
			
        	//return $result;
        	return $result;
		}
	}
	
}// end of Class
/**************************************************************************************************
* End of m_assessment.php
**************************************************************************************************/
?>
