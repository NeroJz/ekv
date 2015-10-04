<legend><h3>Senarai Pengarah Kolej</h3></legend>

<script>
check = false;


		var giCount = 1;
		$(document).ready(function(){	

			$("#table_id").dataTable({
				"aoColumnDefs": [{ bSortable: false, aTargets: [0] } ],
				"bPaginate": true,
				"bFilter": true,
				"bInfo": false,
				"bJQueryUI": true,
				"aaSorting": [[ 1, "asc" ]],
				"oLanguage": { "sSearch": "Carian :" },
				//"complete":reAssignTable,
				"fnDrawCallback": function ( oSettings ) {
					if ( oSettings.bSorted || oSettings.bFiltered )
					{
						for ( var i=0, iLen=oSettings.aiDisplay.length ; i<iLen ; i++ )
						{
							$("td:eq(0)", oSettings.aoData[ oSettings.aiDisplay[i] ].nTr ).html( i+1 );
						}
					}
				},
				"complete":reAssignTable
			});
		});
		
		function fnClickAddRow() {
			$("#table_id").dataTable().fnAddData( [
				giCount+".1",
				giCount+".2",
				giCount+".3",
				giCount+".4",
				giCount+".5",
				giCount+".6",
				giCount+".7",
				giCount+".8" ] );
			giCount++;
		}
		
		function reAssignTable()
		{
			$(".btn_edit_director").bind("click",function(){
		        $('#myDirectorModal').modal({
		          	keyboard: false
		        });
		        $("#btn_edit").click(function() {
		 	 		$("#form_edit_director").submit();
		 		}); 
				var user_id = $(this).attr("title");
				jAjaxLm("#span_result",site_url + "management/user/edit_director/" + user_id,'');
		    });
		}

	</script>
	<!-- Button to trigger modal -->
	<a href="#myModal" role="button" class="btn btn-primary" data-toggle="modal">+ Pengarah Baru</a><br>
	
	<!--START Generate Datatable-->
	<?php
	
	$tmpl = array('table_open' => '<table id="table_id" class="display">');

	$this -> table -> set_template($tmpl);
	$this -> table -> set_heading('id','Nama Pengguna', 'Katanama', 'Email', 'Tarikh Daftar', 'Tarikh Log Masuk', 'Status', 'Kolej','No Telefon','Jawatan','Tindakan');
	foreach ($query  as $item) {
		$created_on = ($item['created_on']!=null) ? date("d-m-Y",$item['created_on']) : "-" ;
		$last_login = ($item['last_login']!=null) ? date("d-m-Y",$item['last_login']) : "-" ;
		
		$status = ($item['active']==1) ? "aktif" : "tidak aktif" ;
		$this -> table -> add_row('',$item['user_name'], $item['user_username'], $item['user_email'], $created_on, $last_login, $status, $item['col_name'], $item['phone'],$item['ul_name'],'<a title="'.$item['user_id'].'" href="#edit" id="btn_edit_director" name="btn_edit_director" data-toggle="modal"><i class="icon-edit"></i></a>');
	}

	echo $table = $this -> table -> generate();
	?>
	<!--END Generate Datatable-->
 
	<!-- Modal Add Director -->
	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    		<h2 id="myModalLabel">Tambah Pengarah Baru</h2>
  		</div>
  		<div class="modal-body">
    		<form name="form_add_director" method="post" action="<?=site_url('management/user/add_director') ?>">
    			<table>
    				<tr>
    					<td>Nama Pengguna</td>
    					<td>:</td>
    					<td><input type="text" name="nama" id="nama" /></td>
    				</tr>
    				<tr>
    					<td>Katanama</td>
    					<td>:</td>
    					<td><input type="text" name="katanama" id="katanama" /></td>
    				</tr>
    				<tr>
    					<td>Katalaluan</td>
    					<td>:</td>
    					<td><input type="password" name="katalaluan" id="katalaluan" /></td>
    				</tr>
    				<tr>
    					<td>Email</td>
    					<td>:</td>
    					<td><input type="text" name="email" id="email" /></td>
    				</tr>
    				<tr>
    					<td>Status</td>
    					<td>:</td>
    					<td>
    						<select name="status" id="status">
    							<option value="">-- Sila Pilih --</option>
    							<option value="1">Aktif</option>
    							<option value="0">Tidak Aktif</option>
    						</select>
    					</td>
    				</tr>
    				<tr>
    					<td>Kolej</td>
    					<td>:</td>
    					<td>
    						<select name="kolej" id="kolej">
    							<option value="">-- Sila Pilih --</option>
    							<?php
    							foreach ($kv_list as $row){
									?>
									<option value="<?=$row->col_id ?>"><?=$row->col_name ?></option>
									<?php
								}
    							?>
    						</select>
    					</td>
    				</tr>
    				<tr>
    					<td>No. Telefon</td>
    					<td>:</td>
    					<td><input type="text" name="no_tel" id="no_tel" /></td>
    				</tr>
    				<tr>
    					<td>Jawatan</td>
    					<td>:</td>
    					<td><input type="text" name="jawatan" id="jawatan" value="5" />Pengarah</td>
    				</tr>
    				<input type="text" name="tarikh_daftar" id="tarikh_daftar" value="<?=time() ?>" />
    			</table>
    		
  		</div>
  		<div class="modal-footer">
    		<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
    		<input type="submit" value="Tambah" class="btn btn-primary">
    		<!--button class="btn btn-primary" data-dismiss="modal" onclick="fnClickAddRow()">Tambah</button-->
  		</div>
  		</form>
	</div>
	
<!-- Modal Update Director -->
	<div id="myDirectorModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  		<div class="modal-header">
    		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
    		<h2 id="myModalLabel">Tambah Pengarah Baru</h2>
  		</div>
  		<div class="modal-body" id="span_result">
    		
    		
  		</div>
  		<div class="modal-footer">
    		<button class="btn" data-dismiss="modal" aria-hidden="true">Tutup</button>
    		<input type="submit" value="Tambah" name="btn_edit" id="btn_edit" class="btn btn-primary">
    		<!--button class="btn btn-primary" data-dismiss="modal" onclick="fnClickAddRow()">Tambah</button-->
  		</div>
	</div>