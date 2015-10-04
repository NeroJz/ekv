<?php
/**************************************************************************************************
* File Name        : v_print_writtenform.php
* Description      : This File contain written form to be print
* Author           : Norafiq Bin Mohd Azman Chew
* Date             : 25 July 2013
* Version          : -
* Modification Log : siti umairah . get total tugasan 31 januari 2014
* Function List	   : -
**************************************************************************************************/
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title> <?=isset($title)?$title:"Borang Pengisian Markah K15"?> </title>
    <link rel="shortcut icon" href="images/favicon.ico">

    <style type="text/css">
		body
		{
			padding-bottom: 40px;
			font-size: 12pt;
		}
		  
		.sidebar-nav
		{
			padding: 9px 0;
		}
		  
		.cellHighlight 
		{
			background-color: Lime;
		}
		
		.data_table 
		{
			text-align: center;
		}
		
		.maintitle1 
		{
			text-align: left;
		}
		
		.maintitle
		{
			text-align: center;
		}
	  
		P.breakhere 
		{
			page-break-before: always;
		}
		table.results
		{
		
			border-width: 0px;
			border-spacing: 0px;
			border-style: solid;
			border-color: gray;
			border-collapse: collapse;
			background-color: white;
		}
		
		table.results2
		{
			font-size: 9pt;
			border-width: 0px;
			border-spacing: 0px;
			border-style: solid;
			border-color: gray;
			border-collapse: collapse;
			background-color: white;
		}
		
		.fbold
		{
			font-weight:bold;
		}
    </style>
    <style>
		@media print
		{
		  tr{ page-break-inside:avoid; page-break-after:auto }
		}
	</style>
<meta charset="utf-8">
</head>
<body onLoad="fonload()">
<script>

var base_url = '<?=base_url();?>';
var site_url = '<?=site_url();?>/';

function setPageBreak()
{
	document.getElementById("pbreak").style.pageBreakAfter="always";
}
	
function displayLoadingBox()
{
	var loadingBox = document.createElement("div");
	loadingBox.id = 'loadingbox';
	document.body.appendChild(loadingBox);
	var lBox = document.getElementById("loadingbox");
	lBox.style.width = '350px';
	lBox.style.height = '40px';
	//lBox.style.textAlign = 'center';
	lBox.style.border='2px #666666 solid';
	lBox.style.backgroundColor='#ffffff';
	lBox.innerHTML = '<div style="font-size: 8pt;font-family:arial;">&nbsp;Keputusan Sedang Diproses, Sila Tunggu...</div>' //<img src="<?=base_url()?>images/loading_ajax.gif" alt="Sedang process"/><center><div style="width:160px;height:12px;border:2px #cccccc solid;text-align:left;">'+
					 //'<div id="progressbar" style="width:5px;height:12px;background:#ffffff;background-image:url(img/progressbar.gif);background-repeat:repeat-x;">&nbsp;</div></div></center>';
	lBox.style.display = 'none';
	lBox.style.position = 'absolute';
	lBox.style.zIndex = "2";
	lBox.style.textAlign='center';
	lBox.style.paddingTop='15px';
	
	var ELheight = parseInt(document.getElementById("loadingbox").clientHeight);
	var ELwidth = parseInt(document.body.clientWidth);
	//alert(ELheight);
	lBox.style.marginTop = ((document.body.clientHeight/2-ELheight/2)-20) + "px";
	lBox.style.left = (ELwidth/2)-100+'px';
	lBox.style.display = 'block';
	
	loadingBoxDisplayed = true;
}

/*************************************************************************
  This code is from Dynamic Web Coding at http://www.dyn-web.com/
  See Terms of Use at http://www.dyn-web.com/bus/terms.html
  regarding conditions under which you may use this code.
  This notice must be retained in the code as is!
*************************************************************************/

function getDocHeight(doc) {
  var docHt = 0, sh, oh;
  if (doc.height) docHt = doc.height;
  else if (doc.body) {
    if (doc.body.scrollHeight) docHt = sh = doc.body.scrollHeight;
    if (doc.body.offsetHeight) docHt = oh = doc.body.offsetHeight;
    if (sh && oh) docHt = Math.max(sh, oh);
  }
  return docHt;
}

function setIframeHeight(iframeName) {
	
	var iframeWin = window.frames[iframeName];
	var iframeEl = document.getElementById? document.getElementById(iframeName): document.all? document.all[iframeName]: null;
	
	if ( iframeEl && iframeWin ) {
		iframeEl.style.height = "auto"; // helps resize (for some) if new doc shorter than previous  
		var docHt = getDocHeight(iframeWin.document);
		// need to add to height to be sure it will all show
		if (docHt) iframeEl.style.height = docHt + 30 + "px";
	}
}

/****************************************
	End of code from Dynamic Web Coding
****************************************/

function hideLoadingBox() {

	document.getElementById("loadingbox").style.display='none';
	loadingBoxDisplayed = false;
	document.getElementById("result").style.display='block';
}

function fonload() {
	
	//alert('loaded');
	if (document.getElementById('idPrint'))
		idPrint.disabled = false;
  
	if (parent == window) {
		document.getElementById("loadingbox").style.display='none';
		document.getElementById("result").style.display='block';
	} else {
		//parent.setIframeHeight('rptiframe');
		//DYNIFS.resize('rptiframe');
		//alert('hiding loading box');
		parent.hideLoadingBox();
	}

}

function printit() {
	document.getElementById('idPrint').style.display = 'none';
	window.print()
	setTimeout("document.getElementById('idPrint').style.display = 'block';", 5000);
}

displayLoadingBox();

</script>

<?php

if(isset($senaraipelajar))
{
	echo('<input disabled id="idPrint" name="idPrint" type="button"  value="Cetak Senarai" onClick="printit()">');
?>
<center>
	<table id="tajuk" class="results2" width="100%">
	<thead>
		<tr>
		    <td height="58" colspan="11" class="maintitle">
		    	<strong>LEMBAGA PEPERIKSAAN<br/>
						KEMENTERIAN PENDIDIKAN MALAYSIA<br/>
						PENILAIAN <?php if(isset($pengisian) && $pengisian == 1)
										{
											echo "BERTERUSAN";
										}
										else if(isset($pengisian) && $pengisian == 2)
										{
											echo "AKHIR";
										}
										?> SEMESTER <?= $semester ?> /&nbsp;<?= $tahun ?><br/>
						BORANG PENGISIAN MARKAH (K15)
			</td>
		</tr>
		<tr>
		    <td colspan="11">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="11">NOMBOR PUSAT<?=nbs(19)?>: <?=$senaraipelajar[0]->col_code?>
			</td>
		</tr>
		<tr>
			<td colspan="11">KOD MATA PELAJARAN<?=nbs(4)?>: <?=$subjectkod ?></td>
		</tr>
		<tr>
			<th width="2%" height="23px">BIL</th>
			<th align="left" width="14%">NAMA</th>
			<th align="left" width="5%">MY KAD</th>
			<th align="left" width="5%">ANGKA GILIRAN</th>
			<?php 
				if(isset($pengisian) && $pengisian == 1)
				{
					
					for($tugasan = 0; $tugasan < $total_assignment->assgmnt_total; $tugasan++) {
					
			?>
					<th align="center" width="4%">MRK</th>
					
			<?php 
					}
				}
				if(isset($pengisian) && $pengisian == 2)
				{
					
			?>
					<th align="center" width="4%">AKHIR</th>
			<?php 
					
				}
			?>			
			<th align="center" width="4%">CATATAN</th>
		</tr>	
	</thead>
	<tbody>
		<?php
			$i = 1;
			foreach ($senaraipelajar as $row)
			{
				if(($i%24) == 0)
				{
        ?>
					<tr id="pbreak">
						<td align="center" style="vertical-align: top;" height="25px"><?=$i?></td>
						<td align="left" style="vertical-align: top;"><?=strtoupper($row->stu_name)?></td>
						<td align="left" style="vertical-align: top;"><?=$row->stu_mykad?></td>
						<td align="left" style="vertical-align: top;"><?=$row->stu_matric_no?></td>
						<?php 
							if(isset($pengisian) && $pengisian == 1)
							{
								for($tugasan = 0; $tugasan < $total_assignment->assgmnt_total; $tugasan++) {
						?>
								<td align="center" style="vertical-align: bottom;">______</td>
							
						<?php 
								}
							}
							if(isset($pengisian) && $pengisian == 2)
							{
								
						?>
								<td align="center" style="vertical-align: bottom;">______</td>
						<?php 
								
							}
						?>						
						<td align="center" style="vertical-align: bottom;">__________</td>	
					</tr>
					
		<?php
					echo "<script> setPageBreak(); </script>";		
              	}
              	else
              	{
        ?>
					<tr >
						<td align="center" style="vertical-align: top;" height="25px"><?=$i?></td>
						<td align="left" style="vertical-align: top;"><?=strtoupper($row->stu_name)?></td>
						<td align="left" style="vertical-align: top;"><?=$row->stu_mykad?></td>
						<td align="left" style="vertical-align: top;"><?=$row->stu_matric_no?></td>						
						<?php 
							if(isset($pengisian) && $pengisian == 1)
							{
								for($tugasan = 0; $tugasan < $total_assignment->assgmnt_total; $tugasan++) {
						?>
								<td align="center" style="vertical-align: bottom;">______</td>
								
						<?php 
								}
							}
							if(isset($pengisian) && $pengisian == 2)
							{
								
						?>
								<td align="center" style="vertical-align: bottom;">______</td>
						<?php 
								
							}
						?>
						<td align="center" style="vertical-align: bottom;">__________</td>		
					</tr>
		<?php
			  	}
				$i++;
			}		
		?>
	</tbody>
	<tfoot>
		<tr>
		    <td colspan="6">
		    	<table width="100%">
		    		<tr><td colspan="7">&nbsp;</td></tr>
		    		<tr>
		    			<td width="20%" height="33px"><strong>DISAHKAN OLEH</strong></td>
		    			<td align="center" width="3%"><strong>:</strong></td>
		    			<td width="10%">____________________</td>
		    			<td width="3%">&nbsp;</td>		    			
		    			<td width="15%"><strong>DISEMAK OLEH</strong></td>
		    			<td align="center" width="3%"><strong>:</strong></td>
		    			<td width="10%">____________________</td>
		    			<td width="16%">&nbsp;</td>
		    		</tr>
		    		<tr>
		    			<td height="33px"><strong>NAMA</strong></td>
		    			<td align="center"><strong>:</strong></td>
		    			<td>____________________</td>
		    			<td>&nbsp;</td>		    			
		    			<td><strong>NAMA</strong></td>
		    			<td align="center"><strong>:</strong></td>
		    			<td>____________________</td>
		    			<td>&nbsp;</td>
		    		</tr>
		    		<tr><td colspan="7">&nbsp;</td></tr>
		    		<tr>
		    			<td colspan="7" align="left">TH : Tidak Hadir <?=nbs(5)?>TS : Tiada Skrip <?=nbs(5)?>MRK : Markah</td>
		    		</tr>
		    	</table>
			</td>
		</tr>
	</tfoot>
	</table>
</center>
<?php
}
?>

<?php
/**************************************************************************************************
* End of v_print_writtenform.php
**************************************************************************************************/
?>