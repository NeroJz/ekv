<?php
/**************************************************************************************************
 * File Name        : report.php
 * Description      : This File contain Report module.
 * Author           : sukor
 * Date             : 15 july 2013
 * Version          : -
 * Modification Log : -
 * Function List       : __construct(),
 **************************************************************************************************/
class Report_v2 extends MY_Controller {

    function __construct() {
        parent::__construct();

        $this -> load -> model('m_result');
        $this -> load -> model('m_report');
    }


/**********************************************************************************************
 * Description      : this function to view FIN
 * input            : 
 * author           : Nabihah Ab Karim
 * Date             : 21 Februari 2014
 * Modification Log : -
**********************************************************************************************/ 
function view_fik_no() 
    {

        $data['centrecode'] = $this -> m_result -> get_institusi();
        $data['year'] = $this -> m_result -> list_year_mt();
        $data['courses'] = $this -> m_result -> list_course();
    
 
        $data['output'] = $this -> load -> view('report/v_reportfikv2', $data, true);
        $this -> load -> view('main', $data);
    }
/**********************************************************************************************
 * Description      : this function to report fin
 * input            : 
 * author           : Nabihah Abkarim
 * Date             : 21 Februari 2014
 * Modification Log : -
**********************************************************************************************/

    function print_fik() {

/*
        $col_name = $this -> input -> post('kodpusat');
        $current_year = $this -> input -> post('mt_year');
        $cou_id = $this -> input -> post('slct_kursus');
        $current_sem = $this -> input -> post('semester');*/
        
          $col_name = "KV Cubaan";
        $current_year = 2014;
        $cou_id = 6;
        $current_sem = 1;
        
        $cC=explode("-", $col_name); 

        $data['student'] = $this -> m_report ->result_fik_v2($cC[0], $cou_id, $current_sem, $current_year);
 echo "<pre>";
        print_r($data['student']);
        echo "</pre>";
        //$data['student'] = $this -> m_report ->get_fik($cC[0], $cou_id, $current_sem, $current_year);
        $data['hkodkolej'] = $cC[0];
        $data['htahun'] = $current_year;
        $data['hkursus'] = $cou_id;
        $data['hsemester'] = $current_sem;
        
    //  $this -> load -> view('report/v_fik_printv3', $data);
        //$this -> load -> view('report/v_fik_print', $data);
    }
    
    
    
    /**********************************************************************************************
 * Description      : this function to export FIK
* input             :
* author            : norafiq
* Date              : 10October 2013
* Modification Log  : -
**********************************************************************************************/ 
function export_xls_fik()
{
   // $col_name = "KV Cubaan";
   //     $current_year = 2014;
    //    $cou_id = 6;
    //    $current_sem = 1;
        $col_name = $this -> input -> post('kodpusat');
        $current_year = $this -> input -> post('mt_year');
        $cou_id = $this -> input -> post('slct_kursus');
        $current_sem = $this -> input -> post('semester');
        
        $cC=explode("-", $col_name); 

        $student = $this -> m_report ->result_fik_v2($cC[0], $cou_id, $current_sem, $current_year);;
    
    if(!empty($student)){
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
    $this->excel->getActiveSheet()->setTitle("FIK");
    
    //save our workbook as this file name
    $filename='Fail_Induk_Keputusan.xls';
    
    //set the informations
        $this->excel->getActiveSheet()->setCellValue('A1', 'FIN');
        $this->excel->getActiveSheet()->mergeCells('A1:J1');
        $this->excel->getActiveSheet()->setCellValue('K1', 'PENTAKSIRAN BERTERUSAN [PB] AKADEMIK');
        $this->excel->getActiveSheet()->mergeCells('K1:Q1');
        $this->excel->getActiveSheet()->setCellValue('R1', 'PENILAIAN AKHIR [PA] AKADEMIK');
        $this->excel->getActiveSheet()->mergeCells('R1:AB1');
        $this->excel->getActiveSheet()->setCellValue('AC1', 'MARKAH PB DAN PA AKADEMIK');
        $this->excel->getActiveSheet()->mergeCells('AC1:AP1');
        $this->excel->getActiveSheet()->setCellValue('AQ1', 'MARKAH PB + PA AKADEMIK');
        $this->excel->getActiveSheet()->mergeCells('AQ1:AW1');
        $this->excel->getActiveSheet()->setCellValue('AX1', 'GRED AKADEMIK');
        $this->excel->getActiveSheet()->mergeCells('AX1:BD1');
        $this->excel->getActiveSheet()->setCellValue('BE1', 'PENTAKSIRAN BERTERUSAN (PB) VOKASIONAL');
        $this->excel->getActiveSheet()->mergeCells('BE1:BT1');
        
        $this->excel->getActiveSheet()->setCellValue('BU1', 'PENILAIAN AKHIR (PA) VOKASIONAL');
        $this->excel->getActiveSheet()->mergeCells('BU1:CJ1');
        $this->excel->getActiveSheet()->setCellValue('CK1', 'MARKAH PB VOKASIONAL');
        $this->excel->getActiveSheet()->mergeCells('CK1:CR1');
        $this->excel->getActiveSheet()->setCellValue('CS1', 'MARKAH PA VOKASIONAL');
        $this->excel->getActiveSheet()->mergeCells('CS1:CZ1');
        $this->excel->getActiveSheet()->setCellValue('DA1', 'MARKAH PB + PA VOKASIONAL');
        $this->excel->getActiveSheet()->mergeCells('DA1:DH1');
        $this->excel->getActiveSheet()->setCellValue('DI1', 'GRED VOKASIONAL');
        $this->excel->getActiveSheet()->mergeCells('DI1:DP1');
    //style for the above information
    $styleArray = array( 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb'=>'F0F0F0 ')),
            'font' => array('bold' => true)
    );
    
    $this->excel->getActiveSheet()->getStyle('A1:DP1')->applyFromArray($styleArray); //apply the style to the cells
    
   // $this->excel->getActiveSheet()->getStyle('B1:B3')->applyFromArray($styleArray); //apply the style to the cells
    
    $highlightCells = array();
    
    //header
    $subjek=array();
    $excel_header = array('BIL','NAMA CALON','NO. KAD PENGENALAN','ANGKA GILIRAN','KOD KURSUS','STATUS','JANTINA','KAUM','AGAMA','KV');
 
 // HEADER   
    
  $subjekUnie= array('BAHASA MELAYU' , 'BAHASA INGGERIS', 'MATHEMATICS' ,
   'SAINS' ,'SEJARAH' ,'PEND ISLAM','PEND MORAL');
     
  foreach($subjekUnie as $rowak){
    array_push($excel_header, $rowak."(100)");  
      
  }
 
  
  foreach($subjekUnie as $rowak){
      array_push($excel_header, $rowak."(100)");
      if($rowak=='SAINS'){
           array_push($excel_header,'SAINS KERTAS 2 (100)','SAINS GABUNG');
      }
      
        if($rowak=='PENDIDIKAN ISLAM'){
           array_push($excel_header,'PEND ISLAM KERTAS 2 ','PEND ISLAM GABUNG');
      }
       
  }

 
 
  foreach($subjekUnie as $rowak){
    array_push($excel_header, $rowak."\r [30]\r [PB]",$rowak.
"\r[70]\r[PA]");  
      
  }
 
 foreach($subjekUnie as $rowak){
    array_push($excel_header, $rowak."(100)");  
      
  }
 foreach($subjekUnie as $rowak){
    array_push($excel_header, $rowak);  
      
  }
    
    
 for ($i=1; $i <17 ; $i++) {
     
     if($i>8){
         $a=$i-8;
     }else{
         $a=$i;
     }
      
      array_push($excel_header,"TEORI $a (100)","AMALI $a (100)" );  
 }   
 for ($i=1; $i <25 ; $i++) {
     
     if($i>16 && $i<25){
         $a=$i-16;
         $scope= '[100]';
     }elseif($i>8){
         $a=$i-8;
         $scope= '[30]';
     }else{
         $a=$i;
         $scope= '[70]';
         
     }
      
      array_push($excel_header,"M$a $scope" );  
 }   
 
  for ($i=1; $i <9 ; $i++) {
     
   
      
      array_push($excel_header,"M$i" );  
 }
   //END OF HEADER
   
    $index = 1;
    $excel_data = array();
   // $excel_data=array();
    foreach($student as $rowData)
    {
        $r = array();
        $s = array();
        $p = array();
        array_push($r, $index);
        
        $namapelajar    = $rowData->stu_name;
        $icpalajar      = $rowData->stu_mykad;
        $angkagiliran   = $rowData->stu_matric_no;
        $kodkursus      = $rowData->cou_course_code;
        $jantina        = $rowData->stu_gender;
        $bangsa         = $rowData->stu_race;
        $agama          = $rowData->stu_religion;
        $status         = $rowData->stat_id;
        $col_name        = $rowData->col_name;
        $cou_idg        =$rowData->cou_id;
      //FIN     
        
        array_push($r, " ".strval(name_strtoupper($namapelajar)), " ".$icpalajar." ",
                       " ".strval(name_strtoupper($angkagiliran)),
                       " ".strval(name_strtoupper($kodkursus)),
                       " ".strval(name_strtoupper($status)),
                       " ".strval(name_strtoupper($jantina)),
                       " ".strval(name_strtoupper($bangsa)),
                       " ".strval(name_strtoupper($agama)),
                       " ".strval(name_strtoupper($col_name )));
               $p=array(); 
               
               //END FIN
               // modul AK       
            foreach($rowData->moduletaken_AK as $markSub)
        {
            $modl=$markSub->mod_name;
            
            $pus=array();
            $sek='';
            
          foreach ($markSub->mark_ass as  $rowm) {
             
              if($rowm->mark_category=='S'){
                      $dats =$rowm->marks_value;
                  
                  if($modl=="Pendidikan Moral"){
          
                    array_push($s,  " "); 
                  
              }
                  
             array_push($s,  " ".strval($dats)); 
             
             if($modl=="Pendidikan Islam"){
                    
                  
                    array_push($s,  " "); 
                  
              }
                
              }else{
                  
                   if($modl=="Pendidikan Moral"){
                    
                  
                    array_push($p,  " ".strval('')); 
                   
              }
                   
                     if($modl=="Science" && $rowm->mark_category=='P'){
                    if(!empty($markSub->mark_teori)){
                     
                     foreach ($markSub->mark_teori as $teoriPak) {
                 
                 if($teoriPak->ppr_category=="P"){
                     
                      array_push($p,  "");  
                    
                 }else{
                     
                      array_push($p,  "");  
                     
                 }
                     
                 
                 
             }   
                 }else{
                     
                     array_push($p,  "","");  
                 }
                  
              }
                   
                 if($modl=="Pendidikan Islam" && $rowm->mark_category=='P'){
                 
                 if(!empty($markSub->mark_teori)){
                     
                     foreach ($markSub->mark_teori as $teoriPak) {
                 
                 if($teoriPak->ppr_category=="P"){
                     
                      array_push($p,  " ".$teoriPak->mark);  
                 }
       
             }   
                 }else{
                   //  array_push($p,  "","");  
                 }
       
              }
                 
                   if($modl=="Pendidikan Moral"){
          
                   // array_push($p,  " ".strval('')); 
                 
              }
                  $datp =$rowm->marks_value;
                 array_push($p,  " ".strval($datp)); 
                 if($modl=="Pendidikan Islam" && $rowm->mark_category=='P'){
                     
                       array_push($p,  "");  
                 }
         
              }

          }  

        }     
        
         foreach ($s as $smark) {
            array_push($r,  " ".strval($smark)); 
        }       
        foreach ($p as $pmark) {
            array_push($r,  " ".strval($pmark)); 
        }
        
              
              foreach($rowData->moduletaken_AK as $markSub)
        {
            
            
             if($markSub->mod_name =="Pendidikan Moral"){
               array_push($r,  " ".strval(''),strval(''));
         }
                $ptotal=array();
         foreach ($markSub->mark_ass as  $rowms) {
             
             
             $markpa=($rowms->marks_total_mark/100)*$rowms->marks_value;
             array_push($r,  " ".strval($markpa));
           
          } 
           if($markSub->mod_name =="Pendidikan Islam"){
               array_push($r,  " ".strval('')," ".strval(''));
         }
           
              
        }
        
              foreach($rowData->moduletaken_AK as $markSubb)
        {
              if($markSubb->mod_name =="Pendidikan Moral"){
               array_push($r,  " ".strval(''));
         }
           array_push($r,  " ".strval($markSubb->mt_full_mark)); 
            if($markSubb->mod_name =="Pendidikan Islam"){
               array_push($r,  " ".strval(''));
         }
        }     
        
            foreach($rowData->moduletaken_AK as $markSubbb)
        {
              if($markSubbb->mod_name =="Pendidikan Moral"){
               array_push($r,  " ".strval(''));
         }
           array_push($r,  " ".strval($markSubbb->grade_type)); 
             if($markSubbb->mod_name =="Pendidikan Islam"){
               array_push($r,  " ".strval(''));
         }
        }       
    
         $n=0;
             foreach($rowData->moduletaken_VK as $markSubvk)
        {
               $markToeri=array();
         $markAmali=array();
         $markToerip=array();
         $markAmalip=array();
          
            if(!empty($markSubvk->mark_teori)){
                 $teorisub= $markSubvk->mark_teori;
               
        
            foreach ($teorisub as $rowteori) {
                  
                   $pecahan[$rowteori->pt_category][$rowteori->assgmnt_name]= $rowteori-> pt_teori   ;
                   $pilih[$rowteori->pt_category][$rowteori->assgmnt_name]= $rowteori-> assgmnt_score_selection   ;    
               if($rowteori->pt_category=='S'){
                   if($rowteori->assgmnt_name=='Teori'){
                           
                       array_push($markToeri,$rowteori->mark);
                       
                   }
                    if($rowteori->assgmnt_name=='Amali'){
                           
                       array_push($markAmali,$rowteori->mark);
                       
                   }
                   
               } elseif ($rowteori->pt_category=='P') {
                   if($rowteori->assgmnt_name=='Teori'){
                           
                       array_push($markToerip,$rowteori->mark);
                       
                   }
                    if($rowteori->assgmnt_name=='Amali'){
                           
                       array_push($markAmalip,$rowteori->mark);
                       
                   }
               }            
                        
                    
                
               
            }
        
            }
    
        arsort($markToeri);
        arsort($markAmali);
        
        //sekolah
        //teori
        $asSTeori=empty($pilih['S']['Teori'])?1:$pilih['S']['Teori'];
        $asSAmali=empty($pilih['S']['Amali'])?1:$pilih['S']['Amali'];
        
        $asPTeori=empty($pilih['P']['Teori'])?1:$pilih['P']['Teori'];
        $asPAmali=empty($pilih['S']['Amali'])?1:$pilih['S']['Amali'];
        
        $tos=array_slice($markToeri, 0,$asSTeori);
        $totalpt[$n]=ceil(array_sum($tos)/$asSTeori);
    

        
      //  amali
        $ams=array_slice($markAmali, 0, $asSAmali);
        $totalams[$n]=ceil(array_sum($ams)/$asSAmali);
      
        //pusat
       // teori
        $totalptp[$n]=ceil(array_sum($markToerip)/ $asPTeori);
        //amali
        $totalamsp[$n]=ceil(array_sum($markAmalip)/$asPAmali);
   
            
            
              if(!empty($markSubvk->mark_ass)){
                  
                  foreach ($markSubvk->mark_ass as $markAss) {
            
                       $maks[$markAss->mark_category][$n]=ceil($markAss->marks_value);
  
              }
              }
              
              
              $grade[$n]=$markSubvk->grade_type;
              $fullmark[$n]=$markSubvk->mt_full_mark;
           $n++; 
            

         } 


for ($ia=0; $ia <8 ; $ia++) {
     
    array_push($r,  empty($totalpt[$ia])?"0":$totalpt[$ia],empty($totalams[$ia])?"0":$totalams[$ia]);
}

   for ($ib=0; $ib <8 ; $ib++) {
     
    array_push($r,  empty($totalptp[$ib])?"0":$totalptp[$ib],empty($totalamsp[$ib])?"0":$totalamsp[$ib]);
}   
   
     for ($ic=0; $ic <8 ; $ic++) {
 
    array_push($r,  empty( $maks['S'][$ic])?"0": $maks['S'][$ic]);
}    
     
      for ($ic=0; $ic <8 ; $ic++) {
 
    array_push($r,  empty( $maks['P'][$ic])?"0": $maks['P'][$ic]);
}      
      
          for ($id=0; $id <8 ; $id++) {
 
    array_push($r,  empty( $fullmark[$id])?"0": $fullmark[$id]);
}           
 
         for ($ie=0; $ie <8 ; $ie++) {
 
    array_push($r,  empty( $grade[$ie])?"0": $grade[$ie]);
}           
     
 
        array_push($excel_data, $r);
    
           
        $index++;
    }
    
    //for debug purpose only, safe to delete
   
    //set auto resize for all the columns
    $co=count($excel_header);
    for ($col= 'A'; $col != 'DP'; $col++)
    {
        $this->excel->getActiveSheet()->getColumnDimension($col)->setAutoSize(true);
    }
    
    //load the header into position B4
    $this->excel->getActiveSheet()->fromArray( $excel_header, NULL, 'A2' );
    
    //load the data into position B5
    $this->excel->getActiveSheet()->fromArray( $excel_data, NULL, 'A3' );
    
    //border fill color for header
    $style_header = array( 'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb'=>'DFDFDF')),
            'font' => array('bold' => true)
    );
    
    $this->excel->getActiveSheet()->getStyle('A2:DP2')->applyFromArray( $style_header ); //apply the border fill
    
    //style to set border
    $borderStyleArray = array('borders' => array('outline' => array('style' => PHPExcel_Style_Border::BORDER_THIN),
            'inside' => array('style' => PHPExcel_Style_Border::BORDER_THIN)
        )
    );
    
  //  $this->excel->getActiveSheet()->getStyle('B4:CK'.(3+$index))->applyFromArray($borderStyleArray);
     
  //  $this->excel->getActiveSheet()->getStyle('D4:D'.(3+$index))->
   //     getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER);
    
   header('Content-Type: application/vnd.ms-excel'); //mime type
    header('Content-Disposition: attachment;filename="'.$filename.'"'); //tell browser what's the file name
  header('Cache-Control: max-age=0'); //no cache
    
    //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension)
    //if you want to save it as .XLSX Excel 2007 format
    $objWriter = PHPExcel_IOFactory::createWriter($this->excel, 'Excel5');
    //force user to download the Excel file without writing it to server's HD
    $objWriter->save('php://output');
    
    }else{
        
                redirect('/report/report_v2/view_fik_no');
    }
}



/**********************************************************************************************
 * Description      : this function to view FIN
 * input            : 
 * author           : sukor
 * Date             : 28 Februari 2014
 * Modification Log : -
**********************************************************************************************/ 
function get_loop_mark() 
    {
        $centrecode='KV Arau';
$student = $this -> m_report ->get_mark_sub_loop($semester=1,$year=2012);


foreach ($student as $d) {
	
    $stu = $this -> m_report ->get_loop($d->stu_id,$d->md_id);
    
    /*
     [md_id] => 500
            [mod_id] => 48
            [stu_id] => 43
            [mt_semester] => 1
            [mt_year] => 2012
            [mt_full_mark] => 89
            [mt_status] => 1
            [grade_id] => 21
            [exam_status] => 1
            [marks_id] => 999
            [marks_assess_type] => VK
            [mark_category] => P
            [marks_total_mark] => 70.00
            [marks_value] => 89.00
     */
    
    
    foreach ($stu as $key) {
        
        
        if($key->marks_assess_type=='AK'){
            
            $dak[$key->marks_assess_type][$key->mark_category]=$key->marks_value;
            
            if($key->marks_assess_type=='AK' && $key->mark_category=='S'){
                
            
            $data = array(
               'marks_value' => $dak['AK']['P'],
               
            );

               $this->db->where('marks_id', $key->marks_id);
            $ss=$this->db->update('marks', $data); 
            
            if($ss){
                echo "md_id=".$key->md_id.'  stu_id='.$key->stu_id.'<br/>';
                
            }
            }
            
            
        }else{
            
              $dak[$key->marks_assess_type][$key->mark_category]=$key->marks_value;
       $nisbah=  ($key->marks_total_mark/100);
          
            $total=    $dak['VK']['P']*$nisbah;
            
            $datap = array(
               'marks_value' => $total,
               
            );

               $this->db->where('marks_id', $key->marks_id);
            $ss=$this->db->update('marks', $datap); 
            
            if($ss){
                echo "md_id=".$key->md_id.'  stu_id='.$key->stu_id.'<br/>';
                
            }
            
            
            
        }
        
        
        
    }
    
    echo "<pre>";
    echo"---------------------------- <br>";
    print_r($stu);
     echo"---------------------------- <br>";
    echo "</pre>";
}

//echo "<pre>";
//print_r($student);
//echo "</pre>";
    }
    
}
?>