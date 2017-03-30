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
    public function index($where = array('type'=>'Popular'),$rpp = 4)
    {
    	$user = new User($this->db);
    	$user_data = $user->find($where['user_id']);
    	$page = 1;
        $merchants_fields = "m.id as m_id,
                m.company_name,
                m.company_logo,
                m.job_title,
                m.email1,
                m.website,
                m.address,              
                m.mobile1 as mobile,
                m.landline1 as landline,
                m.merchant_type,
                m.business_type,
                m.min_discount,
                m.full_name,
                m.latitude,
                m.longitude";
    	if(isset($where['page']))
    	{
    		$page = $where['page'];
    	}
        //IF(pl.status IS NULL,0,pl.status)
    	if($where['type'] == "Popular")
    	{
    		$select = "SELECT p.*,IF(pl.status IS NULL,0,pl.status) as is_liked,m.city as city FROM products as p 
    		LEFT JOIN products_likes as pl ON pl.product_id = p.id
            LEFT JOIN merchants as m ON p.user_id = m.id
    		WHERE p.deleted='0' ";
    		//$result = mysqli_query($this->db,$select);    		
    	}
    	else if($where['type'] == "Category")
    	{
    		$select = "SELECT p.*,IF(pl.status IS NULL,0,pl.status) as is_liked ,m.city as city FROM products as p 
    					LEFT JOIN products_likes as pl ON pl.product_id = p.id 
                        LEFT JOIN merchants as m ON p.user_id = m.id
                        JOIN sub_category as sc ON p.sub_category_id = sc.id
                        WHERE p.deleted='0'
    					AND sc.category_id = '".$where['category_id']."'";            

    	}
    	else if($where['type'] ==  "City"){
    		$select = "SELECT p.*,IF(pl.status IS NULL,0,pl.status) as is_liked,m.city as city FROM products as p 
    					LEFT JOIN products_likes as pl ON pl.product_id = p.id 
    					JOIN merchants as m ON p.user_id = m.id
                        WHERE p.deleted='0' 
    					AND m.city LIKE '%".$where['city']."%' ";            
    	}
        else if($where['type'] == "LatLong")
        {
            $latitude = $where['latitude'];
            $longitude = $where['longitude'];
            $radius = $where['radius'];
            $city = new City($this->db);
            $cities = $city->getNearByCity($latitude,$longitude,$radius=50);
            //$cities = implode(",", $cities);

            $select = "SELECT p.*,IF(pl.status IS NULL,0,pl.status) as is_liked,m.city as city,
                    $merchants_fields
                    FROM products as p 
                        LEFT JOIN products_likes as pl ON pl.product_id = p.id 
                        LEFT JOIN merchants as m ON p.user_id = m.id
                         WHERE p.deleted='0'
                        AND m.city LIKE '%".$cities[0]."%'";
            

        }
        else if($where['type'] == "Promotion")
        {
            $select = "SELECT p.*,IF(pl.status IS NULL,0,pl.status) as is_liked,m.city as city               
                         FROM products as p 
            LEFT JOIN products_likes as pl ON pl.product_id = p.id
            LEFT JOIN merchants as m ON p.user_id = m.id
            WHERE p.deleted='0'";
            $select .=" ORDER BY m.min_discount DESC ";          
        }
        else if($where['type'] == "Search")
        {
            $select = "SELECT p.*,IF(pl.status IS NULL,0,pl.status) as is_liked,m.city as city               
                         FROM products as p 
            LEFT JOIN products_likes as pl ON pl.product_id = p.id
            LEFT JOIN merchants as m ON p.user_id = m.id
            WHERE p.deleted='0' AND 
                p.name LIKE '%".$where['name']."%' 
                OR m.city LIKE '%".$where['name']."%'";

        }
        if($where['type'] != "Promotion"){
            $select .=" GROUP BY p.id ORDER BY p.total_likes DESC ";       
        }
    	
        
		$result = mysqli_query($this->db,$select);	
		$tempData = array();
		$data = array();
		$next = "";
		$response = array();		
		if($result && mysqli_num_rows($result)){
			while($row=mysqli_fetch_assoc($result))
			{
				
				// $row['thumb3'] = SITE_URL."images/Product/Thumb/".$row['image2'];
				// $row['thumb3'] = SITE_URL."images/Product/Thumb/".$row['image3'];
				// $row['thumb4'] = SITE_URL."images/Product/Thumb/".$row['image4'];

				
				// $row['image2'] = SITE_URL."images/Product/".$row['image2'];
				// $row['image3'] = SITE_URL."images/Product/".$row['image3'];
				// $row['image4'] = SITE_URL."images/Product/".$row['image4'];
                for ($i=1; $i<=4 ; $i++) { 
                    if($row['image'.$i]){
                        $row['thumb'.$i] = SITE_URL."images/Product/Thumb/".$row['image'.$i];
                        $row['image'.$i] = SITE_URL."images/Product/".$row['image'.$i];         
                    }
                    
                }

                // $row['price'] = round($row['price']);
                // $row['discount'] = round($row['price']);
                // $row['old_price'] = round($row['old_price']);
                // $row['cash_back'] = round($row['cash_back']);

				$tempData[]=$row;
			}
			for($i= (($page - 1) * $rpp);$i< min(mysqli_num_rows($result),$page*$rpp);$i++){
				$data[] = $tempData[$i];
			}
			if(mysqli_num_rows($result)>$page*$rpp){
				$next = SITE_URL."api/getProductList.php?page=".($page+1);
				foreach($_REQUEST as $key=>$val){
					$next.= "&".$key."=".$val;
				}
			}
			
			$response = array("status"=>"success","data"=>$data,"next"=>$next);	
		}else{
			$response = array('status' => "fail","msg"=>"No Product Found");
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
        if(count($_FILES)>0)
        {
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
		}
		
        //$insert .= "state='GUJARAT', country='INDIA',";
        $insert .="status='1', created_at=CURRENT_TIMESTAMP(), updated_at=CURRENT_TIMESTAMP(), deleted='0'";

        $result = mysqli_query($this->db,$insert);
        $product_id = mysqli_insert_id($this->db);
        
        $repsonse = array("status"=>"success","msg"=>"Product Add success",
        		"data"=>array("product_id"=>$product_id));
        return $repsonse;

	}

	public function find($user_id, $id)
    {
		/*
		
				(p.price * m.min_discount/100) as discounts,
				//m.city,
		*/
        $select = "SELECT p.*,pl.status as is_liked,
        		m.id as m_id,
        		m.company_name,
        		m.company_logo,
        		m.job_title,
        		m.email1,
        		m.website,
        		m.address,        		
        		m.mobile1 as mobile,
        		m.landline1 as landline,
        		m.merchant_type,
        		m.business_type,
        		m.min_discount,
                m.full_name,
                m.latitude,
        		m.longitude,
                m.city as city		
        			FROM products as p 
    		LEFT JOIN products_likes as pl ON pl.product_id = p.id 
    		LEFT JOIN merchants as m ON p.user_id = m.id
    		WHERE p.deleted='0' AND p.id = ".$id;

        $result = mysqli_query($this->db,$select);    
        if($result && mysqli_num_rows($result)){

            $row=mysqli_fetch_assoc($result);

			// $row['thumb1'] = SITE_URL."images/Product/Thumb/".$row['image1'];
			// $row['thumb3'] = SITE_URL."images/Product/Thumb/".$row['image2'];
			// $row['thumb3'] = SITE_URL."images/Product/Thumb/".$row['image3'];
			// $row['thumb4'] = SITE_URL."images/Product/Thumb/".$row['image4'];

			// $row['image1'] = SITE_URL."images/Product/".$row['image1'];			
			// $row['image2'] = SITE_URL."images/Product/".$row['image2'];
			// $row['image3'] = SITE_URL."images/Product/".$row['image3'];
			// $row['image4'] = SITE_URL."images/Product/".$row['image4'];


            for ($i=1; $i<=4 ; $i++) { 
                if($row['image'.$i]){
                    $row['thumb'.$i] = SITE_URL."images/Product/Thumb/".$row['image'.$i];
                    $row['image'.$i] = SITE_URL."images/Product/".$row['image'.$i];         
                }
                
            }
            // $row['price'] = round($row['price']);
            // $row['discount'] = round($row['discount']);
            // $row['old_price'] = round($row['old_price']);
            // $row['cash_back'] = round($row['cash_back']);
			
            $response = array("status"=>"success","msg"=>"Product Found","data"=>$row);

            $SELECT = "SELECT * FROM products_views WHERE $user_id='$user_id' AND product_id = '$id'";
            $SEL_RES = mysqli_query($this->db,$SELECT);
            
            if(mysqli_num_rows($SEL_RES)==0){
            	
            	$INSERT = "INSERT INTO products_views SET user_id = '$user_id', product_id = '$id'";
            	
            	$INSERT_RES = mysqli_query($this->db,$INSERT);

            }
        }else{
            $response = array('status' => "fail","msg"=>"Product not Found");
        } 
        return $response;        
    }

    public function update($data=array(),$id)
    {
        $update = "UPDATE products SET ";
        unset($data['product_id']);

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

    public function getCount($where = array())
    {
        $select = "SELECT * FROM products WHERE deleted='0'";
        $result = mysqli_query($this->db,$select); 
        $data = array();
        $count = mysqli_num_rows($result);
        return $count;
    }

    

}