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