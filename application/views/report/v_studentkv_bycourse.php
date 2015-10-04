<script language="javascript" type="text/javascript" >
	$(document).ready(function()
	{	
			$("#frm_pusat").validationEngine(
			'attach', {scroll: false}	
		);
		
			
	});
  
</script>

<legend><h3>Senarai Murid Mengikut Kursus</h3></legend>
<center>

<form id="frm_pusat" action="<?= site_url('report/report/studentkv_course')?>" method="post" >
<table class="breadcrumb border" width="100%" align="center">
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>

      <tr>
    	<td width="45%" height="35"><div align="right">Semester</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35"><div align="left"><select width="50%" style="width:270px;" name="semester" id="semester" class="validate[required]">
        	<option value="">-- Sila Pilih --</option>
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
		    <?php } ?>
                </select>
            </div>
        </td>
    </tr>
    
    <?php if(($ul_type=='JPN')||($ul_type=='KV')){ ?>
    	 <input type="hidden" value="<?=$state?>"  name="state" ?>
       
    <?php }else{
    ?>
   
     <tr>
    	<td height="35"><div align="right">Negeri</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                <select id="state" name="state" style="width:270px;" class="validate[required]">
                	<option value="">-- Sila Pilih --</option>
            		<?php			
				foreach ($state as $row)
				{
			?>
					<option value="<?= $row->state_id ?>">
					    <?= strtoupper($row->state) ?>
                    </option>
		    <?php } ?>
                </select>
            </div>
        </td>
    </tr>
    <?php	
		
    }?>

    <tr>
    	<td></td>
    	<td height="35"><div align="right"></div></td>
        <td height="35">
        	<div align="left">
          		<input class="btn btn-info" type="submit" name="btn_papar" value="Papar Senarai Murid">
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
    

          	<table width="100%" cellpadding=0 cellspacing=0 border=1 >
             <tr>
              	<th width="3%" align="center" class="desc">KOD</th>
                <th width="20%" align="center" class="desc" >KURSUS</th>
                <th width="10pt" align="center" class="desc">JUMLAH MURID</th>
                <?php
            $nokv=0;
			$coukv=count($college);
			
					foreach ($college as $row) {
				$nokv++;
							$codekv=$row->col_type.$row->col_code;
						    $dkv[$nokv]=$row->col_id;
							$codekvd[$nokv]=$codekv;
							
			
                    ?>
                     <th width="4%" align="center" class="desc"><?=$codekv?></th>
                    <?php } 
                    
				
                    ?>
               
              </tr>
            
             
              	<?php 
              	$bill=0;
				$categories="";
				$totalallrow=0;
			$totkv[]=0;
              	foreach ($student as $stu) {
					  $bill++;
				  
              	?>
              	 <tr>
              	<td width="3%" align="left" class="desc"><?=nbs(1)?><?=$stu->cou_course_code?></td>
                <td width="20%" align="left" class="desc" ><?=nbs(1)?><?=ucwords($stu->cou_name)?></td>
                <td width="6%" align="right" class="desc"><span id="spanJumSub<?=$bill?>">-</span><?=nbs(1)?></td>
                <?php
            
		if(!empty($stu->totalstu)){
			$col="";
			$tot='';
			$bilrow=0;
			$totalkvcourse=0;
			$colname[]='';
                foreach ($stu->totalstu as  $value) {
                	$codekv2=$value->col_type.$value->col_code;
                	$col[$value->col_id]=$value->col_id;
					$tot[$value->col_id]=$value->total;
					$colname[$stu->cou_course_code]=$stu->cou_name;
				}
     $totalall=0;
	
                        for ($i=1; $i<=$coukv; $i++)
  {
  	$bilrow++;
$kvc=empty($dkv[$i])?0:$dkv[$i];
$kvcd=empty($codekvd[$i])?'-':$codekvd[$i];
$colkvc=empty($col[$kvc])?0:$col[$kvc];

 if($colkvc==$kvc){
                 ?>
                 <td width="6%" align="right" class="desc"><?=$tot[$kvc]?><?=nbs(1)?></td>
                 <?php 
                 //kira bil pelajar
					echo "<script language='javascript'>
		$('#spanJumSub" . $bill . "').html('" . ($totalall+=$tot[$kvc]) . "');
		</script>";
		
		$totkv[$kvc]=empty($totkv[$kvc])?0:$totkv[$kvc];
		
		$totkv[$kvc]+=$tot[$kvc];
		
					}else{
                 	?>
                 	<td width="6%" align="right" class="desc">-<?=nbs(1)?></td>
                 	
					<?php }
					}
				
		$totalallrow+=$totalall;
		
		$categories[$stu->cou_course_code]="$totalall";
		 $json_cou=json_encode($colname);
                ?>
          
                </tr>
               <?php 
		}else{
			 for ($s=1; $s<=$coukv; $s++){
			?>
			<td width="6%" align="right" class="desc">-<?=nbs(1)?></td>
			
			<?php
		}
			 echo "</tr>";
		}


			}
               ?>
             <tr>
                <td colspan="2" width="20%" align="right" class="desc" style="font-weight: bold;" >JUMLAH<?=nbs(1)?></td>
                <td width="3%" align="right" class="desc" ><?=empty($totalallrow)?'-':$totalallrow?><?=nbs(1)?></td>
                
                <?php
                 for ($ss=1; $ss<=$coukv; $ss++){
                 	$kvc=empty($dkv[$ss])?0:$dkv[$ss];
			?>
			<td width="6%" align="right" class="desc"><?=empty($totkv[$kvc])?'-':$totkv[$kvc]?><?=nbs(1)?></td>
			
			<?php
		}
				 ?>
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
if(!empty($categories)){
$catcou='';
$valuacv='';
foreach ($categories as $keyy => $rowacv) {

	$catcou.="'".$keyy."'".",";
	$valuacv .= $rowacv . ",";
}


?>
<script src="<?=base_url()?>assets/js/highcharts.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/js/exporting.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/js/themes/grid.js" type="text/javascript"></script>
<script>

var json_cou=<?=$json_cou ?>

	$(function () {
        $('#chart_container').highcharts({
            chart: {
                type: 'bar',
                height: 500,
            },
            title: {
                text: ' Murid Mengikut Kursus'
            },
            subtitle: {
                text:''
            },
            xAxis: {
            
                categories: [<?=$catcou?>],
                title: {
                    text: 'Kursus'
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Murid',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
          tooltip: {
             formatter: function() {
             
                    return '<b>'+ this.x +'</b><br/>'+
                        this.series.name +': '+ this.y +'<br/>'+
                         json_cou[(this.x)];
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
                name: 'Murid',
                data: [<?=$valuacv?>],
                
            },]
        });
    });
</script>
            </div>
          </div>
        </div>
      </div>
      <?php
	}else{
		echo "Tiada Data";
		
	}
	}
?>