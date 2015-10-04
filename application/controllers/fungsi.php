<?php
class Fungsi extends CI_Controller {
	
	function __construct() 
	{
		parent::__construct();
	}
	
	function encode($str){
		echo encodeViaUrl($str);
	}
	
	function decode($str){ 
		
		//echo "hallo";
		echo decodeViaUrl($str);
	}
}
	
?>