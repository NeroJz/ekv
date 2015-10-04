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
</script>
<style type="text/css" media="print" >
#idPrint {
	display: none !important;
	position: absolute;
	
}
</style>
<input id="idPrint"    type="button" onclick="printit()" value="Cetak" name="idPrint">


<?php
if(!empty($student)){
	
?>

          	<table width="100%" cellpadding="0" cellspacing="0" id="student">
          	<thead><tr>
                    	<td colspan="4" align="center" class="dep">
                            LEMBAGA PEPERIKSAAN<br>
                            KEMENTERIAN PENDIDIKAN MALAYSIA<br>
                            PENTAKSIRAN KOLEJ VOKASIONAL 
                            SEMESTER <?=$student[0]->mt_semester?> TAHUN <?=$student[0]->mt_year?><br>
                            JADUAL KEDATANGAN<br>
                        </td>
                     
                    </tr>
                    <tr bgcolor="#ffffff" align="left">
                    	<td colspan="4">
                            <span class="dep">NO. PUSAT :
                            <?=$student[0]->col_type." ".$student[0]->col_code?></br>
                                   INSTITUSI : <?=$student[0]->col_name?></br>
                                   KRUSUS : <?=strtoupper($student[0]->cou_name)?>
                                   </td>
                        </td>
                    </tr>
                    
                    <tr>
                    
        	  <tr bgcolor="#ffffff"  class="tables">
                    <td  bgcolor="#ffffff"  align="center" class="descbold" style="border-right:none;">BIL</td>
                    <td colspan="3" width="97%" align="center" class="descbold">BUTIRAN</td>

        	  </tr></thead>
              <?php 
              $bil = 0;
			  $b=0;
              foreach($student as $row)
			  {
			 
			  
			  	$bil++;
				$b++;
				$kod_subjek = explode(',', $row->kod_subjek);
				$type = explode(',', $row->type);
				$notattd= explode(',', $row->notattd);
				$mod_ids= explode(',', $row->mod_ids);
				
				if(($b%5)==0){
              $tr='id="break"';
              }else{
              	$tr='';
			  }
			  $mod_ids = explode(',', $row->mod_ids);
			
		     
		     
			
			
              ?>
              
        			<tr <?=$tr?>  class="tables">
                    	<td    align="center" style="border-right:none;border-top:none;"><?= $bil ?></td>
                        <td   colspan="3" style="border-top:none; border-bottom: none;">
                        	
                            <table width="100%" cellpadding="0" cellspacing="0">
                            	
                            	<tr class="tables3">
                                    <td class="dep" width="129" align="left">ANGKA GILIRAN </td>
                                    <td class="dep" width="8" align="left" >:</td>
                                    <td class="dep" width="207" align="left"><?=$row->stu_matric_no?></td>
                                    <td class="dep" width="56" align="left">NAMA</td>
                                    <td class="dep" width="8" align="left" >:</td>
                                    <td class="dep" align="left" colspan="6"><?=$row->stu_name?></td>
                                </tr>
                                <tr class="tables3">
                                    <td class="dep" align="left">NOMBOR KP</td>
                                    <td class="dep" align="left" >:</td>
                                    <td class="dep" align="left"><?=$row->stu_mykad?></td>
                                    <td class="dep" align="left">JANTINA</td>
                                    <td class="dep" align="left" >:</td>
                                    <td width="275" align="left" class="dep"><?=$row->stu_gender?></td>
                                    <td width="138" colspan="5" align="left" class="dep">
                                    	JUMLAH MATA PELAJARAN : <span id="spanJumSub<?=$bil?>"><?=$row->count_subj?></span></td>
                                </tr>
                                
                                <tr>
                                	<td colspan="12"   style="border-left:none; border-right:none; width:1px;">
                                    	<table width="100%" height="30px" cellpadding=0 cellspacing=0 class="tables2" style="margin-left:1px;">
                                    		<tr rowspan="3">
                                    			<?php 
                                    			$co=0;
                                    			foreach($kod_subjek as $key=>$rows)
                                    			{
                                    				$avData = array();
												
                                    				if($type[$key]=="AK"){
                                    			  $this->m_result->modul_paper_ak($avData,$aOpt='',$mod_ids[$key]);
                                    			//print_r($avData);
                                    				?>
													<td style="border-top:none;border-left:none;" width="8%" align="center" class="desc" colspan="2"><?=$rows?></td>
														<?php
														foreach($avData as $avrow){
															$countavdata=count($avData);
															$co+=$countavdata;
															$idd=$mod_ids[$key];
														   $data[$idd]=$avrow->mod_paper_num;
														?>
									                     <td style="border-top:none;border-left:none;" width="8%" align="center" class="desc" colspan="2">
									                     	<?=$avrow->mod_paper?>
									                     	</td>
														<?php
														}
														
			
													
                                    				?>
                                    		
                                    			
                                               <?php
													
													}else{
														
													
													?>
													<td style="border-top:none;border-left:none;" width="8%" align="center" class="desc" colspan="2"><?=$rows?></td>
													<?php
													}
												}

												echo "<script language='javascript'>
														$('#spanJumSub".$bil."').html('".($co+$row->count_subj)."');
														</script>";
														
												?>
                                            </tr>
                                            <tr rowspan="3">
                                    			<?php 
                                    			$co=0;
                                    			foreach($kod_subjek as $key=>$rows)
                                    			{
                                    				$avData = array();
												
                                    				if($type[$key]=="AK"){
                                    			  $this->m_result->modul_paper_ak($avData,$aOpt='',$mod_ids[$key]);
                                    			//print_r($avData);
                                    				?>
													<td style="border-left:none;border-right:none;" rowspan="3" class="desc" align="center">1</td>
                                                <td rowspan="3" class="desc" align="center"><input type="checkbox" name="vehicle" checked="checked" value=""></td>
														<?php
														foreach($avData as $avrow){
															
														  $paper_num= $avrow->mod_paper_num;
														?>
									                     <td style="border-left:none;border-right:none;" rowspan="3" class="desc" align="center"><?=$paper_num?></td>
                                                        <td rowspan="3" class="desc" align="center"><input type="checkbox" name="vehicle" checked="checked" value=""></td>
														<?php
														}
												
														
													
                                    				?>
                                    		
                                    			
                                               <?php
													
													}else{
													?>
													<td style="border-left:none;border-right:none;" rowspan="3" class="desc" align="center">1</td>
                                                <td rowspan="3" class="desc" align="center">
                                                 <input type="checkbox" name="vehicle" checked="checked" value=""><br>
                                                
                                                 </td>
													<?php
													}
													}
												?>
                                            </tr>
                                             <tr>
                                             
                                              </tr>
                                          </table>
                                         
                          
                            </table>
                       
        
        	  		<?php
        	  		
        	  		
}
?>
<tfoot>
<tr>
<td colspan="4" align="center" class="dep">
&nbsp;
</td>
        	  </tr>
	
<tr bgcolor="#ffffff"  class="tables">
                    <td style="border:none;">&nbsp;</td>
                     <td  style="font-size:9px; " colspan="2" align="left" class="descbold">
                     <b>PERHATIAN</b><br/>
                     (1)	Angka Giliran calon tidak bole ditukar tanpa kebenaran Pengarah Peperiksaan<br/>
    				(2)	Pengawas dikehendaki memeriksa Kad Pengenalan / No Sijil Kelahiran 
    				calon setiap kali calon menghadiri peperiksaan bagi satu-satu kertas.<br/>
    				
                     </td>
                      <td   style="font-size:9px; " align="left" class="descbold">
                      (3)	Pengawas dikehendaki memeriksa Kenyataan Kemasukan calon jika ada 
                      bantahan daripada calon<br/>
                     (4) <b>RUANG BUTIR-BUTIR CALON:</b> Tandakan dengan .... 
                     dalam petak kehadiran dibawah kod mata pelajaran berkenaan bagi calon yang hadir. 
                      <b>T</b> bagi yang tidak hadirdan <b>H</b> bagi 
                      calon yang sah mengambil peperiksaan di Hospital. 
                      Kesemua petak tersebut mestilah diisi sama dengan ... , <b>T</b> atau <b>H.</b><br/>	
                         (5)	<b>RUANG CATATAN:</b> Tandakan ..... dalam petak berkenaan.<br/>
                      </td>
        	  </tr>
</tfoot>	
					</table>
					<br/>
<center>
	    <form id="frm_pusat" action="<?= site_url('report/result/attendance_ok')?>" method="post" >
                           <input class="btn btn-info" type="submit" name="btn_papar" value="Hantar">
                           </from>
 </center>                				
									
					<?php
				}else{
					echo "Tiada Maklumat";
				}
?>