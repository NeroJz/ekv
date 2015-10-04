<script>
	function activate_slct_status(){
		$($("#slct_status")).removeAttr("disabled");  
	}
</script>
<legend><h3>Penyenggaraan Modul</h3></legend>
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
    	<td width="35%" height="35"><div align="right">Kategori</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35">
            <div align="left">
            	<select name="slct_category" id="slct_category">
            		<option value="akademik">Akademik</option>
            		<option value="vokasional">Vokasional</option>
				</select>
            </div>        
        </td>
    </tr>
    <tr>
    	<td width="35%" height="35"><div align="right">Status</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35">
            <div align="left">
            	<select name="slct_status" id="slct_status">
	            	<option value="aktif" <?php if($status=="aktif"){echo "selected";}?> >Aktif</option>
	            	<option value="tak-aktif" <?php if($status=="tak-aktif"){echo "selected";}?> >Tidak Aktif</option>
				</select>
            </div>        
        </td>
    </tr>
    
    <tr>
    	<td></td>
    	<td height="35"><div align="right"></div></td>
        <td height="35">
        	<div align="left">
          		<input class="btn btn-info" type="submit" name="btn_papar" id="btn_papar" value="Papar Data">
          		<a class="btn" href="<?=site_url('maintenance/crud_module/index') ?>">&nbsp;&nbsp;Set Semula&nbsp;&nbsp;</a>
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

