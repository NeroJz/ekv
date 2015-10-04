<?php
/**************************************************************************************************
* File Name        : v_evaluation_form.php
* Description      : This File contain evaluation of exam mark
* Author           : Norafiq Bin Mohd Azman Chew
* Date             : 10 June 2013 = 1 Syaban
* Version          : -
* Modification Log : -
* Function List	   : -
**************************************************************************************************/

//echo $jsonPelajar;
?>

<style>
.dataTables_filter {
 width: 50%;
 float: right;
 text-align: right;
 margin-right: 10px;
}


.headTable {

font-size:13px;

}

</style>

<script type="text/javascript">
	var optPentaksir = <?=(isset($optPentaksir))?$optPentaksir:'null'?>;
	var primaryKeyStudent = '<?=(isset($primaryKeyList))?"PA%".$primaryKeyList:'null'?>';
	var jsonPelajar = <?=(isset($jsonPelajar))?$jsonPelajar:'null'?>; 
	var currentKVUser = <?=(isset($currentKVUser))?$currentKVUser:'null'?>;
</script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.form.min.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/evaluation/marking.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/localforage.min.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/evaluation/offlineMarking.js"></script>
<script language="javascript">

	// prepare the form when the DOM is ready 
	var bar = null;
	var percent = null;
	
	$(document).ready(function() { 
		bar = $('.bar');
		percent = $('.percent');

	    var options = {
	    	beforeSubmit:  showRequest,  // pre-submit callback   
	        success: function(data){

	        	functionAssignMarkFromExcel(data);
	        	$("#panelFileName").html("");

	        	var percentVal = '100%';
		        bar.width(percentVal)
		        percent.html(percentVal);
	        },  // post-submit callback
	        uploadProgress: function(event, position, total, percentComplete) {
						        var percentVal = percentComplete + '%';
						        bar.width(percentVal)
						        percent.html(percentVal);
						    },
	        clearForm: true,        // clear all form fields after successful submit 
        	resetForm: true   
	    }; 
	 
	    // bind form using 'ajaxForm' 
	    $('#formUploadMarkah').ajaxForm(options); 
	});

	// pre-submit callback 
	function showRequest(formData, jqForm, options) { 
		var percentVal = '0%';
        bar.width(percentVal)
        percent.html(percentVal);
	}
		
	function functionAssignMarkFromExcel(data){
	 
	 try
       {
       	//if problem occur here, throw error
		var dataMarkJson = JSON.parse(data);

		var counterCell = 0;
			$.each(dataMarkJson, function(i, item) {

				var cellAngkaGiliran = $("#tblAssgnMarks tr:eq("+(i+1)+") td:eq(2)").html();
		    	
		    	 $.each(item.mark, function (j, section) {
		    	 	//alert("|"+item.angka_giliran +"|"+ cellAngkaGiliran);
		    	 	if(item.angka_giliran.trim() == cellAngkaGiliran){
		    	 		var currentCellMarks = $(".cellMarks:eq("+(counterCell)+")");
		    	 		currentCellMarks.val(section.nilai);
		    	 		currentCellMarks.trigger("change");
		    	 	}
		    	 	counterCell++;
			        //do stuff with section data, eg. print section.name
			        //console.log(trTable);
			    });
			});

			  $("#panelUploadMsg").text("Markah berjaya dimuatnaik");
			  $('#panelAlertErrorUpload').addClass( "alert-success" );
              $('#panelAlertErrorUpload').attr('style','display:block');

		}
       catch(err)
       {
       	      var errMsg = "";

       	      alert(err.message);

       	       $('#panelAlertErrorUpload').removeClass( "alert-success" );

              $("#panelUploadMsg").text(data);
              $('#panelAlertErrorUpload').attr('style','display:block');
              
       } 
	}
</script>
<?php
	$titleType = "";

	if(isset($assessType) && $assessType == "VK")
	{
		$titleType = "Vokasional";					
	}
	else if(isset($assessType) && $assessType == "AK")
	{
		$titleType = "Akademik";
	}
	else {
		$titleType = "";
	}
?>
<legend><h3>Pentaksiran Akhir <?=$titleType ?></h3></legend>
<center>
<input type="hidden" id="ksmid" value="" name="ksmid" />

<form id="frm_marking" action="<?= site_url('examination/marking/select_configuration')?>" method="post" >
<table class="breadcrumb border" width="100%" align="center">
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
    <tr>
    	<td height="35"><div align="right">Semester</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                <select id="slct_tahun" name="slct_tahun" style="width:270px;" 
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
        <td height="35"><div align="left" id="divModul">
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
            </select>
            </div>
        </td>
    </tr>
     <tr>
    	<td height="35"><div align="right">Kelas</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35"><div align="left" id="divKelas">
        	<select id="slct_kelas" name="slct_kelas" style="width:270px;" 
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
					if(isset($kelasID) && $kelasID == $s->class_id)
					{
						echo '<option selected="selected" value="'.$s->class_id.'">'.
							strtoupper($s->class_name).'</option>';
					}						
					else
					{
						echo '<option value="'.$s->class_id.'">'.
							strtoupper($s->class_name).'</option>';
					}						
				}				
			}
            ?>
          		          
            </select>
            </div>
        </td>
    </tr> 
    
    
    <!--   
    <tr>
    	<td></td>
    	<td height="35"><div align="right"></div></td>
        <td height="35">
        	<div align="left">
        	<?php
            	if(isset($assessType) && $assessType == "VK")
				{					
            ?>	            
	          		<button id="btn_config_markP" class="btn btn-info" type="button" disabled="disabled">
	                    <span>Penetapan Markah</span>
	                </button>
	        <?php
				}
				else
				{
			?>
	          		<button id="btn_config_markP" class="btn btn-info" type="button" disabled="disabled">
	                    <span>Penetapan Markah</span>
	                </button>
					
			<?php
				}
	        ?>
        	</div>
        </td>
    </tr>
    -->
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
</table>
</form>
</center>
<table id="tableOffline" width="100%" align="center" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered">
	<thead>
		<tr style="background-color: white;">
			<th width="3%">BIL</th>
			<th align="left" width="30%">KURSUS</th>
			<th align="left" width="5%">SEMESTER</th>
			<th align="left" width="30%">MODUL</th>
			<th align="left" width="30%">KELAS</th>
			<th align="left" width="10%">STATUS</th>
		</tr>
	</thead>
	<tbody></tbody>
</table>
<span id="panelTblOffline">
	<table style="display:none;" id="tblStudentOffline" width="100%" align="center"  
			cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
		<thead>
			
		</thead>
		<tbody>
			             
		</tbody> 
	</table>
</span>
<?php


if(isset($noopen) && $noopen)
{
	echo "<div style ='font:14px/21px Arial,tahoma,sans-serif;color:#d4271f'>Kemasukan markah belum dibuka</div><br/>";
}
else if(isset($senaraipelajar))
{
	//echo "<pre>";
	//print_r($senaraipelajar);
	//echo "</pre>";				//FDP
		
	if(isset($subjekconfigur))
	{
?>



<button type="button" class="btn btn-success" id="btnInstallOffline">Offline</button>


<table id="tblStudent" width="100%" align="center"  
	cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered" >
	<thead>
	<tr style="background-color: white;">
		<th width="3%">BIL</th>
		<th align="left" width="30%">NAMA MURID</th>
		<th align="left" width="10%">ANGKA GILIRAN</th>
		<?php
		$j = 0;
		foreach($subjekconfigur as $sbc)
		{
			$assignment = strtolower($sbc->assgmnt_name);
			
			if(strtoupper($assignment) == "TEORI")
			{
				if(isset($teoriOpen) && $teoriOpen)
				{
		?>
					<th align="center" width="4%">
						<a onclick="fnOpenAssignment(<?=$sbc->assgmnt_id?>)">
							<?=strtoupper($assignment)?> / <?=$sbc->assgmnt_mark?>
							&nbsp;&nbsp;<img src="<?=base_url()?>assets/img/edit.png">
						</a>
					</th>
		<?php
				}
				else if(isset($teoriOpen) && !$teoriOpen)
				{
					echo ("<div style ='font:14px/21px Arial,tahoma,sans-serif;color:#d4271f'>*Kemasukan Markah Teori tidak dibuka</div><br/>");
				}
			}
			else if(strtoupper($assignment) == "AMALI")
			{
				if(isset($amaliOpen) && $amaliOpen)
				{
		?>
					<th align="center" width="4%">
						<a onclick="fnOpenAssignment(<?=$sbc->assgmnt_id?>)">
							<?=strtoupper($assignment)?> / <?=$sbc->assgmnt_mark?>
							&nbsp;&nbsp;<img src="<?=base_url()?>assets/img/edit.png">
						</a>
					</th>
		<?php
				}				
				else if(isset($amaliOpen) && !$amaliOpen)
				{
					echo ("<div style ='font:14px/21px Arial,tahoma,sans-serif;color:#d4271f'>*Kemasukan Markah Amali tidak dibuka</div><br/>");
				}
			}
			else
			{
				if($assessType == "AK")
				{
					if(isset($academikOpen) && $academikOpen)
					{
		?>
						<th align="center" width="4%">
							<a onclick="fnOpenAssignment(<?=$sbc->assgmnt_id?>)">
								<?=strtoupper($assignment)?>
								&nbsp;&nbsp;<img src="<?=base_url()?>assets/img/edit.png">
							</a>
						</th>
		<?php
					}
					else if(isset($academikOpen) && !$academikOpen)
					{
						echo ("<div style ='font:14px/21px Arial,tahoma,sans-serif;color:#d4271f'>*Kemasukan Markah Akademik tidak dibuka</div><br/>");
					}
				}
			}
						
			$j +=  $sbc->assgmnt_mark;
		}
		?>
		<th width="8%">JUMLAH / <?=$j?></th>
	</tr>	
	</thead>
	<tbody>
	<?php
	$i = 1;
	foreach ($senaraipelajar as $row)
	{
	?>
	<tr>
		<td align="center"><?=$i?></td>
		<td align="left"><?=strtoupper($row->stu_name)?></td>
		<td align="left"><?=$row->stu_matric_no?></td>
		<?php
		$k = 0;
		foreach($subjekconfigur as $sbc)
		{
			
			$assignment = strtolower($sbc->assgmnt_name);
			
			$markah = "";
			
			if($row->markah[$k] != "T")
			{
					
				$markah = ceil($row->markah[$k]);
			
			}
			else
			{
					
				$markah = $row->markah[$k];
					
			}
			
			
			if(strtoupper($assignment) == "TEORI")
			{
				if(isset($teoriOpen) && $teoriOpen)
				{
		?>
					<td align="center">
						<input type="text" readonly="readonly" name="jumlah<?=$row->stu_id?><?=$sbc->assgmnt_id?>" 
							id="jumlah<?=$row->stu_id?><?=$sbc->assgmnt_id?>" style="width: 100px;" value="<?=$markah?>">
					</td>
		<?php
				}
			}
			else if(strtoupper($assignment) == "AMALI")
			{
				if(isset($amaliOpen) && $amaliOpen)
				{
		?>
					<td align="center">
						<input type="text" readonly="readonly" name="jumlah<?=$row->stu_id?><?=$sbc->assgmnt_id?>" 
							 id="jumlah<?=$row->stu_id?><?=$sbc->assgmnt_id?>" style="width: 100px;" value="<?=$markah?>">
					</td>
		<?php
				}
			}
			else
			{
				if(isset($academikOpen) && $academikOpen)
				{
		?>
					<td align="center">
						<input type="text" readonly="readonly" name="jumlah<?=$row->stu_id?><?=$sbc->assgmnt_id?>" 
					 	id="jumlah<?=$row->stu_id?><?=$sbc->assgmnt_id?>" style="width: 100px;" value="<?=$markah?>">
					</td>
		<?php
				}
			}
			
			$k++;
		}
		?>
		<td id="ttlMark_<?=$row->stu_id?>" align="center" class="ttlmrks">
			<?php
			
			//print_r($row);
				if(isset($row->markah[1]))
				{
					if($row->markah[0]=='T' && $row->markah[1]=='T')
					{
						echo "T";
					}
					else
					{
						$totalM = 0.00;
						
						if($row->markah[0] > 0)
						$totalM = $totalM + $row->markah[0];
						
						if($row->markah[1] > 0)
						$totalM = $totalM + $row->markah[1];
						
						echo ceil($totalM);
					}
				}
				else
				{
					if($row->markah[0]=='T')
					{
						echo "T";
					}
					else
					{
						$totalM = 0.00;
						
						if($row->markah[0] >0)
						$totalM = $totalM + $row->markah[0];
						
						echo ceil($totalM);
					}					
				}
			?>
		</td>
	</tr>			
	<?php
		$i++;	
	}		
	?>
	</tbody>
</table>


<div align="right">
	<!--<button id="btn_save_mark" class="btn btn-info" type="button">
        <span>SIMPAN MARKAH</span>
    </button>-->
</div>
<?php
	}
}
?>

<div class="modal hide fade" id="myModal" style="width:66%; left:40%;">
    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" 
		    aria-hidden="true">&nbsp;&times;&nbsp;</button>
        <h3><strong>Pentaksiran Vokasional</strong></h3>
    </div>
    <div class="modal-body" >
        <form id="formConfig" name="formConfig" style="position:relative;" 
        	action="<?=site_url("examination/marking/save_configurations")?>" method="post">
        	
        	<input type="hidden" id="ksmid2" value="" name="ksmid2" />
        	<input type="hidden" id="kursusid" name="kursusid" value="" />
			<input type="hidden" id="subjectid" name="subjectid" value="" />
			<input type="hidden" id="semesterP" name="semesterP" value="" />
			<input type="hidden" id="pentaksiran" name="pentaksiran" value="" />
			<input type="hidden" id="mptID" name="mptID" value="" />
			<input type="hidden" id="kelas3" name="kelas3" value="" />
			<input type="hidden" id="tempKAt2" name="tempKAt2" value="" /><!-- temp utk function AK -->
			
        	<table id="tbltask" style="margin-bottom:5px;" 
        		class="table table-striped table-bordered table-condensed">
            	<thead>
                <tr>
                	<td width="225" ><strong><span id="katTugasan"></span></strong></td>
                  	<td width="175" ><strong>Markah Tugasan(<span id="percent"></span>%)</strong></td>
                  	<td width="175" ><strong>Jumlah Tugasan</strong></td>
                  	<td width="175" ><strong>Pilihan Jumlah Tugasan</strong></td>
                  	<td>&nbsp;</td>
              	</tr>
                </thead>
                <tbody id="catPentaksiran">                
                </tbody>               
            </table>
            
            <div id="tambahTugasan" class="pull-left">
            </div>
            
            <div class="pull-right">            	
            	<button id="btnSaveConfig" type="submit" name="btnSaveConfig" 
            		class="btn btn-primary"><span>SIMPAN</span></button>
            </div>
            <br />
            <br />
        </form>
        <div id="configProgress" style="text-align:center;"></div>
    </div>
</div>

<div class="modal hide fade" id="assgmnpop" style="width:80%; left:25%;" >
    <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" 
		    aria-hidden="true">&nbsp;&times;&nbsp;</button>
        <h3><strong id="markHeader"></strong></h3>
        <h4 id="paparanAgihan"></h4>
    </div>
    <div class="modal-body" >
    <div class="accordion" id="accordionUpload">
			  <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordionUpload" href="#collapseOne">
			        Muatnaik markah dari Excel
			      	<i style="float:right;" class="icon-large icon-upload"></i>
			      </a>
			    </div>
			    <div id="collapseOne" class="accordion-body collapse">
			      <div class="accordion-inner">
			      <form method="post" action="<?=site_url("/examination/markings_v3/upload_from_excel");?>" id="formUploadMarkah" enctype="multipart/form-data">
			      <span id="outputDataUpload"></span>
			  
			      <span>
					    <input  type="file" 
					            style="visibility:hidden; width: 1px;" 
					            id='userfile' name='userfile'  
					            onchange="$(this).parent().find('span').html($(this).val().replace('C:\\fakepath\\', ''))"  /> <!-- Chrome security returns 'C:\fakepath\'  -->
					    <input class="btn btn-primary" type="button" value="Sila pilih fail untuk di muatnaik..." onclick="$(this).parent().find('input[type=file]').click();"/> <!-- on button click fire the file click event -->
					    &nbsp;
					    <span id="panelFileName"  class="badge badge-important" style="padding-left:25px;padding-right:25px;" ></span>
				   </span>
				   <br>
				   <br>
				   <div class="progress progress-striped">
				        <div class="bar" style="width: 0%;"></div>
				        <div class="percent">0%</div>
				    </div>
				    <div id="panelAlertErrorUpload" class="alert" style="display:none;">
					  <button type="button" class="close" data-dismiss="alert">&times;</button>
					  <span id="panelUploadMsg">Best check yo self, you're not...</span>
					</div>
				  <button id="btnUploadMarkah" type="submit" class="btn btn-info pull-right"><span>Muatnaik</span></button>
		            	<br>
		           </form>
			      </div>
			    </div>
			  </div>
			</div>
        <form id="formAssgMark" name="formAssgMark" style="position:relative;" 
        	action="" method="post" >
        	<input type="hidden" id="mark_assg_selection" name="mark_assg_selection" />
        	<input type="hidden" id="mark_total_assg" name="mark_total_assg" />
        	<input type="hidden" id="semesterP4" name="semesterP4" value="" />
			<input type="hidden" id="mptID4" name="mptID4" value="" />
			<input type="hidden" id="category" name="category" value=""/>
			<input type="hidden" id="kelas4" name="kelas4" value=""/> 
			        	
        	<table id="tblAssgnMarks" style="margin-bottom:0px;" 
        		class="table table-striped table-bordered table-condensed">
            	<thead>
            		
                </thead>
                <tbody>
                	             
                </tbody>               
            </table>
            <input type="hidden" id="mark_assg_selection" name="mark_assg_selection" value="" />
            <div style="float:right; display:inline-block;">
            	<input type="hidden" id="hidAssignmentID" value="">
            	
            	<button id="btnClearMarkah" type="button" style="margin-top:10px; margin-left: 5px; "
	            	class="btn btn-primary pull-right"><span>PADAM</span></button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	            	
	            <button id="btnSaveAssgMarks" type="button" disabled="disabled" style="margin-top:10px; "
	            	class="btn btn-primary pull-right"><span>SIMPAN</span></button>&nbsp;&nbsp;
	            	
	            <button id="btnDownloadAssgMarks" onclick="javascript: getw();" type="button" style="margin-top:10px;"
	            	class="btn btn-primary"><span>DOWNLOAD EXCEL</span></button> &nbsp;&nbsp;
            </div>
            <br />
            <br />
        </form>
        <div id="configProgress" style="text-align:center;"></div>
    </div>
</div>
<form id="loadStudent" name="loadStudent" action="<?=site_url("examination/marking/load_configurations")?>" method="post">
<input type="hidden" id="ksmid3" value="" name="ksmid3" />
<input type="hidden" id="kursusid3" name="kursusid3" value="" />
<input type="hidden" id="subjectid3" name="subjectid3" value="" />
<input type="hidden" id="semesterP3" name="semesterP3" value="" />
<input type="hidden" id="pentaksiran3" name="pentaksiran3" value="" />
<input type="hidden" id="kelas3" name="kelas3" value="" />
<input type="hidden" id="mptID3" name="mptID3" value="" />

<input type="hidden" id="tempKAt" name="tempKAt" value="" /><!-- temp utk function AK -->

</form>
<?php
/**************************************************************************************************
* End of v_evaluation_form.php
**************************************************************************************************/
?>