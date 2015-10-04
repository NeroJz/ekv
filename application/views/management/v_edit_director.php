<form name="form_edit_director" id="form_edit_director" method="post" action="<?=site_url('management/user/add_director') ?>">
    			<table>
    				<tr>
    					<td>Nama Pengguna</td>
    					<td>:</td>
    					<td><input type="text" name="nama" id="nama" /></td>
    				</tr>
    				<tr>
    					<td>Katanama</td>
    					<td>:</td>
    					<td><input type="text" name="katanama" id="katanama" /></td>
    				</tr>
    				<tr>
    					<td>Katalaluan</td>
    					<td>:</td>
    					<td><input type="password" name="katalaluan" id="katalaluan" /></td>
    				</tr>
    				<tr>
    					<td>Email</td>
    					<td>:</td>
    					<td><input type="text" name="email" id="email" /></td>
    				</tr>
    				<tr>
    					<td>Status</td>
    					<td>:</td>
    					<td>
    						<select name="status" id="status">
    							<option value="">-- Sila Pilih --</option>
    							<option value="1">Aktif</option>
    							<option value="0">Tidak Aktif</option>
    						</select>
    					</td>
    				</tr>
    				<tr>
    					<td>Kolej</td>
    					<td>:</td>
    					<td>
    						<select name="kolej" id="kolej">
    							<option value="">-- Sila Pilih --</option>
    							<?php
    							foreach ($kv_list as $row){
									?>
									<option value="<?=$row->col_id ?>"><?=$row->col_name ?></option>
									<?php
								}
    							?>
    						</select>
    					</td>
    				</tr>
    				<tr>
    					<td>No. Telefon</td>
    					<td>:</td>
    					<td><input type="text" name="no_tel" id="no_tel" /></td>
    				</tr>
    				<tr>
    					<td>Jawatan</td>
    					<td>:</td>
    					<td><input type="text" name="jawatan" id="jawatan" value="5" />Pengarah</td>
    				</tr>
    				<input type="text" name="tarikh_daftar" id="tarikh_daftar" value="<?=time() ?>" />
    			</table>
</form>