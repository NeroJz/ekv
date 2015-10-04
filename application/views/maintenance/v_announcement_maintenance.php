<!-- Jz starts add file here -->
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/docsupport/prism.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/chosen.css" media="screen" />

<script type="text/javascript" src="<?=base_url()?>/assets/grocery_crud/texteditor/ckeditor/ckeditor.js"></script>
<script type="text/javascript" src="<?=base_url()?>/assets/grocery_crud/texteditor/ckeditor/adapters/jquery.js"></script>
<script type="text/javascript" src="<?=base_url()?>/assets/js/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?=base_url()?>/assets/css/docsupport/prism.js"></script>
<script>
	$(document).ready(function(){
		$('#insert_select_col_id').chosen();
		reloadDatatable();
		$("#btn_insert_popup").bind("click",function(){
			$('#myModal_insert').modal('show');
			$('#frmInsert textarea#field_ann_content').ckeditor();
			$('#frmInsert').validationEngine('attach',{
				onValidationComplete: function(form, status){
					if(status){
						insertPengumuman();
						$("#frmInsert").unbind('submit');
         				return false;
					}
				}
			});
		});
		
		$(function(){
			$('.datepicker').datepicker({
				dateFormat : "yy-mm-dd"
			});
		});
		
		/****************************************************************************
	 	* Description		: this function call pop-up edit form
	 	* input				: -
	 	* author			: Jz
	 	* Date				: 15-04-2014
	 	* Modification Log	:
	 	*****************************************************************************/
		$('#tblAnouncement tbody .btn_edit_popup').live('click',function(){
			var ann_id = $(this).attr('value');
			$('#frmUpdate #ann_id').val(ann_id);
			
			var aData = $('#tblAnouncement').dataTable().fnGetData($(this).parents('tr')[0]);
			
			$("#frmUpdate #ann_title").val(aData[0]);
			$("#frmUpdate #field_ann_open_date").val(aData[2]);
			$("#frmUpdate #field_ann_close_date").val(aData[3]);
			
			var getPengumumanContent = $.ajax({
				url: '<?=site_url('maintenance/announcement/callback_edit')?>',
				data: {
					'ann_id':ann_id
				},
				type: 'POST',
				dataType: 'html'
			});
			
			getPengumumanContent.done(function(data){
				var result = JSON.parse(data);
				$('#frmUpdate textarea#update_field_ann_content').val(result.ann_content);
				$('#frmUpdate textarea#update_field_ann_content').ckeditor();
				
				if(result.user_level == 1){
					$('#frmUpdate #update_select_col_id').chosen();
					
					$('#frmUpdate #update_select_col_id').val(result.colIDs).trigger('chosen:updated');
				}
				
			});
			
			$('#myModal_update').modal('show');
			$('#frmUpdate').validationEngine('attach',{
				onValidationComplete: function(form, status){
					if(status){
						updateAnnouncement();
						$("#frmUpdate").unbind('submit');
         				return false;
					}
				}
			});
			
		});
		
	});
	/****************************************************************************
 	* Description		: this function is use load datatable
 	* input				: -
 	* author			: Jz
 	* Date				: 15-04-2014
 	* Modification Log	:
 	*****************************************************************************/
	function reloadDatatable(){
		<?=$vScript?>
	}
	
	/****************************************************************************
 	* Description		: this function is use insert new announcement
 	* input				: -
 	* author			: Jz
 	* Date				: 01-04-2014
 	* Modification Log	:
 	*****************************************************************************/
	function insertPengumuman(){
		var frm = $("#frmInsert").serializeArray();
		var formObject = {};
		$.each(frm,function(i,v){
			formObject[v.name] = v.value;
		});
		
		var colIDs = $("#frmInsert #insert_select_col_id").val();
		
		if(colIDs == undefined){
			colIDs = 0;
		}
		
		formObject['colIDs'] = colIDs;
		
		var request = $.ajax({
			url: '<?=site_url('maintenance/announcement/insert')?>',
			data: formObject,
			type: 'POST',
			dataType: 'html'
		});
		
		$('#frmInsert')[0].reset();
		$('textarea#field_ann_content').val("");
		$('#insert_select_col_id option').prop('selected', false).trigger('chosen:updated');
		$.unblockUI();
		$('#myModal_insert').modal('toggle');
		
		request.done(function(data){
			var mssg = new Array();
			if(data == true){
				mssg['heading'] = 'Mesej - Berjaya';
				mssg['content'] = 'Pegumuman berjaya ditambah';
			}else if(data == false){
				mssg['heading'] = '<font color="red">Mesej - Tidak Berjaya</font>';
				mssg['content'] = '<font color="red">Pegumuman tidak berjaya ditambah</font>';
			}
			mssg['hideCallback'] = true;
			mssg['callback'] = function(){
				reloadDatatable();
			}
			kv_alert(mssg);
		});
		
		request.fail(function(jqXHR, testStatus){
			var mssg = new Array();
			mssg['heading'] = '<font color="red">Mesej - Tidak Berjaya</font>';
			mssg['content'] = '<font color="red">Penambahan Pengumuman tidak berjaya didaftar</font>';
			mssg['hideCallback'] = true;
			mssg['callback'] = function(){
				reloadDatatable();
			}
			kv_alert(mssg);
		});
	}
	/****************************************************************************
 	* Description		: this function is use insert new announcement
 	* input				: -
 	* author			: Jz
 	* Date				: 01-04-2014
 	* Modification Log	:
 	*****************************************************************************/
	function updateAnnouncement(){
		var frm = $("#frmUpdate").serializeArray();
		var formObject = {};
		$.each(frm,function(i,v){
			formObject[v.name] = v.value;
		});
		var colIDs = $("#frmUpdate #update_select_col_id").val();
		
		if(colIDs == undefined){
			colIDs = 0;
		}
		formObject['colIDs'] = colIDs;
		var update = $.ajax({
			url: '<?=site_url('maintenance/announcement/update')?>',
			data: formObject,
			type: 'POST',
			dataType: 'html',
		});
		$('#myModal_update').modal('toggle');
		update.done(function(data){
			var mssg = new Array();
			if(data == true){
				mssg['heading'] = 'Mesej - Berjaya';
				mssg['content'] = 'Pengumuman berjaya dikemaskini';
			}else if(data == false){
				mssg['heading'] = '<font color="red">Mesej - Tidak Berjaya</font>';
				mssg['content'] = '<font color="red">Kemasikini tidak berjaya didaftar</font>';
			}
			mssg['hideCallback'] = true;
			mssg['callback'] = function(){
				reloadDatatable();
			}
			kv_alert(mssg);
		});
		update.fail(function(jqXHR, testStatus){
				var mssg = new Array();
				mssg['heading'] = '<font color="red">Mesej - Tidak Berjaya</font>';
				mssg['content'] = '<font color="red">Kemasikini tidak berjaya didaftar</font>';
				mssg['hideCallback'] = true;
				mssg['callback'] = function(){
					reloadDatatable();
				}
				kv_alert(mssg);
		});
	}
	
</script>
<style>
#ui-datepicker-div {
	z-index: 1051 !important;
}

.chosen-rtl .chosen-drop { 
	left: -9000px; 
}

.chosen-choices{
	min-width: 600px;
}
</style>
<legend>
	<h3>
		Penyenggaraan Pengumuman
		<div style="float:right; width:249px;">
			<a class="btn btn-success" id="btn_insert_popup">
				<span>Tambah Pengumuman Baru</span>
			</a>
		</div>
	</h3>
</legend>
<?php
echo $vView;
?>
<div class="modal hide fade" id="myModal_insert" style="width: 60%; margin-left: -30%;">
	<div class="modal-header">
		<button id="btn_close" type="button" class="close"
			data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
		<h3>Penambahan Pengumuman Baru</h3>
	</div>
	<form method="post" id="frmInsert" class="form-horizontal" style="margin-top: 20px; padding-top: 20px">
		<div class="modal-body" id="span_result2">
			<div class="control-group">
				<label class="control-label" for="ann_title">Perkara : </label>
				<div class="controls">
					<input type="text" name="ann_title" id="ann_title" class="validate[required] text-input" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="ann_content">Pengumuman : </label>
				<div class="controls">
					<textarea id="field_ann_content" name="ann_content" class="texteditor validate[required]" >
					</textarea>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="ann_open_date">Tarikh Mula : </label>
				<div class="controls">
					<input type="text" id="insert_ann_open_date" name="ann_open_date" maxlength="10" 
					class="validate[required] datepicker">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="ann_close_date">Tarikh Akhir : </label>
				<div class="controls">
					<input type="text" name="ann_close_date" id="ann_close_date" maxlength="10"  
					class="validate[required] datepicker" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="mod_code">Status Pengumuman : </label>
				<div class="controls">
					<select id="ann_status" name="ann_status">
						<option value="1">Aktif</option>
						<option value="0">Tak Aktif</option>
					</select>
				</div>
			</div>
			<?php
				if(!empty($kolej)){
			?>
			<div class="control-group">
				<label class="control-label" for="col_id">Kolej : </label>
				<div class="controls">
					<select name="col_id" id="insert_select_col_id" data-placeholder="- Sila Pilih Kolej -" multiple="multiple" 
					class="validate[required]" style="width: 95%;">
						<?php
							foreach($kolej as $row){
								echo "<option value='$row->col_id'>".$row->col_name."</option>";
							}
						?>
					</select>
				</div>
			</div>
			<?php
				}
			?>	
		</div>
		<div class="modal-footer">
			<div class="pull-right">
				<input type="submit" value="Tambah" class="btn btn-info btn-block" style="width:150px;" />
				<?php
					if(empty($kolej)){?>
						<input type='hidden' name='col_id' id='col_id' value="<?=$col_id?>" />
				<?php
					}
				?>
				
				<input type="hidden" name="user_id" id="user_id" value="<?=$user_id?>" />
			</div>
		</div>
	</form>
</div>
<div class="modal hide fade" id="myModal_update" style="width: 60%; margin-left: -30%;">
	<div class="modal-header">
		<button id="btn_close" type="button" class="close"
			data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
		<h3>Kemaskini Pengumuman</h3>
	</div>
	<form method="post" id="frmUpdate" class="form-horizontal" style="margin-top: 20px; padding-top: 20px">
		<div class="modal-body" id="span_result2">
			<div class="control-group">
				<label class="control-label" for="ann_title">Perkara : </label>
				<div class="controls">
					<input type="text" name="ann_title" id="ann_title" class="validate[required] text-input" />
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="ann_content">Pengumuman : </label>
				<div class="controls">
					<textarea id="update_field_ann_content" name="ann_content" class="texteditor validate[required]" >
					</textarea>
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="ann_open_date">Tarikh Mula : </label>
				<div class="controls">
					<input type="text" id="field_ann_open_date" name="ann_open_date" maxlength="10" 
					class="validate[required] datepicker">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="ann_close_date">Tarikh Akhir : </label>
				<div class="controls">
					<input type="text" id="field_ann_close_date" name="ann_close_date" maxlength="10" 
					class="validate[required] datepicker">
				</div>
			</div>
			<div class="control-group">
				<label class="control-label" for="mod_code">Status Pengumuman : </label>
				<div class="controls">
					<select id="ann_status" name="ann_status">
						<option value="1">Aktif</option>
						<option value="0">Tak Aktif</option>
					</select>
				</div>
			</div>
			<?php
				if(!empty($kolej)){
			?>
			<div class="control-group">
				<label class="control-label" for="col_id">Kolej : </label>
				<div class="controls">
					<select name="col_id" id="update_select_col_id" data-placeholder="- Sila Pilih Kolej -" multiple="multiple" 
					class="validate[required]" style="width: 95%;">
						<?php
							foreach($kolej as $row){
								echo "<option value='$row->col_id'>".$row->col_name."</option>";
							}
						?>
					</select>
				</div>
			</div>
			<?php
				}
			?>	
		</div>
		<div class="modal-footer">
			<div class="pull-right">
				<input type="submit" value="Kemaskini" class="btn btn-info btn-block" style="width:150px;" />
				<input type="hidden" name="ann_id" id="ann_id" />
			</div>
		</div>
	</form>
</div>
