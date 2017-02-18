<?php
	//usersRegister.php
	require_once("../include/config.php");
	$validator = new Validator($_REQUEST);

	if(count($_REQUEST)==0){
		echo json_encode(array('status'=>'fail',"msg"=>"Please Provide Data"));
		exit;
	}
	
	
	$validator->email("email");	
	$errors = $validator->getErrors();
	$id = $validator->getId();
	
	if(count($errors)==0){

		$email = $_REQUEST['email'];

		$result = forgotPassword($email,$db);
		echo json_encode($result);
	}
?>