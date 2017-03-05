<?php
	//usersRegister.php
	require_once("../include/config.php");
	
	
	if(count($_REQUEST)==0){
		echo json_encode(array('status'=>'fail',"msg"=>"Please Provide Data"));
		exit;
	}	
	
	$gump = new GUMP($db);
	$errors = array();
    
    $gump->validation_rules(array(
    'full_name'  => 'required',
    //'email'      => 'valid_email|unique:users',    
    "mobile" 	 => "required|numeric|min_len:10|unique:users",
    'password'   => 'required|max_len:100',
    //'city'		 => "required",
    //"pincode"    => "required",
    ));
    
    $validated_data = $gump->run($_REQUEST);


    if($validated_data === false) {

    $errors = $gump->get_errors_array();
    
	}        
			
	if(count($errors)==0){

		$user = new User($db);
		$response = $user->store($_REQUEST);
				
		echo json_encode($response);		
	}else{
		$response = array('status' => "fail","msg"=>"User Registeration Fail Mobile Already Registered");
		$response['errors'] = $errors;
		echo json_encode($response);		
	}
	
	
	