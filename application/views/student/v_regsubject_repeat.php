  <script type="text/javascript">
	$(document).ready(function() {
		$(".btn_result_popup").bind("click", function() {
			$('#myModal_add').modal({
				keyboard : false
			});
			$("#submit3").click(function() {
				$("#form3").submit();
			});

		});

		$("#form3").validationEngine('attach', {
			scroll : false
		});

	});

</script>
  
<legend><h3>Daftar Modul Mengulang</h3></legend>  
<table width="95%" border="0" cellpadding="0" cellspacing="0" style="margin-top:2px;" class="table table-striped table-bordered table-condensed">
  
	  <tr>
<td>NAMA</td>
<td><?=strtoupper($student[0] -> stu_name) ?></td>
</tr>
 <tr>
<td>ANGKA GILIRAN</td>
<td><?=strtoupper($student[0] -> stu_matric_no) ?></td>
</tr>
		  <tr>
<td>KURSUS</td>
<td><?=strtoupper($student[0] -> cou_name) ?></td>
</tr>
	  <tr>
<td>KOLEJ</td>
<td><?=strtoupper($student[0] -> col_name) ?></td>
</tr>
	  <tr>
<td>SEMESTER</td>
<td><?=strtoupper($student[0] -> stu_current_sem) ?></td>
</tr>
	  <tr>
<td>TAHUN</td>
<td><?=strtoupper($student[0] -> stu_current_year) ?></td>
</tr>
	<?php ?>
  </table>
  
 <?php if(!empty($subject_fail)){  ?>
  <h4>Modul Tidak Lulus</h4>
    <table width="95%" border="0" cellpadding="0" cellspacing="0" style="margin-top:2px;" class="table table-striped table-bordered table-condensed">
		<tr style="font-weight: bold;">
			<td>KOD</td>
			<td>MODUL</td>
			<td style="text-align: center;">KREDIT</td>
			<td style="text-align: center;">GRADE</td>
			<td style="text-align: center;">SEMESTER</td>
			<td style="text-align: center;">TAHUN</td>
		</tr>
 <?php
 
 foreach ($subject_fail as $row) {
     
 
 ?>
  <tr>
<td width='10%'><?=$row -> mod_paper ?></td>
<td width='10%'><?=strcap($row -> mod_name) ?></td>
<td width='10%' style="text-align: center;"><?=$row -> mod_credit_hour ?></td>
<td width='10%' style="text-align: center;"><?=$row -> grade_type ?></td>
<td width='10%' style="text-align: center;"><?=$row -> mt_semester ?></td>
<td width='10%' style="text-align: center;"><?=$row -> mt_year ?></td>
</tr>

<?php } ?>
    </table>
    <?php }else{

		echo "<h4>Tiada Modul Gagal</h4>";
		}
	?>


  
  
  <?php if(!empty($subject_repat)){
  	?>
  
    <h4>Mengulang</h4>
    <table width="95%" border="0" cellpadding="0" cellspacing="0" style="margin-top:2px;" class="table table-striped table-bordered table-condensed">
    	  <tr style="font-weight: bold;">
<td width='18%'>KOD</td>
<td width='18%' >MODUL</td>
<td width='18%' style="text-align: center;" >KREDIT</td>
<td width='18%' style="text-align: center;">GRADE</td>
<td width='18%' style="text-align: center;">SEMESTER</td>
<td width='20%' style="text-align: center;" >TAHUN</td>
<td width='20%' style="text-align: center;">TINDAKAN</td>
</tr>
 <?php
 foreach ( $subject_repat as $row) {
     
 
 ?>
  <tr>
<td style="text-transform: uppercase;"><?=$row -> mod_paper ?></td>
<td><?=strcap($row -> mod_name) ?></td>
<td style="text-align: center;"  ><?=$row -> mod_credit_hour ?></td>
<td style="text-align: center;" ><?=$row -> grade_type ?></td>
<td style="text-align: center;"  ><?=$row -> mt_semester ?></td>
<td style="text-align: center;"  ><?=$row -> mt_year ?></td>
<td><a class="btn btn-info" href='<?=site_url("student/repeat_subject/delete_repeat_subject/" . $row -> md_id . "/" . $row -> stu_id) ?>' ><span>BATAL</span></a></td></td>
</tr>

<?php }
	}
?>
    </table>
  
  
                   <div class="modal hide fade" id="myModal_add" style="width: 70%; margin-left:-35%;">
    <div class="modal-header">
        <h3><strong>DAFTAR MODUL MENGULANG</strong></h3>
    </div>
<?php	

if($student[0] -> stu_current_year != date("Y")){
		?>
		<div class="alert">
  
  <strong>AMARAN</strong> TAHUN TIDAK SAMA DENGAN TAHUN SEMASA PELAJAR
</div>
<?
	}

?>
    <div class="modal-body" >
      <form id="form3" name="form3" action="<?= site_url('student/repeat_subject/add_repeat_subject') ?>" method="post" style="margin-bottom: 0px;">
	<table id="tam" width="95%" border="0" cellpadding="5" cellspacing="1" style=" margin-bottom: 10px; margin-top:-4px;" class="table table-striped table-bordered table-condensed">
	<tr>
		<thead>
			<td></td>
			<td style="vertical-align: middle; text-align: center;"><strong class="tablepadding">MODUL</strong></td>
			<td style="vertical-align: middle; text-align: center;"><strong class="tablepadding">SEMESTER</strong></td>
			<td style="vertical-align: middle; text-align: center;"><strong class="tablepadding">TAHUN</strong></td>
		</thead>
	</tr>
	<tr>
	<td style="vertical-align: middle; text-align: center;">Daftar</td>
	<td >
	 <select id="sub3" name='add_subject[]' class="validate[required] input-xxlarge" style="margin-bottom: 0px;" >
	 <?php  if(!empty($canrepeat)){ ?>
	 <option value =''>-- Sila Pilih --</option>
	 <?php }else{
	 	?>
	 	<option value =''>Tiada Modul Di tawarkan</option>
	<?php	
	 } ?>
	 
	<?php
	foreach ($canrepeat as $row) {

		echo "<option value='" . $row -> mod_id . "|" . $row -> md_id . "'>" . $row -> mod_paper . " - " . strcap($row -> mod_name) . "</option>";

	}
	?>
	</select></td>
	     <td style="vertical-align: middle; text-align: center;">
	     	<?=strtoupper($student[0] -> stu_current_sem) ?>
	     	<input type="hidden" name='add_semester[]' id='semester' value="<?=$student[0] -> stu_current_sem?>">
	 </td>
	<td style="vertical-align: middle; text-align: center;">
			<?=strtoupper($student[0] -> stu_current_year) ?>
	     	<input type="hidden" id="slct_tahun" name="add_year[]" value="<?=$student[0] -> stu_current_year?>">


	</td>
	</tr>
          <input type='hidden' name='stu_id'  value='<?=$student[0] -> stu_id ?>' >
	 
        </table>
	 <div style="text-align:left">
                <button class="btn btn-primary" id="add" type="button" name="addRow" >Tambah Modul</button>
                </div>
        </form>
    </div>
    
    <div class="modal-footer">
    	<button type="submit" id="submit3"  class="btn btn-primary"><span>DAFTAR</span></button>
         <a href="#" class="btn" data-dismiss="modal">TIDAK</a>
    </div>
    
 
</div>
 <div class="pull-right">
 <button align="center" id="btn_result_popup" class="btn btn-info btn_result_popup" type="submit"><span>DAFTAR MENGULANG</span></button>
 <a class="btn" href='<?=site_url('student/repeat_subject/repeat_subject_view/' . $student[0] -> cou_id . '/' . $student[0] -> col_id) ?>'>KEMBALI</a>
</div>

  <script type="text/javascript">
     
     		$(document).ready(function(){
 $("#add").bind("click",function(){
               $("table#tam tr:last").after(
            "<tr>\n\
	     <td style='vertical-align: middle; text-align: center;'>Daftar</td>\n\
                <td ><select id='sub1' name='add_subject[]' style='margin-bottom: 0px;' class='input-xxlarge'>\n\
                <option value=''>-- Sila Pilih --</option>\n\
		    <?php
			foreach ($canrepeat as $row) {

				echo "<option value='" . $row -> mod_id . "|" . $row -> md_id . "'>" . $row -> mod_paper . " :" . $row -> mod_name . "</option>";
			}
		?>
			</select></td>\n\
			<td style='vertical-align: middle; text-align: center;'>\n\
				<?=strtoupper($student[0] -> stu_current_sem) ?>\n\
			<input type='hidden' name='add_semester[]' id='semester' style='margin-bottom: 0px;' value='<?=$student[0] -> stu_current_sem?>' >\n\
			</td>\n\
			<td style='vertical-align: middle; text-align: center;'><?=strtoupper($student[0] -> stu_current_year) ?><input type='hidden' id='sub2' name='add_year[]' style='margin-bottom: 0px;' value='<?=$student[0] -> stu_current_year?>' >\n\
			</td>\n\
			</tr>");
			return false;
			});

			});
			</script >