<?php

	//usersRegister.php
	require_once("../include/config.php");
	$validator = new Validator($_REQUEST);

	if(count($_REQUEST)==0){
		echo json_encode(array('status'=>'fail',"msg"=>"Please Provide Data"));
		exit;
	}
	$gump = new GUMP($db);
	$errors = array();
    
    $gump->validation_rules(array(
    'user_id'      => 'required',    
    
    ));
    
    $validated_data = $gump->run($_REQUEST);


    if($validated_data === false) {
    	$errors = $gump->get_errors_array();
	} 
	
	
	
	if(count($errors)==0){

		$user_id = $_REQUEST['user_id'];		

		$user = new User($db);
		$response = $user->find($user_id);
		
		echo json_encode($response);		
	}else{
		$response = array('status' => "fail","msg"=>"User Not Found");
		
		echo json_encode($response);
	}


		




