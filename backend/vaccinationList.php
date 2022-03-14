<?php 
$title = 'Vaccination List';
include_once('template/head.php'); 
$vaccinations = mysqli_query($con,"SELECT * FROM vaccinations ORDER BY id DESC");
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
            <h1>Vaccination</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Vaccination List</li>
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
                <h3 class="card-title">Vaccination List</h3>
                <a type="button" href="vaccinationAdd.php" class="btn btn-info" style="float: right;"><i class="fa fa-plus-square"></i> ADD NEW</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sr. No</th>
                    <th>Vaccine</th>
                    <th>Cow Id</th>
                    <th>Vaccined Date</th>
                    <th>Next Vaccination Date</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($vaccinations as $key=>$vacc) { ?>
                    <tr>
                        <td><?php echo $key +1 ?></td>
                        <?php
                          $vaccine_id = $vacc['vaccine_id'];
                          $vac_name = mysqli_fetch_assoc(mysqli_query($con,"SELECT name FROM vaccines WHERE id='$vaccine_id' ")); 
                        ?>
                        <td><?=$vac_name['name']?></td>

                        <?php
                          $cow_id = $vacc['cow_id'];
                          $cow = mysqli_fetch_assoc(mysqli_query($con,"SELECT unique_id FROM cows WHERE id='$cow_id' ")); 
                        ?>
                        <td><?=$cow['unique_id']?></td>
                        
                        <td><?=$vacc['vaccined_date']?></td>
                        <td><?=$vacc['next_vaccined_date']?></td>
                        <td>
                          <a class="action-btn-warning" href="vaccinationEdit.php?vacci_id=<?=$vacc['id']?>">
                            <i class="fas fa-edit"></i> 
                          </a>

                           <!-- <a class="action-btn-danger" href="vaccinationList.php?DeleteId=<?=$vacc['id']?>" onclick="return confirm('Are you sure you want to delete this item?');">
                            <i class="fas fa-trash-alt"></i> 
                          </a> -->
                        </td>
                    </tr>

                <?php } ?>
                 
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Sr. No</th>
                    <th>Vaccine</th>
                    <th>Cow Id</th>
                    <th>Vaccined Date</th>
                    <th>Next Vaccination Date</th>
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
  //   $deleteQuery = mysqli_query($con,"DELETE FROM `vaccinations` WHERE id='$id' ");
  //   if ($deleteQuery) {
  //     $_SESSION["SuccessMessage"]="Data deleted successfully";
  //     echo '<script>window.location="vaccinationList.php"</script>';
  //   }
  // }
  ?>
