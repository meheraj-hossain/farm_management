<?php 
$title = 'Buy cow food Edit';
include_once('template/head.php'); 

if (isset($_GET['BCF_id'])) {
  $BCF_id = $_GET['BCF_id'];

  $foodExpenses = mysqli_query($con, "SELECT * FROM cow_food_expenses WHERE id='$BCF_id'");
  $FE = mysqli_fetch_array($foodExpenses);

  $errorMessage = array();
    
  if(isset($_POST['update'])){
    if (empty($_POST['food_id']) ||  empty($_POST['quantity']) || empty($_POST['unit_price']) || empty($_POST['total_price']) || empty($_POST['buy_at'])) {
      array_push ($errorMessage,"All field must be field out");
      }
    // food_id
    $food_id = strip_tags($_POST['food_id']); 
    $food_id = str_replace(' ', '', $food_id); 
    $_SESSION['bcfe_food_id'] = $food_id; 
    
    //quantity
    $quantity = strip_tags($_POST['quantity']); 
    $quantity = str_replace(' ', '', $quantity); 
    $_SESSION['bcfe_quantity'] = $quantity; 

    //unit_price
    $unit_price = strip_tags($_POST['unit_price']); 
    $unit_price = str_replace(' ', '', $unit_price); 
    $_SESSION['bcfe_unit_price'] = $unit_price; 

    //entry_date
    $total_price = strip_tags($_POST['total_price']); 
    $total_price = str_replace(' ', '', $total_price); 
    $_SESSION['bcfe_total_price'] = $total_price; 

    //buy_at
    $buy_at = strip_tags($_POST['buy_at']); 
    $_SESSION['bcfe_buy_at'] = $buy_at;    
      
    

    if(empty($errorMessage)){
      $update = mysqli_query($con, "UPDATE cow_food_expenses SET food_id='$food_id', quantity='$quantity',unit_price='$unit_price', total_price='$total_price', buy_at='$buy_at' WHERE id='$BCF_id'");
      if ($update) {
        $oldStock = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM cow_foods WHERE id='$food_id'"));
        $preStock = $oldStock['stock'] - $FE['quantity'];
        $newStock = $preStock + $quantity;
        mysqli_query($con,"UPDATE cow_foods SET stock='$newStock' WHERE id='$food_id'");

        $_SESSION["SuccessMessage"] = "Data Updated successfully";
        header('Location:buyCowFoodList.php');

        //Clear session variables after submission
        $_SESSION['bcfe_food_id'] = "";
        $_SESSION['bcfe_quantity'] = "";
        $_SESSION['bcfe_unit_price'] = "";
        $_SESSION['bcfe_total_price'] = "";
        $_SESSION['bcfe_buy_at'] = "";
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
                <h1>Cow Food Expense</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item active">Cow Food Expens Edit</li>
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
                      <h3 class="card-title">Cow Food Expens Edit</h3>
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
                                  if (isset($FE['food_id']) && $FE['food_id']==$cfood_id) {
                                    echo "<option selected value='$cfood_id'>$cfood_name</option>";
                                  }elseif(isset($_SESSION['bcfe_food_id']) && $_SESSION['bcfe_food_id'] == $cfood_id) {
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
                              <input type="number" min="0" step="0.01" name="quantity" class="form-control" id="quantity" placeholder="Quantity" value="<?php if(isset($FE['quantity'])) { echo $FE['quantity']; }  ?>" oninput="calculate()">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="unit_price" class="col-sm-2 col-form-label">Unit Price</label>
                            <div class="col-sm-10">
                              <input type="number" min="0" name="unit_price" class="form-control" id="unit_price" placeholder="Unit Price" value="<?php if(isset($FE['unit_price'])) { echo $FE['unit_price']; }  ?>" oninput="calculate()">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="total_price" class="col-sm-2 col-form-label">Total Price</label>
                            <div class="col-sm-10">
                              <input type="number" min="0" name="total_price" class="form-control" id="total_price" placeholder="Total Price" value="<?php if(isset($FE['total_price'])) { echo $FE['total_price']; }  ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="buy_date" class="col-sm-2 col-form-label">Buy Date</label>
                            <div class="col-sm-10">
                              <input type="text" name="buy_at" class="form-control" id="buy_date" placeholder="Entry Date" value="<?php if(isset($FE['buy_at'])) { echo $FE['buy_at']; }  ?>">
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
			$("#buy_date").datepicker({
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
<?php 
}else{
  header('location:buyCowFoodList.php');
}