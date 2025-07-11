-- phpMyAdmin SQL Dump
-- version 5.2.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 09, 2025 at 09:59 PM
-- Server version: 10.6.22-MariaDB-log
-- PHP Version: 8.3.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fascalab_2020`
--

-- --------------------------------------------------------

--
-- Table structure for table `tbl_nta`
--

CREATE TABLE `tbl_nta` (
  `id` int(11) NOT NULL,
  `nta_date` datetime DEFAULT NULL,
  `received_date` datetime DEFAULT NULL,
  `nta_number` varchar(255) NOT NULL,
  `saro_number` varchar(255) NOT NULL,
  `account_number` varchar(255) NOT NULL,
  `particular` longtext NOT NULL,
  `quarter` varchar(255) NOT NULL,
  `amount` int(11) NOT NULL,
  `obligated` int(11) NOT NULL,
  `balance` int(11) NOT NULL,
  `created_by` int(11) NOT NULL,
  `date_created` datetime DEFAULT NULL,
  `status` int(11) NOT NULL COMMENT '0 = active,\r\n1 = inactive',
  `is_lock` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tbl_nta`
--

INSERT INTO `tbl_nta` (`id`, `nta_date`, `received_date`, `nta_number`, `saro_number`, `account_number`, `particular`, `quarter`, `amount`, `obligated`, `balance`, `created_by`, `date_created`, `status`, `is_lock`) VALUES
(1, '2022-04-12 16:32:48', '2022-04-12 16:32:48', '2022-02-0022', '2022-01-0057', 'NCA-BMB-D-22-0000243', 'NTA #2022-02-0022 - FY 2021 Hazard Pay of CTs (243)', '1Q', 400500, 0, 400500, 3319, '2022-04-12 01:32:48', 0, 0),
(2, '2022-04-12 16:35:41', '2022-04-12 16:35:41', '2022-02-0027', '2022-02-0257', 'NCA-BMB-D-22-0000243', 'NTA #2022-02-0027 - Salaries of ICT Personnel, ICT R/M & Internet Lease Line of the Region (243)', '1Q', 27000, 0, 27000, 3319, '2022-04-12 01:35:41', 0, 0),
(3, '2022-04-12 16:36:37', '2022-04-12 16:36:37', '2022-03-0048', '2022-01-0068', 'NCA-BMB-D-22-0000243', 'NTA #2022-03-0048 - Manila Bay Fund (243)', '1Q', 45641, 0, 45641, 3319, '2022-04-12 01:36:37', 0, 0),
(4, '2022-04-12 16:37:19', '2022-04-12 16:37:19', '2022-03-0049', '2022-02-0286', 'NCA-BMB-D-22-0000243', 'NTA #2022-03-0049 - FY 2022 RCSP (243)', '1Q', 70354, 0, 70354, 3319, '2022-04-12 01:37:19', 0, 0),
(5, '2022-04-13 09:18:20', '2022-04-13 09:18:20', '2022-03-0049', '2022-02-0286', 'NCA-BMB-D-22-0000243', 'NTA #2022-03-0049 - FY 2022 RCSP (243)', '1Q', 70354, 0, 70354, 3319, '2022-04-12 18:18:20', 0, 0),
(6, '2022-04-13 09:19:21', '2022-04-13 09:19:21', '2022-03-0083', '2022-03-0559', 'NCA-BMB-D-22-0000243', 'NTA #2022-03-0083 - Funding for DILG MC 2022-005; Guidelines on the Accreditation of CSOs to Co-implement DILG Programs & Projects (243)', '1Q', 13900, 0, 13900, 3319, '2022-04-12 18:19:21', 0, 0),

-- Indexes for dumped tables
--

--
-- Indexes for table `tbl_nta`
--
ALTER TABLE `tbl_nta`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tbl_nta`
--
ALTER TABLE `tbl_nta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
