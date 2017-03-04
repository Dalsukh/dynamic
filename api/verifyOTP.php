<?php
	//verifyOTP.php
	require_once("../include/config.php");
	$validator = new Validator($_REQUEST);

	if(count($_REQUEST)==0){
		echo json_encode(array('status'=>'fail',"msg"=>"Please Provide Data"));
		exit;
	}
	
	$gump = new GUMP($db);
	$errors = array();
    
    $gump->validation_rules(array(
    'user_id' => 'required',    
    'otp'   => 'required',
    ));
    
    $validated_data = $gump->run($_REQUEST);


    if($validated_data === false) {
    	$errors = $gump->get_errors_array();
	}        
	
	if(count($errors)==0){
		
		$user_id = $_REQUEST['user_id'];
		$otp = $_REQUEST['otp'];

		if(isset($_REQUEST['type']))
		{
			$merchant = new Merchants($db);
			$response=$merchant->verifyOTP($user_id,$otp);
		}else{
			$user = new User($db);
			$response=$user->verifyOTP($user_id,$otp);	
		}

		
		echo json_encode($response);		
	}else{
		$response = array('status' => "fail","msg"=>"Please Provide Correct Data");

		$response['errors'] = $errors;
		echo json_encode($response);
	}
