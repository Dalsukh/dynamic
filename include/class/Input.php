<?php
//Input.php

class Input
{

    public function __construct($db=null)
    {
        $this->db=$db;
        $this->table = "input";
    }

    public function get($name='',$default='')
    {
    	if(strpos($name,".")){
    		$array = explode(".",$name);
	    	$tmp_return = $_REQUEST;
	    	foreach($array as $val){
	    		$tmp_return = $tmp_return[$val];
	    	}	
	    	return $tmp_return;
    	}
    	
    	if(isset($_REQUEST[$name]))
    	{
    		return $_REQUEST[$name];
    	}else{
    		return $default;
    	}
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($city,$where = array())
    {

    	if(array_key_exists("latitude", $where) && array_key_exists("longitude", $where)){

    		$result = getPlaceName($where['latitude'], $where['longitude']);
    		// address city
    		$city = $result['city'];
    	}
    	
    	$select = "SELECT DISTINCT(name) AS name,id FROM geo_locations WHERE name like '%".$city."%'";


        if(empty($city)){
            $select.= " AND pin like '3%'";
        }
        $select .= " ORDER BY name ASC";
    	
        $result = mysqli_query($this->db,$select);    
        $data = array();
        if($result && mysqli_num_rows($result)){
        	while ($row=mysqli_fetch_assoc($result)) {
        		$data[] = $row;
        	}
        	if(array_key_exists("latitude", $where))
        	{
        		$response = array("status"=>"success","msg"=>"City found","data"=>$data[0]);    
        	}else{
        		$response = array("status"=>"success","msg"=>"City found","data"=>$data);    
        	}
            
        }else{
            $response = array('status' => "fail","msg"=>"City not found");
        }         
        return $response;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($data = array())
    {

        $otp = mt_rand(1000,9999);

        $insert = "INSERT INTO users SET ";
        foreach($_REQUEST as $key=>$val){
            if($key == 'password')
            {
                $insert .= $key."='".md5(re_db_input($val,$this->db))."',";
            }else if($key != 'PHPSESSID'){
                $insert .= $key."='".re_db_input($val,$this->db)."',";
            }
        }
        //$insert .= "state='GUJARAT', country='INDIA',";
        $insert .="otp='$otp', status='1', created_at=CURRENT_TIMESTAMP(), updated_at=CURRENT_TIMESTAMP(), deleted='0'";

        $result = mysqli_query($this->db,$insert);
        
        $user_id = mysqli_insert_id($this->db);
        $member_id = strtoupper(generateRandomString(25));

        $QR_path = DIR_FS."images/QRCode/";
        $QR_name = $member_id.".png";
        $errorCorrectionLevel = 'H';
        //array('L','M','Q','H')
        $matrixPointSize = 10;
        $member_qr_code = SITE_URL."/images/QRCode/".$QR_name;

        QRcode::png($member_id, $QR_path.$QR_name, $errorCorrectionLevel, $matrixPointSize, 2); 
        /*
        png($text, $outfile = false, $level = QR_ECLEVEL_L, $size = 3, $margin = 4, $saveandprint=false)
        png($text, $outfile = false, $level = QR_ECLEVEL_L, $size = 3, $margin = 4, $saveandprint=false)
        */   

        
        $merchants_insert = "INSERT INTO `merchants` (
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

        $result = mysqli_query($this->db,$merchants_insert);


        if($result){
            $response = array("status"=>"success","msg"=>"User Register Successfully",
                "data"=>array("user_id"=>$user_id)); 
        }else{
            $response = array('status' => "fail","msg"=>"User Registeration Fail");
        }
        return $response;
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function find($id)
    {
        
    }

}

