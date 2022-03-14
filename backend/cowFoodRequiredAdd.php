<?php 
$title = 'Add Per day cow required food';
include_once('template/head.php'); 

$errorMessage = array();
	
if(isset($_POST['submit'])){
	if (empty($_POST['category_id']) || empty($_POST['min_age']) || empty($_POST['max_age']) || empty($_POST['food_id']) || empty($_POST['quantity']) ) {
		array_push ($errorMessage,"All field must be field out");
    }
	//cow_category_id
	$cow_category_id = strip_tags($_POST['category_id']); 
	$cow_category_id = str_replace(' ', '', $cow_category_id); 
	$_SESSION['category_id'] = $cow_category_id; 

	//min_age
	$min_age = strip_tags($_POST['min_age']); 
	$min_age = str_replace(' ', '', $min_age); 
	$_SESSION['min_age'] = $min_age; 

	//max_age
	$max_age = strip_tags($_POST['max_age']); 
	$max_age = str_replace(' ', '', $max_age); 
	$_SESSION['max_age'] = $max_age; 

	//max_age
	$food_id = strip_tags($_POST['food_id']); 
	$food_id = str_replace(' ', '', $food_id); 
	$_SESSION['food_id'] = $food_id;

	//max_age
	$quantity = strip_tags($_POST['quantity']); 
	$quantity = str_replace(' ', '', $quantity); 
	$_SESSION['quantity'] = $quantity; 		
	

	if(empty($errorMessage)){		
		$insert = mysqli_query($con, "INSERT INTO cow_food_required_perday VALUE('', '$cow_category_id', '$min_age', '$max_age', '$food_id','$quantity')");
		if ($insert) {
			$_SESSION["SuccessMessage"] = "New requried food data added successfully";
			header('Location:cowFoodRequiredList.php');
		}else{
			array_push ($errorMessage,"Date not saved");
		}
		
		//Clear session variables after submission
		$_SESSION['cow_category_id'] = null;
		$_SESSION['min_age'] = null;
		$_SESSION['max_age'] = null;
		$_SESSION['food_id'] = null;
		$_SESSION['quantity'] = null;
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
              <li class="breadcrumb-item active">Cow Food Required Per Day Add</li>
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
	                <h3 class="card-title">Cow Food Required Per Day Add</h3>
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
										
										if (isset($_SESSION['category_id']) && $_SESSION['category_id']==1) {
						                  echo "<option selected value='1'>Cow for Sell</option>";
						                  echo "<option value='2'>Cow for Milk</option>";
						                }elseif (isset($_SESSION['category_id']) && $_SESSION['category_id']==2) {
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
											$food_id = $cf['id'];
											$food_name = $cf['name'];
											if (isset($_SESSION['food_id']) && $_SESSION['food_id']==$food_id) {
							                  echo "<option selected value='$food_id'>$food_name</option>";
							                }else{
										?>
										<option value="<?php echo $food_id ?>"><?php echo $food_name ?></option>
									<?php } } ?>
		                        </select>
		                    </div>
                      	</div>

		                <div class="form-group row">
		                    <label for="min_age" class="col-sm-2 col-form-label">Minimum Cow Age</label>
		                    <div class="col-sm-10">
		                      <input type="number" min="0" step="1" name="min_age" class="form-control" id="min_age" placeholder="Minimum Cow Age" value="<?php if(isset($_SESSION['min_age'])) { echo $_SESSION['min_age']; }  ?>">
		                    </div>
		                </div>	

		                <div class="form-group row">
		                    <label for="max_age" class="col-sm-2 col-form-label">Maximum Cow Age</label>
		                    <div class="col-sm-10">
		                      <input type="number" min="0" step="1" name="max_age" class="form-control" id="max_age" placeholder="Maximam Cow Age" value="<?php if(isset($_SESSION['max_age'])) { echo $_SESSION['max_age']; }  ?>">
		                    </div>
		                </div>	

		                <div class="form-group row">
		                    <label for="quantity" class="col-sm-2 col-form-label">Quantity (kg)</label>
		                    <div class="col-sm-10">
		                      <input type="number" min="0" step="0.25" name="quantity" class="form-control" id="quantity" placeholder="Entry Date" value="<?php if(isset($_SESSION['quantity'])) { echo $_SESSION['quantity']; }  ?>">
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