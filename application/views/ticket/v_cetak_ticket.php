<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/print_setting.js"></script>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
    <title>Examination Result Slip</title>
    <STYLE TYPE="text/css">
       P.breakhere {page-break-before: always}
       body		{font-size: 8pt;font-family:arial; position:relative; }
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
     .onepage {
         page-break-after: always;
         page-break-inside: avoid;
     }

 </STYLE>
 <style type="text/css" media="print" >
    body {
        height: 842px;
        width: 595px;
        /* to centre page on screen*/
        margin-left: auto;
        margin-right: auto;
    }
    
    #printheight {
       height:150pt;
   }
   
    @page 
{
    size: auto;   /* auto is the current printer page size */
    margin: 0mm;  /* this affects the margin in the printer settings */
}

#BrowserPrintDefaults{display:none} 

#break{page-break-after: always;}
#student{width:100%;}
</STYLE>

</style>

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

</script>
<input id="idPrint"    type="button" onclick="printit(jspOptions)" value="Cetak" name="idPrint">
</head>
<body>
   <?php
   if(!empty($ticket)){
   	$bilc=0;    
       foreach ($ticket as $row) {
           $bilc++;
           if(($bilc%2)==0){
               ?>
               <span style="page-break-after: always"></span>
               <div class="onepage">
                   <?php
               }
               ?>

               <table class="BG" cellpadding="0" cellspacing="0" border="0" style="height:52%; width:450pt; margin-bottom: 20px; margin-top: 15px;">
                  <!-- header part -------------------------------------- -->
                  <tr>
                   <td>
                      <table width="100%" cellpadding=0 cellspacing=0 border=0>
                         <tr>
                           <td colspan=9 align="center" style="height:60pt;">
                            <span class="colheader">LEMBAGA PEPERIKSAAN<br>
                                KEMENTERIAN PENDIDIKAN MALAYSIA</span><br><br>
                                <span class="desc">KENYATAAN KEMASUKAN PENILAIAN AKHIR KOLEJ VOKASIONAL<br>
                                    SEMESTER <?= $row->mt_semester ?> <?= $row->mt_year ?></span><br><br>
                                </td>
                            </tr>
                            <tr>
                               <td width="105" class="descbold" style="width:72pt;">NAMA</td>
                               <td width="20" class="descbold" style="width:15pt;">:</td>
                               <td width="595" colspan="7" class="descbold"><?=
                                strtoupper($row->stu_name)?></td>
                            </tr>
                            <tr>
                               <td class="descbold" style="width:72pt;">NO K/P</td>
                               <td class="descbold" style="width:15pt;">:</td>
                               <td class="descbold" colspan="7"><?=$row->stu_mykad?></td>
                           </tr>     
                           <tr>
                            <td class="descbold" style="width:72pt;">ANGKA GILIRAN</td>
                            <td class="descbold" style="width:15pt;">:</td>
                            <td class="descbold" style="width:148pt;" colspan="7"><?=$row->stu_matric_no?></td>
                        </tr>
                        <tr>
                            <td class="descbold" style="width:72pt;">INSTITUSI</td>
                            <td class="descbold" style="width:15pt;">:</td>
                            <td class="descbold" style="width:148pt;" colspan="7">
                               <?=strtoupper($row->col_name)?>
                           </td>
                       </tr>
                       <tr>
                        <td class="descbold" style="width:72pt;">KLUSTER</td>
                        <td class="descbold" style="width:15pt;">:</td>
                        <td class="descbold" colspan="7"><?=
                            strtoupper($row->cou_cluster)?></td>
                        </tr>
                        <tr>
                            <td class="descbold" style="width:72pt;">KURSUS</td>
                            <td class="descbold" style="width:15pt;">:</td>
                            <td class="descbold" style="width:148pt;" colspan="7"><?=
                                strtoupper($row->cou_name)?></td>
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
                     <table width="100%" cellpadding=0 cellspacing=0 border=0 style="margin-top:-80px;" >                        
                        <tr>                           
                            <td class="colheader" width="10%">KOD</td>
                            <td class="colheader" width="40%">MATA PELAJARAN</td>
                            <td class="colheader" width="7%" align="center">JAM KREDIT</td>
                        </tr><br><br><br><br>
                        <?php
                        $subjek=explode(',',$row->subjek_ids);
                        $kod_subjek=explode(',',$row->kod_subjek);
                        $kredit=explode(',',$row->kredit);
                        $type=explode(',',$row->type);
                        $mod_ids=explode(',',$row->mod_ids);
                        $bill=0;

                        foreach ($subjek as $key=>$rows) {
                            $bill++;
                            $avData = array();

                            if($type[$key]=="AK"){
                            ?>
                              <tr>
                                <td class="desc" align="left"><?= $kod_subjek[$key]?></td>
                                <td class="desc" align="left"><?= strtoupper($rows)?></td>
                                <td class="desc" align="center"><?= $kredit[$key]?></td>
                            </tr>
                            <?php
                            $this->m_result->modul_paper_ak($avData,$aOpt='',$mod_ids[$key]);
                            foreach ($avData as $avrow) {
                                ?>
                                <tr>
                                    <td class="desc" align="left"><?= $avrow->mod_paper?></td>
                                    <td class="desc" align="left"><?= strtoupper($avrow->mod_name)?></td>
                                    <td class="desc" align="center">-</td>
                                </tr>
                                <?php

                            }
                            ?>

                            <?php
                        }else{


                            ?>
                            <tr>

                                <td class="desc" align="left"><?= $kod_subjek[$key]?></td>
                                <td class="desc" align="left"><?= strtoupper($rows)?></td>
                                <td class="desc" align="center"><?= $kredit[$key]?></td>
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

    </table>
</div>
<?php

}
}else{
    echo "Tiada Maklumat";
}
?>		 
</body>

