<?php
//addSellar.php
require_once("../include/config.php");
//buyer.php
/*
INSERT INTO `category" (`id`, `name`, `logo`, `keywords`, `status`, `created_at`, `updated_at`, `created_by`, `deleted`) VALUES (NULL, '', '', NULL, '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL, '');
*/
$input = new Input($db);
$user = new User($db);
$users = $user->index($input->get('filter'));
$content="addSellar";
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
	array("latitude","","text",),
	array("longitude","","text",),
	array("status","","text"),
	array("referral_code","","text",),
	array("referral_id","","text",),
	array("min_discount","","text",),
	array("otp","","text",),
	array("mobile_verified","","text",),
	array("email_verified","","text",),
	// array("created_at","","text",),
	// array("updated_at","","text",),
	// array("deleted","","text",),
	// array("full_name","Full Name",'text'),
	// array("gender","Gender",'radio','Male','Female'),
	// array("address","Address",'textarea'),		
		);
	$errors = array();
	$msg = "";

	if(isset($_POST['submit'])){

		$gump = new GUMP($db);
		    
	 	$gump->validation_rules(array(
	  		// "full_name"=>"required",
			// "email"=>"required|valid_email|unique:users",
			// "mobile"=>"required|unique:users",
			// "gender"=>"required",
			// "user_type"=>"required",
			// "address"=>"required",
			// "city"=>"required",
			// "state"=>"required",
			// "country"=>"required",
			// "pincode"=>"required",
			//"image","required",
			//"mobile_verified",
			//"email_verified",
			// "user_package_type"=>"required",
			// "referral_code"=>"required",
			// "status"=>"required",
			// "referral_id"=>"required",
			));
	    
	    $validated_data = $gump->run($_REQUEST);
	    if($validated_data === false) {
	    	$errors = $gump->get_errors_array();
		}       
		if(count($errors)==0){

			$user = new User($db);
			$data = array_except($_POST,'submit');
			$response=$user->store($data);
			
			$msg = $response['msg'];
		}
	}
require_once(DIR_FS_TEMPLATES_ADMIN."main_page.tpl.php");
?>
