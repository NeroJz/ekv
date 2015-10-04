<div class="navbar navbar-fixed-top navbar-inverse" data-spy="affix" data-offset-top="50">
	<div class="navbar-inner">
		<div class="container-fluid">
        	<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>
                 <span class="icon-bar"></span>
            </a>
			<div class="nav-collapse nav-custom">
				<ul class="nav">
					<li><a href="<?= site_url() ?>">Menu Utama</a></li>
                    <li class="divider-vertical"></li>
				<?php
				/**********************************************************************************
				 * Menu bar bahagian Admin login : Pelajar => Senarai Pelajar, Import Pelajar
				 * 								: Kolej Vokasional
				 * 								: Peperiksaan => Masukkan Markah, Keputusan, Gred,
				 * 								: Konfigurasi Pentaksiran Pelajar
				 * 								: Laporan => Roster
				 *********************************************************************************/	
				 //$user = $this->ion_auth->user()->row();
				 //print_r($user);
				 if ($this->ion_auth->in_group("Admin LP"))
				 {			
				?>
                	<li class="dropdown">
                		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Murid 
                		<b class="caret"></b></a>
	                      <ul class="dropdown-menu">
	                      	<li><a href="<?= site_url('student/student_management/add') ?>">Daftar Murid</a></li>
	                        <li><a href="<?= site_url('student/student_management') ?>">Senarai Murid</a></li>
	                        <li><a href="<?= site_url('student/student_management/repeatstudent') ?>">Senarai Murid Mengulang</a></li>
	                        <?/*<li><a href="<?= site_url('student/student_management/import_student') ?>">Import Senarai Pelajar</a></li>
	                        <li><a href="<?= site_url('student/student_management/template_angka_giliran') ?>">Template Angka Giliran</a></li>*/?>
	                      </ul>
                    </li>
                    <li class="divider-vertical"></li>
                    <!--CRUD-->
                    <li class="dropdown">
                		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Penyenggaraan
                		<b class="caret"></b></a>
	                      <ul class="dropdown-menu">
	                        <li><a href="<?= site_url('maintenance/crud_course') ?>">Kursus</a></li>
	                        <li><a href="<?= site_url('maintenance/crud_module/index/akademik/aktif') ?>">Modul</a></li><!--KU: Belum siap-->
	                        <li><a href="<?= site_url('maintenance/module_course_reg/get_view_course') ?>">Daftar Modul Kursus</a></li>
	                        <li><a href="<?= site_url('management/college') ?>">Kolej</a></li>
							<li><a href="<?= site_url('management/user') ?>">Pengguna</a></li>
							<?/*<li><a href="<?= site_url('management/user/user_group') ?>">Kumpulan Pengguna</a></li>*/?>
							<li><a href="<?= site_url('maintenance/announcement') ?>">Pengumuman</a></li>
							<li><a href="<?= site_url('maintenance/pengesahan') ?>">Tarikh Tutup Pengesahan</a></li>
							
	                      </ul>
                    </li>
                    <!--END CRUD-->
                    
                    <li class="divider-vertical"></li>
                    <li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Peperiksaan
                      <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        
                        <li><a href="<?= site_url('examination/combine_marks') ?>">Pencantuman Markah</a></li>
                        <li><a href="<?= site_url('examination/combine_repeat') ?>">Pencantuman Markah Mengulang</a></li>
                        <li><a href="<?= site_url("/report/result/attendance_exam") ?>">Jadual Kedatangan Calon Peperiksaan</a></li>
                        <?php /*?><li><a href="<?= site_url('examination/resultv2') ?>">Keputusan</a></li><?php*/ ?>
                        <?php /*?><li><a href="<?= site_url('laporan/result/allgred') ?>">Gred Keseluruhan</a></li><?php*/ ?>
                        <li><a href="<?= site_url('examination/assessment') ?>">Konfigurasi Pentaksiran</a></li>
                        <li><a href="<?= site_url('examination/weightage') ?>">Konfigurasi Wajaran Markah</a></li>
                        <li><a href="<?= site_url('examination/exam_schedule') ?>">Jadual Peperiksaan</a></li>
                        <li><a href="<?= site_url('report/result/calculate_result_student') ?>">Pengiraan Gred</a></li>
                      </ul>
                    </li>
                    <li class="divider-vertical"></li>
                    <li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Laporan
                      <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                      	<li><a href="<?= site_url('report/report/studentkv_course') ?>">Laporan Murid Mengikut Kursus</a></li>
                      	<li><a href="<?=site_url("/report/report/view_fin")?>"> Fail Induk Nama </a></li>                       
                        
                         <li><a href="<?= site_url("sup/student_ticket/") ?>">Kenyataan Kemasukan Penilaian Akhir</a></li>
                        <li><a href="<?=site_url("/report/result/result_student")?>">Slip Keputusan </a></li>
						<li><a href="<?= site_url("report/result/roster") ?>">Roster</a></li>
						<li><a href="<?= site_url('report/report/view_fik_no') ?>">Fail Induk Keputusan</a></li>
						<li><a href="<?= site_url('report/report_v2/view_fik_no') ?>">Fail Induk Keputusan Tambahan</a></li>
						<li><a href="<?= site_url('/report/result/transkrip') ?>">Transkrip</a></li>
						<li><a href="<?= site_url('laporan/assessment_status/view_status_adminlp') ?>">Status Pentaksiran</a></li>						 
						<?php  /*<li><a href="<?= site_url("/report/result/attendance_exam_check") ?>">Cetak Jadual Kedatangan </a></li>
						<li><a href="<?=site_url("/report/result/analysis_results")?>">Analisis Keputusan </a></li>
						<li><a href="<?=site_url("/report/result/analysis_results_vk")?>">Analisis Keputusan Vokasional </a></li>*/ ?>						
                      </ul>
                    </li>
                    </ul>		
				<?php
				} //end Menu Admin

				/**********************************************************************************
				 * Menu bar bahagian Stiausaha login
				 *								: Kolej Vokasional
				 * 								: Pelajar => Senarai Pelajar, Daftar Pelajar Baru
				 * 								: Peperiksaan => Senarai Pemarkahan
				 * 											  => Pembukaan Kemasukan Markah
				 * 											  => Keputusan Peperiksaan
				 *********************************************************************************/
				 if ($this->ion_auth->in_group("KUPP") || $this->ion_auth->in_group("KUPP SEMENTARA"))
				 {		
				 	echo changeHeader(190);		
				?>
					
                    <li class="dropdown">
                		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Modul Pensyarah
                		<b class="caret"></b></a>
	                      <ul class="dropdown-menu">
	                        <li class="dropdown-submenu" >
								<a href="#">Pembahagian Modul Pensyarah</a>
								<ul class="dropdown-menu">
									<li><a href="<?= site_url('lecturer/assignsubject') ?>">Modul Biasa</a></li>
									<li><a href="<?= site_url('lecturer/assignsubject/assign_subj_repeat') ?>">Modul Mengulang</a></li>
						    			
						    		<?php /*<li><a href="<?= site_url('student/student_management/display_transfer_student') ?>">Terima Murid<span class="pull-right badge badge-important"><?php if(pindah_noti()==true){echo pindah_noti();}?></span></a></li> */?>
	                      		</ul></li>
	                      	<li><a href="<?= site_url('lecturer/assignsubject/subject_lecturer') ?>">Paparan Pensyarah</a></li>
	                      </ul>
                   
                    </li>
                    <li class="divider-vertical"></li>                	
                    <li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Peperiksaan
                      <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                      	<li><a href="<?= site_url('/student/repeat_subject/repeat_subject_view') ?>">Daftar Mengulang</a></li>
                      	<!--  <li><a href="<?= site_url('examination/repeatmark') ?>">Kemasukan Markah Mengulang</a></li>-->
                      	<li><a href="<?= site_url('sup/student_ticket/') ?>">Kenyataan Kemasukan Penilaian Akhir</a></li>
                      	<li><a href="<?= site_url("/report/attendance/attendance_system") ?>">Jadual Kedatangan Calon Peperiksaan</a></li>
                      	<li><a href="<?= site_url('examination/exam_schedule/print_exam') ?>">Cetak Jadual Peperiksaan</a></li>
                      </ul>
                    </li>
                    <li class="divider-vertical"></li>
                    <li class="dropdown">
                		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Laporan
                		<b class="caret"></b></a>
	                      <ul class="dropdown-menu">
	                      	<li><a href="<?= site_url("form/confirmation/student_information") ?>">Pengesahan Pendaftaran</a></li>
	                      	<li><a href="<?= site_url('report/report/studentkv_course') ?>">Laporan Murid Mengikut Kursus</a></li>
	                      	<li><a href="<?=site_url("/report/report/view_fin")?>"> Fail Induk Nama </a></li>
	                      	
	                      	<li><a href="<?=site_url("/report/result/result_student")?>">Slip Keputusan </a></li>
	                      	<li><a href="<?= site_url("report/result/roster") ?>">Roster</a></li>
	                      	<li><a href="<?= site_url('/report/result/transkrip') ?>">Transkrip</a></li>
	                        <?php /*<li><a href="<?= site_url('sup/lecturer') ?>">Status Pentaksiran Pensyarah</a></li>*/ ?>
	                        <li><a href="<?= site_url('laporan/assessment_status/view_status') ?>">Status Pentaksiran Pensyarah</a></li>						
						</ul>
                    </li>
                    <li class="divider-vertical"></li>
                    <li class="dropdown">
                		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Penyenggaraan<span class="pull-right badge badge-important" style="margin-left: 7px;"><?php if(pindah_noti()==true){echo "Baru";}?></span>
                		<b class="caret"></b></a>
	                      <ul class="dropdown-menu">
	                      	<li><a href="<?= site_url('maintenance/course_module/get_view_course') ?>">Kursus</a></li>
	                      	<li><a href="<?= site_url('management/user') ?>">Pengguna</a></li>
	                      	<li class="dropdown-submenu" >
								<a href="#">Kelas</a>
								<ul class="dropdown-menu">
									<li><a href="<?= site_url('class/divide_student/manage_class') ?>">Pengurusan Kelas</a></li>
									<li><a href="<?= site_url('class/divide_student/groupbycourse') ?>">Pembahagian Murid Mengikut Kelas</a></li>
									<li><a href="<?= site_url('class/divide_student/changeClassView') ?>">Penetapan dan Penukaran Kelas Murid</a></li>	
										
	                      		</ul>
	                      	</li>		
							<?php /* <li><a href="<?= site_url('kv/management/college_course_management') ?>">Kursus Kolej</a></li> */ // buang comment kalau enable balik ?>
					<li class="dropdown-submenu" >
								<a href="#">Murid</a>
								<ul class="dropdown-menu">
									<li><a href="<?= site_url('student/student_management/add') ?>">Daftar Murid</a></li>
									<li><a href="<?= site_url('student/student_management/') ?>">Senarai Murid</a></li>
						    		<li><a href="<?= site_url('student/student_management/pindah') ?>">Pindah Murid</a></li>
						    		<li><a href="<?= site_url('student/student_management/pergerakkan') ?>">Pergerakan Murid<span class="pull-right badge badge-important"><?php if(pindah_noti()==true){echo pindah_noti();}?></span></a></li>
						    		<li><a href="<?= site_url('maintenance/module_taken_reg') ?>">Pendaftaran Modul Murid</a></li>	
						    		<?php /*<li><a href="<?= site_url('student/student_management/display_transfer_student') ?>">Terima Murid<span class="pull-right badge badge-important"><?php if(pindah_noti()==true){echo pindah_noti();}?></span></a></li> */?>
	                      		</ul>
	                      	<li><a href="<?= site_url('maintenance/announcement') ?>">Pengumuman</a></li>
	                      	<li class="dropdown-submenu" >
								<a href="#">Maklumat Kolej</a>
								<ul class="dropdown-menu">
									<li><a href="<?= site_url('management/college/display_update_kolej') ?>">Info Kolej</a></li>
									<li><a href="<?= site_url('management/college/view_upload_image') ?>">Muat Naik Gambar</a></li>
										
										
	                      		</ul>
	                      	</li>
	                      </ul>
                    </li>
                    
				</ul>
				<?php
				}//end Menu KUPP

				/**********************************************************************************
				 * Menu bar bahagian Pensyarah login : Peperiksaan 
				 * 										=> Senarai Pemarkahan
				 * 										=> Kemasukan Markah Peperiksaan Sekolah
				 * 										=> Kemasukan Markah Peperiksaan Pusat
				 *********************************************************************************/
				 if ($this->ion_auth->in_group("Pensyarah"))
				 {	
				 	echo changeHeader(55);	
				?>
				
					<li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Pentaksiran
                      <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <?php /*<li><a href="<?= site_url('examination/markings') ?>">Kemasukan Markah Pentaksiran Berterusan Akademik</a></li> */?>
                        <li><a href="<?= site_url('examination/markings_v3') ?>">Kemasukan Markah Pentaksiran Berterusan</a></li>
                        <?php /*<li><a href="<?= site_url('examination/markings_v2') ?>">Kemasukan Markah Pentaksiran Berterusan</a></li>*/ ?>
                        <li><a href="<?= site_url('examination/marking') ?>">Kemasukan Markah Pentaksiran Akhir</a></li>
                        <li><a href="<?= site_url('examination/repeatmark') ?>">Kemasukan Markah Pentaksiran Mengulang</a></li>
                        <li><a href="<?= site_url('examination/writtenform') ?>">Borang Pengisian Markah Bertulis (K15)</a></li>
                      </ul>
                    </li>
				</ul>				
				<?php } //end Menu Pensyarah
				
				/**********************************************************************************
				 * Menu bar bahagian Pemeriksa login : Pemeriksa
				* 										=> Modul untuk Di semak
				*
				*********************************************************************************/
				//if ($this->ion_auth->in_group("Pemeriksa"))
				//{
					?>
								
									<!--  <li class="dropdown">
				                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Pemeriksa
				                      <b class="caret"></b></a>
				                      <ul class="dropdown-menu">
				                      	<li><a href="<?= site_url('examiner/modul_examiner/check_modul') ?>">Modul untuk Di Semak</a></li>
				                      </ul>
				                    </li>
								</ul>				
								<ul class="nav pull-right">
									<li class="divider-vertical"></li>
									<li><a href="<?= site_url('management/userinfo/userdetail') ?>" data-container="body" id="menuAkaun" data-placement="bottom" data-toggle="tooltip" title="Akaun Pengguna"><i class="icon-user icon-white"></i></a></li>
				                    <li><a href="<?= site_url('auth/logout') ?>" id="menuLogout" data-placement="bottom" data-toggle="tooltip" title="Log Keluar"><i class="icon-off icon-white"></i></a></li>
				                </ul>
				                </li>-->
								
								<?php
// } //end Menu Pemeriksa
				
				/**********************************************************************************
				 * Menu bar bahagian JPN login : Penyelenggaraan 
				 * 										=> Pengguna
				 * 										=> Kolej
				 *********************************************************************************/
				 if ($this->ion_auth->in_group("JPN"))
				 {
				 	
				 	echo changeHeader(70);
				 	
				 	?>
				 	<li class="dropdown">
                		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Penyelenggaraan
                		<b class="caret"></b></a>
	                      <ul class="dropdown-menu">
							<li><a href="<?= site_url('management/user') ?>">Pengguna</a></li>
							<li><a href="<?= site_url('management/college') ?>">Kolej</a></li>
							
	                      </ul>
                    </li>
                   <li class="divider-vertical"></li>
                    <li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Laporan
                      <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <li><a href="<?= site_url("sup/student_ticket/") ?>">Slip Peperiksaan</a></li>
						<li><a href="<?= site_url("/report/result/attendance_exam") ?>">Jadual Kedatangan</a></li>
						<li><a href="<?=site_url("/report/result/result_student")?>">Slip Keputusan </a></li>
						<li><a href="<?=site_url("/report/report/view_fin")?>"> Fail Induk Nama </a></li>
						<li><a href="<?= site_url('report/report/studentkv_course') ?>">Laporan Murid Mengikut Kursus</a></li>
                      </ul>
                    </li> 
				</ul>
				 	<?php
				 }// end Menu JPN
				 
				 /**********************************************************************************
				 * Menu bar bahagian BPTV login : Penyelenggaraan
				 *	 									=> Pengguna 
				 * 										=> Kolej
				 *********************************************************************************/
				
				 if ($this->ion_auth->in_group("BPTV"))
				 {
				 	echo changeHeader(90);
				 	?>
				 	<li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Murid 
                        <b class="caret"></b></a>
                          <ul class="dropdown-menu">
                            <li><a href="<?= site_url('student/student_management/add') ?>">Daftar Murid</a></li>
                            <li><a href="<?= site_url('student/student_management') ?>">Senarai Murid</a></li>
                            <li><a href="<?= site_url('student/student_management/repeatstudent') ?>">Senarai Murid Mengulang</a></li>
                            <?/*<li><a href="<?= site_url('student/student_management/import_student') ?>">Import Senarai Pelajar</a></li>
                            <li><a href="<?= site_url('student/student_management/template_angka_giliran') ?>">Template Angka Giliran</a></li>*/?>
                          </ul>
                    </li>
                    <li class="divider-vertical"></li>
                    <!--CRUD-->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">Penyenggaraan
                        <b class="caret"></b></a>
                          <ul class="dropdown-menu">
                            <li><a href="<?= site_url('maintenance/crud_course') ?>">Kursus</a></li>
                            <li><a href="<?= site_url('maintenance/crud_module/index/akademik/aktif') ?>">Modul</a></li><!--KU: Belum siap-->
                            <li><a href="<?= site_url('maintenance/module_course_reg/get_view_course') ?>">Daftar Modul Kursus</a></li>
                            <li><a href="<?= site_url('management/college') ?>">Kolej</a></li>
                            <li><a href="<?= site_url('management/user') ?>">Pengguna</a></li>
                            <?/*<li><a href="<?= site_url('management/user/user_group') ?>">Kumpulan Pengguna</a></li>*/?>
                            <li><a href="<?= site_url('maintenance/announcement') ?>">Pengumuman</a></li>
                            <li><a href="<?= site_url('maintenance/pengesahan') ?>">Tarikh Tutup Pengesahan</a></li>
                           <?php //<li><a href="<?= site_url('import_excellKv/importExcell') ">Integrasi Data</a></li> ?>
                          </ul>
                    </li>
                    <!--END CRUD-->
                    
                    
                    <li class="divider-vertical"></li>
                    <li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Laporan
                      <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                        <li><a href="<?= site_url('report/report/studentkv_course') ?>">Laporan Murid Mengikut Kursus</a></li>
                        <li><a href="<?=site_url("/report/report/view_fin")?>"> Fail Induk Nama </a></li>                       
                        <li><a href="<?= site_url("/report/result/attendance_exam") ?>">Jadual Kedatangan Calon </a></li>
                         <li><a href="<?= site_url("sup/student_ticket/") ?>">Kenyataan Kemasukan Penilaian Akhir</a></li>
                        <li><a href="<?=site_url("/report/result/result_student")?>">Slip Keputusan </a></li>
                        <li><a href="<?= site_url("report/result/roster") ?>">Roster</a></li>
                        <li><a href="<?= site_url('report/report/view_fik_no') ?>">Fail Induk Keputusan</a></li>
                        <li><a href="<?= site_url('/report/result/transkrip') ?>">Transkrip</a></li>                         
                        <?php /*<li><a href="<?= site_url("/report/result/attendance_exam_check") ?>">Cetak Jadual Kedatangan </a></li>
                        <li><a href="<?=site_url("/report/result/analysis_results")?>">Analisis Keputusan </a></li>
                        <li><a href="<?=site_url("/report/result/analysis_results_vk")?>">Analisis Keputusan Vokasional </a></li>*/ ?>                      
                      </ul>
                    </li>
                    </ul>
				 	<?php
				 }// end Menu BPTv
				 
				 /**********************************************************************************
				 * Menu bar bahagian Pengarah login : Penyelenggaraan 
				 * 										=> Kolej
				 *********************************************************************************/
				 if ($this->ion_auth->in_group("Pengarah"))
				 {
				 	echo changeHeader(160);

				 	?>
				   <li class="dropdown">
                		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Penyelenggaraan
                		<b class="caret"></b></a>
	                      <ul class="dropdown-menu">
							<li><a href="<?= site_url('management/user') ?>">Pengguna</a></li>
	                      </ul>
                    </li>
				</ul>
				 	<?php
				 }// end Menu Pengarah	

				 /**********************************************************************************
				 * Menu bar bahagian KJPP login : Penyelenggaraan 
				 * 										=> Kolej
				 *********************************************************************************/
				 if ($this->ion_auth->in_group("KJPP"))
				 {
				 	echo changeHeader(110);
				
				/*</ul>
				<ul class="nav pull-right">
					<li class="divider-vertical"></li>
					<li><a href="<?= site_url('management/userinfo/userdetail') ?>" data-container="body" id="menuAkaun" data-placement="bottom" data-toggle="tooltip" title="Akaun Pengguna"><i class="icon-user icon-white"></i></a></li>
                    <li><a href="<?= site_url('auth/logout') ?>" id="menuLogout" data-placement="bottom" data-toggle="tooltip" title="Log Keluar"><i class="icon-off icon-white"></i></a></li>
                </ul>
                </li>*/
				?>
				 <li class="dropdown">
                		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Modul Pensyarah
                		<b class="caret"></b></a>
	                      <ul class="dropdown-menu">
	                        <li class="dropdown-submenu" >
								<a href="#">Pembahagian Modul Pensyarah</a>
								<ul class="dropdown-menu">
									<li><a href="<?= site_url('lecturer/assignsubject') ?>">Modul Biasa</a></li>
									<li><a href="<?= site_url('lecturer/assignsubject/assign_subj_repeat') ?>">Modul Mengulang</a></li>
						    			
						    		<?php /*<li><a href="<?= site_url('student/student_management/display_transfer_student') ?>">Terima Murid<span class="pull-right badge badge-important"><?php if(pindah_noti()==true){echo pindah_noti();}?></span></a></li> */?>
	                      		</ul></li>
	                      	<li><a href="<?= site_url('lecturer/assignsubject/subject_lecturer') ?>">Paparan Pensyarah</a></li>
	                      </ul>
                   
                    </li>
                    <li class="divider-vertical"></li>                	
                    <li class="dropdown">
                      <a class="dropdown-toggle" data-toggle="dropdown" href="#">Peperiksaan
                      <b class="caret"></b></a>
                      <ul class="dropdown-menu">
                      	<li><a href="<?= site_url('/student/repeat_subject/repeat_subject_view') ?>">Daftar Mengulang</a></li>
                      	<li><a href="<?= site_url('examination/repeatmark') ?>">Kemasukan Markah Mengulang</a></li>
                      	<li><a href="<?= site_url('sup/student_ticket/') ?>">Kenyataan Kemasukan Penilaian Akhir</a></li>
                      	<li><a href="<?= site_url('examination/exam_schedule/print_exam') ?>">Cetak Jadual Peperiksaan</a></li>
                      </ul>
                    </li>
                    <li class="divider-vertical"></li>
                    <li class="dropdown">
                		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Laporan
                		<b class="caret"></b></a>
	                      <ul class="dropdown-menu">
	                      	<li><a href="<?= site_url("form/confirmation/student_information") ?>">Pengesahan Pendaftaran</a></li>
	                      	<li><a href="<?= site_url('report/report/studentkv_course') ?>">Laporan Murid Mengikut Kursus</a></li>
	                      	<li><a href="<?=site_url("/report/report/view_fin")?>"> Fail Induk Nama </a></li>
	                      	<li><a href="<?= site_url("/report/attendance/attendance_system") ?>">Jadual Kedatangan Calon</a></li>
	                      	<li><a href="<?=site_url("/report/result/result_student")?>">Slip Keputusan </a></li>
	                      	<li><a href="<?= site_url("report/result/roster") ?>">Roster</a></li>
	                      	<li><a href="<?= site_url('/report/result/transkrip') ?>">Transkrip</a></li>
	                        <?php /*<li><a href="<?= site_url('sup/lecturer') ?>">Status Pentaksiran Pensyarah</a></li>*/ ?>
	                        <li><a href="<?= site_url('laporan/assessment_status/view_status') ?>">Status Pentaksiran Pensyarah</a></li>						
						</ul>
                    </li>
                    <li class="divider-vertical"></li>
                    <li class="dropdown">
                		<a class="dropdown-toggle" data-toggle="dropdown" href="#">Penyenggaraan<span class="pull-right badge badge-important" style="margin-left: 7px;"><?php if(pindah_noti()==true){echo "Baru";}?></span>
                		<b class="caret"></b></a>
	                      <ul class="dropdown-menu">
	                      	<li><a href="<?= site_url('maintenance/course_module/get_view_course') ?>">Kursus</a></li>
	                      	<li><a href="<?= site_url('management/user') ?>">Pengguna</a></li>
	                      	<li class="dropdown-submenu" >
								<a href="#">Kelas</a>
								<ul class="dropdown-menu">
									<li><a href="<?= site_url('class/divide_student/manage_class') ?>">Pengurusan Kelas</a></li>
									<li><a href="<?= site_url('class/divide_student/groupbycourse') ?>">Pembahagian Murid Mengikut Kelas</a></li>
									<li><a href="<?= site_url('class/divide_student/changeClassView') ?>">Penetapan dan Penukaran Kelas Murid</a></li>		
	                      		</ul>
	                      	</li>		
							<?php /* <li><a href="<?= site_url('kv/management/college_course_management') ?>">Kursus Kolej</a></li> */ // buang comment kalau enable balik ?>
					<li class="dropdown-submenu" >
								<a href="#">Murid</a>
								<ul class="dropdown-menu">
									<li><a href="<?= site_url('student/student_management/add') ?>">Daftar Murid</a></li>
									<li><a href="<?= site_url('student/student_management/') ?>">Senarai Murid</a></li>
						    		<li><a href="<?= site_url('student/student_management/pindah') ?>">Pindah Murid</a></li>
						    		<li><a href="<?= site_url('student/student_management/pergerakkan') ?>">Pergerakan Murid<span class="pull-right badge badge-important"><?php if(pindah_noti()==true){echo pindah_noti();}?></span></a></li>
						    		<li><a href="<?= site_url('maintenance/module_taken_reg') ?>">Pendaftaran Modul Murid</a></li>	
						    		<?php /*<li><a href="<?= site_url('student/student_management/display_transfer_student') ?>">Terima Murid<span class="pull-right badge badge-important"><?php if(pindah_noti()==true){echo pindah_noti();}?></span></a></li> */?>
	                      		</ul>
	                      	<li><a href="<?= site_url('maintenance/announcement') ?>">Pengumuman</a></li>
	                      </ul>
                    </li>
                    
				</ul>
				<?php
				}
				 ?>
				 <ul class="nav pull-right">
					<li class="divider-vertical"></li>
					<li><a href="javascript:void(0);" data-container="body"  data-placement="bottom" id="onlineStatus" data-toggle="tooltip" title="Sistem Online"><i id="offline_globe" class="icon-globe icon-red"><div id="image_mask"></div></i></a></li>
					<li><a href="<?= site_url('management/userinfo/userdetail') ?>" data-container="body" id="menuAkaun" data-placement="bottom" data-toggle="tooltip" title="Akaun Pengguna"><i class="icon-user icon-white"></i></a></li>
                    <li><a href="<?= site_url('auth/logout') ?>" id="menuLogout" data-placement="bottom" data-toggle="tooltip" title="Log Keluar"><i class="icon-off icon-white"></i></a></li>
                </ul>
                </li>
                <style>
					#offline_globe{
						width:14px;height:14px;
					}
					
					#offline_globe #image_mask{
						background-color:green;width:14px;height:14px;opacity:0.6;filter:alpha(opacity=40); /* For IE8 and earlier */
						-webkit-border-radius: 99em;
					  	-moz-border-radius: 99em;
					  	border-radius: 99em;
						box-shadow: 0 3px 2px rgba(0, 0, 0, 0.3);
					}

					</style>
                <script>
                $(".icon-user").hover(
			       function () {
			         $(this).removeClass('icon-white');
			       }, 
			      function () {
			          $(this).toggleClass('icon-white');
			       }
			     );
                </script>
                
				<script>
                $(".icon-off").hover(
			       function () {
			         $(this).removeClass('icon-white');
			       }, 
			      function () {
			          $(this).toggleClass('icon-white');
			       }
			     );
                </script>

				</ul>
             </div>
         </div>
     </div>				
</div>
<!--End Pop-Up Modal-->
