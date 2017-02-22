<?php
	//usersRegister.php
	require_once("../include/config.php");
	$validator = new Validator($_REQUEST);

	if(count($_REQUEST)==0){
		echo json_encode(array('status'=>'fail',"msg"=>"Please Provide Data"));
		exit;
	}
	
	
	$gump = new GUMP($db);
	$errors = array();
	$email ="";
	$mobile ="";
    
    
    
    $validated_data = $gump->run($_REQUEST);


            
	if(isset($_REQUEST['mobile']))
	{
		$gump->validation_rules(array(
		    'mobile' => 'required',    	    
		    ));
		$mobile =$_REQUEST['mobile'];
	}
	else{
		$gump->validation_rules(array(
		    'email' => 'required',
		    ));
		$email = $_REQUEST['email'];

	}
	$validated_data = $gump->run($_REQUEST);

	if($validated_data === false) {
    	$errors = $gump->get_errors_array();
	}
	
	if(count($errors)==0){

		$user = new User($db);
		$result = $user->forgotPassword($mobile,$email,$db);
		echo json_encode($result);
	}
?>