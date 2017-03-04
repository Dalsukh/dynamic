<?php
/*
userImageUpload.php
user_id
image
*/

//usersRegister.php
	require_once("../include/config.php");
	
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
	

    /*
    if($validated_data === false) {
    	$errors = $gump->get_errors_array();
	}
	*/        
	
	if(count($errors)==0){

		if(!empty($_FILES['image']['name'])){
    
		    //call thumbnail creation function and store thumbnail name
		    //cwUpload($field_name = '', $target_folder = '', $file_name = '', $thumb = FALSE, $thumb_folder = '', $thumb_width = '', $thumb_height = ''){
				    $upload_img = cwUpload('image','../images/User/',$_REQUEST['user_id'],TRUE,'../images/User/Thumb/',
				    	'200','200');
		
		$user = new User($db);
		$data = array("image"=>$upload_img);
		$response=$user->update($data,$_REQUEST['user_id']);
		echo json_encode($response);		
		}
		else
		{
			$response = array('status' => "fail","msg"=>"Please Select a image ");
			echo json_encode($response);		
		}

	}else{
		$response = array('status' => "fail","msg"=>"Please Provide Correct Data");

		$response['errors'] = $errors;
		echo json_encode($response);
	}




