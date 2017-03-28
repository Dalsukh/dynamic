<?php
require_once("../include/config.php");
/*
INSERT INTO `category` (`id`, `name`, `logo`, `keywords`, `status`, `created_at`, `updated_at`, `created_by`, `deleted`) VALUES (NULL, '', '', NULL, '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL, '');
*/
	$input = new Input();
	$fields = array(
		array("name","Name","text",),
		array("keywords","Keywords","textarea",),
		array("logo","Logo","file",),
	);
	$errors = array();
	$msg = "";

	if(isset($_POST['submit'])){

		$gump = new GUMP($db);
		    
	 	$gump->validation_rules(array(
	  		"name"=>"required",
			"keywords"=>"required",
			"logo"=>"required_file",			
			));
	    
	    $validated_data = $gump->run($_REQUEST);
	    if($validated_data === false) {
	    	$errors = $gump->get_errors_array();
		}       
		if(count($errors)==0){

			$category = new Category($db);
			$data = array_except($_POST,'submit');
			$response=$category->store($data);
			
			$msg = $response['msg'];
		}
	}	
$content="addCategory";
require_once(DIR_FS_TEMPLATES_ADMIN."main_page.tpl.php");
?>