<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
die('masuk excel_with_group_alumni');
/** Error reporting */
class Excel_Reader{
	
	public function __construct() {
        $this->obj = &get_instance();
    }
	
	public function import_with_group_alumni($file){
		error_reporting(E_ALL);
		
		$link = mysql_connect("192.168.137.1","root","qwerty") or die(mysql_error());
		
		mysql_select_db("sms",$link) or die(mysql_error());
		
		require_once 'Excel/reader.php';
		
		ini_set('include_path', ini_get('include_path').';./Classes/');
		
		/** PHPExcel */
		include 'PHPExcel.php';
		
		/** PHPExcel_Writer_Excel2007 */
		include 'PHPExcel/Writer/Excel2007.php';
		
		// ExcelFile($filename, $encoding);
		$data = new Spreadsheet_Excel_Reader();
		// Set output Encoding.
		$data->setOutputEncoding('CP1251');
		$data->read($file); // relative path to .xls that was uploaded earlier
		
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
					
					
					$name = mysql_real_escape_string($data->sheets[$sheet_cur]['cells'][$i][2]);
		
					if(!empty($data->sheets[$sheet_cur]['cells'][$i][5])){
					 $number = trim($data->sheets[$sheet_cur]['cells'][$i][5]);
					 $number = str_replace("+","",$number);
					 if(preg_match('/-/', $number))
					 {
						 list($num1,$num2) = explode("-",$number);
						 $number = $num1.$num2;
					 }
					 
					 if(substr($number,0,1) == "6")
					 {
						 $number = substr($number,1);
					 }
					 
					 if(substr($number,0,1) != "0")
					 {
						 $number = "0".$number;
					 }
					 
					 if(!preg_match('/^01[0-9]{8}/', $number))
					 {
						 $number='';
					 }
					 
					 if(strlen($number) != 10)
					 {
						 $number='';	 
					 }
					 
					}else{
					 $number = "";
					}
					
					/*if(!empty($data->sheets[$sheet_cur]['cells'][$i][7]))
					{
						$email = $data->sheets[$sheet_cur]['cells'][$i][7];
						$arr_email = explode("/",$email);
						$email = $arr_email[0];
					}
					else*/
						$email = "";
						
					if(!empty($number) && !preg_match('/-/', $number) && strlen($number) > 7)
						{
						$reg_date = date("Y-m-d h:i:s",time()+8*60*60);
						//pk, name, number, email, register date for table user
						
						$sql = "INSERT INTO user VALUES (NULL,'$name','$number','$email','$reg_date','1')";
						
						mysql_query($sql) or die(mysql_error());
							//echo 'ok';
						//echo '<br>';
						
						$matricno = $data->sheets[$sheet_cur]['cells'][$i][1];
						$year_graduate = '2013';
						$year_graduate = trim($year_graduate);
						
						$pk_user = mysql_insert_id();
						
						$sql_s_sgroup = "SELECT g_id FROM s_group WHERE g_detail = '$year_graduate'";
						
						$sl_sg = mysql_query($sql_s_sgroup) or die('s_group select error:'.mysql_error());
						$count_sg = mysql_num_rows($sl_sg);
						
						if($count_sg > 0)
						{
							$rs_sg = mysql_fetch_array($sl_sg);
							$group_id = $rs_sg['g_id'];
						}else
						{
							$sql_ins_g = "INSERT INTO s_group VALUES (NULL, 'Alumni $year_graduate','$year_graduate','1','1',NULL)";
							mysql_query($sql_ins_g) or die('s_group error:'.mysql_error());
							
							$pk_group = mysql_insert_id();
							$group_id = $pk_group;
						}
						
						$sql_ins_ug = "INSERT INTO user_group VALUES (NULL, '$pk_user', '$group_id')";
						mysql_query($sql_ins_ug) or die('user_group error:'.mysql_error());
						
						$faculty_id = substr($matricno,1,2);
						
						$faculty_id = array_search($faculty_id, $faculty_array);
						//pk, matricno , graduate year, pk_table_user, course_id = null
						$sql = "INSERT INTO student VALUES (NULL,'$matricno','$year_graduate','$pk_user','$faculty_id')";
						mysql_query($sql) or die(mysql_error());
							//echo 'ok';
						//echo "<br><br><hr>";
					
						}
						else
						{
							$matricno = $data->sheets[$sheet_cur]['cells'][$i][4];
							//echo $matricno." tak lengkap<br>";
						}
				}
				
				$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
				$objWriter->save(str_replace('.php', '.xls', __FILE__));
	}
}
?>
