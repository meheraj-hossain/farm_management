<?php 
$title = 'Vaccine Expense Edit';
include_once('template/head.php'); 

if (isset($_GET['VE_id'])) {
  $VE_id = $_GET['VE_id'];

  $vaccineExpenses = mysqli_query($con, "SELECT * FROM vaccine_expenses WHERE id='$VE_id'");
  $VaxEx = mysqli_fetch_array($vaccineExpenses);

  $errorMessage = array();
    
  if(isset($_POST['update'])){
    if (empty($_POST['vaccine_id']) ||  empty($_POST['quantity']) || empty($_POST['unit_price']) || empty($_POST['total_price']) || empty($_POST['buy_at'])) {
      array_push ($errorMessage,"All field must be field out");
      }
    // vaccine_id
    $vaccine_id = strip_tags($_POST['vaccine_id']); 
    $vaccine_id = str_replace(' ', '', $vaccine_id); 
    $_SESSION['vee_vaccine_id'] = $vaccine_id; 
    
    //quantity
    $quantity = strip_tags($_POST['quantity']); 
    $quantity = str_replace(' ', '', $quantity); 
    $_SESSION['vee_quantity'] = $quantity; 

    //unit_price
    $unit_price = strip_tags($_POST['unit_price']); 
    $unit_price = str_replace(' ', '', $unit_price); 
    $_SESSION['vee_unit_price'] = $unit_price; 

    //entry_date
    $total_price = strip_tags($_POST['total_price']); 
    $total_price = str_replace(' ', '', $total_price); 
    $_SESSION['vee_total_price'] = $total_price; 

    //buy_at
    $buy_at = strip_tags($_POST['buy_at']); 
    $_SESSION['vee_buy_at'] = $buy_at;    
      
    

    if(empty($errorMessage)){
      $update = mysqli_query($con, "UPDATE vaccine_expenses SET vaccine_id='$vaccine_id', quantity='$quantity',unit_price='$unit_price', total_price='$total_price', buy_at='$buy_at' WHERE id='$VE_id'");
      if ($update) {
        $oldStock = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM vaccines WHERE id='$vaccine_id'"));
        $preStock = $oldStock['stock'] - $VaxEx['quantity'];
        $newStock = $preStock + $quantity;
        mysqli_query($con,"UPDATE vaccines SET stock='$newStock' WHERE id='$vaccine_id'");

        $_SESSION["SuccessMessage"] = "Data Updated successfully";
        header('Location:vaccineExpenseList.php');

        //Clear session variables after submission
        $_SESSION['vee_vaccine_id'] = "";
        $_SESSION['vee_quantity'] = "";
        $_SESSION['vee_unit_price'] = "";
        $_SESSION['vee_total_price'] = "";
        $_SESSION['vee_buy_at'] = "";
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
                <h1>Vaccine Expense</h1>
              </div>
              <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                  <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                  <li class="breadcrumb-item active">Vaccine Expense Edit</li>
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
                      <h3 class="card-title">Vaccine Expense Edit</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form class="form-horizontal" action="" method="POST">
                      <div class="card-body">

                        <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Vaccine</label>
                          <div class="col-sm-10">
                            <select name="vaccine_id" class="form-control" id="role">
                              <option value="">Select Vaccine</option>
                                <?php
                                //get plant plat Type
                                $vaccines = mysqli_query($con,"SELECT * FROM vaccines");
                                foreach ($vaccines as $key => $vac) {
                                  $vaccineId = $vac['id'];
                                  $vaccineName = $vac['name'];
                                  if (isset($_SESSION['vee_vaccine_id']) && $_SESSION['vee_vaccine_id']==$vaccineId) {
                                    echo "<option selected value='$vaccineId'>$vaccineName</option>";
                                  }elseif (isset($VaxEx['vaccine_id']) && $VaxEx['vaccine_id']==$vaccineId) {
                                    echo "<option selected value='$vaccineId'>$vaccineName</option>";
                                  }else{
                                ?>
                                <option value="<?php echo $vaccineId ?>"><?php echo $vaccineName ?></option>
                              <?php } } ?>
                            </select>
                          </div>
                        </div>


                        <div class="form-group row">
                            <label for="quantity" class="col-sm-2 col-form-label">Quantity</label>
                            <div class="col-sm-10">
                              <input type="number" min="0" name="quantity" class="form-control" id="quantity" placeholder="Quantity" value="<?php if(isset($VaxEx['quantity'])) { echo $VaxEx['quantity']; }  ?>" oninput="calculate()">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="unit_price" class="col-sm-2 col-form-label">Unit Price</label>
                            <div class="col-sm-10">
                              <input type="number" min="0" name="unit_price" class="form-control" id="unit_price" placeholder="Unit Price" value="<?php if(isset($VaxEx['unit_price'])) { echo $VaxEx['unit_price']; }  ?>" oninput="calculate()">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="total_price" class="col-sm-2 col-form-label">Total Price</label>
                            <div class="col-sm-10">
                              <input type="number" min="0" name="total_price" class="form-control" id="total_price" placeholder="Total Price" value="<?php if(isset($VaxEx['total_price'])) { echo $VaxEx['total_price']; }  ?>">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="buy_date" class="col-sm-2 col-form-label">Buy Date</label>
                            <div class="col-sm-10">
                              <input type="text" name="buy_at" class="form-control" id="buy_date" placeholder="Entry Date" value="<?php if(isset($VaxEx['buy_at'])) { echo $VaxEx['buy_at']; }  ?>">
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
  header('location:vaccineExpenseList.php');
}