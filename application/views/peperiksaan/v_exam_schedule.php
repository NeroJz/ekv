<script type="text/javascript">




	/**********************************************************************************************
	* Description		: this function
	* input				: data
	* author			: Freddy Ajang Tony
	* Date				: 16 October 2013
	* Modification Log	: -
	**********************************************************************************************/
    function show()
    {    	
        var cid = document.form1.course_id.value;
        var session = document.form1.sesi.value;
        session = session.replace(" ","_");
        session = session.replace("/","-");
        var url = '<?php echo site_url('examination/exam_schedule/subject_list');?>/'+cid+'/'+session;
        
        $.ajax({
        url: url,
        type:'POST',
        dataType: 'json',
        success: function(data){
        	//document.form1.selectto.options.length=0;
        	$('#select-to').html("");
            document.form1.subject.options.length=0;
            //$('#subject').html("");
            document.form1.subject.options[0] = new Option('-','',false,false);
            if(data != null){
            	//console.log(data);
                for(var i = 0; i < data.length; i++){
                    document.form1.subject.options[i+1] = new Option(data[i].subject_code+' - '+data[i].subject_name,data[i].subject_id,false,false);
                } // End of success function of ajax form
            }
        }
            
        }); // End of ajax call         
    }


    /**********************************************************************************************
	* Description		: this function to populate schedule data
	* input				: data
	* author			: Freddy Ajang Tony
	* Date				: 16 October 2013
	* Modification Log	: -
	**********************************************************************************************/
	function showLecturer()
	{		
        var subjectids = document.form1.subject.value;
        var courseids = document.form1.course_id.value;
        var sessions = document.form1.sesi.value;
        sessions = sessions.replace(" ","_");
        sessions = sessions.replace("/","-");
        var url2 = '<?php echo site_url('academic/get_lecturer');?>/'+courseids+'/'+subjectids+'/'+sessions;
        
        $.ajax({
        url: url2,
        type:'POST',
        dataType: 'json',
        success: function(data){
        	//document.form1.selectto.options.length=0;
        	$('#select-to').html("");
            document.form1.ssg_id.options.length=0;
            //$('#subject').html("");
            document.form1.ssg_id.options[0] = new Option('-','',false,false);
            if(data != null){
            	//console.log(data);
                for(var i = 0; i < data.length; i++){
                    document.form1.ssg_id.options[i+1] = new Option(data[i].staff_name+' (Kumpulan '+data[i].level_group_no+')',data[i].staff_subject_group_id,false,false);
                } // End of success function of ajax form
            }
        }
            
        }); // End of ajax call
        
        
        
    }


	/**********************************************************************************************
	* Description		: this function to populate schedule data
	* input				: data
	* author			: Freddy Ajang Tony
	* Date				: 16 October 2013
	* Modification Log	: -
	**********************************************************************************************/
	function populate_exam_schedule()
    {	

		
		//we need to 'clear' the datatable object coz we are going to re-create 
		var ex = document.getElementById('tbl_exam_schedule');
		if ( $.fn.DataTable.fnIsDataTable( ex ) ) {
			oTable.fnClearTable();
		}
		
		$('#tbl_exam_schedule > tbody').html("");
		$('#tbl_exam_schedule > tbody').html('<tr><td colspan="5"><center><img src="'+base_url+
				'assets/img/loading_ajax.gif" alt="Sedang process"/> Sila tunggu...</center></td>');

		setTimeout(function()
		{
			var request = $.ajax({
				url: site_url+"examination/exam_schedule/get_exam_schedule",
				type: "POST",
				dataType: "json"
				});
			
			request.done(function(data) {
				//alert("Berjaya");
				//alert(msg);
				//console.log(data);
				
				if(data != null && data.exam_schedule.length > 0)
				{
					var tbl_row = '';
					$(data.exam_schedule).each(function(index){

						var schedule_date = convert_timestamp(data.exam_schedule[index].schedule_date);
						var day_in_malay = getDayInMalay(schedule_date);
						var time_start = convert_time(data.exam_schedule[index].schedule_time_start);
						var time_end = convert_time(data.exam_schedule[index].schedule_time_end);
						var mod_name = toTitleCase(data.exam_schedule[index].mod_name);
						var mod_paper = data.exam_schedule[index].mod_paper;
						var course_name = toTitleCase(data.exam_schedule[index].cou_name);
						var schedule_id = data.exam_schedule[index].schedule_id;
						var time_start_malay = "";
						var time_end_malay = "";
						//$( "" ).replaceWith( "AM" );
						if(time_start.slice(-2) == "AM")
						{
							time_start_malay = time_start.replace("AM","pagi");
						}
						else if(time_start.slice(-2) == "PM")
						{
							time_start_malay = time_start.replace("PM","petang");
						}else
						{
							time_start_malay = time_start.replace("TG","tengahari");
							time_start = time_start.replace("TG","PM");
						}

						
						//$( "" ).replaceWith( "AM" );
						if(time_end.slice(-2) == "AM")
						{
							time_end_malay = time_end.replace("AM","pagi");
						}
						else if(time_end.slice(-2) == "PM")
						{
							time_end_malay = time_end.replace("PM","petang");
						}else
						{
							time_end_malay = time_end.replace("TG","tengahari");
							time_end = time_end.replace("TG","PM");
						}

					
						
						
						tbl_row +=
							'<tr>'+
							'<td id="td_date_time">'+schedule_date+
							'&nbsp;('+day_in_malay+')'+
							'<br/>'+time_start_malay+
							'<span>&nbsp;-&nbsp;</span>'+time_end_malay+
							'<input type="hidden" id="date" name="date" value="'+schedule_date.replace(/\//g,"-")+'" />'+
							'<input type="hidden" id="time_start" name="time_start" value="'+time_start+'" />'+
							'<input type="hidden" id="time_end" name="time_end" value="'+time_end+'" />'+
							'</td>'+
							'<td style="vertical-align: middle;" id="td_mod_name">'+mod_name+'</td>'+
							'<td style="vertical-align: middle;" id="td_mod_paper">'+mod_paper+'</td>'+
							'<td style="vertical-align: middle;">'+course_name+'</td>'+
							'<td style="vertical-align: middle;"><center>'+
							'<a name="btn_edit_popup" id="btn_edit_popup"'+
							'class="btn btn_edit_popup btn-info" value="'+schedule_id+'"><i class="icon-edit icon-white"></i>Kemaskini</a>&nbsp;'+
							'<a class="btn btn_delete" name="btn_delete" id="btn_delete" value="'+
							+schedule_id+'"><i class="icon-trash"></i>Padam</a></center></td>'+
							'</tr>';
					});
					
				}
				else
				{
					var tbl_row =
						'<thead>'+
						'</thead>'+
						'<tbody>'+
						'</tbody>';
				}
				
				$('#tbl_exam_schedule > tbody').html(tbl_row);
				initiate_edit_delete();

		
				oTable = $("#tbl_exam_schedule").dataTable({
					"aoColumnDefs" : [{bSortable : false,aTargets : [0,4]}],
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
									"sInfoEmpty": "Papar 0 - 0 dari 0 rekod",
									"sEmptyTable": "Tiada Jadual Peperiksaan",
								    "oPaginate": {
								      "sFirst": "Pertama",
								      "sLast": "Akhir",
								      "sNext": "Seterus",
								      "sPrevious": "Sebelum"
								     }
								 },
					"bDestroy" : true,
				 
				});

				
			});
			
			request.fail(function(jqXHR, textStatus) {
				//alert("Gagal");
				//Do nothing
			});
		}, 1500);
    }


	/**************************************************************************************************
	* Description		: this function to initiate edit and delete
	* input				: 
	* author			: Freddy Ajang Tony
	* Date				: 17 October 2013
	* Modification Log	: -
	**************************************************************************************************/
	function initiate_edit_delete()
	{
		//For delete schedule
		$('.btn_delete').click(function(){

			var sche_id = $(this).attr('value');
			
			var opts = new Array();
			opts['heading'] = 'Padam Jadual';
			opts['question'] = 'Anda Pasti Untuk Memadam Jadual?';
			opts['hidecallback'] = true;
			opts['callback'] = function()
			{
				 var request = $.ajax({
						url: site_url+"examination/exam_schedule/delete_schedule",
						type: "POST",
						data: {	schedule_id : sche_id},
						dataType: "html"
					});
		
				request.done(function(data) {
					//alert(data);
					var opts = new Array();
					opts['heading'] = 'Berjaya';
					opts['content'] = 'Jadual berjaya dipadam';
					kv_alert(opts);
					populate_exam_schedule();

				});
	
				request.fail(function(jqXHR, textStatus) {
					var opts = new Array();
					opts['heading'] = 'Tidak Berjaya';
					opts['content'] = 'Jadual tidak berjaya dipadam';
					kv_alert(opts);
				});
			};

			opts['cancelCallback'] = function(){/*do nothing*/};
			kv_confirm(opts);
		});


		$(".btn_edit_popup").bind("click", function() {
			
			var schedule_id = $(this).attr('value');

			var modal_date = $(this).parent().parent().parent().find('#td_date_time').find('#date').val();
			var modal_time_start = $(this).parent().parent().parent().find('#td_date_time').find('#time_start').val();
			var modal_time_end = $(this).parent().parent().parent().find('#td_date_time').find('#time_end').val();
			var modal_name = $(this).parent().parent().parent().find('#td_mod_name').html();

			$('#mod_modul_name').html(modal_name);
			$('#schedule_date_modal').val(modal_date);
			$('#schedule_time_start_modal').val(modal_time_start);
			$('#schedule_time_end_modal').val(modal_time_end);
			$('#schedule_id').val(schedule_id);

			$("#formEdit").validationEngine();
			
			$('#myModal_edit').modal({
				keyboard : false,
				backdrop : 'static'
			});

			//fnRowSpan2($("#tbl_exam_schedule tbody tr > :nth-child(4)"), true);
			//jAjaxLm("#span_result2",site_url + "examination/exam_schedule/edit_exam_schedule/" + schedule_id,'');
		});

		
	}
    

	/**********************************************************************************************
	* Description		: this function to convert timestamp to normal date
	* input				: timestamp
	* author			: Freddy Ajang Tony
	* Date				: 17 October 2013
	* Modification Log	: -
	**********************************************************************************************/
	function convert_timestamp(t)
	{
		var dateObj = new Date(t*1000);
		var year = dateObj.getFullYear();
		var month = dateObj.getMonth();
		var date = dateObj.getDate();
		var fullDate;
		month++;
		
		// Format value as two digits 0 => 00, 1 => 01
		if(date < 10){
			date = '0'+date;
		}
		
		// Format value as two digits 0 => 00, 1 => 01
		if(month < 10){
			month = '0'+month;
		}
			
		return date+'/'+month+'/'+year;
	}


	/**********************************************************************************************
	* Description		: this function to get day in malay
	* input				: date
	* author			: Freddy Ajang Tony
	* Date				: 17 October 2013
	* Modification Log	: -
	**********************************************************************************************/
	function getDayInMalay(s)
	{
		// change to dd-mm-yyyy
		var date = s.split('/').join('-');
		
		// Change the format dd-mm-yy to mm-dd-yy for getDay
		var datepick = new Date(date.replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"));
		
		//get day from date 0-Sunday,1-Monday,2-Tuesday,3-Wednesday,4-Thursday,5-Friday,6-Saturday
		var day = datepick.getDay();

		if(day == 0)
            day = 'Ahad';
        else if(day == 1)
            day = 'Isnin';
        else if(day == 2)
            day = 'Selasa';
        else if(day == 3)
            day = 'Rabu';
        else if(day == 4)
            day = 'Khamis';
        else if(day == 5)
            day = 'Jumaat';
        else if(day == 6)
            day = 'Sabtu';
        
        return day;
	}


	/**********************************************************************************************
	* Description		: this function to convert time
	* input				: date
	* author			: Freddy Ajang Tony
	* Date				: 17 October 2013
	* Modification Log	: -
	**********************************************************************************************/
	function convert_time(time)
	{
		var hour = time.substring(0,2);
		var minute = time.substring(2);
		var am_pm = "";

		if(hour >= 13 && hour <= 23)
		{
			am_pm = "PM";

			if(hour == 13)
				hour = 1;
			else if(hour == 14)
				hour = 2;
			else if(hour == 15)
				hour = 3;
			else if(hour == 16)
				hour = 4;
			else if(hour == 17)
				hour = 5;
			else if(hour == 18)
				hour = 6;
			else if(hour == 19)
				hour = 7;
			else if(hour == 20)
				hour = 8;
			else if(hour == 21)
				hour = 9;
			else if(hour == 22)
				hour = 10;
			else if(hour == 23)
				hour = 11;
		}
		else if(hour == 12)
		{
			am_pm = "TG";
		}
		else if(hour == 24)
		{
			hour = 12;
			am_pm = "AM";
		}
		else
		{
			am_pm = "AM";

			if((hour == 01)||(hour == 02)||(hour == 03)||(hour == 04)||(hour == 05)||
					(hour == 06)||(hour == 07)||(hour == 08)||(hour == 09))
			{
				hour = hour.substring(1);
			} 
		}

		return hour+':'+minute+' '+am_pm;
	}


	/**************************************************************************************************
	* Description 		: this function will change string to title case
	* input				: str 
	* author			: Freddy Ajang Tony
	* Date				: 18/10/2013
	* Modification Log	:  -
	**************************************************************************************************/
	function toTitleCase(str)
	{
	    return str.replace(/\w\S*/g, function(txt){
	    	return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
	    	});
	}

    
</script>

<script type="text/javascript">
 
$(document).ready(function() {
		
		$("#form1").validationEngine();

		
		
		
		oTable = $("#tbl_exam_schedule").dataTable({
			"aoColumnDefs" : [{bSortable : false,aTargets : [0,4]}],
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
							"sInfoEmpty": "Papar 0 - 0 dari 0 rekod",
							"sEmptyTable": "Tiada Jadual Peperiksaan",
						    "oPaginate": {
						      "sFirst": "Pertama",
						      "sLast": "Akhir",
						      "sNext": "Seterus",
						      "sPrevious": "Sebelum"
						     }
						 }
		});

		
		
		if($('#tbl_exam_schedule').length > 0){
			new FixedHeader( oTable, {
		        "offsetTop": 40
		    } );
		}
		
		
		$(function()
		{
			$( "#schedule_date").datepicker({
	            dateFormat:"dd-mm-yy",
	            changeMonth : true,
	            changeYear : true,
	            beforeShowDay: $.datepicker.noWeekends,
	            minDate : 0
			});
			
			$( "#schedule_date_modal").datepicker({
	            dateFormat:"dd-mm-yy",
	            changeMonth : true,
	            changeYear : true,
	            beforeShowDay: $.datepicker.noWeekends,
	            minDate : 0
			});
			
			//$('#schedule_time').timepicker();
			$('#schedule_time_start').timepicker();
			$('#schedule_time_end').timepicker();
			$('#schedule_time_start_modal').timepicker();
			$('#schedule_time_end_modal').timepicker();

			initiate_edit_delete();		

    	});


		//Get module
		$('#cou_id').change(function(){

			var course_id = $(this).val();
			
			$('#td_modul').html('<img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/> Sila tunggu...');
			
			setTimeout(function()
			{
				var request = $.ajax({
					url: site_url+"examination/exam_schedule/get_module_by_course",
					type: "POST",
					data: {cou_id : course_id},
					dataType: "html"
					});
				
				request.done(function(msg) {
					//alert("Berjaya");
					//alert(msg);
					//console.log(msg);
					$('#td_modul').html(msg);
				});
				
				request.fail(function(jqXHR, textStatus) {
					//alert("Gagal");
					//Do nothing
				});
			}, 1500);
				
		});

		//For save edit
		$('#btnSaveEdit').click(function(){

			var sche_id = $('#schedule_id').val();
			var date = $('#schedule_date_modal').val();
			var time_start = $('#schedule_time_start_modal').val();
			var time_end = $('#schedule_time_end_modal').val();

			 var request = $.ajax({
					url: site_url+"examination/exam_schedule/edit_exam_schedule",
					type: "POST",
					data: {	schedule_id : sche_id,
							schedule_date_modal : date,
							schedule_time_start_modal : time_start,
							schedule_time_end_modal : time_end},
					dataType: "html"
				});
	
			request.done(function(data) {
				//alert(data);
				var opts = new Array();
				opts['heading'] = 'Berjaya';
				opts['content'] = 'Perubahan berjaya disimpan';
				kv_alert(opts);	
				$("#myModal_edit").modal('hide');
		
			});

			request.fail(function(jqXHR, textStatus) {
				var opts = new Array();
				opts['heading'] = 'Tidak Berjaya';
				opts['content'] = 'Perubahan tidak berjaya disimpan';
				kv_alert(opts);
				//fnRowSpan2($("#tbl_exam_schedule tbody tr > :nth-child(4)"), true);
			});
			
			/*var opts = new Array();
			opts['heading'] = 'Simpan Jadual Peperiksaan?';
			opts['hidecallback'] = true;
			opts['callback'] = function()
			{
				var sche_id = $('#schedule_id').val();
				var date = $('#schedule_date_modal').val();
				var time_start = $('#schedule_time_start_modal').val();
				var time_end = $('#schedule_time_end_modal').val();

				 var request = $.ajax({
						url: site_url+"examination/exam_schedule/edit_exam_schedule",
						type: "POST",
						data: {	schedule_id : sche_id,
								schedule_date_modal : date,
								schedule_time_start_modal : time_start,
								schedule_time_end_modal : time_end},
						dataType: "html"
					});
		
				request.done(function(data) {
					//alert(data);
					var opts = new Array();
					opts['heading'] = 'Berjaya';
					opts['content'] = 'Perubahan berjaya disimpan';
					kv_alert(opts);
					//fnRowSpan2($("#tbl_exam_schedule tbody tr > :nth-child(4)"), true);

				});
	
				request.fail(function(jqXHR, textStatus) {
					var opts = new Array();
					opts['heading'] = 'Tidak Berjaya';
					opts['content'] = 'Perubahan tidak berjaya disimpan';
					kv_alert(opts);
					//fnRowSpan2($("#tbl_exam_schedule tbody tr > :nth-child(4)"), true);
				});
			};*/

			//opts['cancelCallback'] = function(){/*do nothing*/};
			//kv_confirm(opts);

			
		});

		
		//Save exam schedule
		$('#btn_submit').click(function(e){
			var opts = new Array();
			opts['heading'] = 'Simpan Jadual Peperiksaan?';
			opts['hidecallback'] = true;
			opts['callback'] = function()
			{
				var session = $('#sesi').val();
				var course_id = $('#cou_id').val();
				var module_id = $('#mod_id').val();
				var date = $('#schedule_date').val();
				var time_start = $('#schedule_time_start').val();
				var time_end = $('#schedule_time_end').val();

				 var request = $.ajax({
						url: site_url+"examination/exam_schedule/add",
						type: "POST",
						data: {	sesi : session,
								cou_id : course_id,
								mod_id : module_id,
								schedule_date : date,
								schedule_time_start : time_start,
								schedule_time_end : time_end},
						dataType: "html"
					});
		
				request.done(function(data) {
					//alert(data);
					var opts = new Array();
					opts['heading'] = 'Berjaya';
					opts['content'] = 'Jadual berjaya disimpan';
					kv_alert(opts);
					populate_exam_schedule();
					document.getElementById("form1").reset();
				});
	
				request.fail(function(jqXHR, textStatus) {
					var opts = new Array();
					opts['heading'] = 'Tidak Berjaya';
					opts['content'] = 'Jadual tidak berjaya disimpan';
					kv_alert(opts);
				});
			};

			opts['cancelCallback'] = function(){/*do nothing*/};
			kv_confirm(opts);
		});

		
    			
    } );
    
</script>

<style>
.bblue,.dblue {
	font-weight: bold;
	color: blue;
}

.ddark {
	font-weight: bold;
	color: inherit;
}

.dgreen {
	font-weight: bold;
	color: green;
}
#ui-datepicker-div {
	z-index: 1051 !important;
}
</style>

<script src="<?=base_url()?>assets/js/kv.msg.modal.js" type="text/javascript"></script>
<link href="<?=base_url()?>assets/css/bootstrap-timepicker.css"	rel="stylesheet" />
<script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap-timepicker.js"></script>
<script>

var base_url = '<?=base_url();?>';
var site_url = '<?=site_url();?>/';

</script>

<h3><?= $headline ?></h3><hr />
<center>
		<form id="form1" name="form1" action="" method="post"
			class="form-inline">
			<table id="group" class="breadcrumb border" width="100%" align="center">
					<tr>
						<td colspan="3" height="35">&nbsp;</td>
					</tr>
					<tr>
						<td width="40%" height="35"><div align="right">Kursus</div></td>
						<td width="3%" height="35"><div align="center">:</div></td>
						<td width="57%" height="35">
							<select name="cou_id" id="cou_id" class="validate[required]">
								<option value="">--Sila Pilih--</option>
                       			<?php
									foreach ( $courses as $course ) {
										echo "<option value='" . $course->cou_id . "'>".$course->cou_course_code." - ". ucwords( strtolower ( $course->cou_name )) . "</option>";
									}
								?>
                    		</select>
                    		<input type="hidden" id="sesi" name="sesi" value="<?=$cur_sesi ?>" />
                    	</td>
					</tr>
					<tr>
						<td width="40%" height="35"><div align="right">Modul</div></td>
						<td width="3%" height="35"><div align="center">:</div></td>
						<td width="57%" height="35" id="td_modul">
							<select name="mod_id" id="mod_id" class="validate[required]" disabled="disabled">
								<option value="">--Sila Pilih--</option>
                       			<?php
									foreach ( $subjects as $sbj ) {
										echo "<option value='" . $sbj->mod_id . "'>".$sbj->mod_paper." - ". ucwords ( strtolower ( $sbj->mod_name ) ) . "</option>";
									}
								?>
                    		</select>
                    	</td>
					</tr>
					<tr>
						<td width="40%" height="35"><div align="right">Tarikh</div></td>
						<td width="3%" height="35"><div align="center">:</div></td>
						<td width="57%" height="35">
							<input type="text" name="schedule_date" id="schedule_date" class="validate[required]" />
						</td>
					</tr>
					<tr>
						<td width="40%" height="35"><div align="right">Masa Mula</div></td>
						<td width="3%" height="35"><div align="center">:</div></td>
						<td width="57%" height="35">
							<div class="input-append bootstrap-timepicker">
								<input type="text" id="schedule_time_start"
									name="schedule_time_start" class="input-small">
									<span class="add-on"><i class="icon-time"></i></span>
							</div>
						</td>
					</tr>
					<tr>
						<td width="40%" height="35"><div align="right">Masa Tamat</div></td>
						<td width="3%" height="35"><div align="center">:</div></td>
						<td width="57%" height="35">
							<div class="input-append bootstrap-timepicker">
								<input type="text" id="schedule_time_end"
									name="schedule_time_end" class="input-small">
									<span class="add-on"><i class="icon-time"></i></span>
							</div>
						</td>
					</tr>
					<tr>
						<td colspan="2" style="text-align: center">&nbsp;</td>
						<td>						
							<input class="btn btn-info" type="button" name="btn_submit" id="btn_submit"
							value="Simpan">
							<input class="btn" type="reset" name="btn_reset"
							value="Set Semula">
						</td>
					</tr>
					<tr>
						<td colspan="3" height="35">&nbsp;</td>
					</tr>
			</table>
		</form>
</center>

<script type="text/javascript">
								
	$(document).ready(function() {
		$(".btn_add_popup").bind("click", function() {
			$('#myModal_add').modal({
				keyboard : false
			});
			
			var session = $(this).attr("title");
			session = session.replace(" ","_");
			
			jAjaxLm("#span_result",site_url + "examination/exam_schedule/add_exam_schedule/" + session,'');
		});
		

		$('#myModal_edit').on('hide',function(){
			/* setTimeout(function()
			{
				window.location = site_url+"examination/exam_schedule";
			}, 1500); */

			populate_exam_schedule();
		});
		
		$("#form3").validationEngine();
	
		$(function() {
			$( "#date_start").datepicker({
	            dateFormat:"dd-mm-yy",
	            changeMonth : true,
	            changeYear : true,
	            onClose: function( selectedDate ) {
		        $( "#date_end" ).datepicker( "option", "minDate", selectedDate );
		      }
			});
			$( "#date_end").datepicker({
	            dateFormat:"dd-mm-yy",
	            changeMonth : true,
	            changeYear : true,
	            onClose: function( selectedDate ) {
		        $( "#date_start" ).datepicker( "option", "maxDate", selectedDate );
		      }
			});
		
    	});    
   
	});

</script>
<?php
	$temp_sesi = str_replace ( "/", "-", $cur_sesi );
	
	if ($exam_schedule_rasmi == null)
	{
?>
	<table class="table tablesorter" id="tbl_exam_schedule" style="margin-bottom: 0px;">
		<thead>
			<th width="20%">Tarikh / Masa</th>
			<th width="25%">Modul</th>
			<th width="15%">Kod Modul</th>
			<th width="20%">Kursus</th>
			<th width="20%">Tindakan</th>
		</thead>
		<tbody>
		</tbody>
	</table>
		
<?php
	} 
	else
	{
?>

<br />
<br />
<table class="table tablesorter" id="tbl_exam_schedule" style="margin-bottom: 0px;">
	<thead>
		<th width="20%">Tarikh / Masa</th>
		<th width="25%">Modul</th>
		<th width="15%">Kod Modul</th>
		<th width="20%">Kursus</th>
		<th width="20%">Tindakan</th>
	</thead>
<?php
	foreach ( $exam_schedule_rasmi as $es ) 
	{
?>
	<tr>
		<td id="td_date_time"><?=date('d/m/Y',$es->schedule_date) ?>&nbsp; (<?=$this->func->getDayInMalay(date('l',$es->schedule_date)) ?>)
			<br /><?=date('g:i',strtotime($es->schedule_time_start))?>
			<?php
				if ($es->schedule_time_start < 1200) {
					echo " pagi";
				} else if ($es->schedule_time_start < 1300) {
					echo " tengahari";
				} else if ($es->schedule_time_start < 1900) {
					echo " petang";
				} else {
					echo " malam";
				}
			?>
			<span>&nbsp;-&nbsp;</span>
			<?=date('g:i',strtotime($es->schedule_time_end))?>
			<?php
				if ($es->schedule_time_end < 1200) {
					echo " pagi";
				} else if ($es->schedule_time_end < 1300) {
					echo " tengahari";
				} else if ($es->schedule_time_end < 1900) {
					echo " petang";
				} else {
					echo " malam";
				}
			?>
			<input type="hidden" id="date" name="date" value="<?=date('d-m-y',$es->schedule_date) ?>" />
			<input type="hidden" id="time_start" name="time_start" value="<?=date('h:i A',strtotime($es->schedule_time_start)) ?>" />
			<input type="hidden" id="time_end" name="time_end" value="<?=date('h:i A',strtotime($es->schedule_time_end)) ?>" />
		</td>
		<td style="vertical-align: middle;" id="td_mod_name"><?= ucwords ( strtolower ( $es->mod_name ) )?></td>
		<td style="vertical-align: middle;" id="td_mod_paper"><?=$es->mod_paper ?></td>
		<td style="vertical-align: middle;"><?= ucwords ( strtolower ( $es->cou_name ) )?></td>

		<td style="vertical-align: middle;"><center>
				<a name="btn_edit_popup" id="btn_edit_popup"
					class="btn btn_edit_popup btn-info" value="<?= $es->schedule_id ?>"><i class="icon-edit icon-white"></i>Kemaskini</a>
				<a class="btn btn_delete" name="btn_delete" id="btn_delete" value="<?= $es->schedule_id ?>"><i class="icon-trash"></i>Padam</a>
			</center></td>
	</tr>
<?php
	}
?>
</table>
<?php
}
?>



<div class="modal hide fade" id="myModal_add"
	style="width: 70%; margin-left: -35%;">
	<div class="modal-header">
		<button id="btn_close" type="button" class="close"
			data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
		<h3>Penetapan Jadual Peperiksaan</h3>
	</div>

	<div class="modal-body" id="span_result"></div>

</div>

<div class="modal hide fade" id="myModal_edit"
	style="width: 60%; margin-left: -30%;">
	<div class="modal-header">
		<button id="btn_close" type="button" class="close"
			data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
		<h3>Kemaskini Jadual Peperiksaan</h3>
	</div>

	<div class="modal-body" id="span_result2">
		<form id="formEdit" name="formEdit" style="position: relative;"
			method="post">
			<span><h5>Modul : <span id="mod_modul_name"></span></h5></span>
			<input type="hidden" id="schedule_id" name="schedule_id" value="" />
			<center>
			<table id="tblKemaskini" style="margin-bottom: 5px;width: 100%"
				class="table table-striped table-bordered table-condensed">
				<thead>
					<tr>
						<td width="40%"
							style="vertical-align: middle; text-align: center;"><strong>Tarikh</strong></td>
						<td width="20%" style="text-align: center;"><strong>Masa Mula</strong></td>
						<td width="20%" style="text-align: center;"><strong>Masa Tamat</strong></td>
					</tr>
				</thead>
				<tbody>
					<td style="text-align: center;"><input type="text"
						name="schedule_date_modal" id="schedule_date_modal"
						class="input-small validate[required]" /></td>
					<td style="text-align: center;">
						<div class="input-append bootstrap-timepicker">
							<input type="text" id="schedule_time_start_modal"
								name="schedule_time_start_modal" class="input-small"> <span
								class="add-on"><i class="icon-time"></i></span>
						</div>
					</td>
					<td style="text-align: center;">
						<div class="input-append bootstrap-timepicker">
							<input type="text" id="schedule_time_end_modal"
								name="schedule_time_end_modal" class="input-small"> <span
								class="add-on"><i class="icon-time"></i></span>
						</div>
					</td>
				</tbody>
				<tfoot>
				</tfoot>
			</table>
			</center>			
		</form>
	</div>

	<div class="modal-footer">
			<div class="pull-right">
				<button id="btnSaveEdit" type="button" name="btnSaveEdit" class="btn btn-primary">
					<span>Simpan</span>
				</button>
			</div>
	</div>

</div>