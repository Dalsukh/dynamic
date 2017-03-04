<?php
	//TestSMS.php
	require_once("../include/config.php");

	$user = new User($db);
	$result = $user->sendSms($mobile='8000881833',$message='Test  Message Dynamic');
	print_r($result);
