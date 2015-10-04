<script language="javascript" type="text/javascript" >

$(document).ready(function()
{	
	var kodkv = [
		<?= $centrecode ?>
	];
	
	$( "#kodpusat" ).autocomplete({
		source: kodkv
	});	

    var oTable = $('#tablefin').dataTable(
    {
		
		"sDom": 'T<"clear">lfrtip',
		"oTableTools": 
		{
			"sSwfPath": "<?=base_url()?>assets/img/swf/copy_csv_xls_pdf.swf",				
			"aButtons": [ 
			 				{
								"sExtends": "xls",
								"sButtonText": "Save for Excel"
							}
						]
		}
	});		
});
  
</script>
<legend><h3>Laporan FIN</h3></legend>
<center>

<form id="frm_pusat" action="<?= site_url('report/report/view_fin_no')?>" method="post">
<table class="breadcrumb border" width="100%" align="center">
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
    <tr>
    	<td width="45%" height="35"><div align="right">Kod Pusat</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35"><div align="left">
          <input type="text" value="<?=empty($_POST['kodpusat'])?"":$_POST['kodpusat']?>" name="kodpusat" id="kodpusat" class="span3" style="margin-left:0px">
        </div>
        </td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Kursus</div></td>
        <td height="35"><div align="center">:</div></td>
        <td width="52%" height="35">
        <div align="left">
            <select id="slct_kursus" name="slct_kursus" style="width:270px;" >
            <option value="">-- Sila Pilih --</option>
            <?php			
				foreach ($courses as $row)
				{
			?>
					<option value="<?= $row->cou_id ?>">
					    <?= strtoupper($row->cou_course_code.'  - '.$row->cou_name ) ?>
                    </option>
		    <?php 
				} 
			?>
            </select>
        </div>
        </td>
    </tr>
      <tr>
    	<td width="45%" height="35"><div align="right">Semester</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35"><div align="left"><select width="50%" name="semester" id="semester" /required>
        	<option value="">-Sila Pilih-</option>
        	<option value="1">1</option>
        	<option value="2">2</option>
        	<option value="3">3</option>
        	<option value="4">4</option>
        	<option value="5">5</option>
        	<option value="6">6</option>
        	<option value="7">7</option>
        	<option value="8">8</option>
        	</select></td>
          
        </div>
        </td>
    </tr>
          <tr>
    	<td height="35"><div align="right">Tahun</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                <select id="slct_tahun" name="mt_year" style="width:270px;" class="validate[required]">
                	<option value="">-- Sila Pilih --</option>
            		<?php			
				foreach ($year as $row)
				{
			?>
					<option value="<?= $row->mt_year ?>">
					    <?= strtoupper($row->mt_year) ?>
                    </option>
		    <?php 
				} 
			?>
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

     <div class="accordion" id="accordion" >
        <div class="accordion-group">
          <div class="accordion-heading">
            <a class="accordion-toggle" data-toggle="collapse" data-target="#collapseOne" >
             Laporan
            </a>
          </div>
          <div id="collapseOne" class=" collapse in">
            <div class="accordion-inner">
    

        	
          	<table width="100%" cellpadding=0 cellspacing=0 border=1  id="tablefin">
          <thead>
            <tr>
                <th width="80" id="tdleft" align="center">Bil</a></th>
                <th width="400" align="center">NAMA CALON</th>
		<th width="195" id="tdright" align="center">NO. KAD PENGENALAN</th>
                <th width="195" id="tdright" align="center">ANGKA GILIRAN</th>
                <th width="195" id="tdright" align="center">KOD KURSUS</th>
                <th width="195" id="tdright" align="center">JANTINA</th>
                <th width="195" id="tdright" align="center">KAUM</th>
                <th width="195" id="tdright" align="center">AGAMA</th>
            </tr>
        </thead>
        	<?php 
              	$bil=0;
				
				$tempCC="";
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
                $tempCC = $stu->cou_id;
               }
               ?>
        
        
            
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
                type: 'bar',
                height: 500,
            },
            title: {
                text: 'Peratusan Pelajar mengikut CGPA'
            },
            subtitle: {
                text: '<?=$student[0]->mod_name?>'
            },
            xAxis: {
            
                categories: [<?=$valu?>],
                title: {
                    text: 'CGPA'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Peratusan(%)',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
          tooltip: {
             formatter: function() {
             
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ this.y +'%<br/>'+
                        'Pelajar: '+ json_bil[(this.x).toFixed(2)];
                }
          
            
            },
            plotOptions: {
                bar: {
                 
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'top',
                x: -100,
                y: 100,
                floating: false,
                borderWidth: 1,
                backgroundColor: '#FFFFFF',
                shadow: true
            },
            credits: {
                enabled: false
            },
            series: [{
                name: 'Peratusan',
                data: [<?=$valuacv?>],
                
            },]
        });
    });
</script>



            </div>
          </div>
        </div>
      </div>

