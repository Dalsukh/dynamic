<?php
//sendMessage.php

	//usersRegister.php
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
    'from_user_id'      => 'required',    
    'to_user_id'   => 'required',
    //'message'   => 'required',
    'sender'   => 'required',
    ));
    
    $validated_data = $gump->run($_REQUEST);


    if($validated_data === false) {
    	$errors = $gump->get_errors_array();
	}        
	
	if(count($errors)==0){

		$chatting = new Chatting($db);
		$data = $_REQUEST;
		$data['image'] = "";

		if(!empty($_FILES['image']['name'])){
    
		    //call thumbnail creation function and store thumbnail name
		    //cwUpload($field_name = '', $target_folder = '', $file_name = '', $thumb = FALSE, $thumb_folder = '', $thumb_width = '', $thumb_height = ''){
				    $upload_img = cwUpload('image','../images/Chatting/',$_REQUEST['from_user_id'],TRUE,'../images/Chatting/Thumb/',
				    	'200','200');
		
			$data['image'] = $upload_img;		
		
		}
		
		$response=$chatting->store($data);
		echo json_encode($response);		
	}else{
		$response = array('status' => "fail","msg"=>"Please Provide Correct Data");

		$response['errors'] = $errors;
		echo json_encode($response);
	}
