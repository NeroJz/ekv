<?php if(isset($module) && !isset($get_data)){ ?>
<select name="mod_id" id="mod_id" class="validate[required]">
    	<option value="">-- Sila Pilih --</option>
    	<?php 
    		foreach ($module as $row) 
    		{
    	?>
    			<option value="<?=$row->mod_id ?>">
    				<?= strtoupper($row->mod_paper).'  - '.ucwords ( strtolower ( $row->mod_name ) ) ?>
    			</option>
			
		<?php	
			}
		?>
</select>	

<?php }

elseif(!isset($module) && !isset($get_data)){ ?>

<select name="mod_id" id="mod_id" class="validate[required]">
    	<option value="">-- Sila Pilih --</option>
</select>	
<?php }

if(isset($exam_schedule_rasmi) && isset($get_data)){

		$data = array(
				'exam_schedule' => $exam_schedule_rasmi
		);
		
		echo(json_encode($data));
	
		}?>