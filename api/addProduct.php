<?php
//addProduct.php
require_once("../include/config.php");
	
/*
	id	int(10)		
	2	user_id	int(10)		
	3	sub_category_id	int(11)
	4	name	varchar(50)	
	5	image1	varchar(255)
	6	image2	varchar(255)
	7	image3	varchar(255)
	8	image4	varchar(255)
	9	price	float(16,2)	
	11	keywords	text	
	12	product_code	
	13	total_likes	int(11)
	17	updated_at	timestamp
	18	created_by	int(11)			
*/
	if(count($_REQUEST)==0){
		echo json_encode(array('status'=>'fail',"msg"=>"Please Provide Data"));
		exit;
	}
	
	$gump = new GUMP($db);
	$errors = array();
    
    $gump->validation_rules(array(
    'user_id'      => 'required',    
    'sub_category_id'   => 'required',
    'name'   => 'required',
    'price'   => 'required',
    'description'   => 'required',    
    ));
    
    $validated_data = $gump->run($_REQUEST);


    if($validated_data === false) {
    	$errors = $gump->get_errors_array();
	}        
	
	if(count($errors)==0){

		$product = new Product($db);
		$response=$product->store();
		echo json_encode($response);		
	}else{
		$response = array('status' => "fail","msg"=>"Please Provide Correct Data");

		$response['errors'] = $errors;
		echo json_encode($response);
	}
