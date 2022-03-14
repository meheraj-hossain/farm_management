<?php 
$title = 'Per day cow required food';
include_once('template/head.php'); 
$requiredFoods = mysqli_query($con,"SELECT * FROM cow_food_required_perday ORDER BY id DESC");
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
            <h1>Per day cow required food</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Per day cow required food List</li>
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
                <h3 class="card-title">Per day cow required food List</h3>
                <a type="button" href="cowFoodRequiredAdd.php" class="btn btn-info" style="float: right;"><i class="fa fa-plus-square"></i> ADD NEW</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sr. No</th>
                    <th>Cow Category</th>
                    <th>Cow Food</th>
                    <th>Minimun Age</th>
                    <th>Maximum Age</th>
                    <th>Quantity</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($requiredFoods as $key=>$RF) { ?>
                    <tr>
                        <td><?php echo $key +1 ?></td>
                        <?php
                          if($RF['cow_category_id'] == 1){
                            echo '<td>Cow for sell</td>';
                          }else{
                            echo '<td>Cow for milk</td>';
                          }
                        ?>

                        <?php
                          $food_id = $RF['food_id'];
                          $food_name = mysqli_fetch_assoc(mysqli_query($con,"SELECT name FROM cow_foods WHERE id='$food_id' ")); 
                        ?>
                        <td><?=$food_name['name']?></td>
                        <td><?=$RF['min_age']?> Years</td>
                        <td><?=$RF['max_age']?> Years</td>
                        <td><?=$RF['quantity']?> KG</td>
                        <td>
                          <a class="action-btn-warning" href="cowFoodRequiredEdit.php?CRF_id=<?=$RF['id']?>">
                            <i class="fas fa-edit"></i> 
                          </a>

                           <a class="action-btn-danger" href="cowFoodRequiredList.php?DeleteId=<?=$RF['id']?>" onclick="return confirm('Are you sure you want to delete this item?');">
                            <i class="fas fa-trash-alt"></i> 
                          </a>
                        </td>
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
    $deleteQuery = mysqli_query($con,"DELETE FROM `cow_food_required_perday` WHERE id='$id' ");
    if ($deleteQuery) {
      $_SESSION["SuccessMessage"]="Data deleted successfully";
      echo '<script>window.location="cowFoodRequiredList.php"</script>';
    }
  }
  ?>