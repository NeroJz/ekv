<?php
/**************************************************************************************************
* File Name        : v_evaluation_form.php
* Description      : This File contain evaluation of exam mark
* Author           : Norafiq Bin Mohd Azman Chew
* Date             : 3 July 2013
* Version          : -
* Modification Log : -
* Function List	   : -
**************************************************************************************************/

?>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/evaluation/markings.js"></script>
<legend><h3>Pentaksiran Berterusan Akademik</h3></legend>
<center>
<input type="hidden" id="ksmid" value="" name="ksmid" />

<form id="frm_marking" action="<?= site_url('examination/markings/select_configuration')?>" method="post" >
<table class="breadcrumb border" width="100%" align="center">
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Semester</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                <select id="slct_tahun" name="slct_tahun" style="width:270px;" 
                	class="validate[required]">
            		<option value="">-- Sila Pilih --</option>
                    <option <?php if(isset($semesterP) && $semesterP == 1) echo 'selected = "selected"'; ?> value="1">1</option> 
                    <option <?php if(isset($semesterP) && $semesterP == 2) echo 'selected = "selected"'; ?> value="2">2</option>
                    <option <?php if(isset($semesterP) && $semesterP == 3) echo 'selected = "selected"'; ?> value="3">3</option>
                    <option <?php if(isset($semesterP) && $semesterP == 4) echo 'selected = "selected"'; ?> value="4">4</option>
                    <option <?php if(isset($semesterP) && $semesterP == 5) echo 'selected = "selected"'; ?> value="5">5</option> 
                    <option <?php if(isset($semesterP) && $semesterP == 6) echo 'selected = "selected"'; ?> value="6">6</option>
                    <option <?php if(isset($semesterP) && $semesterP == 7) echo 'selected = "selected"'; ?> value="7">7</option>
                    <option <?php if(isset($semesterP) && $semesterP == 8) echo 'selected = "selected"'; ?> value="8">8</option>
                    <option <?php if(isset($semesterP) && $semesterP == 9) echo 'selected = "selected"'; ?> value="9">9</option>
                    <option <?php if(isset($semesterP) && $semesterP == 10) echo 'selected = "selected"'; ?> value="10">10</option>
                </select>
            </div>
        </td>
    </tr>
    <tr>
    	<td width="40%" height="35"><div align="right">Kursus</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="57%" height="35">
        	<select id="slct_kursus" name="slct_kursus" style="width:270px;" 
        		class="validate[required]">
            <option value="-1">-- Sila Pilih --</option>
            <?php			
				foreach ($kursus as $row)
				{
			?>
					<option value="<?= $row->cou_id ?>"
					<?php
					if(isset($kursusID) && $kursusID == $row->cou_id)
						echo 'selected="selected"';
					?>
					>
					    <?= strtoupper($row->cou_course_code.'  - '.$row->cou_name ) ?>
                    </option>
		    <?php 
				}
			?>
            </select>
        </td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Modul</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35"><div align="left">
        	<select id="slct_jubject" name="slct_jubject" style="width:270px;" 
        		class="validate[required]"  
        		<?php
	            	if(!isset($subjek))
	        			echo 'disabled="disabled"';
        		?>
        	>
            <option value="">-- Sila Pilih --</option>
            <?php
            if(isset($subjek))
			{
				foreach($subjek as $s)
				{
					if(isset($subjectID) && $subjectID == $s->mod_id)
					{
						echo '<option selected="selected" value="'.$s->mod_id.':'.$s->mod_type.':'.$s->cm_id.'">'.
							strtoupper($s->mod_code.' - '.$s->mod_name).'</option>';
						$subjekName = strtoupper($s->mod_name);
					}						
					else
					{
						echo '<option value="'.$s->mod_id.':'.$s->mod_type.':'.$s->cm_id.'">'.
							strtoupper($s->mod_code.' - '.$s->mod_name).'</option>';
					}						
				}				
			}
            ?>
            </select>
        </td>
    </tr>    
    <tr>
    	<td></td>
    	<td height="35"><div align="right"></div></td>
        <td height="35">
        	<div align="left">
          	<?php
            	if(isset($assessType) && $assessType == "VK")
				{					
            ?>	            
	          		<button id="btn_config_markP" class="btn btn-info" type="button">
	                    <span>Penetapan Markah</span>
	                </button>
	        <?php
				}
				else
				{
			?>
					<button id="btn_config_markP" class="btn btn-info" type="button" disabled="disabled">
	                    <span>Penetapan Markah</span>
	                </button>
			<?php
				}
	        ?>
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
/*if(isset($noopen) && $noopen)
{
	echo "<div style ='font:14px/21px Arial,tahoma,sans-serif;color:#d4271f'>Kemasukkan markah belum dibuka</div><br/>";
}*/
if(isset($senaraipelajar))
{
	//echo "<pre>";
	//print_r($senaraipelajar);
	//echo "</pre>";				//FDP
	
	if(isset($subjekconfigur))
	{
?>
<table id="tblStudent" width="100%" align="center"  
	cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered"
	style="float:left;">
	<thead>
	<tr style="background-color: white;">
		<th width="3%">BIL</th>
		<th align="left" width="30%">NAMA MURID</th>
		<th align="left" width="10%">ANGKA GILIRAN</th>
		<?php
		$j = 0;
		foreach($subjekconfigur as $sbc)
		{
			$assignment = strtolower($sbc->assgmnt_name);
				
			if(strtoupper($assignment) == "TEORI")
			{
					
				//if(isset($teoriOpen) && $teoriOpen)
				//{
		?>
					<th align="center" width="4%">
						<a onclick="fnOpenAssignment(<?=$sbc->assgmnt_id?>)">
							<?=strtoupper($assignment)?> / <?=$sbc->assgmnt_mark?>
							&nbsp;&nbsp;<img src="<?=base_url()?>assets/img/edit.png">
						</a>
					</th>
		<?php
				//}
				//else if(isset($teoriOpen) && !$teoriOpen)
				//{
				//	echo ("<div style ='font:14px/21px Arial,tahoma,sans-serif;color:#d4271f'>*Kemasukkan Markah Teori tidak dibuka</div><br/>");
				//}
			}
			else if(strtoupper($assignment) == "AMALI")
			{
				//if(isset($amaliOpen) && $amaliOpen)
				//{
		?>
					<th align="center" width="4%">
						<a onclick="fnOpenAssignment(<?=$sbc->assgmnt_id?>)">
							<?=strtoupper($assignment)?> / <?=$sbc->assgmnt_mark?>
							&nbsp;&nbsp;<img src="<?=base_url()?>assets/img/edit.png">
						</a>
					</th>
		<?php
				//}				
				//else if(isset($amaliOpen) && !$amaliOpen)
				//{
				//	echo ("<div style ='font:14px/21px Arial,tahoma,sans-serif;color:#d4271f'>*Kemasukan Markah Amali tidak dibuka</div><br/>");
				//}
			}
			else
			{
				if($assessType == "AK")
				{
					//if(isset($academikOpen) && $academikOpen)
					//{
		?>
						<th align="center" width="4%">
							<a onclick="fnOpenAssignment(<?=$sbc->assgmnt_id?>)">
								<?=strtoupper($assignment)?>
								&nbsp;&nbsp;<img src="<?=base_url()?>assets/img/edit.png">
							</a>
						</th>
		<?php
					//}
					//else if(isset($academikOpen) && !$academikOpen)
					//{
					//	echo ("<div style ='font:14px/21px Arial,tahoma,sans-serif;color:#d4271f'>*Kemasukan Markah Akademik tidak dibuka</div><br/>");
					//}
				}
			}
						
			$j +=  $sbc->assgmnt_mark;
		}
		?>
		<th width="8%">JUMLAH / <?=$j?></th>
	</tr>
	</thead>
	<tbody>
	<?php
	$i = 1;
	foreach ($senaraipelajar as $row)
	{
	?>
	<tr>
		<td align="center"><?=$i?></td>
		<td align="left"><?=strtoupper($row->stu_name)?></td>
		<td align="left"><?=$row->stu_matric_no?></td>
		<?php
		$k = 0;
		foreach($subjekconfigur as $sbc)
		{			
			$assignment = strtolower($sbc->assgmnt_name);
			
			if(strtoupper($assignment) == "TEORI")
			{
				//if(isset($teoriOpen) && $teoriOpen)
				//{
		?>
					<td align="center">
						<input type="text" readonly="readonly" name="jumlah<?=$row->stu_id?><?=$sbc->assgmnt_id?>" 
							id="jumlah<?=$row->stu_id?><?=$sbc->assgmnt_id?>" style="width: 100px;" value="<?=$row->markah[$k] ?>">
					</td>
		<?php
				//}
			}
			else if(strtoupper($assignment) == "AMALI")
			{
				//if(isset($amaliOpen) && $amaliOpen)
				//{
		?>
					<td align="center">
						<input type="text" readonly="readonly" name="jumlah<?=$row->stu_id?><?=$sbc->assgmnt_id?>" 
							id="jumlah<?=$row->stu_id?><?=$sbc->assgmnt_id?>" style="width: 100px;" value="<?=$row->markah[$k] ?>">
					</td>
		<?php
				//}
			}
			else
			{
				//if(isset($academikOpen) && $academikOpen)
				//{
		?>
					<td align="center">
						<input type="text" readonly="readonly" name="jumlah<?=$row->stu_id?><?=$sbc->assgmnt_id?>" 
					 	id="jumlah<?=$row->stu_id?><?=$sbc->assgmnt_id?>" style="width: 100px;" value="<?=$row->markah[$k] ?>">
					</td>
		<?php
				//}
			}
			
			$k++;
		}
		?>
		<td id="ttlMark_<?=$row->stu_id?>" align="center" class="ttlmrks">
			<?php
				if(isset($row->markah[1]))
				{
					if($row->markah[0]=='T' && $row->markah[1]=='T')
					{
						echo "T";
					}
					else
					{
						$totalM = 0.00;
						
						if($row->markah[0] > 0)
						$totalM = $totalM + $row->markah[0];
						
						if($row->markah[1] > 0)
						$totalM = $totalM + $row->markah[1];
						
						echo $totalM;
					}
				}
				else
				{
					if($row->markah[0]=='T')
					{
						echo "T";
					}
					else
					{
						$totalM = 0.00;
						
						if($row->markah[0] >0)
						$totalM = $totalM + $row->markah[0];
						
						echo $totalM;
					}
				}
			?>
		</td>
	</tr>			
	<?php
		$i++;	
	}		
	?>
	</tbody>
</table><div class="clearfix"></div>
<div align="right">
	<!--<button id="btn_save_mark" class="btn btn-info" type="button">
        <span>SIMPAN MARKAH</span>
    </button>-->
</div>
<?php
	}
}
?>

<div class="modal hide fade" id="myModal" style="width:66%; left:40%;">
    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" 
		    aria-hidden="true">&nbsp;&times;&nbsp;</button>
        <h3><strong>Pentaksiran Berterusan </strong></h3>
    </div>
    <div class="modal-body" >
        <form id="formConfig" name="formConfig" style="position:relative;" 
        	action="<?=site_url("examination/markings/save_configurations")?>" method="post">
        	
        	<input type="hidden" id="ksmid2" value="" name="ksmid2" />
        	<input type="hidden" id="kursusid" name="kursusid" value="" />
			<input type="hidden" id="subjectid" name="subjectid" value="" />
			<input type="hidden" id="semesterP" name="semesterP" value="" />
			<input type="hidden" id="pentaksiran" name="pentaksiran" value="" />
			<input type="hidden" id="mptID" name="mptID" value="" />
			<input type="hidden" id="tempKAt2" name="tempKAt2" value="" /><!-- temp utk function AK -->
			
        	<table id="tbltask" style="margin-bottom:5px;" 
        		class="table table-striped table-bordered table-condensed">
            	<thead>
                <tr>
                	<td width="225" ><strong><span id="katTugasan"></span></strong></td>
                  	<td width="175" ><strong>Markah Tugasan(<span id="percent"></span>%)</strong></td>
                  	<td width="175" ><strong>Jumlah Tugasan</strong></td>
                  	<td width="175" ><strong>Pilihan Jumlah Tugasan</strong></td>
                  	<td>&nbsp;</td>
              	</tr>
                </thead>
                <tbody id="catPentaksiran">                
                </tbody>
                <tfoot>
                <tr>
                	<td align="right"><strong>Jumlah Markah Tugasan :</strong></td>
                  	<td colspan="4" align="left"><span id="jumlahMarkahTugasan"></span>%</td>
              	</tr>
              	</tfoot>         
            </table>
            
            <div id="tambahTugasan" class="pull-left">
            </div>
            
            <div class="pull-right">            	
            	<button id="btnSaveConfig" type="submit" name="btnSaveConfig" 
            		class="btn btn-primary" disabled="disabled"><span>SIMPAN</span></button>
            </div>
            <br />
            <br />
        </form>
        <div id="configProgress" style="text-align:center;"></div>
    </div>
</div>

<div class="modal hide fade" id="assgmnpop" style="width:80%; left:25%;">
    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" 
		    aria-hidden="true">&nbsp;&times;&nbsp;</button>
        <h3><strong id="markHeader"></strong></h3>
        <h4 id="paparanAgihan"></h4>
    </div>
    <div class="modal-body" >
        <form id="formAssgMark" name="formAssgMark" style="position:relative;" 
        	action="" method="post" >
        	<input type="hidden" id="mark_assg_selection" name="mark_assg_selection" />
        	<input type="hidden" id="mark_total_assg" name="mark_total_assg" />
        	<input type="hidden" id="semesterP4" name="semesterP4" value="" />
			<input type="hidden" id="mptID4" name="mptID4" value="" />
			<input type="hidden" id="category" name="category" value=""/>
			
        	<table id="tblAssgnMarks" style="margin-bottom:0px;" 
        		class="table table-striped table-bordered table-condensed" >
            	<thead>
            		
                </thead>
                <tbody>
                	             
                </tbody>               
            </table>
            <input type="hidden" id="mark_assg_selection" name="mark_assg_selection" value="" />
            <div style="float:right; display:inline-block;">
	            <button id="btnSaveAssgMarks" type="button" disabled="disabled" style="margin-top:10px; "
	            	class="btn btn-primary pull-right"><span>SIMPANs</span></button>
            </div>
            <br />
            <br />
        </form>
        <div id="configProgress" style="text-align:center;"></div>
    </div>
</div>
<form id="loadStudent" name="loadStudent" action="<?=site_url("examination/markings/load_configurations")?>" method="post">
<input type="hidden" id="ksmid3" value="" name="ksmid3" />
<input type="hidden" id="kursusid3" name="kursusid3" value="" />
<input type="hidden" id="subjectid3" name="subjectid3" value="" />
<input type="hidden" id="semesterP3" name="semesterP3" value="" />
<input type="hidden" id="pentaksiran3" name="pentaksiran3" value="" />
<input type="hidden" id="mptID3" name="mptID3" value="" />

<input type="hidden" id="tempKAt" name="tempKAt" value="" /><!-- temp utk function AK -->

</form>
<?php
/**************************************************************************************************
* End of v_evaluation_form.php
**************************************************************************************************/
?>