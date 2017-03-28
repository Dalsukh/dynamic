<?php
//editSellar.php

require_once("../include/config.php");
//buyer.php
/*
INSERT INTO `category` (`id`, `name`, `logo`, `keywords`, `status`, `created_at`, `updated_at`, `created_by`, `deleted`) VALUES (NULL, '', '', NULL, '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL, '');
*/
$input = new Input($db);
$merchants = new Merchants($db);

$content="editSellar";
$fields = array(
	array("full_name","","text",),
	array("member_id","","text",),
	array("member_qr_code","","text",),
	array("company_name","","text",),
	//array("company_logo","","text",),
	array("job_title","","text"),
	array("email1","","text",),
	array("email2","","text",),
	array("password","","text",),
	array("website","","text",),
	array("address","","text",),
	array("city","","text",),
	array("state","","text",),
	array("country","","text",),
	array("pincode","","text",),
	array("mobile1","","text",),
	array("mobile2","","text",),
	array("landline1","","text",),
	array("landline2","","text",),
	array("fax1","","text",),
	array("fax2","","text",),
	array("facebook","","text",),
	array("twitter","","text",),
	array("google","","text",),
	array("youtube","","text",),
	array("merchant_type","","text",),
	array("business_type","","text",),
	array("additional_business","","text",),
	//array("latitude","","text",),
	//array("longitude","","text",),
	//array("status","","text"),
	array("referral_code","","text",),
	array("referral_id","","text",),
	array("min_discount","","text",),
	//array("otp","","text",),
	//array("mobile_verified","","text",),
	//array("email_verified","","text",),
	// array("created_at","","text",),
	// array("updated_at","","text",),
	// array("deleted","","text",),
	// array("gender","Gender",'radio','Male','Female'),
	// array("address","Address",'textarea'),		
		);
	$errors = array();
	$msg = "";

	if(isset($_POST['submit'])){

		$gump = new GUMP($db);
		    
	 	$gump->validation_rules(array(
	    	"full_name"=>"required",
			"email1"=>"required|valid_email",
			"mobile1"=>"required",
			"address"=>"required",
			"city"=>"required",
			"state"=>"required",
			"country"=>"required",
			"pincode"=>"required",
			"referral_code"=>"required",
			"referral_id"=>"required",
			));
	    
	    $validated_data = $gump->run($_REQUEST);
	    if($validated_data === false) {
	    	$errors = $gump->get_errors_array();
		}       
		if(count($errors)==0){

			$merchants = new Merchants($db);
			$data = array_except($_POST,'submit');
			$response=$merchants->update($data,$_GET['id']);
			
			$msg = $response['msg'];
		}
	}	
$user_data = $merchants->find($_GET['id']);

require_once(DIR_FS_TEMPLATES_ADMIN."main_page.tpl.php");
?>

