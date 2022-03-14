<?php 
$title = 'Milk Requests';
include_once('template/head.php'); 
$milkRequests = mysqli_query($con,"SELECT * FROM milk_requests WHERE status=1 ORDER BY id DESC");
if (isset($_POST['send'])) {
  $request_id = $_POST['id'];
  $email = $_POST['email'];
  $message = $_POST['message'];

  //send email
  include '../helpers/mailSender.php';
  $mail->addAddress($email);
  $mail->Subject = 'Milk Request Response';
  $mail->Body = "<html>
              <head>
              </head>
              <body>
                <h5>".$message."</h5>
                Thanks,<br>
                Gowala.
              </body>
              </html>";

 if ( $mail->send()) {
   //update as responsed milk_requests table
  mysqli_query($con,"UPDATE milk_requests SET status=2 WHERE id='$request_id' ");
 }
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
            <h1>Cow Food Expense</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Cow Food Expense List</li>
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
                <h3 class="card-title">Cow Food Expense List</h3>
                <a type="button" href="buyCowFoodAdd.php" class="btn btn-info" style="float: right;"><i class="fa fa-plus-square"></i> ADD NEW</a>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example1" class="table table-bordered table-striped">
                  <thead>
                  <tr>
                    <th>Sr. No</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Customer Phone</th>
                    <th>Milk Quantity</th>
                    <th>Request Date</th>
                    <th>Required At</th>
                    <th>Action</th>
                  </tr>
                  </thead>
                  <tbody>
                    <?php foreach ($milkRequests as $key=>$MR) { ?>
                    <tr>
                        <td><?php echo $key +1 ?></td>
                        <td><?=$MR['customer_name']?></td>
                        <td><?=$MR['customer_email']?></td>
                        <td><?=$MR['customer_phone']?></td>
                        <td><?=$MR['milk_quantity']?> Litter</td>
                        <td><?=$MR['request_date']?></td>
                        <td><?=$MR['required_at']?></td>
                        <td>
                            <button class="btn btn-info passingData" data-toggle="modal" data-id="<?=$MR['id']?>" data-email="<?=$MR['customer_email']?>" data-target="#modal-default">Answar</button>
                        </td>
                    </tr>

                <?php } ?>
                 
                  </tbody>
                  <tfoot>
                  <tr>
                    <th>Sr. No</th>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Customer Phone</th>
                    <th>Milk Quantity</th>
                    <th>Request Date</th>
                    <th>Required At</th>
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

      <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Milk Request</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form action="" method="POST">
              <div class="modal-body">

                <input type="hidden" id="idkl" name="id" value="" />
                <input type="hidden" id="emailkl" name="email" value="" />
                <textarea class="form-control placeholder-no-fix" id="message" name="message"></textarea>
              </div>
              <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" name="send" class="btn btn-primary">Send</button>
              </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php include_once('template/footer.php'); ?>
  <script>
    $(document).on("click", ".passingData", function () {
     var ids = $(this).data('id');
     var emails = $(this).data('email');
     $(".modal-body #idkl").val( ids );
     $(".modal-body #emailkl").val( emails );
    });

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
    $deleteQuery = mysqli_query($con,"DELETE FROM `cow_food_expenses` WHERE id='$id' ");
    if ($deleteQuery) {
      $_SESSION["SuccessMessage"]="Data deleted successfully";
      echo '<script>window.location="buyCowFoodList.php"</script>';
    }
  }
  ?>
