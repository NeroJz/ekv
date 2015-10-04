<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">

<script type="text/javascript">
	var base_url = '<?=base_url(); ?>';
	var site_url = '<?=site_url(); ?>';
</script>

<title>Lembaga Peperiksaan</title>

<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/accordion-menu.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap-responsive.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/smoothness/demo_table_jui.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/smoothness/jquery-ui-1.8.4.custom.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/widget.css" />
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>assets/css/validationEngine.jquery.css" />

<!--<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery-1.9.1.min.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery-ui.js"></script>-->
<!-- add by mior for pembahagian subjek (13062013) -->
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery-ui.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validationEngine.js" charset="utf-8"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validationEngine-en.js" tcharset="utf-8"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.blockUI.js"></script>
<!-- end add by mior -->
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.dataTables.min.js"></script>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.dataTables.js"></script>


<script src="<?=base_url()?>assets/js/bootstrap.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap.min.js"></script>
<script src="<?=base_url()?>assets/js/bootstrap-dropdown.js"></script>
<style type="text/css">
body {
	padding-top: 0px;
}
.sidebar-nav {
	padding: 9px 0;
	overflow:hidden;
}
</style>

</head>
<body class="dhe-body" style="background:url(<?=base_url()?>assets/img/ios.png) repeat;">
<?php include("v_header.php");?>
<?php include("v_navbar.php");?>
<div class="">
<div class="container-fluid">
				<div class="inside">
					<div class="row-fluid">
						<div class="form-wraper">
        					<?=$view_content?>
                        <div class="push"></div>
						</div>
					</div>
				</div>
</div>
</div>

<footer class="footer-custom" align="center">
	<?php include("v_footer.php");?>
</footer>



</body>
</html>