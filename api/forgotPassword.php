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

		$to = $_REQUEST['email'];
		$subject = "This is Test Mail";
		$result = sendMail($from="parmar.dalsukh@gmail.com",$to,$subject="")
		echo json_encode($result);
	}
?>