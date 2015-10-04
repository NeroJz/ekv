<?php
if(isset($search) && $search==1)
{
	$staff = array(
		'staffs' => $result
	);
	echo(json_encode($staff));
}
?>