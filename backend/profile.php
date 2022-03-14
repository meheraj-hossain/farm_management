<?php 
$title = 'Profile';
include_once('template/head.php');
if(isset($_SESSION['logged_user_id'])){
  $userData = mysqli_query($con,"SELECT * FROM users WHERE id='$userLoggedInID'");
  $users = mysqli_fetch_array($userData);

  $errorMessage = array();
  if (isset($_POST['updatePassword'])) {
  	$oldPassword = strip_tags($_POST['oldPassword']);
	$newPassword = strip_tags($_POST['newPassword']);
	$confirmPassword = strip_tags($_POST['confirmPassword']);

	$get_password = mysqli_query($con, "SELECT password FROM users WHERE id='$userLoggedInID'");
	$pass = mysqli_fetch_array($get_password);
	$db_password = $pass['password'];

	if(md5($oldPassword) != $db_password) {
		array_push ($errorMessage,"The old password is incorrect!");
	}

	if($newPassword != $confirmPassword) {
		array_push ($errorMessage,"Your two new passwords need to match!"); 
	}

	if(strlen($newPassword) < 5) {
		array_push ($errorMessage,"Sorry, your password must be greater than 5 characters");	
	}

	if (empty($errorMessage)) {
		$newPasswordMD5 = md5($newPassword);
		$password_query = mysqli_query($con, "UPDATE users SET password='$newPasswordMD5' WHERE id='$userLoggedInID'");
		if ($password_query) {
			$_SESSION["SuccessMessage"]="Password updated successfully";
			//header('Location:profile.php');
		}
	}
  }
  ?>
<body class="hold-transition sidebar-mini layout-fixed">

	<div class="wrapper">
	  <!-- Navbar -->
	  <?php include_once('template/navbar.php'); 
	  // navbar 

	  // Main Sidebar Container 
	  include_once('template/left_sidebar.php') ?>
	  <!-- Content Wrapper. Contains page content -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">User Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
      	<?php echo SuccessMessage() ?>
        	<div style="text-align: center">
	      		<?php 
		        if (count($errorMessage) > 0) {
		        	if(count($errorMessage) ==1){	      		
		        		echo '<h4 style="color:#e74c3c">'. $errorMessage[0]. '</h4>';
		        	}else{ 
		        		foreach ($errorMessage as $value) { ?>
		        			<h5><li style="color:#e74c3c"><?=$value?></li></h5>
		        		<?php } 
		        	}
		        }
		        ?>
	      	</div>
        <div class="row">
        	
          <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
              <div class="card-body box-profile">
                <div class="text-center">
                  <img class="profile-user-img img-fluid img-circle"
                       src="<?=$users['image']?>"
                       alt="User profile picture">
                </div>

                <h3 class="profile-username text-center"><?=$users['name']?></h3>

                <p class="text-muted text-center">
                	<?php if ($users['role'] = 1) {
                		echo 'Admin';
                	}else{
                		echo 'Staff';
                	} ?>
                </p>

                
                
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->

            
          </div>
          <!-- /.col -->
          <div class="col-md-9">
            <div class="card">
              <div class="card-header p-2">
                <ul class="nav nav-pills">
                  
                  	<li class="nav-item"><a class="nav-link" href="#settings" data-toggle="tab">Settings</a></li>
                </ul>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content">
                  <div class="active tab-pane" id="activity">

                  <div class="tab-pane" id="settings">
                    <form class="form-horizontal" method="POST" action="">
                      <div class="form-group row">
                        <label for="oldPassword" class="col-sm-2 col-form-label">Old Password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" name="oldPassword" id="oldPassword" placeholder="Old Password">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="newPassword" class="col-sm-2 col-form-label">New Password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" name="newPassword" id="newPassword" placeholder="New Password">
                        </div>
                      </div>
                      <div class="form-group row">
                        <label for="confirmPassword" class="col-sm-2 col-form-label">Confirm New Password</label>
                        <div class="col-sm-10">
                          <input type="password" class="form-control" name="confirmPassword" id="confirmPassword" placeholder="Confirm Passwrod">
                        </div>
                      </div>
                      
                      
                      <div class="form-group row">
                        <div class="offset-sm-2 col-sm-10">
                          <button type="submit" name="updatePassword" class="btn btn-danger">Update Password</button>
                        </div>
                      </div>
                    </form>
                  </div>
                  <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
              </div><!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
 <?php include_once('template/footer.php'); ?>
 <?php }else{
  header('Location:login.php');
}
?>