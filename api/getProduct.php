<?php
	//getProduct.php

	require_once("../include/config.php");
	$gump = new GUMP($db);
	$errors = array();
    
    $gump->validation_rules(array(
    'user_id' => 'required',
    'product_id' => "required"
    ));
    
    $validated_data = $gump->run($_REQUEST);


    if($validated_data === false) {
    	$errors = $gump->get_errors_array();
	}    
	
	if(count($errors)==0){

	$product = new Product($db);
	$user_id = $_REQUEST['user_id'];
	$product_id = $_REQUEST['product_id'];
	$response = $product->find($user_id,$product_id);	
	
	echo json_encode($response);

	}
	else{

		echo json_encode($errors);
	}