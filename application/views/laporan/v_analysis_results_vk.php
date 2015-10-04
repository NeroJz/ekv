
<script language="javascript" type="text/javascript" >
    var kodkv = [
                <?= $centrecode ?>
            ];
</script>
<script src="<?=base_url()?>assets/js/report/kv.attendance.js" type="text/javascript"></script>

<legend><h3>Analisis Keputusan Module Vakisonal</h3></legend>
<center>

<form id="frm_pusat" action="<?= site_url('report/result/analysis_results_print_vk')?>" method="post" target="_blank" class="form-inline">
<table class="breadcrumb border" width="100%" align="center">
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
    
            <?php
            $colll=empty($colname)?'':$colname;
            
            if($colll!=''){
            ?>
          <input type="hidden" value="<?=$colll?>" name="kodpusat" id="kodpusat"/>
          <?php
    }else{
        ?>
         <tr>
        <td width="45%" height="35"><div align="right">Kod Pusat</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35"><div align="left">
        <input type="text" name="kodpusat" id="kodpusat" class="span3" style="margin-left:0px;width:270px;"/>
        <?php
    }
    ?>
        </div>
        </td>
    </tr>
   <tr>
        <td height="35"><div align="right">Kursus</div></td>
        <td height="35"><div align="center">:</div></td>
        <td width="52%" height="35">
        <div align="left" id="divKursus">
            <select id="slct_kursus" name="slct_kursus" style="width:270px;" class="validate[required]" disabled="true">
            <option value="">-- Sila Pilih --</option>
           <!-- <?php           
                foreach ($courses as $row)
                {
            ?>
                    <option value="<?= $row->cou_id ?>">
                        <?= ucwords($row->cou_course_code).'  - '.strcap($row->cou_name) ?>
                    </option>
            <?php 
                } 
            ?> -->
            </select>
        </div>
        </td>
    </tr>
       
     <tr>
    	<td height="35"><div align="right">Status</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
        	<div align="left">
                <select id="statusID" name="status" style="width:270px;">
                	<option value="">Semua</option>
            		<option value="1">Aktif</option>
            		<option value="0">Tidak Aktif</option>
                </select>
            </div>
        </td>
    </tr>
    
    
    <tr>
    	<td></td>
    	<td height="35"><div align="right"></div></td>
        <td height="35">
        	<div align="left">
          		<input class="btn btn-info" type="submit" name="btn_papar" value="Papar Laporan">
        	</div>
        </td>
    </tr>
    <tr>
    	<td colspan="3">&nbsp;</td>
    </tr>
</table>
</form>

</center>
