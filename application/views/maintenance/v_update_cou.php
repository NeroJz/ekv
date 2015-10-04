<legend>
	<strong>Kemaskini Kod</strong>
</legend>
<?php
$hidden = array('id'=>$primary_key);
$form_properties = array('class'=>'form-horizontal');
echo form_open(site_url().'/maintenance/update_cou/update',$form_properties,$hidden);
?>
	<div class="control-group">
		<label class="control-label" for="inputKod">Kod</label>
		<div class="controls">
			<?php
			$data = array(
						'id'=>'inputKod',
						'name'=>'kod',
						'value'=>$cou_code,
						'placeholder'=>'Kod'
					);
			echo form_input($data);
			?>
		</div>
	</div>
	<div class="control-group">
		<label class="control-label" for="inputKod">Kod Kursus</label>
		<div class="controls">
			<?php
			$data = array(
						'id'=>'inputKod',
						'name'=>'kod_kursus',
						'value'=>$cou_course_code,
						'placeholder'=>'Kod Kursus'
					);
			echo form_input($data);
			?>
		</div>
	</div>
	<div class="control-group">
		<div class="controls">
			<?php
			?>
			<input type="hidden" name="id" value="<?=$primary_key;?>">
			<?php
			$data = array(
						'type'=>'submit',
						'class'=>'btn',
						'content'=>'Simpan'
					);
			echo form_button($data);
			?>
		</div>
	</div>
<?=form_close();?>