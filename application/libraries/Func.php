<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/*
 * function for kv
 * Author: fakhruz, amtis solution, fakhruz@amtis.net, november 2010
 *
 *
 */

class Func
{
	
	
	function Func()
	{
		$this->obj =& get_instance();
		$this->obj->load->library('encryption');
	}
	
	//modified:nabihah 30-9-2013
	
	function generateMatricNo($col_id, $cou_id)
	{
		$colType = null;
		$colCode = null;
		$alphaYear = null;
		$sesi = null;
		$couCode = null;
		$newMatricNo = null;
		
		
		$m_general = $this->obj->m_general;
		$conf = $this->obj->config;
		$aCollage = $m_general->kv_list($col_id);
		$aCourse = $m_general->kursus_list($cou_id);
		$aSesi =getSem();
		$sesi = $aSesi["sesi"];
		$tahun = $aSesi["tahun"];
		$aYearToAlpha = $conf->item("yearToAlpha");
		$alphaYear = array_search($tahun, $aYearToAlpha);
	
		$rwCol = sizeof($aCollage)>0?$aCollage[0]:null;
		$rwCou = sizeof($aCourse)>0?$aCourse[0]:null;
		
		if($rwCol !== null)
		{
			$colType = $rwCol->col_type;
			$colCode = $rwCol->col_code;
		}
		
		if($rwCou !== null)
		{
			$couCode = $rwCou->cou_course_code;
		}
		
		$prefixMatricNoLength = $this->obj->config->item("prefixMatricNoLength");
		$MatricNoSeriesLength = $this->obj->config->item("MatricNoSeriesLength");
		$prefixMatricNo = $colType.$colCode.$sesi.$alphaYear.$couCode;
		
		$SerialNo = $m_general->getNextMatricNo($prefixMatricNo);
		
		if(!empty($SerialNo)){
			$SerialNo = intval($SerialNo);
			$SerialNo++;
			$newMatricNo = $prefixMatricNo.str_pad($SerialNo, $MatricNoSeriesLength, "0", STR_PAD_LEFT);
		}else{
			$newMatricNo = $prefixMatricNo.str_pad(1, $MatricNoSeriesLength, "0", STR_PAD_LEFT);
		}	
		
		return $newMatricNo;
	}
	
	//function get sesi and sem based on registration period
	function getSem($p_month = "", $p_year = "")
	{
		$sem_2 = array("start" => 1, "end" => 6);		//Sila Betulkan sesi bila dah live
		$sem_1 = array("start" => 7, "end" => 12);
		
		$month = empty($p_month)?date("m"):$p_month;
		$year = empty($p_year)?date("Y"):$p_year;
		//$year = "2014";
		
		if($month >= $sem_2["start"] && $month <= $sem_2["end"])
		{
			$data["tahun"] = $year;
			$data["sesi"] = 1;
			return $data;
		}
		
		elseif(($month >= $sem_1["start"] && $month <=12) || 
			   ($month >= $sem_1["end"] && $month < $sem_1["start"]))
		{
			if($month >= 7)
			$data['tahun'] = $year;
			else
			$data['tahun'] = $year;
			
			$data['sesi'] = 2;
			return $data;
		}
		
		else
		{
			return "sila pastikan bulan diantara 1 hingga 12";
		}
	}
	
	
	
/**************************************************************************************************
* Description			: func for getting the announcement details 
* Author				: Ku Ahmad Mudrikah Ku Mukhtar
* Date					: 7 July 2013
* Input Parameter		: 
* Modification Log		: 
**************************************************************************************************/
	function display_announcement()
	{
		$this->obj->load->model('m_announcement');
		$user_id = $this->obj->session->userdata('user_id');
		
		$user_login = $this->obj->ion_auth->user()->row();
		$centreCode = $user_login->col_id;
		$userId = $user_login->user_id;
		$state_id= $user_login->state_id;

		$user_groups = $this->obj->ion_auth->get_users_groups($userId)->row();  
		$ul_type= $user_groups->ul_type;
		  
		if($ul_type=="LP" || $ul_type=="BPTV"){
			$result=$this->obj->m_announcement->get_announcement_details();			
		}elseif($ul_type=="KV"){
			$result=$this->obj->m_announcement->get_announcement_by_kv($centreCode);
		}
		 
       
		$i=0;
		foreach ($result as $row) {
			$strlen=strlen(trim(strip_tags($row['ann_content'])));
			$result[$i]['ann_title'].=nbs(2);
			if($strlen>200){
				$arr=str_split($row['ann_content'],200);
				//$row['ann_content']=$arr[0]." <a href='#'>Read more...</a>";
				//$result[$i]['ann_title']=$row['ann_title'];
				$result[$i]['ann_content']=$arr[0];
            $result[$i]['ann_footer'] = "<a class='' onclick='javascript:notifyFullAnnouncement(".$row['ann_id'].")' href='#'><span class='label label-info'>&nbspBaca&nbspSeterusnya..&nbsp</span></a>";
			}
			$i++;
		}
        
		return $result;
	}

	/***********************************************************************************
	* Description			: func to add the announcement details 
	* Author				: Ku Ahmad Mudrikah Ku Mukhtar
	* Date					: 7 July 2013
	* Input Parameter		: 
	* Modification Log		: 
	**************************************************************************************************/
	function get_png_bm($angka_giliran,$semester)
	{
		$this->obj->load->model('m_result');
		return $this -> obj -> m_result -> get_png_bm($angka_giliran,$semester);
	}

	/***********************************************************************************
	* Description			: func to add the announcement details 
	* Author				: Ku Ahmad Mudrikah Ku Mukhtar
	* Date					: 7 July 2013
	* Input Parameter		: 
	* Modification Log		: 
	**************************************************************************************************/
	function get_pngk_bm($angka_giliran,$semester)
	{
		$this->obj->load->model('m_result');
		$pointer=array();
		$total_pointer=0;
		for($i=1;$i<=$semester;$i++){
			$total_pointer=$total_pointer+$this -> obj -> m_result -> get_png_bm($angka_giliran,$i);
		}
		return round($total_pointer/$semester,2);
	}
	
	/**************************************************************************************************
	* Description			: func to add the announcement details 
	* Author				: Ku Ahmad Mudrikah Ku Mukhtar
	* Date					: 7 July 2013
	* Input Parameter		: 
	* Modification Log		: 
	*******************************************************************************************************/
	function add_announcement($title,$content,$open_date,$close_date,$status,$kv_id)
	{
		$this->obj->load->model('m_announcement');
		$user_id = $this->obj->session->userdata('user_id');
		//------------/
		$data=array(
			'ann_title'=>$title,
			'ann_content'=>$content,
			'ann_open_date'=>$open_date,
			'ann_close_date'=>$close_date,
			'ann_status'=>$status,
			'user_id'=>$this->obj->session->userdata('user_id')
		);
		
		$this->obj->m_announcement->add_announcement($data);
		$ann_id=$this->obj->m_announcement->get_last_row();
		foreach ($kv_id as $key) {
			$data_ann_col=array(
				'col_id'=>$key,
				'ann_id'=>$ann_id->ann_id
			);
			$this->obj->m_announcement->add_announcement_college($data_ann_col);
		}
	}
	
	/**************************************************************************************************
	* Description			: func to display dateline warning 
	* Author				: Ku Ahmad Mudrikah Ku Mukhtar
	* Date					: 1 Oct 2013
	* Input Parameter		: 
	* Modification Log		: 
	**************************************************************************************************/
	function dateline_warning()
	{
		$this->obj->load->model('m_alert');
		$user_id=$this->obj->session->userdata('user_id');
		$ul_id=$this->obj->m_alert->get_ulid_by_userid($user_id);
		$end_date=$this->obj->m_alert->get_enddate($ul_id);
		
		$data=array();
		//$result_check=array();
		$output=array();
		foreach ($end_date as $key) {
			$result_check=$this->check_notification($key['end_date_user']);
			if($result_check==1){
				$this->obj->load->view("alert/v_alert_warning");
			}elseif($result_check==-1){
				$this->obj->load->view("alert/v_alert_passed");
			}else{
				// $data["message"]="normal"; 						//FDP 
				// $this->obj->load->view("alert/v_alert_passed",$data);	//FDP
			}
		}
	}

	function tarikh_pengesahan(){
		$this->obj->load->model('m_student_management');
		$session=$this->obj->session->all_userdata();
		$data['tahun']=$session['tahun'];
		$data['sesi']=$session['sesi'];
		$query=$this->obj->m_student_management->get_register_schedule($session['sesi'],$session['tahun']);
		$result=$query->result();
		$today=date('Y-m-d');

		if($query->num_rows()==0){
			$this->obj->load->view("alert/v_tiada_tarikh_pengesahan",$data);
		}
	}
	
	function check_notification($end_date){
		$oneday=24*60*60;
		$today=strtotime(date('Y-m-d'));
		$notification_start=($end_date-($oneday*7));
		$notification_stop=$end_date+$oneday;
		if($today>$notification_start && $today<$notification_stop){
			//display notification	
			return 1;
		}elseif($today>($end_date+$oneday) && $today<($end_date+($oneday*2))){
			//dh lepas tarikh luput
			return -1;
		}else{
			return 0;
		}
	}
	
	/**************************************************************************************************
	* Description			: libraries to store mark and set grade 
	* Author				: Fakhruz
	* Date					: 15 July 2013
	* Input Parameter		: 
	* Modification Log		: 
	**************************************************************************************************/
	function storeMarkAndSetGrade($mdId, $mark, $marksAssessType)
	{
		$this->obj->load->model('m_pelajar');
		$mPelajar = $this->obj->m_pelajar;
		
		//call function in this file getGrade
		$gradeId = $this->getGrade($mark, $marksAssessType);
		
		$dataModuleTaken = array(
							"mt_full_mark" => $mark,
							"grade_id" => $gradeId);
		
		$mPelajar->storeMarkAndSetGrade($mdId, $dataModuleTaken);
	}
	
	/**************************************************************************************************
	* Description			: libraries to get current grade
	* Author				: Fakhruz
	* Date					: 15 July 2013
	* Input Parameter		: 
	* Modification Log		: 
	**************************************************************************************************/
	function getGrade($mark, $marksAssessType,$type='grade_id'){
		$this->obj->load->model('m_pelajar');
		$mPelajar = $this->obj->m_pelajar;
		$aGred = $mPelajar->gradeList($marksAssessType);
		
		if(sizeof($aGred) > 0){
			foreach ($aGred as $rGred) {
				if($rGred->min_mark <= $mark && $rGred->max_mark >= $mark)
				{
					//return default value grade_id or user defined val when call function
					return $rGred->$type;
					break;
				}
			}
			
			return 1;
			
		}
	}
	
	function list_yearSem($sem_year='')
	{
		$year='';
		$sem='';
		
		if(!empty($sem_year))
		{
			$year = $this->calcYear($sem_year);
			$sem = $this->calcSem($sem_year);
		}
		$j=1;
		for($i=1;$i<5;$i++)
		{
			$selected1 = "";
			$selected2 = "";
			
			
			
			if(!empty($sem_year))
			{
				if("$year/$sem" == "$i/1")
				{
					$selected1=" selected ";
				}
				
				if("$year/$sem" == "$i/2")
				{
					$selected2=" selected ";
				}
			}	
			if($sem%2!=0)
			{
				echo "<option value='$j' $selected1>$i/1</option>";
				$j++;
			}
			else
			{
				$j++;
				echo "<option value='$j' $selected2>$i/2</option>";
				
			}
			$j++;
		}
	}
	
	function timeNow() {
	   return date("h:i:s",time());
	}
	
	
	function dayNowYmd() {
	   return date("Y-m-d",time());
	}
	
	function dayNowdmY() {
     return date("d/m/Y",time());
  }
	
	//date to mysql date
	function datetomd($date)
	{
		$datef = array();
		$datef = explode('/',$date);
		
		if(sizeof($date)==0)
			return date("Y-m-d",strtotime($date));
		else
		{
			return $datef[2].'-'.$datef[1].'-'.$datef[0];
		}
	}
	
	//mysql date to date
	function mdtodate($date)
	{	
		return date("d/m/Y",strtotime($date));
	}
	
	function calcYear($sem)
	{
		return ceil($sem/2);
	}
	
	function calcSem($sem)
	{
		if($sem%2==0)
			$semester = 2;
		else
			$semester = 1;
			
		return $semester;
	}
	
	//function convert to capital letter
	function strcap($str)
	{
		$str_small = strtolower($str);
		$str_cptl = ucwords($str_small);
		
		return $str_cptl;
	}

	function get_year($sem)
	{
		$year=ceil($sem/2);
		
		return $year;
		
	}
	
	function get_sem($sem)
	{
		if($sem%2==0)
			$sem=2;
		else
			$sem=1;
		
		return $sem;
				
	}
	
	function get_semList($sem)
	{
		$output='';
		
		$year=$this->calcYear($sem);
		$semester=$this->calcSem($sem);
		
		$k=1;
		for($i=1;$i<5;$i++)
		{
			for($j=1;$j<=2;$j++)
			{
			 $output.="<option value='".($k++)."' ".((($k-1)==$sem)?"selected='selected' ":"").">$i/$j</option>";		
			 
			}
		}		
		
		return $output;
	}
	
	/*Send email function
	att: array $data*/
	function sendMail($data)
	{
		$CI =$this->obj;
		$CI->load->library('email');
		
		if($CI->config->item('smtp_on')){
		  $config['smtp_host'] = $CI->config->item('smtp_host');
		  $config['smtp_user'] = $CI->config->item('smtp_user');
		  $config['smtp_pass'] = $CI->config->item('smtp_pass');
		  $config['smtp_port'] = $CI->config->item('smtp_port');
		  $config['protocol'] = $CI->config->item('protocol');
		  $config['starttls'] = FALSE;
  		  $config['mailtype'] = "html";
		  $CI->email->initialize($config);
		}
		
		
		//print_r($config);
		
		foreach($data as $r)
		{
			$CI->email->clear();
			$CI->email->set_newline("\r\n");
			$CI->email->from($r["from"],$r["from_name"]);
			$CI->email->to($r["to"]);
			$CI->email->subject($r["subject"]);
			$CI->email->message($r["message"]);
	
		if($CI->email->send()){
            return true;
        }
        else{
			//echo 'email=>'.$r["from"];
            show_error($CI->email->print_debugger() );
			return false;

        } 
		}
	}
	
	function get_level_detail($id,$type="id")
	{
			switch($id)
			{
				case (($type!="desc")?1:"pending"):
					return "menunggu";
				break;
				case (($type!="desc")?2:"nurse_pending"):
					return "menunggu kejururawatan";
				break;
				case (($type!="desc")?3:"nurse_interview"):
					return "temuduga kejururawatan";
				break;
				case (($type!="desc")?4:"offer"):
					return "ditawarkan";
				break;
				case (($type!="desc")?5:"reject"):
					return "ditolak";
				break;
				case (($type!="desc")?6:"active"):
					return "aktif";
				break;
				case (($type!="desc")?7:"postpone"):
					return "ditunda";
				break;
				case (($type!="desc")?8:"finish"):
					return "tamat";
				break;
				case (($type!="desc")?9:"terminate"):
					return "ditamatkan";
				break;
				case (($type!="desc")?10:"graduate"):
					return "graduan";
				break;				
			}	
	}
	
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
	 * Description		: function get college for user
	 * input				: -
	 * author			: sukor
	 * Date				: 15 july 2013
	 * Modification Log	: 
 **************************************************************************************************/
		
	function get_user_collegehelp($userId){
		
			$CI =$this->obj;
            $CI->load->model('m_userinfo');
           
		$userdata = $CI->m_userinfo->get_user_collegehelp($userId);
		
		if ($userdata) {
			return $userdata;
		}
	
     }
	
	/**************************************************************************************************
	* Description			: libraries to get notification
	* Author				: Ku Ahmad Mudrikah
	* Date					: 29 July 2013
	* Input Parameter		: 
	* Modification Log		: 
	**************************************************************************************************/
	function pindah_noti(){
		$this->obj->load->model('m_general');
		$this->obj->load->model('m_student_management');
		
		$num_row=0;
		$user_login = $this->obj->ion_auth->user()->row();
		$colid = $user_login->col_id;
		$students=$this->obj->m_general->get_stu_by_status(4);
		
		foreach ($students->result_array() as $key => $value) {
			$stu_colid=$this->obj->m_student_management->get_college_by_cc_id_arr($value['temp_cc_id']);
			// echo $stu_colid[0]['col_id']." == ".$colid;
			if($stu_colid[0]['col_id']==$colid){
				$num_row++;
			}
		}
		return $num_row;
	}
	
	
	/**************************************************************************************************
	* Description			: libraries to store mark and set grade repeat
	* Author				: sukor
	* Date					: 1 August 2013
	* Input Parameter		: 
	* Modification Log		: 
	**************************************************************************************************/
	function storeMarkAndSetGradeRepeat($mdId, $mark, $marksAssessType)
	{
		$this->obj->load->model('m_combinerepeat');
		$mPelajar = $this->obj->m_combinerepeat;
		
		//call function in this file getGrade
		$gradeId = $this->getGradeRepeat($mark, $marksAssessType);
		
		$dataModuleTaken = array(
							"mt_full_mark" => $mark,
							"grade_id" => $gradeId);
		
		$mPelajar->storeMarkAndSetGradeRepeat($mdId, $dataModuleTaken);
	}
	
	/**************************************************************************************************
	* Description			: libraries to get current grade
	* Author				: sukor
	* Date					: 1 August 2013
	* Input Parameter		: 
	* Modification Log		: 
	**************************************************************************************************/
	function getGradeRepeat($mark, $marksAssessType,$type='grade_id'){
		$this->obj->load->model('m_combinerepeat');
		$mPelajar = $this->obj->m_combinerepeat;
		$aGred = $mPelajar->gradeListrRepeat($marksAssessType);
		if(sizeof($aGred) > 0){
			foreach ($aGred as $rGred) {
				if($rGred->min_mark <= $mark && $rGred->max_mark >= $mark)
				{
					//return default value grade_id or user defined val when call function
					return $rGred->$type;
					break;
				}
			}
			
			return 1;
			
		}
	}
	
	function encodeViaUrl($str){
		$str = trim($str);
		$str = urlencode($this->obj->encryption->encode($str));
		return $str;	
	}
	
	function decodeViaUrl($str){
		$str = urldecode($str);
		$str = $this->obj->encryption->decode($str);
		return $str;
	}

	/**************************************************************************************************
	* Description			: func to change date from mysql to fomal format and vice versa
	* Author				: Ku Ahmad Mudrikah Ku Mukhtar
	* Date					: 14 November 2013
	* Input Parameter		: 
	* Modification Log		: 
	**************************************************************************************************/
	function date_format_toggle($date){
		$arr=explode('-',$date);
		return $new_date=$arr[2].'-'.$arr[1].'-'.$arr[0];
	}
	
	
	/**************************************************************************************************
* Description			: func for UPDATE semester and year based on current session
* Author				: Nabihah Ab.Karim
* Date					: 25 November 2013
* Input Parameter		: 
* Modification Log		: 
**************************************************************************************************/

function get_semester()
{
	//	$cur_year = date('Y');
		$cur_year = $this->obj->session->userdata('tahun');
		$cur_sesi = $this->obj->session->userdata('sesi');
		$this->obj->load->model('m_semester');
		
		
		//pembukaan untuk naik semester
		$month_sem = array("first" => 1, "second" =>7);	
		$day_sem = array("start" => 1, "end" =>3);	
		$month = date("m");
		$day = date("j");
		
		if($month == $month_sem['first'] || $month == $month_sem['second'])
		{
			if($day >= $day_sem['start'] && $day <= $day_sem['end'])
			{
			
				$session = $this->obj->m_semester->get_session($cur_sesi, $cur_year);
			}
		}
		
		
		//print_r($session);
		//echo "<br/>";
		//echo "current sesi:".$cur_sesi;
		//echo "<br/>current year:".$cur_year."<br/>";
		//die();
		//echo $session->stu_intake_session;
		//die();
		if(isset($session))
		{
			if(!empty($session))
			{
			foreach($session as $row)
			{
			
				$sem_count = 1;
				list($sesi, $year) = explode(' ', $row->stu_intake_session);
				$total_sem_by_year = intval($cur_year) - intval($year);
			
				
				$total_sem_by_sesi = intval($cur_sesi) - intval($sesi);
				
			
				for($i=0;$i< $total_sem_by_year;$i++)
				{
					
					$sem_count = $sem_count+2;
				}	
			
			
				for($i=0;$i< $total_sem_by_sesi;$i++)
				{
					
					$sem_count = $sem_count+1;
				}	
				
				if($sem_count <= 8 )
				{
					$array= Array('sem'=> $sem_count, 'year'=>$cur_year, 'stu_intake_session'=>$row->stu_intake_session);
					$dData[] = (object) $array;
				}
			}
			
			return $dData;
		}
		}
		
		
		
		
		
		
}



/**************************************************************************************************
* Description			: func for UPDATE semester and year based on current session
* Author				: Nabihah Ab.Karim
* Date					: 27 November 2013
* Input Parameter		: 
* Modification Log		: 
**************************************************************************************************/

function update_semester($semester)
{
		$this->obj->load->model('m_semester');
		
		
		$upStu = 0;
		$noUpStu = 0;
		
		foreach($semester as $row)
		{
			$data = array('stu_current_sem' => $row->sem,
						  'stu_current_year' => $row->year,
						  'stu_group' => 0 );
			
			$stu_id_by_session = $this->obj->m_semester->get_student_id($row->stu_intake_session);
			//echo "<pre>";
			//print_r($stu_id_by_session);
			//echo "</pre>";
			
			foreach($stu_id_by_session as $stu)
			{
				
				$module_st = $this->obj->m_semester->get_module($stu->cc_id, $row->sem);
				
				//echo "++++++++++++++++++++++++++++++++++++++++++++++++<br/>";
				//echo  "cc_id:".$stu->cc_id."<br/>sem:".$row->sem;
			//	echo "<pre>";
				//print_r($module_st);
				//echo "</pre>";
				//echo "<br/>";
				if($module_st)
				{
					
						$affectedRow= $this->obj->m_semester->update_sem_by_stu($data, $stu->stu_id);
						//echo "affectedrow".$affectedRow;
					if($affectedRow == 1)
					{
							//bila effect row student, akan insert data 1 dalam table status_semester		
							$this->obj->m_semester->insert_status_sem($stu->stu_id,$row->sem, 1); 
							$upStu++;
					foreach($module_st as $mod)
					{
						if ($stu->stu_religion == "ISLAM" || $stu->stu_religion == "islam" || $stu->stu_religion == "Islam") 
						{
							if($mod->mod_code != 'A07')
							{
								$data_module_taken = array('mt_semester' => $row->sem, 
												 		'mt_year' => $row->year, 
												 		'mt_full_mark' => '', 
												 		'mt_status' => '1', 
												 		'stu_id' => $stu->stu_id, 
												 		'mod_id' => $mod->mod_id, 
												 		'grade_id' => null, 
												 		'exam_status' => '1');
													
								$this->obj->m_semester->insert_module($data_module_taken);
							}
						}
						else
						{
							if($mod->mod_code != 'A06')
							{
								$data_module_taken = array('mt_semester' => $row->sem, 
												 		'mt_year' => $row->year, 
												 		'mt_full_mark' => '', 
												 		'mt_status' => '1', 
												 		'stu_id' => $stu->stu_id, 
												 		'mod_id' => $mod->mod_id, 
												 		'grade_id' => null, 
												 		'exam_status' => '1');
													
								$this->obj->m_semester->insert_module($data_module_taken);
							}
							
							
						}
					
				} //end foreach
			} //end if
			
				
				
				
			}
// jika module tiada, pelajar tidak akan naik semester
else
	{
		if($row->sem != $stu->stu_current_sem)// digunakan apabila insert data jika sem pelajar tidak sama dgn current sem
		{
			$noUpStu++;
					
			$this->obj->m_semester->insert_status_sem($stu->stu_id,$row->sem, 0);
		}
	}
			
			
		}
		
}

		
		$message = "Bilangan pelajar yang berjaya dinaikkan semester: ".$upStu."<br/>Bilangan pelajar yang tidak berjaya dinaikkan semester: ".$noUpStu;	
		$this->obj->session->set_flashdata("alertContent", $message);
}

}
?>
