<?php 
$title = 'Cow Feed Add';
include_once('template/head.php'); 

$errorMessage = array();
	
if(isset($_POST['submit'])){
	if (empty($_POST['food_id']) || empty($_POST['quantity']) || empty($_POST['feed_at'])) {
		array_push ($errorMessage,"All field must be field out");
    }
	// food_id
	$food_id = strip_tags($_POST['food_id']); 
	$food_id = str_replace(' ', '', $food_id); 
	$_SESSION['cf_food_id'] = $food_id; 
	
	//quantity
	$quantity = strip_tags($_POST['quantity']); 
	$quantity = str_replace(' ', '', $quantity); 
	$_SESSION['cf_quantity'] = $quantity; 

	//buy_at
	$feed_at = strip_tags($_POST['feed_at']); 
	$_SESSION['cf_feed_at'] = $feed_at; 		
    
	

	if(empty($errorMessage)){		
		$insert = mysqli_query($con, "INSERT INTO cow_feeds VALUE('', '$food_id', '$quantity','$feed_at')");
		if ($insert) {
			//update cow food stocks
			$oldStock = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM cow_foods WHERE id='$food_id'"));
			$newStock = $oldStock['stock'] - $quantity;
			mysqli_query($con,"UPDATE cow_foods SET stock='$newStock' WHERE id='$food_id'");

			$_SESSION["SuccessMessage"] = "New data added successfully";
			header('Location:cowFeedList.php');

			//Clear session variables after submission
			$_SESSION['cf_food_id'] = "";
			$_SESSION['cf_quantity'] = "";
			$_SESSION['cf_feed_at'] = "";
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
            <h1>Cow Feed</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Cow Feed Add</li>
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
	                <h3 class="card-title">Cow Feed Add</h3>
	              </div>
	              <!-- /.card-header -->
	              <!-- form start -->
	              <form class="form-horizontal" action="" method="POST">
	                <div class="card-body">

		                <div class="form-group row">
	                        <label class="col-sm-2 col-form-label">Food</label>
	                        <div class="col-sm-10">
		                        <select name="food_id" class="form-control" id="role">
		                        	<option value="">Select Food</option>
		                          	<?php
										//get plant plat Type
										$cow_foods = mysqli_query($con,"SELECT * FROM cow_foods");
										foreach ($cow_foods as $key => $cf) {
											$cfood_id = $cf['id'];
											$cfood_name = $cf['name'];
											if (isset($_SESSION['cf_food_id']) && $_SESSION['cf_food_id']==$food_id) {
							                  echo "<option selected value='$cfood_id'>$cfood_name</option>";
							                }else{
										?>
										<option value="<?php echo $cfood_id ?>"><?php echo $cfood_name ?></option>
									<?php } } ?>
		                        </select>
		                    </div>
                      	</div>


	                	<div class="form-group row">
		                    <label for="quantity" class="col-sm-2 col-form-label">Quantity</label>
		                    <div class="col-sm-10">
		                      <input type="number" min="0" step="0.01" name="quantity" class="form-control" id="quantity" placeholder="Quantity" value="<?php if(isset($_SESSION['bcf_quantity'])) { echo $_SESSION['bcf_quantity']; }  ?>" >
		                    </div>
		                </div>

		                <div class="form-group row">
		                    <label for="feed_at" class="col-sm-2 col-form-label">Feed Date</label>
		                    <div class="col-sm-10">
		                      <input type="text" name="feed_at" class="form-control" id="feed_at" placeholder="Entry Date" value="<?php if(isset($_SESSION['cf_feed_date'])) { echo $_SESSION['cf_feed_date']; }  ?>">
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
	 $("#feed_at").datepicker({
		 showAnim: 'drop',
		 numberOfMonth: 1,
		 maxDate: maxDate,
		 dateFormat:'yy-mm-dd',
		 onClose: function(selectedDate){
		 $('#return').datepicker("option", "maxDate",selectedDate);
		 
		 }
	 });
});

</script> 