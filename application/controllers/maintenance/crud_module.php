<?php

class Crud_module extends MY_Controller{
	
	function __construct(){
		parent::__construct();
		$this->load->model('m_ext_module');
		$this->load->model('m_ext_module_ppr');
		$this->load->model('m_ext_module_pt');
	}
	/************************************************************************************
 	* Description		: this function is use to echo page content
 	* input				: $output - content and data of the page
 	* author			: Jz
 	* Date				: 11-04-2014
 	* Modification Log	:
 	*************************************************************************************/
	function _main_output($output = null, $header = ''){
		$this -> load -> view('main.php', $output);
	}
	
	function index(){
		$heading = array(
			'Kod Modul',
			'Kertas Modul',
			'Nama Modul',
			'Jenis Modul',
			'Markah Modul (Pusat)',
			'Peratusan Kertas Pusat',
			'Markah Modul (Sekolah)',
			'Peratusan Kertas Sekolah',
			'Jam Kredit Modul',
			'Status',
			'Tindakan'
		);
		
		
		//load datatable amtis
		$this->load->library("datatables_amtis");
		$dtAmt = $this->datatables_amtis;
		$dtAmt->set_heading($heading);
		
		$aConfigDt['aoColumnDefs'] = '[
			{ "sWidth": "6%", "aTargets": [ 0 ] },
			{ "sWidth": "10%", "aTargets": [ 1 ] },
            { "sWidth": "12%", "aTargets": [ 2 ] },
            { "sWidth": "8%", "aTargets": [ 3 ] },
            { "sWidth": "10%", "aTargets": [ 4] },
            { "sWidth": "10%", "aTargets": [ 5 ] },
            { "sWidth": "10%", "aTargets": [ 6 ] },
            { "sWidth": "10%", "aTargets": [ 7 ] },
            { "sWidth": "10%", "aTargets": [ 8 ] },
            { "sWidth": "5%", "aTargets": [ 9 ] },
            { "sWidth": "10%", "aTargets": [ 10 ] }                    
        ]';
		$aConfigDt['bSort'] = 'true';
		$aConfigDt['aaSorting'] = '[[ 0, "asc"],[1,"asc"]]';
		
		$dtAmt->setConfig($aConfigDt);
		
		$dtAmt->setAoData('category','sCategory',false);
		$dtAmt->setAoData('status','sStatus',false);
		
		$datatable = $dtAmt->generateView(site_url('maintenance/crud_module/ajaxdata_search_modul'),'tblModul',true);
		
		$data = $datatable;
		$content = array(
			'AK_content' => $this->callback_modTypeSelection('AK'),
			'VK_content' => $this->callback_modTypeSelection('VK')
		);

		$data['content'] = json_encode($content);

		$output['output'] = $this -> load -> view('maintenance/v_module_maintenance', $data, true);
		$this -> _main_output($output);
		
	}
	
	function ajaxdata_search_modul(){
		$this->load->library("datatables_amtis");
		$dtAmt = $this->datatables_amtis;
		
		$category = $this->input->post('category');
		$status = $this->input->post('status');
		
		//if("" == $category){ $category = "AK";}
		
		//if("" == $status){	$status = "1";}
		
		$query = "mod_id, mod_code, mod_paper, mod_name, mod_type, mod_mark_centre, mod_mark_school,
			mod_credit_hour, stat_mod";
			
		$dtAmt->select('mod_id, mod_code, mod_paper, mod_name, mod_type, mod_mark_centre, (mod_id) AS pkp_id, mod_mark_school, 
		(mod_id) AS pks_id, mod_credit_hour, stat_mod')
		->from('module')
		->like("mod_type",$category,'both')
		->like("stat_mod",$status,'both')
		->add_column('Tindakkan', '$1',"checkOptions(Modul, mod_id)");
		
		$dtAmt->edit_column("stat_mod",'$1',"formatStatMod(stat_mod)");
		
		if($category == 'AK'){
			$dtAmt->edit_column('pkp_id','$1',"checkPercentage(pkp_id, P, AK)");
			$dtAmt->edit_column('pks_id','$1',"checkPercentage(pks_id, S, AK)");
		}else if($category == 'VK'){
			$dtAmt->edit_column('pkp_id','$1',"checkPercentage(pkp_id, P, VK)");
			$dtAmt->edit_column('pks_id','$1',"checkPercentage(pks_id, S, VK)");
		}
		
		
		$dtAmt->unset_column('mod_id');
		
		echo $dtAmt->generate();
		
	}
/****************************************************************************************************
 	* Description		: this function is use generate the content for each module type
 	* input				: $mod_type - module type AK or VK
 	*					  $scores - array object with previous record read from database, 0 if empty	 
 	* author			: Jz
 	* Date				: 11-04-2014
 	* Modification Log	:
*****************************************************************************************************/
	function callback_modTypeSelection($mod_type = null, $scores = null){
		$centre = '<div class="control-group">
					<label class="control-label" for="mod_mark_centre">Markah Modul (Pusat) :</label>
						<div class="controls">
							<input type="text" name="mod_mark_centre" id="mod_mark_centre"
							value="'.(empty($scores['mod_mark_centre']) ? 0 : $scores['mod_mark_centre']).'" class="validate[required] text-input" />
						</div>
					</div>';
		$school = '<div class="control-group">
					<label class="control-label" for="mod_mark_school">Markah Modul (Sekolah) :</label>
						<div class="controls">
							<input type="text" name="mod_mark_school" id="mod_mark_school" 
							value="'.(empty($scores['mod_mark_school']) ? 0 : $scores['mod_mark_school']).'" class="validate[required] text-input" />
						</div>
					</div>';
		if($mod_type == 'AK'){
			$centre_percentage = '<div class="control-group">
									<label class="control-label" for="ppr_percentage_p">Peratusan Kertas Pusat :</label>
									<div class="controls">
										<input type="text" maxlength="3" name="ppr_percentage_p" id="ppr_percentage_p"
										value="'.(empty($scores['ppr_p']) ? 0 : $scores['ppr_p']).'" class="validate[required] text-input" style="width:30px;" />%
									</div>
								  </div>';
			$school_percentage = '<div class="control-group">
									<label class="control-label" for="ppr_percentage_s">Peratusan Kertas Sekolah :</label>
									<div class="controls">
										<input type="text" maxlength="3" name="ppr_percentage_s" id="ppr_percentage_s" 
										value="'.(empty($scores['ppr_s']) ? 0 : $scores['ppr_s']).'" class="validate[required] text-input" style="width:30px;" />%
									</div>
								  </div>';
		}elseif($mod_type == 'VK'){
			$centre_percentage = '<div class="control-group">
									<label class="control-label" for="">Peratusan Amali/Teori Pusat :</label>
									<div class="controls">
										Teori : <input type="text" maxlength="3" name="pt_teori_p" id="pt_teori_p" 
										value="'.(empty($scores['pt_teori_p']) ? 0 : $scores['pt_teori_p']).'"class="validate[required] text-input" style="width:30px;" />%
										Amali : <input type="text" maxlength="3" name="pt_amali_p" id="pt_amali_p" 
										value="'.(empty($scores['pt_amali_p']) ? 0 : $scores['pt_amali_p']).'"class="validate[required] text-input" style="width:30px;" />%
									</div>
								  </div>';
			$school_percentage = '<div class="control-group">
									<label class="control-label" for="col_code">Peratusan Amali/Teori Sekolah :</label>
									<div class="controls">
										Teori : <input type="text" maxlength="3" name="pt_teori_s" id="pt_teori_s" 
										value="'.(empty($scores['pt_amali_s']) ? 0 : $scores['pt_amali_s']).'"class="validate[required] text-input" style="width:30px;" />%
										Amali : <input type="text" maxlength="3" name="pt_amali_s" id="pt_amali_s" 
										value="'.(empty($scores['pt_amali_s']) ? 0 : $scores['pt_amali_s']).'"class="validate[required] text-input" style="width:30px;" />%
									</div>
								  </div>';
		}
		return $centre . $centre_percentage . $school . $school_percentage;
	}
	/**************************************************************************************
	* Description		: this function load the record from module, module_ppr, module_pt
	* input				: -
	* author			: Jz
	* Date				: 07-04-2014
	* Modification Log	:
	***************************************************************************************/
	function callback_edit(){
		$mod_id = $this->input->post('mod_id');
		$filers = array(
			'mod_id' => $mod_id
		);
		
		$result_module = $this->m_ext_module->get_filters($filers);
		$result_ppr = $this->m_ext_module_ppr->get_filters($filers);
		$result_pt = $this->m_ext_module_pt->get_filters($filers);
		
		if(!empty($result_module)){
			$module_info['mod_mark_centre'] = $result_module[0]->mod_mark_centre;
			$module_info['mod_mark_school'] = $result_module[0]->mod_mark_school;
			$module_info['stat_mod'] = $result_module[0]->stat_mod;
			$module_info['mod_type'] = $result_module[0]->mod_type;
		}
		if(!empty($result_ppr)){
			foreach($result_ppr as $row){
				$module_info['ppr_percentage_'.$row->ppr_category] = $row->ppr_percentage;
			}
		}
		if(!empty($result_pt)){
			foreach($result_pt as $row){
				$module_info['pt_teori_'.$row->pt_category] = $row->pt_teori;
				$module_info['pt_amali_'.$row->pt_category] = $row->pt_amali;
			}
		}
		$score_AK = array(
			'mod_mark_centre' => $module_info['mod_mark_centre'],
			'mod_mark_school' => $module_info['mod_mark_school'],
			'ppr_p' => $module_info['ppr_percentage_P'],
			'ppr_s' => $module_info['ppr_percentage_S']
		);
		$score_VK = array(
			'mod_mark_centre' => $module_info['mod_mark_centre'],
			'mod_mark_school' => $module_info['mod_mark_school'],
			'pt_teori_p' => $module_info['pt_teori_P'],
			'pt_amali_p' => $module_info['pt_amali_P'],
			'pt_teori_s' => $module_info['pt_teori_S'],
			'pt_amali_s' => $module_info['pt_amali_S']
		);
		
		$module_info['AK_content'] = $this->callback_modTypeSelection('AK',$score_AK);
		$module_info['VK_content'] = $this->callback_modTypeSelection('VK',$score_VK);
		
		echo json_encode($module_info);
	}
/****************************************************************************************************
 	* Description		: this function is use insert data into module, module_ppr, module_pt	 
 	* author			: Jz
 	* Date				: 11-04-2014
 	* Modification Log	:
*****************************************************************************************************/
	function insert(){
		$mod_code = $this->input->post('mod_code');
		$mod_paper = $this->input->post('mod_paper');
		$mod_name = $this->input->post('mod_name');
		$mod_type = $this->input->post('mod_type');
		$mod_mark_centre = $this->input->post('mod_mark_centre');
		$mod_mark_school = $this->input->post('mod_mark_school');
		$mod_credit_hour = $this->input->post('mod_credit_hour');
		$stat_mod = $this->input->post('stat_mod');
		
		
		
		$data = array(
			'mod_code' => $mod_code,
			'mod_paper' => $mod_paper,
			'mod_name' => $mod_name,
			'mod_type' => $mod_type,
			'mod_mark_centre' => $mod_mark_centre,
			'mod_mark_school' => $mod_mark_school,
			'mod_credit_hour' => $mod_credit_hour,
			'stat_mod' => $stat_mod
		);
		
		$result_id = $this->m_ext_module->return_insert_id($data);
		
		if($result_id){
			if($mod_type == 'AK'){
				$ppr_percentage_p = $this->input->post('ppr_percentage_p');
				$ppr_percentage_s = $this->input->post('ppr_percentage_s');
				$data_ppr = array(
					array(
						'ppr_percentage' => $ppr_percentage_p,
						'ppr_category'	 =>	'P',
						'mod_id'		 =>	$result_id
					),
					array(
						'ppr_percentage' => $ppr_percentage_s,
						'ppr_category'	 =>	'S',
						'mod_id'		 =>	$result_id
					)
				);
				$data_pt = array(
					array(
						'pt_teori' 		 => 0,
						'pt_amali'	 => 0,
						'pt_category'	 =>	'P',
						'mod_id'		 =>	$result_id
					),
					array(
						'pt_teori' 		 => 0,
						'pt_amali'	 => 0,
						'pt_category'	 =>	'S',
						'mod_id'		 =>	$result_id
					)
				);
				
				
			}else if($mod_type == 'VK'){
				$pt_teori_p = $this->input->post('pt_teori_p');
				$pt_amali_p = $this->input->post('pt_amali_p');
				
				$pt_teori_s = $this->input->post('pt_teori_s');
				$pt_amali_s = $this->input->post('pt_amali_s');
				
				$data_ppr = array(
					array(
						'ppr_percentage' => 0,
						'ppr_category'	 =>	'P',
						'mod_id'		 =>	$result_id
					),
					array(
						'ppr_percentage' => 0,
						'ppr_category'	 =>	'S',
						'mod_id'		 =>	$result_id
					)
				);
				$data_pt = array(
					array(
						'pt_teori' 		 => $pt_teori_p,
						'pt_amali'	 	 => $pt_amali_p,
						'pt_category'	 =>	'P',
						'mod_id'		 =>	$result_id
					),
					array(
						'pt_teori' 		 => $pt_teori_s,
						'pt_amali'	 	 => $pt_amali_s,
						'pt_category'	 =>	'S',
						'mod_id'		 =>	$result_id
					)
				);
			}
			
			$result_ppr = $this->m_ext_module_ppr->insert_by_batch($data_ppr);
			$result_pt  = $this->m_ext_module_pt->insert_by_batch($data_pt);
			
			if($result_ppr && $result_pt){
				echo TRUE;
			}else{
				echo FALSE;
			}
			
		}
	}
/****************************************************************************************************
 	* Description		: this function is use update data into module, module_ppr, module_pt	 
 	* author			: Jz
 	* Date				: 11-04-2014
 	* Modification Log	:
*****************************************************************************************************/
	
	function update(){
		$mod_id = $this->input->post('mod_id');
		$mod_code = $this->input->post('mod_code');
		$mod_paper = $this->input->post('mod_paper');
		$mod_name = $this->input->post('mod_name');
		$mod_type = $this->input->post('mod_type');
		$mod_mark_centre = $this->input->post('mod_mark_centre');
		$mod_mark_school = $this->input->post('mod_mark_school');
		$mod_credit_hour = $this->input->post('mod_credit_hour');
		$stat_mod = $this->input->post('stat_mod');
		
		$module = array(
			'mod_code' => $mod_code,
			'mod_paper' => $mod_paper,
			'mod_name' => $mod_name,
			'mod_type' => $mod_type,
			'mod_mark_centre' => $mod_mark_centre,
			'mod_mark_school' => $mod_mark_school,
			'mod_credit_hour' => $mod_credit_hour,
			'stat_mod' => $stat_mod
		);
		
		$module_filters = array(
			'mod_id' => $mod_id
		);
		
		if($mod_type == 'AK'){
			$ppr_percentage_p = $this->input->post('ppr_percentage_p');
			$ppr_percentage_s = $this->input->post('ppr_percentage_s');
			
			$module_ppr_p = array(
				'ppr_percentage' => $ppr_percentage_p
			);
			$module_ppr_p_filter = array(
				'mod_id' => $mod_id,
				'ppr_category' => 'P'
			);
			$module_ppr_s = array(
				'ppr_percentage' => $ppr_percentage_s
			);
			$module_ppr_s_filter = array(
				'mod_id' => $mod_id,
				'ppr_category' => 'S'
			);
			$module_pt = array(
				'pt_teori' => 0,
				'pt_amali' => 0
			);
			$module_pt_filters = array(
				'mod_id' => $mod_id
			);
			
			$module_update = $this->m_ext_module->update_filters($module,$module_filters);
			$module_ppr_p_update = $this->m_ext_module_ppr->update_filters($module_ppr_p,$module_ppr_p_filter);
			$module_ppr_s_update = $this->m_ext_module_ppr->update_filters($module_ppr_s,$module_ppr_s_filter);
			$module_pt_update = $this->m_ext_module_pt->update_filters($module_pt,$module_pt_filters);
			
			if(!$module_update && !$module_ppr_p_update && !$module_ppr_s_update && !$module_pt_update){
				echo FALSE;
			}else{
				echo TRUE;
			}
		}else if($mod_type == 'VK'){
			$pt_teori_p = $this->input->post('pt_teori_p');
			$pt_amali_p = $this->input->post('pt_amali_p');
			$pt_teori_s = $this->input->post('pt_teori_s');
			$pt_amali_s = $this->input->post('pt_amali_s');
			
			$module_pt_p = array(
				'pt_teori' => $pt_teori_p,
				'pt_amali' => $pt_amali_p
			);
			$module_pt_p_filters = array(
				'pt_category' => 'P',
				'mod_id' => $mod_id
			);
			
			
			$module_pt_s = array(
				'pt_teori' => $pt_teori_s,
				'pt_amali' => $pt_amali_s
			);
			$module_pt_s_filters = array(
				'pt_category' => 'S',
				'mod_id' => $mod_id
			);
			
			$module_ppr = array(
				'ppr_percentage' => 0
			);
			$module_ppr_filters = array(
				'mod_id' => $mod_id
			);
			
			$module_update = $this->m_ext_module->update_filters($module,$module_filters);
			$module_pt_p_update = $this->m_ext_module_pt->update_filters($module_pt_p, $module_pt_p_filters);
			$module_pt_s_update = $this->m_ext_module_pt->update_filters($module_pt_s, $module_pt_s_filters);
			$module_ppr_update = $this->m_ext_module_ppr->update_filters($module_ppr, $module_ppr_filters);
			
			if(!$module_update && !$module_pt_p_update && !$module_pt_s_update && !$module_ppr_update){
				echo FALSE;
			}else{
				echo TRUE;
			}
		}
	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}