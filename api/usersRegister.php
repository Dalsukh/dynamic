<?php
	//usersRegister.php
	require_once("../include/config.php");
	$validator = new Validator($_REQUEST);

	if(count($_REQUEST)==0){
		echo json_encode(array('status'=>'fail',"msg"=>"Please Provide Data"));
		exit;
	}
	
	/*
	CURRENT_TIMESTAMP()
	insert into visits set source = '',col2='';
	email
	mobile
	password
	city
	pincode
	latitude
	longitude
	*/

	$validator->filledIn("full_name");
	//$validator->length("lname", "<", 15);
	$validator->email("email");
	$validator->filledIn("mobile");
	$validator->filledIn("password");
	$validator->filledIn("city");
	$validator->filledIn("pincode");
	//$validator->filledIn("latitude");
	//$validator->filledIn("longitude");

	$errors = $validator->getErrors();
	$id = $validator->getId();

	
	if(count($errors)==0){
		$insert = "INSERT INTO users SET ";
		foreach($_REQUEST as $key=>$val){
			if($key == 'password')
			{
				$insert .= $key."='".md5(re_db_input($val,$db))."',";
			}else if($key != 'PHPSESSID'){
				$insert .= $key."='".re_db_input($val,$db)."',";
			}
		}
		//$insert .= "address='', city='', state='GUJARAT', country='INDIA',";
		$insert .="status='1', created_at=CURRENT_TIMESTAMP(), updated_at=CURRENT_TIMESTAMP(), deleted='0'";
		$result = mysqli_query($db,$insert);
		if($result){
			$response = array("status"=>"success","msg"=>"User Register Successfully");	
		}else{
			$response = array('status' => "fail","msg"=>"User Registeration Fail");
		}
		
		echo json_encode($response);		
	}else{
		$response = array('status' => "fail","msg"=>"User Registeration Fail");
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


		




	