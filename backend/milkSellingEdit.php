<?php 
$title = 'Milk Selling Edit';
include_once('template/head.php'); 

if (isset($_GET['MS_id'])) {
  $MS_id = $_GET['MS_id'];

  $milkSelling = mysqli_query($con, "SELECT * FROM milk_sellings WHERE id='$MS_id'");
  $MS = mysqli_fetch_array($milkSelling);

  $errorMessage = array();
    
  if(isset($_POST['update'])){
    if (empty($_POST['quantity']) || empty($_POST['unit_price']) || empty($_POST['total_price']) || empty($_POST['selling_date'])) {
      array_push ($errorMessage,"All field must be field out");
    }

    //quantity
    $quantity = strip_tags($_POST['quantity']); 
    $quantity = str_replace(' ', '', $quantity); 
    $_SESSION['mse_quantity'] = $quantity; 

    //unit_price
    $unit_price = strip_tags($_POST['unit_price']); 
    $unit_price = str_replace(' ', '', $unit_price); 
    $_SESSION['mse_unit_price'] = $unit_price; 

    //total_price
    $total_price = strip_tags($_POST['total_price']); 
    $total_price = str_replace(' ', '', $total_price); 
    $_SESSION['mse_total_price'] = $total_price; 

    //selling_date
    $selling_date = strip_tags($_POST['selling_date']); 
    $_SESSION['mse_selling_date'] = $selling_date;    
      
    

    if(empty($errorMessage)){
      $update = mysqli_query($con, "UPDATE milk_sellings SET  quantity='$quantity',unit_price='$unit_price', total_price='$total_price', selling_date='$selling_date' WHERE id='$MS_id'");
      if ($update) {
        $_SESSION["SuccessMessage"] = "Data Updated successfully";
        header('Location:milkSellingList.php');

        //Clear session variables after submission
        $_SESSION['mse_quantity'] = "";
        $_SESSION['mse_unit_price'] = "";
        $_SESSION['mse_total_price'] = "";
        $_SESSION['mse_selling_date'] = "";
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
                <h1>Milk Selling</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item active">Milk Selling Edit</li>
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
                      <h3 class="card-title">Milk Selling Edit</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal" action="" method="POST">
                      <div class="card-body">

                        <div class="form-group row">
                            <label for="quantity" class="col-sm-2 col-form-label">Quantity</label>
                            <div class="col-sm-10">
                              <input type="number" min="0" name="quantity" class="form-control" id="quantity" placeholder="Quantity" value="<?php if(isset($MS['quantity'])) { echo $MS['quantity']; }  ?>" oninput="calculate()">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="unit_price" class="col-sm-2 col-form-label">Unit Price</label>
                            <div class="col-sm-10">
                              <input type="number" min="0" name="unit_price" class="form-control" id="unit_price" placeholder="Unit Price" value="<?php if(isset($MS['unit_price'])) { echo $MS['unit_price']; }  ?>" oninput="calculate()">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="total_price" class="col-sm-2 col-form-label">Total Price</label>
                            <div class="col-sm-10">
                              <input type="number" min="0" name="total_price" class="form-control" id="total_price" placeholder="Total Price" value="<?php if(isset($MS['total_price'])) { echo $MS['total_price']; }  ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="selling_date" class="col-sm-2 col-form-label">Selling Date</label>
                            <div class="col-sm-10">
                              <input type="text" name="selling_date" class="form-control" id="selling_date" placeholder="Entry Date" value="<?php if(isset($MS['selling_date'])) { echo $MS['selling_date']; }  ?>">
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
<?php 
}else{
  header('location:milkSellingList.php');
}