<?php 
$title = 'Cow Selling Report';
include_once('template/head.php');

if (isset($_GET['from_date']) AND isset($_GET['to_date'])) {
  	$fromDate = $_GET['from_date'];
  	$toDate = $_GET['to_date'];

	$current_date = date('d-m-Y');

	$getData = mysqli_query($con,"SELECT * FROM cow_sellings  WHERE order_date BETWEEN '$fromDate' AND '$toDate' ");
  	$data = mysqli_fetch_array($getData);

  	$totalAmount = mysqli_fetch_array(mysqli_query($con,"SELECT SUM(selling_price) AS totalPrice FROM cow_sellings WHERE order_date BETWEEN '$fromDate' AND '$toDate' "));
  	//echo $totalAmount['totalPrice']; exit();
  	
  	//$customer_name = $getData['customer_name'];
  	
  	

?>
<body class="hold-transition sidebar-mini">
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
		        <h1>Report</h1>
		      </div>
		      <div class="col-sm-6">
		        <ol class="breadcrumb float-sm-right">
		          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
		          <li class="breadcrumb-item"><a href="reports.php">Reports</a></li>
		          <li class="breadcrumb-item active">Cow Selling Report</li>
		        </ol>
		      </div>
		    </div>
		  </div><!-- /.container-fluid -->
		</section>

		<section class="content">
		  <div class="container-fluid">
		    <div class="row">
		      <div class="col-12">
		        


		        <!-- Main content -->
		        <div class="invoice p-3 mb-3">
		        	<div id="areaPrint">
			          	<!-- title row -->
			          	<div class="row">
				            <div class="col-12">
				              	<h4>
				                 Cow Selling Report
				                <small class="float-right">Date: <?=$current_date?></small>
				              	</h4>
				            </div>
				            <!-- /.col -->
			          	</div>
			          	<!-- info row -->
			          	<div class="row invoice-info">
				            <div class="col-sm-4 invoice-col">
				              From
				              <address>
				                <strong><?=$fromDate?></strong><br>
				                
				              </address>
				            </div>
				            <!-- /.col -->
				            <div class="col-sm-4 invoice-col">
				              To
				              <address>
				                <strong><?=$toDate?></strong><br>
				                
				              </address>
				            </div>
				            <!-- /.col -->
				            <div class="col-sm-4 invoice-col">
				             
				            </div>
				            <!-- /.col -->
			          	</div>
			          	<!-- /.row -->

			          	<!-- Table row -->
			          	<div class="row">
				            <div class="col-12 table-responsive">
				              <table class="table table-striped">
				                <thead>
				                <tr>
				                  <th>Sr.</th>
				                  <th>Customer Name</th>
				                  <th>Customer Phone</th>
				                  <th>Cow Id</th>
				                  <th>Selling Price</th>
				                  <th>Order Date</th>
				                </tr>
				                </thead>
				                <tbody>
					                <?php foreach ($getData as $key=>$CS) { ?>
					                <tr>
					                  <td><?php echo $key +1 ?></td>
					                  <td><?=$CS['customer_name']?></td>
					                  <td><?=$CS['customer_phone']?></td>
					                  <td><?=$CS['cow_id']?></td>
					                  <td><?=$CS['selling_price']?></td>
					                  <td><?=$CS['order_date']?></td>
					                </tr>
					                <?php } ?>
				                
				                </tbody>
				              </table>
				            </div>
				            <!-- /.col -->
				          	</div>
			          	<!-- /.row -->
			          	<hr>
			          	<div class="row">
				            <!-- accepted payments column -->
				            <div class="col-6">
				              
				            </div>
				            <!-- /.col -->
				            <div class="col-6">
				              

				              <div class="table-responsive">
				                <table class="table">
				                  <!-- <tr>
				                    <th style="width:50%">Subtotal:</th>
				                    <td>$250.30</td>
				                  </tr> -->
				                  <tr>
				                    <th>Total:</th>
				                    <td><?=$totalAmount['totalPrice']?> BDT</td>
				                  </tr>
				                </table>
				              </div>
				            </div>
				            <!-- /.col -->
			          	</div>
			          <!-- /.row -->
			        </div>

		          <!-- this row will not appear when printing -->
		          <div class="row no-print">
		            <div class="col-12">
		              <button  onclick="printDiv('areaPrint')" class="btn btn-info float-right"><i class="fa fa-print"></i></i> Print
		              </button>
		              
		            </div>
		          </div>
		        </div>
		        <!-- /.invoice -->
		      </div><!-- /.col -->
		    </div><!-- /.row -->
		  </div><!-- /.container-fluid -->
		</section>
		<!-- /.content -->
	</div>

<?php include_once('template/footer.php'); 
}else{
  header('location:reports.php');
}
?>

<script>
	function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}
</script>