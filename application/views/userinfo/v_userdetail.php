<script type="text/javascript">
$(document).ready(function(){
	
	$("#form3").validationEngine();
	
	$('#btn_change').click(function(){
		
		$('#password_popup').val("");
		$('#password2').val("");
		
		$('#myPassword').modal({
          keyboard: false,
          backdrop: 'static'
        }); 
	});
	
	$('#form3').on('click','#submit2',function(){
		
		var validate = $('#form3').validationEngine('validate');
		if(validate)
		{
			var user_pass = $('#password_popup').val();
			//site_url('management/userinfo/update_password') ?>
			$('#myPassword').modal('hide')
			
			$.blockUI({ 
				message: '<h5><img src="'+base_url+
				'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h5>', 
				css: { border: '3px solid #660a30' } 
			});
			
			//ajax submit the values
			var request = $.ajax({
				url: base_url+"index.php/management/userinfo/update_password",
				type: "POST",
				data: {user_password : user_pass},
				dataType: "html"
			});
	
			request.done(function(data) {
	
				$.unblockUI();
				
				//msg("Berjaya", data, "Ok");
				var opts = new Array();
				opts['heading'] = 'Berjaya';
				opts['content'] = 'Kemask kini berjaya';
				
				kv_alert(opts);
			});
	
			request.fail(function(jqXHR, textStatus) {
				$.unblockUI();
				//msg("Request failed", textStatus, "Ok");
			});
			//alert();
		}
	});
	
});
</script>

<h3>Maklumat</h3>

<table class="table table-striped">
	
		<tr>
			<td>Nama Pengguna</td>
			<td><?=$userinfo[0]->user_name?></td>
		</tr>
		<tr>
			<td>Katanama</td>
			<td><?=$userinfo[0]->user_username?></td>
		</tr>
		<tr>
			<td>Kata Laluan</td>
			<td><input type="button" id="btn_change" class="btn btn-info" value="Tukar Kata laluan" /></td>
		</tr>
		<tr>
			<td>Email</td>
			<td><?=$userinfo[0]->user_email?></td>
		</tr> 
		<?php if(!empty($userinfo[0]->col_id)){ ?>
		<tr>
			<td>Kolej</td>
			<td><?=$userinfo[0]->col_name?></td>
		</tr>
		<?php } ?>
		<tr>
			<td>Jawatan</td>
			<td><?=$userinfo[0]->ul_name?></td>
		</tr>
	</tbody>
</table>

<div class="modal hide fade" id="myPassword">
    <div class="modal-header">
        <h3><strong>KATA LALUAN</strong></h3>
    </div>
<div class="modal-body" >
        <form id="form3" name="form3" style="position:relative;" method="post">
          <span><i style="color:red">Kemaskini kata laluan</i></span>
            <table class="table table-striped table-bordered table-condensed">
               <tbody>
                      <tr>
                         <td width="136"><strong> Kata Laluan</strong></td>
                         <td width="5"> <div align="center"><strong>:</strong></div></td>
                         <td width="729"><input class="validate[required] text-input" name="password1" id="password_popup" size="20" maxlength="20" type="password" value="" /></td>
                       </tr>
                        <tr>
                          <td width="156"><strong>Sahkan Kata Laluan</strong></td>
                          <td width="5"> <div align="center"><strong>:</strong></div></td>
                          <td width="729"><input class="validate[required,equals[password_popup]] text-input" name="password2" id="password2" size="20" maxlength="20" type="password" value="" /></td>
                         </tr>
				</tbody>
               
            </table>
         
    <div class="modal-footer">
        <input type="hidden"  value="katalaluan" name="updatePassword" />
	<a href="#" class="btn" data-dismiss="modal">TIDAK</a>
        <button type="button" name="submit2" class="btn btn-primary pull-right" id="submit2"><span>KEMASKINI</span></button>
    </div>
        </form>
    </div>

</div>
