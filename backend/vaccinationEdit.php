<?php 
$title = 'Edit Vacctination data';
include_once('template/head.php'); 

if (isset($_GET['vacci_id'])) {
    $vacci_id = $_GET['vacci_id'];

    $vaccinations = mysqli_query($con, "SELECT * FROM vaccinations WHERE id='$vacci_id'");
    $vacci = mysqli_fetch_array($vaccinations);

	$errorMessage = array();
	if(isset($_POST['update'])){
		if (empty($_POST['vaccine_id']) ||  empty($_POST['cow_id']) || empty($_POST['vaccined_date']) || empty($_POST['next_vaccined_date']) ) {
			array_push ($errorMessage,"All field must be field out");
	    }
		// vaccine_id
		$vaccine_id = strip_tags($_POST['vaccine_id']); 
		$vaccine_id = str_replace(' ', '', $vaccine_id);  
		$_SESSION['ve_vaccine_id'] = $vaccine_id; 

		//cow_id
		$cow_id = strip_tags($_POST['cow_id']); 
		$cow_id = str_replace(' ', '', $cow_id); 
		$_SESSION['ve_cow_id'] = $cow_id; 

		//vaccined_date
		$vaccined_date = strip_tags($_POST['vaccined_date']); 
		$vaccined_date = str_replace(' ', '', $vaccined_date); 
		$_SESSION['ve_vaccined_date'] = $vaccined_date; 

		//next_vaccined_date
		$next_vaccined_date = strip_tags($_POST['next_vaccined_date']); 
		$next_vaccined_date = str_replace(' ', '', $next_vaccined_date); 
		$_SESSION['ve_next_vaccined_date'] = $next_vaccined_date; 	

		$current_date = date('Y-m-d');

	    //check data already added today or not
	    $check_date = mysqli_query($con, "SELECT vaccined_date, cow_id, vaccine_id FROM vaccinations WHERE vaccined_date='$current_date' ");
	    $check = mysqli_fetch_array($check_date);
	    if ( mysqli_num_rows($check_date) > 0 && $check['vaccined_date'] == $current_date && $check['cow_id']==$cow_id && $check['vaccine_id'] == $vaccine_id ) {
	    	array_push ($message_array,"Data already recoded today");
	    }

		if(empty($errorMessage)){		
			$update = mysqli_query($con, "UPDATE vaccinations SET vaccine_id='$vaccine_id', cow_id='$cow_id', quantity='$quantity', vaccined_date='$vaccined_date', next_vaccined_date='$next_vaccined_date' WHERE id='$vacci_id'");
			if ($update) {

				$oldStock = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM vaccines WHERE id='$vaccine_id'"));
		        $preStock = $oldStock['stock'] + $vacci['quantity'];
		        $newStock = $preStock - $quantity;
		        mysqli_query($con,"UPDATE vaccines SET stock='$newStock' WHERE id='$vaccine_id'");

				$_SESSION["SuccessMessage"] = "Vacctination data Updated successfully";
				header('Location:vaccinationList.php');

				//Clear session variables after submission
				$_SESSION['ve_vaccine_id'] = null;
				$_SESSION['ve_cow_id'] = null;
				$_SESSION['ve_vaccined_date'] = null;
				$_SESSION['ve_next_vaccined_date'] = null;
			}else{
				array_push ($errorMessage,"Date not saved");
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
			              <li class="breadcrumb-item active">Vaccination Edit</li>
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
				                <h3 class="card-title">Vaccination Edit</h3>
				              </div>
				              <!-- /.card-header -->
				              <!-- form start -->
				              	<form class="form-horizontal" action="" method="POST">
					                <div class="card-body">
					                	<div class="form-group row">
					                        <label class="col-sm-2 col-form-label">Vaccine Id</label>
					                        <div class="col-sm-10">
						                        <select name="vaccine_id" class="form-control" id="role">
						                        	<option value="">Select Vaccine Id</option>
						                          	<?php
														//get plant plat Type
														$vaccines = mysqli_query($con,"SELECT * FROM vaccines");
														foreach ($vaccines as $key => $vaccine) {
															$vaccineId = $vaccine['id'];
															$vaccine_name = $vaccine['name'];
															if (isset($_SESSION['ve_vaccine_id']) && $_SESSION['ve_vaccine_id']==$vaccineId) {
											                  echo "<option selected value='$vaccineId'>$vaccine_name</option>";
											                }elseif (isset($vacci['vaccine_id']) && $vacci['vaccine_id']==$vaccineId) {
											                	echo "<option selected value='$vaccineId'>$vaccine_name</option>";
											                }else{
														?>
														<option value="<?php echo $vaccineId ?>"><?php echo $vaccine_name ?></option>
													<?php } } ?>
						                        </select>
						                    </div>
				                      	</div>

							            <div class="form-group row">
					                        <label class="col-sm-2 col-form-label">Cow Id</label>
					                        <div class="col-sm-10">
						                        <select name="cow_id" class="form-control" id="role">
						                        	<option value="">Select Cow Id</option>
						                          	<?php
														//get plant plat Type
														$cows = mysqli_query($con,"SELECT * FROM cows");
														foreach ($cows as $key => $cow) {
															$cow_id = $cow['id'];
															$cow_unique_id = $cow['unique_id'];
															if (isset($_SESSION['ve_cow_id']) && $_SESSION['ve_cow_id']==$cow_id) {
											                  echo "<option selected value='$cow_id'>$cow_unique_id</option>";
											                }elseif (isset($vacci['cow_id']) && $vacci['cow_id']==$cow_id) {
											                	echo "<option selected value='$cow_id'>$cow_unique_id</option>";
											                }else{
														?>
														<option value="<?php echo $cow_id ?>"><?php echo $cow_unique_id ?></option>
													<?php } } ?>
						                        </select>
						                    </div>
				                      	</div>

				                      	<div class="form-group row">
						                    <label for="vaccined_date" class="col-sm-2 col-form-label">Vaccined Date</label>
						                    <div class="col-sm-10">
						                      <input type="text" name="vaccined_date" class="form-control" id="vaccined_date" placeholder="Vaccined Date" value="<?php if(isset($_SESSION['ve_vaccined_date'])) { echo $_SESSION['ve_vaccined_date']; }else{
	                                                    echo $vacci['vaccined_date'];
	                                                }  ?>">
						                    </div>
						                </div>

						                <div class="form-group row">
						                    <label for="next_vaccined_date" class="col-sm-2 col-form-label">Next Vaccination Date</label>
						                    <div class="col-sm-10">
						                      <input type="text" name="next_vaccined_date" class="form-control" id="next_vaccined_date" placeholder="Next Vaccined Date" value="<?php if(isset($_SESSION['ve_next_vaccined_date'])) { echo $_SESSION['ve_next_vaccined_date']; }else{
	                                                    echo $vacci['next_vaccined_date'];
	                                                }  ?>">
						                    </div>
						                </div>
			                		</div>
					                <!-- /.card-body -->
					                <div class="card-footer">
					                  <button type="submit" name="update" class="btn btn-info">Update</button>
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
	<?php 
}else{
        header('location:cowList.php');
}