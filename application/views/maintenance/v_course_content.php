<script type="text/javascript">
	$(document).ready(function(){
		$("#btn_insert_popup").bind("click",function(){
			$('#myModal_insert').modal('show');
			$('#frmInsert').validationEngine('attach',{
				onValidationComplete: function(form, status){
					if(status){
						insertKursus();
					}
				}
			});
		});
		
		$('#tblKursus tbody .btn_edit_popup').live('click',function(){
			var id = $(this).attr('value');
			
			var aData = $('#tblKursus').dataTable().fnGetData($(this).parents('tr')[0]);
			
			$('#myModal_update #cou_code').val(aData[0]);
			$('#myModal_update #cou_course_code').val(aData[1]);
			$('#myModal_update #cou_name').val(aData[2]);
			$('#myModal_update #cou_cluster').val(aData[3]);
			$('#myModal_update #cou_id').val(id);
			
			$('#myModal_update').modal('show');
			
			
			$('#frmUpdate').validationEngine('attach',{
				onValidationComplete: function(form, status){
					if(status){
						updateKursus();
					}
				}
			});
		});
	});
	
	/****************************************************************************
 	* Description		: this function is use to insert new course
 	* input				: -
 	* author			: Jz
 	* Date				: 01-04-2014
 	* Modification Log	:
 	*****************************************************************************/
	function insertKursus(){
		var frm = $("#frmInsert").serializeArray();
		var formObject = {};
		$.each(frm,function(i,v){
			formObject[v.name] = v.value;
		});
		
		$.ajax({
			url: '<?=site_url('maintenance/crud_course/insert')?>',
			data: formObject,
			type: 'POST',
			dataType: 'html',
			success: function(data){
				var mssg = new Array();
				if(data){
					mssg['heading'] = 'Mesej - Berjaya';
					mssg['content'] = 'Kursus berjaya didaftar';
				}else{
					mssg['heading'] = '<font color="red">Mesej - Tidak Berjaya</font>';
					mssg['content'] = '<font color="red">Kursus tidak berjaya didaftar</font>';
				}
				mssg['hideCallback'] = true;
				mssg['callback'] = function(){
					window.location.reload();
				}
				kv_alert(mssg);
			}
		});
	}
	
	/****************************************************************************
 	* Description		: this function is use to update course
 	* input				: -
 	* author			: Jz
 	* Date				: 01-04-2014
 	* Modification Log	:
 	*****************************************************************************/
	function updateKursus(){
		var frm = $("#frmUpdate").serializeArray();
		var formObject = {};
		$.each(frm,function(i,v){
			formObject[v.name] = v.value;
		});
		
		$.ajax({
			url: '<?=site_url('maintenance/crud_course/update')?>',
			data: formObject,
			type: 'POST',
			dataType: 'html',
			success: function(data){
				
				var mssg = new Array();
				if(data){
					mssg['heading'] = 'Mesej - Berjaya';
					mssg['content'] = 'Kursus berjaya diubah';
				}else{
					mssg['heading'] = '<font color="red">Mesej - Tidak Berjaya</font>';
					mssg['content'] = '<font color="red">Kursus tidak berjaya diubah</font>';
				}
				mssg['hideCallback'] = true;
				mssg['callback'] = function(){
					window.location.reload();
				}
				kv_alert(mssg);
			}
		});
	}
	
	/****************************************************************************
 	* Description		: this function is use to delete the kursus
 	* input				: id - refer primary key field
 	* author			: Jz
 	* Date				: 01-04-2014
 	* Modification Log	:
 	*****************************************************************************/
	function confirm_delete_msg(id){
		var filter = id;
		
		var mssg = new Array();
		mssg['hideCallback'] = true;
		mssg['callback'] = function(){
			$.ajax({
				url: '<?=site_url('maintenance/crud_course/delete')?>',
				data: {cou_id:filter},
				type: 'POST',
				dataType: 'html',
				success: function(data){
					var mssg = new Array();
					if(data){
						mssg['heading'] = 'Mesej - Berjaya';
						mssg['content'] = 'Kursus berjaya dipadam';
					}else{
						mssg['heading'] = '<font color="red">Mesej - Tidak Berjaya</font>';
						mssg['content'] = '<font color="red">Kursus tidak berjaya dipadam</font>';
					}
					mssg['hideCallback'] = true;
					mssg['callback'] = function(){
						window.location.reload();
					}
					kv_alert(mssg);
				}
			});
		};
		mssg['cancelCallback'] = function(){};
		kv_confirm(mssg);
	}
	
</script>


<legend>
	<h3>
		Penyenggaraan Kursus
		<div style="float:right; width:249px;">
			<a class="btn btn-success" id="btn_insert_popup">
				<span>Tambah Kursus Baru</span>
			</a>
		</div>
	</h3>
</legend>
<?php
if(!empty($datatable)){
	echo $datatable;
}

?>

<!-- The code below list the popup form to insert or update the data -->
<div class="modal hide fade" id="myModal_insert" style="width: 60%; margin-left: -30%;">
	<div class="modal-header">
		<button id="btn_close" type="button" class="close"
			data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
		<h3>Tambah Kursus Baru</h3>
	</div>
	<form method="post" id="frmInsert" name="frmInsert" class="form-horizontal" style="margin-top: 20px;">
		<div class="modal-body" id="span_result2">
				<div class="control-group">
					<label class="control-label" for="cou_code">Cou code:</label>
					<div class="controls">
						<input type="text" name="cou_code" id="cou_code" class="validate[required] text-input" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="cou_course_code">Kod Kursus:</label>
					<div class="controls">
						<input type="text" name="cou_course_code" id="cou_course_code" class="validate[required] text-input" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="cou_name">Nama Kursus:</label>
					<div class="controls">
						<input type="text" name="cou_name" id="cou_name" class="validate[required] text-input" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="cou_cluster">Kluster Kursus:</label>
					<div class="controls">
						<input type="text" name="cou_cluster" id="cou_cluster" class="validate[required] text-input" />
					</div>
				</div>
			
		</div>
		<div class="modal-footer">
				<div class="pull-right">
					<input type="submit" value="Tambah" class="btn btn-info btn-block" style="width:150px;" />
				</div>
		</div>
	</form>
</div>


<!-- The code below list the popup form to insert or update the data -->
<div class="modal hide fade" id="myModal_update" style="width: 60%; margin-left: -30%;">
	<div class="modal-header">
		<button id="btn_close" type="button" class="close"
			data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
		<h3>Ubah Kursus</h3>
	</div>
	<form method="post" id="frmUpdate" name="frmUpdate" class="form-horizontal" style="margin-top: 20px;">
		<div class="modal-body" id="span_result2">
				<div class="control-group">
					<label class="control-label" for="cou_code">Cou code:</label>
					<div class="controls">
						<input type="text" name="cou_code" id="cou_code" class="validate[required] text-input" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="cou_course_code">Kod Kursus:</label>
					<div class="controls">
						<input type="text" name="cou_course_code" id="cou_course_code" class="validate[required] text-input" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="cou_name">Nama Kursus:</label>
					<div class="controls">
						<input type="text" name="cou_name" id="cou_name" class="input-xlarge validate[required] text-input" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="cou_cluster">Kluster Kursus:</label>
					<div class="controls">
						<input type="text" name="cou_cluster" id="cou_cluster" class="input-xlarge validate[required] text-input" />
					</div>
					<div>
						<input type="hidden" name="cou_id" id="cou_id" />
					</div>
				</div>
			
		</div>
		<div class="modal-footer">
				<div class="pull-right">
					<input type="submit" value="Ubah" class="btn btn-info btn-block" style="width:100px;" />
				</div>
		</div>
	</form>
</div>


