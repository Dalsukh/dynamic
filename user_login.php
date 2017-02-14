<?php
require_once("./include/config.php");

$email = isset($_GET['email'])?$_GET['email']:'';
$password = isset($_GET['password'])?$_GET['password']:'';

$sql = "SELECT * FROM users WHERE email='".$email."' AND password='$password'";
$res = mysql_query($sql);

if(mysql_num_rows($res)>0){
	$row = mysql_fetch_assoc($res);
	echo json_encode($row);
}
else{
	$row = array("Error"=>"Wrong Username Password");
	$res = json_encode($row);
	echo $res;
}
?>