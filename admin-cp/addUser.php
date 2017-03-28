<?php
//addUser.php
require_once("../include/config.php");
//buyer.php
/*
INSERT INTO `category` (`id`, `name`, `logo`, `keywords`, `status`, `created_at`, `updated_at`, `created_by`, `deleted`) VALUES (NULL, '', '', NULL, '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL, '');
*/
$input = new Input($db);
$user = new User($db);
$users = $user->index($input->get('filter'));
$content="addUser";
$fields = array(
		array("full_name","Full Name",'text'),
		array("email","Email",'text'),
		array("mobile","Mobile",'text'),
		array("gender","Gender",'radio','Male','Female'),
		array("user_type","User Type",'text'),
		array("address","Address",'textarea'),
		array("city","City",'text'),
		array("state","State",'text'),
		array("country","Country",'text'),
		array("pincode","Pincode",'text'),
		//array("image","Image",'file'),
		array("mobile_verified","Mobile Verified",'text'),
		array("email_verified","Email Verified",'text'),
		array("user_package_type","User Package Type",'text'),
		array("referral_code","Referral Code",'text'),
		//array("status","Status",'text'),
		array("referral_id","Referral User",'text'),		
		);
	$errors = array();
	$msg = "";

	if(isset($_POST['submit'])){

		$gump = new GUMP($db);
		    
	 	$gump->validation_rules(array(
	    	"full_name"=>"required",
			"email"=>"required|valid_email|unique:users",
			"mobile"=>"required|unique:users",
			"gender"=>"required",
			"user_type"=>"required",
			"address"=>"required",
			"city"=>"required",
			"state"=>"required",
			"country"=>"required",
			"pincode"=>"required",
			//"image","required",
			//"mobile_verified",
			//"email_verified",
			"user_package_type"=>"required",
			"referral_code"=>"required",
			//"status"=>"required",
			"referral_id"=>"required",
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
