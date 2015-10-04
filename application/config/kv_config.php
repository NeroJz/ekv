<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**************************************************************************************************
* File Name        : kv_config.php
* Description      : This File contain configuration for KV system.
* Author           : Fakhruz
* Date             : 27 June 2013
* Version          : 0.1
* Modification Log : 
* Function List	   : 
**************************************************************************************************/
date_default_timezone_set('Asia/Kuala_Lumpur' );

//configuration for matric no
$config["prefixMatricNoLength"] = 8;
$config["MatricNoSeriesLength"] = 3;
$config['yearToAlpha'] = array("A"=>2012,"B"=>2013,"C"=>2014,"D"=>2015,"E"=>2016,"F"=>2017,"G"=>2018,
								"H"=>2019,"I"=>2020,"J"=>2021,"K"=>2022,"L"=>2023,"M"=>2024,"N"=>2025,
								"O"=>2026,"P"=>2027,"Q"=>2028,"R"=>2029,"S"=>2030,"T"=>2031,"U"=>2032,
								"V"=>2033,"W"=>2034,"X"=>2035,"Y"=>2036,"Z"=>2037);
//end of configuration matric no


   $config['backend_theme'] = "default";
    $config['frontend_theme'] = "default";
    $config['admin_email']="lp@kv.amtis.com.my";
    
    /* Config for Sending Email */
    $config['host_email'] = "lp@kv.amtis.com.my";
    $config['user_email'] = "lp@kv.amtis.com.my";
    $config['smtp_host'] = 'ssl://kiwi.mschosting.com';
    $config['smtp_user'] = 'lp@kv.amtis.com.my';
    $config['admin_name'] = 'Lp';
    $config['smtp_pass'] = 'p@55w0rd';
    $config['smtp_port'] = 465;
    $config['protocol'] = 'smtp';
    $config['smtp_on'] = true;

    //configure sem
    $config['total_sem'] = 10;
    
/**************************************************************************************************
* End of kv_config.php
**************************************************************************************************/
?>