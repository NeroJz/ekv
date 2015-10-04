<?php
if(isset($class_data))
{
	
	$data_class = array(
				
			'class_data'=>$class_data				
	);
	
	/**FDPO - Safe to be deleted**/
	//echo('<pre>');print_r($data_class);echo('</pre>');
	//die();
	//echo $data_class;
	echo (json_encode($data_class));
	
}





?>