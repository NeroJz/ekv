$(document)
		.ready(
				function() {

					var loadingIcon = '<h6><img src="'
							+ base_url
							+ 'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h6>';

					$("#panelReportStudent").html(loadingIcon);

					setTimeout(function() {
						// ajax submit to delete
						var request = $.ajax({
							url : site_url + "/main/statisticStudent",
							type : "POST",
							dataType : "html"
						});

						request.done(function(data) {
							$("#panelReportStudent").html(data);
						});

						request.fail(function(jqXHR, textStatus) {
							$.unblockUI();
							console.log("Request failed" + textStatus);
						});
					}, 1500);
				});