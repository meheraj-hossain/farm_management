<?php 
$title = 'Admin List';
include_once('template/head.php'); 
if(isset($_SESSION['logged_user_id']) && $_SESSION['logged_user_type']==1){

$getAdmins = mysqli_query($con,"SELECT * FROM users WHERE role =1 ORDER BY id DESC");
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
            <h1>Admins</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Admin List</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>
<?php echo SuccessMessage() ?>
    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">

            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Admin List</h3>
                <a type="button" href="userAdd.php" class="btn btn-info" style="float: right;"><i class="fa fa-plus-square"></i> ADD NEW</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sr. No</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($getAdmins as $key=>$admin) { ?>
                    <tr>
                        <td><?php echo $key +1 ?></td>
                        <td><?=$admin['name']?></td>
                        <td><img src="<?=$admin['image']?>" alt="" style="max-width: 50px; max-height: 50px"></td>
                        <td><?=$admin['email']?></td>
                        <td><?=$admin['phone']?></td>
                        <td><?=$admin['address']?></td>
                    </tr>

                <?php } ?>
                 
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Sr. No</th>
                    <th>Name</th>
                    <th>Image</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
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

<?php }else{
  header('location:login.php');
}
