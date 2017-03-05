<?php
	
	//updateMerchantDetail.php

	require_once("../include/config.php");
	
	
	if(count($_REQUEST)==0){
		echo json_encode(array('status'=>'fail',"msg"=>"Please Provide Data"));
		exit;
	}	
	/*
	INSERT INTO 'users' ('id', 'full_name', 'email', 'mobile', 'password', 'gender', 'user_type', 'address', 'city', 'state', 'country', 'pincode', 'image', 'mobile_verified', 'email_verified', 'user_package_type', 'latitude', 'otp', 'longitude', 'status', 'created_at', 'updated_at', 'deleted') VALUES (NULL, 'Vishal', 'vishal@gmail.com123', '8511449288', 'f21ae70bd56700c226d573735ea7d77d', 'Male', '122112', '12121', '521', 'Gujarat', 'India', '360004', '', '0', '0', '0', '', '0', '', '1', '2017-02-19 15:22:38', '2017-02-20 23:32:51', '0');
	/*$merchants_insert = "INSERT INTO `merchants` (
            `id`, `user_id`, `member_id`, `member_qr_code`,
            `company_name`, `company_logo`, `job_title`,
            `email1`, `email2`, `website`, `address`, `city`, `state`, `country`, `pincode`,
            `mobile1`, `mobile2`, `landline1`, `landline2`, `fax1`, `fax2`, 
            `facebook`, `twitter`, `google`, `youtube`, `merchant_type`, `business_type`, 
            `additional_business`, `latitude`, `longitude`, 
            `status`, `created_at`, `updated_at`, `deleted`) 
            VALUES 
            (NULL, '$user_id', '$member_id', '$member_qr_code',
            '', '', '',
            'first@mail.com', '', '', '', 'Rajkot', 'GUJARAT', 'INDIA', 
            '360001',
            '".$data['mobile']."', '', '', '', '', '', 
            'facebook.com', 'twitter.com', 'google.com', 'youtube.com', 'FREE', '',
            '', '', '',
            '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '0');";

        $result = mysqli_query($this->db,$merchants_insert);*/
	
	$gump = new GUMP($db);
	$errors = array();
    
    $gump->validation_rules(array(
    'user_id'  => 'required',
    'company_name'  => 'required',
    'job_title'      => 'required',    
    "city" 	 => "required",
    //'password'   => 'required|max_len:100',    
    'address', 
    'pincode', 
    'website',
    //'landline1',
    //'facebook',
    //'google',
    //'twitter',
    //'youtube',    
    ));
    
    $validated_data = $gump->run($_REQUEST);

    if($validated_data === false) {

    $errors = $gump->get_errors_array();
    
	}        
			
	if(count($errors)==0){

		$user_id = $_REQUEST['user_id'];
		$merchant = new Merchants($db);
		$response = $merchant->update($_REQUEST,$user_id);
				
		echo json_encode($response);		
	}else{
		$response = array('status' => "fail","msg"=>"User Registeration Fail");
		$response['errors'] = $errors;
		echo json_encode($response);		
	}
	
	
