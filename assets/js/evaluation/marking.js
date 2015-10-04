/***********************************************************************************************
 * File Name        : marking.js
 * Description      : This File contain all of javascript for evaluation PUSAT
 * Author           : Norafiq Bin Mohd Azman Chew
 * Date             : 11 june 2013
 * Version          : -
 * Modification Log : -
 * Function List	   : -
 **************************************************************************************************/
var autoCompleteTask = {
	source: ["Teori", "Amali"]
};

var otblAssgnMarks = null;
var markschanged = new Array();
var pentaksiran = "P";
var ptid = "";
var otblStudentOffline = null;
var fixedHeaderStudentOffline = null;

(function($) {
	var _old = $.unique;
	$.unique = function(arr) {
		if ( !! arr[0].nodeType) {
			return _old.apply(this, arguments);
		} else {
			return $.grep(arr, function(v, k) {
				return $.inArray(v, arr) === k;
			});
		}
	};
})(jQuery);

/**************************************************************************************************
 * Description		: this function to delete row at Mymodal
 * input			: val
 * author			: Norafiq Azman
 * Date				: 17 June 2013
 * Modification Log	: -
 **************************************************************************************************/
function fnDelete(val) {
	var heading = 'Padam Tugasan';
	var question = 'Adakah Anda pasti untuk memadam tugasan ini?';
	var cancelButtonTxt = 'Batal';
	var okButtonTxt = 'Padam';

	$('#myModal').block({
		message: '<h5><img src="' + base_url + 'assets/img/loading_ajax.gif"' +
			'alt="Sedang process"/>Sedang diproses, Sila tunggu...</h5>',
		css: {
			border: '3px solid #660a30'
		}
	});

	var callback = function() {
		//$('.deltugasan').tooltip('hide');
		if (-1 != val.indexOf("trAdd")) {
			var assgmnt_id0 = $('#tgsid0').val();
			var assgmnt_id1 = $('#tgsid1').val();

			if ("" != assgmnt_id0 || "" != assgmnt_id1) {
				if ("" != assgmnt_id0) {
					var request = $.ajax({
						url: "marking/assignmentToDelete",
						type: "POST",
						data: {
							tugasanID: assgmnt_id0
						},
						dataType: "json"
					});
				} else if ("" != assgmnt_id1) {
					var request = $.ajax({
						url: "marking/assignmentToDelete",
						type: "POST",
						data: {
							tugasanID: assgmnt_id1
						},
						dataType: "json"
					});
				}

				request.done(function(data) {
					//alert("Tugasan Telah Dipadam..");					//FDP
					var mssg = new Array();
					mssg['heading'] = 'Dipadam';
					mssg['content'] = 'Tugasan telah dipadam';

					kv_alert(mssg);
				});

				request.fail(function(jqXHR, textStatus) {
					//alert("Tugasan tidak dapat dipadam !");
					var mssg = new Array();
					mssg['heading'] = 'Dipadam';
					mssg['content'] = 'Tugasan tidak berjaya dipadam';

					kv_alert(mssg);
				});
			}

			$(val).remove();
			$('#addtask').removeAttr("disabled");
		}

		$('#myModal').unblock();
	};

	var cancelCallback = function() {
		$('#myModal').unblock();
	};

	confirm(heading, question, cancelButtonTxt, okButtonTxt, callback, cancelCallback);
	return false;
}

/**************************************************************************************************
 * Description		: this function is confirm to delete or not.
 * input			: heading, question, cancelButtonTxt, okButtonTxt, callback, cancelCallback
 * author			: Norafiq Azman
 * Date				: 17 June 2013
 * Modification Log	: -
 **************************************************************************************************/
function confirm(heading, question, cancelButtonTxt, okButtonTxt, callback, cancelCallback) {
	var confirmModal = $('<div class="modal hide fade">' +
		'<div class="modal-header">' +
		'<h3>' + heading + '</h3>' +
		'</div>' +
		'<div class="modal-body">' +
		'<p>' + question + '</p>' +
		'</div>' +
		'<div class="modal-footer">' +
		'<a href="javascript:void(0);" id="mdl_cancel_btn" class="btn"' +
		'data-dismiss="modal">' + cancelButtonTxt + '</a>' +
		'<a href="javascript:void(0);" id="okButton" class="btn btn-primary">' +
		okButtonTxt + '</a>' +
		'</div>' +
		'</div>');

	confirmModal.find('#okButton').click(function(event) {
		callback();
		confirmModal.modal('hide');
	});

	confirmModal.find('#mdl_cancel_btn').click(function(event) {
		cancelCallback();
		confirmModal.modal('hide');
	});

	confirmModal.modal({
		keyboard: false,
		backdrop: 'static'
	});
};

/**************************************************************************************************
 * Description		: this function to download excell
 * input			:
 * author			:
 * Date				:
 * Modification Log	: umairah - class
 **************************************************************************************************/
function getw() {
	var assgmntID = $('#hidAssignmentID').val();
	var tempcourse = $('#slct_kursus').val().split(":");
	var slct_sbj = $('#slct_jubject').val().split(":");
	var semester = $('#slct_tahun').val();
	var kelas = $('#slct_kelas').val();

	var sbj_id = slct_sbj[0];
	var sb_cat = slct_sbj[1];
	var cmid = slct_sbj[2];

	window.location.href = 'export_xls_markahStudent' + '?assgmnt_ID=' + assgmntID + '&ksmid2=' + cmid + '&semesterP=' + semester + '&slct_kelas=' + kelas;
}

/**************************************************************************************************
 * Description		: this function to download excell
 * input			:
 * author			: umairah
 * Date				: 25 march 2014
 * Modification Log	: -
 **************************************************************************************************/
function getMarkahMurid() {

	var assgmntID = $('#hidAssignmentID').val();
	var semester = $('#slct_tahun').val();
	var slct_sbj = $('#slct_jubject').val().split(":");
	var kelas = $('#slct_kelas').val();
	var kursus = $('#slct_kursus').val();
	//alert(kelas);
	var sb_id = slct_sbj[0];
	var sb_cat = slct_sbj[1];
	var cm_id = slct_sbj[2];
	//alert(cm_id);
	pentaksiran = "P"; // P = Pusat

	var opts = new Array();

	opts['heading'] = 'Muat Turun';
	opts['question'] = 'Anda Pasti Untuk Muat Turun?';
	opts['hidecallback'] = true;
	opts['callback'] = function() {

		window.location.href = 'export_xls_markahStudent_keseluruhan' + '?ksmid2=' + cm_id + '&kursusid=' +
			kursus + '&subjectid=' + sb_id + '&semesterP=' + semester + '&pentaksiran=' + pentaksiran + '&tempKAt2=' +
			sb_cat + '&kelas3=' + kelas;

	}

	opts['cancelCallback'] = function() { /*do nothing*/ };
	kv_confirm(opts);

} //end of click function



/**************************************************************************************************
 * Description		: this function to popup assignment for lecturer insert detail mark
 * input			: val
 * author			: Norafiq Azman
 * Date				: 19 June 2013
 * Modification Log	: -
 **************************************************************************************************/
function fnOpenAssignment(val) {
	markschanged = new Array();

	var assgmntID = val;
	var tempcourse = $('#slct_kursus').val().split(":");
	var slct_sbj = $('#slct_jubject').val().split(":");
	var semester = $('#slct_tahun').val();
	var kelas = $('#slct_kelas').val();
	var slct_sbj_orig = $('#slct_jubject').val();
	var slct_kelas = $('#slct_kelas').val();
	//var cmid = $('#ksmid2').val();

	$('#hidAssignmentID').val(val);

	var sbj_id = slct_sbj[0];
	var sb_cat = slct_sbj[1];
	var cmid = slct_sbj[2];

	var courseslct = tempcourse[0];

	//alert('assgmnt id:'+assgmntID+' cmid:'+cmid); //FDP

	var request = $.ajax({
		url: base_url + "index.php/examination/marking/get_assignment",
		type: "POST",
		data: {
			assgmnt_ID: assgmntID,
			ksmid2: cmid,
			semesterP: semester,
			slct_kelas: kelas
		},
		dataType: "json"
	});

	request.done(function(data) {
		//console.log(data);
		//console.log(data.senaraipelajar);
		//console.log(data.subjekconfigur);

		$("#formAssgMark").validationEngine('validate', {
			scroll: false
		});

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
		$("#kelas4").val(kelas);

		//kita kena hapuskan datatable objek sebab kita kena re-create
		var ex = document.getElementById('tblAssgnMarks');
		if ($.fn.DataTable.fnIsDataTable(ex)) {
			otblAssgnMarks.fnDestroy();
		}

		$('#tblAssgnMarks > thead').html("");
		$('#tblAssgnMarks > tbody').html("");

		//load data and populate modal
		$('#markHeader').html(assg_name);
		$('#mark_assg_selection').val(assg_selection);
		$('#paparanAgihan').html("Pemilihan " + assg_selection + " Tugasan Terbaik. ");

		var thead = '<tr>' +
			'<th style="text-align:center;width:4%;">BIL</th>' +
			'<th>NAMA MURID</th>' +
			'<th>ANGKA GILIRAN</th>';

		var agihan = (assg_total_mark * 1) / (assg_selection * 1);

		if (1 == assg_selection && 1 == assg_total) {
			thead += '<th style="text-align:center;vertical-align:middle;width:10%;">' + assg_name + '</th>';
		} else {
			for (i = 1; i <= assg_total; i++) {
				thead += '<th style="text-align:center;vertical-align:middle;width:5%;">' + assg_name + ' ' + i + '</th>';
			}
		}

		thead += '<th class="jum_markah" style="text-align:center;width:12%;"> Jumlah / (' + assg_total_mark + '%)</th></tr>';

		$("#tblAssgnMarks > thead").html(thead);

		var rows = data.pelajar;

		//debuging : check content pelajar
		//console.log(rows);

		$(rows).each(function(index) {
			var studid = rows[index].stu_id;
			var namaplajar = rows[index].stu_name;
			var noIC = rows[index].stu_matric_no;
			var marksd = rows[index].marks;
			//var ttlMark = rows[index].ttlMark;
			var ttlMark = 0;



			/*if (ttlMark < 0) {
				ttlMark = "T";
			}
			if (ttlMark == 0 && ttlMark < 1) {
				ttlMark = 1;
			}*/

			var tbody = '<tr id="jumlah' + studid + '' + tugasan_id + '">' +
				'<td>' + (index + 1) + '</td>' +
				'<td>' + namaplajar.toUpperCase() + '</td>' +
				'<td>' + noIC + '</td>';

			var chkVal = 0;

			if (1 == assg_selection && 1 == assg_total) {
				for (i = 1; i <= assg_total; i++) {
					var m = "";

					if (marksd != null) {
						$(marksd).each(function(index2) {
							var assignment_num = marksd[index2].assignment_num;

							if (marksd[index2].data != null && i == assignment_num) {
								m = marksd[index2].data.mark;

								/*if (m == -99.99) {
									m = "T";
								}
								if (m == 0 && m < 1) {
									m = 1;
								}*/

								if (m == -99.99) {
									chkVal += m * 1;
									m = "T";
									ttlMark = ttlMark + (0 * 1);
								} else {
									m = Math.ceil(m);
									ttlMark = ttlMark + (m * 1);
								}

								if (m == 0 && m < 1) {
									m = 1;
									ttlMark = ttlMark + (m * 1);
								}
							}
						});
					}
				}

				tbody += '<td><input style="width: 50px;" name="' + studid + '_' + tugasan_id + '_1" id="' + studid + '_' + tugasan_id + '_1" type="text"' +
					'value="' + m + '" class="cellMarks"/></td>';
			} else {
				for (i = 1; i <= assg_total; i++) {
					var m = "";

					if (marksd != null) {
						$(marksd).each(function(index2) {
							var assignment_num = marksd[index2].assignment_num;

							if (marksd[index2].data != null && i == assignment_num) {
								m = marksd[index2].data.mark;

								/*if (m == -99.99) {
									m = "T";
								}
								if (m == 0 && m < 1) {
									m = 1;
								}*/

								if (m == -99.99) {
									chkVal += m * 1;
									m = "T";
									ttlMark = ttlMark + (0 * 1);
								} else {
									m = Math.ceil(m);
									ttlMark = ttlMark + (m * 1);
								}

								if (m == 0 && m < 1) {
									m = 1;
									ttlMark = ttlMark + (m * 1);
								}
							}
						});
					}

					tbody += '<td><input style="width:50px;" name="' + studid + '_' + tugasan_id + '_' + i + '" id="' + studid + '_' + tugasan_id + '_' + i + '" type="text"' +
						'value="' + m + '" class="cellMarks"/></td>';
				}
			}

			//var ttlM = "";
			//ttlM = ttlMark

			if (chkVal / assg_total != -99.99) {
				ttlMark = Math.ceil((ttlMark / assg_selection) / 100 * assg_total_mark);
			} else {
				ttlMark = "T";
			}


			tbody += '<td style="text-align:center;vertical-align:middle;">' +
				'<input style="width:80px;" type="text" readonly="readonly"' +
				'value="' + ttlMark + '" class="jum_markah" /></td></tr>';

			$("#tblAssgnMarks > tbody").append(tbody);
		});

		otblAssgnMarks = $('#tblAssgnMarks').dataTable({
			"aoColumnDefs": [{
				bSortable: false,
				aTargets: [0]
			}],
			"sScrollY": "200px",
			"bScrollInfinite": true,
			"bScrollCollapse": true,
			"bJQueryUI": false,
			"bPaginate": false,
			"bFilter": false,
			"bAutoWidth": false,
			"bInfo": false,
			"aaSorting": [
				[1, 'asc']
			],
			"fnDrawCallback": function(oSettings) {
				if (oSettings.bSorted || oSettings.bFiltered) {
					for (var i = 0, iLen = oSettings.aiDisplay.length; i < iLen; i++) {
						$('td:eq(0)', oSettings.aoData[oSettings.aiDisplay[i]].nTr).html(i + 1);
					}
				}
			}
		});

		$("#formAssgMark").validationEngine('validate', {
			scroll: false
		});

		//process columns to hightligh colours
		processFullCells();

		$('#assgmnpop').modal({
			keyboard: false,
			backdrop: 'static'
		});
	});

	request.fail(function(jqXHR, textStatus) {
		//console.log(jqXHR);
		//alert( "Request failed: " + textStatus );

		//fakhruz : offline 03 untuk papar markah
		if (jqXHR.status == "0") {
			var kursus = $('#slct_kursus').val();

			primaryKeyStudent = "PA%" + semester + "%" + kursus + "%" + slct_sbj_orig + "%" + slct_kelas;

			localforage.getItem(primaryKeyStudent, function(readValue) {
				if (readValue == null) {
					var mssg = new Array();
					mssg['heading'] = 'Message';
					mssg['content'] = 'Modul ini belum tersedia dengan function offline';

					kv_alert(mssg);
				} else {
					//hide function excel dalam offline
					$('#accordionUpload').hide();
					$('#btnDownloadAssgMarks').hide();

					$("#formAssgMark").validationEngine('validate', {
						scroll: false
					});

					var tugasan_id = 0;
					var assg_name = 0;
					var assg_total_mark = 0;
					var assg_total = 0;
					var assg_selection = 0;
					var indexMarkah = 0;

					$.each(readValue, function(key, valSubjek) {
						var aPelajar = readValue.pelajar;
						var aSubject = readValue.subjekconfigur;

						$(aSubject).each(function(index) {
							if (aSubject[index].assgmnt_id != assgmntID) {} else {
								tugasan_id = aSubject[index].assgmnt_id;
								assg_name = aSubject[index].assgmnt_name;
								assg_total_mark = aSubject[index].assgmnt_mark;
								assg_total = aSubject[index].assgmnt_total;
								assg_selection = aSubject[index].assgmnt_score_selection;
								indexMarkah = index;

								$("#mark_assg_selection").val(assg_selection);
								$("#mark_total_assg").val(assg_total_mark);
								$("#semesterP4").val(semester);
								$("#mptID4").val(cmid);
								$("#category").val(sb_cat);
								$("#kelas4").val(kelas);

								//kita kena hapuskan datatable objek sebab kita kena re-create
								var ex = document.getElementById('tblAssgnMarks');
								if ($.fn.DataTable.fnIsDataTable(ex)) {
									otblAssgnMarks.fnDestroy();
								}

								$('#tblAssgnMarks > thead').html("");
								$('#tblAssgnMarks > tbody').html("");

								//load data and populate modal
								$('#markHeader').html(assg_name);
								$('#mark_assg_selection').val(assg_selection);
								$('#paparanAgihan').html("Pemilihan " + assg_selection + " Tugasan Terbaik. ");

								var thead = '<tr>' +
									'<th style="text-align:center;width:4%;">BIL</th>' +
									'<th>NAMA MURID</th>' +
									'<th>ANGKA GILIRAN</th>';

								var agihan = (assg_total_mark * 1) / (assg_selection * 1);

								if (1 == assg_selection && 1 == assg_total) {
									thead += '<th style="text-align:center;vertical-align:middle;width:10%;">' + assg_name + '</th>';
								} else {
									for (i = 1; i <= assg_total; i++) {
										thead += '<th style="text-align:center;vertical-align:middle;width:5%;">' + assg_name + ' ' + i + '</th>';
									}
								}

								thead += '<th class="jum_markah" style="text-align:center;width:12%;"> Jumlah / (' + assg_total_mark + '%)</th></tr>';

								$("#tblAssgnMarks > thead").html(thead);
							} // end else if found same assgmnt_id
						}); //end each aSubjek

						var rows = aPelajar;

						$(rows).each(function(index) {
							var studid = rows[index].stu_id;
							var namaplajar = rows[index].stu_name;
							var noIC = rows[index].stu_matric_no;
							var marksd = null;
							//var ttlMark = rows[index].markah[indexMarkah];
							var ttlMark = 0;

							$(rows[index].marks).each(function(indexMark) {
								if (typeof rows[index].marks[indexMark][0].data != 'undefined') {
									if (assgmntID == rows[index].marks[indexMark][0].data.assgmnt_id) {
										marksd = rows[index].marks[indexMark];
									}
								}
							});



							/*if (ttlMark < 0) {
								ttlMark = "T";
							}
							if (ttlMark == 0 && ttlMark < 1) {
								ttlMark = 1;
							}*/



							var tbody = '<tr id="jumlah' + studid + '' + tugasan_id + '">' +
								'<td>' + (index + 1) + '</td>' +
								'<td>' + namaplajar.toUpperCase() + '</td>' +
								'<td>' + noIC + '</td>';

							var chkVal = 0;

							if (1 == assg_selection && 1 == assg_total) {
								for (i = 1; i <= assg_total; i++) {
									var m = "";

									if (marksd != null) {
										$(marksd).each(function(index2) {
											var assignment_num = marksd[index2].assignment_num;

											if (marksd[index2].data != null && i == assignment_num) {
												m = marksd[index2].data.mark;

												/*if (m == -99.99) {
													m = "T";
												}
												if (m == 0 && m < 1) {
													m = 1;
												}*/

												if (m == -99.99) {
													chkVal += m * 1;
													m = "T";
													ttlMark = ttlMark + (0 * 1);
												} else {
													m = Math.ceil(m);
													ttlMark = ttlMark + (m * 1);
												}

												if (m == 0 && m < 1) {
													m = 1;
													ttlMark = ttlMark + (m * 1);
												}
											}
										});
									}
								}

								tbody += '<td><input style="width: 50px;" name="' + studid + '_' + tugasan_id + '_1" id="' + studid + '_' + tugasan_id + '_1" type="text"' +
									'value="' + m + '" class="cellMarks"/></td>';
							} else {
								for (i = 1; i <= assg_total; i++) {
									var m = "";

									if (marksd != null) {
										$(marksd).each(function(index2) {
											var assignment_num = marksd[index2].assignment_num;

											if (marksd[index2].data != null && i == assignment_num) {
												m = marksd[index2].data.mark;

												/*if (m == -99.99) {
													m = "T";
												}
												if (m == 0 && m < 1) {
													m = 1;
												}*/

												if (m == -99.99) {
													chkVal += m * 1;
													m = "T";
													ttlMark = ttlMark + (0 * 1);
												} else {
													m = Math.ceil(m);
													ttlMark = ttlMark + (m * 1);
												}

												if (m == 0 && m < 1) {
													m = 1;
													ttlMark = ttlMark + (m * 1);
												}

											}
										});
									}

									tbody += '<td><input style="width:50px;" name="' + studid + '_' + tugasan_id + '_' + i + '" id="' + studid + '_' + tugasan_id + '_' + i + '" type="text"' +
										'value="' + m + '" class="cellMarks"/></td>';
								}
							}

							//var ttlM = "";
							//ttlM = ttlMark
							if (chkVal / assg_total != -99.99) {
								ttlMark = Math.ceil((ttlMark / assg_selection) / 100 * assg_total_mark);
							} else {
								ttlMark = "T";
							}


							tbody += '<td style="text-align:center;vertical-align:middle;">' +
								'<input style="width:80px;" type="text" readonly="readonly"' +
								'value="' + ttlMark + '" class="jum_markah" /></td></tr>';

							$("#tblAssgnMarks > tbody").append(tbody);
						});

						otblAssgnMarks = $('#tblAssgnMarks').dataTable({
							"aoColumnDefs": [{
								bSortable: false,
								aTargets: [0]
							}],
							"sScrollY": "200px",
							"bScrollInfinite": true,
							"bScrollCollapse": true,
							"bJQueryUI": false,
							"bPaginate": false,
							"bFilter": false,
							"bAutoWidth": false,
							"bInfo": false,
							"aaSorting": [
								[1, 'asc']
							],
							"fnDrawCallback": function(oSettings) {
								if (oSettings.bSorted || oSettings.bFiltered) {
									for (var i = 0, iLen = oSettings.aiDisplay.length; i < iLen; i++) {
										$('td:eq(0)', oSettings.aoData[oSettings.aiDisplay[i]].nTr).html(i + 1);
									}
								}
							}
						});

						$("#formAssgMark").validationEngine('validate', {
							scroll: false
						});

						//process columns to hightligh colours
						processFullCells();

						$('#assgmnpop').modal({
							keyboard: false,
							backdrop: 'static'
						});

					});
				}
			}); //end of localforage.getItem
		}

		return false;
	});
}


/**************************************************************************************************
 * Description 		: this function to highlight mark
 * input				:
 * author			: Freddy Ajang Tony
 * Date				: 28 February 2014
 * Modification Log	:  -
 **************************************************************************************************/
function processFullCells() {
	var tlbCol = "#tblAssgnMarks > tbody > tr > :nth-child(4)";

	var mark_assg_selection = parseInt($('#mark_assg_selection').val());
	var mark_total_assg = parseInt($('#mark_total_assg').val());

	$(tlbCol).each(function() {
		//alert($(this).find('.cellMarks').attr('value'));
		var marks = new Array();

		$(this).parent().find('input.cellMarks').each(function(i, obj) {

			var classrow = $(this).parent().parent().attr("class");

			if (!isNaN($(this).val())) {
				if ($(this).val() == 0 && $(this).val() < 1) {
					marks[i] = {
						id: $(this).attr('id'),
						val: 1.00
					};
				} else {
					marks[i] = {
						id: $(this).attr('id'),
						val: $(this).val()
					};
				}
			} else if ($(this).val() == "T" || $(this).val() == "t") {
				//alert($(this).val());
				$(this).val($(this).val().toUpperCase());

				if (classrow == "even") {
					$(this).parent().css('background-color', 'transparent');
				}
				if (classrow == "odd") {
					$(this).parent().css('background-color', '#f9f9f9');
				}

				marks[i] = {
					id: $(this).attr('id'),
					val: -99.99
				};
			} else {
				$(this).val($(this).val().toUpperCase());
				marks[i] = {
					id: $(this).attr('id'),
					val: 1.00
				};
			}

			if (classrow == "even") {
				$(this).parent().css('background-color', 'transparent');
			}
			if (classrow == "odd") {
				$(this).parent().css('background-color', 'whiteSmoke');
			}

		});

		marks.sort(function(a, b) {
			return b.val - a.val
		});

		var sum = 0;
		var avgCal = 0;

		for (i = 0; i < mark_assg_selection; i++) {
			if (marks[i].val * 1 == "-99.99") {
				//alert(marks[i].val*1 +"b9");
				sum = sum + (0 * 1);
				avgCal += marks[i].val * 1;
			} else {
				//alert(marks[i].val*1 +"b0");
				sum = sum + (marks[i].val * 1);
			}

			var cellid = '#' + marks[i].id;

			$(cellid).parent().css('background-color', 'green');
		}
	});
}

/**************************************************************************************************
 * Description 		: function for automatic send data to the server in the background
 * input			:
 * author			: Ku Ahmad Mudrikah Ku Mukhtar
 * Date				: 24 March 2014
 * Modification Log	:  -
 **************************************************************************************************/
function syncPentaksiran() {
	localforage.length(function(length) {
		if (length > 0) {

			var slct_sbj = $('#slct_jubject').val().split(":");
			var semester = $('#slct_tahun').val();
			var kelas = $('#slct_kelas').val();

			var sbj_id = slct_sbj[0];
			var sb_cat = slct_sbj[1];
			var cmid = slct_sbj[2];

			for (var i = 0; i < length; i++) {
				localforage.key(i, function(key) {
					var patt = new RegExp("PB%pentaksiran%", "g");
					var res = patt.test(key);
					if (res == true) {
						localforage.getItem(key, function(value) {
							if (value != null) {
								var request = $.ajax({
									url: base_url + "index.php/examination/marking/save_assignment",
									type: "POST",
									data: value,
									dataType: "html"
								});

								request.done(function(data) {
									//console.log(data);

									//update markah kat jumlah
									$('#tblAssgnMarks > tbody  > tr').each(function() {
										var id = "#" + $(this).attr("id");
										var row = $('#tblStudent').find(id);
										//console.log(row);
										var marks = $(this).find('.jum_markah').val();
										row.val(Math.ceil(marks));
									});

									$('#tblStudent > tbody  > tr').each(function() {
										var ttl = 0.00;
										var index = 0;
										var count = 0;

										$(this).find("input").each(function() {
											var ma = $(this).val();

											if (ma == 'T') {
												count++;
											}

											index++;

											ttl += (isNaN(ma) ? 0.00 : ma * 1);
										});

										if (index != count)
											$(this).find(".ttlmrks").html(Math.ceil(new Number(ttl).toFixed(2)));
										else
											$(this).find(".ttlmrks").html('T');
									});

									markschanged = new Array();

									$('#assgmnpop').unblock();
									$('#assgmnpop').modal('hide');

									var mssg = new Array();
									mssg['heading'] = 'Message';
									mssg['content'] = 'Markah pelajar berjaya dikemaskini.';

									kv_alert(mssg);
									localforage.removeItem(key);

								});

								request.fail(function(jqXHR, textStatus) {
									/*localforage.setItem("PA%pentaksiran", params);
										$('#assgmnpop').unblock();

										var mssg = new Array();
										mssg['heading'] = 'Message';
										mssg['content'] = 'Markah pelajar menunggu untuk dimuatnaik.';

										kv_alert(mssg);
									//alert("tak simpan");*/
								});
							}
						});
					}
				});
			}
		}
	});
}

/**************************************************************************************************
 * Description 		: function for update offline storage after user make changes
 * input			:
 * author			: Fakhruz
 * Date				: 27 March 2014
 * Modification Log	:  -
 **************************************************************************************************/
function updateOfflineMark(changedID, localData) {

	var aPelajar = localData.pelajar;
	var aSubjekconfigur = localData.subjekconfigur;

	/*$(aPelajar).each(function(inPe){
		var aMarks = aPelajar[inPe].marks;
		$(aMarks).each(function(inMa){
			if(aMarks[inMa].length > 0){
				$(aMarks[inMa]).each(function(inSubMa){
				});
			}
		});
	});*/
	var sumMark = [];
	//try {

	$(changedID).each(function(inCurrentMark) {
		var aMarkKey = changedID[inCurrentMark].split("_");
		var studID = aMarkKey[0];
		var assgmnt_id = aMarkKey[1];
		var indexMark = aMarkKey[2];


		$(aPelajar).each(function(inPe) {
			//cari student dulu dalam localstorage
			if (aPelajar[inPe].stu_id == studID) {
				var aMarks = aPelajar[inPe].marks;
				$(aMarks).each(function(inMa) {
					if (aMarks[inMa].length > 0) {
						$(aMarks[inMa]).each(function(inSubMa) {

							//check data.mark exist and insert data.mark for the firsttime
							if (typeof aMarks[inMa][inSubMa].data == 'undefined') {
								if (aMarks[inMa][inSubMa].assignment_id == assgmnt_id && indexMark == aMarks[inMa][inSubMa].assignment_num) {

									localData.pelajar[inPe].marks[inMa][inSubMa].data = {};
									localData.pelajar[inPe].marks[inMa][inSubMa].data.mark = "";
									localData.pelajar[inPe].marks[inMa][inSubMa].data.assgmnt_id = assgmnt_id;
									localData.pelajar[inPe].marks[inMa][inSubMa].data.assigmnt_number = aMarks[inMa][inSubMa].assignment_num;


									aMarks[inMa][inSubMa].data = {};
									aMarks[inMa][inSubMa].data.assgmnt_id = assgmnt_id;
									aMarks[inMa][inSubMa].data.mark = "";
									aMarks[inMa][inSubMa].data.assigmnt_number = aMarks[inMa][inSubMa].assignment_num;
								}
							}

							//check assignment id
							if (typeof aMarks[inMa][inSubMa].data != 'undefined' && assgmnt_id == aMarks[inMa][inSubMa].data.assgmnt_id) {

								if (sumMark[assgmnt_id] == null) {
									sumMark[assgmnt_id] = 0;
								}

								var currentMark = $('#' + changedID[inCurrentMark]).val();
								sumMark[assgmnt_id] += parseInt(currentMark);
								//alert(sumMark[assgmnt_id]);
								if (assgmnt_id == aMarks[inMa][inSubMa].data.assgmnt_id && indexMark == aMarks[inMa][inSubMa].data.assigmnt_number) {
									localData.pelajar[inPe].marks[inMa][inSubMa].data.mark = currentMark;
									//return;
								}


								if (aMarks[inMa].length == (inSubMa + 1)) {

									$(aSubjekconfigur).each(function(inSub) {
										if (aSubjekconfigur[inSub].assgmnt_id == assgmnt_id) {

											var currentMark = $('#' + changedID[inCurrentMark]).val();

											var newMark = $('#' + changedID[inCurrentMark]).parent().parent().find('.jum_markah').val();
											localData.pelajar[inPe].markah[inSub] = newMark;

											return;
										}
									});
								}
							}

						});
						return;
					}
				});
				return;
			}
		});


	});

	//} catch (err) {
	//	console.log(err);
	//}
	//set new localForage data
	localforage.setItem(primaryKeyStudent, localData);

}

function loadModul(listModul) {
	$.each(listModul, function(key, valSubjek) {

		var value = listModul[key].mod_id + ':' + listModul[key].mod_type + ':' + listModul[key].cm_id;
		var text = listModul[key].mod_code.toUpperCase() + ' - ' + listModul[key].mod_name.toUpperCase();

		$('#slct_jubject')
			.append($("<option></option>")
				.attr("value", value)
				.text(text));
	});
}

function loadKelas(listKelas) {
	$.each(listKelas, function(key, valSubjek) {
		var value = key;
		var text = listKelas[key].toUpperCase();

		$('#slct_kelas')
			.append($("<option></option>")
				.attr("value", value)
				.text(text));
	});
}


/**************************************************************************************************
 * Description		: document ready function
 * input			: -
 * author			: Norafiq Azman
 * Date				: 10 June 2013
 * Modification Log	: -
 *************************************************************************************************/
$(document).ready(function() {

	$('#formAssgMark').on('keyup', 'input:text:not([readonly])', function(e) {
		var currentInput = null;
		if (e.which == 39)
			currentInput = $(this).closest('td').next().find('input:text:not([readonly])');
		else if (e.which == 37)
			currentInput = $(this).closest('td').prev().find('input:text:not([readonly])');
		else if (e.which == 40)
			currentInput = $(this).closest('tr').next().find('td:eq(' + $(this).closest('td').index() + ')').find('input:text:not([readonly])');
		else if (e.which == 38)
			currentInput = $(this).closest('tr').prev().find('td:eq(' + $(this).closest('td').index() + ')').find('input:text:not([readonly])');

		if (currentInput != null) {
			currentInput.focus();
			currentInput.select();
		}

	});

	var request = $.ajax({
		url: site_url + "/main/check_online",
		type: "POST",
		dataType: "html"
	});

	request.done(function(data) {
		syncPentaksiran();
	});


	$("#formAssgMark").validationEngine({
		scroll: false
	});
	$("#formConfig").validationEngine({
		promptPosition: "topLeft",
		scroll: false
	});

	var oTable = $("#tblStudent").dataTable({
		"aoColumnDefs": [{
			bSortable: false,
			aTargets: [0]
		}],
		"bPaginate": false,
		"bFilter": true,
		"bAutoWidth": false,
		"bInfo": false,
		"aaSorting": [
			[1, 'asc']
		],
		"oLanguage": {
			"sSearch": "Carian :"
		},
		"fnDrawCallback": function(oSettings) {
			if (oSettings.bSorted || oSettings.bFiltered) {
				for (var i = 0, iLen = oSettings.aiDisplay.length; i < iLen; i++) {
					$('td:eq(0)', oSettings.aoData[oSettings.aiDisplay[i]].nTr).html(i + 1);
				}
			}
		}
	});

	if ($("#tblStudent").length > 0) {
		new FixedHeader(oTable, {
			"offsetTop": 40
		});
	}


	var btnMuatTurun = '<div id="idMuatTurun" style="float:right; width:140px;" margin-right:0px;>' +
		'<button id="btnDownloadMarkahMurid" onclick="javascript: getMarkahMurid();" type="button"' +
		'class="btn btn-primary"><span>Muat Turun Excel</span></button> &nbsp;&nbsp;' +
		'</div>';

	$('#tblStudent_wrapper').prepend(btnMuatTurun);

	var btnMuatTurunDua = '<div id="idMuatTurun" style="float:right; width:140px;">' +
		'<button id="btnDownloadMarkahMurid" onclick="javascript: getMarkahMurid();"' +
		'type="button" style="margin-bottom:10px;"' +
		'class="btn btn-primary"><span>Muat Turun Excel</span></button> &nbsp;&nbsp;' +
		'</div>';


	$('#tblStudent_wrapper').append(btnMuatTurunDua);

	$("#btnClearMarkah").on("click", function() {
		//alert("ok");
		// $('#formAssgMark')[0].reset();
		$('.cellMarks').val('');
		$('.jum_markah').val('');
		$('#btnSaveAssgMarks').attr("disabled", "disabled");
		$('#btnClearMarkah').attr("disabled", "disabled");

	});

	$(".txttugasan").autocomplete(autoCompleteTask);

	$('#slct_tahun').change(function() {
		$("#slct_kursus").val(-1);
		$("#slct_jubject").val("");
		$('#slct_jubject').attr("disabled", "disabled");
		$('#btn_config_markP').attr("disabled", "disabled");

	});

	//offline data download to local
	if (currentKVUser != null) {
		localforage.getItem("currentKVUser", function(value) {
			localforage.setItem("currentKVUser", currentKVUser);
		});
	} else {
		localforage.getItem("currentKVUser", function(value) {
			currentKVUser = value;
		});
	}

	if (optPentaksir != null) {
		localforage.getItem("optPentaksir_" + currentKVUser, function(value) {
			if (value != null) {
				//localforage.setItem();
			} else {
				localforage.setItem("optPentaksir_" + currentKVUser, optPentaksir);
			}
		});
	}


	//offline

	$('#slct_kursus').change(function() {
		$("#frm_marking").validationEngine('validate');

		var semester = $('#slct_tahun').val();
		var courseid = $('#slct_kursus').val();

		if (-1 != courseid) {

			$('#divModul').html('<img src="' + base_url + 'assets/img/loading_ajax.gif" alt="Sedang process"/> Sila tunggu...');

			var dropdown =
				'<select id="slct_jubject" name="slct_jubject" style="width:270px;"' +
				'class="validate[required]">' +
				'<option value="">-- Sila Pilih --</option>';

			$('#divModul').html(dropdown);

			$("#slct_jubject option").remove();
			$('#slct_jubject').append($("<option></option>").text("-- Sila Pilih --"));

			localforage.getItem("optPentaksir_" + currentKVUser, function(readValue) {
				if (readValue != null) {
					var listModul = readValue[courseid + "_" + semester].cou_modul;

					//call function loadModul
					loadModul(listModul);
				} else {
					var listModul = optPentaksir[courseid + "_" + semester].cou_modul;

					//call function loadModul
					loadModul(listModul);
				}
			});

			$("#frm_marking").validationEngine('validate');


		} else {
			$('#slct_jubject').attr("disabled", "disabled");
		}
	});


	//select modul triger kelas
	$('#frm_marking').on('change', '#slct_jubject', function() {

		$("#frm_marking").validationEngine('validate');

		var semester = $('#slct_tahun').val();
		var courseid = $('#slct_kursus').val();
		var modul = $('#slct_jubject').val().split(":");


		if (-1 != courseid) {
			$('#divKelas').html('<img src="' + base_url + 'assets/img/loading_ajax.gif" alt="Sedang process"/> Sila tunggu...');

			var dropdown =
				'<select id="slct_kelas" name="slct_kelas" style="width:270px;"' +
				'class="validate[required]">' +
				'<option value="">-- Sila Pilih --</option>';

			$('#divKelas').html(dropdown);

			$("#slct_kelas option").remove();
			$('#slct_kelas').append($("<option></option>").text("-- Sila Pilih --"));

			localforage.getItem("optPentaksir_" + currentKVUser, function(readValue) {
				if (readValue != null) {

					var listKelas = readValue[courseid + "_" + semester].cou_modul[modul[0]].modul_kelas;

					//call function loadKelas
					loadKelas(listKelas);

				} else {
					var listKelas = optPentaksir[courseid + "_" + semester].cou_modul[modul[0]].modul_kelas;

					//call function loadKelas
					loadKelas(listKelas);
				}
			});

			$("#frm_marking").validationEngine('validate');
		} else {
			$('#slct_kelas').attr("disabled", "disabled");
		}
	});


	$('#btn_config_markP').click(function() {
		$("#frm_marking").validationEngine('validate');
		//$("#formConfig").validationEngine({promptPosition : "topLeft", scroll:false});

		var slct_sbj = $('#slct_jubject').val().split(":");
		var kelas = $('#slct_kelas').val();

		var sb_id = slct_sbj[0];
		var sb_cat = slct_sbj[1];
		var cm_id = slct_sbj[2];

		pentaksiran = "P"; // P = Pusat

		//var temptarikh = "takbuka"; //tukar bila dah ada function buka tarikh masuk markah
		var temptarikh = "dahbuka";

		if ("dahbuka" == temptarikh) {
			if ("VK" == sb_cat) {
				var request = $.ajax({
					url: site_url + "/examination/marking/get_swb",
					type: "POST",
					data: {
						pntksrn: pentaksiran,
						cmID: cm_id,
						type: sb_cat,
						slct_kelas: kelas
					},
					dataType: "json"
				});

				request.done(function(data) {
					//console.log(data);

					$('#katTugasan').html("Tugasan Pusat");
					$('#ksmid2').val(cm_id);

					if (null != data.weightage) {
						$('#percent').html(data.weightage.mod_mark_centre);
						$('#semesterP').val(data.weightage.cm_semester);

						if (null != data.configuration) {
							var row = "";

							for (var key in data.configuration) {
								if (data.configuration.hasOwnProperty(key)) {
									var assgmnt_id = data.configuration[key].assgmnt_id;
									var assgmnt_mark = data.configuration[key].assgmnt_mark;
									var assgmnt_name = data.configuration[key].assgmnt_name;
									var assgmnt_score_selection = data.configuration[key].assgmnt_score_selection;
									var assgmnt_total = data.configuration[key].assgmnt_total;
									var la_id = data.configuration[key].la_id;
									var ptid2 = data.configuration[key].pt_id;

									row = row + '<tr >' +
										'<td ><input type="hidden" name="tgsid' + key + '" id="tgsid' + key + '" value="' + assgmnt_id + '">' +
										'<input type="text" name="tugasan' + key + '" id="tugasan' + key + '" class="span7" readonly="readonly" value="' + assgmnt_name + '"/></td>' +
										'<td ><input type="text" name="peratusan' + key + '" id="peratusan' + key + '" class="span7" readonly="readonly" value="' + assgmnt_mark + '"/></td>' +
										'<td ><input type="text" name="jmlhtugsan' + key + '" id="jmlhtugsan' + key + '" class="validate[required] span7" value="' + assgmnt_total + '"/></td>' +
										'<td ><input type="text" name="tugasanterbaik' + key + '" id="tugasanterbaik' + key + '" class="validate[required] span7" value="' + assgmnt_score_selection + '"/></td>' +
										'<td>&nbsp;</td>' +
										'</tr>';
								}
							}

							ptid = ptid2;

							$('#catPentaksiran').html(row);
						} else {
							ptid = data.weightage.pt_id;

							$('#catPentaksiran')
								.html('<tr >' +
									'<td ><input type="hidden" name="tgsid0" id="tgsid0" value="0">' +
									'<input type="text" name="tugasan0" id="tugasan0" class="span7" readonly="readonly" value="Teori"/></td>' +
									'<td ><input type="text" name="peratusan0" id="peratusan0" class="span7" readonly="readonly" value="' + data.weightage.pt_teori + '"/></td>' +
									'<td ><input type="text" name="jmlhtugsan0" id="jmlhtugsan0" class="validate[required] span7"/></td>' +
									'<td ><input type="text" name="tugasanterbaik0" id="tugasanterbaik0" class="validate[required] span7"/></td>' +
									'<td>&nbsp;</td>' +
									'</tr>' +
									'<tr>' +
									'<td ><input type="hidden" name="tgsid1" id="tgsid1" value="0">' +
									'<input type="text" name="tugasan1" id="tugasan1" class="span7" readonly="readonly" value="Amali"/></td>' +
									'<td ><input type="text" name="peratusan1" id="peratusan1" class="span7" readonly="readonly" value="' + data.weightage.pt_amali + '"/></td>' +
									'<td ><input type="text" name="jmlhtugsan1" id="jmlhtugsan1" class="validate[required] span7"/></td>' +
									'<td ><input type="text" name="tugasanterbaik1" id="tugasanterbaik1" class="validate[required] span7"/></td>' +
									'<td>&nbsp;</td>' +
									'</tr>'
							);
						}

						$("#kursusid").val($('#slct_kursus').val());
						$("#subjectid").val(sb_id);
						$("#semesterP").val($('#slct_tahun').val());
						$("#pentaksiran").val(pentaksiran);
						$("#mptID").val(ptid);
						$('#kelas3').val(kelas);
						$('#tempKAt2').val(sb_cat); //temp buang lepas wujud fucntion AK

						$("#formConfig").validationEngine('attach');

						$('#myModal').modal({
							keyboard: false,
							backdrop: 'static'
						});
					} else {
						var mssg = new Array();
						mssg['heading'] = 'Message';
						mssg['content'] = 'Weightage null, sila hubungi lembaga peperiksaan';

						kv_alert(mssg);
					}

				});

				request.fail(function(jqXHR, textStatus) {
					var mssg = new Array();
					mssg['heading'] = 'Message';
					mssg['content'] = 'Request failed: ' + textStatus;

					kv_alert(mssg);

					//alert( "Request failed: " + textStatus );
				});
			} else {


				//nak dapatkan percent bagi subjek AK yg ada lebih 1 paper
				var request = $.ajax({
					url: site_url + "/examination/marking/get_ak_swb",
					type: "POST",
					data: {
						pntksrn: pentaksiran,
						cmID: cm_id,
						type: sb_cat,
						slct_kelas: kelas
					},
					dataType: "json"
				});

				request.done(function(data) {
					//console.log(data);

					$('#katTugasan').html("Kertas - Pusat");
					$('#ksmid2').val(cm_id);

					if (null != data.weightage) {
						$('#percent').html(data.weightage[0].mod_mark_centre);
						//$('#semesterP').val(data.weightage.cm_semester);

						if (null != data.configuration) {
							var row = "";
							for (var key in data.configuration) {
								if (data.configuration.hasOwnProperty(key)) {
									var assgmnt_id = data.configuration[key].assgmnt_id;
									var assgmnt_mark = data.configuration[key].assgmnt_mark;
									var assgmnt_name = data.configuration[key].assgmnt_name;
									var assgmnt_score_selection = data.configuration[key].assgmnt_score_selection;
									var assgmnt_total = data.configuration[key].assgmnt_total;
									var la_id = data.configuration[key].la_id;
									var ptid2 = data.configuration[key].ppr_id;

									row = row + '<tr >' +
										'<td ><input type="hidden" name="tgsid' + key + '" id="tgsid' + key + '" value="' + assgmnt_id + '">' +
										'<input type="text" name="tugasan' + key + '" id="tugasan' + key + '" class="span7" readonly="readonly" value="' + assgmnt_name + '"/></td>' +
										'<td ><input type="text" name="peratusan' + key + '" id="peratusan' + key + '" class="span7" readonly="readonly" value="' + assgmnt_mark + '"/></td>' +
										'<td ><input type="text" name="jmlhtugsan' + key + '" id="jmlhtugsan' + key + '" class="validate[required] span7" readonly="readonly" value="' + assgmnt_total + '"/></td>' +
										'<td ><input type="text" name="tugasanterbaik' + key + '" id="tugasanterbaik' + key + '" class="validate[required] span7" readonly="readonly" value="' + assgmnt_score_selection + '"/></td>' +
										'<td>&nbsp;</td>' +
										'</tr>';
								}
							}

							ptid = ptid2;

							$('#catPentaksiran').html(row);
						} else {
							var row = "";
							for (var key in data.weightage) {
								if (data.weightage.hasOwnProperty(key)) {
									var modPaper = data.weightage[key].mod_paper;
									var pprPercentage = data.weightage[key].ppr_percentage;
									var pprid = data.weightage[key].ppr_id;

									row = row + '<tr >' +
										'<td >' +
										'<input type="text" name="tugasan' + key + '" id="tugasan' + key + '" class="span7" readonly="readonly" value="' + modPaper + '"/></td>' +
										'<td ><input type="text" name="peratusan' + key + '" id="peratusan' + key + '" class="span7" readonly="readonly" value="' + pprPercentage + '"/></td>' +
										'<td ><input type="text" name="jmlhtugsan' + key + '" id="jmlhtugsan' + key + '" class="validate[required] span7" readonly="readonly" value="1"/></td>' +
										'<td ><input type="text" name="tugasanterbaik' + key + '" id="tugasanterbaik' + key + '" class="validate[required] span7" readonly="readonly" value="1"/></td>' +
										'<td>&nbsp;</td>' +
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
						$("#kelas3").val(kelas);
						$('#tempKAt2').val(sb_cat); //temp buang lepas wujud fucntion AK

						$('#myModal').modal({
							keyboard: false,
							backdrop: 'static'
						});
					} else {
						var mssg = new Array();
						mssg['heading'] = 'Berjaya';
						mssg['content'] = 'Weightage null, sila hubungi lembaga peperiksaan';

						kv_alert(mssg);
					}
				});

				request.fail(function(jqXHR, textStatus) {
					var mssg = new Array();
					mssg['heading'] = 'Message';
					mssg['content'] = 'Request failed: ' + textStatus;

					kv_alert(mssg);
				});
			}
		} else {
			//console.log(data); //kalau tarikh xbuka keluarkan alert kata tarikh xbuka lagi
			var mssg = new Array();
			mssg['heading'] = 'Message';
			mssg['content'] = 'Tarikh untuk memasukkan markah belum di buka';

			kv_alert(mssg);
		}
	});

	$('#formConfig').on('click', '#addtask', function() {
		var newID = 1;

		//$("#formConfig").validationEngine('validate',{scroll: false});

		$('#tbltask > tbody:last')
			.append('<tr id="trAdd' + newID + '">' +
				'<td ><input type="text" name="tugasan' + newID + '" id="tugasan' + newID + '" class="validate[required] txttugasan span7"/></td>' +
				'<td ><input type="text" name="peratusan' + newID + '" id="peratusan' + newID + '" class="validate[required] span7"/></td>' +
				'<td ><input type="text" name="jmlhtugsan' + newID + '" id="jmlhtugsan' + newID + '" class="validate[required] span7"/></td>' +
				'<td ><input type="text" name="tugasanterbaik' + newID + '" id="tugasanterbaik' + newID + '" class="validate[required] span7"/></td>' +
				'<td><a class="deltugasan" href="javascript:void(0)" data-original-title="Delete Tugasan">' +
				'<img src="' + base_url + 'assets/img/E_Delete_Sm_N.png" alt="Delete Tugasan" style="height:16px;width:16px;max-width:16px;"' +
				'onclick="fnDelete(\'#trAdd' + newID + '\')"></a></td>' +
				'</tr>'
		);

		$(".txttugasan").autocomplete(autoCompleteTask);

		var autoSuggestion = document.getElementsByClassName('ui-autocomplete');
		if (autoSuggestion.length > 0) {
			autoSuggestion[newID].style.zIndex = 1051;
		}

		$("#addtask").attr("disabled", "disabled");

	});

	$('#tblAssgnMarks').on('change', '.cellMarks', function(event) {

		//get and reset value for this cell
		var v = $(this).val();
		if (v == 0 && v < 1) {
			v = 1;
			$(this).val(v);
		}
		//else
		//{*/
		//if( !$(this).validationEngine('validate'))
		//{
		//append to the modified

		if (v <= 100) {
			$('#' + $(this).attr('id')).validationEngine('hide');

			var classrow = $(this).parent().parent().attr('class');

			if (classrow == "even") {
				$(this).parent().css('background-color', 'transparent');
			}
			if (classrow == "odd") {
				$(this).parent().css('background-color', '#f9f9f9');
			}
			//$('#btnSaveAssgMarks').removeAttr("disabled");			
		} else if (v > 101) {
			$('#' + $(this).attr('id')).validationEngine('showPrompt', '*Sila Pastikan Jumlah Markah Tidak Melebihi 100%', 'err', 'topLeft', true);
			$(this).parent().css('background-color', 'red');
			//$('#btnSaveAssgMarks').attr("disabled", "disabled");
		} else if ("T" != v && "t" != v) {
			$('#' + $(this).attr('id')).validationEngine('showPrompt', 'Anda Dibenarkan menggunakan Huruf T sahaja', 'err', 'topLeft', true);
			$(this).parent().css('background-color', 'red');
			$('#btnSaveAssgMarks').attr("disabled", "disabled");
		}

		markschanged.push($(this).attr('id'));

		var mark_assg_selection = parseInt($('#mark_assg_selection').val());
		var mark_total_assg = parseInt($('#mark_total_assg').val());
		var marks = new Array();

		$(this).parent().parent().find('input.cellMarks').each(function(i, obj) {

			if (!isNaN($(this).val())) {
				if ($(this).val() == 0 && $(this).val() < 1) {
					marks[i] = {
						id: $(this).attr('id'),
						val: 1.00
					};
				} else {
					marks[i] = {
						id: $(this).attr('id'),
						val: $(this).val()
					};
				}
			} else if ($(this).val() == "T" || $(this).val() == "t") {
				//alert($(this).val());
				$(this).val($(this).val().toUpperCase());

				var classrow = $(this).parent().parent().attr("class");

				if (classrow == "even") {
					$(this).parent().css('background-color', 'transparent');
				}
				if (classrow == "odd") {
					$(this).parent().css('background-color', '#f9f9f9');
				}

				marks[i] = {
					id: $(this).attr('id'),
					val: -99.99
				};
				$('#btnSaveAssgMarks').removeAttr("disabled");
				$('#btnClearMarkah').removeAttr("disabled");


			} else {
				$(this).val($(this).val().toUpperCase());
				marks[i] = {
					id: $(this).attr('id'),
					val: 1.00
				};
			}

			if (classrow == "even") {
				$(this).parent().css('background-color', 'transparent');
			}
			if (classrow == "odd") {
				$(this).parent().css('background-color', 'whiteSmoke');
			}
		});

		marks.sort(function(a, b) {
			return b.val - a.val;
		});

		var sum = 0;
		var avgCal = 0;
		for (i = 0; i < mark_assg_selection; i++) {
			if (marks[i].val * 1 == "-99.99") {
				//alert(marks[i].val*1 +"b9");
				sum = sum + (0 * 1);
				avgCal += marks[i].val * 1;
			} else {
				//alert(marks[i].val*1 +"b0");
				sum = sum + (marks[i].val * 1);
			}

			var cellid = '#' + marks[i].id;

			$(cellid).parent().css('background-color', 'green');
		}

		if (avgCal / mark_assg_selection != -99.99) {
			var markahs = (sum / mark_assg_selection) / 100 * mark_total_assg;

			if (markahs <= mark_total_assg) {
				$(this).parent().parent().find('.jum_markah')
					.val(Math.ceil(new Number(markahs).toFixed(2)))
					.validationEngine('hide');

				$('#btnSaveAssgMarks').removeAttr("disabled");
				$('#btnClearMarkah').removeAttr("disabled");

			} else if (markahs > mark_total_assg) {
				$(this).parent().parent().find('.jum_markah')
					.val(Math.ceil(new Number(markahs).toFixed(2)))
					.validationEngine('showPrompt', '*Sila Pastikan Jumlah Markah Tidak Melebihi ' + mark_total_assg + '%', 'err', 'topLeft', true);

				$('#btnSaveAssgMarks').attr("disabled", "disabled");
				$('#btnClearMarkah').attr("disabled", "disabled");
			}
		} else {
			$(this).parent().parent().find('.jum_markah').val('T');
		}
	});

	$('#formAssgMark').on('click', '#btnSaveAssgMarks', function() {
		//console.log(markschanged);

		$("#mark_assg_selection").val();
		$("#mark_total_assg").val();
		$("#semesterP4").val();
		$("#mptID4").val();
		$("#category").val();
		$("#kelas4").val();

		$("#assgmnpop").scrollTop(0);
		$('#assgmnpop').css('overflow', 'hidden');
		$('#assgmnpop').block({
			message: '<h5><img src="' + base_url + 'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang diproses, Sila tunggu...</h5>',
			css: {
				border: '3px solid #660a30'
			}
		});

		setTimeout(function() {


			//var validate = $('#formAssgMarks').validationEngine('validate');
			//if(validate)
			//{
			//scrollTo = $('#markHeader');
			//$('#modalMarks').scrollTop(0); //scrollTo.offset().top - $('#modalMarks').offset().top + $('#modalMarks').scrollTop() -15
			if (markschanged.length > 0) {
				var changedID = $.unique(markschanged);

				var cmid = $("#mptID4").val();
				var semester = $("#semesterP4").val();
				var category = $("#category").val();
				var kelas = $("#kelas4").val();

				var params = "pentaksiran=" + pentaksiran + '&cmid=' + cmid + '&sem=' + semester + '&cat=' + category + '&kelas4=' + kelas;

				for (i = 0; i < changedID.length; i++) {
					//if(i!=0)
					params += '&';

					params += changedID[i] + '=' + $('#' + changedID[i]).val();
				}

				// offline fakhruz : getLocalUntukUpdateMark
				localforage.getItem(primaryKeyStudent, function(readValue) {
					if (readValue == null) {} else {
						updateOfflineMark(changedID, readValue);
					}
				});

				//changedID = null;

				//alert(params);

				//ajax submit the values



				var request = $.ajax({
					url: base_url + "index.php/examination/marking/save_assignment",
					type: "POST",
					data: params,
					dataType: "html"
				});

				request.done(function(data) {
					//console.log(data);

					//update markah kat jumlah
					$('#tblAssgnMarks > tbody  > tr').each(function() {
						var id = "#" + $(this).attr("id");
						var row = $('#tblStudent').find(id);
						//console.log(row);
						var marks = $(this).find('.jum_markah').val();

						if (marks != "T") {

							row.val(Math.ceil(marks));
						} else {

							row.val(marks);
						}
					});

					$('#tblStudent > tbody  > tr').each(function() {
						var ttl = 0.00;
						var index = 0;
						var count = 0;

						$(this).find("input").each(function() {
							var ma = $(this).val();

							if (ma == 'T') {
								count++;
							}

							index++;

							ttl += (isNaN(ma) ? 0.00 : ma * 1);
						});

						if (index != count)
							$(this).find(".ttlmrks").html(Math.ceil(new Number(ttl).toFixed(2)));
						else
							$(this).find(".ttlmrks").html('T');
					});

					markschanged = new Array();

					$('#assgmnpop').unblock();
					$('#assgmnpop').modal('hide');

					var mssg = new Array();
					mssg['heading'] = 'Message';
					mssg['content'] = 'Markah pelajar berjaya dikemaskini.';

					kv_alert(mssg);

				});

				request.fail(function(jqXHR, textStatus) {
					//update markah kat jumlah
					$('#tblAssgnMarks > tbody  > tr').each(function() {
						var id = "#" + $(this).attr("id");
						var row = $('#tblStudentOffline').find(id);
						//console.log(row);
						var marks = $(this).find('.jum_markah').val();

						if (marks != "T") {

							row.val(Math.ceil(marks));
						} else {

							row.val(marks);
						}
					});

					$('#tblStudentOffline > tbody  > tr').each(function() {
						var ttl = 0.00;
						var index = 0;
						var count = 0;

						$(this).find("input").each(function() {
							var ma = $(this).val();

							if (ma == 'T') {
								count++;
							}

							index++;

							ttl += (isNaN(ma) ? 0.00 : ma * 1);
						});

						if (index != count)
							$(this).find(".ttlmrks").html(Math.ceil(new Number(ttl).toFixed(2)));
						else
							$(this).find(".ttlmrks").html('T');
					});

					markschanged = new Array();


					var id = cmid + ':' + semester + ':' + category;
					localforage.getItem("PB%pentaksiran%" + id, function(value) {
						if (value != null) {
							for (i = 0; i < changedID.length; i++) {
								value += '&';

								value += changedID[i] + '=' + $('#' + changedID[i]).val();
							}
							console.log(value);
							localforage.setItem("PB%pentaksiran%" + id, value);
						} else if (value == null) {
							localforage.setItem("PB%pentaksiran%" + id, params);
						}
					});

					markschanged = new Array();

					$('#assgmnpop').unblock();
					$('#assgmnpop').modal('hide');

					var mssg = new Array();
					mssg['heading'] = 'Message';
					mssg['content'] = 'Markah pelajar menunggu untuk dimuatnaik.';

					kv_alert(mssg);
				});
			} else {
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

	$('#frm_marking').on('change', '#slct_kelas', function() {

		if ($('#slct_kelas').val().length > 0) {

			var semester = $('#slct_tahun').val();
			var slct_sbj = $('#slct_jubject').val().split(":");
			var kelas = $('#slct_kelas').val();

			var sb_id = slct_sbj[0];
			var sb_cat = slct_sbj[1];
			var cm_id = slct_sbj[2];

			pentaksiran = "P"; // P = Pusat			

			$('#btn_config_markP').attr("disabled", "disabled");

			$.blockUI({
				message: '<h5>Sedang diproses, Sila tunggu...</h5><div class="progress progress-striped active" style="width: 70%; margin-left: 15%;"><div class="bar" style="width: 100%;"></div></div>'
			});


			var request = $.ajax({
				url: site_url + "/examination/marking/get_ak_swb",
				type: "POST",
				data: {
					pntksrn: pentaksiran,
					cmID: cm_id,
					type: sb_cat,
					slct_kelas: kelas
				},
				dataType: "json"
			});

			request.done(function(data) {
				//console.log(data);					

				if (null != data.weightage) {
					var row = "";

					if (null != data.configuration) {
						for (var key in data.configuration) //dah ada configurasi mark
						{
							if (data.configuration.hasOwnProperty(key)) {
								var assgmnt_id = data.configuration[key].assgmnt_id;
								var assgmnt_mark = data.configuration[key].assgmnt_mark;
								var assgmnt_name = data.configuration[key].assgmnt_name;
								var assgmnt_score_selection = data.configuration[key].assgmnt_score_selection;
								var assgmnt_total = data.configuration[key].assgmnt_total;
								var la_id = data.configuration[key].la_id;
								if ("AK" == sb_cat) {
									var ptid2 = data.configuration[key].ppr_id;
								} else if ("VK" == sb_cat) {
									var ptid2 = data.configuration[key].pt_id;
								}

								row = row + '<tr >' +
									'<td ><input type="hidden" name="tgsid' + key + '" id="tgsid' + key + '" value="' + assgmnt_id + '">' +
									'<input type="text" name="tugasan' + key + '" id="tugasan' + key + '" class="span7" readonly="readonly" value="' + assgmnt_name + '"/></td>' +
									'<td ><input type="text" name="peratusan' + key + '" id="peratusan' + key + '" class="span7" readonly="readonly" value="' + assgmnt_mark + '"/></td>' +
									'<td ><input type="text" name="jmlhtugsan' + key + '" id="jmlhtugsan' + key + '" class="validate[required] span7" readonly="readonly" value="' + assgmnt_total + '"/></td>' +
									'<td ><input type="text" name="tugasanterbaik' + key + '" id="tugasanterbaik' + key + '" class="validate[required] span7" readonly="readonly" value="' + assgmnt_score_selection + '"/></td>' +
									'<td>&nbsp;</td>' +
									'</tr>';
							}
						}

						ptid = ptid2;
						$('#catPentaksiran').html(row);
					} else // system akan buat configurasi kalau xde lagi
					{
						for (var key in data.weightage) {
							if (data.weightage.hasOwnProperty(key)) {
								var modPaper = data.weightage[key].mod_paper;

								if ("AK" == sb_cat) {
									var pprPercentage = data.weightage[key].ppr_percentage;
									var pprid = data.weightage[key].ppr_id;

									row = row + '<tr >' +
										'<td >' +
										'<input type="text" name="tugasan' + key + '" id="tugasan' + key + '" class="span7" readonly="readonly" value="' + modPaper + '"/></td>' +
										'<td ><input type="text" name="peratusan' + key + '" id="peratusan' + key + '" class="span7" readonly="readonly" value="' + pprPercentage + '"/></td>' +
										'<td ><input type="text" name="jmlhtugsan' + key + '" id="jmlhtugsan' + key + '" class="validate[required] span7" readonly="readonly" value="1"/></td>' +
										'<td ><input type="text" name="tugasanterbaik' + key + '" id="tugasanterbaik' + key + '" class="validate[required] span7" readonly="readonly" value="1"/></td>' +
										'<td>&nbsp;</td>' +
										'</tr>';
								} else if ("VK" == sb_cat) {
									var pamali = data.weightage[key].pt_amali;
									var pteori = data.weightage[key].pt_teori;
									var pprid = data.weightage[key].pt_id;

									row = row + '<tr >' +
										'<td >' +
										'<input type="text" name="tugasan0" id="tugasan0" class="span7" readonly="readonly" value="Teori"/></td>' +
										'<td ><input type="text" name="peratusan0" id="peratusan0" class="span7" readonly="readonly" value="' + pteori + '"/></td>' +
										'<td ><input type="text" name="jmlhtugsan0" id="jmlhtugsan0" class="validate[required] span7" readonly="readonly" value="1"/></td>' +
										'<td ><input type="text" name="tugasanterbaik0" id="tugasanterbaik0" class="validate[required] span7" readonly="readonly" value="1"/></td>' +
										'<td>&nbsp;</td>' +
										'</tr>' +
										'<tr >' +
										'<td >' +
										'<input type="text" name="tugasan1" id="tugasan1" class="span7" readonly="readonly" value="Amali"/></td>' +
										'<td ><input type="text" name="peratusan1" id="peratusan1" class="span7" readonly="readonly" value="' + pamali + '"/></td>' +
										'<td ><input type="text" name="jmlhtugsan1" id="jmlhtugsan1" class="validate[required] span7" readonly="readonly" value="1"/></td>' +
										'<td ><input type="text" name="tugasanterbaik1" id="tugasanterbaik1" class="validate[required] span7" readonly="readonly" value="1"/></td>' +
										'<td>&nbsp;</td>' +
										'</tr>';
								}
							}
						}

						ptid = pprid;
						$('#catPentaksiran').html(row);
					}

					$('#ksmid2').val(cm_id);
					$("#kursusid").val($('#slct_kursus').val());
					$("#subjectid").val(sb_id);
					$("#semesterP").val($('#slct_tahun').val());
					$("#pentaksiran").val(pentaksiran);
					$("#mptID").val(ptid);
					$('#tempKAt2').val(sb_cat);
					$('#kelas3').val(kelas);
					$('#formConfig').submit();

				} else {

					$.unblockUI();
					var mssg = new Array();
					mssg['heading'] = 'Pemberitahuan!';
					mssg['content'] = 'Weightage null, sila hubungi lembaga peperiksaan';

					kv_alert(mssg);
				}
			});

			request.fail(function(jqXHR, textStatus) {
				//fakhruz: modify untuk offline function, load data dari database
				if (jqXHR.status == "0") {
					var semester = $('#slct_tahun').val();
					var slct_sbj = $('#slct_jubject').val().split(":");
					var kursus = $('#slct_kursus').val();
					var slct_sbj_orig = $('#slct_jubject').val();
					var slct_kelas = $('#slct_kelas').val();

					var sb_id = slct_sbj[0];
					var sb_cat = slct_sbj[1];
					var cm_id = slct_sbj[2];

					$('#tblStudentOffline').show();
					$.unblockUI();

					primaryKeyStudent = "PA%" + semester + "%" + kursus + "%" + slct_sbj_orig + "%" + slct_kelas;

					localforage.getItem(primaryKeyStudent, function(readValue) {
						var ex = document.getElementById('tblStudentOffline');
						if (readValue == null) {

							if ($.fn.DataTable.fnIsDataTable(ex)) {
								otblStudentOffline.fnDestroy();
							}

							$('.fixedHeader').hide();

							console.log(fixedHeaderStudentOffline);

							$('#tblStudentOffline > thead').html("");
							$('#tblStudentOffline > tbody').html("");

							$('#tblStudentOffline').hide();

							var mssg = new Array();
							mssg['heading'] = 'Message';
							mssg['content'] = 'Modul ini belum tersedia dengan function offline';

							kv_alert(mssg);
						} else {
							//kita kena hapuskan datatable objek sebab kita kena re-create

							if ($.fn.DataTable.fnIsDataTable(ex)) {
								otblStudentOffline.fnDestroy();
							}

							$('#tblStudentOffline > thead').html("");
							$('#tblStudentOffline > tbody').html("");

							var thead = '<tr style="background-color:white;">' +
								'<th style="text-align:center;width:3%;">BIL</th>' +
								'<th align="left" width="30%">NAMA MURID</th>' +
								'<th align="left" width="10%">ANGKA GILIRAN</th>';

							var j = 0;
							$.each(readValue, function(key, valSubjek) {
								var aPelajar = readValue.pelajar;
								var aSubject = readValue.subjekconfigur;

								if (key == "subjekconfigur") {

									$.each(aSubject, function(kSub, valSub) {
										var assignment = valSub.assgmnt_name;
										if (assignment.toLowerCase() == "teori") {
											thead += '<th align="center" width="4%"><a onclick="fnOpenAssignment(' + valSub.assgmnt_id + ')">' + assignment.toUpperCase() + ' / ' + valSub.assgmnt_mark + '&nbsp;&nbsp;<img src="' + base_url + 'assets/img/edit.png"></a></th>';
										} else if (assignment.toLowerCase() == "amali") {
											thead += '<th align="center" width="4%"><a onclick="fnOpenAssignment(' + valSub.assgmnt_id + ')">' + assignment.toUpperCase() + ' / ' + valSub.assgmnt_mark + '&nbsp;&nbsp;<img src="' + base_url + 'assets/img/edit.png"></a></th>';
										} else {
											if (sb_cat == "AK") {
												thead += '<th align="center" width="4%"><a onclick="fnOpenAssignment(' + valSub.assgmnt_id + ')">' + assignment.toUpperCase() + ' / ' + valSub.assgmnt_mark + '&nbsp;&nbsp;<img src="' + base_url + 'assets/img/edit.png"></a></th>';
											}
										}
										var iTotalMark = valSub.assgmnt_mark;
										j += Number(iTotalMark);
									}); //end aSubject
									thead += '<th width="8%">JUMLAH / ' + j + '</th>';

									$("#tblStudentOffline > thead").html(thead);
								} //end if subjekconfigur

								if (key == "pelajar") {
									$(aPelajar).each(function(index) {
										var tbody = '<tr><td align="center">' + (index + 1) + '</td>' + '<td align="left">' + aPelajar[index].stu_name.toUpperCase() + '</td>' + '<td align="left">' + aPelajar[index].stu_matric_no + '</td>';

										var iFinalTotal = 0;
										var iTotalStudMark = 0;
										var bTStatus = 0;
										//add student mark
										$(aSubject).each(function(indSub) {
											var iMarkah = aPelajar[index].markah[indSub];

											if (iMarkah == "T") {
												bTStatus++;
											} else {
												iMarkah = Math.ceil(Number(iMarkah));
												iTotalStudMark += Number(iMarkah);
											}

											tbody += '<td align="center">' + '<input type="text" readonly="readonly" name="jumlah' + aPelajar[index].stu_id + aSubject[indSub].assgmnt_id + '" id="jumlah' + aPelajar[index].stu_id + aSubject[indSub].assgmnt_id + '" style="width: 100px;" value="' + iMarkah + '"></td>';
											//console.log(tbody);
										});


										if (bTStatus == aPelajar[index].markah.length) {
											iFinalTotal = "T";
										} else {
											iFinalTotal = iTotalStudMark;
										}

										tbody += '<td id="ttlMark_' + aPelajar[index].stu_id + '" align="center" class="ttlmrks">' + iFinalTotal + '</td>';

										tbody += '</tr>';

										$("#tblStudentOffline > tbody").append(tbody);

									});
								} //end key pelajar
							});

							otblStudentOffline = $("#tblStudentOffline").dataTable({
								"aoColumnDefs": [{
									bSortable: false,
									aTargets: [0]
								}],
								"bPaginate": false,
								"bFilter": true,
								"bAutoWidth": false,
								"bInfo": false,
								"aaSorting": [
									[1, 'asc']
								],
								"oLanguage": {
									"sSearch": "Carian :"
								},
								"fnDrawCallback": function(oSettings) {
									if (oSettings.bSorted || oSettings.bFiltered) {
										for (var i = 0, iLen = oSettings.aiDisplay.length; i < iLen; i++) {
											$('td:eq(0)', oSettings.aoData[oSettings.aiDisplay[i]].nTr).html(i + 1);
										}
									}
								}
							});

							if ($("#tblStudentOffline").length > 0) {
								fixedHeaderStudentOffline = new FixedHeader(otblStudentOffline, {
									"offsetTop": 40
								});

								fixedHeaderStudentOffline.fnUpdate();
							}

						}
					});

				} else {
					var mssg = new Array();
					mssg['heading'] = 'Message';
					mssg['content'] = 'Request failed: ' + textStatus;

					kv_alert(mssg);
				}
			});
		}
	});

	$('#btn_save_mark').click(function() {
		var mssg = new Array();
		mssg['heading'] = 'Message';
		mssg['content'] = 'Markah Pentaksiran Pusat Berjaya disimpan';

		kv_alert(mssg);
	});

	$('#assgmnpop').on('shown.bs.modal', function() {
		$('#tblAssgnMarks').dataTable().fnAdjustColumnSizing(false);
	});

	//fakhruz : function ni untuk check offline jaaaa...
	var request = $.ajax({
		url: site_url + "/main/check_online",
		type: "POST",
		dataType: "html"
	});

	request.done(function(data) {
		$("#panelTblOffline").html("");
	});

	request.fail(function(jqXHR, textStatus) {
		if (jqXHR.status == "0")
			console.log("start offline module...");
	});

}); //end of document.ready
/**************************************************************************************************
 * End of marking.js
 ***********************************************************************************************/