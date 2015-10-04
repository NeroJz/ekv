<?php
if(isset($search) && $search==1)
{
	$kv = array(
		'kvs' => $result
	);
	echo(json_encode($kv));
}
elseif(isset($configuration)||isset($manual_configuration))
{
		$data = array(
			'sdconfig' => $configuration,
			'sdmconfig' => $manual_configuration,
		);
		
		echo(json_encode($data));
}
elseif(isset($semester_config))
{
	$data = array(
		'semester_config' => $semester_config
	);
	
	echo(json_encode($data));
}

if(isset($group_semester_vk))
{
	$data = array(
			'group_semester_vk' => $group_semester_vk,
		);
		
	echo(json_encode($data));
}

if(isset($group_semester_ak))
{
	$data = array(
			'group_semester_ak' => $group_semester_ak,
		);
		
	echo(json_encode($data));
}


?>