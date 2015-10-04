<?php
$user_login = $this->ion_auth->user()->row();
$colid = $user_login->col_id;
$userId = $user_login->user_id;
$state_id= $user_login->state_id;

$user_groups = $this->ion_auth->get_users_groups($userId)->row();
$ul_type= $user_groups->ul_type;

$srcUsrPhoto = "data:image/jpg;base64,".$stu_photo;
?>
<legend>
<h3>Kemas Kini Murid</h3>
</legend>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/input_plugin.js"></script>
<script>
jQuery(function($) {
$("#no_kp").mask("999999-99-9999");
});

$("#myModalAddStudent").ready(function() {});
$(document).ready(function(){
$("#updateStudent").validationEngine({promptPosition : "bottomLeft", scroll: false});
$("#first-choice").bind("change",function() {
$("#second-choice").load("<?=site_url()?>/student/student_management/dropdown_data/" + $("#first-choice").val());
});
if($("#first-choice").length>0 && $("#first-choice").val() != "") {
$("#second-choice").load("<?=site_url()?>/student/student_management/dropdown_data/" + $("#first-choice").val());
}
});
</script>

<!--START Generate FROM UPDATE-->
<?php
foreach ($kv_list as $row) {
$option[$row -> col_id] = $row -> col_name;
}
$status[0] = "Berhenti";
$status[1] = "Aktif";
$hidden=array(
'cc_id'=>$cc_id,
'stu_id'=>$stu_id
);
?>
<?= form_open('student/student_management/update_student', array('class' => 'form-horizontal', 'id' => 'updateStudent','name'=>'updateStudent'),$hidden); ?>

<div class="container-fluid">
<div class="row-fluid">


<!-- END Span 6 -->
<div style="width:500px;border-right: 1px solid #E6E6E6; float:left;">

<div class="control-group">
<label class="control-label" for="nama">Nama Pelajar</label>
<div class="controls">
<?php
if($ul_type=="LP"){ 
echo form_input('nama', $nama, 'class="input-xlarge validate[required] text-input"');
}else{
if($editable==1){
echo form_input('nama', $nama, 'class="input-xlarge validate[required] text-input"');
}else{
echo form_input('nama', $nama, 'class="input-xlarge validate[required] text-input" disabled');
echo form_hidden('nama', $nama);
}
}
?>
</div>
</div>
<div class="control-group">
<label class="control-label" for="no_kp">No Kad Pengenalan</label>
<div class="controls">
<?php
if($ul_type=="LP"){ 
echo form_input('no_kp', $no_kp, 'class="input-xlarge validate[required] text-input"');
}else{
if($editable==1){
echo form_input('no_kp', $no_kp, 'class="input-xlarge validate[required] text-input"');
}else{
echo form_input('no_kp', $no_kp, 'class="input-xlarge validate[required] text-input" disabled');
echo form_hidden('no_kp', $no_kp);
}
}
?>
</div>
</div>
<div class="control-group">
<label class="control-label" for="jantina">Jantina</label>
<div class="controls">
<?php
$lelaki = array(
'name'        => 'jantina',
'id'          => 'jantina',
'value'       => 'lelaki',
'style'       => 'margin:10px',
'checked'	  => FALSE
);
$perempuan = array(
'name'        => 'jantina',
'id'          => 'jantina',
'value'       => 'perempuan',
'style'       => 'margin:10px',
'checked'	  => FALSE
);
if($ul_type=="LP"){
$lelakiH="<div style='padding-top:5px;'><input type='radio' name='jantina' value='Lelaki'";
$perempuanH="<div style='padding-top:5px;'><input type='radio' name='jantina' value='Perempuan'";

if($jantina=="LELAKI" || $jantina=="Lelaki"){
// $lelaki['checked']=TRUE;
// $lelaki['disabled']='disabled';
// $perempuan['disabled']='disabled';
$lelakiH.=" checked>&nbsp Lelaki</div>";
$perempuanH.=">&nbsp Perempuan</div>";
}elseif($jantina=="PEREMPUAN" || $jantina=="Perempuan"){
// $perempuan['checked']=TRUE;
// $perempuan['disabled']='disabled';
// $lelaki['disabled']='disabled';
$lelakiH.=" >&nbsp Lelaki</div>";
$perempuanH.=" checked>&nbsp Perempuan</div>";
}else{
$lelakiH.=" >&nbsp Lelaki</div>";
$perempuanH.=">&nbsp Perempuan</div>";
}
// echo form_radio($lelaki)." Lelaki ";
// echo form_radio($perempuan)." Perempuan";
echo $lelakiH;
echo $perempuanH;
}else{
$lelakiH="<div style='padding-top:5px;'><input type='radio' name='jantina' value='Lelaki'";
$perempuanH="<div style='padding-top:5px;'><input type='radio' name='jantina' value='Perempuan'";

if($editable==1){
if($jantina=="LELAKI" || $jantina=="Lelaki"){
$lelakiH.=" checked>&nbsp Lelaki</div>";
$perempuanH.=">&nbsp Perempuan</div>";
}elseif($jantina=="PEREMPUAN" || $jantina=="Perempuan"){
$lelakiH.=" >&nbsp Lelaki</div>";
$perempuanH.=" checked>&nbsp Perempuan</div>";
}else{
$lelakiH.=" >&nbsp Lelaki</div>";
$perempuanH.=">&nbsp Perempuan</div>";
}
echo $lelakiH;
echo $perempuanH;
}else{
if($jantina=="LELAKI" || $jantina=="Lelaki"){
$lelakiH.=" checked disabled>&nbsp Lelaki</div>";
$perempuanH.=" disabled>&nbsp Perempuan</div>";
}elseif($jantina=="PEREMPUAN" || $jantina=="Perempuan"){
$lelakiH.=" disabled>&nbsp Lelaki</div>";
$perempuanH.=" checked disabled>&nbsp Perempuan</div>";
}else{
$lelakiH.=" disabled>&nbsp Lelaki</div>";
$perempuanH.=" disabled>&nbsp Perempuan</div>";
}
echo $lelakiH;
echo $perempuanH;
}
}
?>
</div>
</div>
<div class="control-group">
<label class="control-label" for="bangsa">Bangsa</label>
<div class="controls">
<?php
echo form_input('bangsa', $bangsa, 'class="input-xlarge validate[required] text-input"');
?>
</div>
</div>
<div class="control-group">
<label class="control-label" for="agama">Agama</label>
<div class="controls">
<?php
echo form_input('agama', $agama, 'class="input-xlarge validate[required] text-input"');
?>
</div>
</div>
<div class="control-group">
<label class="control-label" for="group">Kelas</label>
<div class="controls">
<?php
if($ul_type=="LP"){
echo form_input('group', $group, 'class="input-mini validate[required] text-input" disabled');
}else{
if($editable==1){
echo form_input('group', $group, 'class="input-mini validate[required] text-input" disabled');
}else{
echo form_input('group', $group, 'class="input-mini validate[required] text-input" disabled');
echo form_hidden('group', $group);
}
}
?>
</div>
</div>
<div class="control-group">
<label class="control-label" for="semester">Semester :</label>
<div class="controls">
<?php if($ul_type=="LP"){ ?> 
<input type="number"  name="semester" max="10" min="1" class="input-mini validate[required] 
text-input" required="true" value="<?=$semester?>"/>
<?php }else{ 
if($editable==1){ ?>
<input type="number"  name="semester" max="10" min="1" class="input-mini validate[required] 
text-input" required="true" value="<?=$semester?>" />
<?php }else{ ?>
<input type="number"  name="semester" max="10" min="1" class="input-mini validate[required] 
text-input" required="true" value="<?=$semester?>" disabled />
<?php
}
echo form_hidden('semester', $semester); 
} 
?>
<br>
</div>
</div>
<div class="control-group">

<label class="control-label" for="kv">Kolej Vokasional :</label>
<div class="controls">
	<?php 
	$options = array();
	if($ul_type=="LP"){
		foreach ($kv_list as $row) {
			if($row -> col_id==$kv){
				$options[$row->col_id]=$row->col_name;
			}
			$options[$row->col_id]=$row->col_name;
		}
		echo form_dropdown('kv', $options, $kv,'disabled');
		echo form_hidden('kv', $kv);
	}else{
		foreach ($kv_list as $row) {
			if($row -> col_id==$kv){
				$options[$row->col_id]=$row->col_name;
			}
			$option[$row->col_id]=$row->col_name;
		}
		if($editable==1){
			echo form_dropdown('kv', $options, $kv);
		}else{
			echo form_dropdown('kv', $options, $kv,'disabled');
			echo form_hidden('kv', $kv);
		}
	}
	?>
</div>
</div>
<div class="control-group">
<label class="control-label" for="second-choice">Kursus :</label>
<div class="controls">
<?php
$options = array();
if($ul_type=="LP"){
foreach ($list_course as $row) {
if($row -> cou_id==$kursus_id){
$options[$row->cc_id]=$row->cou_name;
}
$options[$row->cc_id]=$row->cou_name;
}
echo form_dropdown('kursus', $options, $cc_id,'disabled');
echo form_hidden('kursus', $kursus_id);
}else{
foreach ($list_course as $row) {
if($row -> cou_id==$kursus_id){
$options[$row->cc_id]=$row->cou_name;
}
$options[$row->cc_id]=$row->cou_name;
}
if($editable==1){
echo form_dropdown('kursus', $options, $cc_id);
}else{
echo form_dropdown('kursus', $options, $cc_id,'disabled');
echo form_hidden('kursus', $kursus_id);
}
}
?>
</div>
</div>
<div class="control-group">
<label class="control-label" for="status">Status :</label>
<div class="controls">
<?php
$aktif = array(
'name'        => 'status',
'id'          => 'status',
'value'       => 'aktif',
'style'       => 'margin:10px',
'checked'     => FALSE
);
$takaktif = array(
'name'        => 'status',
'id'          => 'status',
'value'       => 'takaktif',
'style'       => 'margin:10px',
'checked'     => FALSE
);
if($ul_type=="LP"){
$aktifH="<div style='padding-top:5px;'><input type='radio' name='status' value='1'";
$takaktifH="<div style='padding-top:5px;'><input type='radio' name='status' value='0'";

if($stat_id==1){
// $aktif['checked']=TRUE;
$aktifH.=" checked>&nbsp Aktif</div>";
$takaktifH.=">&nbsp Tak Aktif</div>";
}elseif($stat_id==0){
// $takaktif['checked']=TRUE;
$aktifH.=">&nbsp Aktif</div>";
$takaktifH.=" checked>&nbsp Tak Aktif</div>";
}else{
$aktifH.=">&nbsp Aktif</div>";
$takaktifH.=">&nbsp Tak Aktif</div>";
}
// echo form_radio($aktif)." Aktif";
// echo form_radio($takaktif)." Tak Aktif";
echo $aktifH;
echo $takaktifH;
}else{
$aktifH="<div style='padding-top:5px;'><input type='radio' name='status' value='1'";
$takaktifH="<div style='padding-top:5px;'><input type='radio' name='status' value='0'";

if($stat_id==1){
// $aktif['checked']=TRUE;
$aktifH.=" checked>&nbsp Aktif</div>";
$takaktifH.=">&nbsp Tak Aktif</div>";
}elseif($stat_id==0){
// $takaktif['checked']=TRUE;
$aktifH.=">&nbsp Aktif</div>";
$takaktifH.=" checked>&nbsp Tak Aktif</div>";
}else{
$aktifH.=">&nbsp Aktif</div>";
$takaktifH.=">&nbsp Tak Aktif</div>";
}
// echo form_radio($aktif)." Aktif";
// echo form_radio($takaktif)." Tak Aktif";
echo $aktifH;
echo $takaktifH;
}
?>
</div>
</div>
<div class="control-group">
<div class="controls">
<button type="submit" class="btn btn-info">
Simpan
</button>
</div>
</div>

</div>
<!-- END Span 6 -->


<!-- END Span 6 -->
<?php if(!empty($stu_photo)){ ?>
&nbsp;&nbsp;&nbsp;<img src="<?=$srcUsrPhoto?>" class="img-polaroid">
<?php } ?>

<!-- END Span 6 -->


</div>
</div>


<?=form_close(); ?>
<!--END Generate FROM UPDATE-->
