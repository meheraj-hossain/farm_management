<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <!-- Notification Dropdown Menu -->
      <?php if ($_SESSION['logged_user_type'] == 1) { ?>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="reports.php" class="nav-link">Reports</a>
      </li>
    <?php } ?>
    </ul>

    <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <?php 
      $today = date('Y-m-d');
      $vac_query = mysqli_query($con, "SELECT * FROM vaccinations WHERE next_vaccined_date <='$today' AND opened=0  ORDER BY id DESC");
      $num_vac_query = mysqli_num_rows($vac_query);

      $numof_vac_notification_unread = mysqli_query($con,"SELECT * FROM vaccinations WHERE next_vaccined_date <='$today' AND viewed=0");
      $vac_numOfRow = mysqli_num_rows($numof_vac_notification_unread);
      ?>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" id="vacc-notify">
          <i class="fas fa-syringe"></i>
          <span class="badge badge-danger navbar-badge" id="vacc-badge"><?php if($vac_numOfRow > 0 ) echo $vac_numOfRow; ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header"><?=$vac_numOfRow?> Notifications</span>
          <div class="dropdown-divider"></div>
          <?php
          if ($num_vac_query > 0) {
            while ($vac_noitfication = mysqli_fetch_array($vac_query)) {
              //get cow's data
              $CowId = $vac_noitfication['cow_id'];
              $cowData = mysqli_fetch_array(mysqli_query($con,"SELECT unique_id FROM cows WHERE id='$CowId'"))
            ?>
          <a href="vaccinationAdd.php" class="dropdown-item" id='vaccine-item'>
            <i class="fas fa-envelope mr-2"></i> Today <?php echo $cowData['unique_id']; ?> cow will have a vaccine</p>
            <input type="hidden" value="<?php echo $vac_noitfication['id']?>" id="vac-noitfication-id">
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <?php 
                  } 
                }else{?>
                    <div class="dropdown-item">
                      <h3 class="dropdown-item-title">
                        There is no data
                      </h3>
                    </div>
                <?php   
                }
                ?>
          <div class="dropdown-divider"></div>
          
        </div>
      </li>


      <!-- Notification Dropdown Menu -->
      <?php if ($_SESSION['logged_user_type'] == 1) { ?>
      
      <?php 
      $current_date = date('Y-m-d');
      $query = mysqli_query($con, "SELECT * FROM notifications WHERE opened=0  ORDER BY id DESC");
      $num_query = mysqli_num_rows($query);

      $numof_notification_unread = mysqli_query($con,"SELECT * FROM notifications WHERE viewed=0");
      $numOfRow = mysqli_num_rows($numof_notification_unread);
      ?>
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#" id="notify-link">
          <i class="far fa-bell"></i>
          <span class="badge badge-danger navbar-badge" id="notify-badge"><?php if($numOfRow > 0 ) echo $numOfRow; ?></span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <?php
                if ($num_query > 0) {
                  while ($noitfication = mysqli_fetch_array($query)) {
                  ?>
                    <a href="<?php echo $noitfication['message_for']; ?>" class="dropdown-item" id='notify-item'>
                      <!-- Message Start -->
                      <div class="media">
                        <div class="media-body">
                          <h3 class="dropdown-item-title">
                            <?php echo $noitfication['title']; ?>
                            
                          </h3>
                          <p class="text-sm"><?php echo $noitfication['message']; ?></p>
                          <input type="hidden" value="<?php echo $noitfication['id']?>" id="noitfication-id">
                          
                        </div>
                      </div>
                      <!-- Message End -->
                    </a>
          <?php 
                  } 
                }else{?>
                    <div class="dropdown-item">
                      <h3 class="dropdown-item-title">
                        There is no data
                      </h3>
                    </div>
                <?php   
                }
                ?>
          <div class="dropdown-divider"></div>
          
        </div>
      </li>
      <?php } ?>
      <li class="nav-item">
        <a class="nav-link" data-widget="fullscreen" href="#" role="button">
          <i class="fas fa-expand-arrows-alt"></i>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
          <i class="fas fa-th-large"></i>
        </a>
      </li>
    </ul>
  </nav>

<script>
  //other notifications
$(document).ready(function(){
  $('#notify-link').click(function() {
    jQuery.ajax({
      url:'helpers/notification.php',
      success:function(){
        $('#notify-badge').fadeOut('slow');
      }
    })
  });


  var noitfication_id = $('#noitfication-id').val();
  $('#notify-item').click(function() {
    jQuery.ajax({
      type:"GET",
      url:'helpers/notification.php',
      data:{id:noitfication_id},
      
    })
  });

}); 

</script>

<script>
  //vaccination notificaiton
$(document).ready(function(){
  $('#vacc-notify').click(function() {
    jQuery.ajax({
      url:'helpers/vaccineNotification.php',
      success:function(){
        $('#vacc-badge').fadeOut('slow');
      }
    })
  });


  var vac_noitfication_id = $('#vac-noitfication-id').val();
  $('#vaccine-item').click(function() {
    jQuery.ajax({
      type:"GET",
      url:'helpers/vaccineNotification.php',
      data:{id:vac_noitfication_id},
      
    })
  });

}); 
</script>