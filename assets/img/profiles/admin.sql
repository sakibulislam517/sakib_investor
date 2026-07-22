-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2023 at 07:46 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 7.4.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `loan`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `name` varchar(200) DEFAULT NULL,
  `desig` varchar(100) DEFAULT NULL,
  `user_name` varchar(100) DEFAULT NULL,
  `pass` varchar(200) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `number` varchar(50) DEFAULT NULL,
  `img` varchar(100) DEFAULT NULL,
  `access` text DEFAULT NULL,
  `date` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `name`, `desig`, `user_name`, `pass`, `email`, `number`, `img`, `access`, `date`) VALUES
(1, 'sakib', NULL, 'admin', '40bd001563085fc35165329ea1ff5c5ecbdbbeef', 'sakibulislam30@gmail.com', '01789295203', '', 'dashboard,organization,organization_add,organization_edit,organization_delete,lessor,lessor_add,lessor_edit,lessor_delete,loan,loan,loan_add,loan_edit,loan_delete,loan_payment,loan_payment_add,loan_payment_edit,loan_payment_delete,interest,generate_interest,generate_interest_add,generate_interest_delete,interest_payment,interest_payment_add,interest_payment_edit,interest_payment_delete,report,lessor_statement,loan_statement,interest_statement,organization_liab,user,user_add,user_edit,user_delete,interest,payment_account,received_by,received_by_add,received_by_edit,received_by_delete,payment_method,payment_method_add,payment_method_edit,payment_method_delete,mng_pages,mng_pages_add,mng_pages_edit,mng_pages_delete', '2023-05-20 17:04:04');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
