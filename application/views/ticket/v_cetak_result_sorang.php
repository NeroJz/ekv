<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<title>Examination Result Slip</title>
<STYLE TYPE="text/css">
     P.breakhere {page-break-before: always}
     body		{font-size: 8pt;font-family:arial;}
	.header		{font-size:9pt;font-weight:bold;}
	.colheader	{font-size:8pt;font-weight:bold;padding-left:2pt;padding-right:2pt;}
	.subheader	{font-size:8pt;font-weight:bold;padding-left:2pt;padding-right:2pt;}
	.desc		{font-size:8pt;padding-left:2pt;padding-right:2pt;}
	.descbold	{font-size:8pt;padding-left:2pt;padding-right:2pt;font-weight:bold;height:10pt;}
	.descs		{font-size:7pt;padding-left:2pt;padding-right:2pt;}
	.descsbold	{font-size:7pt;padding-left:2pt;padding-right:2pt;font-weight:bold;}
	.descxsitalic	{font-size:7pt;padding-left:2pt;padding-right:2pt;font-style:italic}
	.amaun		{font-size:8pt;text-align:right;padding-left:2pt;padding-right:2pt;}
	.total		{font-size:8pt;text-align:right;font-weight:bold;padding-left:2pt;padding-right:2pt;}
	.grandtotal	{font-size:8pt;text-align:right;font-weight:bold;padding-left:2pt;padding-right:2pt;border-top:2px #000000 solid;border-bottom:5px #000000 double;}
	.linetop	{font-size:8pt;font-weight:bold;border-top:2px #000000 solid;padding-left:2pt;padding-right:2pt;}
	.linebottom	{font-size:8pt;font-weight:bold;border-bottom:2px #000000 solid;padding-left:2pt;padding-right:2pt;}
	
	.BG {
			background-image:url(../../../assets/img/bg_result.png);
			background-repeat:no-repeat;/*dont know if you want this to repeat, ur choice.*/
			height:10%;
			width:10%
		}
	
</STYLE>
</head>
<body>
<?php
	//for($i = 0; $i <= 5; $i++)
	//{
?>
        <table class="BG" cellpadding="0" cellspacing="0" border="0" style="width:540pt;">
		<!-- header part -------------------------------------- -->
        <tr>
        	<td>
        		<table width="100%" cellpadding=0 cellspacing=0 border=0>
        			<tr>
                    	<td colspan=9 align="center" style="height:60pt;">
                            <span class="colheader">LEMBAGA PEPERIKSAAN<br>
                            KEMENTERIAN PENDIDIKAN MALAYSIA</span><br><br>
                            <span class="desc">KEPUTUSAN PENTAKSIRAN KOLEJ VOKASIONAL<br>
                            SEMESTER 1 TAHUN 2012</span><br><br>
                        </td>
                    </tr>
        			<tr>
                    	<td width="105" class="descbold" style="width:72pt;">NAMA</td>
                        <td width="20" class="descbold" style="width:15pt;">:</td>
                        <td width="595" colspan="7" class="descbold">Nama Pelajar dipaparkan disini</td>
                    </tr>
        			<tr>
                    	<td class="descbold" style="width:72pt;">NO K/P</td>
                        <td class="descbold" style="width:15pt;">:</td>
                        <td class="descbold" colspan="7">No IC dipaparkan disini</td>
                    </tr>     
        			<tr>
        				<td class="descbold" style="width:72pt;">ANGKA GILIRAN</td>
                        <td class="descbold" style="width:15pt;">:</td>
                        <td class="descbold" style="width:148pt;" colspan="7"> CTH123456789</td>
        			</tr>
        			<tr>
        				<td class="descbold" style="width:72pt;">INSTITUSI</td>
                        <td class="descbold" style="width:15pt;">:</td>
                        <td class="descbold" style="width:148pt;" colspan="7">
                        	Nama Institusi diapaparkan disini
                        </td>
        			</tr>
        			<tr>
        				<td class="descbold" style="width:72pt;">KLUSTER</td>
                        <td class="descbold" style="width:15pt;">:</td>
                        <td class="descbold" colspan="7">Kluster dipapar disini</td>
        			</tr>
        			<tr>
        				<td class="descbold" style="width:72pt;">KURSUS</td>
                        <td class="descbold" style="width:15pt;">:</td>
                        <td class="descbold" style="width:148pt;" colspan="7">Kursus dipapar disini</td>
        			</tr>
                    <tr>
                        <td style="width:148pt;" colspan="9">&nbsp;</td>
        			</tr>
        		</table>
       		</td>
        </tr>
<!-- end of header part -------------------------------- -->

<!-- subject list part --------------------------------- -->
        <tr>
          <td>
          	<table width="100%" cellpadding=0 cellspacing=0 border=0 >
        	  <tr>
                    <td class="colheader" width="6%">KOD</td>
                    <td class="colheader" width="40%">MATA PELAJARAN</td>
                    <td class="colheader" width="7%" align="center">JAM KREDIT</td>
                    <td class="colheader" width="7%" align="center">GRED</td>
                    <td class="colheader" width="8%" align="center">NILAI MATA</td>
                    <td class="colheader" width="8%" align="center">NILAI GRED</td>
                    <td class="colheader" width="8%" align="center">JAM KREDIT</td>
                    <td class="colheader" width="16%" align="center">PENCAPAIAN/TAHAP KOMPETENSI</td>
        	  </tr>
              <?php
				 	for($bil = 1; $bil <=5; $bil++)
					{
				 ?>
        			<tr>
                        <td class="desc" >Kod <?= $bil ?></td>
                        <td class="desc" >Mata Pelajaran <?= $bil ?></td>
                        <td class="desc" align="center">0.00</td>
                        <td class="desc" align="center">-</td>
                        <td class="desc" align="center">-</td>
                        <td class="desc" align="center">-</td>
                        <td class="desc" align="center">-</td>
                        <td class="desc" align="center">-</td>
        	  		</tr>
                 <?php
					}
				 ?>
            </table>
          </td>
        </tr>
<!-- end of subject list part -------------------------- -->

<!-- footer part --------------------------------------- -->
        <tr>
        	<td>
            	<table cellpadding="0" cellspacing="0" border="0" width="100%">
                    <tr>
        				<td class="descxsitalic" colspan="4">&nbsp;</td>
                    </tr>
        			<tr>
        				<td class="descxsitalic" colspan="2">PURATA NILAI GRED VOKASIONAL (PNGV)</td>
        				<td class="descxsitalic" width="3%" align="center">:</td>
        				<td class="descxsitalic" width="51%">0.00</td>
                    </tr>
                    <tr>
        				<td class="descxsitalic" colspan="2">PURATA NILAI GRED KUMULATIF VOKASIONAL (PNGKV)</td>
        				<td class="descxsitalic" align="center">:</td>
        				<td class="descxsitalic" >0.00</td>
                    </tr>
                    <tr>
        				<td class="descxsitalic" colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
        				<td class="descxsitalic" colspan="2">PURATA NILAI GRED KESELURUHAN (PNGK)</td>
        				<td class="descxsitalic" align="center">:</td>
        				<td class="descxsitalic">0.00</td>
                    </tr>
                    <tr>
        				<td class="descxsitalic" colspan="2">PURATA NILAI GRED KUMULATIF KESELURUHAN (PNGKK)</td>
        				<td class="descxsitalic" align="center">:</td>
        				<td class="descxsitalic" >0.00</td>
                    </tr>
                    <tr>
        				<td class="descxsitalic" colspan="4">&nbsp;</td>
                    </tr>
                    <tr>
        				<td class="descxsitalic" colspan="4">&nbsp;</td>
                    </tr>
                 </table>
          	  </td>
       		</tr>
<!-- end of footer part -------------------------------- -->
			<tr>
                <td class="descxsitalic" colspan="4" style="height:60pt;">&nbsp;</td>
            </tr>
   	     </table>
<?php
	//}
?>
</body>