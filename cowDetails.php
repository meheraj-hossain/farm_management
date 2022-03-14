<?php include_once('template/head.php');
if (isset($_GET['CID'])) {
	$cowID = $_GET['CID'];
	$cow_data = mysqli_fetch_array(mysqli_query($con, "SELECT * FROM `saleable_cows` JOIN cows ON saleable_cows.cow_id = cows.unique_id WHERE cows.unique_id='$cowID' ")); 
    $cid = $cow_data['id'];

	if (isset($_POST['dcode'])) {
        
		$code = $_POST['discount_code'];
        //echo $code; exit();
		$getDiscount = mysqli_query($con, "SELECT amount FROM discount_codes WHERE code='$code' AND cow_id='$cid'");
		$Discount = mysqli_fetch_array($getDiscount);
		$num_discount = mysqli_num_rows($getDiscount);
	}

	?>
	<body>
		<?php include_once('template/header.php') ?>

		<!-- page header section ending here -->
        <section class="page-header padding-tb page-header-bg-1">
            <div class="container">
                <div class="page-header-item d-flex align-items-center justify-content-center">
                    <div class="post-content">
                        <h3>Cow Details</h3>
                        <div class="breadcamp">
                            <ul class="d-flex flex-wrap justify-content-center align-items-center">
								<li><a href="index.php">Home</a></li>
                                <li><a class="active">Cow Details</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- page header section ending here -->

		<!-- Shop Page Section start here -->		            
		<section class="shop-single padding-tb">
			<div class="container">
				<div class="row">
					<div class="col-lg-12 col-12 sticky-widget">
						<div class="product-details">
							<div class="row">
								<div class="col-md-6 col-12">
									<div class="product-thumb">
										<div class="slider-for">
											<div class="thumb">
												<img id="myimage" src="backend/<?=$cow_data['image1']?>" alt="shopZoom">
											</div>
											
											<div class="thumb">
												<img id="myimage2" src="backend/<?=$cow_data['image2']?>" alt="shopZoom">
											</div>
											<div class="thumb">
												<img id="myimage3" src="backend/<?=$cow_data['image3']?>" alt="shopZoom">
											</div>
											
										</div>
										<div class="slider-nav">
											<div class="thumb">
												<img src="backend/<?=$cow_data['image1']?>" alt="shopZoom" alt="shop">
											</div>
											<div class="thumb">
												<img src="backend/<?=$cow_data['image2']?>" alt="shop">
											</div>
											<div class="thumb">
												<img src="backend/<?=$cow_data['image3']?>" alt="shop">
											</div>
											
										</div>
									</div>
								</div>
								
									<div class="col-md-6 col-12">
										
										<div class="post-content">
											<h4>Cow:</h4> <?=$cow_data['unique_id']?>
											
											<h4>Price:</h4> 
											<?php if (isset($num_discount) && $num_discount>0) {
												echo $Discount['amount'] . ' BDT &nbsp;';
												echo '<del>'.$cow_data['price'].'</del>';
											}else{
												echo $cow_data['price'];
											} ?> BDT
											<h5>
												Product Description
											</h5>
											<p>
												<?=$cow_data['description']?>
											</p>
											<?php if (isset($_SESSION['logged_username']) && $cow_data['status'] ==1) { ?>
												<form action="" method="POST">
													<div class="discount-code">
														<h5>
															Discount Code
														</h5>
														<?php if (isset($num_discount) && $num_discount ==0) {
																echo "<h6 style='color:red'>Invalid Code</h6>";
															}
														?>
														<div class="row">
															<input type="text" class="col-md-6" name="discount_code" placeholder="Enter Discount Code">
															<input name="dcode" class="btn btn-success col-md-4" style="margin: 0 0 0 10px; max-height: 46px" type="submit" value="Apply">
														</div>
													</div>
												</form>
										<?php } ?>
										</div>
										<br>
										<?php if (isset($_SESSION['logged_username'])) { ?>
											<form action="checkout.php" method="POST">
												<?php if (isset($num_discount) && $num_discount>0) { ?>
													<input type="hidden" name="cow_price"  value="<?=$Discount['amount']?>" />
													<input type="hidden" name="discount_code"  value="<?=$code?>" />
												<?php }else{ ?>
													<input type="hidden" name="cow_price" value="<?=$cow_data['price']?>" />
												<?php } ?>
												<input type="hidden" name="CowId" value="<?=$cow_data['unique_id']?>" />
												<?php if ($cow_data['status'] ==1) {
													echo '<input style="width: 100%" name="submit" type="submit" value="Proceed" class="btn btn-success">';
												}else{
													echo '<input style="width: 100%" readonly="" type="button" value="Sold Out" class="btn btn-danger">';
												} ?>
												
											</form>
										<?php }else{
											echo '<a href="login.php" class="btn btn-success">Please Login</a>';
										} ?>
 										
									</div>
								
							</div>
						</div>
						
					</div>
					
				</div>
			</div>
		</section>
		<!-- Shop Page Section ending here -->
    
		<!-- footer section start here -->
		<?php include_once('template/footer.php'); ?>
		<!-- footer section start here -->


		
		<?php include_once('template/script.php');?>
	</body>


</html>
<?php 
}else{
	header('Location:cows.php');
}
 ?>
	