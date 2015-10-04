<div class="block" id="paragraphs">
<script type="text/javascript">
	var templates = new Array(0);
	var examples = new Array(0);
	var x;
	
	function reset_reset()
	{
		templates = new Array(0);
		examples = new Array(0);
		
		jQuery("#metafield").empty();
		jQuery("#txtTemplate").val('');
		jQuery("#lblExample").text("Example: ");
		jQuery("#metafield").css('border', '1px solid #CCCCCC');
		x.resetForm();
		
		var inputs = jQuery("#client-add :input");
		
		for (var i = 0; i < inputs.length; i++)
		{
			var input = jQuery(inputs[i]);
			var temp = input.qtip('api');
			
			if (temp)
			{
				temp.destroy();
				input.removeAttr('title');
			}
		}
	}
	
	function fill(name, example)
	{
		templates.push(name);
		examples.push(example);
		
		var id = templates.length;
		var template = "";
		var sample = "";
		
		jQuery("#metafield").append('<span class="metabutton" id="opt' + (id - 1) + '">' + name.replace('<', '&lt;').replace('>', '&gt;') + ' <a onclick="discard(' + (id - 1) + ')" class="btn" title="Click to delete">&times;</a></span> ');
		
		for (var i = 0; i < id; i++)
		{
			if (templates[i] != '')
				template += templates[i] + "<divider>";
				
			if (examples[i] != '')
				sample += examples[i];
		}
		
		jQuery("#txtTemplate").val(template);
		jQuery("#lblExample").text("Example: " + sample);
	}
	
	function discard(id)
	{
		var count = 0;
		var template = "";
		var sample = "";
		templates[id] = '';
		examples[id] = '';
		
		for (var i = 0; i < templates.length; i++)
		{
			if (templates[i] == '')
				count++;
			else
			{
				template += templates[i] + "<divider>";
				sample += examples[i];
			}
		}
		
		jQuery("#opt" + id).remove();
		jQuery("#txtTemplate").val(template);
		jQuery("#lblExample").text("Example: " + sample);
		
		if (count == templates.length)
		{
			templates = new Array(0);
			examples = new Array(0);
			
			jQuery('#txtTemplate').val('');
			jQuery("#lblExample").text("Example: ");
		}
	}
	
	function validate_meta()
	{
		if (jQuery("#txtTemplate").val() == "")
		{
			jQuery("#metafield").css('border', '1px solid red');
			jQuery("#metafield").attr('title', 'This field is required.');
			
			jQuery("#metafield").qtip({
				position: {
					my: 'left center',
					at: 'right center'
				},
				style: {classes: 'ui-tooltip-red'}
			});
		}
		else
		{
			var temp = jQuery("#metafield").qtip('api');
			
			jQuery("#metafield").removeAttr('title');
			
			if (temp)
				temp.destroy();
		}
	}
	
	function addOption()
	{
		var options = jQuery('input[name=rdOptions]:checked').val();
		var character_case = jQuery('input[name=rdCharacterCase]:checked').val();
		var option = "", id = "";
		
		if (options == "rdSeparator")
			option = jQuery("#cmbSeparator option:selected").val();
		else if (options == "rdStatic")
			option = jQuery("#txtStatic").val();
		else if (options == "rdDynamic")
		{
			option = jQuery("#cmbDynamic option:selected").text();
			id = jQuery("#cmbDynamic option:selected").attr("id");
		}
		
		if (options != "rdSeparator")
		{
			var dynamic = "";
			var example = "";
			
			if (character_case == "UPPERCASE")
			{
				if (options == "rdDynamic")
				{
					dynamic = ("&lt;" + option + "&gt;").toUpperCase();
					example = id.toUpperCase();
				}
				else
				{
					dynamic = option.toUpperCase();
					example = dynamic;
				}
			}
			else if (character_case == "lowercase")
			{
				if (options == "rdDynamic")
				{
					dynamic = ("&lt;" + option + "&gt;").toLowerCase();
					example = id.toLowerCase();
				}
				else
				{
					dynamic = option.toLowerCase();
					example = dynamic;
				}
			}
			else if (character_case == "TitleCase")
			{
				var coba = option.toLowerCase();
				var split = coba.split(" ");
				option = "";
				
				for (var i = 0; i < split.length; i++)
				{
					var t = split[i].charAt(0).toUpperCase();
					option += t + split[i].substring(1);
					
					if (i != split.length - 1)
						option += " ";
				}
				
				coba = id.toLowerCase();
				split = coba.split(" ");
				id = "";
				
				for (var i = 0; i < split.length; i++)
				{
					var t = split[i].charAt(0).toUpperCase();
					id += t + split[i].substring(1);
					
					if (i != split.length - 1)
						id += " ";
				}
				
				if (options == "rdDynamic")
				{
					dynamic = "&lt;" + option + "&gt;";
					example = id;
				}
				else
				{
					dynamic = option;
					example = option;
				}
			}
			
			if (dynamic != '' && example != '')
				fill(dynamic, example);
		}
		else
			fill(option, option);
		
		var meta = jQuery("#metafield");
		var temp = meta.qtip('api');
		
		x.resetForm();
		meta.css('border', '1px solid #CCCCCC');
		
		if (temp)
		{
			temp.destroy();
			meta.removeAttr('title');
		}
	}
	
	function grabfocus(options)
	{
		if (options == "rdSeparator")
		{
			jQuery("#cmbSeparator").removeAttr('disabled');
			jQuery("#txtStatic").attr('disabled', 'true');
			jQuery("#cmbDynamic").attr('disabled', 'true');
			jQuery("#txtStatic").attr('disabled', 'true');
			jQuery("#cmbDynamic").attr('disabled', 'true');
			jQuery("#rdCharacterCase_0").attr('disabled', 'true');
			jQuery("#rdCharacterCase_1").attr('disabled', 'true');
			jQuery("#rdCharacterCase_2").attr('disabled', 'true');
			jQuery("#rdCharacterCase_0").prop('checked', false);
			jQuery("#rdCharacterCase_1").prop('checked', false);
			jQuery("#rdCharacterCase_2").prop('checked', false);
		}
		else if (options == "rdStatic")
		{
			jQuery("#cmbSeparator").attr('disabled', 'true');
			jQuery("#txtStatic").removeAttr('disabled');
			jQuery("#cmbDynamic").attr('disabled', 'true');
			jQuery("#rdCharacterCase_0").removeAttr('disabled');
			jQuery("#rdCharacterCase_1").removeAttr('disabled');
			jQuery("#rdCharacterCase_2").removeAttr('disabled');
		}
		else if (options == "rdDynamic")
		{
			jQuery("#cmbSeparator").attr('disabled', 'true');
			jQuery("#txtStatic").attr('disabled', 'true');
			jQuery("#cmbDynamic").removeAttr('disabled');
			jQuery("#rdCharacterCase_0").removeAttr('disabled');
			jQuery("#rdCharacterCase_1").removeAttr('disabled');
			jQuery("#rdCharacterCase_2").removeAttr('disabled');
		}
		
		jQuery("#cmbSeparator").val(0);
		jQuery("#txtStatic").val('');
		jQuery("#cmbDynamic").val(0);
	}
	
	jQuery(document).ready(function(){
		x = jQuery("#setting-naming_convention").validate({
    		rules: {
	  			txtTemplate: {required: true, maxlength: 300},
    		},
  		});
	});
	

</script>
		<form method="POST" id="setting-naming_convention">
			<fieldset>
				<legend>Template Angka Giliran</legend>
                <table id="tablecontent" class="breadcrumb border" width="100%">
	                <!--<tr>
     	               <td colspan="3"><h6>Please fill up one of following fields and choice to set naming template</h6></td>
                    </tr>-->
	                <tr>
     	               <td colspan="3"><p style="padding: 5px;">Nama Pilihan Entiti :</p></td>
                    </tr>
                                    <tr>
<!--                                        <td><div align="right">Name Entity Options</div></td>
                                      	<td><div align="center">:
											<script type="text/javascript">
    
                                            </script>
                                            </div>
                                      	</td>-->
                                        <td>
                                            <table width="80%" cellpadding="0" cellspacing="0" style="margin:0 auto;">
                                            <tr>
                                            <td rowspan="4" width="10%">&nbsp;
                                            </td>
                                                <td width="30%" id="th1" style="padding-left: 16px;">Separator 
                                                </td><td rowspan="4" style="border-left: 1px solid rgb(197, 197, 197); width: 6%;">&nbsp;</td>
                                                <td width="30%" id="th2" style="padding-left: 16px;">Static Field 
                                                </td>
                                                <td rowspan="4" class="td4">Character Case:
                                                        <label><input type="radio" name="rdCharacterCase" value="UPPERCASE" id="rdCharacterCase_0" disabled>UPPERCASE</label>
                                                        <label><input type="radio" name="rdCharacterCase" value="lowercase" id="rdCharacterCase_1" disabled>lowercase</label>
                                                        <label><input type="radio" name="rdCharacterCase" value="TitleCase" id="rdCharacterCase_2" disabled>TitleCase</label>
												</td>
                                            </tr>
                                            <tr>
                                                    <td class="td3">
                                                        <input type="radio" name="rdOptions" id="rdOptions_0" value="rdSeparator" onclick="grabfocus(this.value)">
                                                        <select name="cmbSeparator" id="cmbSeparator" disabled>
                                                            <option>- Please Select -</option>
                                                            <option value=":">:</option>
                                                            <option value="/">/</option>
                                                            <option value="-">-</option>
                                                            <option value="(">(</option>
                                                            <option value=")">)</option>
                                                        </select>
                                                    </td>
                                                    <td class="td4">
                                                            <input type="radio" name="rdOptions" id="rdOptions_1" value="rdStatic" onclick="grabfocus(this.value)">
                                                            <input name="txtStatic" class="input" id="txtStatic" type="text" size="30" disabled>
                                                        </td>

                                                </tr>
                                                <tr>
                                                    <td class="td3"></td>
	                                                <td width="25%" id="th2" style="padding-left: 16px;">Dynamic Field 
    	                                            </td>                                            									
                                                </tr>
                                                <tr>
                                                <td></td>
                                                <td class="td4">
                                                        <input type="radio" name="rdOptions" id="rdOptions_2" value="rdDynamic" onclick="grabfocus(this.value)">
                                                        <select name="cmbDynamic" id="cmbDynamic" disabled>
                                                            <option>- Please Select -</option>
                                                            <option id="851220035201" value="no_kp">No KP</option>
                                                            <option id="LB121" value="kod_pusat">Kod Pusat</option>
                                                            <option id="Y" value="kategori_kv">Kategori KV</option>
                                                            <option id="<?=date('y')?>" value="Tahun">Tahun</option>
                                                        </select>
                                                </td>
                                                <td></td>
                                                </tr>
                                                                                              <tr>
                                              	<td colspan="3">&nbsp;</td>
                                              </tr>
                                                <tr>
                                                    <td colspan="5" class="td3" style="text-align:center" width="30%">								  
                                                        <input name="btnAddOption" type="button" class="btn btn-success" id="btnAddOption" value="Add Option" onClick="addOption();"></td>
                                              </tr>
                                              <tr>
                                              	<td colspan="3">&nbsp;</td>
                                              </tr>
                                            </table>					  </td>
                                    </tr>
                </table>                
                <div class="wells" style="margin:0 auto;">
				<table id="tablecontent" class="border" width="100%">
					<tr>
						<td height="35" width="45%">
                        	<div align="right">Format Angka Giliran <span class="style1">*</span></div>
                        </td>
						<td width="3%">
                        	<div align="center">:</div>
						</td>
						<td>
							<input type="hidden" name="txtTemplate" id="txtTemplate" size="80" value="">
							<div id="metafield" class="metafield"></div>
						</td>
					</tr>
					<tr>
						<td colspan="4" align="center">
                        	<label id="lblExample">- Example -</label>
                            
						</td>
					</tr>
                    <tr>
                    	<td>&nbsp;</td>
					</tr>
					<tr>
                        <td colspan="3" align="center">
							<input type="Submit" class="btn btn-primary" name="btnSubmit" id="btnSubmit" value="Submit" onclick="validate_meta()" align="right">
                        	<input type="reset" class="btn" name="btnClear" id="btnClear" value="Clear" onClick="reset_reset();">
                            <input type="hidden" name="txtSubmit" id="txtSubmit" value="1">
						</td>
					</tr>
				</table></div>
				

			</fieldset>
			<div class="dialog_overlay" id="job_code_template" style="display: none">
				<strong>Job Code Template</strong><br/><br/>
				<p class="text-info">Setup firm's job code (naming) by using the entity options.<br/>
				   Example: if your organization's project code is as this:<br/>
				   &nbsp;&nbsp;&nbsp;AMCAF-TIMESHEET-2011<br/>
				   Then, setup as steps below:<br/>
				   &nbsp;1. Click &amp; choose dynamic field as 'firm initial', click UPPERCASE &amp; 'Add Option'.<br/>
				   &nbsp;2. Click &amp; choose separator as '-', click 'Add Option'.<br/>
				   &nbsp;3. Click static field, type 'timesheet', click UPPERCASE &amp; 'Add Option'.<br/>
				   &nbsp;4. Repeat step 2.<br/>
				   &nbsp;5. Click &amp; choose dynamic field as 'year', click 'Add Option'.<br/>
				   &nbsp;6. Click 'x'/'Clear' to remove entity option.<br/>
				   &nbsp;7. Click 'Submit' to confirm company's job code (naming).<br/></p>
			</div>
		</form>
	</div>