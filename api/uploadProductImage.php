<?php
//uploadProductImage.php
require_once("../include/config.php");
	
/*
	id	int(10)		
	4	name	varchar(50)	
	5	image1	varchar(255)
	6	image2	varchar(255)
	7	image3	varchar(255)
	8	image4	varchar(255)
	
*/

	
	
	if(count($_REQUEST)==0){
		echo json_encode(array('status'=>'fail',"msg"=>"Please Provide Data"));
		exit;
	}
	
	$gump = new GUMP($db);
	$errors = array();
	$response = array();
    
    
    $gump->validation_rules(array(
    'product_id'      => 'required',        
    ));
    
    $validated_data = $gump->run($_REQUEST);
	

    
    if($validated_data === false) {
    	$errors = $gump->get_errors_array();
	}
	
	
	if(count($errors)==0)
	{

		for($i=1;$i<=4;$i++)
		{


			if(isset($_FILES['image'.$i]['name']) && !empty($_FILES['image']['name'])){
	    
			    //call thumbnail creation function and store thumbnail name
			    //cwUpload($field_name = '', $target_folder = '', $file_name = '', $thumb = FALSE, $thumb_folder = '', $thumb_width = '', $thumb_height = ''){
				$upload_img = cwUpload('image'.$i,'../images/Product/',$_FILES['image'.$i]['name'],TRUE,'../images/Product/Thumb/',
				    	'100','100');
				    
				    	    
			$product = new Product($db);
			$data = array("image$i"=>$upload_img);
			$response=$product->update($data,$_REQUEST['product_id']);
			
			}
		}
		echo json_encode($response);		
	}
	else
	{
		$response = array('status' => "fail","msg"=>"Please Select a image ");
		echo json_encode($response);		
	}