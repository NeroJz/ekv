<script type="text/javascript" src="<?= base_url();?>/assets/js/dataTables.fnFakeRowspan.js"></script>
<style>

#fin_ajax_length {

text-align :left;

}

#fin_ajax_info{

text-align :left;

}

#tdbil {

width: 5px;

}

</style>
<script>

function fnRowSpan2(column, ignorePre)
{

   //alert(column);
   var currentCell2;
   var rowSpan = 1;
   var prevCell;
   
   
   column.each(function()
   {
       
       if(typeof currentCell2 == "undefined")
       {
           currentCell2 = $(this);
       }
       
       else 
       { 
       		
           if(!ignorePre)
           {
           //	alert(currentCell2.text()+"="+$(this).text());
           		if(currentCell2.text()==$(this).text() && 
	           	currentCell2.prev().html()==$(this).prev().html())
	           {
	           	
	           
	            // console.log("try");
	           	//alert(currentCell2.text()+$(this).text());
	            
	               $(this).hide();
	               rowSpan++;
	           }
	           
	           else
	           {
	               currentCell2 = $(this);
	               rowSpan=1;
	           }
           	 currentCell2.attr('title',rowSpan);
           }
           
           else
           {
           		if(currentCell2.text()==$(this).text())
	           {
	               $(this).hide();
	               
	               rowSpan++;
	           }
	           else
	           {
	               currentCell2 = $(this);
	               rowSpan=1;
	           }
	             
           }
           
           currentCell2.attr('rowSpan',rowSpan);
         
          
       }
       
       
     	//console.log(rowSpan);   
   });
}



$(document).ready(function(){

	fnRowSpan2($("#fin_ajax tbody tr > :nth-child(2)"), true);
	//fnRowSpan2($("#fin_ajax tbody tr > :nth-child(2)"), true);
	oTable = $("#fin_ajax").dataTable({
		"aoColumnDefs" : [{bSortable : false,aTargets : [0,2]}],
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

	
	fnRowSpan2($("#fin_ajax tbody tr > :nth-child(2)"), true);
	//$('#fin_ajax').dataTable().fnFakeRowspan(1);
	
	if($("#fin_ajax").length > 0){ 
		new FixedHeader( oTable, 
		{
		       "offsetTop": 40
		});
	}

	

	 $('#btn_reset').click(function() 
	 {
		 
		 $('#select-to option:selected').remove();
		
	 });
	
	$('#btn_daftar').attr('disabled','disabled');
	
	$('#pemeriksa').click(function()
	{
		
		$('#btn_daftar').removeAttr("disabled");
	
	});
	
	$('#btn-add').click(function()
	{
	    $('#kv option:selected').each( function() {
	            $('#select-to').append("<option value='"+$(this).val()+"'>"+$(this).text()+"</option>");
	            $('#select-to').find('option').attr('selected','selected');
	        $(this).remove();
	    });
	});

	
	$('#btn-remove').click(function()
	{
	    $('#select-to option:selected').each( function() {
	        $('#kv').append("<option value='"+$(this).val()+"'>"+$(this).text()+"</option>");
	        $(this).remove();
	    });
	});

	
	$("#btn_daftar").on("click",function()
	{
		 $.blockUI({ 
			 message: '<h5><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h5>', 
			 css: { border: '3px solid #660a30' }
			       });

			setTimeout(function()
			{
				var pemeriksa = $("#pemeriksa").val();
				var kolej = $("#select-to").val();
			
				 $.ajax({
			     url: site_url+'/examiner/reg_examiner/assign_kv/',
			     type:'POST',
			     data: {
						
						pemeriksa : pemeriksa,
						kolej : kolej,
			   	   },
			     success: function(data)
			     {		
			    	// fnRowSpan2($("#fin_ajax tbody tr > :nth-child(2)"), true);  
			    	 	$.unblockUI();
			    	 	var mssg = new Array();
						mssg['heading'] = 'Informasi';
						mssg['content'] = 'Pemeriksa telah berjaya di tetapkan';
						kv_alert(mssg);
		
						$('#frm_pusat')[0].reset();
						$('#select-to option:selected').remove();
						$('#btn_daftar').attr('disabled','disabled');
						//fnRowSpan2($("#fin_ajax tbody tr > :nth-child(2)"), true);
						refresh_table();
						//fnRowSpan2($("#fin_ajax tbody tr > :nth-child(2)"), true);
						
					}
				
			});
					
		},1500);

});
					
	
	//fnRowSpan2($("#fin_ajax tbody tr > :nth-child(3)"), false);

	$("#pemeriksa" ).autocomplete({
	   	source: [ 

	 <?php foreach ($pemeriksa as $pem) { ?>
	 
	{value: "<?=$pem->user_name;?>",
		id: "<?=$pem->user_id;?>"},

	 <?php } ?>
	],

	select: function(event, ui) {
	$("#pemeriksa1").val(ui.item.id);
	   }
	 });


});

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
   			url: '<?=site_url('examiner/reg_examiner/get_detail_examiner')?>',
   			dataType: 'json',
   			data: {
					
	   			},
	   			
	   			success: function(data) 
				{

					//console.log(data);
					var row_data = "";

					$(data.details_pemeriksa).each(function(index)
					{

						var exam_id = data.details_pemeriksa[index].exam_id;
						var user_name = data.details_pemeriksa[index].user_name;
						var col_name = data.details_pemeriksa[index].col_name;
						
						row_data +=

							
							'<tr><td width="10" align="center">'+(index+1)+'</td>'+
							'<td width="300"><input type="hidden" id="exam_id" name="exam_id[]" value="'+exam_id+'"> '+data.details_pemeriksa[index].user_name+' </td>'+
							'<td width="300"><input type="hidden" id="exam_id" name="exam_id[]" value="'+exam_id+'"> '+data.details_pemeriksa[index].col_name+' </td>'+
							'</tr>';
						
					});	

					//we need to 'clear' the datatable object coz we are going to re-create 
					var ex = document.getElementById('fin_ajax');
					if ( $.fn.DataTable.fnIsDataTable( ex ) ) {
					oTable.fnClearTable();
					}

				    	
					
					
						$('#fin_ajax > tbody').html("");
						$('#fin_ajax > tbody').html(row_data);
						//$(".btn_save").hide();
						
						
						
						oTable = $("#fin_ajax").dataTable({
							"aoColumnDefs" : [{bSortable : false,aTargets : [0,2]}],
							"bPaginate" : true,
							"iDisplayLength" : 10,
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

						fnRowSpan2($("#fin_ajax tbody tr > :nth-child(2)"), true);
					    //fnRowSpan2($("#fin_ajax tbody tr > :nth-child(3)"), true);
						
						if($("#fin_ajax").length > 0){ 
							new FixedHeader( oTable, 
							{
							       "offsetTop": 40
							});
						}

						
				}

			});
	
}


</script>

<legend><h3>Penetapan Pemeriksa</h3></legend>
<form name="frm_pusat" id="frm_pusat" method="post" class="form-inline">
<table id = "table_group" class="breadcrumb border" width="100%" align="center">
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
    <tr>
    	<td width="35%" height="35"><div align="right">Pemeriksa</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35">
            <div align="left">
           
            	<input id="pemeriksa" name="pemeriksa" style="width:205px;" type="text">	
            	 <input id="pemeriksa1" name="pemeriksa1"  type="hidden">	
            </div>        
        </td>
    </tr>	
      <tr>
            <td width="30%" align="right" >Kolej</td>
             <td width="3%" height="35"><div align="center">:</div></td>
                   <td width="70%" height="35">
                   	<table>
                   	<tr colspan = 3>
                   		</tr>
                   		<tr>
                   			<td>
                    <select name="kv" id="kv" multiple size="5">
                   <?php
					foreach ( $kv as $row ) {
						echo "<option id='kv' value='" . $row->col_id . "'>".$row->col_code." - ". ucwords( strtolower ( $row->col_name )) . "</option>";
							}
						?>
                    </select>
                    </td>
                    <td><center><a href="JavaScript:void(0);" id="btn-add">Tambah &raquo;</a><br/>
    				<a href="JavaScript:void(0);" id="btn-remove">&laquo; Buang</a></center></td>
            		<td> 
            		<select name="selectto[]" id="select-to" class="validate[required]"  multiple size="5"></select>
    				</td>
       </tr>
                    </table>
            </td>    
        </tr>
   
    <tr>
    	<td></td>
    	<td height="35"><div align="right"></div></td>
        <td height="35">
        	<div align="left">
        	</br>
          		<input class="btn btn-info" type="button" id="btn_daftar" name="btn_daftar" value="Daftar">
          		<input class="btn" type="reset" name="btn_reset" id="btn_reset" value="Reset">
        	</div>
        </td>
    </tr>
    
    <tr><td>
    &nbsp;&nbsp;</td>
    </tr>
   
</table>
</form>


<center>
<form id="frm_table_class">
 <table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#E5E5E5" class="display dataTable" id="fin_ajax" style="display: table; margin-left: 0px; width: 100%;">
   <thead>  	
         <th width="10" id="tdleft" align="center"><b>BIL</b></th>
         <th width="195" id="tdright" align="center"><b>PEMERIKSA</b></th>
         <th width="300" align="center"><b>KOLEJ</b></th>
  </thead>
<tbody>
<?php 

if(isset ($details_pemeriksa))
	
	{
	?>
        <?php 
        $i=1;
        foreach($details_pemeriksa as $det)
        {
        ?>
        
        <tr>
      		<td width="10" align="center">
        		<?= $i ?>
        	</td>
        		       		        	        	
        	<td width="300">
	        		<input type="hidden" name="exam_id[]" id="exam_id" value="<?= $det->exam_id ?>"/>
	        		<?= strcap($det->user_name);?>
        		</td>
        		
        	<td width="100">
	        		<input type="hidden" name="exam_id[]" id="exam_id" value="<?= $det->exam_id ?>"/>
	        		<?= $det->col_name?>
        		</td>      
        		
        	
        	</tr>
         	
       <?php 
        $i++;
        }
}
else 
{	
	
}
?>

</tbody>
</table>
</form>
</center>



