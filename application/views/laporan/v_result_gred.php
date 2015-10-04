<?php 
echo $_SESSION['gred_kv'];
?>
<STYLE TYPE="text/css">

	.colheader	{font-size:9pt;font-weight:bold;padding-left:2pt;padding-right:2pt;}
	.desc		{font-size:8pt;padding-left:2pt;padding-right:2pt;}
	.descbold	{font-size:11pt;padding-left:2pt;padding-right:2pt;font-weight:bold;height:10pt;}
	.descc		{font-size:11pt;padding-left:2pt;padding-right:2pt;height:10pt;}
	
</STYLE>

<table cellpadding="0" cellspacing="0" border="0" width="100%">
		<!-- header part -------------------------------------- -->
        <tr>
        	<td>
        		<table width="100%" cellpadding=0 cellspacing=0 border=0>
        			<tr>
                    	<td colspan=7 align="center" style="height:60pt;">
                            <span class="descbold">LEMBAGA PEPERIKSAAN<br>
                            KEMENTERIAN PENDIDIKAN MALAYSIA<br>
                            GRED KESELURUHAN KOLEJ VOKASIONAL</span><br><br>
                        </td>
                    </tr>
        			<tr>
                    	<td width="50" class="descc">&nbsp;</td>
                    	<td width="96" class="descc" style="width:72pt;">NO. PUSAT</td>
                        <td width="32" class="descc" style="width:15pt;">:</td>
                        <td width="542" class="descc" colspan="2">CTH1234</td>
                    </tr>
        			<tr>
                    	<td>&nbsp;</td>
                    	<td style="width:72pt;" class="descc">KURSUS</td>
                        <td style="width:15pt;" class="descc">:</td>
                        <td colspan="2" class="descc"><?= strtoupper($kursusdipilih->kursus_kluster)?></td>
                    </tr>
                    <tr>
                    	<td colspan="4" class="descc">&nbsp;</td>
                    </tr>
        		</table>
       		</td>
        </tr>
<!-- end of header part -------------------------------- -->

<!-- subject list part --------------------------------- -->
        <tr>
          <td>
          	<table width="100%" cellpadding=0 cellspacing=0 border=1 >
        	  <tr>
              	<td align="center" class="descbold" colspan="4">&nbsp;</td>
                <td align="center" class="descbold" colspan="7" width="28%">
                	Gred Mata Pelajaran Akademik
                </td>
                <td align="center" class="descbold" colspan="5" width="20%">
                	Gred Mata Pelajaran Vokasional
                </td>
        	  </tr>
              <tr>
              	<td width="3%" align="center" class="desc">BIL</td>
                <td width="20%" align="center" class="desc" colspan="2">NAMA</td>
                <td width="6%" align="center" class="desc">ANGKA GILIRAN</td>
                    <?php
					if(sizeof($subjek_akademik) > 0){
					 	foreach($subjek_akademik as $rsa){
					 ?>
                    <td width="4%" align="center" class="desc"><?=$rsa->kod_subjek_modul?>
                	</td>
                    <?php
						}
					}	
					?>
                                        <?php
					if(sizeof($subjek_kv) > 0){
					 	foreach($subjek_kv as $rsa){
					 ?>
                  <td width="4%" align="center" class="desc"><?=$rsa->kod_subjek_modul?></td>
                    <?php
						}
					}	
					?>
              </tr>
              <?php
			  	if(sizeof($pelajar_akademik) > 0)
				{
					$i = 0;
					foreach($pelajar_akademik as $rpa)
					{
						$i++;
			  ?>
              <tr>
              	<td width="3%" align="center" class="desc"><?= $i ?></td>
                <td width="20%" align="left" class="desc" colspan="2"><?=strtoupper($rpa->nama_pelajar)?></td>
                <td width="6%" align="center" class="desc"><?=$rpa->angka_giliran?></td>
                 <?php
					if(sizeof($subjek_akademik) > 0){
						$gred_aka = json_decode($_SESSION['gred_aka'],true);
					 	foreach($subjek_akademik as $rsa){
					 ?>
                    <td width="4%" align="center" class="desc"><?=$gred_aka[$rpa->id_pelajar][$rsa->subjek_id]?></td>
                    <?php
						}
					}	
					?>
                                        <?php
					if(sizeof($subjek_kv) > 0){
						$gred_kv = json_decode($_SESSION['gred_kv'],true);
						//print_r($gred_kv);
					 	foreach($subjek_kv as $rsa){
					 ?>
                  <td width="4%" align="center" class="desc"><?=$gred_kv[$rpa->id_pelajar][$rsa->subjek_id]?></td>
                    <?php
						}
					}	
					?>
              </tr>
              <?php
					}
				}
			  ?>
            </table>
          </td>
        </tr>
<!-- end of subject list part -------------------------- -->

<!-- footer part --------------------------------------- -->
        
<!-- end of footer part -------------------------------- -->
        <tr>
            <td class="descxsitalic" colspan="4" style="height:60pt;">&nbsp;</td>
        </tr>
     </table>