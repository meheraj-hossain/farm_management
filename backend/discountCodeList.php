<?php 
$title = 'Discount Codes';
include_once('template/head.php'); 
 if(isset($_SESSION['logged_user_id']) && $_SESSION['logged_user_type']==1){ 

$discountCodes = mysqli_query($con,"SELECT * FROM discount_codes ORDER BY id DESC");
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
            <h1>Discount Codes</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Discount Code List</li>
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
                <h3 class="card-title">Discount Code List</h3>
                <a type="button" href="discountCodeAdd.php" class="btn btn-info" style="float: right;"><i class="fa fa-plus-square"></i> ADD NEW</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sr. No</th>
                    <th>Code</th>
                    <th>Cow ID</th>
                    <th>Discount Amount</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($discountCodes as $key=>$DC) { ?>
                    <tr>
                        <td><?php echo $key +1 ?></td>
                        <td><?=$DC['code']?></td>
                        <td><?=$DC['cow_id']?></td>
                        <td><?=$DC['amount']?> BDT</td>
                        
                    </tr>

                <?php } ?>
                 
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Sr. No</th>
                    <th>Code</th>
                    <th>Cow ID</th>
                    <th>Discount Amount</th>
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

<?php }else{
  header('Location:loin.php');
}
?>