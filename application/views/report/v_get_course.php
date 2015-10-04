<?php if(isset($course)){ ?>
<select id="slct_kursus" name="slct_kursus" style="width:270px;">
            <option value="">-- Sila Pilih --</option>
           <?php			
				foreach ($course as $row)
				{
			?>
					<option value="<?= $row->cou_id ?>">
					    <?= strtoupper($row->cou_course_code).'  - '.ucwords($row->cou_name)  ?>
                    </option>
		    <?php 
				} 
			?>
</select>

<?php }else{ ?>
<select width="50%" name="modul" id="modul" style="width:270px;" class="validate[required]">
    	<option value="">-- Sila Pilih --</option>
    	<?php 
    		foreach ($module as $row) 
    		{
    	?>
    			<option value="<?=$row->mod_code ?>">
    				<?= strtoupper($row->mod_paper).'  - '.ucwords(strtolower($row->mod_name )) ?>
    			</option>
			
		<?php	
			}
		?>
</select>	

<?php } ?>
