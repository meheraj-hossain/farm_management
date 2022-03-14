<?php 
	session_start();
	$_SESSION["logged_user"]= null;
	$_SESSION['logged_user_id'] = null;
	$_SESSION['logged_user_type'] = null;
	session_destroy();
	header("Location: login.php");
?>
