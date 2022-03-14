<?php

include_once('template/head.php');

if(isset($_SESSION['logged_username']) & !empty($_SESSION['logged_username'])){
        header("Location: index.php");
    }

$errorMessage= array();

if (isset($_POST["login"])) {
    $email = mysqli_real_escape_string($con,$_POST["email"]); 
    $_SESSION['atm_user'] = $email; 
    $password = md5($_POST["password"]);
  

    if(empty($email) || empty($password)){
      array_push($errorMessage, "All Field must be filled out");
    }else{
        //Check account verified or not
        $check_user = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password='$password' AND role=3");
        $check_found = mysqli_num_rows($check_user); 

        $row = mysqli_fetch_array($check_user);

        if ($check_found == 1 && $row['verified'] == 0) {
            array_push($errorMessage, "Please Verifiy your account.");
        }else if($check_found == 1 && $row['verified'] == 1){
            $_SESSION['atm_user'] = "";
            

            $_SESSION['logged_username'] = $row['username'];
            $_SESSION['logged_user_id'] = $row['id'];
            header("location: index.php");
        }else{
            array_push($errorMessage, "Email or Password was incorrect");
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
                        <h3>Loign</h3>
                        <div class="breadcamp">
                            <ul class="d-flex flex-wrap justify-content-center align-items-center">
                                <li><a href="index.php">Home</a> </li>
                                <li><a class="active">Login</a></li>
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
                        <!-- show error message -->
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
                                <h4>Login</h4>
                            </div>
                            <form action="" method="POST">
                                <div class="contact-form d-flex flex-wrap justify-content-between">
                                    <input type="email" name="email" placeholder="Your Email" <?php if (isset($_SESSION['atm_user'])) {
                                        echo $_SESSION['atm_user'];
                                    }?> >
                                    <input type="password" name="password" placeholder="Password">
                                    
                                    <input class="btn" type="submit" name="login" value="Login"><br>
                                                  
                                    <h4>Don't Have Account? <a href="signup.php" style="text-decoration: underline; color: #00a8ff">SIGNUP</a></h4>
                                    
                                </div>
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