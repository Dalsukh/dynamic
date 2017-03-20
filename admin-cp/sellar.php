<?php
require_once("../include/config.php");
/*
<!-- sellar.php -->
INSERT INTO `category` (`id`, `name`, `logo`, `keywords`, `status`, `created_at`, `updated_at`, `created_by`, `deleted`) VALUES (NULL, '', '', NULL, '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL, '');
*/
$sellar = new Merchants($db);
$sellars = $sellar->index();
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
$content="sellar";
require_once(DIR_FS_TEMPLATES_ADMIN."main_page.tpl.php");
?>