
<style>

#tajuk {

color :red;

}

</style>

<style>

#setup {

color :blue;

}

</style>


<?php
	$this->set_css($this->default_theme_path.'/flexigrid/css/flexigrid.css');
	$this->set_css('assets/css/validationEngine.jquery.css');
	$this->set_js_lib($this->default_theme_path.'/flexigrid/js/jquery.form.js');
	$this->set_js_config($this->default_theme_path.'/flexigrid/js/flexigrid-add.js');

	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/jquery.noty.js');
	$this->set_js_lib($this->default_javascript_path.'/jquery_plugins/config/jquery.noty.config.js');
	
	$this->obj =& get_instance();
	$checkController = $this->obj->uri->segment(2);
	
	if($checkController == "user"){
?>
<script type="text/javascript">
$(document).ready(function() 
{
	function noimage(image) {
		image.onerror = "";
		image.src = "img/user.png";
		return true;
	} 
});
</script>
<!--  <object id="MyKadAllActiveXControl" classid="CLSID:1F01E54C-AAD2-4A1E-990B-91D96927F189" codebase="MyKadAllActiveX.CAB#version=1,0,0,10" style="display: none;"></object>-->
<table class="table table-bordered">
      <thead>
        <tr>
          <th id="tajuk">PERHATIAN!</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>
          	<p>	
        <?php
        	 $baseurl = base_url()."caroot.crt";
        	 $servicesUrl = base_url()."setup.msi";
        ?>
				 Aplikasi Web ini membolehkan anda untuk mengakses dan membaca data yang disimpan di dalam chip MyKad (dan MyKid) anda. Ia menggunakan teknologi
				 yang membolehkan anda untuk berinteraksi dengan peranti seperti Pembaca Kad Pintar, Pengimbas dan lain-lain. 
				 <a id="setup" href="<?php echo $baseurl?>">Certification</a> | <a id="setup" href="<?php echo $servicesUrl?>">Setup Reader</a>
		 	</p>
	 	</td>
        </tr>
        <tr>
        	<td>
        		<?php /* ?><button class="btn btn-primary" onclick="CallMyKad(MyKadAllActiveXControl)" type="button">Baca MyKad</button> <?php // */?>
        		<applet name="mykad" code="MyKadForm.class" ARCHIVE="<?=base_url()?>MyKadDemo.jar" width=400 height=120>
				</applet>
        	</td>
        </tr>
      </tbody>
    </table>

<?php } ?>


<script type="text/javascript" src="<?=base_url()?>assets/js/mykad_staff.js"></script>
<script language="javascript" type="text/javascript" >

	$(document).ready(function()
	{	
		$("#crudForm").validationEngine('attach', {scroll: false});
		
	});
	
</script>

<div class="flexigrid crud-form" style='width: 100%;' data-unique-hash="<?php echo $unique_hash; ?>">
	<div class="mDiv">
		<div class="ftitle">
			<div class='ftitle-left'>
				<?php /*echo $this->l('form_add'); ?> <?php echo $subject?> <?php if($checkController == "user"){ ?><button class="btn btn-primary" onclick="CallMyKad(MyKadAllActiveXControl)" type="button">Baca MyKad</button>
				<?php } */?>
			</div>
			<div class='clear'></div>
		</div>
		<div title="<?php echo $this->l('minimize_maximize');?>" class="ptogtitle">
			<span></span>
		</div>
	</div>
<div id='main-table-box'>
	<?php echo form_open( $insert_url, 'method="post" id="crudForm" autocomplete="off" enctype="multipart/form-data"'); ?>
		<div class='form-div'>
		<?php if($checkController == "user"){ ?>
			<div class='form-field-box even' id="photo_field_box">
				<div class='form-display-as-box' id="photo_display_as_box">
					Gambar :
				</div>
				<div class='form-input-box' id="photo_input_box">
					<img style="margin-left: 25px;" src="" id="photo" onerror="javascript: noimage(this);">
				</div>
				<div class='clear'></div>
			</div>
		<?php } ?>
			<?php
			$counter = 0;
				foreach($fields as $field)
				{
					$even_odd = $counter % 2 == 0 ? 'odd' : 'even';
					$counter++;
			?>
			<div class='form-field-box <?php echo $even_odd?>' id="<?php echo $field->field_name; ?>_field_box">
				<div class='form-display-as-box' id="<?php echo $field->field_name; ?>_display_as_box">
					<?php echo $input_fields[$field->field_name]->display_as; ?><?php echo ($input_fields[$field->field_name]->required)? "<span class='required'>*</span> " : ""; ?> :
				</div>
				<div class='form-input-box' id="<?php echo $field->field_name; ?>_input_box">
					<?php echo $input_fields[$field->field_name]->input?>
				</div>
				<div class='clear'></div>
			</div>
			<?php }?>
			<!-- Start of hidden inputs -->
				<?php
					foreach($hidden_fields as $hidden_field){
						echo $hidden_field->input;
					}
				?>
			<!-- End of hidden inputs -->
			<?php if ($is_ajax) { ?><input type="hidden" name="is_ajax" value="true" /><?php }?>

			<div id='report-error' class='report-div error'></div>
			<div id='report-success' class='report-div success'></div>
		</div>
		<div class="pDiv">
			<div class='form-button-box'>
				<input id="form-button-save" type='submit' value='<?php echo $this->l('form_save'); ?>'  class="btn btn-large"/>
			</div>
<?php 	if(!$this->unset_back_to_list) { ?>
			<div class='form-button-box'>
				<input type='button' value='<?php echo $this->l('form_save_and_go_back'); ?>' id="save-and-go-back-button"  class="btn btn-large"/>
			</div>
			<div class='form-button-box'>
				<input type='button' value='<?php echo $this->l('form_cancel'); ?>' class="btn btn-large" id="cancel-button" />
			</div>
<?php 	} ?>
			<div class='form-button-box'>
				<div class='small-loading' id='FormLoading'><?php echo $this->l('form_insert_loading'); ?></div>
			</div>
			<div class='clear'></div>
		</div>
	<?php echo form_close(); ?>
</div>
</div>
<script>
	var validation_url = '<?php echo $validation_url?>';
	var list_url = '<?php echo $list_url?>';

	var message_alert_add_form = "<?php echo $this->l('alert_add_form')?>";
	var message_insert_error = "<?php echo $this->l('insert_error')?>";
</script>