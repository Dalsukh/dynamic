<?php
	require_once("lib/config.php");
	extract($_GET);
	extract($_POST);
	if(!isset($email)){$email=$txt_email;}
	$select="Select * from tbl_user Where user_email='$email'";
	$result=mysql_query($select);
	if(mysql_num_rows($result)>0 && !isset($edit_id) && !isset($txt_id))
	{
		if(!isset($_POST)){
		echo "User Email Already Register";
		}
		$user_exist=true;
	}
	
?>