-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 01, 2024 at 01:52 PM
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
-- Database: `ams_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tblbranch`
--

CREATE TABLE `tblbranch` (
  `branch_id` int(11) NOT NULL,
  `branch_name` varchar(100) NOT NULL,
  `b_email` varchar(50) DEFAULT NULL,
  `b_contact_no` int(15) DEFAULT NULL,
  `b_address` varchar(100) NOT NULL,
  `security_guard_mobile` varchar(25) DEFAULT NULL,
  `secrataty_mobile` varchar(25) DEFAULT NULL,
  `moderator_mobile` varchar(25) DEFAULT NULL,
  `building_make_year` varchar(25) DEFAULT NULL,
  `building_image` varchar(250) DEFAULT NULL,
  `b_status` tinyint(4) NOT NULL DEFAULT 1,
  `builder_company_name` varchar(250) DEFAULT NULL,
  `builder_company_phone` varchar(50) DEFAULT NULL,
  `builder_company_address` varchar(1000) DEFAULT NULL,
  `building_rule` text DEFAULT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tblbranch`
--

INSERT INTO `tblbranch` (`branch_id`, `branch_name`, `b_email`, `b_contact_no`, `b_address`, `security_guard_mobile`, `secrataty_mobile`, `moderator_mobile`, `building_make_year`, `building_image`, `b_status`, `builder_company_name`, `builder_company_phone`, `builder_company_address`, `building_rule`, `created_date`) VALUES
(20, 'AL nahyan', NULL, NULL, 'AAAAAADRESS', NULL, NULL, NULL, '30', '', 1, NULL, NULL, NULL, NULL, '2024-02-29 06:51:12');

-- --------------------------------------------------------

--
-- Table structure for table `tblsuper_admin`
--

CREATE TABLE `tblsuper_admin` (
  `user_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(300) NOT NULL,
  `contact` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `password` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tblsuper_admin`
--

INSERT INTO `tblsuper_admin` (`user_id`, `name`, `email`, `contact`, `password`, `added_date`) VALUES
(1, 'Alexander Pierc', 'superadmin@gmail.com', '+8801679110711', 'MTIzNDU2', '2015-06-29 06:15:29');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_admin`
--

CREATE TABLE `tbl_add_admin` (
  `aid` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `contact` varchar(100) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `image` varchar(250) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_add_admin`
--

INSERT INTO `tbl_add_admin` (`aid`, `name`, `email`, `contact`, `password`, `image`, `branch_id`, `added_date`) VALUES
(7, 'Tony', 'admin@gmail.com', '+8801679110711', 'MTIzNDU2', 'B7962E98-0550-407D-01A7-3C088DCCD2EF.jpg', 8, '2019-08-27 04:45:27');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_bill`
--

CREATE TABLE `tbl_add_bill` (
  `bill_id` int(11) NOT NULL,
  `bill_type` varchar(200) NOT NULL,
  `bill_date` varchar(200) NOT NULL,
  `bill_month` int(11) NOT NULL,
  `bill_year` int(11) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `deposit_bank_name` varchar(200) NOT NULL,
  `bill_details` varchar(200) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_add_bill`
--

INSERT INTO `tbl_add_bill` (`bill_id`, `bill_type`, `bill_date`, `bill_month`, `bill_year`, `total_amount`, `deposit_bank_name`, `bill_details`, `branch_id`, `added_date`) VALUES
(14, '4', '27/08/2019', 8, 11, 5000.00, 'DBBL', 'purfect', 8, '2019-08-27 04:37:27');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_bill_type`
--

CREATE TABLE `tbl_add_bill_type` (
  `bt_id` int(11) NOT NULL,
  `bill_type` varchar(200) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_add_bill_type`
--

INSERT INTO `tbl_add_bill_type` (`bt_id`, `bill_type`, `added_date`) VALUES
(1, 'Gas', '2016-05-05 09:49:35'),
(3, 'Water', '2016-05-05 09:50:39'),
(4, 'Electric', '2016-05-05 09:50:51');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_builder_info`
--

CREATE TABLE `tbl_add_builder_info` (
  `bldrid` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `phone` varchar(200) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_building_info`
--

CREATE TABLE `tbl_add_building_info` (
  `bldid` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `address` varchar(200) NOT NULL,
  `security_guard_mobile` varchar(200) NOT NULL,
  `secrataty_mobile` varchar(200) NOT NULL,
  `moderator_mobile` varchar(200) NOT NULL,
  `building_make_year` varchar(200) NOT NULL,
  `b_name` varchar(200) NOT NULL,
  `b_address` varchar(200) NOT NULL,
  `b_phone` varchar(200) NOT NULL,
  `building_image` varchar(200) NOT NULL,
  `building_rules` text NOT NULL,
  `branch_id` int(11) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_complain`
--

CREATE TABLE `tbl_add_complain` (
  `complain_id` int(11) NOT NULL,
  `c_title` varchar(200) NOT NULL,
  `c_description` varchar(1000) NOT NULL,
  `c_date` varchar(200) NOT NULL,
  `c_month` varchar(50) NOT NULL,
  `c_year` varchar(50) NOT NULL,
  `c_userid` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `job_status` int(1) NOT NULL DEFAULT 0,
  `assign_employee_id` int(11) DEFAULT 0,
  `solution` varchar(500) NOT NULL,
  `complain_by` varchar(100) DEFAULT NULL,
  `person_name` varchar(250) DEFAULT NULL,
  `person_email` varchar(100) DEFAULT NULL,
  `person_contact` varchar(50) DEFAULT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_employee`
--

CREATE TABLE `tbl_add_employee` (
  `eid` int(11) NOT NULL,
  `e_name` varchar(200) NOT NULL,
  `e_email` varchar(200) NOT NULL,
  `e_contact` varchar(200) NOT NULL,
  `e_pre_address` varchar(200) NOT NULL,
  `e_per_address` varchar(200) NOT NULL,
  `e_nid` varchar(200) NOT NULL,
  `e_designation` int(11) NOT NULL,
  `e_date` varchar(200) NOT NULL,
  `ending_date` varchar(200) NOT NULL,
  `e_status` int(1) NOT NULL DEFAULT 0,
  `e_password` varchar(100) NOT NULL,
  `image` varchar(200) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `salary` decimal(15,2) NOT NULL DEFAULT 0.00,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_employee_salary_setup`
--

CREATE TABLE `tbl_add_employee_salary_setup` (
  `emp_id` int(11) NOT NULL,
  `emp_name` varchar(200) NOT NULL,
  `designation` varchar(200) NOT NULL,
  `month_id` int(11) NOT NULL,
  `xyear` int(11) NOT NULL,
  `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `issue_date` varchar(200) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_fair`
--

CREATE TABLE `tbl_add_fair` (
  `f_id` int(11) NOT NULL,
  `type` varchar(200) NOT NULL,
  `floor_no` varchar(200) NOT NULL,
  `unit_no` varchar(200) NOT NULL,
  `rid` int(11) NOT NULL DEFAULT 0,
  `month_id` int(11) NOT NULL,
  `xyear` varchar(200) NOT NULL,
  `rent` decimal(15,2) NOT NULL DEFAULT 0.00,
  `water_bill` decimal(15,2) NOT NULL DEFAULT 0.00,
  `electric_bill` decimal(15,2) NOT NULL DEFAULT 0.00,
  `gas_bill` decimal(15,2) NOT NULL DEFAULT 0.00,
  `security_bill` decimal(15,2) NOT NULL DEFAULT 0.00,
  `utility_bill` decimal(15,2) NOT NULL DEFAULT 0.00,
  `other_bill` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_rent` decimal(15,2) NOT NULL DEFAULT 0.00,
  `issue_date` varchar(200) NOT NULL,
  `paid_date` varchar(25) DEFAULT NULL,
  `branch_id` int(11) NOT NULL,
  `bill_status` tinyint(1) NOT NULL DEFAULT 0,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_floor`
--

CREATE TABLE `tbl_add_floor` (
  `fid` int(11) NOT NULL,
  `floor_no` varchar(200) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `ownid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_add_floor`
--

INSERT INTO `tbl_add_floor` (`fid`, `floor_no`, `branch_id`, `added_date`, `ownid`) VALUES
(38, '11', 20, '2024-02-29 06:51:26', 30);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_fund`
--

CREATE TABLE `tbl_add_fund` (
  `fund_id` int(11) NOT NULL,
  `owner_id` int(11) NOT NULL,
  `month_id` int(11) NOT NULL,
  `xyear` varchar(200) NOT NULL,
  `f_date` varchar(200) NOT NULL,
  `total_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `purpose` varchar(400) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_maintenance_cost`
--

CREATE TABLE `tbl_add_maintenance_cost` (
  `mcid` int(11) NOT NULL,
  `m_title` varchar(200) NOT NULL,
  `m_date` varchar(200) NOT NULL,
  `m_amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `m_details` varchar(200) NOT NULL,
  `ownid` int(11) DEFAULT 0,
  `fid` int(11) DEFAULT 0,
  `branch_id` int(11) DEFAULT NULL,
  `uid` int(11) DEFAULT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_add_maintenance_cost`
--

INSERT INTO `tbl_add_maintenance_cost` (`mcid`, `m_title`, `m_date`, `m_amount`, `m_details`, `ownid`, `fid`, `branch_id`, `uid`, `added_date`) VALUES
(13, 'lll', '29/02/2024', 25.00, 'jkhgy', 30, 38, 20, 70, '2024-02-29 13:43:26'),
(14, 'ss', '02/03/2024', 55.00, 'hhfjhgf', 30, 38, 20, 70, '2024-03-01 06:22:04');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_management_committee`
--

CREATE TABLE `tbl_add_management_committee` (
  `mc_id` int(11) NOT NULL,
  `mc_name` varchar(200) NOT NULL,
  `mc_email` varchar(200) NOT NULL,
  `mc_contact` varchar(200) NOT NULL,
  `mc_pre_address` varchar(500) NOT NULL,
  `mc_per_address` varchar(500) NOT NULL,
  `mc_nid` varchar(200) NOT NULL,
  `member_type` varchar(200) NOT NULL,
  `mc_joining_date` varchar(200) NOT NULL,
  `mc_ending_date` varchar(200) NOT NULL,
  `mc_status` int(1) NOT NULL DEFAULT 0,
  `image` varchar(200) NOT NULL,
  `mc_password` varchar(200) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_member_type`
--

CREATE TABLE `tbl_add_member_type` (
  `member_id` int(11) NOT NULL,
  `member_type` varchar(200) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_month_setup`
--

CREATE TABLE `tbl_add_month_setup` (
  `m_id` int(11) NOT NULL,
  `month_name` varchar(200) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_owner`
--

CREATE TABLE `tbl_add_owner` (
  `ownid` int(11) NOT NULL,
  `o_name` varchar(200) NOT NULL,
  `o_email` varchar(200) NOT NULL,
  `o_contact` varchar(200) NOT NULL,
  `o_pre_address` varchar(500) NOT NULL,
  `o_per_address` varchar(500) NOT NULL,
  `o_nid` varchar(200) NOT NULL,
  `o_password` varchar(100) NOT NULL,
  `image` varchar(200) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_add_owner`
--

INSERT INTO `tbl_add_owner` (`ownid`, `o_name`, `o_email`, `o_contact`, `o_pre_address`, `o_per_address`, `o_nid`, `o_password`, `image`, `branch_id`, `created_date`) VALUES
(30, 'hamza', 'hamza@gmail.com', '+9718283211144', '', 'DDDD', '2321231', '', '', 16, '2024-02-29 06:50:53');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_owner_unit_relation`
--

CREATE TABLE `tbl_add_owner_unit_relation` (
  `owner_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_add_owner_unit_relation`
--

INSERT INTO `tbl_add_owner_unit_relation` (`owner_id`, `unit_id`) VALUES
(19, 30),
(19, 32),
(20, 34),
(21, 34),
(21, 35);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_owner_utility`
--

CREATE TABLE `tbl_add_owner_utility` (
  `owner_utility_id` int(11) NOT NULL,
  `floor_no` int(11) NOT NULL,
  `unit_no` int(11) NOT NULL,
  `month_id` int(11) NOT NULL,
  `rent` decimal(15,2) NOT NULL DEFAULT 0.00,
  `water_bill` decimal(15,2) NOT NULL DEFAULT 0.00,
  `electric_bill` decimal(15,2) NOT NULL DEFAULT 0.00,
  `gas_bill` decimal(15,2) NOT NULL DEFAULT 0.00,
  `security_bill` decimal(15,2) NOT NULL DEFAULT 0.00,
  `utility_bill` decimal(15,2) NOT NULL DEFAULT 0.00,
  `other_bill` decimal(15,2) NOT NULL DEFAULT 0.00,
  `total_rent` decimal(15,2) NOT NULL DEFAULT 0.00,
  `issue_date` varchar(200) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_rent`
--

CREATE TABLE `tbl_add_rent` (
  `rid` int(11) NOT NULL,
  `r_name` varchar(200) NOT NULL,
  `r_email` varchar(200) DEFAULT NULL,
  `r_password` varchar(100) DEFAULT NULL,
  `r_contact` varchar(200) NOT NULL,
  `r_address` varchar(200) DEFAULT NULL,
  `r_nid` varchar(200) DEFAULT NULL,
  `image` varchar(200) DEFAULT NULL,
  `r_passport` varchar(255) DEFAULT NULL,
  `ownid` int(11) NOT NULL,
  `r_building` int(11) NOT NULL,
  `r_floor_no` varchar(200) NOT NULL,
  `r_unit_no` varchar(200) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `months` int(11) DEFAULT NULL,
  `amount` decimal(15,2) NOT NULL DEFAULT 0.00,
  `r_vat` varchar(255) DEFAULT '0',
  `parking_status` varchar(255) DEFAULT NULL,
  `r_property` int(11) NOT NULL,
  `r_bank_name` varchar(255) NOT NULL,
  `r_total_check` int(11) NOT NULL,
  `parking_amount` double DEFAULT NULL,
  `r_date` varchar(200) NOT NULL,
  `r_gone_date` varchar(200) DEFAULT NULL,
  `r_status` int(1) NOT NULL DEFAULT 1,
  `discount` double NOT NULL,
  `final_amount` double NOT NULL,
  `other_cost` double DEFAULT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `r_advance` decimal(15,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_add_rent`
--

INSERT INTO `tbl_add_rent` (`rid`, `r_name`, `r_email`, `r_password`, `r_contact`, `r_address`, `r_nid`, `image`, `r_passport`, `ownid`, `r_building`, `r_floor_no`, `r_unit_no`, `start_date`, `end_date`, `months`, `amount`, `r_vat`, `parking_status`, `r_property`, `r_bank_name`, `r_total_check`, `parking_amount`, `r_date`, `r_gone_date`, `r_status`, `discount`, `final_amount`, `other_cost`, `added_date`, `r_advance`) VALUES
(67, 'adil', 'admaaa@gmail.com', NULL, '+92de23421', '565689', '11221', NULL, '1111111111', 30, 20, '38', '71', '2024-02-29', '2024-02-29', 2, 252.00, 'on', 'on', 1, '2K', 2, 0, '2024-02-29 14:17:20', NULL, 1, 2, 261, 11, '2024-02-29 13:09:51', 0.00),
(68, 'aqua', 'a2d@gmail.com', NULL, '+9234921333', 'fds', '11221', NULL, '1111111111', 30, 20, '38', '72', '2024-03-01', '2024-04-30', 2, 222.00, 'on', 'on', 1, 'FF21', 3, 0, '2024-03-01 11:32:28', NULL, 1, 22, 433.1, 222, '2024-03-01 10:32:28', 0.00),
(69, 'aqua11', 'adm444@gmail.com', NULL, '55', 'jgyj', '11221', NULL, '1111111111', 30, 20, '38', '69', '2024-03-01', '2024-03-01', 2, 12000.00, 'on', 'on', 1, 'ff', 3, 9898, '2024-03-01 11:44:31', NULL, 1, 2, 32449, 55, '2024-03-01 10:41:55', 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_unit`
--

CREATE TABLE `tbl_add_unit` (
  `uid` int(11) NOT NULL,
  `floor_no` varchar(200) NOT NULL,
  `unit_no` varchar(200) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `ownid` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT 0,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_add_unit`
--

INSERT INTO `tbl_add_unit` (`uid`, `floor_no`, `unit_no`, `branch_id`, `ownid`, `status`, `added_date`) VALUES
(69, '38', '33', 20, 30, 1, '2024-02-29 06:51:39'),
(70, '38', '3k', 20, 30, 0, '2024-02-29 07:11:47'),
(71, '38', '33333', 20, 30, 1, '2024-02-29 07:29:55'),
(72, '38', 'aa', 20, 30, 1, '2024-02-29 08:33:00');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_utility_bill`
--

CREATE TABLE `tbl_add_utility_bill` (
  `utility_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL DEFAULT 0,
  `gas_bill` varchar(200) NOT NULL,
  `security_bill` varchar(200) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_add_year_setup`
--

CREATE TABLE `tbl_add_year_setup` (
  `y_id` int(11) NOT NULL,
  `xyear` varchar(200) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_currency`
--

CREATE TABLE `tbl_currency` (
  `cid` int(11) NOT NULL,
  `symbol` varchar(5) NOT NULL,
  `name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_emi_payment`
--

CREATE TABLE `tbl_emi_payment` (
  `id` int(11) NOT NULL,
  `rid` int(11) NOT NULL,
  `ckeck_number` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `amount` double NOT NULL,
  `payment_by` enum('0','1') NOT NULL DEFAULT '0',
  `status` enum('0','1','2') NOT NULL DEFAULT '0',
  `check_status` enum('0','1','2') NOT NULL DEFAULT '0',
  `date` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_emi_payment`
--

INSERT INTO `tbl_emi_payment` (`id`, `rid`, `ckeck_number`, `bank_name`, `amount`, `payment_by`, `status`, `check_status`, `date`, `created_at`) VALUES
(16, 39, '3', 'jh', 456.33, '0', '0', '1', '2024-10-25', '2024-02-24 11:08:49'),
(21, 42, '1212', '', 103, '0', '0', '2', '2024-08-27', '2024-02-26 06:09:37'),
(23, 44, '#121', '', 501.33, '1', '2', '0', '2024-02-26', '2024-02-26 08:13:25'),
(24, 44, '#212', '', 501.33, '0', '0', '0', '2024-06-27', '2024-02-26 08:13:25'),
(25, 44, '#111', '', 501.33, '0', '0', '0', '2024-10-27', '2024-02-26 08:13:25'),
(26, 47, '22s', '', 3459.55, '0', '0', '0', '2024-02-27', '2024-02-27 07:35:28'),
(27, 47, '21s', '', 3459.55, '0', '0', '0', '2024-03-29', '2024-02-27 07:35:28'),
(28, 48, '2e2', '', 353.8, '1', '1', '0', '2024-02-27', '2024-02-27 08:23:26'),
(29, 48, 'e2e', '', 353.8, '0', '0', '0', '2024-03-14', '2024-02-27 08:23:26'),
(30, 49, '#121', '', 852, '1', '2', '0', '2024-02-27', '2024-02-27 08:40:48'),
(31, 49, '#120', '', 852, '0', '0', '0', '2024-03-14', '2024-02-27 08:40:48'),
(32, 50, '#dd1', '', 444.67, '0', '0', '0', '2024-02-27', '2024-02-27 08:44:18'),
(33, 50, '#dd2', '', 444.67, '0', '0', '0', '2024-03-09', '2024-02-27 08:44:18'),
(34, 50, '#dd3', '', 444.67, '0', '0', '0', '2024-03-20', '2024-02-27 08:44:18'),
(35, 51, '2', '', 232.28, '1', '2', '0', '2024-02-27', '2024-02-27 08:51:42'),
(36, 51, '111', '', 232.28, '0', '0', '0', '2024-03-14', '2024-02-27 08:51:42'),
(37, 52, 'sd21', '', 64.65, '1', '1', '0', '2024-02-27', '2024-02-27 09:44:16'),
(38, 53, '20', '', 509.6, '1', '1', '0', '2024-02-27', '2024-02-27 10:35:55'),
(39, 54, '21S', '', 651.55, '1', '2', '0', '2024-02-28', '2024-02-27 11:06:17'),
(40, 54, '12W', '', 651.55, '0', '0', '0', '2024-03-15', '2024-02-27 11:06:17'),
(41, 55, '125l', '', 3.02, '1', '2', '0', '2024-02-27', '2024-02-27 11:12:03'),
(42, 55, '2', '', 3.02, '0', '0', '0', '2024-02-29', '2024-02-27 11:12:03'),
(43, 55, '21', '', 3.02, '0', '0', '0', '2024-03-03', '2024-02-27 11:12:03'),
(44, 55, '212', '', 3.02, '0', '0', '0', '2024-03-05', '2024-02-27 11:12:03'),
(45, 55, '121', '', 3.02, '0', '0', '0', '2024-03-08', '2024-02-27 11:12:03'),
(46, 55, '1221', '', 3.02, '0', '0', '0', '2024-03-10', '2024-02-27 11:12:03'),
(47, 55, '1212', '', 3.02, '0', '0', '0', '2024-03-13', '2024-02-27 11:12:03'),
(48, 55, '2131', '', 3.02, '0', '0', '0', '2024-03-15', '2024-02-27 11:12:03'),
(49, 55, '31231', '', 3.02, '0', '0', '0', '2024-03-18', '2024-02-27 11:12:03'),
(50, 55, '123123', '', 3.02, '0', '0', '0', '2024-03-20', '2024-02-27 11:12:03'),
(51, 55, '312312', '', 3.02, '0', '0', '0', '2024-03-23', '2024-02-27 11:12:03'),
(52, 55, '31231', '', 3.02, '0', '0', '0', '2024-03-25', '2024-02-27 11:12:03'),
(53, 55, '2121', '', 3.02, '0', '0', '0', '2024-03-28', '2024-02-27 11:12:03'),
(54, 55, '1221', '', 3.02, '0', '0', '0', '2024-03-30', '2024-02-27 11:12:03'),
(55, 55, '2112', '', 3.02, '0', '0', '0', '2024-04-02', '2024-02-27 11:12:03'),
(56, 55, '2123', '', 3.02, '0', '0', '0', '2024-04-04', '2024-02-27 11:12:03'),
(57, 55, '312', '', 3.02, '0', '0', '0', '2024-04-07', '2024-02-27 11:12:03'),
(58, 55, '3121', '', 3.02, '0', '0', '0', '2024-04-09', '2024-02-27 11:12:03'),
(59, 55, '3123', '', 3.02, '0', '0', '0', '2024-04-12', '2024-02-27 11:12:03'),
(60, 55, '12312', '', 3.02, '0', '0', '0', '2024-04-14', '2024-02-27 11:12:03'),
(61, 55, '31231', '', 3.02, '0', '0', '0', '2024-04-17', '2024-02-27 11:12:03'),
(62, 55, '3121', '', 3.02, '0', '0', '0', '2024-04-19', '2024-02-27 11:12:03'),
(63, 55, '3123', '', 3.02, '0', '0', '0', '2024-04-22', '2024-02-27 11:12:03'),
(64, 55, '3123', '', 3.02, '0', '0', '0', '2024-04-24', '2024-02-27 11:12:03'),
(65, 55, '312123', '', 3.02, '0', '0', '0', '2024-04-27', '2024-02-27 11:12:03'),
(66, 56, '12', '', 1506, '1', '2', '0', '2024-02-28', '2024-02-27 12:34:36'),
(67, 57, '1', '', 710.75, '1', '1', '0', '2024-02-27', '2024-02-27 13:08:14'),
(68, 57, '2', '', 710.75, '0', '0', '0', '2024-03-14', '2024-02-27 13:08:14'),
(69, 58, 'a1', '', 2653.4, '1', '1', '0', '2024-02-28', '2024-02-28 11:58:35'),
(70, 58, 'a2', '', 2653.4, '0', '0', '0', '2024-03-30', '2024-02-28 11:58:35'),
(71, 59, '2dw', '', 758.05, '1', '1', '0', '2024-02-28', '2024-02-28 12:03:29'),
(72, 59, '2dr', '', 758.05, '0', '0', '0', '2024-03-15', '2024-02-28 12:03:29'),
(73, 60, '555', '', 3024.9, '1', '2', '0', '2024-02-28', '2024-02-28 12:14:51'),
(74, 60, '5551', '', 3024.9, '0', '0', '0', '2024-03-15', '2024-02-28 12:14:51'),
(75, 61, '12', '', 336.77, '1', '2', '0', '2024-02-28', '2024-02-28 13:11:07'),
(76, 61, '13', '', 336.77, '0', '0', '0', '2024-05-22', '2024-02-28 13:11:07'),
(77, 61, '14', '', 336.77, '0', '0', '0', '2024-08-15', '2024-02-28 13:11:07'),
(78, 61, '15', '', 336.77, '0', '0', '0', '2024-11-07', '2024-02-28 13:11:07'),
(79, 62, '22ww', '', 122.8, '1', '2', '0', '2024-02-28', '2024-02-28 13:22:01'),
(80, 62, '2s', '', 122.8, '0', '0', '0', '2024-03-15', '2024-02-28 13:22:01'),
(81, 63, '22', '', 116.55, '1', '1', '0', '2024-02-28', '2024-02-28 13:34:40'),
(82, 63, '22', '', 116.55, '0', '0', '0', '2024-03-15', '2024-02-28 13:34:40'),
(83, 64, '22ww', '', 3654.75, '0', '0', '0', '2024-02-29', '2024-02-29 06:53:30'),
(84, 64, '2s2', '', 3654.75, '0', '0', '0', '2024-05-23', '2024-02-29 06:53:30'),
(85, 64, '1', '', 3654.75, '0', '0', '0', '2024-08-15', '2024-02-29 06:53:30'),
(86, 64, '112', '', 3654.75, '0', '0', '0', '2024-11-07', '2024-02-29 06:53:30'),
(87, 65, '22ww', '', 677.33, '1', '2', '0', '2024-02-29', '2024-02-29 07:13:31'),
(88, 65, '12ww', '', 677.33, '0', '0', '0', '2006-02-09', '2024-02-29 07:13:31'),
(89, 65, '11ww', '', 677.33, '0', '0', '0', '1988-01-21', '2024-02-29 07:13:31'),
(90, 66, 'aa', '', 233, '1', '1', '0', '2024-02-29', '2024-02-29 08:00:00'),
(91, 67, 'FG', '', 136.8, '1', '1', '0', '2024-02-29', '2024-02-29 13:09:51'),
(92, 67, 'FG', '', 136.8, '0', '0', '0', '2024-03-15', '2024-02-29 13:09:51'),
(93, 68, 'Ew2', '', 144.37, '1', '2', '0', '2024-03-01', '2024-03-01 10:32:28'),
(94, 68, 'dwwq', '', 144.37, '0', '0', '0', '2024-03-21', '2024-03-01 10:32:28'),
(95, 68, 'dde', '', 144.37, '0', '0', '0', '2024-04-10', '2024-03-01 10:32:28'),
(96, 69, 'majad', '', 6348.5, '0', '0', '0', '2024-03-01', '2024-03-01 10:41:55'),
(97, 69, 'majad', '', 6348.5, '0', '0', '0', '2024-03-31', '2024-03-01 10:41:55');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee_leave_request`
--

CREATE TABLE `tbl_employee_leave_request` (
  `leave_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `from` date NOT NULL,
  `to` date NOT NULL,
  `leave_text` varchar(5000) NOT NULL,
  `request_status` varchar(50) NOT NULL DEFAULT 'Pending',
  `request_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_employee_notice`
--

CREATE TABLE `tbl_employee_notice` (
  `notice_id` int(11) NOT NULL,
  `notice_title` varchar(500) NOT NULL,
  `notice_description` text NOT NULL,
  `notice_status` tinyint(4) NOT NULL,
  `branch_id` int(11) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_full_payments`
--

CREATE TABLE `tbl_full_payments` (
  `id` int(11) NOT NULL,
  `ep_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `comments` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_full_payments`
--

INSERT INTO `tbl_full_payments` (`id`, `ep_id`, `amount`, `date`, `comments`) VALUES
(24, 90, 233, '2024-02-29', NULL),
(25, 91, 100, '2024-02-29', NULL),
(26, 91, 21, '2024-03-01', NULL),
(27, 93, 21, '2024-03-01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_max_power`
--

CREATE TABLE `tbl_max_power` (
  `purchase_code` varchar(150) DEFAULT NULL,
  `website_url` varchar(150) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `installed_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_check_date` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_max_power`
--

INSERT INTO `tbl_max_power` (`purchase_code`, `website_url`, `email`, `installed_date`, `last_check_date`) VALUES
('0232c2c6-7062-42d2-b2a8-c45b0e744ce6', 'http://mombasahomes.co.ke/', 'carogatuta@gmail.com', '2020-05-23 12:39:11', '2020-05-23 12:39:11');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_meeting`
--

CREATE TABLE `tbl_meeting` (
  `meeting_id` int(11) NOT NULL,
  `meeting_title` varchar(300) NOT NULL,
  `meeting_description` text NOT NULL,
  `issue_date` date NOT NULL,
  `branch_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_meeting`
--

INSERT INTO `tbl_meeting` (`meeting_id`, `meeting_title`, `meeting_description`, `issue_date`, `branch_id`) VALUES
(6, 'Water Problem', '<p><strong>We need to solve water problem soon.</strong></p>\r\n', '2019-08-27', 8);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notice_board`
--

CREATE TABLE `tbl_notice_board` (
  `notice_id` int(11) NOT NULL,
  `notice_title` varchar(500) NOT NULL,
  `notice_description` text NOT NULL,
  `notice_status` tinyint(1) NOT NULL DEFAULT 1,
  `branch_id` int(11) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `tbl_notice_board`
--

INSERT INTO `tbl_notice_board` (`notice_id`, `notice_title`, `notice_description`, `notice_status`, `branch_id`, `created_date`) VALUES
(7, 'Building In and Out', '<p>asasas</p>\r\n', 1, 8, '2019-08-27');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_notification_alert`
--

CREATE TABLE `tbl_notification_alert` (
  `notification_Id` int(11) NOT NULL,
  `subject` varchar(250) NOT NULL,
  `message` varchar(5000) NOT NULL,
  `type` int(11) DEFAULT NULL COMMENT '1=sms,2=email,3=both',
  `user_details` varchar(5000) NOT NULL,
  `branch_id` int(11) DEFAULT NULL,
  `sent_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_owner_notice_board`
--

CREATE TABLE `tbl_owner_notice_board` (
  `notice_id` int(11) NOT NULL,
  `notice_title` varchar(500) NOT NULL,
  `notice_description` text NOT NULL,
  `notice_status` tinyint(1) NOT NULL DEFAULT 1,
  `branch_id` int(11) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tbl_particle_payments`
--

CREATE TABLE `tbl_particle_payments` (
  `id` int(11) NOT NULL,
  `ep_id` int(11) NOT NULL,
  `amount` double NOT NULL,
  `invoice_no` bigint(20) DEFAULT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `comments` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_particle_payments`
--

INSERT INTO `tbl_particle_payments` (`id`, `ep_id`, `amount`, `invoice_no`, `date`, `comments`) VALUES
(33, 87, 677.33, NULL, '2024-02-29', NULL),
(34, 91, 1, NULL, '2024-02-29', NULL),
(35, 91, 1, NULL, '2024-02-29', NULL),
(36, 91, 2, NULL, '2024-03-01', NULL),
(37, 93, 2, NULL, '2024-03-01', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tbl_property_type`
--

CREATE TABLE `tbl_property_type` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `vat` enum('0','1') NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_property_type`
--

INSERT INTO `tbl_property_type` (`id`, `name`, `vat`, `created_at`) VALUES
(1, 'Residential', '0', '2024-02-08 08:31:50'),
(2, 'Commercial', '1', '2024-02-08 08:31:50');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_settings`
--

CREATE TABLE `tbl_settings` (
  `lang_code` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `currency` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `currency_seperator` varchar(5) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `currency_position` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `currency_decimal` int(11) NOT NULL DEFAULT 2,
  `mail_protocol` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT 'mail',
  `super_admin_image` varchar(350) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `date_format` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `smtp_hostname` varchar(250) DEFAULT NULL,
  `smtp_username` varchar(250) DEFAULT NULL,
  `smtp_password` varchar(250) DEFAULT NULL,
  `smtp_port` varchar(10) DEFAULT NULL,
  `smtp_secure` varchar(10) DEFAULT NULL,
  `cat_username` varchar(50) DEFAULT NULL,
  `cat_password` varchar(100) DEFAULT NULL,
  `cat_apikey` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_settings`
--

INSERT INTO `tbl_settings` (`lang_code`, `currency`, `currency_seperator`, `currency_position`, `currency_decimal`, `mail_protocol`, `super_admin_image`, `date_format`, `smtp_hostname`, `smtp_username`, `smtp_password`, `smtp_port`, `smtp_secure`, `cat_username`, `cat_password`, `cat_apikey`) VALUES
('English', '$', '.', 'left', 2, 'mail', 'CA8D0636-E7DD-542A-8775-7CC2DA9C7739.jpg', '', '', '', '', '', 'tls', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbl_visitor`
--

CREATE TABLE `tbl_visitor` (
  `vid` int(11) NOT NULL,
  `issue_date` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `name` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `mobile` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `address` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `floor_id` int(11) NOT NULL,
  `unit_id` int(11) NOT NULL,
  `intime` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `outtime` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `xmonth` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `xyear` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `branch_id` int(11) NOT NULL,
  `added_date` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbl_visitor`
--

INSERT INTO `tbl_visitor` (`vid`, `issue_date`, `name`, `mobile`, `address`, `floor_id`, `unit_id`, `intime`, `outtime`, `xmonth`, `xyear`, `branch_id`, `added_date`) VALUES
(17, '27/08/2019', 'Kalvin Peter', '1212121212', '799 Princess Drive\r\nNorwood, MA 02062', 12, 30, '12:50 PM', '05:50 PM', '8', '2019', 8, '2019-08-27 04:40:22');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tblbranch`
--
ALTER TABLE `tblbranch`
  ADD PRIMARY KEY (`branch_id`);

--
-- Indexes for table `tblsuper_admin`
--
ALTER TABLE `tblsuper_admin`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `tbl_add_admin`
--
ALTER TABLE `tbl_add_admin`
  ADD PRIMARY KEY (`aid`);

--
-- Indexes for table `tbl_add_bill`
--
ALTER TABLE `tbl_add_bill`
  ADD PRIMARY KEY (`bill_id`);

--
-- Indexes for table `tbl_add_bill_type`
--
ALTER TABLE `tbl_add_bill_type`
  ADD PRIMARY KEY (`bt_id`);

--
-- Indexes for table `tbl_add_builder_info`
--
ALTER TABLE `tbl_add_builder_info`
  ADD PRIMARY KEY (`bldrid`);

--
-- Indexes for table `tbl_add_building_info`
--
ALTER TABLE `tbl_add_building_info`
  ADD PRIMARY KEY (`bldid`);

--
-- Indexes for table `tbl_add_complain`
--
ALTER TABLE `tbl_add_complain`
  ADD PRIMARY KEY (`complain_id`);

--
-- Indexes for table `tbl_add_employee`
--
ALTER TABLE `tbl_add_employee`
  ADD PRIMARY KEY (`eid`);

--
-- Indexes for table `tbl_add_employee_salary_setup`
--
ALTER TABLE `tbl_add_employee_salary_setup`
  ADD PRIMARY KEY (`emp_id`);

--
-- Indexes for table `tbl_add_fair`
--
ALTER TABLE `tbl_add_fair`
  ADD PRIMARY KEY (`f_id`);

--
-- Indexes for table `tbl_add_floor`
--
ALTER TABLE `tbl_add_floor`
  ADD PRIMARY KEY (`fid`);

--
-- Indexes for table `tbl_add_fund`
--
ALTER TABLE `tbl_add_fund`
  ADD PRIMARY KEY (`fund_id`);

--
-- Indexes for table `tbl_add_maintenance_cost`
--
ALTER TABLE `tbl_add_maintenance_cost`
  ADD PRIMARY KEY (`mcid`);

--
-- Indexes for table `tbl_add_management_committee`
--
ALTER TABLE `tbl_add_management_committee`
  ADD PRIMARY KEY (`mc_id`);

--
-- Indexes for table `tbl_add_member_type`
--
ALTER TABLE `tbl_add_member_type`
  ADD PRIMARY KEY (`member_id`);

--
-- Indexes for table `tbl_add_month_setup`
--
ALTER TABLE `tbl_add_month_setup`
  ADD PRIMARY KEY (`m_id`);

--
-- Indexes for table `tbl_add_owner`
--
ALTER TABLE `tbl_add_owner`
  ADD PRIMARY KEY (`ownid`);

--
-- Indexes for table `tbl_add_owner_unit_relation`
--
ALTER TABLE `tbl_add_owner_unit_relation`
  ADD KEY `owner_id` (`owner_id`);

--
-- Indexes for table `tbl_add_owner_utility`
--
ALTER TABLE `tbl_add_owner_utility`
  ADD PRIMARY KEY (`owner_utility_id`);

--
-- Indexes for table `tbl_add_rent`
--
ALTER TABLE `tbl_add_rent`
  ADD PRIMARY KEY (`rid`);

--
-- Indexes for table `tbl_add_unit`
--
ALTER TABLE `tbl_add_unit`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `tbl_add_utility_bill`
--
ALTER TABLE `tbl_add_utility_bill`
  ADD PRIMARY KEY (`utility_id`);

--
-- Indexes for table `tbl_add_year_setup`
--
ALTER TABLE `tbl_add_year_setup`
  ADD PRIMARY KEY (`y_id`);

--
-- Indexes for table `tbl_currency`
--
ALTER TABLE `tbl_currency`
  ADD PRIMARY KEY (`cid`);

--
-- Indexes for table `tbl_emi_payment`
--
ALTER TABLE `tbl_emi_payment`
  ADD PRIMARY KEY (`id`),
  ADD KEY `rid` (`rid`) USING BTREE;

--
-- Indexes for table `tbl_employee_leave_request`
--
ALTER TABLE `tbl_employee_leave_request`
  ADD PRIMARY KEY (`leave_id`);

--
-- Indexes for table `tbl_employee_notice`
--
ALTER TABLE `tbl_employee_notice`
  ADD PRIMARY KEY (`notice_id`);

--
-- Indexes for table `tbl_full_payments`
--
ALTER TABLE `tbl_full_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_meeting`
--
ALTER TABLE `tbl_meeting`
  ADD PRIMARY KEY (`meeting_id`);

--
-- Indexes for table `tbl_notice_board`
--
ALTER TABLE `tbl_notice_board`
  ADD PRIMARY KEY (`notice_id`);

--
-- Indexes for table `tbl_notification_alert`
--
ALTER TABLE `tbl_notification_alert`
  ADD PRIMARY KEY (`notification_Id`);

--
-- Indexes for table `tbl_owner_notice_board`
--
ALTER TABLE `tbl_owner_notice_board`
  ADD PRIMARY KEY (`notice_id`);

--
-- Indexes for table `tbl_particle_payments`
--
ALTER TABLE `tbl_particle_payments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_property_type`
--
ALTER TABLE `tbl_property_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbl_visitor`
--
ALTER TABLE `tbl_visitor`
  ADD PRIMARY KEY (`vid`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tblbranch`
--
ALTER TABLE `tblbranch`
  MODIFY `branch_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `tblsuper_admin`
--
ALTER TABLE `tblsuper_admin`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tbl_add_admin`
--
ALTER TABLE `tbl_add_admin`
  MODIFY `aid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_add_bill`
--
ALTER TABLE `tbl_add_bill`
  MODIFY `bill_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_add_bill_type`
--
ALTER TABLE `tbl_add_bill_type`
  MODIFY `bt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tbl_add_builder_info`
--
ALTER TABLE `tbl_add_builder_info`
  MODIFY `bldrid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_add_building_info`
--
ALTER TABLE `tbl_add_building_info`
  MODIFY `bldid` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_add_complain`
--
ALTER TABLE `tbl_add_complain`
  MODIFY `complain_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `tbl_add_employee`
--
ALTER TABLE `tbl_add_employee`
  MODIFY `eid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_add_employee_salary_setup`
--
ALTER TABLE `tbl_add_employee_salary_setup`
  MODIFY `emp_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `tbl_add_fair`
--
ALTER TABLE `tbl_add_fair`
  MODIFY `f_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `tbl_add_floor`
--
ALTER TABLE `tbl_add_floor`
  MODIFY `fid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `tbl_add_fund`
--
ALTER TABLE `tbl_add_fund`
  MODIFY `fund_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `tbl_add_maintenance_cost`
--
ALTER TABLE `tbl_add_maintenance_cost`
  MODIFY `mcid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_add_management_committee`
--
ALTER TABLE `tbl_add_management_committee`
  MODIFY `mc_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tbl_add_member_type`
--
ALTER TABLE `tbl_add_member_type`
  MODIFY `member_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_add_month_setup`
--
ALTER TABLE `tbl_add_month_setup`
  MODIFY `m_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tbl_add_owner`
--
ALTER TABLE `tbl_add_owner`
  MODIFY `ownid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `tbl_add_owner_utility`
--
ALTER TABLE `tbl_add_owner_utility`
  MODIFY `owner_utility_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_add_rent`
--
ALTER TABLE `tbl_add_rent`
  MODIFY `rid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `tbl_add_unit`
--
ALTER TABLE `tbl_add_unit`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;

--
-- AUTO_INCREMENT for table `tbl_add_utility_bill`
--
ALTER TABLE `tbl_add_utility_bill`
  MODIFY `utility_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_add_year_setup`
--
ALTER TABLE `tbl_add_year_setup`
  MODIFY `y_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `tbl_currency`
--
ALTER TABLE `tbl_currency`
  MODIFY `cid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `tbl_emi_payment`
--
ALTER TABLE `tbl_emi_payment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=98;

--
-- AUTO_INCREMENT for table `tbl_employee_leave_request`
--
ALTER TABLE `tbl_employee_leave_request`
  MODIFY `leave_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_employee_notice`
--
ALTER TABLE `tbl_employee_notice`
  MODIFY `notice_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_full_payments`
--
ALTER TABLE `tbl_full_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `tbl_meeting`
--
ALTER TABLE `tbl_meeting`
  MODIFY `meeting_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tbl_notice_board`
--
ALTER TABLE `tbl_notice_board`
  MODIFY `notice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tbl_notification_alert`
--
ALTER TABLE `tbl_notification_alert`
  MODIFY `notification_Id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_owner_notice_board`
--
ALTER TABLE `tbl_owner_notice_board`
  MODIFY `notice_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tbl_particle_payments`
--
ALTER TABLE `tbl_particle_payments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `tbl_property_type`
--
ALTER TABLE `tbl_property_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tbl_visitor`
--
ALTER TABLE `tbl_visitor`
  MODIFY `vid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
