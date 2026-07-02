-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 02, 2026 at 06:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `carzon_im102_final`
--

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customerID` int(11) NOT NULL,
  `customerName` varchar(50) DEFAULT NULL,
  `contactNumber` varchar(20) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customerID`, `customerName`, `contactNumber`, `address`, `created_at`) VALUES
(1, 'Valerie Dimple Telmoso', '09171234567', 'Purok 1, Iligan City', '2026-07-01 13:08:17'),
(2, 'Rayhana Saripada', '09181234567', 'Purok 2, Iligan City', '2026-07-01 13:08:17'),
(3, 'Rixianne Jade Generalao', '09191234567', 'Purok 3, Iligan City', '2026-07-01 13:08:17'),
(4, 'Shanley Tampos', '09201234567', 'Purok 4, Iligan City', '2026-07-01 13:08:17'),
(5, 'Mica-Ella Bacalso', '09211234567', 'Purok 5, Iligan City', '2026-07-01 13:08:17'),
(6, 'Allyza Gwenn Suana', '09221234567', 'Purok 6, Iligan City', '2026-07-01 13:08:17'),
(7, 'Mark Ramos', '09231234567', 'Purok 7, Iligan City', '2026-07-01 13:08:17'),
(8, 'Jereck Bodiongan', '09241234567', 'Purok 8, Iligan City', '2026-07-01 13:08:17'),
(9, 'Raffy Gadores', '09251234567', 'Purok 9, Iligan City', '2026-07-01 13:08:17'),
(10, 'Jydhan Alima', '09261234567', 'Purok 10, Iligan City', '2026-07-01 13:08:17'),
(11, 'Sofia Vergara', '09837625123', 'Purok 11, Iligan City', '2026-07-02 11:14:02'),
(12, 'Pablo Aquino', '09512725371', 'Purok 12, Iligan City', '2026-07-02 11:30:02'),
(13, 'Thea Garcia', '09628281634', 'Purok 13, Iligan City', '2026-07-02 16:11:25');

-- --------------------------------------------------------

--
-- Table structure for table `deliveries`
--

CREATE TABLE `deliveries` (
  `deliveryID` int(11) NOT NULL,
  `orderID` int(11) DEFAULT NULL,
  `driverName` varchar(50) DEFAULT NULL,
  `deliveryDate` date DEFAULT NULL,
  `remarks` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `deliveries`
--

INSERT INTO `deliveries` (`deliveryID`, `orderID`, `driverName`, `deliveryDate`, `remarks`, `created_at`) VALUES
(1, 1, 'Mark Dela Peña', '2026-07-01', 'Preparing', '2026-07-01 13:16:14'),
(2, 3, 'Mark Dela Peña', '2026-07-01', 'Preparing', '2026-07-01 13:16:14'),
(3, 5, 'John Reyes', '2026-07-05', 'Pending', '2026-07-01 13:16:14'),
(4, 7, 'John Reyes', '2026-07-02', 'Delivered', '2026-07-01 13:16:14'),
(5, 9, 'Mark Dela Peña', '2026-07-01', 'Preparing', '2026-07-01 13:16:14'),
(6, 10, 'John Reyes', '2026-07-04', 'Pending', '2026-07-01 13:16:14');

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `orderID` int(11) NOT NULL,
  `customerID` int(11) DEFAULT NULL,
  `added_by` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `pricePerGallon` decimal(10,2) DEFAULT NULL,
  `totalPrice` decimal(10,2) DEFAULT NULL,
  `deliveryType` enum('Pickup','Delivery') DEFAULT NULL,
  `orderStatus` enum('Pending','Preparing','Delivered','Completed') DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`orderID`, `customerID`, `added_by`, `quantity`, `pricePerGallon`, `totalPrice`, `deliveryType`, `orderStatus`, `created_at`) VALUES
(1, 1, 1, 4, 30.00, 120.00, 'Delivery', 'Delivered', '2026-07-01 13:13:56'),
(2, 2, 1, 2, 30.00, 60.00, 'Pickup', 'Completed', '2026-07-01 13:13:56'),
(3, 3, 1, 5, 30.00, 150.00, 'Delivery', 'Preparing', '2026-07-01 13:13:56'),
(4, 4, 1, 1, 30.00, 30.00, 'Pickup', 'Completed', '2026-07-01 13:13:56'),
(5, 5, 1, 4, 30.00, 120.00, 'Delivery', 'Pending', '2026-07-01 13:13:56'),
(6, 6, 1, 2, 30.00, 60.00, 'Pickup', 'Completed', '2026-07-01 13:13:56'),
(7, 7, 1, 6, 30.00, 180.00, 'Delivery', 'Delivered', '2026-07-01 13:13:56'),
(8, 8, 1, 3, 30.00, 90.00, 'Pickup', 'Completed', '2026-07-01 13:13:56'),
(9, 9, 1, 5, 30.00, 150.00, 'Delivery', 'Preparing', '2026-07-01 13:13:56'),
(10, 10, 1, 2, 30.00, 60.00, 'Delivery', 'Pending', '2026-07-01 13:13:56'),
(11, 12, 1, 5, 30.00, 150.00, 'Pickup', 'Pending', '2026-07-02 12:41:53'),
(12, 11, 1, 7, 30.00, 210.00, 'Delivery', 'Pending', '2026-07-02 16:07:27'),
(13, 13, 3, 2, 30.00, 60.00, 'Delivery', 'Delivered', '2026-07-02 16:12:27'),
(14, 1, 1, 2, 30.00, 60.00, 'Pickup', 'Pending', '2026-07-02 16:16:21'),
(15, 2, 1, 1, 30.00, 30.00, 'Delivery', 'Delivered', '2026-07-02 16:16:47');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL,
  `password_hash` varchar(255) NOT NULL,
  `role` enum('admin','staff') DEFAULT 'staff',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `username`, `email`, `password_hash`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', '2026-07-01 13:01:55'),
(3, 'Staff', 'staff@gmail.com', '$2y$10$o45WVIeq615iK13iB.YUYeSySDffbNCIQJemLJVl7f3ULm2YwNxYO', 'staff', '2026-07-02 14:36:18');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customerID`);

--
-- Indexes for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD PRIMARY KEY (`deliveryID`),
  ADD KEY `orderID` (`orderID`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `customerID` (`customerID`),
  ADD KEY `added_by` (`added_by`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `deliveries`
--
ALTER TABLE `deliveries`
  MODIFY `deliveryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `deliveries`
--
ALTER TABLE `deliveries`
  ADD CONSTRAINT `deliveries_ibfk_1` FOREIGN KEY (`orderID`) REFERENCES `orders` (`orderID`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `orders_ibfk_1` FOREIGN KEY (`customerID`) REFERENCES `customers` (`customerID`),
  ADD CONSTRAINT `orders_ibfk_2` FOREIGN KEY (`added_by`) REFERENCES `users` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
