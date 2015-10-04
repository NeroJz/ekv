<script type="text/javascript">


    function show()
    {
    	
        var cid = document.form1.course_id.value;
        var session = document.form1.sesi.value;
        session = session.replace(" ","_");
        session = session.replace("/","-");
        var url = '<?php echo site_url('academic/subjectlist');?>/'+cid+'/'+session;
        
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
            	//console.log(data);
                for(var i = 0; i < data.length; i++){
                    document.form1.subject.options[i+1] = new Option(data[i].subject_code+' - '+data[i].subject_name,data[i].subject_id,false,false);
                } // End of success function of ajax form
            }
        }
            
        }); // End of ajax call 
        
    }
 
function showLecturer(){
		
        var subjectids = document.form1.subject.value;
        var courseids = document.form1.course_id.value;
        var sessions = document.form1.sesi.value;
        sessions = sessions.replace(" ","_");
        sessions = sessions.replace("/","-");
        var url2 = '<?php echo site_url('academic/get_lecturer');?>/'+courseids+'/'+subjectids+'/'+sessions;
        
        $.ajax({
        url: url2,
        type:'POST',
        dataType: 'json',
        success: function(data){
        	//document.form1.selectto.options.length=0;
        	$('#select-to').html("");
            document.form1.ssg_id.options.length=0;
            //$('#subject').html("");
            document.form1.ssg_id.options[0] = new Option('-','',false,false);
            if(data != null){
            	//console.log(data);
                for(var i = 0; i < data.length; i++){
                    document.form1.ssg_id.options[i+1] = new Option(data[i].staff_name+' (Kumpulan '+data[i].level_group_no+')',data[i].staff_subject_group_id,false,false);
                } // End of success function of ajax form
            }
        }
            
        }); // End of ajax call 
            
        
    }
</script>

<script type="text/javascript">
 
$(document).ready(function() {
		
		$("#form1").validationEngine();
		
		$(function() {
			$( "#schedule_date").datepicker({
	            dateFormat:"dd-mm-yy",
	            changeMonth : true,
	            changeYear : true
			});
			
			$('#schedule_time').timepicker();
		
    	});
		
    } );
</script>

<style>
	
	.bblue, .dblue{font-weight:bold; color:blue;}
	.ddark{font-weight:bold; color:inherit;}
	.dgreen{font-weight:bold; color:green;}
</style>
<script src="<?=base_url()?>assets/scripts/kuim.msg.modal.js" type="text/javascript"></script>
<script>
var base_url = '<?=base_url();?>';
var site_url = '<?=site_url();?>/';

</script>

<center>
    <div class="alert alert-info" align="center" style="width:70%; margin:auto;">
    <form id="form1" name="form1" action="<?=site_url('examination/exam_schedule/add_exam_schedule') ?>" method="post">
     <table id="group" class="table table-bordered table-striped" width="100%" align="center">
            <tbody>
                 <tr>
                   <td width="30%" align="left">Kursus</td>
                   <td width="70%" height="35">
                       
                    <select name="course_id" id="course_id" onchange="show()" class="validate[required]">
                    <option value="">-</option>
                       <?php
                        foreach ($courses as $course) 
                        {
                            echo "<option value='" . $course->cou_id . "'>" . ucwords(strtolower($course->cou_name)) . "</option>";
                        }
                        ?>
                       ?>
                    </select>
                   </td>
                 </tr>
                 
                 <tr>
            <td width="30%" align="right">Sesi</td>
                   <td width="70%" height="35">
                   	<input type="hidden" id="sesi" name="sesi" value="<?=$sesi ?>" />
                   	<?php
                      echo $sesi;
					  ?>
            </td>
        </tr>
        <tr>
            <td width="30%" align="right">Subjek</td>
                   <td width="70%" height="35">
                <select name="subject" id="subject" onchange="showLecturer()" class="validate[required]">
                    <option value="">-</option>
                </select>
            </td>
        </tr>
        <tr>
            <td width="30%" align="right">Pensyarah</td>
                   <td width="70%" height="35">
                <select name="ssg_id" id="ssg_id" class="validate[required]">
                    <option value="">-</option>
                </select>
            </td>
        </tr>
        <tr>
            <td width="30%" align="right">Tarikh</td>
                   <td width="70%" height="35">
                   <input type="text" name="schedule_date" id="schedule_date" class="validate[required]" />
            </td>
        </tr>
        <tr>
            <td width="30%" align="right">Masa</td>
                   <td width="70%" height="35">
	                   <div class="input-append bootstrap-timepicker">
				            <input type="text" id="schedule_time" name="schedule_time" class="input-small" >
				            <span class="add-on"><i class="icon-time"></i></span>
				        </div>
                   </td>
        </tr>
        <tr>
            <td width="30%" align="right">Tempat Peperiksaan</td>
                   <td width="70%" height="35">
                <select name="hall_id" id="hall_id" class="validate[required]">
                    <option value="">-</option>
                    <?php
                    foreach($exam_hall as $eh)
					{
						?>
						<option value="<?=$eh->hall_id ?>"><?=$eh->hall_name ?></option>
						<?php	
					}
                    ?>
                </select>
            </td>
        </tr>
        <tr>
        	<td colspan="2" style="text-align: center">  <input class="btn btn-info" type="submit" name="submit" id="submit" value="Simpan"> <input class="btn" type="reset" name="btn_reset" value="Reset"></td>
        </tr>
            </tbody>        
      </table>
	</form>
	</div>
</center>