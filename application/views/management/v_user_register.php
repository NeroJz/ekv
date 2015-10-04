
<script type="text/javascript" src="<?=base_url()?>assets/js/mykad.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("#addUser").validationEngine('attach',{
			onValidationComplete:function(form,status){
				if(status){
					storeData();
				}
			}	
		});
		
		var request = $.ajax({
			url: site_url + "/main/check_online",
			type: "POST",
			dataType: "html"
		});
		
		request.done(function(data){
			setInterval(syncData,3000);
		});
		
		
		$("#begin").keyup(function(){
			this.value = this.value.toUpperCase();
		});
		
	});
	function noimage(image){
			image.onerror = "";
			image.src = base_url+"assets/img/user.png";
			return true;
	}
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
	//function store data to local storage
	function storeData(){
		var frm = $("#addUser").serializeArray();
		
		var frmObject = {};
		$.each(frm,function(i,v){
			frmObject[v.name] = v.value;
		});
		
		var user_level = [];
		$("input[name='user_level[]']:checked").each(function(){
			user_level.push(this.value);
		});
		
		frmObject['user_level[]'] = user_level;
		var request = $.ajax({
			url: site_url + "/main/check_online",
			type: "POST",
			dataType: "html"
		});
		
		request.fail(function(jqXHR, textStatus){
			if(jqXHR.status == "0"){
				var ext_user = localStorage.getItem('user');
				if(ext_user == null){
					localStorage.setItem("user" , JSON.stringify(frmObject));
				}else{
					localStorage.setItem("user",ext_user+','+JSON.stringify(frmObject));
				}
				var mssg = new Array();
				mssg['heading'] = 'Mesej';
				mssg['content'] = 'Pengguna berjaya didaftarkan';
				kv_alert(mssg);
				$('#addUser')[0].reset();
			}
		});
		
		request.done(function(data){
			sendData(frmObject);
		});
		
	}
	function sendData(obj){
		$.ajax({
			url: '<?=site_url('management/user/add_user')?>',
			type: 'POST',
			dataType: 'html',
			data: obj,
			success:function(data){
				var mssg = new Array();
				if(data == "insert"){
				
					mssg['heading'] = 'Mesej';
					mssg['content'] = 'Pengguna berjaya didaftarkan';
				
				}else if(data == "error"){

					mssg['heading'] = '<font color="red">Mesej</color>';
					mssg['content'] = '<font color="red">Pengguna ini sudah didaftarkan didalam sistem</color>';
					
				}
				kv_alert(mssg);
				$('#addUser')[0].reset();
			}
		});
	}
	function syncData(){
		var getLocalStorage = localStorage.getItem("user");
		if(getLocalStorage != null){
			var txt = '{"user":['+getLocalStorage+']}';
			var obj = JSON.parse(txt);
			if(obj.user.length > 0){
				var obj1 = JSON.stringify(obj.user.splice(0,1));
				var obj2 = JSON.stringify(obj.user);

				var user = obj1.substring(1,obj1.length-1);
				var restuser = obj2.substring(1,obj2.length-1);
					
				$("#blockProgressMessageSendLocalData").show();
				sendLocalStorage(user,restuser);
			}
		}
	}
	function sendLocalStorage(obj,objs){

      $.ajax({
  		url: '<?=site_url('management/user/add_user')?>',
		type: 'POST',
		dataType: 'html',
		data: JSON.parse(obj),
        success: function(data){
        	//alert(data);
			if(objs!=''){
				localStorage.setItem("user",objs);
				
			}else{
				localStorage.removeItem("user");
				$("#blockProgressMessageSendLocalData").hide();
			}
		}
      });
	}
	
	/***********************************************************************
	 * Description: this function use to disable/enable checkbox
	 ***********************************************************************/
	function disableCheckbox(evt){
		var ele = $(evt);
		if(ele.attr('checked') == 'checked'){
			if(ele.attr('id') == 'chck_pengarah'){
				$('#chck_tmb_pengarah').attr('disabled','true');
			}else if(ele.attr('id') == 'chck_tmb_pengarah'){
				$('#chck_pengarah').attr('disabled','true');
			}
		}else if(ele.attr('checked') == undefined){
			if(ele.attr('id') == 'chck_pengarah'){
				$('#chck_tmb_pengarah').removeAttr('disabled');
			}else if(ele.attr('id') == 'chck_tmb_pengarah'){
				$('#chck_pengarah').removeAttr('disabled');
			}
		}
	}
	
</script>
<div class="alert alert-block" id="blockProgressMessageSendLocalData" style="display:none;">
	  	<button type="button" class="close" data-dismiss="alert">&times;</button>
	  	<div class="progress progress-striped active">
		  <div class="bar" style="width: 100%;"></div>
		</div>
	  	<span id="blockMessageSendLocalData"></span>
	</div>
<ul class="nav nav-tabs" id="myTab">
	<li class="active"><a href="#daftar-pengguna" data-toggle="tab">Tambah Pengguna Baru</a></li>
	<li><a href="#status-daftar" data-toggle="tab">Status Pendaftaran Offline</a></li>
</ul>
<div class="tab-content">
	<div class="tab-pane active" id="daftar-pengguna"	>
	<legend>
		<h3>Tambah Pengguna Baru
			<div style="float: right; width: 249px;">
				<a class="btn btn-warning" type="application/pdf" href="<?=base_url()?>assets/pdffile/ManualReaderInstllation.pdf" 
					target="_blank">
					<span>Manual Installation Reader</span>
				</a>
			</div>	
		</h3>
	</legend>
	<!-- start panel info untuk how to use mykad -->
	<table class="table table-bordered">
		<thead>
			<tr>
				<th id="tajuk">PERHATIAN!</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<p>
						<?php
							$baseurl = base_url()."caroot.crt";
							$servicesUrl = base_url()."setup.msi";
						?>
						Aplikasi Web ini membolehkan anda untuk mengakses dan membaca data yang disimpan di dalam chip MyKad (dan MyKid) anda. Ia menggunakan teknologi
					 	yang membolehkan anda untuk berinteraksi dengan peranti seperti Pembaca Kad Pintar, Pengimbas dan lain-lain. 
					 	<a href="<?php echo $baseurl?>">Certification</a> | <a href="<?php echo $servicesUrl?>">Setup Reader</a>
					</p>
				</td>
			</tr>
			<tr>
				<td>
					<applet name="mykad" code="MyKadForm.class" ARCHIVE="<?=base_url()?>MyKadDemo.jar" width="400" height="120"></applet>
				</td>
			</tr>
		</tbody>
	</table>
	<!--end panel info untuk how to use mykad-->
	<div class="breadcrumb">
		<div class="row" style="display: block; margin: auto; width: 500px;">
			<form method="post" class="form-horizontal" id="addUser" name="addUser" style="margin-top: 20px;">
				<div id="out"></div>
				<div class="control-group">
					<label class="control-label" for="nama">Gambar :</label>
					<div class="controls">
						<img style="margin-left: 25px;" src="" id="photo" onError="javascript: noimage(this);" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="nama">Nama Pengguna :</label>
					<div class="controls">
						<input type="text" name="nama" placeholder="Muhammad bin Abdullah" class="validate[required] text-input" id="begin" style="width: 380px;" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="no_kp">No MyKad :</label>
					<div class="controls">
						<input type="text" name="no_kp" placeholder="Cth: 921221-11-5501" id="ic" data-mask='999999-99-9999' class="validate[required] text-input" />
					</div>
				</div>
					
				<div class="control-group">
					<label class="control-label" for="nationality">Warganegara :</label>
					<div class="controls">
						<select name="nationality" id="nationality">
							<option value="malaysia" selected="selected">Warganegara</option>
							<option value="non-malaysia">Bukan Warganegara</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="username">Username<font color="red">*</font> :</label>
					<div class="controls">
						<input type="text" name="username" id="username" class="validate[required] text-input" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label" for="email">Email :</label>
					<div class="controls">
						<input type="text" name="email" id="email" class="input-xlarge validate[custom[email]]" />
					</div>
				</div>
				
				<div class="control-group">
					<label class="control-label">Telefon :</label>
					<div class="controls">
						<input type="text" name="telephone" id="telephone" class="input-xlarge" onkeypress="validate(event)" />
					</div>
				</div>
				<?php
					if(!empty($kolej)){
				?>
					<div class="control-group">
						<label class="control-label" for="college">Kolej :</label>
						<div class="controls">
							<select name="col_id" id="col_id">
							<?php
								foreach($kolej as $row){
									echo "<option value='$row->col_id'>".$row->col_name."</option>";
								}
							?>
							</select>
						</div>
					</div>
				<?php	
					}else{
						echo "<input type='hidden' name='col_id' id='col_id' value='$col_id' />";
					}
				?>	
				<div class="control-group">
					<label class="control-label" for="user_level">Jawatan :</label>
					<div class="controls">
						<?=$checkbox;?>
					</div>
				</div>
				<div class="" style="text-align: center">
					<input type="submit" value="Daftar" class="btn btn-info btn-block" style="width: 50%;" />
				</div>
				<input type="hidden" name="date_of_birth" id="date_of_birth" />
				<input type="hidden" name="address1" id="address1" style="width: 380px;" />
				<input type="hidden" name="address2" id="address2" style="width: 380px;" />
				<input type="hidden" name="address3" id="address3" style="width: 380px;" />
				<input type="hidden" name="postcode" id="postcode" style="width: 80px;" />
				<input type="hidden" name="status" id="status" value="1" />
				<input type="hidden" name="state" id="state" />
				<input type="hidden" name="user_password" id="user_password" value="@user" />
			</form>
		</div>
	</div>
</div>
<div class="tab-pane" id="status-daftar">
<legend><h3>Status Pendaftaran Offline</h3></legend>
	<table class="table table-bordered">
      <thead>
        <tr>
          <th>Penerangan</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
          	<p>	
          		Senarai pengguna yang di bawah akan dimuat naik secara automatik. 
		 	</p>
	 	</td>
        </tr>
      </tbody>
    </table>
	<div class="row" style="display: block; margin: auto; width: 80%;">
		<table cellpadding="0" cellspacing="0" id="tblUser" class="display" >
		</table>
	</div>
</div> <!-- Closing of tab status-daftar tab -->
</div> <!-- Closing of tab-content tag -->
<script src="<?=base_url() ?>assets/js/student/process.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#myTab').click(function(e){
			e.preventDefault();
			$(this).tab('show');
		});
		
		
		//This function is to check the offline registration status
		function checkStatus(){
			if(localStorage.user){
				var user_lists = localStorage.getItem("user");
				var txt_user_list = '['+user_lists+']';
				
				var obj = JSON.parse(txt_user_list);
				var array_1=[];
				var array_2=[];
				for(var key in obj){
					var tmp = [];
					tmp.push(obj[key].nama);
					tmp.push(obj[key].no_kp);
					array_1.push(tmp);
				}
				renderTable(array_1);
			}
			
		}
		
		//This function call to render the datatable after checking the status
		function renderTable(data){
			//data = [["hello","1"],["hello","2"]];
			$('#tblUser').dataTable({
				"aaData": 
					data
				,
				"aoColumns": [
		            { "sTitle": "Nama Pengguna" },
		            { "sTitle": "No Kad Pengenalan" }
		        ],
				"bPaginate" : true,
				"sPaginationType" : "full_numbers",
				"bFilter" : true,
				"bInfo" : true,
				"bJQueryUI" : true,
				"bPaginate": true,
				"oLanguage": {  "sSearch": "Carian :",
							"sLengthMenu": "Paparan _MENU_ senarai",
	 						"sInfo": "Papar _START_-_END_ dari _TOTAL_ rekod",
							"sInfoEmpty": "Showing 0 to 0 of 0 records",
						    "oPaginate": {
						      "sFirst": "Pertama",
						      "sLast": "Akhir",
						      "sNext": "Seterus",
						      "sPrevious": "Sebelum"
						     }
						 }
			});
		}
		checkStatus();
	});
</script>

















