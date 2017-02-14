<?php
	require_once("../include/config.php");
	$validator = new Validator($_REQUEST);

	$select = "SELECT * FROM category  WHERE deleted='0'";
	$result = mysqli_query($db,$select);	
	$data = array();
	if($result && mysqli_num_rows($result)){
		while($row=mysqli_fetch_assoc($result))
		{
			$data[]=$row;
		}
		$response = array("status"=>"success","data"=>$data);	
	}else{
		$response = array('status' => "fail","msg"=>"Please Login First");
	}		
	echo json_encode($response);