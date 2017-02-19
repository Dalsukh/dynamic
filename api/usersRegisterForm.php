<?php
	//usersRegisterForm.php
	require_once("../include/config.php");
	
	/*
	CURRENT_TIMESTAMP()
	insert into visits set source = '',col2='';
	INSERT INTO 'users' ('id', 'first_name', 'last_name', 'email', 'mobile', 'password', 'gender', 'user_type', 'address', 'city', 'state', 'country', 'pincode', 'latitude', 'longitude', 'status', 'created_at', 'updated_at', 'deleted') VALUES (NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '0000-00-00 00:00:00.000000', '0000-00-00 00:00:00.000000', '');
	*/

?>
<form action="usersRegister.php">
	<?php

		$fields = array('full_name', 'email', 'mobile', 'password', 'gender', 'user_type', 'address', 'city', 'state', 'country', 'pincode', 'latitude', 'longitude',);
		foreach ($fields as $key => $value) {
			echo $value;
			echo "<input type='text' name='$value'>";
			echo "<br/>";
		}
	?>
	<input type="submit" name="">
</form>

		




	