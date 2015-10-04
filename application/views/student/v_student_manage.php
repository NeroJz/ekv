<legend><h3>Senarai Pelajar</h3></legend>

<form id="frm_pusat" action="" method="post" >
<table class="breadcrumb border" width="100%" align="left">
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
    <tr>
    	<td width="45%" height="35"><div align="right">Kod Pusat</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35">
            <div align="left">
            <?php		
            //print_r($kv);
            	$options[''] = '-- Sila Pilih --';	
				foreach ($kv as $row)
				{
					$options[$row->col_id] = strtoupper($row->col_name );
				} 
				
				echo form_dropdown('slct_kv', $options, $current_kv,'style="width:270px;"');
			?>
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
					<option value="<?= $row->cou_id ?>">
					    <?= strtoupper($row->cou_code.'  - '.$row->cou_cluster ) ?>
                    </option>
		    <?php 
				} 
			?>
            </select>
            </div>
        </td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Sesi</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                <select id="slct_sesi" name="slct_sesi" style="width:270px;" class="validate[required]">
                   <?php for($i = 2013; $i <= date('Y'); $i++): ?>
                    <option value="<?=$i?>"><?=$i?></option>
                    <?php endfor; ?>
                </select>
            </div>
        </td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Semester</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                <select id="slct_sem" name="slct_sem" style="width:270px;" class="validate[required]">
            		<?php for($i = 1; $i < 9; $i++): ?>
                    <option value="<?=$i?>"><?=$i?></option>
                    <?php endfor; ?>
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

