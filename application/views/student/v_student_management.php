<legend>
	<h3>Senarai Murid</h3>
</legend>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/input_plugin.js"></script>

<script>
	var giCount = 1;

	jQuery(function($) {
		$("#ic").mask("999999-99-9999");
	});

	$('#myModal').modal().css({
		'margin-top' : function() {
			return -($(this).height() / 2);
		}
	})

	$(document).ready(function() {
		$("#addStudent").validationEngine({
			promptPosition : "bottomLeft",
			scroll : false
		});

		$("#table_id").dataTable({
			"aoColumnDefs" : [{
				bSortable : false,
				aTargets : [0]
			}],
			"bPaginate" : true,
			"sPaginationType" : "full_numbers",
			"bFilter" : true,
			"bInfo" : true,
			"bJQueryUI" : true,
			"sScrollY": "200px",
			"bPaginate": true,
			"aaSorting" : [[1, "asc"]],
			"oLanguage": {  "sSearch": "Carian :",
 						"sLengthMenu": "Papar _MENU_ senarai",
	 					"sInfo": "Papar _START_-_END_ dari _TOTAL_ rekod",
						"sInfoEmpty": "Showing 0 to 0 of 0 records",
						    "oPaginate": {
						      "sFirst": "Pertama",
						      "sLast": "Akhir",
						      "sNext": "Seterus",
						      "sPrevious": "Sebelum"
						     }
 						 },
			"fnDrawCallback" : function(oSettings) {
				if (oSettings.bSorted || oSettings.bFiltered) {
					for (var i = 0, iLen = oSettings.aiDisplay.length; i < iLen; i++) {
						$("td:eq(0)", oSettings.aoData[oSettings.aiDisplay[i]].nTr).html(i + 1);
					}
				}
			}
		});
	});

	function fnClickAddRow() {
		$("#table_id").dataTable().fnAddData([giCount + ".1", giCount + ".2", giCount + ".3", giCount + ".4", giCount + ".5", giCount + ".6", giCount + ".7", giCount + ".8"]);
		giCount++;
	}


	$("#myModalAddStudent").ready(function() {

	}); 
</script>
<!-- Button to trigger modal -->
<?//<a href="#myModalAddStudent" role="button" class="btn btn-info btn-small" data-toggle="modal" style="margin-bottom: 5px;"><i class="icon-plus icon-white"></i> Murid Baru</a>?>
<center>

	<form id="frm_pusat" action="" method="post">
		<table class="breadcrumb border" width="100%" align="center">
			<tbody>
				<tr>
					<td colspan="3">&nbsp;</td>
				</tr>
				<tr style="">
					<td width="45%" height="35">
					<div align="right">
						Kolej Vokasional
					</div></td>
					<td width="3%" height="35">
					<div align="center">
						:
					</div></td>
					<td width="52%" height="35" align="left">
						<div align="left">
							<span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
							<select name="slct_kv" id="slct_kv">
								<?php
								echo $kv_list_option;
								// foreach ($kv_list as $row) {
									// if($colid==$row->col_id){
										// echo "<option value=$row->col_id>$row->col_name</option selected disable>";
									// }else{
										// // echo "<option value=$row->col_id>$row->col_name</option>";
									// }
								// }
								?>
							</select> dan/atau
						</div>
					</td>
				</tr>
				<tr style="">
					<td width="45%" height="35">
					<div align="right">
						Semester
					</div></td>
					<td width="3%" height="35">
					<div align="center">
						:
					</div></td>
					<td width="52%" height="35" align="left">
						<div align="left">
							<span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
							<select name="slct_sem">
								<option value="">Sila Pilih</option>
								<?php
								for($i=1;$i<=8;$i++) {
									echo "<option value=$i>$i</option>";
								}
								?>
							</select> dan/atau
						</div>
					</td>
				</tr>
				<tr style="">
					<td width="45%" height="35">
					<div align="right">
						Jantina
					</div></td>
					<td width="3%" height="35">
					<div align="center">
						:
					</div></td>
					<td width="52%" height="35" align="left">
						<div align="left">
							<span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
							<select name="slct_gender">
								<option value="">Sila Pilih</option>
								<option value="Lelaki">Lelaki</option>
								<option value="Perempuan">Perempuan</option>
							</select> dan/atau
						</div>
					</td>
				</tr>
				<tr style="">
					<td width="45%" height="35">
					<div align="right">
						Bangsa
					</div></td>
					<td width="3%" height="35">
					<div align="center">
						:
					</div></td>
					<td width="52%" height="35" align="left">
						<div align="left">
							<span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
							<select name="slct_race">
								<option value="">Sila Pilih</option>
								<option value="Melayu/Bumiputra">Melayu/Bumiputra</option>
								<option value="Cina">Cina</option>
								<option value="India">India</option>
								<option value="Lain-lain">Lain-lain</option>
							</select> dan/atau
						</div>
					</td>
				</tr>
				<tr style="">
					<td width="45%" height="35">
					<div align="right">
						Status
					</div></td>
					<td width="3%" height="35">
					<div align="center">
						:
					</div></td>
					<td width="52%" height="35" align="left">
						<div align="left">
							<span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
							<select name="slct_status">
								<option value="">Sila Pilih</option>
								<option value="1">Aktif</option>
								<option value="0">Tak Aktif</option>
							</select> dan/atau
						</div>
					</td>
				</tr>
				<tr style="">
					<td width="45%" height="35">
					<div align="right">
						Negeri
					</div></td>
					<td width="3%" height="35">
					<div align="center">
						:
					</div></td>
					<td width="52%" height="35" align="left">
						<div align="left">
							<span role="status" aria-live="polite" class="ui-helper-hidden-accessible"></span>
							<select name="slct_state">
								<option value="">Sila Pilih</option>
								<?php
								foreach ($state_list as $row) {?>
									<option value=<?php echo $row->state_id;?>><?php echo $row->state;?></option>
								<?php }?>
							</select> dan/atau
						</div>
					</td>
				</tr>
				<tr>
					<td></td>
					<td><input type="submit" value="Cari" class="btn btn-info" style="margin-bottom: 10px;"></td>
					<td></td>
				</tr>
				<tr>
					<td colspan="3">&nbsp;</td>
				</tr>
			</tbody>
		</table>
	</form>

</center>
<a href="<?= site_url('student/student_management/add') ?>" class="btn btn-info btn-small" style="margin-bottom: 5px;"><i class="icon-plus icon-white"></i> Murid Baru</a>
<br>

<!--START Generate Datatable-->
<?php $i = 1;
	foreach ($kv_list as $row) {
		$option[$row -> col_id] = $row -> col_name;
		$i++;
	}
	for ($i = 1; $i <= 10; $i++) {
		$semester[$i] = $i;
	}

	$status[0] = "Berhenti";
	$status[1] = "Aktif";

	$tmpl = array('table_open' => '
<table id="table_id" class="display">
');

	$this -> table -> set_template($tmpl);
	$this -> table -> set_heading('Bil', 'Nama Murid', 'No MyKad', 'Angka Giliran', 'Kursus', 'Jantina', 'Bangsa', 'Agama', 'Tindakan');
	foreach ($query as $item) {
		$this -> table -> add_row('', strcap($item['stu_name']), $item['stu_mykad'], strtoupper($item['stu_matric_no']), strcap($item['cou_name']), strcap($item['stu_gender']), strcap($item['stu_race']),
			strcap($item['stu_religion']), '<a href="'.site_url().'/student/student_management/display_update_student/' . $item['stu_id'] . '"><i class="icon-edit"></i></a>');
	}

	echo $table = $this -> table -> generate();
?>
<!--END Generate Datatable-->

<!-- Modal -->
<?php $att = 'required="true"'; ?>
<?php $att_ajax = 'required="true" id="kv"'; ?>
<div id="myModalAddStudent" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-header">
<button type="button" class="close" data-dismiss="modal" aria-hidden="true">
x
</button>
<h3 id="myModalLabel">Tambah Murid Baru</h3>
</div>
<div class="modal-body">
<?=form_open('student/student_management/choose_course',array('class'=>'form-horizontal','id'=>'addStudent','name'=>'addStudent'))
?>
<div class="control-group">
<label class="control-label" for="nama">Nama Murid :</label>
<div class="controls">
<?=form_input(array('name'=>'nama','placeholder'=>'Cth: Muhammad bin Abdullah','class'=>'validate[required] text-input'))
?>
</div>
</div>
<div class="control-group">
<label class="control-label" for="no_kp">No KyKad :</label>
<div class="controls">
<?=form_input(array('name'=>'no_kp','placeholder'=>'Cth: 921221-11-5501','id'=>'ic','class'=>'validate[required] text-input'))
?>
</div>
</div>
<div class="control-group"><label class="control-label">
Jantina : </label><div class="controls"><label class="radio"> <?=form_radio('jantina', 'Lelaki')
?>
Lelaki </label>
<label class="radio"> <?=form_radio('jantina', 'Perempuan')
?>
Perempuan </label></div>
</div>
<div class="control-group">
<label class="control-label" for="bangsa">Bangsa :</label>
<div class="controls">
<?=form_input(array('name'=>'bangsa','placeholder'=>'Cth: Melayu','class'=>'validate[required] text-input'))
?>
</div>
</div>
<div class="control-group">
<label class="control-label" for="agama">Agama :</label>
<div class="controls">
<?=form_input(array('name'=>'agama','placeholder'=>'Cth: Islam','class'=>'validate[required] text-input'))
?>
</div>
</div>
<!-- <div class="control-group">
<label class="control-label" for="group">Group :</label>
<div class="controls"> -->
<? //=form_input(array('name'=>'group','placeholder'=>'Cth: 1','class'=>'validate[required] text-input')) ?>
<?= form_hidden('group', '1'); ?>
<!-- </div>
</div> -->
<div class="control-group">
<label class="control-label" for="semester">Semester :</label>
<div class="controls">
<input type="number"  name="semester" max="10" min="1" required="true" value="1"/>
<br>
</div>
</div>
<div class="control-group">
<label class="control-label" for="kv">Kolej Vokasional :</label>
<div class="controls">
<?=form_dropdown('kv',$option,'','id="kv"')?><
br>
</div>
</div>
<div class="control-group" id="course"></div>
<?= form_hidden('status', '1'); ?>
</div>
<div class="modal-footer">
<button class="btn" data-dismiss="modal" aria-hidden="true">
Tutup
</button>
<input type="submit" value="Tambah" class="btn btn-info">
<!--button class="btn btn-primary" data-dismiss="modal" onclick="fnClickAddRow()">Tambah</button-->
</div>
<?=form_close()
?>
</div>
<script src="<?=base_url() ?>assets/js/student/process.js" type="text/javascript"></script>
