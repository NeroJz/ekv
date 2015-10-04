/**************************************************************************************************
* File Name        : kv.attendance.js
* Description      : This File contain all of javascript for attendance
* Author           : Freddy Ajang Tony
* Date             : 30 October 2013
* Version          : -
* Modification Log : -
* Function List	   : - 
**************************************************************************************************/


/**************************************************************************************************
* Description		: document ready function
* input				: -
* author			: Freddy Ajang Tony
* Date				: 30 October 2013
* Modification Log	: -
**************************************************************************************************/
var oTable = null;

$(document).ready(function(){
	$("#frm_pusat").validationEngine(
			'attach', {scroll: false}
			
		);
	
		$( "#kodpusat" ).autocomplete({
			source: kodkv,
			close: function( event, ui ) {}
		});	
		
		//alert($('#kodpusat').attr('type'));
		if("hidden" == $('#kodpusat').attr('type'))
		{
			var inputVal = $('#kodpusat').val();
			//alert(inputVal);
			var data = inputVal.split('-');
			
			var request = $.ajax({
					url: site_url+"/report/attendance/get_course_by_kv",
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
		}
		
		
		
		
		/*var btnMuatTurunDua = '<div id="idMuatTurun" style="float:right; width:140px;">' +
		'<button id="btnDownloadMarkahMurid" onclick="javascript: getMarkahMurid();" type="button" style="margin-bottom:10px;"' +
		'class="btn btn-primary"><span>Muat Turun Excel</span></button> &nbsp;&nbsp;' +
		'</div>';


		$('#tblStudent_wrapper').append(btnMuatTurunDua);*/

		
		$( "#kodpusat" ).on( "autocompleteclose", function( event, ui ) {
			
			var inputVal = $(this).val();
			
			var data = inputVal.split('-');
			
			//alert(data[1].substr(2));
			
			$('#divKursus').html('<img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/> Sila tunggu...');
			
			setTimeout(function()
			{
				var request = $.ajax({
					url: site_url+"/report/attendance/get_course_by_kv",
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
		
		
		
		$('#frm_pusat').on("change",'#slct_kursus',function(){
			var courseID = $(this).val();
			//modType = $('input[name="rdType"]:checked').val()
			//$('#subkredit').val("");
			//$('#subsem').val("");
			//$('#btn_config_weightage').attr("disabled", "true");
			//alert(courseID);
			//$('#divModul').html('<img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/> Sila tunggu...');

				$.blockUI({ 
			message: '<h5>Sedang diproses, Sila tunggu...</h5><div class="progress progress-striped active" style="width: 70%; margin-left: 15%;"><div class="bar" style="width: 100%;"></div></div>'
		});	
			
			setTimeout(function()
			{

			

				var request = $.ajax({
					url: site_url+"/report/attendance/get_module_by_course",
					type: "POST",
					data: {slct_kursus : courseID},
					dataType: "html"
					});
				
				request.done(function(msg) {
					//alert("Berjaya");
					//alert(msg);
					//console.log(msg);
					$('#divModul').html(msg);
				});
				
				request.fail(function(jqXHR, textStatus) {
					//alert("Gagal");
					//Do nothing
				});

				$.unblockUI();
			}, 1500);
		
		});
		
		$('#frm_pusat').on('click','#btnPapar',function(){
			
			var validate = $('#frm_pusat').validationEngine('validate');
			 if(validate)
			 {
				 $('#tblAttendance > thead').html("");
				 $('#tblAttendance > tbody').html("");
				 $('#form_attendance').hide();
				 //$('#loading_process').html('<center><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/> Sila tunggu...<center>');
				 $.blockUI({ 
				 message: '<h5>Sedang diproses, Sila tunggu...</h5><div class="progress progress-striped active" style="width: 70%; margin-left: 15%;"><div class="bar" style="width: 100%;"></div></div>'
				 });


				 var sKodPusat = $('#kodpusat').val();
				 var sKursus = $('#slct_kursus').val();
				 var sModul = $('#modul').val();
				 var iSemester = $('#semester').val();
				 var iTahun = $('#slct_tahun').val();
				 var sStatus = $('#statusID').val();
				 
						 
				 /*console.log(sKodPusat);
				 console.log(sKursus);
				 console.log(sModul);
				 console.log(iSemester);
				 console.log(iTahun);
				 console.log(sStatus);*/
				 
				 setTimeout(function()
				 {
					 var request = $.ajax({
							url: site_url+"/report/attendance/attendance_system_view",
							type: "POST",
							data: {	kodpusat : sKodPusat,
									slct_kursus : sKursus,
									modul : sModul,
									semester : iSemester,
									mt_year : iTahun,
									statusID : sStatus,},
							dataType: "json"
							});
						
						request.done(function(data){
							//alert("Berjaya");
							//alert(msg);
							$('#loading_process').html("");
							$('#tblAttendance > thead').html("");
							$('#tblAttendance > tbody').html("");
							$('#form_attendance').show();
							fnPopulate_data(data);
							//console.log(data);
						});
						
						request.fail(function(jqXHR, textStatus) {
							//alert("Gagal");
							//Do nothing
						});

						$.unblockUI();

				 },1500);

				  
			 }
		});

});
/**************************************************************************************************
* End of $(document).ready
**************************************************************************************************/

/**************************************************************************************************
 * Description		: this function is to download excel open esimen
 * input			:
 * author			:
 * Date				:
 * Modification Log	: umairah - add class
 **************************************************************************************************/
function get_jadual() {
	
	var kursus = $('#slct_kursus').val();
	var modul = $('#modul').val();
	var semester = $('#semester').val();
	var tahun = $('#slct_tahun').val();
	var status = $('#statusID').val();
	var cc = $('#kodpusat').val().split("-");
	var ccCode = cc[0];
	
	/*alert(kursus);
	alert(modul);
	alert(semester);
	alert(tahun);
	alert(status);
	alert(cc);*/
	
	window.location.href = 'export_xls_jadual_kedatangan' + '?slct_kursus=' + kursus + '&modul=' + modul + 
	'&semester=' + semester + '&slct_tahun=' + tahun + '&statusID=' + status + '&kodpusat=' + ccCode;
}




/**************************************************************************************************
* Description : this function will change string to title case
* input	 : str 
* author	 : Freddy Ajang Tony
* Date	 : 18/10/2013
* Modification Log	:  -
**************************************************************************************************/
function toTitleCase(str)
{
   return str.replace(/\w\S*/g, function(txt){
   	return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
   	});
}

/**************************************************************************************************
* Description		: this function to populate data
* input				: data
* author			: Freddy Ajang Tony
* Date				: 31 October 2013
* Modification Log	: -
**************************************************************************************************/
function fnPopulate_data(data)
{
	//console.log(data);
	
	//we need to 'clear' the datatable object coz we are going to re-create 
	var ex = document.getElementById('tblAttendance');
	if ( $.fn.DataTable.fnIsDataTable( ex ) ) {
		oTable.fnClearTable();
	}

	var row_head = 
		'<tr>'+
	    '<th width="5%">BIL</th>'+
	    '<th width="50%">NAMA MURID</th>'+
	    '<th width="35%">ANGKA GILIRAN</th>'+
	    '<th width="10%">TINDAKAN'+
		'</th>'+           
		'</tr>';
	
	$('#tblAttendance > thead').html(row_head);
	
	if(data != null && data.student.length>0)
	{

		var row_body = "";
		
		$(data.student).each(function(index)
		{
			
			
			if(data.student[index].notattd == 0)
			{
				row_body +=
					'<tr><td></td>'+
					'<td>'+toTitleCase(data.student[index].stu_name)+'</td>'+
					'<td>'+data.student[index].stu_matric_no+'</td>'+
					'<td class="chkKehadiran" align="center">'+
					'<label class="radio inline">'+
					'<input type="checkbox" class="chk_attendance" data-original-title="Hadir" id="'+data.student[index].md_id+'" checked="checked">'+
					'</label>'+
					'<span class="chkKehadiran_th"></span>'+
					' </td></tr>';
			}
			else if(data.student[index].notattd == 1)
			{
				row_body +=
					'<tr><td></td>'+
					'<td>'+toTitleCase(data.student[index].stu_name)+'</td>'+
					'<td>'+data.student[index].stu_matric_no+'</td>'+
					'<td class="chkKehadiran" align="center">'+
					'<label class="radio inline">'+
					'<input type="checkbox" class="chk_attendance" data-original-title="Hadir" id="'+data.student[index].md_id+'">'+
					'</label>'+
					'<span class="chkKehadiran_th">'+
					'&nbsp;'+
					'&nbsp;'+
					'<label class="radio inline">'+
					'<input type="radio" id="inlineRadio1" class="radio_btn" data-original-title="Tidak Hadir" name="optAttendance_'+data.student[index].md_id+'" value="1" checked="checked">T'+
					'</label>'+
					'<label class="radio inline">'+
					'<input type="radio" id="inlineRadio2" class="radio_btn" data-original-title="Hospital" name="optAttendance_'+data.student[index].md_id+'" value="2"> H'+
					'</label>'+
					'</span>'+
					' </td></tr>';
			}
			else
			{
				row_body +=
					'<tr><td></td>'+
					'<td>'+toTitleCase(data.student[index].stu_name)+'</td>'+
					'<td>'+data.student[index].stu_matric_no+'</td>'+
					'<td class="chkKehadiran" align="center">'+
					'<label class="radio inline">'+
					'<input type="checkbox" class="chk_attendance" data-original-title="Hadir" id="'+data.student[index].md_id+'">'+
					'</label>'+
					'<span class="chkKehadiran_th">'+
					'&nbsp;'+
					'&nbsp;'+
					'<label class="radio inline">'+
					'<input type="radio" id="inlineRadio1" class="radio_btn" data-original-title="Tidak Hadir" name="optAttendance_'+data.student[index].md_id+'" value="1">T'+
					'</label>'+
					'<label class="radio inline">'+
					'<input type="radio" id="inlineRadio2" class="radio_btn" data-original-title="Hospital" name="optAttendance_'+data.student[index].md_id+'" value="2" checked="checked"> H'+
					'</label>'+
					'</span>'+
					' </td></tr>';
			}
			
		});
		
		$('#tblAttendance > tbody').html(row_body);
	}

	
	oTable = $('#tblAttendance').dataTable({
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
		"aoColumnDefs": [	{ bSortable: false, aTargets: [0] },
		                 	{ bSortable: false, aTargets: [3] } ],
		"iDisplayLength" : 20,
		"bJQueryUI": true,
		"bPaginate": false,
		"bAutoWidth": true,
		"bDestroy": true,
		"bScrollCollapse": true,
		"bFilter": true,		
		"bInfo": true,
		"aaSorting": [[ 1, 'asc' ]],		
		
		 "fnDrawCallback": function ( oSettings ) 
		 {
				if ( oSettings.bSorted || oSettings.bFiltered )
				{
					for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
					{
						$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
					}
				}
		 }
			
	});
	
	if($('#tblAttendance').length > 0){
		new FixedHeader( oTable, {
	        "offsetTop": 40
	    } );
	}
	
	//$("div.toolbar").html('Custom tool bar! Text/images etc.');
	var btnSubmits = '<button id="btnSaveAttendance" class="btn btn-primary '+
    ' pull-right" style="margin-left: 10px;"><span>Simpan</span></button>';

	var btnExport = '<button id="btnDownloadMarkahMurid" onclick="javascript: get_jadual();" type="button" style="margin-left: 10px;"' +
	'class="btn btn-primary pull-right"><span>Muat Turun</span></button>';
	
	$("#tblAttendance_wrapper > .fg-toolbar").append(btnExport);
	
	$("#tblAttendance_wrapper > .fg-toolbar").append(btnSubmits);
	//$("#tblAttendance_wrapper > .fg-toolbar").append(btnExport);
	
	fnChkAttendance();
	
	$('.chk_attendance').tooltip();
	$('.radio_btn').tooltip();
	
}


/***************************************************************************************************
* Description		: this function for checkbox attendance 
* input				: 
* author			: Freddy Ajang Tony
* Date				: 30 October 2013
* Modification Log	: -
***************************************************************************************************/
function fnChkAttendance()
{
	$('.chk_attendance').click(function(){
		 var iMd_id = $(this).attr('id');
		//alert();
		if ($(this).is(':checked')) {
		   //alert("Checked");
			$(this).attr("name","optAttendance_"+iMd_id+"");
			$(this).attr("value","0");
			$(this).parent().parent().find('.chkKehadiran_th').html("");
		   
		} else {
		   //alert("Not CHecked");
		   
		  
		   
			var td_row =
				'&nbsp;'+
				'&nbsp;'+
				'<label class="radio inline">'+
				'<input type="radio" id="inlineRadio1" class="radio_btn" data-original-title="Tidak Hadir" name="optAttendance_'+iMd_id+'" value="1" checked="checked"> T'+
				'</label>'+
				'<label class="radio inline">'+
				'<input type="radio" id="inlineRadio2" class="radio_btn" data-original-title="Hospital" name="optAttendance_'+iMd_id+'" value="2"> H'+
				'</label>';

	    	$(this).parent().parent().find('.chkKehadiran_th').append(td_row);
	    	$('.radio_btn').tooltip();
		} 
			    				
	});
	
	$('#formAttendance').on('click','#btnSaveAttendance',function(e) {
		var sData = $('input', oTable.fnGetNodes()).serialize();
		//alert( "The following data would have been submitted to the server: \n\n"+sData );
		//console.log(sData);
		if(sData != "")
		{
			var opts = new Array();
			opts['heading'] = 'Anda Pasti?';
			opts['question'] = 'Anda Pasti Untuk Simpan Jadual Kedatangan?';
			opts['hidecallback'] = true;
			opts['callback'] = function()
			{
				
					 /*$.blockUI({ 
						message: '<h5><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h5>', 
						css: { border: '3px solid #660a30' } 
		        	}); */
					
					//ajax submit to delete
					var request = $.ajax({
						url: site_url+"/report/attendance/attendance_save",
						type: "POST",
						data: {data : sData},
						dataType: "html"
					});

					request.done(function(data) {
						//$.unblockUI();
						//console.log(data);
						if(data == 1)
						{
							var opts = new Array();
							opts['heading'] = 'Berjaya';
							opts['content'] = 'Kedatangan berjaya disimpan';
													
							kv_alert(opts);
						}
						else
						{
							var opts = new Array();
							opts['heading'] = 'Tidak Berjaya';
							opts['content'] = 'Kedatangan tidak berjaya disimpan';
							
							kv_alert(opts);
						}
					});

					request.fail(function(jqXHR, textStatus) {
						$.unblockUI();
						//msg("Request failed", textStatus, "Ok");
						alert("Request failed"+ textStatus);
					});
				
			};
			
			e.stopImmediatePropagation();
			opts['cancelCallback'] = function(){/*do nothing*/};
			kv_confirm(opts);

		}
				
		return false;
	} );
}

/**************************************************************************************************
* End of kv.attendance.js
**************************************************************************************************/