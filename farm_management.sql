-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 28, 2021 at 11:00 AM
-- Server version: 10.4.18-MariaDB
-- PHP Version: 8.0.5

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `farm_management`
--

-- --------------------------------------------------------

--
-- Table structure for table `cows`
--

CREATE TABLE `cows` (
  `id` int(11) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cows`
--

INSERT INTO `cows` (`id`, `unique_id`, `image1`, `image2`, `image3`, `category_id`, `entry_date`, `birth_date`, `weight`, `description`, `status`) VALUES
(1, '1Caws', 'assets/img/cows/9ccb0641078b5712b5994b5f06c82e951a8606ee62c6c8b8ee3172df50c09b23Shindhi-Cross-Breed-Red-and-Black-151260-tk.jpg', 'assets/img/cows/313202ad547dc90e37640ddca2807fb71a8606ee62c6c8b8ee3172df50c09b23Shindhi-Cross-Breed-Red-and-Black-151260-tk.jpg', 'assets/img/cows/5e87d80e924049f2cd342474a4c053451a8606ee62c6c8b8ee3172df50c09b23Shindhi-Cross-Breed-Red-and-Black-151260-tk.jpg', 1, '2021-05-13', '2018-03-08', 200.00, 'perfect desi cow', 1),
(2, '2Cows', 'assets/img/cows/9f8941f3131f3edb7bee4a9f4b9dd8041c17e12b8b27967bc428504c45296e5aMoreno-Ms.-Lady-Rolls-Royce-404.jpg', 'assets/img/cows/fb71cefb3a346b8e7871dea6ff7998581c17e12b8b27967bc428504c45296e5aMoreno-Ms.-Lady-Rolls-Royce-404.jpg', 'assets/img/cows/f317928a417ccd18c23d09126903b9751c17e12b8b27967bc428504c45296e5aMoreno-Ms.-Lady-Rolls-Royce-404.jpg', 1, '2021-05-24', '2018-03-08', 200.00, 'best for large amount of meat', 1),
(3, '3cowm', 'assets/img/cows/d63bbe076337aa2ecedad3159a495cf9images.jpg', 'assets/img/cows/65fa651e2d8bcbcbbd1ff0942fa53f9bimages.jpg', 'assets/img/cows/f03c1c7f648c4230a9308013b4dc15f7images.jpg', 2, '2021-05-24', '2018-03-08', 160.00, 'provides 20kg milk daily', 1);

-- --------------------------------------------------------

--
-- Table structure for table `cow_feeds`
--

CREATE TABLE `cow_feeds` (
  `id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `feed_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cow_feeds`
--

INSERT INTO `cow_feeds` (`id`, `food_id`, `quantity`, `feed_at`) VALUES
(1, 1, 1, '2021-05-19');

-- --------------------------------------------------------

--
-- Table structure for table `cow_foods`
--

CREATE TABLE `cow_foods` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `stock` float(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cow_foods`
--

INSERT INTO `cow_foods` (`id`, `name`, `stock`) VALUES
(1, 'barn', 19.00),
(2, 'straw', 15.00);

-- --------------------------------------------------------

--
-- Table structure for table `cow_food_expenses`
--

CREATE TABLE `cow_food_expenses` (
  `id` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` float(8,2) NOT NULL,
  `total_price` float(8,2) NOT NULL,
  `buy_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cow_food_expenses`
--

INSERT INTO `cow_food_expenses` (`id`, `food_id`, `quantity`, `unit_price`, `total_price`, `buy_at`) VALUES
(1, 1, 20, 40.00, 800.00, '2021-05-08'),
(2, 2, 15, 80.00, 1200.00, '2021-05-15');

-- --------------------------------------------------------

--
-- Table structure for table `cow_food_required_perday`
--

CREATE TABLE `cow_food_required_perday` (
  `id` int(11) NOT NULL,
  `cow_category_id` int(11) NOT NULL,
  `min_age` int(11) NOT NULL,
  `max_age` int(11) NOT NULL,
  `food_id` int(11) NOT NULL,
  `quantity` float(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `cow_food_required_perday`
--

INSERT INTO `cow_food_required_perday` (`id`, `cow_category_id`, `min_age`, `max_age`, `food_id`, `quantity`) VALUES
(1, 1, 1, 2, 1, 1.00),
(2, 2, 1, 2, 2, 0.50);

-- --------------------------------------------------------

--
-- Table structure for table `cow_sellings`
--

CREATE TABLE `cow_sellings` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(50) NOT NULL,
  `customer_phone` varchar(50) NOT NULL,
  `cow_id` int(11) NOT NULL,
  `selling_price` float(8,2) NOT NULL,
  `order_date` date NOT NULL,
  `payment_status` int(2) NOT NULL COMMENT '1-Paid, 2-Unpaid',
  `delivery_status` int(2) NOT NULL COMMENT '1-delivered, 2-pending',
  `delivery_date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `cow_selling_transactions`
--

CREATE TABLE `cow_selling_transactions` (
  `id` int(11) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `transaction_type` varchar(100) NOT NULL,
  `transaction_date` varchar(50) NOT NULL,
  `cow_id` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `discount_codes`
--

CREATE TABLE `discount_codes` (
  `id` int(11) NOT NULL,
  `code` varchar(50) NOT NULL,
  `cow_id` varchar(50) NOT NULL,
  `amount` float(9,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `milk_collections`
--

CREATE TABLE `milk_collections` (
  `id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `collection_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `milk_collections`
--

INSERT INTO `milk_collections` (`id`, `quantity`, `collection_date`) VALUES
(1, 20, '2021-05-19');

-- --------------------------------------------------------

--
-- Table structure for table `milk_requests`
--

CREATE TABLE `milk_requests` (
  `id` int(11) NOT NULL,
  `customer_name` varchar(40) NOT NULL,
  `customer_email` varchar(80) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `milk_quantity` int(11) NOT NULL,
  `request_date` date NOT NULL,
  `required_at` date NOT NULL,
  `status` int(2) NOT NULL COMMENT '1-Pending, 2-Responsed'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `milk_sellings`
--

CREATE TABLE `milk_sellings` (
  `id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit_price` float(8,2) NOT NULL,
  `total_price` float(8,2) NOT NULL,
  `selling_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `milk_sellings`
--

INSERT INTO `milk_sellings` (`id`, `quantity`, `unit_price`, `total_price`, `selling_date`) VALUES
(1, 6, 100.00, 600.00, '2021-05-21');

-- --------------------------------------------------------

--
-- Stand-in structure for view `milk_stocks`
-- (See below for the actual view)
--
CREATE TABLE `milk_stocks` (
`milkStock` decimal(55,0)
);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `message` varchar(255) NOT NULL,
  `message_for` varchar(150) NOT NULL,
  `opened` int(1) NOT NULL,
  `viewed` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `saleable_cows`
--

CREATE TABLE `saleable_cows` (
  `id` int(11) NOT NULL,
  `cow_id` int(11) NOT NULL,
  `price` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `saleable_cows`
--

INSERT INTO `saleable_cows` (`id`, `cow_id`, `price`) VALUES
(1, 1, '150000'),
(2, 2, '180000');

-- --------------------------------------------------------

--
-- Table structure for table `staff_basic_salaries`
--

CREATE TABLE `staff_basic_salaries` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `salary` float(8,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `staff_basic_salaries`
--

INSERT INTO `staff_basic_salaries` (`id`, `staff_id`, `salary`) VALUES
(1, 2, 20000.00);

-- --------------------------------------------------------

--
-- Table structure for table `staff_salaries`
--

CREATE TABLE `staff_salaries` (
  `id` int(11) NOT NULL,
  `staff_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `salary_paid` float(8,2) NOT NULL,
  `pay_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `gender`, `image`, `phone`, `address`, `role`, `username`, `email`, `password`, `verification_key`, `verified`) VALUES
(1, 'Admin', 'Male', 'assets/img/profile/default.png', '8801689876543', '166/a Mirpur,Dhaka', 1, 'Admin', 'noman@admin.com', 'e10adc3949ba59abbe56e057f20f883e', '', 1),
(2, 'Miraj', 'Male', 'assets/img/profile/default.png', '01533536240', 'shatinagr,Dhaka', 2, 'miraj1', '100739@daffodil.ac', '25d55ad283aa400af464c76d713c07ad', '', 1);

-- --------------------------------------------------------

--
-- Table structure for table `vaccinations`
--

CREATE TABLE `vaccinations` (
  `id` int(11) NOT NULL,
  `vaccine_id` int(11) NOT NULL,
  `cow_id` int(11) NOT NULL,
  `quantity` int(5) NOT NULL,
  `vaccined_date` date NOT NULL,
  `next_vaccined_date` date DEFAULT NULL,
  `opened` int(1) DEFAULT NULL,
  `viewed` int(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vaccinations`
--

INSERT INTO `vaccinations` (`id`, `vaccine_id`, `cow_id`, `quantity`, `vaccined_date`, `next_vaccined_date`, `opened`, `viewed`) VALUES
(1, 1, 1, 1, '2021-05-24', '2021-12-22', 0, 0),
(2, 2, 2, 2, '2021-05-25', '2021-11-18', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `vaccines`
--

CREATE TABLE `vaccines` (
  `id` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `stock` float(6,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vaccines`
--

INSERT INTO `vaccines` (`id`, `name`, `stock`) VALUES
(1, 'Foot and mouth disease', 6.00),
(2, 'Fangas', 3.00);

-- --------------------------------------------------------

--
-- Table structure for table `vaccine_expenses`
--

CREATE TABLE `vaccine_expenses` (
  `id` int(11) NOT NULL,
  `vaccine_id` int(11) NOT NULL,
  `unit_price` float(8,2) NOT NULL,
  `quantity` int(5) NOT NULL,
  `total_price` float(9,2) NOT NULL,
  `buy_at` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `vaccine_expenses`
--

INSERT INTO `vaccine_expenses` (`id`, `vaccine_id`, `unit_price`, `quantity`, `total_price`, `buy_at`) VALUES
(1, 2, 300.00, 5, 1500.00, '2021-05-15'),
(2, 1, 500.00, 7, 3500.00, '2021-05-15');

-- --------------------------------------------------------

--
-- Structure for view `milk_stocks`
--
DROP TABLE IF EXISTS `milk_stocks`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `milk_stocks`  AS SELECT sum((select sum(`milk_collections`.`quantity`) from `milk_collections`) - (select sum(`milk_sellings`.`quantity`) from `milk_sellings`)) AS `milkStock` ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cows`
--
ALTER TABLE `cows`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cow_feeds`
--
ALTER TABLE `cow_feeds`
  ADD PRIMARY KEY (`id`),
  ADD KEY `food_id` (`food_id`);

--
-- Indexes for table `cow_foods`
--
ALTER TABLE `cow_foods`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cow_food_expenses`
--
ALTER TABLE `cow_food_expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_cowFodd` (`food_id`);

--
-- Indexes for table `cow_food_required_perday`
--
ALTER TABLE `cow_food_required_perday`
  ADD PRIMARY KEY (`id`),
  ADD KEY `food_id` (`food_id`);

--
-- Indexes for table `cow_sellings`
--
ALTER TABLE `cow_sellings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `cow_id` (`cow_id`);

--
-- Indexes for table `cow_selling_transactions`
--
ALTER TABLE `cow_selling_transactions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `discount_codes`
--
ALTER TABLE `discount_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `milk_collections`
--
ALTER TABLE `milk_collections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `milk_requests`
--
ALTER TABLE `milk_requests`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `milk_sellings`
--
ALTER TABLE `milk_sellings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `saleable_cows`
--
ALTER TABLE `saleable_cows`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_SaleableCow` (`cow_id`);

--
-- Indexes for table `staff_basic_salaries`
--
ALTER TABLE `staff_basic_salaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `staff_salaries`
--
ALTER TABLE `staff_salaries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vaccinations`
--
ALTER TABLE `vaccinations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vaccine_id` (`vaccine_id`),
  ADD KEY `cow_id` (`cow_id`);

--
-- Indexes for table `vaccines`
--
ALTER TABLE `vaccines`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `vaccine_expenses`
--
ALTER TABLE `vaccine_expenses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `vaccine_id` (`vaccine_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cows`
--
ALTER TABLE `cows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cow_feeds`
--
ALTER TABLE `cow_feeds`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `cow_foods`
--
ALTER TABLE `cow_foods`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cow_food_expenses`
--
ALTER TABLE `cow_food_expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cow_food_required_perday`
--
ALTER TABLE `cow_food_required_perday`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cow_sellings`
--
ALTER TABLE `cow_sellings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cow_selling_transactions`
--
ALTER TABLE `cow_selling_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `discount_codes`
--
ALTER TABLE `discount_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `milk_collections`
--
ALTER TABLE `milk_collections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `milk_requests`
--
ALTER TABLE `milk_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `milk_sellings`
--
ALTER TABLE `milk_sellings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `saleable_cows`
--
ALTER TABLE `saleable_cows`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `staff_basic_salaries`
--
ALTER TABLE `staff_basic_salaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `staff_salaries`
--
ALTER TABLE `staff_salaries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vaccinations`
--
ALTER TABLE `vaccinations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vaccines`
--
ALTER TABLE `vaccines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `vaccine_expenses`
--
ALTER TABLE `vaccine_expenses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cow_feeds`
--
ALTER TABLE `cow_feeds`
  ADD CONSTRAINT `cow_feeds_ibfk_1` FOREIGN KEY (`food_id`) REFERENCES `cow_foods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cow_food_expenses`
--
ALTER TABLE `cow_food_expenses`
  ADD CONSTRAINT `FK_cowFodd` FOREIGN KEY (`food_id`) REFERENCES `cow_foods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cow_food_required_perday`
--
ALTER TABLE `cow_food_required_perday`
  ADD CONSTRAINT `cow_food_required_perday_ibfk_1` FOREIGN KEY (`food_id`) REFERENCES `cow_foods` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `cow_sellings`
--
ALTER TABLE `cow_sellings`
  ADD CONSTRAINT `cow_sellings_ibfk_1` FOREIGN KEY (`cow_id`) REFERENCES `cows` (`id`);

--
-- Constraints for table `saleable_cows`
--
ALTER TABLE `saleable_cows`
  ADD CONSTRAINT `FK_SaleableCow` FOREIGN KEY (`cow_id`) REFERENCES `cows` (`id`);

--
-- Constraints for table `vaccinations`
--
ALTER TABLE `vaccinations`
  ADD CONSTRAINT `vaccinations_ibfk_1` FOREIGN KEY (`vaccine_id`) REFERENCES `vaccines` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `vaccinations_ibfk_2` FOREIGN KEY (`cow_id`) REFERENCES `cows` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `vaccine_expenses`
--
ALTER TABLE `vaccine_expenses`
  ADD CONSTRAINT `vaccine_expenses_ibfk_1` FOREIGN KEY (`vaccine_id`) REFERENCES `vaccines` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
