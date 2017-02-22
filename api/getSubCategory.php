<?php
	require_once("../include/config.php");
	$category = new Category($db);
	$gump = new GUMP($db);
	$errors = array();
    
    $gump->validation_rules(array(
    'category_id'      => 'required',    
    
    ));
    
    $validated_data = $gump->run($_REQUEST);


    if($validated_data === false) {
    	$errors = $gump->get_errors_array();
	} 
	if(count($errors)==0){

		$subCategory = new SubCategory($db);
		$category_id = $_REQUEST['category_id'];
		$response=$subCategory->index($where = array("category_id"=>$category_id));
		echo json_encode($response);		
	}else{
		$response = array('status' => "fail","msg"=>"Please Provide Correct Data");

		$response['errors'] = $errors;
		echo json_encode($response);
	}      
	
	