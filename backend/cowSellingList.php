<?php 
$title = 'Cow Selling';
include_once('template/head.php'); 
$cowSellings = mysqli_query($con,"SELECT * FROM cow_sellings ORDER BY id DESC");
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
            <h1>Cow Selling</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Cow Selling List</li>
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
            <?php echo SuccessMessage() ?>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Cow Selling List</h3>
                <a type="button" href="cowSellingAdd.php" class="btn btn-info" style="float: right;"><i class="fa fa-plus-square"></i> ADD NEW</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sr. No</th>
                    <th>Customer Name</th>
                    <th>Customer Phone</th>
                    <th>Cow ID</th>
                    <th>Selling Price</th>
                    <th>Order Date</th>
                    <th>Payment Status</th>
                    <th>Delivery Status</th>
                    <th>Delivery Date</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($cowSellings as $key=>$CS) { ?>
                    <tr>
                        <td><?php echo $key +1 ?></td>
                        <td><?=$CS['customer_name']?></td>
                        <td><?=$CS['customer_phone']?></td>
                        <td><?=$CS['cow_id']?></td>
                        <td><?=$CS['selling_price']?> BDT</td>
                        <td><?=$CS['order_date']?></td>
                        <td>
                        <?php if ($CS['payment_status'] ==1) {
                          echo 'Paid';
                        }else echo 'Unpaid';
                        ?>
                        <td>
                        <?php if ($CS['delivery_status'] == 1) {
                          echo 'Delivered';
                        }else echo 'Pending';
                        ?>
                        </td>
                        
                        <?php 
                        if ($CS['delivery_date'] == null) {
                          echo '';
                        }else
                        ?>
                        <td><?=$CS['delivery_date']?></td>
                        <td>
                          <a class="action-btn-warning" href="cowSellingEdit.php?CS_id=<?=$CS['id']?>">
                            <i class="fas fa-edit"></i> 
                          </a>

                          <!-- <a class="action-btn-danger" href="cowSellingList.php?DeleteId=<?=$CS['id']?>" onclick="return confirm('Are you sure you want to delete this item?');">
                            <i class="fas fa-trash-alt"></i> 
                          </a> -->
                        </td>
                    </tr>

                <?php } ?>
                 
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Sr. No</th>
                    <th>Customer Name</th>
                    <th>Customer Phone</th>
                    <th>Cow ID</th>
                    <th>Selling Price</th>
                    <th>Order Date</th>
                    <th>Payment Status</th>
                    <th>Delivery Status</th>
                    <th>Delivery Date</th>
                    <th>Action</th>
                  </tr>
                  </tfoot>
                </table>
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
	  $(function () {
	    $("#example1").DataTable({
	      "responsive": true, "lengthChange": false, "autoWidth": false,
	      "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
	    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
	    $('#example2').DataTable({
	      "paging": true,
	      "lengthChange": false,
	      "searching": false,
	      "ordering": true,
	      "info": true,
	      "autoWidth": false,
	      "responsive": true,
	    });
	  });
	</script>

  <?php
  //delete query
  // if (isset($_GET['DeleteId'])) {
  //   $id = $_GET['DeleteId'];
  //   $deleteQuery = mysqli_query($con,"DELETE FROM `cow_sellings` WHERE id='$id' ");
  //   if ($deleteQuery) {
  //     $_SESSION["SuccessMessage"]="Data deleted successfully";
  //     echo '<script>window.location="cowSellingList.php"</script>';
  //   }
  // }
  ?>
