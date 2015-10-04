<style type="text/css">
	#box {
		width: 100%;
		font-size: 14px;
		font-weight: bold;
	}
	strong {
		color: #000;
	}
</style>

<legend>
	<h4>Pindah Murid</h4>
</legend>
<center>
	<form name="form_seach" id="form_seach" action="<?= site_url('student/student_management/change_status'); ?>" method="post">
		<input type="hidden" id="stu_id" name="stu_id" value="<?= $stu_id; ?>" readonly />
		<input type="hidden" id="cou_id" name="cou_id" value="<?= $cou_id; ?>" readonly />

		<table class="breadcrumb border" width="100%" align="center">

			<tr>
				<td width="240" align="right">&nbsp;</td>
				<td width="10" align="center">&nbsp;</td>
				<td width="368" height="35" align="left" style="font-size: 16px;font-weight: bold;">&nbsp;</td>
			</tr>

			<tr>
				<td align="right">Nama</td>
				<td align="center">:</td>
				<td height="35">
				<input type="text" name="nama" value="<?= $stu_name; ?>" readonly />
				</td>
			</tr>
			<tr>
				<td align="right">Angka Giliran</td>
				<td align="center">:</td>
				<td height="35">
				<input type="text" name="angka_giliran" value="<?= $stu_matric_no; ?>" readonly />
				</td>
			</tr>
			<tr>
				<td align="right">MyKad</td>
				<td align="center">:</td>
				<td height="35">
				<input type="text" name="mykad" value="<?= $stu_mykad; ?>" readonly />
				</td>
			</tr>
			<tr>
				<td align="right">Kursus</td>
				<td align="center">:</td>
				<td height="35">
				<input type="text" name="kursus" value="<?= $cou_name; ?>" readonly />
				</td>
			</tr>
			<tr>
				<td align="right">Kolej Vokasional</td>
				<td align="center">:</td>
				<td height="35">
				<input type="text" name="kursus" value="<?= $col_name; ?>" readonly />
				</td>
			</tr>
			<tr>
				<td align="right">Pindah ke</td>
				<td align="center">:</td>
				<td height="35">
				<select class="new_kv" name="kv_transfer">
					<?php foreach ($kv_list as $row) {?>
						<option value="<?=$row['col_id'] ?>"><?=$row['col_name'] ?></option>
					<?php } ?>
				</select>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td >
					<a href="#myModal" role="button" class="btn btn-info" data-toggle="modal">Pindah</a>
					<!-- <input class="btn btn-info" type="submit" name="btn_carian" value="Pindah"> -->
					<a href="<?=site_url()?>/student/student_management/pindah" class="btn">Batal</a>
					<br />
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td >&nbsp;</td>
			</tr>
		</table>
		<?/*Modal start*/?>
		<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
					x
				</button>
				<h3 id="myModalLabel">Pengesahan</h3>
			</div>
			<div class="modal-body">
				<p>
					Adakah anda pasti untuk memindahkan <b><?=$stu_name ?></b> ke KV baru?
				</p>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">
					Tidak
				</button>
				<button id="ya" type="submit" class="btn btn-info">
					Ya
				</button>
			</div>
		</div>
		<?/*Modal end*/?>
	</form>
</center>
<script src="<?=base_url() ?>assets/js/student/change_status.js" type="text/javascript"></script>