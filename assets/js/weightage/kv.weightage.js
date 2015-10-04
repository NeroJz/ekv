/**************************************************************************************************
* File Name        : kv.weightage.js
* Description      : This File contain all of javascript for set weightage
* Author           : Freddy Ajang Tony
* Date             : 21 june 2013
* Version          : -
* Modification Log : -
* Function List	   : - 
**************************************************************************************************/



/**************************************************************************************************
* Description		: document ready function
* input				: -
* author			: Freddy Ajang Tony
* Date				: 21 June 2013
* Modification Log	: -
**************************************************************************************************/
var year;
var modType;

$(document).ready(function(){
	
	
	
	$('#frmWeightage').on("click",'input[name="rdType"]',function(){
		//modType = $(this).val();
		modType = $('input[name="rdType"]:checked').val();
		$('#subkredit').val("");
		$('#subsem').val("");
		$('#btn_config_weightage').attr("disabled", "true");
		//alert(modType);
		$('#tdmdl').html('<img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sila tunggu...');
		
		setTimeout(function()
		{
			var request = $.ajax({
				url: site_url+"/examination/weightage/get_module_list",
				type: "POST",
				data: {rdmodType : modType},
				dataType: "html"
				});
			
			request.done(function(msg) {
				//alert("Berjaya");
				//alert(msg);
				//console.log(msg);
				$('#tdmdl').html(msg);
			});
			
			request.fail(function(jqXHR, textStatus) {
				//alert("Gagal");
				//Do nothing
			});
		}, 1500);
		
	});
	
	$('#frmWeightage').on("change",'#mdl',function(){
		
		if($(this).val()!="-1")
		{
			var selected = $(this).val().split(":");
			//alert(selected);
			var moduleid = selected[0];
			var paper = selected[2];
				
			var request = $.ajax({
				url: site_url+"/examination/weightage/get_module_weightage",
				type: "POST",
				data: {	mod_id : moduleid,
						mod_type : modType},
				dataType: "json"
			});

			request.done(function(data){
				
				//console.log(data);
				$('#headerWajaran').html("");
				
				var modul_id = data.module_detail.mod_id;
				var wajaran_pusat = data.module_detail.mod_mark_centre;
				var wajaran_sekolah = data.module_detail.mod_mark_school;
				var jam_kredit = data.module_detail.mod_credit_hour;
				var semester = data.module_detail.cm_semester;
				var kod_modul = data.module_detail.mod_code;
				var nama_modul = data.module_detail.mod_name;
				var p_amali = 30;
				var p_teori = 40;
				var s_amali = 20;
				var s_teori = 10;
				var p_id = 0;
				var s_id = 0;
				var jumlahMarkah = wajaran_pusat*1 + wajaran_sekolah*1;
				
				var tblRow =
					'<tr id="rowCentre">'+
					'<td width="20%" ><strong class="tablepadding">Pusat :</strong></td>'+
					'<td colspan="3" style="text-align: center;">'+
					'<input id="txtPusat" name="txtPusat" style="text-align:center;" class="input-mini" type="text" disabled="true" value="'+wajaran_pusat+'"/>'+
					'</td></tr>'+
					'<tr id="rowSchool">'+
					'<td width="20%" ><strong class="tablepadding">Sekolah :</strong></td>'+
					'<td colspan="3" style="text-align: center;">'+
					'<input id="txtSekolah" name="txtSekolah" style="text-align:center;" class="input-mini" type="text" disabled="true" value="'+wajaran_sekolah+'"/>'+
					'</td></tr>'+
					'<tr>'+
					'<td align="right"><strong>Jumlah :</strong></td>'+
					'<td colspan="5" align="left"><strong><span id="jumlahMarkah">'+jumlahMarkah+'</span>%</strong></td>'+
					'</td>'+
					'</tr>';
				
				$("#tblwajaran > tbody").html("");
				
				$('#tblwajaran > tbody').html(tblRow);
				
				
				if(data.module_detail.module_pt != null)
				{
					p_id = data.module_detail.module_pt[0].pt_id;
					var p_kategori = data.module_detail.module_pt[0].pt_category;
					p_amali = data.module_detail.module_pt[0].pt_amali;
					p_teori = data.module_detail.module_pt[0].pt_teori;
					
					s_id = data.module_detail.module_pt[1].pt_id;
					var s_kategori = data.module_detail.module_pt[1].pt_category;
					s_amali = data.module_detail.module_pt[1].pt_amali;
					s_teori = data.module_detail.module_pt[1].pt_teori;
					
					var tblHeader =
						'<td colspan="3" style="text-align: center;" width="30%">Keseluruhan</td>'+
						'<td style="text-align: center;">Amali</td>'+
						'<td style="text-align: center;">Teori</td>';
					
					var rowCentre =
						'<td style="text-align: center;">'+
						'<input id="txtPamali" name="txtPamali" style="text-align:center;" class="input-mini" type="text" disabled="true" value="'+p_amali+'"/></td>'+
						'<td style="text-align: center;">'+
						'<input id="txtPteori" name="txtPteori" style="text-align:center;" class="input-mini" type="text" disabled="true" value="'+p_teori+'"/></td>';

					var rowSchool =	
						'<td style="text-align: center;">'+
						'<input id="txtSamali" name="txtSamali" style="text-align:center;" class="input-mini" type="text" disabled="true" value="'+s_amali+'"/></td>'+
						'<td style="text-align: center;">'+
						'<input id="txtSteori" name="txtSteori" style="text-align:center;" class="input-mini" type="text" disabled="true" value="'+s_teori+'"/></td>';

					
					$('#rowCentre').append(rowCentre);
					$('#rowSchool').append(rowSchool);
					
					
				}	
				
				if(data.module_detail.module_ppr != null)
				{
					$('#headerWajaran').html("");
					var countpaper = 1;
					var countCentre = 0;
					var countSchool = 0;
					var dataLength = (data.module_detail.module_ppr.length*1-1);
					
					var tblHeader =
						'<td colspan="3" style="text-align: center;" width="30%" >Keseluruhan</td>';
					
					$(data.module_detail.module_ppr).each(function(index) {
					
						var pprid = data.module_detail.module_ppr[index].ppr_id;
						var pprType = data.module_detail.module_ppr[index].ppr_category;
						var pprPercentage = data.module_detail.module_ppr[index].ppr_percentage;
						
						//alert("index : "+index);
						//alert("ppr : "+pprType);
						//alert("countpaper : "+countpaper);
						
						if(dataLength < 2)
						{
							if(index != dataLength)
							{
								if(pprType != data.module_detail.module_ppr[index*1+1].ppr_category)
								{
									tblHeader +=
										'<td style="text-align: center;">Kertas '+(countpaper)+'</td>';
									
									//alert("in "+data.module_detail.module_ppr[index*1+1].ppr_category);
																								
									countpaper++;
								}
								
								var tdAdd =
									'<td style="text-align: center;">'+
									'<input id="txtPaper'+pprType+'_'+pprid+'" name="txtPaper'+pprType+'_'+pprid+'" '+
									'style="text-align:center;" class="input-mini inputpaper" type="text" disabled="true" value="'+pprPercentage+'"/></td>';
								
							}
							else
							{
								/*tblHeader +=
									'<td style="text-align: center;">Kertas '+(countpaper)+'</td>';*/
								
								var tdAdd =
									'<td style="text-align: center;">'+
									'<input id="txtPaper'+pprType+'_'+pprid+'" name="txtPaper'+pprType+'_'+pprid+'" '+
									'style="text-align:center;" class="input-mini inputpaper" type="text" disabled="true" value="'+pprPercentage+'"/></td>';
								
								//countpaper++;
							}
						}
						else
						{
							if(index != dataLength)
							{
								if(pprType == data.module_detail.module_ppr[index*1+1].ppr_category)
								{
									tblHeader +=
										'<td style="text-align: center;">Kertas '+(countpaper)+'</td>';
									
									//alert("in "+data.module_detail.module_ppr[index*1+1].ppr_category);
																								
									countpaper++;
								}
								
								var tdAdd =
									'<td style="text-align: center;">'+
									'<input id="txtPaper'+pprType+'_'+pprid+'" name="txtPaper'+pprType+'_'+pprid+'" '+
									'style="text-align:center;" class="input-mini inputpaper" type="text" disabled="true" value="'+pprPercentage+'"/></td>';
								
							}
							else
							{
								/*tblHeader +=
									'<td style="text-align: center;">Kertas '+(countpaper)+'</td>';*/
								
								var tdAdd =
									'<td style="text-align: center;">'+
									'<input id="txtPaper'+pprType+'_'+pprid+'" name="txtPaper'+pprType+'_'+pprid+'" '+
									'style="text-align:center;" class="input-mini inputpaper" type="text" disabled="true" value="'+pprPercentage+'"/></td>';
								
								//countpaper++;
							}
						}
						
						
						
						if(pprType == "P")
						{
							$('#rowCentre').append(tdAdd);
							countCentre++;
						}
						else
						{
							$('#rowSchool').append(tdAdd);
							countSchool++;
						}
					});
					
					//Add empty td to make the td even
					if(countCentre > countSchool)
					{
						for(countSchool;countSchool<countCentre;countSchool++)
						{
							var tdAdd =
								'<td style="text-align: center;"></td>';
							$('#rowSchool').append(tdAdd);
						}
					}
					else
					{
						for(countCentre;countCentre<countSchool;countCentre++)
						{
							var tdAdd =
								'<td style="text-align: center;"></td>';
							$('#rowCentre').append(tdAdd);
						}
					}

				}
					
				$('#headerWajaran').append(tblHeader);
				$('#subsem').val(semester);
				$('#subkredit').val(jam_kredit);
				$('#btn_config_weightage').removeAttr("disabled");
				
				$('#category').val(modType);
				$('#module').html(kod_modul+'-'+nama_modul);
				$('#mod_id').val(modul_id);
				$('#p_id').val(p_id);
				$('#s_id').val(s_id);
				$('#paper').val(paper);
				$("#formConfig").validationEngine({promptPosition : "topLeft", scroll: true, autoPositionUpdate: true});
	
			});

			request.fail(function(jqXHR, textStatus) {
				//msg("Request failed", textStatus, "Ok");
			});
		}
		
	});
	
	
	$('#formConfig').on("change","#txtPusat,#txtSekolah",function(){
		var wajaransekolah = $('#txtSekolah').val();
		var wajaranpusat = $('#txtPusat').val();
		
		$('#jumlahMarkah').html((wajaransekolah*1 + wajaranpusat*1 ));
		
		calculatePercent((wajaransekolah*1 + wajaranpusat*1 ),100,'jumlahMarkah');
		
	});
	
	
	$('#formConfig').on("change","#txtPamali,#txtPteori",function(){
		var wajaranpusat = $('#txtPusat').val();
		var p_amali = $('#txtPamali').val();
		var p_teori = $('#txtPteori').val();
		
		var id = $(this).attr('id');
		
		calculatePercent((p_amali*1 + p_teori*1 ),wajaranpusat,id);
	});
	
	
	$('#formConfig').on("change","#txtSamali,#txtSteori",function(){
		var wajaransekolah = $('#txtSekolah').val();
		var s_amali = $('#txtSamali').val();
		var s_teori = $('#txtSteori').val();
		
		var id = $(this).attr('id');
		
		calculatePercent((s_amali*1 + s_teori*1 ),wajaransekolah,id);
	});
	
	
	$('#formConfig').on("click","#btn_edit_weightage",function(){
		$('#txtPusat,#txtSekolah,#txtPamali,#txtPteori,#txtSamali,#txtSteori').removeAttr("disabled");
		$('.inputpaper').removeAttr("disabled");
		$('#btnClearConfiq,#btnSaveConfiq').removeAttr("disabled");
	});
	
	
	$('#formConfig').on("change",".inputpaper",function(){
		//$(this).validationEngine('validate');
		//$("#formConfig").validationEngine({promptPosition : "topLeft", scroll: true, autoPositionUpdate: true});
		var totalPaper = 0;
		var id = $(this).attr('id');
		
		$(this).parent().parent().find('.inputpaper').each(function(i,obj)
		{
			if(!isNaN($(this).val()))
			{
				totalPaper += $(this).val()*1;
			}
		});
		
		calculatePercent(totalPaper,'100',id);	
	});
	
	$('#frmWeightage').on("click","#btn_config_weightage",function(){
		
		if($('#btn_config_weightage').is(':disabled'))
		{
			return false;
		}
		else
		{
			$('#myModal').modal({
				keyboard: false,
				backdrop: 'static'
			});
		}
		

	});
	
	//Save Weightage
	$('#formConfig').on("click","#btnSaveConfiq",function(e){
		
		if($('#btnSaveConfiq').is(':disabled'))
		{
			return false;
		}
		
		e.stopImmediatePropagation(); //Prevent Looping
		
		var wajaranpusat = $('#txtPusat').val();
		var p_amali = $('#txtPamali').val();
		var p_teori = $('#txtPteori').val();
		var wajaransekolah = $('#txtSekolah').val();
		var s_amali = $('#txtSamali').val();
		var s_teori = $('#txtSteori').val();
		
		var validate1 = calculatePercent((wajaransekolah*1 + wajaranpusat*1 ),100,'jumlahMarkah');
		var validate2 = calculatePercent((p_amali*1 + p_teori*1 ),wajaranpusat,'txtPteori');
		var validate3 = calculatePercent((s_amali*1 + s_teori*1 ),wajaransekolah,'txtSteori');
		
		if(validate1 == 0 )
		{
			var opts = new Array();
			opts['heading'] = 'Menyimpan Penetapan Wajaran';
			opts['hidecallback'] = true;
			opts['callback'] = function()
			{
			
				$("#myModal").scrollTop(0);
				$('#myModal').css('overflow','hidden');
				$('#myModal').block({ 
					message: '<h6><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h6>', 
					css: { border: '3px solid #660a30' } 
		    	}); 
				
				 setTimeout(function()
				 {
						//ajax submit to delete
						var request = $.ajax({
							url: site_url+"/examination/weightage/save_update_weightage_configuration",
							type: "POST",
							data: $('#formConfig').serialize(),
							dataType: "html"
						});
						//alert(data);
						request.done(function(data) {
							//$.unblockUI();
							//alert(data);
							$('#myModal').unblock();
							$('#myModal').modal('hide');
							
							if(data.length>0 && data>0)
							{
								var opts = new Array();
								opts['heading'] = 'Berjaya';
								opts['content'] = 'Maklumat Tarikh Pembukaan Kemasukkan Markah Berjaya disimpan';
								
								kv_alert(opts);
								//location.reload();
								$('#txtPusat,#txtSekolah,#txtPamali,#txtPteori,#txtSamali,#txtSteori').attr("disabled","disabled");
								$('.inputpaper').attr("disabled","disabled");
							}
							else
							{
								var opts = new Array();
								opts['heading'] = 'Tidak Berjaya';
								opts['content'] = 'Data-data tidak sah! Maklumat Pembukaan Kemasukkan Markah tidak dapat disimpan';
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
				}, 1500);
			
			};
			
			
			opts['cancelCallback'] = function(){/*do nothing*/};
			kv_confirm(opts);
		}
		
			
		
	});
	
});//end of document.ready


/**************************************************************************************************
 * Description		: This function to validate weightage percent
 * Author			: Freddy Ajang Tony
 * Date				: 08 July 2013
 * Input Parameter	:
 * Modification Log	: -				  
 *************************************************************************************************/
function calculatePercent(total,totalpercent,idname)
{
	
	if(totalpercent==total)
	{
		$('#'+idname+'').validationEngine('hide');
		$('#btnSaveConfiq').removeAttr("disabled");
		$('#btnClearConfiq').removeAttr("disabled");
		
		return 0;
	}
	else if(totalpercent>total)
	{
		$('#'+idname+'').validationEngine('showPrompt', '*Sila Pastikan Jumlah Wajaran ialah '+totalpercent+"%", 'load', 'bottomLeft', true);
		$('#btnSaveConfiq').attr("disabled", "disabled");
		$('#btnClearConfiq').attr("disabled", "disabled");
		
		return 1;
	}
	else if(totalpercent<total)
	{
		$('#btnSaveConfiq').attr("disabled", "disabled");
		$('#btnClearConfiq').attr("disabled", "disabled");
		$('#'+idname+'').validationEngine('showPrompt', '*Pastikan Jumlah Wajaran tidak melebihi '+totalpercent+"%", 'err', 'bottomLeft', true);
		
		return 1;
	}
}

/**************************************************************************************************
* End of kv.weightage.js
**************************************************************************************************/