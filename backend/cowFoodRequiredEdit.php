<?php 
$title = 'Add Per day cow required food';
include_once('template/head.php'); 


if (isset($_GET['CRF_id'])) {
    $CRF_id = $_GET['CRF_id'];

    $food_requireds = mysqli_query($con, "SELECT * FROM cow_food_required_perday WHERE id='$CRF_id'");
    $required_food = mysqli_fetch_array($food_requireds);

	$errorMessage = array();
	
	if(isset($_POST['submit'])){
		if (empty($_POST['category_id']) || empty($_POST['min_age']) || empty($_POST['max_age']) || empty($_POST['food_id']) || empty($_POST['quantity']) ) {
			array_push ($errorMessage,"All field must be field out");
	    }
		//cow_category_id
		$cow_category_id = strip_tags($_POST['category_id']); 
		$cow_category_id = str_replace(' ', '', $cow_category_id); 
		$_SESSION['cfr_category_id'] = $cow_category_id; 

		//min_age
		$min_age = strip_tags($_POST['min_age']); 
		$min_age = str_replace(' ', '', $min_age); 
		$_SESSION['cfr_min_age'] = $min_age; 

		//max_age
		$max_age = strip_tags($_POST['max_age']); 
		$max_age = str_replace(' ', '', $max_age); 
		$_SESSION['cfr_max_age'] = $max_age; 

		//food_id
		$food_id = strip_tags($_POST['food_id']); 
		$food_id = str_replace(' ', '', $food_id); 
		$_SESSION['cfr_food_id'] = $food_id;

		//quantity
		$quantity = strip_tags($_POST['quantity']); 
		$quantity = str_replace(' ', '', $quantity); 
		$_SESSION['cfr_quantity'] = $quantity; 		
		

		if(empty($errorMessage)){
			$update = mysqli_query($con, "UPDATE cow_food_required_perday SET cow_category_id='$cow_category_id', min_age='$min_age', max_age='$max_age', food_id='$food_id', quantity='$quantity' WHERE id='$CRF_id'");

			if ($update) {
				$_SESSION["SuccessMessage"] = "Required Food Set successfully";
				header('Location:cowFoodRequiredList.php');

				//Clear session variables after submission
				$_SESSION['cfr_cow_category_id'] = null;
				$_SESSION['cfr_min_age'] = null;
				$_SESSION['cfr_max_age'] = null;
				$_SESSION['cfr_food_id'] = null;
				$_SESSION['cfr_quantity'] = null;
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
	            <h1>Cow Food Required Per Day</h1>
	          </div>
	          <div class="col-sm-6">
	            <ol class="breadcrumb float-sm-right">
	              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
	              <li class="breadcrumb-item active">Cow Food Required Per Day Edit</li>
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
		                <h3 class="card-title">Cow Food Required Per Day Edit</h3>
		              </div>
		              <!-- /.card-header -->
		              <!-- form start -->
		              <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
		                <div class="card-body">

			                <div class="form-group row">
		                        <label class="col-sm-2 col-form-label">Cow Category</label>
		                        <div class="col-sm-10">
			                        <select name="category_id" class="form-control" id="role">
			                        	<option value="">Select Cow Category</option>
			                          		<?php
											
											if (isset($_SESSION['cfr_category_id']) && $_SESSION['cfr_category_id']==1) {
							                  echo "<option selected value='1'>Cow for Sell</option>";
							                  echo "<option value='2'>Cow for Milk</option>";
							                }elseif (isset($_SESSION['cfr_category_id']) && $_SESSION['ce_cacfr_category_idtegory_id']==2) {
							                  echo "<option value='1'>Cow for Sell</option>";
							                  echo "<option selected value='2'>Cow for Milk</option>";
							                }elseif (isset($cow['cow_category_id']) && $cow['cow_category_id']==1) {
							                  echo "<option selected value='1'>Cow for Sell</option>";
							                  echo "<option value='2'>Cow for Milk</option>";
							                }elseif (isset($cow['cow_category_id']) && $cow['cow_category_id']==2) {
							                  echo "<option value='1'>Cow for Sell</option>";
							                  echo "<option selected value='2'>Cow for Milk</option>";
							                }else{
											?>
											<option value="1">Cow for Sell</option>
											<option value="2">Cow for Milk</option>
										<?php } ?>
			                        </select>
			                    </div>
	                      	</div>

	                      	<div class="form-group row">
		                        <label class="col-sm-2 col-form-label">Cow Food</label>
		                        <div class="col-sm-10">
			                        <select name="food_id" class="form-control" id="role">
			                        	<option value="">Select Cow Food</option>
			                          	<?php
											//get plant plat Type
											$cow_foods = mysqli_query($con,"SELECT * FROM cow_foods");
											foreach ($cow_foods as $cf) {
												$cfood_id = $cf['id'];
												$cfood_name = $cf['name'];
												if (isset($_SESSION['cfr_food_id']) && $_SESSION['cfr_food_id'] !=null && $_SESSION['cfr_food_id']==$cfood_id) {
													
								                  echo "<option selected value='$cfood_id'>$cfood_name</option>";
								                }elseif (isset($required_food['food_id']) && $required_food['food_id']==$cfood_id) {
								                	echo "<option selected value='$cfood_id'>$cfood_name</option>";
								                }else{
											?>
											<option value="<?php echo $cfood_id ?>"><?php echo $cfood_name ?></option>
										<?php } } ?>
			                        </select>
			                    </div>
	                      	</div>

			                <div class="form-group row">
			                    <label for="min_age" class="col-sm-2 col-form-label">Minimum Cow Age</label>
			                    <div class="col-sm-10">
			                      <input type="number" min="0" step="1" name="min_age" class="form-control" id="min_age" placeholder="Entry Date" value="<?php if(isset($_SESSION['cfr_min_age'])) { echo $_SESSION['cfr_min_age']; }else{
                                                    echo $required_food['min_age'];
                                                }  ?>">
			                    </div>
			                </div>	

			                <div class="form-group row">
			                    <label for="max_age" class="col-sm-2 col-form-label">Maximum Cow Age</label>
			                    <div class="col-sm-10">
			                      <input type="number" min="0" step="1" name="max_age" class="form-control" id="max_age" placeholder="Entry Date" value="<?php if(isset($_SESSION['cfr_max_age'])) { echo $_SESSION['cfr_max_age']; }else{
                                                    echo $required_food['max_age'];
                                                }  ?>">
			                    </div>
			                </div>	

			                <div class="form-group row">
			                    <label for="quantity" class="col-sm-2 col-form-label">Quantity (kg)</label>
			                    <div class="col-sm-10">
			                      <input type="number" min="0" step="0.25" name="quantity" class="form-control" id="quantity" placeholder="Entry Date" value="<?php if(isset($_SESSION['cfr_quantity'])) { echo $_SESSION['cfr_quantity']; }else{
                                                    echo $required_food['quantity'];
                                                }  ?>">
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
<?php }else{
        header('location:cowFoodRequiredList.php');
}