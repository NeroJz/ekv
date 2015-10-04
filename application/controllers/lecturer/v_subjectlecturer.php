
<script type="text/javascript" src="<?= base_url();?>/assets/js/dataTables.fnFakeRowspan.js"></script>

<?php
//print_r($this->session->all_userdata());
?>

<style>

#subject_lecturer_length {

text-align :left;

}

</style>
<script language="javascript" type="text/javascript" >
$(document).ready(function()
{
	$('#subject_lecturer').hide();		
	$('#btn_carian').click(function()
	{
		oTable = $('#subject_lecturer').dataTable(
		{
			"oLanguage": {
							"sProcessing": "Sedang Diproses...",
							"sLengthMenu" : "Papar _MENU_ senarai",
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
			"aoColumns": [ { "bSortable": false },null,null,null,null,null,null],
			"aoColumnDefs" : [{bSortable : false,aTargets : [0,2,3,4,5,6]}],
			"bDestroy" : true,
			"iDisplayLength": 10,
			"aaSorting": [[1, 'asc']],
			"bJQueryUI": true,
			"sPaginationType": "full_numbers",
			"bProcessing": true,
			"bServerSide": true,
			"bPaginate": true,
			"bFilter": true,
			"bAutoWidth": false,
			"sAjaxSource": "<?=site_url('lecturer/assignsubject/ajax_subject_lecturer');?>",
			"fnServerData": function ( sSource, aoData, fnCallback )
							{
								aoData.push({"name": "semester", "value": $('#semester').val()});
								aoData.push({"name": "subject", "value": $('#subject').val()});
								aoData.push({"name": "course", "value": $('#course').val()});
								aoData.push({"name": "lecturer", "value": $('#lecturer').val()});
								$.ajax({
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


		//$('#subject_lecturer').dataTable().fnFakeRowspan(0);
		$('#subject_lecturer').dataTable().fnFakeRowspan(1);
		$('#subject_lecturer').dataTable().fnFakeRowspan(2);
		$('#subject_lecturer').dataTable().fnFakeRowspan(3);
		$('#subject_lecturer').dataTable().fnFakeRowspan(4);
		$('#subject_lecturer').dataTable().fnFakeRowspan(5);
		$('#subject_lecturer').dataTable().fnFakeRowspan(6);
		
		$('#subject_lecturer').show();
	});	

	$("#lecturer" ).autocomplete({
	   	source: [ 

	 <?php foreach ($lecturer as $lec) { ?>
	 
	{value: "<?=$lec->user_name;?>"},
	

	 <?php } ?>
	],

	select: function(event, ui) {
	$("#lecturer_name").val(ui.item.id);
	   }
	 });
		
});
	
function show()
{
	var cid = $('#course').val();
	var sem = $('#semester').val();
    
	var url = '<?php echo site_url('lecturer/assignsubject/subject_list');?>/'+cid+'/'+sem;
          
	$.ajax(
	{
        url: url,
        type:'POST',
        dataType: 'json',
        success: function(data)
        {
        	//console.log(data);
        	
            document.form1.subject.options.length=0;
            $('#subject').html("");
            document.form1.subject.options[0] = new Option('-- Sila Pilih --','',false,false);
            if(data != null)
            {
            	
                for(var i = 0; i < data.length; i++)
                {
                    document.form1.subject.options[i+1] = new Option(data[i].mod_paper+' - '+data[i].mod_name,data[i].mod_id,false,false);
                } // End of success function of ajax form
            }
        }
            
	}); // End of ajax call 
        
    var url = '<?php echo site_url('lecturer/assignsubject/group_no');?>/'+cid;
}
    
</script>
<legend><h3><?=$title?></h3></legend>
    <form name="form1" id="form1" action="" method="post">
    	<table class="breadcrumb border" width="100%" align="center">
    		<tr>
    			<td width="240" align="right"></td>
    			<td width="10" align="center"></td>
    			<td width="368" height="35" align="left" style="font-size: 16px;font-weight: bold;"></td>
			</tr>
			<tr>
				<td align="right">Nama Pensyarah</td>
				<td align="center">:</td>
				<td height="35"><input type="text" value="" name="lecturer" id="lecturer" />
				<input id="lecturer_name" name="lecturer_name" type="hidden" />
				</td>
			</tr>
			<tr>
				<td height="35"><div align="right">Kursus</div></td>
				<td height="35"><div align="center">:</div></td>
				<td height="35"><div align="left">
					<select id="course" name="course" class="validate[required]" onchange="show()">
					<option value="">-- Sila Pilih --</option>
					<?php
							foreach($course as $row)
							{
            					echo "<option value='".$row->cou_id."'>";
								echo $row->cou_course_code."-".$row->cou_name;
								echo "</option>";
            				}
            		?>
            		</select>
        		</td>
        	</tr>
        	<tr>
        		<td height="35"><div align="right">Semester</div></td>
        		<td height="35"><div align="center">:</div></td>
        		<td height="35">
        			<div align="left">
        				<select class="validate[required]"  onchange="show()" name="semester" id="semester" >
		        		<option value="">-- Sila Pilih --</option>
		        		<option value="1">1</option>
		        		<option value="2">2</option>
		        		<option value="3">3</option>
		        		<option value="4">4</option>
		        		<option value="5">5</option>
		        		<option value="6">6</option>
		        		<option value="7">7</option>
		        		<option value="8">8</option>
		        		</select>
	        		</div>
	        	</td>
    		</tr>
    		<tr>
    			<td height="35"><div align="right">Modul</div></td>
    			<td height="35"><div align="center">:</div></td>
    			<td height="35"><div align="left">
        			<select id="subject" name="subject" class="validate[required]" >
            			<option value="">-- Sila Pilih --</option>
            		</select>
        		</td>
    		</tr>
    		<tr>
    			<td><input name="redirect" type="hidden" value="<?= $this->uri->uri_string() ?>" /></td>
    			<td>&nbsp;</td>
            	<td>
            		<input class="btn btn-info" type="button" id="btn_carian" name="btn_carian" value="Cari">
            		<input class="btn" type="reset" name="btn_reset" value="Reset">
            	</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
            	<td>&nbsp;</td>
            	<td>&nbsp;</td>
            </tr>       
      </table>        
	</form>
	
	<table id="subject_lecturer" style="margin-bottom:0px;" 
        		class="table table-striped table-bordered table-condensed">
	    <thead>
	        <tr>
	            <th width="80" id="tdleft" align="center">Bil</th>
	            <th width="400" align="tdright">Nama Pensyarah</th>
				<th width="195" id="tdright" align="center">Modul</th>
	            <th width="195" id="tdright" align="center">Kursus</th>
	            <th width="195" id="tdright" align="center">Sesi</th>
	            <th width="195" id="tdright" align="center">Semester</th>
	            <th width="195" id="tdright" align="center">Kelas</th>
	        </tr>
	    </thead>
	    <tbody>
	    </tbody>
	</table>
