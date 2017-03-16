<!-- productForm.tpl.php -->
<table border="1" align=center>
<caption><b>Image Upload</b></caption>
<form method="post" action="addProduct.php" enctype="multipart/form-data">
	<?php foreach($fields as $field=>$type){ ?>
		<tr><td><?php echo $field;?></td><td><input type="<?php echo $type; ?>" name="<?php echo $field;?>"></td></tr>
	
	<?php }	?>
	<tr>
	<td>User</td>
	<td>
		<select name="user_id" id="">
			<?php foreach($user_data as $key=>$row){
				echo "<option value='".$row['id']."'>".$row['full_name']."</option>";
			} ?>
			
		</select>
	</td>
	</tr>
	<tr>
	<td>Sub Category</td>
	<td>
	<select name="sub_category_id" id="">
		<?php foreach($subCatData as $key=>$row){
				echo "<option value='".$row['id']."'>".$row['name']."</option>";
			} ?>
	</select>
	</td>
	</tr>	
	<tr><td>&nbsp;</td><td><input type="submit" name="upload" value="Submit"></td></tr>	
</form>
</table>