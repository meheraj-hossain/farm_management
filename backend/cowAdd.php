<?php 
$title = 'Add new cow';
include_once('template/head.php'); 

$errorMessage = array();
	
if(isset($_POST['submit'])){
	if (empty($_POST['unique_id']) || empty($_FILES["image1"]["name"]) || empty($_FILES["image2"]["name"]) ||empty($_FILES["image3"]["name"]) || empty($_POST['category_id']) || empty($_POST['entry_date']) || empty($_POST['birth_date']) || empty($_POST['weight']) || empty($_POST['description']) ) {
		array_push ($errorMessage,"All field must be field out");
    }
    //print_r($_POST); exit();
	// unique_id
	$unique_id = strip_tags($_POST['unique_id']); 
	$unique_id = str_replace(' ', '', $unique_id); 
	$_SESSION['unique_id'] = $unique_id; 

	//check this cow exist or not in database
	$check_cow = mysqli_query($con, "SELECT unique_id FROM cows WHERE unique_id = '$unique_id'");
	$cow = mysqli_num_rows($check_cow);

	if($cow > 0){
		array_push ($errorMessage,"This cow already exist");
	}

	$image1 = "assets/img/cows/".md5(time().uniqid()).basename($_FILES["image1"]["name"]);
	$image2 = "assets/img/cows/".md5(time().uniqid()).basename($_FILES["image2"]["name"]);
	$image3 = "assets/img/cows/".md5(time().uniqid()).basename($_FILES["image3"]["name"]);

	
	//category_id
	$category_id = strip_tags($_POST['category_id']); 
	$category_id = str_replace(' ', '', $category_id); 
	$_SESSION['category_id'] = $category_id; 

	//entry_date
	$weight = strip_tags($_POST['weight']); 
	$weight = str_replace(' ', '', $weight); 
	$_SESSION['weight'] = $weight; 	

	//entry_date
	$entry_date = strip_tags($_POST['entry_date']); 
	$entry_date = str_replace(' ', '', $entry_date); 
	$_SESSION['entry_date'] = $entry_date; 

	//entry_date
	$birth_date = strip_tags($_POST['birth_date']); 
	$birth_date = str_replace(' ', '', $birth_date); 
	$_SESSION['birth_date'] = $birth_date; 	

	//entry_date
	$description = strip_tags($_POST['description']); 
	$_SESSION['description'] = $description; 	
    
	

	if(empty($errorMessage)){		
		$insert = mysqli_query($con, "INSERT INTO cows VALUE('', '$unique_id', '$image1', '$image2', '$image3','$category_id', '$entry_date','$birth_date','$weight','$description', 1)");
		if ($insert) {
			//move images
			move_uploaded_file($_FILES["image1"]["tmp_name"],$image1);
			move_uploaded_file($_FILES["image2"]["tmp_name"],$image2);
			move_uploaded_file($_FILES["image3"]["tmp_name"],$image3);


			//Clear session variables after submission
			$_SESSION['unique_id'] = "";
			$_SESSION['category_id'] = "";
			$_SESSION['entry_date'] = "";
			$_SESSION['entry_age'] = "";
			$_SESSION['weight'] = "";
			$_SESSION['description'] = "";
            
            
            $_SESSION["SuccessMessage"] = "New cow added successfully";
			header('Location:cowList.php');
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
            <h1>Cow ADD</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Cow Add</li>
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
		        	if(count($errorMessage) == 1){	      		
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
	                <h3 class="card-title">Cow Add</h3>
	              </div>
	              <!-- /.card-header -->
	              <!-- form start -->
	              <form class="form-horizontal" action="" method="POST" enctype="multipart/form-data">
	                <div class="card-body">
	                	<div class="form-group row">
		                    <label for="unique_id" class="col-sm-2 col-form-label">Unique Cow ID</label>
		                    <div class="col-sm-10">
		                      <input type="text" name="unique_id" class="form-control" id="unique_id" placeholder="Unique Cow ID" value="<?php if(isset($_SESSION['unique_id'])) { echo $_SESSION['unique_id']; }  ?>">
		                    </div>
		                </div>

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
		                    <label for="weight" class="col-sm-2 col-form-label">Weight</label>
		                    <div class="col-sm-10">
		                      <input type="number" min="0" step="0.1" name="weight" class="form-control" id="weight" placeholder="Weight" value="<?php if(isset($_SESSION['weight'])) { echo $_SESSION['weight']; }  ?>">
		                    </div>
		                </div>

		                <div class="form-group row">
		                    <label for="image1" class="col-sm-2 col-form-label">Image 1</label>
		                    <div class="col-sm-10">
		                      <input type="file" name="image1" class="form-control" id="image1" placeholder="Image 1">
		                    </div>
		                </div>

		                <div class="form-group row">
		                    <label for="image2" class="col-sm-2 col-form-label">Image 2</label>
		                    <div class="col-sm-10">
		                      <input type="file" name="image2" class="form-control" id="image2" placeholder="Image 2">
		                    </div>
		                </div>

		                <div class="form-group row">
		                    <label for="image3" class="col-sm-2 col-form-label">Image 3</label>
		                    <div class="col-sm-10">
		                      <input type="file" name="image3" class="form-control" id="image3" placeholder="Image 3">
		                    </div>
		                </div>

		                <div class="form-group row">
		                    <label for="entry_date" class="col-sm-2 col-form-label">Entry Date</label>
		                    <div class="col-sm-10">
		                      <input type="text" name="entry_date" class="form-control" id="entry_date" placeholder="Entry Date" value="<?php if(isset($_SESSION['entry_date'])) { echo $_SESSION['entry_date']; }  ?>">
		                    </div>
		                </div>		                

	                   	<div class="form-group row">
		                    <label for="birth_date" class="col-sm-2 col-form-label">Birth Date</label>
		                    <div class="col-sm-10">
		                      <input type="text" name="birth_date" class="form-control" id="birth_date" placeholder="Birth Date" value="<?php if(isset($_SESSION['birth_date'])) { echo $_SESSION['birth_date']; }  ?>">
		                    </div>
	                  	</div>

	                  	<div class="form-group row">
		                    <label for="description" class="col-sm-2 col-form-label">Description</label>
		                    <div class="col-sm-10">
		                    	<textarea class="form-control" name="description"><?php if(isset($_SESSION['description'])) { echo $_SESSION['description']; }  ?></textarea>
		                      
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