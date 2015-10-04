<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Examination Result Slip</title>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.js"></script>
<STYLE TYPE="text/css">
     P.breakhere {page-break-before: always}
     body		{font-size: 8pt;font-family:arial;}
	.header		{font-size:9pt;font-weight:bold;}
	.colheader	{font-size:8pt;font-weight:bold;padding-left:2pt;padding-right:2pt;}
	.subheader	{font-size:8pt;font-weight:bold;padding-left:2pt;padding-right:2pt;}
	.desc		{font-size:8pt;padding-left:2pt;padding-right:2pt;}
	.descbold	{font-size:8pt;padding-left:2pt;padding-right:2pt;font-weight:bold;height:10pt;}
	.descs		{font-size:7pt;padding-left:2pt;padding-right:2pt;}
	.descsbold	{font-size:7pt;padding-left:2pt;padding-right:2pt;font-weight:bold;}
	.descxsitalic	{font-size:7pt;padding-left:2pt;padding-right:2pt;font-style:italic}
	.amaun		{font-size:8pt;text-align:right;padding-left:2pt;padding-right:2pt;}
	.total		{font-size:8pt;text-align:right;font-weight:bold;padding-left:2pt;padding-right:2pt;}
	.grandtotal	{font-size:8pt;text-align:right;font-weight:bold;padding-left:2pt;padding-right:2pt;border-top:2px #000000 solid;border-bottom:5px #000000 double;}
	.linetop	{font-size:8pt;font-weight:bold;border-top:2px #000000 solid;padding-left:2pt;padding-right:2pt;}
	.linebottom	{font-size:8pt;font-weight:bold;border-bottom:2px #000000 solid;padding-left:2pt;padding-right:2pt;}
	
	.BG {
			background-image:url(../../../assets/img/bg_result.png);
			background-repeat:no-repeat;/*dont know if you want this to repeat, ur choice.*/
			height:10%;
			width:10%
		}

</STYLE>
<script language="javascript" type="text/javascript">
	function printpage()
  	{
  		window.print()
  	}

	function getw()
	{	
		var centreCode 	= $('#hkodpusat').val();
		var year 		= $('#hmt_year').val();
		var course 		= $('#hslct_kursus').val();
		var semester 	= $('#hsemester').val();

        window.location.href = 'export_xls_fik'+'?ckod='+centreCode+'&kursus='+course+'&semtr='+semester+'&tahun='+year;
	}

  
</script>

<?php /* <input type="button" value="Cetak" onclick="printpage()"> */?>

</head>
<body>
<?php
if(!empty($student))
{
?>

<input type="hidden" id="hkodpusat" name="hkodpusat" value="<?= $hkodkolej ?>">
<input type="hidden" id="hslct_kursus" name="hslct_kursus" value="<?= $hkursus ?>">
<input type="hidden" id="hsemester" name="hsemester" value="<?= $hsemester ?>">
<input type="hidden" id="hmt_year" name="hmt_year" value="<?= $htahun ?>">

<a href="javascript:void(0);" class="btn btn-primary" onclick="getw()">Ekspot Excel</a>    
    
    <h2>Fail Induk Keputusan</h2>

        	
          	<table width="100%" cellpadding=0 cellspacing=0 border=1  id="tablefin">
          <thead>
            <tr>
                <th class="desc" width="" id="tdleft" align="center">Bil</a></th>
                <th class="desc" width="" align="center">NAMA CALON</th>
		<th class="desc" width="" id="tdright" align="center">MYKAD</th>
                <th class="desc" width="1" id="tdright" align="center">ANGKA GILIRAN</th>
                <th class="desc" width="" id="tdright" align="center">KOD KURSUS</th>
                <th class="desc" width="" id="tdright" align="center">JANTINA</th>
                <th class="desc" width="" id="tdright" align="center">KAUM</th>
                <th class="desc" width="" id="tdright" align="center">AGAMA</th>
                
                
                <?php
               $arysubb=array();
                $sucount=$student[0]->count_subj;
				foreach ($student as $stuk) {
				$kod_subjekk=explode(',',$stuk->kod_subjek);
				foreach ($kod_subjekk as $keyk => $rowk) {
				
				 		array_push($arysubb,$keyk);
					
				}
				$uniqcodesub=array_unique($arysubb);
				$countsubj=count($uniqcodesub);
				}
				
                for ($i=1; $i<=$countsubj; $i++){
                		?>
                	       <th class="desc" width="" align="center">KOD_MP<?=$i?></th>
		<th class="desc" width="" id="tdright" align="center">NAMA_MP<?=$i?></th>
                <th class="desc" width="" id="tdright" align="center">JK_MP<?=$i?></th>
                <th class="desc" width="" id="tdright" align="center">GRED_MP<?=$i?></th>
                <th class="desc" width="" id="tdright" align="center">NM_MP<?=$i?></th>
                <th class="desc" width="" id="tdright" align="center">MK_MP<?=$i?></th>
                <th class="desc" width="" id="tdright" align="center">STATUS_MP<?=$i?></th>
                <?php
                }
                ?>
             
                            	       <th class="desc" width="" align="center">PNG</th>
		<th class="desc" width="" id="tdright" align="center">PNGK</th>
                <th class="desc" width="" id="tdright" align="center">PNG_VOK</th>
                <th class="desc" width="" id="tdright" align="center">PNGK_VOK</th>
                <th class="desc" width="" id="tdright" align="center">JUM MP</th>
                <th class="desc" width="" id="tdright" align="center">JUM JK</th>
                <th class="desc" width="" id="tdright" align="center">JUM NM</th>
                <th class="desc" width="" id="tdright" align="center">STATUS</th>
            </tr>
        </thead>
        	<?php 
              	$bil=0;
				
				$tempCC="";
				$nilaMatatot=0;
				 $arysub=array();
              	foreach ($student as $stu) {
              		
					  if($tempCC !=$stu->cou_id && $tempCC!="")
					   {
					   	$bil = 0;
						
					   }
					  $bil++;
					
			
              	?>
              	 <tr>
              	<td width="3%" align="center" class="desc"><?=$bil?></td>
                <td width="20%" align="left" class="desc" ><?=ucwords($stu->stu_name)?></td>
                <td width="20%" align="left" class="desc" ><?=$stu->stu_mykad?></td>
                <td width="6%" align="left" class="desc"><?=$stu->stu_matric_no?></td>
                <td width="6%" align="left" class="desc"><?=$stu->cou_course_code?></td>
                <td width="6%" align="left" class="desc"><?=$stu->stu_gender?></td>
                <td width="6%" align="left" class="desc"><?=$stu->stu_race?></td>
                <td width="6%" align="left" class="desc"><?=$stu->stu_religion?></td>
                   <?php
                  
             $gred=explode(',',$stu->greds);
			 $subjek=explode(',',$stu->subjek);
			 $kod_subjek=explode(',',$stu->kod_subjek);
			 $kredit=explode(',',$stu->kredit);
			 $nilaigred=explode(',',$stu->nilaigred);
			 $level_gred=explode(',',$stu->level_gred);
                
				
              	 	foreach ($kod_subjek as $key => $row) {
				 		//array_push($arysub,$key);
						
						
				$subjectcode[$key]=$row;
				$gd_id=($gred[$key]=="0"?'-':$gred[$key]);	
				$ng=($nilaigred[$key]=="0"?'-':$nilaigred[$key]);	
				$lvgd=($level_gred[$key]=="0"?'-':$level_gred[$key]);	
				
				$nilaMata=$kredit[$key]*$ng;
				
					$nilaMatatot+= $nilaMata;
					}
					
					for ($p=0; $p<$countsubj; $p++){
						$nilaMata=$kredit[$p]*$nilaigred[$p];
				 ?>
        			
                        <td class="desc" ><?= empty($subjectcode[$p])?'-':$subjectcode[$p] ?></td>
                        <td class="desc" ><?= empty($subjek[$p])?'-':$subjek[$p] ?></td>
                        <td class="desc" align="center"><?=empty($kredit[$p])?"-":$kredit[$p]?></td>
                        <td class="desc" align="center"><?=empty($gred[$p])?"-":$gred[$p]?></td>
                         <td class="desc" align="center"><?=empty($nilaigred[$p])?'-':$nilaigred[$p]?></td></td>
                        <td class="desc" align="center"><?=number_format($nilaMata,2)?></td>
                        <td class="desc" align="center"><?=empty($level_gred[$p])?'-':$level_gred[$p]?></td></td></td>
        	  		
                 <?php
                 $nilaMata=0;
				 $subjectcode[$p]='';
					}
				 ?>
                           <td class="desc" width="" align="center"><?=$stu->pngk?></th>
		<td class="desc" width="" id="tdright" align="center"><?=$stu->pngkk?></th>
                <td class="desc" width="" id="tdright" align="center"><?=$stu->pngv?></td>
                <td class="desc" width="" id="tdright" align="center"><?=$stu->pngkv?></td>
                <td class="desc" width="" id="tdright" align="center"><?=$sucount?></td>
                <td class="desc" width="" id="tdright" align="center"><?=$stu->sumcredit?></td>
                <td class="desc" width="" id="tdright" align="center"><?=$nilaMatatot?></td>
                <td class="desc" width="" id="tdright" align="center">1</td>
               <?php
                $tempCC = $stu->cou_id;
				 
					
               }
              
					
               ?>
     <spa
        </tr>
        
            
            </table>
       
       
<?php
	
	}else{
		echo "Tiada Maklumat";
	}
?>
</body>