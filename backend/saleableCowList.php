<?php 
$title = 'Milk Selling';
include_once('template/head.php'); 
$saleableCows = mysqli_query($con,"SELECT * FROM saleable_cows ORDER BY id DESC");
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
            <h1>Saleable Cows</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Saleable Cow List</li>
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
                <h3 class="card-title">Saleabel Cow List</h3>
                <a type="button" href="saleableCowAdd.php" class="btn btn-info" style="float: right;"><i class="fa fa-plus-square"></i> ADD NEW</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sr. No</th>
                    <th>Cow Id</th>
                    <th>Price</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($saleableCows as $key=>$SC) { ?>
                    <tr>
                        <td><?php echo $key +1 ?></td>
                        <td><?=$SC['cow_id']?></td>
                        <td><?=$SC['price']?> BDT</td>
                        <td>
                          <a class="action-btn-warning" href="saleableCowEdit.php?SC_id=<?=$SC['id']?>">
                            <i class="fas fa-edit"></i> 
                          </a>

                          <a class="action-btn-danger" href="saleableCowList.php?DeleteId=<?=$SC['id']?>" onclick="return confirm('Are you sure you want to delete this item?');">
                            <i class="fas fa-trash-alt"></i> 
                          </a>
                        </td>
                    </tr>

                <?php } ?>
                 
                  </tbody>
                  <tfoot>
                  <tr>
                   <th>Sr. No</th>
                    <th>Cow Id</th>
                    <th>Price</th>
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
  if (isset($_GET['DeleteId'])) {
    $id = $_GET['DeleteId'];
    $deleteQuery = mysqli_query($con,"DELETE FROM `saleable_cows` WHERE id='$id' ");
    if ($deleteQuery) {
      $_SESSION["SuccessMessage"]="Data deleted successfully";
      echo '<script>window.location="saleableCowList.php"</script>';
    }
  }
  ?>
