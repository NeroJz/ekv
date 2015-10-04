
 
 
<!--<link href="<?=base_url()?>assets/css/jquery-

ui.css" rel="stylesheet" />-->

<!--<script src="<?=base_url()?>assets/js/jquery.min.js"></script>-->
<!--<script src="<?=base_url()?>assets/js/jquery-

ui.min.js"></script>-->
<!--<script src="<?=base_url()?>assets/js/jquery.ui.timepicker.js"></script>-->
 



<style>
	
	.bblue, .dblue{font-weight:bold; color:blue;}
	.ddark{font-weight:bold; color:inherit;}
	.dgreen{font-weight:bold; color:green;}
</style>
<script src="<?=base_url()?>assets/js/kv.msg.modal.js" 

type="text/javascript"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/bootstrap-timepicker.js"></script>
<link href="<?=base_url()?>assets/css/bootstrap-

timepicker.css" rel="stylesheet" />
<script>
 
var base_url = '<?=base_url();?>';
var site_url = '<?=site_url();?>/';

</script>
<h3><?= $headline ?></h3><hr/>
<center>
    <div align="center" style="width:100%; margin:auto;">
   <form id="form1" name="form1" action="<?=site_url('examination/exam_schedule/print_exam_schedule_kv')?>" method="post" class="form-inline" target="_blank">
     <table id="group" class="breadcrumb border" width="100%" align="center">
       <tr>
       	
       	<td colspan="3" height="35">&nbsp;</td>
      	</tr>
      		<tr>
				<td width="57%" height="35" align="center">&nbsp;&nbsp;&nbsp;&nbsp;Kursus &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; : &nbsp;
				<select name="cou_id" id="cou_id" class="validate[required]">
				<option value="">--Sila Pilih--</option>
				<?php
				foreach ( $courses as $course ) {
					echo "<option value='" . $course->cou_id . "'>".$course->cou_course_code." - ". ucwords( strtolower ( $course->cou_name )) . "</option>";
						}
					?>
                  </select>
                 </td>
			</tr>
        
        <tr>
			
            <td width="57%" height="35" align="center">&nbsp;&nbsp;&nbsp; Semester &nbsp; : &nbsp;
	        	<select class="validate[required]" name="semester" id="semester" >
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
    		<td>
    			</br>
    		</td>
    	</tr>           
        <tr>
        
        	<td align="center">
        		<input class="btn btn-info" type="submit" name="submit" id="submit" value="Papar">
        	</td>
		</tr>
		 <tr>
        	<td>
        		&nbsp;
        	</td>
		</tr>
	</table>
</form>
</div>
</center>