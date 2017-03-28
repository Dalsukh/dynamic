<?php
//getMerchantDetail.php

	require_once("../include/config.php");
	

	if(count($_REQUEST)==0){
		echo json_encode(array('status'=>'fail',"msg"=>"Please Provide Data"));
		exit;
	}
	$gump = new GUMP($db);
	$errors = array();
    
    $gump->validation_rules(array(
    'merchant_id'      => 'required', 
    ));
    
    $validated_data = $gump->run($_REQUEST);


    if($validated_data === false) {
    	$errors = $gump->get_errors_array();
	} 
		
	if(count($errors)==0){

		$merchant_id = $_REQUEST['merchant_id'];		

		$user = new Merchants($db);
		$response = $user->find($merchant_id);
		
		echo json_encode($response);		
	}else{

		$response = array(
				'status' => "fail",
				"msg"=>"User Not Found",
				"errors"=>$errors
				);
		
		echo json_encode($response);
	}