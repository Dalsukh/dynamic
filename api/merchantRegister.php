<?php
	//merchantRegister.php
	require_once("../include/config.php");
	
	if(count($_REQUEST)==0){
		echo json_encode(array('status'=>'fail',"msg"=>"Please Provide Data"));
		exit;
	}
	$gump = new GUMP($db);
	$errors = array();

	$gump->validation_rules(array(
    'full_name'  => 'required',
    "mobile1" 	 => "required|numeric|min_len:10|unique:merchants",
    'password'   => 'required',
    'min_discount'   => 'required',
    'referral_code'   => 'required',    
    ));
    
    $validated_data = $gump->run($_REQUEST);

    if($validated_data === false) {

    $errors = $gump->get_errors_array();
    
	} 
	
	if(count($errors)==0){
		$merchant = new Merchants($db);
		$response = $merchant->store($_REQUEST);
		
		echo json_encode($response);		
	}else{
		$response = array('status' => "fail","msg"=>"Mobile Already Registered","errors"=>$errors);
		
		echo json_encode($response);
	}
   
    