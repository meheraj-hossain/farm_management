<?php 
$title = 'Milk Selling';
include_once('template/head.php'); 

$errorMessage = array();
	
if(isset($_POST['submit'])){
	if (empty($_POST['quantity']) || empty($_POST['unit_price']) || empty($_POST['total_price']) || empty($_POST['selling_date'])) {
		array_push ($errorMessage,"All field must be field out");
    }
    //quantity
	$quantity = strip_tags($_POST['quantity']); 
	$quantity = str_replace(' ', '', $quantity); 
	$_SESSION['ms_quantity'] = $quantity; 


    $check_stocks = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM milk_stocks"));
    $stock = $check_stocks['milkStock'];
    
    if ($quantity > $stock && $stock!=NULL) {
    	array_push ($errorMessage,"Cross the stock. Stock is = $stock Litter");
    }
	

	//unit_price
	$unit_price = strip_tags($_POST['unit_price']); 
	$unit_price = str_replace(' ', '', $unit_price); 
	$_SESSION['ms_unit_price'] = $unit_price; 

	//entry_date
	$total_price = strip_tags($_POST['total_price']); 
	$total_price = str_replace(' ', '', $total_price); 
	$_SESSION['ms_total_price'] = $total_price; 

	//selling_date
	$selling_date = strip_tags($_POST['selling_date']); 
	$_SESSION['ms_selling_date'] = $selling_date; 		
    
	

	if(empty($errorMessage)){		
		$insert = mysqli_query($con, "INSERT INTO milk_sellings VALUE('', '$quantity', '$unit_price',  '$total_price','$selling_date')");
		if ($insert) {
			$_SESSION["SuccessMessage"] = "Milk Selling data added successfully";
			header('Location:milkSellingList.php');

			//Clear session variables after submission
			$_SESSION['ms_quantity'] = "";
			$_SESSION['ms_unit_price'] = "";
			$_SESSION['ms_total_price'] = "";
			$_SESSION['ms_selling_date'] = "";
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
            <h1>Milk Selling</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Milk Selling Add</li>
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
	                <h3 class="card-title">Milk Selling Add</h3>
	              </div>
	              <!-- /.card-header -->
	              <!-- form start -->
	              <form class="form-horizontal" action="" method="POST">
	                <div class="card-body">

	                	<div class="form-group row">
		                    <label for="quantity" class="col-sm-2 col-form-label">Quantity</label>
		                    <div class="col-sm-10">
		                      <input type="number" min="0" name="quantity" class="form-control" id="quantity" placeholder="Quantity" value="<?php if(isset($_SESSION['ms_quantity'])) { echo $_SESSION['ms_quantity']; }  ?>" oninput="calculate()">
		                    </div>
		                </div>

		                <div class="form-group row">
		                    <label for="unit_price" class="col-sm-2 col-form-label">Unit Price</label>
		                    <div class="col-sm-10">
		                      <input type="number" min="0" name="unit_price" class="form-control" id="unit_price" placeholder="Unit Price" value="<?php if(isset($_SESSION['ms_unit_price'])) { echo $_SESSION['ms_unit_price']; }  ?>" oninput="calculate()">
		                    </div>
		                </div>

		                <div class="form-group row">
		                    <label for="total_price" class="col-sm-2 col-form-label">Total Price</label>
		                    <div class="col-sm-10">
		                      <input type="number" min="0" name="total_price" class="form-control" id="total_price" placeholder="Total Price" value="<?php if(isset($_SESSION['ms_total_price'])) { echo $_SESSION['ms_total_price']; }  ?>" readonly>
		                    </div>
		                </div>

		                <div class="form-group row">
		                    <label for="selling_date" class="col-sm-2 col-form-label">Selling Date</label>
		                    <div class="col-sm-10">
		                      <input type="text" name="selling_date" class="form-control" id="selling_date" placeholder="Selling Date" value="<?php if(isset($_SESSION['ms_selling_date'])) { echo $_SESSION['ms_selling_date']; }  ?>">
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
	 $("#selling_date").datepicker({
		 showAnim: 'drop',
		 numberOfMonth: 1,
		 maxDate: maxDate,
		 dateFormat:'yy-mm-dd',
		 onClose: function(selectedDate){
		 $('#return').datepicker("option", "maxDate",selectedDate);
		 
		 }
	 });
});

function calculate() {
    var quantity = document.getElementById('quantity').value; 
    var unitPrice = document.getElementById('unit_price').value; 
    var myResult = quantity * unitPrice;
    document.getElementById('total_price').value = myResult;

}

</script> 