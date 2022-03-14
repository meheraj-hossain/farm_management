<?php 
include_once('../helpers/db_con.php'); 
if(isset($_SESSION['logged_username']) & !empty($_SESSION['logged_username'])){
        header("Location: index.php");
    }

$errorMessage = array(); //array to keep messages

if (isset($_POST["signIn"])) {

    $username = mysqli_real_escape_string($con,$_POST["username"]); //Escape special characters in strings
    $_SESSION['username'] = $username; //store username into session variable
    $password = md5($_POST["password"]); //encript password by using md5 hasing algorithm

  
    if(empty($username) || empty($password)){
      array_push($errorMessage, "All Field must be filled out");
    }else{
      //Check account verified or not
      $check_user = mysqli_query($con, "SELECT * FROM users WHERE username='$username' AND password='$password' AND (role = 1 || role=2) ");
      $check_found = mysqli_num_rows($check_user); 

      $row = mysqli_fetch_array($check_user);


       if($check_found == 1){
        $_SESSION['username'] = "";

        $_SESSION['logged_username'] = $row['username'];
        $_SESSION['logged_user_id'] = $row['id'];
        $_SESSION['logged_user_type'] = $row['role'];
        header("location: index.php");
      }else{
        array_push($errorMessage, "Email or Password was incorrect");
      } 
    } 
}
    

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>FM-Login</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
</head>
<body class="hold-transition login-page">
<div class="login-box">
  <!-- /.login-logo -->
  <?php
  if (count($errorMessage) > 0) {
      foreach ($errorMessage as $value) { ?>
        <h4 style="color:#e74c3c; text-align: center;"><?=$value?></h4>
      <?php } 
    }
  ?>
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a href="index.php" class="h1"><b>Farm</b>Management</a>
    </div>
    <div class="card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form action="" method="POST">
        <div class="input-group mb-3">
          <input type="text" name="username" class="form-control" placeholder="Username" value="<?php if(isset($_SESSION['username'])){ echo $_SESSION['username']; } ?>">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" name="password" class="form-control" placeholder="Password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-8">
            <div class="icheck-primary">
              
            </div>
          </div>
          <!-- /.col -->
          <div class="col-4">
            <input type="submit" name="signIn" value="Sign In" class="btn btn-primary btn-block">
          </div>
          <!-- /.col -->
        </div>
      </form>

     

      <!-- <p class="mb-1">
        <a href="forgot-password.html">I forgot my password</a>
      </p> -->
      
    </div>
    <!-- /.card-body -->
  </div>
  <!-- /.card -->
</div>
<!-- /.login-box -->

<!-- jQuery -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src=".assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
</body>
</html>
