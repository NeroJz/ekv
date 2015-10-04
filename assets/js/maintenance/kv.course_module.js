/**************************************************************************************************
* File Name        : kv.course_module.js
* Description      : This File contain all of javascript for course_module
* Author           : Freddy Ajang Tony
* Date             : 10 december 2013
* Version          : -
* Modification Log : -
* Function List	   : - 
**************************************************************************************************/


/**************************************************************************************************
* Description		: document ready function
* input				: -
* author			: Freddy Ajang Tony
* Date				: 10 december 2013
* Modification Log	: -
**************************************************************************************************/
$(document).ready(function(){
	$("#frm_pusat").validationEngine(
			'attach', {promptPosition : "bottomRight",scroll: false}	
		);
	
	oTable = $("#tbl_kursus").dataTable({
		"aoColumnDefs" : [{bSortable : false, aTargets : [0,3]}],
		"bPaginate" : true,
		"sPaginationType" : "full_numbers",
		"bFilter" : true,
		"bInfo" : true,
		"bJQueryUI" : true,
		"bPaginate": true,
		"aaSorting" : [[1, "asc"]],
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
					  },
		"fnDrawCallback" : function(oSettings) {
			if (oSettings.bSorted || oSettings.bFiltered) {
				for (var i = 0, iLen = oSettings.aiDisplay.length; i < iLen; i++) {
					$("td:eq(0)", oSettings.aoData[oSettings.aiDisplay[i]].nTr).html(i + 1);
				}
			}
		}
	});

	/*if($("#collapseOne").length > 0){ 
		new FixedHeader( oTable, 
		{
		       "offsetTop": 40
		});
	}*/
	
	$( window ).scroll(function() {
		//alert("Scroll");
		new FixedHeader( oTable, 
				{
				       "offsetTop": 40
				});
		});
	
	//bila accordion report buka balik selepas ditutup dia akan panggil balik function fixedheader
	$('#collapseOne').on('shown', function () {	
		$("body").children(".fixedHeader").each(function (index) {
            $(this).remove();
        });
	});

	//bagi mengelakkan fixedheader tu tergantung walaupun accordion dah ditutup, remove dia (tapi ni remove semua ye),
	//kalau ada lebih dari satu, kena pakai index
	$('#collapseOne').on('hide', function () {
		$("body").children(".fixedHeader").each(function (index) {
            $(this).remove();
        });
   	});
	
	$("#formCourseModule").on("click","#add_module",function(){
		
		//alert();
		
	});
	
	
	/*$("#semester,#slct_kursus").on("change",function(){
		var slct_semester = $("#semester").val();
		var slct_course = $("#slct_kursus").val();
		var slct_val = slct_course.split(':');
		
		if(slct_course != "")
		{
			$("#semester").removeAttr( "disabled" );
		}
		else
		{
			$("#semester").attr( "disabled",true);
		}
		
		$('#course_module').hide();
		
		if(slct_semester != "" && slct_course != "")
		{
			$("#loading_process").show();
			
			setTimeout(function()
			{
				var request = $.ajax({
					url: site_url+"/maintenance/course_module/get_module",
					type: "POST",
					data: {	course : slct_val[1],
							semester : slct_semester,},
					dataType: "json"
					});
				
				request.done(function(data){
					//alert("Berjaya");
					//alert(msg);
					console.log(data);
					$("#loading_process").hide();
					$("#td_kursus").html(slct_val[1]+" - "+slct_val[2]);
					$("#kod_kursus").val(slct_val[0]);
					$("#td_semester").html(slct_semester);
					$("#hide_semester").val(slct_semester);
					$("#td_kluster").html(slct_val[3]);
					//$('#tblAttendance > thead').html("");
					//$('#tblCourseModule > tbody').html("");
					
					fnPopulate_data(data);
					$('#course_module').show();
					
					
				});
				
				request.fail(function(jqXHR, textStatus) {
					//alert("Gagal");
					//Do nothing
				});
				
			 },1500);
		}
		
		
	});*/
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////// SAVE UPDATE  ////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////
	$('#btn_reg_course').click(function(e){
		
		var kursus = $('#slct_kursus').val();
		
		var validate = $('#frm_pusat').validationEngine('validate');
		
		if(validate)
		{
			var opts = new Array();
			opts['heading'] = 'Pasti?';
			opts['question'] = 'Anda pasti untuk mendaftar kursus?';
			opts['hidecallback'] = true;
			opts['callback'] = function()
			{
				/* $.blockUI({ 
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
							url: site_url+"/maintenance/course_module/save_course",
							type: "POST",
							data: {
								course_id : kursus
							},
							dataType: "html"
						});
						//alert(data);
						request.done(function(data) {
							$.unblockUI();
							//alert(data);
							if(data>0)
							{
								var opts = new Array();
								opts['heading'] = 'Berjaya';
								opts['content'] = 'Daftar Kursus Berjaya disimpan';
								
								kv_alert(opts);		
							}
							else
							{
								var opts = new Array();
								opts['heading'] = 'Tidak Berjaya';
								opts['content'] = 'Kursus telah berada dalam pangkalan data';
								kv_alert(opts);
							}
							
							refresh_table();
							
						});
			
						request.fail(function(jqXHR, textStatus) {
							$.unblockUI();
							//msg("Request failed", textStatus, "Ok");
							alert("Request failed"+ textStatus);
						});
				}, 1500);
			};
			
			
			opts['cancelCallback'] = function(){/*do nothing*/};
			kv_confirm(opts); 
		 
		}
	});
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////// DELETE COURSE ///////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////
	$('#frm_table_kursus').on('click','.btn_padam',function(){
		
		var cc_id = $(this).attr('value');
		
		var opts = new Array();
		opts['heading'] = 'Pasti?';
		opts['question'] = 'Anda pasti untuk memadam kursus?';
		opts['hidecallback'] = true;
		opts['callback'] = function()
		{
			/* $.blockUI({ 
					message: '<center><h5><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h5></center>', 
					css: { border: '3px solid #660a30' } 
	        	});*/ 

			 $.blockUI({ 
			message: '<h5>Sedang diproses, Sila tunggu...</h5><div class="progress progress-striped active" style="width: 70%; margin-left: 15%;"><div class="bar" style="width: 100%;"></div></div>'
			});
			 
			 setTimeout(function()
			 {
					//ajax submit to save
					var request = $.ajax({
						url: site_url+"/maintenance/course_module/delete_course",
						type: "POST",
						data: {
							cc_id : cc_id
						},
						dataType: "html"
					});
					//alert(data);
					request.done(function(data) {
						$.unblockUI();
						//alert(data);
						if(data>0)
						{
							var opts = new Array();
							opts['heading'] = 'Berjaya';
							opts['content'] = 'Kursus berjaya dipadam.';
							
							kv_alert(opts);		
						}
						else
						{
							var opts = new Array();
							opts['heading'] = 'Tidak Berjaya';
							opts['content'] = 'Kursus mempunyai pelajar.';
							kv_alert(opts);
						}
						
						refresh_table();
						
					});
		
					request.fail(function(jqXHR, textStatus) {
						$.unblockUI();
						//msg("Request failed", textStatus, "Ok");
						alert("Request failed"+ textStatus);
					});
			}, 1500);
		};
		
		
		opts['cancelCallback'] = function(){/*do nothing*/};
		kv_confirm(opts);
	});

});
/**************************************************************************************************
* End of $(document).ready
**************************************************************************************************/


/**********************************************************************************************
* Description		: this function to refresh table data
* input				: 
* author			: Freddy Ajang Tony
* Date				: 16 december 2013
* Modification Log	: -
**********************************************************************************************/
function refresh_table()
{		

		$('#tbl_kursus > tbody').html('<tr><td colspan = "3"> <center><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sila tunggu...</center></td></tr>');
	
		setTimeout(function()
		{
			var request = $.ajax({
				url: site_url+"/maintenance/course_module/get_course_ajax",
				type: "POST",
				dataType: "json"
				});
			
			request.done(function(data){
				//alert("Berjaya");
				//alert(msg);
				//console.log(data);
				
				var row_data = "";

				$(data.list_course_kv).each(function(index)
				{

					var cc_id = data.list_course_kv[index].cc_id;
					var cou_code = data.list_course_kv[index].cou_course_code;
					var cou_name = data.list_course_kv[index].cou_name;
					var cou_cluster = data.list_course_kv[index].cou_cluster;
					
					row_data +=
						'<tr><td width="30" align="center">'+(index+1)+'</td>'+
						'<td width="400" align="left">'+cou_code+'-'+cou_name+'</td>'+
						'<td width="400" align="left">'+cou_cluster+'</td>'+
						'<td width="100" align="left">'+
						'<center>'+
						'<a class="btn btn_padam" name="btn_padam" id="btn_padam" type="button" value="'+cc_id+'"><i class="icon-trash"></i>&nbsp;Padam</a>'+
						'</center>'+
						'</td></tr>';
					
				});
				
				//we need to 'clear' the datatable object coz we are going to re-create 
				var ex = document.getElementById('tbl_kursus');
				if ( $.fn.DataTable.fnIsDataTable( ex ) ) {
				oTable.fnClearTable();
				}
					$('#tbl_kursus > tbody').html("");
					$('#tbl_kursus > tbody').html(row_data);

					oTable = $("#tbl_kursus").dataTable({
						"aoColumnDefs" : [{bSortable : false,aTargets : [0,3]}],
						"bPaginate" : true,
						"sPaginationType" : "full_numbers",
						"bFilter" : true,
						"bInfo" : true,
						"bJQueryUI" : true,
						"bDestroy" : true,
						"bPaginate": true,
						"aaSorting" : [[1, "asc"]],
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
									  },
						"fnDrawCallback" : function(oSettings) {
							if (oSettings.bSorted || oSettings.bFiltered) {
								for (var i = 0, iLen = oSettings.aiDisplay.length; i < iLen; i++) {
									$("td:eq(0)", oSettings.aoData[oSettings.aiDisplay[i]].nTr).html(i + 1);
								}
							}
						}
					});

					if($("#tbl_kursus").length > 0){ 
						new FixedHeader( oTable, 
						{
						       "offsetTop": 40
						});
					}
				
			});
			
			request.fail(function(jqXHR, textStatus) {
				//alert("Gagal");
				//Do nothing
			});
			
		 },1500);
}


/**************************************************************************************************
* End of kv.course_module.js
**************************************************************************************************/