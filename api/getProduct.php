<?php
//getProduct.php
/*
type
mostPopular
SubCategoryID
ProdductID

*/
	require_once("../include/config.php");
	$product = new Product($db);
	$response = $product->index();	
	echo json_encode($response);