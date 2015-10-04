<script type="text/javascript">
	var loading_img = "<?=base_url()?>assets/img/loading_ajax.gif";
	$(document).ready(function() {
			
			var oTable = $("#table_ann").dataTable({
				"bPaginate" : true,
				"sPaginationType" : "full_numbers",
				"bFilter" : true,
				"bInfo" : true,
				"bDestroy" : true,
				"bJQueryUI" : true,
				"bPaginate" : true,
				"iDisplayLength": 10,
				"aaSorting" : [[0, "asc"]],
				"aoColumn" : [
					null,null,null,null,null,null,null,null
				],
				// "aoColumnDefs": [
    //  				{ "sWidth": "35%", "aTargets": [ 0 ] },
    //  				{ "sWidth": "10%", "aTargets": [ 1 ] },
    //  				{ "sWidth": "15%", "aTargets": [ 2 ] },
    //  				{ "sWidth": "8%", "aTargets": [ 3 ] },
    //  				{ "sWidth": "20%", "aTargets": [ 4 ] }
    // 			],
				"oLanguage" : {
					"sProcessing":'<img src="'+loading_img+'" width="24" height="24" align="center"/> Sedang diproses...',
					"sSearch" : "Carian :",
					"sLengthMenu" : "Papar _MENU_ senarai",
					"sInfo" : "Papar _START_-_END_ dari _TOTAL_ rekod",
					"sInfoEmpty" : "Showing 0 to 0 of 0 records",
					"oPaginate" : {
						"sFirst" : "Pertama",
						"sLast" : "Akhir",
						"sNext" : "Seterus",
						"sPrevious" : "Sebelum"
					}
				}
			});
			new FixedHeader( oTable, {
				"offsetTop": 40
			} );
		});
</script>
<?= $table ?>