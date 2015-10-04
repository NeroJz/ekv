<legend><h3>Institusi Kolej Vokasional</h3></legend>
<center>

<form id="frm_pusat" action="<?= site_url('welcome/kv_info')?>" method="post" >
<table class="breadcrumb border" width="100%" align="center">
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
    <tr>
    	<td width="45%" height="35"><div align="right">Kod Institusi</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35"><div align="left">
        	<input type="text" name="txt_code" id="txt_code" class="span3 validate[required]" /></div>
        </td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Nama Institusi</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35"><div align="left">
        	<select id="slct_nama" name="slct_nama" style="width:270px;" class="validate[required]">
            <option value="">-- Sila Pilih --</option>
            <?php			
				foreach ($kolejvokasional as $row)
				{
			?>
					<option value="<?= $row->kv_id ?>">
					    <?= strtoupper($row->kod_pusat.' - '.$row->nama_institusi ) ?>
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
          		<input class="btn btn-info" type="submit" name="btn_carian" value="Cari">
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
if(isset($plh_kolej))
{
?>
<div class="alert alert-info" style="width:95.5%; margin:auto;">
<table width="100%" align="center">
	<tr>
    	<td colspan="4"><strong><?= strtoupper($plh_kolej->nama_institusi) ?></strong></td>
    </tr>
    <tr>
    	<td colspan="4">&nbsp;</td>
    </tr>
    <tr>
   	  <td width="18%" align="right">KOD PUSAT</td>
        <td width="4%" align="center">:</td>
        <td width="39%"><?php
        					if(isset($plh_kolej->kod_pusat) && $plh_kolej->kod_pusat != "")
							{
								echo strtoupper($plh_kolej->kod_pusat);
							}
							else
							{
								echo "-";
							}
						?>
        </td>
        
		<?php
            if(isset($jumlahmurid))
            {
        		echo "<td width='39%' rowspan='7' align='center'>&nbsp;</td>";
            }         
            else
            {
				// xde form untuk upload (dummy)
        		echo "<td width='39%' rowspan='5' align='left'>Import Pelajar:<br/>";
				echo "<input type='file' name='file' id='file'><br>";
				echo "<input type='submit' name='submit' value='Import'></td>";
            }
        ?>
    </tr>
    <tr>
    	<td align="right">NEGERI</td>
        <td align="center">:</td>
        <td><?php
				if(isset($plh_kolej->negeri) && $plh_kolej->negeri != "")
				{
					echo strtoupper($plh_kolej->negeri);
				}
				else
				{
					echo "-";
				}
			?>
        </td>
    </tr>
    <tr>
    	<td align="right">NO. TEL PEJABAT</td>
        <td align="center">:</td>
        <td><?php
				if(isset($plh_kolej->tel_pejabat) && $plh_kolej->tel_pejabat != "")
				{
					echo strtoupper($plh_kolej->tel_pejabat);
				}
				else
				{
					echo "-";
				}
			?>
        </td>
    </tr>
    <tr>
    	<td align="right">NO. TEL FAX</td>
        <td align="center">:</td>
        <td><?php
				if(isset($plh_kolej->fax) && $plh_kolej->fax != "")
				{
					echo strtoupper($plh_kolej->fax);
				}
				else
				{
					echo "-";
				}
			?>
        </td>
    </tr>
    <tr>
    	<td align="right">ALAMAT</td>
        <td align="center">:</td>
        <td><?php
				if(isset($plh_kolej->alamat) && $plh_kolej->alamat != "")
				{
					echo strtoupper($plh_kolej->alamat);
				}
				else
				{
					echo "-";
				}
			?>
        </td>
    </tr>
    <?php
		if(isset($jumlahmurid))
		{
	?>
    <tr>
    	<td align="right">TAHUN KOHORT</td>
        <td align="center">:</td>
        <td><?= strtoupper($plh_kolej->tahun_kohort) ?></td>
    </tr>
    <tr>
    	<td align="right">JUMLAH MURID</td>
        <td align="center">:</td>
        <td><?= strtoupper($plh_kolej->jumlah_murid) ?></td>
    </tr>
    <?php
		}
	?>
    <tr>
    	<td colspan="4">&nbsp;</td>
    </tr>
</table>
</div>
<?php
}
?>