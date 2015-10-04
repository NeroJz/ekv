<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/** Error reporting */
class Excel_Reader{
	
	public function __construct() {
		//$CI =$this->obj;     
         $this->obj = &get_instance();
	// $this->load->model('m_financial');
    }

    function import_with_pemarkahan_berterusan($file=""){
    	error_reporting(E_ALL);
		
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
		$data->read("./uploaded/excellkv/". $file);
		//$data->read("./uploaded/".$file['file']); // relative path to .xls that was uploaded earlier
		
		$sheet_cur = 0;
				
		$abc = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
			     'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
			     'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ',
			     'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY', 'CZ', 
			     'DA', 'DB', 'DC', 'DD', 'DE', 'DF','DG','DH', 'DI', 'DJ', 'DK', 'DL');

		$rows = $data->sheets[$sheet_cur]['cells'];
				$row_count = count($data->sheets[$sheet_cur]['cells']);
				// echo"<pre>";
				// echo 'Bilangan row dalam excel adalah '.$row_count.'<br/>';
				// echo"</pre>";
				//echo $rows;
				
				$sheet_count = count($data->boundsheets);
				
			
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()->setTitle("test");
				$objPHPExcel->setActiveSheetIndex(0);
				
				$j = 0;
				$bil = 0;
				
				$data_temp=array();
				$data_title= array();
				
				for ($i = 1; $i <= $row_count; $i++) {
					$bil++;
					//var_dump($rows[$i]);
					
					if($j==0)
						$j = $i;
					else
						$j++;

					$data_oneStudent = array();

					for ($k = 1; $k <= $data->sheets[$sheet_cur]['numCols']; $k++) 
					{
						if(!empty($data->sheets[$sheet_cur]['cells'][$i][$k])){
							$cur_row = $data->sheets[$sheet_cur]['cells'][$i][$k];
							$objPHPExcel->getActiveSheet()->SetCellValue($abc[($k-1)].$j, $cur_row);
						}
						/* else
							//echo "\"".""."\","; */

						if($k > 1){
							if($i == 1){
								if(isset($data->sheets[$sheet_cur]['cells'][$i][$k])){
									$data_title[$k]	= is_string($data->sheets[$sheet_cur]['cells'][$i][$k])?
									strtolower(str_replace(" ", "_", $data->sheets[$sheet_cur]['cells'][$i][$k]))
									:$data->sheets[$sheet_cur]['cells'][$i][$k];
								}
								continue;
							}

							if($k > 3){
								if(isset($data_title[$k]) && isset($data->sheets[$sheet_cur]['cells'][$i][$k]) ){
									$data_oneStudent['mark'][$k-3]['subjek'] = $data_title[$k];
									$data_oneStudent['mark'][$k-3]['nilai'] = $data->sheets[$sheet_cur]['cells'][$i][$k];
								}
							}
							else
								$data_oneStudent[$data_title[$k]] = $data->sheets[$sheet_cur]['cells'][$i][$k];
						}
					}

					if($i != 1)
						array_push($data_temp,$data_oneStudent);
					
				}
				
				//unlink($file);

				return $data_json = json_encode($data_temp);
				//return $data_temp ;
				
				$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
				$objWriter->save(str_replace('.php', '.xls', __FILE__));
    }
	
	function import_with_kv($file="", $bil_sub="")
	{
		error_reporting(E_ALL);
		
		//echo $cou_name;
		
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
		$data->read("./uploaded/excellkv/". $file);
		//$data->read("./uploaded/".$file['file']); // relative path to .xls that was uploaded earlier
		
		$sheet_cur = 0;
				
		$abc = array('A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','V','W','X','Y','Z',
			     'AA','AB','AC','AD','AE','AF','AG','AH','AI','AJ','AK','AL','AM','AN','AO','AP','AQ','AR','AS','AT','AU','AV','AW','AX','AY','AZ',
			     'BA','BB','BC','BD','BE','BF','BG','BH','BI','BJ','BK','BL','BM','BN','BO','BP','BQ','BR','BS','BT','BU','BV','BW','BX','BY','BZ',
			     'CA','CB','CC','CD','CE','CF','CG','CH','CI','CJ','CK','CL','CM','CN','CO','CP','CQ','CR','CS','CT','CU','CV','CW','CX','CY', 'CZ', 
			     'DA', 'DB', 'DC', 'DD', 'DE', 'DF','DG','DH', 'DI', 'DJ', 'DK', 'DL');
		
//'DB', 'DC', 'DD', 'DE', 'DF', 'DG', 'DH'
		$feeno = array();
		$group_arr = array();
				
				$rows = $data->sheets[$sheet_cur]['cells'];
				$row_count = count($data->sheets[$sheet_cur]['cells']);
				echo"<pre>";
				echo 'Bilangan row dalam excel adalah '.$row_count.'<br/>';
				echo"</pre>";
				//echo $rows;
				
				$sheet_count = count($data->boundsheets);
				
			
				$objPHPExcel = new PHPExcel();
				$objPHPExcel->getProperties()->setTitle("test");
				$objPHPExcel->setActiveSheetIndex(0);
				
				$j = 0;
				$bil = 0;
				
				$data_temp=array();
				
				for ($i = 2; $i <= $row_count; $i++) {
					$bil++;
					//var_dump($rows[$i]);
					
					if($j==0)
						$j = $i;
					else
						$j++;
					
					for ($k = 1; $k <= $data->sheets[$sheet_cur]['numCols']; $k++) 
					{
						if(!empty($data->sheets[$sheet_cur]['cells'][$i][$k])){
							$cur_row = $data->sheets[$sheet_cur]['cells'][$i][$k];
							$objPHPExcel->getActiveSheet()->SetCellValue($abc[($k-1)].$j, $cur_row);
						}
						/* else
							//echo "\"".""."\","; */
					}
					
					
					//$name = mysql_real_escape_string($data->sheets[$sheet_cur]['cells'][$i][2]);
		
					//maklumat pelajar
					
						$feeno['name'] = $data->sheets[$sheet_cur]['cells'][$i][2];
						$feeno['ic'] = $data->sheets[$sheet_cur]['cells'][$i][3];
						$feeno['nomatric'] = $data->sheets[$sheet_cur]['cells'][$i][4];
						$feeno['kv'] = $data->sheets[$sheet_cur]['cells'][$i][5];
						//$feeno['state'] = $data->sheets[$sheet_cur]['cells'][$i][6];
						$feeno['kursus'] = $data->sheets[$sheet_cur]['cells'][$i][6];
						$feeno['kod'] = $data->sheets[$sheet_cur]['cells'][$i][7];
						$feeno['gender'] = $data->sheets[$sheet_cur]['cells'][$i][8];
						$feeno['race'] = $data->sheets[$sheet_cur]['cells'][$i][9];
                        $feeno['rel'] = $data->sheets[$sheet_cur]['cells'][$i][10];
						
						
						$feeno['KOD_MP1'] = $data->sheets[$sheet_cur]['cells'][$i][11];
						$feeno['NAMA_MP1'] = $data->sheets[$sheet_cur]['cells'][$i][12];
						$feeno['JK_MP1'] = $data->sheets[$sheet_cur]['cells'][$i][13];
						$feeno['GRED_MP1'] = $data->sheets[$sheet_cur]['cells'][$i][14];
						$feeno['NM_MP1'] = $data->sheets[$sheet_cur]['cells'][$i][15];
						$feeno['MK_MP1'] = $data->sheets[$sheet_cur]['cells'][$i][16];
						
						$feeno['KOD_MP2'] = $data->sheets[$sheet_cur]['cells'][$i][17];
						$feeno['NAMA_MP2'] = $data->sheets[$sheet_cur]['cells'][$i][18];
						$feeno['JK_MP2'] = $data->sheets[$sheet_cur]['cells'][$i][19];
						$feeno['GRED_MP2'] = $data->sheets[$sheet_cur]['cells'][$i][20];
						$feeno['NM_MP2'] = $data->sheets[$sheet_cur]['cells'][$i][21];
						$feeno['MK_MP2'] = $data->sheets[$sheet_cur]['cells'][$i][22];
						
						$feeno['KOD_MP3'] = $data->sheets[$sheet_cur]['cells'][$i][23];
						$feeno['NAMA_MP3'] = $data->sheets[$sheet_cur]['cells'][$i][24];
						$feeno['JK_MP3'] = $data->sheets[$sheet_cur]['cells'][$i][25];
						$feeno['GRED_MP3'] = $data->sheets[$sheet_cur]['cells'][$i][26];
						$feeno['NM_MP3'] = $data->sheets[$sheet_cur]['cells'][$i][27];
						$feeno['MK_MP3'] = $data->sheets[$sheet_cur]['cells'][$i][28];
						
						$feeno['KOD_MP4'] = $data->sheets[$sheet_cur]['cells'][$i][29];
						$feeno['NAMA_MP4'] = $data->sheets[$sheet_cur]['cells'][$i][30];
						$feeno['JK_MP4'] = $data->sheets[$sheet_cur]['cells'][$i][31];
						$feeno['GRED_MP4'] = $data->sheets[$sheet_cur]['cells'][$i][32];
						$feeno['NM_MP4'] = $data->sheets[$sheet_cur]['cells'][$i][33];
						$feeno['MK_MP4'] = $data->sheets[$sheet_cur]['cells'][$i][34];
						
						$feeno['KOD_MP5'] = $data->sheets[$sheet_cur]['cells'][$i][35];
						$feeno['NAMA_MP5'] = $data->sheets[$sheet_cur]['cells'][$i][36];
						$feeno['JK_MP5'] = $data->sheets[$sheet_cur]['cells'][$i][37];
						$feeno['GRED_MP5'] = $data->sheets[$sheet_cur]['cells'][$i][38];
						$feeno['NM_MP5'] = $data->sheets[$sheet_cur]['cells'][$i][39];
						$feeno['MK_MP5'] = $data->sheets[$sheet_cur]['cells'][$i][40];
						
						$feeno['KOD_MP6'] = $data->sheets[$sheet_cur]['cells'][$i][41];
						$feeno['NAMA_MP6'] = $data->sheets[$sheet_cur]['cells'][$i][42];
						$feeno['JK_MP6'] = $data->sheets[$sheet_cur]['cells'][$i][43];
						$feeno['GRED_MP6'] = $data->sheets[$sheet_cur]['cells'][$i][44];
						$feeno['NM_MP6'] = $data->sheets[$sheet_cur]['cells'][$i][45];
						$feeno['MK_MP6'] = $data->sheets[$sheet_cur]['cells'][$i][46];
						
						$feeno['KOD_MP7'] = $data->sheets[$sheet_cur]['cells'][$i][47];
						$feeno['NAMA_MP7'] = $data->sheets[$sheet_cur]['cells'][$i][48];
						$feeno['JK_MP7'] = $data->sheets[$sheet_cur]['cells'][$i][49];
						$feeno['GRED_MP7'] = $data->sheets[$sheet_cur]['cells'][$i][50];
						$feeno['NM_MP7'] = $data->sheets[$sheet_cur]['cells'][$i][51];
						$feeno['MK_MP7'] = $data->sheets[$sheet_cur]['cells'][$i][52];
						
						$feeno['KOD_MP8'] = $data->sheets[$sheet_cur]['cells'][$i][53];
						$feeno['NAMA_MP8'] = $data->sheets[$sheet_cur]['cells'][$i][54];
						$feeno['JK_MP8'] = $data->sheets[$sheet_cur]['cells'][$i][55];
						$feeno['GRED_MP8'] = $data->sheets[$sheet_cur]['cells'][$i][56];
						$feeno['NM_MP8'] = $data->sheets[$sheet_cur]['cells'][$i][57];
						$feeno['MK_MP8'] = $data->sheets[$sheet_cur]['cells'][$i][58];
						
						$feeno['KOD_MP9'] = $data->sheets[$sheet_cur]['cells'][$i][59];
						$feeno['NAMA_MP9'] = $data->sheets[$sheet_cur]['cells'][$i][60];
						$feeno['JK_MP9'] = $data->sheets[$sheet_cur]['cells'][$i][61];
						$feeno['GRED_MP9'] = $data->sheets[$sheet_cur]['cells'][$i][62];
						$feeno['NM_MP9'] = $data->sheets[$sheet_cur]['cells'][$i][63];
						$feeno['MK_MP9'] = $data->sheets[$sheet_cur]['cells'][$i][64];
						
						if($bil_sub >= 10)
						{
						$feeno['KOD_MP10'] = $data->sheets[$sheet_cur]['cells'][$i][65];
						$feeno['NAMA_MP10'] = $data->sheets[$sheet_cur]['cells'][$i][66];
						$feeno['JK_MP10'] = $data->sheets[$sheet_cur]['cells'][$i][67];
						$feeno['GRED_MP10'] = $data->sheets[$sheet_cur]['cells'][$i][68];
						$feeno['NM_MP10'] = $data->sheets[$sheet_cur]['cells'][$i][69];
						$feeno['MK_MP10'] = $data->sheets[$sheet_cur]['cells'][$i][70];
						}
						
						if ($bil_sub >= 11)
						{
						$feeno['KOD_MP11'] = $data->sheets[$sheet_cur]['cells'][$i][71];
						$feeno['NAMA_MP11'] = $data->sheets[$sheet_cur]['cells'][$i][72];
						$feeno['JK_MP11'] = $data->sheets[$sheet_cur]['cells'][$i][73];
						$feeno['GRED_MP11'] = $data->sheets[$sheet_cur]['cells'][$i][74];
						$feeno['NM_MP11'] = $data->sheets[$sheet_cur]['cells'][$i][75];
						$feeno['MK_MP11'] = $data->sheets[$sheet_cur]['cells'][$i][76];
						}

						if ($bil_sub >= 12)
						{
						$feeno['KOD_MP12'] = $data->sheets[$sheet_cur]['cells'][$i][77];
						$feeno['NAMA_MP12'] = $data->sheets[$sheet_cur]['cells'][$i][78];
						$feeno['JK_MP12'] = $data->sheets[$sheet_cur]['cells'][$i][79];
						$feeno['GRED_MP12'] = $data->sheets[$sheet_cur]['cells'][$i][80];
						$feeno['NM_MP12'] = $data->sheets[$sheet_cur]['cells'][$i][81];
						$feeno['MK_MP12'] = $data->sheets[$sheet_cur]['cells'][$i][82];
						}
						
						if ($bil_sub >= 13)
						{
						$feeno['KOD_MP13'] = $data->sheets[$sheet_cur]['cells'][$i][83];
					 	$feeno['NAMA_MP13'] = $data->sheets[$sheet_cur]['cells'][$i][84];
						$feeno['JK_MP13'] = $data->sheets[$sheet_cur]['cells'][$i][85];
						$feeno['GRED_MP13'] = $data->sheets[$sheet_cur]['cells'][$i][86];
						$feeno['NM_MP13'] = $data->sheets[$sheet_cur]['cells'][$i][87];
						$feeno['MK_MP13'] = $data->sheets[$sheet_cur]['cells'][$i][88];
						}

						if ($bil_sub >= 14)
						{
						$feeno['KOD_MP14'] = $data->sheets[$sheet_cur]['cells'][$i][89];
					 	$feeno['NAMA_MP14'] = $data->sheets[$sheet_cur]['cells'][$i][90];
						$feeno['JK_MP14'] = $data->sheets[$sheet_cur]['cells'][$i][91];
						$feeno['GRED_MP14'] = $data->sheets[$sheet_cur]['cells'][$i][92];
						$feeno['NM_MP14'] = $data->sheets[$sheet_cur]['cells'][$i][93];
						$feeno['MK_MP14'] = $data->sheets[$sheet_cur]['cells'][$i][94];
						}

						if ($bil_sub >= 15)
						{
						$feeno['KOD_MP15'] = $data->sheets[$sheet_cur]['cells'][$i][95];
					 	$feeno['NAMA_MP15'] = $data->sheets[$sheet_cur]['cells'][$i][96];
						$feeno['JK_MP15'] = $data->sheets[$sheet_cur]['cells'][$i][97];
						$feeno['GRED_MP15'] = $data->sheets[$sheet_cur]['cells'][$i][98];
						$feeno['NM_MP15'] = $data->sheets[$sheet_cur]['cells'][$i][99];
						$feeno['MK_MP15'] = $data->sheets[$sheet_cur]['cells'][$i][100];
						}
						
						
						//result
			/*
                        $feeno['PNG_AKA'] = $data->sheets[$sheet_cur]['cells'][$i][100];
						$feeno['PNG_VOK'] = $data->sheets[$sheet_cur]['cells'][$i][101];
						$feeno['PNG'] = $data->sheets[$sheet_cur]['cells'][$i][99];
						$feeno['JUM_NM'] = $data->sheets[$sheet_cur]['cells'][$i][104];
						$feeno['JUM_JK'] = $data->sheets[$sheet_cur]['cells'][$i][103];
			            $feeno['JUM_MP'] = $data->sheets[$sheet_cur]['cells'][$i][102];
			
					
						/*
						$feeno['PNG_AKA'] = $data->sheets[$sheet_cur]['cells'][$i][107];
						$feeno['PNG_VOK'] = $data->sheets[$sheet_cur]['cells'][$i][108];
						$feeno['PNG'] = $data->sheets[$sheet_cur]['cells'][$i][106];
						$feeno['JUM_NM'] = $data->sheets[$sheet_cur]['cells'][$i][111];
						$feeno['JUM_JK'] = $data->sheets[$sheet_cur]['cells'][$i][110];
			            $feeno['JUM_MP'] = $data->sheets[$sheet_cur]['cells'][$i][109];
			
						
						/*
						$feeno['ic'] = $data->sheets[$sheet_cur]['cells'][$i][1];
						$feeno['KOD_MP'] = $data->sheets[$sheet_cur]['cells'][$i][2];
						$feeno['grade'] = $data->sheets[$sheet_cur]['cells'][$i][5];
						*/
					
					/*
					$p=array(
						
						"name"=>$feeno['name'] ,
						"ic"=>$feeno['ic'] ,
						"nomatric"=>$feeno['nomatric'] ,
						"kv"=>$feeno['kv'] ,
						//"state"=>$feeno['state'] ,
						"kod"=>$feeno['kod'] ,
						"gender"=>$feeno['gender'] ,
						"race"=>$feeno['race'],
                        "rel"=>  $feeno['rel'],
						
						'KOD_MP1'=> $feeno['KOD_MP1'],
						'GRED_MP1'=> $feeno['GRED_MP1'],
						'NAMA_MP1' => $feeno['NAMA_MP1'],
						'JK_MP1' => $feeno['JK_MP1'],
						'NM_MP1'=> $feeno['NM_MP1'],
						'MK_MP1'=>  $feeno['MK_MP1'],
						'KOD_MP2'=>  $feeno['KOD_MP2'],
						'GRED_MP2'=>  $feeno['GRED_MP2'],
						'NAMA_MP2' => $feeno['NAMA_MP2'],
						'JK_MP2' => $feeno['JK_MP2'],
						'NM_MP2'=>  $feeno['NM_MP2'],
						'MK_MP2'=>  $feeno['MK_MP2'],
						
						'KOD_MP3'=> $feeno['KOD_MP3'],
						'GRED_MP3'=>  $feeno['GRED_MP3'],
						'NAMA_MP3' => $feeno['NAMA_MP3'],
						'JK_MP3' => $feeno['JK_MP3'],
						'NM_MP3'=>  $feeno['NM_MP3'],
						'MK_MP3'=>  $feeno['MK_MP3'],
						'KOD_MP4'=> $feeno['KOD_MP4'],
						'GRED_MP4'=> $feeno['GRED_MP4'],
						'NAMA_MP4' => $feeno['NAMA_MP4'],
						'JK_MP4' => $feeno['JK_MP4'],
						'NM_MP4'=> $feeno['NM_MP4'],
						'MK_MP4'=> $feeno['MK_MP4'],
						'KOD_MP5'=> $feeno['KOD_MP5'],
						'GRED_MP5'=>$feeno['GRED_MP5'],
						'NAMA_MP5' => $feeno['NAMA_MP5'],
						'JK_MP5' => $feeno['JK_MP5'],
						'NM_MP5'=>$feeno['NM_MP5'],
						'MK_MP5'=> $feeno['MK_MP5'],
						'KOD_MP6'=> $feeno['KOD_MP6'],
						'GRED_MP6'=> $feeno['GRED_MP6'],
						'NAMA_MP6' => $feeno['NAMA_MP6'],
						'JK_MP6' => $feeno['JK_MP6'],
						'NM_MP6'=> $feeno['NM_MP6'],
						'MK_MP6'=> $feeno['MK_MP6'],
						'KOD_MP7'=> $feeno['KOD_MP7'],
						'GRED_MP7'=> $feeno['GRED_MP7'],
						'NAMA_MP7' => $feeno['NAMA_MP7'],
						'JK_MP7' => $feeno['JK_MP7'],
						'NM_MP7'=> $feeno['NM_MP7'],
						'MK_MP7'=> $feeno['MK_MP7'],
						'KOD_MP8'=> $feeno['KOD_MP8'],
						'GRED_MP8'=> $feeno['GRED_MP8'],
						'NAMA_MP8' => $feeno['NAMA_MP8'],
						'JK_MP8' => $feeno['JK_MP8'],
						'NM_MP8'=> $feeno['NM_MP8'],
						'MK_MP8'=> $feeno['MK_MP8'],
						'KOD_MP9'=> $feeno['KOD_MP9'],
						'GRED_MP9'=> $feeno['GRED_MP9'],
						'NAMA_MP9' => $feeno['NAMA_MP9'],
						'JK_MP9' => $feeno['JK_MP9'],
						'NM_MP9'=> $feeno['NM_MP9'],
						'MK_MP9'=> $feeno['MK_MP9']
						/*
						'KOD_MP10'=> $feeno['KOD_MP10'],
						'GRED_MP10'=> $feeno['GRED_MP10'],
						'NAMA_MP10' => $feeno['NAMA_MP10'],
						'JK_MP10' => $feeno['JK_MP10'],
						'NM_MP10'=> $feeno['NM_MP10'],
						'MK_MP10'=> $feeno['MK_MP10'],
						'KOD_MP11'=> $feeno['KOD_MP11'],
						'GRED_MP11'=> $feeno['GRED_MP11'],
						'NAMA_MP11' => $feeno['NAMA_MP11'],
						'JK_MP11' => $feeno['JK_MP11'],
						'NM_MP11'=> $feeno['NM_MP11'],
						'MK_MP11'=> $feeno['MK_MP11'],
						'KOD_MP12'=> $feeno['KOD_MP12'],
						'GRED_MP12'=> $feeno['GRED_MP12'],
						'NAMA_MP12' => $feeno['NAMA_MP12'],
						/*'JK_MP12' => $feeno['JK_MP12'],
						'NM_MP12'=> $feeno['NM_MP12'],
						'MK_MP12'=> $feeno['MK_MP12'],
						'PNG_AKA'=> $feeno['PNG_AKA'],
						'PNG_VOK'=> $feeno['PNG_VOK'],
						'PNG'=> $feeno['PNG'],
						'JUM_NM'=>$feeno['JUM_NM'],
						'JUM_JK'=>$feeno['JUM_JK'],
			            'JUM_MP'=> $feeno['JUM_MP'],
						
						
					);
					
					*/
					
					//tambahan 6/2/2014
					
					
						
					
					/*
					'KOD_MP13'=> $feeno['KOD_MP13'],
						'GRED_MP13'=> $feeno['GRED_MP13'],
						'NAMA_MP13' => $feeno['NAMA_MP13'],
						'JK_MP13' => $feeno['JK_MP13'],
						'NM_MP13'=> $feeno['NM_MP13'],
						'MK_MP13'=> $feeno['MK_MP13'],
					 */
					 /*
					$p=array(
					        'noic'=> $feeno['ic'],
						'kod'=> $feeno['KOD_MP'],
						'grade'=> $feeno['grade'],
						
					);
					*/
					
					array_push($data_temp,$feeno);
					
					 
					 //array_push($data_temp,$feeno['fee']);
				
					
				}
				
				
				return $data_temp ;
				
				$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
				$objWriter->save(str_replace('.php', '.xls', __FILE__));
	}
}
?>
