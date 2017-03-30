<?php
//ProductLike.php

class ProductLike
{
	public function __construct($db=null)
    {
        $this->db=$db;
        $this->table = "products_likes";
    }
    public function like($where = array())
    {

    	/* 
    	'user_id'  => 'required',
    	"product_id" 

		id 	user_id	product_id	status 0-INACTIVE OR UNAPROVED 1-ACTIVE OR APPROVED
		created_at
		updated_at
		deleted 	0-NO 1-YES
    	**/
	$update = "UPDATE products SET total_likes = total_likes + 1 WHERE id = '".$where['product_id']."'";

	$result = mysqli_query($this->db,$update);

    	$INSERT = "INSERT INTO products_likes SET ";
    	$INSERT .= "user_id ='".$where['user_id']."',";
    	$INSERT .= "product_id ='".$where['product_id']."',";
        $INSERT .="status='1',created_at = CURRENT_TIMESTAMP(),updated_at = CURRENT_TIMESTAMP()";
        
        $result = mysqli_query($this->db,$INSERT);
        $response = array("status"=>"success","msg"=>"Update Successfully");
        return $response;
    
    }
}