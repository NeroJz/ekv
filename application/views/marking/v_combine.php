<?php if(isset($pentaksiran) && 'cc' == $pentaksiran){ ?>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/FixedColumns.js"></script>
<?php } ?>
<script language="javascript" type="text/javascript" >
	//send to javascript variable if kursus has been selected
	var curCCID = '<?=set_value('slct_kursus');?>';
	
	$(document).ready(function()
	{	
		var kodkv = [
			<?= $centrecode ?>
		];
		
		$( "#kodpusat" ).autocomplete({
			source: kodkv
		});	
	});
	
	$(document).ready(function(){
    	
    	$("#frm_pusat").validationEngine();
    	
		$('#pelajar').dataTable({
			"iDisplayLength" : 100,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bAutoWidth": true
		});
		<?php if('cc' == $pentaksiran){ ?>
		var oTable = $('#pelajar_akademik_cantum').dataTable({
			"iDisplayLength" : 100,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			
			"sScrollY": 500,
			"sScrollX": "100%",
 		"sScrollXInner": "2000px",
 		"bScrollCollapse": true
		});
		
		new FixedColumns( oTable, {
		
 		"iLeftColumns": 4,
 		"iRightColumns": 0
 		} );
		<?php } ?>
		
		
		
		$('#btn_simpan').click(function(){
			alert("Markah Telah Disimpan");
		});
		
		$('#btn_simpan2').click(function(){
			alert("Markah Telah Disimpan");
		});
		
		
		$('.markah_akademik_sekolah').bind('change',function(event){
			var iMark =$(this).val();
			var iJumlah = 0;
			
			iJumlah = (iMark/100)*30;
			iJumlah =  new Number(iJumlah).toFixed(1);
			
			$(this).next('#cur_gred').html(iJumlah+'/30');
			
		});
		
		$('.markah_kv_sekolah').bind('change',function(event){
			var iMark =$(this).val();
			var iJumlah = 0;
			
			iJumlah = (iMark/100)*70;
			iJumlah =  new Number(iJumlah).toFixed(1);
			
			$(this).next('#cur_gred').html(iJumlah+'/70');
			
		});
		
		$('.markah_akademik_pusat').bind('change',function(event){
			var ind = $(".markah_akademik_pusat").index(this);
			var iMark =$(this).val();
			var iJumlah = 0;
			var cid = $(this).attr('id');
			var aId = cid.split("_");
			
			iJumlah = (iMark/aId[2])*70;
			iJumlah =  new Number(iJumlah).toFixed(1);
			
			$(this).next('#cur_gred').html(iJumlah+'/70');
			
		});
		
		$('.markah_kv_pusat').bind('change',function(event){
			var iMark =$(this).val();
			var iJumlah = 0;
			
			iJumlah = (iMark/100)*30;
			iJumlah =  new Number(iJumlah).toFixed(1);
			
			$(this).next('#cur_gred').html(iJumlah+'/30');
			
		});
	});
	
</script>
<?php //$gred_akademik; ?>
<legend><h3>Pencantuman Markah Akademik / Vokasional</h3></legend>
<center>

<form id="frm_pusat" action="<?= site_url('examination/combine_marks/view_list')?>" method="post" >
<table class="breadcrumb border" width="100%" align="center">
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
    <tr>
    	<td width="45%" height="35"><div align="right">Kod Pusat</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35" align="left">
            <div align="left">
                <?php
                	$dataKodPusat = array(
		              'name'        => 'kodpusat',
		              'id'          => 'kodpusat',
		              'value'       => set_value('kodpusat'),
		              'class'   => 'span4',
		              'size'        => '25'
		            );
					echo form_input($dataKodPusat);
                ?>
            </div>            
        </td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Pengurusan</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                <?php
        	$dataPengurusan = array();
        	$dataPengurusan['Akademik'] = array(
		    'name'        => 'pengurusan',
		    'id'          => 'pengurusan',
		    'value'       => 'ak',
		    'checked'     => FALSE,
		    'class'       => 'pengurusan',
		    );
			
        	$dataPengurusan['Vokasional'] = array(
		    'name'        => 'pengurusan',
		    'id'          => 'pengurusan',
		    'value'       => 'vk',
		    'checked'     => FALSE,
		    'class'       => 'pengurusan',
		    );
			
			$attLabel = array(
							'class' => 'radio inline'
						);
			
			$valPengurusan = set_value('pengurusan');
			
			foreach($dataPengurusan as $key => $curPengurusan){
				if($valPengurusan==$curPengurusan["value"])
					$curPengurusan["checked"] = TRUE;
				
				$curFormPengurusan = form_radio($curPengurusan);
				echo form_label($curFormPengurusan.nbs(1).$key, '',$attLabel);
			}
        	?>
            </div>
        </td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Kursus</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35"><div align="left">
        	<select id="slct_kursus" name="slct_kursus" class="validate[required]">
            </select>
        </td>
    </tr>
    <tr>
    	<td width="45%" height="35"><div align="right">Semester</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35"><div align="left">
        	<?php
        	$attr_semester = 'style="" class="validate[required]"';
        	$options_semester = array("" => '-- Sila Pilih --');
        		for($cur_semester = 1; $cur_semester <= 8; $cur_semester++)
        		{
        			$options_semester[$cur_semester] = $cur_semester;
				}
				
				echo form_dropdown('semester', $options_semester, set_value('semester'), $attr_semester);
        	?>
        	</td>
          
        </div>
        </td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Tahun</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                <?php
	        	$attr = 'style="" class="validate[required]"';
	        	$options = array("" => '-- Sila Pilih --');
        		foreach ($year as $row)
				{
        			$options[$row->mt_year] = strtoupper($row->mt_year);
				}
				
				echo form_dropdown('slct_tahun', $options, set_value('slct_tahun'), $attr);
        	?>
            </div>
        </td>
    </tr>
    <tr>
    	<td></td>
    	<td height="35"><div align="right"></div></td>
        <td height="35">
        	<div align="left">
          		<input class="btn btn-info" type="submit" name="btn_papar" value="Papar Murid">
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
if(isset($pilihan))
{
	if('ak' == $pilihan)
	{
		?>
        <form method="post" action="<?=site_url("peperiksaan/pemarkahan/proses_akademik")?>">
        <?php
        if('cc' == $pentaksiran){
			?>
			<table cellpadding="0" cellspacing="0" style="width:100% !important;" border="0" class="display" id="pelajar_akademik_cantum">
            <thead>
                <tr>
                    <th>Bil</th>
                    <th>Nama Murid</th>
                    <th>No Kad Pengenalan</th>
                    <th>Angka Giliran</th>
                    <?php
					
					if(sizeof($subjek_akademik) > 0){
						$i = 0;
					 	foreach($subjek_akademik as $rsa){
					 ?>
                    <th><a href="javascript:void(0);" data-container="body" class="titleSubject" data-toggle="tooltip" title="<?=$rsa->mod_name?>"><?=$rsa->mod_paper?></a><br />
                    
                	</th>
                    <th><a href="javascript:void(0);" data-container="body" class="titleSubject" data-toggle="tooltip" title="<?=$rsa->mod_name?>"><?=$rsa->mod_paper?></a><br />
                    
                	</th>
                    <?php
					$i++;
						}
						 	foreach($subjek_akademik as $rsa){
							 ?>
							<th><a href="javascript:void(0);" data-container="body" class="titleSubject" data-toggle="tooltip" title="<?=$rsa->mod_name?>"><?=$rsa->mod_paper?></a><br />
							
							</th>
							<?php
							$i++;
								}
								
								foreach($subjek_akademik as $rsa){
							 ?>
							<th><a href="javascript:void(0);" data-container="body" class="titleSubject" data-toggle="tooltip" title="<?=$rsa->mod_name?>"><?=$rsa->mod_paper?></a><br />
							
							</th>
							<?php
							$i++;
								}
					}	
					?>
                </tr>
            </thead>
            <tbody>
            
             <?php
					if(sizeof($pelajar_akademik) > 0){
						$i = 0;
						
						$sgred_aka = array();
						
					 	foreach($pelajar_akademik as $rpa){
							$i++;
							
					 ?>
                <tr>
                    <td><?=$i?></td>
                    <td><?=ucwords(strtolower($rpa->stu_name))?></td>
                    <td align="center"><?=$rpa->stu_mykad?></td>
                    <td align="center"><?=$rpa->stu_matric_no?></td>
                     <?php
                     $aModuleTakenMarksAk = !(empty($rpa->listModuleTakenMarksAk))?$rpa->listModuleTakenMarksAk:'';
					if(sizeof($subjek_akademik) > 0){
						
						//echo "<pre>";					//FDP
						//print_r($aModuleTakenMarksAk);
						//echo "</pre>";
						//die();
						
						
						$j = 0;
						$jum_markah = array();
						$sgred_cur = array();
						$mVal1 = 0;
						$mVal2 = 0;
						
						
					 	foreach($subjek_akademik as $rsa){
					 		//echo $rsa->mod_id.'S';
					 		$aMarkS = !(empty($aModuleTakenMarksAk[$rsa->mod_id.'S']))?$aModuleTakenMarksAk[$rsa->mod_id.'S']:"";
							$aMarkP = !(empty($aModuleTakenMarksAk[$rsa->mod_id.'P']))?$aModuleTakenMarksAk[$rsa->mod_id.'P']:"";
							if(empty($aMarkS)){
								$mVal = "-";
								$mVal1 = "-";
							}else
							{
								/*Modification Log : 30072013 by Mior : Buat operation calculate percentage */
								if ($aMarkS['marks_value']== -99.99) {
									$mVal = $aMarkS['marks_value'];
								}
								else {
									$mVal = $aMarkS['marks_value']*($aMarkS['marks_total_mark']/100);
								}
								
								$mVal1 = sprintf("%.2f",$mVal);
							}
							
							if(empty($aMarkP)){
								$mVal = "-";
								$mVal2 = "-";
							}else
							{
								/*Modification Log : 30072013 by Mior : Buat operation calculate percentage */
								if ($aMarkP['marks_value']== -99.99) {
									$mVal = $aMarkP['marks_value'];
								}
								else {
									$mVal = $aMarkP['marks_value']*($aMarkP['marks_total_mark']/100);
								}
								
								$mVal2 = sprintf("%.2f",$mVal);
							}
							
							if($mVal1 == "-" || $mVal2 == "-"){
								if($mVal1 != "-" && $mVal2 == "-"){
									$jum_markah[] = ceil($mVal1);
								}
								elseif($mVal2 != "-" && $mVal1 == "-"){
									$jum_markah[] = ceil($mVal2);
								}else{
									$jum_markah[] = "-";									
								}
							}
							else {
								if($mVal1 == -99.99 || $mVal2 == -99.99)
								{
									$jum_markah[] = -99.99;
									$tempMark = -99.99;
								}
								else{
									$tempMark = ceil($mVal1+$mVal2);
									$jum_markah[] = $tempMark;
								}

								if(empty($aMarkS["mt_full_mark"]))
								{
									storeMarkAndSetGrade($aMarkS["md_id"], $tempMark, $aMarkS["marks_assess_type"]);
								}
								elseif ($aMarkS["mt_full_mark"] != $tempMark) {
									storeMarkAndSetGrade($aMarkS["md_id"], $tempMark, $aMarkS["marks_assess_type"]);
								}								
							}
					 ?>
                    <td align="center" bgcolor="#FFFF00"><span id="cur_gred" style="text-align:center;"><?=$mVal1!=-99.99?$mVal1:"T"?></span>
                    <td align="center"><span id="cur_gred2" style="text-align:center;"><?=$mVal2!=-99.99?$mVal2:"T"?></span>
                    </td>
                    <?php
					$j++;
						}
						$j = 0;
						foreach($subjek_akademik as $rsa){
							?>
                    <td align="center" bgcolor="#CCCCCC"><span id="cur_gred" style="text-align:center;"><?=($jum_markah[$j]>= -5)?$jum_markah[$j]:"T"?></span>
							<?php
							$j++;
						}
						
						$j = 0;
						foreach($subjek_akademik as $rsa){
							
							$aMarkS = !(empty($aModuleTakenMarksAk[$rsa->mod_id.'S']))?$aModuleTakenMarksAk[$rsa->mod_id.'S']:"";
							$aMarkP = !(empty($aModuleTakenMarksAk[$rsa->mod_id.'P']))?$aModuleTakenMarksAk[$rsa->mod_id.'P']:"";
							
							if(!empty($aMarkS)){
								$aMark = $aMarkS;
							}
							else{
								$aMark = $aMarkP;
							}
							
							if($jum_markah[$j] == "-"){
								$sgred_cur[$rsa->mod_id] = "-";
							}else{
								$sgred_cur[$rsa->mod_id] = getGrade($jum_markah[$j], $aMark["marks_assess_type"],'grade_type');								
							}
							?>
                    <td align="center" bgcolor="#00FFCC"><span id="cur_gred" style="text-align:center;"><?=$sgred_cur[$rsa->mod_id]?></span>
							<?php
							$j++;
						}
					}	
					?>
                </tr>
                <?php
						$sgred_aka[$rpa->stu_id] = $sgred_cur;
						}
					}	
					?>
            </tbody>
        </table>
			<?php
		}
		echo "</form>";
	}
	else if('vk' == $pilihan)
	{
		?>
		<form action="<?=site_url("peperiksaan/pemarkahan/proses_kv")?>" method="post">
		<?php
		 if('cc' == $pentaksiran){
			?>
			<table cellpadding="0" cellspacing="0" border="0" class="display table table-bordered" id="pelajar_akademik_cantum">
            <thead>
                <tr>
                    <th>Bil</th>
                    <th>Nama Murid</th>
                    <th>No Kad Pengenalan</th>
                    <th>Angka Giliran</th>
                    <?php
					
					if(sizeof($subjek_kv) > 0){
						$i = 0;
					 	foreach($subjek_kv as $rsa){
					 ?>
                    <th><a href="javascript:void(0);" data-container="body" class="titleSubject" data-toggle="tooltip" title="<?=$rsa->mod_name?>"><?=$rsa->mod_paper?></a><br />
                    
                	</th>
                    <th><a href="javascript:void(0);" data-container="body" class="titleSubject" data-toggle="tooltip" title="<?=$rsa->mod_name?>"><?=$rsa->mod_paper?></a><br />
                    
                	</th>
                    <?php
					$i++;
						}
						 	foreach($subjek_kv as $rsa){
							 ?>
							<th><a href="javascript:void(0);" data-container="body" class="titleSubject" data-toggle="tooltip" title="<?=$rsa->mod_name?>"><?=$rsa->mod_paper?></a><br />
							
							</th>
							<?php
							$i++;
								}
								
								foreach($subjek_kv as $rsa){
							 ?>
							<th><a href="javascript:void(0);" data-container="body" class="titleSubject" data-toggle="tooltip" title="<?=$rsa->mod_name?>"><?=$rsa->mod_paper?></a><br />
							
							</th>
							<?php
							$i++;
								}
					}	
					?>
                </tr>
            </thead>
            <tbody>
            
             <?php
					if(sizeof($pelajar_akademik) > 0){
						$i = 0;
						
						$sgred_aka = array();
						
					 	foreach($pelajar_akademik as $rpa){
							$i++;
							
					 ?>
                <tr>
                    <td><?=$i?></td>
                    <td><?=ucwords(strtolower($rpa->stu_name))?></td>
                    <td align="center"><?=$rpa->stu_mykad?></td>
                    <td align="center"><?=$rpa->stu_matric_no?></td>
                     <?php
                     $aModuleTakenMarksAk = !(empty($rpa->listModuleTakenMarksAk))?$rpa->listModuleTakenMarksAk:'';
					if(sizeof($subjek_kv) > 0){
						
						$j = 0;
						$jum_markah = array();
						$sgred_cur = array();
						$mVal1 = 0;
						$mVal2 = 0;
						
						
					 	foreach($subjek_kv as $rsa){
					 		//echo $rsa->mod_id.'S';
					 		$aMarkS = !(empty($aModuleTakenMarksAk[$rsa->mod_id.'S']))?$aModuleTakenMarksAk[$rsa->mod_id.'S']:"";
							$aMarkP = !(empty($aModuleTakenMarksAk[$rsa->mod_id.'P']))?$aModuleTakenMarksAk[$rsa->mod_id.'P']:"";
							
							if(empty($aMarkS)){
								$mVal = "-";
								$mVal1 = "-";
							}else
							{
								$mVal = $aMarkS['marks_value'];
								$mVal1 = sprintf("%.2f",$mVal);
							}
							
							if(empty($aMarkP)){
								$mVal = "-";
								$mVal2 = "-";
							}else
							{
								$mVal = $aMarkP['marks_value'];
								$mVal2 = sprintf("%.2f",$mVal);
							}
							
							if($mVal1 == "-" || $mVal2 == "-"){
								if($mVal1 != "-" && $mVal2 == "-"){
									$jum_markah[] = ceil($mVal1);
								}
								elseif($mVal2 != "-" && $mVal1 == "-"){
									$jum_markah[] = ceil($mVal2);
								}else{
									$jum_markah[] = "-";									
								}
							}
							else {
								
								if($mVal1 == -99.99 || $mVal2 == -99.99)
								{
									$jum_markah[] = -99.99;
									$tempMark = -99.99;
								}
								else{
									
								 
									$tempMark = ceil($mVal1+$mVal2);
									
									
									if($aMarkS['status_competent']==0){
										
										if($tempMark >= 59){
											
											$jum_markah[] = 59;
										}else{
											$jum_markah[] = $tempMark;
											
										}
										
									}else{
										$jum_markah[] = $tempMark;
										
									}
									?>
									<script>
										
										console.log(<?= $tempMark?>);
									</script>
									<?php
									
								}

								if(empty($aMarkS["mt_full_mark"]))
								{
									storeMarkAndSetGrade($aMarkS["md_id"], $tempMark, $aMarkS["marks_assess_type"]);
								}
								elseif ($aMarkS["mt_full_mark"] != $tempMark) {
									storeMarkAndSetGrade($aMarkS["md_id"], $tempMark, $aMarkS["marks_assess_type"]);
								}								
							}
					 ?>
                    <td align="center" bgcolor="#FFFF00"><span id="cur_gred" style="text-align:center;"><?=$mVal1!=-99.99?$mVal1:"T"?></span>
                    <td align="center"><span id="cur_gred2" style="text-align:center;"><?=$mVal2!=-99.99?$mVal2:"T"?></span>
                    </td>
                    <?php
					$j++;
						}
						$j = 0;
						foreach($subjek_kv as $rsa){
							?>
                    <td align="center" bgcolor="#CCCCCC"><span id="cur_gred" style="text-align:center;"><?=($jum_markah[$j] >= -5)?$jum_markah[$j]:"T"?></span>
							<?php
							$j++;
						}
						
						$j = 0;
						foreach($subjek_kv as $rsa){
							
							$aMarkS = !(empty($aModuleTakenMarksAk[$rsa->mod_id.'S']))?$aModuleTakenMarksAk[$rsa->mod_id.'S']:"";
							$aMarkP = !(empty($aModuleTakenMarksAk[$rsa->mod_id.'P']))?$aModuleTakenMarksAk[$rsa->mod_id.'P']:"";
							
							if($aMarkS != ""){
								$aMark = $aMarkS;
							}
							elseif ($aMarkP != "") {
								$aMark = $aMarkP;								
							}
							
							if($jum_markah[$j] == "-"){
								$sgred_cur[$rsa->mod_id] = "-";
							}else{
								if(sizeof($aMark)>0)
									$sgred_cur[$rsa->mod_id] = getGrade($jum_markah[$j], $aMark["marks_assess_type"],'grade_type');
								else {
									$sgred_cur[$rsa->mod_id] = "-";
								}								
							}
							?>
                    <td align="center" bgcolor="#00FFCC"><span id="cur_gred" style="text-align:center;"><?=$sgred_cur[$rsa->mod_id]?></span>
							<?php
							$j++;
						}
					}	
					?>
                </tr>
                <?php
						$sgred_aka[$rpa->stu_id] = $sgred_cur;
						}
					}	
					?>
            </tbody>
        </table>
			<?php
		}
	}
}
?>
</form>
<script src="<?=base_url()?>assets/js/evaluation/process_marking.js" type="text/javascript"></script>
