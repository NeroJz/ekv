/**************************************************************************************************
 * File Name        : wform.js
 * Description      : This File contain all of javascript for written form K15
 * Author           : Norafiq Bin Mohd Azman Chew
 * Date             : 25 July 2013
 * Version          : -
 * Modification Log : -
 * Function List	: - 
 *************************************************************************************************/
/**************************************************************************************************
 * Description		: document ready function
 * input			: -
 * author			: Norafiq 
 * Date				: 25 July 2013
 * Modification Log	: umairah 7/4/2014
 *************************************************************************************************/
$(document).ready(function()
{
	$("#btn_cetak").hide();
	
	$("#frm_written").validationEngine();
	
	$('#slct_semester').change(function()
	{
		$("#slct_kursus").val(-1);
		$("#slct_jubject").val("");
		$('#slct_jubject').attr("disabled", "disabled");
		$('#slct_kelas').attr("disabled", "disabled");
		$('#slct_pengisian').attr("disabled", "disabled");		
	});
	
	$('#slct_jubject').change(function()
	{
		var moduleid = $('#slct_jubject').val();
		
		if("" != moduleid)
		{
			$('#btn_print_form').removeAttr("disabled");

		}
		else
		{
			$('#btn_print_form').attr("disabled", "disabled");
		}
	});
	
	$('#slct_kursus').change(function()
	{
		$("#frm_written").validationEngine('validate');
		
		var semester = $('#slct_semester').val();
		var courseid = $('#slct_kursus').val();

		if(-1 != courseid)
		{

			$.blockUI({ 
			message: '<h5>Sedang diproses, Sila tunggu...</h5><div class="progress progress-striped active" style="width: 70%; margin-left: 15%;"><div class="bar" style="width: 100%;"></div></div>'
		});

			var request = $.ajax({
				url: site_url+"/examination/writtenform/spsubject",
				type: "POST",
				data: {course_id : courseid, semes_ter : semester},
				dataType: "json"
			});

			request.done(function(data)
			{	
				var vle = "";
				
				$('#slct_jubject').removeAttr("disabled");				

				$("#slct_jubject option").remove();
				
				$('#slct_jubject')
				.append($("<option></option>")
				.attr("value",vle)
				.text("-- Sila Pilih --"));

				for (var key in data.subjek)
				{
					if (data.subjek.hasOwnProperty(key))
					{
						var cm_id = data.subjek[key].cm_id;
						var subjek_id = data.subjek[key].mod_id;
						var subjek_cat = data.subjek[key].mod_type;
						var subjek_kod = data.subjek[key].mod_code;
						var subjek_name = data.subjek[key].mod_name;

						$('#slct_jubject')
						.append($("<option></option>")
						.attr("value",subjek_id+':'+subjek_cat+':'+cm_id)
						.text(subjek_kod.toUpperCase()+' - '+subjek_name.toUpperCase()));
					}
				}
				
				//$("#frm_written").validationEngine('validate');
				//$('#btn_print_form').removeAttr("disabled");
				$('#btn_print_form').attr("disabled", "disabled");
				//$('#slct_pengisian').removeAttr("disabled");
				//$('#slct_jubject').attr("disabled", "disabled");

				$.unblockUI(); 
				
			});

			request.fail(function(jqXHR, textStatus)
			{
				var mssg = new Array();
				mssg['heading'] = 'Tiada Modul';
				mssg['content'] = 'Sila Pastikan Semester dan Kursus adalah Betul..';

				kv_alert(mssg);
			});	

				$.unblockUI(); 		
		}
		else
		{
			$('#slct_jubject').attr("disabled", "disabled");
		}		
	});

	
	//untuk triger kelas apabila pilih modul
	$('#slct_jubject').change(function()
	{
		$("#frm_written").validationEngine('validate');
		
		var semester = $('#slct_semester').val();
		var courseid = $('#slct_kursus').val();
		var modul = $('#slct_jubject').val().split(":");
		
		if(-1 != courseid)
		{
			var request = $.ajax({
				url: site_url+"/examination/writtenform/spsubject_kelas",
				type: "POST",
				data: {course_id : courseid, semes_ter : semester, slct_jubject : modul[2]},
				dataType: "json"
			});

			request.done(function(data)
			{	
				var dropdown = 
					'<select id="slct_kelas" name="slct_kelas" style="width:270px;"'+ 
					'class="validate[required]">'+ 
					'<option value="">-- Sila Pilih --</option>';
				//console.log(data.subjek[0].subjek_id);
				//alert(data);							//FDP
				$('#divKelas').html(dropdown);
				
				$("#slct_kelas option").remove();
				$('#slct_kelas').append($("<option value=''></option>").text("-- Sila Pilih --"));

				
				var row_data = "";

				$(data.class_data).each(function(index)
				{
					//print_r(data.class_data);	
					var class_id = data.class_data[index].class_id;
					var class_name = data.class_data[index].class_name;
					
					row_data +=
						$('#slct_kelas').append($("<option></option>").attr("value",class_id).text(class_name.toUpperCase()));
					
				});	
				
					//$("#frm_written").validationEngine('validate');
					$('#slct_pengisian').removeAttr("disabled");
					//$('#btn_print_form').attr("disabled","disabled");
				
			});

		}
		else
		{
			//$("#frm_written").validationEngine('validate');
			$('#slct_kelas').attr("disabled", "disabled");
		}		
	});

	//umairah - add class - 19/3/2014
	$('#slct_jubject').change(function()
	{
		if($('#slct_jubject').val().length>0)
		{
			var slctsem = $('#slct_semester').val();
			var slct_sbj 	= $('#slct_jubject').val().split(":");
			var kelas = $('#slct_kelas').val();
	
			var sb_id		= slct_sbj[0];
			var sb_cat 		= slct_sbj[1];
			var cm_id		= slct_sbj[2];
			
			$('#cmId').val(cm_id);
			$('#semester').val(slctsem);
			$('#subjectId').val(sb_id);
			$('#kelas1').val(kelas);
		}
	});

});//end of document.ready
/**************************************************************************************************
 * End of wform.js
 *************************************************************************************************/