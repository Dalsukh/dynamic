<?php

	//usersRegister.php
	require_once("../include/config.php");
	$validator = new Validator($_REQUEST);

	if(count($_REQUEST)==0){
		echo json_encode(array('status'=>'fail',"msg"=>"Please Provide Data"));
		exit;
	}
	
	
	$validator->filledIn("user_id");
	
	$errors = $validator->getErrors();
	$id = $validator->getId();

	
	if(count($errors)==0){

		$user_id = $_REQUEST['user_id'];
		

		$select = "SELECT * FROM users WHERE id =".$user_id;
		$result = mysqli_query($db,$select);	
		if($result && mysqli_num_rows($result)){
			$row = $row=mysqli_fetch_assoc($result);

			$response = array("status"=>"success","data"=>$row);	
		}else{
			$response = array('status' => "fail","msg"=>"User not found");
		}		
		echo json_encode($response);		
	}else{
		$response = array('status' => "fail");
		foreach($errors as $key => $value) {
			if(strstr($key, "|")) {
				$key = str_replace("|", " and ", $key);

			}
			$field = str_replace("_", " ", $key);
			$response[$key] = $field . " field required";
			//echo "<b>Error $value:</b> on field $key<br>";			
			
		}
		echo json_encode($response);
	}


		




