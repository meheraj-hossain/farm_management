<?php 
$title = 'Saleable Cow Add';
include_once('template/head.php'); 

$errorMessage = array();
	
if(isset($_POST['submit'])){
	if (empty($_POST['cow_id']) || empty($_POST['price'])) {
		array_push ($errorMessage,"All field must be field out");
    }
    //cow_id
	$cow_id = strip_tags($_POST['cow_id']); 
	$cow_id = str_replace(' ', '', $cow_id); 
	$_SESSION['sc_cow_id'] = $cow_id; 


    $check_cows = mysqli_query($con,"SELECT cow_id FROM saleable_cows WHERE cow_id='$cow_id' ");
    $numOfRow = mysqli_num_rows($check_cows);
    if ($numOfRow > 0) {
    	array_push ($errorMessage,"This cow is already added");
    }
	
	//unit_price
	$price = strip_tags($_POST['price']); 
	$price = str_replace(' ', '', $price); 
	$_SESSION['sc_price'] = $price; 

	if(empty($errorMessage)){		
		$insert = mysqli_query($con, "INSERT INTO saleable_cows VALUE('', '$cow_id', '$price')");
		if ($insert) {
			$_SESSION["SuccessMessage"] = "Cow Added to sell";
			header('Location:saleableCowList.php');

			//Clear session variables after submission
			$_SESSION['sc_cow_id'] = "";
			$_SESSION['sc_price'] = "";
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
            <h1>Add cow for sell</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Add cow for sell</li>
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
	                <h3 class="card-title">Saleable Add</h3>
	              </div>
	              <!-- /.card-header -->
	              <!-- form start -->
	              <form class="form-horizontal" action="" method="POST">
	                <div class="card-body">

	                	<div class="form-group row">
		                  	<label class="col-sm-2 col-form-label">Cow Id</label>
		                  	<div class="col-sm-10">
			                  	<select class="select2bs4" name="cow_id" style="width: 100%;">
				                    <option selected="selected" value="">Select Cow</option>
				                    <?php
										//get plant plat Type
										$cows = mysqli_query($con,"SELECT * FROM cows WHERE status=1 ");
										foreach ($cows as $key => $cow) {
											$cow_id = $cow['unique_id'];
											if (isset($_SESSION['sc_cow_id']) && $_SESSION['sc_cow_id']==$cow_id) {
							                  echo "<option selected value='$cow_id'>$cow_id</option>";
							                }else{
										?>
										<option value="<?php echo $cow_id ?>"><?php echo $cow_id ?></option>
									<?php } } ?>
			                  	</select>
		                  	</div>
		                </div>

		                <div class="form-group row">
		                    <label for="price" class="col-sm-2 col-form-label">Price</label>
		                    <div class="col-sm-10">
		                      <input type="number" min="0" name="price" class="form-control" id="price" placeholder="Price" value="<?php if(isset($_SESSION['sc_price'])) { echo $_SESSION['sc_price']; }  ?>" >
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