<legend><h3>Pilih Kursus</h3></legend>
<?=form_open('student/student_management/add_student','',$hidden)?>
<?=$kv_name;?> menawarkan kursus yang berikut:<br>
<select name="course">
<?php
if($list_course!=null){
	foreach ($list_course as $row){
		echo "<option value=".$row->cou_id.">".$row->cou_name."</option>";
	}
}else{
	echo "<option>Tiada data</option>";
}
?>
</select>
<br><input type='submit' value='Simpan' class='btn btn-primary'>
<?=form_close();?>