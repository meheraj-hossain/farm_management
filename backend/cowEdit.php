<?php 
$title = 'Edit cow';
include_once('template/head.php'); 

if (isset($_GET['cow_id'])) {
    $cow_id = $_GET['cow_id'];

    $cows = mysqli_query($con, "SELECT * FROM cows WHERE id='$cow_id'");
    $cow = mysqli_fetch_array($cows);

	$errorMessage = array();
		
	if(isset($_POST['update'])){
		if (empty($_POST['unique_id']) || empty($_POST['category_id']) || empty($_POST['entry_date']) || empty($_POST['birth_date']) || empty($_POST['weight']) || empty($_POST['description']) ) {
		array_push ($errorMessage,"All field must be field out");
    	}
    
		// unique_id
		$unique_id = strip_tags($_POST['unique_id']); 
		$_SESSION['ce_unique_id'] = $unique_id; 

		//find names
		$find_unique_id = mysqli_query($con, "SELECT * FROM cows WHERE unique_id = '$unique_id'");
		$caw_unique_id = mysqli_fetch_array($find_unique_id);
		$num_unique_id = mysqli_num_rows($find_unique_id);

		//check name is already exits or not
		if ($num_unique_id > 0 && $caw_unique_id['unique_id'] != $unique_id) {
			array_push ($errorMessage,"This cow already exist");
		}
		
		//category_id
		$category_id = strip_tags($_POST['category_id']); 
		$category_id = str_replace(' ', '', $category_id); 
		$_SESSION['ce_category_id'] = $category_id; 

		//entry_date
		$weight = strip_tags($_POST['weight']); 
		$weight = str_replace(' ', '', $weight); 
		$_SESSION['ce_weight'] = $weight; 	

		//echo $weight; exit();

		//entry_date
		$entry_date = strip_tags($_POST['entry_date']); 
		$entry_date = str_replace(' ', '', $entry_date); 
		$_SESSION['ce_entry_date'] = $entry_date; 

		//entry_date
		$birth_date = strip_tags($_POST['birth_date']); 
		$birth_date = str_replace(' ', '', $birth_date); 
		$_SESSION['ce_birth_date'] = $birth_date; 

		//entry_date
		$description = strip_tags($_POST['description']); 
		$_SESSION['ce_description'] = $description; 	

		//images
		if (!empty($_FILES["image1"]["name"])) {
			$image1 = "assets/img/cows/".md5(time().uniqid()).basename($_FILES["image1"]["name"]);
		}else{
			$image1 = $cow['image1'];
		}

		if (!empty($_FILES["image2"]["name"])) {
			$image2 = "assets/img/cows/".md5(time().uniqid()).basename($_FILES["image2"]["name"]);
		}else{
			$image2 = $cow['image2'];
		}

		if (!empty($_FILES["image3"]["name"])) {
			$image3 = "assets/img/cows/".md5(time().uniqid()).basename($_FILES["image3"]["name"]);
		}else{
			$image3 = $cow['image3'];
		}
		

		if(empty($errorMessage)){		
			$update = mysqli_query($con, "UPDATE cows SET unique_id='$unique_id', category_id='$category_id', weight='$weight', image1='$image1', image2='$image2', image3='$image3',  entry_date='$entry_date', birth_date='$birth_date', description='$description'  WHERE id='$cow_id'");
			if ($update) {
				if (!empty($_FILES["image1"]["name"])) {
					unlink($cow['image1']);
					move_uploaded_file($_FILES["image1"]["tmp_name"],$image1);
				}

				if (!empty($_FILES["image2"]["name"])) {
					unlink($cow['image3']);
					move_uploaded_file($_FILES["image2"]["tmp_name"],$image2);
				}

				if (!empty($_FILES["image3"]["name"])) {
					unlink($cow['image3']);
					move_uploaded_file($_FILES["image3"]["tmp_name"],$image3);
				}
				

				$_SESSION["SuccessMessage"] = "Cow Updated successfully";
				header('Location:cowList.php');

				//Clear session variables after submission
				$_SESSION['ce_name'] = null;
				$_SESSION['ce_category_id'] = null;
				$_SESSION['ce_weight'] = null;
				$_SESSION['ce_image'] = null;
				$_SESSION['ce_entry_date'] = null;
				$_SESSION['ce_birth_date'] = null;
				$_SESSION['ce_description'] = null;
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
			            <h1>Cow Category Edit</h1>
			          </div>
			          <div class="col-sm-6">
			            <ol class="breadcrumb float-sm-right">
			              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
			              <li class="breadcrumb-item active">Cow Category Edit</li>
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
				                <h3 class="card-title">Cow Category Edit</h3>
				              </div>
				              <!-- /.card-header -->
				              <!-- form start -->
				              	<form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
					                <div class="card-body">
					                	<div class="form-group row">
						                    <label for="unique_id" class="col-sm-2 col-form-label">Unique Id</label>
						                    <div class="col-sm-10">
						                      <input type="text" name="unique_id" class="form-control" id="unique_id" placeholder="Unique Id" value="<?php if(isset($_SESSION['ce_unique_id'])) {
		                                                            echo $_SESSION['ce_unique_id'];
		                                                        }else{
		                                                            echo $cow['unique_id'];
		                                                        } ?>">
						                    </div>
						                </div>

						                <div class="form-group row">
					                        <label class="col-sm-2 col-form-label">Cow Category</label>
					                        <div class="col-sm-10">
						                        <select name="category_id" class="form-control" id="role">
						                        	<option value="">Select Cow Category</option>
						                          		<?php
														
														if (isset($_SESSION['ce_category_id']) && $_SESSION['ce_category_id']==1) {
										                  echo "<option selected value='1'>Cow for Sell</option>";
										                  echo "<option value='2'>Cow for Milk</option>";
										                }elseif (isset($_SESSION['ce_category_id']) && $_SESSION['ce_category_id']==2) {
										                  echo "<option value='1'>Cow for Sell</option>";
										                  echo "<option selected value='2'>Cow for Milk</option>";
										                }elseif (isset($cow['category_id']) && $cow['category_id']==1) {
										                  echo "<option selected value='1'>Cow for Sell</option>";
										                  echo "<option value='2'>Cow for Milk</option>";
										                }elseif (isset($cow['category_id']) && $cow['category_id']==2) {
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
						                    <label for="weight" class="col-sm-2 col-form-label">Weight</label>
						                    <div class="col-sm-10">
						                      <input type="number" min="0" step="0.1" name="weight" class="form-control" id="weight" placeholder="Weight" value="<?php if(isset($_SESSION['ce_weight'])) { echo $_SESSION['ec_weight']; }else{
		                                                            echo $cow['weight'];
		                                                        }  ?>">
						                    </div>
						                </div>

						                <div class="form-group row">
						                    <label for="image" class="col-sm-2 col-form-label">Image 1</label>
						                    <div class="col-sm-10">
						                      <input type="file" name="image1" class="form-control" id="image" placeholder="Image" value="<?php if(isset($_SESSION['image'])) {
	                                                    echo $_SESSION['image'];
	                                                }else{
	                                                    echo $cow['image1'];
	                                                } ?>">
						                    </div>

						                    <label for="image" class="col-sm-2 col-form-label">Previous Image</label>
						                    <div class="col-sm-10 mt-50">
							                    <img src="<?=$cow['image1']?>" style="width: 100px; height: 75px" alt="">
							                </div>
						                </div>

						                <div class="form-group row">
						                    <label for="image" class="col-sm-2 col-form-label">Image 2</label>
						                    <div class="col-sm-10">
						                      <input type="file" name="image2" class="form-control" id="image" placeholder="Image" value="<?php if(isset($_SESSION['image'])) {
	                                                    echo $_SESSION['image'];
	                                                }else{
	                                                    echo $cow['image2'];
	                                                } ?>">
						                    </div>

						                    <label for="image" class="col-sm-2 col-form-label">Previous Image 2</label>
						                    <div class="col-sm-10 mt-50">
							                    <img src="<?=$cow['image2']?>" style="width: 100px; height: 75px" alt="">
							                </div>
						                </div>

						                <div class="form-group row">
						                    <label for="image" class="col-sm-2 col-form-label">Image 3</label>
						                    <div class="col-sm-10">
						                      <input type="file" name="image3" class="form-control" id="image" placeholder="Image" value="<?php if(isset($_SESSION['image'])) {
	                                                    echo $_SESSION['image'];
	                                                }else{
	                                                    echo $cow['image3'];
	                                                } ?>">
						                    </div>
						                    <label for="image" class="col-sm-2 col-form-label">Previous Image 3</label>
						                    <div class="col-sm-10 mt-50">
							                    <img src="<?=$cow['image3']?>" style="width: 100px; height: 75px" alt="">
							                </div>
						                </div>

						                <div class="form-group row">
						                    <label for="entry_date" class="col-sm-2 col-form-label">Entry Date</label>
						                    <div class="col-sm-10">
						                      <input type="date" name="entry_date" class="form-control" id="entry_date" placeholder="Entry Date" value="<?php if(isset($_SESSION['ce_entry_date'])) {
	                                                    echo $_SESSION['ce_entry_date'];
	                                                }else{
	                                                    echo $cow['entry_date'];
	                                                } ?>">
						                    </div>
						                </div>		                

					                   	<div class="form-group row">
						                    <label for="birth_date" class="col-sm-2 col-form-label">Birth Date</label>
						                    <div class="col-sm-10">
						                      <input type="date" name="birth_date" class="form-control" id="birth_date" placeholder="Birth Date" value="<?php if(isset($_SESSION['ce_birth_date'])) {
		                                                            echo $_SESSION['ce_birth_date'];
		                                                        }else{
		                                                            echo $cow['birth_date'];
		                                                        } ?>">
						                    </div>
					                  	</div>

					                  	<div class="form-group row">
						                    <label for="description" class="col-sm-2 col-form-label">Description</label>
						                    <div class="col-sm-10">
						                    	<textarea class="form-control" name="description"><?php if(isset($_SESSION['ce_description'])) { echo $_SESSION['ce_description']; }else{
		                                                            echo $cow['description'];
		                                                        }  ?></textarea>
						                      
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
	<script>
	$(document).ready(function (){
		 var maxDate = new Date();
		 $("#birth_date").datepicker({
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
		 var maxDate = new Date();
		 $("#entry_date").datepicker({
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
        header('location:cowList.php');
}