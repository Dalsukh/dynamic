<?php
	//usersRegister.php
	require_once("../include/config.php");
	

	if(count($_REQUEST)==0){
		echo json_encode(array('status'=>'fail',"msg"=>"Please Provide Data"));
		exit;
	}
	
	$gump = new GUMP($db);
	$errors = array();
    
    $gump->validation_rules(array(
    'email'      => 'required',    
    'password'   => 'required',
    ));
    
    $validated_data = $gump->run($_REQUEST);


    if($validated_data === false) {
    	$errors = $gump->get_errors_array();
	}        
	
	if(count($errors)==0){

		$user = new User($db);
		$response=$user->login();
		echo json_encode($response);		
	}else{
		$response = array('status' => "fail","msg"=>"Please Provide Correct Data");

		$response['errors'] = $errors;
		echo json_encode($response);
	} /*
include("../include/config.php");
	if(isset($_REQUEST['password'])){
          if(isset($_REQUEST['mobile'])){
		$username = $_REQUEST['mobile'];
//                $email=$_REQUEST['email'];
		$password = md5($_REQUEST['password']);
		$result = mysqli_query($db,"SELECT * FROM users WHERE mobile= '$username' AND password= '$password'");


		$json = array();
		$category = array();
		if(mysqli_num_rows($result)){
			$row = mysqli_fetch_assoc($result);
			$json['data'] = $row;
			$json['success'] = 'success';
		}else{
			$json['success'] = 'fail';
			$json["message"] = "No data found";
		}
}else{
//$username = $_REQUEST['mobile'];
                $email=$_REQUEST['email'];
		$password = md5($_REQUEST['password']);
		$result = mysqli_query($db,"SELECT * FROM users WHERE email= '$email' AND password= '$password'");


		$json = array();
		$category = array();
		if(mysqli_num_rows($result)){
			$row = mysqli_fetch_assoc($result);
			$json['data'] = $row;
			$json['success'] = 'success';
		}else{
			$json['success'] = 'fail';
			$json["message"] = "No data found";
		}
}

	}else{
		$json['success'] = '0';
		$json["message"] = "Parameters not valid";
	}
	echo json_encode($json);
	mysqli_close($db);
	*/