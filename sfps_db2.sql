-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 28, 2024 at 10:04 PM
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
-- Database: `sfps_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `a`
--

CREATE TABLE `a` (
  `pas` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(30) NOT NULL,
  `course` varchar(100) NOT NULL,
  `description` text NOT NULL,
  `level` varchar(150) NOT NULL,
  `total_amount` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course`, `description`, `level`, `total_amount`, `date_created`) VALUES
(4, 'AIML', '', '1', 3833, '2024-12-28 15:15:10'),
(5, 's', '', '1', 1, '2024-12-28 23:30:10');

-- --------------------------------------------------------

--
-- Table structure for table `fees`
--

CREATE TABLE `fees` (
  `id` int(30) NOT NULL,
  `course_id` int(30) NOT NULL,
  `description` varchar(200) NOT NULL,
  `amount` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `fees`
--

INSERT INTO `fees` (`id`, `course_id`, `description`, `amount`) VALUES
(8, 4, 'kcet', 3833),
(9, 5, 'kcet', 1);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(30) NOT NULL,
  `ef_id` int(30) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `remarks` text NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`id`, `ef_id`, `amount`, `remarks`, `date_created`) VALUES
(1, 1, 1000.00, 'sample', '2020-10-31 14:25:35'),
(2, 1, 500.00, 'sample 2', '2020-10-31 14:47:15'),
(5, 4, 65000.00, 'No Remarks', '2023-09-18 13:53:20'),
(6, 0, 0.00, '', '2024-12-28 15:14:11'),
(7, 5, 220.00, '', '2024-12-28 15:15:39'),
(8, 5, 670.00, '', '2024-12-28 15:16:30'),
(9, 5, 943.00, '', '2024-12-28 15:21:36');

-- --------------------------------------------------------

--
-- Table structure for table `payments1`
--

CREATE TABLE `payments1` (
  `id` int(11) NOT NULL,
  `user_id` varchar(255) NOT NULL,
  `payment_id` varchar(255) NOT NULL,
  `order_id` varchar(255) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `date_created` datetime DEFAULT current_timestamp(),
  `remarks` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments1`
--

INSERT INTO `payments1` (`id`, `user_id`, `payment_id`, `order_id`, `amount`, `date_created`, `remarks`) VALUES
(1, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 100.00, '2024-12-29 00:50:35', NULL),
(2, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 00:51:57', NULL),
(3, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 00:55:50', NULL),
(4, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 01:00:23', NULL),
(5, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 01:07:04', NULL),
(6, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 01:09:25', NULL),
(7, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 01:13:00', NULL),
(8, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 01:15:29', NULL),
(9, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 01:16:40', NULL),
(10, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 01:17:48', NULL),
(11, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 01:21:10', NULL),
(12, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 01:24:16', NULL),
(13, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 01:27:42', NULL),
(14, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 01:31:00', NULL),
(15, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 01:34:16', NULL),
(16, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 01:37:26', NULL),
(17, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 01:39:40', NULL),
(18, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 01:42:35', NULL),
(19, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 01:44:21', NULL),
(20, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 01:44:33', NULL),
(21, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 01:45:09', NULL),
(22, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 01:45:30', NULL),
(23, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 01:48:24', NULL),
(24, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 01:52:03', NULL),
(25, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 01:53:20', NULL),
(26, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 01:55:05', NULL),
(27, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 01:56:42', NULL),
(28, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 02:01:42', NULL),
(29, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 02:01:55', NULL),
(30, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 02:02:06', NULL),
(31, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 02:02:22', NULL),
(32, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 02:05:46', NULL),
(33, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 02:06:29', NULL),
(34, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 02:11:02', NULL),
(35, '3br21ai123', 'pay_PchXbl8X2bnj8J', 'order_PchXJ1jPpKKDRd', 1.00, '2024-12-29 02:24:34', NULL),
(36, '3br21ai108', 'pay_PcjjyOKYb1wvk8', 'order_PcjjVBm9jzUFPL', 1.00, '2024-12-29 02:30:23', NULL),
(37, '3br21ai108', 'pay_PcjjyOKYb1wvk8', 'order_PcjjVBm9jzUFPL', 1.00, '2024-12-29 02:32:24', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(30) NOT NULL,
  `id_no` varchar(100) NOT NULL,
  `name` text NOT NULL,
  `contact` varchar(100) NOT NULL,
  `address` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `id_no`, `name`, `contact`, `address`, `email`, `date_created`) VALUES
(2, '3br21ai114', 'uday', '8989898999', '', 'uday@gmail.com', '2024-12-28 20:23:34'),
(6, '3br21ai108', 'srinivas', '8050183924', '', '2004msrinivasa@gmail.com', '2023-11-25 22:28:00'),
(7, '3br21ai123', 'vishwa', '1234567890', 'bellary', 'viswa@gmail.com', '2024-12-28 23:30:48');

-- --------------------------------------------------------

--
-- Table structure for table `student data`
--

CREATE TABLE `student data` (
  `Student_Name` varchar(255) NOT NULL,
  `Student_ID` varchar(255) NOT NULL,
  `Payment_Amount` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `student_data`
--

CREATE TABLE `student_data` (
  `Student_Name` varchar(255) NOT NULL,
  `Student_ID` varchar(255) NOT NULL,
  `Payment_Method` varchar(255) NOT NULL,
  `UPI_Number` varchar(255) NOT NULL,
  `Debit_Card_Details` varchar(255) NOT NULL,
  `Select_Payment_Type` varchar(255) NOT NULL,
  `Payment_Amount` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_data`
--

INSERT INTO `student_data` (`Student_Name`, `Student_ID`, `Payment_Method`, `UPI_Number`, `Debit_Card_Details`, `Select_Payment_Type`, `Payment_Amount`) VALUES
('eferf', 'scssfd', '', '', '', '', 2233),
('srinivas', '3br21ai108', '', '', '', '', 15000),
('srinivasm', '3br21ai108', '', '', '', '', 13000),
('srinivasrtdsdtrdt', '3br21ai108', '', '', '', '', 23131),
('srinivas', '21', '', '', '', '', 100000),
('srinivas', '21', '', '', '', '', 100000),
('srinivas', '21', '', '', '', '', 100000),
('uday', '114', '', '', '', '', 100000),
('uday', '114', '', '', '', '', 100000),
('u', '123', '', '', '', '', 100000),
('u2', '000', 'UPI', '123456789@ybl', '', '', 20000),
('u3', '112233', 'Debit_Card', '', '1233434 3453', 'Kcet', 93526),
('u', '3br21ai108', 'UPI', '22424@gpay', '', 'Installment1', 600000),
('uuu', '1232', 'UPI', '2324', '', 'Installment1', 600000),
('uuu', '1232', 'UPI', '2324', '', 'Installment1', 600000),
('uuuuuu', '1234', 'UPI', '32214', '', 'Installment1', 600000),
('uuuuuu', '1234', 'UPI', '32214', '', 'Installment1', 600000),
('srinivas', '3br21ai108', 'UPI', '232136@ybl', '', 'Installment1', 600000),
('MS', '114', 'UPI', '5465', '', 'Installment1', 600000),
('', '', '', '', '', 'Installment1', 600000),
('srinivas', '3br21ai108', '', '', '', 'Installment1', 600000),
('srinivas', '3br21ai108', 'UPI', '232136@ybl', '', 'Installment1', 600000),
('santosh', '3br21ai098', '', '', '', 'Installment1', 600000),
('santosh', '3br21ai098', 'UPI', '143w@ybl', '', 'Installment1', 600000),
('vijay', '3br21ai122', 'Debit_Card', '', '123231312', 'Kcet', 93526),
('srinivas', '', 'UPI', '1232@ybl', '', 'Installment2', 650000),
('srinivas', '3br21ai108', 'UPI', '1213323@ybl', '', 'Kcet', 93526),
('shiva', '3br21ai138', 'UPI', '12345@ybl', '', 'Kcet', 93526);

-- --------------------------------------------------------

--
-- Table structure for table `student_ef_list`
--

CREATE TABLE `student_ef_list` (
  `id` int(30) NOT NULL,
  `student_id` int(30) NOT NULL,
  `ef_no` varchar(200) NOT NULL,
  `course_id` int(30) NOT NULL,
  `total_fee` float NOT NULL,
  `date_created` datetime NOT NULL DEFAULT current_timestamp(),
  `payment_status` varchar(50) DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_ef_list`
--

INSERT INTO `student_ef_list` (`id`, `student_id`, `ef_no`, `course_id`, `total_fee`, `date_created`, `payment_status`) VALUES
(1, 2, '2020-654278', 4, 3833, '2020-10-31 12:04:18', 'Pending'),
(2, 1, '2020-65427823', 1, 4500, '2020-10-31 13:12:13', 'Pending'),
(4, 3, '2023-24', 2, 155000, '2023-09-18 13:36:53', 'Paid'),
(5, 6, '1', 5, 1, '2024-12-28 15:15:22', 'Pending'),
(6, 7, '2', 5, 1, '2024-12-28 23:31:12', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `system_settings`
--

CREATE TABLE `system_settings` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(20) NOT NULL,
  `cover_img` text NOT NULL,
  `about_content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `system_settings`
--

INSERT INTO `system_settings` (`id`, `name`, `email`, `contact`, `cover_img`, `about_content`) VALUES
(1, 'School Fees Payment System', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(30) NOT NULL,
  `name` text NOT NULL,
  `username` varchar(200) NOT NULL,
  `password` text NOT NULL,
  `type` tinyint(1) NOT NULL DEFAULT 3 COMMENT '1=Admin,2=Staff'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `type`) VALUES
(1, 'admin', 'admin', '0192023a7bbd73250516f069df18b500', 1);

-- --------------------------------------------------------

--
-- Table structure for table `userss`
--

CREATE TABLE `userss` (
  `user_name` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `userss`
--

INSERT INTO `userss` (`user_name`, `password`) VALUES
('3br', '12345678'),
('3br', '1234'),
('sri', '1234');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fees`
--
ALTER TABLE `fees`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payments1`
--
ALTER TABLE `payments1`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student_ef_list`
--
ALTER TABLE `student_ef_list`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_settings`
--
ALTER TABLE `system_settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `fees`
--
ALTER TABLE `fees`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `payments1`
--
ALTER TABLE `payments1`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `student_ef_list`
--
ALTER TABLE `student_ef_list`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `system_settings`
--
ALTER TABLE `system_settings`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(30) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
