<?php 
include_once('helpers/db_con.php');
function SuccessMessage(){
    if(isset($_SESSION["SuccessMessage"])){
      $output ="<div class='alert alert-success alert-dismissable'>
                <button aria-hidden='true' data-dismiss='alert' class='close' type='button'> × </button>";
      $output.= htmlentities($_SESSION["SuccessMessage"]);
      $output.="</div>";
      $_SESSION["SuccessMessage"] = null;
      return $output;
    }
 }
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Gowala</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="description" content="Gowala is a Creative Dairy Farm & Eco Product HTML5 Template">
	<meta name="keywords" content="Gowala, HTML5, Dairy Farm & Eco Product, Template">
	<meta name="author" content="CodexCoder">
	
	<link href="https://fonts.googleapis.com/css?family=Frank+Ruhl+Libre:300,400,500,700,900&amp;display=swap" rel="stylesheet">
	
	<link href="https://fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i" rel="stylesheet">
	

	<link rel="stylesheet" type="text/css" href="assets/css/daterangepicker.css">

	<link rel="shortcut icon" type="image/x-icon" href="assets/images/x-icon.png">
	<link rel="stylesheet" type="text/css" href="assets/css/animate.css">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/all.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/lightcase.css">
	<link rel="stylesheet" type="text/css" href="assets/flaticon/flaticon.css">
	<link rel="stylesheet" type="text/css" href="assets/css/swiper.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/slick.css">
	<link rel="stylesheet" type="text/css" href="assets/css/slick-theme.css">
	<link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>
