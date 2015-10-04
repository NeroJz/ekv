/**************************************************************************************************
* File Name        : kv.assessment.js
* Description      : This File contain all of javascript for assessment configuration
* Author           : Freddy Ajang Tony
* Date             : 19 june 2013
* Version          : -
* Modification Log : -
* Function List	   : - 
**************************************************************************************************/



/**************************************************************************************************
* Description		: document ready function
* input				: -
* author			: Freddy Ajang Tony
* Date				: 19 June 2013
* Modification Log	: -
**************************************************************************************************/
var typeAcro = new Array('PA','PT','PAK');
var typeName = new Array('Pusat (Amali)','Pusat (Teori)',
						 'Akademik (Pusat)');
var typePosition = new Array('Pengarah','Timbalan Pengarah','KJPP/KUPP');
var semesterDisable = new Array();
var todaydate = "";
var to_date = ""; 
var today_date = ""; 
var semNum=1;
var params = "";


$(document).ready(function(){
	
	$("#frmOpenSetting , #frmOpenSettingAK").validationEngine('attach', {promptPosition : "centerRight", scroll: false});
	$("#frmOpenManual , #frmOpenManualAK").validationEngine('attach', {promptPosition : "centerRight", scroll: false});
	$("#frmSearchKv").validationEngine();
	$('#progress').html("PUSAT (AMALI)");
	$("#tblUserdate_PT").hide();
	$("#tblUserdate_PAK").hide();
		
	$('#progressm').html("PUSAT (AMALI)");
	$("#tblUsermdate_PT").hide();
	$("#tblUsermdate_PAK").hide();
	
	$('#progressak').html("AKADEMIK (PUSAT)");
	$("#tblUserdate_SAK").hide();
	
	$('#progressmak').html("AKADEMIK (PUSAT)");
	$("#tblUsermdate_SAK").hide();
	
	var semester = new Array();
	var currentsession = $('#cur_session').val();
	var collapseindex = 0;
	var searchFrm = "";

	todaydate = convert_timestamp($('#today_date').val());
	to_date = todaydate.split('-'); //For Compare Date
	today_date = new Date(to_date[1]+'-'+to_date[0]+'-'+to_date[2]).getTime(); //For Compare Date


	$('#tblStatusSd').html("");
	
	var session_year = currentsession.split('/');
	
	// For session dropdown
	var selectsession =
		'<option value="'+session_year[0]+':'+session_year[1]+'">'+currentsession+'</option>';

	// For session dropdown
	if(session_year[0] == 1)
	{
		selectsession +=
			'<option value="2:'+(session_year[1]-1)+'">2/'+(session_year[1]-1)+'</option>'+
			'<option value="1:'+(session_year[1]-1)+'">1/'+(session_year[1]-1)+'</option>';
	}else
	{
		selectsession +=
			'<option value="'+(session_year[0]-1)+':'+session_year[1]+'">'+(session_year[0]-1)+'/'+session_year[1]+'</option>'+
			'<option value="'+session_year[0]+':'+(session_year[1]-1)+'">'+session_year[0]+'/'+(session_year[1]-1)+'</option>';
	}
	
	//put to option session
	$('#slctsesi_vk').append(selectsession);
	$('#slctsesi_mvk').append(selectsession);
	$('#slctsesi_ak').append(selectsession);
	$('#slctsesi_mak').append(selectsession);

	var tblRowData =
		'<tr>'+
		'<td colspan="2"><strong id="menutitle">Status Kemasukan Pentaksiran</strong></td>'+
		'</tr>'+
		'<tr>'+
		'<td width="10%" ><strong class="tablepadding">Sesi</strong></td>'+
		'<td><select id="slctsesi_sdconfig" name="slctsesi_sdconfig" class="span2">'+
		'<option value="'+session_year[0]+':'+session_year[1]+'">'+currentsession+'</option>';
	
	// For session dropdown (Status sdconfig)
	if(session_year[0] == 1)
	{
		tblRowData +=
			'<option value="2:'+(session_year[1]-1)+'">2/'+(session_year[1]-1)+'</option>'+
			'<option value="1:'+(session_year[1]-1)+'">1/'+(session_year[1]-1)+'</option>';
	}else
	{
		tblRowData +=
			'<option value="'+(session_year[0]-1)+':'+session_year[1]+'">'+(session_year[0]-1)+'/'+session_year[1]+'</option>'+
			'<option value="'+session_year[0]+':'+(session_year[1]-1)+'">'+session_year[0]+'/'+(session_year[1]-1)+'</option>';
	}
	
	tblRowData +=
		'</td>'+
		'</tr>'+
		'<tr>'+
		'<td width="10%" ><strong class="tablepadding">Status</strong></td>'+
		'<td>'+
		'<ul class="nav nav-tabs" id="myTabStatus">'+
		'<li class="active"><a href="#tab_sem1" data-toggle="tab">Semester 1</a></li>'+
		'<li><a href="#tab_sem2" data-toggle="tab">Semester 2</a></li>'+
		'<li><a href="#tab_sem3" data-toggle="tab">Semester 3</a></li>'+
		'<li><a href="#tab_sem4" data-toggle="tab">Semester 4</a></li>'+
		'<li><a href="#tab_sem5" data-toggle="tab">Semester 5</a></li>'+
		'<li><a href="#tab_sem6" data-toggle="tab">Semester 6</a></li>'+
		'<li><a href="#tab_sem7" data-toggle="tab">Semester 7</a></li>'+
		'<li><a href="#tab_sem8" data-toggle="tab">Semester 8</a></li>'+
		'</ul>'+
		'<div class="tab-content">';
	
	
	//For empty configuration
	for(var a = 1;a<=8;a++)
	{
		if(a == 1)
		{
			tblRowData +=	
  				'<div class="tab-pane active" id="tab_sem'+a+'">'+
				'<div class="accordion" id="accordion_status'+a+'">';
		}
		else
		{
			tblRowData +=	
  				'<div class="tab-pane" id="tab_sem'+a+'">'+
				'<div class="accordion" id="accordion_status'+a+'">';
		}
		
		
		for(var irowType = 0 ; irowType < 3 ; irowType++)
		{
			tblRowData +=
				'<div class="accordion-group">'+
				'<div class="accordion-heading">'+
				'<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_status" href="#collapse'+a+collapseindex+'">'+
				'<strong id="menutitle">'+typeName[irowType]+'</strong>'+
				'<strong class="tablepadding dred">&nbsp;&nbsp; : &nbsp;Tutup </strong>'+
				'&nbsp;&nbsp;<i class="icon-chevron-down pull-right"></i>'+
				'</a></div>'+
				'<div id="collapse'+a+collapseindex+'" class="accordion-body collapse">'+
				'<div class="accordion-inner">'+
				'<table style="width:400px; margin-left:100px;" class="table table-bordered table-condensed" >'+
				'<tr><td><strong class="tablepadding"> Jawatan </strong></td>'+
				'<td><strong class="tablepadding"> Tarikh Tutup </strong></td></tr>';
			
			for(var irowData = 0 ; irowData < 3 ; irowData++)
			{
				tblRowData +=
					'<tr><td> '+typePosition[irowData]+' : </td>'+
					'<td><span class="dred"> Tutup </span></td></tr>';
			}
			
			collapseindex++;
			
			tblRowData +=
				'</table>'+
				'</div>'+
				'</div>'+				
				'</div>';
		}
		
		tblRowData +=
			'</div>'+
			'</div>';
		
	}
	
	tblRowData +=
		'</div>'+
		'</td>'+
		'</tr>';
	
	$('#tblStatusSd').append(tblRowData);
	

	
	//To get configuration
	params = session_year[0]+':'+session_year[1];
	fnPopulateStatus(params);
	
	
	$('#selKVList').on("click", ".closebtn", function(){
		$(this).parent().remove();
	});
	
	
	var removeIntent = false;
	$('#selKvList').sortable({
		over: function () {
			removeIntent = false;
		},
		out: function () {
			removeIntent = true;
		},
		beforeStop: function (event, ui) {
			if(removeIntent == true){
				ui.item.remove();   
			}
		}
	});
	
	$('#myTab a:first').tab('show');
	$('#myTab a').click(function (e) {
  		e.preventDefault();
  		$(this).tab('show');
	});
	
	$('#myTab a:last').click(function (e) {
  		e.preventDefault();
  		
  		//$('#collapseOne').collapse('show');
	});
	
	
	$('#myTabStatus a:first').tab('show');
	$('#myTabStatus a').click(function (e) {
  		e.preventDefault();
  		$(this).tab('show');
	});
	
	$('#myTabStatus a:last').click(function (e) {
  		e.preventDefault();
  		
  		//$('#collapseOne').collapse('show');
	});

	
	///////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////// SELECT SESSION (VK)//////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////
	$('#slctsesi_vk').on('change',function(e){
		//alert($(this).val());
		var params = $(this).val();
		var formType = $(this).parent().parent().parent().parent().parent().attr('id');
		semester = new Array();
		semesterDisable = new Array();
		
		//Reset data
		fnResetData();
		
		//$('#sddatefrom_PA').reset();
		$('#tdlink_group').html("");
		
		
		for(var i=1;i<=8;i++)
		{
			$('#chkSem'+i+'').removeAttr("disabled");
			$('#chkSem'+i+'').prop("checked", false);
		}
		
		if(params != "")
		{
			var request = $.ajax({
				url: site_url+"/examination/assessment/get_group_semester_by_session_vk",
				type: "POST",
				data: {sesi : params},
				dataType: "json"
			});
			
			request.done(function(data){
				//console.log(data);
				
			if(data != null){
				$(data.group_semester_vk).each(function(index)
				{
					var g_sem = data.group_semester_vk[index].semester;
					semester.push(g_sem);
					semesterDisable.push(g_sem);
				});
				
				$.unique($.unique(semester));
				//$.distinct(semester);
				//console.log(semesterDisable);
				
				var rowLink = "";
				$(semester).each(function(index)
				{
					//alert(semester[index]);
					rowLink +=
					'<a href="javascript:void(0)" onclick="fnGetGroupSemester(\''+semester[index]+'\',\'vk\',\''+params+'\')">'+
					'Semester '+semester[index]+''+
					'</a>&nbsp;&nbsp;';
					
					if(semester[index].length > 1)
					{
						var sem_chk = semester[index].split(',');
						
						$(sem_chk).each(function(index){
							$("input[id='chkSem"+sem_chk[index]+"']").attr("disabled", "disabled");
						});
					}
					else{
						$("input[id='chkSem"+semester[index]+"']").attr("disabled", "disabled");
					}
						
				});
				
				rowLink +=
				'<br>';
				
				$('#tdlink_group').prepend(rowLink);
			}
				
			});
			
			
			request.fail(function(jqXHR, textStatus){
				//alert("Request failed"+ textStatus);
			});
		}

		
	});
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////////////// SELECT SESSION (AK)//////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////
	$('#slctsesi_ak').on('change',function(e){
		//alert($(this).val());
		var params = $(this).val();
		$('#tdlink_group_ak').html("");
		semester = new Array();
		
		for(var i=1;i<=8;i++)
		{
			$('#chkakSem'+i+'').removeAttr("disabled");
			$('#chkakSem'+i+'').prop("checked", false);
		}
		
		if(params != "")
		{
			var request = $.ajax({
				url: site_url+"/examination/assessment/get_group_semester_by_session_ak",
				type: "POST",
				data: {sesi : params},
				dataType: "json"
			});
			
			request.done(function(data){
				//console.log(data);
				
			if(data != null){
				$(data.group_semester_ak).each(function(index)
				{
					var g_sem = data.group_semester_ak[index].semester;
					semester.push(g_sem);	
				});
				
				$.unique($.unique(semester));
				//$.distinct(semester);
				//console.log(semester);
				
				var rowLink = "";
				$(semester).each(function(index)
				{
					//alert(semester[index]);
					rowLink +=
					'<a href="javascript:void(0)" onclick="fnGetGroupSemester(\''+semester[index]+'\',\'ak\',\''+params+'\')">'+
					'Semester '+semester[index]+''+
					'</a>&nbsp;&nbsp;';
					
					if(semester[index].length > 1)
					{
						var sem_chk = semester[index].split(',');
						
						$(sem_chk).each(function(index){
							$("input[id='chkakSem"+sem_chk[index]+"']").attr("disabled", "disabled");
						});
					}
					else{
						$("input[id='chkakSem"+semester[index]+"']").attr("disabled", "disabled");
					}
						
				});
				
				rowLink +=
				'<br>';
				
				$('#tdlink_group_ak').prepend(rowLink);
			}
				
			});
			
			
			request.fail(function(jqXHR, textStatus){
				//alert("Request failed"+ textStatus);
			});
		}

		
	});
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////////// SELECT STATUS//////////////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////
	$('#slctsesi_sdconfig').on('change',function(e){
		
		//alert($(this).val());
		var tblRowDataT = "";
		var tblRowDataAK = "";
		var indexsem = "";
		
		//To get configuration
		var sessionYear = $(this).val();
		$('#tblStatusSd').find('#status_manual').remove();
		fnPopulateStatus(sessionYear);	
		
	});
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////
	///////////////////////////// SAVE UPDATE CONFIGURATION (MANUAL) //////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////
	$('#btn_save_m, #btn_save_m_ak').click(function(e){
		
		//get form id
		var formType = $(this).parent().parent().parent().parent().parent().attr('id');

		var selName = 'selKvList';
		var txtName = 'txtKvList';
		var klist = "";
		
		if("searchmKv" == searchFrm)
		{	
			selName = 'selKvListm';
			txtName = 'txtKvListm';
		}	
		
		$("#"+selName+" li").each(function()
		{
			klist+=$(this).find('span.kvid').html()+';';
		});
		
		if(klist.length>0)
		{
			klist = klist.substr(0,klist.length-1); //buang the extra ; kat belakang
			$('#'+txtName+'').val(klist);
		}
		else
		{
			//show error message
			$('#'+selName+'').validationEngine('showPrompt', '*Sila Masukkan sekurang-kurangnya satu KV', 'err', 'topLeft', true)
			e.preventDefault();
		}
		
		 $.blockUI({ 
				message: '<h5><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h5>', 
				css: { border: '3px solid #660a30' } 
        	}); 
		 
		 setTimeout(function()
		 {
			 var validate = $('#'+formType+'').validationEngine('validate');
			 if(validate)
			 {
				//ajax submit to delete
				var request = $.ajax({
					url: site_url+"/examination/assessment/save_assessment_configuration_manual",
					type: "POST",
					data: $('#'+formType+'').serialize(),
					dataType: "html"
				});
				//alert(data);
				request.done(function(data) {
					$.unblockUI();
					//alert(data);
					if(data.length>0 && data>0)
					{
						var opts = new Array();
						opts['heading'] = 'Berjaya';
						opts['content'] = 'Maklumat Tarikh Pembukaan Kemasukkan Markah Berjaya disimpan';
						
						kv_alert(opts);		
					}
					else
					{
						var opts = new Array();
						opts['heading'] = 'Tidak Berjaya';
						opts['content'] = 'Data-data tidak sah! Maklumat Pembukaan Kemasukkan Markah tidak dapat disimpan';
						kv_alert(opts);
					}
					
					//Refresh all
					$('#'+formType+'')[0].reset();
					fnPopulateStatus(params);
					$('#selKvList li').remove();
					
					//to reconfigure table manual
					$('#tblStatusSd').find('#status_manual').remove();
				});
	
				request.fail(function(jqXHR, textStatus) {
					$.unblockUI();
					//msg("Request failed", textStatus, "Ok");
					alert("Request failed"+ textStatus);
				});
			 }
			 else
			 {
				 $.unblockUI();
				 
				 var opts = new Array();
				 opts['heading'] = 'Tidak Berjaya';
				 opts['content'] = 'Data-data tidak sah! Maklumat Pembukaan Kemasukkan Markah tidak dapat disimpan';
				 kv_alert(opts);
			 }
				
		}, 1500);	
		 	//window.location.reload();
			//window.location.href = base_url+"index.php/examination/assessment";
	});
	
	
	
	$('#btn_reset_m').click(function(e){
		$('#selKvList').validationEngine('hide');
		$('#selKvList li').remove();
	});
	
	$('#btn_reset_a').click(function(e){
		
		$('#tdlink_group').html("");
		
		//Reset data
		fnResetData();
		
	});
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////// SAVE UPDATE CONFIGURATION /////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////
	$('#btn_save_a,#btn_save_ak').click(function(e){
		
		//get form id
		 var formType = $(this).parent().parent().parent().parent().parent().attr('id');
		
		 $.blockUI({ 
				message: '<h5><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h5>', 
				css: { border: '3px solid #660a30' } 
        	}); 
		 
		 setTimeout(function()
		 {
			 var validate = $('#'+formType+'').validationEngine('validate');
			 if(validate)
			 {
					//ajax submit to save
					var request = $.ajax({
						url: site_url+"/examination/assessment/save_assessment_configuration",
						type: "POST",
						data: $('#'+formType+'').serialize(),
						dataType: "html"
					});
					//alert(data);
					request.done(function(data) {
						$.unblockUI();
						//alert(data);
						if(data.length>0 && data>0)
						{
							var opts = new Array();
							opts['heading'] = 'Berjaya';
							opts['content'] = 'Maklumat Tarikh Pembukaan Kemasukan Markah Berjaya disimpan';
							
							kv_alert(opts);		
						}
						else
						{
							var opts = new Array();
							opts['heading'] = 'Tidak Berjaya';
							opts['content'] = 'Data-data tidak sah! Maklumat Pembukaan Kemasukan Markah tidak dapat disimpan';
							kv_alert(opts);
						}
						
						//Refresh all
						$('#'+formType+'')[0].reset();
						$('#tdlink_group').html("");
						fnPopulateStatus(params);
						
						//to reconfigure table manual
						$('#tblStatusSd').find('#status_manual').remove();
						
					});
		
					request.fail(function(jqXHR, textStatus) {
						$.unblockUI();
						//msg("Request failed", textStatus, "Ok");
						alert("Request failed"+ textStatus);
					});
			 }
			 else
			 {
				$.unblockUI();
				var opts = new Array();
				opts['heading'] = 'Tidak Berjaya';
				opts['content'] = 'Data-data tidak sah! Maklumat Pembukaan Kemasukan Markah tidak dapat disimpan';
				kv_alert(opts);
			 }

		}, 1500);
	});
	

	
	$('.mclosebtn').click(function(){
			
			var id_to_delete = $(this).find('.kvid').html();
			var li = $(this).parent();
			
			var opts = new Array();
			opts['heading'] = 'Memadam Pembukaan Pentaksiran Pelajar';
			opts['hidecallback'] = true;
			opts['callback'] = function()
			{
				if(id_to_delete!=null && id_to_delete.length>0)
				{
					 $.blockUI({ 
						message: '<h5><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h5>', 
						css: { border: '3px solid #660a30' } 
	            	}); 
					
					//ajax submit to delete
					var request = $.ajax({
						url: site_url+"/examination/assessment/delete_manual_configuration",
						type: "POST",
						data: {fid : id_to_delete},
						dataType: "html"
					});
		
					request.done(function(data) {
						$.unblockUI();
						if(data.length>0 && data>0)
						{
							var opts = new Array();
							opts['heading'] = 'Berjaya';
							opts['content'] = 'rekod berjaya dipadam';
							
							if(li.parent().find('li').size()==1)
								li.closest('tr').remove();
							
							li.remove();
							
							kv_alert(opts);
							
						}
						else
						{
							var opts = new Array();
							opts['heading'] = 'Tidak Berjaya';
							opts['content'] = 'rekod berjaya dipadam';
							kv_alert(opts);
						}
					});
		
					request.fail(function(jqXHR, textStatus) {
						$.unblockUI();
						//msg("Request failed", textStatus, "Ok");
						alert("Request failed"+ textStatus);
					});
				}
			};
			
			
			opts['cancelCallback'] = function(){/*do nothing*/};
			kv_confirm(opts);
			
			
	});
	
	
	$('#CarianKv').click(function(){
		
		if($("#frmSearchKv").validationEngine('validate',{scroll: false}))
		{	
			$('#searchModal').block({ 
			message: '<h5><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h5>',
			css: { border: '3px solid #660a30' } 
            });
		
			var search = $('#cKv').val();
		
			var request = $.ajax({
				url: site_url+"/examination/assessment/search_kv_details",
				type: "POST",
				data: {str : search},
				dataType: "json"
			});

			request.done(function(data) {
				//console.log(data);
				$('#Hkv > tbody').html("");
				
				if(data.kvs!=null && data.kvs.length>0)
				{
					$(data.kvs).each(function(index)
					{
						var kvkod = data.kvs[index].col_code;
						var kvname = data.kvs[index].col_name;
						var kvid = data.kvs[index].col_id;
						
						if(null == kvkod)
							kvkod = "-";
						
						var tblRow = '<tr>'+
						'<td>'+kvkod +'</td>'+
						'<td>'+kvname +'</td>'+
						'<td style="text-align:center"><a class="addKv btn" href="javascript:void(0);"' +
						'data-original-title="Pilih Kv"><i class="icon-plus"><span class="kvid">'+kvid+'</span></i></a></td>'+
						'</tr>'
						
						$('#Hkv > tbody:last').append(tblRow);
						
					});
					
					$('.addkv').tooltip();
					
					$('#searchModal').unblock();
				}
				else
				{
					$('#searchModal').unblock();
					//alert("Tiada Maklumat Staff");
					$('#Hkv > tbody:last').append(
					'<tr><td colspan="4"><span class="style8">tiada maklumat institusi dijumpai</span></td></tr>');
				}
			});

			request.fail(function(jqXHR, textStatus) {
				//msg("Request failed", textStatus, "Ok");
				alert("Request failed"+ textStatus);
				$('#searchModal').unblock();
			});

			return false;
		}
	});
	
	
	$('#Hkv').on("click", ".addKv", function(){
		var display_data = $(this).parent().parent().find("td").eq(0).html()+'-'+
			$(this).parent().parent().find("td").eq(1).html();
		var kvid = $(this).find(".kvid").html();
		//alert(sid);
		var selValues = new Array();
		
		if("searchmKv" == searchFrm)
		{
			$("#searchKvListm li").each(function()
			{
				selValues.push($(this).find('.vals').html());
			});
			//console.log(selValues);
			if($.inArray(display_data, selValues)==-1)
			{
				$('#searchKvListm').append('<li class="items"><span class="vals">'+display_data+'</span><span class="kvid">'+kvid+'</span><div class="closebtn"></div></li>');
			}
		}
		else
		{
			$("#searchKvList li").each(function()
			{
				selValues.push($(this).find('.vals').html());
			});
			//console.log(selValues);
			if($.inArray(display_data, selValues)==-1)
			{
				$('#searchKvList').append('<li class="items"><span class="vals">'+display_data+'</span><span class="kvid">'+kvid+'</span><div class="closebtn"></div></li>');
			}
		}
		
	});
	
	
	var removeIntents = false;
	$('#searchKvList, #searchKvListm').sortable({
		over: function () {
			removeIntent = false;
		},
		out: function () {
			removeIntent = true;
		},
		beforeStop: function (event, ui) {
			if(removeIntent == true){
				ui.item.remove();   
			}
		}
	});
	
	
	$('#searchKvList , #selKvList, #searchKvListm , #selKvListm').on("click", ".closebtn", function(){
		$(this).parent().remove();
	});
	
	
	$('#btnCnfmKv').click(function(e){
		
		searchFrm = $('#searchForm').val();
		
		if("searchmKv" == searchFrm)
		{
			$("#searchKvListm li").each(function()
			{
				var selValues = new Array();
				$("#selKvListm li").each(function()
				{
					selValues.push($(this).find('.vals').html());
				});
				//console.log(selValues);
				if($.inArray($(this).find('.vals').html(), selValues)==-1)
				{
					$('#selKvListm').append($(this));
				}
			});
		}
		else
		{
			$("#searchKvList li").each(function()
			{
				var selValues = new Array();
				$("#selKvList li").each(function()
				{
					selValues.push($(this).find('.vals').html());
				});
				//console.log(selValues);
				if($.inArray($(this).find('.vals').html(), selValues)==-1)
				{
					$('#selKvList').append($(this));
				}

			});
		}
		
		$('#searchModal').modal('hide');
		e.preventDefault();
	});
	
	
	
	///////////////////////////////////////////////////////////////////////////////////////////////
	/////////////////////////////////// ASSESSMENT TYPE DATEPICKER ////////////////////////////////
	///////////////////////////////////////////////////////////////////////////////////////////////
	//PUSAT (AMALI)
	$("#sddatefrom_PA").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends,
		onSelect: function(dateText, inst){
			$( "#sddateto_PA" ).datepicker( "option", "minDate", dateText );
			$( "#udtid_5_PA" ).datepicker( "option", "minDate", dateText );
			$( "#udtid_6_PA" ).datepicker( "option", "minDate", dateText );
			$( "#udtid_3_PA" ).datepicker( "option", "minDate", dateText );
			
			$('#progress').html('<img src="'+base_url+'assets/img/loading_ajax.gif"'+
					'alt="Sedang process"/>Sila tunggu...');
			$("#tblUserdate_PT").hide();
			$("#tblUserdate_PAK").hide();
			
			setTimeout(function()
			{
				$('#progress').html("PUSAT (AMALI)");
				$("#tblUserdate_PA").show();
			}, 500);
		}
	});
	
	$("#sddateto_PA").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends,
		onSelect: function(dateText, inst){
			$( "#udtid_5_PA" ).datepicker( "option", "maxDate", dateText );
			$( "#udtid_6_PA" ).datepicker( "option", "maxDate", dateText );
			$( "#udtid_3_PA" ).datepicker( "option", "maxDate", dateText );
			
			check_working_days(dateText,"PA","A");
			
			$('#progress').html('<img src="'+base_url+'assets/img/loading_ajax.gif"'+
			'alt="Sedang process"/>Sila tunggu...');
			$("#tblUserdate_PT").hide();
			$("#tblUserdate_PAK").hide();
						
			setTimeout(function()
			{
				$('#progress').html("PUSAT (AMALI)");
				$("#tblUserdate_PA").show();
			}, 500);
		}
	});
	
	//PUSAT (TEORI)
	$("#sddatefrom_PT").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends,
		onSelect: function(dateText, inst){
			$( "#sddateto_PT" ).datepicker( "option", "minDate", dateText );
			$( "#udtid_5_PT" ).datepicker( "option", "minDate", dateText );
			$( "#udtid_6_PT" ).datepicker( "option", "minDate", dateText );
			$( "#udtid_3_PT" ).datepicker( "option", "minDate", dateText );
			
			$('#progress').html('<img src="'+base_url+'assets/img/loading_ajax.gif"'+
					'alt="Sedang process"/>Sila tunggu...');
			$("#tblUserdate_PA").hide();
			$("#tblUserdate_PAK").hide();
			
			setTimeout(function()
			{
				$('#progress').html("PUSAT (TEORI)");
				$("#tblUserdate_PT").show();
			}, 500);
		}
	});
	
	$("#sddateto_PT").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends,
		onSelect: function(dateText, inst){
			$( "#udtid_5_PT" ).datepicker( "option", "maxDate", dateText );
			$( "#udtid_6_PT" ).datepicker( "option", "maxDate", dateText );
			$( "#udtid_3_PT" ).datepicker( "option", "maxDate", dateText );
			
			check_working_days(dateText,"PT","A");
			
			$('#progress').html('<img src="'+base_url+'assets/img/loading_ajax.gif"'+
			'alt="Sedang process"/>Sila tunggu...');
			$("#tblUserdate_PA").hide();
			$("#tblUserdate_PAK").hide();
			
			setTimeout(function()
			{
				$('#progress').html("PUSAT (TEORI)");
				$("#tblUserdate_PT").show();
			}, 500);
		}
	});
		
	/////////////////////
	//Manual Datepicker//
	/////////////////////
	
	//PUSAT (AMALI)
	$("#sdmdatefrom_PA").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends,
		onSelect: function(dateText, inst){
			$( "#sdmdateto_PA" ).datepicker( "option", "minDate", dateText );
			$( "#udtmid_5_PA" ).datepicker( "option", "minDate", dateText );
			$( "#udtmid_6_PA" ).datepicker( "option", "minDate", dateText );
			$( "#udtmid_3_PA" ).datepicker( "option", "minDate", dateText );
			
			$('#progressm').html('<img src="'+base_url+'assets/img/loading_ajax.gif"'+
					'alt="Sedang process"/>Sila tunggu...');
			$("#tblUsermdate_PT").hide();
			$("#tblUsermdate_PAK").hide();
			
			setTimeout(function()
			{
				$('#progressm').html("PUSAT (AMALI)");
				$("#tblUsermdate_PA").show();
			}, 500);
		}
	});
	
	$("#sdmdateto_PA").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends,
		onSelect: function(dateText, inst){
			$( "#udtmid_5_PA" ).datepicker( "option", "maxDate", dateText );
			$( "#udtmid_6_PA" ).datepicker( "option", "maxDate", dateText );
			$( "#udtmid_3_PA" ).datepicker( "option", "maxDate", dateText );
			
			check_working_days(dateText,"PA");
			
			$('#progressm').html('<img src="'+base_url+'assets/img/loading_ajax.gif"'+
			'alt="Sedang process"/>Sila tunggu...');
			$("#tblUsermdate_PT").hide();
			$("#tblUsermdate_PAK").hide();
			
			setTimeout(function()
			{
				$('#progressm').html("PUSAT (AMALI)");
				$("#tblUsermdate_PA").show();
			}, 500);
		}
	});
	
	//PUSAT (TEORI)
	$("#sdmdatefrom_PT").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends,
		onSelect: function(dateText, inst){
			$( "#sdmdateto_PT" ).datepicker( "option", "minDate", dateText );
			$( "#udtmid_5_PT" ).datepicker( "option", "minDate", dateText );
			$( "#udtmid_6_PT" ).datepicker( "option", "minDate", dateText );
			$( "#udtmid_3_PT" ).datepicker( "option", "minDate", dateText );
			
			$('#progressm').html('<img src="'+base_url+'assets/img/loading_ajax.gif"'+
					'alt="Sedang process"/>Sila tunggu...');
			$("#tblUsermdate_PA").hide();
			$("#tblUsermdate_PAK").hide();
			 
			setTimeout(function()
			{
				$('#progressm').html("PUSAT (TEORI)");
				$("#tblUsermdate_PT").show();
			}, 500);
		}
	});
	
	$("#sdmdateto_PT").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends,
		onSelect: function(dateText, inst){
			$( "#udtmid_5_PT" ).datepicker( "option", "maxDate", dateText );
			$( "#udtmid_6_PT" ).datepicker( "option", "maxDate", dateText );
			$( "#udtmid_3_PT" ).datepicker( "option", "maxDate", dateText );
			
			check_working_days(dateText,"PT");
			
			$('#progressm').html('<img src="'+base_url+'assets/img/loading_ajax.gif"'+
			'alt="Sedang process"/>Sila tunggu...');
			$("#tblUsermdate_PA").hide();
			$("#tblUsermdate_PAK").hide();
			
			setTimeout(function()
			{
				$('#progressm').html("PUSAT (TEORI)");
				$("#tblUsermdate_PT").show();
			}, 500);
		}
	});
			
	/////////////////////
	//ACADEMIC (CENTRE)//
	/////////////////////
	//AKADEMIK (PUSAT)
	$("#sddatefrom_PAK").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends,
		onSelect: function(dateText, inst){
			$( "#sddateto_PAK" ).datepicker( "option", "minDate", dateText );
			$( "#udtid_5_PAK" ).datepicker( "option", "minDate", dateText );
			$( "#udtid_6_PAK" ).datepicker( "option", "minDate", dateText );
			$( "#udtid_3_PAK" ).datepicker( "option", "minDate", dateText );
			
			$('#progress').html('<img src="'+base_url+'assets/img/loading_ajax.gif"'+
					'alt="Sedang process"/>Sila tunggu...');
			$("#tblUserdate_PT").hide();
			$("#tblUserdate_PA").hide();
			
			setTimeout(function()
			{
				$('#progress').html("AKADEMIK (PUSAT)");
				$("#tblUserdate_PAK").show();
			}, 500);
		}
	});
	
	$("#sddateto_PAK").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends,
		onSelect: function(dateText, inst){
			$( "#udtid_5_PAK" ).datepicker( "option", "maxDate", dateText );
			$( "#udtid_6_PAK" ).datepicker( "option", "maxDate", dateText );
			$( "#udtid_3_PAK" ).datepicker( "option", "maxDate", dateText );
			
			check_working_days(dateText,"PAK","A");
			
			$('#progress').html('<img src="'+base_url+'assets/img/loading_ajax.gif"'+
			'alt="Sedang process"/>Sila tunggu...');
			$("#tblUserdate_PT").hide();
			$("#tblUserdate_PA").hide();
			
			setTimeout(function()
			{
				$('#progress').html("AKADEMIK (PUSAT)");
				$("#tblUserdate_PAK").show();
			}, 500);
		}
	});

	
	//AKADEMIK (SEKOLAH)
	$("#sddatefrom_SAK").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends,
		onSelect: function(dateText, inst){
			$( "#sddateto_SAK" ).datepicker( "option", "minDate", dateText );
			$( "#udtid_5_SAK" ).datepicker( "option", "minDate", dateText );
			$( "#udtid_6_SAK" ).datepicker( "option", "minDate", dateText );
			$( "#udtid_3_SAK" ).datepicker( "option", "minDate", dateText );
			
			$('#progressak').html('<img src="'+base_url+'assets/img/loading_ajax.gif"'+
					'alt="Sedang process"/>Sila tunggu...');
			$("#tblUserdate_PAK").hide();
			
			setTimeout(function()
			{
				$('#progressak').html("AKADEMIK (SEKOLAH)");
				$("#tblUserdate_SAK").show();
			}, 500);
		}
	});
	
	$("#sddateto_SAK").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends,
		onSelect: function(dateText, inst){
			$( "#udtid_5_SAK" ).datepicker( "option", "maxDate", dateText );
			$( "#udtid_6_SAK" ).datepicker( "option", "maxDate", dateText );
			$( "#udtid_3_SAK" ).datepicker( "option", "maxDate", dateText );
			
			check_working_days(dateText,"SAK","A");
			
			$('#progressak').html('<img src="'+base_url+'assets/img/loading_ajax.gif"'+
			'alt="Sedang process"/>Sila tunggu...');
			$("#tblUserdate_PAK").hide();
			
			setTimeout(function()
			{
				$('#progressak').html("AKADEMIK (SEKOLAH)");
				$("#tblUserdate_SAK").show();
			}, 500);
		}
	});
	
	
	////////////////////////////
	//ACADEMIC (CENTRE) Manual//
	////////////////////////////
	//AKADEMIK (PUSAT) Manual
	$("#sdmdatefrom_PAK").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends,
		onSelect: function(dateText, inst){
			$( "#sdmdateto_PAK" ).datepicker( "option", "minDate", dateText );
			$( "#udtmid_5_PAK" ).datepicker( "option", "minDate", dateText );
			$( "#udtmid_6_PAK" ).datepicker( "option", "minDate", dateText );
			$( "#udtmid_3_PAK" ).datepicker( "option", "minDate", dateText );
			
			$('#progressm').html('<img src="'+base_url+'assets/img/loading_ajax.gif"'+
					'alt="Sedang process"/>Sila tunggu...');
			$("#tblUsermdate_PA").hide();
			$("#tblUsermdate_PT").hide();
			
			setTimeout(function()
			{
				$('#progressm').html("AKADEMIK (PUSAT)");
				$("#tblUsermdate_PAK").show();
			}, 500);
		}
	});
	
	$("#sdmdateto_PAK").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends,
		onSelect: function(dateText, inst){
			$( "#udtmid_5_PAK" ).datepicker( "option", "maxDate", dateText );
			$( "#udtmid_6_PAK" ).datepicker( "option", "maxDate", dateText );
			$( "#udtmid_3_PAK" ).datepicker( "option", "maxDate", dateText );
			
			check_working_days(dateText,"PAK");
			
			$('#progressm').html('<img src="'+base_url+'assets/img/loading_ajax.gif"'+
			'alt="Sedang process"/>Sila tunggu...');
			$("#tblUsermdate_PA").hide();
			$("#tblUsermdate_PT").hide();
			
			setTimeout(function()
			{
				$('#progressm').html("AKADEMIK (PUSAT)");
				$("#tblUsermdate_PAK").show();
			}, 500);
		}
	});

	
	//AKADEMIK (SEKOLAH)
	$("#sdmdatefrom_SAK").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends,
		onSelect: function(dateText, inst){
			$( "#sdmdateto_SAK" ).datepicker( "option", "minDate", dateText );
			$( "#udtmid_5_SAK" ).datepicker( "option", "minDate", dateText );
			$( "#udtmid_6_SAK" ).datepicker( "option", "minDate", dateText );
			$( "#udtmid_3_SAK" ).datepicker( "option", "minDate", dateText );
			
			$('#progressmak').html('<img src="'+base_url+'assets/img/loading_ajax.gif"'+
					'alt="Sedang process"/>Sila tunggu...');
			$("#tblUsermdate_PAK").hide();
			
			setTimeout(function()
			{
				$('#progressmak').html("AKADEMIK (SEKOLAH)");
				$("#tblUsermdate_SAK").show();
			}, 500);
		}
	});
	
	$("#sdmdateto_SAK").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends,
		onSelect: function(dateText, inst){
			$( "#udtmid_5_SAK" ).datepicker( "option", "maxDate", dateText );
			$( "#udtmid_6_SAK" ).datepicker( "option", "maxDate", dateText );
			$( "#udtmid_3_SAK" ).datepicker( "option", "maxDate", dateText );
			
			check_working_days(dateText,"SAK");
			
			$('#progressmak').html('<img src="'+base_url+'assets/img/loading_ajax.gif"'+
			'alt="Sedang process"/>Sila tunggu...');
			$("#tblUsermdate_PAK").hide();
			
			setTimeout(function()
			{
				$('#progressmak').html("AKADEMIK (SEKOLAH)");
				$("#tblUsermdate_SAK").show();
			}, 500);
		}
	});
	
	
	///////////////////
	//User Level Date//
	///////////////////
	$("#udtid_5_PA").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	$("#udtid_6_PA").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	
	$("#udtid_3_PA").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	$("#udtid_5_PT").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	$("#udtid_6_PT").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	
	$("#udtid_3_PT").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	$("#udtid_5_SA").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	$("#udtid_6_SA").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	
	$("#udtid_3_SA").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	$("#udtid_5_ST").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	$("#udtid_6_ST").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	
	$("#udtid_3_ST").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	
	////////////////////////////
	//User Level Date (MANUAL)//
	////////////////////////////
	$("#udtmid_5_PA").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	$("#udtmid_6_PA").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	
	$("#udtmid_3_PA").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	$("#udtmid_5_PT").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	$("#udtmid_6_PT").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	
	$("#udtmid_3_PT").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	$("#udtmid_5_SA").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	$("#udtmid_6_SA").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	
	$("#udtmid_3_SA").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	$("#udtmid_5_ST").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	$("#udtmid_6_ST").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	
	$("#udtmid_3_ST").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	
	//////////////////////////////
	/////Call Modal Search KV/////
	//////////////////////////////
	$('#searchKv, #searchmKv').tooltip();

	$('#searchKv, #searchmKv').click(function(){
		 searchFrm = $(this).attr('id');
		 
		 if("searchmKv" == searchFrm)
			 $('#searchKvList').attr('id','searchKvListm');
		 else
			 $('#searchKvListm').attr('id','searchKvList');
		
		 $('#searchForm').val(searchFrm);
		 $('#Hkv > tbody').html("");
		 $('#searchModal').modal({
                keyboard: false,
				backdrop: 'static'
		 });
	});
	
	
	//////////////////////////////
	//User Level Date (ACADEMIC)//
	//////////////////////////////
	$("#udtid_5_PAK").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	$("#udtid_6_PAK").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	$("#udtid_3_PAK").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	$("#udtid_5_SAK").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	$("#udtid_6_SAK").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	$("#udtid_3_SAK").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	
	/////////////////////////////////////
	//User Level Date (ACADEMIC) Manual//
	/////////////////////////////////////
	$("#udtmid_5_PAK").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	$("#udtmid_6_PAK").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	$("#udtmid_3_PAK").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	$("#udtmid_5_SAK").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	$("#udtmid_6_SAK").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	$("#udtmid_3_SAK").datepicker({
		dateFormat: 'dd-mm-yy',
		showAnim:"slideDown",
		changeMonth: true,
		changeYear: true,
		beforeShowDay: $.datepicker.noWeekends
	});
	
	
	//////////////
	// Btn user //
	//////////////
	$('#btnUserPA').tooltip();
	$('#btnUserPA').click(function(){
		
		$('#progress').html('<img src="'+base_url+'assets/img/loading_ajax.gif"'+
		'alt="Sedang process"/>Sila tunggu...');
		
		$("#tblUserdate_PT").hide();
		$("#tblUserdate_PAK").hide();
		
		setTimeout(function()
		{
			$('#progress').html("PUSAT (AMALI)");
			$("#tblUserdate_PA").show();
		}, 500);
	});
	
	$('#btnUserPT').tooltip();
	$('#btnUserPT').click(function(){
		$('#progress').html('<img src="'+base_url+'assets/img/loading_ajax.gif"'+
		'alt="Sedang process"/>Sila tunggu...');
		
		$("#tblUserdate_PA").hide();
		$("#tblUserdate_PAK").hide();
		
		setTimeout(function()
		{
			$('#progress').html("PUSAT (TEORI)");
			$("#tblUserdate_PT").show();
		}, 500);	
		
	});
	
	//////////////////////
	// Btn user (manual)//
	//////////////////////
	$('#btnUsermPA').tooltip();
	$('#btnUsermPA').click(function(){
		
		$('#progressm').html('<img src="'+base_url+'assets/img/loading_ajax.gif"'+
		'alt="Sedang process"/>Sila tunggu...');
		
		$("#tblUsermdate_PT").hide();
		$("#tblUsermdate_PAK").hide();
		
		setTimeout(function()
		{
			$('#progressm').html("PUSAT (AMALI)");
			$("#tblUsermdate_PA").show();
		}, 500);
	});
	
	$('#btnUsermPT').tooltip();
	$('#btnUsermPT').click(function(){
		$('#progressm').html('<img src="'+base_url+'assets/img/loading_ajax.gif"'+
		'alt="Sedang process"/>Sila tunggu...');
		
		$("#tblUsermdate_PA").hide();
		$("#tblUsermdate_PAK").hide();
		
		setTimeout(function()
		{
			$('#progressm').html("PUSAT (TEORI)");
			$("#tblUsermdate_PT").show();
		}, 500);	
		
	});

	///////////////////////
	// Btn user academic //
	///////////////////////
	$('#btnUserPAK').tooltip();
	$('#btnUserPAK').click(function(){
		$('#progress').html('<img src="'+base_url+'assets/img/loading_ajax.gif"'+
		'alt="Sedang process"/>Sila tunggu...');
		
		$("#tblUserdate_PT").hide();
		$("#tblUserdate_PA").hide();
		
		setTimeout(function()
		{
			$('#progress').html("AKADEMIK (PUSAT)");
			$("#tblUserdate_PAK").show();
		}, 500);
	});
	
	////////////////////////////////
	// Btn user academic (Manual) //
	////////////////////////////////
	$('#btnUsermPAK').tooltip();
	$('#btnUsermPAK').click(function(){
		$('#progressm').html('<img src="'+base_url+'assets/img/loading_ajax.gif"'+
		'alt="Sedang process"/>Sila tunggu...');
		
		$("#tblUsermdate_PA").hide();
		$("#tblUsermdate_PT").hide();
		
		setTimeout(function()
		{
			$('#progressm').html("AKADEMIK (PUSAT)");
			$("#tblUsermdate_PAK").show();
		}, 500);
	});
	
});//end of document.ready


/**************************************************************************************************
* Description		: this function to convert timestamp to normal date
* input				: timestamp
* author			: Freddy Ajang Tony
* Date				: 03 July 2013
* Modification Log	: -
**************************************************************************************************/
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
		
	return date+'-'+month+'-'+year;
}


/**************************************************************************************************
* Description		: this function to check working days when set date.
* input				: date,category
* author			: Freddy Ajang Tony
* Date				: 09 July 2013
* Modification Log	: -
**************************************************************************************************/
function check_working_days(date,category,type)
{
	var month = new Array(0,31,28,31,30,31,30,31,31,30,31,30,31);
	
	// Change the format dd-mm-yy to mm-dd-yy for getDay
	var datepick = new Date(date.replace( /(\d{2})-(\d{2})-(\d{4})/, "$2/$1/$3"));
	
	//get day from date 0-Sunday,1-Monday,2-Tuesday,3-Wednesday,4-Thursday,5-Friday,6-Saturday
	var day = datepick.getDay();
	
	//get day date
	var daydate = datepick.getDate();
	var monthdate = datepick.getMonth();
	var yeardate = datepick.getFullYear();
	monthdate++;
	
	var lvl2_day = day-2;
	var lvl1_day;
	var daydatel1;
	
	//For Timbalan Pegarah date
	if(lvl2_day == 0) //If new date on Sunday
	{	
		lvl2_day = 5; //Change to Friday
		daydate -= 4;
		
		
	}
	else if(lvl2_day == -1) //If new date on Saturday
	{
		lvl2_day = 4; //Change to Thursday
		daydate -= 4;
	}
	else //If on working day
	{
		daydate -= 2; 
	}
	
	if(daydate < 1) //If date below 1, change new month.
	{
		monthdate -= 1;
		
		daydate += month[monthdate];
	}
	
	var fullDate = daydate+'-'+monthdate+'-'+yeardate;
	
	//For KUPP/KJPP/Pensyarah Date
	daydatel1 = daydate-2;
	
	lvl1_day = lvl2_day -2;
	
	if(lvl1_day == 0) //If new date on Sunday
	{	
		lvl1_day = 5; //Change to Friday
		daydatel1 -= 2;
	}
	else if(lvl1_day == -1) //If new date on Saturday
	{
		lvl1_day = 4; //Change to Thursday
		daydatel1-=2;
	}
	
	if(daydatel1 < 1) //If date below 1, change new month.
	{
		monthdate -= 1;
		
		daydatel1 += month[monthdate];
	}
	
	var fullDatel1 = daydatel1+'-'+monthdate+'-'+yeardate;
	
	if(type != null)
	{
		$( "#udtid_5_"+category+"" ).datepicker( "setDate", date );
		$( "#udtid_6_"+category+"" ).datepicker( "setDate", fullDate );
		$( "#udtid_3_"+category+"" ).datepicker( "setDate", fullDatel1 );
	}
	else
	{
		$( "#udtmid_5_"+category+"" ).datepicker( "setDate", date );
		$( "#udtmid_6_"+category+"" ).datepicker( "setDate", fullDate );
		$( "#udtmid_3_"+category+"" ).datepicker( "setDate", fullDatel1 );
	}
}


/**************************************************************************************************
* Description		: this function get data by semester
* input				: sem
* author			: Freddy Ajang Tony
* Date				: 29 July 2013
* Modification Log	: -
**************************************************************************************************/
function fnGetGroupSemester(sem,type,sessionyear)
{
	var listsem = sem.split(',');
	var sesiYear = sessionyear.split(':');
	
	//Reset data
	fnResetData();
	
	/*for(var i=1;i<=8;i++)
	{
		$('#chkSem'+i+'').removeAttr("disabled");
		$('#chkSem'+i+'').prop("checked", false);
	}*/
	if(semesterDisable.length > 0)
	{
		$(semesterDisable).each(function(index){
			$('#chkSem'+semesterDisable[index]+'').prop("checked", false);
			$("input[id='chkSem"+semesterDisable[index]+"']").attr("disabled", "disabled");
		});
			
		
	}
	
	$('#chkSem'+sem+'').removeAttr("disabled");
	$('#chkSem'+sem+'').prop("checked", false);
	
	
	
	//alert(type);
	if(sem != -1)
	{
		var request = $.ajax({
			url: site_url+"/examination/assessment/assessment_config_by_semester",
			type: "POST",
			data: {semester : sem,
				   type : type,
				   sesi : sesiYear[0],
				   tahun : sesiYear[1]},
			dataType: "json"
		});
		
		request.done(function(data){
			//console.log(data);
				
			if(data !== null)
			{
				if("vk" == type)
				{
					$(listsem).each(function(index){
						$('#chkSem'+listsem[index]+'').prop("checked", true);
						$('#chkSem'+listsem[index]+'').removeAttr("disabled");
					});
				}
				else
				{
					$(listsem).each(function(index){
						$('#chkakSem'+listsem[index]+'').prop("checked", true);
						$('#chkakSem'+listsem[index]+'').removeAttr("disabled");
					});
				}
				
				
				
				$(data.semester_config).each(function(index)
				{
					var sdconfigid = data.semester_config[index].sdconfig_id;
					var sddatefrom = convert_timestamp(data.semester_config[index].sd_open_date);
					var sddateto = convert_timestamp(data.semester_config[index].sd_close_date);
					var sdassessmenttype = data.semester_config[index].sd_assessment_type;
					
					
					//insert data to each assessment type in penetapan kemasukkan pentaksiran
					$('#sdconfig_id_'+sdassessmenttype+'').val(sdconfigid);
					$('#sddatefrom_'+sdassessmenttype+'').val(sddatefrom);
					$('#sddateto_'+sdassessmenttype+'').val(sddateto);
					$('#ulmsdconfig_id_'+sdassessmenttype+'').val(sdconfigid);
					
					$(data.semester_config[index].userlist).each(function(index2)
					{
						//var ulmuserid = data.semester_config[index].userlist[index2].ul_id;
						var ulmuserids = data.semester_config[index].userlist[index2].ul_ids;
						var ulmname = data.semester_config[index].userlist[index2].ul_names;
						var ulmsdconfigid = data.semester_config[index].userlist[index2].sdconfig_id;
						var ulmconfigid = data.semester_config[index].userlist[index2].ulmconfig_ids;
						var ulmenddate = convert_timestamp(data.semester_config[index].userlist[index2].end_date_user);
						//alert(ulmuserids.substr(0,1));
						
						//insert data to each user in penetapan kemasukkan pentaksiran
						$('#ulmconfig_id_'+ulmuserids.substr(0,1)+'_'+sdassessmenttype+'').val(ulmconfigid);
						$('#udtid_'+ulmuserids.substr(0,1)+'_'+sdassessmenttype+'').val(ulmenddate);
						
						
						
					});
					
				});
			}
			else
			{
				if("vk" == type)
				{
					document.getElementById("frmOpenSetting").reset();
				}
				else
				{
					document.getElementById("frmOpenSettingAK").reset();
				}
				
				//$('#selsem option[value="' + sem +'"]').prop("selected", true);
				
			}
		});
		
		request.fail(function(jqXHR, textStatus){
			//alert("Request failed"+ textStatus);
		});
	}
}


/**************************************************************************************************
* Description		: this function to delete kv in manual configuration
* input				: col_id
* author			: Freddy Ajang Tony
* Date				: 03 September 2013
* Modification Log	: -
**************************************************************************************************/
function fnDelete(col_id,session)
{
	var id_to_delete = $('#mclosebtn_'+col_id+'').find('.kvid').html();
	var li = $('#mclosebtn_'+col_id+'').parent();

	var opts = new Array();
	opts['heading'] = 'Memadam Pembukaan Pentaksiran Pelajar';
	opts['hidecallback'] = true;
	opts['callback'] = function()
	{
		if(id_to_delete!=null && id_to_delete.length>0)
		{
			 $.blockUI({ 
				message: '<h5><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h5>', 
				css: { border: '3px solid #660a30' } 
        	}); 
			
			//ajax submit to delete
			var request = $.ajax({
				url: site_url+"/examination/assessment/delete_manual_configuration",
				type: "POST",
				data: {fid : id_to_delete,
					   sesi : session},
				dataType: "html"
			});

			request.done(function(data) {
				$.unblockUI();
				if(data.length>0 && data>0)
				{
					var opts = new Array();
					opts['heading'] = 'Berjaya';
					opts['content'] = 'rekod berjaya dipadam';
					
					if(li.parent().find('li').size()==1)
						li.closest('tr').remove();
					
					li.remove();
					
					kv_alert(opts);
					
				}
				else
				{
					var opts = new Array();
					opts['heading'] = 'Tidak Berjaya';
					opts['content'] = 'rekod berjaya dipadam';
					kv_alert(opts);
				}
			});

			request.fail(function(jqXHR, textStatus) {
				$.unblockUI();
				//msg("Request failed", textStatus, "Ok");
				alert("Request failed"+ textStatus);
			});
		}
	};
	
	
	opts['cancelCallback'] = function(){/*do nothing*/};
	kv_confirm(opts);
}


/**************************************************************************************************
* Description		: this function to populate data
* input				: data
* author			: Freddy Ajang Tony
* Date				: 04 September 2013
* Modification Log	: -
**************************************************************************************************/
function fnPopulateStatus(sessionYear)
{
	var indexData = 0;
	var dataLength = 0;
	var semester = 1;
	var tblRowDataT = "";
	var tblRowDataAK = "";
	var indexsem = "";
	var indexmsem = "";
	
	var request = $.ajax({
		url: site_url+"/examination/assessment/assessment_config",
		type: "POST",
		data: {sesi : sessionYear},
		dataType: "json"
	});
	
	request.done(function(data){
		//console.log(data);
		if(data != null && data.sdconfig.length>0)
			dataLength = data.sdconfig.length;
		
		//Show each data (submit_date_configuration)
		for(var irowType = 0 ; irowType < 3 ; irowType++)
		{
			var sdconfigid = 0;
			var sdassessmenttype = "";
			var sddatefrom = "";
			var sddateto = "";
			var sd_from = ""; 
			var sd_date_from = "";
			var sd_to = "";
			var sd_date_to = "";
			var status = "Tutup";
			var statustext = "";
			var sdtypename = "";
			var csstype = "dred";
			var sdcursemester = 0;

			if(indexData < dataLength)
			{
				sdassessmenttype = data.sdconfig[indexData].sd_assessment_type;
				sdcursemester = data.sdconfig[indexData].sd_current_semester;
				//alert(sdassessmenttype);
				if(sdassessmenttype == typeAcro[irowType] && semester == sdcursemester)
				{
					sdconfigid = data.sdconfig[indexData].sdconfig_id;
					sddatefrom = convert_timestamp(data.sdconfig[indexData].sd_open_date);
					sddateto = convert_timestamp(data.sdconfig[indexData].sd_close_date);
					
					//For Compare Date
					sd_from = sddatefrom.split('-');
					sd_to = sddateto.split('-');
					sd_date_from = new Date(sd_from[1]+'-'+sd_from[0]+'-'+sd_from[2]).getTime();
					sd_date_to = new Date(sd_to[1]+'-'+sd_to[0]+'-'+sd_to[2]).getTime();
				}
			}
			
			if(today_date <= sd_date_to && today_date >= sd_date_from)
			{	
				status = "Buka";
				statustext = "Kemasukan Pentaksiran kini dibuka dari";
				csstype = "bblue";
			}
			
			if(today_date <= sd_date_from)
			{
				status = "";
				statustext = "Kemasukan Pentaksiran akan dibuka dari";
				csstype = "bblue";
			}
			
			indexsem = semester+""+irowType;
			//alert(indexsem);
			
			if("PA" == typeAcro[irowType])
			{
				sdtypename = "Pusat (Amali)";
				
				if(semester > 1)
				{
					tblRowDataT +=	
		  				'<div class="tab-pane" id="tab_sem'+semester+'">'+
						'<div class="accordion" id="accordion_status'+semester+'">';
				}
				else
				{
					tblRowDataT +=	
		  				'<div class="tab-pane active " id="tab_sem'+semester+'">'+
						'<div class="accordion" id="accordion_status'+semester+'">';
				}
				
			}
			else if("PT" == typeAcro[irowType])
			{
				sdtypename = "Pusat (Teori)";
			}
			else
			{
				sdtypename = "Akademik (Pusat)";
			}
			
			tblRowDataT +=
				'<div class="accordion-group">'+
				'<div class="accordion-heading">'+
				'<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_status" href="#collapse'+indexsem+'">'+
				'<strong id="menutitle">'+sdtypename+'</strong>'+
				'<strong class="tablepadding '+csstype+'">&nbsp;&nbsp; : &nbsp;'+status+' </strong>'+
				''+statustext+' ';
				
			if("" != statustext)
			{
				tblRowDataT +=
					'<span class="bblue">'+sddatefrom+'</span> hingga <span class="bblue">'+sddateto+'</span>';
			}
			
			tblRowDataT +=
				'&nbsp;&nbsp;<i class="icon-chevron-down pull-right"></i>'+
				'</a></div>'+
				'<div id="collapse'+indexsem+'" class="accordion-body collapse">'+
				'<div class="accordion-inner">'+
				'<table style="width:400px; margin-left:100px;" class="table table-bordered table-condensed" >'+
				'<tr><td><strong class="tablepadding"> Jawatan </strong></td>'+
				'<td><strong class="tablepadding"> Tarikh Tutup </strong></td></tr>';
			
			for(var irowData = 0 ; irowData < 3 ; irowData++)
			{
				var ulmenddate = "";
				//alert(indexData+"/"+irowData+"/"+irowType);
				if(indexData < dataLength)
				{
					ulmenddate = convert_timestamp(data.sdconfig[indexData].userlist[irowData].end_date_user);
				}
				tblRowDataT +=
					'<tr><td> '+typePosition[irowData]+' : </td>';
				
				if("Tutup" == status)
					tblRowDataT += '<td><span class="dred"> Tutup </span></td></tr>';
				else
					tblRowDataT += '<td><span class="bblue"> '+ulmenddate+' </span></td></tr>';
			}
			
			tblRowDataT +=
				'</table>'+
				'</div>'+
				'</div>'+
				'</div>';
			
			if(typeAcro[irowType] == sdassessmenttype && semester == sdcursemester )
			{
				indexData++;
			}
			
			if(("PAK" == typeAcro[irowType]) && semester < 9)
			{
				tblRowDataT +=
					'</div>'+
					'</div>';
				//alert('semester: '+semester);
				$('#tab_sem'+semester+'').html("");
				$('#tab_sem'+semester+'').html(tblRowDataT);
				
				tblRowDataT = "";
				irowType = -1;
				semester++;
			}
			//collapseindex = index+1;
			indexsem++;
			
			if(semester > 8)
				break;
		}
		
		
				
		// For manual configuration
		var tblRowDataM = "";
		tblRowDataM  += 
			'<tr id="status_manual">'+
			'<td width="10%" style="vertical-align:top" ><strong class="tablepadding">Status Pembukaan Manual</strong></td>'+
			'<td>'+
			'<table class="table table-bordered"><tr>'+
			'<th width="29%">Senarai KV</th>'+
			'<th width="71%">Tarikh</th></tr>';
		
		var sdmlength = 1;
		
		if(data != null && data.sdmconfig.length>0)
		{
			sdmlength = data.sdmconfig.length;
			
			if(data.sdmconfig.length == 0)
				sdmlength = 1;
		}
		
		
		//Loop for each data in each row table
		for(var sdmData = 0 ; sdmData < sdmlength ; sdmData++)
		{
			var indexmData = 0;
			var datamLength = 0;
			
			tblRowDataM +=
				'<tr><td>';
				
			
			if(data != null && data.sdmconfig.length>0)
			{
				datamLength = data.sdmconfig[sdmData].assessment_type.length;
				
				tblRowDataM +=
					'<ul class="sul" style="width:98%">';
				
				//Add KVlist
				$(data.sdmconfig[sdmData].kvslist).each(function(index)
				{
					var sdmcolid = data.sdmconfig[sdmData].kvslist[index].col_id;
					var sdmcolcode = data.sdmconfig[sdmData].kvslist[index].col_code;
					var sdmcolname = data.sdmconfig[sdmData].kvslist[index].col_name;
					var sdmcoltype = data.sdmconfig[sdmData].kvslist[index].col_type;
						
					tblRowDataM +=
						'<li class="items" style="width:97%">'+sdmcoltype+''+sdmcolcode+' - '+sdmcolname+''+
						'<div class="mclosebtn" id="mclosebtn_'+sdmcolid+'" onclick ="fnDelete(\''+sdmcolid+'\',\''+sessionYear+'\');">'+
						'<span class="kvid">'+sdmcolid+'</span></div>'+
						'</li>';
				});
				
				tblRowDataM +=
					'</ul>';
			}

			
			tblRowDataM +=
				'</td>'+
				'<td>'+
				'<ul class="nav nav-tabs" id="myTabStatusManual">'+
				'<li class="active"><a href="#tab_m_sem1'+sdmData+'" data-toggle="tab"><p style="font-size:12px">Semester 1</p></a></li>'+
				'<li><a href="#tab_m_sem2'+sdmData+'" data-toggle="tab"><p style="font-size:12px">Semester 2</p></a></li>'+
				'<li><a href="#tab_m_sem3'+sdmData+'" data-toggle="tab"><p style="font-size:12px">Semester 3</p></a></li>'+
				'<li><a href="#tab_m_sem4'+sdmData+'" data-toggle="tab"><p style="font-size:12px">Semester 4</p></a></li>'+
				'<li><a href="#tab_m_sem5'+sdmData+'" data-toggle="tab"><p style="font-size:12px">Semester 5</p></a></li>'+
				'<li><a href="#tab_m_sem6'+sdmData+'" data-toggle="tab"><p style="font-size:12px">Semester 6</p></a></li>'+
				'<li><a href="#tab_m_sem7'+sdmData+'" data-toggle="tab"><p style="font-size:12px">Semester 7</p></a></li>'+
				'<li><a href="#tab_m_sem8'+sdmData+'" data-toggle="tab"><p style="font-size:12px">Semester 8</p></a></li>'+
				'</ul>'+
				'<div class="tab-content">';

			for(var sem = 1;sem<=8;sem++)
			{
				var sdmassessmenttype = "";
				var sdmcursemester = 0;
				
				if(sem == 1)
				{
					tblRowDataM +=	
		  				'<div class="tab-pane active" id="tab_m_sem'+sem+''+sdmData+'">'+
						'<div class="accordion" id="accordion_m_status'+sem+''+sdmData+'">';
				}
				else
				{
					tblRowDataM +=	
		  				'<div class="tab-pane" id="tab_m_sem'+sem+''+sdmData+'">'+
						'<div class="accordion" id="accordion_m_status'+sem+''+sdmData+'">';
				}
				
					for(var irowmType = 0 ; irowmType < 3 ; irowmType++)
					{
						
						var sdmConfigids = 0;
						var sdmOpendate = "";
						var sdmClosedate = "";
						var sdm_open = "";
						var sdm_open_date = "";
						var sdm_close = "";
						var sdm_close_date = "";
						var statusmtext = "";
						var sdmtypename = "";
						var status = "Tutup";
						var csstypem = "dred";
						
						if(indexmData < datamLength)
						{
							sdmassessmenttype = data.sdmconfig[sdmData].assessment_type[indexmData].sdm_assessment_type;
							sdmcursemester = data.sdmconfig[sdmData].assessment_type[indexmData].sdm_current_semester;
							
							if(sdmassessmenttype == typeAcro[irowmType] && sem == sdmcursemester)
							{
								sdmconfigid = data.sdmconfig[sdmData].assessment_type[indexmData].sdmconfig_ids;
								sdmOpendate = convert_timestamp(data.sdmconfig[sdmData].assessment_type[indexmData].sdm_open_date);
								sdmClosedate = convert_timestamp(data.sdmconfig[sdmData].assessment_type[indexmData].sdm_close_date);
								
								//For Compare Date
								sdm_open = sdmOpendate.split('-');
								sdm_close = sdmClosedate.split('-');
								sdm_open_date = new Date(sdm_open[1]+'-'+sdm_open[0]+'-'+sdm_open[2]).getTime();
								sdm_close_date = new Date(sdm_close[1]+'-'+sdm_close[0]+'-'+sdm_close[2]).getTime();
							}
							
						}
						
						if(today_date <= sdm_close_date && today_date >= sdm_open_date)
						{
							status = "Buka";
							statusmtext = "Kemasukan Pentaksiran kini dibuka dari";
							csstypem = "bblue";
						}
					
						if(today_date <= sdm_open_date)
						{
							status = "";
							statusmtext = "Kemasukan Pentaksiran akan dibuka dari";
							csstypem = "bblue";
						}
							
						
						indexmsem = sem+""+irowmType+""+sdmData;
						
						if("PA" == typeAcro[irowmType])
						{
							sdmtypename = "Pusat (Amali)";
						}
						else if("PT" == typeAcro[irowmType])
						{
							sdmtypename = "Pusat (Teori)";
						}
						else
						{
							sdmtypename = "Akademik (Pusat)";
						}
						
						tblRowDataM +=
							'<div class="accordion-group">'+
							'<div class="accordion-heading">'+
							'<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_status_manual" href="#collapseM'+indexmsem+'">'+
							'<strong id="menutitle">'+sdmtypename+'</strong>'+
							'<strong class="tablepadding '+csstypem+'">&nbsp;&nbsp; : &nbsp;'+status+' </strong>'+
							''+statusmtext+' ';
								
						if("" != statusmtext)
						{
							tblRowDataM +=
								'<span class="bblue">'+sdmOpendate+'</span> hingga <span class="bblue">'+sdmClosedate+'</span>';
						}
							
						tblRowDataM +=
							'&nbsp;&nbsp;<i class="icon-chevron-down pull-right"></i>'+
							'</a></div>'+
							'<div id="collapseM'+indexmsem+'" class="accordion-body collapse">'+
							'<div class="accordion-inner">'+
							'<table style="width:400px; margin-left:100px;" class="table table-bordered table-condensed" >'+
							'<tr><td><strong class="tablepadding"> Jawatan </strong></td>'+
							'<td><strong class="tablepadding"> Tarikh Tutup </strong></td></tr>';
						
						for(var irowmData = 0 ; irowmData < 3 ; irowmData++)
						{
								var ulmmenddate = "";
								//alert(indexmData+"/"+irowmData+"/"+datamLength);
								if(indexmData < datamLength)
								{
									//alert(data.sdmconfig[sdmData].assessment_type[indexmData].userlist[irowmData].end_date_user);
									ulmmenddate = convert_timestamp(data.sdmconfig[sdmData].assessment_type[indexmData].userlist[irowmData].end_date_user);
								}
								tblRowDataM +=
									'<tr><td> '+typePosition[irowmData]+' : </td>';
								
								if("Tutup" == status)
									tblRowDataM += '<td><span class="dred"> Tutup </span></td></tr>';
								else
									tblRowDataM += '<td><span class="bblue"> '+ulmmenddate+' </span></td></tr>';	
						}
						
						tblRowDataM +=
							'</table>'+
							'</div>'+
							'</div>'+
							'</div>';
						
						if(typeAcro[irowmType] == sdmassessmenttype && sem == sdmcursemester )
						{
							indexmData++;
						}
						
						indexmsem++;
					}
					
					tblRowDataM +=
						'</div>'+
						'</div>';
			}	
			tblRowDataM +=
				'</div>'+
				'</div>'+
				'</td></tr>';
				
		}
		
		tblRowDataM +=
			'</table></tr>';
		
		 
		$('#tblStatusSd').append(tblRowDataM);
		
	});
	
	request.fail(function(jqXHR, textStatus){
		//alert("Request failed"+ textStatus);
	});
	
	
	
}


/**************************************************************************************************
* Description		: this function to reset some data and hidden value in 
* 					  configuration when change value.
* input				: 
* author			: Freddy Ajang Tony
* Date				: 20 November 2013
* Modification Log	: -
**************************************************************************************************/
function fnResetData()
{
	//Reset hidden value to default : 0
	$('#sdconfig_id_PA').val(0);
	$('#sdconfig_id_PT').val(0);
	$('#sdconfig_id_PAK').val(0);
	$('#ulmsdconfig_id_PA').val(0);
	$('#ulmconfig_id_5_PA').val(0);
	$('#ulmconfig_id_6_PA').val(0);
	$('#ulmconfig_id_3_PA').val(0);
	$('#ulmsdconfig_id_PT').val(0);
	$('#ulmconfig_id_5_PT').val(0);
	$('#ulmconfig_id_6_PT').val(0);
	$('#ulmconfig_id_3_PT').val(0);
	$('#ulmsdconfig_id_PAK').val(0);
	$('#ulmconfig_id_5_PAK').val(0);
	$('#ulmconfig_id_6_PAK').val(0);
	$('#ulmconfig_id_3_PAK').val(0);
	
	//Reset input
	$('#sddatefrom_PA').val('');
	$('#sddateto_PA').val('');
	$('#udtid_5_PA').val('');
	$('#udtid_6_PA').val('');
	$('#udtid_3_PA').val('');
	$('#sddatefrom_PT').val('');
	$('#sddateto_PT').val('');
	$('#udtid_5_PT').val('');
	$('#udtid_6_PT').val('');
	$('#udtid_3_PT').val('');
	$('#sddatefrom_PAK').val('');
	$('#sddateto_PAK').val('');
	$('#udtid_5_PAK').val('');
	$('#udtid_6_PAK').val('');
	$('#udtid_3_PAK').val('');

}

/**************************************************************************************************
* End of kv.assessment.js
**************************************************************************************************/