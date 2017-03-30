<?php
//Category.php
/**
* 
*/
class Category 
{
	
	public function __construct($db=null)
    {
        $this->db=$db;
        $this->table = "category";
    }
    public function index($where = array())
    {
    	$select = "SELECT * FROM category  WHERE deleted='0'";
    	if(is_array($where)){
            foreach($where as $key=>$val)
            {
            	$select .=" AND $key LIKE '%".$val."%'";
            }
        }
        $select ."  ORDER BY id ASC";
        $result = mysqli_query($this->db,$select);	
		$data = array();
		$response = array();
		if($result && mysqli_num_rows($result)){
			while($row=mysqli_fetch_assoc($result))
			{
				if(!empty($row['logo']))
				{
					$row['image'] = SITE_URL."images/Category/".$row['logo'];
					$row['thumb'] = SITE_URL."images/Category/Thumb/".$row['logo'];
				}
				else
				{
					$row['image'] = "";
					$row['thumb'] = "";
				}
				$data[]=$row;
			}
			$response = array("status"=>"success","data"=>$data);	
		}else{
			$response = array('status' => "fail","msg"=>"No Category Found","data"=>array());
		}
		return $response;
    }
	public function store($data = array())
	{
		$insert = "INSERT INTO category SET ";
        foreach($_REQUEST as $key=>$val){
            
            if($key != 'PHPSESSID' && $key !="upload" && $key !="submit"){
                $insert .= $key."='".re_db_input($val,$this->db)."',";
            }
        }
        $upload_img = "";
        if(!empty($_FILES['logo']['name'])){
    
		    //call thumbnail creation function and store thumbnail name
		    //cwUpload($field_name = '', $target_folder = '', $file_name = '', $thumb = FALSE, $thumb_folder = '', $thumb_width = '', $thumb_height = ''){
		    $upload_img = cwUpload('logo','../images/Category/',$_REQUEST['name'],TRUE,'../images/Category/Thumb/',
		    	'100','100');
		    
		    //full path of the thumbnail image
		    $thumb_src = 'uploads/thumbs/'.$upload_img;
		    
		    //set success and error messages
		    $message = $upload_img?"<span style='color:#008000;'>Image thumbnail have been created successfully.</span>":"<span style='color:#F00000;'>Some error occurred, please try again.</span>";
		    
		}else{
		    
		    //if form is not submitted, below variable should be blank
		    $thumb_src = '';
		    $message = '';
		}
		$insert.="logo='".$upload_img."',";
        //$insert .= "state='GUJARAT', country='INDIA',";
        $insert .="status='1', created_at=CURRENT_TIMESTAMP(), updated_at=CURRENT_TIMESTAMP(), deleted='0'";

        $result = mysqli_query($this->db,$insert);
        return $result;

	}

	public function find($id)
    {
        $select = "SELECT * FROM category WHERE id='$id'";
        $result = mysqli_query($this->db,$select);    
        if($result && mysqli_num_rows($result)){
            $row=mysqli_fetch_assoc($result);
            if(!empty($row['logo'])){
                $row['thumb'] = SITE_URL."images/User/Thumb/".$row['logo'];
                $row['image'] = SITE_URL."images/User/".$row['logo'];    
            }else{
                $row['thumb'] = '';
            }

            $response = array("status"=>"success","msg"=>"Login success","data"=>$row);    
        }else{
            $response = array('status' => "fail","msg"=>"Wrong email or password");
        } 
        return $response;   
        
    }

    public function update($data=array(),$id)
    {
        $update = "UPDATE category SET ";
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
        if(!empty($_FILES['logo']['name'])){
    
		    //call thumbnail creation function and store thumbnail name
		    //cwUpload($field_name = '', $target_folder = '', $file_name = '', $thumb = FALSE, $thumb_folder = '', $thumb_width = '', $thumb_height = ''){
		    $upload_img = cwUpload('logo','../images/Category/',$_REQUEST['name'],TRUE,'../images/Category/Thumb/',
		    	'100','100');
		    
		    //full path of the thumbnail image
		    $thumb_src = 'uploads/thumbs/'.$upload_img;
		    
		    //set success and error messages
		    $message = $upload_img?"<span style='color:#008000;'>Image thumbnail have been created successfully.</span>":"<span style='color:#F00000;'>Some error occurred, please try again.</span>";
		    $update .= "logo = '".$upload_img."',";
		    
		}
		
        $update.="updated_at = CURRENT_TIMESTAMP";
        $update.=" WHERE id='$id'";

        $result = mysqli_query($this->db,$update);
        $response = array("status"=>"success","msg"=>"Update Successfully");
        return $response;
    }


	public function destroy($id)
    {
        $delete = "UPDATE category SET deleted='1' WHERE id = '$id'";
        $result = mysqli_query($this->db,$delete);
    }

    public function getCount($where = array())
    {
        $select = "SELECT * FROM category WHERE deleted='0'";
        $result = mysqli_query($this->db,$select); 
        $data = array();
        $count = mysqli_num_rows($result);
        return $count;
    }
}