<script>

	/**************************************************************************************************
	* Description : this function will change string to title case
	* input	 : str 
	* author	 : umairah
	* Date	 : 8/4/2014
	* Modification Log	:  -
	**************************************************************************************************/
	function toTitleCase(str)
	{
	  return str.replace(/\w\S*/g, function(txt){
	  return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
	  });
	}



    function show()
    {
        var course_id = document.getElementById("course_id").value;
        var semester = document.getElementById("semester").value;
      //  var year = document.getElementById("year").value;
        var max= document.getElementById("max").value;
        //alert(max);
        var method = $('input[name="method"]:checked').val();

        //alert(method);
        if(course_id == "" || semester == "" )
        {
        	$('#button').attr('disabled','disabled');
        	 document.getElementById("totalStudent").value="-";
        	 $('#classKelas').hide();
            document.getElementById("class").value="-";
        } 
        else 
        {
        	/*$.blockUI({ 
				 message: '<h5><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h5>', 
				 css: { border: '3px solid #660a30' }
				       });*/


            $.blockUI({ 
            message: '<h5>Sedang diproses, Sila tunggu...</h5><div class="progress progress-striped active" style="width: 70%; margin-left: 15%;"><div class="bar" style="width: 100%;"></div></div>'
        });


				setTimeout(function()
				{
            var url = site_url+'class/divide_student/coursegroupstatus/'+course_id+'/'+semester;
          			
            $.ajax({
	            url: url,
	            type:'POST',
	            data: $("#frm_pusat").serialize(),
	            dataType:'json',
	            
            success: function(data)
            {	
            	$.unblockUI();
                document.getElementById("totalStudent").value=data.totalStudent;
                document.getElementById("noGroup").value=data.nullGroup;
               
				//console.log(data);
                if(data.totalStudent > 0)
                {
                    if(method == 'kelas')
                    {
                    	document.getElementById("max").disabled=true;
                    	 $("#max").hide();
                        $("#max").val("");
                    }else
                    {
                        $("#max").show();
                    	 document.getElementById("max").disabled=false;

                    	 $("#max").keyup(function(e){
								//alert($("#max").val());
								//console.log($("#max").val());
								
								
								if(($("#max").val()*1) !== 0) 
								{		
									//alert("ok");					
									if(($("#max").val()*1) > (data.nullGroup*1))
									{
										$('#max').validationEngine('showPrompt', '*Nombor tidak boleh melebihi jumlah pelajar', 'err', 'topRight', true);									
										$('#button').attr('disabled','disabled');
										e.preventDefault();
									}
									else if($("#max").val() <= data.nullGroup)
									{							
										$('#button').removeAttr("disabled");
									}	
									
										
								}
								else if ($("#max").val() != "")
								{
                    		 		$('#button').attr('disabled','disabled');
								}
								else
								{
									$('#button').attr('disabled','disabled');
								}	
                    	 												
                    	 });
                   	
                    }
                }
                else
                {
                    document.getElementById("max").disabled=true;
                }               
                    
                if(data.maxClass == null)
                {
                    document.getElementById("class").value = "Tiada kelas";
                  
                } 
                else 
                {
                	
                    document.getElementById("class").value = data.maxClass+" kelas";
                    
                    if(data.maxClass == 0 && data.nullGroup == 0 && data.totalStudent == 0)
                     {
                    	$('#button').attr('disabled','disabled');
						
                     }
                    document.getElementById("newGroup").innerHTML = "";
                    $("#newGroup").html("");

                    	
                        if(data.stuClass.length != 0)
                        {
                           // alert(data.stuClass.length);  
                           var myClass=new Array("error","success","warning","info");              
                          var noArray = 0;
                          	$("#newGroup").append('<table id="classKelas" class="table table-striped table-bordered" style="width: 50%;"><tr class="info"><th>Nama Kelas</th><th width="40%">Bilangan Murid</th></tr></table>');
                        	for (var i = 0; i < data.stuClass.length; i++) 

                            	{  		var deleteClass = 0;
                                		var tblRow= "<tr class='"+myClass[noArray]+"'> <td>"+toTitleCase(data.stuClass[i].class_name)+" </td>  <td>"+data.stuClass[i].bil+"  </td></tr> ";
                                		$("#newGroup tr:last").after(tblRow);
                   
                                		$('#button').removeAttr("disabled");
                                		
										noArray++;

										if(noArray == 4)
											noArray = 0;

										
                                		
                        	} 

                        	
                        	
                        }

						
                        if($("#noGroup").val() >= 0)
                        {

                        	$('#button').removeAttr("disabled");

                        }
                        else
                        {

							$('#button').attr('disabled','disabled');

                        }
                        
                        if($("#noGroup").val() == 0)
                        {

                        	$('#button').attr('disabled','disabled');

                        }  
                                             
                        
                    }
                $("#btn_reset").bind("click",function(){

           		 $('#classKelas').remove();

           		
            		//$('#myModal').modal('show'); 
				
           	 });

             } 
        	},1500);    
             // End of success function of ajax form
            }); // End of ajax call 

				
        }
    }


	
    //$('#frmWeightage').on("click",'input[name="rdType"]',function(){
		//modType = $(this).val();
		
	
    //});
    
    
</script>

<script type="text/javascript">
	
	$(document).ready(function() {

		$('#button').attr('disabled','disabled');
		
		$("#frm_pusat").validationEngine();

		$('#max').attr('disabled','disabled');

        $("#max").hide();
		
   		$("#kelas").change(function(){
   		 
   			//$(this).parent().parent().find("td:eq(4)").find(".btn_save").removeAttr('disabled');		
   			$('#max').attr('disabled','disabled');

       		
   		 });
		
		 $("#button").bind("click",function() {

			 /*$.blockUI({ 
				 message: '<h5><img src="'+base_url+'assets/img/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h5>', 
				 css: { border: '3px solid #660a30' }
				       });*/

            $.blockUI({ 
            message: '<h5>Sedang diproses, Sila tunggu...</h5><div class="progress progress-striped active" style="width: 70%; margin-left: 15%;"><div class="bar" style="width: 100%;"></div></div>'
        });


				setTimeout(function()
				{
					var course_id=$("#course_id").val();
					var semester=$("#semester").val();
					//var year=$("#year").val();

					if(course_id == "" && semester == "")
					{	
						$.unblockUI();
					 	var mssg = new Array();
						mssg['heading'] = 'Informasi';
						mssg['content'] = 'Data kursus dan semester perlu di masukkan';
						kv_alert(mssg);
						
					}
				 	else
				 	{
				    	 $.ajax({
				   			url: '<?=site_url('class/divide_student/create_new_group')?>',
				   			type: 'POST', 
				   			dataType : 'html',
				   			data: $("#frm_pusat").serialize(),
				   			
							success: function(data) 
								   {	

								  // alert(data);
								  		if(data == 1)
									  	{
									  		$.unblockUI();
											var mssg = new Array();
											mssg['heading'] = 'Informasi';
											mssg['content'] = 'Pembahagian murid telah berjaya di kemaskini';
											kv_alert(mssg);
											show();
								  		}
								  		else
								  		{
								  			$.unblockUI();
											var mssg = new Array();
											mssg['heading'] = 'Informasi';
											mssg['content'] = 'Pembahagian murid tidak berjaya di bahagikan';
											kv_alert(mssg);
											show();

										}
		                        	
								   }	
				   
				 });//end of ajax
				 }

					},1500);
				
			
		  });//end of click function
	
	});
		
</script>

<script>
 
var base_url = '<?=base_url();?>';
var site_url = '<?=site_url();?>/';

</script>

<legend><h3>Pembahagian Murid Mengikut Kelas</h3></legend>
<center>
<form name="frm_pusat" id="frm_pusat" action="" method="" class="form-inline">
<table id = "table_group" class="breadcrumb border" width="100%" align="center">
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
    <tr>
		<td height="35" width="40%"><div align="right">Kursus</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
				<select name="course_id" id="course_id" onchange="show()" class="validate[required]">
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
	        	<select class="validate[required]"  name="semester" onchange="show()" id="semester" >
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
    	<td height="35"><div align="right">Pembahagian Mengikut</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left" style="width:225px;">
        	<label class="radio">
                    <input type="radio" id="kelas" onchange="show()" name="method" value="kelas" class="validate[required] method" checked="checked">Kelas
                </label>
                <label class="radio">
                    <input type="radio" id="pelajar" onchange="show()" name="method" value="pelajar" class="validate[required] method">Murid
                </label>
				<input type="text" style="padding-left:5px;" name="max" id="max" class="validate[required,custom[onlyNumberSp]] span6 max"/>
            </div>
        </td>
    </tr>
    
          
    <tr>
    	<td height="35"><div align="right">Jumlah Murid</div></td>
        <td height="35"><div align="center">:</div></td>
        <td><input type="text" readonly="readonly" name="totalStudent" id="totalStudent" value="-" /></td>
    </tr>  
    <tr>
    	<td height="35"><div align="right">Murid Tiada Kelas</div></td>
        <td height="35"><div align="center">:</div></td>
        <td><input type="text" readonly="readonly" name="noGroup" id="noGroup" value="-" /></td>
    </tr>  
    <tr>
    	<td height="35"><div align="right">Bilangan Kelas</div></td>
        <td height="35"><div align="center">:</div></td>
        <td>
        	<input type="text" readonly="readonly" name="class" id="class" value="-" />
        </td>
    </tr>
    <tr>
    	<td><div align="right"></div></td>
        <td><div align="center"></div></td>
        <td><div id="newGroup"></div></td>
    </tr>  
    <tr>
    	<td></td>
    	<td height="35"><div align="right"></div></td>
        <td height="35">
        	<div align="left">
        		</br>
          		<input class="btn btn-info" type="button" id="button" name="btn_papar" value="Bahagi Kelas"> <input id="btn_reset" class="btn" type="reset" name="btn_reset" value="Set Semula">
        	</div>
        </td>
    </tr> 
    <tr><td>
    &nbsp;&nbsp;</td>
    </tr>
   
</table>
</form>
</center>

  

