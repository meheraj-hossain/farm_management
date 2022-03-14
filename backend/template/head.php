<?php 
include_once('../helpers/db_con.php');
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

if(isset($_SESSION['logged_user_id'])){
    $userLoggedIn = $_SESSION['logged_username'];
    $userLoggedInID = $_SESSION['logged_user_id'];
    $userLoggedInType = $_SESSION['logged_user_type'];

    //get admin data
    $userData = mysqli_query($con,"SELECT * FROM users WHERE id='$userLoggedInID'");
    $user = mysqli_fetch_array($userData);
}else{
  header("Location: login.php");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?=$title?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="assets/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <link rel="stylesheet" href="assets/plugins/select2/css/select2.min.css">  
  <link rel="stylesheet" href="assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="assets/plugins/jqvmap/jqvmap.min.css">
  
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="assets/plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="assets/plugins/summernote/summernote-bs4.min.css">

   <!-- DataTables -->
  <link rel="stylesheet" href="assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="assets/dist/css/custom.css">

  <script src="assets/plugins/jquery/jquery.min.js"></script>
</head>