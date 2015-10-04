<?php
/**************************************************************************************************
* File Name        : v_evaluation_repeat.php
* Description      : This File contain evaluation of repeat exam mark
* Author           : Norafiq Bin Mohd Azman Chew
* Date             : 16 August 2013
* Version          : -
* Modification Log : umairah 9/4/2014
* Function List	   : -
**************************************************************************************************/
?>

<legend><h3>Pentaksiran Mengulang Akademik dan Vokasional</h3></legend>
<center>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/evaluation/repeatmark.js"></script>
<form id="frm_marking" action="<?=site_url("examination/repeatmark/getstu_by")?>" method="post" >
<table class="breadcrumb border" width="100%" align="center">
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
    
    <tr>
    	<td width="40%" height="35"><div align="right">Kursus</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="57%" height="35">
        	<select id="slct_kursus" name="slct_kursus" style="width:270px;">
            	<option value="">-- Sila Pilih --</option>
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
    	<td height="35"><div align="right">Semester</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                <select id="slct_sem" name="slct_sem" style="width:270px;" 
                	class="validate[required]">
            		<option value="">-- Sila Pilih --</option>
            		<option <?php if(isset($semester) && $semester == 1) echo 'selected = "selected"'; ?> value="1">1</option>
                    <option <?php if(isset($semester) && $semester == 2) echo 'selected = "selected"'; ?> value="2">2</option>
                    <option <?php if(isset($semester) && $semester == 3) echo 'selected = "selected"'; ?> value="3">3</option>
                    <option <?php if(isset($semester) && $semester == 4) echo 'selected = "selected"'; ?> value="4">4</option>
                    <option <?php if(isset($semester) && $semester == 5) echo 'selected = "selected"'; ?> value="5">5</option> 
                    <option <?php if(isset($semester) && $semester == 6) echo 'selected = "selected"'; ?> value="6">6</option>
                    <option <?php if(isset($semester) && $semester == 7) echo 'selected = "selected"'; ?> value="7">7</option>
                    <option <?php if(isset($semester) && $semester == 8) echo 'selected = "selected"'; ?> value="8">8</option>
                    <option <?php if(isset($semester) && $semester == 9) echo 'selected = "selected"'; ?> value="9">9</option>
                    <option <?php if(isset($semester) && $semester == 10) echo 'selected = "selected"'; ?> value="10">10</option>
                </select>
            </div>
        </td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    	<td height="35">&nbsp;</td>
        <td height="35"> ATAU
        </td>
    </tr> 
    <tr>
    	<td height="35"><div align="right">Angka Giliran</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35"><div align="left">
        <?php
        	if(isset($nomatric))
        	{
        ?>
        		<input type="text" name="nomatrik" id="nomatrik" value="<?=$nomatric?>" style="width:256px;">
        <?php
        	}
        	else if(isset($enomatric))
        	{
         ?>
        		<input type="text" name="nomatrik" id="nomatrik" value="<?=$enomatric?>" style="width:256px;">
        <?php
        	}
        	else
        	{
        ?>
        		<input type="text" name="nomatrik" id="nomatrik" style="width:256px;">
        <?php
        	}
        ?>
        </td>
    </tr>
    <tr>
    	<td>&nbsp;</td>
    	<td height="35">&nbsp;</td>
        <td height="35">
			<button id="btn_cari" class="btn btn-info" type="button">
	           <span>Cari Murid</span>
	        </button>
        </td>
    </tr>
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
</table>
</form>
</center>

<?php
if(isset($repeatstd))
{
?>
<table id="tblStudent" width="100%" align="center"  
	cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered"
	style="float:left;">
	<thead>
	<tr>
		<th width="3%">BIL</th>
		<th align="center" width="25%">NAMA MURID</th>
		<th align="center" width="12%">ANGKA GILIRAN</th>
		<th align="center" width="20%">KURSUS</th>
		<th align="center" width="30%">MODUL MENGULANG</th>
		<th align="center" width="17%">SEMESTER</th>
	</tr>	
	</thead>
	<tbody>
	<?php
		$bil = 1;
		foreach($repeatstd as $rep)
		{
	?>
			<tr>
				<td><?=$bil?></td>
				<td><?=ucwords(strtolower($rep->stu_name))?></td>
				<td><?=$rep->stu_matric_no?></td>
				<td><?=$rep->cou_name?></td>
				<td><a style="cursor: pointer;" onclick="fnOpenMark(<?=$rep->md_id?>)"><?=$rep->mod_paper?> - <?=$rep->mod_name?>&nbsp;&nbsp; <img src="<?=base_url()?>assets/img/edit.png"></a></td>
				<td><?=$rep->mt_semester?></td>
			</tr>
	<?php
		}
	?>
	</tbody>
</table><div class="clearfix"></div>
<?php
}
else if(isset($enomatric))
{
?>
	<div class="alert alert-error">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<h4>Carian Tidak Sah!</h4>
  		Sila Kosongkan ruangan Angka Giliran !
	</div>
<?php
}
else
{
?>
	<div class="alert alert-block">
  		<button type="button" class="close" data-dismiss="alert">&times;</button>
  		<h4>Perhatian</h4>
  		Tiada Maklumat Murid Mengulang !
	</div>
<?php
}
?>

<div class="modal hide fade" id="repeatpop" style="left:50%;">
    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" 
		    aria-hidden="true">&nbsp;&times;&nbsp;</button>
        <h3><strong>Masukan Markah Modul Mengulang</strong></h3>
    </div>
    <div class="modal-body" style="overflow-y:visible;">
        <form id="formRepeatMark" name="formRepeatMark" style="margin: 0px; position:relative;" 
        	action="" method="post" >
			<br />   	
        	<table id="tblRepeatnMarks" style="margin-bottom: 10px;" 
        		class="table table-striped table-bordered table-condensed">
            	<thead>
            		<tr>
            			<th align="left" >Modul</th>
            			<th align="left" width="20%">Markah</th>
            			<th align="left" width="20%">Jumlah(%)</th>
                	</tr>
                </thead>
                <tbody>
                	<tr>
                		<td><span id="modulesubjek"></span></td>
                		<td><input type="text" id="rmarkah" name="rmarkah" class="validate[required] cellMarks span9"></td>
                		<td><input type="text" id="jrmarkah" name="jrmarkah" class="span9 jum_markah" readonly="readonly">
                			<input type="hidden" id="modcentre" name="modcentre" >
                			<input type="hidden" id="modid" name="modid" >
                		</td>
                	</tr>    
                </tbody>               
            </table>
            
            <div style="float:right; width:155px;">
            	<button id="btnSaveRepeatMarks" type="button" 
	            	class="btn btn-primary pull-right"><span>SIMPAN</span></button>
            </div>
            
            <br />
            <br />
        </form>        
        <div id="configProgress" style="text-align:center;"></div>
    </div>
</div>

<?php
/**************************************************************************************************
* End of v_evaluation_repeat.php
**************************************************************************************************/
?>