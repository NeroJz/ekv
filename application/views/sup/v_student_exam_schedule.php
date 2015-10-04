
<?php
   if(!empty($student_details)){
   	$bilc=0;    
	foreach ($student_details as $stu) {
	$bilc++;
   	     if(($bilc%2)==0){
   	     ?>
   	     <span style="page-break-after: always"></span>
   	     <div class="onepage">
 <?php
				}
		 ?>
<div id="header" align="center">
	LEMBAGA PEPERIKSAAN<br />KEMENTERIAN PEPERIKSAAN MALAYSIA<br /><br />KENYATAAN KEMASUKKAN PEPERIKSAAN
</div>
<br /><br />
<div id="user_detail">
	<table width="100%">
		<tr>
			<td>Angka Giliran</td>
			<td>:</td>
			<td colspan="7"><?=$stu->stu_matric_no?></td>
		</tr>
		<tr>
			<td>Nama Pusat/Sekolah</td>
			<td>:</td>
			<td colspan="7"><?=$stu->col_code ." - " . $stu->col_name ?></td>
		</tr>
		<tr>
			<td colspan="9">&nbsp;</td>
		</tr>
		<tr>
			<td>Nama</td>
			<td>:</td>
			<td colspan="7"><?=$stu->stu_name ?></td>
		</tr>
		<tr>
			<td>No. Kad Pengenalan</td>
			<td>:</td>
			<td><?=$stu->stu_mykad ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>Agama : <?=$stu->stu_religion ?></td>
			<td>&nbsp;</td>
			<td>Jantina : <?=$stu->stu_gender ?></td>
		</tr>
		<tr>
			<td>Kursus</td>
			<td>:</td>
			<td><?=$stu->cou_name ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="3">Keturunan : <?=$stu->stu_race ?></td>
		</tr>
		<tr>
			<td>Peperiksaan Dahulu</td>
			<td>:</td>
			<td colspan="7">
				<?php
				$tahun_lahir =  "19" .substr($stu->stu_mykad, 0, 2);
				$umur = date('Y') - $tahun_lahir;
				
				if($umur==17)
				{
					echo "Murid tingkatan 5 dan telah mencapai umur 16 tahun pada 1 Januari tahun peperiksaan SPM";
				}
				else if ($umur<17) {
					echo "Murid belum mencapai umur 16 tahun pada 1 Januari tahun peperiksaan SPM";
				}
				else{
					echo "Murid telah mencapai umur 16 tahun pada 1 Januari tahun peperiksaan SPM";
				}
				?>
				</td>
		</tr>
		<tr>
			<td colspan="9">&nbsp;</td>
		</tr>
		<tr>
			<td>Mata Pelajaran Yang Diambil</td>
			<td>:</td>
			<td colspan="7">
				<table width="100%">
					<tr>
<?php

$subjek_ids = explode(',',$stu->subjek_ids);	
$kod_subjek = explode(',',$stu->kod_subjek);
$masa_mula= explode(',',$stu->masa_mula);
$masa_tamat = explode(',',$stu->masa_tamat);
$tarikh = explode(',',$stu->tarikh);
						$bil = 0;
						foreach ($kod_subjek as $key => $value) {
							$bil++;
							if($bil==5 or $bil==9 or $bil==14 or $bil==18)
							{
								echo "</tr>";
							}
							echo "<td>".$value."</td>";
						}
						?>
						
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td colspan="9">&nbsp;</td>
		</tr>
		<tr>
			<td>Jumlah Mata Pelajaran</td>
			<td>:</td>
			<td colspan="7"><?=$stu->jumlah ?></td>
		</tr>
	</table>
</div>

<div id="note">
	<b>Nota: Mata Pelajaran bertanda (*) adalah Mata Pelajaran Tambahan</b><br /><br />
	**Calon yang mendaftar mata pelajaran Sejarah, sila pastikan anda memperolehi Tema Umum untuk 
	Sejarah Kertas 3 (1249/3) di portal LP http://www.moe.gov.my/lp bermula pada 6 minggu sebelum 
	tarikh permulaan peperiksaan bertulis.<br /><br />
	<b>PERINGATAN : BAWA KENYATAAN KEMASUKAN INI SETIAP KALI MENGHADIRI PEPERIKSAAN</b>
</div>
<br /><br />
<div id="schedule">
	<center><strong>JADUAL WAKTU PEPERIKSAAN BERTULIS SPM 2013</strong></center><br />
	
	<table border="1" width="100%">
		<thead>
			<tr>
				<th>TARIKH</th>
				<th>MASA</th>
				<th>KERTAS</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach ($subjek_ids as $key => $value) {
				?>
			<tr>
				<td><?=date('d-m-Y',$tarikh[$key]) ?></td>
				<td><?=date('g:i',strtotime($masa_mula[$key])) ?>
								<?
								if($masa_mula[$key]<1200)
								{
									echo " pagi";
								}
								else if($masa_mula[$key]<1300)
								{
									echo " tengah hari";
								}
								else if($masa_mula[$key]<1900)
								{
									echo " petang";
								}
								else
								{
									echo " malam";
								}
								?></td>
				<td><?=$value ?></td>
			</tr>
				<?php
			}
			?>
		</tbody>
	</table>
</div>

<?php
				
					}
					  }else{
					  	echo "Tiada Maklumat";
					  }

				 ?>		 
<br /><br />
