<style>
.dataTables_filter {
  width: 50%;
  float: left;
  text-align: left;
}

.dgreen{font-weight:bold; color:green;}
.dred{font-weight:bold; color:red;}

</style>

<script src="<?=base_url()?>assets/js/maintenance/kv.module_course_reg.js" type="text/javascript"></script>


<legend><h3>Daftar Modul Kursus</h3></legend>

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
						<option value="<?= $row->cou_id ?>:<?= $row->cou_course_code ?>:<?= $row->cou_name ?>:<?= $row->cou_cluster ?>">
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
    	<td height="35"><div align="right">Semester</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
        		 <select width="50%" name="semester" id="semester" class="validate[required]" disabled="true">
				   	<option value="">-- Sila Pilih --</option>
				   	<option value="1">1</option>
				   	<option value="2">2</option>
				   	<option value="3">3</option>
				   	<option value="4">4</option>
				   	<option value="5">5</option>
				   	<option value="6">6</option>
				   	<option value="7">7</option>
				   	<option value="8">8</option>
				 </select></td>
        	</div>
        </td>
    </tr>
    <tr><td>
    &nbsp;&nbsp;</td>
    </tr>   
 </table>   
 </form>



<div id="loading_process"><center><img src="<?=base_url()?>assets/img/loading_ajax.gif" alt="Sedang process"/> Sila tunggu...<center></div>
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
				<td>
					<b>Status</b>
				</td>
				<td>
					<center><b>:</b></center>
				</td>
				<td id="td_status" colspan="2">
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
				<table width="100%" id="tbl_vokasional" class="table">
					<thead>
					<th colspan="2"><center>Vokasional</center></th>
					</thead>
					<tbody>
					</tbody>
				</table>
				<table width="100%" id="tbl_add_module" class="table">
					<tbody>
					<tr>
					<td><input type="text" id="searchModule" class="validate[required]" style="width:80%;">
					<span class="pull-right">
					<button class="btn btn-small btn-primary" type="button" id="add_module" data-original-title="Tambah Modul"><i class="icon-plus icon-white"></i></button>
					</span>
					</td>
					</tr>
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
</div>




<!--
<button class="btn btn-primary pull-right"> Save </button>
-->