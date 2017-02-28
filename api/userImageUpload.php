<?php
/*
userImageUpload.php
user_id
image
*/


if(!empty($_FILES['image']['name'])){
    
		    //call thumbnail creation function and store thumbnail name
		    //cwUpload($field_name = '', $target_folder = '', $file_name = '', $thumb = FALSE, $thumb_folder = '', $thumb_width = '', $thumb_height = ''){
		    $upload_img = cwUpload('logo','../images/Category/',$_REQUEST['name'],TRUE,'../images/Category/Thumb/',
		    	'100','100');
}
