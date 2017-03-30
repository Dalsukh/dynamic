<?php
//Chatting.php

class Chatting 
{
	
	public function __construct($db=null)
    {
        $this->db=$db;
        $this->table = "chatting";
    }
    public function index($where = array())
    {
        $join = "";
        $fields ="";
        

    	$select = "SELECT * FROM chatting  WHERE deleted='0' ";
    	foreach ($where as $key => $value) {
            if($key != "PHPSESSID")
            {
                $select.= " AND $key='$value'";
            }
    	}
        if($where['sender'] == "BUYER"){
            $select .= " OR (to_user_id ='".$where['from_user_id']."' AND sender='SELLER')";
        }else{
            $select .= " OR (to_user_id ='".$where['from_user_id']."' AND sender='BUYER')";
        }

    	$select .= " ORDER BY id ASC";
		$result = mysqli_query($this->db,$select);	
		$data = array();
		$response = array();
		if($result && mysqli_num_rows($result)){
			while($row=mysqli_fetch_assoc($result))
			{
                if(!empty($row['image'])){
                    $row['thumb'] = SITE_URL."images/Chatting/Thumb/".$row['image'];
                    $row['image'] = SITE_URL."images/Chatting/".$row['image'];
                }else{
                    $row['thumb'] = "";
                    $row['image'] = "";
                }
				$data[]=$row;
			}
			$response = array("status"=>"success","data"=>$data);	
		}else{
			$response = array('status' => "fail","msg"=>"No Chatting Found");
		}
		return $response;
    }
    //conversation
    public function conversation($where = array())
    {
        /*
        username
        user img
        last msg
        SELECT * FROM ( 
    SELECT emailID, fromEmail, subject, timestamp, MIN(read) as read 
    FROM incomingEmails 
    WHERE toUserID = '$userID' 
    ORDER BY timestamp DESC
) AS tmp_table GROUP BY LOWER(fromEmail)
        */
       
        $join = "";
        $fields ="";
        $select ="";
        if(isset($where['sender']) && $where['sender'] == "BUYER")
        {
            $fields = " c.*,m.full_name as user_name,m.company_logo as thumb,c.message as last_message";
            $join .= "LEFT JOIN merchants as m ON c.to_user_id = m.id";
            $group_by = " ";
            
        }else{
            $fields = " c.*,u.full_name as user_name,u.image as thumb,c.message as last_message";
            $join .= "LEFT JOIN users as u ON c.to_user_id = u.id";
            $group_by = " ";            
        }
        
        $select .= "SELECT ".$fields."  FROM chatting as c ".$join;
        
        $select .= " WHERE c.deleted='0' ";
        $select .= " AND from_user_id ='".$where['user_id']."' AND sender ='".$where['sender']."' ";
        $select .= " OR (to_user_id  ='".$where['user_id']."' 
            AND sender !='".$where['sender']."')";

        $select .="ORDER BY to_user_id DESC,c.id DESC ";
        //$select .= $group_by;
        /*
        SELECT  c.*,m.full_name as user_name,m.company_logo as thumb,c.message as last_message  FROM chatting as c LEFT JOIN merchants as m ON c.to_user_id = m.id WHERE c.deleted='0'  AND from_user_id ='13' AND sender ='BUYER'  OR (to_user_id  ='13' 
            AND sender !='BUYER') ORDER BY c.id DESC,to_user_id DESC  
        */
        
        $result = mysqli_query($this->db,$select);  
        $data = array();
        $response = array();
        if($result && mysqli_num_rows($result)){
            $input = new Input();
            while($row=mysqli_fetch_assoc($result))
            {
                $row['time_ago'] = $input->time_elapsed_string($row['created_at']);
                if($row['thumb']){
                    $row['thumb'] = SITE_URL."images/User/Thumb/".$row['thumb'];
                }else{
                    $row['thumb']= "";
                }
                if($row['image']){
                    $row['image'] = SITE_URL."images/Chatting/Thumb/".$row['image'];
                }else{
                    $row['image']= "";
                }
                $data[]=$row;
            }
            $return = array();
            $to_user_id = null;
            foreach($data as $key=>$row)
            {
                if(!$to_user_id)
                {
                    $return[] = $row;
                    $to_user_id = $row['to_user_id'];
                }
                else if($to_user_id != $row['to_user_id'] && $where['sender']==$row['sender'])
                {
                    $return[] = $row;
                    $to_user_id = $row['to_user_id'];
                }
            }
            $response = array("status"=>"success","data"=>$return);   
        }else{
            $response = array('status' => "fail","msg"=>"No Chatting Found");
        }
        return $response;
    }
	public function store($data = array())
	{
		$insert = "INSERT INTO chatting SET ";
        foreach($data as $key=>$val){
            
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
}
