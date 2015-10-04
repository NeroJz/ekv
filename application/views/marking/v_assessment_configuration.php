<?php
/**************************************************************************************************
* File Name        : v_assessment_configuration.php
* Description      : This File contain configuration open and close date for assessment.
* Author           : Freddy Ajang Tony
* Date             : 18 June 2013
* Version          : -
* Modification Log : -
* Function List	   : -
**************************************************************************************************/
	$sdconfig_id = 0;
	$session = '';
	$year = '';
	$open_date = '';
	$close_date = '';
	$start_date_mil = 0;
	$end_date_mil = 0;
	$status = false;
	$today = strtotime(date("d-m-Y"));
	$ulmconfig_id = array();
	$ulmconfig_mid = array();
	$ul_details = array();
	$ul_mdetails;
	$ul_name = array("Pengarah","Timbalan Pengarah","KJPP/KUPP");
	$ul_id = array("5","6","3_7_8");
	$empty_date = '';
	$index = 0;
	$current_session = $this->session->userdata["sesi"];
	$current_year = $this->session->userdata["tahun"];
	
	
	if(isset($configuration))
	{
	
		if(isset($configuration->userlist))
		{
			foreach($configuration->userlist as $userconf=>$value)
			{
				$strValue[] = str_replace(',','_',$value["ul_ids"]);
				$ul_details[$value["ul_names"]]= $value;
				$ulmconfig_id[] = $value["ulmconfig_ids"];
			}
		}
		
		/**FDPO - Safe to be deleted**/
		//echo('<pre>');print_r($ul_details);echo('</pre>');
		//die();
		if($today<=$end_date_mil && $today>=$start_date_mil)
			$status = true;
	}
	
	
?>
<style>
	#selKvList, #searchKvList, #selKvListm, #searchKvListm, .sul { list-style-type: none; margin: 0; padding: 0; float: left; margin-right: 10px; background: #eee; padding: 5px; width: 350px;}
	.items {margin: 1px; padding: 2px; border: 1px solid #CCC; background: #F6F6F6; 
			font-weight:bold; color: #1C94C4; outline: none; cursor:default; position: relative;
    		float:left;	width:345px;
	}
	.closebtn, .mclosebtn {position:absolute;opacity:1;right:0px;top:3px;width:16px;height:16px;cursor:pointer; border:1px solid #000; background-color:#efefef;
   			z-index: 5;background: url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAQAAAC1+jfqAAAAiElEQVR42r2RsQrDMAxEBRdl8SDcX8lQPGg1GBI6lvz/h7QyRRXV0qUULwfvwZ1tenw5PxToRPWMC52eA9+WDnlh3HFQ/xBQl86NFYJqeGflkiogrOvVlIFhqURFVho3x1moGAa3deMs+LS30CAhBN5nNxeT5hbJ1zwmji2k+aF6NENIPf/hs54f0sZFUVAMigAAAABJRU5ErkJggg==) no-repeat;
    		text-align:right; border: 0; cursor: pointer;    
	}
	.closebtn:hover, .closebtn:focus, .mclosebtn:hover, .mclosebtn:focus  {
		background: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAQAAAC1+jfqAAAAqklEQVR4XqWRMQ6DMAxF/1Fyilyj2SmIBUG5QcTCyJA5Z8jGhlBPgRi4TmoDraVmKFJlWYrlp/g5QfwRlwEVNWVa4WzfH9jK6kCkEkBjwxOhLghheMWMELUAqqwQ4OCbnE4LJnhr5IYdqQt4DJQjhe9u4vBBmnxHHNzRFkDGjHDo0VuTAqy2vAG4NkvXXDHxbGsIGlj3e835VFNtdugma/Jk0eXq0lP//5svi4PtO01oFfYAAAAASUVORK5CYII=") no-repeat;
	}
	.kvid{display:none;}
	.kvidm{display:none;}
	.bblue, .dblue{font-weight:bold; color:blue;}
	.ddark{font-weight:bold; color:inherit;}
	.dgreen{font-weight:bold; color:green;}
	.dred{font-weight:bold; color:red;}
	
	#menutitle{
    font-size:14px;
    font-family:"Times New Roman", Times, serif;
    color:#006699;
    font-weight:bold;
	}
</style>
<script src="<?=base_url()?>assets/js/assessment/kv.assessment.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/js/kv.msg.modal.js" type="text/javascript"></script>

<h3>Penetapan Kemasukan Pentaksiran</h3><hr/><br/>
<ul class="nav nav-tabs" id="myTab">
  <li class="active"><a href="#s_status" data-toggle="tab">Status</a></li>
  <li><a href="#s_configure_vk" data-toggle="tab">Penetapan Kemasukan Pentaksiran (Akademik)</a></li>
</ul>
<div class="tab-content">
  <div class="tab-pane active " id="s_status">
  	<input type="hidden" id="today_date" name="today_date" value="<?=$today ?>">
  	<input type="hidden" id="cur_session" name="cur_session" value="<?=$current_session ?>/<?=$current_year ?>">
  	<table id="tblStatusSd" width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped ">
        <tbody>
     
        </tbody>
    </table>
  </div>
    <div class="tab-pane" id="s_configure_vk">
    <div class="accordion" id="accordion_s_configure">
		  <div class="accordion-group">
		    <div class="accordion-heading">
			       <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_s_configure" href="#collapseOne">
			        <strong id="menutitle">Penetapan Tarikh Kemasukan Pentaksiran</strong> &nbsp;&nbsp;<i class="icon-edit pull-right"></i>
			      </a>
			</div>
		    <div id="collapseOne" class="accordion-body collapse in">
		      <div class="accordion-inner">
		        <form id="frmOpenSetting" name="frmOpenSetting" method="post" class="form-horizontal"><br />
				
		        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped ">
		        <tbody>
		            
		            <tr>
		                <td width="17%" ><strong class="tablepadding">Sesi</strong></td>
		                <td id="tdsessionyear3" width="40%" >
		                <select id="slctsesi_vk" name="slctsesi" class="validate[required] span3">
		                	<option value="">--Sesi--</option>
		                </select>
		                <strong class="tablepadding"></strong></td>
		                
		                <td ><strong class="tablepadding">&nbsp;</strong></td>
		            </tr>
		            <tr>
		            	<td rowspan="2"><strong class="tablepadding">Semester</strong></td>
		            	<td id="tdlink_group" style="height: 37px;">
		            		
		            	</td>
		            	<td>
		            		
		            	</td>
		            </tr>
		            <tr>
		                
		                <td>		          
		                	<label class="checkbox inline">
							  <input class="validate[required]" type="checkbox" name="chksem[]" id="chkSem1" value="1"> 1
							</label>
							<label class="checkbox inline">
							  <input class="validate[required]" type="checkbox" name="chksem[]" id="chkSem2" value="2"> 2
							</label>
							<label class="checkbox inline">
							  <input class="validate[required]" type="checkbox" name="chksem[]" id="chkSem3" value="3"> 3
							</label>
		                	<label class="checkbox inline">
							  <input class="validate[required]" type="checkbox" name="chksem[]" id="chkSem4" value="4"> 4
							</label>
							<label class="checkbox inline">
							  <input class="validate[required]" type="checkbox" name="chksem[]" id="chkSem5" value="5"> 5
							</label>
							<label class="checkbox inline">
							  <input class="validate[required]" type="checkbox" name="chksem[]" id="chkSem6" value="6"> 6
							</label>
							<label class="checkbox inline">
							  <input class="validate[required]" type="checkbox" name="chksem[]" id="chkSem7" value="7"> 7
							</label>
							<label class="checkbox inline">
							  <input class="validate[required]" type="checkbox" name="chksem[]" id="chkSem8" value="8"> 8
							</label>						
		                </td>
		                
		                <td id="progress"><strong class="tablepadding">&nbsp;</strong></td>
		            </tr>
		            <tr>
		                <td width="30%" colspan="2" valign="middle">
		                <table id="tblAssessmentdate" name="tblAssessmentdate" class="table table-condensed table-bordered" width="100%">
		                <tbody>
		                
		                <tr><td width="25%" style="vertical-align: middle;">Pusat (Amali)</td>
		                <input type="hidden" id="sdctype_PA" name="sdctype_PA[sd_assessment_type]" value="PA">
		                <input type="hidden" id="sdconfig_id_PA" name="sdctype_PA[sdconfig_id]" value="0">
		                <td width="30%" style="vertical-align: middle;">Dari*:&nbsp;&nbsp;		               	
		                <input id="sddatefrom_PA" name="sdctype_PA[sd_open_date]" placeholder="DD-MM-YYYY" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>&nbsp;&nbsp;
		                </td>
		                <td style="vertical-align: middle;">Hingga*:&nbsp;&nbsp;
		                <input id="sddateto_PA" name="sdctype_PA[sd_close_date]" placeholder="DD-MM-YYYY" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>			                	
		                <button id="btnUserPA" class="btn pull-right" type="button" data-original-title="Tarikh Pengguna Pusat(Amali)"><i class="icon-user pull-right"></i></button>
		                </td></tr>
		                
		                <tr><td width="30%" style="vertical-align: middle;">Pusat (Teori)</td>
		                <input type="hidden" id="sdctype_PT" name="sdctype_PT[sd_assessment_type]" value="PT">
		                <input type="hidden" id="sdconfig_id_PT" name="sdctype_PT[sdconfig_id]" value="0">
		                <td style="vertical-align: middle;">Dari*:&nbsp;&nbsp;
		                <input id="sddatefrom_PT" name="sdctype_PT[sd_open_date]" placeholder="DD-MM-YYYY" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>&nbsp;&nbsp;		                	
		                </td><td style="vertical-align: middle;">Hingga*:&nbsp;&nbsp;
		                <input id="sddateto_PT" name="sdctype_PT[sd_close_date]" placeholder="DD-MM-YYYY" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>	                	
		                <button id="btnUserPT" class="btn pull-right" type="button" data-original-title="Tarikh Pengguna Pusat(Teori)"><i class="icon-user pull-right"></i></button>	
		                </td></tr>
		                
		                <tr><td width="25%" style="vertical-align: middle;">Akademik (Pusat)</td>
		                <input type="hidden" id="sdctype_PAK" name="sdctype_PAK[sd_assessment_type]" value="PAK">
		                <input type="hidden" id="sdconfig_id_PAK" name="sdctype_PAK[sdconfig_id]" value="0">
		                <td width="30%" style="vertical-align: middle;">Dari*:&nbsp;&nbsp;
		                <input id="sddatefrom_PAK" name="sdctype_PAK[sd_open_date]" placeholder="DD-MM-YYYY" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>&nbsp;&nbsp;
		                </td>
		                <td style="vertical-align: middle;">Hingga*:&nbsp;&nbsp;
		                <input id="sddateto_PAK" name="sdctype_PAK[sd_close_date]" placeholder="DD-MM-YYYY" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>	
		                <button id="btnUserPAK" class="btn pull-right" type="button" data-original-title="Tarikh Pengguna Pusat(Akademik)"><i class="icon-user pull-right"></i></button>
		                </td></tr>
		               
		                </tbody></table>
		               
		                </td>
		                
		                <td id="tdload" >
		                <input type="hidden" id="ulmsdconfig_id_PA" name="usersdconfig_PA" value="0" />
		                <table id="tblUserdate_PA" name="tblUserdate_PA" class="table-striped table-bordered table-condensed" width="100%">
		                <tr><td width="30%" align="middle"><strong class="tablepadding">Jawatan</strong></td>
		                <td width="30%" align="middle"><strong class="tablepadding">Tarikh Tutup</strong></td>
		                </tr>
		                <tr>
		                <td width="30%" valign="middle"> Pengarah : </td>
		                <input type="hidden" id="ulmconfig_id_5_PA" name="userconfig_PA_5[ulmconfig_id]" value="0" />
		                <input type="hidden" id="ulid_5_PA" name="userconfig_PA_5[ul_id]" value="5" />
		                <td>&nbsp;
		                <input id="udtid_5_PA" name="userconfig_PA_5[end_date_user]" placeholder="DD-MM-YYYY" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>
		                </td></tr>
		                <tr>
		                <td width="30%" valign="middle"> Timb. Pengarah : </td>
		                <input type="hidden" id="ulmconfig_id_6_PA" name="userconfig_PA_6[ulmconfig_id]" value="0" />
		                <input type="hidden" id="ulid_6_PA" name="userconfig_PA_6[ul_id]" value="6" />
		                <td>&nbsp;
		                <input id="udtid_6_PA" name="userconfig_PA_6[end_date_user]" placeholder="DD-MM-YYYY" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>
		                </td></tr>
		                <tr>
		                <td width="30%" valign="middle"> KJPP/KUPP : </td>
		                <input type="hidden" id="ulmconfig_id_3_PA" name="userconfig_PA_3[ulmconfig_id]" value="0" />
		                <input type="hidden" id="ulid_3_PA" name="userconfig_PA_3[ul_id]" value="3,7,8" />
		                <td>&nbsp;
		                <input id="udtid_3_PA" name="userconfig_PA_3[end_date_user]" placeholder="DD-MM-YYYY" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>
		                </td></tr>	           	
		                </table>
		                
		                <input type="hidden" id="ulmsdconfig_id_PT" name="usersdconfig_PT" value="0" />
		                <table id="tblUserdate_PT" name="tblUserdate_PT" class="table-striped table-bordered table-condensed" width="100%">
		                <tr><td width="30%" align="middle"><strong class="tablepadding">Jawatan</strong></td>
		                <td width="30%" align="middle"><strong class="tablepadding">Tarikh Tutup</strong></td>
		                </tr>
		                <tr>
		                <td width="30%" valign="middle"> Pengarah : </td>
		                <input type="hidden" id="ulmconfig_id_5_PT" name="userconfig_PT_5[ulmconfig_id]" value="0" />
		                <input type="hidden" id="ulid_5_PT" name="userconfig_PT_5[ul_id]" value="5" />
		                <td>&nbsp;
		                <input id="udtid_5_PT" name="userconfig_PT_5[end_date_user]" placeholder="DD-MM-YYYY" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>
		                </td></tr>
		                <tr>
		                <td width="30%" valign="middle"> Timb. Pengarah : </td>
		                <input type="hidden" id="ulmconfig_id_6_PT" name="userconfig_PT_6[ulmconfig_id]" value="0" />
		                <input type="hidden" id="ulid_6_PT" name="userconfig_PT_6[ul_id]" value="6" />
		                <td>&nbsp;
		                <input id="udtid_6_PT" name="userconfig_PT_6[end_date_user]" placeholder="DD-MM-YYYY" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>
		                </td></tr>
		                <tr>
		                <td width="30%" valign="middle"> KJPP/KUPP : </td>
		                <input type="hidden" id="ulmconfig_id_3_PT" name="userconfig_PT_3[ulmconfig_id]" value="0" />
		                <input type="hidden" id="ulid_3_PT" name="userconfig_PT_3[ul_id]" value="3,7,8" />
		                <td>&nbsp;
		                <input id="udtid_3_PT" name="userconfig_PT_3[end_date_user]" placeholder="DD-MM-YYYY" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>
		                </td></tr>	           	
		                </table>
		                		                
		                <input type="hidden" id="ulmsdconfig_id_PAK" name="usersdconfig_PAK" value="0" />
		                <table id="tblUserdate_PAK" name="tblUserdate_PAK" class="table-striped table-bordered table-condensed" width="100%">
		                <tr><td width="30%" align="middle"><strong class="tablepadding">Jawatan</strong></td>
		                <td width="30%" align="middle"><strong class="tablepadding">Tarikh Tutup</strong></td>
		                </tr>
		                <tr>
		                <td width="30%" valign="middle"> Pengarah : </td>
		                <input type="hidden" id="ulmconfig_id_5_PAK" name="userconfig_PAK_5[ulmconfig_id]" value="0" />
		                <input type="hidden" id="ulid_5_PAK" name="userconfig_PAK_5[ul_id]" value="5" />
		                <td>&nbsp;
		                <input id="udtid_5_PAK" name="userconfig_PAK_5[end_date_user]" placeholder="DD-MM-YYYY" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>
		                </td></tr>
		                <tr>
		                <td width="30%" valign="middle"> Timb. Pengarah : </td>
		                <input type="hidden" id="ulmconfig_id_6_PAK" name="userconfig_PAK_6[ulmconfig_id]" value="0" />
		                <input type="hidden" id="ulid_6_PAK" name="userconfig_PAK_6[ul_id]" value="6" />
		                <td>&nbsp;
		                <input id="udtid_6_PAK" name="userconfig_PAK_6[end_date_user]" placeholder="DD-MM-YYYY" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>
		                </td></tr>
		                <tr>
		                <td width="30%" valign="middle"> KJPP/KUPP : </td>
		                <input type="hidden" id="ulmconfig_id_3_PAK" name="userconfig_PAK_3[ulmconfig_id]" value="0" />
		                <input type="hidden" id="ulid_3_PAK" name="userconfig_PAK_3[ul_id]" value="3,7,8" />
		                <td>&nbsp;
		                <input id="udtid_3_PAK" name="userconfig_PAK_3[end_date_user]" placeholder="DD-MM-YYYY" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>
		                </td></tr>	           	
		                </table>

		                </td>             
		            </tr>
		            
		            <tr>
		                <td colspan="3">
		                  	<button id="btn_save_a" class="btn btn-info pull-right" type="button">Simpan</button>&nbsp;
		                    <button id="btn_reset_a" type="reset" class="btn btn-info pull-right" style="margin-right: 5px;">Reset</button>&nbsp;
		                 </td>
		            </tr>
		        </tbody>
		        </table>
		        </form>
		      </div>
		    </div>
		    </div>
		    <div class="accordion-group">
			    <div class="accordion-heading">
			      <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion_s_configure" href="#collapseTwo">
			        <strong id="menutitle">Penetapan Tarikh Kemasukan Pentaksiran (Manual)</strong>&nbsp;&nbsp;<i class="icon-edit pull-right"></i>
			      </a>
			    </div>
			    <div id="collapseTwo" class="accordion-body collapse">
			      <div class="accordion-inner">
			        <form id="frmOpenManual" name="frmOpenManual" method="post" class="form-horizontal">
			        <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-bordered table-striped ">
			        <tbody>
			        	 <tr>
		                <td width="17%" ><strong class="tablepadding">Sesi</strong></td>
		                <td id="tdmsessionyear3" width="38%" >
		                	<select id="slctsesi_mvk" name="slctsesi" class="validate[required] span3">
		                	<option value="">--Sesi--</option>
		          
		                	</select>
		                <strong class="tablepadding"></strong></td>
		                <td>&nbsp;</td>
		            	</tr>
		            	<tr>
		            	<td><strong class="tablepadding">Semester</strong></td>
		            	<td>		          
		                	<label class="checkbox inline">
							  <input class="validate[required]" type="checkbox" name="chksem[]" id="chkSem1" value="1"> 1
							</label>
							<label class="checkbox inline">
							  <input class="validate[required]" type="checkbox" name="chksem[]" id="chkSem2" value="2"> 2
							</label>
							<label class="checkbox inline">
							  <input class="validate[required]" type="checkbox" name="chksem[]" id="chkSem3" value="3"> 3
							</label>
		                	<label class="checkbox inline">
							  <input class="validate[required]" type="checkbox" name="chksem[]" id="chkSem4" value="4"> 4
							</label>
							<label class="checkbox inline">
							  <input class="validate[required]" type="checkbox" name="chksem[]" id="chkSem5" value="5"> 5
							</label>
							<label class="checkbox inline">
							  <input class="validate[required]" type="checkbox" name="chksem[]" id="chkSem6" value="6"> 6
							</label>
							<label class="checkbox inline">
							  <input class="validate[required]" type="checkbox" name="chksem[]" id="chkSem7" value="7"> 7
							</label>
							<label class="checkbox inline">
							  <input class="validate[required]" type="checkbox" name="chksem[]" id="chkSem8" value="8"> 8
							</label>						
		                </td>	
		            	<td id="progressm">&nbsp;</td>	       
		            	</tr>			     
			            <tr>			           
			               	<td width="30%" colspan="2" valign="middle">
			                <table id="tblAssessmentmdate" name="tblAssessmentmdate" class="table table-condensed table-bordered" width="100%">
			                <tbody>
			                
			                <tr><td width="25%" style="vertical-align: middle;">Pusat (Amali)</td>
			                <input type="hidden" id="sdmctype_PA" name="sdmctype_PA[sdm_assessment_type]" value="PA">
			                <input type="hidden" id="sdmconfig_id_PA" name="sdmctype_PA[sdmconfig_id]" value="0">
			                <td width="30%" style="vertical-align: middle;">Dari*:&nbsp;&nbsp;<input id="sdmdatefrom_PA"  placeholder="DD-MM-YYYY" name="sdmctype_PA[sdm_open_date]" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>&nbsp;&nbsp;
			                </td>
			                <td style="vertical-align: middle;">Hingga*:&nbsp;&nbsp;<input id="sdmdateto_PA" placeholder="DD-MM-YYYY" name="sdmctype_PA[sdm_close_date]" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>	
			                <button id="btnUsermPA" class="btn pull-right" type="button" data-original-title="Tarikh Pengguna Pusat(Amali)" ><i class="icon-user pull-right"></i></button>
			                </td></tr>
			                
			                <tr><td width="30%" style="vertical-align: middle;">Pusat (Teori)</td>
			                <input type="hidden" id="sdmctype_PT" name="sdmctype_PT[sdm_assessment_type]" value="PT">
			                <input type="hidden" id="sdmconfig_id_PT" name="sdmctype_PT[sdmconfig_id]" value="0">
			                <td style="vertical-align: middle;">Dari*:&nbsp;&nbsp;<input id="sdmdatefrom_PT" placeholder="DD-MM-YYYY" name="sdmctype_PT[sdm_open_date]" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>&nbsp;&nbsp;
			                </td><td style="vertical-align: middle;">Hingga*:&nbsp;&nbsp;<input id="sdmdateto_PT" placeholder="DD-MM-YYYY" name="sdmctype_PT[sdm_close_date]" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>
			                <button id="btnUsermPT" class="btn pull-right" type="button" data-original-title="Tarikh Pengguna Pusat(Teori)"><i class="icon-user pull-right"></i></button>	
			                </td></tr>
			                
			                <tr><td width="25%" style="vertical-align: middle;">Akademik (Pusat)</td>
			                <input type="hidden" id="sdmctype_PAK" name="sdmctype_PAK[sdm_assessment_type]" value="PAK">
			                <input type="hidden" id="sdmconfig_id_PAK" name="sdmctype_PAK[sdmconfig_id]" value="0">
			                <td width="30%" style="vertical-align: middle;">Dari*:&nbsp;&nbsp;<input id="sdmdatefrom_PAK" placeholder="DD-MM-YYYY" name="sdmctype_PAK[sdm_open_date]" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>&nbsp;&nbsp;
			                </td>
			                <td style="vertical-align: middle;">Hingga*:&nbsp;&nbsp;<input id="sdmdateto_PAK" placeholder="DD-MM-YYYY" name="sdmctype_PAK[sdm_close_date]" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>	
			                <button id="btnUsermPAK" class="btn pull-right" type="button" data-original-title="Tarikh Pengguna Akademik(Pusat)" ><i class="icon-user pull-right"></i></button>
			                </td></tr>
	
			                </tbody></table>			          
			                </td> 
			                
				            <td>
			                <input type="hidden" id="ulmsdmconfig_id_PA" name="usersdmconfig_PA" value="0" />
			                <table id="tblUsermdate_PA" name="tblUsermdate_PA" class="table-striped table-bordered table-condensed" width="100%">
			                <tr><td width="30%" align="middle"><strong class="tablepadding">Jawatan</strong></td>
			                <td width="30%" align="middle"><strong class="tablepadding">Tarikh Tutup</strong></td>
			                </tr>
			                <tr>
			                <td width="30%" valign="middle"> Pengarah : </td>
			                <input type="hidden" id="ulmmconfig_id_5_PA" name="usermconfig_PA_5[ulmconfig_id]" value="0" />
			                <input type="hidden" id="ulmid_5_PA" name="usermconfig_PA_5[ul_id]" value="5" />
			                <td>&nbsp;
			                <input id="udtmid_5_PA" name="usermconfig_PA_5[end_date_user]" placeholder="DD-MM-YYYY" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>
			                </td></tr>
			                <tr>
			                <td width="30%" valign="middle"> Timb. Pengarah : </td>
			                <input type="hidden" id="ulmmconfig_id_6_PA" name="usermconfig_PA_6[ulmconfig_id]" value="0" />
			                <input type="hidden" id="ulmid_6_PA" name="usermconfig_PA_6[ul_id]" value="6" />
			                <td>&nbsp;
			                <input id="udtmid_6_PA" name="usermconfig_PA_6[end_date_user]" placeholder="DD-MM-YYYY" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>
			                </td></tr>
			                <tr>
			                <td width="30%" valign="middle"> KJPP/KUPP : </td>
			                <input type="hidden" id="ulmmconfig_id_3_PA" name="usermconfig_PA_3[ulmconfig_id]" value="0" />
			                <input type="hidden" id="ulmid_3_PA" name="usermconfig_PA_3[ul_id]" value="3,7,8" />
			                <td>&nbsp;
			                <input id="udtmid_3_PA" name="usermconfig_PA_3[end_date_user]" placeholder="DD-MM-YYYY" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>
			                </td></tr>	           	
			                </table>
			                
			                <input type="hidden" id="ulmsdmconfig_id_PT" name="usersdmconfig_PT" value="0" />
			                <table id="tblUsermdate_PT" name="tblUsermdate_PT" class="table-striped table-bordered table-condensed" width="100%">
			                <tr><td width="30%" align="middle"><strong class="tablepadding">Jawatan</strong></td>
			                <td width="30%" align="middle"><strong class="tablepadding">Tarikh Tutup</strong></td>
			                </tr>
			                <tr>
			                <td width="30%" valign="middle"> Pengarah : </td>
			                <input type="hidden" id="ulmmconfig_id_5_PT" name="usermconfig_PT_5[ulmconfig_id]" value="0" />
			                <input type="hidden" id="ulmid_5_PT" name="usermconfig_PT_5[ul_id]" value="5" />
			                <td>&nbsp;
			                <input id="udtmid_5_PT" name="usermconfig_PT_5[end_date_user]" placeholder="DD-MM-YYYY" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>
			                </td></tr>
			                <tr>
			                <td width="30%" valign="middle"> Timb. Pengarah : </td>
			                <input type="hidden" id="ulmmconfig_id_6_PT" name="usermconfig_PT_6[ulmconfig_id]" value="0" />
			                <input type="hidden" id="ulmid_6_PT" name="usermconfig_PT_6[ul_id]" value="6" />
			                <td>&nbsp;
			                <input id="udtmid_6_PT" name="usermconfig_PT_6[end_date_user]" placeholder="DD-MM-YYYY" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>
			                </td></tr>
			                <tr>
			                <td width="30%" valign="middle"> KJPP/KUPP : </td>
			                <input type="hidden" id="ulmmconfig_id_3_PT" name="usermconfig_PT_3[ulmconfig_id]" value="0" />
			                <input type="hidden" id="ulmid_3_PT" name="usermconfig_PT_3[ul_id]" value="3,7,8" />
			                <td>&nbsp;
			                <input id="udtmid_3_PT" name="usermconfig_PT_3[end_date_user]" placeholder="DD-MM-YYYY" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>
			                </td></tr>	           	
			                </table>
			                
			                <input type="hidden" id="ulmsdmconfig_id_PAK" name="usersdmconfig_PAK" value="0" />
			                <table id="tblUsermdate_PAK" name="tblUsermdate_PAK" class="table-striped table-bordered table-condensed" width="100%">
			                <tr><td width="30%" align="middle"><strong class="tablepadding">Jawatan</strong></td>
			                <td width="30%" align="middle"><strong class="tablepadding">Tarikh Tutup</strong></td>
			                </tr>
			                <tr>
			                <td width="30%" valign="middle"> Pengarah : </td>
			                <input type="hidden" id="ulmmconfig_id_5_PAK" name="usermconfig_PAK_5[ulmconfig_id]" value="0" />
			                <input type="hidden" id="ulmid_5_PAK" name="usermconfig_PAK_5[ul_id]" value="5" />
			                <td>&nbsp;
			                <input id="udtmid_5_PAK" name="usermconfig_PAK_5[end_date_user]" placeholder="DD-MM-YYYY" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>
			                </td></tr>
			                <tr>
			                <td width="30%" valign="middle"> Timb. Pengarah : </td>
			                <input type="hidden" id="ulmmconfig_id_6_PAK" name="usermconfig_PAK_6[ulmconfig_id]" value="0" />
			                <input type="hidden" id="ulmid_6_PAK" name="usermconfig_PAK_6[ul_id]" value="6" />
			                <td>&nbsp;
			                <input id="udtmid_6_PAK" name="usermconfig_PAK_6[end_date_user]" placeholder="DD-MM-YYYY" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>
			                </td></tr>
			                <tr>
			                <td width="30%" valign="middle"> KJPP/KUPP : </td>
			                <input type="hidden" id="ulmmconfig_id_3_PAK" name="usermconfig_PAK_3[ulmconfig_id]" value="0" />
			                <input type="hidden" id="ulmid_3_PAK" name="usermconfig_PAK_3[ul_id]" value="3,7,8" />
			                <td>&nbsp;
			                <input id="udtmid_3_PAK" name="usermconfig_PAK_3[end_date_user]" placeholder="DD-MM-YYYY" value="" type="text" class="validate[custom[tarikh],datepicker] input-small"/>
			                </td></tr>	           	
			                </table>
			                
			                </td>
			            </tr>
			           
			            <tr>
			                <td width="10%" style="vertical-align:top"><strong class="tablepadding">Buka Kepada<span class="style8">*</span></strong></td>
			                <td colspan="2">                            
			                    <div id="kvList">
			                        <table class="table-striped table-bordered table-condensed">
			                            <tr>
			                                <td width="28%" style="vertical-align:top">
			                                	<div align="left"><strong id="menutitle">
			                                    &nbsp;Carian KV:</strong>
			                                    <a id="searchKv" style="margin-left:10px;" class="btn" href="javascript: void(0);" data-original-title="Carian KV">
			                               	 	<i class="icon-search"></i>                                    
			                               	 	</a></div>                              
			                               	 </td>
			                              <td width="55%" style="vertical-align:top">
			                                <input type="hidden" id="txtKvList" name="txtKvList" value="" />
			                                <ul id="selKvList">
			                                </ul>                                
			                              </td>
			                            </tr>
			                        </table>
			                  </div>
			                </td>
			            </tr>
			            <tr>		               
			                <td colspan="3">
			                    <button id="btn_save_m" class="btn btn-info pull-right" type="button">Simpan</button>
			                    <button id="btn_reset_m" type="reset" class="btn btn-info pull-right" style="margin-right: 5px;">Reset</button>
			                 </td>
			            </tr>
			        </tbody>
			        </table>
			    </form>
			      </div>
			    </div>
			  </div>
		  </div>
  </div>
  
        
  </div>
</div>


<div class="modal hide fade" id="searchModal" style="width:90%; left:27%;">
    <div class="modal-header">
    <button id="btn_close" type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
      <h4><strong>CARIAN KV</strong></h4>
    </div>
    <div class="modal-body" >
  	
	<form id="frmSearchKv" name="frmSearchKv" method="post" class="form-inline" style="position:relative;vertical-align:center;">
	  <input type="hidden" id="searchForm" name="searchForm" value="" />
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table table-striped table-bordered">
        <tbody>
            <tr>
                <td colspan="2" ><strong id="menutitle">&nbsp;&nbsp;&nbsp;Cari KV :&nbsp;&nbsp;</strong>
                  <input type="text" name="cKv" id="cKv" class="span3 " placeholder="Kod Institusi atau Nama Institusi"/>
                  <input type="submit" name="CarianKv" id="CarianKv" value="Cari" class="btn btn-primary"/>
                                  
                </td>
          </tr>
          <tr>
          		<td colspan="2">
                	<table id="Hkv" width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bordered">
                    	<thead>
                        <tr>
                        	<th style="border-bottom:1px solid #DDD;" width="20%">Kod Pusat</th>
                            <th style="border-bottom:1px solid #DDD;" width="70%">Nama Institusi</th>
                            <th style="border-bottom:1px solid #DDD;" width="10%" align="center">&nbsp;</th>
                        </tr>
                        </thead> 
                        <tr>                  
                        <tbody></tbody>
                    	</tr>
                    </table>
                 </td>
          </tr>
          <tr>
          	<td width="15%">Institusi yang Dipilih</td>
            <td>
            <ul id="searchKvList">
            </ul>
            </td>
          </tr>
        </tbody>
      </table>
      
      <button id="btnCnfmKv" type="submit" name="submit" class="btn btn-info pull-right"><span>OK</span></button>
      
      <br />
      <br />

  </form>
  </div>  	
</div>

<?php
/**************************************************************************************************
* End of v_assessment_configuration.php
**************************************************************************************************/
?>