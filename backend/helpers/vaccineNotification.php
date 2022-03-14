<?php
include("../../helpers/db_con.php");
$today = date('Y-m-d');
mysqli_query($con,"UPDATE vaccinations SET viewed=1 WHERE next_vaccined_date <= '$today'");

if (isset($_GET['id'])) {
	$VNID = $_GET['id'];
	mysqli_query($con,"UPDATE vaccinations SET opened=1 WHERE id='$VNID'");
}
?>