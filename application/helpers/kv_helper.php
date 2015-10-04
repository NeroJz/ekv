<?php 
/**************************************************************************************************
* File Name        : kv_helper.php
* Description      : This File contain function collection.
* Author           : Fakhruz
* Date             : 27 June 2013
* Version          : 0.1
* Modification Log : 
* Function List	   : getSem(), get_sem_study(), convert_number(), floatToFraction(), 
* 		     		 get_status_yurane(), get_block_student(), curl_post_data()
**************************************************************************************************/

if ( ! defined('BASEPATH')) exit('No direct script access allowed');



//function get sesi and sem based on registration period
function getSem($p_month = "", $p_year = "")
{
	$CI =& get_instance();	
 	return $CI->func->getSem($p_month, $p_year);         
}

//function get sesi and sem based on registration period
function get_png_bm($angka_giliran = "", $semester = "")
{
	$CI =& get_instance();	
 	return $CI->func->get_png_bm($angka_giliran, $semester);
}
//function get sesi and sem based on registration period
function get_pngk_bm($angka_giliran = "", $semester = "")
{
	$CI =& get_instance();	
 	return $CI->func->get_pngk_bm($angka_giliran, $semester);
}

//function get sesi and sem based on study period
function get_sem_study($p_month = "", $p_year = "")
{
	$sem_1 = array("start" => 6, "end" => 11);
	$sem_2 = array("start" => 12, "end" => 5);
	
	$month = empty($p_month)?date("m"):$p_month;
	$year = empty($p_year)?date("Y"):$p_year;
	
	if($month >= $sem_1["start"] && $month <= $sem_1["end"])
	{
		$data["sesi"] = $year."/".($year+1);
		$data["sem"] = 1;
		return $data;
	}
	elseif(($month >= $sem_2["end"] && $month <=12) || 
		   ($month <= $sem_2["end"]))
	{
		if($month >= 12)
		$data['sesi'] = $year."/".($year+1);
		else
		$data['sesi'] = ($year-1)."/".$year;
		
		$data['sem'] = 2;
		return $data;
	}
	else
	{
		return "sila pastikan bulan diantara 1 hingga 12";
	}
}

	function generateMatricNo($col_id, $cou_id)
	{
		$CI =& get_instance();
		return $CI->func->generateMatricNo($col_id, $cou_id);
	}

function convert_number($number) 
{ 
    if (($number < 0) || ($number > 999999999)) 
    { 
    throw new Exception("Nombor diluar dari julat");
    } 

    $Gn = floor($number / 1000000);  /* Millions (giga) */ 
    $number -= $Gn * 1000000; 
    $kn = floor($number / 1000);     /* Thousands (kilo) */ 
    $number -= $kn * 1000; 
    $Hn = floor($number / 100);      /* Hundreds (hecto) */ 
    $number -= $Hn * 100; 
    $Dn = floor($number / 10);       /* Tens (deca) */ 
    $n = $number % 10;               /* Ones */ 

    $res = ""; 

    if ($Gn) 
    { 
        $res .= convert_number($Gn) . " Juta"; 
    } 

    if ($kn) 
    { 
        $res .= (empty($res) ? "" : " ") .convert_number($kn) . " Ribu"; 
    } 

    if ($Hn) 
    { 
        $res .= (empty($res) ? "" : " ") .convert_number($Hn) . " Ratus"; 
    } 

    $ones = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", 
        "Tujuh", "Lapan", "Sembilan", "Sepuluh", "Sebelas", "Dua Belas", "Tiga Belas", 
        "Empat Belas", "Lima Belas", "Enam  Belas", "Tujuh Belas", "Lapan Belas", 
        "Sembilan Belas"); 
    $tens = array("", "", "Dua Puluh", "Tiga Puluh", "Empat Puluh", "Lima Puluh", "Enam Puluh", "Tujuh Puluh", "Lapan Puluh", "Sembilan Puluh"); 

    if ($Dn || $n) 
    { 
        if (!empty($res)) 
        { 
            $res .= " ";
			//$res .= " dan ";
        } 

        if ($Dn < 2) 
        { 
            $res .= $ones[$Dn * 10 + $n]; 
        } 
        else 
        { 
            $res .= $tens[$Dn]; 

            if ($n) 
            { 
                $res .= " " . $ones[$n]; 
				//$res .= "-" . $ones[$n]; 
            } 
        } 
    } 

    if (empty($res)) 
    { 
        $res = "kosong"; 
    } 

    return $res; 
}

	function floatToFraction($float, $leastCommonDenom = 12)
	{
		
    $whole = floor ( $float );
    $decimal = $float - $whole;

	
	for($i=2; $i <= floor($leastCommonDenom/2); $i++)
	{
		if($leastCommonDenom%$i==0)
			 $denominators[]= $i;
	}
	
	$denominators[] = $leastCommonDenom;
	
	//print_r($denominators);
    //$denominators = array (2, 3, 4, 6, 12 );
    $roundedDecimal = round ( $decimal * $leastCommonDenom ) / $leastCommonDenom;
    if ($roundedDecimal == 0)
        return $whole;
    if ($roundedDecimal == 1)
        return $whole + 1;
    foreach ( $denominators as $d ) {
        if ($roundedDecimal * $d == floor ( $roundedDecimal * $d )) {
            $denom = $d;
            break;
        }
    }

    return ($whole == 0 ? "" : $whole) . " " . ($roundedDecimal * $denom) . "/" . $denom;	
	}

	
	

 function get_status_yurane($matric_no,$sem){
$CI =& get_instance();	
 return $CI->func->get_status_yurane($matric_no,$sem);              
                }


 function get_block_student($level_id){
$CI =& get_instance();	
 return $CI->func->get_block_student($level_id);              
                }

	
	
	function curl_post_data($post_data, $url,$fee_sesi,$no_in,$type)
	{
		$CI =& get_instance();	
     return $CI->func->curl_post_data($post_data, $url,$fee_sesi,$no_in,$type);   
	}
	

	
/**************************************************************************************************
* Description			: change input string to uppercase 
* Author				: Amir khursaini
* Date					: 1 March 2013
* Input Parameter		: $string - student name
* Modification Log		: 19 March 2013 - Norafiq - string to lower dulu baru boleh upper
**************************************************************************************************/
	function name_strtoupper($string) 
	{
		$string = strtolower($string);		   
		$name = strtoupper($string);        
		return $name;
    }	
	
	
/**************************************************************************************************
* Description			: helper for reg subject asasi auto 
* Author				: sukor
* Date					: 22 April 2013
* Input Parameter		: object 
* Modification Log		: 
**************************************************************************************************/	
	function reg_asasi_subject($level_id){
		$CI =& get_instance();	
		return $CI->func->reg_asasi_subject($level_id);
	}
	
/**************************************************************************************************
* Description			: helper for getting the announcement details 
* Author				: Ku Ahmad Mudrikah Ku Mukhtar
* Date					: 7 July 2013
* Input Parameter		: 
* Modification Log		: 
**************************************************************************************************/
	function display_announcement() 
	{
		$CI =& get_instance();	
		return $CI->func->display_announcement();
    }	
	
/**************************************************************************************************
* Description			: helper to add the announcement details 
* Author				: Ku Ahmad Mudrikah Ku Mukhtar
* Date					: 7 July 2013
* Input Parameter		: 
* Modification Log		: 
**************************************************************************************************/
	function add_announcement($title,$content,$open_date,$close_date,$status,$kv_id) 
	{
		$CI =& get_instance();	
		return $CI->func->add_announcement($title,$content,$open_date,$close_date,$status,$kv_id);
    }
	
	/**************************************************************************************************
	* Description			: helper to store mark and set grade ( trigger function from libraries func)
	* Author				: Fakhruz
	* Date					: 15 July 2013
	* Input Parameter		: 
	* Modification Log		: 
	**************************************************************************************************/
	function storeMarkAndSetGrade($mdId, $mark, $marksAssessType)
	{
		$CI =& get_instance();	
		return $CI->func->storeMarkAndSetGrade($mdId, $mark, $marksAssessType);
	}
	
	/**************************************************************************************************
	* Description			: helper to get current grade ( trigger function from libraries func)
	* Author				: Fakhruz
	* Date					: 15 July 2013
	* Input Parameter		: 
	* Modification Log		: 
	**************************************************************************************************/
	function getGrade($mark, $marksAssessType, $type)
	{
		$CI =& get_instance();	
		return $CI->func->getGrade($mark, $marksAssessType, $type);
	}
	
	/**************************************************************************************************
	* Description			: helper to get trasfer student num row
	* Author				: Ku Ahmad Mudrikah
	* Date					: 29 July 2013
	* Input Parameter		: 
	* Modification Log		: 
	**************************************************************************************************/
	function pindah_noti()
	{
		$CI =& get_instance();	
		return $CI->func->pindah_noti();
	}
	
	/**************************************************************************************************
	* Description			: to display alert
	* Author				: Ku Ahmad Mudrikah
	* Date					: 1 Oct 2013
	* Input Parameter		: 
	* Modification Log		: 
	**************************************************************************************************/
	function display_dateline_warning()
	{
		$CI =& get_instance();	
		return $CI->func->dateline_warning();
	}


	/**************************************************************************************************
	* Description			: to display alert on tarikh pengesahan
	* Author				: Ku Ahmad Mudrikah
	* Date					: 13 Nov 2013
	* Input Parameter		: 
	* Modification Log		: 
	**************************************************************************************************/
	function display_tarikh_pengesahan()
	{
		$CI =& get_instance();	
		return $CI->func->tarikh_pengesahan();
	}
	
	
	//function convert to capital letter
	function strcap($str)
	{
		$str_small = strtolower($str);
		$str_cptl = ucwords($str_small);
		
		return $str_cptl;
	}
	
	
	/**************************************************************************************************
	 * Description		: function get college for user
	 * input				: -
	 * author			: sukor
	 * Date				: 15 july 2013
	 * Modification Log	: 
 **************************************************************************************************/
	
	function get_user_collegehelp($userId){
		$CI =& get_instance();	
		return $CI->func->get_user_collegehelp($userId);
	}
	
/**************************************************************************************************
	* Description			: helper to store mark and set grade ( trigger function from libraries func)
	* Author				: sukor
	* Date					: 1 August 2013
	* Input Parameter		: 
	* Modification Log		: 
	**************************************************************************************************/
	function storeMarkAndSetGradeRepeat($mdId, $mark, $marksAssessType)
	{
		$CI =& get_instance();	
		return $CI->func->storeMarkAndSetGradeRepeat($mdId, $mark, $marksAssessType);
	}	
	
	
	/**************************************************************************************************
	* Description			: helper to get current grade ( trigger function from libraries func)
	* Author				: sukor
	* Date					: 1 August 2013
	* Input Parameter		: 
	* Modification Log		: 
	**************************************************************************************************/
	function getGradeRepeat($mark, $marksAssessType, $type)
	{
		$CI =& get_instance();	
		return $CI->func->getGradeRepeat($mark, $marksAssessType, $type);
	}

	/**************************************************************************************************
	 * Description			: helper to encode using CI encode and urlencode ( trigger function from libraries func)
	* Author				: Fakhruz
	* Date					: 25 Oct 2013
	* Input Parameter		:
	* Modification Log		:
	**************************************************************************************************/
	function encodeViaUrl($str){
		$CI =& get_instance();
		return $CI->func->encodeViaUrl($str);
	}

	/**************************************************************************************************
	 * Description			: helper to encode using CI decode and urldecode ( trigger function from libraries func)
	* Author				: Fakhruz
	* Date					: 25 Oct 2013
	* Input Parameter		:
	* Modification Log		:
	**************************************************************************************************/
	function decodeViaUrl($str){
		$CI =& get_instance();
		return $CI->func->decodeViaUrl($str);
	}

	/**************************************************************************************************
	* Description			: func to change date from mysql to fomal format and vice versa
	* Author				: Ku Ahmad Mudrikah Ku Mukhtar
	* Date					: 14 November 2013
	* Input Parameter		: 
	* Modification Log		: 
	**************************************************************************************************/
	function date_format_toggle($date){
		$CI =& get_instance();
		return $CI->func->date_format_toggle($date);
	}
	
	
	/**************************************************************************************************
	* Description			: func to get semester
	* Author				: Nabihah
	* Date					: 26 November 2013
	* Input Parameter		: 
	* Modification Log		: 
	**************************************************************************************************/
	function get_semester()
	{
		$CI =& get_instance();
		return $CI->func->get_semester();
	}
	
	/**************************************************************************************************
	* Description			: func to update semester
	* Author				: Nabihah
	* Date					: 27 November 2013
	* Input Parameter		: 
	* Modification Log		: 
	**************************************************************************************************/
	function update_semester($semester)
	{
		$CI =& get_instance();
		return $CI->func->update_semester($semester);
	}

	function get_menu(&$menu,$ul_id,$parent_id=null){
		$CI =& get_instance();
		$CI->db->select('*');
		$CI->db->from('menu_ul');
		$CI->db->join('menu','menu_ul.menu_id = menu.menu_id');
		$CI->db->where('menu.parent_id',$parent_id);
		if($ul_id>-1){
			$CI->db->where('menu_ul.ul_id',$ul_id);
		}
		$CI->db->group_by('menu.menu_item');
		$CI->db->order_by('menu.menu_order','asc');
		$data = $CI->db->get();

		if($data->num_rows()>0){
			foreach ($data->result() as $row) {
				//print_r($row);
				$menu[$row->menu_id]=$row;
				$menu[$row->menu_id]->children=array();
				get_menu($menu[$row->menu_id]->children,$ul_id,$row->menu_id);
			}
		}
	}

	/**************************************************************************************************
	* Description			: func untuk tukar hari dalam english kepada b.melayu
	* Author				: Fakhruz
	* Date					: 26 December 2013
	* Input Parameter		: 
	* Modification Log		: 
	**************************************************************************************************/
	function getDayInMalay($day){
        if($day == 'Sunday')
            $day = 'Ahad';
        else if($day == 'Monday')
            $day = 'Isnin';
        else if($day == 'Tuesday')
            $day = 'Selasa';
        else if($day == 'Wednesday')
            $day = 'Rabu';
        else if($day == 'Thursday')
            $day = 'Khamis';
        else if($day == 'Friday')
            $day = 'Jumaat';
        else if($day == 'Saturday')
            $day = 'Sabtu';
        
        return $day;
    }

    /**************************************************************************************************
	* Description			: func untuk tukar dalam english kepada bahasa melayu
	* Author				: Fakhruz
	* Date					: 26 December 2013
	* Input Parameter		: 
	* Modification Log		: 
	**************************************************************************************************/
	//return $this->func->getMonthInMalay(2);
	function getMonthInMalay($month)
	{
		switch($month){
            case 1:
                $month = 'Januari';
                break;
            case 2:
                $month = 'Februari';
                break;
            case 3:
                $month = 'Mac';
                break;
            case 4:
                $month = 'April';
                break;
            case 5:
                $month = 'Mei';
                break;
            case 6:
                $month = 'Jun';
                break;
            case 7:
                $month = 'Julai';
                break;
            case 8:
                $month = 'Ogos';
                break;
            case 9:
                $month = 'September';
                break;
            case 10:
                $month = 'Oktober';
                break;
            case 11:
                $month = 'November';
                break;
            case 12:
                $month = 'Disember';
                break;       
        }
		
		return $month;
	}
    
    /**************************************************************************************************
 * Description          : email
* Author                : sukor
* Date                  : 5 januari 2014
* Input Parameter       :
* Modification Log      :
**************************************************************************************************/
function sendMail($str){
    $CI =& get_instance();
    return $CI->func->sendMail($str);
}

function changeHeader($color="0",$filter = "hue-rotate"){
	$script = "";
	$sFilter = "";
	$sFilter1 = "";
	
	switch($filter){
		case "hue-rotate" :
			$sFilter = $filter."(".$color."deg)";
			$sFilter1 = $filter."(-".$color."deg)";
		break;
		case "saturate" :
			$sFilter = $filter."(".$color.")";
			$sFilter1 = $filter."(-$color)";
		case "brightness" :
			$sFilter = $filter."(".$color.")";
			$sFilter1 = $filter."(-$color)";
		break;
		case "grayscale" :
		case "contrast" :
		case "invert" :
		case "sepia" :
		case "opacity" :
			$sFilter = $filter."(".$color."%)";
			$sFilter1 = $filter."(-".$color."%)";
		break;
		case "blur" :
			$sFilter = $filter."(".$color."px)";
			$sFilter1 = $filter."(-".$color."px)";
		break;
	}

	$script .="<style>
	.top-bg{
		-webkit-filter: $sFilter;
	}

	.logorespond{
		z-index:1000;
		-webkit-filter: $sFilter1 !important;
	}
	</style>";

	return $script;
}
    
	
	
	
/**************************************************************************************************
* End of kv_helper.php
**************************************************************************************************/	