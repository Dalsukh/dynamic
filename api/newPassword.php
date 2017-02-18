<?php
//newPassword.php

	require_once("../include/config.php");
	$validator = new Validator($_REQUEST);

	if(count($_REQUEST)==0){
		echo json_encode(array('status'=>'fail',"msg"=>"Please Provide Data"));
		exit;
	}
	
	$validator->filledIn("token");
	$validator->filledIn("password");	
	$validator->filledIn("confirm_password");	
	
	$errors = $validator->getErrors();
	$id = $validator->getId();

	
	if(count($errors)==0){
		$token = $_REQUEST['token'];
		$SELECT = "SELECT * FROM  password_resets  WHERE token = '$token'";

		$result = mysqli_query($db,$SELECT);
		if($result && mysqli_num_rows($result)){
			$row = mysqli_fetch_assoc($result);

			$UPDATE = "UPDATE  users SET ";
			$UPDATE .= "password='".md5(re_db_input($_REQUEST['password'],$db))."'";			
			$result = mysqli_query($db,$UPDATE);

			$response = array("status"=>"success","msg"=>"Password Changed!");
		}
		else
		{
			$response = array('status' => "fail","msg"=>"Wrong token");
		}		
		echo json_encode($response);		
		
	}else{
		$response = array('status' => "fail");
		foreach($errors as $key => $value) {
			if(strstr($key, "|")) {
				$key = str_replace("|", " and ", $key);

			}
			$field = str_replace("_", " ", $key);
			$response[$key] = $field . " field required";
			
			
		}
		echo json_encode($response);
	}


		




