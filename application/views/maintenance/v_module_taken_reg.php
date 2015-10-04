<style>
.dgreen{font-weight:bold; color:green;}

</style>

<script src="<?=base_url()?>assets/js/maintenance/kv.module_taken.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){

    $('#checkall').on('click', function () {
    	
         $("INPUT[type='checkbox']").attr('checked', $('#checkall').is(':checked'));    
    });

});

</script>
<legend>
	<h3>Modul Murid</h3>
	

</legend>

<table width="95%" border="0" cellpadding="0" cellspacing="0" style="margin-top:2px;" class="table table-striped table-bordered table-condensed">
  
<tr>
<td width="20%"><b>Nama</b></td>
<td width="10px"><b>:</b></td>
<td><?=strcap($student-> stu_name) ?></td>
</tr>
 <tr>
<td><b>Angka Giliran</b></td>
<td width="10px"><b>:</b></td>
<td><?=strtoupper($student -> stu_matric_no) ?></td>
</tr>
<tr>
<td><b>Kursus</b></td>
<td width="10px"><b>:</b></td>
<td><?=strcap($student -> cou_name) ?></td>
</tr>
<tr>
<td><b>Kolej</b></td>
<td width="10px"><b>:</b></td>
<td><?=strcap($student -> col_name) ?></td>
</tr>
<tr>
<td><b>Semester</b></td>
<td width="10px"><b>:</b></td>
<td><?=strcap($student -> stu_current_sem) ?></td>
</tr>
<tr>
<td><b>Tahun</b></td>
<td width="10px"><b>:</b></td>
<td><?=strcap($student -> stu_current_year) ?></td>
</tr>

  </table>
  
  
 <?php 
 $arr_mod = array();
 $arr_cm=array();
 ?>
  <h4>Modul didaftarkan</h4>
   <table width="95%" border="0" cellpadding="0" cellspacing="0" style="margin-top:2px;" class="table table-striped table-bordered table-condensed">
		<tr style="font-weight: bold;">
			<td><b>Kod</b></td>
			<td><b>Modul</b></td>
			<td style="text-align: center;"><b>Jam Kredit</b></td>
			
			<td style="text-align: center;"><b>Semester</b></td>
			<td style="text-align: center;"><b>Status</b></td>
			
		</tr>
 <?php
 //print_r($module_taken);
// print_r($course_module);
 
 if(!empty($module_taken)){  
 	
 	
// print_r($module_taken);
 foreach($module_taken as $row)
 {
 	array_push($arr_mod, $row->mod_id);
 	echo "<tr>";
 	echo "<td>$row->mod_paper</td>";
	echo "<td> ".strcap($row->mod_name) ."</td>";
	echo "<td>$row->mod_credit_hour</td>";
	echo "<td>$row->mod_sem</td>";
	echo "<td class='dgreen'>Telah Daftar</td>";
 	echo "<tr>";
 }
 
 
 
 
 }
 
 else
		{
			echo "<tr>";
			echo "<td colspan='5'>";
			echo "<i><span style='color:red'/>Tiada Maklumat</span></i>";
			echo "</td></tr>";
		}
		
 echo "</table>";
 
 echo " <h4>Modul belum didaftarkan</h4>";
 if(!empty($course_module)){
 	
		?>
		<form id="form_module">
		<table width="95%" border="0" cellpadding="0" cellspacing="0" style="margin-top:2px;" class="table table-striped table-bordered table-condensed">
		<tr style="font-weight: bold;">
			<td><b>Kod</b></td>
			<td><b>Modul</b></td>
			<td style="text-align: center;"><b>Jam Kredit</b></td>
			
			<td style="text-align: center;"><b>Semester</b></td>
			<td style="text-align: center;"><input type="checkbox" id="checkall" class="checkall">&nbsp;<b>Pilih Semua</b></a></td>
			
			
		</tr>
		<input type="hidden" name="student" value="<?=$student -> stu_id?>"/>
		<input type="hidden" name="semester" value="<?=$student -> stu_current_sem?>"/>
		
		<?php
		//count module_course
		$count=0;
		foreach($course_module as $mod)
		{
			if(!in_array($mod->mod_id, $arr_mod))
			{
				$count++;
			}
		}
		foreach($course_module as $mod)
		{
			
			if(!in_array($mod->mod_id, $arr_mod))
			{
			$m_data = 1;
			echo "<tr>";
			echo "<td><center>$mod->mod_paper</center></td>";
			echo "<td>".strcap($mod->mod_name)."</td>";
			echo "<td><center>$mod->mod_credit_hour</center></td>";
			echo "<td><center>$mod->mod_sem</center></td>";
			echo "<td><center><input class='validate[minCheckbox[$count]] checkbox' id='module' type='checkbox' name='module[]' value='$mod->mod_id'></center></td>";
			echo "</tr>";
			}
			
		}
		
		if(!isset($m_data))
		{
			echo "<tr>";
			echo "<td colspan='5'>";
			echo "<i><span style='color:red'/>Tiada Maklumat</span></i>";
			echo "</td></tr>";
		}
		
		
		echo "</table>";
		
	if(isset($m_data)){
				echo "<input class='btn btn-info' type='button' id='btn_reg_module' name='btn_reg_module' style='width:10%' value='Daftar'>";
		
		}
		echo "</form>";

 } 
 
 ?>
 
 
