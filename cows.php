<?php
include_once('template/head.php');


 ?>
	<body>
		<?php include_once('template/header.php') ?>
		
		<!-- page header section ending here -->
        <section class="page-header padding-tb page-header-bg-1">
            <div class="container">
                <div class="page-header-item d-flex align-items-center justify-content-center">
                    <div class="post-content">
                        <h3>Gowala Cows</h3>
                        <div class="breadcamp">
                            <ul class="d-flex flex-wrap justify-content-center align-items-center">
								<li><a href="index.php">Home</a></li>
                                <li><a class="active">Cows</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- page header section ending here -->
		<!-- Shop Page Section start here -->		            
		<section class="shop-page padding-tb">
			<div class="container">
				<div class="row">
					<div class="col-lg-9 col-12 sticky-widget">
						<?php echo SuccessMessage() ?>
						<div id="dynamic_content">
						
						</div>
					</div>
					<div class="col-lg-3 col-12 sticky-widget">
						<div class="sidebar-widget">
							<div class="widget-search">
								<h4>Search With Price</h4>
								<form action="">
									<label>Search With Minimum Price <i class='fa fa-search' aria-hidden='true'></i></label>
									<input type="text" name="search_box" id="search_box" placeholder="Minumum Price Range" name="search_box" >
								</form>
							</div>
							
						</div>
					</div>
				</div>
				
			</div>
		</section>
		<!-- Shop Page Section ending here -->
    
		<!-- footer section start here -->
		<?php include_once('template/footer.php'); ?>
		<!-- footer section start here -->


		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.js"></script>
		<?php include_once('template/script.php');?>
	</body>


</html>
<script>
  $(document).ready(function(){

    load_data(1);

    function load_data(page, query = '')
    {
      $.ajax({
        url:"cowData.php",
        method:"POST",
        data:{page:page, query:query},
        success:function(data)
        {
          $('#dynamic_content').html(data);
        }
      });
    }

    $(document).on('click', '.page-link', function(){
      var page = $(this).data('page_number');
      var query = $('#search_box').val();
      load_data(page, query);
    });

    $('#search_box').keyup(function(){
      var query = $('#search_box').val();
      //console.log(query);
      load_data(1, query);
    });

  });
</script>
