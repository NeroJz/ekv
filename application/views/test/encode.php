<html>
<head>
<script language="javascript" type="text/javascript" src="<?=base_url()?>assets/js/jquery.js"></script>
</head>
<body>
<?php echo "page testing encode!!";?>
<script type="text/javascript">
 $(document).ready(function(){
	 $.get( "<?=site_url('fungsi/encode/')?>/sukor", function( data ) {
		  $( ".result" ).html( data );
		  var curData = showDecode(data);
			 alert( curData );
		});
 });

 function showDecode(curData){
	 var returnStr;
	 $.get( "<?=site_url('fungsi/decode/')?>/"+curData, function( data ) {

			 returnStr = data;
		});
	return returnStr;
 }
</script>
result encode:
<span class="result"></span>
</body>
</html>
