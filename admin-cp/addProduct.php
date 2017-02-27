<?php
//addProduct.php
require_once("../include/config.php");
/*
INSERT INTO 'category' ('id', 'name', 'logo', 'keywords', 'status', 'created_at', 'updated_at', 'created_by', 'deleted') VALUES (NULL, '', '', NULL, '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL, '');
*/
$category = new Category($db);
$category->store();
$fields = array('id'=>"text", 'user_id'=>"text", 'name'=>"text", 'image1'=>"file", 'image2'=>"file", 'image3'=>"file", 'image4'=>"file", 'price'=>"text", 'description'=>"text",
 'keywords'=>"text", 'product_code'=>"text", 'total_likes'=>"text", 'total_views'=>"text", 'created_by'=>"text");

if(isset($_POST)){
	$product = new Product($db);
	$result = $product->store($_POST);
	print_r($result);
}
?>
<html>
<head>
<title>FileUpload</title>
</head>
<body>
<br><br><br>
<table border="1" align=center>
<caption><b>Image Upload</b></caption>
<form method="post" action="addProduct.php" enctype="multipart/form-data">
	<?php foreach($fields as $field=>$type){ ?>
		<tr><td><?php echo $field;?></td><td><input type="<?php echo $type; ?>" name="<?php echo $field;?>"></td></tr>
	<?php }	?>
	<tr><td>&nbsp;</td><td><input type="submit" name="upload" value="Submit"></td></tr>	
</form>
</table>

