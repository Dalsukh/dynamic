<?php
require_once("../include/config.php");
/*
INSERT INTO `category` (`id`, `name`, `logo`, `keywords`, `status`, `created_at`, `updated_at`, `created_by`, `deleted`) VALUES (NULL, '', '', NULL, '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL, '');
*/
$category = new Category($db);
$category->store();


/*
INSERT INTO 'category' ('id', 'name', 'logo', 'keywords', 'status', 'created_at', 'updated_at', 'created_by', 'deleted') VALUES (NULL, '', '', NULL, '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL, '');
*/
/*$category = new Category($db);
$category->store();*/
$fields = array('id'=>"text",'name'=>"text", 'image1'=>"file", 'image2'=>"file", 'image3'=>"file", 'image4'=>"file", 'price'=>"text", 'description'=>"text",
 'keywords'=>"text", 'product_code'=>"text", 'total_likes'=>"text", 'total_views'=>"text", 'created_by'=>"text");

if(isset($_POST)){
	$product = new Product($db);
	$result = $product->store($_POST);
	
}
$user = new User($db);
$user_data = $user->index();

$subCategory = new SubCategory($db);
$subCat = $subCategory->index();
$subCatData = $subCat['data'];

require_once(DIR_FS_TEMPLATES_ADMIN."main_page.tpl.php");
?>