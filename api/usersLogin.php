<?php
	//usersRegister.php
	require_once("../include/config.php");
	$validator = new Validator($_REQUEST);

	if(count($_REQUEST)==0){
		echo json_encode(array('status'=>'fail',"msg"=>"Please Provide Data"));
		exit;
	}
	
	
	$validator->email("email");	
	$validator->filledIn("password");
	
	$errors = $validator->getErrors();
	$id = $validator->getId();

	
	if(count($errors)==0){

		$email = $_REQUEST['email'];
		$password = $_REQUEST['password'];

		$select = "SELECT * FROM users WHERE (email='$email' OR mobile='$email') AND password='".md5(re_db_input($password,$db))."'";
		$result = mysqli_query($db,$select);	
		if($result && mysqli_num_rows($result)){
			$row = $row=mysqli_fetch_assoc($result);

			$response = array("status"=>"success","data"=>$row);	
		}else{
			$response = array('status' => "fail","msg"=>"Wrong email or password");
		}		
		echo json_encode($response);		
	}else{
		$response = array('status' => "fail","msg"=>"Please Provide Correct Data");
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


		




