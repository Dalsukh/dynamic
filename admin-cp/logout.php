<?php
	require_once('../include/config.php');
	session_unset();
	session_destroy();
	header("Location:login.php");
?>
	