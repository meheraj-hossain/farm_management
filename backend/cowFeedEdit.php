<?php 
$title = 'Buy cow food Edit';
include_once('template/head.php'); 

if (isset($_GET['CF_id'])) {
  $CF_id = $_GET['CF_id'];

  $cowFeeds = mysqli_query($con, "SELECT * FROM cow_feeds WHERE id='$CF_id'");
  $CF = mysqli_fetch_array($cowFeeds);

  $errorMessage = array();
    
  if(isset($_POST['update'])){
    if (empty($_POST['food_id']) ||  empty($_POST['quantity']) || empty($_POST['feed_at'])) {
      array_push ($errorMessage,"All field must be field out");
      }
    // food_id
    $food_id = strip_tags($_POST['food_id']); 
    $food_id = str_replace(' ', '', $food_id); 
    $_SESSION['cfe_food_id'] = $food_id; 
    
    //quantity
    $quantity = strip_tags($_POST['quantity']); 
    $quantity = str_replace(' ', '', $quantity); 
    $_SESSION['cfe_quantity'] = $quantity; 

    //feed_at
    $feed_at = strip_tags($_POST['feed_at']); 
    $_SESSION['cfe_feed_at'] = $feed_at;    
      
    

    if(empty($errorMessage)){
      $update = mysqli_query($con, "UPDATE cow_feeds SET food_id='$food_id', quantity='$quantity', feed_at='$feed_at' WHERE id='$CF_id'");
      if ($update) {
        $oldStock = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM cow_foods WHERE id='$food_id'"));
        $preStock = $oldStock['stock'] + $CF['quantity'];
        $newStock = $preStock - $quantity;
        mysqli_query($con,"UPDATE cow_foods SET stock='$newStock' WHERE id='$food_id'");

        $_SESSION["SuccessMessage"] = "Data Updated successfully";
        header('Location:cowFeedList.php');

        //Clear session variables after submission
        $_SESSION['cfe_food_id'] = "";
        $_SESSION['cfe_quantity'] = "";
        $_SESSION['cfe_feed_at'] = "";
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
                <h1>Cow Feed</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item active">Cow Feed Edit</li>
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
                      <h3 class="card-title">Cow Feed Edit</h3>
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
                                foreach ($cow_foods as $cf) {
                                  $cfood_id = $cf['id'];
                                  $cfood_name = $cf['name'];
                                  if (isset($CF['food_id']) && $CF['food_id']==$cfood_id) {
                                    echo "<option selected value='$cfood_id'>$cfood_name</option>";
                                  }elseif(isset($_SESSION['cfe_food_id']) && $_SESSION['cfe_food_id'] == $food_id) {
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
                              <input type="number" min="0" step="0.01" name="quantity" class="form-control" id="quantity" placeholder="Quantity" value="<?php if(isset($CF['quantity'])) { echo $CF['quantity']; }  ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="feed_at" class="col-sm-2 col-form-label">Feed At</label>
                            <div class="col-sm-10">
                              <input type="text" name="feed_at" class="form-control" id="feed_at" placeholder="Entry Date" value="<?php if(isset($CF['feed_at'])) { echo $CF['feed_at']; }  ?>">
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
<?php 
}else{
  header('location:cowFeedList.php');
}