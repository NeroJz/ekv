<style>

#fin_ajax_length {

text-align :left;

}

#fin_ajax_info{

text-align :left;

}

</style>


<script>

var class_name1 = '';

/////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////first load document ready////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
$(document).ready(function()
{

	$("#frm_pusat").validationEngine();
	$(".btn_save").hide();
	$("#frm_pusat").validationEngine();

	initiate_jquery();
	
	oTable = $("#fin_ajax").dataTable({
		"aoColumnDefs" : [{bSortable : false, aTargets : [0,1,4]}],
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

	/*if($("#collapseOne").length > 0){ 
		new FixedHeader( oTable, 
		{
		       "offsetTop": 40
		});
	}*/
	
	$( window ).scroll(function() {
		
		new FixedHeader( oTable, 
				{
				       "offsetTop": 40
				});
		});

		
	//bila accordion report buka balik selepas ditutup dia akan panggil balik function fixedheader
	$('#collapseOne').on('shown', function () {	
		$("body").children(".fixedHeader").each(function (index) {
            $(this).remove();
        });
	})

	//bagi mengelakkan fixedheader tu tergantung walaupun accordion dah ditutup, remove dia (tapi ni remove semua ye),
	//kalau ada lebih dari satu, kena pakai index
	$('#collapseOne').on('hide', function () {
		$("body").children(".fixedHeader").each(function (index) {
            $(this).remove();
        });
   	})
	


//keyup nama kelas
$( "#class_name" ).keyup(function() {
	 $(this).val($(this).val().toUpperCase());
});
		
		


/////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////click button tambah kelas////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
$("#btn_class").bind("click",function()
{

	var course_id=$("#course_id").val();
	var semester=$("#semester").val();
	//var year=$("#year").val();
	var class_name=$("#class_name").val();

	var validate = $('#frm_pusat').validationEngine('validate');
	
		 if(validate)
		 {
			
		    $.ajax({
		   	url: '<?=site_url('class/divide_student/insert_class')?>',
		   	type: 'POST', 
		   	data: {
						course_id : course_id,
						semester : semester,
						class_name : class_name,
			   	   },
			   			
			success: function(data) 
				{

					if(data != 1)
					{
						var mssg = new Array();
						mssg['heading'] = 'Informasi';
						mssg['content'] = 'Kelas telah berjaya di tambah';
						kv_alert(mssg);

						//$(".frm_pusat").reset();
						//document.getElementById("frm_pusat").reset();
						$('#frm_pusat')[0].reset();
						refresh_table();
						//initiate_jquery();
					}
					else
					{
						var mssg = new Array();
						mssg['heading'] = 'Informasi';
						mssg['content'] = 'Nama kelas telah ada dalam rekod';
						kv_alert(mssg);

						refresh_table();
						//initiate_jquery();
					}
				}//end of success function
		    
		 	});//end of ajax
		 }
		 
	  });//end of click function

});//end of document ready



/**********************************************************************************************
* Description		: this function to initiate jQuery
* input				: 
* author			: siti umairah
* Date				: 13 november 2013
* Modification Log	: 14 november 2013 - siti umairah - hide button edit when click
**********************************************************************************************/
function initiate_jquery()
{	

	 /////////////////////////////////////////////////////////////////////////////////////////////////
	 ////////////////////////////////click button save after edit/////////////////////////////////////
	 /////////////////////////////////////////////////////////////////////////////////////////////////
	 $("#frm_table_class").on("click",".btn_save",function()
	  {
		// alert($(this).attr('id'));
		 if($(this).attr('disabled'))
		 {
			// alert();
		 	return false;
		 }
		 else
		 {
		 	var class_id = $(this).attr('value');
		 	var class_name = $('#class_name_'+class_id+'').val();
		 	var cou_id= $('#cou_id_'+class_id+'').val();
		 	var sem = $('#sem_'+class_id+'').html();
		 	//console.log(class_id);
		 	//console.log(class_name);
		 	//console.log(cou_id);
		 	//console.log(sem);
			//console.log();
		 	$('#class_name_'+class_id+'').attr("readonly","readonly");
			$(this).attr('disabled','disabled');

		 	$.ajax({
	   			url: '<?=site_url('class/divide_student/edit_class')?>',
	   			type: 'POST',
	   			dataType: 'html',	
	   			data: {
						class_id : class_id,
						class_name : class_name,
						cou_id : cou_id,
						sem : sem,
						
		   			  },
		   			
				success: function(data) 
					{
						if(data != 1)
						{							
						 	var mssg = new Array();
							mssg['heading'] = 'Informasi';
							mssg['content'] = 'Nama Kelas telah berjaya di ubah';
							kv_alert(mssg);

							$('#class_name_'+class_id+'').css("borderColor","");
							$('#class_name_'+class_id+'').attr("readonly","readonly");
							//$(".btn_save").hide();
							$('#btn_edit_'+class_id+'').show();
							$('#btn_edit_'+class_id+'').parent().find(".btn_save").hide();
							//alert($('#btn_edit_'+class_id+'').parent().attr("class"));
							
							
					
						}
						else
						{

							var mssg = new Array();
							mssg['heading'] = 'Informasi';
							mssg['content'] = 'Nama kelas telah ada dalam rekod';
							kv_alert(mssg);

							$('#class_name_'+class_id+'').css("borderColor","");
							$('#class_name_'+class_id+'').val(class_name1);							
							//$(".btn_save").hide();
							$('#btn_edit_'+class_id+'').show();
							$('#btn_edit_'+class_id+'').parent().find(".btn_save").hide();
							
						}

						

					}//end of success function

		   		 
		 	});//en of ajax function
		 }
	 });//end of button save edit

	
	 /////////////////////////////////////////////////////////////////////////////////////////////////
	 ////////////////////////////////click button delete to delete class//////////////////////////////
	 /////////////////////////////////////////////////////////////////////////////////////////////////
	 $("#frm_table_class").on("click",".btn_padam",function(e){

		 

			var class_id = $(this).attr('value');			
			var opts = new Array();
			
			opts['heading'] = 'Padam Kelas';
			opts['question'] = 'Anda Pasti Untuk Memadam Kelas?';
			opts['hidecallback'] = true;
			opts['callback'] = function()
			{
				
				 var request = $.ajax({
					 
						url: '<?=site_url('class/divide_student/delete_kelas')?>',
						type: "POST",						
						dataType: "html",
						data: {	class_id : class_id},

						success: function(data) 
						{
							//alert(data);
							if(data == 0)
							{								
							 	var mssg = new Array();
								mssg['heading'] = 'Informasi';
								mssg['content'] = 'Kelas tidak berjaya di padam kerana terdapat murid';
								kv_alert(mssg);
							}
							else
							{

								var mssg = new Array();
								mssg['heading'] = 'Informasi';
								mssg['content'] = 'Kelas berjaya di padam';
								kv_alert(mssg);

								refresh_table();
							}

						}//end of success function
						
						
						
					});//end of ajax function
		
			}//end of modal function comfirm delete
			
			e.stopImmediatePropagation();
			opts['cancelCallback'] = function(){/*do nothing*/};
			kv_confirm(opts);
			
	 });//end of delete class name

	
	 /////////////////////////////////////////////////////////////////////////////////////////////////
	 ////////////////////////////////detect on change class name for button save edit/////////////////
	 /////////////////////////////////////////////////////////////////////////////////////////////////
	 $("#frm_table_class").on("keypress",".class_name",function(){
		 
		$(this).parent().parent().find("td:eq(4)").find(".btn_save").removeAttr('disabled');
		//$(".btn_save").show();		
	
	 });


	
	
	 /////////////////////////////////////////////////////////////////////////////////////////////////
	 ////////////////////////////////click button edit////////////////////////////////////////
	 /////////////////////////////////////////////////////////////////////////////////////////////////
	 $("#frm_table_class").on("click",".btn_edit",function()
	   {

		 var class_id = $(this).attr('value');
		 var class_name = $('#class_name_'+class_id+'').val();

		 $('#class_name_'+class_id+'').css("borderColor","red");
		 $('#class_name_'+class_id+'').removeAttr("readonly");
		 $('#btn_save_'+class_id+'').show();
		 class_name1 = $('#class_name_'+class_id+'').val();
		 $('#btn_edit_'+class_id+'').hide();
		 

	   });
}



/**************************************************************************************************
* Description 		: this function will change string to title case
* input				: str 
* author			: Freddy Ajang Tony
* Date				: 18/10/2013
* Modification Log	:  -
**************************************************************************************************/
function toTitleCase(str)
{
    return str.replace(/\w\S*/g, function(txt){
    	return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    	});
}



/**********************************************************************************************
* Description		: this function to refresh table data
* input				: 
* author			: siti umairah
* Date				: 14 november 2013
* Modification Log	: -
**********************************************************************************************/
function refresh_table()
{		

		$('#fin_ajax > tbody').html('<center><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sila tunggu...</center>');
			

		 $.ajax({
   			url: '<?=site_url('class/divide_student/get_class')?>',
   			dataType: 'json',
   			data: {
					
	   			},
	   			
	   			success: function(data) 
				{

					//console.log(data);
					var row_data = "";

					$(data.class_data).each(function(index)
					{

						var class_id = data.class_data[index].class_id;
						var class_name = data.class_data[index].class_name;
						var cou_id = data.class_data[index].cou_id;

						
						row_data +=
							'<tr><td width="30" align="center">'+(index+1)+'</td>'+
							'<td width="300" align="center"><input class="class_name" readonly="readonly" type="text" id="class_name_'+class_id+'" value="'+class_name.toUpperCase()+'" </td>'+
							'<td width="300" align="center"><input type="hidden" name="cou_id_'+class_id+'" id="cou_id_'+class_id+'" value="'+cou_id+'">'+data.class_data[index].cou_name+'</td>'+
							'<td width="300" align="center"><span id="sem_'+class_id+'">'+data.class_data[index].class_sem+'</td>'+
							'<td width="300" align="center">'+
							'<center>'+
							'<a class="btn btn_edit btn-info" name="btn_edit" id="btn_edit_'+class_id+'" type="button" value="'+class_id+'"> <i class="icon-edit icon-white"></i>&nbsp;Kemas Kini</a> '+
							'<a class="btn btn_save btn-success" name="btn_save" id="btn_save_'+class_id+'" type="button" value="'+class_id+'" disabled="disabled"><i class="icon-ok icon-white"></i>&nbsp;Simpan</a> '+
							'<a class="btn btn_padam" name="btn_padam" id="btn_padam" type="button" value="'+class_id+'"><i class="icon-trash"></i>&nbsp;Padam</a>'+
							'</center>'+
							'</td></tr>';
						
					});	

					//we need to 'clear' the datatable object coz we are going to re-create 
					var ex = document.getElementById('fin_ajax');
					if ( $.fn.DataTable.fnIsDataTable( ex ) ) {
					oTable.fnClearTable();
					}
						$('#fin_ajax > tbody').html("");
						$('#fin_ajax > tbody').html(row_data);
						$(".btn_save").hide();

						oTable = $("#fin_ajax").dataTable({
							"aoColumnDefs" : [{bSortable : false,aTargets : [0,1,4]}],
							"bPaginate" : true,
							"sPaginationType" : "full_numbers",
							"bFilter" : true,
							"bInfo" : true,
							"bJQueryUI" : true,
							"bDestroy" : true,
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

						initiate_jquery();
				}

			});
	
}

</script>

<legend><h3>Pengurusan Kelas</h3></legend>

<div class="panel-group" id="accordion">
  <div class="panel panel">
    <div class="panel-heading">
      <h4 class="panel-title">
       <button  class="btn btn-info" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          Tambah Kelas 
       </button>     
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse">
      <div class="panel-body">
       
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
				<select name="course_id" id="course_id" class="validate[required]">
				<option value="">--Sila Pilih--</option>
				<?php
				foreach ($course_list as $course ) {
					
					echo "<option value='" . $course->cou_id . "'>".$course->cou_course_code." - ". ucwords( strtolower ( $course->cou_name )) . "</option>";
						}
					?>
                  </select>
                  </div>
                 </td>
	</tr>
    <tr>
		</br>
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
    <!--  <tr>
    	<td height="35"><div align="right">Tahun</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                 <select name="year" id="year" class="validate[required]">
                    <option value="">-- Sila Pilih --</option>
                    <?php
				/*foreach ( $year as $ses ) {
					echo "<option value='" . $ses->stu_current_year. "'>".$ses->stu_current_year."</option>";
						}*/
					?>
                </select>
            </div>
        </td>
    </tr>-->
    <tr>
		<td height="35" width="40%"><div align="right">Nama Kelas</div></td>
   	 	<td height="35"><div align="center">:</div></td>
    	<td height="35">
    		<div align="left">
   				<input id="class_name" name="class_name" style="width:205px;" type="text" class="validate[required]">	
     		</div>
     	</td>
    </tr>     
    <tr>
    	<td></td>
    	<td height="35"><div align="right"></div></td>
        <td height="35">
        	<div align="left">
        	</br>
          		<input class="btn btn-info" type="button" id="btn_class" name="btn_class" value="Tambah Kelas" class="validate[required]">
        		<input class="btn" type="reset" name="btn_reset" value="Set Semula">
        	</div>
        </td>
    </tr>
    <tr><td>
    &nbsp;&nbsp;</td>
    </tr>   
 </table>   
 </form>
       
      </div>
    </div>
  </div>
</div>


<center>
 <form id="frm_table_class">
 <table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#E5E5E5" class="display dataTable" id="fin_ajax" style="display: table; margin-left: 0px; width: 100%;">
   <thead>  	
         <th><b>BIL</b></th>
         <th><b>NAMA KELAS</b></th>
         <th><b>KURSUS</b></th>
         <th><b>SEMESTER</b></th>
         <th><b>TINDAKAN</b></th>   
  </thead>
<tbody>
<?php 
if(isset ($class_data))
	
	{
	?>
        <?php 
        
        $i=1;
        foreach($class_data as $cls)
        {
        ?>
        
        <tr>
      		<td width="30" align="center">
        		<?= $i ?>
        	</td>
        		       		
        	<td width="300">
        		<input class="class_name" readonly="readonly" type="text" id="class_name_<?= $cls->class_id ?>" value="<?= strtoupper($cls->class_name) ?>">
        	</td>
        	
        	<td width="300">       		
        		<input type="hidden" name="cou_id_<?= $cls->class_id ?>" id="cou_id_<?= $cls->class_id ?>" value="<?= $cls->cou_id?>"/>
        		<?= strcap($cls->cou_name);?>
        	</td>        	
        	
        	<td width="300" align="center">
        		<span id="sem_<?= $cls->class_id ?>"><?= $cls->class_sem ?></span>
        	</td>
        		
        	<td width="300" align="center">
        		<center>
				<a name="btn_edit" id="btn_edit_<?= $cls->class_id ?>" class="btn btn_edit btn-info " type="button" value="<?= $cls->class_id ?>"><i class="icon-edit icon-white"></i>&nbsp;Kemas Kini</a>
				<a name="btn_save" id="btn_save_<?= $cls->class_id ?>" class="btn btn_save btn-success " type="button" disabled="disabled" value="<?= $cls->class_id ?>"><i class="icon-ok icon-white"></i>&nbsp;Simpan</a>
				<a name="btn_padam" id="btn_padam" class="btn btn_padam" type="button" value="<?= $cls->class_id ?>"><i class="icon-trash"></i>&nbsp;Padam</a>
			</center>
			
			</td>
        	</tr>
         	
       <?php 
        $i++;
        }
}
?>
</table>
</form>	
</tbody>
</center>