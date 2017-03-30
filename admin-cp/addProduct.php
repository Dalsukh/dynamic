<?php
require_once("../include/config.php");
/*
INSERT INTO `category` (`id`, `name`, `logo`, `keywords`, `status`, `created_at`, `updated_at`, `created_by`, `deleted`) VALUES (NULL, '', '', NULL, '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL, '');
*/
// $category = new Category($db);
// $category->store();


/*
INSERT INTO 'category' ('id', 'name', 'logo', 'keywords', 'status', 'created_at', 'updated_at', 'created_by', 'deleted') VALUES (NULL, '', '', NULL, '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL, '');
*/
$input = new Input();
$fields = array(
	array('id',"","text",),
	array('name',"","text",),
	array('image1',"","file",),
	array('image2',"","file",),
	array('image3',"","file",),
	array('image4',"","file",),
	array('price',"","text",),
	array('description',"","text",),
	array('keywords',"","text",),
	array('product_code',"","text",),
	array('total_likes',"","text",),
	array('total_views',"","text",),
	array('created_by',"","text"),
	);

if(isset($_POST)){
	$product = new Product($db);
	$result = $product->store($_POST);
	print_r($result);
	
}

$errors = array();
$user = new User($db);
$user_data = $user->index();

$subCategory = new SubCategory($db);
$subCat = $subCategory->index();
$subCatData = $subCat['data'];

require_once(DIR_FS_TEMPLATES_ADMIN."main_page.tpl.php");
?>