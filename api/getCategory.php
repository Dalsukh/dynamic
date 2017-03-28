<?php
	//getCategory.php
	require_once("../include/config.php");
	$category = new Category($db);
	$response = $category->index();	
	echo json_encode($response);