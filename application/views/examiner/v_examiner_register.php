<script>

$(document).ready(function()
{

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

/////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////click button tambah pemeriksa////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////
$("#btn_pemeriksa").bind("click",function()
{

		var pemeriksa=$("#pemeriksa").val();
		var myKad=$("#myKad").val();
		var lahir=$("#lahir").val();
		var jantina=$("#jantina").val();
		var bangsa=$("#bangsa").val();
		var agama=$("#agama").val();
		var alamat1=$("#alamat1").val();
		var alamat2=$("#alamat2").val();
		var alamat3=$("#alamat3").val();
		var poskod=$("#poskod").val();
		var bandar=$("#bandar").val();
		var warganegara=$("#warganegara").val();
		var username=$("#username").val();
		var katalaluan=$("#katalaluan").val();
		var email=$("#email").val();
		var status=$("#status").val();
		var notel=$("#notel").val();
		var negeri=$("#negeri").val();
		var jawatan=$("#jawatan").val();
		//var user_id=$("#pemeriksa").val();
		

		//alert(jawatan);
		//alert(user_id);
		
		$.ajax({
			url: '<?=site_url('examiner/reg_examiner/insert_examiner')?>',
			type: 'POST', 
			data: {
				
				pemeriksa : pemeriksa,
				myKad : myKad,
				lahir : lahir,
				jantina : jantina,
				bangsa : bangsa,
				agama : agama,
				alamat1 : alamat1,
				alamat2 : alamat2,
				alamat3 : alamat3,
				poskod : poskod,
				bandar : bandar,
				warganegara : warganegara,
				username : username,
				katalaluan : katalaluan,
				email : email,
				status : status,
				notel : notel,
				negeri : negeri,
				jawatan : jawatan
				
				
				
				
				  },
		
		success: function(data) 
		{
			
			var mssg = new Array();
			mssg['heading'] = 'Informasi';
			mssg['content'] = 'Pemeriksa telah berjaya di tambah';
			kv_alert(mssg);
			
			//$(".frm_pusat").reset();
			//document.getElementById("frm_pusat").reset();
			$('#frm_pusat')[0].reset();
			//refresh_table();
			//initiate_jquery();
	
		}//end of success function
			
			});//end of ajax
			
		
		});//end of click function

	
});
</script>


<legend><h3>Daftar Pemeriksa</h3></legend>

<div class="panel-group" id="accordion">
  <div class="panel panel">
    <div class="panel-heading">
      <h4 class="panel-title">
       <button  class="btn btn-info" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          Daftar Pemeriksa
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
		<td height="35" width="40%"><div align="right">Nama Pemeriksa</div></td>
   	 	<td height="35"><div align="center">:</div></td>
    	<td height="35">
    		<div align="left">
   				<input id="pemeriksa" name="pemeriksa" style="width:205px;" type="text">	
     		</div>
     	</td>
    </tr>  
    <tr>
		<td height="35" width="40%"><div align="right">No MyKad</div></td>
   	 	<td height="35"><div align="center">:</div></td>
    	<td height="35">
    		<div align="left">
   				<input id="myKad" name="myKad" style="width:205px;" type="text">	
     		</div>
     	</td>
    </tr>  
    <tr>
		<td height="35" width="40%"><div align="right">Tarikh Lahir</div></td>
   	 	<td height="35"><div align="center">:</div></td>
    	<td height="35">
    		<div align="left">
   				<input id="lahir" name="lahir" style="width:205px;" type="text">	
     		</div>
     	</td>
    </tr>  
    <tr>
		<td height="35" width="40%"><div align="right">Jantina</div></td>
   	 	<td height="35"><div align="center">:</div></td>
    	<td height="35">
    		<div align="left">
   				<input id="jantina" name="jantina" style="width:205px;" type="text">	
     		</div>
     	</td>
    </tr>
    <tr>
		<td height="35" width="40%"><div align="right">Bangsa</div></td>
   	 	<td height="35"><div align="center">:</div></td>
    	<td height="35">
    		<div align="left">
   				<input id="bangsa" name="bangsa" style="width:205px;" type="text">	
     		</div>
     	</td>
    </tr>  
    <tr>
		<td height="35" width="40%"><div align="right">Agama</div></td>
   	 	<td height="35"><div align="center">:</div></td>
    	<td height="35">
    		<div align="left">
   				<input id="agama" name="agama" style="width:205px;" type="text">	
     		</div>
     	</td>
    </tr>  
    <tr>
		<td height="35" width="40%"><div align="right">Alamat 1</div></td>
   	 	<td height="35"><div align="center">:</div></td>
    	<td height="35">
    		<div align="left">
   				<input id="alamat1" name="alamat1" style="width:205px;" type="text">	
     		</div>
     	</td>
    </tr>
    <tr>
		<td height="35" width="40%"><div align="right">Alamat 2</div></td>
   	 	<td height="35"><div align="center">:</div></td>
    	<td height="35">
    		<div align="left">
   				<input id="alamat2" name="alamat2" style="width:205px;" type="text">	
     		</div>
     	</td>
    </tr>  
    <tr>
		<td height="35" width="40%"><div align="right">Alamat 3</div></td>
   	 	<td height="35"><div align="center">:</div></td>
    	<td height="35">
    		<div align="left">
   				<input id="alamat3" name="alamat3" style="width:205px;" type="text">	
     		</div>
     	</td>
    </tr>
    <tr>
		<td height="35" width="40%"><div align="right">Poskod</div></td>
   	 	<td height="35"><div align="center">:</div></td>
    	<td height="35">
    		<div align="left">
   				<input id="poskod" name="poskod" style="width:205px;" type="text">	
     		</div>
     	</td>
    </tr>  
    <tr>
		<td height="35" width="40%"><div align="right">Bandar</div></td>
   	 	<td height="35"><div align="center">:</div></td>
    	<td height="35">
    		<div align="left">
   				<input id="bandar" name="bandar" style="width:205px;" type="text">	
     		</div>
     	</td>
    </tr>
    <tr>
		<td height="35" width="40%"><div align="right">Warganegara</div></td>
   	 	<td height="35"><div align="center">:</div></td>
    	<td height="35">
    		<div align="left">
   				<input id="warganegara" name="warganegara" style="width:205px;" type="text">	
     		</div>
     	</td>
    </tr>  
    <tr>
		<td height="35" width="40%"><div align="right">Username</div></td>
   	 	<td height="35"><div align="center">:</div></td>
    	<td height="35">
    		<div align="left">
   				<input id="username" name="username" style="width:205px;" type="text">	
     		</div>
     	</td>
    </tr>  
    <tr>
		<td height="35" width="40%"><div align="right">Kata Laluan</div></td>
   	 	<td height="35"><div align="center">:</div></td>
    	<td height="35">
    		<div align="left">
   				<input id="katalaluan" name="katalaluan" style="width:205px;" type="text">	
     		</div>
     	</td>
    </tr>  
    <tr>
		<td height="35" width="40%"><div align="right">Email</div></td>
   	 	<td height="35"><div align="center">:</div></td>
    	<td height="35">
    		<div align="left">
   				<input id="email" name="email" style="width:205px;" type="text">	
     		</div>
     	</td>
    </tr>  
    <tr>
		<td height="35" width="40%"><div align="right">Status</div></td>
   	 	<td height="35"><div align="center">:</div></td>
    	<td height="35">
    		<div align="left">
   				<input id="status" name="status" style="width:205px;" type="text">	
     		</div>
     	</td>
    </tr>  
    <tr>
		<td height="35" width="40%"><div align="right">No.Tel</div></td>
   	 	<td height="35"><div align="center">:</div></td>
    	<td height="35">
    		<div align="left">
   				<input id="notel" name="notel" style="width:205px;" type="text">	
     		</div>
     	</td>
    </tr>  
    <tr>
    	<td height="35"><div align="right">Negeri</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                <select id="negeri" name="negeri" style="width:270px;">
                	<option value="">-- Sila Pilih --</option>
            		<?php			
				foreach ($state as $row)
				{
			?>
					<option value="<?= $row->state_id ?>">
					    <?= strtoupper($row->state) ?>
                    </option>
		    <?php } ?>
                </select>
            </div>
        </td>
    </tr>
   <tr>
    	<td height="35"><div align="right">Jawatan</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                <select id="jawatan" name="jawatan" style="width:270px;">
                	<option value="">-- Sila Pilih --</option>
            		<?php			
				foreach ($level as $row)
				{
			?>
					<option value="<?= $row->ul_id ?>">
					    <?= strtoupper($row->ul_name) ?>
                    </option>
		    <?php } ?>
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
          		<input class="btn btn-info" type="button" id="btn_pemeriksa" name="btn_pemeriksa" value="Daftar Pemeriksa" class="validate[required]">
        		<input class="btn" type="reset" name="btn_reset" value="Reset">
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
         <th><b>Bil</b></th>
         <th><b>Nama Pemeriksa</b></th>
         <th><b>Username</b></th>
         <th><b>Email</b></th>
         <th><b>Status</b></th>
         <th><b>No.Telefon</b></th>
         <th><b>Jawatan</b></th> 
         <th><b>Negeri</b></th>
          <th><b>Tindakan</b></th>  
  </thead>
<tbody>
<?php 
if(isset ($data_pemeriksa))
	
	{
	?>
        <?php 
        
        $i=1;
        foreach($data_pemeriksa as $pem)
        {
        ?>
        
        <tr>
      		<td width="30" align="center">
        		<?= $i ?>
        	</td>
        	
        	<td width="300" align="center">
        		<span id="sem_<?= $cls->class_id ?>"><?= $cls->class_sem ?></span>
        	</td>
        	
        	<td width="300" align="center">
        		<span id="sem_<?= $cls->class_id ?>"><?= $cls->class_sem ?></span>
        	</td>
        	
        	<td width="300" align="center">
        		<span id="sem_<?= $cls->class_id ?>"><?= $cls->class_sem ?></span>
        	</td>
        	
        	<td width="300" align="center">
        		<span id="sem_<?= $cls->class_id ?>"><?= $cls->class_sem ?></span>
        	</td>     		    	
        	
        	<td width="300" align="center">
        		<span id="sem_<?= $cls->class_id ?>"><?= $cls->class_sem ?></span>
        	</td>
        	
        	<td width="300" align="center">
        		<span id="sem_<?= $cls->class_id ?>"><?= $cls->class_sem ?></span>
        	</td>     		    	
        	
        	<td width="300" align="center">
        		<span id="sem_<?= $cls->class_id ?>"><?= $cls->class_sem ?></span>
        	</td>
        		
        	<td width="300" align="center">
        		<center>
				<a name="btn_edit" id="btn_edit_<?= $cls->class_id ?>" class="btn btn_edit btn-info " type="button" value="<?= $cls->class_id ?>"><i class="icon-edit icon-white"></i>&nbsp;Kemaskini</a>
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
