<?php
include_once('template/head.php');
if(isset($_SESSION['logged_username']) & !empty($_SESSION['logged_username'])){
	$username = $_SESSION['logged_username']; 
	$getUserData = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM users WHERE username='$username'"));

	$customer_name = $getUserData['name'];
	$customer_phone = $getUserData['phone'];
	$customer_email = $getUserData['email']; 

	if (isset($_POST['request'])) {
		$request_date = date('Y-m-d');

		$milk_quantity = $_POST['milk_quantity'];
		$milk_required_at = $_POST['milk_required_at'];


		$send_request = mysqli_query($con, "INSERT INTO milk_requests VALUE('','$customer_name','$customer_email','$customer_phone','$milk_quantity','$request_date','$milk_required_at',1)");
		if ($send_request) {
			$_SESSION["SuccessMessage"] = "Milk Request Sent. Please keep in touch with your email";

			//insert notification
			mysqli_query($con,"INSERT INTO notifications VALUE('','Milk Request', '$customer_name is request for Milk','milkRequestList.php',0,0)");
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
                        <h3>Request For Milk</h3>
                        <div class="breadcamp">
                            <ul class="d-flex flex-wrap justify-content-center align-items-center">
								<li><a href="index.php">Home</a></li>
                                <li><a class="active">Milk Request</a></li>
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
                    <div class="col-lg-8 col-12">
                    	<?php echo SuccessMessage() ?>
                        <div class="contact-part">
                            <div class="contact-title">
                                <h4>Send Request for milk</h4>
                            </div>
                            <form action="" method="POST">
	                            <div class="contact-form d-flex flex-wrap justify-content-between">
	                                <input type="number" min="0" step="0.01" name="milk_quantity" placeholder="Milk Quantity">
	                                <input type="text" id="milk_required_at" name="milk_required_at" placeholder="Milk Required date">
	                                
	                                <input class="btn" name="request" type="submit" value="Send Request">
	                            </div>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-4 col-12">
						<div class="contact-info">
							<h3>Quick Contact</h3>
							<p>Continually productize compelling quality dome
							packed with all Elated Themes ently utilize 
							website and creating pages corporate </p>
							<ul class="contact-location">
								<li>
									<div class="icon-part">
										<i class="fas fa-phone-volume"></i>
									</div>
									<div class="content-part">
										<p>+88130-589-745-6987</p>
										<p>+1655-456-523</p>
									</div>
								</li>
								<li>
									<div class="icon-part">
										<i class="fas fa-clock"></i>
									</div>
									<div class="content-part">
										<p>Mon - Fri 09:00 - 18:00</p>
										<p>(except public holidays)</p>
									</div>
								</li>
								<li>
									<div class="icon-part">
										<i class="fas fa-map-marker-alt"></i>
									</div>
									<div class="content-part">
										<p>25/2 Lane2 Vokte Street Building <br>Melborn City</p>
									</div>
								</li>
							</ul>
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
	