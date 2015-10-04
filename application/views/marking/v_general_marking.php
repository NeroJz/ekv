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
    	
		$('#pelajar').dataTable({
			"iDisplayLength" : 10,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"sScrollY": "200px",
			"bPaginate": true,
			"bAutoWidth": true,
	 		"oLanguage": {  "sSearch": "Carian :",
	 						"sLengthMenu": "Papar _MENU_ senarai",
		 					"sInfo": "Papar _START_-_END_ dari _TOTAL_ rekod",
							"sInfoEmpty": "Showing 0 to 0 of 0 records",
							    "oPaginate": {
							      "sFirst": "Pertama",
							      "sLast": "Terakhir",
							      "sNext": "Seterus",
							      "sPrevious": "Sebelum"
							     }
	 						 },
		});
		<?php if('cc' == $pentaksiran){ ?>
		var oTable = $('#pelajar_akademik_cantum').dataTable({
			"iDisplayLength" : 100,
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bAutoWidth": true,
			"sScrollX": "100%",
 			"sScrollXInner": "150%",
 			"bScrollCollapse": true
		});
		
		new FixedColumns( oTable, {
 		"iLeftColumns": 4
 		} );
		<?php } ?>

	});
	
</script>
<?php //$gred_akademik; ?>
<legend><h3>Pentaksiran Markah Akademik / Vokasional</h3></legend>
<center>

<form id="frm_pusat" action="<?= site_url('examination/general_marking/view_list')?>" method="post" >
<table class="breadcrumb border" width="100%" align="center">
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
    <tr style="<?=$ul_type=="KV"?"display: none":""?>">
    	<td width="45%" height="35"><div align="right">Kod Pusat</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35" align="left">
            <div align="left">
                <?php
                if($ul_type=="KV"){
                	echo form_hidden('kodpusat', set_value('kodpusat')==""?$colname:set_value('kodpusat'));
                }else{
                	$dataKodPusat = array(
		              'name'        => 'kodpusat',
		              'id'          => 'kodpusat',
		              'value'       => set_value('kodpusat'),
		              'class'   => 'span4',
		              'size'        => '25'
		            );
					echo form_input($dataKodPusat);
				}
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
    	<td height="35"><div align="right">Pentaksiran</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
        	<?php
        	$dataPentaksiran['Sekolah'] = array(
		    'name'        => 'pentaksiran',
		    'id'          => 'pentaksiran',
		    'value'       => 'ps',
		    'checked'     => FALSE,
		    );

        	$dataPentaksiran["Pusat"] = array(
		    'name'        => 'pentaksiran',
		    'id'          => 'pentaksiran',
		    'value'       => 'pp',
		    'checked'     => FALSE,
		    );

			$attLabel = array(
							'class' => 'radio inline'
						);
			
			$valPentaksiran = set_value('pentaksiran');
			
			foreach($dataPentaksiran as $key => $curPentaksiran){
				if($valPentaksiran==$curPentaksiran["value"])
					$curPentaksiran["checked"] = TRUE;
				
				$curFormPentaksiran = form_radio($curPentaksiran);
				echo form_label($curFormPentaksiran.nbs(1).$key, '',$attLabel);
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
        	$attr_semester = ' required width="50%"';
        	$options_semester = array("" => '-- Sila Pilih --');
        		for($cur_semester = 1; $cur_semester <= 8; $cur_semester++)
        		{
        			$options_semester[$cur_semester] = $cur_semester;
				}
				
				echo form_dropdown('semester', $options_semester, set_value('semester'));
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
	if('ak' == $pilihan || 'vk' == $pilihan)
	{
		$hidden = array('curAssessment' => set_value('pentaksiran'),
		 'curSemester' => set_value('semester'),
		  'curYear' => set_value('slct_tahun'),
		  'curModType' => set_value('pengurusan'),
		  'curCourse' => set_value('slct_kursus'));
		 
		$attributes = array('name' => 'frmGeneralMarking', 'id' => 'frmGeneralMarking');
		echo form_open('examination/general_marking/process_marking', $attributes, $hidden);
		
		if('ps' == $pentaksiran || 'pp' == $pentaksiran){
?>
		<div align="right" style="margin-bottom: 10px;">
			<input name="Submit" type="button" class="btn btn-info btnSimpanGeneralMarking" id="btnSimpanGeneralMarking" value="Simpan Markah Murid">
		</div>

        <table cellpadding="0" cellspacing="0" border="0" class="display table table-striped table-bordered" id="pelajar" style="float: left; width: 100% !important; margin-bottom: 0px;" >
            <thead>
                <tr>
                    <th>Bil</th>
                    <th>Nama Murid</th>
                    <th>No MyKad</th>
                    <th>Angka Giliran</th>
                    <?php
					if(sizeof($subjek_akademik) > 0){
						
					 	foreach($subjek_akademik as $rsa){
					 ?>
                    <th><a href="javascript:void(0);" data-container="body" class="titleSubject" data-toggle="tooltip" title="<?=$rsa->mod_name?>"><?=$rsa->mod_paper?></a><br />
						(100)
                	</th>
                    <?php
						}
					}	
					?>
                </tr>
            </thead>
            <tbody>
            
             <?php
					if(sizeof($pelajar_akademik) > 0){
						$aka_pss = isset($_SESSION['aka_ps'])?$_SESSION['aka_ps']:'';
						$jp = json_decode($aka_pss, true);
						$i = 0;
					 	foreach($pelajar_akademik as $rpa){
							$i++;
					 ?>
                <tr>
                    <td><?=$i?></td>
                    <td><?=ucwords(strtolower($rpa->stu_name))?></td>
                    <td align="center"><?=$rpa->stu_mykad?></td>
                    <td align="center"><?=$rpa->stu_matric_no?></td>
                     <?php
                     $rsm = "";
					 
                     if(!empty($rpa->listModuleTakenMarksAk))
					 {
					 	$rsm = $rpa->listModuleTakenMarksAk;
					 }
					 
					if(sizeof($subjek_akademik) > 0){
					 	foreach($subjek_akademik as $rsa){
					 		 $mdId = 0;
					 		 $curMark = 0;
							 $marksId = 0; 
							 
					 		$curMTIndex = $rpa->stu_id.$rsa->mod_id;
							$totalMark = (($pentaksiran == "ps")?$rsa->mod_mark_school:$rsa->mod_mark_centre);
							
							// foreach($rsm as $r){
								// echo "<pre>";
								// print_r($r);
								// echo "</pre>";
							// }
							
							if(empty($rsm) || !array_key_exists($curMTIndex, $rsm)){
								$mVal = 0;
								$mVall = "0.0/$totalMark";
								$mValLast = 0.0;
								
								if(!empty($rsm) && !array_key_exists($curMTIndex, $rsm))
									$marksId = "X";
							}else
							{
								$mdId = $rsm[$curMTIndex]["md_id"];
								$curMark = $rsm[$curMTIndex]["marks_value"];
								$marksId = $rsm[$curMTIndex]["marks_id"];
								
								if($curMark != -99.99)
								{
									if('ak' == $pilihan){
										$mVal = sprintf("%.1f",$curMark);
										$mVall = sprintf("%.1f",$curMark/100*$totalMark)."/$totalMark";
										$mValLast = sprintf("%.1f",$curMark/100*$totalMark);
									}else{
										$mVal = sprintf("%.1f",$curMark/$totalMark*100);
										$mVall = sprintf("%.1f",$curMark)."/$totalMark";
										$mValLast = sprintf("%.1f",$curMark);									
									}
								}
								else {
									$mVal = "T";
									$mVall = "0.0/$totalMark";
									$mValLast = "T";
								}
							}
							
					 ?>
                    <td align="left"><input id="sub_<?=$mdId?>_<?=$rpa->stu_id?>" name="sub_<?=$mdId?>_<?=$rpa->stu_id?>" size="6" value="<?=$mVal?>" data-total="<?=$totalMark?>" type="text" class="span5 markah_akademik_sekolah"/> 
                    	<span id="cur_gred" style="text-align:center;"><?=$mVall?></span>
                    	<input type="hidden" id="cur_mark" name="mark_<?=$mdId?>_<?=$rpa->stu_id?>" value="<?=$mValLast?>">
                    	<input type="hidden" id="cur_totalMark" name="totalMark_<?=$mdId?>_<?=$rpa->stu_id?>" value="<?=$totalMark?>">
                    	<input type="hidden" name="markStatus_<?=$mdId?>_<?=$rpa->stu_id?>" value="<?=$marksId?>">
                    </td>
                    <?php
						}
					}	
					?>
                </tr>
                <?php
						}
					}	
					?>
            </tbody>
        </table>
<div align="right" style="margin-top: 10px;">
        	<input name="Submit" type="button" class="btn btn-info btnSimpanGeneralMarking" id="btnSimpanGeneralMarking" value="Simpan Markah Murid">
        </div>
<?php
		}
	}
}
?>
</form>

<script src="<?=base_url()?>assets/js/evaluation/process_marking.js" type="text/javascript"></script>