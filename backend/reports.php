<?php 
$title = 'Cow Food Expenses';
include_once('template/head.php'); 

$errorMessage = array();

if (isset($_POST['cow_sellings']) && (!empty($_POST['from_date']) || !empty($_POST['to_date']))) {
  $from_date = $_POST['from_date'];
  $to_date = $_POST['to_date'];
  
  header( "Location:reportCowSelling.php?from_date=$from_date&to_date=$to_date" );
  
}elseif(isset($_POST['cow_sellings']) && (empty($_POST['from_date']) || empty($_POST['to_date']))){
  array_push ($errorMessage,"Please Select both date first");
}

if (isset($_POST['milk_sellings']) && (!empty($_POST['from_date']) || !empty($_POST['to_date']))) {
  $from_date = $_POST['from_date'];
  $to_date = $_POST['to_date'];
  header( "Location:reportMilkSelling.php?from_date=$from_date&to_date=$to_date" );
  
}elseif(isset($_POST['milk_sellings']) && (empty($_POST['from_date']) || empty($_POST['to_date']))){
  array_push ($errorMessage,"Please Select both date first");
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
            <h1>Reports</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Report List</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">

        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Report List</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">

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

                <form action="" method="POST">
                  <div class="form-group row">
                    <div class="col col-sm-6">
                      <label for="from_date" class="col-sm-2 col-form-label">From</label>
                      <div class="col-sm-10">
                        <input type="text" name="from_date" class="form-control" id="from_date" placeholder="Entry Date" value="<?php if(isset($_SESSION['bcf_buy_date'])) { echo $_SESSION['bcf_buy_date']; }  ?>">
                      </div>
                    </div>

                    <div class="col col-sm-6">
                      <label for="to_date" class="col-sm-2 col-form-label">To</label>
                      <div class="col-sm-10">
                        <input type="text" name="to_date" class="form-control" id="to_date" placeholder="Entry Date" value="<?php if(isset($_SESSION['bcf_buy_date'])) { echo $_SESSION['bcf_buy_date']; }  ?>">
                      </div>
                    </div>
                  </div>
                  <table class="table table-bordered table-striped">
                    <thead>
                    <tr>
                      <th>Sr. No</th>
                      <th>Report For</th>
                      <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                      <tr>
                          <td>1</td>
                          <td>Cow Selling Report</td>
                          
                          <td>
                            <button type="submit" class="btn btn-primary" name="cow_sellings">
                              <i class="fas fa-eye"></i> View
                            </button>
                          </td>
                      </tr>
                       <tr>
                          <td>2</td>
                          <td>Milk Selling Report</td>
                          
                          <td>
                            <button type="submit" class="btn btn-primary" name="milk_sellings">
                              <i class="fas fa-eye"></i> View
                            </button>
                          </td>
                      </tr>
                   
                    </tbody>
                    <tfoot>
                    <tr>
                      <th>Sr. No</th>
                      <th>Report For</th>
                      <th>Action</th>
                    </tr>
                    </tfoot>
                  </table>
                </form>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </div>
      <!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include_once('template/footer.php'); ?>

<script>
$(document).ready(function (){
   var maxDate = new Date();
   $("#from_date").datepicker({
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
   var minDate = new Date();
   $("#to_date").datepicker({
     showAnim: 'drop',
     numberOfMonth: 1,
     minDate: minDate,
     dateFormat:'yy-mm-dd',
     onClose: function(selectedDate){
     $('#return').datepicker("option", "maxDate",selectedDate);
     
     }
   });
});

</script> 