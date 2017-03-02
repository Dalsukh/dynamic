<?php
	
	//updateUserDetail.php

	require_once("../include/config.php");
	
	
	if(count($_REQUEST)==0){
		echo json_encode(array('status'=>'fail',"msg"=>"Please Provide Data"));
		exit;
	}	
	/*
	INSERT INTO 'users' ('id', 'full_name', 'email', 'mobile', 'password', 'gender', 'user_type', 'address', 'city', 'state', 'country', 'pincode', 'image', 'mobile_verified', 'email_verified', 'user_package_type', 'latitude', 'otp', 'longitude', 'status', 'created_at', 'updated_at', 'deleted') VALUES (NULL, 'Vishal', 'vishal@gmail.com123', '8511449288', 'f21ae70bd56700c226d573735ea7d77d', 'Male', '122112', '12121', '521', 'Gujarat', 'India', '360004', '', '0', '0', '0', '', '0', '', '1', '2017-02-19 15:22:38', '2017-02-20 23:32:51', '0');
	*/
	$gump = new GUMP($db);
	$errors = array();
    
    $gump->validation_rules(array(
    'user_id'  => 'required',
    // 'full_name'  => 'required',
    //'email'      => 'valid_email|unique:users,id !='.$_REQUEST['user_id'],    
    //"mobile" 	 => "required|numeric|min_len:10|unique:users,id !=".$_REQUEST['user_id'],
    //'password'   => 'required|max_len:100',    
    //'gender' => "required", 
    //'user_type', 
    //'address', 
    //'city', 
    //'state', 
    //'country', 
    //'pincode', 
    //'image', 
    //'user_package_type',
    //'latitude',
    //'longitude'  
    
    ));
    
    $validated_data = $gump->run($_REQUEST);


    if($validated_data === false) {

    $errors = $gump->get_errors_array();
    
	}        
			
	if(count($errors)==0){

		$user_id = $_REQUEST['user_id'];
		$user = new User($db);
		$response = $user->update($_REQUEST,$user_id);
				
		echo json_encode($response);		
	}else{
		$response = array('status' => "fail","msg"=>"User Registeration Fail");
		$response['errors'] = $errors;
		echo json_encode($response);		
	}
	
	
