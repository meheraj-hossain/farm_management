<?php
	//connection variables
	$host = 'localhost';
	$user = 'root';
	$password = '';

	//create mysql connection
	$con = new mysqli($host,$user,$password);
	if ($con->connect_errno) {
	    printf("Connection failed: %s\n", $con->connect_error);
	    die();
	}

	//SQL to drop database;
	$sqlToDropDB = "DROP DATABASE IF EXISTS farm_management;";
	if ($con->query($sqlToDropDB) === TRUE) {
		echo "Database droped successfully<br>";
	} else {
		echo "Error: " . $sqlToDropDB . "<br>" . $con->error. "<br>";
	}

	//create the database
	if ( !$con->query('CREATE DATABASE farm_management') ) {
	    printf("Errormessage: %s\n", $con->error);
	}

	//Creating connection object with database name;
	$sqlToUseDB = "USE farm_management;";
	if ($con->query($sqlToUseDB) === TRUE) {
		echo "Database selected successfully<br>";
	} else {
		echo "Error: " . $sqlToUseDB . "<br>" . $con->error. "<br>";
	}

	//SQL to create table users
	$users_sql = "CREATE TABLE `users` (
	  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  `name` varchar(50) NOT NULL,
	  `gender` varchar(8) NOT NULL,
	  `image` varchar(255) NOT NULL,
	  `phone` varchar(30) NOT NULL,
	  `address` varchar(50) NOT NULL,
	  `role` int(2) NOT NULL,
	  `username` varchar(30) NOT NULL,
	  `email` varchar(80) NOT NULL,
	  `password` varchar(255) NOT NULL,
	  `verification_key` varchar(255) NOT NULL,
	  `verified` int(2) NOT NULL COMMENT '0-NO, 1-YES'
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;";


	if ($con->query($users_sql) === TRUE) {
		echo "users table created successfully<br>";
	} else {
		echo "Error: " . $users_sql . "<br>" . $con->error. "<br>";
	}

	//insert admin
	$insert_admin = "INSERT INTO `farm_management`.`users`(`name`,`gender`,`image`,`phone`,`address`,`role`,`username`,`email`, `password`,`verification_key`,`verified`) VALUES ('Admin','Male','assets/img/profile/default.png','8801689876543','166/a Mirpur,Dhaka',1,'Admin','noman@admin.com', 'e10adc3949ba59abbe56e057f20f883e','',1);";

	if ($con->query($insert_admin) === TRUE) {
		echo "Admin created successfully<br>
		<b>username:Admin<br>password:123456</b><br><br>";
	} else {
		echo "Error: " . $insert_admin . "<br>" . $con->error. "<br>";
	}

	//SQL to create table staff_basic_salaries
	$staff_basic_salaries_sql = "CREATE TABLE `staff_basic_salaries` (
	  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  `staff_id` int(11) NOT NULL,
	  `salary` float(8,2) NOT NULL
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	if ($con->query($staff_basic_salaries_sql) === TRUE) {
		echo "staff_basic_salaries table created successfully<br>";
	} else {
		echo "Error: " . $staff_basic_salaries_sql . "<br>" . $con->error. "<br>";
	}

	//SQL to create table staff_salaries
	$staff_salaries_sql = "CREATE TABLE `staff_salaries` (
	  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  `staff_id` int(11) NOT NULL,
	  `category_id` int(11) NOT NULL,
	  `salary_paid` float(8,2) NOT NULL,
	  `pay_date` date NOT NULL
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	if ($con->query($staff_salaries_sql) === TRUE) {
		echo "staff_salaries table created successfully<br>";
	} else {
		echo "Error: " . $staff_salaries_sql . "<br>" . $con->error. "<br>";
	}

	//SQL to create table cows
	$cows_sql = "CREATE TABLE `cows` (
	  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  `unique_id` varchar(50) NOT NULL,
	  `image1` varchar(255) NOT NULL,
	  `image2` varchar(255) NOT NULL,
	  `image3` varchar(255) NOT NULL,
	  `category_id` int(11) NOT NULL,
	  `entry_date` date NOT NULL,
	  `birth_date` date NOT NULL,
	  `weight` float(6,2) NOT NULL,
	  `description` text NOT NULL,
	  `status` int(2) NOT NULL COMMENT '0-sold, 1-available'
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	if ($con->query($cows_sql) === TRUE) {
		echo "cow_categories table created successfully<br>";
	} else {
		echo "Error: " . $cows_sql . "<br>" . $con->error. "<br>";
	}

	//SQL to create table discount_codes
	$discount_codes_sql = "CREATE TABLE `discount_codes` (
	  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  `code` varchar(50) NOT NULL,
	  `cow_id` varchar(50) NOT NULL,
	  `amount` float(9,2) NOT NULL
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	if ($con->query($discount_codes_sql) === TRUE) {
		echo "discount_codes table created successfully<br>";
	} else {
		echo "Error: " . $discount_codes_sql . "<br>" . $con->error. "<br>";
	}


	//SQL to create table saleable_cows
	$saleable_cows_sql = "CREATE TABLE `saleable_cows` (
	  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  `cow_id` int(11) NOT NULL,
	  `price` varchar(255) NOT NULL,
	  CONSTRAINT FK_SaleableCow FOREIGN KEY (cow_id)
      REFERENCES cows(id)
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	if ($con->query($saleable_cows_sql) === TRUE) {
		echo "saleable_cows table created successfully<br>";
	} else {
		echo "Error: " . $saleable_cows_sql . "<br>" . $con->error. "<br>";
	}

	//SQL to create table milk_requests
	$milk_requests_sql = "CREATE TABLE `milk_requests` (
	  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  `customer_name` varchar(40) NOT NULL,
	  `customer_email` varchar(80) NOT NULL,
	  `customer_phone` varchar(20) NOT NULL,
	  `milk_quantity` int(11) NOT NULL,
	  `request_date` date NOT NULL,
	  `required_at` date NOT NULL,
	  `status` int(2) NOT NULL COMMENT '1-Pending, 2-Responsed'
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	if ($con->query($milk_requests_sql) === TRUE) {
		echo "milk_requests table created successfully<br>";
	} else {
		echo "Error: " . $milk_requests_sql . "<br>" . $con->error. "<br>";
	}

	//SQL to create table cow_sellings
	$cow_sellings_sql = "CREATE TABLE `cow_sellings` (
	  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  `customer_name` varchar(50) NOT NULL,
	  `customer_phone` varchar(50) NOT NULL,
	  `cow_id` int(11) NOT NULL,
	  `selling_price` float(8,2) NOT NULL,
	  `order_date` date NOT NULL,
	  `payment_status` int(2) NOT NULL COMMENT '1-Paid, 2-Unpaid',
	  `delivery_status` int(2) NOT NULL COMMENT '1-delivered, 2-pending',
	  `delivery_date` date NULL,
	  FOREIGN KEY (cow_id) REFERENCES cows(id)
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	if ($con->query($cow_sellings_sql) === TRUE) {
		echo "cow_sellings table created successfully<br>";
	} else {
		echo "Error: " . $cow_sellings_sql . "<br>" . $con->error. "<br>";
	}

	//SQL to create table cow_sellings
	$cow_selling_transactions_sql = "CREATE TABLE `cow_selling_transactions` (
	  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  `transaction_id` varchar(255) NOT NULL,
	  `transaction_type` varchar(100) NOT NULL,
	  `transaction_date` varchar(50) NOT NULL,
	  `cow_id` varchar(50) NOT NULL
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	if ($con->query($cow_selling_transactions_sql) === TRUE) {
		echo "cow_selling_transactions table created successfully<br>";
	} else {
		echo "Error: " . $cow_selling_transactions_sql . "<br>" . $con->error. "<br>";
	}

	//SQL to create table cow_foods
	$cow_foods_sql = "CREATE TABLE `cow_foods` (
	  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  `name` varchar(50) NOT NULL,
	  `stock` float(6,2) NOT NULL
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	if ($con->query($cow_foods_sql) === TRUE) {
		echo "cow_foods table created successfully<br>";
	} else {
		echo "Error: " . $cow_foods_sql . "<br>" . $con->error. "<br>";
	}

	//SQL to create table cow_food_required_perday
	$cow_food_required_perday_sql = "CREATE TABLE `cow_food_required_perday` (
	  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  `cow_category_id` int(11) NOT NULL,
	  `min_age` int(11) NOT NULL,
	  `max_age` int(11) NOT NULL,
	  `food_id` int(11) NOT NULL,
	  `quantity` float(8,2) NOT NULL,
	  FOREIGN KEY (food_id) REFERENCES cow_foods(id) ON DELETE CASCADE ON UPDATE CASCADE
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	if ($con->query($cow_food_required_perday_sql) === TRUE) {
		echo "cow_food_required_perday table created successfully<br>";
	} else {
		echo "Error: " . $cow_food_required_perday_sql . "<br>" . $con->error. "<br>";
	}

	//SQL to create table cow_food_expenses
	$cow_food_expenses_sql = "CREATE TABLE `cow_food_expenses` (
	  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  `food_id` int(11) NOT NULL,
	  `quantity` int(11) NOT NULL,
	  `unit_price` float(8,2) NOT NULL,
	  `total_price` float(8,2) NOT NULL,
	  `buy_at` date NOT NULL,
	  CONSTRAINT FK_cowFodd FOREIGN KEY (food_id)
      REFERENCES cow_foods(id) ON DELETE CASCADE ON UPDATE CASCADE
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	if ($con->query($cow_food_expenses_sql) === TRUE) {
		echo "cow_food_expenses table created successfully<br>";
	} else {
		echo "Error: " . $cow_food_expenses_sql . "<br>" . $con->error. "<br>";
	}

	//SQL to create table cow_feeds
	$cow_feeds_sql = "CREATE TABLE `cow_feeds` (
	  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  `food_id` int(11) NOT NULL,
	  `quantity` int(11) NOT NULL,
	  `feed_at` date NOT NULL,
	  FOREIGN KEY (food_id) REFERENCES cow_foods(id) ON DELETE CASCADE ON UPDATE CASCADE
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	if ($con->query($cow_feeds_sql) === TRUE) {
		echo "cow_feeds table created successfully<br>";
	} else {
		echo "Error: " . $cow_feeds_sql . "<br>" . $con->error. "<br>";
	}

	//SQL to create table milk_collections
	$milk_collections_sql = "CREATE TABLE `milk_collections` (
	  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  `quantity` int(11) NOT NULL,
	  `collection_date` date NOT NULL
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	if ($con->query($milk_collections_sql) === TRUE) {
		echo "milk_collections table created successfully<br>";
	} else {
		echo "Error: " . $milk_collections_sql . "<br>" . $con->error. "<br>";
	}

	//SQL to create table milk_sellings
	$milk_sellings_sql = "CREATE TABLE `milk_sellings` (
	  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  `quantity` int(11) NOT NULL,
	  `unit_price` float(8,2) NOT NULL,
	  `total_price` float(8,2) NOT NULL,
	  `selling_date` date NOT NULL
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	if ($con->query($milk_sellings_sql) === TRUE) {
		echo "milk_sellings table created successfully<br>";
	} else {
		echo "Error: " . $milk_sellings_sql . "<br>" . $con->error. "<br>";
	}

	//SQL to create table vaccines
	$vaccines_sql = "CREATE TABLE `vaccines` (
	  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  `name` varchar(50) NOT NULL,
	  `stock` float(6,2) NOT NULL
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	if ($con->query($vaccines_sql) === TRUE) {
		echo "vaccines table created successfully<br>";
	} else {
		echo "Error: " . $vaccines_sql . "<br>" . $con->error. "<br>";
	}

	//SQL to create table vaccine_expenses
	$vaccine_expenses_sql = "CREATE TABLE `vaccine_expenses` (
	  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  `vaccine_id` int(11) NOT NULL,
	  `unit_price` float(8,2) NOT NULL,
	  `quantity` int(5) NOT NULL,
	  `total_price` float(9,2) NOT NULL,
	  `buy_at` date NOT NULL,
	  FOREIGN KEY (vaccine_id) REFERENCES vaccines(id) ON DELETE CASCADE ON UPDATE CASCADE 
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	if ($con->query($vaccine_expenses_sql) === TRUE) {
		echo "vaccine_expenses table created successfully<br>";
	} else {
		echo "Error: " . $vaccine_expenses_sql . "<br>" . $con->error. "<br>";
	}


	//SQL to create table vaccinations
	$vaccinations_sql = "CREATE TABLE `vaccinations` (
	  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  `vaccine_id` int(11) NOT NULL,
	  `cow_id` int(11) NOT NULL,
	  `quantity` int(5) NOT NULL,
	  `vaccined_date` date NOT NULL,
	  `next_vaccined_date` date NULL,
	  `opened` int(1) NULL,
	  `viewed` int(1) NULL,
	  FOREIGN KEY (vaccine_id) REFERENCES vaccines(id) ON DELETE CASCADE ON UPDATE CASCADE,
	  FOREIGN KEY (cow_id) REFERENCES cows(id) ON DELETE CASCADE ON UPDATE CASCADE 
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	if ($con->query($vaccinations_sql) === TRUE) {
		echo "vaccinations table created successfully<br>";
	} else {
		echo "Error: " . $vaccinations_sql . "<br>" . $con->error. "<br>";
	}

	//SQL to create table notifications
	$notifications_sql = "CREATE TABLE `notifications` (
	  `id` int(11) NOT NULL AUTO_INCREMENT PRIMARY KEY,
	  `title` varchar(100) NOT NULL,
	  `message` varchar(255) NOT NULL,
	  `message_for` varchar(150) NOT NULL,
	  `opened` int(1) NOT NULL,
	  `viewed` int(1) NOT NULL
	)ENGINE=InnoDB DEFAULT CHARSET=utf8;";

	if ($con->query($notifications_sql) === TRUE) {
		echo "notifications table created successfully<br>";
	} else {
		echo "Error: " . $notifications_sql . "<br>" . $con->error. "<br>";
	}

	echo "<br><br>";

	//create sql view milk_stocks
	$milk_stocks_view = "CREATE VIEW milk_stocks AS
	SELECT SUM(( SELECT SUM(quantity) FROM milk_collections) - (SELECT SUM(quantity) FROM milk_sellings) ) AS milkStock";

	if ($con->query($milk_stocks_view) === TRUE) {
		echo "milk_stocks view table created successfully<br>";
	} else {
		echo "Error: " . $milk_stocks_view . "<br>" . $con->error. "<br>";
	}