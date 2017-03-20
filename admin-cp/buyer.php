<?php
require_once("../include/config.php");
//buyer.php
/*
INSERT INTO `category` (`id`, `name`, `logo`, `keywords`, `status`, `created_at`, `updated_at`, `created_by`, `deleted`) VALUES (NULL, '', '', NULL, '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL, '');
*/
$user = new User($db);
$users = $user->index();
$content="buyer";
$header_fields = array(
		"id"=>"No",
		"full_name"=>"Full Name",
		"email"=>"Email",
		"mobile"=>"Mobile",
		"gender"=>"Gender",
		"user_type"=>"User Type",
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
	require_once(DIR_FS_TEMPLATES_ADMIN."main_page.tpl.php");
?>



