<?php
require_once("../include/config.php");
/*
<!-- sellar.php -->
INSERT INTO `category` (`id`, `name`, `logo`, `keywords`, `status`, `created_at`, `updated_at`, `created_by`, `deleted`) VALUES (NULL, '', '', NULL, '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL, '');
*/
$input = new Input();
$sellar = new Merchants($db);

if(isset($_GET['action']) && $_GET['action']=="Delete")
{
	if(isset($_GET['id'])){
		$id = $_GET['id'];
		$sellar->destroy($id);
		$msg = "User deleted successfully!";
	}	
}
$sellars = $sellar->index($input->get('filter'));

$header_fields = array(
		"id"=>"No",
		"full_name"=>"Full Name",
		"email1"=>"Email",
		"mobile1"=>"Mobile",
		"merchant_type"=>"Merchant Type",
		"address"=>"Address",
		// "city"=>"City",
		// "state"=>"State",
		// "country"=>"Country",
		"pincode"=>"Pincode",
		//"image"=>"Image",
		// "mobile_verified"=>"Mobile Verified",
		// "email_verified"=>"Email Verified",
		// "user_package_type"=>"",
		// "referral_code"=>"Referral Code",
		// "status"=>"Status",
		// "referral_id"=>"Referral User",
		// "created_at"=>"Register At",
		// "updated_at"=>"Last Login",
		// "deleted"=>"Deleted",
		);
	// determine page (based on <_GET>)
    $page = isset($_GET['page']) ? ((int) $_GET['page']) : 1;

    // instantiate; set current page; set number of records
	$pagination = (new Pagination());
    $pagination->setCurrent($page);
    $pagination->setRPP(10);
    $pagination->setTotal(count($sellars));

    // grab rendered/parsed pagination markup
    $markup = $pagination->parse();
    $tmp_users = array();
    foreach($sellars as $key=>$row)
    {
    	if($key >=($page-1)*10 && $key <=($page)*10-1 )
    	{
    		$tmp_users[$key] = $row;
    	}
    }
    $sellars =$tmp_users;

$content="sellar";
require_once(DIR_FS_TEMPLATES_ADMIN."main_page.tpl.php");
?>