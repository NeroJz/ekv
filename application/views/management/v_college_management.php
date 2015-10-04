<script type="text/javascript">
	$("document").ready(function(){
		$("#btn_insert_popup").bind("click",function(){
			$('#myModal_insert').modal('show');
			$('#frmInsert').validationEngine('attach',{
				onValidationComplete: function(form, status){
					if(status){
						insertKolej();
					}
				}
			});
		});
		
		$('#tblKolej tbody .btn_edit_popup').live('click',function(){
			var id = $(this).attr('value');
			
			var aData = $('#tblKolej').dataTable().fnGetData($(this).parents('tr')[0]);
			
			var request_ColType = $.ajax({
				url: '<?=site_url('management/college/callback_edit_college_type')?>',
				type: 'POST',
				data: {col_type: aData[0]},
				dataType: "html"
			});
			var request_Director = $.ajax({
				url: '<?=site_url('management/college/callback_edit_user_type')?>',
				type: 'POST',
				data: {
						col_id		: id,
						field_name	: 'col_director',
						user_name	: aData[3]
					  },
				dataType: "html"
			});
			var request_depDirector = $.ajax({
				url: '<?=site_url('management/college/callback_edit_user_type')?>',
				type: 'POST',
				data: {
						col_id		: id,
						field_name	: 'col_dep_director',
						user_name	: aData[4]
					  },
				dataType: "html"
			});
			var request_colKJPP = $.ajax({
				url: '<?=site_url('management/college/callback_edit_user_type')?>',
				type: 'POST',
				data: {
						col_id		: id,
						field_name	: 'col_kjpp',
						user_name	: aData[5]
					  },
				dataType: "html"
			});
			var request_colKUPP = $.ajax({
				url: '<?=site_url('management/college/callback_edit_user_type')?>',
				type: 'POST',
				data: {
						col_id		: id,
						field_name	: 'col_kupp',
						user_name	: aData[6]
					  },
				dataType: "html"
			});
			var request_state = $.ajax({
				url: '<?=site_url('management/college/callback_edit_state')?>',
				type: 'POST',
				data: {
						state	: aData[10]
					  },
				dataType: "html"
			});
			
			request_ColType.done(function(msg){
				$('#myModal_update #drop_menu_jenis_kolej').html(msg);
			});
			request_Director.done(function(msg){
				$('#myModal_update #drop_menu_pengarah_kolej').html(msg);
			});
			request_depDirector.done(function(msg){
				$('#myModal_update #drop_menu_dep_pengarah_kolej').html(msg);
			});
			request_colKJPP.done(function(msg){
				$('#myModal_update #drop_menu_kjpp_kolej').html(msg);
			});
			request_colKUPP.done(function(msg){
				$('#myModal_update #drop_menu_kupp_kolej').html(msg);
			});
			request_state.done(function(msg){
				$('#myModal_update #drop_menu_state_kolej').html(msg);
			});
			
			request_ColType.fail(function(jqXHR, textStatus){});
			request_Director.fail(function(jqXHR, textStatus){});
			request_depDirector.fail(function(jqXHR, textStatus){});
			request_colKJPP.fail(function(jqXHR, textStatus){});
			request_colKUPP.fail(function(jqXHR, textStatus){});
			request_state.fail(function(jqXHR, textStatus){});
			
			$('#myModal_update #col_name').val(aData[1]);
			$('#myModal_update #col_code').val(aData[2]);
			$('#myModal_update #col_phone').val(aData[7]);
			$('#myModal_update #col_kupp_phone').val(aData[8]);
			$('#myModal_update #col_email').val(aData[9]);
			$('#myModal_update #col_id').val(id)
			
			$('#myModal_update').modal('show');
			
			
			$('#frmUpdate').validationEngine('attach',{
				onValidationComplete: function(form, status){
					if(status){
						updateKolej();
					}
				}
			});
		});
	});
	
	/****************************************************************************
 	* Description		: this function is use to insert new Kolej
 	* input				: -
 	* author			: Jz
 	* Date				: 01-04-2014
 	* Modification Log	:
 	*****************************************************************************/
	function insertKolej(){
		var frm = $("#frmInsert").serializeArray();
		var formObject = {};
		$.each(frm,function(i,v){
			formObject[v.name] = v.value;
		});
		
		$.ajax({
			url: '<?=site_url('management/college/insert')?>',
			data: formObject,
			type: 'POST',
			dataType: 'html',
			success: function(data){
				var mssg = new Array();
				if(data){
					mssg['heading'] = 'Mesej - Berjaya';
					mssg['content'] = 'Kolej berjaya didaftar';
				}else{
					mssg['heading'] = '<font color="red">Mesej - Tidak Berjaya</font>';
					mssg['content'] = '<font color="red">Kolej tidak berjaya didaftar</font>';
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
 	* Description		: this function accept number only
 	* input				: -
 	* author			: Jz
 	* Date				: 01-04-2014
 	* Modification Log	:
 	*****************************************************************************/
	function validate(evt) {
		var theEvent = evt || window.event;
		var key = theEvent.keyCode || theEvent.which;
		key = String.fromCharCode( key );
		var regex = /[0-9]|\./;
		if( !regex.test(key) ) {
		    theEvent.returnValue = false;
		    if(theEvent.preventDefault) theEvent.preventDefault();
		}
	}
	/****************************************************************************
 	* Description		: this function is use to update college
 	* input				: -
 	* author			: Jz
 	* Date				: 01-04-2014
 	* Modification Log	:
 	*****************************************************************************/
	function updateKolej(){
		var frm = $("#frmUpdate").serializeArray();
		var formObject = {};
		$.each(frm,function(i,v){
			formObject[v.name] = v.value;
		});
		
		$.ajax({
			url: '<?=site_url('management/college/update')?>',
			data: formObject,
			type: 'POST',
			dataType: 'html',
			success: function(data){
				
				var mssg = new Array();
				if(data){
					mssg['heading'] = 'Mesej - Berjaya';
					mssg['content'] = 'Kolej berjaya dikemaskini';
				}else{
					mssg['heading'] = '<font color="red">Mesej - Tidak Berjaya</font>';
					mssg['content'] = '<font color="red">Kolej tidak berjaya dikemaskini</font>';
				}
				mssg['hideCallback'] = true;
				mssg['callback'] = function(){
					window.location.reload();
				}
				kv_alert(mssg);
			}
		});
	}
</script>


<legend>
	<h3>
		Penyenggaraan Kolej
		<div style="float:right; width:249px;">
			<a class="btn btn-success" id="btn_insert_popup">
				<span>Tambah Kolej Baru</span>
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
		<h3>Tambah Kolej Baru</h3>
		<p>Sila pasti anda isi maklumat yang bertanda *</p>
	</div>
	<form method="post" id="frmInsert" name="frmInsert" class="form-horizontal" style="margin-top: 20px; padding-top: 20px;">
		<div class="modal-body" id="span_result2">
				<div class="control-group">
					<label class="control-label" for="col_type">Jenis Kolej* :</label>
					<div class="controls">
						<?=$col_type;?>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="cou_course_code">Nama Kolej* :</label>
					<div class="controls">
						<input type="text" name="col_name" id="col_name" class="validate[required] text-input" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="col_code">Kod Kolej :</label>
					<div class="controls">
						<input type="text" name="col_code" id="col_code" class="text-input" onkeypress="validate(event)" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="col_phone">No. Telefon Kolej :</label>
					<div class="controls">
						<input type="text" name="col_phone" id="col_phone" class="text-input" onkeypress="validate(event)" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="col_kupp_phone">No. Telefon KUPP :</label>
					<div class="controls">
						<input type="text" name="col_kupp_phone" id="col_kupp_phone" class="text-input" onkeypress="validate(event)" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="col_email">Email Kolej :</label>
					<div class="controls">
						<input type="text" name="col_email" id="col_email" class="text-input" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="state_id">Negeri* :</label>
					<div class="controls">
						<select name="state_id" id="state_id" class="validate[required]">
						<?php
						foreach($state as $row){ ?>
							<option value="<?=$row->state_id;?>"><?=$row->state_code;?>&nbsp;-&nbsp;<?=$row->state;?></option>
						<?php }	?>
					</select>
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
		<h3>Kemasikini Kolej</h3>
	</div>
	<form method="post" id="frmUpdate" name="frmUpdate" class="form-horizontal" style="margin-top: 20px">
		<div class="modal-body" id="span_result2">
				<div class="control-group">
					<label class="control-label" for="col_type">Jenis Kolej :</label>
					<div class="controls" id="drop_menu_jenis_kolej">
						
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="cou_course_code">Nama Kolej :</label>
					<div class="controls">
						<input type="text" name="col_name" id="col_name" class="validate[required] text-input" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="col_code">Kod Kolej :</label>
					<div class="controls">
						<input type="text" name="col_code" id="col_code" class="validate[required] text-input" onkeypress="validate(event)" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="col_director">Pengarah Kolej :</label>
					<div class="controls" id="drop_menu_pengarah_kolej">
						
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="col_code">Timbalan Pengarah Kolej :</label>
					<div class="controls" id="drop_menu_dep_pengarah_kolej">
						
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="col_kjpp">KJPP Kolej :</label>
					<div class="controls" id="drop_menu_kjpp_kolej">
						
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="col_kupp">KUPP Kolej :</label>
					<div class="controls" id="drop_menu_kupp_kolej">
						
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="col_phone">No. Telefon Kolej :</label>
					<div class="controls">
						<input type="text" name="col_phone" id="col_phone" class="text-input" onkeypress="validate(event)" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="col_kupp_phone">No. Telefon KUPP :</label>
					<div class="controls">
						<input type="text" name="col_kupp_phone" id="col_kupp_phone" class="text-input" onkeypress="validate(event)" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="col_email">Email Kolej :</label>
					<div class="controls">
						<input type="text" name="col_email" id="col_email" class="text-input" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="state_id">Negeri :</label>
					<div class="controls" id="drop_menu_state_kolej">
						
					</div>
					<div>
						<input type="hidden" name="col_id" id="col_id" />
					</div>
				</div>
		</div>
		<div class="modal-footer">
				<div class="pull-right">
					<input type="submit" value="Kemaskini" class="btn btn-info btn-block" style="width:150px;" />
				</div>
		</div>
	</form>
</div>