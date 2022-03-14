<?php
include_once('template/head.php');
if(isset($_SESSION['logged_user_id']) & !empty($_SESSION['logged_user_id'])){
	$userId = $_SESSION['logged_user_id']; 
	$getUserData = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM users WHERE id='$userId'"));

	$errorMessage = array();
	if (isset($_POST['updatePassword'])) {
	  	$oldPassword = strip_tags($_POST['oldPassword']);
		$newPassword = strip_tags($_POST['newPassword']);
		$confirmPassword = strip_tags($_POST['confirmPassword']);

		$get_password = mysqli_query($con, "SELECT password FROM users WHERE id='$userId'");
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
			$password_query = mysqli_query($con, "UPDATE users SET password='$newPasswordMD5' WHERE id='$userId'");
			if ($password_query) {
				$_SESSION["SuccessMessage"]="Password updated successfully";
				//header('Location:profile.php');
			}
		}
	}
?>
	

	<body>
		<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js'></script>
		<?php include_once('template/header.php') ?>
		
		<!-- page header section ending here -->
        <section class="page-header padding-tb page-header-bg-1">
            <div class="container">
                <div class="page-header-item d-flex align-items-center justify-content-center">
                    <div class="post-content">
                        <h3>Change Password</h3>
                        <div class="breadcamp">
                            <ul class="d-flex flex-wrap justify-content-center align-items-center">
								<li><a href="index.php">Home</a></li>
                                <li><a class="active">Change Passwoed</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- page header section ending here -->

        <!-- contact us section start here -->
	    <div class="contact padding-tb">
            <div class="container">
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
                <div class="section-wrapper row">
                    <div class="col-lg-8 col-12">
                    	<?php echo SuccessMessage() ?>
                        <div class="contact-part">
                            <div class="contact-title">
                                <h4>Change Password</h4>
                            </div>
                            <form action="" method="POST">
	                            <div class="contact-form d-flex flex-wrap justify-content-between">
	                                <input type="text" name="oldPassword" placeholder="Old Password"> <br>
	                                <input type="text" id="new_password" name="newPassword" placeholder="New Password">
	                                <input type="text" id="confirm_new_Password" name="confirmPassword" placeholder="Confirm New Password">
	                                
	                                <input class="btn" name="updatePassword" type="submit" value="Update">
	                            </div>
                            </form>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>
		<!-- contact us section ending here -->
		
		<!-- gmap section start here -->
        <div class="gmaps padding-tb">
			<div class="container">
				<div id="map"></div>
			</div>
        </div>
        <!-- gmap section ending here -->

		<!-- footer section start here -->
		<?php include_once('template/footer.php'); ?>
		<!-- footer section start here -->


		
		<?php include_once('template/script.php');?>
	</body>
	<script>
	$(document).ready(function (){
		var minDate = new Date();
		$("#milk_required_at").datepicker({
			 showAnim: 'drop',
			 numberOfMonth: 1,
			 minDate: minDate,
			 dateFormat:'yy-mm-dd',
			 onClose: function(selectedDate){
			 $('#return').datepicker("option", "minDate",selectedDate);
			 
			 }
		});
	});
</script>
</html>

 <?php   }else{
 	header('Location:login.php');
 }

 ?>
	