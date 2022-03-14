<?php 
$title = 'Milk Collection Edit';
include_once('template/head.php'); 

if (isset($_GET['MC_id'])) {
    $MC_id = $_GET['MC_id'];

    $milkCollection = mysqli_query($con, "SELECT * FROM milk_collections WHERE id='$MC_id'");
    $MC = mysqli_fetch_array($milkCollection);

	$errorMessage = array();
	
	if(isset($_POST['update'])){
		if (empty($_POST['quantity']) || empty($_POST['collection_date'])) {
			array_push ($errorMessage,"All Field is Required");
	    }
		// name
		$quantity = strip_tags($_POST['quantity']); 
		$_SESSION['mce_quantity'] = $quantity; 

		$collection_date = strip_tags($_POST['collection_date']); 
		$_SESSION['mce_collection_date'] = $collection_date;

	    
		

		if(empty($errorMessage)){
			$update = mysqli_query($con, "UPDATE milk_collections SET quantity='$quantity', collection_date='$collection_date'  WHERE id='$MC_id'");
			if ($update) {

				$_SESSION["SuccessMessage"] = "Milk Collection Data updated successfully";
				header('Location:milkCollectionList.php');
			}else{
				array_push ($errorMessage,"Date not saved");
			}

			//Clear session variables after submission
			$_SESSION['mca_quantity'] = null;
			$_SESSION['mca_collection_date'] = null;
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
			              <li class="breadcrumb-item active">Milk Collection Edit</li>
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
				                <h3 class="card-title">Milk Collection Edit</h3>
				              </div>
				              <!-- /.card-header -->
				              <!-- form start -->
				              <form class="form-horizontal" action="" method="POST">
				              	<div class="card-body">
					              	<div class="form-group row">
					                    <label for="quantity" class="col-sm-2 col-form-label">Quantity (L)</label>
					                    <div class="col-sm-10">
					                      <input type="number" min="0" name="quantity" class="form-control" id="quantity" placeholder="Ex. 10 Litter" value="<?php if(isset($_SESSION['mce_quantity'])) {
	                                                    echo $_SESSION['mce_quantity'];
	                                                }else{
	                                                    echo $MC['quantity'];
	                                                } ?>">
					                    </div>
				                  	</div>

					                <div class="form-group row">
					                    <label for="collection_date" class="col-sm-2 col-form-label">Collection Date</label>
					                    <div class="col-sm-10">
					                      <input type="text" name="collection_date" class="form-control" id="collection_date" placeholder="Collection Date" value="<?php if(isset($_SESSION['mce_collection_date'])) {
	                                                    echo $_SESSION['mce_collection_date'];
	                                                }else{
	                                                    echo $MC['collection_date'];
	                                                } ?>">
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

<?php }else{
    header('location:milkCollectionList.php');
}