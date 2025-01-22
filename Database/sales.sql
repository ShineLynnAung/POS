-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 11, 2024 at 04:18 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sales`
--

-- --------------------------------------------------------

--
-- Table structure for table `invoice`
--

CREATE TABLE `invoice` (
  `customer` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `city` varchar(50) NOT NULL,
  `invoice_number` int(11) NOT NULL,
  `invoice_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `invoice`
--

INSERT INTO `invoice` (`customer`, `address`, `city`, `invoice_number`, `invoice_date`) VALUES
('SLA', 'Hmawbi', 'Yangon', 1, '2024-03-07'),
('AMK', 'Dagon North', 'Yangon', 2, '2024-03-07'),
('LY', 'Dagon North', 'Yangon', 3, '2024-03-07'),
('AA', 'Yangon', 'Yangon', 4, '2024-03-08'),
('BB', 'Thin Gangyun', 'Yangon', 5, '2024-03-08'),
('CC', 'Dagon South', 'Yangon', 6, '2024-03-09'),
('Dave', 'HTY', 'Yangon', 7, '2024-03-09'),
('AMK', 'Dagon North', 'Yangon', 8, '2024-03-11'),
('KTL', 'Hlaing Taryar', 'Yangon', 9, '2024-03-11');

-- --------------------------------------------------------

--
-- Table structure for table `inv_sequence`
--

CREATE TABLE `inv_sequence` (
  `next_not_cached_value` bigint(21) NOT NULL,
  `minimum_value` bigint(21) NOT NULL,
  `maximum_value` bigint(21) NOT NULL,
  `start_value` bigint(21) NOT NULL COMMENT 'start value when sequences is created or value if RESTART is used',
  `increment` bigint(21) NOT NULL COMMENT 'increment value',
  `cache_size` bigint(21) UNSIGNED NOT NULL,
  `cycle_option` tinyint(1) UNSIGNED NOT NULL COMMENT '0 if no cycles are allowed, 1 if the sequence should begin a new cycle when maximum_value is passed',
  `cycle_count` bigint(21) NOT NULL COMMENT 'How many cycles have been done'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `inv_sequence`
--

INSERT INTO `inv_sequence` (`next_not_cached_value`, `minimum_value`, `maximum_value`, `start_value`, `increment`, `cache_size`, `cycle_option`, `cycle_count`) VALUES
(1, 1, 9223372036854775806, 1, 1, 1000, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `sale_items`
--

CREATE TABLE `sale_items` (
  `id` int(11) NOT NULL,
  `sale_id` int(100) NOT NULL,
  `stock_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` int(100) NOT NULL,
  `amount` int(11) NOT NULL,
  `total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `sale_items`
--

INSERT INTO `sale_items` (`id`, `sale_id`, `stock_id`, `quantity`, `price`, `amount`, `total`) VALUES
(1, 1, 3, 2, 300, 300, 300),
(2, 2, 3, 6, 300, 1800, 1800),
(3, 2, 7, 2, 200, 400, 400),
(4, 3, 1, 1, 1500, 1500, 1500),
(5, 3, 2, 1, 1200, 1200, 1200),
(6, 3, 3, 3, 300, 900, 900),
(7, 3, 4, 1, 500, 500, 500),
(8, 3, 5, 2, 500, 1000, 1000),
(9, 3, 7, 5, 200, 1000, 1000),
(10, 4, 4, 4, 500, 2000, 2000),
(11, 5, 4, 5, 500, 2500, 2500),
(12, 6, 4, 4, 500, 2000, 2000),
(13, 8, 1, 2, 1500, 3000, 3000),
(14, 9, 11, 1, 40000, 40000, 40000),
(15, 9, 6, 1, 3000, 3000, 3000),
(16, 7, 1, 1, 1500, 1500, 1500);

-- --------------------------------------------------------

--
-- Table structure for table `stocks`
--

CREATE TABLE `stocks` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `balance` int(11) NOT NULL,
  `price` decimal(10,0) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stocks`
--

INSERT INTO `stocks` (`id`, `name`, `balance`, `price`) VALUES
(1, 'Apolo', 10, 1500),
(2, 'Top Choice', 10, 1200),
(3, 'Pencil', 57, 300),
(4, 'Ruler', 6, 500),
(5, 'Eraser', 9, 500),
(6, 'dictionary', 5, 3000),
(7, 'candy', 83, 200),
(8, 'Sketch book', 5, 5700),
(9, 'Color Pencil', 7, 3000),
(10, 'Marker', 20, 2000),
(11, 'Bag', 9, 40000);

-- --------------------------------------------------------

--
-- Table structure for table `update_record`
--

CREATE TABLE `update_record` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `last_balance` int(11) NOT NULL,
  `price` int(11) NOT NULL,
  `upd_time` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `update_record`
--

INSERT INTO `update_record` (`id`, `name`, `last_balance`, `price`, `upd_time`) VALUES
(1, 'Apolo', 9, 1500, '2024-03-10 19:44:33'),
(2, 'Eraser', 7, 500, '2024-03-10 20:56:55'),
(3, 'Top Choice', 3, 1200, '2024-03-11 05:10:15'),
(4, 'Eraser', 4, 500, '2024-03-11 05:17:27'),
(5, 'dictionary', 5, 3000, '2024-03-11 05:25:33'),
(6, 'Ruler', 4, 500, '2024-03-11 05:28:18'),
(7, 'Ruler', 5, 500, '2024-03-11 05:32:33');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`) VALUES
(1, 'POS SYSTEM', 'POS SYSTEM');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`invoice_number`);

--
-- Indexes for table `sale_items`
--
ALTER TABLE `sale_items`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `stocks`
--
ALTER TABLE `stocks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `update_record`
--
ALTER TABLE `update_record`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `invoice`
--
ALTER TABLE `invoice`
  MODIFY `invoice_number` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `sale_items`
--
ALTER TABLE `sale_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `stocks`
--
ALTER TABLE `stocks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `update_record`
--
ALTER TABLE `update_record`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
