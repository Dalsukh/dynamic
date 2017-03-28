<?php
//FeedbackCategory.php

class FeedbackCategory
{

    public function __construct($db=null)
    {
        $this->db=$db;
        $this->table = "feedback_category";
    }

    public function index($where = array())
    {
        $select = "SELECT * FROM feedback_category WHERE deleted='0'";
        $result = mysqli_query($this->db,$select); 
        $data = array();
        if($result && mysqli_num_rows($result)){
            while ($row=mysqli_fetch_assoc($result)) {
                
                $data[] = $row;
            } 
        }
        $response = array("status"=>"success","msg"=>"Data Found","data"=>$data);
        return $response;
    }

    public function store($data = array())
    {
        $insert = "INSERT INTO feedback SET ";
        foreach($_REQUEST as $key=>$val){
            
            if($key != 'PHPSESSID' && $key !="upload"){
                $insert .= $key."='".re_db_input($val,$this->db)."',";
            }
        }
        
        //$insert .= "state='GUJARAT', country='INDIA',";
        $insert .="created_at=CURRENT_TIMESTAMP(), updated_at=CURRENT_TIMESTAMP(), deleted='0'";

        $result = mysqli_query($this->db,$insert);
        $response = array("status"=>"success","data"=>$data);
        return $response;

    }
    /*
    1   id  int(11)
    2   user_id int(11)         
    3   feed_catgory_id int(11)         
    4   sender  varchar(25) 
    5   message 
    6   created_at  
    7   updated_at
    8   deleted
    */
}