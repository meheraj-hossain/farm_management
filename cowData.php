<?php
include_once('helpers/db_con.php');

$limit = '6';
$page = 1;
if($_POST['page'] > 1)
{
  $offset = (($_POST['page'] - 1) * $limit);
  $page = $_POST['page'];
}
else
{
  $offset = 0;
}

$query = mysqli_query($con, "SELECT * FROM `saleable_cows` JOIN cows ON saleable_cows.cow_id = cows.unique_id ");
$total_Records = mysqli_num_rows($query);

if(!empty($_POST['query'])){
	$qry = $_POST['query'];
  $cows = mysqli_query($con, "SELECT * FROM `saleable_cows` JOIN cows ON saleable_cows.cow_id = cows.unique_id  WHERE saleable_cows.price>={$qry} LIMIT {$offset},{$limit}");
  $total_data = mysqli_num_rows($cows);
  
  
}else{
	$cows = mysqli_query($con, "SELECT * FROM `saleable_cows` JOIN cows ON saleable_cows.cow_id = cows.unique_id  ORDER BY cows.id LIMIT {$offset},{$limit}");
	$total_data = mysqli_num_rows($cows);
}
?>

					<div class="shop-title d-flex flex-wrap justify-content-between">
							<p>Cow Results</p>
							
						</div>
						<div class="shop-product-wrap grid row">
						<?php	if($total_data > 0){
							  foreach($cows as $cow){ ?>
							  	<div class="col-lg-4 col-md-6 col-12">
															
									<div class="product-item">
										<div class="product-thumb">
											<a href="cowDetails.php?CID=<?=$cow['unique_id']?>">
												<img src="backend/<?php echo $cow['image1']?>" alt="cow" style="height: 150px;">
											</a>
											
										</div>
										<div class="product-content">
											<h5><a href="cowDetails.php?CID=<?=$cow['unique_id']?>"><?php echo $cow['unique_id']?></a></h5>
											<p>
												<?php if ($cow['status']==1) {
													echo '<span class="badge badge-success">Available</span>';
												}else{
													echo '<span class="badge badge-danger">Sold Out</span>';
												} ?>
											</p>
											<h6><?php echo $cow['price']?> BDT</h6>
										</div>
									</div>
									
								</div>
							
							<?php  }
							}
							else
							{
							  echo "<h2>No Data Found </h2>";
							}
							echo "</div>";

							$output = '<div class="pagination-area  d-flex flex-wrap justify-content-center">
							<ul class="pagination  d-flex flex-wrap m-0">';
							$total_links = ceil($total_Records/$limit);
							$previous_link = '';
							$next_link = '';
							$page_link = '';
                            $page_array = array();

							// /echo $total_links;

							if($total_links > 4){
							  if($page < 5)
							  {
							    for($count = 1; $count <= 5; $count++)
							    {
							      $page_array[] = $count;
							    }
							    $page_array[] = '...';
							    $page_array[] = $total_links;
							  }
							  else
							  {
							    $end_limit = $total_links - $total_links;
							    if($page > $end_limit)
							    {
							      $page_array[] = 1;
							      $page_array[] = '...';
							      for($count = $end_limit; $count <= $total_links; $count++)
							      {
							        $page_array[] = $count;
							      }
							    }
							    else
							    {
							      $page_array[] = 1;
							      $page_array[] = '...';
							      for($count = $page - 1; $count <= $page + 1; $count++)
							      {
							        $page_array[] = $count;
							      }
							      $page_array[] = '...';
							      $page_array[] = $total_links;
							    }
							  }
							}
							else
							{
							  for($count = 1; $count <= $total_links; $count++)
							  {
							    $page_array[] = $count;
							  }
							}

							for($count = 0; $count < count($page_array); $count++)
							{
							  if($page == $page_array[$count])
							  {
							    $page_link .= '
							    <li class="page-item active disabled">
							      <a class="page-link" href="#">'.$page_array[$count].' <span class="sr-only">(current)</span></a>
							    </li>
							    ';

							    $previous_id = $page_array[$count] - 1;
							    if($previous_id > 0){
							      $previous_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$previous_id.'"><i class="fas fa-arrow-left"></i></a></li>';
							    }
							    else{
							      $previous_link = '
							      <li class="page-item disabled">
							        <a class="page-link" href="#"><i class="fas fa-arrow-left"></i></a>
							      </li>
							      ';
							    }
							    $next_id = $page_array[$count] + 1;
							    if($next_id >= $total_links){
							      $next_link = '
							      <li class="page-item disabled">
							        <a class="page-link" href="#"><i class="fas fa-arrow-right"></i></a>
							      </li>
							        ';
							    }
							    else
							    {
							      $next_link = '<li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$next_id.'"><i class="fas fa-arrow-right"></i></a></li>';
							    }
							  }
							  else
							  {
							    if($page_array[$count] == '...')
							    {
							      $page_link .= '
							      <li class="page-item disabled">
							          <a class="page-link" href="#">...</a>
							      </li>
							      ';
							    }
							    else
							    {
							      $page_link .= '
							      <li class="page-item"><a class="page-link" href="javascript:void(0)" data-page_number="'.$page_array[$count].'">'.$page_array[$count].'</a></li>
							      ';
							    }
							  }
							}

							$output .= $previous_link . $page_link . $next_link;
							$output .= '
							  </ul>
						</div>


							';

							echo $output;

							?>
