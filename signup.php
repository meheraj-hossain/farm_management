<?php 
$title = 'Signup';
include_once('template/head.php'); 

$errorMessage = array();
	
if(isset($_POST['submit'])){
	if (empty($_POST['name']) || empty($_POST['phone']) || empty($_POST['gender']) ||  empty($_POST['address']) || empty($_POST['email']) || empty($_FILES["image"]["name"]) ||empty( $_POST['username']) || empty($_POST['password'])) {
		array_push ($errorMessage,"All field must be field out");
    }else{
    	// name
		$name = strip_tags($_POST['name']); 
		$_SESSION['name'] = $name; 

		$gender = strip_tags($_POST['gender']); 
		$_SESSION['gender'] = $gender; 
		
		//Email
		$email = strip_tags($_POST['email']); 
		$email = str_replace(' ', '', $email); 
		$_SESSION['email'] = $email; 

		//image
    	$image = "assets/images/customers/".basename($_FILES["image"]["name"]);

		//username
		$username = strip_tags($_POST['username']); 
		$username = str_replace(' ', '', $username); 
		$_SESSION['username'] = $username; 
		
		//password
		$password = strip_tags($_POST['password']); 

		//address
		$address = strip_tags($_POST['address']);
		$_SESSION['address'] = $address;

		//phone
		$phone = filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);//take only integer
	    $phone = str_replace("-", "", $phone); 

	    if (strlen($phone) < 11 || strlen($phone) > 14) {
	     array_push ($errorMessage,"Invalid Number");
	    }
	    
	    //check phone number already exist or not in database
		$check_phone_query = mysqli_query($con, "SELECT phone FROM users WHERE phone = '$phone'");
		$num_of_phones = mysqli_num_rows($check_phone_query);

		if($num_of_phones > 0){
			array_push ($errorMessage,"Phone Number already exist");
		} 
	    $_SESSION['phone'] = $phone; 		

		
		//check if email is in valid format 
		if (filter_var($email, FILTER_VALIDATE_EMAIL)){
			$email = filter_var($email, FILTER_VALIDATE_EMAIL);
			
			//Check if email already exist or not
			$email_check = mysqli_query($con, "SELECT email FROM users WHERE email = '$email'");
			//Count the number of rows returned
			
			$num_row = mysqli_num_rows($email_check);
			//print_r($num_row); exit;
			if($num_row > 0){
				array_push ($errorMessage,"Email already exist");
			}
		}else{
			array_push ($errorMessage,"Invalid Format");
		}
		
		if(preg_match('/[^A-Za-z0-9]/',$password)){
			array_push ($errorMessage,"Password should only contain english character or number");
		}
		
		if(strlen($password) < 5 ){
			array_push ($errorMessage,"Password must be more then 5 characters");
		}

		//check user already exist or not in database
		$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username = '$username'");
		$num_username = mysqli_num_rows($check_username_query);

		if($num_username > 0){
			array_push ($errorMessage,"Username already exist");
		}
    }
	

	if(empty($errorMessage)){
		$verification_key = md5(time().$username); //generate the varification key

		$password = md5($password); //encrypt password
		
		include 'helpers/mailSender.php';
      	$mail->addAddress($email, $name);
      	$mail->Subject = 'Account varification';
      	$mail->Body = "<html>
                    <head>
                      <style>
                        a{
                          background-color: #4CAEC8;
                          border: none;
                          color: white !important;
                          padding: 15px 32px;
                          text-align: center;
                          text-decoration: none;
                          display: inline-block;
                          font-size: 16px;
                          border-radius: 5px;
                        }
                      </style>
                    </head>
                    <body>
                      <h2>You are almost done. Please click on the link below to complete your reigstration:</h2><br>
                      
                      <a href='http://localhost/farm_management/helpers/mailConfirmation.php?email=$email&verification_key=$verification_key'>Click Here</a>
                      
                    </body>
                    </html>";

      	if ($mail->send()){
        	$insert_query = mysqli_query($con, "INSERT INTO users VALUES('','$name','$gender','$image','$phone','$address',3,'$username','$email','$password','$verification_key',0)");

        	if ($insert_query) {
        		move_uploaded_file($_FILES["image"]["tmp_name"],$image);// save image on upload folder
				$_SESSION["SuccessMessage"] = "Your Registration almost complteted. Please verify you email";
				//header('Location:signup.php');

				//Clear session variables after submission
				$_SESSION['name'] = '';
				$_SESSION['gender'] = '';
				$_SESSION['phone'] = '';
				$_SESSION['address'] = '';
				$_SESSION['username'] = '';
				$_SESSION['email'] = '';
			}else{
				array_push ($errorMessage,"Date not saved");
			}
        }else{
				array_push ($errorMessage,"Please Check your email!!");
		}
	}		
}
?>
	<body>
		<?php include_once('template/header.php') ?>

		<!-- page header section ending here -->
        <section class="page-header padding-tb page-header-bg-1">
            <div class="container">
                <div class="page-header-item d-flex align-items-center justify-content-center">
                    <div class="post-content">
                        <h3>Registration</h3>
                        <div class="breadcamp">
                            <ul class="d-flex flex-wrap justify-content-center align-items-center">
                                <li><a href="index.php">Home</a> </li>
                                <li><a class="active">Signup</a></li>
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
                <div class="section-wrapper row">
                    <div class="col-lg-2 col-12">
                	</div>
                	<div class="col-lg-8 col-12">
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
                		<div class="contact-part">
                            <div class="contact-title">
                                <h4>Registration</h4>
                            </div>
                            <form action="" method="POST" enctype="multipart/form-data">
								<div class="form-group row">
				                    <label for="name" class="col-sm-2 col-form-label">Name</label>
				                    <div class="col-sm-10">
				                       <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="<?php if(isset($_SESSION['name'])) { echo $_SESSION['name']; }  ?>">
				                    </div>
				                </div>

				                <div class="form-group row">
									<label for="gender" class="col-sm-2 col-form-label">Gender</label>
									<div class="col-sm-10">
										<select class="form-control" id="gender" name="gender">
                                         <?php 
                                          if (isset($_SESSION['gender']) && $_SESSION['gender']=='Male') {
                                            echo "<option value='' style='color: black'>Select Gender</option>";
                                            echo "<option selected='' value='Male' style='color:black'>Male</option>";
                                            echo "<option value='Female' style='color:black'>Female</option>";
                                          }elseif (isset($_SESSION['gender']) && $_SESSION['gender']=='Female') {
                                            echo "<option value='' style='color: black'>Select Gender</option>";
                                            echo "<option value='Female' style='color:black'>Male</option>";
                                            echo "<option selected='' value='Female' style='color:black'>Female</option>";
                                          }else{ ?>
                                            <option value="" style="color: black">Select Gender</option>
                                            <option value='Male' style='color:black'>Male</option>
                                            <option value='Female' style='color:black'>Female</option>
                                          <?php }
                                        ?>
                                      </select>
									</div>
									
								</div>

								<div class="form-group row">
									<label for="phone" class="col-sm-2 col-form-label">Phone</label>
									<div class="col-sm-10">
										<input type="text" name="phone" class="form-control" id="phone" placeholder="Phone" value="<?php if(isset($_SESSION['phone'])) { echo $_SESSION['phone']; }  ?>">
									</div>
								</div>

								<div class="form-group row">
									<label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
									<div class="col-sm-10">
										<input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email" value="<?php if(isset($_SESSION['email'])) { echo $_SESSION['email']; }  ?>">
									</div>
								</div>

								<div class="form-group row">
									<label for="address" class="col-sm-2 col-form-label">Address</label>
									<div class="col-sm-10">
										<input type="text" name="address" class="form-control" id="address" placeholder="Address" value="<?php if(isset($_SESSION['address'])) { echo $_SESSION['address']; }  ?>">
									</div>
								</div>

								<div class="form-group row">
									<label for="image" class="col-sm-2 col-form-label">Image</label>
									<div class="col-sm-10">
										<input type="file" name="image" class="form-control" id="image" placeholder="Address" value="<?php if(isset($_SESSION['image'])) { echo $_SESSION['image']; }  ?>">
									</div>
								</div>

								<div class="form-group row">
									<label for="username" class="col-sm-2 col-form-label">Username</label>
									<div class="col-sm-10">
										<input type="text" name="username" class="form-control" id="username" placeholder="Username" value="<?php if(isset($_SESSION['username'])) { echo $_SESSION['username']; }  ?>">
									</div>
								</div>

								<div class="form-group row">
									<label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
									<div class="col-sm-10">
										<input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
									</div>
								</div>
								<button type="submit" name="submit" class="btn btn-primary">Submit</button>
							</form>
                        </div>
                	</div>                    
                </div>
            </div>
        </div>
		<!-- contact us section ending here -->
		
		
		<!-- footer section start here -->
		<?php include_once('template/footer.php'); ?>
		<!-- footer section start here -->


		
		<?php include_once('template/script.php');?>
	</body>
</html>