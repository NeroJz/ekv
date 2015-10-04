/**************************************************************************************************
* File Name        : kv.module_course_reg
* Description      : This File contain all of javascript for module course
* Author           : Freddy Ajang Tony
* Date             : 16 december 2013
* Version          : -
* Modification Log : -
* Function List	   : - 
**************************************************************************************************/


/**************************************************************************************************
* Description	 : document ready function
* input	 : -
* author	 : Freddy Ajang Tony
* Date	 : 16 december 2013
* Modification Log	: -
**************************************************************************************************/
var last_index = 1;
var mod_id_slct;

$(document).ready(function(){
	$("#frm_pusat").validationEngine(
			'attach', {scroll: false}
	
	);
	
	$("#formCourseModule").validationEngine(
			'attach', {scroll: false}
	
	);

	$("#loading_process").hide();
	$("#course_module").hide();
	$('#add_module').tooltip();
	
	$("#formCourseModule").on("click","#add_module",function(){
	
		var validate = $("#formCourseModule").validationEngine("validate");
		
		if(validate){
			var module = $("#searchModule").val();
			//alert(mod_id_slct);
			var add_row_vk =
				'<tr>'+
				'<td>'+module+
				'<input type="hidden" name="chk_module[]" value="'+mod_id_slct+'"/>'+
				'<span class="pull-right">'+
				'<a class="del_module" style="margin-left:10px;" href="javascript: void(0);" data-original-title="Padam">'+
				'<i class="icon-remove" ></i>'+
				'</a>'+
				'</span>'+
				'</td>';
					
			
			$('#tbl_vokasional > tbody').append(add_row_vk);
			
			$("#searchModule").val("");
			
			$('.del_module').tooltip();
			
			last_index++;
		}
		
	
	});

	$("#formCourseModule").on("click",".del_module",function(){
		//alert($(this).attr('class'));
		$(this).parent().parent().parent().remove();
		
		
	});

	$("#semester,#slct_kursus").on("change",function(){
		//get module course
		get_module();
	});


///////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// SAVE UPDATE MODULE /////////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////////
$('#btnSaveCourseModule').click(function(e){


	var opts = new Array();
	opts['heading'] = 'Pasti?';
	opts['question'] = 'Anda pasti untuk mendaftar modul kursus?';
	opts['hidecallback'] = true;
	opts['callback'] = function()
	{
	$.blockUI({ 
	message: '<h5><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h5>', 
	css: { border: '3px solid #660a30' } 
	       	}); 
	
		setTimeout(function()
		{
			//ajax submit to save
			var request = $.ajax({
				url: site_url+"/maintenance/module_course_reg/save_module_course",
				type: "POST",
				data: $('#formCourseModule').serialize(),
				dataType: "html"
			});
			//alert(data);
			request.done(function(data) {
				$.unblockUI();
				//console.log(data);
				//alert(data);
				if(data == 0)
				{
					var opts = new Array();
					opts['heading'] = 'Berjaya';
					opts['content'] = 'Daftar Modul Kursus Berjaya disimpan';
					
					kv_alert(opts);	
					
					$('#td_status').html('Telah Daftar');
					$('#td_status').attr('class','dgreen');
				}
				else if (data == 1)
				{
					var opts = new Array();
					opts['heading'] = 'Tiada Perubahan';
					opts['content'] = 'Modul sudah didaftarkan sebelum ini.';
					kv_alert(opts);
				}
				
				else
				{
					var opts = new Array();
					opts['heading'] = 'Berjaya';
					opts['content'] = 'Modul sudah dikemaskini.';
					kv_alert(opts);
				}
				
				//refresh the data.
				get_module();
			
			});
		
			request.fail(function(jqXHR, textStatus) {
				$.unblockUI();
				//msg("Request failed", textStatus, "Ok");
				//alert("Request failed"+ textStatus);
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


/**************************************************************************************************
* Description	 : this function to populate data
* input	 : data
* author	 : Freddy Ajang Tony
* Date	 : 16 December 2013
* Modification Log	: -
**************************************************************************************************/
function fnPopulate_data(data)
{
	//console.log(data);
	var module_list = new Array();
	
	if(data != null)
	{
		
		var row_body_ak = "";
		var row_body_vk = "";
		
		if(data.check_module != null)
		{
			var status = data.check_module;
			
			if(status == 1)
			{
				$('#td_status').html('Telah Daftar');
				$('#td_status').attr('class','dgreen');
			}
			else{
				$('#td_status').html('Belum Daftar');
				$('#td_status').attr('class','dred');
			}
				
			
		}
		
		if(data.module_ak != null)
		{
			$(data.module_ak).each(function(index)
			{
				var chk_box = 'checked="checked"';
				var mod_id = data.module_ak[index].mod_id;
				var mod_paper = data.module_ak[index].mod_paper;
				
				if(mod_paper == "A08401" || mod_paper == "A09401" || mod_paper == "A10401"
					|| mod_paper == "A11401")
					chk_box = "";
				
				var kod_paper = mod_paper.slice(-1);
				
				//alert(kod_paper);
				if(kod_paper <= 1 || kod_paper != 2)
				{
					row_body_ak +=
						'<tr>'+
						'<td>'+mod_paper+' - '+data.module_ak[index].mod_name+
						'<span class="pull-right">'+
						'<input type="checkbox" class="chk_module" name="chk_module[]" value="'+mod_id+'" '+chk_box+'>'+
						'</span>'+
						'</td>'+
						'</tr>';
				}
				
						
			});
		}
		
		last_index = 1;
		
		if(data.module_vk != null)
		{
			$(data.module_vk).each(function(index)
			{
				
				row_body_vk +=
				'<tr>'+
				'<td>'+data.module_vk[index].mod_paper+' - '+data.module_vk[index].mod_name+
				'<span class="pull-right">'+
				'<input type="checkbox" class="chk_module" name="chk_module[]" value="'+data.module_vk[index].mod_id+'" checked="checked">'+
				'</span>'+
				'</td>'+
				'</tr>';
				
				last_index++;
			
			});
		
		}
		
		//for add module
		/*row_body_vk +=
		'<tr>'+
		'<td width="3%">'+last_index+'</td>'+
		'<td><input type="text" name="searchModule" id="searchModule">'+
		'<span class="pull-right">'+
		'<button class="btn btn-small btn-primary" type="button" id="add_module"><i class="icon-plus icon-white"></i></button>'+
		'</span>'+
		'</td>'+
		'</tr>';*/
		
		$('#tbl_akademik > tbody').html(row_body_ak);
		$('#tbl_vokasional > tbody').html(row_body_vk);
		
		if(data.module_course_ak != null)
		{
			$('#tbl_akademik > tbody > tr').each(function(index){
				var mod_id = $(this).find('td').find('span').find('input').val();
				var mod_state = 0;
				
				$(data.module_course_ak).each(function(index)
				{
					//alert();
					var cm_mod_id = data.module_course_ak[index].mod_id;
					
					if(cm_mod_id == mod_id)
					{
						mod_state = 1;
					}
					
				});
				
				if(mod_state == 0)
				{
					$(this).find('td').find('span').find('input').removeAttr('checked');
				}
				
			});
		}
		
		if(data.module_course_vk != null)
		{
			var course_code = $('#td_kursus').html().substr(0,3);
			
			$(data.module_course_vk).each(function(index)
			{
				var cm_course_code = data.module_course_vk[index].mod_paper.substr(0,3);
				//alert(cm_course_code);
									
				if(cm_course_code != course_code)
				{
					var add_row_vk =
						'<tr>'+
						'<td>'+data.module_course_vk[index].mod_paper+' - '+data.module_course_vk[index].mod_name+
						'<span class="pull-right">'+
						'<input type="checkbox" class="chk_module" name="chk_module[]" value="'+data.module_course_vk[index].mod_id+'" checked="checked">'+
						'</span>'+
						'</td>'+
						'</tr>';
							
					
					$('#tbl_vokasional > tbody').append(add_row_vk);
					last_index++;
				}
				
				
				
			});
			
			//For check box. checked or unchecked.
			$('#tbl_vokasional > tbody > tr').each(function(index){
				var mod_id = $(this).find('td').find('span').find('input').val();
				var mod_state = 0;
				
				$(data.module_course_vk).each(function(index)
				{
					//alert();
					var cm_mod_id = data.module_course_vk[index].mod_id;
										
					if(cm_mod_id == mod_id)
					{
						mod_state = 1;
					}	
				});
				
				if(mod_state == 0)
				{
					$(this).find('td').find('span').find('input').removeAttr('checked');
				}
				
			});
		}
		
		if(data.module_list != null){
		 
		  $(data.module_list).each(function(index){
			  
			  var mod_id = data.module_list[index].mod_id;
			  var mod_name = data.module_list[index].mod_name;
			  var mod_paper = data.module_list[index].mod_paper;
			  var mod_paper_name = mod_paper+" - "+mod_name;
			  
			  var module = {"value" : mod_paper_name,"id" : mod_id };
			  
			  //push data to module_list, for autocomplete.
			  module_list.push(module);
			  
		  });
		  
		  //console.log(module_list);
	 	}

		
		$( "#searchModule" ).autocomplete({
		     
		  source: module_list,
		
		  select: function(event, ui) {
		   //$("#searchProd_hidden").val(ui.item.id);
			  	mod_id_slct = ui.item.id;
		     }
		  });
		
		
	}
	
	

}


/**************************************************************************************************
* Description	: this function to get module course data
* input	 		: data
* author	 	: Freddy Ajang Tony
* Date	 		: 13 March 2014
* Modification Log	: -
**************************************************************************************************/
function get_module()
{
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
					url: site_url+"/maintenance/module_course_reg/get_module",
					type: "POST",
					data: {	course_id : slct_val[0],
							course : slct_val[1],
							semester : slct_semester,},
					dataType: "json"
				});
			
				request.done(function(data){
					//alert("Berjaya");
					//console.log(data);
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
}



/**************************************************************************************************
* End of kv.module_course_reg.js
**************************************************************************************************/