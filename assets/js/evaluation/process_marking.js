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
	if($("#kodpusat").length > 0){
		//trigger click and view course based on kv id
		$("#kodpusat").bind("blur",function(){
			var kodPusatPenuh = $("#kodpusat").val();
			var aKodPusatPenuh = kodPusatPenuh.split(" - ");
			var kodPusat = aKodPusatPenuh[1];
			
			fLoadCourse(kodPusat);
		});
		// $(".kodpusat").bind("click",function(){
		// 	var kodPusatPenuh = $("#kodpusat").val();
		// 	var aKodPusatPenuh = kodPusatPenuh.split(" - ");
		// 	var kodPusat = aKodPusatPenuh[1];
			
		// 	fLoadCourse(kodPusat);
		// });
		
		
		var kodPusat = $("#kodpusat");
		if(kodPusat.val()!="")
		{
			var kodPusatPenuh = kodPusat.val();
			var aKodPusatPenuh = kodPusatPenuh.split(" - ");
			var kodPusat = aKodPusatPenuh[1];
			
			fLoadCourse(kodPusat);
		}
	}
	
	if($(".markah_akademik_sekolah").length > 0){
		$('.markah_akademik_sekolah').bind('change',function(event){
			var iMark =$(this).val();
			var iJumlah = 0;
			var curGred = 0;
			var curMark = 0;
			
			var totalMark = $(this).attr('data-total');
			var modType = $(this).attr('data-modtype');
			
			if(iMark <= 100 || $(this).val() == "T" || $(this).val() == "t")
			{			
				$('#'+$(this).attr('id')).validationEngine('hide');
				$('.btnSimpanGeneralMarking').removeAttr("disabled");			
			}
			else if(iMark > 101)
			{			
				$('#'+$(this).attr('id')).validationEngine('showPrompt', '*Sila Pastikan Jumlah Markah Tidak Melebihi 100%', 'err', 'topLeft', true);
				$('.btnSimpanGeneralMarking').attr("disabled", "disabled");
			}
			else if("T" != iMark && "t" != iMark)
			{
				$('#'+$(this).attr('id')).validationEngine('showPrompt', 'Anda Dibenarkan menggunakan Huruf T sahaja', 'err', 'topLeft', true);
				$('.btnSimpanGeneralMarking').attr("disabled", "disabled");
			}
			
				if(!isNaN($(this).val())){
					iJumlah = (iMark/100)*totalMark;
					iJumlah =  new Number(iJumlah).toFixed(1);
					
					curMark = iJumlah;
					curGred = iJumlah+'/'+totalMark;
				}
				else if($(this).val() == "T" || $(this).val() == "t"){
					curMark = "T";
					curGred = '0.0/'+totalMark;
				}else{
					curMark = 0;
					curGred = '0.0/'+totalMark;
				}
			
			$(this).next('#cur_gred').html(curGred);
			var pCurMark = $(this).next('#cur_gred').next('#cur_mark');
			pCurMark.val(curMark);
		});
	}
	
	$("#frmGeneralMarking").validationEngine('validate',{scroll: false});
	
	//Save Weightage
	$('#frmGeneralMarking').on("click","#btnSimpanGeneralMarking",function(){
		
		if($('#btnSimpanGeneralMarking').is(':disabled'))
		{
			return false;
		}
		
		//if($(this).validationEngine('validate')){
		
			var opts = new Array();
			opts['heading'] = 'Menyimpan Markah Murid';
			opts['hidecallback'] = true;
			opts['callback'] = function()
			{
			
				$("#myModal").scrollTop(0);
				$('#myModal').css('overflow','hidden');
				$('#myModal').block({ 
					message: '<h6><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h6>', 
					css: { border: '3px solid #660a30' } 
		    	}); 
				

			 	$.blockUI({ 
					message: '<h5><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h5>', 
					css: { border: '3px solid #660a30' } 
				});
				//ajax submit to delete
				var request = $.ajax({
					url: site_url+"/examination/general_marking/process_marking",
					type: "POST",
					data: $('#frmGeneralMarking').serialize(),
					dataType: "html"
				});
				//alert(data);
				request.done(function(data) {
					$.unblockUI();
					//alert(data);
					$('#myModal').unblock();
					$('#myModal').modal('hide');
					
					if(data.length>0 && data>0)
					{
						var opts = new Array();
						opts['heading'] = 'Berjaya';
						opts['content'] = 'Maklumat Markah Murid Berjaya disimpan';
						
						kv_alert(opts);		
					}
					else
					{
						var opts = new Array();
						opts['heading'] = 'Tidak Berjaya';
						opts['content'] = 'Data-data tidak sah! Maklumat Pemarkahan Murid tidak dapat disimpan';
						kv_alert(opts);
					}
				});
	
				request.fail(function(jqXHR, textStatus) {
					//$.unblockUI();
					$('#myModal').unblock();
					$('#myModal').modal('hide');
					//msg("Request failed", textStatus, "Ok");
					alert("Request failed"+ textStatus);
				});
			
			};
			
			
			opts['cancelCallback'] = function(){/*do nothing*/};
			kv_confirm(opts);	
		//}
	});
	

});

	function fLoadCourse(kodPusat){
		
		$.blockUI({ 
			message: '<h5><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h5>', 
			css: { border: '3px solid #660a30' } 
		});
		
		var request = $.ajax({
			url : site_url + "/examination/general_marking/view_kursus_by_kod",
			type : "POST",
			data: {colID : kodPusat, ccID : curCCID},
			dataType : "html"
		});
	
		request.done(function(data) {
			$.unblockUI();
			$("#slct_kursus").html(data);
		});
	
		request.fail(function(jqXHR, textStatus) {
			$.unblockUI();
			alert("Request failed" + textStatus);
		});
	}