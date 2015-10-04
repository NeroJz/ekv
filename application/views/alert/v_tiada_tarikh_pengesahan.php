<?php
$user_login = $this->ion_auth->user()->row();
$userId = $user_login->user_id;

$user_groups = $this->ion_auth->get_users_groups($userId)->row();  
$ul_type= $user_groups->ul_type;
?>
<div class="alert alert-error">
<button type="button" class="close" data-dismiss="alert">x</button>
<strong>Peringatan!</strong> Tiada tarikh tutup pengesahan ditetapkan untuk Sesi <?= $sesi." Tahun ".$tahun ?>. 
<?php if($ul_type=="LP"){ ?>
<a href="<?= site_url('/maintenance/pengesahan') ?>">Klik di sini</a> untuk memasukkan tarikh tutup pengesahan.
<?php } ?>
</div>