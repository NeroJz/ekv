<script language="javascript" type="text/javascript" >
	$(function()
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
	
	$(document).ready(function(){
    	
		$('#pelajar').dataTable({
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bAutoWidth": true
		});
		
		$('#btn_simpan').click(function(){
			alert("Markah Telah Disimpan");
		});
		
		$('#btn_simpan2').click(function(){
			alert("Markah Telah Disimpan");
		});
	});
	
</script>

<legend><h3>Pentaksiran Akademik / Vokasional</h3></legend>
<center>

<form id="frm_pusat" action="<?= site_url('peperiksaan/pemarkahan/pilihanpengurusan1')?>" method="post" >
<table class="breadcrumb border" width="100%" align="center">
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
    <tr>
    	<td width="45%" height="35"><div align="right">Pengurusan</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35">
        	<div align="left">
                <input type="radio" name="pengurusan" value="ak">&nbsp;Akademik&nbsp;&nbsp;
                <input type="radio" name="pengurusan" value="vk">&nbsp;Vokasional
            </div>
        </td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Pentaksiran</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                <input type="radio" name="pentaksiran" value="ps">&nbsp;Sekolah&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="pentaksiran" value="pp">&nbsp;Pusat
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
            </select></div>
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
        <table cellpadding="0" cellspacing="0" border="0" class="display" id="pelajar">
            <thead>
                <tr>
                    <th>Bil</th>
                    <th>Nama Pelajar</th>
                    <th>No Kad Pengenalan</th>
                    <th>Angka Giliran</th>
                    <th>A04101(100)</th>
                    <th>A05101(100)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Norafiq Bin Mohd Azman Chew</td>
                    <td align="center">8980320075253</td>
                    <td align="center">10QIP10F1058</td>
                    <td align="center"><input id="a04" name="a04" size="10" type="text" class="span1"/></td>
                    <td align="center"><input id="a05" name="a05" size="10" type="text" class="span1"/></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Freddy Ajang Tony</td>
                    <td align="center">881110125211</td>
                    <td align="center">10QIP10F1054</td>
                    <td align="center"><input id="a04" name="a04" size="10" type="text" class="span1"/></td>
                    <td align="center"><input id="a05" name="a05" size="10" type="text" class="span1"/></td>
                </tr>
            </tbody>
        </table>
        <div align="right">
        	<input class="btn btn-info" type="button" id="btn_simpan" value="Simpan Markah Pelajar">
        </div>
<?php
	}
	else if('vk' == $pilihan)
	{
?>
		<table cellpadding="0" cellspacing="0" border="0" class="display" id="pelajar">
            <thead>
                <tr>
                    <th>Bil</th>
                    <th>Nama Pelajar</th>
                    <th>No Kad Pengenalan</th>
                    <th>Angka Giliran</th>
                    <th>Modul 1</th>
                    <th>Modul 2</th>
                    <th>Modul 3</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Norafiq Bin Mohd Azman Chew</td>
                    <td align="center">8980320075253</td>
                    <td align="center">10QIP10F1058</td>
                    <td align="center"><input id="a01" name="a01" size="10" type="text" class="span1"/></td>
                    <td align="center"><input id="a02" name="a02" size="10" type="text" class="span1"/></td>
                    <td align="center"><input id="a03" name="a03" size="10" type="text" class="span1"/></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Freddy Ajang Tony</td>
                    <td align="center">881110125211</td>
                    <td align="center">10QIP10F1054</td>
                    <td align="center"><input id="a01" name="a01" size="10" type="text" class="span1"/></td>
                    <td align="center"><input id="a02" name="a02" size="10" type="text" class="span1"/></td>
                    <td align="center"><input id="a03" name="a03" size="10" type="text" class="span1"/></td>
                </tr>
            </tbody>
        </table>
        <div align="right">
        	<input class="btn btn-info" type="button" id="btn_simpan2" value="Simpan Markah Pelajar">
        </div>
<?php
	}
}
?>