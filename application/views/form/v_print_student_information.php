<script language="javascript" type="text/javascript" src="<?=base_url() ?>assets/js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/print_setting.js"></script>
<style type="text/css" media="print">
	.dataNumber {
		padding: 0px 5px 0px 5px;
		text-align: right;
		font-size: 10;
	}
	
	.dataString{
		padding: 0px 0px 0px 5px;
		text-align: left;
		font-size: 10;
	}
	
	.colheader {
		font-size: 9pt;
		font-weight: bold;
		padding-left: 2pt;
		padding-right: 2pt;
	}
	.desc {
		font-size: 8pt;
		padding-left: 2pt;
		padding-right: 2pt;
	}
	.descbold {
		font-size: 10pt;
		padding-left: 2pt;
		padding-right: 2pt;
		font-weight: bold;
		height: 10pt;
	}
	.descc {
		font-size: 10pt;
		padding-left: 2pt;
		padding-right: 2pt;
		height: 10pt;
	}
	.dep {
		font-size: 9pt;
	}
	
	.tables td {
		border: 1px solid #000000;
	}

	.tables2 {
		border-right: none;
		border-left: none;
	}
	.tables2 td {
		border-bottom: none;
	}
	.tables3 td {
		border: none;
		padding: 3px;
	}
	.tables4 {
		border-top: none;
		border-bottom: none;
	}

	
	@page 
{
    size: auto;   /* auto is the current printer page size */
    margin: 0mm;  /* this affects the margin in the printer settings */
}

#BrowserPrintDefaults{display:none} 

#break{page-break-after: always;}
#student{width:100%;}
</STYLE>

<script type="text/javascript">
  //parameter untuk set jsPrintSetup option
  var jspOptions = [];

  //jika ada perubahan/penambahan guna push sebab saya pakai json
  //contoh option yang ada boleh rujuk kat sini : https://addons.mozilla.org/en-US/firefox/addon/js-print-setup/‎
  //ni example : 
  //jspOptions.push({'id':"headerStrLeft",'val':'sukor'});

</script>
	
	
	
<STYLE TYPE="text/css" media="screen">
	.dataNumber {
		padding: 0px 5px 0px 5px;
		text-align: right;
		font-size: 12;
	}
	
	.dataString{
		padding: 0px 0px 0px 5px;
		text-align: left;
		font-size: 12;
	}
	
	.colheader {
		font-size: 11pt;
		font-weight: bold;
		padding-left: 2pt;
		padding-right: 2pt;
	}
	.desc {
		font-size: 10pt;
		padding-left: 2pt;
		padding-right: 2pt;
	}
	.descbold {
		font-size: 12pt;
		padding-left: 2pt;
		padding-right: 2pt;
		font-weight: bold;
		height: 10pt;
	}
	.descc {
		font-size: 12pt;
		padding-left: 2pt;
		padding-right: 2pt;
		height: 10pt;
	}
	.dep {
		font-size: 11pt;
	}

	.tables td {
		border: 1px solid #000000;
	}

	.tables2 {
		border-right: none;
		border-left: none;
	}
	.tables2 td {
		border-bottom: none;
	}
	.tables3 td {
		border: none;
		padding: 3px;
	}
	.tables4 {
		border-top: none;
		border-bottom: none;
	}

</STYLE>
<STYLE TYPE="text/css" media="print">
	#break {
		page-break-after: always;
		position: relative;
	}
	#student {
		width: 100%;
	}
</STYLE>

<style type="text/css" media="print" >
	#idPrint {
		display: none !important;
		position: absolute;
	}
</style>
<input id="idPrint"    type="button" onclick="printit(jspOptions)" value="Cetak" name="idPrint">
<?php
if(!empty($student)){
	
	$search=explode("|", $search);
	$col_name= $search[0];
	$cou_id = $search[1];
	$current_sem= $search[2];
    $current_year = $search[3];
	$status_stu = $search[4];
?>		
          	<table width="100%" cellpadding="0" cellspacing="0" id="student">
          	<thead>
          		<tr height="20px">
                	<td colspan="11" align="center" class="dep">
                		<br>
                		<b style="font-size: 16">Pengesahan Maklumat Pendaftaran bagi SEM <?=$current_sem ?> <?=$current_year ?></b>
                    </td>
                </tr>
				<tr>
                	<td  width="">&nbsp; </td>
                    <td  width="1%">&nbsp; </td>
                    <td >&nbsp; </td>
                    <td >&nbsp; </td>
                    <td >&nbsp; </td>
                    <td >&nbsp; </td>
                    <td >&nbsp; </td>
                    <td >&nbsp; </td>
                    <td >&nbsp; </td>
                    <td >&nbsp; </td>
                    <td >&nbsp; </td>
				</tr>
        	  	<tr bgcolor="#ffffff"  class="tables">
              		<td  bgcolor="#ffffff"  align="center" class="descbold" style="border-right:none;">BIL</td>
                	<td  align="center" class="descbold">NAMA</td>
                	<td  align="center" class="descbold">MYKAD</td>
                	<td  align="center" class="descbold">A/GILIRAN</td>
                	<td  align="center" class="descbold">KURSUS</td>
                	<td  align="center" class="descbold">JANTINA</td>
                	<td  align="center" class="descbold">KAUM</td>
                	<td  align="center" class="descbold">AGAMA</td>
                	<td  align="center" class="descbold">STATUS</td>
                	<td  align="center" class="descbold">T/TANGAN</td>
                	<td  align="center" class="descbold">CATATAN</td>
				</tr>
			</thead>
			<tbody>
              <?php 
              $bil = 0;
			  $b=0;
              foreach($student as $row)
			  {
			 // for ($s=1; $s<=4; $s++){
			  
			  	$bil++;
				$b++;
				
				if($b=='20'){
					if(($b%20)==0){
              $tr='id="break"';
              }else{
              	$tr='';
			  }
					
				}else{
				$bc=$b-20;	
			if((($bc)%20)==0){
              $tr='id="break"';
              }else{
              	$tr='';
			  }
					
				}
				
					
				
			
              ?>
              	<tr <?=$tr ?> class="tables">
						<!-- start content -->
                    	<td class="dataNumber"><?= $bil ?></td>
                        <td class="dataString" width="30%"><?=$row->stu_name?></td>
                        <td class="dataString"><?=$row->stu_mykad?></td>
                        <td class="dataString"><?=$row->stu_matric_no?></td>
                        <td class="dataString"><?=$row->cou_course_code?></td>
                        <td class="dataString"><?=strtoupper($row->stu_gender)?></td>
                        <td class="dataString"><?=$row->stu_race?></td>
                        <td class="dataString"><?=$row->stu_religion?></td>
                        <td class="dataString"><?=$row->stat_id?></td>
                        <td align="center">&nbsp;</td>
                        <td align="center">&nbsp;</td>
				</tr>
						</td>
						<!-- end content -->
					</tr>
					<?php } ?>
					</tbody>
					<tfoot>
						<tr >
							<td align="right" colspan="11"><?=br(5)?>_____________________________<?=br()?>Pengesahan Pengarah<br><?=date("d F Y")?></td>							
						</tr>
					</tfoot>
				
				</table>

					
									
					<?php
					}else{
					echo "Tiada Maklumat";
					}
				?>