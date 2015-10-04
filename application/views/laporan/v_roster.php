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
#break{page-break-after: always; position: relative;}
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
<table width="100%" cellpadding="0" cellspacing="0">
          		<tr>
                	<td colspan="4" align="center" class="dep">
                            LEMBAGA PEPERIKSAAN<br>
                            KEMENTERIAN PENDIDIKAN MALAYSIA<br>
                            KEPUTUSAN PENTAKSIRAN KOLEJ VOKASIONAL<br>
                            SEMESTER <?=$student[0]->mt_semester?> TAHUN <?=$student[0]->mt_year?><br>   
                    </td>
                </tr>
				<tr bgcolor="#ffffff" align="left">
                	<td colspan="4">
                            <span class="dep">NO. PUSAT :
                            <?=$student[0]->col_type." ".$student[0]->col_code?></br>
                                   INSTITUSI :<?=$student[0]->col_name?>
					</td>
				</tr>
				<tr>
                	<td  width="">&nbsp; </td>
                    <td  width="1%">&nbsp; </td>
                    <td >&nbsp; </td>
                    <td >&nbsp; </td>
				</tr>
			</table>
			
          	<table width="100%" cellpadding="0" cellspacing="0" id="student">
          	<thead>
				<tr>
                	<td  width="">&nbsp; </td>
                    <td  width="1%">&nbsp; </td>
                    <td >&nbsp; </td>
                    <td >&nbsp; </td>
				</tr>
        	  	<tr bgcolor="#ffffff"  class="tables">
              		<td  bgcolor="#ffffff"  align="center" class="descbold" style="border-right:none;">BIL</td>
                	<td colspan="3" width="97%" align="center" class="descbold">BUTIRAN</td>
				</tr>
			</thead>
              <?php 
              $bil = 0;
			  $b=0;
              foreach($student as $row)
			  {
			 // for ($s=1; $s<=4; $s++){
			  
			  	$bil++;
				$b++;
				$kod_subjek = explode(',', $row->kod_subjek);
				$grade= explode(',', $row->greds);
				
				if($b=='5'){
					if(($b%5)==0){
              $tr='id="break"';
              }else{
              	$tr='';
			  }
					
				}else{
				$bc=$b-5;	
			if((($bc)%7)==0){
              $tr='id="break"';
              }else{
              	$tr='';
			  }
					
				}
				
					
				
			
              ?>
              	<tr <?=$tr?> class="tables">
						<!-- start content -->
                    	<td    align="center" style="border-right:none;border-top:none;"><?= $bil ?></td>
                        <td   colspan="3" style="border-top:none; border-bottom: none;">
                        	
                            <table width="100%" cellpadding="0" cellspacing="0">
                            	
                            	 <tr class="tables3">
                                    <td class="dep" align="left">ANGKA GILIRAN</td>
                                    <td class="dep" align="left" >:</td>
                                    <td class="dep" align="left"><?=$row->stu_matric_no?></td>
                                    <td class="dep" align="left">NAMA</td>
                                    <td class="dep" align="left" >:</td>
                                    <td width="275" align="left" class="dep"><?=$row->stu_name?></td>
                                    <td width="138" colspan="5" align="left" class="dep">
                                    	PNGK: <?=$row->pngk?></td>
                                </tr>
                                <tr class="tables3">
                                    <td class="dep" align="left">NOMBOR KP</td>
                                    <td class="dep" align="left" >:</td>
                                    <td class="dep" align="left"><?=$row->stu_mykad?></td>
                                    <td class="dep" align="left">JANTINA</td>
                                    <td class="dep" align="left" >:</td>
                                    <td width="275" align="left" class="dep"><?=$row->stu_gender?></td>
                                    <td width="138" colspan="5" align="left" class="dep">
                                    	JUMLAH MATA PELAJARAN : <?=$row->count_subj?></td>
                                </tr>
                                
                                <tr>
                                	<td colspan="12"   style="border-left:none; border-right:none; width:1px;">
                                    	<table width="100%" height="30px" cellpadding=0 cellspacing=0 class="tables2" style="margin-left:1px;">
                                    		<tr >
                                    			<?php 
                                    			foreach($kod_subjek as $key=>$rows)
                                    			{
                                    				?>
                                    		
                                    			<td style="border-top:none;border-left:none;" width="8%" align="center" class="desc" ><?=$rows?></td>
                                               <?php
												}
												?>
                                            </tr>
                                            <tr>
                                            	<?php
                                            	//$notattd[$i]==0?"/":"X"
                                            	for($i=0; $i<count($kod_subjek);$i++)
												{
												?>
												
                                                <td style="border-left:none;"  class="desc" align="center">
                                                <?=isset($grade[$i])&&!empty($grade[$i])?$grade[$i]:'-'?>
                                                </td>
                                                
                                                <?php
												}
												?>
                                                
                                             </tr>
                                             <tr>
                                             
                                              </tr>
											</table>
										</td>
									</tr>
     
                            </table>
						</td>
						<!-- end content -->
					</tr>
					<?php } ?>
				</table>

					
									
					<?php
				}else{
					echo "Tiada Maklumat";
				}
?>