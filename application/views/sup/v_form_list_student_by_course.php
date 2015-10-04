<?php
//print_r($kursus);
?>
<script type="text/javascript">

$(document).ready(function() 
{
	$("#frm_senarai").validationEngine('attach', {scroll: false});
});
</script>

<legend><h4>Senarai Kehadiran Peperiksaan</h4></legend>
<center>

<form id="frm_senarai" action="<?=site_url('sup/student/show_list') ?>" method="post" target="_blank">
<table class="breadcrumb border" width="100%" align="center">
    <tr>
      <td width="240" align="right">&nbsp;</td>
      <td width="10" align="center">&nbsp;</td>
      <td width="368" height="35" align="left" style="font-size: 16px;font-weight: bold;">&nbsp;</td>
    </tr>
    <tr>
    	<td width="240" height="35"><div align="right">Kursus</div></td>
        <td width="10" height="35"><div align="center">:</div></td>
        <td width="368" height="35">
        <div align="left">
        	<select id="slct_kursus" name="slct_kursus" style="width:270px;" class="validate[required]">
            <option value="">-- Sila Pilih --</option>
            <?php			
				foreach ($kursus as $row)
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
    	<td height="35"><div align="right">Tahun</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                <select id="slct_tahun" name="slct_tahun" style="width:270px;" class="validate[required]">
            		<option value="">-- Sila Pilih --</option>
                    <option value="2010">2010</option>
                    <option value="2011">2011</option>
                    <option value="2012">2012</option>
                    <option value="2013">2013</option>
                </select>
            </div>
        </td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Semester</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                <select id="slct_semester" name="slct_semester" style="width:270px;" class="validate[required]">
            		<option value="">-- Sila Pilih --</option>
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                </select>
            </div>
        </td>
    </tr>
    <tr>
    	<td></td>
    	<td height="35"><div align="right"></div></td>
        <td height="35">
        	<div align="left">
          		<input class="btn btn-info" type="submit" name="btn_papar" value="Cetak">
        	</div>
        </td>
    </tr>
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
</table>
</form>

</center>