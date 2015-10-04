<?php 
foreach($css_files as $file): ?>
    <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>

<?php

 foreach($js_files as $file): 
 ?>
    <script src="<?php echo $file; ?>" type="text/javascript"></script>
<?php endforeach; ?>

<?php echo $output;?>