<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
//die('masuk excel reader');
/** Error reporting */
class Excel_Reader{
	
	public function __construct() {
        $this->obj = &get_instance();
    }
	
	function import_with_group_alumni($file){
		
		error_reporting(E_ALL);
		
		$this->obj->load->model("m_import");
		$this->obj->load->model("m_pelajar");
		
		require_once 'Excel/reader.php';
		
		ini_set('include_path', ini_get('include_path').';Classes/');
		
		/** PHPExcel */
		include 'Classes/PHPExcel.php';
		
		/** PHPExcel_Writer_Excel2007 */
		include 'Classes/PHPExcel/Writer/Excel2007.php';
		
		// ExcelFile($filename, $encoding);
		$data = new Spreadsheet_Excel_Reader();
		// Set output Encoding.
		$data->setOutputEncoding('CP1251');
		
		if(!file_exists("./uploaded/".$file['upload_data']['file_name']))
		{
			$this->session->set_flashdata("alert_content", "no data found");
			$this->session->set_flashdata('alert_type','MessageBarWarning');
			redirect('student/student_management/import_student');	
		}
		
		$data->read("./uploaded/".$file['upload_data']['file_name']); // relative path to .xls that was uploaded earlier
		//$data->read("./uploaded/AKA SEM 2.xls");
		
		
		$sheet_cur = $file['slct_sheet'];
				
		$abc = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		
		$faculty_array = array(
							   1 => "03",
							   15 => "06",
							   16 => "01",
							   17 => "02",
							   18 => "04",
							   19 => "05",
							   25 => "07"
							   );
		
		$group_arr = array();
				
				$rows = $data->sheets[$sheet_cur]['cells'];
				$row_count = count($data->sheets[$sheet_cur]['cells']);
				//echo 'my row count is'.$row_count.'<br/>';
				
				$sheet_count = count($data->boundsheets);
			
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()->setTitle("test");
				$objPHPExcel->setActiveSheetIndex(0);
				
				$j = 0;
				$bil = 0;
				
				for ($i = 2; $i <= $row_count; $i++) {
					$bil++;
					//var_dump($rows[$i]);
					
					if($j==0)
						$j = $i;
					else
						$j++;
					
					for ($k = 1; $k <= $data->sheets[$sheet_cur]['numCols']; $k++) {
						if(!empty($data->sheets[$sheet_cur]['cells'][$i][$k])){
							$cur_row = $data->sheets[$sheet_cur]['cells'][$i][$k];
							$objPHPExcel->getActiveSheet()->SetCellValue($abc[($k-1)].$j, $cur_row);
						}
						/* else
							//echo "\"".""."\","; */
					} 
					
					$templateAngkaGiliran = $this->obj->m_import->getTemplateAngkaGiliran();
					
					$slct_nama = $file['slct_nama'];
					$slct_noKp = $file['slct_noKp'];
					$slct_angkaGiliran = $file['slct_angkaGiliran'];
					$slct_kodKursus = $file['slct_kodKursus'];
					$slct_jantina = $file['slct_jantina'];
					$slct_kaum = $file['slct_kaum'];
					$slct_agama = $file['slct_agama'];
					$rImportType = $file["rImportType"];
					
					$name = mysql_real_escape_string($data->sheets[$sheet_cur]['cells'][$i][$slct_nama]);
					$noKadPengenalan = mysql_real_escape_string($data->sheets[$sheet_cur]['cells'][$i][$slct_noKp]);
					$angkaGiliran = mysql_real_escape_string($data->sheets[$sheet_cur]['cells'][$i][$slct_angkaGiliran]);
					$kodKursus = mysql_real_escape_string($data->sheets[$sheet_cur]['cells'][$i][$slct_kodKursus]);
					$jantina	 = mysql_real_escape_string($data->sheets[$sheet_cur]['cells'][$i][$slct_jantina]);
					$kaum = mysql_real_escape_string($data->sheets[$sheet_cur]['cells'][$i][$slct_kaum]);
					$agama	 = mysql_real_escape_string($data->sheets[$sheet_cur]['cells'][$i][$slct_agama]);
					
					$kursusId = $this->obj->m_import->getKursusIdByKod($kodKursus);
					$aIKv = $this->obj->m_import->getKvById($file["slct_kv"]);
					
					if(count($aIKv) > 0)
					{
						foreach($aIKv as $row){
							$kodPusatById = $row->kod_pusat;
						}
					}
					
					$kodPusat = substr($angkaGiliran, 0, 5);
					
					$aKv = $this->obj->m_import->getKvByKodPusat($kodPusat);
					$aDataTemplate = array();
					$aDataTemplate["<divider>"] = "";
					$aDataTemplate["<TAHUN>"] = date("y");
					$aDataTemplate["<KOD PUSAT>"] = $file["slct_kv"];
					$aDataTemplate["<KATEGORI KV>"] = "Y";
					$aDataTemplate["<NO KP>"] = $noKadPengenalan;
					
					if(sizeof($aKv) > 0)
					{
						foreach($aKv as $column => $value){
							$key = strtoupper($column);
							$key = str_replace("_", " ", $key);
							
							if(!empty($value))
							$aDataTemplate["<".$key.">"] = $value;
						}	
					}
					
					$aTemplateKey = array();
					$aTemplateVal = array();
					
					foreach($aDataTemplate as $key => $val)
					{
						$aTemplateKey[] = $key;
						$aTemplateVal[] = $val;
					}
					
					$angkaGiliran = str_replace($aTemplateKey, $aTemplateVal, $templateAngkaGiliran);
					
					if($rImportType == "importNow")
					{
						$statusImport = 2;
					}
					else
					{
						$statusImport = 0;
					}
					
					$dataPelajar = array(
									"id_pusat" => $aDataTemplate["<KOD PUSAT>"],
									"no_kp" => $noKadPengenalan,
									"nama_pelajar" => $name,
									"angka_giliran" => $angkaGiliran,
									"jantina" => $jantina,
									"kaum" => $kaum,
									"agama" => $agama,
									"status_import" => $statusImport,
									"time_import" => $file["uploadTime"]
									);
					
					$idPelajar = $this->obj->m_import->addStudentTemp($dataPelajar);
					
					$dataLevel = array(
									"id_pelajar" => $idPelajar,
									"level_semester" => $file["slct_sem"],
									"tahun" => $file["slct_sesi"],
									"kursus_id" => $kursusId
								);
								
					$idLevel = $this->obj->m_import->addLevelTemp($dataLevel);
					
					if($rImportType == "importNow")
					{
						unset($dataPelajar["status_import"]);
						unset($dataPelajar["time_import"]);
						
						$curLevelId = $this->obj->m_import->addImportStudentLevel($dataPelajar, $dataLevel, $idPelajar, $idLevel);
						$lsSubject =$this->obj->m_pelajar->getSubjectById($kursusId);
		
						foreach($lsSubject as $rs)
						{
							$arrSubject = array(
										  	"subjek_id" => $rs->subjek_id,
											"level_id" => $curLevelId,
											"semester_diambil" => $file["slct_sem"],
											"tahun_diambil" => $file["slct_sesi"]	
										  );
							$this->obj->m_pelajar->add_subjek($arrSubject);
						}
						
						for($u=1;$u <= 7; $u++)
						{
							$arrSubject = array(
										  	"subjek_id" => $u,
											"level_id" => $curLevelId,
											"semester_diambil" => $file["slct_sem"],
											"tahun_diambil" => $file["slct_sesi"]	
										  );
							$this->obj->m_pelajar->add_subjek($arrSubject);
						}
						
					}
				}
				
				$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
				$objWriter->save(str_replace('.php', '.xls', __FILE__));
	}

function importKv()
{
		error_reporting(E_ALL);
		
		$this->obj->load->model("m_import");

		
		require_once 'Excel/reader.php';
		
		ini_set('include_path', ini_get('include_path').';Classes/');
		
		/** PHPExcel */
		include 'Classes/PHPExcel.php';
		
		/** PHPExcel_Writer_Excel2007 */
		include 'Classes/PHPExcel/Writer/Excel2007.php';
		
		// ExcelFile($filename, $encoding);
		$data = new Spreadsheet_Excel_Reader();
		// Set output Encoding.
		$data->setOutputEncoding('CP1251');
		
		if(!file_exists("./uploaded/sem1.xls"))
		{
			$this->session->set_flashdata("alert_content", "no data found");
			$this->session->set_flashdata('alert_type','MessageBarWarning');
			redirect('test/');	
		}
		
		$data->read("./uploaded/pendaftaran.xls"); // relative path to .xls that was uploaded earlier
		//$data->read("./uploaded/AKA SEM 2.xls");
		
		
		$sheet_cur = 0;
				
		$abc = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z');
		
		$faculty_array = array(
							   1 => "03",
							   15 => "06",
							   16 => "01",
							   17 => "02",
							   18 => "04",
							   19 => "05",
							   25 => "07"
							   );
		
		$group_arr = array();
				
				$rows = $data->sheets[$sheet_cur]['cells'];
				$row_count = count($data->sheets[$sheet_cur]['cells']);
				//echo 'my row count is'.$row_count.'<br/>';
				
				$sheet_count = count($data->boundsheets);
			
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()->setTitle("test");
				$objPHPExcel->setActiveSheetIndex(0);
				
				$j = 0;
				$bil = 0;
				
				//print_r($data->sheets);
				
				for ($i = 3; $i <= $row_count+1; $i++) {
					$bil++;
					//var_dump($rows[$i]);
					
					if($j==0)
						$j = $i;
					else
						$j++;
					
					for ($k = 1; $k <= $data->sheets[$sheet_cur]['numCols']; $k++) {
						if(!empty($data->sheets[$sheet_cur]['cells'][$i][$k])){
							$cur_row = $data->sheets[$sheet_cur]['cells'][$i][$k];
							$objPHPExcel->getActiveSheet()->SetCellValue($abc[($k-1)].$j, $cur_row);
						}
						/* else
							//echo "\"".""."\","; */
					} 
					
					$code1 = mysql_real_escape_string($data->sheets[$sheet_cur]['cells'][$i][2]);
					$name1 = mysql_real_escape_string($data->sheets[$sheet_cur]['cells'][$i][3]);
					$code2 = isset($data->sheets[$sheet_cur]['cells'][$i][4])?mysql_real_escape_string($data->sheets[$sheet_cur]['cells'][$i][4]):'';
					$name2 = isset($data->sheets[$sheet_cur]['cells'][$i][5])?mysql_real_escape_string($data->sheets[$sheet_cur]['cells'][$i][5]):'';
					$code3 = isset($data->sheets[$sheet_cur]['cells'][$i][6])?mysql_real_escape_string($data->sheets[$sheet_cur]['cells'][$i][6]):'';
					$name3 = isset($data->sheets[$sheet_cur]['cells'][$i][7])?mysql_real_escape_string($data->sheets[$sheet_cur]['cells'][$i][7]):'';
					
					if(!empty($code1))
					{
						$type = "K";
						$data1 = array(
								 "col_type" => $type,
								 "col_name" => $name1,
								 "col_code" => $code1
								);
						$this->obj->m_import->addCollage($data1);
					}
					
					if(!empty($code2))
					{
						$type = "A";
						$data2 = array(
								 "col_type" => $type,
								 "col_name" => $name2,
								 "col_code" => $code2
								);
						$this->obj->m_import->addCollage($data2);
					}
					
					if(!empty($code3))
					{
						$type = "S";
						$data3 = array(
								 "col_type" => $type,
								 "col_name" => $name3,
								 "col_code" => $code3
								);
						$this->obj->m_import->addCollage($data3);
					}
									
				}
				
				$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
				$objWriter->save(str_replace('.php', '.xls', __FILE__));	
}

}

// end of Class
/**************************************************************************************************
* End of excel_reader.php
**************************************************************************************************/
?>
