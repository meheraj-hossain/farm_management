<?php 
$title = 'Add new admin';
include_once('template/head.php'); 
if(isset($_SESSION['logged_user_id']) && $_SESSION['logged_user_type']==1){ 
$errorMessage = array();
	
if(isset($_POST['submit'])){
	if (empty($_POST['name']) || empty($_POST['phone']) || empty($_POST['gender']) ||  empty($_POST['address']) || empty($_POST['email']) || empty( $_POST['username']) || empty($_POST['password']) || empty($_POST['role']) ) {
		array_push ($errorMessage,"All field must be field out");
    }else{
    	// name
		$name = strip_tags($_POST['name']); 
		$name = ucfirst(strtolower($name));
		$_SESSION['name'] = $name; 

		$gender = strip_tags($_POST['gender']); 
		$_SESSION['gender'] = $gender; 
		
		//Email
		$email = strip_tags($_POST['email']); 
		$email = str_replace(' ', '', $email); 
		$_SESSION['email'] = $email; 

		//username
		$username = strip_tags($_POST['username']); 
		$username = str_replace(' ', '', $username); 
		$_SESSION['username'] = $username; 
		
		//password
		$password = strip_tags($_POST['password']); 

		//address
		$address = strip_tags($_POST['address']);
		$_SESSION['address'] = $address;

		//phone
		$phone = filter_var($_POST['phone'], FILTER_SANITIZE_NUMBER_INT);//take only integer
	    $phone = str_replace("-", "", $phone); 

	    if (strlen($phone) < 11 || strlen($phone) > 14) {
	     array_push ($errorMessage,"Invalid Number");
	    }
	    
	    //check phone number already exist or not in database
		$check_phone_query = mysqli_query($con, "SELECT phone FROM users WHERE phone = '$phone'");
		$num_of_phones = mysqli_num_rows($check_phone_query);

		if($num_of_phones > 0){
			array_push ($errorMessage,"Phone Number already exist");
		} 
	    $_SESSION['phone'] = $phone; 

		//role
		$role = $_POST['role'];
		$_SESSION['role'] = $role;

		

		
		//check if email is in valid format 
		if (filter_var($email, FILTER_VALIDATE_EMAIL)){
			$email = filter_var($email, FILTER_VALIDATE_EMAIL);
			
			//Check if email already exist or not
			$email_check = mysqli_query($con, "SELECT email FROM users WHERE email = '$email'");
			//Count the number of rows returned
			
			$num_row = mysqli_num_rows($email_check);
			//print_r($num_row); exit;
			if($num_row > 0){
				array_push ($errorMessage,"Email already exist");
			}
		}else{
			array_push ($errorMessage,"Invalid Format");
		}
		
		if(preg_match('/[^A-Za-z0-9]/',$password)){
			array_push ($errorMessage,"Password should only contain english character or number");
		}
		
		if(strlen($password) < 5 ){
			array_push ($errorMessage,"Password must be more then 5 characters");
		}

		//check user already exist or not in database
		$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username = '$username'");
		$num_username = mysqli_num_rows($check_username_query);

		if($num_username > 0){
			array_push ($errorMessage,"Username already exist");
		}
    }
	

	if(empty($errorMessage)){
		$password = md5($password); //encrypt password
		
		$insert = mysqli_query($con, "INSERT INTO users VALUE('', '$name', '$gender','assets/img/profile/default.png', '$phone','$address', '$role', '$username', '$email', '$password','',1)");
		$inserted_id = mysqli_insert_id($con);

		if (isset($_POST['salary']) && !empty($_POST['salary'])) {
			$salary = $_POST['salary'];
			$_SESSION['salary'] = $salary;

			$insert_salary = mysqli_query($con,"INSERT INTO staff_basic_salaries VALUE('','$inserted_id','$salary') ");
			if ($insert_salary) {
				$_SESSION["SuccessMessage"] = "New staff created successfully";
				header('Location:userStaffs.php');
			}else{
				array_push ($errorMessage,"Salary Date not saved");
			}			
		}else{
			if ($insert) {
				$_SESSION["SuccessMessage"] = "New admin created successfully";
				header('Location:userAdmins.php');
			}else{
				array_push ($errorMessage,"Date not saved");
			}
		}
		
		//Clear session variables after submission
		$_SESSION['name'] = null;
		$_SESSION['gender'] = null;
		$_SESSION['phone'] = null;
		$_SESSION['address'] = null;
		$_SESSION['role'] = null;
		$_SESSION['username'] = null;
		$_SESSION['email'] = null;
		$_SESSION['password'] = null;
		$_SESSION['salary'] = null;
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
<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js'></script>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>User ADD</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="index.php">Home</a></li>
              <li class="breadcrumb-item active">Admin Add</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      	<div class="container-fluid">
	      	<div style="text-align: center">
	      		<?php 

		        if (count($errorMessage) > 0) {
		        	if(count($errorMessage) ==1){	      		
		        		echo '<h4 style="color:#e74c3c">'. $errorMessage[0]. '</h4>';
		        	}else{ 
		        		foreach ($errorMessage as $value) { ?>
		        			<h5><li style="color:#e74c3c"><?=$value?></li></h5>
		        		<?php } 
		        	}
		        }
		        ?>
	      	</div>
      	
	        <div class="row">
	          <!-- left column -->
	          <div class="col-md-12">
	    		<!-- Horizontal Form -->
	            <div class="card card-info">
	              <div class="card-header">
	                <h3 class="card-title">User Add</h3>
	              </div>
	              <!-- /.card-header -->
	              <!-- form start -->
	              <form class="form-horizontal" action="" method="POST">
	                <div class="card-body">
	                	<div class="form-group row">
		                    <label for="name" class="col-sm-2 col-form-label">Name</label>
		                    <div class="col-sm-10">
		                      <input type="text" name="name" class="form-control" id="name" placeholder="Name" value="<?php if(isset($_SESSION['name'])) { echo $_SESSION['name']; }  ?>">
		                    </div>
		                </div>

		                <div class="form-group row">
	                        <label class="col-sm-2 col-form-label">Gender</label>
	                        <div class="col-sm-10">
		                        <select name="gender" class="form-control" id="gender">
		                          	<?php 
                                    if (isset($_SESSION['gender']) && $_SESSION['gender']=='Male') {
                                        echo "<option value=''>Select Gender</option>";
                                        echo "<option selected='' value='Male'>Male</option>";
                                        echo "<option value='Female'>Female</option>";
                                        echo "<option value='Other'>Other</option>";
                                    }elseif (isset($_SESSION['gender']) && $_SESSION['gender']=='Female') {
                                        echo "<option value=''>Select Gender</option>";
                                        echo "<option value='Male'>Male</option>";
                                        echo "<option selected='' value='Female'>Female</option>";
                                        echo "<option value='Other'>Other</option>";
                                    }elseif (isset($_SESSION['gender']) && $_SESSION['gender']=='Other') {
                                        echo "<option value=''>Select Gender</option>";
                                        echo "<option value='Male'>Male</option>";
                                        echo "<option value='Female'>Female</option>";
                                        echo "<option selected='' value='Other'>Other</option>";
                                    }else{ ?>
                                        <option value="">Select Gender</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Other">Other</option>
                                    <?php }
                                    ?>  
		                        </select>
		                    </div>
                      	</div>

	                   <div class="form-group row">
	                    <label for="phone" class="col-sm-2 col-form-label">Phone</label>
	                    <div class="col-sm-10">
	                      <input type="text" name="phone" class="form-control" id="phone" placeholder="Phone" value="<?php if(isset($_SESSION['phone'])) { echo $_SESSION['phone']; }  ?>">
	                    </div>
	                  </div>

	                   <div class="form-group row">
	                    <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
	                    <div class="col-sm-10">
	                      <input type="email" name="email" class="form-control" id="inputEmail3" placeholder="Email" value="<?php if(isset($_SESSION['email'])) { echo $_SESSION['email']; }  ?>">
	                    </div>
	                  </div>

	                   <div class="form-group row">
	                    <label for="address" class="col-sm-2 col-form-label">Address</label>
	                    <div class="col-sm-10">
	                      <input type="text" name="address" class="form-control" id="address" placeholder="Address" value="<?php if(isset($_SESSION['address'])) { echo $_SESSION['address']; }  ?>">
	                    </div>
	                  </div>

	                   <div class="form-group row">
	                    <label for="username" class="col-sm-2 col-form-label">Username</label>
	                    <div class="col-sm-10">
	                      <input type="text" name="username" class="form-control" id="username" placeholder="Username" value="<?php if(isset($_SESSION['username'])) { echo $_SESSION['username']; }  ?>">
	                    </div>
	                  </div>
	                  
	                  	<div class="form-group row">
		                    <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
		                    <div class="col-sm-10">
		                      <input type="password" name="password" class="form-control" id="inputPassword3" placeholder="Password">
		                    </div>
	                  	</div>

	                  	<div class="form-group row">
	                        <label class="col-sm-2 col-form-label">Role</label>
	                        <div class="col-sm-10">
		                        <select name="role" class="form-control" id="role"  onchange="changeFunc()">
		                          <?php 
                                    if (isset($_SESSION['role']) && $_SESSION['role']=='1') {
                                        echo "<option value=''>Select Role</option>";
                                        echo "<option selected='' value='1'>Admin</option>";
                                        echo "<option value='2'>Staff</option>";
                                    }elseif (isset($_SESSION['role']) && $_SESSION['role']=='2') {
                                        echo "<option value=''>Select Role</option>";
                                        echo "<option value='1'>Admin</option>";
                                        echo "<option selected='' value='2'>Staff</option>";
                                    }else{ ?>
                                        <option value="">Select Role</option>
                                        <option value="1">Admin</option>
                                        <option value="2">Staff</option>
                                    <?php }
                                    ?>  
		                        </select>
		                    </div>
                      	</div>
                      	
	                    <div class="form-group row" id="sala">
		                    <label for="salary" class="col-sm-2 col-form-label">Slaray</label>
		                    <div class="col-sm-10">
		                      <input type="number"  min="0" name="salary" class="form-control" id="salary" placeholder="Salary">
		                    </div>
		                </div>
	                </div>
	                <!-- /.card-body -->
	                <div class="card-footer">
	                  <button type="submit" name="submit" class="btn btn-info">Submit</button>
	                  <button type="submit" class="btn btn-default float-right">Cancel</button>
	                </div>
	                <!-- /.card-footer -->
	              </form>
	            </div>
	            <!-- /.card -->

	          </div>
			</div>
	        <!-- /.row -->
      	</div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->


</div>
  <!-- /.content-wrapper -->
<?php include_once('template/footer.php'); ?>
<script type="text/javascript">
	function changeFunc() {
		var role = document.getElementById("role");
		var selectedValue = role.options[role.selectedIndex].value;
		if (selectedValue=="2"){
			$('#sala').show();
		}else{
			$('#sala').hide();
		}
	}
</script>
<?php } else{
	header('Location: Login.php');
}