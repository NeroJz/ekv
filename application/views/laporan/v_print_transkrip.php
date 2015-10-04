<html>
<head>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/print_setting.js"></script>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

<input id="idPrint" name="idPrint" type="button"  value="Cetak Transkrip" onClick="printit(jspOptions)">
<title>Examination Result Transkrip</title>

<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap2.css" media="screen,print" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap-responsive.css" media="screen" />


<STYLE TYPE="text/css" media="screen,print" >
     P.breakhere {page-break-before: always}
     body		{font-size: 4pt !important;font-family:arial;}
	.header		{font-size:9pt;font-weight:bold;}
	.colheader	{font-size:8pt;font-weight:bold;padding-left:2pt;padding-right:2pt;}
	.colheader2	{font-size:7pt;font-weight:bold;padding-left:2pt;padding-right:2pt;}
	.subheader	{font-size:8pt;font-weight:bold;padding-left:2pt;padding-right:2pt;}
	.desc		{font-size:7pt;padding-left:2pt;padding-right:2pt;}
	.descbold	{font-size:8pt;padding-left:2pt;padding-right:2pt;font-weight:bold;height:10pt;}
	.descs		{font-size:7pt;padding-left:2pt;padding-right:2pt;}
	.descsbold	{font-size:7pt;padding-left:2pt;padding-right:2pt;font-weight:bold;}
	.descxsitalic	{font-size:7pt;padding-left:2pt;padding-right:2pt;font-style:italic}
	.amaun		{font-size:8pt;text-align:right;padding-left:2pt;padding-right:2pt;}
	.total		{font-size:8pt;text-align:right;font-weight:bold;padding-left:2pt;padding-right:2pt;}
	.grandtotal	{font-size:8pt;text-align:right;font-weight:bold;padding-left:2pt;padding-right:2pt;border-top:2px #000000 solid;border-bottom:5px #000000 double;}
	.linetop	{font-size:8pt;font-weight:bold;border-top:2px #000000 solid;padding-left:2pt;padding-right:2pt;}
	.linebottom	{font-size:8pt;font-weight:bold;border-bottom:2px #000000 solid;padding-left:2pt;padding-right:2pt;}
	#break{page-break-after: always;}
	.BG {
			background-image:url(../../../assets/img/bg_result.png);
			background-repeat:no-repeat;/*dont know if you want this to repeat, ur choice.*/
			height:10%;
			width:10%
		}

@page 
{
    size: auto;   /* auto is the current printer page size */
    margin: 0mm;  /* this affects the margin in the printer settings */
}

#BrowserPrintDefaults{display:none} 

#break{page-break-after: always;}
#student{width:100%;}

.colheader {
	font-size: 8pt;
	font-weight: bold;
	padding-left: 2pt;
	padding-right: 2pt;
	height: 1px;
}

.colheader2 {
	font-size: 7pt;
	font-weight: bold;
	padding-left: 2pt;
	padding-right: 2pt;
	height: 1px;
}

.desc {
	font-size: 7pt;
	padding-left: 2pt;
	padding-right: 2pt;
	height: 1px;
}

table td{ vertical-align: top !important;}
</STYLE>
<style type="text/css" media="print" >
#idPrint {
	display: none !important;
	position: absolute;
	
}

table td{ vertical-align: top !important; }
</style>

<script type="text/javascript">
  //parameter untuk set jsPrintSetup option
  var jspOptions = [];

  //jika ada perubahan/penambahan guna push sebab saya pakai json
  //contoh option yang ada boleh rujuk kat sini : https://addons.mozilla.org/en-US/firefox/addon/js-print-setup/‎
  //ni example : 
  //jspOptions.push({'id':"headerStrLeft",'val':'sukor'});

</script>

</head>


<body>
<?php 


$loopCount = 0;

foreach ($resultS as $key => $value)
{
?>
<div <?php if($loopCount > 0){?>style="page-break-before: always"<?php }?>>
<div class="row-fluid">
	<div class="span12">
		<center>
			
			<span class="colheader">LEMBAGA PEPERIKSAAN<br>
									KEMENTERIAN PENDIDIKAN MALAYSIA
			</span><br>
			<span class="desc">TRANSKRIP KOLEJ VOKASIONAL</span><br/>
		</center>
		<table width="100%" cellpadding="0" cellspacing="0" border="0" >
			<tr>
				<td class="descbold" style="width:72pt;">NAMA</td>
				<td class="descbold" style="width:15pt;">:</td>
				<td class="descbold" style="width:148pt;"><?=strtoupper($value->stu_name)?></td>
			</tr>
			<tr>
				<td class="descbold" style="width:72pt;">NO K/P</td>
				<td class="descbold" style="width:15pt;">:</td>
				<td class="descbold" style="width:148pt;"><?=$value->stu_mykad?></td>
			</tr>
			<tr>
				<td class="descbold" style="width:72pt;">ANGKA GILIRAN</td>
				<td class="descbold" style="width:15pt;">:</td>
				<td class="descbold" style="width:148pt;"><?=$value->stu_matric_no?></td>
			</tr>
			<tr>
				<td class="descbold" style="width:72pt;">INSTITUSI</td>
				<td class="descbold" style="width:15pt;">:</td><
				<td class="descbold" style="width:148pt;" ><?=strtoupper($value->col_name)?></td>
			</tr>
			<tr>
				<td class="descbold" style="width:72pt;">KLUSTER</td>
				<td class="descbold" style="width:15pt;">:</td>
				<td class="descbold" ><?=strtoupper($value->cou_cluster)?></td>
		    </tr>
		    <tr>
				<td class="descbold" style="width:72pt;">KURSUS</td>
				<td class="descbold" style="width:15pt;">:</td>
				<td class="descbold" style="width:148pt;"><?=strtoupper($value->cou_name)?></td>
		    </tr>
		    <tr>
		    	<td style="width:148pt;" colspan="6">&nbsp;</td>
		    </tr>
		</table>
	</div>
</div>
<?php
	$bil=0;
	$semMt='';
	
	foreach ($value->mtaken as $keymt => $row)
	{	
		if( $semMt!=$row->mt_semester || $semMt=='' )
		{
			$bil=0;
		}
		
		$bil++;

		$subPaper[$row->mt_semester][$bil]=$row->mod_paper;
		$subName[$row->mt_semester][$bil]=strtoupper($row->mod_name);
		$subtype[$row->mt_semester][$bil]=$row->grade_type;
		$mtcount[$row->mt_semester]=$bil;
		$modcredit[$row->mt_semester][$bil]=$row->mod_credit_hour;
		$subEn[$row->mt_semester][$bil]=$row->mod_en;
		
		$semMt=$row->mt_semester;
	}
	
	foreach ($value->results as $keys => $rows)
	{
		$semr[$rows->semester_count]=$rows->semester_count;
		$pngvd[$rows->semester_count]=$rows->pngv;
		$pngkvd[$rows->semester_count]=$rows->pngkv;
		$pngkd[$rows->semester_count]=$rows->pngk;
		$pngkkd[$rows->semester_count]=$rows->pngkk;
		$cuyeard[$rows->semester_count]=$rows->current_year;
		
		$pnga[$rows->semester_count]=$rows->pnga;
		$pngka[$rows->semester_count]=$rows->pngka;
	}					
?>
<div class="row-fluid">
	<div class="span6">
		<?php
		for ($n=1; $n<=9; $n++)
		{
			if( $n%2 != 0 )
			{ 
				if(isset($semr[$n]))
				{
		?>
			<br>
			<table style="min-height:200px;" width="100%" cellpadding=0 cellspacing=0 border=0 >
			<tr>
				<td>
				<table style="height: 200px;" width="100%" cellpadding=0 cellspacing=0 border=0 >
					<tr >
						<td class="colheader" width="6%" colspan="4">SEMESTER <?=$n?> TAHUN <?=$cuyeard[$n]?></td>
					</tr>
					<tr >
						<td class="colheader2" width="6%">KOD</td>
						<td class="colheader2" >MATA PELAJARAN</td>
						<td class="colheader2" width="10%" align="center">JAM KREDIT</td>
						<td class="colheader2" width="10%" align="left">GRED</td>
					</tr>
					<?php
						for ($i=1; $i<=$mtcount[$n]; $i++)
		                {
					?>
							<tr>
								<td class="desc" valign="top"><?= $subPaper[$n][$i]; ?></td>
								<?php if($subEn[$n][$i]==1){ ?>
								<td class="desc" valign="top" style="padding-bottom: 0px;"><i><?= $subName[$n][$i]; ?></i></td>
								<?php }else{ ?>
								<td class="desc" valign="top" style="padding-bottom: 0px;"><?= $subName[$n][$i]; ?></td>
								<?php } ?>
								<td class="desc" align="center" valign="top" style="padding-bottom: 0px;"><?= $modcredit[$n][$i]; ?></td>
								<td class="desc" style="text-align:left;" valign="top" >&nbsp;&nbsp;&nbsp;&nbsp;<?= $subtype[$n][$i]; ?></td>
							</tr>
					<?php
		                }
		            ?>
		            <tr><td colspan="4">&nbsp;</td></tr>           
		        </table>        
		        <table cellpadding="0" cellspacing="0" border="0" width="100%">
		        	<tr>
		        		<td>
			        		<table cellpadding="0" cellspacing="0" border="0" width="100%">
			        			<tr>
			        				<td class="descxsitalic" colspan="2">PNGBM</td>
			        				<td class="descxsitalic" width="3%" align="center">:</td>
			        				<td class="descxsitalic" width="51%"><?=number_format(get_png_bm($value->stu_matric_no,$n),2)?></td>
			        			</tr>
			        			<tr>
			        				<td class="descxsitalic" colspan="2">PNGK BM</td>
			        				<td class="descxsitalic" width="3%" align="center">:</td>
			        				<td class="descxsitalic" width="51%"><?=number_format(get_pngk_bm($value->stu_matric_no,$n),2)?></td>
			        			</tr>
			        			<tr>
			        				<td class="descxsitalic" colspan="2">PNGA</td>
			        				<td class="descxsitalic" width="3%" align="center">:</td>
			        				<td class="descxsitalic" width="51%"><?=number_format($pnga[$n],2)?></td>
			        			</tr>
			        			<tr>
			        				<td class="descxsitalic" colspan="2">PNGKA</td>
			        				<td class="descxsitalic" align="center">:</td>
			        				<td class="descxsitalic" ><?=number_format($pngka[$n],2)?></td>
			        			</tr>  
			        			<tr>
			        				<td class="descxsitalic" colspan="2">PNGV</td>
			        				<td class="descxsitalic" width="3%" align="center">:</td>
			        				<td class="descxsitalic" width="51%"><?=number_format($pngvd[$n],2)?></td>
			        			</tr>
			        			<tr>
			        				<td class="descxsitalic" colspan="2">PNGKV</td>
			        				<td class="descxsitalic" align="center">:</td>
			        				<td class="descxsitalic" ><?=number_format($pngkvd[$n],2)?></td>
			        			</tr>                  
			                    <tr>
			        				<td class="descxsitalic" colspan="2">PNGK</td>
			        				<td class="descxsitalic" align="center">:</td>
			        				<td class="descxsitalic"><?=number_format($pngkd[$n],2)?></td>
			                    </tr>
			                    <tr>
			        				<td class="descxsitalic" colspan="2">PNGKK</td>
			        				<td class="descxsitalic" align="center">:</td>
			        				<td class="descxsitalic" ><?=number_format($pngkkd[$n],2)?></td>
			                    </tr> 
			                    <tr>
			        				<td colspan="3">&nbsp;</td>
			                    </tr>
			                 </table>
			             </td>
					</tr>
				</table>
				</td>
			</tr>
		</table>
		<?php
				}
			}
		}
		?>
		<br>	
	</div>
	<div class="span6">
	<?php 
	for ($m=1; $m<=10; $m++)
	{
		if( $m%2 == 0 )
		{ 
			if(isset($semr[$m]))
			{
	?>
	<br>
	<table style="min-height:200px;" width="100%" cellpadding=0 cellspacing=0 border=0 >
	<tr>
	<td>
			<table style="height: 200px;" width="100%" cellpadding=0 cellspacing=0 border=0 >
				<tr >
					<td class="colheader" width="6%" colspan="4">SEMESTER <?=$m?> TAHUN <?=$cuyeard[$m]?></td>
				</tr>
				<tr >
					<td class="colheader2" width="6%">KOD</td>
					<td class="colheader2" width="40%">MATA PELAJARAN</td>
					<td class="colheader2" width="10%" align="center">JAM KREDIT</td>
					<td class="colheader2" width="7%" align="left">GRED</td>
				</tr>
				<?php
				if(isset($mtcount[$m]))
				{
					for ($i=1; $i<=$mtcount[$m]; $i++)
	                {
				?>
						<tr>
							<td class="desc" valign="top"><?=$subPaper[$m][$i]?></td>
							<!-- <td class="desc" ><?=$subName[$m][$i]?></td> -->
							<?php if($subEn[$m][$i]==1){ ?>
							<td class="desc" valign="top"><i><?= $subName[$m][$i]; ?></i></td>
							<?php }else{ ?>
							<td class="desc" valign="top"><?= $subName[$m][$i]; ?></td>
							<?php } ?>
							<td class="desc" align="center" valign="top"><?=$modcredit[$m][$i]?></td>
							<td class="desc" valign="top" style="text-align:left;">&nbsp;&nbsp;&nbsp;&nbsp;<?=$subtype[$m][$i]?></td>
						</tr>
				<?php
	                }
				}
	            ?>
	            <tr><td colspan="4">&nbsp;</td></tr>        
	        </table>
	        <table cellpadding="0" cellspacing="0" border="0" width="100%" >
	        	<tr>
	        		<td>
		        		<table cellpadding="0" cellspacing="0" border="0" width="100%">
							<tr>
			       				<td class="descxsitalic" colspan="2">PNGBM</td>
			       				<td class="descxsitalic" width="3%" align="center">:</td>
			       				<td class="descxsitalic" width="51%"><?=number_format(get_png_bm($value->stu_matric_no,$m),2)?></td>
			       			</tr>
			       			<tr>
			       				<td class="descxsitalic" colspan="2">PNGK BM</td>
			        			<td class="descxsitalic" width="3%" align="center">:</td>
			        			<td class="descxsitalic" width="51%"><?=number_format(get_pngk_bm($value->stu_matric_no,$m),2)?></td>
			        		</tr>
		        			<tr>
			        			<td class="descxsitalic" colspan="2">PNGA</td>
			        			<td class="descxsitalic" width="3%" align="center">:</td>
			       				<td class="descxsitalic" width="51%"><?=number_format($pnga[$m],2)?></td>
			       			</tr>
			       			<tr>
			       				<td class="descxsitalic" colspan="2">PNGKA</td>
			       				<td class="descxsitalic" align="center">:</td>
			       				<td class="descxsitalic" ><?=number_format($pngka[$m],2)?></td>
			       			</tr>  
		        			<tr>
		        				<td class="descxsitalic" colspan="2">PNGV</td>
		        				<td class="descxsitalic" width="3%" align="center">:</td>
		        				<td class="descxsitalic" width="51%"><?=number_format($pngvd[$m],2)?></td>
		        			</tr>
		        			<tr>
		        				<td class="descxsitalic" colspan="2">PNGKV</td>
		        				<td class="descxsitalic" align="center">:</td>
		        				<td class="descxsitalic" ><?=number_format($pngkvd[$m],2)?></td>
		        			</tr>                  
		                    <tr>
		        				<td class="descxsitalic" colspan="2">PNGK</td>
		        				<td class="descxsitalic" align="center">:</td>
		        				<td class="descxsitalic"><?=number_format($pngkd[$m],2)?></td>
		                    </tr>
		                    <tr>
		        				<td class="descxsitalic" colspan="2">PNGKK</td>
		        				<td class="descxsitalic" align="center">:</td>
		        				<td class="descxsitalic" ><?=number_format($pngkkd[$m],2)?></td>
		                    </tr>
		                    <tr>
		        				<td colspan="3">&nbsp;</td>
		                    </tr>                 
		                 </table>
		             </td>
				</tr>
			</table>		
	        </td>
	        </tr>
	        </table>
	<?php
			}
		}
	}
	?>
	<br>
	</div>
</div>
<br/>
</div>
<!--<span style="page-break-before: always"></span>-->
<?php
	//for page break
	$loopCount++;
}
?>
</body>			
</html>