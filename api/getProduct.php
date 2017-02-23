<?php
//getProduct.php
	require_once("../include/config.php");
	$product = new Product($db);
	$response = $product->index();	
	echo json_encode($response);