<?php

class User 
{

    public function __construct($db=null)
    {
        $this->db=$db;
        $this->table = "users";
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($where = array())
    {

        
    }

    public function login($data = array())
    {

        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];
        $response = array();
        
        $select = "SELECT * FROM users WHERE (email='$email' OR mobile='$email') AND password='".md5(re_db_input($password,$this->db))."'";
        $result = mysqli_query($this->db,$select);    
        if($result && mysqli_num_rows($result)){
            $row = $row=mysqli_fetch_assoc($result);

            $response = array("status"=>"success","msg"=>"Login success","data"=>$row);    
        }else{
            $response = array('status' => "fail","msg"=>"Wrong email or password");
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
        $insert .="status='1', created_at=CURRENT_TIMESTAMP(), updated_at=CURRENT_TIMESTAMP(), deleted='0'";
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
            '".$data['email']."', '', '', '', '".$data['city']."', 'GUJARAT', 'INDIA', 
            '".$data['pincode']."',
            '".$data['mobile']."', '', '', '', '', '', 
            'facebook.com', 'twitter.com', 'google.com', 'youtube.com', 'FREE', '',
            '', '', '',
            '1', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP, '0');";

        $result = mysqli_query($this->db,$merchants_insert);


        if($result){
            $response = array("status"=>"success","msg"=>"User Register Successfully"); 
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($data=array(),$id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
    }
}
