<?php
//getAllMessage.php

	require_once("../include/config.php");
	
	if(count($_REQUEST)==0){
		echo json_encode(array('status'=>'fail',"msg"=>"Please Provide Data"));
		exit;
	}
	
	$gump = new GUMP($db);
	$errors = array();
	/*
	`from_user_id` int(10) UNSIGNED ,  
  	`to_user_id` int(10) UNSIGNED ,  
  	`message` text,
	*/
    
    $gump->validation_rules(array(
    'user_id'   => 'required',
    'sender'    => 'required'
    ));
    
    $validated_data = $gump->run($_REQUEST);


    if($validated_data === false) {
    	$errors = $gump->get_errors_array();
	}        
	
	if(count($errors)==0){

		$chatting = new Chatting($db);
		$response=$chatting->conversation($_REQUEST);
		echo json_encode($response);		
	}else{
		$response = array('status' => "fail","msg"=>"Please Provide Correct Data");

		$response['errors'] = $errors;
		echo json_encode($response);
	}
