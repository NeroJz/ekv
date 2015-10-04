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

<legend><h3>Gred Keseluruhan Akademik & Vokasional</h3></legend>
<center>

<form id="frm_pusat" action="<?= site_url('laporan/result/resultkeseluruhan')?>" method="post" target="_blank">
<table class="breadcrumb border" width="100%" align="center">
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
    <tr>
    	<td width="45%" height="35"><div align="right">Kod Pusat</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35"><div align="left">
          <input type="text" name="kodpusat" id="kodpusat" class="span3" style="margin-left:0px"/>
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
					<option value="<?= $row->kursus_id ?>">
					    <?= strtoupper($row->kod_kursus.'  - '.$row->kursus_kluster ) ?>
                    </option>
		    <?php 
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