<?php
if(isset($module_detail))
{
	$data = array(
		'module_detail' => $module_detail
	);
	echo(json_encode($data));
}
else
{
?>

<script>
	$(document).ready(function(){
		<?php 
		//this function will populate semester, and student list for that particular subject 
		//thought by the lecturer 
		//the process is done through ajax processing
		?>
		
		
	});
		
</script>
<select name="mdl" id="mdl" class="span5">
<option value="-1">-- Sila Pilih --</option>
<?php

					
foreach ($module_list as $row) {
	
	if($row->mod_paper_one == null)
	{
		
	
	//if($row->mod_paper_one =! null)
	//{											
	    $avData;
	    $this->m_weightage->modul_paper_ak($avData,$aOpt='',$row->mod_id);
	//}
?> 
	<option value="<?= $row->mod_id.':'.$row->mod_code.':'.$avData ?>">
	<?= strtoupper($row->mod_paper)." - ".ucwords(strtolower($row->mod_name)) ?>
	</option>
<?php 
	}
	
	$avData = null;
} ?>
</select>
<?php
	
}
?>