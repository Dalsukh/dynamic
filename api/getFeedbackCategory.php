<?php
//getFeedbackCategory.php
	
	require_once("../include/config.php");
	
	// if(count($_REQUEST)==0){
	// 	echo json_encode(array('status'=>'fail',"msg"=>"Please Provide Data"));
	// 	exit;
	// }
	
	$gump = new GUMP($db);
	$errors = array();
	
    
    /*
    $gump->validation_rules(array(
    'user_id'      => 'required',    
    ));
    
    $validated_data = $gump->run($_REQUEST);


    if($validated_data === false) {
    	$errors = $gump->get_errors_array();
	} 
	*/       
	
	if(count($errors)==0){

		$chatting = new FeedbackCategory($db);
		$response=$chatting->index($_REQUEST);
		echo json_encode($response);		
	}else{
		$response = array('status' => "fail","msg"=>"Please Provide Correct Data");

		$response['errors'] = $errors;
		echo json_encode($response);
	}

