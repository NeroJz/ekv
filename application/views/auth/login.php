
<style type="text/css">
.wraper {
	background-color: #E6E6E6;
	border-radius:10px;
	display: block;
	margin:auto;
	padding:10px;
}
.inside-login {
}

.login-logo {
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
<link href="<?=base_url()?>assets/css/bootstrap-custom.css" rel="stylesheet">
<link href="<?=base_url()?>assets/css/bootstrap-responsive-custom.css" rel="stylesheet">
<title>SPPKV</title>
<meta name="viewport" content="width=device-width, initial-scale=1"/>
<body style="box-shadow:inset 0px 0px 250px 0px rgba(0,0,0,0.3), inset 0px 0px 250px 250px rgba(0,0,0,.3);background-image:url(<?=base_url()?>assets/img/ios.png);
		">  
<br/>
<div class="container">
<div class="span5" style="display: block;margin:auto; float:none;">

<div class="wraper" style="margin:0 10px;">
            <img src="<?=base_url()?>assets/img/logo_mbmb_login.png" style="display:block; margin:auto;">
	<div class="inside-login">
		<div id="infoMessage" class="alert alert-error" style="text-align: center;"><?php echo $message;?></div>
    <?php echo form_open("auth/login");?>
    <fieldset class="form-box">
    	<table width="100%;" class="logintbl">
            
        	<tr>
            	<td colspan="2" style="text-align: center;" class="pengguna"><?php echo form_input($identity);?></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;" class="pengguna">
                	<?php $extra = ''; 
                		echo form_input($password);?>
                <?php 	$attributes = 'class = "btn btn-large btn-primary" style = "vertical-align: top; width: 80px;"'; 
                			echo form_submit('submit', lang('login_submit_btn'), $attributes);?>
                </td>
            </tr>
            <tr>
                <td style="text-align:center;">
                	<div style="display: block;width: 43.3%;text-align: right;float: left;
}">
        <?php 
    		$attributes = array(
                'class' => 'remember',
			);
			$content_remember = form_checkbox('remember', '1', FALSE, 'id="remember" ').nbs(1).lang('login_remember_label');
			echo form_label($content_remember, 'remember', $attributes);
		?>
				</div><?=nbs(1)?> 
				<div style="width: 53%;float: right;text-align: left;"> | <?=nbs(1)?><?=nbs(1)?> <a style="font-size:13px;" href="forgot_password">
					<?php echo lang('login_forgot_password');?></a></div>





		

                </td>
            </tr>
        </table>
    </fieldset>
    <?php echo form_close();?>
	</div>
</div>
</div>
    </div>
</body>