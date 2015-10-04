<?php 
/**************************************************************************************************
* File Name        : signage_helper.php
* Description      : This File contain function collection.
* Author           : Fakhruz
* Date             : 26 NOV 2013
* Version          : 0.1
* Modification Log : 
* Function List	   : 
**************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**************************************************************************************************
 * Description			: func to change date from mysql to fomal format and vice versa
* Author				: fakhruz
* Date					: 26 November 2013
* Input Parameter		:
* Modification Log		:
**************************************************************************************************/
function dateFormatToggle($date){
	$arr=explode('-',$date);
	//print_r($arr);
		return $new_date=$arr[2].'-'.$arr[1].'-'.$arr[0];
}

function checkEdit($url, $id, $title, $staff_id)
{	
 	$CI =& get_instance();
 	
 	if($staff_id == $CI->session->userdata('staff_id') || $CI->session->userdata('staff_id') == 1){
 		return '<div style="margin-left:5px;">'.anchor($url.$id, $title).'</div>';
 	}
 	else
 	{
 		return '<div style="margin-left:5px;">'.$title.'</div>';
 	}

}

function checkStatus($url, $id, $title)
{
	$CI =& get_instance();
	
	$ee = $title;
	$strStatus = '';
	$stat = 0;
	$btnSubmitStatus = '';

	switch($CI->session->userdata("level"))
  	{
  		case 1:
  			$btnSubmitStatus = "style='cursor:pointer;' onclick=formSubmit('f".$id."')";
  			break;
  		case 2:
  			$btnSubmitStatus = "class='img_grey'";		
  			break;
  		default:
  			echo "Tahap Akses belum diset!!!";
  			break;
  	}
	
  	
  	$attributes = array('name' => 'f'.$id, 'id'=>'f'.$id);
  	//open form with codeigniter to included CSRF
  	$strStatus .= form_open($url, $attributes);
	$strStatus .= '<div align="center">';
	
	if($ee == 1) {
		$strStatus .= "<img src='".base_url()."images/on.png'
		$btnSubmitStatus id='element' data-original-title='Enable Content'  />";
		$stat = 0;
	}
	else {
	$strStatus .= "<img src='".base_url()."images/off.png'
	$btnSubmitStatus alt='DELETE' id='element' data-original-title='Disable Content' />";
	$stat = 1;
	}
	
	$strStatus .= '<input name="hid_status" type="hidden" value="'.$stat.'">
	<input name="hid_id" type="hidden" value="'.$id.'">
	</div>
	</form>';
	
	return $strStatus;

}

function checkDelete($url, $id, $staff_id)
{
	$CI =& get_instance();
	
	switch($CI->session->userdata("level"))
  	{
  		case 1:
  			return '<center><a onclick="return ask();" href="'.site_url($url.$id).'">
      						<img src="'.base_url().'images/images/delete-32.png" width="28" height="28"
							 alt="DELETE" id="element" data-original-title="Delete" /></a></center>';
  			break;
  		case 2:
  			if($staff_id == $CI->session->userdata('staff_id')){
  				return '<center><a onclick="return ask();" href="'.site_url($url.$id).'">
      						<img src="'.base_url().'images/images/delete-32.png" width="28" height="28"
							 alt="DELETE" id="element" data-original-title="Delete" /></a></center>';
  			}
  			else
  			{  				
  				return'<center><img class="img_grey" src="'.base_url().'images/images/delete-32.png" width="28" height="28"></center>';
  			}	
  			break;
  		default:
  			echo "Tahap Akses belum diset!!!";
  			break;
  	}
}

function checkAction($url, $id)
{
	return "<center><a class='btn btn-info btn-mini btn-in-table' href='" . site_url($url 
					.$id)."'><i class='icon-edit icon-white'></i>&nbsp;&nbsp;Kemas Kini</a></center>";
}


function formatName($val){
	return ucwords(strtolower($val));
}

function formatNumber($val){
	return "<div align='right'>$val</div>";
}

/*****************************************
 * Description: Added function for datatable
 * Author: Jz
 ****************************************/
function formatUserStatus($val){
	if($val == 1){
		return "<font color='green'>Aktif</font>";
	}else{
		return "<font color='red'>Tidak Aktif</font>";
	}
}
function strtotime_convert_to_date($value)
{
	if(null != $value) //kalau value tak sama null
	{
		$date = date("d-m-Y",$value);
	}
	else
	{
		$date = "-";
	}
		
	return $date;
}
/************************************************************************************
 * Description		: this function is use to call the model m_user and perform select
 * 					  user_name query
 * input			: $val - user_id
 * author			: Jz
 * Date				: 01-04-2014
 * Modification Log	:
*************************************************************************************/
function getUserInfo($val){
	$CI =& get_instance();
	$CI->load->model('m_user');
	
	$var = $CI->m_user->return_user_name($val);
	
	return $var;	
}
/************************************************************************************
 * Description		: this function is use to check percentage from module_ppr or module_pt
 * input			: $val - mod_id, $types - ppr_category or pt_category
 *                    $category - AK or VK
 * author			: Jz
 * Date				: 01-04-2014
 * Modification Log	:
*************************************************************************************/
function checkPercentage($val,$types, $category){
	$CI =& get_instance();
	if($category == 'AK'){
		$filters = array(
			'ppr_category' => $types,
			'mod_id' => $val
		);
		$CI->load->model('m_ext_module_ppr');
		$percentage = $CI->m_ext_module_ppr->get_by_filter($filters);
	}else if($category == 'VK'){
		$filters = array(
			'pt_category' => $types,
			'mod_id' => $val
		);
		$CI->load->model('m_ext_module_pt');
		$percentage = $CI->m_ext_module_pt->get_by_filter($filters);
	}
	
	if($percentage != ''){
		if(strpos($percentage, "-")!==false){
			$percentage = explode( '-',$percentage);
			$teori = $percentage[0];
			$amali = $percentage[1];
			return 'Teori : '.$teori.'%<br/>'.'Amali : '.$amali.'%';
		}else{
			return $percentage.'%';
		}	
	}else{
		return '<font color="red">'.'Tiada record'.'</font>';
	}	
}
/************************************************************************************
 * Description		: this function is use to convert the status of module
 * input			: $val - stat_mod
 * author			: Jz
 * Date				: 01-04-2014
 * Modification Log	:
*************************************************************************************/
function formatStatMod($val){
	if($val == 1){
		return '<font color="green" size="1.8em">Aktif</font>';
	}else if($val == 0){
		return '<font color="red" size="1.8em">Tidak Aktif</font>';
	}
}

/***********************************************************************************
 * Description: This function check and return the list of options available for the user to perform
 * Parameters: $menu - kursus, kolej, modul
 *             $id - id of a single record
 * ********************************************************************************/
function checkOptions($menu,$id){
	switch($menu){
		case 'Kursus':
			//$edit_url = site_url('/maintenance/crud_course/view/'.$id);
			
			//set two anchor links
			$anchor1 = "<a class='btn btn-info btn-mini btn-in-table btn_edit_popup' value='" . $id ."'>
			<i class='icon-edit icon-white'></i>&nbsp;&nbsp;Kemas Kini</a>";
			$anchor2 = "<a class='btn btn-danger btn-mini btn-in-table' onclick='confirm_delete_msg(" . $id .")'>
			<i class='icon-trash icon-white'></i>&nbsp;&nbsp;Hapus</a>";
			
			return "<center>".$anchor1."&nbsp".$anchor2."</center>";
			break;
		case 'Modul':
			$anchor1 = "<a class='btn btn-info btn-mini btn-in-table btn_edit_popup' value='" . $id ."'>
			<i class='icon-edit icon-white'></i>&nbsp;&nbsp;Kemas Kini</a>";
			return "<center>".$anchor1."</center>";
			break;
		case 'Kolej':
			$anchor1 = "<a class='btn btn-info btn-mini btn-in-table btn_edit_popup' value='" . $id ."'>
			<i class='icon-edit icon-white'></i>&nbsp;&nbsp;Kemas Kini</a>";
			return "<center>".$anchor1."</center>";
			break;
		case 'Pengumuman':
			$anchor1 = "<a class='btn btn-info btn-mini btn-in-table btn_edit_popup' value='" . $id ."'>
			<i class='icon-edit icon-white'></i>&nbsp;&nbsp;Kemas Kini</a>";
			return "<center>".$anchor1."</center>";
			break;
		default:
			echo "Tahap Akses belum diset!!!";
			break;
	}
}

/***********************************************************************************
 * Description: This function check and return the strings of announcement
 * Parameters: $content - contents of news
 * ********************************************************************************/
function formatNewsDisplay($content){
	$content = strip_tags($content);
	if(str_word_count($content) > 20){
		$content = explode(' ',$content);
		$content = array_splice($content,0,20);
		$content[] = "[...]";
		$content = implode(' ',$content);
	}
	return $content;
}

/***********************************************************************************
 * Description: This function is use to format the college name in announcement display
 * Parameters: $col_name - college name
 * ********************************************************************************/
function formatCollegeName($col_name){
	if($col_name == NULL){
		return 'Semua Kolej';
	}
	return $col_name;
}