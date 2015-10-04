
<script language="javascript" type="text/javascript" >
    var kodkv = [
                <?= $centrecode ?>
            ];
</script>

<script src="<?=base_url()?>assets/js/report/kv.attendance.js" type="text/javascript"></script>
<legend><h3>Fail Induk Keputusan</h3></legend>
<center>

<form id="frm_pusat" action="<?= site_url('report/report/print_fik')?>" method="post" target="_blank">
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
        <input type="text" name="kodpusat" id="kodpusat" class="span3 validate[required]" style="margin-left:0px;width:270px;"/>
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
        <td width="45%" height="35"><div align="right">Semester</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35"><div align="left"><select width="50%" style="width:270px;" name="semester" id="semester" class="validate[required]" >
            <option value="">-- Sila Pilih --</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
            <option value="8">8</option>
            </select></td>
          
        </div>
        </td>
    </tr>
        <tr>
        <td height="35"><div align="right">Tahun</div></td>
        <td height="35"><div align="center">:</div></td>
        <td height="35">
            <div align="left">
                <select id="slct_tahun" name="mt_year" class="validate[required]" style="width:270px;" >
                    <option value="">-- Sila Pilih --</option>
                    <?php           
                foreach ($year as $row)
                {
            ?>
                    <option value="<?= $row->mt_year ?>">
                        <?= strtoupper($row->mt_year) ?>
                    </option>
            <?php 
                } 
            ?>
                </select>
            </div>
        </td>
    </tr>
    
   
    <tr>
        <td></td>
        <td height="35"><div align="right"></div></td>
        <td height="35">
            <div align="left">
                <input class="btn btn-info" type="submit" name="btn_papar" value="Papar Fail Induk">
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3">&nbsp;</td>
    </tr>
</table>
</form>

</center>