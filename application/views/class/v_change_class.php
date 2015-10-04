
<script language="javascript" type="text/javascript">

//first load
$(document).ready(function()
{
	$("#frm_pusat").validationEngine();
	
	$( ".group" ).change(function() {
		
		var stuGroup = $(this).val();
		
		var class_name = $(this).find('option:selected').text();
		
   		if(stuGroup != -1)
   		{
   			 $(this).parent().parent().find(".class_name").html(class_name);
			 $.ajax({
		     url: site_url+'/class/divide_student/changeclass/'+stuGroup,
		     type:'POST',
		     success: function(data)
		     {			     
		    	 	var mssg = new Array();
					mssg['heading'] = 'Informasi';
					mssg['content'] = 'Kelas telah berjaya di kemaskini';
					kv_alert(mssg);
					
				}
			 
			
	});

	}
});//end of get group function


	oTable = $("#fin_ajax").dataTable({
		"aoColumnDefs" : [{bSortable : false,aTargets : [0,5]}],
		"bPaginate" : true,
		"sPaginationType" : "full_numbers",
		"bFilter" : true,
		"bInfo" : true,
		"bJQueryUI" : true,
		"bPaginate": true,
		"aaSorting" : [[1, "asc"]],
		"oLanguage": {  "sSearch": "Carian :",
						"sLengthMenu": "Paparan _MENU_ senarai",
 						"sInfo": "Papar _START_-_END_ dari _TOTAL_ rekod",
						"sInfoEmpty": "Showing 0 to 0 of 0 records",
					    "oPaginate": {
					      "sFirst": "Pertama",
					      "sLast": "Akhir",
					      "sNext": "Seterus",
					      "sPrevious": "Sebelum"
					     }
					 },
		"fnDrawCallback" : function(oSettings) {
			if (oSettings.bSorted || oSettings.bFiltered) {
				for (var i = 0, iLen = oSettings.aiDisplay.length; i < iLen; i++) {
					$("td:eq(0)", oSettings.aoData[oSettings.aiDisplay[i]].nTr).html(i + 1);
				}
			}
		}
	});
		
	if($("#fin_ajax").length > 0){ 
		new FixedHeader( oTable, 
		{
		       "offsetTop": 40
		});
	}
	
});
</script>

<legend><h3>Penetapan dan Pertukaran Kelas Murid</h3></legend>
<form name="frm_pusat" id="frm_pusat" method="post" class="form-inline">
<table id = "table_group" class="breadcrumb border" width="100%" align="center">
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
    <tr>
		<td height="35" width="40%"><div align="right">Kursus</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
				<select width="130" name="course_id" id="course_id" class="validate[required]">
					<option value="">--Sila Pilih--</option>
					<?php
					foreach ( $course_list as $course ) {
						echo "<option value='" . $course->cou_id . "'>".$course->cou_course_code." - ". ucwords( strtolower ( $course->cou_name )) . "</option>";
							}
						?>
                </select>
           </div>
         </td>
	</tr>			
    <tr>
        <td height="35"><div align="right">Semester</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
	        	<select  name="semester" id="semester" class="validate[required]">
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
    	<td></td>
    	<td height="35"><div align="right"></div></td>
        <td height="35">
        	<div align="left">
        	</br>
          		<input class="btn btn-info" type="submit" id="button" name="submit" value="Cari">
        	</div>
        </td>
    </tr>
    
    <tr><td>
    &nbsp;&nbsp;</td>
    </tr>
   
</table>
</form>

<?php 
if(isset ($student_data))
{
?>
<table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#E5E5E5" class="display dataTable" id="fin_ajax" style="display: table; margin-left: 0px; width: 100%;">
    <thead>
          <tr>
              <th width="40" id="tdleft" align="center"><b>BIL</b></th>
              <th width="195" id="tdright" align="center"><b>NAMA MURID</b></th>
              <th width="300" align="center"><b>ANGKA GILIRAN</b></th>
               <th width="300" align="center"><b>SEMESTER</b></th>
              <th width="195" id="tdright" align="center"><b>KURSUS</b></th>
              <th width="150" id="tdright" align="center"><b>NAMA KELAS</b></th>
              <th width="195" id="tdright" align="center"><b>KELAS</b></th>
          </tr>
    </thead>
    <tbdody>
        <?php 
        
        $i=1;
        foreach($student_data as $stu)
        {
        ?>
        	<tr>
      			<td width="40">
        			<?= $i ?>
        		</td>
        		
        		<td width="300">
	        		<input type="hidden" name="stu_id[]" id="stu_id" value="<?= $stu->stu_id ?>"/>
	        		<?= strcap($stu->stu_name);?>
        		</td>
        		
        		<td width="100">
	        		<input type="hidden" name="stu_id[]" id="stu_id" value="<?= $stu->stu_id ?>"/>
	        		<?= $stu->stu_matric_no?>
        		</td>                
        		
        		<td width="100" align="center">
	        		<?= $stu->stu_current_sem?>
        		</td>   		
        		
        		<td>
        			<?= strcap($stu->cou_name);?>
        		</td>
        		
        		<td align="center" width="200" class="class_name">
        			<?= $stu->class_name?>
        		</td>
        	
        		<td align="right">
        			<select  width="150" id="group" name="group[]" class="group">
        			<option value="-1">--Sila Pilih--</option>
	        			<?php 
	        			
	        			foreach($max as $row)
	       				 {
	        				?>
	        			
	        			<option value='<?php echo $stu->stu_id."/".$row->class_id; ?>'> <?= $row->class_name ?></option>
	        			
	        			<?php }
	        			
	        			?>
        			</select>
        		</td>
        	</tr>
        	        	
       <?php 
       $i++;
    }
}
else 
{
?>	

	<div class="alert alert-block">
  		<button type="button" class="close" data-dismiss="alert">x</button>
  		<h4>Perhatian</h4>
  		Tiada data murid di paparkan
  	</div>
<?php  			
}
?>
      
</table>
</tbody>

