var intervalStatus;
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
					var patt = new RegExp("%?:", "g");
					var res = patt.test(key);
					if (res == true) {
						var selectionData = key.split("%");
						var modul = selectionData[2].split(":");
						localforage.getItem("optPentaksir_" + currentKVUser, function(readValue) {
							var listKursus = readValue[selectionData[1] + "_" + selectionData[0]];
							if (typeof listKursus != 'undefined') {
								var listModul = listKursus.cou_modul[modul[0]];
								var kelas = listModul.modul_kelas[selectionData[3]];

								counter++;

								$("#tableOffline > tbody:last").append("<tr><td>" + counter +
									"</td><td>" + listKursus.cou_code + " - " + listKursus.cou_name + "</td><td>" + selectionData[0] + "</td><td>" +
									listModul.mod_name + "</td><td>" + toTitleCase(kelas) +
									"</td><td><a onclick=fnOpenOfflinePentaksiran(\'" +
									key + "\')>Pentaksiran</a></td></tr>");

								$("#tableOffline").show();
							}
						});

						/*localforage.getItem(selectionData[1] + "%mod%" + modul[2], function(mod) {
							localforage.getItem("optPentaksir", function(kelasArr) {
								console.log(modul[0]);
								var listKelas = kelasArr[selectionData[1] + "_" + selectionData[0]].cou_modul[modul[0]].modul_kelas;
								$.each(listKelas, function(indexKelas, valueKelas) {
									if (indexKelas == selectionData[3]) {
										$.each(kursusData, function(index, value) {
											if (selectionData[1] == value.cou_id) {
												counter++;
												$("#tableOffline > tbody:last").append("<tr><td>" + counter +
													"</td><td>" + value.cou_course_code + " - " + value.cou_name + "</td><td>" + selectionData[0] + "</td><td>" + mod.mod_name +
													"</td><td>" + toTitleCase(valueKelas) + "</td><td><a onclick=fnOpenOfflinePentaksiran(\'" + //Tambah key
													key + "\')>Pentaksiran</a></td></tr>");
												$("#tableOffline").show();
											}
										});
									}
								});
							});
						});*/
					}
				});
			}
		}
	});
}

/**************************************************************************************************
 * Description		: function to get data from local database
 * input			: -
 * author			: Ku Ahmad Mudrikah Ku Mukhtar
 * Date				: 18 March 2014
 * Modification Log	: -
 **************************************************************************************************/
function sycnData() {
	localforage.length(function(length) {
		if (length > 0) {
			for (var i = 0; i < length; i++) {
				localforage.key(i, function(key) {
					var patt = new RegExp("^PA%pentaksiran", "g");
					var res = patt.test(key);
					if (res == true) {
						localforage.getItem(key, function(properties) {
							var request = $.ajax({
								url: base_url + "index.php/examination/markings_v3/save_assignment",
								type: "POST",
								data: properties,
								dataType: "html"
							});

							request.done(function(data) {
								$('#assgmnpop').unblock();
								$('#assgmnpop').modal('hide');

								localforage.removeItem(key);

								var mssg = new Array();
								mssg['heading'] = 'Berjaya';
								mssg['content'] = 'Markah pelajar Berjaya dihantar ke pelayan.';

								kv_alert(mssg);
								clearInterval(intervalStatus);
							});
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
	$('#slct_tahun').val(columns[0]);
	$('#slct_kursus').val(columns[1]);
	$("#slct_kursus").trigger("change");
	setTimeout(function() {
		$('#slct_jubject').val(columns[2]);
		$("#slct_jubject").trigger("change");
		setTimeout(function() {
			$('#slct_kelas').val(columns[3]); //kelas yg ada dalam key
			$("#slct_kelas").trigger("change");
		}, 100);
	}, 100);

}

function fnLoadDataToLocalForage() {
	$.blockUI({
		message: '<h5>Sedang diproses, Sila tunggu...</h5><div class="progress progress-striped active" style="width: 70%; margin-left: 15%;"><div class="bar" style="width: 100%;"></div></div>'
	});
	
	var counter = 0;
	var tempcourse = $('#slct_kursus').val();
	var slct_sbj = $('#slct_jubject').val();
	var semester = $('#slct_tahun').val();
	var kelas = $('#slct_kelas').val();
	var configSlct = semester + "%" + tempcourse + "%" + slct_sbj + "%" + kelas;
	var kursusData = "";
	var modulData = "";
	

	var aSlct_sbj = $('#slct_jubject').val().split(":");
	var sbj_id = aSlct_sbj[0];
	var sb_cat = aSlct_sbj[1];
	var cmid = aSlct_sbj[2];

	var studentsList = [];

	var header = $('#tblStudent th').map(function() {
		return $(this).text().trim();
	}).get();

	var penetapan = $('#tblStudent th').map(function() {
		if ($(this).attr("title") == undefined) {
			return "";
		} else {
			return $(this).attr("title");
		}
	}).get();

	var students = $('#tblStudent tr td').map(function() {
		var student = [];
		if ($(this).text().trim() == "") {
			return $(this).context.innerHTML.trim();
		} else {
			return $(this).text().trim();
		}
		return student;
	}).get();

	var student = [];
	$.each(students, function(key, val) {
		if (student.length < header.length) {
			student.push(students[key]);
			if (key == students.length - 1) {
				studentsList.push(student);
			}
		} else {
			studentsList.push(student);
			student = [];
			student.push(students[key]);
		}
	});

	var data = {
		"penetapan": penetapan,
		"header": header,
		"student": studentsList
	};

	$.each(jsonPelajar, function(key, value) {
		var request = [];
		var cAjax = 0;

		if (key == "subjekconfigur") {
			countSubject = value.length;

			$.each(value, function(y, subValue) {
				aSubjek = value;

				request[cAjax] = $.ajax({
					url: base_url + "index.php/examination/markings_v3/get_assignment",
					type: "POST",
					data: {
						assgmnt_ID: subValue.assgmnt_id,
						ksmid2: cmid,
						semesterP: semester,
						slct_kelas: kelas
					},
					dataType: "json"
				});

				request[cAjax].done(function(data1) {
					$.each(data1, function(z, dataStud) {
						if (z == "pelajar") {
							var cStud = 0;
							$.each(dataStud, function(inMark, dataMark) {

								if (typeof jsonPelajar.pelajar[cStud].marks == 'undefined')
									jsonPelajar.pelajar[cStud].marks = [];

								jsonPelajar.pelajar[cStud].marks.push(dataMark.marks);
								jsonPelajar.pelajar[cStud].status_competent = dataMark.status_competent;
								cStud++;

							});
						}
					});

					cAjax++;
					if (cAjax == jsonPelajar.subjekconfigur.length) {
						data.pelajar = {};
						data.subjekconfigur = {};

						data.pelajar = jsonPelajar.pelajar;
						data.subjekconfigur = jsonPelajar.subjekconfigur;

						localforage.setItem(configSlct, data);
					}
				});



			});

		}
	});
	
	$("#enableOffline").switchClass( "btn-danger", "btn-success",0);
	$('#enableOffline').text("Offline Mode: On");
	$.unblockUI();
}

/**************************************************************************************************
 * Description		: document ready function
 * input			: -
 * author			: Ku Ahmad Mudrikah Ku Mukhtar
 * Date				: 12 March 2014
 * Modification Log	: -
 **************************************************************************************************/
$(document).ready(function() {
	var counter = 0;
	var tempcourse = $('#slct_kursus').val();
	var slct_sbj = $('#slct_jubject').val();
	var semester = $('#slct_tahun').val();
	var kelas = $('#slct_kelas').val();
	var configSlct = semester + "%" + tempcourse + "%" + slct_sbj + "%" + kelas;
	var kursusData = "";
	var modulData = "";
	

	var aSlct_sbj = $('#slct_jubject').val().split(":");
	var sbj_id = aSlct_sbj[0];
	var sb_cat = aSlct_sbj[1];
	var cmid = aSlct_sbj[2];

	$("#tableOffline").hide();
	$("#offlineTbl").hide();

	var request = $.ajax({
		url: site_url + "/main/check_online",
		type: "POST",
		dataType: "html"
	});

	request.fail(function(jqXHR, textStatus) {
		if (jqXHR.status == "0") {
			$('#btn_config_markP').hide();
		}
	});

	request.done(function(data) {
		intervalStatus = setInterval(sycnData, 5000);
	});

	localforage.getItem("optPentaksir_" + currentKVUser, function(data) {
		getLocalData(data);
	});

	localforage.getItem(configSlct, function(value) {
		if (value == null) {
			$("#enableOffline").switchClass( "btn-success", "btn-danger",0);
			$('#enableOffline').text("Offline Mode: Off");
		} else {
			$("#enableOffline").switchClass( "btn-danger", "btn-success",0);
			$('#enableOffline').text("Offline Mode: On");
		}
	});

	$('#enableOffline').click(function() {
		localforage.getItem(configSlct, function(value) { //change "a" to configSlct

			if (value == null) {
				fnLoadDataToLocalForage();
			} else if (value != null) {
				var bStatus = false;
				var mssg = new Array();
				mssg['heading'] = 'Penetapan Offline!';
				mssg['question'] = 'Penetapan offline sudah dibuat sebelum ini, anda pasti untuk set semula?';
				mssg['callback'] = function() {
					localforage.removeItem(configSlct, "");
					fnLoadDataToLocalForage();
					bStatus = true;
				}

				kv_confirm(mssg);
			}

			
		});
	});
});