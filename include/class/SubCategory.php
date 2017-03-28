<?php
//Category.php
/**
* 
*/
class SubCategory 
{
	
	public function __construct($db=null)
    {
        $this->db=$db;
        $this->table = "category";
    }
    public function index($where = array())
    {
    	$data = array();

    	$select = "SELECT s.*,c.name as category_name FROM sub_category as s
    		LEFT JOIN category as c ON s.category_id = c.id 
    		WHERE s.deleted='0' ";		
		foreach($where as $key=>$val){
			$select.=" AND $key='$val'";
		}
		$result = mysqli_query($this->db,$select);
		$response = array();
		if($result && mysqli_num_rows($result)){
			while($row=mysqli_fetch_assoc($result))
			{
				$row['image'] = SITE_URL."images/Category/".$row['logo'];
				$row['thumb'] = SITE_URL."images/Category/Thumb/".$row['logo'];
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
		
		$insert = "INSERT INTO sub_category SET ";
        foreach($_REQUEST as $key=>$val){
            
            if($key != 'PHPSESSID' && $key !="upload"){
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
}