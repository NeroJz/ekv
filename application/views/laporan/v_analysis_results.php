
<script language="javascript" type="text/javascript" >
    var kodkv = [
                <?= $centrecode ?>
            ];
</script>
<script src="<?=base_url()?>assets/js/report/kv.attendance.js" type="text/javascript"></script>

<legend><h3>Analisis Keputusan Mengikut Subjek Akademik</h3></legend>
<center>

<form id="frm_pusat" action="<?= site_url('report/result/analysis_results_s')?>" method="post" target="_blank" class="form-inline">
<table class="breadcrumb border" width="100%" align="center">
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
    
            <?php
            $colll=empty($colname)?'':$colname;
            
            if($colll!=''){
            ?>
          <input type="hidden" value="<?=$colll?>" name="kodpusat" id="kodpusat"/>
          <?php
    }else{
        ?>
         <tr>
        <td width="45%" height="35"><div align="right">Kod Pusat</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35"><div align="left">
        <input type="text" name="kodpusat" id="kodpusat" class="span3" style="margin-left:0px;width:270px;"/>
        <?php
    }
    ?>
        </div>
        </td>
    </tr>
   <tr>
        <td height="35"><div align="right">Kursus</div></td>
        <td height="35"><div align="center">:</div></td>
        <td width="52%" height="35">
        <div align="left" id="divKursus">
            <select id="slct_kursus" name="slct_kursus" style="width:270px;" class="validate[required]" disabled="true">
            <option value="">-- Sila Pilih --</option>
           <!-- <?php           
                foreach ($courses as $row)
                {
            ?>
                    <option value="<?= $row->cou_id ?>">
                        <?= ucwords($row->cou_course_code).'  - '.strcap($row->cou_name) ?>
                    </option>
            <?php 
                } 
            ?> -->
            </select>
        </div>
        </td>
    </tr>
        <tr>
    	<td height="35"><div align="right">Modul</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                <select id="slct_tahun" name="module" style="width:270px;" class="validate[required]">
                	<option value="">-- Sila Pilih --</option>
            		<?php			
				foreach ($module_code as $row)
				{
			?>
					<option value="<?= $row->mod_code ?>">
					    <?= strtoupper($row->mod_code)." ".strtoupper($row->mod_name) ?>
                    </option>
		    <?php 
				} 
			?>
                </select>
            </div>
        </td>
    </tr>
     <tr>
    	<td height="35"><div align="right">Status</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                <select id="statusID" name="status" style="width:270px;">
                	<option value="">Semua</option>
            		<option value="1">Aktif</option>
            		<option value="0">Tidak Aktif</option>
                </select>
            </div>
        </td>
    </tr>
    
    
    <tr>
    	<td></td>
    	<td height="35"><div align="right"></div></td>
        <td height="35">
        	<div align="left">
          		<input class="btn btn-info" type="submit" name="btn_papar" value="Papar Laporan">
        	</div>
        </td>
    </tr>
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
</table>
</form>

</center>
<?php
if(isset($_POST['btn_papar']) && !empty($student)){

?>

     <div class="accordion" id="accordion" >
        <div class="accordion-group">
          <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-target="#collapseOne" >
             Laporan
            </a>
          </div>
          <div id="collapseOne" class=" collapse in">
            <div class="accordion-inner">
            
            <form action="<?=site_url("report/result/analysis_result_print")?>" method="POST" target="_blank">
               <input type="hidden" value="<?=$student[0]->col_name?>" name="kodpusat"/>
              <input type="hidden" value="<?=$student[0]->cou_id?>" name="slct_kursus"/>
              <input type="hidden" value="<?=$student[0]->mod_code?>" name="module"/>
 <input type="submit" value="cetak" />
            </form>
          
     
<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<!-- header part -------------------------------------- -->
        <tr>
        	<td>
        		<table width="100%" cellpadding=0 cellspacing=0 border=0>
        			<tr>
                    	<td colspan=7 align="center" style="height:60pt;">
                            <span class="descbold">LEMBAGA PEPERIKSAAN<br>
                            KEMENTERIAN PENDIDIKAN MALAYSIA<br>
                            ANALISIS KEPUTUSAN MENGIKUT SUBJEK AKADEMIK</span><br><br>
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
              	<td width="3%" align="center" class="desc">BIL</td>
                <td width="20%" align="center" class="desc" >NAMA</td>
                <td width="6%" align="center" class="desc">ANGKA GILIRAN</td>
                <?php
            $kodmer=array();
					foreach ($student as $row) {
					//$data[$row->mod_paper]=$row->mod_paper;
					
					
					$kod=explode(',',$row->kod_subjek);
					foreach($kod as $kodcode){
						
						array_push($kodmer,$kodcode);
					}
					
				
					}
					
						$koduniq=array_unique($kodmer);
					$bikod=0;
						foreach($koduniq as $ckey=>$k){
							$bikod++;
							$kodarry[$bikod]=$k;
						
                    ?>
                     <td width="4%" align="center" class="desc"><?=$k?></td>
                    <?php
						}
			
                ?>
                  <td width="4%" align="center" class="desc">PNGK</td>
              </tr>
            
             
              	<?php 
              	$bill=0;
				$db=array();
              	foreach ($student as $stu) {
					  $bill++;
				  
              	?>
              	 <tr>
              	<td width="3%" align="center" class="desc"><?=$bill?></td>
                <td width="20%" align="left" class="desc" ><?=nbs(1)?><?=strtoupper($stu->stu_name)?></td>
                <td width="6%" align="center" class="desc"><?=$stu->stu_matric_no?></td>
                <?php
                $grdv=explode(',',$stu->nilaigred);
                $sem=explode(',',$stu->semester);
				$kod_subjek=explode(',',$stu->kod_subjek);
				$kredit=explode(',',$stu->kredit);
			
				$kreditvalue=0;
				$totall=0;
				//print_r($kod_subjek);
				
				 foreach ($kod_subjek as  $key=>$value) {
                	
                	$kreditvalue+=$kredit[$key]*$grdv[$key];
					
					$totall=$kreditvalue;
					$kodsubjek=empty($kod_subjek[$key])?0:$kod_subjek[$key];
					$v[$value]=$grdv[$key];
					
			//echo $key."=".$kredit[$key];
		             }
				/*
                foreach ($grdv as  $key=>$value) {
                	
                	$kreditvalue=$kredit[$key]*$grdv[$key];
					
					$totall+=$kreditvalue;
					$kodsubjek=empty($kod_subjek[$key])?0:$kod_subjek[$key];
					$v[$kodsubjek]=$value;
			echo $kodsubjek."=".$value;
		             }
				 
				 */
				for ($i=1; $i<=count($koduniq); $i++){
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
            </div>
          </div>
        </div>
        <div class="accordion-group">
          <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-target="#collapseTwo" >
              Graf
            </a>
          </div>
          <div id="collapseTwo" class=" collapse">
            <div class="accordion-inner">
                  
                  <div id="chart_container" align="center">
</div>
<?php


$acv=array_count_values($db);
krsort($acv);
 $totalarray=count($db);
 $valuacv="";
					 foreach($acv as $keyy => $rowacv){
					 	
					 	$bitol[$keyy]=$rowacv;
						$valuacv.=(round(($rowacv/$totalarray)*100)).",";
					 }
					 

	 $json_bil=json_encode($bitol);
	 
      $dbuniq=array_unique($db);
					 arsort($dbuniq);
				
					 $valu="";
					 foreach($dbuniq as $row){
					 	
						$valu.=$row.",";
					 }
					 
					 
					 

?>
<script src="<?=base_url()?>assets/js/highcharts.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/js/exporting.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/js/themes/grid.js" type="text/javascript"></script>
<script>

var json_bil=<?=$json_bil ?>

	$(function () {
        
  
        $('#chart_container').highcharts({
            chart: {
                type: 'line',
                marginRight: 130,
                marginBottom: 25
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
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -10,
                y: 100,
                borderWidth: 0
            },
            series: [{
                name: 'Peratusan',
                data: [<?=$valuacv?>]
            }]
        });
    });
    
</script>
            </div>
          </div>
        </div>
      </div>
      <?php
    }
?>