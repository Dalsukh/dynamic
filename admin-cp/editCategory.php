<?php
require_once("../include/config.php");
/*
INSERT INTO `category` (`id`, `name`, `logo`, `keywords`, `status`, `created_at`, `updated_at`, `created_by`, `deleted`) VALUES (NULL, '', '', NULL, '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', NULL, '');
*/
$category = new Category($db);
$category->store();
?>
<html>
<head>
<title>FileUpload</title>
</head>
<body>
<br><br><br>
<table border="1" align=center>
<caption><b>Image Upload</b></caption>
<form method="post" action="addCategory.php" enctype="multipart/form-data">
	<tr><td>Category Name</td><td><input type="text" name="name"></td></tr>
	<tr><td></td><td><textarea name="keywords" cols=25 rows=5></textarea></td>	</tr>
	<tr><td>File </td><td><input type="file" name="logo"></td></tr>
	<tr><td>&nbsp;</td><td><input type="submit" name="upload" value="Submit"></td></tr>	
</form>
</table>

