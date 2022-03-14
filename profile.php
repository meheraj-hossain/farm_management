<?php
include_once('template/head.php');
if(isset($_SESSION['logged_user_id'])){
$userLoggedInID = $_SESSION['logged_user_id'];
$userData = mysqli_query($con,"SELECT * FROM users WHERE id='$userLoggedInID'");
  $user = mysqli_fetch_array($userData);
 ?>
<body>
		
	<?php include_once('template/header.php') ?>
	<div class="contact padding-tb">

		<link href="assets/css/profile.css" rel="stylesheet">
		<div class="container">
    		<div class="main-body">
    
          <div class="row gutters-sm">
            <div class="col-md-4 mb-3">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex flex-column align-items-center text-center">
                    <img style="height: 250px" src="<?=$user['image']?>">
                    <div class="mt-3">
                      <h4><?=$user['name']?></h4>
                      
                      <a href="changePassword.php" class="btn btn-primary">Change Password</a>
                    </div>
                  </div>
                </div>
              </div>
              
            </div>
            <div class="col-md-8">
              <div class="card mb-3">
                <div class="card-body">
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Full Name</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?=$user['name']?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Email</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?=$user['email']?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Phone</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?=$user['phone']?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Address</h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?=$user['address']?>
                    </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-sm-3">
                      <h6 class="mb-0">Gender </h6>
                    </div>
                    <div class="col-sm-9 text-secondary">
                      <?=$user['gender']?>
                    </div>
                  </div>
                  
                </div>
              </div>
              
            </div>
          </div>
        	</div>
    	</div>
	</div>
	<!-- footer section start here -->
	<?php include_once('template/footer.php'); ?>
	<!-- footer section start here -->


	
	<?php include_once('template/script.php');?>
</body>
<?php }else{
  header('Location:login.php');
}
?>