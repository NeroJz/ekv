<style type="text/css">
.wraper {
	height: 320px;
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
	background-image:url(<?=base_url()?>assets/img/logo_mbmb_login.png);
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

</style>
<link href="<?=base_url()?>assets/css/bootstrap.css" rel="stylesheet">
<link href="<?=base_url()?>assets/css/bootstrap-responsive.css" rel="stylesheet">

<body style="box-shadow:
		inset 0px 0px 250px 0px rgba(0,0,0,0.3), inset 0px 0px 250px 250px rgba(0,0,0,.3);
		background-image:url(http://amtisserver/eacara/assets/img/ios.png);
		margin:0px;">
        
<div class="wraper">
	<div class="login-logo"></div>
	<div class="inside-login">
    <form id="frm_login" class="form-box" action="<?= site_url('welcome/paparan')?>" method="post" >
    <fieldset>
    	<table width="449" style="font-size: 13px;">
        	<tr>
            	<td width="159" align="right"><strong>Nama Pengguna : </strong></td>
                <td width="247" align="left"><input type="text" name="input01" style="padding:4px; height:28px;"></td>
            </tr>
            <tr>
            	<td align="right"><strong>Kata Laluan : </strong></td>
                <td align="left"><input type="password" name="input02" style="padding:4px; height:28px;"></td>
            </tr>
            <tr>
            	<th>&nbsp;</th>
                <td><input class="btn btn-large btn-primary" type="submit" name="btn_login" value="Login" style="font-weight: bold; width: 90px;">
                	&nbsp;&nbsp;&nbsp;
                	<a href="#">Lupa kata laluan?</a>
				</td>
            </tr>
            <tr>
            	<th>&nbsp;</th>
                <td></td>
            </tr>
        </table>
    </fieldset>
    </form>
	</div>
</div>
</body>