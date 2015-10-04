/**************************************************************************************************
 * File Name        : repeatmark.js
 * Description      : This File contain all of javascript for evaluation PUSAT repeat paper
 * Author           : Norafiq Bin Mohd Azman Chew
 * Date             : 16 August 2013
 * Version          : -
 * Modification Log : -
 * Function List	   : - 
 *************************************************************************************************/
var markschanged = new Array();

(function($){
	var _old = $.unique;
	$.unique = function(arr){
		if (!!arr[0].nodeType){
			return _old.apply(this,arguments);
		} else {
			return $.grep(arr,function(v,k){
				return $.inArray(v,arr) === k;
			});
		}
	};
})(jQuery);
/**************************************************************************************************
 * Description		: this function to open mark form 
 * input			: val
 * author			: Norafiq Azman
 * Date				: 20 August 2013
 * Modification Log	: umairah - subjek vk 11/4/2014
 *************************************************************************************************/
function fnOpenMark(val)
{
	var mdid = val;
	
	var request = $.ajax({
		url: site_url+"/examination/repeatmark/get_sbj",
		type: "POST",
		data: {takenid : mdid},
		dataType: "json"
	});
	
	request.done(function(data)
	{
				
			if(data.subjek != null)
			{
				var jumlahmarkah = "";
				var repeatmarkah = data.subjek.marks_value;
				var modulename = data.subjek.mod_name;
				var markcentre = data.subjek.mod_mark_centre;
				var markSchool = data.subjek.mod_mark_school;
				var mark_type = data.subjek.mod_type;
				var mark_cat = data.subjek.mark_category;
				//alert(repeatmarkah);

				
				$("#modulesubjek").html(modulename);
				
				if(mark_type == "AK" && mark_cat == "P")
				{
					$("#modcentre").val(markcentre);
				}
				else
				{
					$("#modcentre").val(markSchool);
				}
				
				$("#modid").val(mdid);
				
				if(repeatmarkah == "-99.99")
				{
					jumlahmarkah = "T";
					repeatmarkah = "T";
				}
				else
				{
					
					if(mark_type == "AK" && mark_cat == "P"){
					
						jumlahmarkah = (repeatmarkah/100 * markcentre).toFixed(2);
						$("#rmarkah").val(Math.ceil(repeatmarkah));
						$("#jrmarkah").val(Math.ceil(jumlahmarkah));	
					}
					else
					{
						
						jumlahmarkah = (repeatmarkah/100 * markSchool).toFixed(2);
						$("#rmarkah").val(Math.ceil(repeatmarkah));
						$("#jrmarkah").val(Math.ceil(jumlahmarkah));	
						
					}
					
				}							
							
			}
			else
			{
				$("#rmarkah").val("");
				$("#jrmarkah").val("");
			}
			
			
			
			
			$('#repeatpop').modal({
				keyboard: false,
				backdrop: 'static'						
			});
			
		});
				
	request.fail(function(jqXHR, textStatus)
	{
		var mssg = new Array();
		mssg['heading'] = 'Message';
		mssg['content'] = 'Request failed: ' + textStatus;

		kv_alert(mssg);
	});	
}

/**************************************************************************************************
 * Description		: document ready function
 * input			: -
 * author			: Norafiq Azman
 * Date				: 16 August 2013
 * Modification Log	: umairah - subjek vk - 11/4/2014
 *************************************************************************************************/
$(document).ready(function(){
	
	$('#tblRepeatnMarks').dataTable({
		"aoColumnDefs": [	{ bSortable: false, aTargets: [0] },
		                 	{ bSortable: false, aTargets: [1] },
		                 	{ bSortable: false, aTargets: [2] }
						],
		"bPaginate": false,
		"bFilter": false,
		"bAutoWidth": false,
		"bInfo": false,
		"aaSorting": [[ 1, 'asc' ]]
	});
	
	$("#tblStudent").dataTable({
		"aoColumnDefs": [{ bSortable: false, aTargets: [0,4] } ],
		"bPaginate": false,
		"bFilter": true,
		"bAutoWidth": false,
		"bInfo": false,
		"aaSorting": [[ 1, 'asc' ]],
		"oLanguage": { "sSearch": "Carian :" },
		"fnDrawCallback": function ( oSettings ) {
			if ( oSettings.bSorted || oSettings.bFiltered )
			{
				for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
				{
					$('td:eq(0)', oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
				}
			}
		}

	});
	
	$('#btn_cari').click(function()
	{		
		var slct_cou	= $('#slct_kursus').val();
		var slct_sem	= $('#slct_sem').val();
		var matikno		= $('#nomatrik').val();
		
		if("" != slct_cou)
		{
			$("#frm_marking").validationEngine({scroll:false});
			
			if("" != slct_sem)
			{
				$('#frm_marking').submit();
			}
			else
			{
				$("#frm_marking").validationEngine('validate');
			}
		}
		else
		{
			$('#frm_marking').submit();
		}
	});
	
	$('#tblRepeatnMarks').on('change','.cellMarks',function(event)
	{
		var v = $(this).val();
		
		if(v  == 0 && v < 1)												 
		{
			v = 1;
			$(this).val(v);
		}
		if(v <= 100)
		{			
			$('#'+$(this).attr('id')).validationEngine('hide');
			
			var classrow = $(this).parent().parent().attr('class');
			
			if(classrow == "even")
			{
				$(this).parent().css('background-color', 'transparent');
			}
			if(classrow == "odd")
			{
				$(this).parent().css('background-color', '#f9f9f9');
			}
		}
		else if(v >= 101)
		{			
			$('#'+$(this).attr('id')).validationEngine('showPrompt', '*Sila Pastikan Jumlah Markah Tidak Melebihi 100%', 'err', 'topLeft', true);
			$(this).parent().css('background-color', 'red');
		}
		else if("T" != v && "t" != v)
		{
			$('#'+$(this).attr('id')).validationEngine('showPrompt', 'Anda Dibenarkan menggunakan Huruf T sahaja', 'err', 'topLeft', true);
			$(this).parent().css('background-color', 'red');
			//$('#btnSaveRepeatMarks').attr("disabled", "disabled");
		}
		
		markschanged.push($(this).attr('id'));
		
			var mark_total_mark = parseInt($('#modcentre').val());
		
		var marks = new Array();

		$(this).parent().parent().find('input.cellMarks').each(function(i,obj){

			if(!isNaN($(this).val()))
			{
				if($(this).val() == 0 && $(this).val() < 1)
				{
					marks[i] = {id : $(this).parent().attr('id') ,val : 1.00};
				}
				else
				{
					marks[i] = {id : $(this).parent().attr('id') ,val : $(this).val()};
				}
			}
			else if($(this).val() == "T" || $(this).val() == "t")
			{
				//alert($(this).val()); //FDP
				$('#'+$(this).attr('id')).validationEngine('hide');
				
				$(this).val($(this).val().toUpperCase());
				
				classrow = $(this).parent().parent().attr("class");
				
				if(classrow == "even")
				{
					$(this).parent().css('background-color', 'transparent');
				}
				if(classrow == "odd")
				{
					$(this).parent().css('background-color', '#f9f9f9');
				}
				
				marks[i] = {id : $(this).parent().attr('id') ,val : -99.99};
			}
			else
			{
				$(this).val($(this).val().toUpperCase());
				marks[i] = {id : $(this).parent().attr('id') ,val : 1.00};
			}
		});

		marks.sort(function(a,b){return b.val-a.val});

		var sum = 0;
		var avgCal = 0;
		
		for(i=0; i<1; i++)
		{
			if(marks[i].val*1 == "-99.99")
			{
				sum = sum+(0*1);
				avgCal += marks[i].val*1;
			}
			else
			{
				sum = sum+(marks[i].val*1);
			}
		}
		
		if(avgCal/1 != -99.99)
		{
			var markahs = (sum/1)/100 * mark_total_mark;
			
			
			if(markahs <= mark_total_mark)
			{
				$(this).parent().parent().find('.jum_markah')
				.val(Math.ceil(new Number(markahs).toFixed(2)))
				.validationEngine('hide');
				
				$('#btnSaveRepeatMarks').removeAttr("disabled");
			}
			else if(markahs > mark_total_mark)
			{
				$(this).parent().parent().find('.jum_markah')
				.val(Math.ceil(new Number(markahs).toFixed(2)))
				.validationEngine('showPrompt', '*Sila Pastikan Jumlah Markah Tidak Melebihi '+mark_total_mark+'%', 'err', 'bottomLeft', true);
							
				$('#btnSaveRepeatMarks').attr("disabled", "disabled");
			}
		}
		else
		{
				$(this).parent().parent().find('.jum_markah').val('T');
				//$('#btnSaveRepeatMarks').removeAttr("disabled");

				$('#btnSaveRepeatMarks').attr("disabled", "disabled");				
			
		}
	});
	

	
	$('#formRepeatMark').on('click', '#btnSaveRepeatMarks', function() 
	{
		//console.log(markschanged);
		
		$("#formRepeatMark").validationEngine('validate');
		
		$("#modid").val();
		$("#rmarkah").val();
		$("#modcentre").val();
			
		$("#repeatpop").scrollTop(0);
		$('#repeatpop').css('overflow','hidden');
		$('#repeatpop').block({ 
			message: '<h5><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang proses, Sila tunggu...</h5>', 
			css: { border: '3px solid #660a30', width:'270px'} 
		});

		setTimeout(function()
		{
			var ttlmark = $("#rmarkah").val();
			var mod_id = $("#modid").val();
			var mttlmrk = $("#modcentre").val();
			
			var request = $.ajax({
				url: base_url+"index.php/examination/repeatmark/save_repeatmark",
				type: "POST",
				data: {takenid : mod_id, rptmark : ttlmark, modcentre : mttlmrk},
				dataType: "html"
			});

			request.done(function(data)
			{
				//console.log(data);
				var mssg = new Array();
				mssg['heading'] = 'Mesej';
				mssg['content'] = 'Markah pelajar Berjaya di simpan.';		
				mssg['callback'] = function()
				{
					$('#repeatpop').unblock();
				}
				
				kv_alert(mssg);
				$("#repeatpop").modal('hide');
			});

			request.fail(function(jqXHR, textStatus)
			{
				$('#repeatpop').unblock();
							
				var mssg = new Array();
				mssg['heading'] = 'Mesej';
				mssg['content'] = 'Markah pelajar TIDAK Berjaya di simpan.';

				kv_alert(mssg);	
				$("#repeatpop").modal('hide');
			});

		}, 1500);

		return false;
	});
	
}); // end of document ready
/**************************************************************************************************
 * End of repeatmark.js
 *************************************************************************************************/