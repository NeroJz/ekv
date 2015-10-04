/**************************************************************************************************
 * File Name        : process.js
 * Description      : This File contain all of javascript for Add Student marks
 * Author           : Ku Ahmad Mudrikah
 * Date             : 09 Julai 2013
 * Version          : -
 * Modification Log : -
 * Function List	   : - 
 **************************************************************************************************/
$(document).ready(function(){

	/**************************************************************************************************
	 * Description		: this function to populate course data in filter
	 * input			: val
	 * author			: Ku Ahmad Mudrikah
	 * Date				: 09 Julai 2013
	 * Modification Log	: -
	 **************************************************************************************************/
	if($("#kv").length>0){
		//trigger click and view course based on kv id
		$("#kv").bind("change",function(){
			var kodKV = $("#kv").val();
			$.blockUI({ 
				message: '<h5><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h5>', 
				css: { border: '3px solid #660a30' } 
        	});
			
			var request = $.ajax({
				url : site_url + "/student/student_management/choose_course_ajax",
				type : "POST",
				data: {kv : kodKV},
				dataType : "html"
			});

			request.done(function(data) {
				$.unblockUI();
				$("#course_display").html(data);
			});

			request.fail(function(jqXHR, textStatus) {
				$.unblockUI();
				alert("Request failed" + textStatus);
			});
		});
	}
});