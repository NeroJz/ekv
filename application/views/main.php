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

<title>SPPKV</title>

<?php 
if(isset($css_files)){
foreach($css_files as $file): ?>
	<link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach;} 


?>
<?php 
if(isset($js_files)){
foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach;} ?>
<link rel="shortcut icon" href="<?=base_url()?>assets/img/favicon.ico">
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/accordion-menu.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/style.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap2.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap-responsive.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap-custom.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/bootstrap-responsive-custom.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/smoothness/demo_table_jui.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/smoothness/demo_page.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/widget.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/smoothness/jquery-ui-1.10.3.custom.min.css" media="screen" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/validationEngine.jquery.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/ticker/modern-ticker.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/offline-theme-default.css" />
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/loadingbar.css" />
<!--link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/jquery-ui-1.7.2.custom.css" /-->


<?php 
if(!isset($js_files) || sizeof($js_files) == 0){
  $this->carabiner->js(base_url('assets/js/jquery.js'));
  $this->carabiner->js(base_url('assets/js/jquery-ui-1.10.3.custom.min.js'));
  $this->carabiner->js(base_url('assets/js/jquery.dataTables.min.js'));
  $this->carabiner->js(base_url('assets/js/FixedHeader.js'));
  $this->carabiner->js(base_url('assets/js/jquery.blockUI.js'));
  $this->carabiner->js(base_url('assets/js/kv.msg.modal.js'));
  $this->carabiner->js(base_url('assets/js/jasny-bootstrap.js'));
}
$this->carabiner->js(base_url('assets/js/jquery.validationEngine.js'));
$this->carabiner->js(base_url('assets/js/jquery.validationEngine-ms.js'));
$this->carabiner->js(base_url('assets/js/offline.min.js'));
$this->carabiner->js(base_url('assets/js/jquery.loadingbar.min.js'));
$this->carabiner->js(base_url('assets/js/common.js'));
$this->carabiner->display('js');
?>

<?php // if(!isset($js_files) || sizeof($js_files) == 0){ ?>
<!-- <script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.js"></script> -->
<!-- <script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery-ui-1.10.3.custom.min.js"></script> -->
<!-- <script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.dataTables.min.js"></script> -->
<!-- <script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/FixedHeader.js"></script> -->
<!-- <script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.blockUI.js"></script> -->
<!-- <script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/kv.msg.modal.js"></script> -->
<!-- <script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jasny-bootstrap.js"></script> -->
<?php // } ?>
<!-- <script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validationEngine.js" charset="utf-8"></script> -->
<!-- <script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.validationEngine-ms.js" tcharset="utf-8"></script> -->
<!-- <script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/offline.min.js"></script> -->
<!-- <script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.loadingbar.min.js"></script> -->
<!-- <script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/common.js"></script> -->

<style type="text/css">
body {
	padding-top: 0px;
}
.sidebar-nav {
	padding: 9px 0;
	overflow:hidden;
}

.themes { text-align: center; }

      /* Sticky footer styles
      -------------------------------------------------- */

      html,
      body {
        height: 100%;
        /* The html and body elements cannot have any padding or margin. */
      }

      /* Wrapper for page content to push down footer */
      #wrap {
        min-height: 100%;
        height: auto !important;
        height: 100%;
        /* Negative indent footer by it's height */
        margin: 0 auto -60px;
      }

      /* Set the fixed height of the footer here */
      #push,
      #footer {
        height: 60px;
      }
      #footer {
        background-color: #f5f5f5;
      }

      /* Lastly, apply responsive CSS fixes as necessary */
      @media (max-width: 767px) {
        #footer {
          margin-left: -20px;
          margin-right: -20px;
          padding-left: 20px;
          padding-right: 20px;
        }
      }
      
      .infoMessage:empty { display: none }

</style>
<!--<script src="<?=base_url()?>assets/js/jquery.js"></script>-->
<script src="<?=base_url()?>assets/js/bootstrap.js"></script>
<!--script src="<?=base_url()?>assets/js/bootstrap.min.js"></script--><!--BUANG SEMENTARA. KACAU JS YG ATAS. ON TIME PRODUCTION-->

<script src="<?=base_url()?>assets/js/bootstrap-dropdown.js"></script>

</head>
<body class="dhe-body" style="background:url(<?=base_url()?>assets/img/ios.png) repeat;">

<div class="pull-right customw3c" style="display:none; absolute;right: 12px;z-index:10000;">
<div id="collapsible_div_outer"> 
<table border="0" align="center" id="collapsible_table_inner"> 
  <tbody><tr> 
    <td width="100%">

<div class="pull-left">
	<table class="breadcrumb border" width="100%" align="center">
	    <tr>
    	<td width="45%" height="35"><div align="right">Sesi</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35" align="left">
	 	<?php
	        	$attr_semester = 'style="" class="span1 validate[required]"';
	        		for($cur_semester = 1; $cur_semester <= 8; $cur_semester++)
	        		{
	        			$options_semester[$cur_semester] = $cur_semester;
					}
					
					echo form_dropdown('current_sesi', $options_semester, set_value('current_sesi'), $attr_semester);
	        	?>
	     </td>
	    <td width="45%" height="35"><div align="right">Semester</div></td>
        <td width="3%" height="35"><div align="center">:</div></td>
        <td width="52%" height="35" align="left">
		<?php
        		$attr_semester = 'style="" class="span1 validate[required]"';
        		for($cur_semester = 1; $cur_semester <= 8; $cur_semester++)
        		{
        			$options_semester[$cur_semester] = $cur_semester;
				}
				
				echo form_dropdown('current_semester', $options_semester, set_value('current_semester'), $attr_semester);
        ?>
        </td>
        </tr>
	</table>
</div>  
    
<div class="btn-group pull-left pullcustom" style="margin-left:10px;">

</div>
    </td> 
    <td width="1%" valign="top"> 
    <img src="<?=base_url()?>assets/img/up.png" width="38" height="51" class="closeImg"></td> 
  </tr> 
</tbody></table> 


</div> 

<div class="pull-right"><img src="<?=base_url()?>assets/img/down.png" width="38" height="51" class="openImg" id="collapsible_indicator">
</div>

</div>


<div id="wrap">

<div id="myAlertModal" class="modal hide fade">
  <div class="modal-header" style="background-color: #blue;">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3 id="modalAlertHeader">Modal header</h3>
  </div>
  
    <div id="panelAlertContent" class="alert alert-block">
  <b id="modalAlertContent">Alert Content</b>
</div>
 
  <div class="modal-footer" style="margin-top:-20px;">
    <a href="#" class="btn btn-info" data-dismiss="modal">Close</a>
  </div>
</div>
<?php
	if(isset($modalAlert)){
		echo $modalAlert;
	}
	else if($this->session->flashdata("alertContent") != "")
	{
		$alertContent = $this->session->flashdata("alertContent");
		$alertType = $this->session->flashdata("alertType");
		$alertHeader = $this->session->flashdata("alertHeader");
		
		$alertType = empty($alertType)?'success':$alertType;
		$alertHeader = empty($alertHeader)?'Kepastian':$alertHeader;
		
		echo "<script>
		var mssg = new Array();
		mssg['heading'] = '".$alertHeader."';
		mssg['content'] = '".$alertContent."';
		kv_alert(mssg);</script>";
	}
?>	
	
<?php include("v_header.php");?>
<?php include("v_navbar2.php"); ?>
		<div class="container-fluid" style="margin-top: 10px;">
				<div class="inside">
					<div class="row-fluid">
						<div class="form-wraper">
        					<?echo $output?>
                        <div class="push"></div>
						</div>
					</div>
				</div>
		</div></div>
		<div class="push"></div>
</div>		
<div id="footer">
	<footer class="footer-custom" align="center">
		<?php include("v_footer.php");?>
	</footer>
</div>
<?php /*?>
<div class="modal" id="confirmbox" style="display: none">
    <div class="modal-body">
        <p id="confirmMessage">Any confirmation message?</p>
    </div>
    <div class="modal-footer">
        <button class="btn" id="confirmFalse">Batal</button>
        <button class="btn btn-primary" id="confirmTrue">OK</button>
    </div>
</div>

<!-- Modal -->
<div id="myModalDownloadPluginMozilla" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Plugin untuk Mencetak</h3>
  </div>
  <div class="modal-body">
    <p>Sila download plugin <a href="<?=base_url().'/plugin/js_print_setup-0.9.1-fx.xpi'?>">jsPrintSetup</a> untuk Mozilla Firefox bagi memudahkan proses Printing</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
    <button class="btn btn-primary" data-dismiss="modal" onclick="window.location='<?=base_url().'/plugin/js_print_setup-0.9.1-fx.xpi'?>'">Download</button>
  </div>
</div>
*/

?>
<script type="text/javascript">
$(document).ready(function(){
  /*if ( $.browser.mozilla ) {
      if(typeof jsPrintSetup == 'undefined'){
        $('#myModalDownloadPluginMozilla').modal('show');
      }
  }*/

$('.nav-custom').collapse('hide');


});
</script>
</body>
</html>