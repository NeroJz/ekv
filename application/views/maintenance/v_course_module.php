<style>
.dataTables_filter {
   width: 50%;
}

#tbl_kursus_length {

text-align :left;

}

#tbl_kursus_info{

text-align :left;

}

</style>

<script src="<?=base_url()?>assets/js/maintenance/kv.course_module.js" type="text/javascript"></script>

<legend><h3>Daftar Kursus</h3></legend>

<div class="panel-group" id="accordion">
  <div class="panel panel">
    <div class="panel-heading">
      <h4 class="panel-title">
       <button  class="btn btn-info" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          Daftar Kursus 
       </button>     
      </h4>
    </div>
    <div id="collapseOne" class="panel-collapse collapse">
      <div class="panel-body">
       
<form name="frm_pusat" id="frm_pusat" method="post" class="form-inline">
<table id = "table_group" class="breadcrumb border" width="100%" align="center">
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
    <tr>
		<td height="35" width="40%"><div align="right">Kursus</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
				<select id="slct_kursus" name="slct_kursus" class="validate[required]">
				<option value="">--Sila Pilih--</option>
				<?php			
					foreach ($get_course as $row)
					{
				?>
						<option value="<?= $row->cou_id ?>">
						    <?= ucwords($row->cou_course_code).'  - '.strcap($row->cou_name) ?>
		                </option>
			    <?php 
					} 
					
				?>
                  </select>
                  </div>
                 </td>
	</tr>    
    <tr>
    	<td></td>
    	<td height="35"><div align="right"></div></td>
        <td height="35">
        	<div align="left">
        	</br>
          		<input class="btn btn-info" type="button" id="btn_reg_course" name="btn_reg_course" value="Daftar">
        		<input class="btn" type="reset" name="btn_reset" value="Set Semula">
        	</div>
        </td>
    </tr>
    <tr><td>
    &nbsp;&nbsp;</td>
    </tr>   
 </table>   
 </form>
       
      </div>
    </div>
  </div>
</div>
<center>
 <form id="frm_table_kursus">
 <table width="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="#E5E5E5" class="display dataTable" id="tbl_kursus" style="display: table; margin-left: 0px; width: 100%;">
   <thead>  	
         <th><b>BIL</b></th>
         <th><b>KURSUS</b></th>
         <th><b>KLUSTER</b></th>
         <th><b>TINDAKAN</b></th>   
  </thead>
<tbody>
<?php 
if(isset ($list_course_kv))
	
	{
	?>
        <?php 
        
        $i=1;
        foreach($list_course_kv as $rows)
        {
        ?>
        
        <tr>
      		<td width="30" align="center">
        		<?= $i ?>
        	</td>
        		       		        	
        	<td width="400">       		
           		<?= $rows->cou_course_code?> - <?= strcap($rows->cou_name);?>
        	</td>        	
        	
        	<td width="400">
        		<?= strcap($rows->cou_cluster); ?>
        	</td>
        		
        	<td width="100" align="center">
        		<center>
				<button name="btn_padam" id="btn_padam" class="btn btn_padam" type="button" value="<?= $rows->cc_id ?>"><i class="icon-trash"></i>&nbsp;Padam</button>
			</center>
			
			</td>
        	</tr>
         	
       <?php 
        $i++;
        }
}
else 
{	
	echo "Tiada data di paparkan";
}
?>
</table>
</form>	
</tbody>
</center>
<?php /*
<div id="course_module">
	<form id="formCourseModule" name="formCourseModule" class="form-inline">
		<table id="tblCourseModule" cellpadding="0" cellspacing="0" border="0" 
			class="display table table-striped table-bordered" style="width: 100% !important; margin-bottom: -1px;" >
			<tbody>
			<tr>
				<td width="20%">
					<b>Kursus</b>
					<input type="hidden" value="" name="kod_kursus" id="kod_kursus"/>
				</td>
				<td width="2%">
					<center><b>:</b></center>
				</td>
				<td width="78%" id="td_kursus" colspan="2">
				</td>
			</tr>
			<tr>
				<td>
					<b>Semester</b>
					<input type="hidden" value="" name="hide_semester" id="hide_semester"/>
				</td>
				<td>
					<center><b>:</b></center>
				</td>
				<td id="td_semester" colspan="2">
				</td>
			</tr>
			<tr>
				<td>
					<b>Kluster</b>
				</td>
				<td>
					<center><b>:</b></center>
				</td>
				<td id="td_kluster" colspan="2">
				</td>
			</tr>
			<tr>
				<td valign="middle">
					<b>Modul</b>
				</td>
				<td>
					<center><b>:</b></center>
				</td>
				<td width="39%">
				<table width="100%" id="tbl_akademik" class="table">
					<thead>
					<th colspan="2"><center>Akademik</center></th>
					</thead>
					<tbody>
					</tbody>
				</table>
				</td>
				<td width="39%">
				<table width="100%" id="tbl_vokasional">
					<thead>
					<th colspan="2"><center>Vokasional</center></th>
					</thead>
					<tbody>
					</tbody>
				</table>	
				</td>
			</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="4">
						<button id="btnSaveCourseModule" class="btn btn-primary pull-right" type="button">
						Simpan
						</button>
					</td>
				</tr>
			</tfoot>
		</table>
	</form>
</div> */
?>
	


<!--
<button class="btn btn-primary pull-right"> Save </button>
-->
