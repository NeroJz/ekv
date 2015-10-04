<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/print_setting.js"></script>

<input id="idPrint" name="idPrint" type="button"  value="Cetak Keputusan" onClick="printit(jspOptions)">
<title>Examination Result Slip</title>
<STYLE TYPE="text/css">
     P.breakhere {page-break-before: always}
     body       {font-size: 8pt; font-family: Century Gothic, Arial, Courier New, Sans-Serif; position:relative;}
    .header     {font-size:9pt;font-weight:bold;}
    .colheader  {font-size:8pt;font-weight:normal;padding-left:2pt;padding-right:2pt;}
    .subheader  {font-size:8pt;font-weight:bold;padding-left:2pt;padding-right:2pt;}
    .desc       {font-size:8pt; font-family: Arial, Courier New, Sans-Serif; padding-left:2pt;padding-right:2pt; text-transform: uppercase;}
    .descbold   {font-size:8pt;padding-left:2pt;padding-right:2pt;font-weight:bold;height:10pt;}
    .descs      {font-size:7pt;padding-left:2pt;padding-right:2pt;}
    .descsbold  {font-size:7pt;padding-left:2pt;padding-right:2pt;font-weight:bold;}
    .descxsitalic   {font-size:7pt;padding-left:2pt;padding-right:2pt;font-style:italic}
    .amaun      {font-size:8pt;text-align:right;padding-left:2pt;padding-right:2pt;}
    .total      {font-size:8pt;text-align:right;font-weight:bold;padding-left:2pt;padding-right:2pt;}
    .grandtotal {font-size:8pt;text-align:right;font-weight:bold;padding-left:2pt;padding-right:2pt;border-top:2px #000000 solid;border-bottom:5px #000000 double;}
    .linetop    {font-size:8pt;font-weight:bold;border-top:2px #000000 solid;padding-left:2pt;padding-right:2pt;}
    .linebottom {font-size:8pt;font-weight:bold;border-bottom:2px #000000 solid;padding-left:2pt;padding-right:2pt;}
    
    .BG {
            background-image:url(../../../assets/img/bg_result.png);
            background-repeat:no-repeat;/*dont know if you want this to repeat, ur choice.*/
            height:10%;
            width:10%
        }
        .onepage {
            page-break-after: always;
            page-break-inside: avoid;
        }

    .slip td{ vertical-align: top;}

</STYLE>
<style type="text/css" media="print" >
    body {
        height: 842px;
        width: 595px;
        /* to centre page on screen*/
        margin-left: auto;
        margin-right: auto;
    }
    
    .slip td{ vertical-align: top;}
    
#printheight {
    height:100pt;
}
    
@page 
{
    size: auto;   /* auto is the current printer page size */
    margin: 0mm;  /* this affects the margin in the printer settings */
}

#BrowserPrintDefaults{display:none} 

#break{page-break-after: always;}
#student{width:100%;}
</STYLE>
<script type="text/javascript">
  //parameter untuk set jsPrintSetup option
  var jspOptions = [];

  //jika ada perubahan/penambahan guna push sebab saya pakai json
  //contoh option yang ada boleh rujuk kat sini : https://addons.mozilla.org/en-US/firefox/addon/js-print-setup/‎
  //ni example : 
  //jspOptions.push({'id':"headerStrLeft",'val':'sukor'});

</script>
</head>
<body>
<?php
if(!empty($result)){
    foreach ($result as  $value) {
?>
<div>
        <table class="BG onepage" cellpadding="0" cellspacing="0" border="0" style="width:595px;">
        <!-- header part -------------------------------------- -->
        <tr>
            <td>
                <table width="100%" cellpadding=0 cellspacing=0 border=0>
                    <tr>
                        <td colspan=9 align="center" style="height:60pt;">
                            <span class="colheader"><b>LEMBAGA PEPERIKSAAN<br>
                            KEMENTERIAN PENDIDIKAN MALAYSIA</b></span><br>&nbsp;<br>
                            <span class="desc">KEPUTUSAN PENTAKSIRAN KOLEJ VOKASIONAL<br>
                            SEMESTER <?=$value->mt_semester?> TAHUN <?=$value->mt_year?></span><br><br>
                        </td>
                    </tr>
                    <tr>
                        <td width="105" class="desc" style="width:72pt;"><b>NAMA</b></td>
                        <td width="20" class="desc" style="width:15pt;"><b>:</b></td>
                        <td width="595" colspan="6" class="desc"><b><?=
                            strtoupper($value->stu_name)?></b>
                        </td>
                        <td rowspan="6">
                            <?php
                            
                            // start qr code ********************
                            $sFilename=''; //string
                            $path = 'uploaded/qrcode/';
                            //get product name and convert to lowercase and replace underscore for file naming
                            $sFilename=str_replace(" ",'_',strtolower($value->stu_matric_no));
                            $sFilename = $sFilename.'_'.$value->mt_semester.'_'.$value->mt_year;
                            $urlFilename = urlencode($this->encryption->encode($sFilename));
                            $sUrl=site_url('public/student/result/'.$urlFilename);
                            //$sUrl='http://192.168.43.201/kvv1/index.php/public/student/result/'.$urlFilename;
                            $params['data'] = $sUrl;
                            $params['level'] = 'H';
                            $params['size'] = 10;
                            $params['savename'] = $path.'qr_'.$sFilename.'.png';
                            
                            if(!file_exists($params['savename'])){
                                $qr_code=$this->ciqrcode->generate($params);
                            }
                            
                            echo '<img height="100px" width="100px" src="'.base_url($params['savename']).'" />';
                            // end qr code *********************
                            
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td class="desc" style="width:72pt;"><b>NO K/P</b></td>
                        <td class="desc" style="width:15pt;"><b>:</b></td>
                        <td class="desc" colspan="6"><b><?=$value->stu_mykad?></b></td>
                    </tr>     
                    <tr>
                        <td class="desc" style="width:72pt;"><b>ANGKA GILIRAN</b></td>
                        <td class="desc" style="width:15pt;"><b>:</b></td>
                        <td class="desc" style="width:148pt;" colspan="6"><b><?=$value->stu_matric_no?></b></td>
                    </tr>
                    <tr>
                        <td class="desc" style="width:72pt;"><b>INSTITUSI</b></td>
                        <td class="desc" style="width:15pt;"><b>:</b></td>
                        <td class="desc" style="width:148pt;" colspan="6"><b>
                            <?=strtoupper($value->col_name)?></b>
                        </td>
                    </tr>
                    <tr>
                        <td class="desc" style="width:72pt;"><b>KLUSTER</b></td>
                        <td class="desc" style="width:15pt;"><b>:</b></td>
                        <td class="desc" colspan="6"><b><?=
                        strtoupper($value->cou_cluster)?></b></td>
                    </tr>
                    <tr>
                        <td class="desc" style="width:72pt;"><b>KURSUS</b></td>
                        <td class="desc" style="width:15pt;"><b>:</b></td>
                        <td class="desc" style="width:148pt;" colspan="6"><b><?=
                        strtoupper($value->cou_name)?></b></td>
                    </tr>
                    <tr>
                        <td style="width:148pt;" colspan="9">&nbsp;</td>
                    </tr>
                </table>
            </td>               
        </tr>
<!-- end of header part -------------------------------- -->
        <tr>
          <td>
            <!-- subject list part --------------------------------- -->
            <table width="100%" cellpadding=0 cellspacing=0 border=0 class="slip">
              <tr>
                    <td class="colheader" width="6%"><b>KOD</b></td>
                    <td class="colheader" width="41" style="text-align: left;"><b>MATA PELAJARAN/MODUL</b></td>
                    <td class="colheader" width="8%" align="center"><b>JAM KREDIT</b></td>
                    <td class="colheader" width="8%" align="center"><b>GRED</b></td>
                    
                    <td class="colheader" width="7%" align="center"><b>NILAI GRED</b></td>
                    <td class="colheader" width="7%" align="center"><b>NILAI MATA</b></td>
                    <td class="colheader" width="27%" align="left"><b><?=nbs(4)?>PENCAPAIAN/<br/><?=nbs(4)?>TAHAP KOMPETENSI</b></td>
              </tr>
              <?php
              
            
     
           $gred=explode(',',$value->greds);
           $subjek=explode(',',$value->subjek);
           $kod_subjek=explode(',',$value->kod_subjek);
           $kredit=explode(',',$value->kredit);
             $nilaigred=explode(',',$value->nilaigred);
             $level_gred=explode(',',$value->level_gred);
             $aStudentId=explode(',',$value->student_id);
			 $examStatus=explode(',',$value->examstatus);
			 $modType=explode(',',$value->modtype);
			 
             
             $aNilaiMata = array();
             $aNilaiMataKv = array();
             $aJumJamKv = array();
             $aJumJam = array();
             //akademik
              $aNilaiMataKa = array();
              $aJumJamKa = array();
			  $aMataKvall= array();
              $aMataKaall= array();
			  $aNilaiMataKeselurahan= array();
			  $kreditolak= array();
			  $kreditolakVK=array();
			  $kreditolakAK=array();
              $studentId = '';
              
                    foreach ($kod_subjek as $key => $row) {
                        
						//if($examStatus[$key]!=2){
						
                $gd_id=($gred[$key]=="0"?'-':$gred[$key]);  
                $ng=($nilaigred[$key]=="0"?'-':$nilaigred[$key]);   
                $lvgd=($level_gred[$key]=="0"?'-':$level_gred[$key]);   
                
                $studentId = $aStudentId[$key];
                
                $nilaMata=$kredit[$key]*$ng;
                //tambah nilai mata
                if($examStatus[$key]!=2){
                
                $aNilaiMata[] = $nilaMata;
                $aJumJam[] = $kredit[$key];
				
				 $aNilaiMataKeselurahan[] = $nilaMata;
				
				
                
                if($modType[$key] == 'VK')
                {
                    $aNilaiMataKv[] = $nilaMata;
                    $aJumJamKv[] = $kredit[$key];
					 $aMataKvall[]= $nilaMata;
                }else{
                    
                    $aNilaiMataKa[] = $nilaMata;
                    $aJumJamKa[] = $kredit[$key];
					 $aMataKaall[] = $nilaMata;
                }
				
				
				
                
				}else{
			
		        $subPast= $this->m_result->get_repeat_subject_past($studentId,$row);
				
					if( $nilaigred[$key] > $subPast[0]->grade_value){
							
						$nilaMata_old=$subPast[0]->mod_credit_hour*$subPast[0]->grade_value;
						
						 $aNilaiMataKeselurahan[] = $nilaMata-$nilaMata_old;
						 $kreditolak[]=-$subPast[0]->mod_credit_hour;
						 
			  if($modType[$key] == 'VK')
                {
                	
                    $aMataKvall[] = $nilaMata-$nilaMata_old;
					 $kreditolakVK[]=-$subPast[0]->mod_credit_hour;
                    
                }else{
                    
                    $aMataKaall[] = $nilaMata-$nilaMata_old;
					 $kreditolakAK[]=-$subPast[0]->mod_credit_hour;
                 
                }
				
	
					}	
				}
  
      if($examStatus[$key]!=2){
                     
                 ?>
                    <tr>
                        <td class="desc" ><?= $row ?></td>
                        <td class="desc" ><?= $subjek[$key] ?></td>
                        <td class="desc" align="center"><?=$kredit[$key]?></td>
                        <td class="desc" align="left"><?=nbs(5)?><?=$gd_id?></td>
                       
                        <td class="desc" align="center"><?=$ng?></td></td>
                        <td class="desc" align="center"><?=number_format($nilaMata,2)?></td>
                        <td class="desc" align="left"><?=nbs(4)?><?=$lvgd?></td></td></td>
                    </tr>
                 <?php
	  }
                    }
                 ?>
            </table>
          </td>
        </tr>
<!-- end of subject list part -------------------------- -->
<?php



     $pevsem=$value->mt_semester-1;
   
    $curResult = $this->m_result->resultBySemYearStudent($value->mt_semester, $value->mt_year, $studentId);
    $Resultsem = $this->m_result->resultBySemYearStudent($pevsem, $year='',$studentId);
   // $Resultsem = $this->m_result->get_kredit($studentId);
      if(!empty($curResult))
    {
        $pngv = $curResult[0]->pngv;
        $pngkv = $curResult[0]->pngkv;
        $pngk = $curResult[0]->pngk;
        $pngkk = $curResult[0]->pngkk;
        $pnga = $curResult[0]->pnga;
        $pngka = $curResult[0]->pngka;
        
        
       
    }
    else{

   
    $stuId = $value->stu_id;
	
//print_r($kreditolak);
 
      //  if($status!=2){
      	//untuk semasa 
        $jumMata = array_sum($aNilaiMata);
        $jumJam = array_sum($aJumJam);
		
		//utk kesluruhan
		$jumMatarepeat= array_sum($aNilaiMataKeselurahan);
        
        $curGpa = sprintf("%.2f",$jumMata/$jumJam);
        
		//untuk kesluruhan
		$jumMataKvtotal=array_sum($aMataKvall);
		//untuk semasa
        $jumMataKv = array_sum($aNilaiMataKv);
        $jumJamKv = array_sum($aJumJamKv);
        
        $curGpaKv = sprintf("%.2f",$jumMataKv/$jumJamKv);
        
        //akdemik
        //unruk all
        
        $jumMataKatotal = array_sum($aMataKaall);
        //untuk semasa
        $jumMataKa = array_sum($aNilaiMataKa);
        $jumJamKa = array_sum($aJumJamKa);
        
        
        
        $curGpaKaa = sprintf("%.2f",$jumMataKa/$jumJamKa);
        
        $pngv = $curGpaKv;
        $pngkv = $curGpaKv;
        $pngk = $curGpa;
        $pngkk = $curGpa;
        $pnga = $curGpaKaa;
        $pngka = $curGpaKaa;
         $pointavk =$jumMataKv;
         $pointaak = $jumMataKa;
         $pointav = $jumMata;
        
        if(!empty($Resultsem)){
           
            
        $pointer_ak = $Resultsem[0]->pointer_ak;
        $pointer_vk = $Resultsem[0]->pointer_vk;
        $pointer_value = $Resultsem[0]->pointer_value;
       
       $pointavk =$jumMataKvtotal+$pointer_vk;
       $pointaak = $jumMataKatotal+$pointer_ak;
       $pointav = $jumMatarepeat+$pointer_value;
       
      // kredit all termasuk mengulan
        $kredit_ak= $this->m_result->get_kredit($studentId,$modtype="AK",$value->mt_semester);
        $kredit_vk= $this->m_result->get_kredit($studentId,$modtype="VK",$value->mt_semester);
        $kredit_all= $this->m_result->get_kredit($studentId,$modtype="",$value->mt_semester);
  
   
      //kredit all tolak denga kredit mengulan
      
      $clearkreditAll=$kredit_all[0]->kreditot - array_sum($kreditolak);
      
	   $clearkreditAK=$kredit_ak[0]->kreditot  -array_sum($kreditolakAK);
      
      $clearkreditVK= $kredit_vk[0]->kreditot  -array_sum($kreditolakVK);
      
       $pngkk=round($pointav/$clearkreditAll,2);
       $pngka=round($pointaak/$clearkreditAK,2);
       $pngkv=round($pointavk/$clearkreditVK,2);
      
        }
        
        $dataResult = array(
                        "semester_count" => $value->mt_semester,
                        "current_year" => $value->mt_year,
                        "pngv" => $pngv,
                        "pngkv" => $pngkv,
                        "pngk" => $pngk,
                        "pngkk" => $pngkk,
                        "stu_id" => $studentId,
                        "pnga" => $pnga,
                        "pngka" => $pngka,
                        "pointer_ak"=>$pointaak,
                        "pointer_vk"=>$pointavk,
                        "pointer_value"=>$pointav
                      );
    
        $curResult = $this->m_result->addResult($dataResult);
        }
   ?>
<!-- footer part --------------------------------------- -->
<tr height="50pt">&nbsp;</tr>
        <tr>
            <td>
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr>
                        <td class="descxsitalic" colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="colheader" colspan="2">PURATA NILAI GRED BAHASA MELAYU  (PNGBM)</td>
                        <td class="colheader" width="3%" align="center">:</td>
                        <td class="colheader" width="51%" align="left"><?=number_format(get_png_bm($value->stu_matric_no,$value->mt_semester),2)?></td>
                    </tr>
                    <tr>
                        <td class="colheader" colspan="2" width="60%">PURATA NILAI GRED KUMULATIF BAHASA MELAYU (PNGKBM)</td>
                        <td class="colheader" align="center">:</td>
                        <td class="colheader" align="left"><?=number_format(get_pngk_bm($value->stu_matric_no,$value->mt_semester),2)?></td>
                    </tr>
                    <tr>
                        <td class="colheader" colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="colheader" colspan="2">PURATA NILAI GRED AKADEMIK  (PNGA)</td>
                        <td class="colheader" align="center">:</td>
                        <td class="colheader" width="51%" align="left"><?=number_format($pnga,2)?></td>
                    </tr>
                    <tr>
                        <td class="colheader" colspan="2">PURATA NILAI GRED KUMULATIF AKADEMIK (PNGKA)</td>
                        <td class="colheader" align="center">:</td>
                        <td class="colheader" align="left"><?=number_format($pngka,2)?></td>
                    </tr>
                    <tr>
                        <td class="colheader" colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="colheader" colspan="2">PURATA NILAI GRED VOKASIONAL (PNGV)</td>
                        <td class="colheader" width="3%" align="center">:</td>
                        <td class="colheader" width="51%" align="left"><?=number_format($pngv,2)?></td>
                    </tr>
                    <tr>
                        <td class="colheader" colspan="2">PURATA NILAI GRED KUMULATIF VOKASIONAL (PNGKV)</td>
                        <td class="colheader" align="center">:</td>
                        <td class="colheader" align="left"><?=number_format($pngkv,2)?></td>
                    </tr>
                    <tr>
                        <td class="colheader" colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="colheader" colspan="2">PURATA NILAI GRED KESELURUHAN (PNGK)</td>
                        <td class="colheader" align="center">:</td>
                        <td class="colheader" align="left"><?=number_format($pngk,2)?></td>
                    </tr>
                    <tr>
                        <td class="colheader" colspan="2">PURATA NILAI GRED KUMULATIF KESELURUHAN (PNGKK)</td>
                        <td class="colheader" align="center">:</td>
                        <td class="colheader" align="left" ><?=number_format($pngkk,2)?></td>
                    </tr>
                    <tr>
                        <td class="descxsitalic" colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
                        <td class="descxsitalic" colspan="4">&nbsp;</td>
                    </tr>
                 </table>
              </td>
            </tr>
            <tr id='printheight' >&nbsp;</tr>
<!-- end of footer part -------------------------------- -->
<tr>
    <td>
    <table style="width:450pt;">
        <tr>
                <td class="desc" >Tarikh:<?php
                								$d = date('d');
                								$m = date('m');
                								$y = date('Y');
                								
                								$month = getMonthInMalay($m);
                								
                								echo $d.' '.$month.' '.$y;
                						 ?>
                </td>
                <td class="colheader" style="text-align: right;">PENGARAH PEPERIKSAAN</td>
            </tr>
            <tr>
                <td class="descxsitalic" colspan="4" style="height:60pt; width: 100%;"><center>slip ini adalah cetakan komputer,tandatangan tidak diperlukan</center></td>
            </tr>
    </table> 
    </td>
  </tr>         
</table>
</div>
         <span style="page-break-before: always"></span>  
<?php
    }
    }else{
        echo "Tiada Maklumat";
    }
?>
</body>