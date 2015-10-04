<?php
$user_login = $this->ion_auth->user()->row();
$colid = $user_login->col_id;
$userId = $user_login->user_id;
$state_id= $user_login->state_id;

$user_groups = $this->ion_auth->get_users_groups($userId)->row();  
$ul_name= $user_groups->ul_name;
$ul_id= $user_groups->id;


$user['Admin LP']=array(
  'Colour'=>0,
  'Main Menu'=>site_url(),
  'Murid'=>array(
      'Daftar Murid'=>site_url('student/student_management/add'),
      'Senarai Murid'=>site_url('student/student_management'),
      'Senarai Murid Mengulang'=>site_url('student/student_management/repeatstudent')
    ),
  'Penyelenggaraan'=>array(
      'Kursus'=>site_url('maintenance/crud_course'),
      'Modul'=>site_url('maintenance/crud_module/index/akademik/aktif'),
      'Daftar Modul Kursus'=>site_url('maintenance/module_course_reg/get_view_course'),
      'Kolej'=>site_url('management/college'),
      'Pengguna'=>site_url('management/user'),
      'Pengumuman'=>site_url('maintenance/announcement'),
      'Tarikh Tutup Pengesahan'=>site_url('maintenance/pengesahan')
    ),
  'Peperiksaan'=>array(
      'Pencantuman Markah'=>site_url('examination/combine_marks'),
      'Pencantuman Markah Mengulang'=>site_url('examination/combine_repeat'),
      'Jadual Kedatangan Calon Peperiksaan'=>site_url("/report/result/attendance_exam"),
      'Konfigurasi Pentaksiran'=>site_url('examination/assessment'),
      'Konfigurasi Wajaran Markah'=>site_url('examination/weightage'),
      'Jadual Peperiksaan'=>site_url('examination/exam_schedule'),
      'Pengiraan Gred'=>site_url('report/result/calculate_result_student')
    ),
  'Laporan'=>array(
      'Laporan Murid Mngikut Kursus'=>site_url('report/report/studentkv_course'),
      'Fail Induk Nama'=>site_url("/report/report/view_fin"),
      'Kenyataan Kemasukan Penilaian Akhir'=>site_url("sup/student_ticket/"),
      'Slip Keputusan'=>site_url("/report/result/result_student"),
      'Roster'=>site_url("report/result/roster"),
      'Fail Induk Keputusan'=>site_url('report/report/view_fik_no'),
      'Fail Induk Keputusan Tambahan'=>site_url('report/report_v2/view_fik_no'),
      'Transkrip'=>site_url('/report/result/transkrip'),
      'Status Pentaksiran'=>site_url('laporan/assessment_status/view_status_adminlp')
    )
  );

$user['KUPP']=array(
  'Colour'=>190,
  'Main Menu'=>site_url(),
  'Modul Pensyarah'=>array(
      'Pembahagian Modul Pensyarah'=>array(
          'Modul Biasa'=>site_url('lecturer/assignsubject'),
          'Modul Mengulang'=>site_url('lecturer/assignsubject/assign_subj_repeat')
        ),
      'Paparan Pensyarah'=>site_url('student/student_management'),
    ),
  'Penyelenggaraan'=>array(
      'Kursus'=>site_url('maintenance/crud_course'),
      'Modul'=>site_url('maintenance/crud_module/index/akademik/aktif'),
      'Daftar Modul Kursus'=>site_url('maintenance/module_course_reg/get_view_course'),
      'Kolej'=>site_url('management/college'),
      'Pengguna'=>site_url('management/user'),
      'Pengumuman'=>site_url('maintenance/announcement'),
      'Tarikh Tutup Pengesahan'=>site_url('maintenance/pengesahan')
    ),
  'Peperiksaan'=>array(
      'Pencantuman Markah'=>site_url('examination/combine_marks'),
      'Pencantuman Markah Mengulang'=>site_url('examination/combine_repeat'),
      'Jadual Kedatangan Calon Peperiksaan'=>site_url("/report/result/attendance_exam"),
      'Konfigurasi Pentaksiran'=>site_url('examination/assessment'),
      'Konfigurasi Wajaran Markah'=>site_url('examination/weightage'),
      'Jadual Peperiksaan'=>site_url('examination/exam_schedule'),
      'Pengiraan Gred'=>site_url('report/result/calculate_result_student')
    ),
  'Laporan'=>array(
      'Laporan Murid Mngikut Kursus'=>site_url('report/report/studentkv_course'),
      'Fail Induk Nama'=>site_url("/report/report/view_fin"),
      'Kenyataan Kemasukan Penilaian Akhir'=>site_url("sup/student_ticket/"),
      'Slip Keputusan'=>site_url("/report/result/result_student"),
      'Roster'=>site_url("report/result/roster"),
      'Fail Induk Keputusan'=>site_url('report/report/view_fik_no'),
      'Fail Induk Keputusan Tambahan'=>site_url('report/report_v2/view_fik_no'),
      'Transkrip'=>site_url('/report/result/transkrip'),
      'Status Pentaksiran'=>site_url('laporan/assessment_status/view_status_adminlp')
    ),
  'Maklumat Kolej'=>array(
      'Info Kolej'=>site_url('management/college/display_update_kolej'),
      'Muat Naik Gambar'=>site_url('management/college/view_upload_image')
    )
  );

$user['KJPP']=array(
  'Colour'=>110,
  'Main Menu'=>site_url(),
  'Modul Pensyarah'=>array(
      'Pembahagian Modul Pensyarah'=>array(
        'Modul Biasa'=>site_url('lecturer/assignsubject'),
        'Modul Mengulang'=>site_url('lecturer/assignsubject/assign_subj_repeat')
        ),
      'Paparan Pensyarah'=>site_url('student/student_management')
    ),
  'Peperiksaan'=>array(
      'Daftar Mengulang'=>site_url('student/repeat_subject/repeat_subject_view'),
      'Kemasukan Markah Mengulang'=>site_url('examination/repeatmark'),
      'Kenyataan Kemasukan Penilaian Akhir'=>site_url('sup/student_ticket'),
      'Cetak Jadual Peperiksaan'=>site_url('examination/exam_schedule/print_exam')
    ),
  'Laporan'=>array(
      'Pengesahan Pendaftaran'=>site_url('form/confirmation/student_information'),
      'Laporan Murid Mengikut Kelas'=>site_url('report/report/studentkv_course'),
      'Fail Induk Nama'=>site_url('report/report/view_fin'),
      'Jadual Kedatangan Calon'=>site_url('report/attendance/attendance_system'),
      'Slip Keputusan'=>site_url('report/result/result_student'),
      'Roster'=>site_url('report/result/roster'),
      'Transkrip'=>site_url('report/result/transkrip'),
      'Status Pentaksiran Pensyarah'=>site_url('laporan/assessment_status/view_status'),
    ),
  'Penyelenggaraan'=>array(
      'Kursus'=>site_url('maintenance/course_module/get_view_course'),
      'Pengguna'=>site_url('management/user'),
      'Kelas'=>array(
          'Pengurusan Kelas'=>'class/divide_student/manage_class',
          'Pembahagian Murid Mengikut Kelas'=>'class/divide_student/groupbycourse',
          'Penetapan dan Penukaran Kelas Murid'=>'class/divide_student/changeClassView',
        ),
      'Murid'=>array(
          'Daftar Murid'=>'student/student_management/add',
          'Senarai Murid'=>'student/student_management',
          'Pindah Murid'=>'student/student_management/pindah',
          'Pergerakkan Murid'=>'student/student_management/pergerakkan',
          'Pendaftaran Modul Murid'=>'maintenance/module_taken_reg',
        ),
      'Pengumuman'=>site_url('maintenance/announcement'),
    ),
  'Maklumat Kolej'=>array(
      'Info Kolej'=>site_url('management/college/display_update_kolej'),
      'Muat Naik Gambar'=>site_url('management/college/view_upload_image')
    )
  );

$user['Pensyarah']=array(
  'Colour'=>55,
  'Main Menu'=>site_url(),
  'Pentaksiran'=>array(
      'Kemasukan Markah Pentaksiran Berterusan'=>site_url('examination/markings_v3'),
      'Kemasukan Markah Pentaksiran Akhir'=>site_url('examination/marking'),
      'Kemasukan Markah Pentaksiran Mengulang'=>site_url('examination/repeatmark'),
      'Borang Pengisian Markah Bertulis'=>site_url('examination/writtenform'),
    ),
  );
?>

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
          <?php
          foreach ($menu as $key => $value) {
            if(is_object($value) && !empty($value->children)){
              echo "<li class='dropdown'>";
                echo "<a class='dropdown-toggle' data-toggle='dropdown' href='#'>$value->menu_item <b class='caret'></b></a>";
                echo "<ul class='dropdown-menu'>";
                foreach ($value->children as $item => $link) {
                  if(is_object($link) && !empty($link->children)){
                    echo "<li class='dropdown-submenu'>";
                      echo "<a tabindex='-1' href=''>$link->menu_item</a>";
                      echo "<ul class='dropdown-menu'>";
                      foreach ($link->children as $sub => $subchildren) {
                        echo "<li><a href='".site_url().$subchildren->menu_path."'>$subchildren->menu_item</a></li>";
                      }
                      echo "</ul>";
                  }else{
                    echo "<li><a href='".site_url().$link->menu_path."'>$link->menu_item</a></li>";
                  }
                  echo "</li>";
                }
                echo "</ul>";
              echo "</li>";
            }else{
              // print_r($menu[$ul_id]);
              // echo "<pre>";
              // print_r($value);
              // echo "</pre>";
              echo "<li><a href='".site_url().$value->menu_path."'>$value->menu_item</a></li>";
            }
          echo "<li class='divider-vertical'></li>";
          } ?>
        </ul>
        <ul class="nav pull-right">
          <li class="divider-vertical"></li>
          <li><a href="javascript:void(0);" data-container="body"  data-placement="bottom" id="onlineStatus" data-toggle="tooltip" title="Sistem Online"><i id="offline_globe" class="icon-globe icon-red"><div id="image_mask"></div></i></a></li>
          <li><a href="<?= site_url('management/userinfo/userdetail') ?>" data-container="body" id="menuAkaun" data-placement="bottom" data-toggle="tooltip" title="Akaun Pengguna"><i class="icon-user icon-white"></i></a></li>
          <li><a href="<?= site_url('auth/logout') ?>" id="menuLogout" data-placement="bottom" data-toggle="tooltip" title="Log Keluar"><i class="icon-off icon-white"></i></a></li>
        </ul>

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

      </div>
    </div>
  </div>
</div>

<script>
  $(".icon-user").hover(
    function () {
      $(this).removeClass('icon-white');
    }, 
    function () {
      $(this).toggleClass('icon-white');
    }
  );

  $(".icon-off").hover(
    function () {
      $(this).removeClass('icon-white');
    }, 
    function () {
      $(this).toggleClass('icon-white');
    }
  );
</script>