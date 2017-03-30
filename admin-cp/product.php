<?php
require_once("../include/config.php");
/*
INSERT INTO `category` (`id`, `name`, `logo`, `keywords`, `status`, `created_at`, `updated_at`, `created_by`, `deleted`) VALUES (NULL, '', '', NULL, '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL, '');
*/
$input = new Input();
$product = new Product($db);
$products = $product->index($data = array('user_id'=>"1","type"=>"Popular"),100);
$products = $products['data'];

$header_fields = array(		
		"id"=>"No",
		"user_id"=>"User ID",
		"sub_category_id"=>"Category",
		"name"=>"Name",
		"image1"=>"Image1",
		"image2"=>"Image2",
		"image3"=>"Image3",
		"image4"=>"Image4",
		"price"=>"Price",
		"description"=>"Description",
		"keywords"=>"Keywords",
		"product_code"=>"Product Code",
		"total_likes"=>"Total Likes",
		"total_views"=>"Total View",
		"city"=>"City",
		// "discount"=>"Discount",
		// "old_price"=>"Old Price",
		// "cash_back"=>"Cash Back",
		"status"=>"Status",
		"created_at"=>"created_at",
		"updated_at"=>"updated_at",
		"created_by"=>"created_by",
		"deleted"=>"Deleted",
	);

//$content=basename($_SERVER['REQUEST_URI'],".php");
$content = "product";
$markup = "";
require_once(DIR_FS_TEMPLATES_ADMIN."main_page.tpl.php");
?>