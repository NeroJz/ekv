
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap2.css" media="screen" />

<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.blockUI.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/bootstrap-modal.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/kv.msg.modal.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jasny-bootstrap.js"></script>


<script language="javascript" type="text/javascript" >

	var base_url = '<?=base_url(); ?>';
	var site_url = '<?=site_url(); ?>';

	$(document).ready(function()
	{
		/*******************************************************************************************
		* Description		: this function for checkbox attendance 
		* input				: 
		* author			: Freddy Ajang Tony
		* Date				: 30 October 2013
		* Modification Log	: -
		*******************************************************************************************/
		$('.chk_attendance').click(function(){

			//alert();
			if ($(this).is(':checked')) {
			   //alert("Checked");
				$(this).parent().find('.desc_th').html("");
			   
			} else {
			   //alert("Not CHecked");
			   
			   var iMd_id = $(this).attr('id');
			   
				var td_row =
					'&nbsp;'+
					'&nbsp;'+
					'<label class="radio inline">'+
					'<input type="radio" id="inlineRadio1" name="optAttendance_'+iMd_id+'" value="1"> T'+
					'</label>'+
					'<label class="radio inline">'+
					'<input type="radio" id="inlineRadio2" name="optAttendance_'+iMd_id+'" value="2"> H'+
					'</label>';

		    	$(this).parent().find('.desc_th').append(td_row);
			} 
				    				
		});
		
	});

</script>
<STYLE TYPE="text/css" >

	.colheader	{font-size:9pt;font-weight:bold;padding-left:2pt;padding-right:2pt;}
	.desc		{font-size:8pt;padding-left:2pt;padding-right:2pt;}
	.descbold	{font-size:11pt;padding-left:2pt;padding-right:2pt;font-weight:bold;height:10pt;}
	.descc		{font-size:11pt;padding-left:2pt;padding-right:2pt;height:10pt;}
	.dep		{font-size:9pt;}
	
	.tables td{ border: 1px solid #000000;}
	.tables2{ border-right:none; border-left:none; }
	.tables2 td{ border-bottom:none; border-right:none; }
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
<input id="idPrint"   type="button" onclick="printit()" value="Cetak" name="idPrint">
<?php /*<form id="frm_pusat" action="<?= site_url('report/result/attendance_ok')?>" method="post" >
                           <input id="btnHantar" class="btn btn-info" type="submit" name="btnHantar" value="Hantar">
                           </from> */?>
<?php
if(!empty($student)){
	
?>

          	<table width="100%" cellpadding="0" cellspacing="0" id="student">
          	<thead><tr>
                    	<td width="100%" colspan="7" align="center" class="dep">
                            <strong>LEMBAGA PEPERIKSAAN<br>
                            KEMENTERIAN PENDIDIKAN MALAYSIA<br>
                            PENTAKSIRAN KOLEJ VOKASIONAL 
                            SEMESTER <?=$student[0]->mt_semester?> TAHUN <?=$student[0]->mt_year?><br>
                            JADUAL KEDATANGAN<br></strong>
                        </td>
                     
                    </tr>
                    <tr bgcolor="#ffffff" align="left">
                    	<td colspan="2">
                            <span class="dep"><strong>INSTITUSI :</strong>
                            <?=$student[0]->col_type."".$student[0]->col_code." - ".$student[0]->col_name?></br>
                                   
                                   <strong>KURSUS :</strong> <?=strtoupper($student[0]->cou_name)?></br>
                                   <strong>MODUL :</strong> <?=strtoupper($student[0]->kod_subjek." - ".$student[0]->mod_name)?>
                                   
                                   
                        </td>
                        <td colspan="3" align="right">
                        <table>
                        	<td>
                        	 <br>
                        <span class="dep">
                        	<!--TARIKH  :  <br>
                        	MASA  :--> 
                        </span>
                        	</td>
                        	<td>
                        	</td>
                        </table>
                       
                        </td>
                    </tr>
                    
                    <tr>&nbsp; </tr>
                    
        	  <tr bgcolor="#ffffff" height="26px" class="tables">
                    <td width="3%" bgcolor="#ffffff"  align="center" class="descbold" style="border-right:none;">BIL</td>
                    <td width="39%" align="center" class="descbold">NAMA MURID</td>
                    <td width="25%" align="center" class="descbold" style="border-left:none;">ANGKA GILIRAN</td>
                   
                    	<?php
                    		$kod_modul = explode(',', $student[0]->kod_subjek);
							foreach($kod_modul as $key=>$rows)
                			{
                				
                    	 ?>
                    	  		<td width="14%" align="center" class="descbold" style="border-left:none;">
                    			<?=$rows?>
                    			</td>
                    	<?php
							}
						?>
                   

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
              
        			<tr <?=$tr?> height="26px" class="tables">
                    	<td class="dep" align="center" style="border-right:none;border-top:none;"><?= $bil ?></td>
                    	<td class="dep" style="border-top:none;">
                    		&nbsp;&nbsp;<?=strcap($row->stu_name)?>
                    	</td>
                    	<td class="dep" align="center" style="border-top:none;border-left:none">
                    		&nbsp;&nbsp;<?=$row->stu_matric_no?>
                    	</td>
                    	<!--<td class="dep" style="border-top:none;">-->
                    		<!--<table width="100%" height="30px" cellpadding=0 cellspacing=0 class="tables2">
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
                                            <tr rowspan="3">-->
                                    			<?php 
                                    			$co=0;
                                    			foreach($kod_subjek as $key=>$rows)
                                    			{
                                    				$avData = array();
												
                                    				if($type[$key]=="AK"){
                                    			  $this->m_result->modul_paper_ak($avData,$aOpt='',$mod_ids[$key]);
                                    			//print_r($avData);
                                    				?>
													
                                                <td class="desc" align="center" style="border-left:none;border-top:none">
                                                </td>
														<?php
														foreach($avData as $avrow){
															
														  $paper_num= $avrow->mod_paper_num;
														?>
									                     
                                                        <td class="desc" align="center" style="border-left:none;border-top:none">
                                                        </td>
														<?php
														}
												
														
													
                                    				?>
                                    		
                                    			
                                               <?php
													
													}else{
													?>
													
                                                <td class="desc" align="center" style="border-left:none;border-top:none">
                                                </td>
													<?php
													}
													}
												?>
                                            <!--</tr>
                                             
                                          </table>
                    		
                    	</td>
                    	<td>
                    		
                    	</td>-->
                        <!--<td   colspan="3" style="border-top:none; border-bottom: none;">
                        	
                            <!--<table width="100%" cellpadding="0" cellspacing="0">-->
                            	
                            	<!--<tr class="tables3">
                            		<td class="dep" align="left"><?=$row->stu_name?></td>
                            		<td class="dep" width="207" align="left"><?=$row->stu_matric_no?></td>
                            		
                                    <!--
                                    <td class="dep" width="129" align="left">ANGKA GILIRAN </td>
                                    <td class="dep" width="8" align="left" >:</td>
                                    <td class="dep" width="207" align="left"><?=$row->stu_matric_no?></td>
                                    <td class="dep" width="56" align="left">NAMA</td>
                                    <td class="dep" width="8" align="left" >:</td>
                                    <td class="dep" align="left" colspan="6"><?=$row->stu_name?></td>
                                    -->
                              <!-- </tr>
                                <tr>
                                	<!--<td colspan="12"   style="border-left:none; border-right:none; width:1px;">-->
                                    	<!--<table width="100%" height="30px" cellpadding=0 cellspacing=0 class="tables2" style="margin-left:1px;">
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
                                                <td rowspan="3" class="desc" align="center">&nbsp;</td>
														<?php
														foreach($avData as $avrow){
															
														  $paper_num= $avrow->mod_paper_num;
														?>
									                     <td style="border-left:none;border-right:none;" rowspan="3" class="desc" align="center"><?=$paper_num?></td>
                                                        <td rowspan="3" class="desc" align="center">&nbsp;</td>
														<?php
														}
												
														
													
                                    				?>
                                    		
                                    			
                                               <?php
													
													}else{
													?>
													<td style="border-left:none;border-right:none;" rowspan="3" class="desc" align="center">1</td>
                                                <td rowspan="3" class="desc" align="center">&nbsp;</td>
													<?php
													}
													}
												?>
                                            </tr>
                                             <tr>
                                             
                                              </tr>
                                          </table>-->
                                         
                          
                            <!--</table>-->
                           
                 
        
        	  		<?php
        	  		
        	  		
}
?>
<tfoot>
<tr>
<td colspan="4" align="center" class="dep">
&nbsp;
</td>
        	  </tr>
	

</tfoot>	
					</table>
					<br>
<table>
<tr bgcolor="#ffffff"  class="tables">
                    <td style="border:none;">&nbsp;</td>
                     <td  style="font-size:9px; " align="left" class="descbold">
                     <b>PERHATIAN</b><br/>
                     (1)	Angka Giliran calon tidak bole ditukar tanpa kebenaran Pengarah Peperiksaan<br/>
    				(2)	Pengawas dikehendaki memeriksa Kad Pengenalan / No Sijil Kelahiran 
    				calon setiap kali calon menghadiri peperiksaan bagi satu-satu kertas.<br/>
    				
                     </td>
                      <td   style="font-size:9px; " colspan="2" align="left" class="descbold">
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
</table>
<center>
	    
 </center>   
					
									
					<?php
				}else{
					echo "Tiada Maklumat";
				}
?>