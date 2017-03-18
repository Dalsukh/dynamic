<?php
	/*
		http://localhost/apps/sandeep/json/login.php?user_name=sohil&user_password=admin
		http://intelinfotech.com/apps/sandipceramic/json/login.php?username="aaa"&password="bbb"
		username
		password
	*/
	include("../include/config.php");
	if(isset($_REQUEST['mobile']) || isset($_REQUEST['email']) && isset($_REQUEST['password'])){
		$username = $_REQUEST['mobile'];
                $email=$_REQUEST['email'];
		$password = $_REQUEST['password'];
		$result = mysqli_query($db,"SELECT * FROM users WHERE email= '$email' OR mobile= '$username' AND password= '$password'");
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
		$json['success'] = '0';
		$json["message"] = "Parameters not valid";
	}
	echo json_encode($json);
	mysqli_close($db);
?>		