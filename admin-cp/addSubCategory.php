<?php
require_once("../include/config.php");
/*
INSERT INTO `sub_category` (`id`, `category_id`, `name`, `logo`, `keywords`, `status`, `created_at`, `updated_at`, `created_by`, `deleted`) VALUES (NULL, NULL, '', '', NULL, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', NULL, '');
*/
$category = new Category($db);
$data = $category->index();
$data = $data['data'];
$subCategory = new SubCategory($db);
$subCategory->store($_REQUEST);


?>
<html>
<head>
<title>FileUpload</title>
</head>
<body>
<br><br><br>
<table border="1" align=center>
<caption><b>Image Upload</b></caption>
<form method="post" action="addSubCategory.php" enctype="multipart/form-data">
	
	<tr><td>Category </td><td>
	<select name="category_id" id="">
		<?php foreach($data as $key=>$row){ ?>
			<option value="<?php echo $row['id'];?>"><?php echo $row['name'] ?></option>
		<?php } ?>
		
	</select>
	</td></tr>
	<tr><td>Sub Category Name</td><td><input type="text" name="name"></td></tr>
	<tr><td></td><td><textarea name="keywords" cols=25 rows=5></textarea></td>	</tr>
	<tr><td>File </td><td><input type="file" name="logo"></td></tr>
	<tr><td>&nbsp;</td><td><input type="submit" name="upload" value="Submit"></td></tr>	
</form>
</table>

