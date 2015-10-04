var offlineStatus = null;

$(document).ready(function() {

	$("#tableOffline").hide();
	localforage.getItem("optPentaksir_" + currentKVUser, function(data) {
		getLocalData(data);
	});

	localforage.getItem(primaryKeyStudent, function(readValue) {
		if (readValue == null) {
			$("#btnInstallOffline").switchClass( "btn-success", "btn-danger",0);
			$("#btnInstallOffline").text("Offline Mode : Off");
		} else {
			$("#btnInstallOffline").switchClass( "btn-danger", "btn-success",0);
			$("#btnInstallOffline").text("Offline Mode : On");
		}
	});

	$("#btnInstallOffline").click(function() {
		localforage.getItem(primaryKeyStudent, function(value) { //change "a" to configSlct
			if (value == null) {
				fnLoadDataToLocalForage();
			} else if (value != null) {
				var mssg = new Array();
				mssg['heading'] = 'Penetapan Offline!';
				mssg['question'] = 'Penetapan offline sudah dibuat sebelum ini, anda pasti untuk set semula?';
				mssg['callback'] = function() {
					localforage.removeItem(primaryKeyStudent, "");
					fnLoadDataToLocalForage();
					bStatus = true;
				}
				kv_confirm(mssg);
			}
		});
	});
});

function setLocalStorageStudent(pJsonPelajar) {
	localforage.setItem(primaryKeyStudent, pJsonPelajar);
}

/**************************************************************************************************
 * Description		: function to get data from local database
 * input			: -
 * author			: Ku Ahmad Mudrikah Ku Mukhtar
 * Date				: 18 March 2014
 * Modification Log	: -
 **************************************************************************************************/
function getLocalData(data) {
	var counter = 0;
	kursusData = data;
	localforage.length(function(length) {
		if (length > 0) {
			for (var i = 0; i < length; i++) {
				localforage.key(i, function(key) {
					var patt = new RegExp("^PA%?%", "g");
					var res = patt.test(key);
					if (res == true) {
						var selectionData = key.split("%");
						var modul = selectionData[3].split(":");

						localforage.getItem("optPentaksir_" + currentKVUser, function(readValue) {
							var listKursus = readValue[selectionData[2] + "_" + selectionData[1]];
							if (typeof listKursus != 'undefined') {
								var listModul = listKursus.cou_modul[modul[0]];
								var kelas = listModul.modul_kelas[selectionData[4]];

								counter++;

								$("#tableOffline > tbody:last").append("<tr><td>" + counter +
									"</td><td>" + listKursus.cou_code + " - " + listKursus.cou_name + "</td><td>" + selectionData[1] + "</td><td>" +
									listModul.mod_name + "</td><td>" + toTitleCase(kelas) +
									"</td><td><a onclick=fnOpenOfflinePentaksiran(\'" +
									key + "\')>Pentaksiran</a></td></tr>");

								$("#tableOffline").show();
							}
						});
					}
				});
			}
		}
	});
}

/**************************************************************************************************
 * Description		: Function to open pentaksiran data based on offline database data
 * input			: -
 * author			: Ku Ahmad Mudrikah Ku Mukhtar
 * Date				: 25 March 2014
 * Modification Log	: -
 **************************************************************************************************/
function fnOpenOfflinePentaksiran(key) {
	var columns = key.split("%");
	$('#slct_tahun').val(columns[1]);
	$('#slct_kursus').val(columns[2]);
	$("#slct_kursus").trigger("change");
	setTimeout(function() {
		$('#slct_jubject').val(columns[3]);
		$("#slct_jubject").trigger("change");
		setTimeout(function() {
			$('#slct_kelas').val(columns[4]);
			$("#slct_kelas").trigger("change");
		}, 100);
	}, 100);

}


/**************************************************************************************************
 * Description		: Function to load offline data
 * input			: -
 * author			: Fakhruzzaman
 * Date				: 21 April 2014
 * Modification Log	: -
 **************************************************************************************************/
function fnLoadDataToLocalForage() {
	$.blockUI({
		message: '<h5>Sedang diproses, Sila tunggu...</h5><div class="progress progress-striped active" style="width: 70%; margin-left: 15%;"><div class="bar" style="width: 100%;"></div></div>'
	});

	var tempcourse = $('#slct_kursus').val().split(":");
	var slct_sbj = $('#slct_jubject').val().split(":");
	var semester = $('#slct_tahun').val();
	var kelas = $('#slct_kelas').val();
	//var cmid = $('#ksmid2').val();

	var sbj_id = slct_sbj[0];
	var sb_cat = slct_sbj[1];
	var cmid = slct_sbj[2];

	var courseslct = tempcourse[0];

	var btn = $("#btnInstallOffline");
	var countSubject = 0;
	var aSubjek = null;
	window.aMark = [];

	btn.attr('disabled', 'disabled');
	btn.text('loading...');

	$.each(jsonPelajar, function(key, value) {
		var request = [];
		var cAjax = 0;

		if (key == "subjekconfigur") {
			countSubject = value.length;

			$.each(value, function(y, subValue) {
				aSubjek = value;

				request[cAjax] = $.ajax({
					url: base_url + "index.php/examination/marking/get_assignment",
					type: "POST",
					data: {
						assgmnt_ID: subValue.assgmnt_id,
						ksmid2: cmid,
						semesterP: semester,
						slct_kelas: kelas
					},
					dataType: "json"
				});

				request[cAjax].done(function(data) {
					$.each(data, function(z, dataStud) {
						if (z == "pelajar") {
							var cStud = 0;
							$.each(dataStud, function(inMark, dataMark) {

								if (typeof jsonPelajar.pelajar[cStud].marks == 'undefined')
									jsonPelajar.pelajar[cStud].marks = [];

								jsonPelajar.pelajar[cStud].marks.push(dataMark.marks);
								cStud++;

							});
						}
					});

					cAjax++;
					if (cAjax == jsonPelajar.subjekconfigur.length) {
						setLocalStorageStudent(jsonPelajar);
					}
				});



			});

		}
	});
	
	$("#btnInstallOffline").switchClass( "btn-danger", "btn-success",0);
	btn.text("Offline Mode : On");
	btn.removeAttr('disabled');

	$.unblockUI();
}