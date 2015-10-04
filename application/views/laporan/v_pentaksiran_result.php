<script language="javascript" type="text/javascript" >
	$(document).ready(function()
	{	
		var kodkv = [
			"LB121",
			"KJ243",
			"PP723",
			"SB322",
			"KH982"
		];
		
		$( "#kodpusat" ).autocomplete({
			source: kodkv
		});	
	});
	
</script>

<legend><h3>Keputusan Pentaksiran</h3></legend>
<center>

<form id="frm_pusat" action="<?= site_url('laporan/result/paparresult')?>" method="post" target="_blank">
<table class="breadcrumb border" width="100%" align="center">
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
    <tr>
    	<td width="45%" height="35"><div align="right">Kod Institusi</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35"><div align="left">
          <input type="text" name="kodpusat" id="kodpusat" class="span3" style="margin-left:0px"/>
        </div>
        </td>
    </tr>
     <tr>
    	<td height="35"><div align="right">Kursus</div></td>
        <td height="35"><div align="center">:</div></td>
        <td width="52%" height="35">
        <div align="left">
        	<select id="slct_kursus" name="slct_kursus" style="width:270px;" class="validate[required]">
            <option value="">-- Sila Pilih --</option>
            <?php			
				foreach ($kursus as $row)
				{
			?>
					<option value="<?= $row->kursus_id ?>">
					    <?= strtoupper($row->kod_kursus.'  - '.$row->kursus_kluster ) ?>
                    </option>
		    <?php 
				} 
			?>
            </select>
        </div>
        </td>
    </tr>
    
     <tr>
    	<td height="35"><div align="right">Semster</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                <select id="slct_sem" name="slct_sem" style="width:270px;" class="validate[required]">
            		<option value="">-- Sila Pilih --</option>
                    <option value="1">Semester 1</option>
                    <option value="2">Semester 2</option>
                    <option value="3">Semester 3</option>
                    <option value="4">Semester 4</option>
                    <option value="5">Semester 5</option>
                    <option value="6">Semester 6</option>
                    <option value="7">Semester 7</option>
                    <option value="8">Semester 8</option>
                    <option value="8">Semester 9</option>
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
            		<?php			
				foreach ($tahun as $row)
				{
			?>
					<option value="<?= $row->tahun_diambil ?>">
					    <?= strtoupper($row->tahun_diambil) ?>
                    </option>
		    <?php 
				} 
			?>
                </select>
            </div>
        </td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Angka Giliran Pelajar</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
            <div align="left">
                <input id="angka_giliran" name="angka_giliran" size="25" type="text" class="span3"/>
            </div>            
        </td>
    </tr>
    <tr>
    	<td></td>
    	<td height="35"><div align="right"></div></td>
        <td height="35">
        	<div align="left">
          		<input class="btn btn-info" type="submit" name="btn_papar" value="Cetak Keputusan">
        	</div>
        </td>
    </tr>
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
</table>
</form>

</center>