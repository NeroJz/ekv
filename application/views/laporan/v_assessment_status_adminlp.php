
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
var kodkv = [
	 			<?php echo $centrecode; ?>
	 		];

</script>
<script language="javascript" type="text/javascript" >
$(document).ready(function()
{
	$( "#kodpusat" ).autocomplete({
		source: kodkv,
		close: function( event, ui ) {}
	});
	 
	$('#lecturer_status').hide();
	
	$('#btnBack').click(function(){
		$('#myModal_lecturer').modal('hide');
	});
	
	$('#lecturer_status').on('click','.btn_papar',function(){
		//alert();
		var data = $(this).attr('id');
		
		var ids = data.split(':');
		
		$.blockUI({ 
		message: '<h5><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h5>', 
		css: { border: '3px solid #660a30' } 
		       	}); 
		
		setTimeout(function()
		{
			//ajax submit to save
			var request = $.ajax({
				url: site_url+"laporan/assessment_status/get_kv_courses",
				type: "POST",
				data: {	col_id : ids[0],
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
				
				if(null != data.course)
				{
					//loop course
					$(data.course).each(function(index){
						
						var course_name = data.course[index].cou_name;
						
						var status = "Lengkap";
						var color = "dgreen";
						
						if(null != data.course[index].lecturer)
						{
							//loop lecturer
							$(data.course[index].lecturer).each(function(index2){
								
								if(null != data.course[index].lecturer[index2].module)
								{
									//loop module
									$(data.course[index].lecturer[index2].module).each(function(index3){
										
										var data_conf_p = data.course[index].lecturer[index2].module[index3].data_configuration_P;
										var data_conf_s = data.course[index].lecturer[index2].module[index3].data_configuration_S;
										
										if(null != data_conf_p && null != data_conf_s)
										{
											if(null != data.course[index].lecturer[index2].module[index3].student)
											{
												//loop student
												$(data.course[index].lecturer[index2].module[index3].student).each(function(index4){
												
													var student_mark_p = data.course[index].lecturer[index2].module[index3].student[index4].markah_p;
													var student_mark_s = data.course[index].lecturer[index2].module[index3].student[index4].markah_s;
													
													if(null != student_mark_p)
													{
														//loop mark
														$(data.course[index].lecturer[index2].module[index3].student[index4].markah_p).each(function(index5){
															
															var mark_p = data.course[index].lecturer[index2].module[index3].student[index4].markah_p[index5];
												
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
														//loop mark
														$(data.course[index].lecturer[index2].module[index3].student[index4].markah_s).each(function(index6){
															
															var mark_s = data.course[index].lecturer[index2].module[index3].student[index4].markah_s[index6];
												
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
									
									});
								}
								
							});
						}
						
						if(null != course_name)
						{
							toTitleCase(course_name);
						}
						
						add_row_modal+=
						'<tr>'+
						'<td>'+course_name+'</td>'+
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
	
		course_id = $('#slct_kursus').val();
		semester = $('#semester').val();
		var college = $('#kodpusat').val();
		
		//alert(col_code);
		//alert(semester);
		
		$.blockUI({ 
		message: '<h5><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h5>', 
		css: { border: '3px solid #660a30' } 
		       	}); 
		
		setTimeout(function()
		{
			//ajax submit to save
			var request = $.ajax({
				url: site_url+"laporan/assessment_status/get_kvs",
				type: "POST",
				data: {cou_id : course_id,
						sem : semester,
						college : college,
				},
				dataType: "json"
			});
			//alert(data);
			request.done(function(data) {
				$.unblockUI();
				//alert(data);
				
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
	
	
	$( "#kodpusat" ).on( "autocompleteclose", function( event, ui ) {
			
		var inputVal = $(this).val();
		
		var data = inputVal.split('-');
		
		//alert(data[1].substr(2));
		
		$('#divKursus').html('<img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/> Sila tunggu...');
		
		setTimeout(function()
		{
			var request = $.ajax({
				url: site_url+"laporan/assessment_status/get_course_by_kv",
				type: "POST",
				data: {kodpusat : data[1]},
				dataType: "html"
				});
			
			request.done(function(msg) {
				//alert("Berjaya");
				//alert(msg);
				//console.log(msg);
				$('#divKursus').html(msg);
			});
			
			request.fail(function(jqXHR, textStatus) {
				//alert("Gagal");
				//Do nothing
			});
		}, 1500);
	
	
	} );
});
//End Of Document Ready


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
	
	if(null != data.kvs)
	{
	
		$('#lecturer_status > tbody').html("");
		
		var count = 1;
	
		//Loop Kv
		$(data.kvs).each(function(index){
			
			var col_id = data.kvs[index].col_id;
			var col_name = data.kvs[index].col_name;
			
			var btn_type = "btn-info";
			var status = "Lengkap";
			
			if(null != data.kvs[index].course)
			{
				//Loop Course
				$(data.kvs[index].course).each(function(index2){
					
					var cou_name = data.kvs[index].course[index2].cou_name;
					
					if(null != data.kvs[index].course[index2].lecturer)
					{
						//Loop Lecturer
						$(data.kvs[index].course[index2].lecturer).each(function(index3){
							
							var user_id = data.kvs[index].course[index2].lecturer[index3].user_id;
							var lecturer_name = data.kvs[index].course[index2].lecturer[index3].user_name;
														
							if(null != data.kvs[index].course[index2].lecturer[index3].module)
							{
								//Loop Module
								$(data.kvs[index].course[index2].lecturer[index3].module).each(function(index4){
									
									var data_conf_p = data.kvs[index].course[index2].lecturer[index3].module[index4].data_configuration_P;
									var data_conf_s = data.kvs[index].course[index2].lecturer[index3].module[index4].data_configuration_S;
									
									if(null != data_conf_p && null != data_conf_s)
									{
										if(null != data.kvs[index].course[index2].lecturer[index3].module[index4].student)
										{
											//Loop Student
											$(data.kvs[index].course[index2].lecturer[index3].module[index4].student).each(function(index5){
												
												var student_mark_p = data.kvs[index].course[index2].lecturer[index3].module[index4].student[index5].markah_p;
												var student_mark_s = data.kvs[index].course[index2].lecturer[index3].module[index4].student[index5].markah_s;
												
												if(null != student_mark_p)
												{
													//Loop mark
													$(data.kvs[index].course[index2].lecturer[index3].module[index4].student[index5].markah_p).each(function(index6){
														
														var mark_p = data.kvs[index].course[index2].lecturer[index3].module[index4].student[index5].markah_p[index6];
														
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
													$(data.kvs[index].course[index2].lecturer[index3].module[index4].student[index5].markah_s).each(function(index7){
														
														var mark_s = data.kvs[index].course[index2].lecturer[index3].module[index4].student[index5].markah_s[index7];
														
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
										else //else student
										{
											btn_type = "btn-danger";
											status = "Tidak Lengkap";
										}
										
									}
									else //else data_conf
									{
										btn_type = "btn-danger";
										status = "Tidak Lengkap";
									}
									
								});
							}
							else //else Module
							{
								btn_type = "btn-danger";
								status = "Tidak Lengkap";
							}
					
							
							
						});
					}
					
					
				});
				
				
			}
			
			add_row +=
			'<tr>'+
			'<td><center></center></td>'+
			'<td>'+toTitleCase(col_name)+'</td>'+
			'<td><center><input type="button" class="btn '+btn_type+' btn_papar"'+
			'id="'+col_id+':'+course_id+':'+semester+'" value="'+status+'"></center></td>'+
			'</tr>';
			
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

<h3>Status Pentaksiran</h3><hr/>
<center>
    <div align="center" style="width:100%; margin:auto;">
   <form id="form1" name="form1" method="post" class="form-inline">
     <table id="group" class="breadcrumb border" width="100%" align="center">
       <tr>
    	<td colspan="3">&nbsp;</td>
	   </tr>
	    <tr>
	    	<td width="45%" height="35"><div align="right">Kod Pusat</div></td>
	        <td width="3%" height="35"><div align="center">:</div></td>
	        <td width="52%" height="35"><div align="left">
	    	<input type="text" name="kodpusat" id="kodpusat" class="span3" style="margin-left:0px; width:270px;"/>
	        </div>
	        </td>
	    </tr>
	       <tr>
	    	<td height="35"><div align="right">Kursus</div></td>
	        <td height="35"><div align="center">:</div></td>
	        <td width="52%" height="35">
	        <div align="left" id="divKursus">
	            <select id="slct_kursus" name="slct_kursus" style="width:270px;" class="validate[required]" disabled="true">
	            <option value="">-- Sila Pilih --</option>
	 
	            </select>
	        </div>
	        </td>
	    </tr>
	    <tr>
	    	<td width="45%" height="35"><div align="right">Semester</div></td>
	        <td width="3%" height="35"><div align="center">:</div></td>
	        <td width="52%" height="35"><div align="left"><select width="50%" name="semester" id="semester" style="width:270px;" class="validate[required]">
	        	<option value="">-- Sila Pilih --</option>
	        	<option value="1">1</option>
	        	<option value="2">2</option>
	        	<option value="3">3</option>
	        	<option value="4">4</option>
	        	<option value="5">5</option>
	        	<option value="6">6</option>
	        	<option value="7">7</option>
	        	<option value="8">8</option>
	        	</select></td>
	          
	        </div>
	        </td>
	    </tr>               
        <tr>
        	<td align="center" colspan="3">
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
	        
	            <th width="3%" align="tdright"><b>Bil.</b></th>
	            <th width="67%" align="tdright"><b>Nama Institusi</b></th>
	            <th width="30%" align="center"><center><b>Status</b></center></th>
	     
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
						<td width="80%" style="text-align: left;"><strong>Kursus</strong></td>
						<td width="20%" style="text-align: center;"><strong>Status</strong></td>
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