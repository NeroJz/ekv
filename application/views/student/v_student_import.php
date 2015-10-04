<legend><h4>Import Pelajar</h4></legend>

<form id="frm_pusat" action="<?php echo site_url("student/student_management/do_upload");?>" enctype="multipart/form-data" method="post" >
<div class="span12">
	<div class="span6">
		<table class="breadcrumb border" width="100%" align="left">
    <tr>
    	<td colspan="3"><div align="center"><h5>Konfigurasi Fail</h5></div></td>
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
    	<td height="35"><div align="right">Kolej Vokasional</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
             <?php		
            	$options[''] = '-- Sila Pilih --';	
				foreach ($kv as $row)
				{
					$options[$row->kv_id] = strtoupper($row->nama_institusi );
				} 
				
				echo form_dropdown('slct_kv', $options, "",'style="width:270px;"');
			?>
            </div>
        </td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Muat Naik Fail</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
            <input type="file" name="file_excel" id="file_excel" />
            </div>
        </td>
    </tr>
     <tr>
    	<td colspan="3" height="35">
    	<div align="center">
    	 <?php 
            	$dataRadioImport = array(
			    'name'        => 'rImportType',
			    'id'          => 'rImportType',
			    'value'       => 'importNow',
			    'checked'     => TRUE,
			    'class'       => 'checkbox inline',
			    );
				
				$dataRadioNoImport = array(
			    'name'        => 'rImportType',
			    'id'          => 'rImportType',
			    'value'       => 'importNextTime',
			    'checked'     => FALSE,
			    'class'       => 'checkbox inline',
			    );
			
			echo '<label class="checkbox inline">'.form_radio($dataRadioImport)." Import Terus</label>";
			echo '<label class="checkbox inline">'.form_radio($dataRadioNoImport)." Import Kemudian</label>";
            ?>
    	</div></td>
    </tr>
</table>	
	</div>
	<div class="span6">
	<table class="breadcrumb border" width="100%" align="left">
    <tr>
    	<td colspan="3"><div align="center"><h5>Konfigurasi Excel</h5></div></td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Sheet</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                    <?php		
            	//$options_nama[''] = '-- Tiada --';	
				for ($i = 0; $i <= 20; $i++)
				{
					$options_sheet[$i] = $i;
				} 
				
				echo form_dropdown('slct_sheet', $options_sheet, "7",'style="width:270px;"');
			?>
            </div>
        </td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Nama</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                 <?php		
            	$options_nama[''] = '-- Tiada --';	
				for ($i = 1; $i <= 20; $i++)
				{
					$options_nama[$i] = $i;
				} 
				
				echo form_dropdown('sel_nama', $options_nama, "2",'style="width:270px;"');
			?>
            </div>
        </td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Nombor KP</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
             <?php		
            	$options_noKp[''] = '-- Tiada --';	
				for ($i = 1; $i <= 20; $i++)
				{
					$options_noKp[$i] = $i;
				} 
				
				echo form_dropdown('sel_noKp', $options_noKp, "3",'style="width:270px;"');
			?>
            </div>
        </td>
    </tr>                           
    <tr>
    	<td height="35"><div align="right">Angka Giliran</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
            <?php		
            	$options_angkaGiliran[''] = '-- Tiada --';	
				for ($i = 1; $i <= 20; $i++)
				{
					$options_angkaGiliran[$i] = $i;
				} 
				
				echo form_dropdown('sel_angkaGiliran', $options_angkaGiliran, "4",'style="width:270px;"');
			?>
            </div>
        </td>
    </tr>
        <tr>
    	<td height="35"><div align="right">Kod Kursus</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
            <?php		
            	$options_kodKursus[''] = '-- Tiada --';	
				for ($i = 1; $i <= 20; $i++)
				{
					$options_kodKursus[$i] = $i;
				} 
				
				echo form_dropdown('sel_kodKursus', $options_kodKursus, "5",'style="width:270px;"');
			?>
            </div>
        </td>
    </tr>
        <tr>
    	<td height="35"><div align="right">Jantina</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
            <?php		
            	$options_jantina[''] = '-- Tiada --';	
				for ($i = 1; $i <= 20; $i++)
				{
					$options_jantina[$i] = $i;
				} 
				
				echo form_dropdown('sel_jantina', $options_jantina, "6",'style="width:270px;"');
			?>
            </div>
        </td>
    </tr>
        <tr>
    	<td height="35"><div align="right">Kaum</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
            <?php		
            	$options_kaum[''] = '-- Tiada --';	
				for ($i = 1; $i <= 20; $i++)
				{
					$options_kaum[$i] = $i;
				} 
				
				echo form_dropdown('sel_kaum', $options_kaum, "7",'style="width:270px;"');
			?>
            </div>
        </td>
    </tr>
    </tr>
        <tr>
    	<td height="35"><div align="right">Agama</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
            <?php		
            	$options_agama[''] = '-- Tiada --';	
				for ($i = 1; $i <= 20; $i++)
				{
					$options_agama[$i] = $i;
				} 
				
				echo form_dropdown('sel_agama', $options_agama, "8",'style="width:270px;"');
			?>
            </div>
        </td>
    </tr>
</table>
	</div>
</div>
<div class="form-actions" align="center" style="padding-left: 20px;">
  <button type="submit" class="btn btn-primary">Import Pelajar</button>
  <button type="reset" class="btn">Batal</button>
</div>
</form>

