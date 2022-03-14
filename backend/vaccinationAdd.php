<?php 
$title = 'Buy cow food';
include_once('template/head.php'); 

$errorMessage = array();
	
if(isset($_POST['submit'])){
	if (empty($_POST['vaccine_id']) ||  empty($_POST['cow_id']) || empty($_POST['quantity']) || empty($_POST['vaccined_date']) ) {
		array_push ($errorMessage,"All field must be field out");
    }
	// vaccine_id
	$vaccine_id = strip_tags($_POST['vaccine_id']); 
	$vaccine_id = str_replace(' ', '', $vaccine_id); 
	$_SESSION['va_vaccine_id'] = $vaccine_id; 
	
	//cow_id
	$cow_id = strip_tags($_POST['cow_id']); 
	$cow_id = str_replace(' ', '', $cow_id); 
	$_SESSION['va_cow_id'] = $cow_id; 

	//quantity
	$quantity = strip_tags($_POST['quantity']); 
	$quantity = str_replace(' ', '', $quantity); 
	$_SESSION['va_quantity'] = $quantity; 

	//vaccined_date
	$vaccined_date = strip_tags($_POST['vaccined_date']); 
	$vaccined_date = str_replace(' ', '', $vaccined_date); 
	$_SESSION['va_vaccined_date'] = $vaccined_date; 

	
    $current_date = date('Y-m-d');

	//check data already added today or not
	$check_date = mysqli_query($con, "SELECT vaccined_date, cow_id, vaccine_id FROM vaccinations WHERE vaccined_date<='$current_date' AND vaccine_id = '$vaccine_id' AND cow_id='$cow_id' ");
    $check = mysqli_fetch_array($check_date);
    if ( mysqli_num_rows($check_date) > 0 ) {
    	array_push ($errorMessage,"This Cow has this vaccine before");
    }
	

	if(empty($errorMessage)){
		if (!empty($_POST['next_vaccined_date'])) {
			//next_vaccined_date
			$next_vaccined_date = strip_tags($_POST['next_vaccined_date']); 
			$next_vaccined_date = str_replace(' ', '', $next_vaccined_date); 
			$_SESSION['va_next_vaccined_date'] = $next_vaccined_date;

			$insert = mysqli_query($con, "INSERT INTO vaccinations VALUE('', '$vaccine_id', '$cow_id','$quantity','$vaccined_date', '$next_vaccined_date',0,0)"); 
		}else{
			$insert = mysqli_query($con, "INSERT INTO vaccinations VALUE('', '$vaccine_id', '$cow_id','$quantity','$vaccined_date', NULL,1,1)");
			
		}		
		
		if ($insert) {
			//update cow food stocks
			$oldStock = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM vaccines WHERE id='$vaccine_id'"));
			$newStock = $oldStock['stock'] - $quantity;
			mysqli_query($con,"UPDATE vaccines SET stock='$newStock' WHERE id='$vaccine_id' ");

			$_SESSION["SuccessMessage"] = "New data added successfully";
			header('Location:vaccinationList.php');

			//Clear session variables after submission
			$_SESSION['va_vaccine_id'] = "";
			$_SESSION['va_cow_id'] = "";
			$_SESSION['va_vaccined_date'] = "";
			$_SESSION['va_next_vaccined_date'] = "";
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
            <h1>Vaccination</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Vaccination Add</li>
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
	                <h3 class="card-title">Vaccination Add</h3>
	              </div>
	              <!-- /.card-header -->
	              <!-- form start -->
	              <form class="form-horizontal" action="" method="POST">
	                <div class="card-body">

		                <div class="form-group row">
	                        <label class="col-sm-2 col-form-label">Vaccine</label>
	                        <div class="col-sm-10">
		                        <select name="vaccine_id" class="form-control" id="role">
		                        	<option value="">Select Vaccine</option>
		                          	<?php
										//get plant plat Type
										$vaccines = mysqli_query($con,"SELECT * FROM vaccines");
										foreach ($vaccines as $key => $vac) {
											$vac_id = $vac['id'];
											$vac_name = $vac['name'];
											if (isset($_SESSION['va_vaccine_id']) && $_SESSION['va_vaccine_id']==$vac_id) {
							                  echo "<option selected value='$vac_id'>$vac_name</option>";
							                }else{
										?>
										<option value="<?php echo $vac_id ?>"><?php echo $vac_name ?></option>
									<?php } } ?>
		                        </select>
		                    </div>
                      	</div>

                      	<div class="form-group row">
	                        <label class="col-sm-2 col-form-label">Cow</label>
	                        <div class="col-sm-10">
		                        <select name="cow_id" class="form-control" id="role">
		                        	<option value="">Select Cow</option>
		                          	<?php
										//get plant plat Type
										$cows = mysqli_query($con,"SELECT * FROM cows");
										foreach ($cows as $key => $cow) {
											$c_id = $cow['id'];
											$cow_name = $cow['unique_id'];
											if (isset($_SESSION['va_vaccine_id']) && $_SESSION['va_vaccine_id']==$c_id) {
							                  echo "<option selected value='$c_id'>$cow_name</option>";
							                }else{
										?>
										<option value="<?php echo $c_id ?>"><?php echo $cow_name ?></option>
									<?php } } ?>
		                        </select>
		                    </div>
                      	</div>

                      	<div class="form-group row">
		                    <label for="quantity" class="col-sm-2 col-form-label">Quantity</label>
		                    <div class="col-sm-10">
		                      <input type="number" min="0" name="quantity" class="form-control" id="quantity" placeholder="Quantity" value="<?php if(isset($_SESSION['va_quantity'])) { echo $_SESSION['va_quantity']; }  ?>" >
		                    </div>
		                </div>

		                <div class="form-group row">
		                    <label for="vaccined_date" class="col-sm-2 col-form-label">Vaccined Date</label>
		                    <div class="col-sm-10">
		                      <input type="text" name="vaccined_date" class="form-control" id="vaccined_date" placeholder="Vaccined Date" value="<?php if(isset($_SESSION['va_vaccined_date'])) { echo $_SESSION['va_vaccined_date']; }  ?>">
		                    </div>
		                </div>	

		                <div class="form-group row">
		                    <label for="next_vaccined_date" class="col-sm-2 col-form-label">Next Vaccination Date</label>
		                    <div class="col-sm-10">
		                      <input type="text" name="next_vaccined_date" class="form-control" id="next_vaccined_date" placeholder="Next Vaccined Date" value="<?php if(isset($_SESSION['va_next_vaccined_date'])) { echo $_SESSION['va_next_vaccined_date']; }  ?>">
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

<link href="http://code.jquery.com/ui/1.11.3/themes/smoothness/jquery-ui.css" rel="stylesheet">
<script src="assets/plugins/jquery/jquery.js"></script>
<script src="assets/plugins/jquery-ui/jquery-ui.js"></script>
<script>
	$(document).ready(function (){
	 var maxDate = new Date();
	 $("#vaccined_date").datepicker({
		 showAnim: 'drop',
		 numberOfMonth: 1,
		 maxDate: maxDate,
		 dateFormat:'yy-mm-dd',
		 onClose: function(selectedDate){
		 $('#return').datepicker("option", "maxDate",selectedDate);
		 
		 }
	 });
	});
	
	$(document).ready(function (){
		 var minDate = new Date();
		 $("#next_vaccined_date").datepicker({
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