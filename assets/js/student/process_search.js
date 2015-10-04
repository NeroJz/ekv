/**************************************************************************************************
 * File Name        : process_marking.js
 * Description      : This File contain all of javascript for Combine Pusat & KV marks
 * Author           : Fakhruz
 * Date             : 09 Julai 2013
 * Version          : -
 * Modification Log : -
 * Function List	   : - 
 **************************************************************************************************/
$(document).ready(function(){

	/**************************************************************************************************
	 * Description		: this function to populate course data in filter
	 * input			: val
	 * author			: Fakhruz
	 * Date				: 09 Julai 2013
	 * Modification Log	: -
	 **************************************************************************************************/
	if($("form.pindah").length > 0){
		//trigger click and view course based on kv id
		$("form.pindah").bind("submit",function(){
			var nama = $("#nama").val();
			var angka_giliran = $("#angka_giliran").val();
			var mykad = $("#mykad").val();
			var kursus = $("#kursus").val();
			$.blockUI({ 
				message: '<h5><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h5>', 
				css: { border: '3px solid #660a30' } 
        	});
			
			var request = $.ajax({
				url : site_url + "/student/student_management/search_student1/",
				type : "GET",
				data: {name : nama, angka_giliran : angka_giliran, mykad : mykad, kursus : kursus},
				dataType : "html"
			});

			request.done(function(data) {
				$.unblockUI();
				$("#student_search_ajax").html(data);
			});

			request.fail(function(jqXHR, textStatus) {
				$.unblockUI();
				alert("Request failed" + textStatus);
			});
			return false;
		});
	}
});