<?php 
$title = 'Milk Collection';
include_once('template/head.php'); 

$errorMessage = array();
	
if(isset($_POST['submit'])){
	if (empty($_POST['quantity']) || empty($_POST['collection_date'])) {
		array_push ($errorMessage,"All Field is Required");
    }
	// name
	$quantity = strip_tags($_POST['quantity']); 
	$_SESSION['mca_quantity'] = $quantity; 

	$collection_date = strip_tags($_POST['collection_date']); 
	$_SESSION['mca_collection_date'] = $collection_date;

    
	

	if(empty($errorMessage)){		
		$insert = mysqli_query($con, "INSERT INTO milk_collections VALUE('', '$quantity', '$collection_date')");
		if ($insert) {
			$_SESSION["SuccessMessage"] = "Milk Collection Data recorded successfully";
			header('Location:milkCollectionList.php');
		}else{
			array_push ($errorMessage,"Date not saved");
		}

		//Clear session variables after submission
		$_SESSION['mce_quantity'] = null;
		$_SESSION['mce_collection_date'] = null;
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
		            <h1>Milk Collection</h1>
		          </div>
		          <div class="col-sm-6">
		            <ol class="breadcrumb float-sm-right">
		              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
		              <li class="breadcrumb-item active">Milk Collection Add</li>
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
			                <h3 class="card-title">Milk Collection Add</h3>
			              </div>
			              <!-- /.card-header -->
			              <!-- form start -->
			              <form class="form-horizontal" action="" method="POST">
			              	<div class="card-body">
				              	<div class="form-group row">
				                    <label for="quantity" class="col-sm-2 col-form-label">Quantity (L)</label>
				                    <div class="col-sm-10">
				                      <input type="number" min="0" name="quantity" class="form-control" id="quantity" placeholder="Ex. 10 Litter" value="<?php if(isset($_SESSION['mca_quantity'])) { echo $_SESSION['mca_quantity']; }  ?>">
				                    </div>
			                  	</div>

				                <div class="form-group row">
				                    <label for="collection_date" class="col-sm-2 col-form-label">Collection Date</label>
				                    <div class="col-sm-10">
				                      <input type="text" name="collection_date" class="form-control" id="collection_date" placeholder="Collection Date" value="<?php if(isset($_SESSION['mca_collection_date'])) { echo $_SESSION['mca_collection_date']; }  ?>">
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
			 $("#collection_date").datepicker({
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