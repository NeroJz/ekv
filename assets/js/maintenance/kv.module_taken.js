/**************************************************************************************************
* File Name        : kv.course_module.js
* Description      : This File contain all of javascript for course_module
* Author           : Nabihah
* Date             : 24 March 2014
* Version          : -
* Modification Log : -
* Function List	   : - 
**************************************************************************************************/


/**************************************************************************************************
* Description		: document ready function
* input				: -
* author			:Nabihah
* Date				: 24 March 2014
* Modification Log	: -
**************************************************************************************************/
$(document).ready(function(){
	
	$("#form_module").validationEngine(
			'attach', {scroll: false}
	
	);
//////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////////// SAVE UPDATE  ////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////
	$('#btn_reg_module').click(function(e){

		var validate = $("#form_module").validationEngine("validate");
		//alert(validate);
		if(validate){
			var opts = new Array();
			opts['heading'] = 'Pasti?';
			opts['question'] = 'Anda pasti untuk mendaftar modul?';
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
							url: site_url+"/maintenance/module_taken_reg/save_module",
							type: "POST",
							data: $("#form_module").serialize(),
							dataType: ""
						});
						//alert(data);
						request.done(function(data) {
							$.unblockUI();
							console.log(data);
							if(data>0)
							{
								var opts = new Array();
								opts['heading'] = 'Berjaya';
								opts['content'] = 'Daftar Modul disimpan';
								
								kv_alert(opts);		
							}
							else
							{
								var opts = new Array();
								opts['heading'] = 'Tidak Berjaya';
								opts['content'] = 'Modul telah berada dalam pangkalan data';
								kv_alert(opts);
							}
							 window.location.reload();
							
							
						});
			
						request.fail(function(jqXHR, textStatus) {
							$.unblockUI();
							
							alert("Request failed"+ textStatus);
						});
				}, 1500);
			};
			
			
			opts['cancelCallback'] = function(){/*do nothing*/};
			kv_confirm(opts); 
		 
		}	
	});
	
		
	
});