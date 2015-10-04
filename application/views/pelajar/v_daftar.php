<?php 
$msg = $this->session->flashdata('msg');
if(!empty($msg))
{
	list($class, $mesej) = explode("%",$msg);
	if(empty($class))
		$class = 'success';
	echo '<div class="alert alert-'.$class.'">
              <button type="button" class="close" data-dismiss="alert">×</button>
              '.$mesej.'
            </div>';
}
?>

<form name="formPelajar" id="formPelajar" action="<?=site_url("pelajar/urus/proses_daftar")?>" method="post">
<table class="table table-bordered table-condensed" style="background-color:#ffffff;" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr style="background-color: whitesmoke; ">
                            <td colspan="2"> <strong id="menutitle"> <i class="icon-user"></i> Maklumat Pelajar</strong></td>
                        </tr>
                        <tr>
                            <td style="min-width:15%;" width="15%"><strong>Nombor Kad Pengenalan<span class="style8"></span></strong></td>
                            <td width="85%">
		               			<span class="cth">
                                  <input name="no_kp" id="txt_no_kp" value="" class="span2 validate[required]" type="text">
                               	</span>
		                  		<i style="color: silver; padding-left:5px;"> e.g : 851111015121 </i>
			    			</td>
                       </tr>
                       <tr>
                            <td style="min-width:15%;" width="15%"><strong>Nama Pelajar<span class="style8"></span></strong></td>
                            <td width="85%">
	               			  <span class="cth">
                                  <input name="nama_pelajar" id="nama_pelajar" value="" class="span3" type="text">
                           	  </span><i style="color: silver; padding-left:5px;">e.g : Ozil </i></td>
                       </tr>
                       <tr>
                            <td style="min-width:15%;"><strong>Jantina</strong></td>
                         <td>
		               	 	<select style="width:170px;" name="jantina" id="jantina">
			        		<option value=""> ---------- Pilih ---------- </option>
                            <option value="Lelaki">Lelaki</option>
                            <option value="Perempuan">Perempuan</option>
		            		</select>
                         </td>
                       </tr>
                        <tr>
                            <td><strong>Kaum<span class="style8"></span></strong></td>
                            <td>
							<select style="width:170px;" name="kaum" id="kaum">
			        		<option value=""> ---------- Pilih ---------- </option>
                            <option value="Melayu/Bumiputra">Melayu/Bumiputra</option>
                            <option value="Cina">Cina</option>
                            <option value="India">India</option>
                            <option value="Lain-Lain">Lain-Lain</option>
		            		</select>			    
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Agama<span class="style8"></span></strong></td>
                            <td>
		              		<select style="width:170px;" name="agama" id="agama">
			        		<option value=""> ---------- Pilih ---------- </option>
                            <option value="Islam">Islam</option>
                            <option value="Bukan Islam">Bukan Islam</option>
		            		</select>		
			    </td>
                        </tr>
                     
                    </tbody>
                </table>
  
  
  <table class="table table-bordered table-condensed" style="background-color:#ffffff;" width="100%" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr style="background-color: whitesmoke; ">
                            <td colspan="2"> <strong id="menutitle"> <i class="icon-envelope"></i> Maklumat Akademik</strong></td>
                        </tr>
                        <tr>
                            <td style="min-width:15%;" width="15%"><strong>Nombor Giliran<span class="style8"></span></strong></td>
                            <td width="85%"><span class="cth">
                              <input name="angka_giliran" value="" id="angka_giliran" class="validate[required] span2" type="text">
					<i style="color: silver; padding-left:5px;"> e.g : 10QIP10F1058 </i>
                            </span></td>
                        </tr>
		        <tr>
                            <td><strong>Kursus<span class="style8"></span></strong></td>
                            <td><select id="kursus" name="kursus" style="width:270px;" class="validate[required]">
                                <option value="">-- Sila Pilih --</option>
                                <?php			
                                    foreach ($kursus as $row)
                                    {
                                ?>
                                        <option value="<?= $row->kursus_id ?>">
                                            <?= strtoupper($row->kod_kursus.'  - '.$row->kursus_kluster ) ?>
                                        </option>
                                <?php 
                                    } 
                                ?>
                                </select>
                            </td>
                        </tr>                     
                    </tbody>
                </table>
  <div class="form-actions">
      <div class="pull-right">
                <button class="btn btn-primary" type="submit"><i class="icon-ok icon-white"></i>&nbsp;Simpan</button>
                <button class="btn"><i class="icon-remove"></i>&nbsp;Batal</button>
    </div>
  </div>
                
</form>