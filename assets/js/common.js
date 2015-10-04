function notify(pContent, pHeader, pType) {
	pContent = typeof pContent !== 'undefined' ? pContent : 'Maklumat Telah Berjaya Disimpan';
	pHeader = typeof pHeader !== 'undefined' ? pHeader : 'Maklumat Tindakan';
	pType = typeof pType !== 'undefined' ? pType : 'success';

	$("#panelAlertContent").addClass("alert-" + pType);
	$('#modalAlertHeader').html(pHeader);
	$('#modalAlertContent').html(pContent);

	//trigger and show modal
	$('#myAlertModal').modal('show');

}

function notifyFullAnnouncement(ann_id) {
	var request = $.ajax({
		url: site_url + "/maintenance/announcement/display_full",
		type: "POST",
		data: {
			annId: ann_id
		},
		dataType: "html"
	});

	request.done(function(data) {
		notify(data, "Pengumuman", "info");
	});

	request.fail(function(jqXHR, textStatus) {
		$.unblockUI();
		alert("Request failed" + textStatus);
	});
}

/**************************************************************************************************
 * Description : this function will change string to title case
 * input	 : str
 * author	 : Freddy Ajang Tony
 * Date	 : 18/10/2013
 * Modification Log	:  -
 **************************************************************************************************/
function toTitleCase(str) {
	return str.replace(/\w\S*/g, function(txt) {
		return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
	});
}

var countMasukChecker = 0;
var currentStatusOnline = "online";

function checkOfflineOrNot(){
	countMasukChecker++;
	

	var request = $.ajax({
		url: site_url + "/main/check_online",
		type: "POST",
		dataType: "html"
	});

	request.done(function(data) {
		$("#image_mask").css("background-color", "green");
		$('#onlineStatus').attr('title','Sistem Offine');
		$('#onlineStatus').attr('data-original-title','Sistem Online');

		if(currentStatusOnline == "offline")
			$('#onlineStatus').tooltip('show');
		
		currentStatusOnline = "online";
	});

	request.fail(function(jqXHR, textStatus) {
		$("#image_mask").css("background-color", "red");
		$('#onlineStatus').attr('title','Sistem Offline');
		$('#onlineStatus').attr('data-original-title','Sistem Offline');
		
		if(currentStatusOnline == "online")
			$('#onlineStatus').tooltip('show');
		
		currentStatusOnline = "offline";
	});
}

$(document).ready(function() {

	setInterval(checkOfflineOrNot, 5000);

	//toolbox collapse
	$("img.closeImg").click(
		function() {
			$("#collapsible_table_inner").slideUp("fast");
			$("#collapsible_div_outer").slideUp("medium");
			$("img#collapsible_indicator").attr("src", base_url + "assets/img/up.png");
			$("span#collapsible_text").html("Open");
		}
	);

	$("img.openImg").click(
		function() {
			if (jQuery("img#collapsible_indicator").attr("src") == base_url + "assets/img/down.png") {
				$("#collapsible_table_inner").show();
				$("#collapsible_div_outer:hidden").slideDown("fast");
				$("img#collapsible_indicator").attr("src", base_url + "assets/img/up.png");
				$("span#collapsible_text").html("Close");
			} else {
				$("#collapsible_table_inner").slideUp("fast");
				$("#collapsible_div_outer").slideUp("medium");
				$("img#collapsible_indicator").attr("src", base_url + "assets/img/down.png");
				$("span#collapsible_text").html("Open");
			}
		}
	);

	$('#menuAkaun').tooltip('hide');
	$('#menuLogout').tooltip('hide');
	$('.titleSubject').tooltip('hide');
	$('#onlineStatus').tooltip('hide');
});