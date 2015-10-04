<?php

$user_login = $this->ion_auth->user()->row();
$userName = $user_login->user_name;
$userId = $user_login->user_id;
$user_groups = $this->ion_auth->get_users_groups($userId)->row();  
$ul_type= $user_groups->ul_type;
$ul_name= $user_groups->ul_name;

if($ul_type=="KV"){
$col=get_user_collegehelp($userId);	
	
	
}



    $hour=date('G');
	
	if($hour<12){
		$hello="Selamat Pagi";
	}elseif(12>=$hour && $hour<=13){
		$hello="Selamat Tengahari Hari";
	}else{
		$hello="Selamat Petang";
	}

?>


<div class="" style="background: linear-gradient(to bottom, #fafafa 0%,#f3f4f4 23%,#e1e2e1 72%,#dedede 86%,#dedede 100%);">
<div class="top-bg">
	<div class="header-text">
    	<img class="logorespond" src="<?=base_url()?>assets/img/header.png" alt="Logo" align="center"></a>
    	<!-- greeting -->
    	<div style=" margin-top: -2px; text-align:right; color:#fbc021; float: right; font-size:11px;">
		<span class="greeting" style="color:#FFFFFF; text-transform: uppercase;">
		
		<?=$hello." " ?>
		<span style="font-weight:bold; text-transform:uppercase;"><?=$userName?></span>
		</span>
		<br>
		<div style="margin-top:-2px;color:#000000;font-weight:bold;" ><?=$ul_name?></div>
		<div style="font-size:11px; margin-top:-6px; font-weight:bold; color:#000000;"><?php echo empty($col[0]->col_name)?'':$col[0]->col_name ?></div>
		</div>
		<!-- greeting -->
    	
        <!--<a href="?page=v_home2"><a href="<?= site_url('welcome') ?>" class="btn pull-right" style="margin-top: 60px;"><i class="icon-off"></i>&nbsp;Logout</a>-->
	</div>
</div>
</div>


