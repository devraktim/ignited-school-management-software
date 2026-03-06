-- phpMyAdmin SQL Dump
-- version 5.2.1deb3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Mar 06, 2026 at 07:04 AM
-- Server version: 11.8.5-MariaDB-ubu2404
-- PHP Version: 8.2.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `stfrancis_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `withdrawn_students`
--

CREATE TABLE `withdrawn_students` (
  `id` int(11) NOT NULL,
  `student_id` int(11) DEFAULT NULL,
  `session_id` int(11) DEFAULT NULL,
  `class_id` int(11) DEFAULT NULL,
  `section_id` int(11) DEFAULT NULL,
  `tc_no` text DEFAULT NULL,
  `tc_date` date DEFAULT NULL,
  `date_of_leaving` date DEFAULT NULL,
  `reason` text DEFAULT NULL,
  `transfer_certificate` text DEFAULT NULL,
  `charecter_certificate` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `withdrawn_students`
--

INSERT INTO `withdrawn_students` (`id`, `student_id`, `session_id`, `class_id`, `section_id`, `tc_no`, `tc_date`, `date_of_leaving`, `reason`, `transfer_certificate`, `charecter_certificate`, `created_at`) VALUES
(1, 552, 1, 1, 1, '1111/2025', '2025-01-22', '2025-01-22', 'Transfer of parents', '{\"field_1\":\"Namgyal  Bhutia\",\"field_2\":\"\",\"field_3\":\"10-10-2025\",\"field_4\":\"\",\"field_5\":\"2025-01-22\",\"field_6\":\"\",\"field_7\":\"\",\"field_8\":\"\",\"field_9\":\"\",\"field_10\":\"\",\"field_11\":\"01-03-2020\",\"field_12\":\"\"}', NULL, '2025-01-22 04:22:58'),
(2, 536, 1, 15, 2, '0000/23-24', '2025-02-06', '2025-02-06', 'Transfer of parents', '{\"field_1\":\"KARMA WANGCHUK LAMA TAMANG\",\"field_2\":\"TSHERING LAMA TAMANG\",\"field_3\":\"04-02-2019\",\"field_4\":\"\",\"field_5\":\"2025-02-06\",\"field_6\":\"\",\"field_7\":\"\",\"field_8\":\"\",\"field_9\":\"\",\"field_10\":\"\",\"field_11\":\"12-03-2008\",\"field_12\":\"\"}', '{\"field_1\":\"KARMA WANGCHUK LAMA TAMANG\",\"field_2\":\"TSHERING LAMA TAMANG\",\"field_3\":\"\",\"field_4\":\"\",\"field_5\":\"\",\"field_6\":\"11-12-2025\"}', '2025-02-06 09:53:31'),
(3, 519, 1, 13, 1, '0000/23-24', '2025-02-06', '2025-02-06', 'Transfer of parents', NULL, NULL, '2025-02-06 09:54:56'),
(4, 480, 1, 12, 1, '0000/23-24', '2025-02-06', '2025-02-06', 'Transfer of parents', '{\"field_1\":\"PRIYA  TAMANG\",\"field_2\":\"YOGEN TAMANG\",\"field_3\":\"12-12-2013\",\"field_4\":\"\",\"field_5\":\"2025-02-06\",\"field_6\":\"\",\"field_7\":\"\",\"field_8\":\"\",\"field_9\":\"\",\"field_10\":\"\",\"field_11\":\"21-07-2010\",\"field_12\":\"\"}', '{\"field_1\":\"PRIYA  TAMANG\",\"field_2\":\"YOGEN TAMANG\",\"field_3\":\"\",\"field_4\":\"\",\"field_5\":\"\",\"field_6\":\"24-07-2025\"}', '2025-02-06 09:56:18'),
(5, 491, 1, 12, 1, '0000/23-24', '2025-02-06', '2025-02-06', 'Transfer of parents', NULL, NULL, '2025-02-06 09:56:35'),
(7, 424, 1, 11, 1, '0000/23-24', '2025-02-06', '2025-02-06', 'Transfer of parents', NULL, NULL, '2025-02-06 09:57:35'),
(8, 423, 1, 11, 1, '0000/23-24', '2025-02-06', '2025-02-06', 'Transfer of parents', NULL, NULL, '2025-02-06 09:57:55'),
(9, 429, 1, 11, 1, '0000/23-24', '2025-02-06', '2025-02-06', 'Transfer of parents', NULL, NULL, '2025-02-06 09:58:09'),
(10, 430, 1, 11, 1, '0000/23-24', '2025-02-07', '2025-02-07', 'Transfer of parents', NULL, NULL, '2025-02-07 09:54:05'),
(11, 439, 1, 11, 1, '0000/23-24', '2025-02-07', '2025-02-07', 'Transfer of parents', NULL, NULL, '2025-02-07 09:54:28'),
(12, 427, 1, 11, 1, '0000/23-24', '2025-02-07', '2025-02-07', 'Transfer of parents', NULL, NULL, '2025-02-07 09:54:54'),
(13, 453, 1, 11, 1, '0000/23-24', '2025-02-07', '2025-02-07', 'Transfer of parents', NULL, NULL, '2025-02-07 09:55:18'),
(14, 371, 1, 10, 1, '0000/23-24', '2025-02-07', '2025-02-07', 'Transfer of parents', NULL, NULL, '2025-02-07 09:55:44'),
(15, 393, 1, 10, 1, '0000/23-24', '2025-02-07', '2025-02-07', 'Transfer of parents', NULL, NULL, '2025-02-07 09:56:00'),
(16, 395, 1, 10, 1, '0000/23-24', '2025-02-07', '2025-02-07', 'Transfer of parents', NULL, NULL, '2025-02-07 09:56:36'),
(17, 392, 1, 10, 1, '0000/23-24', '2025-02-07', '2025-02-07', 'Transfer of parents', NULL, NULL, '2025-02-07 09:56:59'),
(18, 401, 1, 10, 1, '0000/23-24', '2025-02-07', '2025-02-07', 'Transfer of parents', NULL, NULL, '2025-02-07 09:57:24'),
(19, 376, 1, 10, 1, '0000/23-24', '2025-02-07', '2025-02-07', 'Transfer of parents', NULL, NULL, '2025-02-07 09:57:45'),
(20, 322, 1, 9, 1, '0000/23-24', '2025-02-07', '2025-02-07', 'Transfer of parents', NULL, NULL, '2025-02-07 09:58:13'),
(21, 367, 1, 9, 1, '0000/23-24', '2025-02-07', '2025-02-07', 'Transfer of parents', NULL, NULL, '2025-02-07 09:58:34'),
(22, 343, 1, 9, 1, '0000/23-24', '2025-02-07', '2025-02-07', 'Transfer of parents', NULL, NULL, '2025-02-07 09:59:02'),
(23, 357, 1, 9, 1, '0000/23-24', '2025-02-07', '2025-02-07', 'Transfer of parents', NULL, NULL, '2025-02-07 09:59:22'),
(24, 331, 1, 9, 1, '0000/23-24', '2025-02-07', '2025-02-07', 'Transfer of parents', NULL, NULL, '2025-02-07 09:59:42'),
(25, 342, 1, 9, 1, '0000/23-24', '2025-02-07', '2025-02-07', 'Transfer of parents', NULL, NULL, '2025-02-07 09:59:55'),
(26, 387, 1, 10, 1, '0000/23-24', '2025-02-07', '2025-02-07', 'Transfer of parents', '{\"field_1\":\"PRIYANSI  BISWAKARMA\",\"field_2\":\"MR.MAN BAHADUR BISWAKARMA\",\"field_3\":\"19-01-2016\",\"field_4\":\"\",\"field_5\":\"2025-02-07\",\"field_6\":\"\",\"field_7\":\"\",\"field_8\":\"\",\"field_9\":\"\",\"field_10\":\"\",\"field_11\":\"25-10-2012\",\"field_12\":\"\"}', NULL, '2025-02-07 10:00:27'),
(27, 294, 1, 8, 1, '0000/23-24', '2025-02-07', '2025-02-07', 'Transfer of parents', NULL, NULL, '2025-02-07 10:01:26'),
(28, 278, 1, 8, 1, '0000/23-24', '2025-02-07', '2025-02-07', 'Transfer of parents', NULL, NULL, '2025-02-07 10:01:39'),
(29, 198, 1, 6, 1, '0000/23-24', '2025-02-07', '2025-02-07', 'Transfer of parents', NULL, NULL, '2025-02-07 10:02:12'),
(30, 188, 1, 6, 1, '0000/23-24', '2025-02-07', '2025-02-07', 'Transfer of parents', NULL, NULL, '2025-02-07 10:02:28'),
(31, 203, 1, 6, 1, '0000/23-24', '2025-02-07', '2025-02-07', 'Transfer of parents', NULL, NULL, '2025-02-07 10:02:49'),
(32, 259, 1, 7, 1, '0000/23-24', '2025-02-07', '2025-02-07', 'Transfer of parents', NULL, NULL, '2025-02-07 10:03:35'),
(33, 124, 1, 4, 1, '0000/23-24', '2025-02-08', '2025-02-08', 'Transfer of parents', '{\"field_1\":\"REYANSH  GUPTA\",\"field_2\":\"RAJESH GUPTA\",\"field_3\":\"20-02-2023\",\"field_4\":\"\",\"field_5\":\"2025-02-08\",\"field_6\":\"\",\"field_7\":\"\",\"field_8\":\"\",\"field_9\":\"\",\"field_10\":\"\",\"field_11\":\"09-02-2019\",\"field_12\":\"\"}', '{\"field_1\":\"REYANSH  GUPTA\",\"field_2\":\"RAJESH GUPTA\",\"field_3\":\"\",\"field_4\":\"\",\"field_5\":\"\",\"field_6\":\"20-01-2026\"}', '2025-02-08 06:28:12'),
(34, 361, 1, 9, 1, '0000/23-24', '2025-02-08', '2025-02-08', 'Transfer of parents', NULL, NULL, '2025-02-08 06:30:11'),
(35, 36, 1, 2, 1, '0000/23-24', '2025-02-08', '2025-02-08', 'Transfer of parents', NULL, NULL, '2025-02-08 06:33:05'),
(36, 40, 1, 2, 1, '0000/23-24', '2025-02-08', '2025-02-08', 'Transfer of parents', NULL, NULL, '2025-02-08 06:33:50'),
(37, 17, 1, 2, 1, '0000/23-24', '2025-02-21', '2025-02-21', 'MEDICAL', NULL, NULL, '2025-02-21 03:11:01'),
(38, 91, 1, 3, 1, '0000/23-24', '2025-02-21', '2025-02-21', 'MEDICAL', NULL, NULL, '2025-02-21 03:12:20'),
(39, 218, 1, 6, 1, '0000/23-24', '2025-02-25', '2025-02-25', 'OTHER REASON', NULL, NULL, '2025-02-25 04:49:45'),
(40, 15, 1, 2, 1, '0000/23-24', '2025-02-25', '2025-02-25', 'PARENTS REQUEST', NULL, NULL, '2025-02-25 04:51:33'),
(41, 120, 1, 4, 1, '0000/23-24', '2025-02-25', '2025-02-25', 'PARENTS REQUEST', '{\"field_1\":\"PAVIKA RANI SINHA\",\"field_2\":\"GAYTAM KUMAR SINHA\",\"field_3\":\"22-02-2023\",\"field_4\":\"\",\"field_5\":\"2025-02-25\",\"field_6\":\"\",\"field_7\":\"\",\"field_8\":\"\",\"field_9\":\"\",\"field_10\":\"\",\"field_11\":\"14-08-2018\",\"field_12\":\"\"}', NULL, '2025-02-25 06:01:58'),
(42, 157, 1, 5, 1, '0000/23-24', '2025-02-25', '2025-02-25', 'PARENTS REQUEST', NULL, NULL, '2025-02-25 06:04:31'),
(43, 243, 1, 7, 1, '0000/23-24', '2025-02-25', '2025-02-25', 'PARENTS REQUEST', NULL, NULL, '2025-02-25 06:09:16'),
(44, 323, 1, 8, 1, '0000/23-24', '2025-02-25', '2025-02-25', 'OTHER REASON', NULL, NULL, '2025-02-25 06:10:41'),
(45, 286, 1, 8, 1, '0000/23-24', '2025-02-25', '2025-02-25', 'PARENTS REQUEST', NULL, NULL, '2025-02-25 06:13:11'),
(47, 411, 1, 11, 1, '0000/23-24', '2025-02-25', '2025-02-25', 'PARENTS REQUEST', NULL, NULL, '2025-02-25 06:29:20'),
(48, 421, 1, 11, 1, '0000/23-24', '2025-02-25', '2025-02-25', 'PARENTS REQUEST', NULL, NULL, '2025-02-25 06:29:51'),
(49, 438, 1, 11, 1, '0000/23-24', '2025-02-25', '2025-02-25', 'OTHER REASON', NULL, NULL, '2025-02-25 06:30:30'),
(50, 10, 1, 2, 1, '0000/23-24', '2025-03-01', '2025-03-01', 'Transfer of parents', NULL, NULL, '2025-03-01 05:43:26'),
(51, 652, 1, 14, 3, '0001/23-24', '2025-06-25', '2025-06-25', 'OTHER REASON', NULL, NULL, '2025-06-25 12:23:50'),
(52, 653, 1, 14, 3, '0002/23-24', '2025-06-25', '2025-06-25', 'OTHER REASON', NULL, NULL, '2025-06-25 12:24:53'),
(53, 121, 1, 4, 1, '0000/23-24', '2025-07-18', '2025-07-18', 'Transfer of parents', '{\"field_1\":\"PEMTSHEY SOYANG TAMANG\",\"field_2\":\"DILKASH TAMANG\",\"field_3\":\"13-02-2023\",\"field_4\":\"-\",\"field_5\":\"2025-07-18\",\"field_6\":\"Good\",\"field_7\":\"One 1\",\"field_8\":\"ICSE\",\"field_9\":\"February \",\"field_10\":\"January \",\"field_11\":\"17-11-2018\",\"field_12\":\"Case doesn\'t arise \"}', '{\"field_1\":\"PEMTSHEY SOYANG TAMANG\",\"field_2\":\"DILKASH TAMANG\",\"field_3\":\"JORETHANG SOUTH SIKKIM\",\"field_4\":\"GOOD\",\"field_5\":\"GOOD\",\"field_6\":\"18-07-2025\"}', '2025-07-18 04:02:20'),
(56, 470, 1, 12, 1, '0000/23-24', '2025-07-27', '2025-07-27', 'MEDICAL', '{\"field_1\":\"KODELA  LOUKYA\",\"field_2\":\"KODELA SRINIVAS\",\"field_3\":\"17-04-2023\",\"field_4\":\"\",\"field_5\":\"2025-07-27\",\"field_6\":\"\",\"field_7\":\"\",\"field_8\":\"\",\"field_9\":\"\",\"field_10\":\"\",\"field_11\":\"20-03-2012\",\"field_12\":\"\"}', NULL, '2025-07-27 16:48:06'),
(57, 658, 1, 14, 2, '0000/23-24', '2025-10-27', '2025-10-27', 'PARENTS REQUEST', '{\"field_1\":\"PRATIK  GUPTA\",\"field_2\":\"ANAND SAGAR GUPTA\",\"field_3\":\"08-02-2020\",\"field_4\":\"SARASWATI SISHU VIDYALAYA, WEST SIKKIM\",\"field_5\":\"2025-10-27\",\"field_6\":\"GOOD\",\"field_7\":\"X (TEN)\",\"field_8\":\"ICSE\",\"field_9\":\"FEBRUARY\",\"field_10\":\"JANUARY\",\"field_11\":\"18-08-2009\",\"field_12\":\"GRANTED\"}', '{\"field_1\":\"PRATIK  GUPTA\",\"field_2\":\"ANAND SAGAR GUPTA\",\"field_3\":\"NAYABAZAR, WEST SIKKIM\",\"field_4\":\"GOOD\",\"field_5\":\"Average in grasping\",\"field_6\":\"27-10-2025\"}', '2025-10-27 07:24:38'),
(58, 44, 1, 3, 1, '0001/25-26', '2025-04-29', '2025-04-30', 'PARENTS REQUEST', NULL, NULL, '2025-10-27 13:23:46'),
(59, 69, 1, 3, 1, '0000/23-24', '2025-11-13', '2025-11-13', 'PARENTS REQUEST', '{\"field_1\":\"EVA  PRADHAN\",\"field_2\":\"BISHAL PRADHAN\",\"field_3\":\"05-02-2024\",\"field_4\":\"FC CONVENT, JORETHANG\",\"field_5\":\"2025-11-13\",\"field_6\":\"GOOD\",\"field_7\":\"UKG\",\"field_8\":\"ICSE\",\"field_9\":\"FEBRUARY\",\"field_10\":\"JANUARY\",\"field_11\":\"17-09-2019\",\"field_12\":\"-\"}', '{\"field_1\":\"EVA  PRADHAN\",\"field_2\":\"BISHAL PRADHAN\",\"field_3\":\"JORETHANG SOUTH SIKKIM\",\"field_4\":\"Good\",\"field_5\":\"Excellent in grasping\",\"field_6\":\"13-11-2025\"}', '2025-11-13 03:31:51'),
(60, 586, 1, 1, 1, '0000/23-24', '2025-11-14', '2025-11-14', 'MEDICAL', NULL, NULL, '2025-11-14 13:48:14'),
(61, 329, 1, 9, 1, '0000/23-24', '2025-11-15', '2025-11-15', 'PARENTS REQUEST', '{\"field_1\":\"ANANYA  SANDILYA\",\"field_2\":\"K.N CHAUDHARY\",\"field_3\":\"02-02-2022\",\"field_4\":\"\",\"field_5\":\"2025-11-15\",\"field_6\":\"\",\"field_7\":\"\",\"field_8\":\"\",\"field_9\":\"\",\"field_10\":\"\",\"field_11\":\"27-01-2014\",\"field_12\":\"\"}', NULL, '2025-11-15 05:22:52'),
(62, 359, 1, 9, 1, '0000/23-24', '2025-11-15', '2025-11-15', 'Transfer of parents', NULL, '{\"field_1\":\"ROSE K BRAHMA\",\"field_2\":\"KAMAL KAFLEY\",\"field_3\":\"\",\"field_4\":\"\",\"field_5\":\"\",\"field_6\":\"10-12-2025\"}', '2025-11-15 05:23:15'),
(63, 568, 1, 1, 1, '0002/23-24', '2025-12-10', '2025-12-10', 'PARENTS REQUEST', '{\"field_1\":\"DIVYANSHU  RAI\",\"field_2\":\"SUMIT RAI\",\"field_3\":\"27-01-2025\",\"field_4\":\"                                                                                                                                                     NA                                                \",\"field_5\":\"2025-12-10\",\"field_6\":\"GOOD\",\"field_7\":\"NURSERY\",\"field_8\":\"ICSE\",\"field_9\":\"FEBRUARY\",\"field_10\":\"JANUARY\",\"field_11\":\"23-01-2022\",\"field_12\":\"GRANTED\"}', NULL, '2025-12-10 05:37:43'),
(64, 656, 1, 2, 1, '0003/23-24', '2025-12-10', '2025-12-10', 'PARENTS REQUEST', '{\"field_1\":\"IQRA  HAYYAT\",\"field_2\":\"\",\"field_3\":\"01-04-2025\",\"field_4\":\"AL HIDAYAH MISSION SCHOOL\",\"field_5\":\"2025-12-10\",\"field_6\":\"GOOD\",\"field_7\":\"LKG\",\"field_8\":\"ICSE\",\"field_9\":\"JANUARY\",\"field_10\":\"FEBRUARY\",\"field_11\":\"01-02-2022\",\"field_12\":\"GRANTED\"}', '{\"field_1\":\"IQRA  HAYYAT\",\"field_2\":\"\",\"field_3\":\"\",\"field_4\":\"\",\"field_5\":\"\",\"field_6\":\"10-12-2025\"}', '2025-12-10 05:38:59'),
(65, 22, 1, 2, 1, '0004/23-24', '2025-12-10', '2025-12-10', 'PARENTS REQUEST', NULL, NULL, '2025-12-10 05:39:29'),
(66, 28, 1, 2, 1, '0004/23-24', '2025-12-10', '2025-12-10', 'PARENTS REQUEST', '{\"field_1\":\"NYLAH  FATIMA\",\"field_2\":\"TARIQ ANSARI\",\"field_3\":\"05-02-2024\",\"field_4\":\"\",\"field_5\":\"2025-12-10\",\"field_6\":\"\",\"field_7\":\"\",\"field_8\":\"\",\"field_9\":\"\",\"field_10\":\"\",\"field_11\":\"17-07-2020\",\"field_12\":\"\"}', '{\"field_1\":\"NYLAH  FATIMA\",\"field_2\":\"TARIQ ANSARI\",\"field_3\":\"\",\"field_4\":\"\",\"field_5\":\"\",\"field_6\":\"10-12-2025\"}', '2025-12-10 05:42:52'),
(67, 19, 1, 2, 1, '0008/23-24', '2025-12-10', '2025-12-10', 'PARENTS REQUEST', NULL, NULL, '2025-12-10 08:51:40'),
(68, 419, 5, 12, 1, '0000/23-24', '2025-12-10', '2025-12-10', 'PARENTS REQUEST', NULL, NULL, '2026-01-28 09:13:18'),
(70, 368, 5, 11, 1, '0000/23-24', '2025-12-10', '2025-12-10', 'PARENTS REQUEST', NULL, NULL, '2026-01-28 09:18:30'),
(72, 559, 5, 2, 1, '0000/23-24', '2026-02-05', '2026-03-05', 'MEDICAL', NULL, NULL, '2026-03-05 08:42:01');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `withdrawn_students`
--
ALTER TABLE `withdrawn_students`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `withdrawn_students`
--
ALTER TABLE `withdrawn_students`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=73;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
