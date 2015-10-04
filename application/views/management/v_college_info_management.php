<script type="text/javascript">
$(document).ready(function(){
	
	$("#form").validationEngine();
	
	$('#btn_change').click(function()
	{
		
		$('#modalUpdate').modal({
          keyboard: false,
          backdrop: 'static'
        }); 
	});
	
	$('#form').on('click','#btnUpdate',function(){
		
		var validate = $('#form').validationEngine('validate');
		if(validate)
		{

			var director 		= $('#director').val();
			var directorId 		= $('#director_id').val();
			var timDirector 	= $('#tim_director').val();
			var timDirectorId 	= $('#tim_director_id').val();
			var phone 			= $('#phone').val();
			var email 			= $('#email').val();
			var kolejId 		= $('#kolej_id').val();

			$('#modalUpdate').modal('hide')
			
			$.blockUI({ 
				message: '<h5>Sedang diproses, Sila tunggu...</h5><div class="progress progress-striped active" style="width: 70%; margin-left: 15%;"><div class="bar" style="width: 100%;"></div></div>', 
				css: { border: '3px solid #660a30' } 
				
			});

			setTimeout(function()
			{
			//ajax submit the values
				var request = $.ajax({
					url: base_url+"index.php/management/college/update_college_info",
					type: "POST",
					data: {	directorkv : director,
							directoridkv : directorId,
							timdirectorkv : timDirector,
							timdirectoridkv : timDirectorId,
							phonekv : phone, 
							emailkv : email,  
							dir_col_idkv : kolejId
						   },
					dataType: "json"
				});

	
				request.done(function(data) {
		
					$.unblockUI();
					
					var opts = new Array();
					opts['heading'] = 'BERJAYA';
					opts['content'] = 'Maklumat Kolej Berjaya Dikemaskini.';
					opts['callback'] = function()
					{
						location.reload();
					}
					
					kv_alert(opts);
				});	

				request.fail(function(jqXHR, textStatus) {
					$.unblockUI();
					
					var opts = new Array();
					opts['heading'] = 'TIDAK BERJAYA';
					opts['content'] = 'Maklumat TIDAK BERJAYA dikemaskini. Sila cuba sekali lagi..';
					
					kv_alert(opts);
				});

			},1500);
		}
	});
	
});
</script>

<!-- Html Tag -->
<legend><h3>Maklumat Kolej Vokasional</h3></legend>
<?php
if(isset($kvinfo))
{
	$nama_kolej		= $kvinfo->col_name ;
	$id_kolej		= $kvinfo->col_id ;
	$no_tel_kolej	= isset($kvinfo->col_phone) ? $kvinfo->col_phone : "";
	$email_kolej	= isset($kvinfo->col_email) ? $kvinfo->col_email : "";
?>
	<table class="table table-bordered" width="100%">
		<tr>
			<td width="20%" style="text-align:right;"><strong>Nama Kolej : </strong></td>
			<td style="text-align:left;"><?= $nama_kolej; ?></td>
		</tr>
		<tr>
			<td width="20%" style="text-align:right;"><strong>Pengarah Kolej : </strong></td>
			<td style="text-align:left;"><?php
												if(isset($kvuser[0]->user_name))
												{
													echo ucwords( strtolower ( $kvuser[0]->user_name ));
												}
												else
												{
													?>
													<a class="btn btn-info" type="application/pdf" href="<?=site_url('management/user/user_register/5');?>"><span>Daftar Pengarah</span></a>
													<?php												
												}
										 ?>
			</td>
		</tr>
		<tr>
			<td width="20%" style="text-align:right;"><strong>Timbalan Pengarah Kolej : </strong></td>
			<td style="text-align:left;"><?php
												if(isset($kvuser[1]->user_name))
												{
													echo ucwords( strtolower ( $kvuser[1]->user_name ));
												}
												else
												{
													?>
													<a class="btn btn-info" type="application/pdf" href="<?=site_url('management/user/user_register/6');?>"><span>Daftar Timbalan Pengarah</span></a>
													<?php												
												}
										 ?>
			</td>
		</tr>
		<tr>
			<td width="20%" style="text-align:right;"><strong>No. Telefon Kolej : </strong></td>
			<td style="text-align:left;"><?=(isset($kvinfo->col_phone)) ? $kvinfo->col_phone : ""; ?></td>
		</tr>
		<tr>
			<td width="20%" style="text-align:right;"><strong>Emel Kolej : </strong></td>
			<td style="text-align:left;"><?=(isset($kvinfo->col_email)) ? $kvinfo->col_email : ""; ?></td>
		</tr>
	</table>
	<div style="margin-left:20%;"><button type="button" id="btn_change" class="btn btn-info">Kemaskini Kolej</button></div>



	<?php /* //modal updat info */ ?>
	<div class="modal hide fade" id="modalUpdate">
	    <div class="modal-header">
	        <h3><strong>Kemas Kini Maklumat Kolej</strong></h3>
	    </div>
		<div class="modal-body" style="margin-left: 129px;" >
		    <form action="<?=site_url('management/college/update_college_info')?>" id="form" name="form" style="position:relative;" method="post">
		     <?php
				if(isset($kvuser[0]->user_name))
				{
					$id_direktor = isset($kvuser[0]->user_id) ? $kvuser[0]->user_id : "";
				?>
					<div class="control-group">
						<label class="control-label" for="director">Pengarah Kolej</label>
						<div class="controls">
							<input type="text" name="director" id="director" class="input-xlarge validate[required]" value="<?= $kvuser[0]->user_name; ?>" />
							<input type="hidden" name="director_id" id="director_id" value="<?= $id_direktor; ?>" />
						</div>
					</div>
				<?php
				}
				else
				{
				?>
					<input type="hidden" name="director" id="director" value="" />
					<input type="hidden" name="director_id" id="director_id" value="" />
				<?php
				}
				if(isset($kvuser[1]->user_name))
				{
					$id_tim_direktor = isset($kvuser[1]->user_id) ? $kvuser[1]->user_id : "";
				?>
					<div class="control-group">
						<label class="control-label" for="director">Timbalan Pengarah Kolej</label>
						<div class="controls">
							<input type="text" name="tim_director" id="tim_director" class="input-xlarge validate[required]" value="<?= $kvuser[1]->user_name; ?>" />
							<input type="hidden" name="tim_director_id" id="tim_director_id" value="<?= $id_tim_direktor; ?>" />
						</div>
					</div>
				<?php
				}
				else
				{
				?>
					<input type="hidden" name="tim_director" id="tim_director" value="" />
					<input type="hidden" name="tim_director_id" id="tim_director_id" value="" />
				<?php
				}
				?>
					<div class="control-group">
						<label class="control-label" for="phone">No. Telefon Kolej</label>
						<div class="controls">
							<input type="text" name="phone" id="phone" class="input-xlarge validate[required]" value="<?=$no_tel_kolej;?>" />
						</div>
					</div>
					<div class="control-group">
						<label class="control-label" for="email">Email Kolej&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<div class="controls">
							<input type="text" name="email" id="email" class="input-xlarge validate[required]" value="<?=$email_kolej;?>" />
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<a href="" class="btn" data-dismiss="modal">TIDAK</a>
							<input type="hidden" name="kolej_id" id="kolej_id" value="<?= $id_kolej; ?>" />
							<button type="button" class="btn btn-info" id="btnUpdate">Kemaskini</button>							
						</div>	
					</div>
			</form>
    	</div>
	</div>
<?php
}
?>