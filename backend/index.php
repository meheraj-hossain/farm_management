<?php 
$title = 'Home';
include_once('template/head.php'); ?>
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
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">

          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <?php $totalMilkSellingMoney = mysqli_fetch_array(mysqli_query($con,"SELECT SUM(total_price) AS totalAmount FROM milk_sellings"));?>
                <h3><?php if ($totalMilkSellingMoney['totalAmount']==NULL) {
                  echo "0";
                }else{
                  echo $totalMilkSellingMoney['totalAmount'];
                } ?> BDT</h3>

                <p>Total Milk Seelling Amount</p>
              </div>
              <div class="icon">
                <i class="ion ion-cash"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->

          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <?php $totalCowSellingMoney = mysqli_fetch_array(mysqli_query($con,"SELECT SUM(selling_price) AS totalAmount FROM `cow_sellings`"));?>
                <h3><?php if ($totalCowSellingMoney['totalAmount']==NULL) {
                  echo "0";
                }else{
                  echo $totalCowSellingMoney['totalAmount'];
                } ?> BDT</h3>

                <p>Total Cow Seelling Amount</p>
              </div>
              <div class="icon">
                <i class="ion ion-cash"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->

          <!-- ./col -->
          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <?php 
                $totalIcome = $totalCowSellingMoney['totalAmount'] + $totalMilkSellingMoney['totalAmount'];
                ?>
                <h3><?php if ($totalIcome==NULL) {
                  echo "0";
                }else{
                  echo $totalIcome;
                } ?> BDT</h3>

                <p>Total Income</p>
              </div>
              <div class="icon">
                <i class="ion ion-cash"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <?php $milkStocks = mysqli_fetch_array(mysqli_query($con,"SELECT * FROM milk_stocks"));?>
                <h3><?=$milkStocks['milkStock']?> Litter</h3>

                <p>Today's Milk Stock</p>
              </div>
              <div class="icon">
                <i class="ion ion-beaker"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->

          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">

                <h3>
                  <?php $totalCow = mysqli_num_rows(mysqli_query($con,"SELECT id FROM `cows` WHERE status=1"));
                  echo $totalCow; ?>
                </h3>

                <p>Total Cows On Farm</p>
              </div>
              <div class="icon">
                <i class=""><img style="height: 70px; width: 70px; margin-top: -71px;" src="assets/img/cow-silhouette.png" alt=""></i>
              </div>
            </div>
          </div>

          <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <?php $vaex = mysqli_fetch_array(mysqli_query($con,"SELECT SUM(total_price) AS totalVaccineExpense FROM vaccine_expenses"));?>
                
                <h3><?php if ($vaex['totalVaccineExpense']==NULL) {
                  echo "0";
                }else{
                  echo $vaex['totalVaccineExpense'];
                } ?> BDT</h3>


                <p>Total Vaccine Expense</p>
              </div>
              <div class="icon">
                <i class="ion ion-cash"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->

           <div class="col-lg-4 col-6">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <?php $CFEX = mysqli_fetch_array(mysqli_query($con,"SELECT SUM(total_price) AS totalCowFoodExpense FROM cow_food_expenses"));?>
                
                <h3><?php if ($CFEX['totalCowFoodExpense']==NULL) {
                  echo "0";
                }else{
                  echo $CFEX['totalCowFoodExpense'];
                } ?> BDT</h3>


                <p>Total Cow Food Expense</p>
              </div>
              <div class="icon">
                <i class="ion ion-cash"></i>
              </div>
            </div>
          </div>
          <!-- ./col -->
          
        </div>
        <!-- /.row -->
        <!-- Main row -->
        
        <!-- /.row (main row) -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
 

<?php include_once('template/footer.php'); ?>
