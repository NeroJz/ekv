<script>
	var loading_img = "<?=base_url()?>assets/img/loading_ajax.gif";
	$(document).ready(function() {
		$("#table_id").hide();
		
		var cache = {};
		var iColid = <?= $colid ?>;
		$("#nama").autocomplete({
		  source: function(request, response) {
		    var term          = request.term.toLowerCase(),
		        element       = this.element,
		        cache         = this.element.data('autocompleteCache') || {},
		        foundInCache  = false;
		      $.ajax({
		          url: '<?= site_url() ?>/student/student_management/ajax_student_autosuggest/'+iColid,
		          dataType: "json",
		          data: request,
		          success: function(data) {
		              cache[term] = data;
		              response(data);
		          }
		      });
		  },
		  minLength: 2
		});
		
		var cache = {};
		$("#angka_giliran").autocomplete({
		  source: function(request, response) {
		    var term          = request.term.toLowerCase(),
		        element       = this.element,
		        cache         = this.element.data('autocompleteCache') || {},
		        foundInCache  = false;
		      $.ajax({
		          url: '<?= site_url() ?>/student/student_management/ajax_student_matric_autosuggest/'+iColid,
		          dataType: "json",
		          data: request,
		          success: function(data) {
		              cache[term] = data;
		              response(data);
		          }
		      });
		  },
		  minLength: 2
		});
		
		$("#cari").bind("click",function(){
			$("#table_id").show();
			var sNama =$('#nama').val();
			var sAngka_giliran =$('#angka_giliran').val();
			var sMykad =$('#mykad').val();
			var sSem =$('#sem').val();
			
			var oTable=$("#table_id").dataTable({
				"bPaginate" : true,
				"sPaginationType" : "full_numbers",
				"bFilter" : true,
				"bInfo" : true,
				"bDestroy" : true,//nk reinitailize time nak repopulate data
				"bJQueryUI" : true,
				"bPaginate" : true,
				"iDisplayLength": 10,
				"aaSorting" : [[0, "asc"]],
				"aoColumn" : [
					null,null,null,null,null
				],
				"aoColumnDefs": [
     				{ "sWidth": "30%", "aTargets": [ 0 ] },
     				{ "sWidth": "10%", "aTargets": [ 1 ] },
     				{ "sWidth": "15%", "aTargets": [ 2 ] },
     				{ "sWidth": "8%", "aTargets": [ 3 ] },
     				{ "sWidth": "5%", "aTargets": [ 4 ] }
    			],
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
				},
				"bProcessing": true,
				"bServerSide":true,
				"sAjaxSource": "<?= site_url('student/student_management/ajax_student_pindah_response'); ?>",
				"fnServerData": function(sSource, aoData, fnCallback){
					aoData.push({"name": "nama", "value": sNama});
					aoData.push({"name": "angka_giliran", "value": sAngka_giliran});
					aoData.push({"name": "mykad", "value": sMykad});
					aoData.push({"name": "sem", "value": sSem});
					$.ajax({
						"dataType": 'json',
						"type":"POST",
						"url":sSource,
						"data":aoData,
						"success":fnCallback
					});
				}
			});
			new FixedHeader( oTable, {
				"offsetTop": 40
			} );
		});
	}); 
</script>
<legend>
	<h3>Pindah Murid</h3>
</legend>
<center>
	<form id="pindah" class="pindah" action="<?=site_url() ?>/student/student_management/pindah" method="post">
		<table class="breadcrumb border" width="100%" align="center">
			<tr>
				<td width="240" align="right">&nbsp;</td>
				<td width="10" align="center">&nbsp;</td>
				<td width="368" height="35" align="left" style="font-size: 16px;font-weight: bold;">&nbsp;</td>
			</tr>
			<tr>
				<td align="right">Nama</td>
				<td align="center">:</td>
				<td height="35">
				<input type="text" name="nama" id="nama" placeholder="Cth: Muhammad" />
				</td>
			</tr>
			<tr>
				<td align="right">Angka Giliran</td>
				<td align="center">:</td>
				<td height="35">
				<input type="text" name="angka_giliran" id="angka_giliran" placeholder="Cth: K000CEA000" />
				</td>
			</tr>
			<tr>
				<td align="right">MyKad</td>
				<td align="center">:</td>
				<td height="35">
				<input type="text" name="mykad" id="mykad" placeholder="Cth: 890909095501" />
				</td>
			</tr>
			<tr>
				<td align="right">Semester</td>
				<td align="center">:</td>
				<td height="35">
				<?php
				$options[0]=" -- Sila Pilih -- ";
				for($i=1;$i<=10;$i++){
					$options[$i]=$i;
				}
				echo form_dropdown('sem', $options,'',"id='sem'");
				?>
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td >
				<input class="btn btn-info" type="button" name="btn_carian" value="Cari" id="cari">
				<input class="btn" type="reset" name="btn_reset" value="Set Semula">
				<br />
				</td>
			</tr>
			<tr>
				<td></td>
				<td></td>
				<td >&nbsp;</td>
			</tr>

		</table>
		<input type="hidden" name="form_submit" value="true">
	</form>
</center>
<?php
$tmpl = array('table_open' => '<table id="table_id" width="100%">',
			 'heading_cell_start'  => '<th><b>',
             'heading_cell_end'    => '</b></th>');
$this -> table -> set_template($tmpl);
$this -> table -> set_heading("NAMA MURID", "MYKAD", "ANGKA GILIRAN", "SEMESTER", "TINDAKAN");
echo $this -> table -> generate();

// print_r($result);
// echo $this -> db -> last_query();
?>
