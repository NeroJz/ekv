<style>
.dataTables_filter {
   width: 50%;
   float: left;
   text-align: left;
}
</style>


<script language="javascript" type="text/javascript" >
	var kodkv = [
	 			<?= $centrecode ?>
	 		];
</script>

<script src="<?=base_url()?>assets/js/report/kv.attendance.js" type="text/javascript"></script>

<div>
<legend><h3>Jadual Kedatangan Calon Peperiksaan</h3></legend>


<form id="frm_pusat" class="form-inline" action="<?= site_url('report/attendance/attendance_system_print')?>" method="post" target="_blank">
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
    	<input type="text" name="kodpusat" id="kodpusat" class="span3" style="margin-left:0px; width:270px;"/>
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
	<td width="45%" height="35"><div align="right">Modul</div></td>
    <td width="3%" height="35"><div align="center">:</div></td>
    <td width="52%" height="35"><div align="left" id="divModul">
    	<select width="50%" name="modul" id="modul" style="width:270px;" class="validate[required]" disabled="true">
    	<option value="">-- Sila Pilih --</option>
    	</select>
    </td>
      
    </div>
    </td>
    </tr>
    <tr>
    	<td width="45%" height="35"><div align="right">Semester</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35"><div align="left"><select width="50%" name="semester" id="semester" style="width:270px;" class="validate[required]">
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
                <select id="statusID" name="status" style="width:270px;" class="validate[required]">
                	<option value="">-- Sila Pilih --</option>
            		<option value="1">Biasa</option>
            		<option value="2">Mengulang</option>
                </select>
            </div>
        </td>
    </tr>
    <tr>
    	<td></td>
    	<td height="35"><div align="right"></div></td>
        <td height="35">
        	<div align="left">
          		<input type="button" class="btn btn-info" name="btn_papar" value="Papar" id="btnPapar">
          		<input class="btn btn-info" type="submit" name="btn_cetak" value="Cetak" id="btnCetak">
        	</div>
        </td>
    </tr>
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
</table>
</form>
<div id="loading_process"></div>
<div id="form_attendance">
	<form id="formAttendance" name="formAttendance" class="form-inline">
		<table id="tblAttendance" cellpadding="0" cellspacing="0" border="0" 
			class="display table table-striped table-bordered" style="width: 100% !important; margin-bottom: -1px;" >
			<thead>
			</thead>
			<tbody>
			</tbody>
		</table>
	</form>
</div>
</div>

	


<!--
<button class="btn btn-primary pull-right"> Save </button>
-->
