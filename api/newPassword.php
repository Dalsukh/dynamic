<?php
//newPassword.php

	require_once("../include/config.php");
	$validator = new Validator($_REQUEST);

	if(count($_REQUEST)==0){
		echo json_encode(array('status'=>'fail',"msg"=>"Please Provide Data"));
		exit;
	}
	
	$gump = new GUMP($db);
	$errors = array();
    
    $gump->validation_rules(array(
    'token'      => 'required',    
    'password'   => 'required',
    'confirm_password'   => 'required',
    ));
    
    $validated_data = $gump->run($_REQUEST);


    if($validated_data === false) {
    	$errors = $gump->get_errors_array();
	}  
	
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
		
		$response = array('status' => "fail","msg"=>"Reset Password Faail","errors"=>$errors);
		
		echo json_encode($response);
	}


		




