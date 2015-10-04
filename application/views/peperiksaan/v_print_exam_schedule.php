<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.js"></script>
<STYLE TYPE="text/css" >

	.colheader	{font-size:9pt;font-weight:bold;padding-left:2pt;padding-right:2pt;}
	.desc		{font-size:8pt;padding-left:2pt;padding-right:2pt;}
	.descbold	{font-size:11pt;padding-left:2pt;padding-right:2pt;font-weight:bold;height:10pt;}
	.descc		{font-size:11pt;padding-left:2pt;padding-right:2pt;height:10pt;}
	.dep		{font-size:9pt;}
	
	
	.tables td{ border: 1px solid #000000;}
	.tables2{ border-right:none; border-left:none; }
	.tables2 td{ border-bottom:none;}
	.tables3 td{ border:none; padding:3px;}
	.tables4 {border-top:none; border-bottom: none;}
	.tables5 td{border-right: none}
	
	.left {width: 50%;}
	.right{margin-left: 50%;}

</STYLE>
<STYLE TYPE="text/css" media="print">
#break{page-break-after: always;}
#student{width:100%;}
</STYLE>

<script>
	function printit() {
	document.getElementById('idPrint').style.display = 'none';
	window.print()
	setTimeout("document.getElementById('idPrint').style.display = 'block';", 5000);
	}


	/***********************************************************************************************
	* Description 		: this function make rowspan for table 
	* input				: 
	* author			: Freddy Ajang Tony
	* Date				: 27.11.2013
	* Modification Log	: 
	***********************************************************************************************/
	function fnRowSpan2(column, ignorePre)
	{

	   //alert(column);
	   var currentCell2;
	   var rowSpan = 1;
	   var prevCell;
	   
	   
	   column.each(function()
	   {
	       
	       if(typeof currentCell2 == "undefined")
	       {
	           currentCell2 = $(this);
	       }
	       
	       else 
	       { 
	       		
	           if(!ignorePre)
	           {
	           	//alert(currentCell2.text()+"="+$(this).text());
	           		if(currentCell2.text()==$(this).text() && 
		           	currentCell2.prev().html()==$(this).prev().html())
		           {
		           	
		           
		            // console.log("try");
		           	//alert(currentCell2.text()+$(this).text());
		            
		               $(this).hide();
		               rowSpan++;
		           }
		           
		           else
		           {
		               currentCell2 = $(this);
		               rowSpan=1;
		           }
	           	 currentCell2.attr('title',rowSpan);
	           }
	           
	           else
	           {
	           		if(currentCell2.text()==$(this).text())
		           {
		               $(this).hide();
		               
		               rowSpan++;
		           }
		           else
		           {
		               currentCell2 = $(this);
		               rowSpan=1;
		           }
		             
	           }
	           
	           currentCell2.attr('rowSpan',rowSpan);
	         
	          
	       }
	       
	       
	     	//console.log(rowSpan);   
	   });
	}
</script>
<script type="text/javascript">
$(document).ready(function(){
	fnRowSpan2($("#tbl_exam_schedule tbody tr > :nth-child(1)"), true);
});
</script>
<style type="text/css" media="print" >
#idPrint {
	display: none !important;
	position: absolute;
	
}
</style>
<input id="idPrint"    type="button" onclick="printit()" value="Cetak" name="idPrint">

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
	<title>Exam Schedule Slip</title>
</head>
	<body>
<?php
if(!empty($student_data)){

	$loopCount = 0;
	
	foreach ($student_data as $value)
	{
?>	
		<div <?php if($loopCount > 0){?>style="page-break-before: always"<?php }?>>
		<table width="100%" cellpadding="0" cellspacing="0" class="dep">
			<tr>
				<td class="descbold" colspan="9" align="center" style="font-size:10pt;">LEMBAGA PEPERIKSAAN</td>
			</tr>
		
			<tr>
				<td class="descbold" colspan="9" align="center" style="font-size:10pt;">KEMENTERIAN PENDIDIKAN MALAYSIA</td>
			</tr>
			<tr>
				<td colspan="9"><br></td>
			</tr>
			<tr>
				<td class="descbold" colspan="9" align="center" style="font-size:10pt;">JADUAL KEMASUKAN PENILAIAN AKHIR</td>	
			</tr>
			<tr>
				<td class="descbold" colspan="9" align="center" style="font-size:10pt;">SEMESTER <?= $semester ?> <?= date("Y") ?></td>	
			</tr>
			<tr>
				<td colspan="9"><br><br></td>
			</tr>
			<tr>
				<td style="font-weight:bold;">Angka Giliran</td>
				<td align="center">:</td>
				<td colspan="7">&nbsp;&nbsp;&nbsp;<?= $value->stu_matric_no?></td>
			</tr>
			
			<tr>
				<td style="font-weight:bold;">Nama Pusat/Sekolah</td>
				<td align="center">:</td>
				<td colspan="7">&nbsp;&nbsp;
				<?=$college->col_type.$college->col_code; ?> -
				 <?=$college->col_name;?></td>
			</tr>
			<tr>
				<td colspan="9"><br></td>
			</tr>
			<tr>
				<td style="font-weight:bold;">Nama</td>
				<td align="center">:</td>
				<td colspan="7">&nbsp;&nbsp;&nbsp;<?= $value->stu_name?></td>
			</tr>
			
			<tr>
				<td style="font-weight:bold;">No. Kad Pengenalan</td>
				<td align="center">:</td>
				<td width="30%">&nbsp;&nbsp;&nbsp;<?= $value->stu_mykad?></td>
				<td width="5%" style="font-weight:bold;">Agama</td>
				<td align="center">:</td>
				<td>&nbsp;&nbsp;&nbsp;<?= $value->stu_religion?></td>
				<td align="right" style="font-weight:bold;">Jantina</td>
				<td align="center">:</td>
				<td>&nbsp;&nbsp;&nbsp;<?= $value->stu_gender?></td>
			</tr>
			
			<tr>
				<td style="font-weight:bold;">Jenis Pendaftaran</td>
				<td align="center">:</td>
				<td>&nbsp;&nbsp;&nbsp;Calon baru</td>
				<td style="font-weight:bold;">Keturunan</td>
				<td align="center">:</td>
				<td colspan="4">&nbsp;&nbsp;&nbsp;<?= $value->stu_race?></td>
			</tr>
			<tr>
				<td colspan="9"><br></td>
			</tr>
			<tr>
				<td style="vertical-align: top;font-weight:bold;">Mata Pelajaran Yang Diambil</td>
				<td align="center" style="vertical-align: top;">:</td>
				<td colspan="7">
					<table width="100%" class="dep">
					<?php 
					$count = 0;
					if($value->stu_module_exam != null)
					{	
						foreach($value->stu_module_exam as $modul)
						{
							if($count == 0 || $count == 4 || $count == 8)
							{?>
							<tr>
					<?php    }?>			
							<td>&nbsp;&nbsp;&nbsp;<?= $modul->mod_paper;?> - 1</td>
							
					<?php   if($count == 3 || $count == 7 || $count == 11)
							{?>
							</tr>
						<?php 
							}
							
							$count++;
						}
					}
						?>
						
						<!-- <tr >
							<td>1103 - 1,2</td>
							<td>1119 - 1,2</td>
							<td>1249 - 1,2,3</td>
							<td>1449 - 1,2</td>
						</tr>
						
						<tr >
							<td>1677 - 1,2,3</td>
							<td>1234 - 1,2,3</td>
							<td>1250 - 1,2</td>
							<td>1005 - 1,2</td>
						</tr>
						<tr >
							<td>1113 - 1,2</td>
							<td>1229 - 1,2,3</td> 
						</tr>-->
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="9"><br></td>
			</tr>
			<tr>
				<td style="font-weight:bold;">Jumlah Mata Pelajaran</td>
				<td align="center">:</td>
				<td colspan="7">&nbsp;&nbsp;&nbsp;<?=$count ?></td>
			</tr>
			<tr>
				<td colspan="9"><br></td>
			</tr>
			<tr>
				<td colspan="9" class="descbold" style="font-size:9pt;">Nota : Mata Pelajaran bertanda (*) adalah Mata Pelajaran Tambahan</td>
			</tr>
			
			<tr>
				<td>&nbsp;</td>
			</tr>
			
			<tr>
				<td colspan="9" style="font-size:9pt;">**Calon yang mendaftar mata pelajaran 
							Sejarah, sila pastikan anda memperolehi 
							Tema Umum untuk Sejarah Kertas 3 (1249/3) 
							di portal<br> LP http://www.moe.gov.my/lp bermula
							pada 6 minggu sebelum tarikh permulaan
							peperiksaan bertulis.</td>
				
			</tr>
			
			<tr>
				<td>&nbsp;</td>
			</tr>
			
			<tr>
				<td class="descbold" colspan="9" style="font-size:9pt;">PERINGATAN : BAWA KENYATAAN KEMASUKAN INI SETIAP KALI MENGHADIRI PEPERIKSAAN</td>
				
			</tr>
			
			<tr>
				<td colspan="9"><br><br></td>
			</tr>
			
			</table>
			</br></br>
			<center>
				<table class="tables" id="tbl_exam_schedule" width="90%" cellpadding="0" cellspacing="0">
				
				<tr>
					<td class="descbold" colspan="3" align="center" style="border: none;font-size: 9pt;">
					JADUAL WAKTU PEPERIKSAAN BERTULIS SPM <?=date("Y");?><br></td>
				</tr>
				
				<tr>
					<td class="descbold" width="17%"style="font-size:9pt;">TARIKH</td>
					<td class="descbold" width="23%" style="border-left: none;font-size: 9pt;">MASA</td>
					<td class="descbold" width="50%" style="border-left: none;font-size: 9pt;">KERTAS</td>
				</tr>
				<?php 
				if($value->stu_module_exam != null)
				{
					foreach($value->stu_module_exam as $modul)
					{
				?>	
				<tr>
					<td style="border-top: none;font-size:8pt;padding-left:2pt;">
					<?= $modul->schedule_date == null ? "&nbsp;-&nbsp" : date('d/m/Y',$modul->schedule_date); ?>
					&nbsp; <?=$modul->schedule_date == null ? "" : "(".$this->func->getDayInMalay(date('l',$modul->schedule_date)).")"; ?>
					</td>
					<td style="border-left: none;border-top: none;font-size:8pt;padding-left:2pt;">
					<?= $modul->schedule_time_start == null ? "" : date('g:i',strtotime($modul->schedule_time_start))?>
					<?php
						if($modul->schedule_time_start != null){
							if ($modul->schedule_time_start < 1200) {
								echo " pagi";
							} else if ($modul->schedule_time_start < 1300) {
								echo " tgh hari";
							} else if ($modul->schedule_time_start < 1900) {
								echo " petang";
							} else {
								echo " malam";
							}
						}
						
					?>&nbsp;-&nbsp;
					<?= $modul->schedule_time_end == null ? "" : date('g:i',strtotime($modul->schedule_time_end))?>
					<?php
						if($modul->schedule_time_end != null){
							if ($modul->schedule_time_end < 1200) {
								echo " pagi";
							} else if ($modul->schedule_time_end < 1300) {
								echo " tgh hari";
							} else if ($modul->schedule_time_end < 1900) {
								echo " petang";
							} else {
								echo " malam";
							}
						}
					?>
					</td>
					<td style="border-left: none;border-top: none;font-size:8pt;padding-left:2pt;">
					<?= $modul->mod_paper;?> - <?= strcap($modul->mod_name);?>
					</td>
				</tr>
				<?php 
					}
				}
				else
				{
				?>
				<tr>
					<td colspan="3" style="border-top: none;font-size:8pt;" align="center">Tiada Jadual</td>
				</tr>
				<?php
				}
				?>
					
				<!--<tr rowspan="2">
          
					<td style="border-left: none;border-top: none;">02.00 petang - 04.00 petang</td>
					<td style="border-left: none;border-top: none;">1103 - Bahasa Melayu Kertas 2</td>
				</tr>
				
				<tr rowspan="2">
					<td rowspan="2" style="border-top: none;">07/11/2013</td>
					<td style="border-left: none;border-top: none;">08.00 pagi - 11.15 pagi</td>
					<td style="border-left: none;border-top: none;">1119 - Bahasa English Kertas 1</td>
				</tr>
					
				<tr rowspan="2">
					<td style="border-left: none;border-top: none;">02.00 petang - 04.30 petang</td>
					<td style="border-left: none;border-top: none;">1119 - Bahasa English Kertas 2</td>
				</tr>
				
				<tr rowspan="2">
					<td rowspan="2" style="border-top: none;">08/11/2013</td>
					<td style="border-left: none;border-top: none;">09.00 pagi - 11.45 pagi</td>
					<td style="border-left: none;border-top: none;">1249 - Sejarah Kertas 1</td>
				</tr>
					
				<tr rowspan="2">
					<td style="border-left: none;border-top: none;">02.00 petang - 04.45 petang</td>
					<td style="border-left: none;border-top: none;">1249 - Sejarah Kertas 2</td>
				</tr>-->
				
			</table>
			<br>
			<br>
			</center>
			</div>
<?php
		$loopCount++;
	}
	}else{
		echo "Tiada Maklumat";
	}
?>			
			
		</body>
	</html>
