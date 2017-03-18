<?php
	//sendFeedback.php

	require_once("../include/config.php");
	
	
	if(count($_REQUEST)==0){
		echo json_encode(array('status'=>'fail',"msg"=>"Please Provide Data"));
		exit;
	}	
	
	$gump = new GUMP($db);
	$errors = array();
    
    $gump->validation_rules(array(
    'name'  => 'required',
    "mobile" 	 => "required|numeric|min_len:10",
    'message'   => 'required',    
    ));
    
    $validated_data = $gump->run($_REQUEST);


    if($validated_data === false) {

    $errors = $gump->get_errors_array();
    
	}        
			
	if(count($errors)==0){

		$from = "no-reply@p2d.esy.es";
		if(isset($_REQUEST['email'])){
			$from = $_REQUEST['email'];
		}
		$email = "parmar.dalsukh@gmail.com";
		$message = "Feedback From : ".$_REQUEST['name']."<br/>";
		$message.= $_REQUEST['message'];
		$message.= "<br/> Mobile No:".$_REQUEST['mobile'];

		simpleMail($from,$to=$email,$subject="Feedback - Dynamic",$message);  
		$response = array('status' => "success","msg"=>"Feedback send successfully!" );
		echo json_encode($response);		
	}else{
		$response = array('status' => "fail","msg"=>"Please input data.");
		$response['errors'] = $errors;
		echo json_encode($response);		
	}
	
	
	