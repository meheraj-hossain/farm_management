<?php 
$title = 'Edit cow category';
include_once('template/head.php'); 

if (isset($_GET['vac_id'])) {
    $vac_id = $_GET['vac_id'];

    $vaccine = mysqli_query($con, "SELECT * FROM vaccines WHERE id='$vac_id'");
    $vac = mysqli_fetch_array($vaccine);

	$errorMessage = array();
		
	if(isset($_POST['update'])){
		if (empty($_POST['name']) ) {
			array_push ($errorMessage,"Vccine Name is required");
	    }else{
	    	// name
			$name = strip_tags($_POST['name']); 
			$name = ucfirst(strtolower($name));
			$_SESSION['vce_name'] = $name; 

			//find names
			$find_name = mysqli_query($con, "SELECT name FROM vaccines WHERE name = '$name'");
			$vac_name = mysqli_fetch_array($find_name);
			$num_name = mysqli_num_rows($find_name);

			//check name is already exits or not
			if ($num_name > 0 && $vac_name['name'] != $name) {
				array_push ($errorMessage,"This vaccine already exist");
			}
	    }
		

		if(empty($errorMessage)){		
			$update = mysqli_query($con, "UPDATE vaccines SET name='$name' WHERE id='$vac_id'");
			if ($update) {
				$_SESSION["SuccessMessage"] = "Vccine Updated successfully";
				header('Location:vaccineList.php');

				//Clear session variables after submission
				$_SESSION['vce_name'] = null;
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
		            <h1>Cow Vaccine</h1>
		          </div>
		          <div class="col-sm-6">
		            <ol class="breadcrumb float-sm-right">
		              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
		              <li class="breadcrumb-item active">Vaccine Edit</li>
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
			                <h3 class="card-title">Vaccine Edit</h3>
			              </div>
			              <!-- /.card-header -->
			              <!-- form start -->
			              <form class="form-horizontal" action="" method="POST">
			                <div class="card-body">
			                	<div class="form-group row">
				                    <label for="name" class="col-sm-2 col-form-label">Name</label>
				                    <div class="col-sm-10">
				                      <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="<?php if(isset($_SESSION['vce_name'])) {
                                                            echo $_SESSION['vce_name'];
                                                        }else{
                                                            echo $vac['name'];
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
		
<?php }else{
        header('location:vaccineList.php');
}