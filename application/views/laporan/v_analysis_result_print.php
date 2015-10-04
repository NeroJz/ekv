<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/print_setting.js"></script>
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

<script type="text/javascript">
  //parameter untuk set jsPrintSetup option
  var jspOptions = [];

  //jika ada perubahan/penambahan guna push sebab saya pakai json
  //contoh option yang ada boleh rujuk kat sini : https://addons.mozilla.org/en-US/firefox/addon/js-print-setup/‎
  //ni example : 
  //jspOptions.push({'id':"headerStrLeft",'val':'sukor'});

</script>

<?php
if(isset($student) && !empty($student))
{
	echo('<input id="idPrint" name="idPrint" type="button"  value="Cetak Laporan" onClick="printit(jspOptions)">');
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
                            ANALISIS KEPUTUSAN MENGIKUT SUBJEK AKADEMIK
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
            			$kodmer=array();
            			
						foreach ($student as $row) 
						{
							//$data[$row->mod_paper]=$row->mod_paper;				
					
							$kod=explode(',',$row->kod_subjek);
							foreach($kod as $kodcode)
							{								
								array_push($kodmer,$kodcode);
							}
						}
					
						$koduniq=array_unique($kodmer);
						$bikod=0;
						
						foreach($koduniq as $ckey=>$k)
						{
							$bikod++;
							$kodarry[$bikod]=$k;
                    ?>
                     		<td width="4%" align="center" class="desc"><b><?=$k?></b></td>
                    <?php
						}			
                	?>
                  	<td width="4%" align="center" class="desc"><b>PNGK</b></td>
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
		                $grdv=explode(',',$stu->nilaigred);
		                $sem=explode(',',$stu->semester);
						$kod_subjek=explode(',',$stu->kod_subjek);
						$kredit=explode(',',$stu->kredit);
					
						$kreditvalue=0;
						$totall=0;
						//print_r($kod_subjek);
				
				 		foreach ($kod_subjek as  $key=>$value)
						{
                	
		                	$kreditvalue+=$kredit[$key]*$grdv[$key];
							
							$totall=$kreditvalue;
							$kodsubjek=empty($kod_subjek[$key])?0:$kod_subjek[$key];
							$v[$value]=$grdv[$key];
					
							//echo $key."=".$kredit[$key];
		             	}
						/*
                		foreach ($grdv as  $key=>$value)
                		{                	
		                	$kreditvalue=$kredit[$key]*$grdv[$key];
							
							$totall+=$kreditvalue;
							$kodsubjek=empty($kod_subjek[$key])?0:$kod_subjek[$key];
							$v[$kodsubjek]=$value;
							echo $kodsubjek."=".$value;
		             	}
				 		*/
		             	
						for ($i=1; $i<=count($koduniq); $i++)
						{
							$kodarc=empty($kodarry[$i])?0:$kodarry[$i];
							
		        ?>
		                 	<td width="6%" align="right" class="desc"><?= empty($v[$kodarc])?0:$v[$kodarc] ?><?=nbs(1)?></td>
		        <?php   
		                 	$v[$kodarc]='';
						}
			
                ?>
            				<td width="6%" align="right" class="desc"><?=number_format($totall/$stu->totalcredit,2)?><?=nbs(1)?></td>                 
                		</tr>
				<?php
						$cgpa=$totall/$stu->totalcredit;
						$cgpa2=number_format($cgpa,2);
						array_push($db,"$cgpa2");
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
   
	//print_r($acv);
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
    
    /*
?>
//graf liner
<script>

	var json_bil=<?=$json_bil ?>

	$(function ()
	{
        $('#chart_container').highcharts(
        {
            chart: {
                type: 'line'
            },
            
            title: {
                text: 'Peratusan Murid Mengikut PNGK',
                x: -20 //center
            },
            
            subtitle: {
                text: '<?=$student[0]->mod_name?>',
                x: -20
            },
            
            xAxis: {
            	categories: [<?=$valu?>]
            },
            
            yAxis: {
            	title: {
                    text: 'Peratusan'
                },
              
            },
            
            tooltip: {
                 formatter: function() {
             
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ this.y +'%<br/>'+
                        'Murid: '+ json_bil[(this.x).toFixed(2)];
                }
          
            
            },
            
            series: [{
                name: 'PNGK',
                data: [<?=$valuacv?>],
            }]
        });
    });
   
</script>

 <?php */ ?>

<script>
 $(function () {
        $('#chart_container').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Bilangan Murid Mengikut PNGK Subjek'
            },
            subtitle: {
                text: '<?=$student[0]->mod_name?>'
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


?><?php /*
<STYLE TYPE="text/css">

	.colheader	{font-size:9pt;font-weight:bold;padding-left:2pt;padding-right:2pt;}
	.desc		{font-size:8pt;padding-left:2pt;padding-right:2pt;}
	.descbold	{font-size:11pt;padding-left:2pt;padding-right:2pt;font-weight:bold;height:10pt;}
	.descc		{font-size:11pt;padding-left:2pt;padding-right:2pt;height:10pt;}
	
</STYLE>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<!-- header part -------------------------------------- -->
        <tr>
        	<td>
        		<table width="100%" cellpadding=0 cellspacing=0 border=0>
        			<tr>
                    	<td colspan=7 align="center" style="height:60pt;">
                            <span class="descbold">LEMBAGA PEPERIKSAAN<br>
                            KEMENTERIAN PENDIDIKAN MALAYSIA<br>
                            ANALISIS KEPEUTUSAN MENGIKUT SUBJEK AKADEMIK</span><br><br>
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
              <thead><tr>
              	<td width="3%" align="center" class="desc">BIL</td>
                <td width="20%" align="center" class="desc" >NAMA</td>
                <td width="6%" align="center" class="desc">ANGKA GILIRAN</td>
                <?php
            
					foreach ($student as $row) {
					//$data[$row->mod_paper]=$row->mod_paper;
					$kod=explode(',',$row->kod_subjek);
					}
						foreach($kod as $k){
							
							
                    ?>
                     <td width="4%" align="center" class="desc"><?=$k?></td>
                    <?php
					}
			
                ?>
                  <td width="4%" align="center" class="desc">PNGK</td>
              </tr></thead>
            
             
              	<?php 
              	$bill=0;
				$db=array();
              	foreach ($student as $stu) {
					  $bill++;
				  
              	?>
              	 <tr>
              	<td width="3%" align="center" class="desc"><?=$bill?></td>
                <td width="20%" align="left" class="desc" ><?=ucwords($stu->stu_name)?></td>
                <td width="6%" align="left" class="desc"><?=$stu->stu_matric_no?></td>
                <?php
                $grdv=explode(',',$stu->nilaigred);
                $sem=explode(',',$stu->semester);
				$kod_subjek=explode(',',$stu->kod_subjek);
				$kredit=explode(',',$stu->kredit);
				
				$kreditvalue=0;
				$totall=0;
				
                foreach ($grdv as  $key=>$value) {
                	
                	$kreditvalue=$kredit[$key]*$grdv[$key];
					
					$totall+=$kreditvalue;
		
                 ?>
                 <td width="6%" align="right" class="desc"><?=$value?></td>
                 <?php   
                }
                
                ?>
            <td width="6%" align="right" class="desc"><?=number_format($totall/$stu->totalcredit,2)?></td>
                 
                </tr>
               <?php
                
               }
               ?>
             
       
            </table>
          </td>
        </tr>

        <tr>
            <td class="descxsitalic" colspan="4" style="height:60pt;">&nbsp;</td>
        </tr>
     </table>
      */
      ?>