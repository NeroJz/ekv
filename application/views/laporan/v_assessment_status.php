
<!--<link href="<?=base_url()?>assets/css/jquery-

ui.css" rel="stylesheet" />-->

<!--<script src="<?=base_url()?>assets/js/jquery.min.js"></script>-->
<!--<script src="<?=base_url()?>assets/js/jquery-

ui.min.js"></script>-->
<!--<script src="<?=base_url()?>assets/js/jquery.ui.timepicker.js"></script>-->
 



<style>
	
	.bblue, .dblue{font-weight:bold; color:blue;}
	.ddark{font-weight:bold; color:inherit;}
	.dgreen{font-weight:bold; color:green;}
	.dred{font-weight:bold; color:red;}
	
#lecturer_status_length {

text-align :left;

}

#lecturer_status_info{

text-align :left;

}

</style>
<script src="<?=base_url()?>assets/js/kv.msg.modal.js" 

type="text/javascript"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap-timepicker.js"></script>
<link href="<?=base_url()?>assets/css/bootstrap-timepicker.css" rel="stylesheet" />
<script>
 
var base_url = '<?=base_url();?>';
var site_url = '<?=site_url();?>/';
var course_id = "";
var semester = "";

</script>
<script language="javascript" type="text/javascript" >
$(document).ready(function()
{

	$('#lecturer_status').hide();
	
	$('#btnBack').click(function(){
		$('#myModal_lecturer').modal('hide');
	});
	
	$('#lecturer_status').on('click','.btn_papar',function(){
		//alert();
		var data = $(this).attr('id');
		
		var ids = data.split(':');
		
		/*$.blockUI({ 
		message: '<h5><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h5>', 
		css: { border: '3px solid #660a30' } 
		       	}); */

		$.blockUI({ 
			message: '<h5>Sedang diproses, Sila tunggu...</h5><div class="progress progress-striped active" style="width: 70%; margin-left: 15%;"><div class="bar" style="width: 100%;"></div></div>'
		});
		
		setTimeout(function()
		{
			//ajax submit to save
			var request = $.ajax({
				url: site_url+"laporan/assessment_status/get_lecturers_module",
				type: "POST",
				data: {	user_id : ids[0],
						cou_id : ids[1],
						sem : ids[2],
				},
				dataType: "json"
			});
			//alert(data);
			request.done(function(data) {
				$.unblockUI();
				//alert(data);
				
				//console.log(data);
				
				var add_row_modal;
				
				$('#tblmodul > tbody').html("");
									
				//remake_data(data);
				if(null != data.module)
				{
					//Loop module
					$(data.module).each(function(index){
						
						var data_conf_p = data.module[index].data_configuration_P;
						var data_conf_s = data.module[index].data_configuration_S;
						var mod_paper = data.module[index].mod_paper;
						var mod_name = data.module[index].mod_name;
						var course_name = data.module[index].cou_name;
						var semester = data.module[index].cm_semester;
						
						var status = "Lengkap";
						var color = "dgreen";
						
						if(null != data_conf_p && null != data_conf_s)
						{
							if(null != data.module[index].student)
							{
								//Loop Student
								$(data.module[index].student).each(function(index2){
									
									var student_mark_p = data.module[index].student[index2].markah_p;
									var student_mark_s = data.module[index].student[index2].markah_s;
									
									if(null != student_mark_p)
									{
										//Loop mark
										$(data.module[index].student[index2].markah_p).each(function(index3){
											
											var mark_p = data.module[index].student[index2].markah_p[index3];
											
											if(null == mark_p || "" == mark_p)
											{
												color = "dred";
												status = "Tidak Lengkap";
											}
											 	
										});
										
									}
									else
									{
										color = "dred";
										status = "Tidak Lengkap";
									}
									
									if(null != student_mark_s)
									{
										//Loop mark
										$(data.module[index].student[index2].markah_s).each(function(index4){
											
											var mark_s = data.module[index].student[index2].markah_s[index4];
											
											if(null == mark_s || "" == mark_s)
											{
												color = "dred";
												status = "Tidak Lengkap";
											}
											 	
										});
										
									}
									else
									{
										color = "dred";
										status = "Tidak Lengkap";
									}
									
								});
							}
							else
							{
								color = "dred";
								status = "Tidak Lengkap";
							}
						}
						else
						{
							color = "dred";
							status = "Tidak Lengkap";
						}
						
						if(null != mod_name)
						{
							toTitleCase(mod_name);
						}
						
						add_row_modal+=
						'<tr>'+
						'<td>'+mod_paper+'-'+mod_name+'</td>'+
						'<td>'+course_name+'</td>'+
						'<td><center>'+semester+'</center></td>'+
						'<td><center><strong class="tabblepadding '+color+'">'+status+'</strong></center></td>'+
						'</tr>';
						
					});
					
					$('#tblmodul > tbody').html(add_row_modal);
				}
				
				//alert(ids);
				$('#myModal_lecturer').modal({
				       	keyboard: false,
						backdrop: 'static'
				});
				
			});
		
			request.fail(function(jqXHR, textStatus) {
				$.unblockUI();
				//msg("Request failed", textStatus, "Ok");
				alert("Request failed"+ textStatus);
			});
		}, 1500);
		
		
		
	});
	

	$('#btnPapar').click(function(){
	
		course_id = $('#cou_id').val();
		semester = $('#semester').val();
		
		//alert(course_id);
		//alert(semester);
		
		/*$.blockUI({ 
		message: '<h5><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h5>', 
		css: { border: '3px solid #660a30' } 
		       	}); */

		$.blockUI({ 
			message: '<h5>Sedang diproses, Sila tunggu...</h5><div class="progress progress-striped active" style="width: 70%; margin-left: 15%;"><div class="bar" style="width: 100%;"></div></div>'
		});
		
		setTimeout(function()
		{
			//ajax submit to save
			var request = $.ajax({
				url: site_url+"laporan/assessment_status/get_lecturers",
				type: "POST",
				data: {cou_id : course_id,
						sem : semester,
				},
				dataType: "json"
			});
			//alert(data);
			request.done(function(data) {
				$.unblockUI();
				//alert(data);
				/*if(data == 0)
				{
					var opts = new Array();
					opts['heading'] = 'Berjaya';
					opts['content'] = 'Daftar Modul Kursus Berjaya disimpan';
					
					kv_alert(opts);	
					
				}
				else
				{
					var opts = new Array();
					opts['heading'] = 'Tidak Berjaya';
					opts['content'] = 'Modul Kursus tidak berjaya disimpan';
					kv_alert(opts);
				}*/
				
				//console.log(data);
									
				remake_data(data);
				
			});
		
			request.fail(function(jqXHR, textStatus) {
				$.unblockUI();
				//msg("Request failed", textStatus, "Ok");
				alert("Request failed"+ textStatus);
			});
		}, 1500);
		//};
		
		
	});
});


/***************************************************************************************************
* Description		: this function for checkbox attendance 
* input				: 
* author			: Freddy Ajang Tony
* Date				: 30 October 2013
* Modification Log	: -
***************************************************************************************************/
function remake_data(data)
{
	$('#lecturer_status > tbody').html("");
	
	//we need to 'clear' the datatable object coz we are going to re-create 
	var ex = document.getElementById('lecturer_status');
	if ( $.fn.DataTable.fnIsDataTable( ex ) ) {
		oTable.fnClearTable();
	}
					
	var add_row;
	
	if(null != data.lecturer)
	{
	
		$('#lecturer_status > tbody').html("");
		
		var count = 1;
	
		//Loop Lecturer
		$(data.lecturer).each(function(index){
			
			var user_id = data.lecturer[index].user_id;
			var lecturer_name = data.lecturer[index].user_name;
			
			var btn_type = "btn-info";
			var status = "Lengkap";
			
			/*if(count == 2 || count == 6)
			{
				btn_type = "btn-danger";
				status = "Tidak Lengkap";
				
			}*/
			
			if(null != data.lecturer[index].module)
			{
				//Loop module
				$(data.lecturer[index].module).each(function(index2){
					
					var data_conf_p = data.lecturer[index].module[index2].data_configuration_P;
					var data_conf_s = data.lecturer[index].module[index2].data_configuration_S;
					
					if(null != data_conf_p && null != data_conf_s)
					{
						if(null != data.lecturer[index].module[index2].student)
						{
							//Loop Student
							$(data.lecturer[index].module[index2].student).each(function(index3){
								
								var student_mark_p = data.lecturer[index].module[index2].student[index3].markah_p;
								var student_mark_s = data.lecturer[index].module[index2].student[index3].markah_s;
								
								if(null != student_mark_p)
								{
									//Loop mark
									$(data.lecturer[index].module[index2].student[index3].markah_p).each(function(index4){
										
										var mark_p = data.lecturer[index].module[index2].student[index3].markah_p[index4];
										
										if(null == mark_p || "" == mark_p)
										{
											btn_type = "btn-danger";
											status = "Tidak Lengkap";
										}
										 	
									});
									
								}
								else
								{
									btn_type = "btn-danger";
									status = "Tidak Lengkap";
								}
								
								if(null != student_mark_s)
								{
									//Loop mark
									$(data.lecturer[index].module[index2].student[index3].markah_s).each(function(index5){
										
										var mark_s = data.lecturer[index].module[index2].student[index3].markah_s[index5];
										
										if(null == mark_s || "" == mark_s)
										{
											btn_type = "btn-danger";
											status = "Tidak Lengkap";
										}
										 	
									});
									
								}
								else
								{
									btn_type = "btn-danger";
									status = "Tidak Lengkap";
								}
								
							});
						}
						else
						{
							btn_type = "btn-danger";
							status = "Tidak Lengkap";
						}
					}
					else
					{
						btn_type = "btn-danger";
						status = "Tidak Lengkap";
					}
					
				});
			}
			
			add_row +=
			'<tr>'+
			'<td><center></center></td>'+
			'<td>'+toTitleCase(lecturer_name)+'</td>'+
			'<td><center><input type="button" class="btn '+btn_type+' btn_papar"'+
			'id="'+user_id+':'+course_id+':'+semester+'" value="'+status+'"></center></td>'+
			'</tr>';
			
			count++;
		});
		
		$('#lecturer_status > tbody').html(add_row);
		
	}
	
	$('#lecturer_status').show();
	
	oTable = $('#lecturer_status').dataTable({
		"oLanguage": {  "sSearch": "Carian :",
				"sInfo": "Papar _START_-_END_ dari _TOTAL_ rekod",
			"sInfoEmpty": "Papar 0 - 0 dari 0 rekod",
			"sEmptyTable": "Tiada data",
			    "oPaginate": {
							      "sFirst": "Pertama",
							      "sLast": "Terakhir",
							      "sNext": "Seterus",
							      "sPrevious": "Sebelum"
			    			 }
		 },
		"aoColumnDefs": [	{ bSortable: false, aTargets: [0,2],}],
		"fnDrawCallback" : function(oSettings) {
			if (oSettings.bSorted || oSettings.bFiltered) {
				for (var i = 0, iLen = oSettings.aiDisplay.length; i < iLen; i++) {
					$("td:eq(0)", oSettings.aoData[oSettings.aiDisplay[i]].nTr).html(i + 1);
				}
			}
		},
		"iDisplayLength" : 20,
		"bJQueryUI": true,
		"bPaginate": true,
		"sPaginationType" : "full_numbers",
		"bAutoWidth": true,
		"bDestroy": true,
		"bScrollCollapse": true,
		"bFilter": true,		
		"bInfo": true,
		"aaSorting": [[ 1, 'asc' ]]
			
	});
	
	if($('#lecturer_status').length > 0){
		new FixedHeader( oTable, {
	        "offsetTop": 40
	    } );
	}
	
}


/**************************************************************************************************
* Description 		: this function will change string to title case
* input				: str 
* author			: Freddy Ajang Tony
* Date				: 18/10/2013
* Modification Log	:  -
**************************************************************************************************/
function toTitleCase(str)
{
    return str.replace(/\w\S*/g, function(txt){
    	return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    	});
}


</script>

<h3>Status Pentaksiran Pensyarah</h3><hr/>
<center>
    <div align="center" style="width:100%; margin:auto;">
   <form id="form1" name="form1" method="post" class="form-inline">
     <table id="group" class="breadcrumb border" width="100%" align="center">
       <tr>
       	
       	<td colspan="3" height="35">&nbsp;</td>
      	</tr>
      		<tr>
				<td width="57%" height="35" align="center">&nbsp;&nbsp;&nbsp;&nbsp;Kursus &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;
				<select name="cou_id" id="cou_id" class="validate[required]">
				<option value="">--Sila Pilih--</option>
				<?php
				foreach ( $courses as $course ) {
					echo "<option value='" . $course->cou_id . "'>".$course->cou_course_code." - ". ucwords( strtolower ( $course->cou_name )) . "</option>";
						}
					?>
                  </select>
                 </td>
			</tr>
        
        <tr>
			
            <td width="57%" height="35" align="center">&nbsp;&nbsp;&nbsp; Semester &nbsp; : &nbsp;
	        	<select class="validate[required]" name="semester" id="semester" >
	        		<option value="">-- Sila Pilih --</option>
	        		<option value="1">1</option>
	        		<option value="2">2</option>
	        		<option value="3">3</option>
	        		<option value="4">4</option>
	        		<option value="5">5</option>
	        		<option value="6">6</option>
	        		<option value="7">7</option>
	        		<option value="8">8</option>
	        	</select>
	        	</td>
    	</tr>           
        <tr>
        	<td align="center">
        	</br>
        		<input class="btn btn-info" type="button" name="btnPapar" id="btnPapar" value="Papar">
        	</td>
		</tr>
		 <tr>
        	<td>
        		&nbsp;
        	</td>
		</tr>
	</table>
</form>
</div>
<div id="showData">
	<form id="form1" name="form1" method="post" class="form-inline">
	<table id="lecturer_status" class="table table-bordered table-condensed display dataTable" style="margin-bottom: 0px;">
	    <thead>
	        
	            <th width="3%" align="tdright"><b>BIL</b></th>
	            <th width="67%" align="tdright"><b>NAMA PENSYARAH</b></th>
	            <th width="30%" align="center"><center><b>STATUS</b></center></th>
	     
	    </thead>
	    <tbody>
	    </tbody>
	</table>
	</form>
</div>
<div class="modal hide fade" id="myModal_lecturer"
	style="width: 90%; margin-left: -45%;">
	<div class="modal-header">
		<button id="btn_close" type="button" class="close"
			data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
		<h3 align="left">Status Pentaksiran</h3>
	</div>

	<div class="modal-body" id="span_result2">
		<form id="formEdit" name="formEdit" style="position: relative;"
			method="post">
			<center>
			<table id="tblmodul" style="margin-bottom: 5px;width: 100%"
				class="table table-striped table-bordered table-condensed">
				<thead>
					<tr>
						<td width="40%"
							style="vertical-align: middle; text-align: center;"><strong>MODUL</strong></td>
						<td width="35%" style="text-align: center;"><strong>KURSUS</strong></td>
						<td width="5%" style="text-align: center;"><strong>SEMESTER</strong></td>
						<td width="20%" style="text-align: center;"><strong>STATUS</strong></td>
					</tr>
				</thead>
				<tbody>
					
				</tbody>
				<tfoot>
				</tfoot>
			</table>
			</center>			
		</form>
	</div>

	<div class="modal-footer">
			<div class="pull-right">
				<button id="btnBack" type="button" name="btnBack" class="btn btn-primary">
					<span>Kembali</span>
				</button>
			</div>
	</div>

</div>
</center>