<?php
include("../../helpers/db_con.php");
$current_date = date('Y-m-d');
mysqli_query($con,"UPDATE notifications SET viewed=1");

if (isset($_GET['id'])) {
	$nID = $_GET['id'];
	mysqli_query($con,"UPDATE notifications SET opened=1 WHERE id='$nID'");
}
?>