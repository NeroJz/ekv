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
<h1><?php echo lang('change_password_heading');?></h1>
<br />
<div id="infoMessage"><?php echo $message;?></div>
<?php echo form_open("auth/change_password");?>
	<fieldset class="form-box">
    	<table width="449" style="font-size: 13px;">
        	<tr>
            	<td style="text-align: center;"><?php echo lang('change_password_old_password_label', 'old_password');?></td>
            </tr>
            <tr>
            	<td style="text-align: center;"><?php echo form_input($old_password);?></td>
            </tr>
            <tr>
                <td style="text-align: center;"><label for="new_password"><?php echo sprintf(lang('change_password_new_password_label'), $min_password_length);?></label></td>
            </tr>
            <tr>
            	<td style="text-align: center;"><?php echo form_input($new_password);?></td>
            </tr>
            <tr>
            	<td style="text-align: center;"><?php echo lang('change_password_new_password_confirm_label', 'new_password_confirm');?></td>
            </tr>
            <tr>
            	<td style="text-align: center;"><?php echo form_input($new_password_confirm);?></td>
            </tr>            
            <tr>
            	<td style="text-align: center;"><?php echo form_input($user_id);?><?php echo form_submit('submit', lang('change_password_submit_btn'));?></td>
            </tr>
            </tr>
            <tr height="100%">
                <td></td>
            </tr>
        </table>
    </fieldset>
<?php echo form_close();?>
</center>
</div>
</body>