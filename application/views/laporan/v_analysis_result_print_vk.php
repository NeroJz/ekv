<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?=base_url()?>assets/js/highcharts.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/js/exporting.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/js/themes/grid.js" type="text/javascript"></script>

<STYLE TYPE="text/css" media="print">
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





<script>
	function printit()
	{
		document.getElementById('idPrint').style.display = 'none';
		window.print()
		setTimeout("document.getElementById('idPrint').style.display = 'block';", 5000);
	}
</script>
<?php
if(isset($student) && !empty($student))
{
	echo('<input id="idPrint" name="idPrint" type="button"  value="Cetak Laporan" onClick="printit()">');
?>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<!-- header part -------------------------------------- -->
	<tr>
		<td>
			<table width="100%" cellpadding=0 cellspacing=0 border=0>
				<tr>
					<td colspan=7 align="center" style="height:60pt;">
						<span class="descbold">
							LEMBAGA PEPERIKSAAN<br>
                            KEMENTERIAN PENDIDIKAN MALAYSIA<br>
                            ANALISIS KEPUTUSAN VOKASIONAL 
                        </span><br><br>
                    </td>
				</tr>
				<tr>
					<td width="50" class="descc">&nbsp;</td>
					<td width="96" class="descc" style="width:72pt;">NO. PUSAT</td>
					<td width="32" class="descc" style="width:15pt;">:</td>
					<td width="542" class="descc" colspan="2"><?=$student[0]->col_type." ".$student[0]->col_code?></td>
				</tr>
				<tr>
					<td>&nbsp;</td>
					<td style="width:72pt;" class="descc">KURSUS</td>
					<td style="width:15pt;" class="descc">:</td>
					<td colspan="2" class="descc"><?=$student[0]->cou_name?></td>
				</tr>
				<tr>
					<td colspan="4" class="descc">&nbsp;</td>
				</tr>
			</table>
		</td>
	</tr>
	<tr>
		<td>
			<table width="100%" cellpadding=0 cellspacing=0 border=1 >
				<tr>
	              	<td width="3%" align="center" class="desc"><b>BIL</b></td>
	                <td width="20%" align="center" class="desc"><b>NAMA</b></td>
	                <td width="6%" align="center" class="desc"><b>ANGKA GILIRAN</b></td>
	                <td width="6%" align="center" class="desc"><b>STATUS</b></td>
	                <?php
	                $arycount=array();
	                foreach ($student as $stu)
                    {
                         if(!empty($stu->result)){
	               $arry= count($stu->result);
                    array_push($arycount,$arry);
       
                    }
                    }
                   $aruniq= array_unique($arycount);
                    arsort($aruniq);
                    
              for ($consem=1; $consem <=$aruniq[0] ; $consem++) { 
                  
              
              
	                ?>
	                
                	
                     		<td width="4%" align="center" class="desc"><b>SEMESTER <?=$consem?></b></td>
                  
                 <?php } ?>   
                  	<td width="4%" align="center" class="desc"><b>PNGKV</b></td>
			   </tr>
			   <?php 
	              	$bill=0;
					$db=array();
					
					foreach ($student as $stu)
					{
					  	$bill++;
				  
              ?>
              			<tr>
		              		<td width="3%" align="center" class="desc"><?=$bill?></td>
		              		<td width="20%" align="left" class="desc" ><?=nbs(1)?><?=strtoupper($stu->stu_name)?></td>
		              		<td width="6%" align="center" class="desc"><?=$stu->stu_matric_no?></td>
		              		<td width="6%" align="center" class="desc"><?=$stu->stat_id?></td>
              <?php
		              //  $semm=count($stu->result);
				
                if(!empty($stu->result)){
				 		foreach ($stu->result as  $row)
						{
                	
                            $pngv[$row->semester_count] =$row->pngv;
                            $pngkv =$row->pngkv;
		                	
					
							//echo $key."=".$kredit[$key];
		             	}
                }
                
                
			
		             	
						for ($i=1; $i<=$aruniq[0]; $i++)
						{
							
							
		        ?>
		                 	<td width="6%" align="right" class="desc"><?= empty($pngv[$i])?0:$pngv[$i] ?><?=nbs(1)?></td>
		        <?php   
		                 	//$v[$kodarc]='';
		                 	$pngv[$i]=0;
               
						}
			
                ?>
            				<td width="6%" align="right" class="desc"><?=number_format($pngkv,2)?><?=nbs(1)?></td>                 
                		</tr>
				<?php
					//	$cgpa=$totall/$stu->totalcredit;
						$cgpa2=number_format($pngkv,2);
						array_push($db,$cgpa2);
					 $pngkv=0;
					}
               ?>
			</table>
		</td>
	</tr>
	<tr>
		<td class="descxsitalic" colspan="4" style="height:60pt;">&nbsp;</td>
	</tr>
</table>                
<div id="chart_container" align="center" style="width: 50%;">
</div>
<?php

	$acv=array_count_values($db);
	ksort($acv);
 	$totalarray=count($db);
 	$valuacv="";
    
    $total01=0;
    $total02=0;
    $total03=0;
    $total04=0;
    $total05=0;
    $total06=0;
    $total07=0;
   
   
	
	foreach($acv as $keyy => $rowacv)
	{
		//print_r(" ");
		
		$bitol[$keyy]=$rowacv;
		$valuacv.=(round(($rowacv/$totalarray)*100)).",";
        
        if($keyy>=0 && $keyy<=1){
            $total01+=$rowacv;        
            
        }elseif($keyy>1 && $keyy<=1.5){
            $total02+=$rowacv;
            
        }elseif($keyy>1.5 && $keyy<=2){
            
            $total03+=$rowacv;
            
        }elseif($keyy>2 && $keyy<=2.5){
            
            $total04+=$rowacv;
           
        }elseif($keyy>2.5 && $keyy<=3){
            
            $total05+=$rowacv;
          
        }elseif($keyy>3 && $keyy<=3.5){
            
            $total06+=$rowacv;
           
        }elseif($keyy>3.5 && $keyy<=4){
            
            $total07+=$rowacv;
        }
        
        
	}
	
	
   	$nila=$total01.','.$total02.','.$total03.','.$total04.','.$total05.','.$total06.','.$total07;
    $nilabar="'0-1'".','."'1-1.5'".','."'1.6-2'".','."'2.01-2.5'".','."'2.56-3.00'".','."'3.01-3.50'".','."'3.51-4.00'";
    
	$json_bil=json_encode($bitol);
	
	$dbuniq=array_unique($db);
	asort($dbuniq);
	$valu="";

	foreach($dbuniq as $row)
	{
		$valu.=$row.",";
	}
    
   
?>


<script>
 $(function () {
        $('#chart_container').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Bilangan Murid Mengikut PNGKV '
            },
            subtitle: {
                text: ''
            },
            xAxis: {
               categories: [<?=$nilabar?>]
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Bilangan'
                }
            },
            tooltip: {
                headerFormat: '<span style="font-size:10px"><b>{point.key}<b></span><table>',
                pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                    '<td style="padding:0">{point.y} </td></tr>',
                footerFormat: '</table>',
                shared: true,
                useHTML: true
            },
            plotOptions: {
                column: {
                    pointPadding: 0.2,
                    borderWidth: 0
                }
            },
             series: [{
                name: 'Murid',
                data: [<?=$nila?>],
            }]
        });
    });
 
 </script>
 
<?php
}
else
{
    echo "Tiada Maklumat";
}

