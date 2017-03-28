<?php
require_once("../include/config.php");
/*
INSERT INTO `category` (`id`, `name`, `logo`, `keywords`, `status`, `created_at`, `updated_at`, `created_by`, `deleted`) VALUES (NULL, '', '', NULL, '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL, '');
*/
$category = new Category($db);
$input = new Input();

if(isset($_GET['action']) && $_GET['action']=="Delete")
{
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$category->destroy($id);
		$msg = "Category deleted successfully!";
	}	
}
$categories = $category->index($input->get('filter'));
$categories = $categories['data'];

$header_fields = array(			
		"id"=>"No",
		"name"=>"Name",
		"logo"=>"Logo",
		"keywords"=>"Keywords",
		"status"=>"Status",
		"created_at" => "Created At",
		"updated_at" => "Updated At",		
		"created_by" => "Created By",
		"deleted" => "Deleted",
		"image" => "Image",
		"thumb" => "Thumb",
		"action" => "Action",
		);
$search = array(
		'name' => "Name",
		'keywords' => "Keywords"
		 );

// determine page (based on <_GET>)
    $page = isset($_GET['page']) ? ((int) $_GET['page']) : 1;

    // instantiate; set current page; set number of records
    $pagination = (new Pagination());
    $pagination->setCurrent($page);
    $pagination->setRPP(10);
    $pagination->setTotal(count($categories));

    // grab rendered/parsed pagination markup
    $markup = $pagination->parse();
    $categories_tmp = array();
    foreach($categories as $key=>$row)
    {
    	if($key >=($page-1)*10 && $key <=($page)*10-1 )
    	{
    		$categories_tmp[$key] = $row;
    	}
    }
    $categories =$categories_tmp;


$content="category";
require_once(DIR_FS_TEMPLATES_ADMIN."main_page.tpl.php");
?>


