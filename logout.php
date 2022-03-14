<?php 
	session_start();
	$_SESSION["logged_username"]= null;
	$_SESSION['logged_user_id'] = null;
	session_destroy();
	header("Location: login.php");
?>
