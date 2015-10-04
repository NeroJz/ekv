
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/print_setting.js"></script>
<STYLE TYPE="text/css" >
	body		{font-size: 8pt;font-family:arial; position:relative; }
	.colheader	{font-size:8pt;font-weight:bold;padding-left:2pt;padding-right:2pt;}
	.desc		{font-size:8pt;padding-left:2pt;padding-right:2pt;}
	.descbold	{font-size:9pt;padding-left:2pt;padding-right:2pt;font-weight:bold;height:10pt;}
	.descc		{font-size:9pt;padding-left:2pt;padding-right:2pt;height:10pt;}
	.dep		{font-size:8pt;}
	
	.tables td{ border: 1px solid #000000;}

	.tables2{ border-right:none; border-left:none; }
	.tables2 td{ border-bottom:none;}
	.tables3 td{ border:none; padding:1px;}
	.tables4 {border-top:none; border-bottom: none;}
	

</STYLE>
<STYLE TYPE="text/css" media="print">
#break{page-break-before: always; position: relative;}
#student{width:100%;}

@page 
{
    size: auto;   /* auto is the current printer page size */
    margin: 0mm;  /* this affects the margin in the printer settings */
}

#BrowserPrintDefaults{display:none} 

</STYLE>

<style type="text/css" media="print" >
#idPrint {
	display: none !important;
	position: absolute;	
}
</style>
<script type="text/javascript">
  //parameter untuk set jsPrintSetup option
  var jspOptions = [];

  //jika ada perubahan/penambahan guna push sebab saya pakai json
  //contoh option yang ada boleh rujuk kat sini : https://addons.mozilla.org/en-US/firefox/addon/js-print-setup/‎
  //ni example : 
  //jspOptions.push({'id':"headerStrLeft",'val':'sukor'});
  //jspOptions.push({'id':"marginLeft",'val':'20'});

</script>
<input id="idPrint"    type="button" onclick="printit(jspOptions)" value="Cetak" name="idPrint">
<?php
if(!empty($student))
{
?>
	<table width="100%" cellpadding="0" cellspacing="0">
		<tr>
	    	<td colspan="4" align="center" class="dep">
	    		<span style="font-weight:bold;">
	                LEMBAGA PEPERIKSAAN<br>
	                KEMENTERIAN PENDIDIKAN MALAYSIA<br>
	            </span>
	                KEPUTUSAN PENTAKSIRAN KOLEJ VOKASIONAL<br>
	                SEMESTER <?=$student[0]->moduletaken[0]->mt_semester?> TAHUN <?=$student[0]->moduletaken[0]->mt_year?><br>   
	        </td>
	    </tr>
		<tr bgcolor="#ffffff" align="left">
	    	<td colspan="4">
	                <span class="dep" style="font-weight:bold;">NO. PUSAT : <?=$student[0]->col_type." ".$student[0]->col_code?></br>
	                	INSTITUSI :<?=$student[0]->col_name?>
	                </span>
			</td>
		</tr>
		<tr>
	    	<td colspan="4">&nbsp; </td>
		</tr>
	</table>
	
	    <?php 
	    	$bil = 0;
			$b=0;
			$bill=0;
			$count = 0;
			$loopCount = 0;
			
			foreach($student as $row)
			{
				$bil++;
				$b++;
								
				if($b=='9')
				{
					if(($b%9)==0)
					{
						$tr='id="break"';
					}
					else
					{
						$tr='';
					}
				}
				else
				{
					$bc=$b-9;
					
					if((($bc)%10)==0)
					{
						$tr='id="break"';
					}
					else
					{
						$tr='';
					}
				}
		?>
		<div <?php if($loopCount > 0){ echo $tr; }?>>
		<table width="100%" cellpadding="0" cellspacing="0" id="student">
		<?php
			
			
			if($count < 1)
			{
		?>
			<thead>
			  	<tr bgcolor="#ffffff"  class="tables">
		      		<td  bgcolor="#ffffff" width="33px" align="center" class="descbold" style="border-right:none;">BIL</td>
		        	<td colspan="3" align="center" class="descbold">BUTIRAN</td>
				</tr>
			</thead>
		<?php		
			}
		
			$count++;
			$loopCount++;
		?>
	  	
				<tr <?=$tr?> class="tables">
					<!-- start content -->
		        	<td align="center" width="38px" style="border-right:none;border-top:none;font-size:9pt;"><?= $bil ?></td>
		            <td colspan="3" style="border-top:none; border-bottom: none;">
		            	<table width="100%" cellpadding="0" cellspacing="0">
		            		<tr class="tables3">
		            			<td width="40%" class="dep" align="left">ANGKA GILIRAN : <?=$row->stu_matric_no?></td>
		            			<td width="40%" class="dep" align="left">NAMA : <?=strtoupper($row->stu_name)?></td>
		            			<td width="20%" class="dep" align="left">JANTINA : <?=strtoupper($row->stu_gender)?></td>
		            		</tr>
	                        <tr class="tables3">
	                            <td width="40%" class="dep" align="left">NOMBOR KP : <?=$row->stu_mykad?></td>
	                            <td width="40%" class="dep" align="left">
	                            	JUMLAH MATA PELAJARAN : <span id="spanJumSub<?= $bil ?>"><?= $bill ?></span>
	                            </td>
	                            <td width="20%" class="dep" align="left">&nbsp;</td>
	                        </tr>
	                        <tr class="tables3">
	                        	<td colspan="3" class="dep">
	                        		<table width="100%" cellpadding="0" cellspacing="0">
	                        			<tr>
	                        				<td class="dep" align="left">PNGBM : <?=number_format(get_png_bm($row->stu_matric_no,$row->moduletaken[0]->mt_semester),2)?>
	                        					&nbsp;&nbsp;PNGKBM : <?=number_format(get_pngk_bm($row->stu_matric_no,$row->moduletaken[0]->mt_semester),2)?></td>
	                        				<td class="dep" align="left">PNGA : <?=$row->pnga?>&nbsp;&nbsp;PNGKA : <?=$row->pngka?></td>
				                            <td class="dep" align="left">PNGV : <?=$row->pngv?>&nbsp;&nbsp;PNGKV : <?=$row->pngkv?></td>
				                            <td class="dep" align="left">PNGK : <?=$row->pngk?>&nbsp;&nbsp;PNGKK : <?=$row->pngkk?></td>
	                        			</tr>
	                        		</table>
	                        	<td>
	                        </tr>
	                        <?php
	                        	
			                       if($stat_subj == 1)
								   {
								   	 $size= 100;
								   }
								   else 
								   {
									   $size= (sizeof($row->moduletaken)/10)*100;
								   }
	                        ?>
	                        <tr>
	                        	<td colspan="12"   style="border-left:none; border-right:none; width:1px;">
	                            	<table width="<?=$size?>%" height="30px" cellpadding=0 cellspacing=0 class="tables2" style="margin-left:1px;">
	                            		<tr >
	                            		<?php 
	                            			$bill=0;
	                            			foreach($row->moduletaken as $rows)
	                            			{
	                            				$bill++;
										?>
		                            			<td style="border-top:none;border-left:none;" width="8%" align="center" class="desc" ><?=$rows->mod_paper?></td>
	                                    <?php
											}
											if($stat_subj == 2)
						  				 	{
							  				 	for($sRow=0;$sRow<6-$bill;$sRow++)
												{
													?>
													<td style="border-top:none;border-left:none;" width="8%" align="center" class="desc" ></td>
		                                  			<?php
												}
						  				 	
						   				 	}
											
											echo "<script language='javascript'>
												$('#spanJumSub".$bil."').html('".($bill)."');
												</script>";
										?>
	                                    </tr>
	                                    <tr>
	                                    <?php
	                                    	//$notattd[$i]==0?"/":"X"
	                                    	foreach($row->moduletaken as $rows)
											{
										?>
												<td style="border-left:none;"  class="desc" width="8%" align="center">
	                                        	<?=isset($rows->grade_type)&&!empty($rows->grade_type)?$rows->grade_type:'-'?>
	                                        	</td>
	                                    <?php
											}
											
											if($stat_subj == 2)
						  				 	{
							  				 	for($sRow=0;$sRow<6-$bill;$sRow++)
												{
													?>
													<td style="border-left:none;"  class="desc" width="8%" align="center"></td>
		                                  			<?php
												}						  				 	
						   				 	}											
										?>
										</tr>
									</table>
								</td>
							</tr>
						</table>
					</td>
					<!-- end content -->
				</tr>
			</table>
			</div>
<?php } ?>
		
<?php
}
else
{
	echo "Tiada Maklumat";
}
?>