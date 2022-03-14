<?php 
$title = 'Cow Selling Edit';
include_once('template/head.php'); 

if (isset($_GET['CS_id'])) {
  $CS_id = $_GET['CS_id'];

  $cowSelling = mysqli_query($con, "SELECT * FROM cow_sellings WHERE id='$CS_id'");
  $CS = mysqli_fetch_array($cowSelling);

  $errorMessage = array();
    
  if(isset($_POST['update'])){
    if (empty($_POST['customer_name']) || empty($_POST['customer_phone']) || empty($_POST['cow_id']) || empty($_POST['selling_price']) || empty($_POST['order_date'])|| empty($_POST['delivery_status']) || empty($_POST['payment_status'])) {
      array_push ($errorMessage,"All field must be field out");
      }
      //customer_name
    $customer_name = strip_tags($_POST['customer_name']); 
    $customer_name = str_replace(' ', '', $customer_name); 
    $_SESSION['cs_customerName'] = $customer_name; 

    //customer_phone
    $customer_phone = strip_tags($_POST['customer_phone']); 
    $customer_phone = str_replace(' ', '', $customer_phone); 
    $_SESSION['cs_customerPhone'] = $customer_phone; 

      //cow_id
    $cow_id = strip_tags($_POST['cow_id']); 
    $cow_id = str_replace(' ', '', $cow_id); 
    $_SESSION['cs_cowId'] = $cow_id; 

    //selling_price
    $selling_price = strip_tags($_POST['selling_price']); 
    $selling_price = str_replace(' ', '', $selling_price); 
    $_SESSION['cs_sellingPrice'] = $selling_price; 

    //order_date
    $order_date = strip_tags($_POST['order_date']); 
    $order_date = str_replace(' ', '', $order_date); 
    $_SESSION['cs_orderDate'] = $order_date; 

    //delivery_status
    $delivery_status = strip_tags($_POST['delivery_status']);  
    $delivery_status = str_replace(' ', '', $delivery_status); 
    $_SESSION['cs_deliveryStatus'] = $delivery_status; 

    //payment_status
    $payment_status = strip_tags($_POST['payment_status']);  
    $payment_status = str_replace(' ', '', $payment_status); 
    $_SESSION['cs_paymentStatus'] = $payment_status; 

    //delivery_status
    if (isset($_POST['delivery_date'])) {
      $delivery_date = strip_tags($_POST['delivery_date']);  
      $delivery_date = str_replace(' ', '', $delivery_date); 
      $_SESSION['cs_deliveryDate'] = $delivery_date; 
    }else{
      $delivery_date= null;
    }
        
      
    

    if(empty($errorMessage)){ 

      $update = mysqli_query($con, "UPDATE cow_sellings SET  customer_name='$customer_name',customer_phone='$customer_phone', cow_id='$cow_id', selling_price='$selling_price', order_date='$order_date', payment_status='$payment_status', delivery_status='$delivery_status', delivery_date='$delivery_date' WHERE id='$CS_id'");
      if ($update) {

        $_SESSION["SuccessMessage"] = "Data updated successfully";
        header('Location:cowSellingList.php');

        //Clear session variables after submission
        $_SESSION['cs_customerName'] = "";
        $_SESSION['cs_customerPhone'] = "";
        $_SESSION['cs_cowId'] = "";
        $_SESSION['cs_sellingPrice'] = "";
        $_SESSION['cs_orderDate'] = "";
        $_SESSION['cs_paymentStatus'] = "";
        $_SESSION['cs_deliveryStatus'] = "";
        $_SESSION['cs_deliveryDate'] = "";
      }else{
        array_push ($errorMessage,"Date not saved");
      }
    }   
  }
  ?>
  <script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js'></script>
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
              <h1>Cow Selling</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                <li class="breadcrumb-item active">Cow Selling Add</li>
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
                    <h3 class="card-title">Cow Selling Add</h3>
                  </div>
                  <!-- /.card-header -->
                  <!-- form start -->
                  <form class="form-horizontal" action="" method="POST">
                    <div class="card-body">

                      <div class="form-group row">
                          <label for="customer_name" class="col-sm-2 col-form-label">Customer Name</label>
                          <div class="col-sm-10">
                            <input type="text" name="customer_name" class="form-control" id="customer_name" placeholder="Customer Name" value="<?php if(isset($_SESSION['cs_customerName'])) { echo $_SESSION['cs_customerName']; }elseif(isset($CS['customer_name'])) { echo $CS['customer_name']; }  ?>">
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="customer_phone" class="col-sm-2 col-form-label">Customer Phone</label>
                          <div class="col-sm-10">
                            <input type="text" name="customer_phone" class="form-control" id="customer_phone" placeholder="Customer Phone" value="<?php if(isset($_SESSION['cs_customerPhone'])) { echo $_SESSION['cs_customerPhone']; }elseif(isset($CS['customer_phone'])) { echo $CS['customer_phone']; }  ?>">
                          </div>
                      </div>

                      <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Cow Id</label>
                          <div class="col-sm-10">
                          <select class="select2bs4" readonly="" name="cow_id" style="width: 100%;">
                            <option selected="selected" value="">Select Cow</option>
                            <?php
                            //get plant plat Type
                            $cows = mysqli_query($con,"SELECT * FROM cows ");
                            foreach ($cows as $key => $cow) {
                              $cow_id = $cow['unique_id'];
                              if (isset($_SESSION['sc_cowId']) && $_SESSION['sc_cowId']==$cow_id) {
                                        echo "<option selected value='$cow_id'>$cow_id</option>";
                                      }elseif (isset($CS['cow_id']) && $CS['cow_id']==$cow_id) {
                                        echo "<option selected value='$cow_id'>$cow_id</option>";
                                      }else{
                            ?>
                            <option value="<?php echo $cow_id ?>"><?php echo $cow_id ?></option>
                          <?php } } ?>
                          </select>
                        </div>
                      </div>

                      <div class="form-group row">
                          <label for="selling_price" class="col-sm-2 col-form-label">Selling Price</label>
                          <div class="col-sm-10">
                            <input type="number" min="0" name="selling_price" class="form-control" id="selling_price" placeholder="Unit Price" value="<?php if(isset($_SESSION['cs_sellingPrice'])) { echo $_SESSION['cs_sellingPrice']; }elseif(isset($CS['selling_price'])) { echo $CS['selling_price']; }  ?>" >
                          </div>
                      </div>

                      <div class="form-group row">
                          <label for="order_date" class="col-sm-2 col-form-label">Order Date</label>
                          <div class="col-sm-10">
                            <input type="text" name="order_date" class="form-control" id="order_date" placeholder="Order Date" value="<?php if(isset($_SESSION['cs_orderDate'])) { echo $_SESSION['cs_orderDate']; }elseif(isset($CS['order_date'])) { echo $CS['order_date']; }  ?>">
                          </div>
                      </div>

                      <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Payment Status</label>
                          <div class="col-sm-10">
                            <select name="payment_status" class="form-control" id="payment_status">
                                  <?php 
                                      if (isset($CS['payment_status']) && $CS['payment_status']==1) {
                                          echo "<option value=''>Select Gender</option>";
                                          echo "<option selected='' value='1'>Paid</option>";
                                          echo "<option value='2'>Unpaid</option>";
                                      }elseif (isset($CS['payment_status']) && $CS['payment_status']==2) {
                                          echo "<option value=''>Select Gender</option>";
                                          echo "<option value='1'>Paid</option>";
                                          echo "<option selected='' value='2'>Unpaid</option>";
                                      }else{ ?>
                                          <option value="">Select One</option>
                                          <option value="1">Paid</option>
                                          <option value="2">Unpaid</option>
                                      <?php }
                                      ?>   
                              </select>
                        </div>
                      </div>


                      <div class="form-group row">
                          <label class="col-sm-2 col-form-label">Delivery Status</label>
                          <div class="col-sm-10">
                            <select name="delivery_status" class="form-control" id="delivery_status">
                              <?php 
                                      if (isset($CS['delivery_status']) && $CS['delivery_status']==1) {
                                          echo "<option value=''>Select Gender</option>";
                                          echo "<option selected='' value='1'>Delivered</option>";
                                          echo "<option value='2'>pending</option>";
                                      }elseif (isset($CS['delivery_status']) && $CS['delivery_status']==2) {
                                          echo "<option value=''>Select Gender</option>";
                                          echo "<option value='1'>Delivered</option>";
                                          echo "<option selected='' value='2'>pending</option>";
                                      }else{ ?>
                                          <option value="">Select One</option>
                                          <option value="1">Delivered</option>
                                          <option value="2">pending</option>
                                      <?php }
                                      ?>  
                                  
                              </select>
                        </div>
                      </div>

                      <div class="form-group row">
                          <label for="delivery_date" class="col-sm-2 col-form-label">Delivery Date</label>
                          <div class="col-sm-10">
                            <input type="text" name="delivery_date" class="form-control" id="delivery_date" placeholder="Order Date" value="<?php if(isset($_SESSION['cs_deliveryDate'])) { echo $_SESSION['cs_deliveryDate']; }elseif(isset($CS['delivery_date'])) { echo $CS['delivery_date']; }  ?>">
                          </div>
                      </div>                  

                        
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                      <button type="submit" name="update" class="btn btn-info">Submit</button>
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
    $("#order_date").datepicker({
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
    $("#delivery_date").datepicker({
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
      var cowID = document.getElementById('cow_id').value; 
      var unitPrice = document.getElementById('unit_price').value; 
      var myResult = quantity * unitPrice;
      document.getElementById('total_price').value = myResult;

  }

  $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()

      //Initialize Select2 Elements
      $('.select2bs4').select2({
        theme: 'bootstrap4'
      })
  })
  </script> 
  <?php
}else{
  header('location:cowSellingList.php');
}
?>