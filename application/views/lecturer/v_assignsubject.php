
<style>
	#selStaffList, #searchStaffList, .sul { list-style-type: none; margin: 0; padding: 0; float: left; margin-right: 10px; background: #eee; padding: 5px; width: 350px;}
	.items {margin: 1px; padding: 2px; border: 1px solid #CCC; background: #F6F6F6; 
			font-weight:bold; color: #1C94C4; outline: none; cursor:default; position: relative;
    		float:left;	width:345px;
	}
	.closebtn, .mclosebtn {position:absolute;opacity:1;right:0px;top:3px;width:16px;height:16px;cursor:pointer; border:1px solid #000; background-color:#efefef;
   			z-index: 5;background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAQAAAC1+jfqAAAAiElEQVR42r2RsQrDMAxEBRdl8SDcX8lQPGg1GBI6lvz/h7QyRRXV0qUULwfvwZ1tenw5PxToRPWMC52eA9+WDnlh3HFQ/xBQl86NFYJqeGflkiogrOvVlIFhqURFVho3x1moGAa3deMs+LS30CAhBN5nNxeT5hbJ1zwmji2k+aF6NENIPf/hs54f0sZFUVAMigAAAABJRU5ErkJggg==) no-repeat;
    		text-align:right; border: 0; cursor: pointer;    
	}
	.closebtn:hover, .closebtn:focus, .mclosebtn:hover, .mclosebtn:focus  {
		background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAQAAAC1+jfqAAAAqklEQVR4XqWRMQ6DMAxF/1Fyilyj2SmIBUG5QcTCyJA5Z8jGhlBPgRi4TmoDraVmKFJlWYrlp/g5QfwRlwEVNWVa4WzfH9jK6kCkEkBjwxOhLghheMWMELUAqqwQ4OCbnE4LJnhr5IYdqQt4DJQjhe9u4vBBmnxHHNzRFkDGjHDo0VuTAqy2vAG4NkvXXDHxbGsIGlj3e835VFNtdugma/Jk0eXq0lP//5svi4PtO01oFfYAAAAASUVORK5CYII=") no-repeat;
	}
	.staffid{display:none;}
	.bblue, .dblue{font-weight:bold; color:blue;}
	.ddark{font-weight:bold; color:inherit;}
	.dgreen{font-weight:bold; color:green;}
</style>


<script language="javascript" type="text/javascript" >
	
	$(document).ready(function()
	{
		//$("#form1").validationEngine();
		$('#selStaffList').on("click", ".closebtn", function(){
		
		});	

		var kodkv = [<?=$college?>];
		
		$( "#kodpusat" ).autocomplete({
			source: kodkv
		});
		$('#kodpusat').focusout(function(){
			
		var kodpusat = $('#kodpusat').val();
		var request = $.ajax({
        url: '<?php echo site_url('lecturer/assignsubject/get_course_college');?>',
        type:'POST',
        data: {college : kodpusat},
        dataType: 'json'    
        }); // End of ajax call 
        
        request.done(function(data){

        //	alert ("("+ data+")");
            document.form1.course.options.length=0;
            $('#course').html("");
            document.form1.course.options[0] = new Option('-- Sila Pilih --','',false,false);
            if(data != null)
            {
                for(var i = 0; i < data.length; i++)
                {
                    document.form1.course.options[i+1] = new Option(data[i].cou_code+' - '+data[i].cou_cluster,data[i].cou_id,false,false);
                } // End of success function of ajax form
            }
        });
        request.fail(function(jqXHR, textStatus) {
				alert("Request failed"+ textStatus);
				});		
	});

	
	$('#searchStaff').click(function(){
		
		if($('#searchStaff').is(':disabled'))
		{
			return false;
		}
		else
		{
			$('#searchModal').modal({
	                keyboard: false,
					backdrop: 'static'
			 });
		}
		 
	});

	$("#btn_reset").bind("click",function(){

		 $('#selStaffList li').remove();

		//$('#myModal').modal('show');  

	 });


	
	$('#group').change(function() {
            
            
        var course_id = $('#course').val();
        var subject_id = $('#subject').val();
        var group_no = $('#group').val();
        var sem = $('#semester').val();
        var status = 1;
      //  alert (course_id+subject_id+group_no+sem);
        
        
        
        $('#selStaffList li').remove();
       
        
        var url = '<?php echo site_url('lecturer/assignsubject/get_ajax_lecturer_subjectgroup');?>/'+
           course_id+'/'+sem+'/'+subject_id+'/'+ status+'/'+group_no;

        $.ajax({
        url: url,
        dataType: "json",
        type:'POST',
        
        success: function(data)
        {
        	//alert("ok");
           // console.log(data);
             // console.log(url);
            if(data != null)
            {
            	
                for(var i = 0; i < data.length; i++)
                {
                   
                    var staffname = data[i].user_name;
                    var staffposition = data[i].ul_name;
                    var userid = data[i].user_id;
                   
                  
                    $('#selStaffList').append('<li class="items"><span class="vals">'+toTitleCase(staffname)+'-'+staffposition+'</span><span class="staffid">'+userid+'</span><div class="closebtn"></div></li>');
                    
                    if(i==0)
                    {
                    	$('#selStaffList li:first-child').append('<b> (Ketua)</b>');
                    }
                }
            } 
        },
        error:function(err,txtStatus)
        {
        	alert(err+txtStatus);
        }
        
            
        });      
        });
        
	
	$('#form1').submit(function(event) {
		
		
				$("#form1").validationEngine('validate');
				var course=$("#course").val();
				var semester=$("#semester").val();
				var subject=$("#subject").val();
				var group=$("#group").val();
				
			//	alert()
				//var se=$("#course").val();
				
                var slist = "";
                $("#selStaffList li").each(function()
                {
                        slist+=$(this).find('span.staffid').html()+';';
                });

              
                if(slist.length>0)
                {
                		
				slist = slist.substr(0,slist.length-1); //buang the extra ; kat belakang
			
				$('#txtStaffList').val(slist);
			
				//alert(slist);
              
                	//alert (slist);
                	event.preventDefault();
					var request = $.ajax({
					url: '<?php echo site_url('lecturer/assignsubject/assign_subj_lect');?>',
					type: "POST",
					data: $("#form1").serialize(),
					dataType: ""
					});
			
					request.done(function(data) {

						if(course == "" || semester == "" || subject == "" || group == "" || slist.length == 0)
						{
							var mssg = new Array();
							mssg['heading'] = 'Informasi';
							mssg['content'] = 'Sila penuhkan maklumat';
							kv_alert(mssg);
						}
						
						else
						{

							var mssg = new Array();
							mssg['heading'] = 'Informasi';
							mssg['content'] = 'Penetapan modul berjaya';
							kv_alert(mssg);
							$('#form1')[0].reset();
							$('#selStaffList').html("");
							

						}
						
					});
			
				request.fail(function(jqXHR, textStatus) 
				{
				
					alert("Form can't be submitted:"+ textStatus);
				
				});
                        
                }
                else
                {		

                		
                        //show error message
                        if(slist.length == 0)
                        {
                         	$('#selStaffList').validationEngine('showPrompt', '* Sila Masukkan Nama Pensyarah', 'err', 'topRight', true);
                        }

						
                        	$('#course').validationEngine('showPrompt', '* Sila Masukkan Nama Kursus', 'err', 'topRight', true);
						
							$('#semester').validationEngine('showPrompt', '* Sila Masukkan Semester', 'err', 'topRight', true);
						
							$('#group').validationEngine('showPrompt', '* Sila Masukkan Nama Kelas', 'err', 'topRight', true);
						
							$('#subject').validationEngine('showPrompt', '* Sila Masukkan Nama Modul', 'err', 'topRight', true);
						
						
                        event.preventDefault();
                        
                }
			
	});
	
	$('#CarianStf').click(function(){
	
		//if($("#searchStf").validationEngine('validate',{scroll: false}))
		{	
			$('#searchModal').block({ 
			message: '<h5>Sedang diprocess, Sila tunggu...</h5><div class="progress progress-striped active" style="width: 70%; margin-left: 15%;"><div class="bar" style="width: 100%;"></div></div>'
            })
		
			var search = $('#cStaff').val();
		   //alert(search);
			var request = $.ajax({
			url: '<?php echo site_url('lecturer/assignsubject/search_staff_details');?>',
			type: "POST",
			data: $("#searchStf").serialize(),
			dataType: "json"
			});
			request.done(function(data) {
				$('#Hstaff > tbody').html("");
				
                                if(data.staffs!=null && data.staffs.length>0)
				{
                                   

					$(data.staffs).each(function(index)
					{
						
						var staffid = data.staffs[index].user_id;
						var staffname = data.staffs[index].user_name;
						var staffpost = data.staffs[index].ul_name;

						var tblRow = '<tr>'+
						'<td>'+ toTitleCase(staffname) +'</td>'+
						'<td>'+ toTitleCase(staffpost) +'</td>'+
						'<td style="text-align:center"><a class="addStaff btn" href="javascript:void(0);"' +
						'data-original-title="Pilih Staff"><span class="staffid">'+staffid+'</span><i class="icon-plus"></i></a></td>'+
						'</tr>'
						
						$('#Hstaff > tbody:last').append(tblRow);
						
					});
					
					$('.addStaff').tooltip();
					
					$('#searchModal').unblock();
				}
				else
				{
					$('#searchModal').unblock();
					//alert("Tiada Maklumat Staff");
//					$('#Hstaff > tbody:last').append(
//					'<tr><td colspan="4"><span class="style8">tiada maklumat staff dijumpai</span></td></tr>');
                                        var tblRow = '<tr>'+
						'<td>Akan diisi</td>'+
						'<td>-</td>'+
						'<td style="text-align:center"><a class="addStaff btn" href="javascript:void(0);"' +
						'data-original-title="Pilih Staff"><i class="icon-plus"><span class="staffid">-</span></i></a></td>'+
						'</tr>'
						
						$('#Hstaff > tbody:last').append(tblRow);
                 }
			});

			request.fail(function(jqXHR, textStatus) {
				//msg("Request failed", textStatus, "Ok");
				alert("Request failed"+ textStatus);
				$('#searchModal').unblock();
			});

			return false;
		}
	});
	
	$('#Hstaff').on("click", ".addStaff", function(){
		
		
		var display_data = $(this).parent().parent().find("td").eq(0).html()+'-'+
			$(this).parent().parent().find("td").eq(1).html();
			
	
		var sid = $(this).find(".staffid").html();
		
		//alert(sid);
		var selValues = new Array();
		var selFirst;
		
		selFirst = $("#selStaffList li:first-child" ).find('.vals').html();
		
		$("#selStaffList li").each(function()
		{
			selValues.push($(this).find('.vals').html());
		});
		
		//alert(display_data);
		//alert(selValues);
		
		if($.inArray(display_data, selValues)==-1)
		{
				if(selValues.length == 3)
				{
					$('#searchStaff').attr('disabled',true);
				}
			
				$('#selStaffList').append('<li class="items"><span class="vals">'+display_data+'</span><span class="staffid">'+sid+'</span><div class="closebtn"></div></li>');
				
				if(selFirst == "" || selFirst == null)
			{
				
				$('#selStaffList li:first-child').append('<b> (Ketua)</b>');
			}
			
		}
		
		$('#searchModal').modal('hide');
		
		//e.preventDefault();
		
	});
	
	$('#selStaffList').on("click", ".closebtn", function(){
		var selClick = $(this).parent().find('.vals').html();
		var selFirst = $("#selStaffList li:first-child" ).find('.vals').html();
		
		$('#searchStaff').removeAttr("disabled");
		
		$(this).parent().remove();
		if(selClick == selFirst)
		{
			
			$('#selStaffList li:first-child').append('<b> (Ketua)</b>');
		}
		
		
	});
	});
	

	function show(){
		 
		$.blockUI({ 
			message: '<h5>Sedang diproses, Sila tunggu...</h5><div class="progress progress-striped active" style="width: 70%; margin-left: 15%;"><div class="bar" style="width: 100%;"></div></div>'
		});

		 var cid = $('#course').val();
	     var sem = $('#semester').val();
		  
		 var url = '<?php echo site_url('lecturer/assignsubject/subject_list_bysem');?>/'+cid+'/'+sem;
          
	    $.ajax({
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
	            	//console.log(data);
	                for(var i = 0; i < data.length; i++)
	                {
	                    document.form1.subject.options[i+1] = new Option(data[i].mod_paper+' - '+toTitleCase(data[i].mod_name),data[i].mod_id,false,false);
	                } // End of success function of ajax form
	            }

	            $.unblockUI();
	        }
	           
	        //$('#subject').prop('disabled', false);
	        //$('#subject').removeAttr('disabled');

	        }); // End of ajax call 

		}




	
	function showPaper(){
		
    	$.blockUI({ 
			message: '<h5>Sedang diproses, Sila tunggu...</h5><div class="progress progress-striped active" style="width: 70%; margin-left: 15%;"><div class="bar" style="width: 100%;"></div></div>'
		});

        var cid = $('#course').val();
        var sem = $('#semester').val();
       // alert(cid);        
        var url = '<?php echo site_url('lecturer/assignsubject/group_no');?>/'+cid+'/'+sem;
          //alert(sem);
        $.ajax({
        url: url,
        type:'POST',
        dataType: 'json',
        success: function(data){
        	
            document.form1.group.options.length=0;
            //$('#s').html("");
            document.form1.group.options[0] = new Option('-- Sila Pilih --','',false,false);
            if(data != null){
            	//console.log(data);
                for(var i = 0; i < data.length; i++){
                    document.form1.group.options[i+1] = new Option(data[i].class_name,data[i].class_id,false,false);
                } // End of success function of ajax form
            }

	        $.unblockUI();
        }
       
        }); // End of ajax call 
        $('#selStaffList li').remove(); 
    }
	/**************************************************************************************************
	* Description : this function will change string to title case
	* input	 : str 
	* author	 : Freddy Ajang Tony
	* Date	 : 18/10/2013
	* Modification Log	:  -
	**************************************************************************************************/
	function toTitleCase(str)
	{
	   return str.replace(/\w\S*/g, function(txt){
	   	return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
	   	});
	}	
	
</script>

<legend><h3><?=$title?></h3></legend>
<center>

<form id="form1" name="form1" action="">
<table class="breadcrumb border" width="100%" align="center">
   				<tr>
                  <td width="240" align="right"></td>
                  <td width="10" align="center"></td>
                  <td width="368" height="35" align="left" style="font-size: 16px;font-weight: bold;"></td>
                </tr>
   <?php
   /*<tr>
    	<td width="45%" height="35"><div align="right">Kod Pusat</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35"><div align="left">
        <input type="text" name="kodpusat" id="kodpusat" class="span3 validate[required]" style="margin-left:0px"/>
        </div>
        </td>
    </tr>*/ ?>
    <tr>
    	<td height="35"><div align="right">Kursus</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35"><div align="left">
        	<select id="course" name="course" class="validate[required]" >
            <option value="">--  Sila Pilih  --</option>
            <?php
            	foreach($course as $row)
				{
					echo "<option value='".$row->cou_id."'>".$row->cou_course_code."-".$row->cou_name."</option>";
				}
            ?>
            
            </select>
        </td>
    </tr>
     <tr>
    	<td height="35"><div align="right">Semester</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35"><div align="left">
        	<select id="semester" name="semester" class="validate[required]" onchange="show()">
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
        </td>
    </tr>
    <tr>
     <tr>
    	<td height="35"><div align="right">Mata Pelajaran / Modul</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35"><div align="left" id="pnlSubject" style="width:50%;">
        	<select id="subject" name="subject" class="validate[required]" onchange="showPaper()">
            <option value="">-- Sila Pilih --</option>
            
            </select>
            <div>
        </td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Kelas</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35"><div align="left">
        	<select id="group" name="group" class="validate[required]">
            <option value="">-- Sila Pilih --</option>
            
            </select>
        </td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Pensyarah</div></td>
        <td height="35"><div align="center">:</div></td>
            	<div id="staffList">
        <td width="38%" style="vertical-align:bottom;">
        	<div style="font-size:14px">
	        	<button type="button" id="searchStaff" class="btn" href="javascript: void(0);" data-original-title="Carian Staff">
	            <i class="icon-search"></i>&nbsp;Carian Pensyarah</button>            
	           	<span class="help-inline"><small style="color: red">*Maksimum 4 Pensyarah</small></span>
            </div>
                                 
    	</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
	    <td width="55%" style="vertical-align:top">
		    <input type="hidden" id="txtStaffList" name="txtStaffList" value="" class="validate[required]"/>
		    <ul id="selStaffList" name="selStaffList">
		    </ul>
	    </td>
	</tr>
                  </div>
        </td>
    </tr>
    <tr>
        <td colspan="3" height="35">
        	<div align="center">
          		<input class="btn btn-info" type="submit" id="submit" name="update" value="Simpan Penetapan" style="margin-top: 15px;">
          		<input id="btn_reset" class="btn" type="reset" name="btn_reset" value="Set Semula" style="margin-top: 15px;">
        	</div>
        </td>
    </tr>
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
</table>
</form>

<div class="modal hide fade" id="searchModal" style="width:90%; left:27%;">
    <div class="modal-header">
    <button id="btn_close_assg_marks" type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
      <h3><strong>CARIAN PENSYARAH</strong></h3>
    </div>
    <div class="modal-body" >
  	
	<form id="searchStf" name="searchStf" method="post" style="position:relative;vertical-align:center;">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">
        <tbody>
            <tr>
                <td colspan="2" ><div align="left"><strong id="menutitle" style="padding: 10px;">Cari Pensyarah :</strong>
                  <input type="text" name="cStaff" id="cStaff" class="validate[required] span3" style="margin-bottom: 0px;"/>
                  <input type="submit" name="CarianStf" id="CarianStf" value="Cari" class="btn btn-primary"/>
                </div>                  </td>
          </tr>
          <tr>
          		<td colspan="2">
                	<table id="Hstaff" width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered">
                    	<thead>
                        <tr>
                        	
                            <th style="border-bottom:1px solid #DDD;" width="40%">Nama Pensyarah</th>
                            <th style="border-bottom:1px solid #DDD;" width="30%">Jawatan</th>
                            <th style="border-bottom:1px solid #DDD;" width="10%" align="center">&nbsp;</th>
                        </tr>
                        </thead> 
                        <tr>                  
                        <tbody></tbody>
                    	</tr>
                    </table>
                 </td>
          </tr>
         
        </tbody>
      </table>
      <br />
      <br />

  </form>
  </div>  	
</div>

</center>
