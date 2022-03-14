<?php 
$title = 'Discount Code Add';
include_once('template/head.php'); 
 if(isset($_SESSION['logged_user_id']) && $_SESSION['logged_user_type']==1){ 

$errorMessage = array();
	
if(isset($_POST['submit'])){
	if (empty($_POST['code']) || empty($_POST['cow_id']) || empty($_POST['amount'])) {
		array_push ($errorMessage,"All field must be field out");
    }
    //code
	$code = strip_tags($_POST['code']); 
	$code = str_replace(' ', '', $code); 
	$_SESSION['dc_code'] = $code; 

	//check code on database
	$check_cow = mysqli_query($con, "SELECT code FROM discount_codes WHERE code = '$code'");
	$d_code = mysqli_num_rows($check_cow);

	if($d_code > 0){
		array_push ($errorMessage,"This code already exist");
	}

	//cow_id
	$cow_id = strip_tags($_POST['cow_id']); 
	$cow_id = str_replace(' ', '', $cow_id); 
	$_SESSION['dc_cow_id'] = $cow_id; 

	//amount
	$amount = strip_tags($_POST['amount']); 
	$amount = str_replace(' ', '', $amount); 
	$_SESSION['dc_amount'] = $amount; 

	$email = $_POST['user_for'];    
	

	if(empty($errorMessage)){		
		$insert = mysqli_query($con, "INSERT INTO discount_codes VALUE('', '$code', '$cow_id', '$amount')");
		if ($insert) {
			include '../helpers/mailSender.php';
	      	$mail->addAddress($email);
	      	$mail->Subject = 'Discount Code';
	      	$mail->Body = "<html>
	                    <head>
	                    </head>
	                    <body>
	                      <h2>Discount Code</h2><br>
	                      <h3>Your discount Code is: ".$code."</h3><br>
	                      
	                      Thanks,
	                      Gowala.
	                      
	                    </body>
	                    </html>";
	        $mail->send();
			$_SESSION["SuccessMessage"] = "Data added successfully";
			header('Location:discountCodeList.php');

			//Clear session variables after submission
			$_SESSION['dc_code'] = "";
			$_SESSION['dc_cow_id'] = "";
			$_SESSION['dc_amount'] = "";
		}else{
			array_push ($errorMessage,"Date not saved");
		}
	}		
}
?>
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js'></script>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <?php include_once('template/navbar.php'); 
  // navbar 

  // Main Sidebar Container 
  include_once('template/left_sidebar.php') ?>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Discount Code</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Discount Code Add</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      	<div class="container-fluid">
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
	          <!-- left column -->
	          <div class="col-md-12">
	    		<!-- Horizontal Form -->
	            <div class="card card-info">
	              <div class="card-header">
	                <h3 class="card-title">Discount Code Add</h3>
	              </div>
	              <!-- /.card-header -->
	              <!-- form start -->
	              <form class="form-horizontal" action="" method="POST">
	                <div class="card-body">

	                	<div class="form-group row">
		                    <label for="code" class="col-sm-2 col-form-label">Discount Code</label>
		                    <div class="col-sm-10">
		                      <input type="text" name="code" class="form-control" id="code" placeholder="Discount Code" value="<?php if(isset($_SESSION['dc_code'])) { echo $_SESSION['dc_code']; }  ?>">
		                    </div>
		                </div>

		                <div class="form-group row">
		                  	<label class="col-sm-2 col-form-label">Cow Id</label>
		                  	<div class="col-sm-10">
		                  	<select class="select2bs4" name="cow_id" style="width: 100%;">
			                    <option selected="selected" value="">Select Cow</option>
			                    <?php
										//get plant plat Type
										$cows = mysqli_query($con,"SELECT * FROM `saleable_cows` JOIN cows ON saleable_cows.cow_id = cows.unique_id WHERE cows.status=1");
										foreach ($cows as $key => $cow) {
											$cow_id = $cow['cow_id'];
                                            $unique_id = $cow['unique_id'];
											if (isset($_SESSION['dc_cow_id']) && $_SESSION['dc_cow_id']==$cow_id) {
							                  echo "<option selected value='$cow_id'>$unique_id</option>";
							                }else{
										?>
										<option value="<?php echo $cow_id ?>"><?php echo $unique_id ?></option>
									<?php } } ?>
		                  	</select>
		                  </div>
		                </div>

		                <div class="form-group row">
		                    <label for="amount" class="col-sm-2 col-form-label">Amount</label>
		                    <div class="col-sm-10">
		                      <input type="number" min="0" name="amount" class="form-control" id="amount" placeholder="Amount After Discount" value="<?php if(isset($_SESSION['dc_amount'])) { echo $_SESSION['dc_amount']; }  ?>" >
		                    </div>
		                </div>  

		                <div class="form-group row">
		                  	<label class="col-sm-2 col-form-label">User For</label>
		                  	<div class="col-sm-10">
		                  	<select class="select2bs4" name="user_for" style="width: 100%;">
			                    <option value="">Select User</option>
			                    <?php
										//get plant plat Type
										$users = mysqli_query($con,"SELECT * FROM users WHERE verified=1 AND role=3");
										foreach ($users as $key => $user) {
											$username = $user['username'];
											$email = $user['email'];
											if (isset($_SESSION['dc_cusername']) && $_SESSION['dc_username']==$username) {
							                  echo "<option selected value='$email'>$username</option>";
							                }else{
										?>
										<option value="<?php echo $email ?>"><?php echo $username ?></option>
									<?php } } ?>
		                  	</select>
		                  </div>
		                </div>             
	                   	
	                </div>
	                <!-- /.card-body -->
	                <div class="card-footer">
	                  <button type="submit" name="submit" class="btn btn-info">Submit</button>
	                  <button type="submit" class="btn btn-default float-right">Cancel</button>
	                </div>
	                <!-- /.card-footer -->
	              </form>
	            </div>
	            <!-- /.card -->

	          </div>
			</div>
	        <!-- /.row -->
      	</div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->


</div>
  <!-- /.content-wrapper -->
<?php include_once('template/footer.php'); ?>


<script>

$(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })
})
</script> 

<?php }else{
	header('Location:loin.php');
}
?>

  
