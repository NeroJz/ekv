<script>

	$(document).ready(function() {
		$("#col_table").dataTable({
			"aoColumnDefs" : [{
				bSortable : false,
				aTargets : [4]
			}],
			"bPaginate" : true,
			"sPaginationType" : "full_numbers",
			"bFilter" : true,
			"bInfo" : true,
			"bJQueryUI" : true,
			"sScrollY": "200px",
			"bPaginate": true,
			"aaSorting" : [[0, "asc"]],
			"oLanguage": {  "sSearch": "Carian :",
 						"sLengthMenu": "Papar _MENU_ senarai",
	 					"sInfo": "Papar _START_-_END_ dari _TOTAL_ rekod",
						"sInfoEmpty": "Showing 0 to 0 of 0 records",
						    "oPaginate": {
						      "sFirst": "Pertama",
						      "sLast": "Akhir",
						      "sNext": "Seterus",
						      "sPrevious": "Sebelum"
						     }
 						 },
			// "fnDrawCallback" : function(oSettings) {
				// if (oSettings.bSorted || oSettings.bFiltered) {
					// for (var i = 0, iLen = oSettings.aiDisplay.length; i < iLen; i++) {
						// $("td:eq(0)", oSettings.aoData[oSettings.aiDisplay[i]].nTr).html(i + 1);
					// }
				// }
			// }
		});
	});
</script>
<legend><h4>Penyelenggaraan Kursus - Tambah Kolej</h4></legend>
<table class="breadcrumb border" width="100%" align="left">
    <tbody><tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
    <tr>
    	<td width="35%"><div align="right">Nama Kursus</div></td>
        <td width="3%"><div align="center">:</div></td>
        <td width="52%">
            <div align="left"><b>
            	<?=$cou_name?>
            </div></b>        
        </td>
    </tr>
    <tr>
    	<td width="35%"><div align="right">Kod</div></td>
        <td width="3%"><div align="center">:</div></td>
        <td width="52%">
            <div align="left"><b>
            	<?=$cou_code?>
            </div></b>        
        </td>
    </tr>
    <tr>
    	<td width="35%"><div align="right">Kod Kursus</div></td>
        <td width="3%"><div align="center">:</div></td>
        <td width="52%">
            <div align="left"><b>
            	<?=$cou_course_code?>
            </div></b>        
        </td>
    </tr>
    <tr>
    	<td width="35%"><div align="right">Kluster Kursus</div></td>
        <td width="3%"><div align="center">:</div></td>
        <td width="52%">
            <div align="left"><b>
            	<?=$cou_cluster?>
            </div></b>
        </td>
    </tr>
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
</tbody></table>
<!-- FORM -->
<center>
<?php
$hidden = array('cou_id'=>$cou_id);
echo form_open('maintenance/crud_course/add_cc','',$hidden);
echo form_dropdown('col_id',$kv_list);
$button = array(
    'name' 		=> 'tambah',
    'id' 		=> 'tambah_button',
    'type' 		=> 'submit',
    'content'	=> 'Tambah',
    'class'		=> 'btn btn-info btn-small',
    'style'		=> "margin: 0px 0px 10px 10px"
);
echo form_button($button);
echo form_close();
?>
</center>