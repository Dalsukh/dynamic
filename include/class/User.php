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
        $select = "SELECT * FROM users WHERE deleted='0'";
        if(is_array($where)){
            foreach($where as $key=>$val)
            {
                $select .=" AND $key LIKE '%".$val."%'";
            }
        }
        $result = mysqli_query($this->db,$select); 
        $data = array();
        if($result && mysqli_num_rows($result)){
            while ($row=mysqli_fetch_assoc($result)) {
                if(!empty($row['image'])){
                    $row['thumb'] = SITE_URL."images/User/Thumb/".$row['image'];
                    $row['image'] = SITE_URL."images/User/".$row['image'];
                }else{
                    $row['thumb']='';
                }
                $data[] = $row;
            } 
        }
        return $data;
        
    }

    public function login($data = array())
    {

        $email = $_REQUEST['email'];
        $password = $_REQUEST['password'];
        $response = array();
        
        $select = "SELECT * FROM users WHERE (email='$email' OR mobile='$email') AND password='".md5(re_db_input($password,$this->db))."'";
        $result = mysqli_query($this->db,$select);    
        if($result && mysqli_num_rows($result)){
            $row=mysqli_fetch_assoc($result);
            
            if(!empty($row['image'])){

                $row['thumb'] = SITE_URL."images/User/Thumb/".$row['image'];
                $row['image'] = SITE_URL."images/User/".$row['image'];    
            }else{
                $row['thumb'] = '';
            }

            $response = array("status"=>"success",
                    "msg"=>"Login success",
                    "sender"=>"BUYER",
                    "data"=>$row,);    
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

        $otp = mt_rand(1000,9999);

        $insert = "INSERT INTO users SET ";
        foreach($data as $key=>$val){
            if($key == 'password')
            {
                $insert .= $key."='".md5(re_db_input($val,$this->db))."',";
            }else if($key != 'PHPSESSID' || $key != 'submit'){
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
        $select = "SELECT * FROM users WHERE id='$id'";
        $result = mysqli_query($this->db,$select);    
        if($result && mysqli_num_rows($result)){
            $row=mysqli_fetch_assoc($result);
            if(!empty($row['image'])){
                $row['thumb'] = SITE_URL."images/User/Thumb/".$row['image'];
                $row['image'] = SITE_URL."images/User/".$row['image'];    
            }else{
                $row['thumb'] = '';
            }

            $response = array("status"=>"success","msg"=>"Login success","data"=>$row);    
        }else{
            $response = array('status' => "fail","msg"=>"Wrong email or password");
        } 
        return $response;   
        
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
        $update = "UPDATE users SET ";
        unset($data['user_id']);

        foreach($data as $key=>$val)
        {
            if($key == 'password')
            {
                $update .= $key."='".md5(re_db_input($val,$this->db))."',";
            }else if($key != 'PHPSESSID'){
                $update .= $key."='".re_db_input($val,$this->db)."',";
            }           

        }
        $update.="updated_at = CURRENT_TIMESTAMP";
        $update.=" WHERE id='$id'";

        $result = mysqli_query($this->db,$update);
        $response = array("status"=>"success","msg"=>"Update Successfully");
        return $response;
    }

    public function verifyOTP($user_id,$otp)
    {
        $user_id = $_REQUEST['user_id'];
        $otp = $_REQUEST['otp'];
        $response = array();
        
        echo $select = "SELECT * FROM users WHERE id = '$user_id' AND otp='$otp'";
        $result = mysqli_query($this->db,$select);    
        if($result && mysqli_num_rows($result)){
            $row = $row=mysqli_fetch_assoc($result);

            $update_data = array('mobile_verified' => "1");
            $this->update($update_data,$user_id);

            $response = array("status"=>"success","msg"=>"OTP Verify success","data"=>$row);    
        }else{
            $response = array('status' => "fail","msg"=>"Wrong OTP");
        } 
        return $response;
    }


    public function forgotPassword($mobile,$email,$db)
    {
        $return = array();
        $select = "SELECT * FROM users WHERE email='$email' OR mobile = '$mobile'";
        $result = mysqli_query($db,$select);    
        if($result && mysqli_num_rows($result)){

        $row =mysqli_fetch_assoc($result);

        $token = generateRandomString();
        if(!empty($mobile))
        {
            $token = mt_rand(1000,9999);
        }


        $INSERT = "INSERT INTO password_resets (`user_id`,`email`, `token`, `created_at`)
                    VALUES ('".$row['id']."','$email', '$token', CURRENT_TIMESTAMP());";
        $result = mysqli_query($db,$INSERT);

        if(!empty($mobile))
        {
            $return = array('status' => "success","msg"=>"SMS send success","data"=>array("token"=>$token));
            return $return;
        }

        $message = '<html>
                    <head>
                    <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
                    </head>
                    <body>';
        $message .='<div class="row">
                        <div class="col-md-6">
                            <br/><br/>
                            Hi '.$row['full_name'].' <br/>
                            Your password reset token is : '.$token.'
                            <br/>
                            Thanks & Regards
                            Dynamic     
                        </div>
                    </div>';

        
        
        /*$addURLS = $_POST['addURLS'];
        if (($addURLS) != '') {
            $message .= "<tr><td><strong>URL To Change (additional):</strong> </td><td>" . strip_tags($addURLS) . "</td></tr>";
        }*/
        /*$curText = htmlentities($_POST['curText']);           
        if (($curText) != '') {
            $message .= "<tr><td><strong>CURRENT Content:</strong> </td><td>" . $curText . "</td></tr>";
        }
        $message .= "<tr><td><strong>NEW Content:</strong> </td><td>" . htmlentities($_POST['newText']) . "</td></tr>";
        $message .= "</table>";*/
        $message .= '<img src="'.SITE_URL.'/images/full_logo_small.png" alt="Dynamic" />';
        $message .= "</body></html>";

        simpleMail($from="no-reply@p2d.esy.es",$to=$email,$subject="Forgot Password - Dynamic",$message);   
        $return = array('status' => "success","msg"=>"Email send success");
        return $return;

        }
        else{
            $return = array('status' => "fail","msg"=>"Email not found");
            return $return;
        }
        
    }

    public function sendSms($mobile='',$message='')
    {
        $curlSession = curl_init();
        curl_setopt($curlSession, CURLOPT_URL, 'http://sms.hspsms.com/sendSMS?username=FMANTRA&message='.$message.'&sendername=MANTRA&smstype=TRANS&numbers='.$mobile.'&apikey=6d7fc73c-a8b7-4d1d-8037-75f64fce38e9');
        curl_setopt($curlSession, CURLOPT_BINARYTRANSFER, true);
        curl_setopt($curlSession, CURLOPT_RETURNTRANSFER, true);

        $jsonData = json_decode(curl_exec($curlSession));
        
        curl_close($curlSession);
        //$jsonData = file_get_contents('http://sms.hspsms.com/sendSMS?username=FMANTRA&message='.$message.'&sendername=MANTRA&smstype=TRANS&numbers='.$mobile.'&apikey=6d7fc73c-a8b7-4d1d-8037-75f64fce38e9');
        return $jsonData;
    }
    public function sendMMS($mobile='',$message='')
    {

    /*Send SMS using PHP*/    
    
    //Your authentication key
    $apikey = "6d7fc73c-a8b7-4d1d-8037-75f64fce38e9";
    
    //Multiple mobiles numbers separated by comma
    $mobileNumber = $mobile;
    
    //Sender ID,While using route4 sender id should be 6 characters long.
    //$senderId = "102234";
    $sendername='MANTRA';
    
    //Your message to send, Add URL encoding here.
    $message = urlencode("Test message");
    
    //Define route 
    $route = "default";
    /*username=FMANTRA&message='.$message.'&sendername=MANTRA&smstype=TRANS&numbers='.$mobile.'&apikey=6d7fc73c-a8b7-4d1d-8037-75f64fce38e9');*/
    //Prepare you post parameters
    $postData = array(
        'apikey' => $apikey,
        'numbers' => $mobile,
        'message' => $message,
        //'sender' => $senderId,
        'route' => $route,
        'username'=>'FMANTRA',
        'message'=>$message,
        'sendername'=>'MANTRA',
        'smstype'=>'TRANS',
    );
    
    //API URL
    $url="http://sms.hspsms.com/sendSMS";
    
    // init the resource
    $ch = curl_init();
    curl_setopt_array($ch, array(
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $postData
        //,CURLOPT_FOLLOWLOCATION => true
    ));
    

    //Ignore SSL certificate verification
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

    
    //get response
    $output = curl_exec($ch);
    
    //Print error if any
    if(curl_errno($ch))
    {
        echo 'error:' . curl_error($ch);
    }
    
    curl_close($ch);
    
    echo $output;

    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = "UPDATE users SET deleted='1' WHERE id = '$id'";
        $result = mysqli_query($this->db,$delete);
    }


    public function getCount($where = array())
    {
        $select = "SELECT * FROM users WHERE deleted='0'";
        $result = mysqli_query($this->db,$select); 
        $data = array();
        $count = mysqli_num_rows($result);
        return $count;
    }
}
