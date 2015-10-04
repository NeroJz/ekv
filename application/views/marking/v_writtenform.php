<?php
/**************************************************************************************************
* File Name        : v_writtenform.php
* Description      : This File contain written form to be print
* Author           : Norafiq Bin Mohd Azman Chew
* Date             : 25 July 2013
* Version          : -
* Modification Log : -
* Function List	   : -
**************************************************************************************************/
?>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/evaluation/wform.js"></script>

<legend><h3>Borang Pengisian Markah (K15)</h3></legend>
<center>
<form id="frm_written" action="<?=site_url("examination/writtenform/get_students")?>" method="post" target="_blank">
<table class="breadcrumb border" width="100%" align="center">
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Semester</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                <select id="slct_semester" name="slct_semester" style="width:270px;" 
                	class="validate[required]">
            		<option value="">-- Sila Pilih --</option>
                    <option <?php if(isset($semesterP) && $semesterP == 1) echo 'selected = "selected"'; ?> value="1">1</option> 
                    <option <?php if(isset($semesterP) && $semesterP == 2) echo 'selected = "selected"'; ?> value="2">2</option>
                    <option <?php if(isset($semesterP) && $semesterP == 3) echo 'selected = "selected"'; ?> value="3">3</option>
                    <option <?php if(isset($semesterP) && $semesterP == 4) echo 'selected = "selected"'; ?> value="4">4</option>
                    <option <?php if(isset($semesterP) && $semesterP == 5) echo 'selected = "selected"'; ?> value="5">5</option> 
                    <option <?php if(isset($semesterP) && $semesterP == 6) echo 'selected = "selected"'; ?> value="6">6</option>
                    <option <?php if(isset($semesterP) && $semesterP == 7) echo 'selected = "selected"'; ?> value="7">7</option>
                    <option <?php if(isset($semesterP) && $semesterP == 8) echo 'selected = "selected"'; ?> value="8">8</option>
                    <option <?php if(isset($semesterP) && $semesterP == 9) echo 'selected = "selected"'; ?> value="9">9</option>
                    <option <?php if(isset($semesterP) && $semesterP == 10) echo 'selected = "selected"'; ?> value="10">10</option>
                </select>
            </div>
        </td>
    </tr>
    <tr>
    	<td width="40%" height="35"><div align="right">Kursus</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="57%" height="35">
        	<select id="slct_kursus" name="slct_kursus" style="width:270px;" 
        		class="validate[required]">
            <option value="-1">-- Sila Pilih --</option>
            <?php			
				foreach ($kursus as $row)
				{
			?>
					<option value="<?= $row->cou_id ?>"
					<?php
					if(isset($kursusID) && $kursusID == $row->cou_id)
						echo 'selected="selected"';
					?>
					>
					    <?= strtoupper($row->cou_course_code.'  - '.$row->cou_name ) ?>
                    </option>
		    <?php 
				}
			?>
            </select>
        </td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Modul</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35"><div align="left">
        	<select id="slct_jubject" name="slct_jubject" style="width:270px;" 
        		class="validate[required]"  
        		<?php
	            	if(!isset($subjek))
	        			echo 'disabled="disabled"';
        		?>
        	>
            <option value="">-- Sila Pilih --</option>
            <?php
            if(isset($subjek))
			{
				foreach($subjek as $s)
				{
					if(isset($subjectID) && $subjectID == $s->mod_id)
					{
						echo '<option selected="selected" value="'.$s->mod_id.':'.$s->mod_type.':'.$s->cm_id.'">'.
							strtoupper($s->mod_code.' - '.$s->mod_name).'</option>';
						$subjekName = strtoupper($s->mod_name);
					}						
					else
					{
						echo '<option value="'.$s->mod_id.':'.$s->mod_type.':'.$s->cm_id.'">'.
							strtoupper($s->mod_code.' - '.$s->mod_name).'</option>';
					}						
				}				
			}
            ?>
            </select></div>
        </td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Kelas</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35"><div align="left" id="divKelas">
        	<select id="slct_kelas" name="slct_kelas" style="width:270px;" 
        		class="validate[required]" 
        	<?php
	            	if(!isset($kelas))
	        			echo 'disabled="disabled"';
        	?>
        	
        	>
            <option value="">-- Sila Pilih --</option>
          		
          	<?php
            if(isset($kelas))
			{
				//echo $kelas;
				foreach($kelas as $s)
				{
					
						echo '<option selected="selected" value="'.$s->class_id.'">'.
							strtoupper($s->class_name).'</option>';
						$className = strtoupper($s->class_name);
											
				}				
			}
            ?>
          		          
            </select>
            </div>
        </td>
    </tr>     
    <tr>
    	<td height="35"><div align="right">Pengisian Markah</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35"><div align="left">
        	<select id="slct_pengisian" name="slct_pengisian" style="width:270px;" 
        		class="validate[required]"
        		
        		<?php
	            	if(!isset($pengisian))
	        			echo 'disabled="disabled"';
        		?>
        		>
        		<option value="">-- Sila Pilih --</option>
                <option <?php if(isset($pengisian) && $pengisian == 1) echo 'selected = "selected"'; ?> value="1">Berterusan</option> 
                <option <?php if(isset($pengisian) && $pengisian == 2) echo 'selected = "selected"'; ?> value="2">Akhir</option>
            </select></div>
        </td>
    </tr>
    <tr>
    	<td></td>
    	<td height="35"><div align="right"></div></td>
        <td height="35">
        	<div align="left">        	
				<button id="btn_print_form" class="btn btn-info" type="submit" disabled="disabled">
                    <span>Papar Borang</span>
                </button>
        	</div>
        </td>
    </tr>
    <tr>
    	<td colspan="3">&nbsp;
    		<input type="hidden" id="cmId" value="" name="cmId" />
    		<input type="hidden" id="semester" value="" name="semester" />
    		<input type="hidden" id="subjectId" value="" name="subjectId" />
    		<input type="hidden" id="kelas1" value="" name="kelas1" />
    	</td>
    </tr>
</table>
</form>
</center>

<table id="tblStudent" width="100%" align="center"  
	cellpadding="0" cellspacing="0" border="0" class="table table-striped">
	<thead>
		
	</thead>
	<tbody>

	</tbody>
</table>
<div align="right">
	<button id="btn_cetak" class="btn btn-info" type="button">
        <span>CETAK BORANG</span>
    </button>
</div>









<?php
/**************************************************************************************************
* End of v_writtenform.php
**************************************************************************************************/
?>