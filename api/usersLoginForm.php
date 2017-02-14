<form action="usersLogin.php">
	<?php

		$fields = array('email', 'password',);
		foreach ($fields as $key => $value) {
			echo $value;
			echo "<input type='text' name='$value'>";
			echo "<br/>";
		}

	?>
	<input type="submit" name="">
</form>

		