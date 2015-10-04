<script>
	var json = <?=$content?>;
	var jsonUpdate;
	$(document).ready(function(){
		loadContent();
		$('#tblModul').hide();
		
		$("#btn_insert_popup").bind("click",function(){
			$('#myModal_insert').modal('show');
			loadContent();
			$('#frmInsert').validationEngine('attach',{
				onValidationComplete: function(form, status){
					if(status){
						insertModule();
						$("#frmInsert").unbind('submit');
         				return false;
					}
				}
			});
		});
		
		/****************************************************************************
	 	* Description		: this function call pop-up edit form
	 	* input				: -
	 	* author			: Jz
	 	* Date				: 07-04-2014
	 	* Modification Log	:
	 	*****************************************************************************/
		$("#tblModul tbody .btn_edit_popup").live('click',function(){
			var mod_id = $(this).attr('value');
			$('#frmUpdate #mod_id').val(mod_id);
			var aData = $('#tblModul').dataTable().fnGetData($(this).parents('tr')[0]);
			
			$('#frmUpdate #mod_code').val(aData[0]);
			$('#frmUpdate #mod_paper').val(aData[1]);
			$('#frmUpdate #mod_name').val(aData[2]);
			$('#frmUpdate #mod_type').val(aData[3]);
			$('#frmUpdate #mod_credit_hour').val(aData[8]);
			
			
			var request = $.ajax({
				url: '<?=site_url('maintenance/crud_module/callback_edit')?>',
				data: {'mod_id':mod_id},
				type: 'POST',
				dataType: 'html'
			});
			
			request.done(function(data){
				jsonUpdate = JSON.parse(data);
				$('#frmUpdate #stat_mod').val(jsonUpdate.stat_mod);
				$('#frmUpdate #mod_type').val(jsonUpdate.mod_type);
				loadUpdateContent();
				$('#frmUpdate #mod_mark_centre').val(aData[4]);
				$('#frmUpdate #mod_mark_school').val(aData[6]);
			});
			
			$('#myModal_update').modal('show');
			$('#frmUpdate').validationEngine('attach',{
				onValidationComplete: function(form, status){
					if(status){
						updateModule();
						$("#frmUpdate").unbind('submit');
         				return false;
					}
				}
			});
		});
		
		/****************************************************************************
	 	* Description		: assign btn_search to Click event, filter the datatable
	 	* input				: -
	 	* author			: Jz
	 	* Date				: 07-04-2014
	 	* Modification Log	:
	 	*****************************************************************************/
		$('#btn_search').bind("click",function(){
			loadDatatable();
		});
	});
	/****************************************************************************
	 * Description		: load datatable
	 * input			: -
	 * author			: Jz
	 * Date				: 07-04-2014
	 * Modification Log	:
	*****************************************************************************/
	function loadDatatable(){
		$('#tblModul').show();
		var sCategory = $('#slct_category').val();
		var sStatus = $('#slct_status').val();
		
		<?=$vScript?>
	}
	
	/****************************************************************************
	 * Description		: load content based on the module type
	 * input			: -
	 * author			: Jz
	 * Date				: 07-04-2014
	 * Modification Log	:
	*****************************************************************************/
	function loadContent(){
		var module_type = $('#frmInsert #mod_type').val();
		
		if(module_type == 'AK'){
			$('#frmInsert #loadContent').html(json.AK_content);
		}else if(module_type == 'VK'){
			$('#frmInsert #loadContent').html(json.VK_content);
		}
	}
	
	function loadUpdateContent(){
		var module_type = $('#frmUpdate #mod_type').val();
		
		if(module_type == 'AK'){
			$('#frmUpdate #loadUpdateContent').html(jsonUpdate.AK_content);
		}else if(module_type == 'VK'){
			$('#frmUpdate #loadUpdateContent').html(jsonUpdate.VK_content);
		}
	}
	
	/****************************************************************************
 	* Description		: this function is use to insert new module
 	* input				: -
 	* author			: Jz
 	* Date				: 01-04-2014
 	* Modification Log	:
 	*****************************************************************************/
	function insertModule(){
		var frm = $("#frmInsert").serializeArray();
		var formObject = {};
		$.each(frm,function(i,v){
			formObject[v.name] = v.value;
		});
		
		var request = $.ajax({
			url: '<?=site_url('maintenance/crud_module/insert')?>',
			data: formObject,
			type: 'POST',
			dataType: 'html'
		});
		$('#frmInsert')[0].reset();
		$.unblockUI();
		$('#myModal_insert').modal('toggle');
		request.done(function(data){
			var mssg = new Array();
			if(data == true){
				mssg['heading'] = 'Mesej - Berjaya';
				mssg['content'] = 'Modul berjaya didaftar';
			}else if(data == false){
				mssg['heading'] = '<font color="red">Mesej - Tidak Berjaya</font>';
				mssg['content'] = '<font color="red">Modul tidak berjaya didaftar</font>';
			}
				mssg['hideCallback'] = true;
				mssg['callback'] = function(){
					loadDatatable();
				}
				kv_alert(mssg);
		});
		request.fail(function(jqXHR, testStatus){
				var mssg = new Array();
				mssg['heading'] = '<font color="red">Mesej - Tidak Berjaya</font>';
				mssg['content'] = '<font color="red">Modul tidak berjaya didaftar</font>';
				mssg['hideCallback'] = true;
				mssg['callback'] = function(){
					loadDatatable();
				}
				kv_alert(mssg);
		});
	}
	/****************************************************************************
 	* Description		: this function is use to update module
 	* input				: -
 	* author			: Jz
 	* Date				: 01-04-2014
 	* Modification Log	:
 	*****************************************************************************/
	function updateModule(){
		var frm = $("#frmUpdate").serializeArray();
		var formObject = {};
		$.each(frm,function(i,v){
			formObject[v.name] = v.value;
		});
		/*** Call to server to update ****/
		var update = $.ajax({
			url: '<?=site_url('maintenance/crud_module/update')?>',
			data: formObject,
			type: 'POST',
			dataType: 'html',
		});
		$('#frmUpdate')[0].reset();
		$.unblockUI();
		$('#myModal_update').modal('toggle');
		
		update.done(function(data){
			var mssg = new Array();
			if(data == true){
				mssg['heading'] = 'Mesej - Berjaya';
				mssg['content'] = 'Modul berjaya dikemaskini';
			}else if(data == false){
				mssg['heading'] = '<font color="red">Mesej - Tidak Berjaya</font>';
				mssg['content'] = '<font color="red">Kemasikini tidak berjaya didaftar</font>';
			}
			mssg['hideCallback'] = true;
			mssg['callback'] = function(){
				loadDatatable();
			}
			kv_alert(mssg);
		});
		update.fail(function(jqXHR, testStatus){
				var mssg = new Array();
				mssg['heading'] = '<font color="red">Mesej - Tidak Berjaya</font>';
				mssg['content'] = '<font color="red">Kemasikini tidak berjaya didaftar</font>';
				mssg['hideCallback'] = true;
				mssg['callback'] = function(){
					loadDatatable();
				}
				kv_alert(mssg);
		});
	}
</script>


<legend>
	<h3>
		Penyenggaraan Modul
		<div style="float:right; width:249px;">
			<a class="btn btn-success" id="btn_insert_popup">
				<span>Tambah Modul Baru</span>
			</a>
		</div>
	</h3>
</legend>

<?php
	if($this->ion_auth->in_group("Admin LP")||$this->ion_auth->in_group("UPMPD")||
	   $this->ion_auth->in_group("SPDP")||$this->ion_auth->in_group("BPTV")||$this->ion_auth->in_group("JPN")){
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
		            		<option value="AK">Akademik</option>
		            		<option value="VK">Vokasional</option>
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
			            	<option value="1">Aktif</option>
			            	<option value="0" >Tidak Aktif</option>
						</select>
		            </div>        
		        </td>
		    </tr>
		    
		    <tr>
		    	<td></td>
		    	<td height="35"><div align="right"></div></td>
		        <td height="35">
		        	<div align="left">
		        		<a class="btn btn-info" id="btn_search"><span>Papar</span></a>
		          		<a class="btn btn-success"><span>Set Semula</span></a>
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
<?php
echo $vView;
?>

<div class="modal hide fade" id="myModal_insert" style="width: 60%; margin-left: -30%;">
	<div class="modal-header">
		<button id="btn_close" type="button" class="close"
			data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
		<h3>Penambahan Modul Baru</h3>
	</div>
	<form method="post" id="frmInsert" name="frmInsert" class="form-horizontal" style="margin-top: 20px; padding-top: 20px;">
		<div class="modal-body" id="span_result2">
				<div class="control-group">
					<label class="control-label" for="mod_code">Kod Modul : </label>
					<div class="controls">
						<input type="text" name="mod_code" id="mod_code" class="validate[required] text-input" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="mod_paper">Kertas Modul :</label>
					<div class="controls">
						<input type="text" name="mod_paper" id="mod_paper" class="validate[required] text-input" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="mod_name">Nama Modul :</label>
					<div class="controls">
						<input type="text" name="mod_name" id="mod_name" class="validate[required] text-input" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="mod_type">Jenis Modul :</label>
					<div class="controls">
						<select name="mod_type" id="mod_type" onchange="loadContent();">
							<option value="AK">AK</option>
							<option value="VK">VK</option>
						</select>
					</div>
				</div>
				<div id="loadContent"></div>
				<div class="control-group">
					<label class="control-label" for="mod_credit_hour">Jam Kredit Modul :</label>
					<div class="controls">
						<input type="text" name="mod_credit_hour" id="mod_credit_hour" class="text-input" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="stat_mod">Status :</label>
					<div class="controls">
						<select name="stat_mod" id="stat_mod">
							<option value="0">Tak Aktif</option>
							<option value="1">Aktif</option>
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
<div class="modal hide fade" id="myModal_update" style="width: 60%; margin-left: -30%;">
	<div class="modal-header">
		<button id="btn_close" type="button" class="close"
			data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
		<h3>Kemaskini Modul</h3>
	</div>
	<form method="post" id="frmUpdate" name="frmUpdate" class="form-horizontal" style="margin-top: 20px; padding-top: 20px;">
		<div class="modal-body" id="span_result2">
				<div class="control-group">
					<label class="control-label" for="mod_code">Kod Modul : </label>
					<div class="controls">
						<input type="text" name="mod_code" id="mod_code" class="validate[required] text-input" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="mod_paper">Kertas Modul :</label>
					<div class="controls">
						<input type="text" name="mod_paper" id="mod_paper" class="validate[required] text-input" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="mod_name">Nama Modul :</label>
					<div class="controls">
						<input type="text" name="mod_name" id="mod_name" class="validate[required] text-input" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="mod_type">Jenis Modul :</label>
					<div class="controls">
						<select name="mod_type" id="mod_type" onchange="loadUpdateContent();">
							<option value="AK">AK</option>
							<option value="VK">VK</option>
						</select>
					</div>
				</div>
				<div id="loadUpdateContent"></div>
				<div class="control-group">
					<label class="control-label" for="mod_credit_hour">Jam Kredit Modul :</label>
					<div class="controls">
						<input type="text" name="mod_credit_hour" id="mod_credit_hour" class="text-input" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="stat_mod">Status :</label>
					<div class="controls">
						<select name="stat_mod" id="stat_mod">
							<option value="0">Tak Aktif</option>
							<option value="1">Aktif</option>
						</select>
						<input type="hidden" name="mod_id" id="mod_id" />
					</div>
				</div>
			
		</div>
		<div class="modal-footer">
				<div class="pull-right">
					<input type="submit" value="Kemas Kini" class="btn btn-info btn-block" style="width:150px;" />
				</div>
		</div>
	</form>
</div>
<p>&nbsp;</p>