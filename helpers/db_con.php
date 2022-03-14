<?php
session_start();

$timezone = date_default_timezone_set("Asia/Dhaka");

$con = mysqli_connect("localhost", "root", "", "farm_management"); //Connection variable

if(mysqli_connect_errno()) 
{
	echo "Failed to connect: " . mysqli_connect_errno();
}

?>