/**************************************************************************************************
 * File Name        : markings.js
 * Description      : This File contain all of javascript for evaluation PUSAT
 * Author           : Norafiq Bin Mohd Azman Chew
 * Date             : 3 july 2013
 * Version          : -
 * Modification Log : -
 * Function List	   : - 
 **************************************************************************************************/
var autoCompleteTask = { source: ["Teori","Amali"] };

var otblAssgnMarks = null;
var markschanged = new Array();
var pentaksiran = "S";
var ptid		= "";
var newID = 1;

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
 * Description		: this function to delete row at Mymodal
 * input			: val
 * author			: Norafiq Azman
 * Date				: 3 july 2013
 * Modification Log	: -
 **************************************************************************************************/
function fnDelete(val)
{	
	var heading = 'Padam Tugasan';
	var question = 'Adakah Anda pasti untuk memadam tugasan ini?';
	var cancelButtonTxt = 'Batal';
	var okButtonTxt = 'Padam';

	$('#myModal').block({ 
		message: '<h5><img src="'+base_url+'assets/img/loading_ajax.gif"' +
		'alt="Sedang process"/>Sedang process, Sila tunggu...</h5>', 
		css: { border: '3px solid #660a30' } 
	});

	var callback = function()
	{
		//$('.deltugasan').tooltip('hide');
		if(-1 != val.indexOf("trAdd"))
		{
			//var assgmnt_id0 = $('#tgsid0').val()
			var assgmnt_id1 = $('#tgsid1').val()

			//if("" != assgmnt_id0 || "" != assgmnt_id1)
			if("" != assgmnt_id1)
			{
				/*if("" != assgmnt_id0)
				{
					var request = $.ajax({
						url: "markings/assignmentToDelete",
						type: "POST",
						data: {tugasanID : assgmnt_id0},
						dataType: "json"
					});
				}*/
				//if("" != assgmnt_id1)
				//{
					var request = $.ajax({
						url: site_url+"/examination/markings_v2/assignmentToDelete",
						type: "POST",
						data: {tugasanID : assgmnt_id1},
						dataType: "html"
					});
				//}				

				request.done(function(data)
				{
					//alert("Tugasan Telah Dipadam..");					//FDP
					var mssg = new Array();
					mssg['heading'] = 'Dipadam';
					mssg['content'] = 'Tugasan telah dipadam';

					kv_alert(mssg);
				});

				request.fail(function(jqXHR, textStatus)
				{
					//alert("Tugasan tidak dapat dipadam !");
					var mssg = new Array();
					mssg['heading'] = 'Dipadam';
					mssg['content'] = 'Tugasan tidak berjaya dipadam';

					kv_alert(mssg);
				});	
			}

			$(val).remove();
			$('#addtask').removeAttr("disabled");
			calculatePercent();
		}	

		$('#myModal').unblock();
	};

	var cancelCallback = function()
	{
		$('#myModal').unblock();
	};

	confirm(heading, question, cancelButtonTxt, okButtonTxt, callback, cancelCallback);
	return false;		
}

/**************************************************************************************************
 * Description		: this function is confirm to delete or not.
 * input			: heading, question, cancelButtonTxt, okButtonTxt, callback, cancelCallback
 * author			: Norafiq Azman
 * Date				: 3 july 2013
 * Modification Log	: -
 **************************************************************************************************/
function confirm(heading, question, cancelButtonTxt, okButtonTxt, callback, cancelCallback)
{
	var confirmModal = $('<div class="modal hide fade">' +    
			'<div class="modal-header">' +
			'<h3>' + heading +'</h3>' +
			'</div>' +
			'<div class="modal-body">' +
			'<p>' + question + '</p>' +
			'</div>' +
			'<div class="modal-footer">' +
			'<a href="javascript:void(0);" id="mdl_cancel_btn" class="btn"'+ 
			'data-dismiss="modal">'+ cancelButtonTxt + '</a>' +
			'<a href="javascript:void(0);" id="okButton" class="btn btn-primary">' + 
			okButtonTxt + '</a>' +
			'</div>' +
	'</div>');

	confirmModal.find('#okButton').click(function(event)
	{
		callback();
		confirmModal.modal('hide');
	});

	confirmModal.find('#mdl_cancel_btn').click(function(event)
	{
		cancelCallback();
		confirmModal.modal('hide');
	});

	confirmModal.modal({keyboard: false,backdrop: 'static'});     
};

/**************************************************************************************************
 * Description		: this function to popup assignment for lecturer insert detail mark
 * input			: val
 * author			: Norafiq Azman
 * Date				: 3 july 2013
 * Modification Log	: -
 **************************************************************************************************/
function fnOpenAssignment(val)
{
	markschanged = new Array();

	var assgmntID = val;
	var tempcourse = $('#slct_kursus').val().split(":");
	var slct_sbj =  $('#slct_jubject').val().split(":");
	var semester =  $('#slct_tahun').val()
	

	var sbj_id = slct_sbj[0];
	var sb_cat = slct_sbj[1];
	var cmid = slct_sbj[2];
	
	var courseslct = tempcourse[0];	
	
	//alert('assgmnt id:'+assgmntID+' cmid:'+cmid); //FDP

	var request = $.ajax({
		url: base_url+"index.php/examination/markings_v2/get_assignment",
		type: "POST",
		data: {assgmnt_ID : assgmntID, ksmid2 : cmid, semesterP : semester},
		dataType: "json"
	});	

	request.done(function(data)
	{	
		//console.log(data);
		//console.log(data.senaraipelajar);
		//console.log(data.subjekconfigur);

		$("#formAssgMark").validationEngine('validate',{scroll: false});
		
		var tugasan_id = data.subjek.assgmnt_id;
		var assg_name = data.subjek.assgmnt_name;
		var assg_total_mark = data.subjek.assgmnt_mark;
		var assg_total = data.subjek.assgmnt_total;
		var assg_selection = data.subjek.assgmnt_score_selection;

		$("#mark_assg_selection").val(assg_selection);
		$("#mark_total_assg").val(assg_total_mark);		
		$("#semesterP4").val(semester);
		$("#mptID4").val(cmid);
		$("#category").val(sb_cat);

		//kita kena hapuskan datatable objek sebab kita kena re-create
		var ex = document.getElementById('tblAssgnMarks');
		if ( $.fn.DataTable.fnIsDataTable( ex ) )
		{
			otblAssgnMarks.fnDestroy();
		}

		$('#tblAssgnMarks > thead').html("");
		$('#tblAssgnMarks > tbody').html("");

		//load data and populate modal
		$('#markHeader').html(assg_name);
		$('#mark_assg_selection').val(assg_selection);
		$('#paparanAgihan').html("Pemilihan "+assg_selection+" Tugasan Terbaik. " );

		var thead = '<tr style="background-color=white;">'+
		'<th>BIL</th>'+
		'<th>NAMA MURID</th>'+
		'<th>ANGKA GILIRAN</th>';

		var agihan = (assg_total_mark*1)/(assg_selection*1);
		
		if("Teori" == assg_name)
		{
			if(1 == assg_selection && 1 == assg_total)
			{
				thead+='<th style="text-align:center;vertical-align:middle;width:10%;">'+data.subjek.sub_theory[0].th_sub_name+
				' ('+data.subjek.sub_theory[0].th_percentage+'%)'+
				'</th>';
			}
			else
			{
				$index_th = 0;
				for(i=1; i<=assg_total; i++)
				{
					thead += '<th style="text-align:center;vertical-align:middle;width:5%;">'+data.subjek.sub_theory[$index_th].th_sub_name+
					' ('+data.subjek.sub_theory[$index_th].th_percentage+'%)'+
					'</th>';
					
					$index_th++;
				}
			}
		}
		else
		{
			if(1 == assg_selection && 1 == assg_total)
			{
				thead+='<th style="text-align:center;vertical-align:middle;width:10%;">'+assg_name+'</th>';
			}
			else
			{
				for(i=1; i<=assg_total; i++)
				{
					thead += '<th style="text-align:center;vertical-align:middle;width:5%;">'+assg_name+ ' '+i+'</th>';
				}
			}
		}

		

		thead += '<th class="jum_markah" style="text-align:center;width:10%;"> Jumlah / '+assg_total_mark+'%</th></tr>';

		$("#tblAssgnMarks > thead").html(thead);

		var rows = data.pelajar;

		$(rows).each(function(index)
		{
			var studid = rows[index].stu_id;
			var namaplajar = rows[index].stu_name;
			var noIC = rows[index].stu_matric_no;
			var marksd = rows[index].marks;
			var ttlMark = rows[index].ttlMark;
			
			//var i = 0;
			
			if(ttlMark < 0)
			{
				ttlMark = "T";
			}
			if(ttlMark == 0 && ttlMark < 1)
			{
				ttlMark = 1;
			}

			var tbody = '<tr id="jumlah'+studid+''+tugasan_id+'">'+	
			'<td>'+(index+1)+'</td>'+
			'<td>'+namaplajar.toUpperCase()+'</td>'+
			'<td>'+noIC+'</td>';
						
			if(1 == assg_selection && 1 == assg_total)
			{
				for(i=1; i<=assg_total; i++)
				{
					var m = "";					
					
					if(marksd != null)
					{
						$(marksd).each(function(index2)
						{
							var assignment_num = marksd[index2].assignment_num;
							
							if(marksd[index2].data!=null && i == assignment_num )
							{
								m = marksd[index2].data.mark;
								
								if(m == -99.99)
								{
									m = "T";
								}
								if(m == 0 && m < 1)
								{
									m = 1;
								}
							}							
						});
					}
				}
				
				tbody += '<td><input style="width: 50px;" name="'+studid+'_'+tugasan_id+'_1" id="'+studid+'_'+tugasan_id+'_1" type="text"'+
				'value="'+Math.ceil(m)+'" class="cellMarks"/></td>';
			}
			else
			{				
				for(i=1; i<=assg_total; i++)
				{
					var m = "";					
					
					if(marksd != null)
					{
						$(marksd).each(function(index2)
						{
							var assignment_num = marksd[index2].assignment_num;
							
							if(marksd[index2].data!=null && i== assignment_num )
							{
								m = marksd[index2].data.mark;
								
								if(m == -99.99)
								{
									m = "T";
								}
								if(m == 0 && m < 1)
								{
									m = 1;
								}
							}							
						});
					}
					
					tbody += '<td><input style="width:50px;" name="'+studid+'_'+tugasan_id+ '_'+i+'" id="'+studid+'_'+tugasan_id+ '_'+i+'" type="text"'+
					'value="'+Math.ceil(m)+'" class="cellMarks"/></td>';
				}
			}
			
			//var ttlM = "";
			//ttlM = ttlMark

			tbody += '<td style="text-align:center;vertical-align:middle;">'+
			'<input style="width:80px;" type="text" readonly="readonly"'+
			'value="'+Math.ceil(ttlMark)+'" class="jum_markah" /></td></tr>';

			$("#tblAssgnMarks > tbody").append(tbody);
		});
		
		otblAssgnMarks = $('#tblAssgnMarks').dataTable(
		{
			"aoColumnDefs": [	{ bSortable: false, aTargets: [0] },
			                 	{ bSortable: false, aTargets: [3] },
			                 	{ bSortable: false, aTargets: [4] }],
			"sScrollY": "200px",
			"bScrollInfinite": true,
	        "bScrollCollapse": true,
			"bJQueryUI": false,
			"bPaginate": false,
			"bFilter": false,
			"bAutoWidth": false,
			"bInfo": false,
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
				
		/*if($("#tblAssgnMarks").length > 0){ 
			new FixedHeader( otblAssgnMarks, {
		        "offsetTop": 140,
		        "zTop" : "1051",
		        "right" : true
		    });
			
			var tblAssgnWidth = $("#tblAssgnMarks").width();
			
			$("body").children(".fixedHeader").each(function (index) {
				if(index == 1)
				{
					alert(tblAssgnWidth);
					$(this).width(tblAssgnWidth+"%");
				}
			});
		}*/  //Untuk fixed header yang xjadi lagi
		
		$("#formAssgMark").validationEngine('validate',{scroll: false});
				
		$('#assgmnpop').modal({
			keyboard: false,
			backdrop: 'static'						
		});
		
		otblAssgnMarks.fnAdjustColumnSizing(false);
		otblAssgnMarks.fnDraw();
		
		
		$('#assgmnpop').on('hide', function () {
			$("body").children(".fixedHeader").each(function (index) {
				if(index == 1)
                $(this).remove();
            });
		})
	});

	request.fail(function(jqXHR, textStatus)
	{
		//console.log(jqXHR);
		//alert( "Request failed: " + textStatus );
		return false;
	});			
}

/**************************************************************************************************
* Description 		: this function to calculate percent for total coursework.
* input				: 
* author			: Norafiq Azman Chew
* Date				: 7 July 2013
* Modification Log	:  -
**************************************************************************************************/
function calculatePercent()
{
	var totalpercent = parseInt($('#percent').html());
	var total = 0;
	$(".inputperatusan").each(function() {
		var val = isNaN(parseInt($(this).val()))? 0 : parseInt($(this).val());
		total += val;
	});

	$('#jumlahMarkahTugasan').html(total);

	if(totalpercent==total)
	{
		$('#jumlahMarkahTugasan').validationEngine('hide');
		$('#btnSaveConfig').removeAttr("disabled");
	}
	else if(totalpercent>total)
	{
		$('#jumlahMarkahTugasan').validationEngine('showPrompt', '*Sila Pastikan Jumlah Markah Tugasan ialah '+totalpercent+"%", 'load', 'bottomLeft', true);
		$('#btnSaveConfig').attr("disabled", "disabled");
	}
	else if(totalpercent<total)
	{
		$('#btnSaveConfig').attr("disabled", "disabled");
		$('#jumlahMarkahTugasan').validationEngine('showPrompt', '*Pastikan Jumlah Markah Tugasan tidak melebihi '+totalpercent+"%", 'err', 'bottomLeft', true);
	}
}

/**************************************************************************************************
* Description 		: this function to submit some form from another function
* input				: 
* author			: Norafiq Azman Chew
* Date				: 11 dec 2013
* Modification Log	:  -
**************************************************************************************************/
function submitsomeform(ptid)
{
	var semester = $('#slct_tahun').val();
	var slct_sbj 	= $('#slct_jubject').val().split(":");

	var sb_id		= slct_sbj[0];
	var sb_cat 		= slct_sbj[1];
	var cm_id		= slct_sbj[2];
	
	pentaksiran = "S"; // S = Sekolah
	
	$('#ksmid2').val(cm_id);
	$("#kursusid").val($('#slct_kursus').val());
	$("#subjectid").val(sb_id);
	$("#semesterP").val(semester);
	$("#pentaksiran").val(pentaksiran);
	$("#mptID").val(ptid);						
	$('#tempKAt2').val(sb_cat); 
	
	if("AK" == sb_cat)
	{				
		$('#formConfig').submit();
		//console.log("dapat masuk AK "+ptid);
	}
	else
	{
		$('#ksmid3').val(cm_id);
		$('#kursusid3').val($('#slct_kursus').val());
		$('#subjectid3').val(sb_id);
		$('#semesterP3').val(semester);
		$('#pentaksiran3').val(pentaksiran);
		
		$('#tempKAt').val(sb_cat);
		
		//console.log("dapat masuk VK "+ptid);
		$('#loadStudent').submit();
	}
}


/**************************************************************************************************
 * Description		: this function to delete row at Mymodal for theory
 * input			: val
 * author			: Freddy AJang Tony
 * Date				: 27 January 2014
 * Modification Log	: -
 **************************************************************************************************/
function fnDelete_theory(val)
{	
	var heading = 'Padam Tugasan';
	var question = 'Adakah Anda pasti untuk memadam tugasan ini?';
	var cancelButtonTxt = 'Batal';
	var okButtonTxt = 'Padam';

	$('#myModal').block({ 
		message: '<h5><img src="'+base_url+'assets/img/loading_ajax.gif"' +
		'alt="Sedang process"/>Sedang process, Sila tunggu...</h5>', 
		css: { border: '3px solid #660a30' } 
	});

	var callback = function()
	{
		//$('.deltugasan').tooltip('hide');
		if(-1 != val.indexOf("trTheory"))
		{
			var th_id = val.split('_');
			//var assgmnt_id0 = $('#tgsid0').val()
			var theory_id = $('#theory_id_'+th_id[1]+'').val();
			
			newID--;
			
			//alert('theory_id_'+th_id[1]+'');
			$('#jmlhtugsan0').val(newID);
			$('#tugasanterbaik0').val(newID);
			

			//if("" != assgmnt_id0 || "" != assgmnt_id1)
			if("" != theory_id)
			{
				/*if("" != assgmnt_id0)
				{
					var request = $.ajax({
						url: "markings/assignmentToDelete",
						type: "POST",
						data: {tugasanID : assgmnt_id0},
						dataType: "json"
					});
				}*/
				//if("" != assgmnt_id1)
				//{
					var request = $.ajax({
						url: site_url+"/examination/markings_v2/theory_assignment_delete",
						type: "POST",
						data: {th_id : theory_id},
						dataType: "html"
					});
				//}				

				request.done(function(data)
				{
					//alert("Tugasan Telah Dipadam..");					//FDP
					var mssg = new Array();
					mssg['heading'] = 'Dipadam';
					mssg['content'] = 'Tugasan telah dipadam';

					kv_alert(mssg);
				});

				request.fail(function(jqXHR, textStatus)
				{
					//alert("Tugasan tidak dapat dipadam !");
					var mssg = new Array();
					mssg['heading'] = 'Dipadam';
					mssg['content'] = 'Tugasan tidak berjaya dipadam';

					kv_alert(mssg);
				});	
			}

			$(val).remove();
			$('#addtask').removeAttr("disabled");
			calculatePercentTheory();
		}	

		$('#myModal').unblock();
	};

	var cancelCallback = function()
	{
		$('#myModal').unblock();
	};

	confirm(heading, question, cancelButtonTxt, okButtonTxt, callback, cancelCallback);
	return false;		
}


/**************************************************************************************************
* Description 		: this function to calculate percent for total sub theory.
* input				: 
* author			: Freddy Ajang Tony
* Date				: 28 January 2014
* Modification Log	:  -
**************************************************************************************************/
function calculatePercentTheory()
{
	var totalpercent = parseInt($('#peratusan0').val());
	var total = 0;
	
	$(".inputSubTheory").each(function() {
		var val = isNaN(parseInt($(this).val()))? 0 : parseInt($(this).val());
		total += val;
	});

	$('#jumlahMarkahTugasan2').html(total);

	if(totalpercent==total)
	{
		$('#jumlahMarkahTugasan2').validationEngine('hide');
		$('#btnSaveConfig').removeAttr("disabled");
	}
	else if(totalpercent>total)
	{
		$('#jumlahMarkahTugasan2').validationEngine('showPrompt', '*Sila Pastikan Jumlah Markah Tugasan ialah '+totalpercent+"%", 'load', 'bottomLeft', true);
		$('#btnSaveConfig').attr("disabled", "disabled");
	}
	else if(totalpercent<total)
	{
		$('#btnSaveConfig').attr("disabled", "disabled");
		$('#jumlahMarkahTugasan2').validationEngine('showPrompt', '*Pastikan Jumlah Markah Tugasan tidak melebihi '+totalpercent+"%", 'err', 'bottomLeft', true);
	}
}


/**************************************************************************************************
* Description 		: this function to initiate jquery for sub theory table.
* input				: 
* author			: Freddy Ajang Tony
* Date				: 28 January 2014
* Modification Log	:  -
**************************************************************************************************/
function sub_theory_jquery()
{
	$('#tbltask_subTheory').on('change','.inputSubTheory',function(e){
		calculatePercentTheory();
	});
	
	$('#addtaskTheory').tooltip();
	
	$('#formConfig').on('click', '#addtaskTheory', function() 
	{
				
		
		$('#tbltask_subTheory > tbody:last')
		.append('<tr id="trTheory_'+newID+'">'+
				'<td><input type="hidden" name="theory_id[]" id="theory_id_'+newID+'" class="theory_id" value="0">'+
				'<input type="text" name="theory_name[]"'+
				'id="theory_name_'+newID+'" class="validate[required] span7" value=""/></td>'+
				'<td><input type="text" name="percentage[]"'+
				'id="percentage_'+newID+'" class="validate[required,custom[integer]] span7 inputSubTheory" value=""/></td>'+
				'<td>'+
				'<a class="deltugasan" href="javascript:void(0)" data-original-title="Delete Tugasan">' +
				'<img src="'+base_url+'assets/img/E_Delete_Sm_N.png" alt="Delete Tugasan" style="height:16px;width:16px;max-width:16px;"' +
				'onclick="fnDelete_theory(\'#trTheory_'+newID+'\')"></a>'+
				'</td>'+
				'</tr>'
		);

		newID++;
		
		$('#jmlhtugsan0').val(newID);
		$('#tugasanterbaik0').val(newID);
		
		
		/*$(".txttugasan").autocomplete(autoCompleteTask);
		$("#formConfig").validationEngine('attach');
		
		if($('.jumlahMarkahTugasanformError')[0])
			$("#jumlahMarkahTugasan").validationEngine("hide");

		var autoSuggestion = document.getElementsByClassName('ui-autocomplete');
		if(autoSuggestion.length > 0)
		{
			autoSuggestion[newID].style.zIndex = 1051;
		}

		$("#addtask").attr("disabled", "disabled");*/

	});
}

/**************************************************************************************************
 * Description		: document ready function
 * input			: -
 * author			: Norafiq Azman
 * Date				: 3 july 2013
 * Modification Log	: -
 **************************************************************************************************/
$(document).ready(function(){
	
	$("#frm_marking").validationEngine({scroll:false});
	$("#formAssgMark").validationEngine({scroll:false});
	$("#formConfig").validationEngine({promptPosition : "topLeft", scroll:false});
	
	var oTable = $("#tblStudent").dataTable({
		"aoColumnDefs": [{ bSortable: false, aTargets: [0] } ],
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
	
	if($("#tblStudent").length > 0){ 
		new FixedHeader( oTable, {
	        "offsetTop": 40
	    });
	}
	
	$(".txttugasan").autocomplete(autoCompleteTask);
	
	$('#tbltask').on('change','#peratusan0',function(e){
		$('#percent2').html($(this).val());
	});
	
	$('#slct_tahun').change(function()
	{
		$("#slct_kursus").val(-1);
		$("#slct_jubject").val("");
		$('#slct_jubject').attr("disabled", "disabled");
		$('#btn_config_markP').attr("disabled", "disabled");
		
	});
	
	$('#tbltask').on('change','.inputperatusan',function(event){
		calculatePercent();
	});

	$('#slct_kursus').change(function()
	{
		$("#frm_marking").validationEngine('validate');
		
		var semester = $('#slct_tahun').val();
		var courseid = $('#slct_kursus').val();

		if(-1 != courseid)
		{
			var request = $.ajax({
				url: site_url+"/examination/markings_v2/spsubject",
				type: "POST",
				data: {course_id : courseid, semes_ter : semester},
				dataType: "json"
			});

			request.done(function(data)
			{
				//console.log(data1);
				//var data = jQuery.parseJSON(data1); //JSON.stringify(eval("(" + data1 + ")"));
				//console.log(data);  //FDP

				$('#slct_jubject').removeAttr("disabled");

				//console.log(data.subjek[0].subjek_id);
				//alert(data);							//FDP

				$("#slct_jubject option").remove();
				$('#slct_jubject')
				.append($("<option></option>")
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

				$("#frm_marking").validationEngine('validate');
				
			});

			request.fail(function(jqXHR, textStatus)
			{
				var mssg = new Array();
				mssg['heading'] = 'Tiada Modul';
				mssg['content'] = 'Sila Pastikan Semester dan Kursus adalah Betul..';

				kv_alert(mssg);
			});			
		}
		else
		{
			$('#slct_jubject').attr("disabled", "disabled");
		}		
	});

	$('#btn_config_markP').click(function()
	{
		
		$("#frm_marking").validationEngine('validate');
		//$("#formConfig").validationEngine({promptPosition : "topLeft", scroll:false});
		
		var slct_sbj 	= $('#slct_jubject').val().split(":");

		var sb_id		= slct_sbj[0];
		var sb_cat 		= slct_sbj[1];
		var cm_id		= slct_sbj[2];
		
		pentaksiran = "S"; // S = Sekolah
		
		newID = 1;

		//var temptarikh = "takbuka"; //tukar bila dah ada function buka tarikh masuk markah
		var temptarikh 	= "dahbuka";

		if("dahbuka" == temptarikh)
		{
			if("VK" == sb_cat)
			{
				var request = $.ajax({
					url: site_url+"/examination/markings_v2/get_swb",
					type: "POST",
					data: {pntksrn : pentaksiran, cmID : cm_id, type : sb_cat},
					dataType: "json"
				});

				request.done(function(data)
				{
					//console.log(data);
					var butangadd;
					
					$(".txttugasan").autocomplete(autoCompleteTask);
					
					$('#katTugasan').html("Tugasan Sekolah");
					$('#ksmid2').val(cm_id);
					
					if(null != data.weightage)
					{
						$('#percent').html(data.weightage.mod_mark_school);
						$('#semesterP').val(data.weightage.cm_semester);
						
						if(null != data.configuration)
						{
							var row = "";						
							
							for (var key in data.configuration)
							{
								if (data.configuration.hasOwnProperty(key))
								{
									var assgmnt_id = data.configuration[key].assgmnt_id;
									var assgmnt_mark = data.configuration[key].assgmnt_mark;
									var assgmnt_name = data.configuration[key].assgmnt_name;
									var assgmnt_score_selection = data.configuration[key].assgmnt_score_selection;
									var assgmnt_total = data.configuration[key].assgmnt_total;
									var la_id = data.configuration[key].la_id;									
									var ptid2 = data.configuration[key].pt_id;
									var deletelink = "&nbsp;";
									var disabledInput = "";
									
									if(key>0)
									{
										deletelink = '<a class="deltugasan" href="javascript:void(0)" data-original-title="Delete Tugasan">' +
										'<img src="'+base_url+'assets/img/E_Delete_Sm_N.png" alt="Delete Tugasan" style="height:16px;width:16px;max-width:16px;"' +
										'onclick="fnDelete(\'#trAdd'+key+'\')"></a>';
									}
									else
									{
										disabledInput = 'readonly';
									}
								    
								    row = row+'<tr id="trAdd'+key+'">' +
								    '<td ><input type="hidden" name="tgsid'+key+'" id="tgsid'+key+'" value="'+assgmnt_id+'">'+
								    '<select id="tugasan'+key+'" name="tugasan'+key+'" class="validate[required] span7">' +
								    '<option value="Teori"';
								    if(assgmnt_name=='Teori') row=row+' selected="selected" ';
								    row = row+'>Teori</option>'+
								    '<option value="Amali"';
								    if(assgmnt_name=='Amali') row=row+' selected="selected" ';
								    row = row+'>Amali</option>'+
								    '</select></td>' +
								    '<td ><input type="text" name="peratusan'+key+'" id="peratusan'+key+'" class="validate[required,custom[integer]] inputperatusan span7" value="'+assgmnt_mark+'"/></td>' +	             
								    '<td ><input type="text" name="jmlhtugsan'+key+'" id="jmlhtugsan'+key+'" class="validate[required] span7" '+disabledInput+' value="'+assgmnt_total+'"/></td>'+
								    '<td ><input type="text" name="tugasanterbaik'+key+'" id="tugasanterbaik'+key+'" class="validate[required] span7" '+disabledInput+' value="'+assgmnt_score_selection+'"/></td>'+
								    '<td>'+deletelink+'</td>'+
								    '</tr>';
								    
								    //For sub theory
								    if(assgmnt_name=='Teori')
								    {
								    	var totalPercentages = 0;
								    									    									    	
								    	 row += 
									    	'<tr>'+
									    	'<td>&nbsp;</td>'+
									    	'<td colspan="3">&nbsp;'+
									    	'<table id="tbltask_subTheory" style="margin-bottom:5px;" '+
							        		'class="table table-striped table-bordered table-condensed">'+
							            	'<thead>'+
							                '<tr>'+
							                '<td width="175" ><strong>Tugasan</strong></td>'+
							                '<td width="275" ><strong>Markah Tugasan(<span id="percent2">'+
							                ''+assgmnt_mark+'</span>%)</strong></td>'+
							                '<td>&nbsp;</td>'+
							              	'</tr>'+
							                '</thead>'+
							                '<tbody id="catPentaksiran2">';
								    	 
								    	 
								    	 if(data.configuration[key].sub_theory != null)
								    	 {
								    		 $(data.configuration[key].sub_theory).each(function(index)
						    				 {
								    			var theory_id = data.configuration[key].sub_theory[index].th_id;
								    			var theory_name = data.configuration[key].sub_theory[index].th_sub_name;
								    			var theory_percentages = data.configuration[key].sub_theory[index].th_percentage;
								    			
								    			var deletelink_teori = "&nbsp;";
								    			 
								    			if(index>0)
												{
								    				deletelink_teori = '<a class="deltugasan" href="javascript:void(0)" data-original-title="Delete Tugasan">' +
													'<img src="'+base_url+'assets/img/E_Delete_Sm_N.png" alt="Delete Tugasan" style="height:16px;width:16px;max-width:16px;"' +
													'onclick="fnDelete_theory(\'#trTheory_'+index+'\')"></a>';
								    				
								    				newID++;
												}
								    			 
								    			row +=
							    				 '<tr id="trTheory_'+index+'">'+
							    				 '<td><input type="hidden" name="theory_id[]" id="theory_id_'+index+'" class="theory_id" value="'+theory_id+'">'+
							    				 '<input type="text" name="theory_name[]"'+
							    				 'id="theory_name_'+index+'" class="validate[required] span7" value="'+theory_name+'"/></td>'+
							    				 '<td><input type="text" name="percentage[]"'+
							    				 'id="percentage_'+index+'" class="validate[required,custom[integer]] span7 inputSubTheory" value="'+theory_percentages+'"/></td>'+
							    				 '<td>'+deletelink_teori+'</td>'+
							    				 '</tr>';
						    				 });
								    	 }
								    	 
								    	 
								    	 row +=
							                '</tbody>'+
							                '<tfoot>'+
							                '<tr>'+
							                '<td align="right"><strong>Jumlah :</strong></td>'+
							                '<td align="left"><span id="jumlahMarkahTugasan2">'+
							                '</span>%</td>'+
							                '<td align="center">'+
							                '<button type="button" name="addtaskTheory" id="addtaskTheory" class="btn btn-info" data-original-title="Tambah Tugasan">'+
							                '<i class="icon-plus icon-white"></i>'+
							                '</button>'+
							                '</td>'+
							              	'</tr>'+
							              	'</tfoot>'+         
							              	'</table>'+
									    	'</td>'+
									    	'<td>&nbsp;</td>'+
									    	'</tr>';
								    }
								   
								    
								    /*
								    // kalau nak compare lowercase
								    
								    row = row+'<tr id="trAdd'+key+'">' +
								    '<td ><input type="hidden" name="tgsid'+key+'" id="tgsid'+key+'" value="'+assgmnt_id+'">'+
								    '<select id="tugasan'+key+'" name="tugasan'+key+'" class="validate[required] span7">' +
								    '<option value="Teori"';
								    if(assgmnt_name.toLowerCase()=='teori') row=row+' selected="selected" ';
								    row = row+'>Teori</option>'+
								    '<option value="Amali"';
								    if(assgmnt_name.toLowerCase()=='amali') row=row+' selected="selected" ';
								    row = row+'>Amali</option>'+
								    '</select></td>' +
								    '<td ><input type="text" name="peratusan'+key+'" id="peratusan'+key+'" class="validate[required,custom[integer]] inputperatusan span7" value="'+assgmnt_mark+'"/></td>' +	             
								    '<td ><input type="text" name="jmlhtugsan'+key+'" id="jmlhtugsan'+key+'" class="validate[required] span7" value="'+assgmnt_total+'"/></td>'+
								    '<td ><input type="text" name="tugasanterbaik'+key+'" id="tugasanterbaik'+key+'" class="validate[required] span7" value="'+assgmnt_score_selection+'"/></td>'+
								    '<td>'+deletelink+'</td>'+
								    '</tr>';*/
								}
								//alert(newID);
								
							}
							
							ptid = ptid2;
							butangadd = 1;
						}
						else
						{
							row = '<tr>' +
							'<td ><input type="hidden" name="tgsid0" id="tgsid0" value="">'+
							'<select id="tugasan0" name="tugasan0" class="validate[required] span7">' +
							'<option value="Teori">Teori</option>'+
							'<option value="Amali">Amali</option>'+
							'</select></td>'+
							'<td ><input type="text" name="peratusan0" '+
							'id="peratusan0" class="validate[required,custom[integer]] inputperatusan span7" value="'+data.weightage.pt_teori+'"/></td>' +			             	
							'<td ><input type="text" name="jmlhtugsan0" '+
							'id="jmlhtugsan0" class="validate[required] span7" readonly value="1"/></td>'+
							'<td ><input type="text" name="tugasanterbaik0" '+
							'id="tugasanterbaik0" class="validate[required] span7" readonly value="1"/></td>'+
							'<td>&nbsp;</td>'+
							'</tr>';
							
							row += 
						    	'<tr>'+
						    	'<td>&nbsp;</td>'+
						    	'<td colspan="3">&nbsp;'+
						    	'<table id="tbltask_subTheory" style="margin-bottom:5px;" '+
				        		'class="table table-striped table-bordered table-condensed">'+
				            	'<thead>'+
				                '<tr>'+
				                '<td width="175" ><strong>Tugasan</strong></td>'+
				                '<td width="275" ><strong>Markah Tugasan(<span id="percent2">'+
				                ''+data.weightage.pt_teori+'</span>%)</strong></td>'+
				                '<td>&nbsp;</td>'+
				              	'</tr>'+
				                '</thead>'+
				                '<tbody id="catPentaksiran2">';
							
							row +=
			    				 '<tr id="trTheory_'+newID+'">'+
			    				 '<td><input type="hidden" name="theory_id[]" id="theory_id_'+newID+'" class="theory_id" value="0">'+
			    				 '<input type="text" name="theory_name[]"'+
			    				 'id="theory_name_'+newID+'" class="validate[required] span7" value=""/></td>'+
			    				 '<td><input type="text" name="percentage[]"'+
			    				 'id="percentage_'+newID+'" class="validate[required,custom[integer]] span7 inputSubTheory" value=""/></td>'+
			    				 '<td>&nbsp;</td>'+
			    				 '</tr>';
							
							 row +=
				                '</tbody>'+
				                '<tfoot>'+
				                '<tr>'+
				                '<td align="right"><strong>Jumlah :</strong></td>'+
				                '<td align="left"><span id="jumlahMarkahTugasan2">'+
				                '</span>%</td>'+
				                '<td align="center">'+
				                '<button type="button" name="addtaskTheory" id="addtaskTheory" class="btn btn-info" data-original-title="Tambah Tugasan">'+
				                '<i class="icon-plus icon-white"></i>'+
				                '</button>'+
				                '</td>'+
				              	'</tr>'+
				              	'</tfoot>'+         
				              	'</table>'+
						    	'</td>'+
						    	'<td>&nbsp;</td>'+
						    	'</tr>';
							 
							 newID++;
							
							ptid = data.weightage.pt_id;							
						}
						
						$('#catPentaksiran').html(row);	
						
						//To initiate for sub theory
						sub_theory_jquery();
						
						$('#tambahTugasan')
						.html('<button type="button" name="addtask" id="addtask" class="btn btn-info">Tambah Tugasan</button>'
						);
		
						if(1 == butangadd)
						{
							$("#addtask").attr("disabled", "disabled");
						}						
						
						$(".txttugasan").autocomplete(autoCompleteTask);
						$("#formConfig").validationEngine('attach');
						
						$('#myModal').modal({
							keyboard: false,
							backdrop: 'static'
						});
		
						var autoSuggestion = document.getElementsByClassName('ui-autocomplete');
						
						if(autoSuggestion.length > 0)
						{
							autoSuggestion[0].style.zIndex = 1051;
						}						

						$("#kursusid").val($('#slct_kursus').val());
						$("#subjectid").val(sb_id);
						$("#semesterP").val($('#slct_tahun').val());
						$("#pentaksiran").val(pentaksiran);
						$("#mptID").val(ptid);
						
						$('#tempKAt2').val(sb_cat); //temp buang lepas wujud fucntion AK
						
						calculatePercent();
						
					    calculatePercentTheory();
				    	
						
					}	
					else
					{
						var mssg = new Array();
						mssg['heading'] = 'Message';
						mssg['content'] = 'Weightage null, sila hubungi lembaga peperiksaan';

						kv_alert(mssg);
					}
					
				});
	
				request.fail(function(jqXHR, textStatus)
				{
					var mssg = new Array();
					mssg['heading'] = 'Message';
					mssg['content'] = 'Request failed: ' + textStatus;

					kv_alert(mssg);
					
					//alert( "Request failed: " + textStatus );
				});
			}
			else
			{
				//nak dapatkan percent bagi subjek AK yg ada lebih 1 paper
				var request = $.ajax({
					url: site_url+"/examination/marking_v2/get_ak_swb",
					type: "POST",
					data: {pntksrn : pentaksiran, cmID : cm_id, type : sb_cat},
					dataType: "json"
				});
				
				request.done(function(data)
				{
					//console.log(data);
					
					$('#katTugasan').html("Kertas - Pusat");
					$('#ksmid2').val(cm_id);
					
					if(null != data.weightage)
					{
						$('#percent').html(data.weightage[0].mod_mark_centre);
						//$('#semesterP').val(data.weightage.cm_semester);
						
						if(null != data.configuration)
						{
							var row = "";
							for (var key in data.configuration)
							{
								if (data.configuration.hasOwnProperty(key))
								{
									var assgmnt_id = data.configuration[key].assgmnt_id;
									var assgmnt_mark = data.configuration[key].assgmnt_mark;
									var assgmnt_name = data.configuration[key].assgmnt_name;
									var assgmnt_score_selection = data.configuration[key].assgmnt_score_selection;
									var assgmnt_total = data.configuration[key].assgmnt_total;
									var la_id = data.configuration[key].la_id;									
									var ptid2 = data.configuration[key].ppr_id;
									
									row = row+'<tr >' +
									'<td ><input type="hidden" name="tgsid'+key+'" id="tgsid'+key+'" value="'+assgmnt_id+'">'+
									'<input type="text" name="tugasan'+key+'" id="tugasan'+key+'" class="span7" readonly="readonly" value="'+assgmnt_name+'"/></td>' +
									'<td ><input type="text" name="peratusan'+key+'" id="peratusan'+key+'" class="span7" readonly="readonly" value="'+assgmnt_mark+'"/></td>' +			             	
									'<td ><input type="text" name="jmlhtugsan'+key+'" id="jmlhtugsan'+key+'" class="validate[required] span7" readonly="readonly" value="'+assgmnt_total+'"/></td>'+
									'<td ><input type="text" name="tugasanterbaik'+key+'" id="tugasanterbaik'+key+'" class="validate[required] span7" readonly="readonly" value="'+assgmnt_score_selection+'"/></td>'+
									'<td>&nbsp;</td>'+
									'</tr>';
								}
							}
							
							ptid = ptid2;
							
							$('#catPentaksiran').html(row);							
						}
						else
						{
							var row = "";
							for (var key in data.weightage)
							{
								if (data.weightage.hasOwnProperty(key))
								{
									var modPaper = data.weightage[key].mod_paper;
									var pprPercentage = data.weightage[key].ppr_percentage;
									var pprid = data.weightage[key].ppr_id;
									
									row = row+'<tr >' +
									'<td >'+
									'<input type="text" name="tugasan'+key+'" id="tugasan'+key+'" class="span7" readonly="readonly" value="'+modPaper+'"/></td>' +
									'<td ><input type="text" name="peratusan'+key+'" id="peratusan'+key+'" class="span7" readonly="readonly" value="'+pprPercentage+'"/></td>' +			             	
									'<td ><input type="text" name="jmlhtugsan'+key+'" id="jmlhtugsan'+key+'" class="validate[required] span7" readonly="readonly" value="1"/></td>'+
									'<td ><input type="text" name="tugasanterbaik'+key+'" id="tugasanterbaik'+key+'" class="validate[required] span7" readonly="readonly" value="1"/></td>'+
									'<td>&nbsp;</td>'+
									'</tr>';
								}
							}
							
							ptid = pprid;
							$('#catPentaksiran').html(row);
							
						}
						
						$("#kursusid").val($('#slct_kursus').val());
						$("#subjectid").val(sb_id);
						$("#semesterP").val($('#slct_tahun').val());
						$("#pentaksiran").val(pentaksiran);
						$("#mptID").val(ptid);						
						$('#tempKAt2').val(sb_cat); //temp buang lepas wujud fucntion AK
												
						$('#myModal').modal({
							keyboard: false,
							backdrop: 'static'						
						});			
					}	
					else
					{
						var mssg = new Array();
						mssg['heading'] = 'Pemberitahuan';
						mssg['content'] = 'Weightage null, sila hubungi lembaga peperiksaan';

						kv_alert(mssg);
					}
				});
					
				request.fail(function(jqXHR, textStatus)
				{
					var mssg = new Array();
					mssg['heading'] = 'Message';
					mssg['content'] = 'Request failed: ' + textStatus;

					kv_alert(mssg);
				});
			}
		}
		else
		{
			//console.log(data); //kalau tarikh xbuka keluarkan alert kata tarikh xbuka lagi
			var mssg = new Array();
			mssg['heading'] = 'Message';
			mssg['content'] = 'Tarikh masuk markah tak buka lagi';

			kv_alert(mssg);
		}		
	});

	$('#formConfig').on('click', '#addtask', function() 
	{
		var newID = 1;		
		
		$('#tbltask > tbody:last')
		.append('<tr id="trAdd'+newID+'">' +
				'<td ><input type="hidden" name="tgsid'+newID+'" id="tgsid'+newID+'" value="">'+
				'<select name="tugasan'+newID+'" id="tugasan'+newID+'" class="validate[required] span7">'+
				'<option value="Teori">Teori</option>'+
				'<option value="Amali" selected="selected">Amali</option>'+
				'</select></td>'+
				'<td ><input type="text" name="peratusan'+newID+'" id="peratusan'+newID+'" class="validate[required,custom[integer]] inputperatusan span7"/></td>' +
				'<td ><input type="text" name="jmlhtugsan'+newID+'" id="jmlhtugsan'+newID+'" class="validate[required] span7"/></td>' +
				'<td ><input type="text" name="tugasanterbaik'+newID+'" id="tugasanterbaik'+newID+'" class="validate[required] span7"/></td>' +
				'<td><a class="deltugasan" href="javascript:void(0)" data-original-title="Delete Tugasan">' +
				'<img src="'+base_url+'assets/img/E_Delete_Sm_N.png" alt="Delete Tugasan" style="height:16px;width:16px;max-width:16px;"' +
				'onclick="fnDelete(\'#trAdd'+newID+'\')"></a></td>' +
				'</tr>'
		);

		$(".txttugasan").autocomplete(autoCompleteTask);
		$("#formConfig").validationEngine('attach');
		
		if($('.jumlahMarkahTugasanformError')[0])
			$("#jumlahMarkahTugasan").validationEngine("hide");

		var autoSuggestion = document.getElementsByClassName('ui-autocomplete');
		if(autoSuggestion.length > 0)
		{
			autoSuggestion[newID].style.zIndex = 1051;
		}

		$("#addtask").attr("disabled", "disabled");

	});

	$('#tblAssgnMarks').on('change','.cellMarks',function(event)
	{
		//get and reset value for this cell
		var v = $(this).val();
		if(v  == 0 && v < 1)												 
		{
			v = 1;
			$(this).val(v);
		}
		//else
		//{*/
		//if( !$(this).validationEngine('validate'))
		//{
		//append to the modified
		
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
			
			//$('#btnSaveAssgMarks').removeAttr("disabled");
		}
		else if(v > 101)
		{			
			$('#'+$(this).attr('id')).validationEngine('showPrompt', '*Sila Pastikan Jumlah Markah Tidak Melebihi 100%', 'err', 'topLeft', true);
			$(this).parent().css('background-color', 'red');
			//$('#btnSaveAssgMarks').attr("disabled", "disabled");
		}
		else if("T" != v && "t" != v)
		{
			$('#'+$(this).attr('id')).validationEngine('showPrompt', 'Anda Dibenarkan menggunakan Huruf T sahaja', 'err', 'topLeft', true);
			$(this).parent().css('background-color', 'red');
			$('#btnSaveAssgMarks').attr("disabled", "disabled");
		}		
		
		markschanged.push($(this).attr('id'));

		var mark_assg_selection = parseInt($('#mark_assg_selection').val());
		var mark_total_assg = parseInt($('#mark_total_assg').val());
		var marks = new Array();

		$(this).parent().parent().find('input.cellMarks').each(function(i,obj){

			if(!isNaN($(this).val()))
			{
				if($(this).val() == 0 && $(this).val() < 1)
				{
					marks[i] = {id : $(this).parent().parent().attr('id') ,val : 1.00};
				}
				else
				{
					marks[i] = {id : $(this).parent().attr('id') ,val : $(this).val()};
				}				
			}
			else if($(this).val() == "T" || $(this).val() == "t")
			{
				//alert($(this).val());
				$(this).val($(this).val().toUpperCase());
				
				var classrow = $(this).parent().parent().attr("class");
				
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
		
		for(i=0; i<mark_assg_selection; i++)
		{
			if(marks[i].val*1 == "-99.99")
			{
				//alert(marks[i].val*1 +"b9");
				sum = sum+(0*1);
				avgCal += marks[i].val*1;
			}
			else
			{
				//alert(marks[i].val*1 +"b0");
				sum = sum+(marks[i].val*1);
			}			
		}

		if(avgCal/mark_assg_selection != -99.99)
		{
			var markahs = (sum/mark_assg_selection)/100 * mark_total_assg;
			
			if(markahs <= mark_total_assg)
			{
				$(this).parent().parent().find('.jum_markah')
				.val(Math.ceil(new Number(markahs).toFixed(2)))
				.validationEngine('hide');
				
				$('#btnSaveAssgMarks').removeAttr("disabled");
			}
			else if(markahs > mark_total_assg)
			{
				$(this).parent().parent().find('.jum_markah')
				.val(Math.ceil(new Number(markahs).toFixed(2)))
				.validationEngine('showPrompt', '*Sila Pastikan Jumlah Markah Tidak Melebihi '+mark_total_assg+'%', 'err', 'topLeft', true);
							
				$('#btnSaveAssgMarks').attr("disabled", "disabled");
			}
		}
		else
		{
			$(this).parent().parent().find('.jum_markah').val('T');
		}
	});

	$('#formAssgMark').on('click', '#btnSaveAssgMarks', function() 
	{
		//console.log(markschanged);
		if($('#btnSaveAssgMarks').is(':disabled'))
		{
			 return false;
		}
		
		$("#mark_assg_selection").val();
		$("#mark_total_assg").val();
		$("#semesterP4").val();
		$("#mptID4").val();
		$("#category").val();

		$("#assgmnpop").scrollTop(0);
		$('#assgmnpop').css('overflow','hidden');
		$('#assgmnpop').block({ 
			message: '<h5><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h5>', 
			css: { border: '3px solid #660a30' } 
		});

		setTimeout(function()
		{
			if(markschanged.length>0)
			{
				var changedID = $.unique(markschanged);
				
				var cmid = $("#mptID4").val();
				var semester = $("#semesterP4").val();
				var category = $("#category").val();
				
				var params = "pentaksiran="+pentaksiran+'&cmid='+cmid+'&sem='+semester+'&cat='+category;
				
				for(i=0; i<changedID.length;i++)
				{
					//if(i!=0)
						params+='&';

					params+=changedID[i]+'='+$('#'+changedID[i]).val();
				}

				//alert(params);

				//ajax submit the values
				var request = $.ajax({
					url: base_url+"index.php/examination/markings/save_assignment",
					type: "POST",
					data: params,
					dataType: "html"
				});

				request.done(function(data)
				{
					//alert(data);
					
					$('#tblAssgnMarks > tbody  > tr').each(function() {
						var id = "#"+$(this).attr("id");
						var row = $('#tblStudent').find(id);
						//console.log(row);
						var marks = $(this).find('.jum_markah').val();
						row.val(marks);
					});
					
					$('#tblStudent > tbody  > tr').each(function()
					{
						var ttl = 0.00;
						var index = 0;
						var count = 0;
						
						$(this).find("input").each(function()
						{								
							var ma = $(this).val();
							
							if(ma=='T')
							{
								count++;
							}
							
							index++;
							
							ttl += (isNaN(ma) ? 0.00 : ma*1) ;
						});
						
						if(index!=count)
							$(this).find(".ttlmrks").html(Math.ceil(new Number(ttl).toFixed(2)));
						else
							$(this).find(".ttlmrks").html('T');
					});

					markschanged = new Array();

					$('#assgmnpop').unblock();
					$('#assgmnpop').modal('hide');
											
					var mssg = new Array();
					mssg['heading'] = 'Berjaya';
					mssg['content'] = 'Markah pelajar Berjaya dikemasini.';

					kv_alert(mssg);

				});

				request.fail(function(jqXHR, textStatus)
				{
					$('#assgmnpop').unblock();
					
					var mssg = new Array();
					mssg['heading'] = 'Message';
					mssg['content'] = 'Markah pelajar TIDAK Berjaya dikemasini.';

					kv_alert(mssg);				
				});
			}
			else
			{
				$('#assgmnpop').unblock();
				$('#assgmnpop').modal('hide');
				
				var mssg = new Array();
				mssg['heading'] = 'Markah tidak disimpan';
				mssg['content'] = 'Markah tidak dikemaskini ke pangkalan data kerana tiada perubahan markah pelajar';

				kv_alert(mssg);	
			}

		}, 1500);

		return false;
	});
	
	$('#slct_jubject').change(function()
	{	
		if($('#slct_jubject').val().length > 0)
		{
			var semester = $('#slct_tahun').val();
			var slct_sbj 	= $('#slct_jubject').val().split(":");
	
			var sb_id		= slct_sbj[0];
			var sb_cat 		= slct_sbj[1];
			var cm_id		= slct_sbj[2];
			
			var pentaksiran = "S"; // S = Sekolah
			var ptid = "";
			
			//console.log(sb_cat);
			
			if("AK" == sb_cat)
			{				
				$('#btn_config_markP').attr("disabled", "disabled");
				$('#spanTitle').html('Akademik');
			}
			else if("VK" == sb_cat)
			{
				$('#btn_config_markP').removeAttr("disabled");
				$('#spanTitle').html('Vokasional');
			}
			
			var request = $.ajax({
				url: site_url+"/examination/markings_v2/get_ak_swb",
				type: "POST",
				data: {pntksrn : pentaksiran, cmID : cm_id, type : sb_cat},
				dataType: "json"
			});
			
			request.done(function(data)
			{
				//console.log(data);					
				
				if(null != data.weightage)
				{	
					var row = "";
					
					if(null != data.configuration) //dah penah buat configuration mark
					{					
						for (var key in data.configuration)
						{
							if (data.configuration.hasOwnProperty(key))
							{
								var assgmnt_id = data.configuration[key].assgmnt_id;
								var assgmnt_mark = data.configuration[key].assgmnt_mark;
								var assgmnt_name = data.configuration[key].assgmnt_name;
								var assgmnt_score_selection = data.configuration[key].assgmnt_score_selection;
								var assgmnt_total = data.configuration[key].assgmnt_total;
								var la_id = data.configuration[key].la_id;
								if("AK" == sb_cat)
								{
									var ptid2 = data.configuration[key].ppr_id;
								}
								else if("VK" == sb_cat)
								{
									var ptid2 = data.configuration[key].pt_id;
								}						
								
								row = row+'<tr >' +
								'<td ><input type="hidden" name="tgsid'+key+'" id="tgsid'+key+'" value="'+assgmnt_id+'">'+
								'<input type="text" name="tugasan'+key+'" id="tugasan'+key+'" class="span7" readonly="readonly" value="'+assgmnt_name+'"/></td>' +
								'<td ><input type="text" name="peratusan'+key+'" id="peratusan'+key+'" class="span7" readonly="readonly" value="'+assgmnt_mark+'"/></td>' +			             	
								'<td ><input type="text" name="jmlhtugsan'+key+'" id="jmlhtugsan'+key+'" class="validate[required] span7" readonly="readonly" value="'+assgmnt_total+'"/></td>'+
								'<td ><input type="text" name="tugasanterbaik'+key+'" id="tugasanterbaik'+key+'" class="validate[required] span7" readonly="readonly" value="'+assgmnt_score_selection+'"/></td>'+
								'<td>&nbsp;</td>'+
								'</tr>';
							}
						}
						
						ptid = ptid2;					
						$('#catPentaksiran').html(row);
						
						submitsomeform(ptid);
					}
					else //belum penah buat configuration mark
					{
						for (var key in data.weightage)
						{
							if (data.weightage.hasOwnProperty(key))
							{
								var modPaper = data.weightage[key].mod_paper;
								var pprPercentage = data.weightage[key].ppr_percentage;
								if("AK" == sb_cat)
								{
									var pprid = data.weightage[key].ppr_id;
								}
								else if("VK" == sb_cat)
								{
									var pprid = data.weightage[key].pt_id;
								}
								
								row = row+'<tr >' +
								'<td >'+
								'<input type="text" name="tugasan'+key+'" id="tugasan'+key+'" class="span7" readonly="readonly" value="'+modPaper+'"/></td>' +
								'<td ><input type="text" name="peratusan'+key+'" id="peratusan'+key+'" class="span7" readonly="readonly" value="'+pprPercentage+'"/></td>' +			             	
								'<td ><input type="text" name="jmlhtugsan'+key+'" id="jmlhtugsan'+key+'" class="validate[required] span7" readonly="readonly" value="1"/></td>'+
								'<td ><input type="text" name="tugasanterbaik'+key+'" id="tugasanterbaik'+key+'" class="validate[required] span7" readonly="readonly" value="1"/></td>'+
								'<td>&nbsp;</td>'+
								'</tr>';
							}
						}
						
						ptid = pprid;
						$('#catPentaksiran').html(row);
						
						if("VK" == sb_cat)
						{
							var mssg = new Array();
							mssg['heading'] = 'Pemberitahuan!';
							mssg['content'] = 'Penetapan Markah Belum dibuat';
							mssg['callback'] = function()
							{
								submitsomeform(ptid);
							}
							kv_alert(mssg);
						}
						else
						{
							submitsomeform(ptid);
						}
					}
				}	
				else
				{
					var mssg = new Array();
					mssg['heading'] = 'Pemberitahuan!';
					mssg['content'] = 'Weightage NULL, sila hubungi lembaga peperiksaan';

					kv_alert(mssg);
				}					
			});
			
			request.fail(function(jqXHR, textStatus)
			{
				var mssg = new Array();
				mssg['heading'] = 'Message';
				mssg['content'] = 'Request failed: ' + textStatus;

				kv_alert(mssg);
			});
		}
	});
	
	$('#btn_save_mark').click(function()
	{
		var mssg = new Array();
		mssg['heading'] = 'Message';
		mssg['content'] = 'Markah Pentaksiran Berterusan Berjaya disimpan';

		kv_alert(mssg);
	});
	
	$('#assgmnpop').on('shown.bs.modal', function ()
	{
		 $('#tblAssgnMarks').dataTable().fnAdjustColumnSizing(false);
	});

});//end of document.ready
/**************************************************************************************************
 * End of marking.js
 **************************************************************************************************/