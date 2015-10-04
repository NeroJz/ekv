<script>
function printit() {
	document.getElementById('idPrint').style.display = 'none';
	window.print();
	setTimeout("document.getElementById('idPrint').style.display = 'block';", 5000);
}
</script>


<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap2.css" media="print, screen" />

<table width="100%">
	<tr>
	    <td width="500">
	    	<center><h3><?=$kv->nama_institusi." (".$kv->kod_pusat .")" ?></h3><br />
	    		<strong> SENARAI KEHADIRAN PELAJAR BAGI KURSUS <?=strtoupper($kursus->kursus_kluster)." (".$kursus->kod_kursus.")" ?></strong><br />
	    		<strong>SESI <?=$sesi ?> SEMESTER <?=$semester ?></strong>
	    	</center>
	    </td>
	</tr>
</table>		
<hr />
<button onclick="printit()" name="idPrint" id="idPrint" type="button" class="btn"><span>Cetak Kehadiran</span></button>
<br />
<br />	  
<table class="table table-striped table-bordered table-condensed">
	<thead>
        <th width="50"><center>BIL.</center></th>
        <th width="300"><center>NAMA PELAJAR</center></th>
        <th width="200"><center>KAD PENGENALAN</center></th>
        <th width="200"><center>ANGKA GILIRAN</center></th>
        <th width="100"><center>KEHADIRAN</center></th>
    </thead>
    <tbody>
    <?php
    $bil = 1;
    foreach($senarai as $s)
	{
    ?>
    <tr>
        <td width="50"><center><?=$bil ?></center></td>
        <td width="300"><center><?=strtoupper($s->nama_pelajar) ?></center></td>
        <td width="200"><center><?=$s->no_kp ?></center></td>
        <td width="200"><center><?=$s->angka_giliran ?></center></td>
        <td width="100"><center></center></td>
    </tr>
    <?php
    $bil++;
    }
    ?>
    </tbody>
</table>   