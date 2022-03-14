<?php 
$title = 'Add new cow category';
include_once('template/head.php'); 

$errorMessage = array();
	
if(isset($_POST['submit'])){
	if (empty($_POST['name'])) {
		array_push ($errorMessage,"Food Name is required");
    }else{
    	// name
		$name = strip_tags($_POST['name']);
		$_SESSION['name'] = $name; 


		//check user already exist or not in database
		$check_name = mysqli_query($con, "SELECT name FROM cow_foods WHERE name = '$name'");
		$num_name = mysqli_num_rows($check_name);

		if($num_name > 0){
			array_push ($errorMessage,"This name already exist");
		}
    }
	

	if(empty($errorMessage)){		
		$insert = mysqli_query($con, "INSERT INTO cow_foods VALUE('', '$name',0)");
		if ($insert) {
			$_SESSION["SuccessMessage"] = "New cow food added successfully";
			header('Location:cowFoodList.php');
		}else{
			array_push ($errorMessage,"Date not saved");
		}

		//Clear session variables after submission
		$_SESSION['name'] = null;
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
		            <h1>Cow Food</h1>
		          </div>
		          <div class="col-sm-6">
		            <ol class="breadcrumb float-sm-right">
		              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
		              <li class="breadcrumb-item active">Cow Food Add</li>
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
			                <h3 class="card-title">Cow Food Add</h3>
			              </div>
			              <!-- /.card-header -->
			              <!-- form start -->
			              <form class="form-horizontal" action="" method="POST">
			                <div class="card-body">
			                	<div class="form-group row">
				                    <label for="name" class="col-sm-2 col-form-label">Name</label>
				                    <div class="col-sm-10">
				                      <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="<?php if(isset($_SESSION['name'])) { echo $_SESSION['name']; }  ?>">
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
		