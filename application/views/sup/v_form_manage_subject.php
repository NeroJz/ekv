<script>

//var autoCompleteOpts = {
		//source: [<?=$lecturers ?>],
		//close: function(event, ui) { $(this).validationEngine('validate'); }
	//};
	
	//$(document).ready(function() {
    //    $("#subjek").autocomplete(autoCompleteOpts);
    //});
	
	// $(document).ready(function(){
    //    $("#form1").validationEngine();
    //});
</script>

<script>
	
	function showLecturer(){
    	
        $('#selStaffList li').remove();
        var url = '<?php echo site_url('sup/manage_subject/get_subject_staff_reserve');?>/'+
            document.form1.course_id.value+'/'+document.form1.subject.value+'/'+document.form1.sesi.value+'/'+document.form1.semester.value;
        
        $.ajax({
        url: url,
        type:'POST',
        dataType: 'json',
        success: function(data){
        	//console.log(data);
            if(data != null && data > 0){
                $('#selStaffList').append('<li class="items"><span class="vals">-Akan diisi (-)</span><span class="staffid">-</span><div class="closebtn"></div></li>');
            }
        }
            
        }); // End of ajax call 
        
        var url = '<?php echo site_url('sup/manage_subject/get_subject_staff');?>/'+
            document.form1.course_id.value+'/'+document.form1.subject.value+'/'+document.form1.sesi.value+'/'+document.form1.semester.value;

        $.ajax({
        url: url,
        type:'POST',
        dataType: 'json',
        success: function(data){
        	  //console.log(data);
        	 // console.log(url);
            if(data != null){
                for(var i = 0; i < data.length; i++){
                	var staffid = data[i].id;
                    var userFirstName = data[i].first_name;
                    var userLastName = data[i].last_name;
                    var email = data[i].email;
                    //var kodPusat = data[i].kod_pusat;
                    //var namaInstitusi = data[i].nama_institusi;
                    
                    $('#selStaffList').append('<li class="items"><span class="vals">'+userFirstName+' '+userLastName+' ('+email+')</span><span class="staffid">'+staffid+'</span><div class="closebtn"></div></li>');
                    //$('#subjek').val(userFirstName+' '+userLastName);
                }
            }
        }
            
        }); // End of ajax call 
    }
</script>

<script type="text/javascript">


    function show(){
    	
        var cid = document.form1.course_id.value;
        //var session = document.form1.semester.value;
        //session = session.replace(" ","_");
        //session = session.replace("/","-");
        var url = '<?php echo site_url('sup/manage_subject/list_subject');?>/'+cid;
        
        
        $.ajax({
        url: url,
        type:'POST',
        dataType: 'json',
        success: function(data){
        	//document.form1.selectto.options.length=0;
        	$('#select-to').html("");
            document.form1.subject.options.length=0;
            //$('#subject').html("");
            document.form1.subject.options[0] = new Option('-','',false,false);
            if(data != null){
            	console.log(data);
                for(var i = 0; i < data.length; i++){
                    document.form1.subject.options[i+1] = new Option(data[i].kod_subjek_modul+' - '+data[i].nama_subjek_modul,data[i].subjek_id,false,false);
                } // End of success function of ajax form
            }
        }
            
        }); // End of ajax call 
        
        //var url = '<?php echo site_url('faculty/managegroup/maxgroup');?>/'+cid+'/'+session;
        
        //$.ajax({
        //url: url,
        //type:'POST',
        //dataType: 'json',
        //success: function(data){
            //document.form1.groupNo.options.length=0;
            //if(data != null)
            //{
            	//added by nabihah 15012013
                //for(var i = 0; i < data; i++)
                //{
                    //document.form1.groupNo.options[i] = new Option((i+1),(i+1),false,false);
                //} // End of success function of ajax form
           // } 
            
            //else 
            //{
                //document.form1.groupNo.options.length=0;
                //document.form1.groupNo.options[0] = new Option('Kumpulan belum diwujudkan','',false,false);
            //}
        //}
            
        //}); // End of ajax call 
    }
 
function showMark(){
		
		//alert("try");
        var subjectid = document.form1.subject.value;
        var courseid = document.form1.course_id.value;
     
        var url = '<?php echo site_url('sup/manage_subject/showMark');?>/'+ subjectid+ '/'+ courseid;
        
        $.ajax({
        url: url,
        type:'POST',
        dataType: 'json',
        success: function(data){
        	
           // document.form1.subject.options.length=0;
           // document.form1.subject.options[0] = new Option('-','',false,false);
            if(data != null)
            {
               //console.log(data);
               // for(var i = 0; i < data.length; i++)
               // {
               //     document.form1.course_work.options[i+1] = new Option(data[i].subject_code+' - '+data[i].subject_name,data[i].subject_id,false,false);
               //} // End of success function of ajax form
                $('#course_work').val(data[0].sp_markah_pusat);
                $('#final').val(data[0].sp_markah_sekolah);
            }
            
            else
            {
            	 $('#course_work').val("");
            	 $('#final').val("");
            }
           
        }
            
        }); // End of ajax call 
            
        
    }
    
    
    
  
	
</script>

<script type="text/javascript">
 //added by nabihah 14/1/2012
    
$(document).ready(function() {
 
    $('#btn-add').click(function(){
        $('#groupNo option:selected').each( function() {
                $('#select-to').append("<option value='"+$(this).val()+"'>"+$(this).text()+"</option>");
                $('#select-to').find('option').attr('selected','selected');
            $(this).remove();
        });
    });
    $('#btn-remove').click(function(){
        $('#select-to option:selected').each( function() {
            $('#groupNo').append("<option value='"+$(this).val()+"'>"+$(this).text()+"</option>");
            $(this).remove();
        });
    });
 
});
$(document).ready(function() {
		
		//$("#form1").validationEngine();
        /* Initialise the DataTable */
        oTable = $('#myTable').dataTable( {
            "sPaginationType": "full_numbers",
                        "bJQueryUI": true,
            "oLanguage": {
                "sSearch": "Carian :"
            }
        } );
		
		window.setTimeout(function() {
			$("#divMssg").fadeTo(1000,0).slideUp(1000, function(){
				//$(this).remove();
			});
		}, 2000);
		
    } );
</script>

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

<script src="<?=base_url()?>assets/js/kv.msg.modal.js" type="text/javascript"></script>

<script>
var base_url = '<?=base_url();?>';
var site_url = '<?=site_url();?>/';

$(document).ready(function(){
	
	//$("#form1").validationEngine();
	
	$('#selStaffList').on("click", ".closebtn", function(){
		$(this).parent().remove();
	});
	
	$('#rdall').click(function(){
		$('#staffList').slideUp();
	});
	
	$('#rdstaff').click(function(){
		$('#staffList').slideDown();
	});
	
	var removeIntent = false;
	$('#selStaffList').sortable({
		over: function () {
			removeIntent = false;
		},
		out: function () {
			removeIntent = true;
		},
		beforeStop: function (event, ui) {
			if(removeIntent == true){
				ui.item.remove();   
			}
		}
	});
	
	$('#myTab a:first').tab('show');
	$('#myTab a').click(function (e) {
  		//e.preventDefault();
  		$(this).tab('show');
	});
	
	$('#submit').click(function(e){
		
		$("#form1").validationEngine();
		
                var slist = "";
                $("#selStaffList li").each(function()
                {
                        slist+=$(this).find('span.staffid').html()+';';
                });

                if(slist.length>0)
                {
                        slist = slist.substr(0,slist.length-1); //buang the extra ; kat belakang
                        $('#txtStaffList').val(slist);
                }
                else
                {
                        //show error message
                        //$('#selStaffList').validationEngine('showPrompt', '*Sila Masukkan sekurang-kurangnya seorang staff', 'err', 'topLeft', true)
                        //e.preventDefault();
                }
		
	});
	
		$('#btn_reset_m').click(function(e){
		$('#selStaffList').validationEngine('hide');
		$('#selStaffList li').remove();
	});
	
	$('#searchStaff').tooltip();

	$('#searchStaff').click(function(){
		 $('#searchModal').modal({
                keyboard: false,
				backdrop: 'static'
		 });
	});
	
	$('.mclosebtn').click(function(){
		
		var id_to_delete = $(this).find('.staffid').html();
		var li = $(this).parent();
		
		var opts = new Array();
		opts['heading'] = 'Memadam Pembukaan Kemasukan Markah';
		opts['hidecallback'] = true;
		opts['callback'] = function()
		{
			if(id_to_delete!=null && id_to_delete.length>0)
			{
				 $.blockUI({ 
					message: '<h5><img src="<?=base_url()?>images/loading_ajax.gif" alt="Sedang process"/>Sedang process, Sila tunggu...</h5>', 
					css: { border: '3px solid #660a30' } 
            	}); 
				
				//ajax submit to delete
				var request = $.ajax({
				url: "<?=base_url()?>index.php/staffs/result/delete_manual_configuration",
				type: "POST",
				data: {fid : id_to_delete},
				dataType: "html"
				});
	
				request.done(function(data) {
					$.unblockUI();
					if(data.length>0 && data>0)
					{
						var opts = new Array();
						opts['heading'] = 'Berjaya';
						opts['content'] = 'rekod berjaya dipadam';
						
						if(li.parent().find('li').size()==1)
							li.closest('tr').remove();
						
						li.remove();
						
						kv_alert(opts);
						
					}
					else
					{
							var opts = new Array();
						opts['heading'] = 'Tidak Berjaya';
						opts['content'] = 'rekod berjaya dipadam';
						kv_alert(opts);
					}
				});
	
				request.fail(function(jqXHR, textStatus) {
					$.unblockUI();
					//msg("Request failed", textStatus, "Ok");
					alert("Request failed"+ textStatus);
				});
			}
		};
		
		
		opts['cancelCallback'] = function(){/*do nothing*/};
		kv_confirm(opts);
	});
});

$(document).ready(function(){
	
	//$("#form1").validationEngine();
    $("#frmOpenSetting").validationEngine('attach', {promptPosition : "centerRight", scroll: false});
	$("#frmOpenManual").validationEngine('attach', {promptPosition : "centerRight", scroll: false});
	$("#searchStf").validationEngine();
	
	$('#CarianStf').click(function(){
	
		if($("#searchStf").validationEngine('validate',{scroll: false}))
		{	
			$('#searchModal').block({ 
			message: '<h5><img src="<?=base_url()?>assets/img/loading_ajax.gif" alt="Sedang proses"/>Sedang proses, Sila tunggu...</h5>', 			css: { border: '3px solid #660a30' } 
            })
		
			var search = $('#cStaff').val();
		
			var request = $.ajax({
			url: "<?=site_url()?>/sup/manage_subject/search_staff_details",
			type: "POST",
			data: {str : search},
			dataType: "json"
			});

			request.done(function(data) {
				$('#Hstaff > tbody').html("");
				
                                if(data.staffs!=null && data.staffs.length>0)
				{
                                    var tblRow = '<tr>'+
						'<td>-</td>'+
						'<td>Akan diisi</td>'+
						'<td>-<span class="staffid">-</span></td>'+
						'<td style="text-align:center"><a class="addStaff btn" href="javascript:void(0);"' +
						'data-original-title="Pilih Staff"><i class="icon-plus"><span class="staffid">-</span></i></a></td>'+
						'</tr>'
						
						$('#Hstaff > tbody:last').append(tblRow);

					$(data.staffs).each(function(index)
					{
						var staffid = data.staffs[index].id;
						var userFirstName = data.staffs[index].first_name;
						var userLastName = data.staffs[index].last_name;
						var email = data.staffs[index].email;
						
						var tblRow = '<tr>'+
						'<td>'+userFirstName +'</td>'+
						'<td>'+userLastName +'</td>'+
						'<td>'+email +'<span class="staffid">'+email+'</span></td>'+
						'<td style="text-align:center"><a class="addStaff btn" href="javascript:void(0);"' +
						'data-original-title="Pilih Staff"><i class="icon-plus"><span class="staffid">'+staffid+'</span></i></a></td>'+
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
						'<td>-</td>'+
						'<td>Akan diisi</td>'+
						'<td>-<span class="staffid">-</span></td>'+
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
			$(this).parent().parent().find("td").eq(1).html()+' ('+$(this).parent().parent().find("td").eq(2).find('.staffid').html()+')';
		var sid = $(this).find(".staffid").html();
		//alert(sid);
		var selValues = new Array();
		$("#searchStaffList li").each(function()
		{
			selValues.push($(this).find('.vals').html());
		});
		$('#selStaffList').empty();
		$('#selStaffList').append('<li class="items"><span class="vals">'+display_data+'</span><span class="staffid">'+sid+'</span><div class="closebtn"></div></li>');
		$('#searchModal').modal('hide');
		//e.preventDefault();
	});
	
	var removeIntents = false;
	$('#searchStaffList').sortable({
		over: function () {
			removeIntent = false;
		},
		out: function () {
			removeIntent = true;
		},
		beforeStop: function (event, ui) {
			if(removeIntent == true){
				ui.item.remove();   
			}
		}
	});
	
	$('#searchStaffList').on("click", ".closebtn", function(){
		$(this).parent().remove();
	});
	
	$('#btnCnfmStaff').click(function(e){
		
		$("#searchStaffList li").each(function()
		{
			var selValues = new Array();
			$("#selStaffList li").each(function()
			{
				selValues.push($(this).find('.vals').html());
			});
			if($.inArray($(this).find('.vals').html(), selValues)==-1)
			{
				$('#selStaffList').append($(this));
			}

		});
		
		$('#searchModal').modal('hide');
		//e.preventDefault();
	});
});

function showMark(){
		
		//alert("try");
        var subjectid = document.form1.subject.value;
        var courseid = document.form1.course_id.value;
     
        var url = '<?php echo site_url('sup/manage_subject/showMark');?>/'+ subjectid+ '/'+ courseid;
        
        $.ajax({
        url: url,
        type:'POST',
        dataType: 'json',
        success: function(data){
        	
           // document.form1.subject.options.length=0;
           // document.form1.subject.options[0] = new Option('-','',false,false);
            if(data != null)
            {
               //console.log(data);
               // for(var i = 0; i < data.length; i++)
               // {
               //     document.form1.course_work.options[i+1] = new Option(data[i].subject_code+' - '+data[i].subject_name,data[i].subject_id,false,false);
               //} // End of success function of ajax form
                $('#course_work').val(data[0].sp_markah_pusat);
                $('#final').val(data[0].sp_markah_sekolah);
            }
            
            else
            {
            	 $('#course_work').val("");
            	 $('#final').val("");
            }
           
        }
            
        }); // End of ajax call 
            
        
    }  
    
</script>

<h4>Pembahagian Pensyarah Mengikut Subjek</h4><hr/><br />

<?php if(isset($message)) { ?>

<center>
    <div id="divMssg" class="alert alert-success" style="width: 50%">
    <?=$message?>
    </div>
</center>

<?php } ?>
    <center>
    <div align="center" style="width:70%; margin:auto;">
    <form id="form1" name="form1" action="" method="post">
  
     <table id="group" class="table table-bordered table-striped" width="100%" align="center">
            <tbody>
                <tr>
                  <td height="35" colspan="3" align="left"> <strong>Pembahagian Pensyarah Mengikut Subjek</strong></td>
                </tr>
                 <tr>
                   <td width="30%" align="left">Kursus</td>
                   <td width="70%" height="35">
                       
                    <select name="course_id" id="course_id" onchange="show()" class="validate[required]">
                    <option value="">-</option>
                        <?php
                        foreach ($kursus as $course) {
                            echo "<option value='" . $course->kursus_id . "'>" .$course->kod_kursus. " - " . $course->kursus_kluster . "</option>";
                        }
                        ?>
                    </select>
                   </td>
                 </tr>
                 <tr>
            <td width="30%" align="right">Subjek</td>
                   <td width="70%" height="35">
                <select name="subject" id="subject" class="validate[required]">
                    <option value="">-</option>
                </select>
            </td>
        </tr>
                 <tr>
            <td width="30%" align="right">Sesi</td>
                   <td width="70%" height="35">
                       <select name="sesi" id="sesi" class="validate[required]" >
	                        <option value="">-</option>
	                    	<option value="2010">2010</option>
	                    	<option value="2011">2011</option>
	                    	<option value="2012">2012</option>
	                    	<option value="2013">2013</option>
                    </select>
            </td>
        </tr>
        <tr>
            <td width="30%" align="right">Semester</td>
                   <td width="70%" height="35">
                       <select name="semester" id="semester" onchange="showLecturer()" class="validate[required]" >
	                        <option value="">-</option>
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
		<!--<tr>
            <td width="30%" align="right">Markah Kursus</td>
                   <td width="70%" height="35">
                <input name="course_work" id="course_work" class="validate[required,custom[onlyNumberSp]] span1" />
            </td>
        </tr>
		<tr>
            <td width="30%" align="right">Peperiksaan Akhir</td>
                   <td width="70%" height="35">
                <input name="final" id="final" class="validate[required,custom[onlyNumberSp]] span1">
            </td>
        </tr> -->
        
        <tr>
            <td>Pensyarah</td>
            <td>
            <!-- <input type="text" class="txteditsubjek validate[required]" name="subjek" id="subjek" /> -->
            <div id="staffList">
                        <table class="table-striped table-bordered table-condensed">
                            <tr>
                                <td width="38%" style="vertical-align:top"><div style="font-size:14px">Carian Pensyarah
                                    <a id="searchStaff" style="margin-left:10px;" class="btn" href="javascript: void(0);" data-original-title="Carian Staff">
                               	 	<i class="icon-search"></i></a></div>                              
                               	</td>
                                
                            </tr>
                            <tr>
                              <td width="55%" style="vertical-align:top">
                                <input type="hidden" id="txtStaffList" name="txtStaffList" value="" />
                                <ul id="selStaffList" name="selStaffList">
                                </ul>                                </td>
                            </tr>
                        </table>
                  </div>
                </td>
        </tr>
                <tr>
                    <td colspan="2" style="text-align: center">  <input class="btn btn-info" type="submit" name="submit" id="submit" value="Simpan"> <input class="btn" type="reset" name="btn_reset" value="Reset">
                <br />
            </td>
            </tbody>        
      </table>
</form>
        </div><br />
        </center>
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
                <td colspan="2" >Cari Pensyarah<div align="left"><strong id="menutitle">&nbsp;&nbsp;&nbsp;Cari Pensyarah :&nbsp;&nbsp;</strong>
                  <input type="text" name="cStaff" id="cStaff" class="validate[required] span3"/>
                  <input type="submit" name="CarianStf" id="CarianStf" value="Cari" class="btn btn-primary"/>
                </div>                  </td>
          </tr>
          <tr>
          		<td colspan="2">
                	<table id="Hstaff" width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered">
                    	<thead>
                        <tr>
                        	<th style="border-bottom:1px solid #DDD;" width="20%">Nama Pertama</th>
                            <th style="border-bottom:1px solid #DDD;" width="40%">Nama Kedua</th>
                            <th style="border-bottom:1px solid #DDD;" width="30%">Email</th>
                            <th style="border-bottom:1px solid #DDD;" width="10%" align="center">&nbsp;</th>
                        </tr>
                        </thead> 
                        <tr>                  
                        <tbody></tbody>
                    	</tr>
                    </table>
                 </td>
          </tr>
          <tr>
          	<td width="15%">Pensyarah yang Dipilih</td>
            <td>
            <ul id="searchStaffList" name="searchStaffList">
            </ul>
            </td>
          </tr>
        </tbody>
      </table>
      <br />
      <br />

  </form>
  </div>  	
</div>

