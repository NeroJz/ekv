<?php if(isset($pentaksiran) && 'cc' == $pentaksiran){ ?>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/FixedColumns.js"></script>
<?php } 

function getGred($iMark)
{
	$cGred = "";
	if($iMark >= 0 && $iMark <= 34)
			{
				$cGred = "E";
			}
			else if($iMark >= 35 && $iMark <= 39)
			{
				$cGred = "D-";
			}
			else if($iMark >= 40 && $iMark <= 44)
			{
				$cGred = "D";
			}
			else if($iMark >= 45 && $iMark <= 49)
			{
				$cGred = "D+";
			}
			else if($iMark >= 50 && $iMark <= 54)
			{
				$cGred = "C";
			}
			else if($iMark >= 55 && $iMark <= 59)
			{
				$cGred = "C+";
			}
			else if($iMark >= 60 && $iMark <= 64)
			{
				$cGred = "B-";
			}
			else if($iMark >= 65 && $iMark <= 69)
			{
				$cGred = "B";
			}
			else if($iMark >= 70 && $iMark <= 79)
			{
				$cGred = "B+";
			}
			else if($iMark >= 80 && $iMark <= 89)
			{
				$cGred = "A-";
			}
			else if($iMark >= 90 && $iMark <= 100)
			{
				$cGred = "A";
			}
			else
			{
				$cGred = "";
			}
	return $cGred;
}
?>
<script language="javascript" type="text/javascript" >
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
			"bAutoWidth": true,
			"sScrollX": "100%",
 		"sScrollXInner": "150%",
 		"bScrollCollapse": true
		});
		
		new FixedColumns( oTable, {
 		"iLeftColumns": 4
 		} );
		<?php } ?>
		
		
		
		$('#btn_simpan').click(function(){
			alert("Markah Telah Disimpan");
		});
		
		$('#btn_simpan2').click(function(){
			alert("Markah Telah Disimpan");
		});
		
		/*$('.marks').bind('change',function(event){
			var iMark =$(this).val();
			var cGred = "";
			
			if(iMark >= 0 && iMark <= 34)
			{
				cGred = "E";
			}
			else if(iMark >= 35 && iMark <= 39)
			{
				cGred = "D-";
			}
			else if(iMark >= 40 && iMark <= 44)
			{
				cGred = "D";
			}
			else if(iMark >= 45 && iMark <= 49)
			{
				cGred = "D+";
			}
			else if(iMark >= 50 && iMark <= 54)
			{
				cGred = "C";
			}
			else if(iMark >= 55 && iMark <= 59)
			{
				cGred = "C+";
			}
			else if(iMark >= 60 && iMark <= 64)
			{
				cGred = "B-";
			}
			else if(iMark >= 65 && iMark <= 69)
			{
				cGred = "B";
			}
			else if(iMark >= 70 && iMark <= 79)
			{
				cGred = "B+";
			}
			else if(iMark >= 80 && iMark <= 89)
			{
				cGred = "A-";
			}
			else if(iMark >= 90 && iMark <= 100)
			{
				cGred = "A";
			}
			else
			{
				cGred = "";
			}
			
			$(this).next('#cur_gred').html(cGred);
			
		});*/
		
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
<legend><h3>Pentaksiran Akademik / Vokasional</h3></legend>
<center>

<form id="frm_pusat" action="<?= site_url('peperiksaan/pemarkahan/pilihanpengurusan')?>" method="post" >
<table class="breadcrumb border" width="100%" align="center">
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
    <tr>
    	<td width="45%" height="35"><div align="right">Kod Pusat</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35" align="left">
            <div align="left">
                <input id="kodpusat" name="kodpusat" size="25" type="text" class="span4"/>
            </div>            
        </td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Pengurusan</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                <input type="radio" name="pengurusan" id="pengurusan" value="ak" <?=$this->input->post('pengurusan')!="ak"?'':'checked="checked"'?>>&nbsp;Akademik&nbsp;&nbsp;
                <input type="radio" name="pengurusan" id="pengurusan" value="vk" <?=$this->input->post('pengurusan')!="vk"?'':'checked="checked"'?>>&nbsp;Vokasional
            </div>
        </td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Pentaksiran</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                <input type="radio" name="pentaksiran" value="ps" <?=$this->input->post('pentaksiran')!="ps"?'':'checked="checked"'?>>&nbsp;Sekolah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="pentaksiran" value="pp" <?=$this->input->post('pentaksiran')!="pp"?'':'checked="checked"'?>>&nbsp;Pusat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="pentaksiran" value="cc" <?=$this->input->post('pentaksiran')!="cc"?'':'checked="checked"'?>>&nbsp;Cantum
            </div>
        </td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Kursus</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35"><div align="left">
        	<select id="slct_kursus" name="slct_kursus" style="width:270px;" class="validate[required]">
            <option value="">-- Sila Pilih --</option>
            <?php			
				foreach ($kursus as $row)
				{
			?>
					<option value="<?= $row->cou_id ?>">
					    <?= strtoupper($row->cou_code.'  - '.$row->cou_name ) ?>
                    </option>
		    <?php 
				} 
			?>
            </select>
        </td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Tahun</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                <select id="slct_tahun" name="slct_tahun" style="width:270px;" class="validate[required]">
            		<option value="">-- Sila Pilih --</option>
                    <option value="10">2010</option>
                    <option value="11">2011</option>
                    <option value="12">2012</option>
                    <option value="13">2013</option>
                </select>
            </div>
        </td>
    </tr>
    <tr>
    	<td></td>
    	<td height="35"><div align="right"></div></td>
        <td height="35">
        	<div align="left">
          		<input class="btn btn-info" type="submit" name="btn_papar" value="Papar Pelajar">
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
		if('ps' == $pentaksiran){
?>

<input type="hidden" name="penilaian" value="ps" />
        <table cellpadding="0" cellspacing="0" border="0" class="display" id="pelajar">
            <thead>
                <tr>
                    <th>Bil</th>
                    <th>Nama Pelajar</th>
                    <th>No Kad Pengenalan</th>
                    <th>Angka Giliran</th>
                    <?php
					if(sizeof($subjek_akademik) > 0){
					 	foreach($subjek_akademik as $rsa){
					 ?>
                    <th><?=$rsa->kod_subjek_modul?><br />
                    <?=$rsa->nama_subjek_modul?><br />
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
                    <td><?=strtoupper($rpa->nama_pelajar)?></td>
                    <td align="center"><?=$rpa->no_kp?></td>
                    <td align="center"><?=$rpa->angka_giliran?></td>
                     <?php
					if(sizeof($subjek_akademik) > 0){
					 	foreach($subjek_akademik as $rsa){
							if(empty($aka_pss)){
								$mVal = 0;
								$mVall = "0.0/30";
							}else
							{
								$mVal = $jp[$rpa->id_pelajar][$rsa->subjek_id];
								$mVall = sprintf("%.1f",($mVal/100)*30)."/30";
							}
					 ?>
                    <td align="center"><input id="sub_<?=$rsa->subjek_id?>" name="sub_<?=$rsa->subjek_id?>_<?=$rpa->id_pelajar?>" size="10" value="<?=$mVal?>" type="text" class="span6 markah_akademik_sekolah"/> <span id="cur_gred" style="text-align:center;"><?=$mVall?></span></td>
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
        </table><br />

<div align="right">
        	<input name="Submit" type="submit" class="btn btn-info" id="btn_simpan" value="Simpan Markah Pelajar">
        </div>
<?php
		}
		else if('pp' == $pentaksiran){
			?>
            pp
            <input type="hidden" name="penilaian" value="pp" />
             <table cellpadding="0" cellspacing="0" border="0" class="display" id="pelajar">
            <thead>
                <tr>
                    <th>Bil</th>
                    <th>Nama Pelajar</th>
                    <th>No Kad Pengenalan</th>
                    <th>Angka Giliran</th>
                    <?php
					$arrTotal = array(100,60,60,70,70,80,80);
					if(sizeof($subjek_akademik) > 0){
						$i = 0;
					 	foreach($subjek_akademik as $rsa){
					 ?>
                    <th><?=$rsa->kod_subjek_modul?><br />
                    <?=$rsa->nama_subjek_modul?><br />
						(<?=$arrTotal[$i]?>)
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
						$aka_ppp = isset($_SESSION['aka_pp'])?$_SESSION['aka_pp']:'';
						$jp = json_decode($aka_ppp, true);
						$i = 0;
					 	foreach($pelajar_akademik as $rpa){
							$i++;
					 ?>
                <tr>
                    <td><?=$i?></td>
                    <td><?=strtoupper($rpa->nama_pelajar)?></td>
                    <td align="center"><?=$rpa->no_kp?></td>
                    <td align="center"><?=$rpa->angka_giliran?></td>
                     <?php
					if(sizeof($subjek_akademik) > 0){
						$j = 0;
					 	foreach($subjek_akademik as $rsa){
							if(empty($aka_ppp)){
								$mVal = 0;
								$mVall = "0.0/70";
							}else
							{
								$mVal = $jp[$rpa->id_pelajar][$rsa->subjek_id];
								$mVall = sprintf("%.1f",($mVal/$arrTotal[$j])*70)."/70";
							}
					 ?>
                    <td align="center"><input id="sub_<?=$rsa->subjek_id?>_<?=$arrTotal[$j]?>" name="sub_<?=$rsa->subjek_id?>_<?=$rpa->id_pelajar?>" value="<?=$mVal?>" size="10" type="text" class="span6 markah_akademik_pusat"/> <span id="cur_gred" style="text-align:center;"><?=$mVall?></span>
                    </td>
                    <?php
					$j++;
						}
					}	
					?>
                </tr>
                <?php
						}
					}	
					?>
            </tbody>
        </table><br />

<div align="right">
        	<input name="Submit" type="submit" class="btn btn-info" id="btn_simpan" value="Simpan Markah Pelajar">
        </div>
        
            <?php
		}
		else if('cc' == $pentaksiran){
			?>
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="pelajar_akademik_cantum">
            <thead>
                <tr>
                    <th>Bil</th>
                    <th>Nama Pelajar</th>
                    <th>No Kad Pengenalan</th>
                    <th>Angka Giliran</th>
                    <?php
					$arrTotal = array(100,60,60,70,70,80,80);
					if(sizeof($subjek_akademik) > 0){
						$i = 0;
					 	foreach($subjek_akademik as $rsa){
					 ?>
                    <th><?=$rsa->kod_subjek_modul?><br />
                    <?=$rsa->nama_subjek_modul?>
                	</th>
                    <th><?=$rsa->kod_subjek_modul?><br />
                    <?=$rsa->nama_subjek_modul?>
                	</th>
                    <?php
					$i++;
						}
						 	foreach($subjek_akademik as $rsa){
							 ?>
							<th><?=$rsa->kod_subjek_modul?><br />
							<?=$rsa->nama_subjek_modul?>
							</th>
							<?php
							$i++;
								}
								
								foreach($subjek_akademik as $rsa){
							 ?>
							<th><?=$rsa->kod_subjek_modul?><br />
							<?=$rsa->nama_subjek_modul?>
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
						$aka_pss = isset($_SESSION['aka_ps'])?$_SESSION['aka_ps']:'';
						$jp = json_decode($aka_pss, true);
						$aka_ppp = isset($_SESSION['aka_pp'])?$_SESSION['aka_pp']:'';
						$jp2 = json_decode($aka_ppp, true);
						$i = 0;
						
						$sgred_aka = array();
						
					 	foreach($pelajar_akademik as $rpa){
							$i++;
							
					 ?>
                <tr>
                    <td><?=$i?></td>
                    <td><?=strtoupper($rpa->nama_pelajar)?></td>
                    <td align="center"><?=$rpa->no_kp?></td>
                    <td align="center"><?=$rpa->angka_giliran?></td>
                     <?php
					if(sizeof($subjek_akademik) > 0){
						$j = 0;
						$jum_markah = array();
						$sgred_cur = array();
						$mVall = 0;
						$mVal2 = 0;
					 	foreach($subjek_akademik as $rsa){
							if(empty($aka_pss)){
								$mVal = 0;
								$mVall = "0.0";
							}else
							{
								$mVal = $jp[$rpa->id_pelajar][$rsa->subjek_id];
								$mVall = sprintf("%.1f",($mVal/100)*30);
							}
							
							if(empty($aka_ppp)){
								$mVal = 0;
								$mVal2 = "0.0";
							}else
							{
								$mVal = $jp2[$rpa->id_pelajar][$rsa->subjek_id];
								$mVal2 = sprintf("%.1f",($mVal/$arrTotal[$j])*70);
							}
							
							$jum_markah[] = ceil($mVall+$mVal2);
					 ?>
                    <td align="center" bgcolor="#FFFF00"><span id="cur_gred" style="text-align:center;"><?=$mVall?></span>
                    <td align="center"><span id="cur_gred2" style="text-align:center;"><?=$mVal2?></span>
                    </td>
                    <?php
					$j++;
						}
						$j = 0;
						foreach($subjek_akademik as $rsa){
							?>
                    <td align="center" bgcolor="#CCCCCC"><span id="cur_gred" style="text-align:center;"><?=$jum_markah[$j]?></span>
							<?php
							$j++;
						}
						
						$j = 0;
						foreach($subjek_akademik as $rsa){
							$sgred_cur[$rsa->subjek_id] = getGred($jum_markah[$j]);
							?>
                    <td align="center" bgcolor="#00FFCC"><span id="cur_gred" style="text-align:center;"><?=getGred($jum_markah[$j])?></span>
							<?php
							$j++;
						}
					}	
					?>
                </tr>
                <?php
						$sgred_aka[$rpa->id_pelajar] = $sgred_cur;
						}
						$jgred_aka = json_encode($sgred_aka);
						$_SESSION['gred_aka'] = $jgred_aka;
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
		if('ps' == $pentaksiran){
?>
<input type="hidden" name="penilaian" value="ps" />
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="pelajar">
            <thead>
                <tr>
                    <th>Bil</th>
                    <th>Nama Pelajar</th>
                    <th>No Kad Pengenalan</th>
                    <th>Angka Giliran</th>
                    <?php
					if(sizeof($subjek_kv) > 0){
					 	foreach($subjek_kv as $rsa){
					 ?>
                  <th><?=$rsa->kod_subjek_modul?><br />
                    <?=$rsa->nama_subjek_modul?><br />
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
						$kv_pss = isset($_SESSION['kv_ps'])?$_SESSION['kv_ps']:'';
						$jp = json_decode($kv_pss, true);
						$i = 0;
					 	foreach($pelajar_akademik as $rpa){
							$i++;
					 ?>
                <tr>
                    <td><?=$i?></td>
                    <td><?=strtoupper($rpa->nama_pelajar)?></td>
                    <td align="center"><?=$rpa->no_kp?></td>
                    <td align="center"><?=$rpa->angka_giliran?></td>
                     <?php
					if(sizeof($subjek_kv) > 0){
					 	foreach($subjek_kv as $rsa){
							if(empty($kv_pss)){
								$mVal = 0;
								$mVall = "0.0/70";
							}else
							{
								$mVal = $jp[$rpa->id_pelajar][$rsa->subjek_id];
								$mVall = sprintf("%.1f",($mVal/100)*70)."/70";
							}
					 ?>
                    <td align="center"><input id="sub_<?=$rsa->subjek_id?>[]" name="sub_<?=$rsa->subjek_id?>_<?=$rpa->id_pelajar?>" size="10" value="<?=$mVal?>" type="text" class="span6 markah_kv_sekolah"/> <span id="cur_gred"><?=$mVall?></span></td>
                   <!-- <td align="center"><input id="gred_<?=$rsa->subjek_id?>[]" name="gred_<?=$rsa->subjek_id?>[]" size="10" type="text" class="span6"/></td>-->
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
        </table><br />

        <div align="right">
        	<input name="Submit" type="submit" class="btn btn-info" id="btn_simpan2" value="Simpan Markah Pelajar">
        </div>
<?php
		}
		else if('pp' == $pentaksiran){
		?>
        pp
        <input type="hidden" name="penilaian" value="pp" />
        <table cellpadding="0" cellspacing="0" border="0" class="display" id="pelajar">
            <thead>
                <tr>
                    <th>Bil</th>
                    <th>Nama Pelajar</th>
                    <th>No Kad Pengenalan</th>
                    <th>Angka Giliran</th>
                    <?php
					if(sizeof($subjek_kv) > 0){
					 	foreach($subjek_kv as $rsa){
					 ?>
                  <th><?=$rsa->kod_subjek_modul?><br />
                    <?=$rsa->nama_subjek_modul?><br />
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
						$i = 0;
							$kv_ppp = isset($_SESSION['kv_pp'])?$_SESSION['kv_pp']:'';
						$jp = json_decode($kv_ppp, true);
					 	foreach($pelajar_akademik as $rpa){
							$i++;
					 ?>
                <tr>
                    <td><?=$i?></td>
                    <td><?=strtoupper($rpa->nama_pelajar)?></td>
                    <td align="center"><?=$rpa->no_kp?></td>
                    <td align="center"><?=$rpa->angka_giliran?></td>
                     <?php
					if(sizeof($subjek_kv) > 0){
					 	foreach($subjek_kv as $rsa){
							
							if(empty($kv_ppp)){
								$mVal = 0;
								$mVall = "0.0/30";
							}else
							{
								$mVal = $jp[$rpa->id_pelajar][$rsa->subjek_id];
								$mVall = sprintf("%.1f",($mVal/100)*30)."/30";
							}
					 ?>
                    <td align="center"><input id="sub_<?=$rsa->subjek_id?>[]" name="sub_<?=$rsa->subjek_id?>_<?=$rpa->id_pelajar?>" size="10" type="text" value="<?=$mVal?>" class="span6 markah_kv_pusat"/> <span id="cur_gred"><?=$mVall?></span></td>
                   <!-- <td align="center"><input id="gred_<?=$rsa->subjek_id?>[]" name="gred_<?=$rsa->subjek_id?>[]" size="10" type="text" class="span6"/></td>-->
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
        </table><br />

        <div align="right">
        	<input class="btn btn-info" type="submit" id="btn_simpan2" value="Simpan Markah Pelajar">
        </div>
        <?php
		}
		else if('cc' == $pentaksiran){
			?>
			<table cellpadding="0" cellspacing="0" border="0" class="display" id="pelajar_akademik_cantum">
            <thead>
                <tr>
                    <th>Bil</th>
                    <th>Nama Pelajar</th>
                    <th>No Kad Pengenalan</th>
                    <th>Angka Giliran</th>
                    <?php
					$arrTotal = array(100,60,60,70,70,80,80);
					if(sizeof($subjek_kv) > 0){
						$i = 0;
					 	foreach($subjek_kv as $rsa){
					 ?>
                    <th><?=$rsa->kod_subjek_modul?><br />
                    <?=$rsa->nama_subjek_modul?>
                	</th>
                    <th><?=$rsa->kod_subjek_modul?><br />
                    <?=$rsa->nama_subjek_modul?>
                	</th>
                    <?php
					$i++;
						}
						 	foreach($subjek_kv as $rsa){
							 ?>
							<th><?=$rsa->kod_subjek_modul?><br />
							<?=$rsa->nama_subjek_modul?>
							</th>
							<?php
							$i++;
								}
								
								foreach($subjek_kv as $rsa){
							 ?>
							<th><?=$rsa->kod_subjek_modul?><br />
							<?=$rsa->nama_subjek_modul?>
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
						$aka_pss = isset($_SESSION['kv_ps'])?$_SESSION['kv_ps']:'';
						$jp = json_decode($aka_pss, true);
						$aka_ppp = isset($_SESSION['kv_pp'])?$_SESSION['kv_pp']:'';
						$jp2 = json_decode($aka_ppp, true);
						$i = 0;
						
						$sgred_kv = array();
					 	foreach($pelajar_akademik as $rpa){
							$i++;
					 ?>
                <tr>
                    <td><?=$i?></td>
                    <td><?=strtoupper($rpa->nama_pelajar)?></td>
                    <td align="center"><?=$rpa->no_kp?></td>
                    <td align="center"><?=$rpa->angka_giliran?></td>
                     <?php
					if(sizeof($subjek_kv) > 0){
						$j = 0;
						$jum_markah = array();
						
						$mVall = 0;
						$mVal2 = 0;
					 	foreach($subjek_kv as $rsa){
							if(empty($aka_pss)){
								$mVal = 0;
								$mVall = "0.0";
							}else
							{
								$mVal = $jp[$rpa->id_pelajar][$rsa->subjek_id];
								$mVall = sprintf("%.1f",($mVal/100)*70);
							}
							
							if(empty($aka_ppp)){
								$mVal = 0;
								$mVal2 = "0.0";
							}else
							{
								$mVal = $jp2[$rpa->id_pelajar][$rsa->subjek_id];
								$mVal2 = sprintf("%.1f",($mVal/$arrTotal[$j])*30);
							}
							
							$jum_markah[] = ceil($mVall+$mVal2);
					 ?>
                    <td align="center" bgcolor="#FFFF00"><span id="cur_gred" style="text-align:center;"><?=$mVall?></span>
                    <td align="center"><span id="cur_gred2" style="text-align:center;"><?=$mVal2?></span>
                    </td>
                    <?php
					$j++;
						}
						$j = 0;
						$sgred_cur= array();
						foreach($subjek_kv as $rsa){
							?>
                    <td align="center" bgcolor="#CCCCCC"><span id="cur_gred" style="text-align:center;"><?=$jum_markah[$j]?></span>
							<?php
							$j++;
						}
						
						$j = 0;
						foreach($subjek_kv as $rsa){
							$sgred_cur[$rsa->subjek_id] = getGred($jum_markah[$j]);
							?>
                    <td align="center" bgcolor="#00FFCC"><span id="cur_gred" style="text-align:center;"><?=getGred($jum_markah[$j])?></span>
							<?php
							$j++;
						}
					}	
					?>
                </tr>
                <?php
						$sgred_kv[$rpa->id_pelajar] = $sgred_cur;
						}
						$jgred_kv = json_encode($sgred_kv);
						$_SESSION['gred_kv'] = $jgred_kv;
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