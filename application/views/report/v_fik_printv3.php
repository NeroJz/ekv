<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Examination Result Slip</title>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/FixedColumns.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/FixedHeader.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.dataTables.js"></script>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/smoothness/demo_table_jui.css" media="screen" />
<STYLE TYPE="text/css" media="print">
    P.breakhere {
        page-break-before: always
    }
    body {
        font-size: 8pt;
        font-family: arial;
    }
    .header {
        font-size: 9pt;
        font-weight: bold;
    }
    .colheader {
        font-size: 8pt;
        font-weight: bold;
        padding-left: 2pt;
        padding-right: 2pt;
    }
    .subheader {
        font-size: 8pt;
        font-weight: bold;
        padding-left: 2pt;
        padding-right: 2pt;
    }
    .desc {
        font-size: 8pt;
        padding-left: 2pt;
        padding-right: 2pt;
    }
    .descbold {
        font-size: 8pt;
        padding-left: 2pt;
        padding-right: 2pt;
        font-weight: bold;
        height: 10pt;
    }
    .descs {
        font-size: 7pt;
        padding-left: 2pt;
        padding-right: 2pt;
    }
    .descsbold {
        font-size: 7pt;
        padding-left: 2pt;
        padding-right: 2pt;
        font-weight: bold;
    }
    .descxsitalic {
        font-size: 7pt;
        padding-left: 2pt;
        padding-right: 2pt;
        font-style: italic
    }
    .amaun {
        font-size: 8pt;
        text-align: right;
        padding-left: 2pt;
        padding-right: 2pt;
    }
    .total {
        font-size: 8pt;
        text-align: right;
        font-weight: bold;
        padding-left: 2pt;
        padding-right: 2pt;
    }
    .grandtotal {
        font-size: 8pt;
        text-align: right;
        font-weight: bold;
        padding-left: 2pt;
        padding-right: 2pt;
        border-top: 2px #000000 solid;
        border-bottom: 5px #000000 double;
    }
    .linetop {
        font-size: 8pt;
        font-weight: bold;
        border-top: 2px #000000 solid;
        padding-left: 2pt;
        padding-right: 2pt;
    }
    .linebottom {
        font-size: 8pt;
        font-weight: bold;
        border-bottom: 2px #000000 solid;
        padding-left: 2pt;
        padding-right: 2pt;
    }

    .BG {
        background-image: url(../../../assets/img/bg_result.png);
        background-repeat: no-repeat;/*dont know if you want this to repeat, ur choice.*/
        height: 10%;
        width: 10%
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

<script>
	function printit() {
	document.getElementById('idPrint').style.display = 'none';
	window.print()

  // set page header
  jsPrintSetup.setOption('headerStrLeft', '');
  jsPrintSetup.setOption('headerStrCenter', '');
  jsPrintSetup.setOption('headerStrRight', '');
  // set empty page footer
  jsPrintSetup.setOption('footerStrLeft', '');
  jsPrintSetup.setOption('footerStrCenter', '');
  jsPrintSetup.setOption('footerStrRight', '');

	setTimeout("document.getElementById('idPrint').style.display = 'block';", 5000);
}
</script>


<script language="javascript" type="text/javascript">
    function printpage() {
        window.print()
    }

    function getw() {
        var centreCode = $('#hkodpusat').val();
        var year = $('#hmt_year').val();
        var course = $('#hslct_kursus').val();
        var semester = $('#hsemester').val();

        window.location.href = 'export_xls_fik' + '?ckod=' + centreCode + '&kursus=' + course + '&semtr=' + semester + '&tahun=' + year;
    }


    $(document).ready(function() {
        var oTable = $('#tablefin').dataTable({
            "iDisplayLength" : 100,
        });
        new FixedHeader(oTable);
    });

</script>


</head>
<body>
<?php

if(!empty($student)){

 $arrSub=array();
			   
			   
			   echo "<pre>";
			   print_r($student);
			   echo "</pre>";
			   die();
               // $sucount=$student[0]->count_subj;
				foreach ($student as $stu) {
					
					$module= $stu->moduletaken_AK;
				 	foreach($module as $mod)
					{
						if(!in_array($mod->mod_name, $arrSub))
						{
							$arrSub["$mod->mod_id"] = $mod->mod_name;
						}
						
						
					}
						
				}	
?>
        <input type="hidden" id="hkodpusat" name="hkodpusat" value="<?= $hkodkolej ?>">
<input type="hidden" id="hslct_kursus" name="hslct_kursus" value="<?= $hkursus ?>">
<input type="hidden" id="hsemester" name="hsemester" value="<?= $hsemester ?>">
<input type="hidden" id="hmt_year" name="hmt_year" value="<?= $htahun ?>">

<a href="javascript:void(0);" class="btn btn-primary" onclick="getw()">Ekspot Excel</a>   
    <h2>Fail Induk Keputusan</h2>

        	
          <table width="100%"  style="background-color: #FFFFFF;"  cellpadding=0 cellspacing=0 border=1  id="tablefin">
          <thead>
          	<tr>
          		 <th colspan="10" class="desc"  id="tdleft" align="center">FIN</a></th>
          		 <th colspan="<?=count($arrSub)?>" class="desc"  id="tdleft" align="center">PENTAKSIRAN BERTERUSAN [PB] AKADEMIK</a></th>
          	 	 <th colspan="<?=count($arrSub)?>" class="desc"  id="tdleft" align="center">PENILAIAN AKHIR [PA] AKADEMIK</a></th>
          	
          	</tr>
            <tr>
                <th class="desc"  id="tdleft" align="center">Bil</a></th>
                <th class="desc"  style="padding-right: 200px;"  align="center">NAMA CALON</th>
		        <th class="desc"  id="tdright" align="center">MYKAD</th>
                <th class="desc"  id="tdright" align="center">ANGKA GILIRAN</th>
                <th class="desc"  id="tdright" align="center">KOD KURSUS</th>
                <th class="desc"  id="tdright" align="center">JANTINA</th>
                <th class="desc"  id="tdright" align="center">STATUS</th>
                <th class="desc"  id="tdright" align="center">KAUM</th>
                <th class="desc"  id="tdright" align="center">AGAMA</th>
                <th class="desc"  id="tdright" align="center">KOLEJ VOKASIONAL</th>


                <?php
              
			
				foreach($arrSub as $subj)
				{
					
					echo "<th class='desc' align='center'>$subj(100)</th>";
		      		
					
				}
				 
				?>
               
          		
          		<th class="desc" width="" align="center">PNG</th>
				<th class="desc"  id="tdright" align="center">PNGK</th>
                <th class="desc"  id="tdright" align="center">PNG_VOK</th>
                <th class="desc"  id="tdright" align="center">PNGK_VOK</th>
                <th class="desc"  id="tdright" align="center">PNG_AK</th>
                <th class="desc"  id="tdright" align="center">PNGK_AK</th>
                <th class="desc"  id="tdright" align="center">JUM MP</th>
                <th class="desc" id="tdright" align="center">JUM JK</th>
                <th class="desc"  id="tdright" align="center">JUM NM</th>
               
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
              	<td  align="center" class="desc"><?=$bil?></td>
                <td  align="left" class="desc" ><?=ucwords($stu->stu_name)?></td>
                <td  align="left" class="desc" ><?=$stu->stu_mykad?></td>
                <td  align="left" class="desc"><?=$stu->stu_matric_no?></td>
                <td  align="left" class="desc"><?=$stu->cou_course_code?></td>
                <td  align="left" class="desc"><?=$stu->stu_gender?></td>
                <td  align="center" class="desc" id="tdright"><?=$stu->stat_id?></td>
                <td  align="left" class="desc"><?=$stu->stu_race?></td>
                <td  align="left" class="desc"><?=$stu->stu_religion?></td>
                <td  align="left" class="desc"><?=$stu->col_name?></td>
                   <?php
                  
          
					$credittotal=0;
					$nilaMata=0;
					$jummod=0;
					$nilaMatatot=0;
					$billmodl=0;
					foreach ($stu->moduletaken as $value) {
            $billmodl++;
            $jummod++;
            $credittotal+=$value->mod_credit_hour;

            $nilaMata=$value->mod_credit_hour*$value->grade_value;
            $nilaMatatot+=$nilaMata;

            $d['mod_paper'][$billmodl]=$value->mod_paper;
            $d['mod_name'][$billmodl]=$value->mod_name ;
            $d['mod_credit_hour'][$billmodl]=$value->mod_credit_hour;
            $d['grade_type'][$billmodl]=$value->grade_type;
            $d['grade_value'][$billmodl]=$value->grade_value;
            $d['grade_level'][$billmodl]=$value->grade_level;
            $nilaMa[$billmodl]=$nilaMata;


				 ?>
        			
                      
        	  		
                 <?php $nilaMata = 0;
                        // $subjectcode[$p]='';
                        }

                        for ($t=1; $t<=($uniqcodesub[0]); $t++){
				 ?>

  						<td class="desc" ><?=  empty($d['mod_paper'][$t])?'-':$d['mod_paper'][$t] ?></td>
                        <td class="desc" ><?= empty($d['mod_name'][$t])?'-':$d['mod_name'][$t]?></td>
                        <td class="desc" align="center"><?=empty($d['mod_credit_hour'][$t])?'-':$d['mod_credit_hour'][$t]?></td>
                        <td class="desc" align="center"><?= empty($d['grade_type'][$t])?'-':$d['grade_type'][$t]?></td>
                        <td class="desc" align="center"><?=empty($d['grade_value'][$t])?'-':$d['grade_value'][$t]?></td></td>
                        <td class="desc" align="center"><?=empty($nilaMa[$t])?'-':$nilaMa[$t]?></td>
                        <td class="desc" align="center"><?=empty($d['grade_level'][$t])?'-':$d['grade_level'][$t]?></td></td></td>



<?php $d['mod_credit_hour'][$t] = '';
    $d['mod_name'][$t] = '';
    $d['mod_paper'][$t] = '';
    $d['grade_type'][$t] = '';
    $d['grade_value'][$t] = '';
    $d['grade_level'][$t] = '';
    $nilaMa[$t] = '';

    }
?>
 
                <td class="desc" width="" align="center"><?=$stu->pngk?></td>
				<td class="desc"  id="tdright" align="center"><?=$stu->pngkk?></td>
                <td class="desc" id="tdright" align="center"><?=$stu->pngv?></td>
                <td class="desc"  id="tdright" align="center"><?=$stu->pngkv?></td>
                <td class="desc" id="tdright" align="center"><?=$stu->pnga?></td>
                <td class="desc"  id="tdright" align="center"><?=$stu->pngka?></td>
                <td class="desc"  id="tdright" align="center"><?=$jummod?></td>
                <td class="desc"  id="tdright" align="center"><?=$credittotal?></td>
                <td class="desc"  id="tdright" align="center"><?=$nilaMatatot?></td>
                
               <?php $tempCC = $stu -> cou_id;

                    }
               ?>
    
        </tr>
        
            
            </table>
       
       
<?php

}else{
echo "Tiada Maklumat";
}
?>
</body>