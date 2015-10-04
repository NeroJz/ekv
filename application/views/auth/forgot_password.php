<style type="text/css">
.wraper {
	height: auto;
	width: 470px;
	position: absolute;
	background-color: #E6E6E6;
	right: 50%;
	top: 50%;
	border-radius:10px;
	margin-right:-235px;
	margin-top:-150px;
}
.inside-login {
	padding:10px;
}

.login-logo {
	background-image:url(<?=base_url()?>
	assets/img/logo_mbmb_login.png);
	width:470px;
	height:145px;
	background-repeat:no-repeat;
	background-position:center;
	}

	.form-box {
		background: #ddd;
		border: 1px dotted #ccc;
		border-radius: 5px;
		padding-top: 15px;
	}
	
	#infoMessage:empty { display: none }

</style>
<link rel="shortcut icon" href="<?=base_url()?>assets/img/favicon.ico">
<link href="<?=base_url()?>assets/css/bootstrap.css" rel="stylesheet">
<link href="<?=base_url()?>assets/css/bootstrap-responsive.css" rel="stylesheet">

<body style="box-shadow: inset 0px 0px 250px 0px rgba(0,0,0,0.3), inset 0px 0px 250px 250px rgba(0,0,0,.3); background-image:url(<?=base_url()?>assets/img/ios.png); margin:0px;">
<div class="wraper thumbnail center well well-small text-center">	
		<center>
<h2 style="font-size: 31.5px; margin: 10px 0;"><?php echo lang('forgot_password_heading'); ?></h2>
<p><?php echo sprintf(lang('forgot_password_subheading'), $identity_label); ?></p>


<div id="infoMessage" class="alert alert-error" style="min-height: 0px;"><?php echo $message; ?></div>

<?php echo form_open("auth/forgot_password"); ?>

      <div class="input-prepend" style="display: inline-block; width: 237px;">
      		<span class="add-on">
		      		<label for="email" style="display: block; margin-bottom: 0px; color: #333333;">
		      			<?php echo sprintf(lang('forgot_password_email_label'), $identity_label); ?>
		      		</label> 
      		</span>
      		<?php
      		$email = array(
              'name'        => 'email',
              'id'          => 'email',
              'style'		=> 'height: 28px;',
              'placeholder' => 'anda@email.com'
            );
      		 echo form_input($email); ?>
      </div>
	<p>
      <?php $attributes = 'class = "btn btn-large btn-info"'; echo form_submit('submit', lang('forgot_password_submit_btn'),$attributes ); ?> <a class="btn btn-large" href="<?=base_url()?>">kembali</a></p>
	</p>
<?php echo form_close(); ?>
</center>
</div>
</body>