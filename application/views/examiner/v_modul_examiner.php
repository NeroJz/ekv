<script language="javascript" type="text/javascript">


$(document).ready(function()
{

	$('#course').attr('disabled','disabled');
	
	$( "#kolej" ).autocomplete({
	   	source: [ 
	 <?php foreach ($kolej_list as $col) { ?>
	 
	{value: "<?=$col->col_name;?>-<?=$col->col_type;?><?=$col->col_code;?>",
	id: "<?=$col->col_id;?>"},

	 <?php } ?>
	],

	select: function(event, ui) {
	$("#kolej_id").val(ui.item.id);

	$('#course').removeAttr('disabled');
	var kolej = $("#kolej_id").val();
	

	//alert(kolej);
	 $.ajax({
     url: '<?=site_url('examiner/modul_examiner/course_list')?>',						     
     type:'POST',
     dataType: "json",
     data: {kolej1 : kolej},
     
     success: function(data)
     {			     
    	 	//console.log(data);		    	 	
    	 document.form1.course.options.length=0;
            $('#course').html("");
            document.form1.course.options[0] = new Option('-- Sila Pilih --','',false,false);
            if(data.course_list.length>0)
            {
                for(var i = 0; i < data.course_list.length; i++)
                {
                    document.form1.course.options[i+1] = new Option(data.course_list[i].cou_course_code+' - '+data.course_list[i].cou_name,data.course_list[i].cc_id,false,false);
                } // End of success function of ajax form
            }
				
	 }
	
});
	
	   }
	   });
	

	
	$("#form_modul").on("change",".gred",function()
	{
		//alert('lalala');
	//$( ".gred" ).change(function() {
			
			var gred = $(this).val();
			//var stu_id = $(this).val();
		 	//var stu_id = $('#stu_id_'+stu_id+'').val();
			///alert(gred);
			//var gred_type = $(this).find('option:selected').text();
			var stu_id = $(this).parent().parent().find("#stu_id").val();
	   		//alert(stu_id);
			 $.ajax({
		     url: '<?=site_url('examiner/modul_examiner/save_gred')?>',
		     type:'POST',
		     dataType: "html",
		     data: {grade_id : gred,
			     	stu_id1 : stu_id},
		     
		     success: function(data)
		     {		
			     	//console.log(data);	     
		    	 	var mssg = new Array();
					mssg['heading'] = 'Informasi';
					mssg['content'] = 'Gred telah berjaya di masukkan';
					kv_alert(mssg);
					
				}
			
		});
	
			
	});//end of get group function
	
	/*$("#form_modul").on("click",".btn_save",function()
	 {		 
			var grade_id = document.getElementById("gred").value;
			
		 	$.ajax({
	   			url: '<?=site_url('examiner/modul_examiner/save_gred')?>',
	   			type: 'POST',
	   			dataType: "json",
	   			dataType: 'html',	
	   			data: {
					
						grade_id : grade_id,
						
		   			  },
		   			
				success: function(data) 
					{												
						 	var mssg = new Array();
							mssg['heading'] = 'Informasi';
							mssg['content'] = 'Gred telah berjaya di masukkan';
							kv_alert(mssg);
						

					}

		   		 
		 	});
		 });*/

	 $("#course").change(function()
				{
							 
					var course = $("#course").val();
					//alert(course);
					 $.ajax({
				     url: '<?=site_url('examiner/modul_examiner/modul_list')?>',						     
				     type:'POST',
				     dataType: "json",
				     data: {course1 : course},
				     
				     success: function(data)
				     {			     
				    	 	//console.log(data);		    	 	
				    	 document.form1.modul.options.length=0;
				            $('#modul').html("");
				            document.form1.modul.options[0] = new Option('-- Sila Pilih --','',false,false);
				            if(data.modul != null)
				            {
				                for(var i = 0; i < data.modul.length; i++)
				                {
				                    document.form1.modul.options[i+1] = new Option(data.modul[i].mod_paper+' - '+data.modul[i].mod_name,data.modul[i].cm_id,false,false);
				                } // End of success function of ajax form
				            }
								
					 }
					
				});
						
			
		});
			

	 
	 /*$("#kolej").focusout(function()
		{
					 
			var kolej = $("#kolej_id").val();
			

			alert(kolej);
			 $.ajax({
		     url: '<?=site_url('examiner/modul_examiner/course_list')?>',						     
		     type:'POST',
		     dataType: "json",
		     data: {kolej1 : kolej},
		     
		     success: function(data)
		     {			     
		    	 	//console.log(data);		    	 	
		    	 document.form1.course.options.length=0;
		            $('#course').html("");
		            document.form1.course.options[0] = new Option('-- Sila Pilih --','',false,false);
		            if(data.course_list.length>0)
		            {
		                for(var i = 0; i < data.course_list.length; i++)
		                {
		                    document.form1.course.options[i+1] = new Option(data.course_list[i].cou_course_code+' - '+data.course_list[i].cou_name,data.course_list[i].cc_id,false,false);
		                } // End of success function of ajax form
		            }
						
			 }
			
		});
				
	
});*/
	
		

	
	$('#form1').on('click','#btn_cari',function()
	{
			var kolej = $("#kolej_id").val();
			var course = $("#course").val();
			var modul = $("#modul").val();

			alert(kolej);
			alert(course);
			alert(modul);
			
			 $.ajax({
		     url: '<?=site_url('examiner/modul_examiner/student_data')?>',						     
		     type:'POST',
		     dataType: "json",
		     data: {
					
					kolej1 : kolej,
					course1 : course,
					modul1 : modul,
		   	   },
		     success: function(data)
		     {
				
		    	 	$('#checkModul > thead').html("");
					$('#checkModul > tbody').html("");
					$('#form_modul').show();
					populateData(data);
		    			
			  }
			
		});
							

});


});


//this function is to populate data

function populateData(data)
{
	//we need to 'clear' the datatable object coz we are going to re-create 
	var ex = document.getElementById('checkModul');
	if ( $.fn.DataTable.fnIsDataTable( ex ) ) {
		oTable.fnClearTable();
	}

	var row_head = 
		'<tr>'+
	    '<th width="5%">Bil</th>'+
	    '<th width="50%">My Kad</th>'+
	    '<th width="35%">No Matrik</th>'+
	    '<th width="10%">Gred'+
		'</th>'+           
		'</tr>';

		$('#checkModul > thead').html(row_head);

			var row_body = "";
			
			
			$(data.student_data).each(function(index)
			{
					var stu_id = data.student_data[index].stu_id;
					var stu_matric = data.student_data[index].stu_matric_no;
					var stu_mykad = data.student_data[index].stu_mykad;    	
											    					
					row_body +=
						'<tr><td width="30">'+(index+1)+'</td>'+		       	
		        		'<td width="200"><input type="hidden" name="stu_id" id="stu_id" value="'+stu_id+'">'+stu_mykad+'</td>'+
			        	'<td width="80">'+stu_matric+'</td>'+               		        		
		        		'<td width="100" align="center">'+
			        		'<select  width="150" id="gred" name="gred" class="gred">'+        			
				        		'<option value="">-- Sila Pilih --</option>'+
				        		'<option value="11">A</option>'+
				        		'<option value="10">A-</option>'+
				        		'<option value="9">B+</option>'+
				        		'<option value="8">B</option>'+
				        		'<option value="7">B-</option>'+
				        		'<option value="6">C+</option>'+
				        		'<option value="5">C</option>'+
				        		'<option value="4">D+</option>'+
				        		'<option value="3">D</option>'+
				        		'<option value="2">D-</option>'+
				        		'<option value="1">E</option>'+
				        		'<option value="23">T</option>'+	        			
		        			'</select>'+
		        		'</td>'+   	      		
		        	'</tr>';		    						    						    					
				
			});
			
			$('#checkModul > tbody').html(row_body);
		

		oTable = $("#checkModul").dataTable({
			"aoColumnDefs" : [{bSortable : false, aTargets : [0,3]}],
			"bPaginate" : true,
			"iDisplayLength" : 10,
			"sPaginationType" : "full_numbers",
			"bFilter" : true,
			"bInfo" : true,
			"bDestroy" : true,
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
		
		if($('#checkModul').length > 0){
			new FixedHeader( oTable, {
		        "offsetTop": 40
		    });
		}
	
	
}

	 
</script>


<legend><h3>Semak Modul</h3></legend>
    <form name="form1" id="form1" action="" method="post">
    	<table class="breadcrumb border" width="100%" align="center">
    		<tr>
    			<td width="240" align="right"></td>
    			<td width="10" align="center"></td>
    			<td width="368" height="35" align="left" style="font-size: 16px;font-weight: bold;"></td>
			</tr>
			<tr>
				<td height="35"><div align="right">Kolej</div></td>
				<td height="35"><div align="center">:</div></td>
				<td height="35"><div align="left">
					<div align="left">
						<input type="hidden" id="kolej_id" name="kolej_id" style="width:205px;" type="text">
   						<input id="kolej" name="kolej" style="width:205px;" type="text">	
     				</div>
        		</td>
        	</tr>
			
			<tr>
				<td height="35"><div align="right">Kursus</div></td>
				<td height="35"><div align="center">:</div></td>
				<td height="35"><div align="left">
					<select id="course" name="course" class="validate[required]">
					<option value="">-- Sila Pilih --</option>
					
            		</select>
        		</td>
        	</tr>
        	
    		<tr>
    			<td height="35"><div align="right">Modul</div></td>
    			<td height="35"><div align="center">:</div></td>
    			<td height="35"><div align="left">
        			<select id="modul" name="modul" class="validate[required]" >
            			<option value="">-- Sila Pilih --</option>
            			
            		</select>
        		</td>
    		</tr>
    		<tr>
    			<td><input name="redirect" type="hidden" value="<?= $this->uri->uri_string() ?>" /></td>
    			<td>&nbsp;</td>
            	<td>
            		<input class="btn btn-info" type="button" id="btn_cari" name="button" value="Cari">
            		<input id="btn_reset" class="btn" type="reset" name="btn_reset" value="Reset">
            	</td>
            </tr>
            <tr>
            	<td>&nbsp;</td>
            	<td>&nbsp;</td>
            	<td>&nbsp;</td>
            </tr>       
      </table>        
	</form>
	<div id="loading_process"></div>
<div id="form_modul">
	<form id="form_modul" name="form_modul" class="form-inline">
		<table id="checkModul" cellpadding="0" cellspacing="0" border="0" 
			class="display table table-striped table-bordered" style="width: 100% !important; margin-bottom: -1px;" >
			<thead>
			</thead>
			<tbody>
			</tbody>
		</table>
	</form>
</div>
	