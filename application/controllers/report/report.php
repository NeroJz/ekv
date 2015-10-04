<?php
/**************************************************************************************************
 * File Name        : report.php
 * Description      : This File contain Report module.
 * Author           : sukor
 * Date             : 15 july 2013
 * Version          : -
 * Modification Log : -
 * Function List	   : __construct(),
 **************************************************************************************************/
class Report extends MY_Controller {

	function __construct() {
		parent::__construct();

		$this -> load -> model('m_result');
		$this -> load -> model('m_report');
	}

	
/**********************************************************************************************
 * Description		: this function to report fin
 * input			: 
 * author			: sukor
 * Date				: 15 july 2013
 * Modification Log	: -
**********************************************************************************************/

	function view_fin() {
         $user_login = $this->ion_auth->user()->row();
        $centreCode = $user_login->col_id;
        $userId = $user_login->user_id;
        $state_id= $user_login->state_id;
    
          $user_groups = $this->ion_auth->get_users_groups($userId)->row();  
          $ul_type= $user_groups->ul_type;
          
        if($ul_type=="KV"){
            $col=get_user_collegehelp($userId);
            $data['colname']=$col[0]->col_name.'-'.$col[0]->col_type.''.$col[0]->col_code;
        }
            if($ul_type=="JPN"){
            $data['centrecode'] = $this -> m_result -> get_institusi($state_id);
        }else{
            $data['centrecode'] = $this -> m_result -> get_institusi();
        }
		
		
		$data['year'] = $this -> m_result -> list_year_mt();
		//$data['courses'] = $this -> m_result -> list_course();
		//$data['state'] = $this -> m_report -> list_state();

		$centreCode = $this -> input -> post('kodpusat');
		//$year = $this -> input -> post('mt_year');
		$year = date("Y");
		$course = $this -> input -> post('slct_kursus');
		$semester = $this -> input -> post('semester');
        $status = $this -> input -> post('status');
        		
		 $cC=explode("-", $centreCode); 
		 
		 
		$data['search'] = $cC[0]."|".$course."|".$semester."|".$year."|".$status;

		$data['output'] = $this -> load -> view('report/v_reportfin', $data, true);
		$this -> load -> view('main', $data);
	}

/**********************************************************************************************
 * Description		: this function to export FIN into excel file
* input			:
* author			: Norafiq Daniel
* Date				: 9 October 2013
* Modification Log	: -
**********************************************************************************************/
	function export_xls_fin()
	{
		//get submit parameters
		$col_name = $this->input->get_post("ckod");
		$cou_id = $this->input->get_post("kursus");
		$current_sem = $this->input->get_post("semtr");
		$current_year = $this->input->get_post("tahun");
		$status_stu =  $this->input->get_post("stts");
		
		//get values
		$list_fin = $this->m_report->get_fin_detail($col_name, $cou_id, $current_sem, $current_year, $status_stu);
		
		//for debug purpose only, safe to delete
		/*echo"<pre>";
		print_r($list_fin);
		echo"</pre>";
		die();*/
		
		//load our new PHPExcel library
		$this->load->library('excel');
			
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
			
		if("" == $col_name && "" == $cou_id)
		{
			//name the worksheet
			$this->excel->getActiveSheet()->setTitle("Semua KV dan Kursus");
			
			$filename='FIN_Semua_Semester_'.$list_fin[0]->stu_current_sem.'.xlsx'; //save our workbook as this file name
		}
		else if("" == $col_name && "" != $cou_id)
		{
			//name the worksheet
			$this->excel->getActiveSheet()->setTitle("Semua KV");
			$filename='FIN_Kolej_Semester_'.$list_fin[0]->stu_current_sem.'.xlsx'; //save our workbook as this file name
		}
		else if("" != $col_name && "" == $cou_id)
		{
			//name the worksheet
			$this->excel->getActiveSheet()->setTitle("Semua Kursus");
			$filename='FIN_Kursus_Semester_'.$list_fin[0]->stu_current_sem.'.xlsx'; //save our workbook as this file name
		}
		else
		{
			//name the worksheet
			$this->excel->getActiveSheet()->setTitle($list_fin[0]->col_name.' - '.$list_fin[0]->cou_name);
			$filename='FIN_Semester_'.$list_fin[0]->stu_current_sem.'.xlsx'; //save our workbook as this file name
		}
		
		$namakolej = "";
		$namakursus = "";
		
		if($current_sem >= 4)
		{
			//set the informations
			$namakolej = $list_fin[0]->col_name;
			
			if("" != $col_name && "" != $cou_id)
			{			
				$namakursus = $list_fin[0]->cou_name;
				$this->excel->getActiveSheet()->setCellValue('B3', "KURSUS ".strtoupper($namakursus));
			}
			else
			{
				$this->excel->getActiveSheet()->setCellValue('B3', "SEMUA KURSUS");
			}
			
			$this->excel->getActiveSheet()->setCellValue('B2', "FAIL INDUK NAMA $namakolej");
			$this->excel->getActiveSheet()->setCellValue('B4', "SEMESTER $current_sem TAHUN $current_year");
			
			$this->excel->getActiveSheet()->mergeCells('B2:I2');
			$this->excel->getActiveSheet()->mergeCells('B3:I3');
			$this->excel->getActiveSheet()->mergeCells('B4:I4');
		}
		else
		{
			//set the informations
			$namakolej = $list_fin[0]->col_name;
			
			if("" != $col_name && "" != $cou_id)
			{			
				$namakursus = $list_fin[0]->cou_name;
				$this->excel->getActiveSheet()->setCellValue('B3', "KURSUS ".strtoupper($namakursus));
			}
			else
			{
				$this->excel->getActiveSheet()->setCellValue('B3', "SEMUA KURSUS");
			}
			
			$this->excel->getActiveSheet()->setCellValue('B2', "FAIL INDUK NAMA $namakolej");
			$this->excel->getActiveSheet()->setCellValue('B4', "SEMESTER $current_sem TAHUN $current_year");
			
			$this->excel->getActiveSheet()->mergeCells('B2:F2');
			$this->excel->getActiveSheet()->mergeCells('B3:F3');
			$this->excel->getActiveSheet()->mergeCells('B4:F4');

			if(file_exists("./uploaded/kvinfo/Logokolej_small.jpg"))
			{
				$gdImage = imagecreatefromjpeg('./uploaded/kvinfo/Logokolej_small.jpg');

				$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
				$objDrawing->setImageResource($gdImage);
				//$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG); 	// image rendering.
				//$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);			// nanti image jadi low quality
				$objDrawing->setOffsetX(60);
				$objDrawing->setOffsetY(-5);
				$objDrawing->setCoordinates('G2');
				$objDrawing->setWorksheet($this->excel->getActiveSheet());
			}

			if(file_exists("./uploaded/kvinfo/Copkolej_medium.png"))
			{
				$copImage = imagecreatefrompng('./uploaded/kvinfo/Copkolej_medium.png');

				$transparent = imagecolorallocate($copImage, 0, 0, 0); // set color transperent utk image

				// Make the background transparent
				imagecolortransparent($copImage, $transparent); // kalau xde ni, background jadi hitam..

				$copDrawing = new PHPExcel_Worksheet_MemoryDrawing();
				$copDrawing->setImageResource($copImage);
				$copDrawing->setOffsetX(60);
				$copDrawing->setOffsetY(-5);
				$copDrawing->setCoordinates('H18');
				$copDrawing->setWorksheet($this->excel->getActiveSheet());
			}

			$this->excel->getActiveSheet()->mergeCellsByColumnAndRow($pColumn1 = 6, $pRow1 = 2, $pColumn2 = 8, $pRow2 = 4);
		}
		
		//style for the above information
		$styleArray = array(
				'font' => array('bold' => true),
				'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
		);
		
		$this->excel->getActiveSheet()->getStyle('B1:B5')->applyFromArray($styleArray); //apply the style to the cells

		$highlightCells = array();
		
		//header
		$excel_header = array('Bil','Nama Calon','MyKad','Angka Giliran','Kod Kursus','Jantina','Kaum','Agama');		
		
		$ttl = 0;
		$columnCount = 65;
		
		//data
		$index = 1;
		$excel_data = array();
		foreach($list_fin as $rowData)
		{
			$r = array();
			array_push($r, $index);
			 
			foreach($rowData as $key => $value)  //loop each column and push inside array
			{	
				if("stu_name" == $key || "stu_mykad" == $key || "stu_matric_no" == $key || "cou_course_code" == $key || "stu_gender" == $key || "stu_race" == $key || "stu_religion" == $key)
				{
					if("stu_religion" == $key)
					{
						$tempreligion = $value;
						
						if("NULL" == $tempreligion)
						{
							$value = "-";
						}
					}
					array_push($r, " ".strval(name_strtoupper($value)));
				}				
			}
			
			array_push($excel_data, $r);
			
			$index++;
		}
				
		//load the header into position B6
		$this->excel->getActiveSheet()->fromArray( $excel_header, NULL, 'B6' );
		
		//load the data into position B7
		$this->excel->getActiveSheet()->fromArray( $excel_data, NULL, 'B7' );
		
		//border fill color for header
		$style_header = array( 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
							   				   'color' => array('rgb'=>'FFC000')),
							   'font' => array('bold' => true)
							 );
							 
		$this->excel->getActiveSheet()->getStyle('B6:I6')->applyFromArray( $style_header ); //apply the border fill
	 
		//style to set border
		$borderStyleArray = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
		        									  'inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
		    					  					)
								 );
	
		$this->excel->getActiveSheet()->getStyle('B6:I'.(5+$index))->applyFromArray($borderStyleArray); 
	 	
		$this->excel->getActiveSheet()->getStyle('D6:D'.(5+$index))->
			getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
		
		//set auto resize for all the columns
		for ($col=65; $col<=90; $col++) 
		{
			$this->excel->getActiveSheet()->getColumnDimension(chr($col))->setAutoSize(true);
		}
		
		header('Content-Type: application/vnd.ms-excel'); //mime type
		header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
		header('Cache-Control: max-age=0'); //no cache
		
		//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension)
		//if you want to save it as .XLSX Excel 2007 format
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel2007');
		//force user to download the Excel file without writing it to server's HD
		$objWriter->save('php://output');
	}
	
	
/**********************************************************************************************
 * Description		: this function to report fin ajax
 * input			: 
 * author			: sukor
 * Date				: 15 july 2013
 * Modification Log	: -
**********************************************************************************************/

	function reportfin_ajax() {
		$arr_data = $this -> m_report -> list_fin_ajax();

		if (sizeof($arr_data) > 0)
			echo json_encode($arr_data);
	}


/**********************************************************************************************
 * Description		: this function to report tak ajax.tak guna
 * input			: 
 * author			: sukor
 * Date				: 16 july 2013
 * Modification Log	: -
**********************************************************************************************/


	function view_fin_no() {

		$data['centrecode'] = $this -> m_result -> get_institusi();
		$data['year'] = $this -> m_result -> list_year_mt();
		$data['courses'] = $this -> m_result -> list_course();
		//$data['state'] = $this -> m_report -> list_state();

		$col_name = $this -> input -> post('kodpusat');
		$current_year = $this -> input -> post('mt_year');
		$cou_id = $this -> input -> post('slct_kursus');
		$current_sem = $this -> input -> post('semester');

		 $cC=explode("-", $col_name); 
		 
		 
		 
	if(!empty($current_sem)){
$data['student'] = $this -> m_report ->get_fin($cC[0], $cou_id, $current_sem, $current_year);
}
	

		$data['output'] = $this -> load -> view('report/v_report_fin', $data, true);
		$this -> load -> view('main', $data);
	}



/**********************************************************************************************
 * Description		: this function to report student total by course
 * input			: 
 * author			: sukor
 * Date				: 17 july 2013
 * Modification Log	: -
**********************************************************************************************/

function studentkv_course()
	{
		
		
	
		$data['courses'] = $this->m_result->list_course();
		$data['year'] =$this->m_result->list_year_mt();
		
		$state= $this->input->post('state');
		$year= $this->input->post('mt_year');
		$semester= $this->input->post('semester');
		
		$user_login = $this->ion_auth->user()->row();
		$colid = $user_login->col_id;
		$userId = $user_login->user_id;
		$state_id= $user_login->state_id;

		  $user_groups = $this->ion_auth->get_users_groups($userId)->row();  
		  $ul_type= $user_groups->ul_type;
		  
		
		if(($ul_type=="JPN") || ($ul_type=="KV")){
			$data['college'] = $this->m_report->college_analysis($colid);
			$data['state']=$state_id;
		}else{
			$data['college'] = $this->m_report->college($state);
				$data['state'] = $this -> m_report -> list_state();
		}
		
		
		$data['ul_type']=$user_groups->ul_type;
	
			
		//$data['student'] = $this->m_report->get_student_course($semester, $year, $state);
		$data['student'] = $this->m_report->course_student_kv($semester,$state,$year,$colid);
		
	
		
		$data['output'] = $this->load->view('report/v_studentkv_bycourse', $data, true);
		$this->load->view('main', $data);
	}



/**********************************************************************************************
 * Description		: this function to report fik
 * input			: 
 * author			: sukor
 * Date				: 18 july 2013
 * Modification Log	: -
**********************************************************************************************/

	function view_fik_no() {

		$data['centrecode'] = $this -> m_result -> get_institusi();
		$data['year'] = $this -> m_result -> list_year_mt();
		$data['courses'] = $this -> m_result -> list_course();
		//$data['state'] = $this -> m_report -> list_state();

		$col_name = $this -> input -> post('kodpusat');
		$current_year = $this -> input -> post('mt_year');
		$cou_id = $this -> input -> post('slct_kursus');
		$current_sem = $this -> input -> post('semester');
		

		 $cC=explode("-", $col_name); 
		 
		 
		 
	if(!empty($current_sem)){
//$data['student'] = $this -> m_report ->get_fik($cC[0], $cou_id, $current_sem, $current_year);
}

		$data['output'] = $this -> load -> view('report/v_reportfik', $data, true);
		$this -> load -> view('main', $data);
	}


/**********************************************************************************************
 * Description		: this function to report fik
 * input			: 
 * author			: sukor
 * Date				: 18 july 2013
 * Modification Log	: -
**********************************************************************************************/
function print_fik() {

		$col_name = $this -> input -> post('kodpusat');
		$current_year = $this -> input -> post('mt_year');
		$cou_id = $this -> input -> post('slct_kursus');
		$current_sem = $this -> input -> post('semester');
		
		
		 $cC=explode("-", $col_name); 

		//$data['student'] = $this -> m_report ->get_fik($cC[0], $cou_id, $current_sem, $current_year);
		$data['student'] = $this -> m_report ->result_fik($cC[0], $cou_id, $current_sem, $current_year);

		
		//$data['student'] = $this -> m_report ->get_fik($cC[0], $cou_id, $current_sem, $current_year);
		$data['hkodkolej'] = $cC[0];
		$data['htahun'] = $current_year;
		$data['hkursus'] = $cou_id;
		$data['hsemester'] = $current_sem;
		
		$this -> load -> view('report/v_fik_printv2', $data);
		//$this -> load -> view('report/v_fik_print', $data);
	}
	
/**********************************************************************************************
 * Description		: this function to export FIK
* input				:
* author			: norafiq
* Date				: 10October 2013
* Modification Log	: -
**********************************************************************************************/	
function export_xls_fik()
{
	//get submit parameters
	$col_name = $this->input->get_post("ckod");
	$cou_id = $this->input->get_post("kursus");
	$current_sem = $this->input->get_post("semtr");
	$current_year = $this->input->get_post("tahun");
	
	//get values
	$list_fik = $this->m_report->result_fik($col_name, $cou_id, $current_sem, $current_year);
	
	//for debug purpose only, safe to delete
	/*echo"<pre>";
	 print_r($list_fik);
	echo"</pre>";
	die();*/
	
	//load our new PHPExcel library
	$this->load->library('excel');
		
	//activate worksheet number 1
	$this->excel->setActiveSheetIndex(0);
	
	//name the worksheet
	$this->excel->getActiveSheet()->setTitle("Fail Induk Keputusan");
	
	//save our workbook as this file name
	$filename='Fail_Induk_Keputusan.xls';
	
	//set the informations
	$this->excel->getActiveSheet()->setCellValue('B2', 'Fail Induk Nama');
	$this->excel->getActiveSheet()->mergeCells('B2:Z2');
	
	//style for the above information
	$styleArray = array(
			'font' => array('bold' => true),
			'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
	);
	
	$this->excel->getActiveSheet()->getStyle('B1:B3')->applyFromArray($styleArray); //apply the style to the cells
	
	$highlightCells = array();
	
	//header
	$excel_header = array('BIL','NAMA CALON','MYKAD','ANGKA GILIRAN','KOD KURSUS','JANTINA','KAUM','AGAMA');
	
	$ttl = 0;
	$columnCount = 65;
	
	$arysubb=array();
	
	//$sucount=$list_fik[0]->count_subj;
	
	foreach ($list_fik as $stuk)
	{
		$keyk=	count($stuk->moduletaken);
				 	
		array_push($arysubb,$keyk);
						
	}	
				
	$uniqcodesub=array_unique($arysubb);
	arsort($uniqcodesub);
	
	for ($i=1; $i<=$uniqcodesub[0]; $i++)
	{
		array_push($excel_header, 'KOD_MP'.$i." ", 'NAMA_MP'.$i." ", 'JK_MP'.$i." ", 'GRED_MP'.$i." ", 'NM_MP'.$i." ",
								  'MK_MP'.$i." ", 'STATUS_MP'.$i." ");
	}
	
	array_push($excel_header, 'PNGA ', 'PNGKA ', 'PNGV ', 'PNGKV ', 'PNGK ', 'PNGKK ', 'JUM_MP ', 'JUM_JK ', 'JUM_MN ', 'STATUS');
	
	
	//data
	$index = 1;
	$excel_data = array();
	foreach($list_fik as $rowData)
	{
		$r = array();
		array_push($r, $index);
		
		$namapelajar 	= $rowData->stu_name;
		$icpalajar 		= $rowData->stu_mykad;
		$angkagiliran	= $rowData->stu_matric_no;
		$kodkursus		= $rowData->cou_course_code;
		$jantina		= $rowData->stu_gender;
		$bangsa			= $rowData->stu_race;
		$agama			= $rowData->stu_religion;
		
		if("NULL" == $agama)
		{
			$agama = "-";
		}		
		
		array_push($r, " ".strval(name_strtoupper($namapelajar)), " ".$icpalajar." ",
					   " ".strval(name_strtoupper($angkagiliran)),
					   " ".strval(name_strtoupper($kodkursus)),
					   " ".strval(name_strtoupper($jantina)),
					   " ".strval(name_strtoupper($bangsa)),
					   " ".strval(name_strtoupper($agama)));
				
		$credittotal	= 0;
		$nilaMata		= 0;
		$jummod			= 0;
		$nilaMatatot	= 0;
		
		foreach($rowData->moduletaken as $moduldiambil)
		{
			$jummod++;
			
			$credittotal 	+= $moduldiambil->mod_credit_hour;
				
			$nilaMata		=  $moduldiambil->mod_credit_hour*$moduldiambil->grade_value;
			$nilaMatatot	+= $nilaMata;
			
			if(0 == $nilaMata)
			{
				$nilaMata = "0";
			}
			
			$kodmodule = $moduldiambil->mod_paper;
			$namamodul = $moduldiambil->mod_name;
			$jamkredit = $moduldiambil->mod_credit_hour;
			$jenisgred = $moduldiambil->grade_type;
			$nilaigred = $moduldiambil->grade_value;
			$levelgred = $moduldiambil->grade_level;
			
			array_push($r, " ".strval(name_strtoupper($kodmodule)),
						   " ".strval(name_strtoupper($namamodul)), $jamkredit." ", 
						   " ".strval(name_strtoupper($jenisgred)), $nilaigred." ", $nilaMata." ",
						   " ".strval(name_strtoupper($levelgred)));
		}
		                
		$pngk 	= $rowData->pngk;
		$pngkk 	= $rowData->pngkk;
		$pngv 	= $rowData->pngv;
		$pngkv 	= $rowData->pngkv;
		$pnga	= $rowData->pnga;
		$pngka	= $rowData->pngka;
		$status = "1 ";
		
		array_push($r, $pnga." ", $pngka." ", $pngv." ", $pngkv." ", $pngk." ", $pngkk." ", $jummod." ",
					   $credittotal." ", $nilaMatatot." ", $status);
		
		array_push($excel_data, $r);
		//array_push($excel_data, $subjek_arr);
			
		$index++;
	}
	
	//for debug purpose only, safe to delete
	/*echo"<pre>";
	 print_r($gabung_arr);
	echo"</pre>";
	die();*/
	
	//set auto resize for all the columns
	for ($col= 'A'; $col != 'CL'; $col++)
	{
		$this->excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
	}
	
	//load the header into position B4
	$this->excel->getActiveSheet()->fromArray( $excel_header, NULL, 'B4' );
	
	//load the data into position B5
	$this->excel->getActiveSheet()->fromArray( $excel_data, NULL, 'B5' );
	
	//border fill color for header
	$style_header = array( 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
			'color' => array('rgb'=>'FFC000')),
			'font' => array('bold' => true)
	);
	
	$this->excel->getActiveSheet()->getStyle('B4:CK4')->applyFromArray( $style_header ); //apply the border fill
	
	//style to set border
	$borderStyleArray = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
			'inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
		)
	);
	
	$this->excel->getActiveSheet()->getStyle('B4:CK'.(3+$index))->applyFromArray($borderStyleArray);
	 
	$this->excel->getActiveSheet()->getStyle('D4:D'.(3+$index))->
		getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
	
	header('Content-Type: application/vnd.ms-excel'); //mime type
	header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	header('Cache-Control: max-age=0'); //no cache
	
	//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension)
	//if you want to save it as .XLSX Excel 2007 format
	$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
	//force user to download the Excel file without writing it to server's HD
	$objWriter->save('php://output');
	
	
}

/**********************************************************************************************
	* Description		: this function to get course by kv
	* input			: 
	* author			:Freddy Ajang Tony
	* Date				: 30 september 2013
	* Modification Log	: edit sukor 13032014
	**********************************************************************************************/
	function get_course_by_kv_edit()
	{
		$code = $this->input->post('kodpusat');
		$course_type = substr(trim($code), 0,1);
		$course_code = substr(trim($code), 1);
		
		
		$data['course'] = $this->m_result->get_course($course_type,$course_code);
		
		/**FDPO - Safe to be deleted**/
		//echo('<pre>');print_r($data);echo('</pre>');
		//die();
		
		$this->load->view('report/v_get_course', $data);
		
		
			
	}

}
?>