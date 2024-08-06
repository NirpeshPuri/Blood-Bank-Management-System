-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 23, 2024 at 05:18 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `blood_bank`
--

-- --------------------------------------------------------

--
-- Table structure for table `accepted_donor_requests`
--

CREATE TABLE `accepted_donor_requests` (
  `name` varchar(255) NOT NULL,
  `donate_id` int(11) NOT NULL,
  `blood_quantity` float NOT NULL,
  `blood_date_time` datetime NOT NULL,
  `donor_phone` int(10) NOT NULL,
  `blood_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accepted_donor_requests`
--

INSERT INTO `accepted_donor_requests` (`name`, `donate_id`, `blood_quantity`, `blood_date_time`, `donor_phone`, `blood_type`) VALUES
('', 4, 4, '2024-03-03 22:34:00', 2147483647, 'A+'),
('', 5, 4, '2024-03-03 22:34:00', 2147483647, 'A+'),
('', 6, 1, '2024-03-11 14:11:00', 2147483647, 'A+'),
('', 7, 2, '2024-03-11 14:23:00', 2147483647, 'A+'),
('', 8, 2, '2024-03-11 18:32:00', 2147483647, 'A+'),
('', 9, 1, '2024-03-11 18:39:00', 2147483647, 'A+'),
('donor1', 10, 5, '2024-03-16 20:24:00', 2147483647, 'A+'),
('donor1', 11, 5, '2024-03-16 23:10:00', 2147483647, 'A+'),
('donor1', 12, 2, '2024-03-16 23:10:00', 2147483647, 'A+'),
('donor1', 13, 4, '2024-03-16 23:25:00', 2147483647, 'A+'),
('donor1', 14, 2, '2024-03-17 14:23:00', 2147483647, 'A+'),
('donor1', 15, 3, '2024-03-17 14:42:00', 2147483647, 'A+'),
('donor1', 16, 7, '2024-03-17 14:42:00', 2147483647, 'A+'),
('donor1', 17, 2, '2024-03-17 15:24:00', 2147483647, 'A+'),
('donor1', 18, 3, '2024-03-17 20:58:00', 2147483647, 'A+'),
('donor1', 22, 3, '2024-03-17 23:49:00', 2147483647, 'A+'),
('donor5', 27, 435, '2024-03-20 01:16:00', 2147483647, 'O+'),
('donor1', 29, -100, '2024-03-19 15:39:00', 2147483647, 'A+');

-- --------------------------------------------------------

--
-- Table structure for table `accepted_requests`
--

CREATE TABLE `accepted_requests` (
  `req_id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `blood_type` varchar(255) NOT NULL,
  `blood_quantity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `accepted_requests`
--

INSERT INTO `accepted_requests` (`req_id`, `user`, `blood_type`, `blood_quantity`) VALUES
(0, 'first', 'A-', '0'),
(1, 'first', 'A-', '2'),
(3, 'first', 'A-', '3'),
(4, 'first', 'A-', '3'),
(5, 'first', 'A-', '2'),
(6, 'first', 'A+', '2'),
(7, 'first', 'A+', '2');

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `name` varchar(255) NOT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`name`, `phone`, `email`, `password`) VALUES
('admin1', '9800000001', 'admin1@gmail.com', 'admin1234'),
('admin2', '9812345678', 'admin2@gmail.com', 'admin456');

-- --------------------------------------------------------

--
-- Table structure for table `donate_blood`
--

CREATE TABLE `donate_blood` (
  `name` varchar(255) NOT NULL,
  `donate_id` int(11) NOT NULL,
  `blood_quantity` float NOT NULL,
  `blood_date_time` datetime NOT NULL,
  `donor_phone` varchar(10) NOT NULL,
  `blood_type` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `donate_blood`
--

INSERT INTO `donate_blood` (`name`, `donate_id`, `blood_quantity`, `blood_date_time`, `donor_phone`, `blood_type`) VALUES
('donor1', 19, 5, '2024-03-17 23:36:00', '9800000002', 'A+'),
('donor1', 21, 6, '2024-03-17 23:49:00', '9800000002', 'A+'),
('donor3', 23, 350, '2024-03-06 01:06:00', '9810000003', 'B+'),
('donor4', 24, 450, '2024-03-08 01:08:00', '9810000004', 'B-'),
('donor1', 25, 350, '2024-03-04 01:08:00', '9810000001', 'A+'),
('donor3', 26, 380, '2024-03-20 01:09:00', '9810000003', 'B+'),
('donor5', 28, 345, '2024-03-20 01:16:00', '9810000005', 'O+'),
('donor1', 30, 234, '2024-03-20 18:54:00', '9810000001', 'A+'),
('donor1', 31, 234, '2024-03-21 19:10:00', '9810000001', 'A+'),
('donor1', 32, 257, '2024-03-20 20:16:00', '9810000001', 'A+');

-- --------------------------------------------------------

--
-- Table structure for table `make_request`
--

CREATE TABLE `make_request` (
  `req_id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `blood_type` varchar(255) NOT NULL,
  `blood_quantity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `make_request`
--

INSERT INTO `make_request` (`req_id`, `user`, `blood_type`, `blood_quantity`) VALUES
(8, 'first', 'A+', 3),
(9, 'first', 'A-', 1),
(10, 'user2', 'B+', 450),
(11, 'user1', 'A-', -1),
(12, 'user1', 'A-', -3);

-- --------------------------------------------------------

--
-- Table structure for table `request_detail`
--

CREATE TABLE `request_detail` (
  `id` int(11) NOT NULL,
  `user` varchar(255) NOT NULL,
  `blood_type` varchar(5) NOT NULL,
  `blood_quantity` int(11) NOT NULL,
  `request_type` enum('donor','receiver') NOT NULL,
  `request_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `request_detail`
--

INSERT INTO `request_detail` (`id`, `user`, `blood_type`, `blood_quantity`, `request_type`, `request_date`) VALUES
(1, 'donor1', 'A+', 3, 'donor', '2024-03-17 18:06:02'),
(2, 'first', 'A-', 1, 'receiver', '2024-03-17 18:18:48'),
(3, 'donor3', 'B+', 350, 'donor', '2024-03-19 19:22:13'),
(4, 'donor4', 'B-', 450, 'donor', '2024-03-19 19:23:20'),
(5, 'donor1', 'A+', 350, 'donor', '2024-03-19 19:24:13'),
(6, 'donor3', 'B+', 380, 'donor', '2024-03-19 19:25:10'),
(7, 'donor5', 'O+', 435, 'donor', '2024-03-19 19:31:46'),
(8, 'donor5', 'O+', 345, 'donor', '2024-03-19 19:31:57'),
(9, 'user2', 'B+', 450, 'receiver', '2024-03-19 19:34:56'),
(11, 'donor1', 'A+', 234, 'donor', '2024-03-20 13:09:49'),
(12, 'donor1', 'A+', 234, 'donor', '2024-03-21 13:25:27'),
(15, 'donor1', 'A+', 257, 'donor', '2024-03-21 14:31:12');

-- --------------------------------------------------------

--
-- Table structure for table `stock_blood`
--

CREATE TABLE `stock_blood` (
  `blood_type` varchar(255) NOT NULL,
  `blood_quantity` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `stock_blood`
--

INSERT INTO `stock_blood` (`blood_type`, `blood_quantity`) VALUES
('A+', 1461),
('A-', 1251),
('B+', 10000),
('B-', 900),
('AB+', 2435),
('AB-', 3567),
('O+', 1765),
('O-', 1654);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(10) NOT NULL,
  `blood_type` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `spe_condition` varchar(255) NOT NULL,
  `user_type` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `name`, `address`, `phone`, `blood_type`, `age`, `spe_condition`, `user_type`, `email`, `password`) VALUES
(1, 'first', 'kapan,Kathmandu', '9800000000', '0+', 21, '', 'receiver', 'abcd@gmail.com', 'abcd*'),
(2, 'donor1', 'kathmandu', '9810000001', 'A+', 19, '', 'donor', 'donor@gmail.com', 'donor1*'),
(4, 'donor2', 'kathmandu', '9810000004', 'AB-', 34, '', 'donor', 'donor2@gmail.com', '$2y$10$zn7grptGIEm/QfwkoXynVOyfMVp5DhTCM76AyA0uxqvyHHJtbq3tS'),
(5, 'user1', 'Kaski', '9800000001', 'B+', 43, '', 'receiver', 'user1@gmail.com', 'user1*'),
(6, 'user2', 'Baglung', '9800000002', 'B-', 23, '', 'receiver', 'user2@gmail.com', 'user2*'),
(7, 'user3', 'Rolpa', '9800000003', 'AB+', 27, '', 'receiver', 'user3@gmail.com', 'user3*'),
(8, 'user4', 'Chitwan', '9800000004', 'AB-', 32, '', 'receiver', 'user4@gmail.com', 'user4*'),
(9, 'user5', 'Pokhara', '9800000005', 'O+', 24, '', 'receiver', 'user5@gmail.com', 'user5*'),
(10, 'donor3', 'bhaktapur', '9810000003', 'B+', 22, '', 'donor', 'donor3@gmail.com', 'donor3*'),
(11, 'donor4', 'Kusma', '9810000004', 'B-', 49, '', 'donor', 'donor4@gmail.com', 'donor4*'),
(12, 'donor5', 'Lalitpur', '9810000005', 'O+', 56, '', 'donor', 'donor5@gmail.com', 'donor5*'),
(15, 'Nirpesh', 'Kapan', '9844734127', 'O+', 21, '', 'receiver', 'nirpeshpuri127@gmail.com', 'nirpesh*');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `accepted_donor_requests`
--
ALTER TABLE `accepted_donor_requests`
  ADD PRIMARY KEY (`donate_id`);

--
-- Indexes for table `accepted_requests`
--
ALTER TABLE `accepted_requests`
  ADD PRIMARY KEY (`req_id`);

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`phone`);

--
-- Indexes for table `donate_blood`
--
ALTER TABLE `donate_blood`
  ADD PRIMARY KEY (`donate_id`);

--
-- Indexes for table `make_request`
--
ALTER TABLE `make_request`
  ADD PRIMARY KEY (`req_id`);

--
-- Indexes for table `request_detail`
--
ALTER TABLE `request_detail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `donate_blood`
--
ALTER TABLE `donate_blood`
  MODIFY `donate_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT for table `make_request`
--
ALTER TABLE `make_request`
  MODIFY `req_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `request_detail`
--
ALTER TABLE `request_detail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
