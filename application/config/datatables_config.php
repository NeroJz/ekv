<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**************************************************************************************************
* File Name        = datatables_config.php
* Description      = This File contain configuration for datatables.
* Author           = Fakhruz
* Date             = 16 dec 2013
* Version          = 0.1
* Modification Log = 
**************************************************************************************************/
$config['loadImg'] = 'assets/img/loading_ajax.gif';

$config['dtConfig']["bPaginate"] = "true";
$config['dtConfig']["sPaginationType"] = "full_numbers";
		
	
/*$config['dtConfig']["fnPreDrawCallback"] = 'function(){
	
	if(window.setSta == undefined || window.setSta == 1)
	{
			setSta =0;
			$.blockUI({ 
			message: "<h5>Sedang diproses, Sila tunggu...</h5><div class=\"progress progress-striped active\" style=\"width: 70%; margin-left: 15%;\"><div class=\"bar\" style=\"width: 100%;\"></div></div>"
		});
	}
			return true;
		}';
             
$config['dtConfig']["fnDrawCallback"] = 'function(){
			setSta = 1;
			$.unblockUI();
		}'; */    

$config['dtConfig']["bFilter"] = "true";
$config['dtConfig']["bInfo"] = "true";
$config['dtConfig']["bDestroy"] = "true";
$config['dtConfig']["bJQueryUI"] = "true";
$config['dtConfig']["bPaginate"] = "true";
$config['dtConfig']["iDisplayLength"]= 10;
$config['dtConfig']["aaSorting"] = '[[0, "asc"]]';
//$config['dtConfig']["aoColumn"] = '[null, null, null, null, null, null, null]';
$config['dtConfig']["oLanguage"] = '{
			"sProcessing":\'{loadImg} Sedang diproses...\',
			"sSearch" : "Carian :",
			"sLengthMenu" : "Papar _MENU_",
			"sInfo" : "Papar _START_ hingga _END_ dari _TOTAL_ rekod",
			"sInfoEmpty" : "Showing 0 to 0 of 0 records",
			"sInfoFiltered": "(jumlah semua _MAX_ rekod)",
			"oPaginate" : {
				"sFirst" : "Pertama",
				"sLast" : "Akhir",
				"sNext" : "Seterus",
				"sPrevious" : "Sebelum"
			}
		}';

$config['dtConfig']["fnServerData"] = 'function(sSource, aoData, fnCallback){
			aoData.push({"name": "{csrfName}", "value": "{csrfValue}"});
			{aoDataList}
			aoData.push({"name": "{aoDataName}", "value": {aoDataValue}});
			{/aoDataList}
			$.ajax({
				"dataType": "json",
				"type":"POST",
				"url":sSource,
				"data":aoData,
				"success":fnCallback
			});
		}';

$config['dtConfig']["bProcessing"] = "true";
$config['dtConfig']["bServerSide"] = "true";


?>