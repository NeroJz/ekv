<script type="text/javascript">
	$(document).ready(function(){
		$("#toggleRow").hide();
		$("#updateFrm").validationEngine();
		
		$( "#btn_togbgle" ).click(function() {
		  $( "#toggleRow" ).toggle( "slow" );
		});
	});
	//function accept number only
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
	
	function addUserGroup(evt){
		var jawatan = $("#addNewRole").val();
		var user_id = $("#user_id").val();
		var data_input = {
			'ul_id' : jawatan,
			'user_id' : user_id
		};
		
		$.ajax({
			url: '<?=site_url('management/user/add_usergroup')?>',
			type: 'POST',
			data: data_input,
			success: function(msg){
				var mssg = new Array();
				if(msg){
					mssg['heading'] = 'Mesej';
					mssg['content'] = 'Jawatan baru berjaya ditambahkan';
					mssg['callback'] = function(){
						window.location.reload();
					};
				}else if(!msg){
					mssg['heading'] = '<font color="red">Mesej</color>';
					mssg['content'] = '<font color="red">Jawatan baru tidak berjaya ditambahkan</color>';
					mssg['callback'] = function(){
						window.location.reload();
					};
				}
				mssg['hideCallback'] = true;
				kv_alert(mssg);
				
			}
		});
		
		
	}
	
	
	function upadateUserGroup(obj){
		var target = $(obj);
		
		var data_input = {
			'ug_id' : target.attr('name'),
			'ul_id' : target.attr('value')
		};
		
		$.ajax({
			url: '<?=site_url('management/user/update_usergroup')?>',
			type: 'POST',
			data: data_input,
			success: function(msg){
				var mssg = new Array();
				if(msg){
					mssg['heading'] = 'Mesej';
					mssg['content'] = 'Jawatan berjaya dikemaskini';
				}else if(!msg){
					mssg['heading'] = '<font color="red">Mesej</color>';
					mssg['content'] = '<font color="red">Jawatan tidak berjaya dikemaskini</color>';
				}
				kv_alert(mssg);
				
			}
		});
	}
	
	function deleteUserRole(ug_id){
		var data_input = {'ug_id': ug_id};
		
		$.ajax({
			url: '<?=site_url('management/user/delete_usergroup')?>',
			type: 'POST',
			data: data_input,
			success: function(msg){
				var mssg = new Array();
				if(msg){
					mssg['heading'] = 'Mesej';
					mssg['content'] = 'Jawatan berjaya dipadamkan';
					mssg['callback'] = function(){
						window.location.reload();
					};
				}else if(!msg){
					mssg['heading'] = '<font color="red">Mesej</color>';
					mssg['content'] = '<font color="red">Jawatan tidak berjaya dipadamkan</color>';
					mssg['callback'] = function(){
						window.location.reload();
					};
				}
				mssg['hideCallback'] = true;
				kv_alert(mssg);
				
			}
		});
	}
	
</script>

<legend><h3>Kemas kini Pengguna</h3>
</legend>
<form action="<?=site_url('management/user/update_info')?>" method="post" id="updateFrm" class="form-horizontal">
	<div class="control-group">
		<label class="control-label" for="nama">Nama Pengguna</label>
		<div class="controls">
			<input type="text" name="nama" id="nama" class="input-xlarge validate[required]" value="<?=$pengguna_nama;?>" />
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="u_nama">Username</label>
		<div class="controls">
			<input type="text" name="u_nama" id="u_nama" class="input-xlarge validate[required]" value="<?=$pengguna_unama;?>" />
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="email">Email</label>
		<div class="controls">
			<input type="text" name="email" id="email" class="input-xlarge validate[custom[email]]" value="<?=$pengguna_email;?>" />
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="status">Status</label>
		<div class="controls">
			<label><input type="radio" name="status" value="1" <?php if($pengguna_status){echo "checked='checked'";} ?> />&nbsp;Aktif</label>
			<label><input type="radio" name="status" value="0" <?php if(!$pengguna_status){echo "checked='checked'";} ?>  />&nbsp;Tidak Aktif</label>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="telefon">No. Telefon</label>
		<div class="controls">
			<input type="text" name="telefon" id="telefon" value="<?=$pengguna_telefon;?>" onkeypress='validate(event);' />
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="nama">Negeri</label>
		<div class="controls">
			<input type="text" disabled="disabled" value="<?=$pengguna_state;?>" />
			
		</div>
	</div>
	<?php
		if(!empty($jawatan)){
			$i=1;
			foreach($jawatan as $user){
				 
	?>
				<div class="control-group">
					<label class="control-label">Jawatan&nbsp;<?=$i;?></label>
					<div class="controls">
						<?=$user['slct_box'];?>
						<?php
							if(sizeof($jawatan) > 1){
						?>
								<a title="Padam Jawatan" class="btn btn-danger" onclick="deleteUserRole(<?=$user['ug_id'];?>)">
									<i class="icon-trash icon-white"></i>
								</a>
						<?
							}
						?>
						
					</div>
					
				</div>
	<?php
			$i++;	
			}
		}
	?>
	
	<div class="control-group">
		<div class="controls">
			<button type="submit" class="btn btn-info">
				Simpan
			</button>
			<a class="btn btn-warning" id="btn_togbgle">
				<i class="icon-plus icon-white"></i> Tambah Jawatan Baru
			</a>
		</div>	
	</div>
	<div id="toggleRow" class="control-group col-md-4" style="border: 1px solid grey; padding: 15px; max-width: 500px;">
		<label class="control-label" for="nama">Tambah Jawatan Baru: </label>
		<div class="controls">
			<?=$addDropbox;?>
			<a class="btn btn-success" style="margin-top: 5px;" onclick="addUserGroup(event);">
			 	Tambah
			</a>
		</div>
	</div>
	
<input type="hidden" name="user_id" id="user_id" value="<?=$pengguna_id;?>" />
</form>