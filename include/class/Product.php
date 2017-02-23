<?php
//Product.php

class Product 
{
	/*	
	INSERT INTO `u646130367_dynam`.`products` (`id`, `user_id`, `name`, `image1`, `image2`, `image3`, `image4`, `price`, `description`, `keywords`, `product_code`, `total_likes`, `total_views`, `status`, `created_at`, `updated_at`, `created_by`, `deleted`) VALUES (NULL, NULL, '', '', '', '', '', NULL, NULL, NULL, NULL, NULL, NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, '');
	*/
	public function __construct($db=null)
    {
        $this->db=$db;
        $this->table = "products";
    }
    public function index($where = array())
    {
    	$select = "SELECT * FROM products  WHERE deleted='0'";
		$result = mysqli_query($this->db,$select);	
		$data = array();
		$response = array();
		if($result && mysqli_num_rows($result)){
			while($row=mysqli_fetch_assoc($result))
			{
				$row['image'] = SITE_URL."images/Product/".$row['logo'];
				$row['thumb'] = SITE_URL."images/Product/Thumb/".$row['logo'];
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
		$insert = "INSERT INTO products SET ";
        foreach($_REQUEST as $key=>$val){
            
            if($key != 'PHPSESSID' && $key !="upload"){
                $insert .= $key."='".re_db_input($val,$this->db)."',";
            }
        }
        $upload_img = "";
        for($i=1;$i<=4;$i++){

	        if(!empty($_FILES['image'.$i]['name'])){
	    
			    //call thumbnail creation function and store thumbnail name
			    //cwUpload($field_name = '', $target_folder = '', $file_name = '', $thumb = FALSE, $thumb_folder = '', $thumb_width = '', $thumb_height = ''){
			    $upload_img = cwUpload('image'.$i,'../images/Product/',$_FILES['image'.$i]['name'],TRUE,'../images/Product/Thumb/',
			    	'100','100');
			    
			    	    
			    //set success and error messages
			    $message = $upload_img?"<span style='color:#008000;'>Image thumbnail have been created successfully.</span>":"<span style='color:#F00000;'>Some error occurred, please try again.</span>";
			    
			}else{
			    
			    //if form is not submitted, below variable should be blank
			    $thumb_src = '';
			    $message = '';
			}
			$insert.="image$i='".$upload_img."',";
		}
		
        //$insert .= "state='GUJARAT', country='INDIA',";
        echo $insert .="status='1', created_at=CURRENT_TIMESTAMP(), updated_at=CURRENT_TIMESTAMP(), deleted='0'";

        $result = mysqli_query($this->db,$insert);
        
        return $result;

	}
}