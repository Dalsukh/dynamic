<?php
	//config.php

	error_reporting(E_ALL);
    ini_set("error_reporting", 32767);
    ini_set("display_errors", 1);
	ini_set('error_log', __DIR__ . '/error_log.txt');
    //session_name("crud");
	session_start();

	if (!headers_sent()) {
		header('Content-type: text/html; utf-8');
	}

	date_default_timezone_set ("Asia/Calcutta");
	define('HTTP_SERVER', "http://".$_SERVER['HTTP_HOST'].'/dynamic/'); 
	define('HTTPS_SERVER', '');
	define('ENABLE_SSL', false);
	define('HTTP_COOKIE_DOMAIN', HTTP_SERVER);
	define('HTTPS_COOKIE_DOMAIN', HTTP_SERVER);
    define('HTTP_COOKIE_PATH', HTTP_SERVER);
    define('HTTPS_COOKIE_PATH', HTTP_SERVER);
    define('SITE_EMAIL', 'parmar.dalsukh@gmail.com');

	define('SITE_URL', HTTP_SERVER);
	define('SITE_URL_ADMIN', SITE_URL.'admin-cp/');
    define('SITE_URL_CSS', SITE_URL.'css/');
    define('SITE_URL_JS', SITE_URL.'js/');
	define('SITE_URL_IMAGES', SITE_URL.'images/');


    define('SITE_URL_INCLUDES', SITE_URL.'include/');
	
	define('DIR_FS',$_SERVER['DOCUMENT_ROOT']."/dynamic/");
    define('DIR_FS_ADMIN',DIR_FS.'admin-cp/');
    define('DIR_FS_CSS', DIR_FS.'css/');
    define('DIR_FS_JS', DIR_FS.'js/');
    define('DIR_FS_IMAGES', DIR_FS.'images/');
    
	define('DIR_FS_INCLUDES',DIR_FS.'include/');
    define('DIR_FS_TEMPLATES', DIR_FS.'templates/');
    define('DIR_FS_CONTENT', DIR_FS_TEMPLATES.'content/');
    define('DIR_FS_TEMPLATES_ADMIN', DIR_FS_TEMPLATES.'admin-cp/');
	define('DIR_FS_CONTENT_ADMIN', DIR_FS_TEMPLATES_ADMIN.'content/');
    
    define('ALLOWED_DAYS',30);
    
    define('DIR_FS_INCLUDES_FUNCTION',DIR_FS_INCLUDES.'functions/');
    define('DIR_FS_INCLUDES_CLASS',DIR_FS_INCLUDES.'class/');

	define('CUTMATDIFF', '2');


	
	define('USE_PCONNECT', 'false');
	define('STORE_SESSIONS', 'mysql');
	define('RECORDS_PER_PAGE',25);
	
	

	if($_SERVER['HTTP_HOST'] !="dalsukhp.io")
	{		
		define('DB_SERVER', 'mysql.hostinger.in');
		define('DB_SERVER_USERNAME', 'u646130367_dynam');
		define('DB_SERVER_PASSWORD', '123456');
		define('DB_DATABASE', 'u646130367_dynam');
		
	}else{
		define('DB_SERVER', 'localhost');
		define('DB_SERVER_USERNAME', 'root');
		define('DB_SERVER_PASSWORD', '');
		define('DB_DATABASE', 'dynamic');
	}
	

	/*
	u646130367_dynam	u646130367_dynam	mysql.hostinger.in	0.02
	*/
	
	/*
	$link=mysql_connect($host,$user,$pass) or 
		die("Error To Connect".mysql_error());
		
	$dlink=mysql_select_db($db) or die("Error in Database Select");

	*/


	// Create connection
	$db = mysqli_connect(DB_SERVER, DB_SERVER_USERNAME, DB_SERVER_PASSWORD,DB_DATABASE)  or 
		die("Error To Connect".mysql_error());;

	// Check connection
	if (!$db) {
	    die("Connection failed: " . mysqli_connect_error());
	}


	$page_name=basename($_SERVER['PHP_SELF']);

	require_once(DIR_FS."/validator/Validator.php");
	require_once(DIR_FS."/PHPMailer/PHPMailerAutoload.php");
	require_once(DIR_FS_INCLUDES_FUNCTION."function.php");
	require_once(DIR_FS_INCLUDES_CLASS."City.php");
	require_once(DIR_FS_INCLUDES_CLASS."Chatting.php");
	require_once(DIR_FS_INCLUDES_CLASS."User.php");
	require_once(DIR_FS_INCLUDES_CLASS."Category.php");
	require_once(DIR_FS_INCLUDES_CLASS."SubCategory.php");
	require_once(DIR_FS_INCLUDES_CLASS."Product.php");
	require_once(DIR_FS_INCLUDES_CLASS."GUMP.php");
	require_once(DIR_FS_INCLUDES_CLASS."cwUpload.php");
	require_once(DIR_FS_INCLUDES."QR/qrlib.php");
