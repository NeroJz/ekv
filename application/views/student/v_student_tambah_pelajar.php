<style>

#tajuk {

color :red;

}

</style>

<script type="text/javascript" src="<?=base_url()?>assets/js/mykad.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/daftar.js"></script>
<script type="text/javascript">

$(document).ready(function() 
{
	$('#btnTest').click(function(){
		$("#blockMessageSendLocalData").html("hahahahahahaha");
		$("#blockProgressMessageSendLocalData").show();
	});

	$('#kelas').attr('disabled','disabled');
	
	$("#course_kv").on("change",function()
	{
		$('#kelas').removeAttr('disabled');
		var course_id = $("#course_kv").val();
		
		 $.ajax({
			   	url: '<?=site_url('student/student_management/get_kelas')?>',
			   	type: 'POST', 
			   	dataType: 'json',
			   	data: {course_kv : course_id},
				   			
				success: function(data) 
				{
					 document.addStudent.kelas.options.length=0;
			            $('#kelas').html("");
			            document.addStudent.kelas.options[0] = new Option('-- Sila Pilih --','',false,false);
			            if(data.kelas.length>0)
			            {
			                for(var i = 0; i < data.kelas.length; i++)
			                {
			                    document.addStudent.kelas.options[i+1] = new Option(data.kelas[i].class_name,data.kelas[i].class_id,false,false);
			                } // End of success function of ajax form
			            }
				}
	 	});
	});

	
	$("#addStudent").validationEngine('attach',{
		onValidationComplete: function(form,status){
			if(status){
				storeData();
			}
		}
	});
	//$("#begin").focus();
	
	function noimage(image) {
		image.onerror = "";
		 image.src = base_url+"assets/img/user.png";
		return true;
	} 
	
	navigator.sayswho= (function(){
		var N = navigator.appName, ua= navigator.userAgent, tem;
		var M = ua.match(/(opera|chrome|safari|firefox|msie)\/?\s*(\.?\d+(\.\d+)*)/i);
		if (M && (tem = ua.match(/version\/([\.\d]+)/i))!= null) M[2]= tem[1];
			M = M ? [M[1], M[2]]: [N, navigator.appVersion,'-?'];
		if (M[0] != 'MSIE') {
			//alert('Warning: This application does not work on browser other than Microsoft Internet Explorer');	
		}				
	})();

	$('#begin').keyup(function() {
		  this.value = this.value.toUpperCase();
		});
	
});

$(function() {
    var availableTagsBangsa = [
      "MELAYU",
      "CINA",
      "INDIA",
      "KADAZAN",
      "SIAM",
      "LAIN-LAIN"
    ];
    var availableTagsAgama = [
      "ISLAM",
      "BUDDHA",
      "HINDU",
      "KRISTIAN",
      "LAIN-LAIN"
    ];
    $( "#bangsa" ).autocomplete({
      source: availableTagsBangsa
    });
    $( "#agama" ).autocomplete({
      source: availableTagsAgama
    });
  });
</script>
<!-- Jz starts edit here -->
<script type="text/javascript">
	$(document).ready(function(){
		var checkLocalStorage = setInterval(sendLocalStorageData,3000);
		
	});

	function storeData(){

		/*$.blockUI({ 
		message: '<h5><img src="'+base_url+'assets/img/loading_ajax.gif"' +
		'alt="Sedang process"/>Sedang diproses, Sila tunggu...</h5>', 
		css: { border: '3px solid #660a30' } 
		});*/


		$.blockUI({ 
			message: '<h5>Sedang diproses, Sila tunggu...</h5><div class="progress progress-striped active" style="width: 70%; margin-left: 15%;"><div class="bar" style="width: 100%;"></div></div>'
		});


		var frm = $("#addStudent").serializeArray();

		var loginFormObject = {};
		$.each(frm,function(i,v){
			loginFormObject[v.name] = v.value;
		});
		
		//alert("masuk sini");

		if(!window.navigator.onLine){

			var ext_student = localStorage.getItem('student');
			if(ext_student == null){
				localStorage.setItem("student",JSON.stringify(loginFormObject));
			}else{
				localStorage.setItem("student",ext_student+','+JSON.stringify(loginFormObject));
			}
			var mssg = new Array();
			mssg['heading'] = 'Mesej';
			mssg['content'] = 'Pelajar berjaya didaftarkan';
			kv_alert(mssg);
			$('#addStudent')[0].reset();
			$.unblockUI();
			
		}else{
			sendData(loginFormObject);
		}
	}
	function sendData(obj){
		$.ajax({
			url: '<?=site_url('student/student_management/add_student')?>',
			type: 'POST',
			dataType: 'html',
			data: obj,
			success:function(data){
				//console.log(data);
				var mssg = new Array();
				if(data == "insert"){
				
					mssg['heading'] = 'Mesej';
					mssg['content'] = 'Pelajar berjaya didaftarkan';
				
				}else if(data == "error"){

					mssg['heading'] = '<font color="red">Mesej</color>';
					mssg['content'] = '<font color="red">Pelajar ini sudah didaftarkan didalam sistem</color>';
					
				}
				else if(data == "errormodule"){

					mssg['heading'] = '<font color="red">Mesej</color>';
					mssg['content'] = '<font color="red">Modul pelajar tidak didaftarkan lagi. Sila semak di bahagian pendaftaran modul</color>';
					
				}
				else{
					mssg['heading'] = 'Mesej';
					mssg['content'] = data;
				}
			
				kv_alert(mssg);
				$('#addStudent')[0].reset();
				$.unblockUI();
			}
		});
	}
	function sendLocalStorageData(){
		var online = window.navigator.onLine;
		
		if(online==true){
			var getLocalStorage = localStorage.getItem("student");
			if(getLocalStorage != null){
				var txt = '{"student":['+getLocalStorage+']}';
				var obj = JSON.parse(txt);

				if(obj.student.length > 0){
					var obj1 = JSON.stringify(obj.student.splice(0,1));
					var obj2 = JSON.stringify(obj.student);

					var student = obj1.substring(1,obj1.length-1);
					var restStudent = obj2.substring(1,obj2.length-1);
					
					$("#blockProgressMessageSendLocalData").show();
					sendLocalStorage(student,restStudent);
				}
			}
		}
	}

	function sendLocalStorage(obj,objs){

      $.ajax({
  		url: '<?=site_url('student/student_management/add_student_offline')?>',
		type: 'POST',
		dataType: 'html',
		data: JSON.parse(obj),
        success: function(data){
        	//alert(data);
			if(objs!=''){
				localStorage.setItem("student",objs);
				
			}else{
				localStorage.removeItem("student");
				$("#blockProgressMessageSendLocalData").hide();
			}
		}
      });
	}
</script>
<!-- Jz ends edit here -->
<?php /* ?><object id="MyKadAllActiveXControl" classid="CLSID:1F01E54C-AAD2-4A1E-990B-91D96927F189" codebase="MyKadAllActiveX.CAB#version=1,0,0,10" style="display: none;"></object><?php // */?>
	<!-- Jz starts edit here -->
	<div class="alert alert-block" id="blockProgressMessageSendLocalData" style="display:none;">
	  	<button type="button" class="close" data-dismiss="alert">&times;</button>
	  	<div class="progress progress-striped active">
		  <div class="bar" style="width: 100%;"></div>
		</div>
	  	<span id="blockMessageSendLocalData"></span>
	</div>
	<ul class="nav nav-tabs" id="myTab">
		<li class="active"><a href="#daftar-murid" data-toggle="tab">Tambah Murid Baru</a></li>
		<li><a href="#status-daftar" data-toggle="tab">Status Pendaftaran Offline</a></li>
	</ul>
	<div class="tab-content">
	<div class="tab-pane active" id="daftar-murid"	>
	<legend><h3>Tambah Murid Baru
		<div style="float:right; width:249px;">
			<a class="btn btn-warning" type="application/pdf" href="<?=base_url()?>assets/pdffile/ManualReaderInstallation.pdf" target="_blank"><span>Manual Installation Reader</span></a>
        </div></h3>
	</legend>
	<!--start panel info untuk how to use mykad-->
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
        		<?php /* ?><button class="btn btn-primary" onclick="CallMyKad(MyKadAllActiveXControl)" type="button">Baca MyKad</button> <?php // */?>
        		<applet name="mykad" code="MyKadForm.class" ARCHIVE="<?=base_url()?>MyKadDemo.jar" width=400 height=120>
				</applet>
        	</td>
        </tr>
      </tbody>
    </table>
    <!--end panel info untuk how to use mykad-->
	<div class="breadcrumb ">
	<div class="row" style="display: block; margin: auto; width: 500px;">
		
	<?=form_open(/*'student/student_management/add_student',*/'',array('class'=>'form-horizontal','id'=>'addStudent','name'=>'addStudent','style'=>'margin-top: 20px;'))

	?>
	<div id="out"></div>
	<div class="control-group">
		<label class="control-label" for="nama">Gambar :</label>
		<div class="controls">
			<input type="hidden" name="rawPhoto" id="rawPhoto">
			<img style="margin-left: 25px;" src="" id="photo" onError="javascript: noimage(this);" />
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="nama">Nama Murid :</label>
		<div class="controls">
			<?=form_input(array('name'=>'nama','placeholder'=>'Cth: Muhammad bin Abdullah','class'=>'validate[required] text-input','id'=>'begin','style'=>'width:380px'))
			?>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="no_kp">No MyKad :</label>
		<div class="controls">
			<?=form_input(array('name'=>'no_kp','placeholder'=>'Cth: 921221-11-5501','id'=>'ic','data-mask'=>'999999-99-9999','class'=>'validate[required] text-input'))
			?>
		</div>
	</div>
	<?//=form_input(array('name'=>'no_kp','placeholder'=>'Cth: 921221-11-5501','id'=>'ic','class'=>''))
			?>
	<div class="control-group">
		<label class="control-label"> Jantina : </label>
		<div class="controls">
			<label class="radio"> <?=form_radio(array("name" => 'jantina',"id" => 'jantina',"value"=>'Lelaki' ,'class'=>'validate[required] text-input'))?>
				Lelaki</label>
			<label class="radio"> <?=form_radio(array("name" => 'jantina',"id" => 'jantina',"value"=>'Perempuan'))?>
				Perempuan</label>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="bangsa">Bangsa :</label>
		<div class="controls">
			<?php /*?><select name="bangsa" required="true" required class="validate[required] text-input">
				<option value="Melayu">Melayu/Bumiputra</option>
				<option value="Melayu">Cina</option>
				<option value="Melayu">India</option>
				<option value="Lain-lain">Lain-lain</option>
			</select>
			 * <?php */?>
			<?=form_input(array('name'=>'bangsa','id'=>'bangsa','class'=>'validate[required] text-input'))?>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="agama">Agama :</label>
		<div class="controls">
			<?php /* ?><select name="agama" id="agama" required="true" required>
				<option value="Islam">Islam</option>
				<option value="Buddha">Buddha</option>
				<option value="Hindu">Hindu</option>
				<option value="Kristian">Kristian</option>
				<option value="Lain-lain">Lain-lain</option>
			</select>
			 * * <?php */?>
			 <?=form_input(array('name'=>'agama','id'=>'agama','class'=>'validate[required] text-input'))?>
		</div>
	</div>
	<!-- <div class="control-group">
	<label class="control-label" for="group">Group :</label>
	<div class="controls"> -->
	<? //=form_input(array('name'=>'group','placeholder'=>'Cth: 1','class'=>'validate[required] text-input')) ?>
	<?= form_hidden('group', '1'); ?>
	<!-- </div>
	</div> -->
	<input type="hidden" name="semester" value="1">
	<?php
	//Modification Log: 6 Sept 2013 by Mior - tambah paparan kv dan kursus ikut user login
	if($this->ion_auth->in_group("Admin LP"))
	{
		?>
		<div class="control-group">
			<label class="control-label" for="kv">Kolej Vokasional :</label>
			<div class="controls">
				<?php $options = array('' => '--Sila Pilih--');
			//	$options[''] = '--Sila Pilih--';
				foreach ($option as $row) {
					$options[$row -> col_id] = $row -> col_name." - ".$row->col_type.$row->col_code;
				}
				?>
				<?=form_dropdown('kv',$options,'','id="kv"')
				?>
				<br>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="course">Kursus :</label>
			<div class="controls">
				<select name="course" id="course_display" style="width:380px">
					<option></option>
				</select>
				<br>
			</div>
		</div>
	<?php
	}
	else
	{
		echo form_hidden('kv', $id_pusat);
		?>
		<div class="control-group">
			<label class="control-label" for="course">Kursus :</label>
			<div class="controls">
				<select name="course" id="course_kv"  class="validate[required]">
				<option value="">--Sila Pilih--</option>
					<?php
					foreach ($cou_list_for_kupp as $row) {
						echo "<option value=".$row -> cou_id.">".$row -> cou_name."</option>";
					}
					?>
				</select>
				<br>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label" for="course">Kelas :</label>
			<div class="controls">
				<select name="kelas" id="kelas">
				<option value="">--Sila Pilih--</option>
					
				</select>
				<br>
			</div>
		</div>
	<?php	
	}
	?>
	
	<?php
	echo form_hidden('status', '1');
	echo form_input(array('name'=>'date_of_birth','id'=>'date_of_birth','value'=>'','type'=>'hidden'));
	echo form_input(array('name'=>'address1','id'=>'address1','value'=>'','type'=>'hidden'));
	echo form_input(array('name'=>'address2','id'=>'address2','value'=>'','type'=>'hidden'));
	echo form_input(array('name'=>'address3','id'=>'address3','value'=>'','type'=>'hidden'));
	echo form_input(array('name'=>'postcode','id'=>'postcode','value'=>'','type'=>'hidden'));
	echo form_input(array('name'=>'city','id'=>'city','value'=>'','type'=>'hidden'));
	echo form_input(array('name'=>'state','id'=>'state','value'=>'','type'=>'hidden'));
	echo form_input(array('name'=>'nationality','id'=>'nationality','value'=>'','type'=>'hidden'));
	?>
<div class="" style="text-align: center;">
	<!-- Jz starts edit -->
	<input type="submit" value="Daftar" class="btn btn-info btn-block" style="width: 50%;" />
	<!-- Jz ends edit -->
	<!--button class="btn btn-primary" data-dismiss="modal" onclick="fnClickAddRow()">Tambah</button-->
</div>
<?=form_close() ?>
<?php $this->form_validation->set_rules('no_kp', 'No Kad Pengenalan', 'required');?>
</div>
</div>
<!-- Jz starts edit here -->
</div> <!-- Closing of tab daftar-murid tab -->
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
          		Senarai murid yang di bawah akan dimuat naik secara automatik. 
		 	</p>
	 	</td>
        </tr>
      </tbody>
    </table>
	<div class="row" style="display: block; margin: auto; width: 80%;">
		<table cellpadding="0" cellspacing="0" id="tblStudent" class="display" >
		</table>
	</div>
</div> <!-- Closing of tab status-daftar tab -->
</div> <!-- Closing of tab-content tag -->
<!-- Jz ends edit here -->
<script src="<?=base_url() ?>assets/js/student/process.js" type="text/javascript"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#myTab').click(function(e){
			e.preventDefault();
			$(this).tab('show');
		});
		
		
		//This function is to check the offline registration status
		function checkStatus(){

			if(localStorage.student){
				var student_lists = localStorage.getItem("student");
				var txt_student_list = '['+student_lists+']';
				
				var obj = JSON.parse(txt_student_list);
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
			$('#tblStudent').dataTable({
				"aaData": 
					data
				,
				"aoColumns": [
		            { "sTitle": "Nama Murid" },
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



