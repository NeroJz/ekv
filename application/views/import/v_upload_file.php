
<div class="alert alert-info">
Cara-cara untuk memuat naik fail<br/>
1. Pastikan jenis fail tersebut adalah xls dan bukan xlsx. Jika fail tersebut adalah xlsx, tukarkan fail tersebut kepada xls.<br/>
2. Fail tersebut mesti mempunyai maklumat mengikut kolej dan semester.<br/>
3. Pastikan saiz fail yang dimuatkan mesti tidak melebihi 2 Mb.<br/>
4. Pastikan fail tersebut tidak mempunyai keputusan semester <br/>
</div>
<div class="alert alert-danger">
<?php echo $error;?>
</div>

<center>
	
<?php echo form_open_multipart('import_excellkv/upload_files');?>
<table>
<tr>
	<td>Semester:</td>
	<td>
	<select name="semester" id="semester">
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	</select>
	</td>
</tr>
<tr>
	<td>Sesi:</td>
	<td>
	<select name="sesi" id="sesi">
		<option value="1 2011">1 2011</option>
		<option value="2 2011">2 2011</option>
		<option value="1 2012">1 2012</option>
		<option value="2 2012">2 2012</option>
		<option value="1 2013">1 2013</option>
		<option value="2 2013">2 2013</option>
		<option value="1 2014">1 2014</option>
		<option value="2 2014">2 2014</option>
	</select>
	</td>
</tr>
<tr>
	<td>Tahun:</td>
	<td>
	<select name="tahun" id="tahun">
		<option value="2011">2011</option>
		<option value="2012">2012</option>
		<option value="2013">2013</option>
		<option value="2014">2014</option>
	</select>
	</td>
</tr>
<tr>
	<td>Bilangan Subjek:</td>
	<td>
	<select name="subjek" id="subjek">
		<option value="9">9</option>
		<option value="10">10</option>
		<option value="11">11</option>
		<option value="12">12</option>
		<option value="13">13</option>
		<option value="14">14</option>
		<option value="15">15</option>
		
	</select>
	</td>
</tr>
<tr>
	<td>
		Fail:
	</td>
	<td>
<input type="file" name="userfile" size="20" />
</td>
</tr>
<tr><td></td><td>
<input class="btn btn-info" type="submit" id="upload" name="upload" value="Memuat Naik" style="margin-top: 15px;">
          		
</td>
</tr>
</table>
</form>
</center>
