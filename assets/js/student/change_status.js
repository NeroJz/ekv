/**************************************************************************************************
 * File Name        : change_status.js
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
	if($(".new_kv").length>0){
		//trigger click and view course based on kv id
		$("#ya").bind("click",function(){
			var kodKV = $(".new_kv").val();
			var stu_id = $("#stu_id").val();
			var cou_id = $("#cou_id").val();


			/*$.blockUI({ 
				message: '<h5><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h5>', 
				css: { border: '3px solid #660a30' } 
        	});*/
			
			$.blockUI({ 
			message: '<h5>Sedang diproses, Sila tunggu...</h5><div class="progress progress-striped active" style="width: 70%; margin-left: 15%;"><div class="bar" style="width: 100%;"></div></div>'
			});



			var request = $.ajax({
				url : site_url + "/student/student_management/change_status",
				type : "POST",
				data: {
					stu_id  : stu_id, 
					temp_kv : kodKV, 
					cou_id  : cou_id
					},
				dataType : "html"
			});

			request.done(function(data) {
				$.unblockUI();
				$(".modal-header").html("<h3 id='myModalLabel'>Berjaya</h3>");
				$(".modal-body").html(data);
				$(".modal-footer").html("<a href='"+site_url+"/student/student_management/pindah' class='btn btn-info'>Kembali</a>");
			});

			request.fail(function(jqXHR, textStatus) {
				$.unblockUI();
				alert("Request failed" + textStatus);
			});
			return false;
		});
	}
});