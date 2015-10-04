<?php
/**************************************************************************************************
* File Name        : attendance.php
* Description      : This File contain attendance V2 module.
* Author           : Freddy Ajang Tony
* Date             : 27 september 2013 
* Version          : -
* Modification Log : -
* Function List	   : __construct(), 
**************************************************************************************************/
class Attendance extends MY_Controller {
	
	function __construct() 
	{
		parent::__construct();

		$this->load->model('m_result');
	}


	/***********************************************************************************************
	* Description		: this function to report attendance_exam
	* input			: 
	* author			: Freddy Ajang Tony
	* Date				: 27 september 2013
	* Modification Log	: -
	***********************************************************************************************/
	function attendance_system()
	{
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
		
		//$data['courses'] = $this->m_result->list_course();
		$data['year'] =$this->m_result->list_year_mt();
		//print_r($data['centrecode']);
		//die();
		$data['output'] = $this->load->view('laporan/v_attendance_system', $data, TRUE);
		$this->load->view('main', $data);
	}
	
		
	/***********************************************************************************************
	* Description		: this function to get module by course
	* input			: 
	* author			: Freddy Ajang Tony
	* Date				: 30 september 2013
	* Modification Log	: -
	***********************************************************************************************/
	function get_module_by_course()
	{
		$course_id = $this->input->post('slct_kursus');
		
		$data['module'] = $this->m_result->get_module($course_id);
		
		/**FDPO - Safe to be deleted**/
		//echo('<pre>');print_r($data);echo('</pre>');
		//die();
		$this->load->view('laporan/v_attendance_system_ajax', $data);
		
		
	}
	
	
	/**********************************************************************************************
	* Description		: this function to get course by kv
	* input			: 
	* author			: Freddy Ajang Tony
	* Date				: 30 september 2013
	* Modification Log	: -
	**********************************************************************************************/
	function get_course_by_kv()
	{
		$code = $this->input->post('kodpusat');
		$course_type = substr(trim($code), 0,1);
		$course_code = substr(trim($code), 1);
		
		
		$data['course'] = $this->m_result->get_course($course_type,$course_code);
		
		/**FDPO - Safe to be deleted**/
		//echo('<pre>');print_r($data);echo('</pre>');
		//die();
		
		$this->load->view('laporan/v_attendance_system_ajax', $data);
			
	}
	
	
	/**********************************************************************************************
	* Description		: this function to get course by kv
	* input			: 
	* author			: Freddy Ajang Tony
	* Date				: 30 september 2013
	* Modification Log	: -
	**********************************************************************************************/
	function attendance_system_print()
	{
		//$code = $this->input->post('kodpusat');
		//$course_type = substr($code, 1,1);
		//$course_code = substr($code, 2);
		
		$centreCode = $this->input->post('kodpusat');
		$semester = $this->input->post('semester');
		$year = $this->input->post('mt_year');
		$course = $this->input->post('slct_kursus');
		$module = $this->input->post('modul');
		$status = $this -> input -> post('status');
		$cC=explode("-", $centreCode);
		$data['student'] = $this->m_result->get_module_taken($cC[0], $semester,$year,$course,$status,$module);
	
		/**FDPO - Safe to be deleted**/
		//echo('<pre>');print_r($data);echo('</pre>');
		//die();
	
		$this->load->view('laporan/v_attendance_system_print', $data, '');
			
	}
	
	/***********************************************************************************************
	* Description		: this function to save attendance
	* input				:
	* author			: Freddy Ajang Tony
	* Date				: 30 October 2013
	* Modification Log	: -
	***********************************************************************************************/
	function attendance_save()
	{
		$data = $this->input->post('data');
		$data_save = array();
		$sData = explode('&',$data);
		/**FDPO - Safe to be deleted**/
		//echo('<pre>');print_r($sData);echo('</pre>');
		//die();
				
		if(!empty($sData))
		{
			foreach($sData as $keys => $values)
			{
				$md_na = substr($values,14);
				$ex_md_na = explode('=',$md_na);
				$md_id = $ex_md_na[0];
				$na_status = $ex_md_na[1];
																
				$u_data = array(
						'md_id' => $md_id,
						'na_status' => $na_status,
				);
							
				array_push($data_save, $u_data);
						
			}
						
			$returnData = $this->m_result->save_not_attendance_exam($data_save);
			
			/**FDPO - Safe to be deleted**/
			//echo('<pre>');print_r($returnData);echo('</pre>');
			//die();
			
			echo $returnData;
		}
	}
	
	
	/**********************************************************************************************
	* Description		: this function to get course by kv
	* input			:
	* author			: Freddy Ajang Tony
	* Date				: 30 october 2013
	* Modification Log	: -
	**********************************************************************************************/
	function attendance_system_view()
	{
		//$code = $this->input->post('kodpusat');
		//$course_type = substr($code, 1,1);
		//$course_code = substr($code, 2);
	
		$centreCode = $this->input->post('kodpusat');
		$semester = $this->input->post('semester');
		$year = $this->input->post('mt_year');
		$course = $this->input->post('slct_kursus');
		$module = $this->input->post('modul');
		$status = $this -> input -> post('statusID');
		$cC=explode("-", $centreCode);
		$data['student'] = $this->m_result->get_module_taken($cC[0], $semester,$year,$course,$status,$module);
	
		/**FDPO - Safe to be deleted**/
		//echo('<pre>');print_r($status);echo('</pre>');
		//die();
		if(isset($data['student'])){
		
			$dataAjax = array(
					'student' => $data['student']
			);
		
			echo(json_encode($dataAjax));
		}
		//$this->load->view('laporan/v_attendance_system_ajax', $data);
			
	}
	
	
	/******************************************************************************************
	 * Description		: eksport excell
	* input				: -
	* author			: umairah
	* Date				: 7 april 2014
	* Modification Log	: -
	******************************************************************************************/
	
	function export_xls_jadual_kedatangan(){
	
		$abc = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
				'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
				'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ',
				'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY', 'CZ',
				'DA', 'DB', 'DC', 'DD', 'DE', 'DF','DG','DH', 'DI', 'DJ', 'DK', 'DL');
	
	
		$centreCode = $this->input->get('kodpusat');
		$semester = $this->input->get('semester');
		$year = $this->input->get('slct_tahun');
		$course = $this->input->get('slct_kursus');
		$module = $this->input->get('modul');
		$status = $this -> input -> get('statusID');
		$cC=explode("-", $centreCode);
		$data['student'] = $this->m_result->get_module_taken($cC[0], $semester,$year,$course,$status,$module);
		$data['nama_kursus'] = $this->m_result->ambik_nama_kursus($course);
		//$data['nama_modul'] = $this->m_result->get_module_jadual_kedatangan($course);
	
		/**FDPO - Safe to be deleted**/
		//echo('<pre>');print_r($module);echo('</pre>');
		//die();
		
		$index = sizeof($data['student']);
	
	
		//load our new PHPExcel library
		$this->load->library('excel');
	
		//activate worksheet number 1
		$this->excel->setActiveSheetIndex(0);
	
		//name the worksheet
		$this->excel->getActiveSheet()->setTitle("Jadual Kedatangan Calon");
	
		//$highlightCells = array();
	
		//header
		$excel_header = array('BIL','NAMA','ANGKA GILIRAN','TINDAKAN');
	
		//$excel_jadual = array();
		
		//$data['student'] = $this->m_result->get_module_taken($cC[0], $semester,$year,$course,$status,$module);

		$filename='Jadual Kedatangan Calon_'.$data['nama_kursus']->cou_name.'_'.$module.'.xls'; //save our workbook as this file name
	
		//load the header into position A1
		$this->excel->getActiveSheet()->fromArray( $excel_header, NULL, 'A10' );
		//	die();
		$ttl = 0;
		$columnCount = 65;
	
		//masukkkan data disini
		$index = 1;
		$excel_data = array();
		//$j = 0;
	
		if(isset($data['student']))
		{
	
			//array_push($r, $index);
			$tidakHadir = 1;
			$hospital = 2;
			
			foreach($data['student'] as $p)
			{				
				$r = array();
				array_push($r,$index);
				array_push($r,strval(name_strtoupper($p->stu_name)));
				array_push($r,$p->stu_matric_no);
				
				if($p->na_status == $tidakHadir)
				{
					array_push($r,"T");
				}
				else if($p->na_status == $hospital)
				{
					array_push($r,"H");
					
				}
				else
				{
					array_push($r,"/");
				}
				
				array_push($excel_data, $r);
				$index++;	
	
			}
				
		}
	
		//echo "<pre>";
		//print_r($excel_data);
		//echo "</pre>";
		//die();
	
		//load the data into position C4
		$this->excel->getActiveSheet()->fromArray( $excel_data, NULL, 'A11' );
	
		//set the informations
		$this->excel->getActiveSheet()->setCellValue('A2', 'Jadual Kedatangan Calon');
		$this->excel->getActiveSheet()->mergeCells('A2:Z2');
		$this->excel->getActiveSheet()->setCellValue('A3', 'Kursus    :    '.$data['nama_kursus']->cou_name);
		$this->excel->getActiveSheet()->mergeCells('A3:Z3');
		$this->excel->getActiveSheet()->setCellValue('A4', 'Semester     :   '.$semester);
		$this->excel->getActiveSheet()->mergeCells('A4:Z4');
		$this->excel->getActiveSheet()->setCellValue('A5', 'T = Tidak Hadir');
		$this->excel->getActiveSheet()->mergeCells('A5:Z5');
		$this->excel->getActiveSheet()->setCellValue('A6', 'H = Hospital');
		$this->excel->getActiveSheet()->mergeCells('A6:Z6');
		$this->excel->getActiveSheet()->setCellValue('A7', '/ = Hadir');
		$this->excel->getActiveSheet()->mergeCells('A7:Z7');

		if(file_exists("./uploaded/kvinfo/Logokolej_small.jpg"))
			{
				$gdImage = imagecreatefromjpeg('./uploaded/kvinfo/Logokolej_small.jpg');

				$objDrawing = new PHPExcel_Worksheet_MemoryDrawing();
				$objDrawing->setImageResource($gdImage);
				$objDrawing->setRenderingFunction(PHPExcel_Worksheet_MemoryDrawing::RENDERING_JPEG); 	// image rendering.
				$objDrawing->setMimeType(PHPExcel_Worksheet_MemoryDrawing::MIMETYPE_DEFAULT);			// nanti image jadi low quality
				$objDrawing->setOffsetX(60);
				$objDrawing->setOffsetY(-5);
				$objDrawing->setCoordinates('C2');
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
				$copDrawing->setCoordinates('B27');
				$copDrawing->setWorksheet($this->excel->getActiveSheet());
			}
		
		//style for the above information
		$styleArray = array(
				'font' => array('bold' => true),
				'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT)
		);
		$this->excel->getActiveSheet()->getStyle('A1:A9')->applyFromArray($styleArray); //apply thee style to the cells
	
		//center alignment
		$styleArrayCenter = array(
				'font' => array('bold' => true),
				'alignment' => array('horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER)
		);
		$this->excel->getActiveSheet()->getStyle('D11:D500')->applyFromArray($styleArrayCenter); //apply thee style to the cells
	
		//border fill color for header
		$style_header = array(
				'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb'=>'FFC000')),
				'font' => array('bold' => true)
		);
		
		
	
		$this->excel->getActiveSheet()->getStyle('A10:'.$abc[(sizeof($excel_header)-1)].'10')->applyFromArray($style_header); //apply the border fill
	
		//style to set border
		$borderStyleArray = array(
				'borders' => array(
						'outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
						'inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
				)
		);
	
		$this->excel->getActiveSheet()->getStyle('A10:'.$abc[(sizeof($excel_header)-1)].(9+$index))->applyFromArray($borderStyleArray);
	
		//style for data even row, we will set color for even rows of data
		$style_even_row = array(
				'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb'=>'FDE9D9'))
		);
		for($i=2; $i<$index; $i++)
		{
			if($i%2==0)
			{
				$this->excel->getActiveSheet()->getStyle('A'.($i+9).':'.$abc[(sizeof($excel_header)-1)].(9+$i))->applyFromArray($style_even_row);
		}
	}
	
	//ni untuk on filter
	//$this->excel->getActiveSheet()->setAutoFilter('A1:'.$abc[(sizeof($excel_header)-1)].($index));
	
	//$this->excel->getActiveSheet()->getCell('A1:'.$abc[(sizeof($excel_header)-1)].'1')->setAutoSize( true ); //apply the border fill
	
	//$this->excel->getActiveSheet()->getStyle(''.($index))->
	//getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
	
	//set auto resize for all the columns
	for ($col=0; $col<=(sizeof($excel_header)-1); $col++)
	{
	$this->excel->getActiveSheet()->getColumnDimension($abc[$col])->setAutoSize(true);
	}
	
	//$blocksList = implode (", ", $mark);
	
	$objValidation = $this->excel->getActiveSheet()->getCell('K1')->getDataValidation();
	/*$objValidation->setType( PHPExcel_Cell_DataValidation::TYPE_DECIMAL);
	$objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_STOP);
	$objValidation->setOperator( PHPExcel_Cell_DataValidation::OPERATOR_LESSTHANOREQUAL);
	$objValidation->setAllowBlank(true);
	$objValidation->setShowInputMessage(true);
	$objValidation->setShowErrorMessage(true);
	$objValidation->setErrorTitle('Input error');
	$objValidation->setError('Only Number is permitted!');
	$objValidation->setPromptTitle('Allowed input');
	$objValidation->setPrompt('Only numbers between 1.0 and 100.0 are allowed.');
	$objValidation->setFormula1(1.0);
	$objValidation->setFormula2(100.0);*/
	
	
	
	$this->excel->getActiveSheet()->removeColumn($abc[(sizeof($excel_header)+1)],1);
	$this->excel->getActiveSheet()->removeColumn($abc[(sizeof($excel_header)+2)],1);
	
	header('Content-Type: application/vnd.ms-excel'); //mime type
	header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
	header('Cache-Control: max-age=0'); //no cache
	
							//save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension)
	//if you want to save it as .XLSX Excel 2007 format
	$objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
	//force user to download the Excel file without writing it to server's HD
	$objWriter->save('php://output');
	}
	
}
?>