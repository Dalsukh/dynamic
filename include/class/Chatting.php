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
    	$select = "SELECT * FROM chatting  WHERE deleted='0' ";
    	foreach ($where as $key => $value) {
    		$select.= " AND $key='$value'";
    	}
    	$select .= " ORDER BY id ASC";
		$result = mysqli_query($this->db,$select);	
		$data = array();
		$response = array();
		if($result && mysqli_num_rows($result)){
			while($row=mysqli_fetch_assoc($result))
			{
				$data[]=$row;
			}
			$response = array("status"=>"success","data"=>$data);	
		}else{
			$response = array('status' => "fail","msg"=>"No Category Found");
		}
		return $response;
    }
	public function store($data = array())
	{
		$insert = "INSERT INTO chatting SET ";
        foreach($_REQUEST as $key=>$val){
            
            if($key != 'PHPSESSID' && $key !="upload"){
                $insert .= $key."='".re_db_input($val,$this->db)."',";
            }
        }
        
		//$insert .= "state='GUJARAT', country='INDIA',";
        $insert .="created_at=CURRENT_TIMESTAMP(), updated_at=CURRENT_TIMESTAMP(), deleted='0'";

        $result = mysqli_query($this->db,$insert);
        return $result;

	}
}
