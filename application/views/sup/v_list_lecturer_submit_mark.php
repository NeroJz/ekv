<style type="text/css">
#box {
    width: 100%;
    font-size: 14px;
    font-weight: bold;
}
strong{ color:#000;}
</style>

<script type="text/javascript">

$(document).ready(function() 
{
	$("#form_seach").validationEngine();
	//$("#form_seach").validationEngine('attach', {scroll: false});
	/* Initialise the DataTable */
 
	oTable = $('#lecturer_submit_mark_ajax').dataTable({

		
		"oLanguage": {
		"sProcessing": "Sedang Diproses...",
		"sLengthMenu": 'Paparan <select>'+
		'<option value="10">10</option>'+
		'<option value="50">25</option>'+
		'<option value="100">50</option>'+
		'<option value="150">100</option>'+
		'<option value="200">150</option>'+
		'<option value="-1">Semua</option>'+
		'</select> rekod',
		"sZeroRecords": "Tiada Rekod Ditemui!",
		"sEmptyTable": "Tiada Rekod Ditemui!",
		"sLoadingRecords": "Loading...",
		"sInfo": "Paparan _START_ hingga _END_ daripada _TOTAL_ rekod",
		"sInfoEmpty": "Paparan 0 hingga 0 daripada 0 rekod",
		"sInfoFiltered": " ",
		"sInfoPostFix": "",
		"sSearch": "Carian:",
		"sUrl": "",
		"oPaginate": {
		"sFirst":    "Mula",
		"sPrevious": "Sebelum",
		"sNext":     "Selepas",
		"sLast":     "Akhir"
				}
		},
		"aoColumns": [
		  { "bSortable": false },null,null,null,null
		],
		
		"iDisplayLength": 10,
		"aaSorting": [[1, 'asc']],
		"bJQueryUI": true,
		"sPaginationType": "full_numbers",
		"bProcessing": true,
		"bServerSide": true,
		"bPaginate": true,
		"sAjaxSource": "<?=site_url('sup/lecturer/lect_submit_mark_ajax');?>",
		"fnServerData": function ( sSource, aoData, fnCallback ) {
		 aoData.push({"name": "search", "value": "<?=$search?>"});
		 var ajaxTime= new Date().getTime();
		  $.ajax( {
		    "dataType": 'json', 
		"type": "POST", 
		"url": sSource, 
		"data": aoData, 
		 "success": fnCallback
		      });
		    }
	});

	new FixedHeader( oTable,
	{
		"offsetTop": 40
	});
});

</script>


<legend><h3>Carian Pensyarah Sudah/Belum Hantar Markah Pentaksiran</h3></legend>
<center>
    <form name="form_seach" id="form_seach" action="" method="post">
    
     <table class="breadcrumb border" width="100%" align="center">

                <tr>
                  <td width="240" align="right">&nbsp;</td>
                  <td width="10" align="center">&nbsp;</td>
                  <td width="368" height="35" align="left" style="font-size: 16px;font-weight: bold;">&nbsp;</td>
                </tr>
                <tr>
                    <td align="right">Pengurusan</td>
                  	<td align="center">:</td>
                    <td height="35"><select name="pengurusan" id="pengurusan">
                    	<option value="">-- Sila Pilih --</option>
		                <option <?php if(isset($_POST["pengurusan"]) && $_POST["pengurusan"]=="AK") { ?>	selected="selected"	<?php } ?> value="AK">Akademik</option>
		                <option <?php if(isset($_POST["pengurusan"]) && $_POST["pengurusan"]=="VK") { ?>	selected="selected"	<?php } ?> value="VK">Vokasional</option>
		             </select>   
                    </td>
                </tr>
                <tr>
                    <td align="right">Semester</td>
                  	<td align="center">:</td>
                    <td height="35">
                    <select name="semester" id="semester" >
                		<option value="">-- Sila Pilih --</option>
                    	<option <?php if(isset($_POST["semester"]) && $_POST["semester"]==1) { ?>	selected="selected"	<?php } ?> value="1">1</option>
                    	<option <?php if(isset($_POST["semester"]) && $_POST["semester"]==2) { ?>	selected="selected"	<?php } ?> value="2">2</option>
                    	<option <?php if(isset($_POST["semester"]) && $_POST["semester"]==3) { ?>	selected="selected"	<?php } ?>value="3">3</option>
                    	<option <?php if(isset($_POST["semester"]) && $_POST["semester"]==4) { ?>	selected="selected"	<?php } ?>value="4">4</option>
                    	<option <?php if(isset($_POST["semester"]) && $_POST["semester"]==5) { ?>	selected="selected"	<?php } ?>value="5">5</option>
                    	<option <?php if(isset($_POST["semester"]) && $_POST["semester"]==6) { ?>	selected="selected"	<?php } ?>value="6">6</option>
                    	<option <?php if(isset($_POST["semester"]) && $_POST["semester"]==7) { ?>	selected="selected"	<?php } ?>value="7">7</option>
                    	<option <?php if(isset($_POST["semester"]) && $_POST["semester"]==8) { ?>	selected="selected"	<?php } ?>value="8">8</option>
                    </select>
                    </td>
                </tr>
                <tr>
                    <td align="right">Status</td>
                  	<td align="center">:</td>
                    <td height="35"><select name="status" id="status" class="validate[required]">
		                <option selected="selected" <?php if(isset($_POST["status"]) && $_POST["status"]==1) { ?>	selected="selected"	<?php } ?> value="1">Sudah Hantar</option>
		                <option <?php if(isset($_POST["status"]) && $_POST["status"]==2) { ?>	selected="selected"	<?php } ?> value="2">Belum Hantar</option>
		             </select>   
                    </td>
                </tr>
                <tr>
             <input name="redirect" type="hidden" value="<?= $this->uri->uri_string() ?>" />
            <td></td>
            <td></td>
            <td ><input class="btn btn-info" type="submit" name="btn_carian" value="Cari"> <a class="btn" href="<?=site_url('sup/lecturer') ?>">Set Semula</a>
                <br />
            </td>
            </tr>
                <tr>
                  <td></td>
                  <td></td>
                  <td >&nbsp;</td>
                </tr>
       
      </table>        
	</form>
</center>


<?php if(isset($_POST["btn_carian"]) || !empty($cari)){?>


<form name="form2" id="form1" action="" method="post">
   
	<table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#E5E5E5" class="display" id="lecturer_submit_mark_ajax">
	    <thead>
	        <tr>
	            <th width="80" id="tdleft" align="center">Bil</th>
	            <th width="400" align="tdright">Nama Pensyarah</th>
				<th width="195" id="tdright" align="center">Subjek</th>
	            <th width="195" id="tdright" align="center">Kursus</th>
	            <th width="195" id="tdright" align="center">Semester</th>
	            
	        </tr>
	    </thead>
	</table>
	<br />
	<input name="redirect" type="hidden" value="<?= $this->uri->uri_string() ?>" />
	
</form>
<?php } ?>
