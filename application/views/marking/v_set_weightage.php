<?php
/**************************************************************************************************
* File Name        : v_set_weightage.php
* Description      : This File contain setting weightage for sekolah and vokasional
* Author           : Freddy Ajang Tony
* Date             : 20 June 2013
* Version          : -
* Modification Log : -
* Function List	   : -
**************************************************************************************************/
	$session = $this->session->userdata["sesi"];;
	$year = $this->session->userdata["tahun"];;
	
	
	/**FDPO - Safe to be deleted**/
	//echo('<pre>');print_r($sesi);echo('</pre>');
	//die();
?>
<style>
	#selKvList, #searchKvList, .sul { list-style-type: none; margin: 0; padding: 0; float: left; margin-right: 10px; background: #eee; padding: 5px; width: 350px;}
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
	.bblue, .dblue{font-weight:bold; color:blue;}
	.ddark{font-weight:bold; color:inherit;}
	.dgreen{font-weight:bold; color:green;}
	
	#menutitle{
    font-size:16px;
    font-family:"Times New Roman", Times, serif;
    color:#006699;
    font-weight:bold;
	}
</style>
<script src="<?=base_url()?>assets/js/kv.msg.modal.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/js/weightage/kv.weightage.js" type="text/javascript"></script>
<h3>Penetapan Wajaran</h3><hr/>


	<form name="frmWeightage" id="frmWeightage" action="" method="post" class="form-inline">
    	<table class="breadcrumb border" width="100%" align="center">
        	<tbody>
               	<tr>
                  	<td colspan="3" height="35" align="center" style="font-size: 24px;font-weight: bold;"></td>
                </tr>               
                <tr>
                	
                    <td width="45%" align="right">Sesi</td>
                  	<td width="3%" align="center">:</td>
                    <td width="52%" id="sesitahun" value="<?=$year ?>"><?=$session ?>&nbsp;/&nbsp;<?=$year ?></td>
                </tr>
                <tr>
                    <td width="200" align="right">Jenis Modul</td>
                  	<td width="10" align="center">:</td>
                    <td width="368" height="35">
						  <label class="radio inline">
						  <input type="radio" class="rdType" name="rdType" id="rdType1" value="AK">Akademik
						  </label>
						  <label class="radio inline">
						  <input type="radio" class="rdType" name="rdType" id="rdType2" value="VK">Vokasional
						  </label>
					</td>
                </tr>
                <tr>
                    <td align="right">Modul</td>
                  	<td align="center">:</td>
                    <td id="tdmdl" height="35">
                      	<select name="mdl" id="mdl" disabled="true">
                        <option value="-1">-- Sila Pilih --</option>
                        </select>
                    </td>
                </tr>
                <tr>
                	<td align="right">Jam Kredit</td>
                   	<td align="center">:</td>
                   	<td height="35"><input readonly="" type="text" id="subkredit" name="subkredit"></td>
                 </tr>
                 <tr>
                 	<td align="right">Semester</td>
                   	<td align="center">:</td>
                    <td height="35"><input readonly="" type="text" id="subsem" name="subsem"></td>
                 </tr>
                 <tr>
                 	<td></td>
            		<td></td>
                    <td id="progress">&nbsp;</td>
                 </tr>
                 <tr>
            		<td colspan="3" style="text-align: center;">
                        <button id="btn_config_weightage" class="btn btn-primary btn_config_weightage" type="button" disabled="disabled">
                        <span>Penetapan Wajaran</span></button>
                    	<input class="btn" type="reset" name="btn_reset" id="btn_clear" value="Set Semula">
                		<br>
            		</td>
                 </tr>
                 <tr>
                  	<td></td>
                  	<td></td>
                  	<td>&nbsp;</td>
                 </tr>
            </tbody>        
      </table>
	</form>    


<div id="progress_switch"></div>
<div class="modal hide fade" id="myModal" style="width:60%; left:40%;">
    <div class="modal-header" style="border-bottom: none;">
    	 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&nbsp;&times;&nbsp;</button>
        <h2><strong>Penetapan Wajaran Markah</strong></h2>
        <h4 style="color: #999999; font-weight: normal;"><span id="module"></span></td></h4>
    </div>
    <div class="modal-body" style="padding-top: 0px;" >
        <form id="formConfig" name="formConfig" style="position:relative;" method="post">
        	<input type="hidden" id="category" name="category" value="" />
        	<input type="hidden" id="mod_id" name="mod_id" value="" />
        	<input type="hidden" id="p_id" name="p_id" value="" />
        	<input type="hidden" id="s_id" name="s_id" value="" />
        	<input type="hidden" id="paper" name="paper" value="null" />
                <table id="tblwajaran" style="margin-bottom:5px;" class="table table-striped table-bordered table-condensed">
            	<thead>
                <tr>
                	<td width="175" rowspan="3" style="vertical-align: middle;" ><strong>Jenis Pentaksiran</strong></td>
                  	<td width="175" colspan="5" style="text-align:center;"><strong>Wajaran Markah(<span id="percent"></span>%)</strong></td>
              	</tr>
              	<tr id="headerWajaran" style="font-weight: bold;">
              	</tr>
                </thead>
                <tbody>
                </tbody>
                <tfoot>
                </tfoot>               
            </table>
            <button id="btn_edit_weightage" class="btn btn-info" type="button">Penetapan Wajaran</button>
            <div class="pull-right">
            <button id="btnClearConfiq" type="button" name="btnClearConfiq" disabled="disabled" class="btn btn-primary"><span>Set Semula</span></button>&nbsp;
            <button id="btnSaveConfiq" type="button" name="btnSave" disabled="disabled" class="btn btn-primary"><span>Simpan</span></button>
            </div>
        </form>
        <div id="configProgress" style="text-align:center;"></div>
    </div>
</div>


<?php
/**************************************************************************************************
* End of v_set_weightage.php
**************************************************************************************************/
?>