<?php
require_once("../include/config.php");
/*
INSERT INTO `sub_category` (`id`, `category_id`, `name`, `logo`, `keywords`, `status`, `created_at`, `updated_at`, `created_by`, `deleted`) VALUES (NULL, NULL, '', '', NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, '');
*/
$category = new Category($db);
$categories = $category->index();
$data = $categories['data'];

	$input = new Input();
	$fields = array(
		array('category_id',"Category","select"),
		array("name","Name","text",),
		array("keywords","Keywords","textarea",),
		array("logo","Logo","file",),
	);
	$errors = array();
	$msg = "";

	if(isset($_POST['submit'])){

		$gump = new GUMP($db);
		    
	 	$gump->validation_rules(array(
	 		"category_id"=>"required",
	  		"name"=>"required",
			"keywords"=>"required",
			//"logo"=>"required_file",			
			));
	    
	    $validated_data = $gump->run($_REQUEST);
	    if($validated_data === false) {
	    	$errors = $gump->get_errors_array();
		}       
		if(count($errors)==0){

			$subCategory = new SubCategory($db);
			$category_data = array_except($_POST,'submit');
			$response=$subCategory->store($category_data);
			
			$msg = $response['msg'];
		}
	}	
$content="addSubCategory";
require_once(DIR_FS_TEMPLATES_ADMIN."main_page.tpl.php");
?>