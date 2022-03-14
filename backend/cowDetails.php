<?php 
$title = 'Add new cow';
include_once('template/head.php'); 
if (isset($_GET['cow_id'])) {
    $cow_id = $_GET['cow_id'];

    $cows = mysqli_query($con, "SELECT * FROM cows WHERE id='$cow_id'");
    $cow = mysqli_fetch_array($cows);
?>
<body class="hold-transition sidebar-mini">
<!-- Site wrapper -->
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
            <h1>Cow</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Cow Details</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card card-solid">
        <div class="card-body">
          <div class="row">
            <div class="col-12 col-sm-6">
              <h3 class="d-inline-block d-sm-none">Cow ID: <?=$cow['unique_id']?></h3>
              <div class="col-12">
                <img src="<?=$cow['image1']?>" class="product-image" alt="Product Image">
              </div>
              <div class="col-12 product-image-thumbs">
                <div class="product-image-thumb" ><img src="<?=$cow['image1']?>" alt="Product Image"></div>
                <div class="product-image-thumb" ><img src="<?=$cow['image2']?>" alt="Product Image"></div>
                <div class="product-image-thumb" ><img src="<?=$cow['image3']?>" alt="Product Image"></div>
                
              </div>
            </div>
            <div class="col-12 col-sm-6">
              <h3 class="my-3">Cow ID: <?=$cow['unique_id']?></h3>
              <p><?=$cow['description']?></p>

              <hr>

              <h4 class="mt-3">Weight</h4>
              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-default text-center">
                  <input type="radio" name="color_option" id="color_option_b1" autocomplete="off">
                  <span class="text-xl"><?=$cow['weight']?></span>
                  <br>
                  KG
                </label>
              </div>

              <hr>
            <?php $date = new DateTime($cow['birth_date']);
             $now = new DateTime();
             $interval = $now->diff($date);
             $year =  $interval->y;
             $month =  $interval->m;
             $day =  $interval->d;
             ?>
              <h4 class="mt-3">Age</h4>
              <div class="btn-group btn-group-toggle" data-toggle="buttons">
                <label class="btn btn-default text-center">
                  <input type="radio" name="color_option" id="color_option_b1" autocomplete="off">
                  <span class="text-xl"><?=$year?> Year - <?=$month?> Month - <?=$day?> Day</span>
                  <br>
                  
                </label>
              </div>

              <div class="bg-gray py-2 px-3 mt-4">
                <h2 class="mb-0">
                  Price
                </h2>
                <h4 class="mt-0">
                  <small>
                    <?php 
                    $price = mysqli_fetch_array(mysqli_query($con, "SELECT price FROM saleable_cows WHERE cow_id='$cow_id' ")); 
                    if ($price['price'] == NULL) {
                      echo "Price Not set yet";
                    }else{
                      echo $price['price'];
                    }
                    ?>
                  </small>
                </h4>
              </div>

              <div class="mt-4">
                <a href="saleableCowAdd.php" class="btn btn-info btn-lg btn-flat">
                  <i class="far fa-money-bill-alt"></i>
                  Add Price
                </a>

                <a href="cowEdit.php?cow_id=<?=$cow['id']?>" class="btn btn-warning btn-lg btn-flat">
                  <i class="far fa-edit"></i>
                  Edit
                </a>
              </div>

            </div>
          </div>
          
        </div>
        <!-- /.card-body -->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include_once('template/footer.php'); ?>
<?php }else{
        header('location:cowList.php');
}