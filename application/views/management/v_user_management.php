
<legend><h3>Penyenggaraan Pengguna</h3></legend>
<?php
if($this->ion_auth->in_group("Admin LP")||$this->ion_auth->in_group("UPMPD")||$this->ion_auth->in_group("SPDP")||$this->ion_auth->in_group("BPTV")||$this->ion_auth->in_group("JPN"))
{
	?>
<form id="frm_user" action="" method="post" >
<table class="breadcrumb border" width="100%" align="left">
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
    <tr>
    	<td width="35%" height="35"><div align="right">Kolej</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35">
            <div align="left">
            	<select name="slct_kv" id="slct_kv" style="margin-bottom: 0px;">
            	<option value="">Sila Pilih</option>
            	<?php
				foreach ($kv as $row)
				{
					?>
					<option <?php if($row->col_id == $current_kv){?> selected="selected"  <?php } ?> value="<?=$row->col_id ?>"><?=$row->col_name." - ".$row->col_type.$row->col_code ?></option>
					<?php
				} 
				?>
				</select>
            </div>        
        </td>
    </tr>
    
    <tr>
    	<td></td>
    	<td height="35"><div align="right"></div></td>
        <td height="35">
        	<div align="left">
          		<input class="btn btn-info" type="submit" name="btn_papar" id="btn_papar" value="Papar Pengguna">
          		<a class="btn" href="<?=site_url('management/user') ?>">&nbsp;&nbsp;Set Semula&nbsp;&nbsp;</a>
        	</div>
        </td>
    </tr>
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
</table>
</form>
<?php
}
?>

