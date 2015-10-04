<script language="javascript" type="text/javascript" >
	$(document).ready(function()
	{	
			$("#frm_pusat").validationEngine(
			'attach', {scroll: false}	
		);
		
		var kodkv = [
			<?= $centrecode ?>
		];
		
		$( "#kodpusat" ).autocomplete({
			source: kodkv
		});	
	
	
		function reAssignTable()
{
	
}

var loading_img = "<?=base_url()?>assets/img/loading_ajax.gif";
	
	oTable = $('#fin_ajax').dataTable( {
            "sDom": 'T<"clear spacer"><"H"lfr>t<"F"ip>',
        "bSort": true,
        "oTableTools": 
			{
                "sSwfPath": "<? echo base_url()."assets/img/swf/copy_csv_xls_pdf.swf"; ?>",
				"aButtons": [
								{
									"sExtends": "xls",
									"sButtonText": "SAVE TO EXCEL"
								},
								{
									"sExtends": "pdf",
									"sButtonText": "SAVE TO PDF"
								}
							] 
				
            } ,
											  "oLanguage": {
				"sProcessing": '<img src="'+loading_img+'" width="24" height="24" align="center"/> Sedang diproses...',
					"sLengthMenu": 'Paparan <select>'+
        '<option value="10">10</option>'+
        '<option value="100">100</option>'+
        '<option value="150">150</option>'+
        '<option value="200">200</option>'+
        '<option value="250">250</option>'+
        '<option value="-1">All</option>'+
        '</select> rekod',
					"sZeroRecords": "No Records Found!",
					"sEmptyTable": "No Records Found!",
					"sLoadingRecords": "Loading...",
					"sInfo": "Paparan _START_ hingga _END_ daripada _TOTAL_ Rekod",
					"sInfoEmpty": "Paparan 0 hingga 0 daripada 0 rekod",
					"sInfoFiltered": " ",
					"sInfoPostFix": "",
					"sSearch": "Carian:",
					"sUrl": "",
						    "oPaginate": {
						      "sFirst": "Pertama",
						      "sLast": "Terakhir",
						      "sNext": "Seterus",
						      "sPrevious": "Sebelum"
					}
			},
    "aoColumns": [
      { "bSortable": false },
      { "bSortable": false },{ "bSortable": false },{ "bSortable": false },
      { "bSortable": false },{ "bSortable": false },{ "bSortable": false },{ "bSortable": false }
    ],
	"iDisplayLength": 10,
    "aaSorting": [[1, 'asc']],
    "bJQueryUI": true,
	
    "sPaginationType": "full_numbers",
    "bProcessing": true,
    "bServerSide": true,
   
	"sAjaxSource": "<?=site_url('report/report/reportfin_ajax/')?>",
    "fnServerData": function ( sSource, aoData, fnCallback ) {
		 aoData.push({"name": "search", "value": "<?=isset($search)?$search:""?>"});
      $.ajax( {
        "dataType": 'json', 
        "type": "POST", 
        "url": sSource, 
        "data": aoData, 
        "success": fnCallback,
        "complete":reAssignTable
      } );
    }

  });
  
  

  
  });
	
</script>

<legend><h3>Pengesahan Maklumat Pendaftaran</h3></legend>
<center>

<form id="frm_pusat" action="<?= site_url('form/confirmation/print_student_information')?>" method="post" target="_blank">
<table class="breadcrumb border" width="100%" align="center">
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
 
        	<?php
        	$colll=empty($colname)?'':$colname;
			
			if($colll!=''){
        	?>
          <input type="hidden" value="<?=$colll?>" name="kodpusat" />
          <?php
    }else{
    	?>
    	 <tr>
    	<td width="45%" height="35"><div align="right">Kod Pusat</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35"><div align="left">
    	<input type="text" name="kodpusat" id="kodpusat" class="span3" style="margin-left:0px;width:270px;"/>
    	<?php
    }
	?>
        </div>
        </td>
    </tr>
      <tr>
    	<td width="45%" height="35"><div align="right">Semester</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35"><div align="left"><select width="50%" style="width:270px;" name="semester" id="semester" class="validate[required]">
        	<option value="">-- Sila Pilih --</option>
        	<option value="1">1</option>
        	<option value="2">2</option>
        	<option value="3">3</option>
        	<option value="4">4</option>
        	<option value="5">5</option>
        	<option value="6">6</option>
        	<option value="7">7</option>
        	<option value="8">8</option>
        	</select></td>
          
        </div>
        </td>
    </tr>
          <tr>
    	<td height="35"><div align="right">Tahun</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                <select id="slct_tahun" name="mt_year" style="width:270px;" class="validate[required]">
                	<option value="">-- Sila Pilih --</option>
            		<?php			
				foreach ($year as $row)
				{
			?>
					<option value="<?= $row->mt_year ?>">
					    <?= strtoupper($row->mt_year) ?>
                    </option>
		    <?php 
				} 
				
				//form_hidden('statusID', '1');
			?>
                </select>
            </div>
        </td>
    </tr>
    <tr style="display: none;">
    	<td height="35"><div align="right">Status</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                <select id="statusID" name="status" style="width:270px;" class="validate[required]" >
                	<option value="">-- Sila Pilih --</option>
            		<option value="1">Biasa</option>
            		<option value="2">Mengulang</option>
                </select>
           
            </div>
        </td>
    </tr>
    <tr>
    	<td></td>
    	<td height="35"><div align="right"></div></td>
        <td height="35">
        	<div align="left">
          		<input class="btn btn-info" type="submit" name="btn_papar" value="Papar Laporan">
        	</div>
        </td>
    </tr>
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
</table>
</form>

</center>

<?php if(isset($_POST['btn_papar']) ){ ?>
<table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#E5E5E5" class="display " id="fin_ajax">
        <thead>
            <tr>
                <th width="80" id="tdleft" align="center">Bil</a></th>
                <th width="400" align="center">NAMA CALON</th>
		<th width="195" id="tdright" align="center">MyKad</th>
                <th width="195" id="tdright" align="center">ANGKA GILIRAN</th>
                <th width="195" id="tdright" align="center">KOD KURSUS</th>
                <th width="195" id="tdright" align="center">JANTINA</th>
                <th width="195" id="tdright" align="center">KAUM</th>
                <th width="195" id="tdright" align="center">AGAMA</th>
            </tr>
        </thead>
        
    </table>
    <?php  } ?>