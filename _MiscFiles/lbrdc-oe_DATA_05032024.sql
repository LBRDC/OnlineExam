-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2024 at 10:45 AM
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
-- Database: `lbrdc-oe`
--
CREATE DATABASE IF NOT EXISTS `lbrdc-oe` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `lbrdc-oe`;

-- --------------------------------------------------------

--
-- Table structure for table `admin_user`
--
-- Creation: Apr 11, 2024 at 12:38 AM
-- Last update: May 03, 2024 at 08:38 AM
--

DROP TABLE IF EXISTS `admin_user`;
CREATE TABLE `admin_user` (
  `admin_id` int(11) NOT NULL,
  `admin_username` varchar(255) NOT NULL,
  `admin_fname` varchar(255) NOT NULL,
  `admin_lname` varchar(255) NOT NULL,
  `admin_pos` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_super` int(1) NOT NULL,
  `admin_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`admin_id`, `admin_username`, `admin_fname`, `admin_lname`, `admin_pos`, `admin_password`, `admin_super`, `admin_created`) VALUES
(1, 'admin', 'Admin', 'User', 'Superuser', 'admin', 1, '2024-04-11 00:38:42'),
(2, 'Lbrdc', 'LBRDC', 'USER', 'Employee', 'lbrdc', 0, '2024-05-03 05:46:55'),
(3, 'administrator', 'Admin2', 'User', 'Administrator', 'admin', 0, '2024-05-03 08:38:50');

-- --------------------------------------------------------

--
-- Table structure for table `cluster_tbl`
--
-- Creation: Apr 11, 2024 at 12:33 AM
--

DROP TABLE IF EXISTS `cluster_tbl`;
CREATE TABLE `cluster_tbl` (
  `clu_id` int(11) NOT NULL,
  `clu_name` varchar(255) NOT NULL,
  `clu_description` varchar(255) NOT NULL,
  `clu_status` int(1) NOT NULL,
  `clu_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cluster_tbl`
--

INSERT INTO `cluster_tbl` (`clu_id`, `clu_name`, `clu_description`, `clu_status`, `clu_created`) VALUES
(1, 'TEST Cluster', 'TEST', 1, '2024-04-11 06:22:03'),
(2, 'Test Cluster 2', 'Test 2', 0, '2024-04-15 03:39:33'),
(3, 'Information Technology', 'IT', 1, '2024-04-11 06:29:25'),
(4, 'Debug', 'for debugging purposes', 1, '2024-04-12 01:28:46'),
(5, 'Admin', 'for admin purposes', 1, '2024-04-15 05:41:41'),
(6, 'Debug 2', '', 1, '2024-04-12 03:36:24'),
(7, 'test', 'zrghaeghr', 1, '2024-04-30 01:31:41');

-- --------------------------------------------------------

--
-- Table structure for table `examinee_answers`
--
-- Creation: Apr 29, 2024 at 08:20 AM
-- Last update: May 03, 2024 at 07:42 AM
--

DROP TABLE IF EXISTS `examinee_answers`;
CREATE TABLE `examinee_answers` (
  `exans_id` int(11) NOT NULL,
  `exmne_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `exqstn_id` int(11) NOT NULL,
  `exmne_answer` varchar(255) NOT NULL,
  `exatmpt_no` int(11) NOT NULL,
  `exans_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examinee_answers`
--

INSERT INTO `examinee_answers` (`exans_id`, `exmne_id`, `exam_id`, `exqstn_id`, `exmne_answer`, `exatmpt_no`, `exans_created`) VALUES
(1, 6, 1, 35, 'CH 1', 1, '2024-04-30 05:25:44'),
(2, 6, 2, 36, 'Choice 3', 1, '2024-04-30 05:25:53'),
(3, 6, 11, 37, 'CH1', 1, '2024-04-30 05:26:08'),
(4, 4, 1, 35, 'CH 4', 1, '2024-04-30 06:58:31'),
(5, 4, 2, 36, 'Choice 5', 1, '2024-04-30 07:01:34'),
(6, 4, 11, 37, 'CH1', 1, '2024-04-30 07:01:44'),
(7, 1, 2, 36, 'Choice 2', 1, '2024-04-30 07:33:50'),
(8, 1, 11, 37, 'CH1', 1, '2024-04-30 07:44:04'),
(9, 1, 1, 35, 'CH 1', 1, '2024-04-30 07:56:49'),
(10, 1, 10, 25, 'CH 1', 1, '2024-04-30 07:59:24'),
(11, 1, 10, 26, 'CH 2', 1, '2024-04-30 07:59:24'),
(12, 1, 10, 27, 'CH 3', 1, '2024-04-30 07:59:24'),
(13, 1, 10, 28, 'CH 4', 1, '2024-04-30 07:59:24'),
(14, 1, 10, 29, 'CH 5', 1, '2024-04-30 07:59:24'),
(15, 1, 10, 30, 'xftjh', 1, '2024-04-30 07:59:24'),
(16, 1, 10, 32, 'uk', 1, '2024-04-30 07:59:24'),
(17, 1, 10, 33, 'tuyrtu', 1, '2024-04-30 07:59:24'),
(18, 1, 10, 34, 'zhzdrh rhjyjj tttt', 1, '2024-04-30 07:59:24'),
(19, 7, 1, 35, 'CH 1', 1, '2024-05-03 01:28:36'),
(20, 7, 11, 37, 'CH1', 1, '2024-05-03 01:29:17'),
(21, 7, 10, 25, 'CH 3', 1, '2024-05-03 01:29:47'),
(22, 7, 10, 26, 'CH 1', 1, '2024-05-03 01:29:47'),
(23, 7, 10, 27, 'CH 1', 1, '2024-05-03 01:29:47'),
(24, 7, 10, 28, 'CH 6', 1, '2024-05-03 01:29:47'),
(25, 7, 10, 29, 'CH 1', 1, '2024-05-03 01:29:47'),
(26, 7, 10, 30, 'xftjh', 1, '2024-05-03 01:29:47'),
(27, 7, 10, 31, '6', 1, '2024-05-03 01:29:47'),
(28, 7, 10, 32, 'yjdtyj', 1, '2024-05-03 01:29:47'),
(29, 7, 10, 33, 'tuyrtu', 1, '2024-05-03 01:29:47'),
(30, 7, 10, 34, 'zrhzrhzrh', 1, '2024-05-03 01:29:47'),
(31, 8, 1, 35, 'CH 1', 1, '2024-05-03 07:38:59'),
(32, 8, 2, 36, 'Choice 1', 1, '2024-05-03 07:40:07'),
(33, 8, 11, 37, 'CH1', 1, '2024-05-03 07:41:19'),
(34, 8, 10, 25, 'CH 1', 1, '2024-05-03 07:42:50'),
(35, 8, 10, 26, 'CH 2', 1, '2024-05-03 07:42:50'),
(36, 8, 10, 27, 'CH 3', 1, '2024-05-03 07:42:50'),
(37, 8, 10, 28, 'CH 4', 1, '2024-05-03 07:42:50'),
(38, 8, 10, 29, 'CH 5', 1, '2024-05-03 07:42:50'),
(39, 8, 10, 30, 'xftjh', 1, '2024-05-03 07:42:50'),
(40, 8, 10, 32, 'thszdrgh', 1, '2024-05-03 07:42:50'),
(41, 8, 10, 33, 'txfjt', 1, '2024-05-03 07:42:50'),
(42, 8, 10, 34, 'hxh zhzdth zrhzdrh zrSEt', 1, '2024-05-03 07:42:50');

-- --------------------------------------------------------

--
-- Table structure for table `examinee_attempt`
--
-- Creation: Apr 29, 2024 at 02:34 AM
-- Last update: May 03, 2024 at 07:42 AM
--

DROP TABLE IF EXISTS `examinee_attempt`;
CREATE TABLE `examinee_attempt` (
  `exatmpt_id` int(11) NOT NULL,
  `exmne_id` int(11) NOT NULL,
  `ex_id` int(11) NOT NULL,
  `ex_score` int(11) NOT NULL,
  `ex_total` int(11) NOT NULL,
  `exatmpt_no` int(11) NOT NULL,
  `exatmpt_date` date NOT NULL,
  `exatmpt_time` time NOT NULL,
  `exatmpt_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examinee_attempt`
--

INSERT INTO `examinee_attempt` (`exatmpt_id`, `exmne_id`, `ex_id`, `ex_score`, `ex_total`, `exatmpt_no`, `exatmpt_date`, `exatmpt_time`, `exatmpt_created`) VALUES
(1, 6, 1, 1, 1, 1, '2024-04-30', '07:25:44', '2024-04-30 05:25:44'),
(2, 6, 2, 1, 1, 1, '2024-04-30', '07:25:53', '2024-04-30 05:25:53'),
(3, 6, 11, 1, 1, 1, '2024-04-30', '07:26:08', '2024-04-30 05:26:08'),
(4, 4, 1, 0, 1, 1, '2024-04-30', '08:58:31', '2024-04-30 06:58:31'),
(5, 4, 2, 0, 1, 1, '2024-04-30', '09:01:34', '2024-04-30 07:01:34'),
(6, 4, 11, 1, 1, 1, '2024-04-30', '09:01:44', '2024-04-30 07:01:44'),
(7, 1, 2, 0, 1, 1, '2024-04-30', '09:33:50', '2024-04-30 07:33:50'),
(8, 1, 11, 1, 1, 1, '2024-04-30', '09:44:04', '2024-04-30 07:44:04'),
(9, 1, 1, 1, 1, 1, '2024-04-30', '09:56:49', '2024-04-30 07:56:49'),
(10, 1, 10, 6, 10, 1, '2024-04-30', '09:59:24', '2024-04-30 07:59:24'),
(11, 4, 10, 0, 10, 1, '2024-05-03', '03:17:04', '2024-05-03 01:17:04'),
(12, 7, 1, 1, 1, 1, '2024-05-03', '03:28:36', '2024-05-03 01:28:36'),
(13, 7, 2, 0, 1, 1, '2024-05-03', '03:29:03', '2024-05-03 01:29:03'),
(14, 7, 11, 1, 1, 1, '2024-05-03', '03:29:17', '2024-05-03 01:29:17'),
(15, 7, 10, 1, 10, 1, '2024-05-03', '03:29:47', '2024-05-03 01:29:47'),
(16, 8, 1, 1, 1, 1, '2024-05-03', '09:38:59', '2024-05-03 07:38:59'),
(17, 8, 2, 0, 1, 1, '2024-05-03', '09:40:07', '2024-05-03 07:40:07'),
(18, 8, 11, 1, 1, 1, '2024-05-03', '09:41:19', '2024-05-03 07:41:19'),
(19, 8, 10, 5, 10, 1, '2024-05-03', '09:42:50', '2024-05-03 07:42:50');

-- --------------------------------------------------------

--
-- Table structure for table `examinee_tbl`
--
-- Creation: Apr 19, 2024 at 02:39 AM
-- Last update: May 03, 2024 at 07:31 AM
--

DROP TABLE IF EXISTS `examinee_tbl`;
CREATE TABLE `examinee_tbl` (
  `exmne_id` int(11) NOT NULL,
  `exmne_clu_id` varchar(255) NOT NULL,
  `exmne_fname` varchar(255) NOT NULL,
  `exmne_mname` varchar(255) NOT NULL,
  `exmne_lname` varchar(255) NOT NULL,
  `exmne_sfname` varchar(255) NOT NULL,
  `exmne_sex` varchar(255) NOT NULL,
  `exmne_birthdate` date NOT NULL,
  `exmne_email` varchar(255) NOT NULL,
  `exmne_pass` varchar(255) NOT NULL,
  `exmne_status` varchar(255) NOT NULL,
  `exmne_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examinee_tbl`
--

INSERT INTO `examinee_tbl` (`exmne_id`, `exmne_clu_id`, `exmne_fname`, `exmne_mname`, `exmne_lname`, `exmne_sfname`, `exmne_sex`, `exmne_birthdate`, `exmne_email`, `exmne_pass`, `exmne_status`, `exmne_created`) VALUES
(1, '1', 'Test', 'Debug', 'User', 'Jr.', 'Male', '1999-02-19', 'test@email.com', 'test', '1', '2024-04-30 06:48:16'),
(2, '4', 'Debug', 'Test', 'User', 'Sr.', 'Male', '1990-02-12', 'debug@email.com', 'debug', '1', '2024-04-19 05:22:02'),
(3, '2', 'TEST', 'test', 'Test', 'III', 'Female', '1999-02-12', 'test2@email.com', 'test', '1', '2024-04-19 05:26:38'),
(4, '1', 'LBRDC', 'Test', 'User', 'Jr.', 'Male', '1980-02-12', 'lbrdc@email.com', 'lbrdc', '1', '2024-04-30 06:16:45'),
(5, '4', 'wegweg', '', 'wG', '', '', '0000-00-00', 'gar@email.com', 'gar', '0', '2024-04-22 05:11:01'),
(6, '1', 'Test', 'User', 'Examinee', 'Jr.', 'Male', '1999-02-19', 'test.user@email.com', 'test', '1', '2024-04-30 00:05:43'),
(7, '1', 'Test 3', '', 'User', '', 'Male', '0000-00-00', 'test3@email.com', 'test', '1', '2024-05-03 01:25:09'),
(8, '1', 'Admin', '', 'Test', '', '', '0000-00-00', 'admintest@email.com', 'admin', '1', '2024-05-03 07:31:58');

-- --------------------------------------------------------

--
-- Table structure for table `exam_cluster_tbl`
--
-- Creation: Apr 11, 2024 at 12:33 AM
--

DROP TABLE IF EXISTS `exam_cluster_tbl`;
CREATE TABLE `exam_cluster_tbl` (
  `exclu_id` int(11) NOT NULL,
  `ex_id` int(11) NOT NULL,
  `clu_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_cluster_tbl`
--

INSERT INTO `exam_cluster_tbl` (`exclu_id`, `ex_id`, `clu_id`) VALUES
(76, 9, 4),
(77, 9, 6),
(89, 6, 2),
(90, 2, 1),
(91, 11, 1),
(93, 7, 3),
(94, 7, 4),
(95, 7, 5),
(96, 8, 4),
(97, 8, 5),
(98, 1, 1),
(99, 10, 1),
(100, 10, 4);

-- --------------------------------------------------------

--
-- Table structure for table `exam_question_tbl`
--
-- Creation: Apr 11, 2024 at 12:33 AM
--

DROP TABLE IF EXISTS `exam_question_tbl`;
CREATE TABLE `exam_question_tbl` (
  `exqstn_id` int(11) NOT NULL,
  `ex_id` int(11) NOT NULL,
  `exam_image` varchar(255) NOT NULL,
  `exam_question` varchar(255) NOT NULL,
  `exam_ch1` varchar(255) NOT NULL,
  `exam_ch2` varchar(255) NOT NULL,
  `exam_ch3` varchar(255) NOT NULL,
  `exam_ch4` varchar(255) NOT NULL,
  `exam_ch5` varchar(255) NOT NULL,
  `exam_ch6` varchar(255) NOT NULL,
  `exam_ch7` varchar(255) NOT NULL,
  `exam_ch8` varchar(255) NOT NULL,
  `exam_ch9` varchar(255) NOT NULL,
  `exam_ch10` varchar(255) NOT NULL,
  `exqstn_answer` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_question_tbl`
--

INSERT INTO `exam_question_tbl` (`exqstn_id`, `ex_id`, `exam_image`, `exam_question`, `exam_ch1`, `exam_ch2`, `exam_ch3`, `exam_ch4`, `exam_ch5`, `exam_ch6`, `exam_ch7`, `exam_ch8`, `exam_ch9`, `exam_ch10`, `exqstn_answer`) VALUES
(1, 8, '', 'TEST Question', '1', '2', '3', '4', '5', '', '', '', '', '', '2'),
(2, 8, '', 'Line Question 1', 'A', 'B', 'C', 'D', 'E', '', '', '', '', '', 'B'),
(3, 8, '', 'rsjk', 'rsjt', 'xj', 'ytk', '', '', '', '', '', '', '', '3'),
(4, 8, '', 'RTJTJ', 'RGHAWERGH', 'EHRRH', '', '', '', '', '', '', '', '', '2'),
(5, 8, '', 'ehh', 'hhaeh', '', '', '', '', '', '', '', '', '', '1'),
(6, 8, '', 'ehjhrsrjsr', 'zdsntfnazen', 'werahhwaeh', 'aerhawrh', '', '', '', '', '', '', '', '3'),
(7, 8, '', 'earh', 'werh', 'erh', 'awehr', '', '', '', '', '', '', '', '1'),
(8, 8, '', 'erh', 'abadfv', 'WEGWGjjjjjj', '', '', '', '', '', '', '', '', 'WEGWGjjjjjj'),
(9, 6, 'id_6-Test_Image_2(3).jpg', 'tjhnzedtrjhz', 'sghWSH', 'srhWSZh', 'nbzdnzxcvb', 'rhsehesfd', '', '', '', '', '', '', 'rhsehesfd'),
(10, 6, '', 'rfyjn', 'zfb', 'erhreh', '', '', '', '', '', '', '', '', 'zfb'),
(11, 6, '', 'jdyjxfhg', 'zrhsjhsr', 'xfgnn', '', '', '', '', '', '', '', '', 'xfgnn'),
(12, 6, '', 'ftgjhzeh', 'zdvzsgws', 'segWSHw', 'zsg', '', '', '', '', '', '', '', 'zdvzsgws'),
(13, 6, '', 'jrtjrt', 'hzxh', 'vbvc', '', '', '', '', '', '', '', '', 'hzxh'),
(14, 6, '', 'cjcjdff', 'zdhezrzr', 'zhdhr', 'EFGSDF', 'xfdtjtjh', '', '', '', '', '', '', 'xfdtjtjh'),
(15, 6, '', 'fgxjgxfjxfdtj', 'zdghzrdgh', '', '', '', '', '', '', '', '', '', 'zdghzrdgh'),
(20, 9, 'id_9-question-1.jpg', 'Test Question 1', '1', '2', '3', '4', '', '', '', '', '', '', '1'),
(21, 9, '', 'Test Question 2', '1', '2', '3', '4', '', '', '', '', '', '', '2'),
(23, 9, '', '4 ÷ 2 = ? ÷≥≤≠×', '2345', '52135', '5634', '', '', '', '', '', '', '', '2345'),
(24, 9, '', 'fxtjrtj', 'rtjzrtjrt', 'rjrtjr', 'xghxfgn', '', '', '', '', '', '', '', 'rtjzrtjrt'),
(25, 10, 'id_10-Test_Image_1.jpg', 'Test Question 1?', 'CH 1', 'CH 2', 'CH 3', 'CH 4', '', '', '', '', '', '', 'CH 1'),
(26, 10, 'id_10-Test_Image_2.jpg', 'Test Question 2?', 'CH 1', 'CH 2', 'CH 3', 'CH 4', '', '', '', '', '', '', 'CH 2'),
(27, 10, 'id_10-Test_Image_3.jpg', 'Test Question 3?', 'CH 1', 'CH 2', 'CH 3', 'CH 4', '', '', '', '', '', '', 'CH 3'),
(28, 10, '', 'Test Question 4?', 'CH 1', 'CH 2', 'CH 3', 'CH 4', 'CH 5', 'CH 6', '', '', '', '', 'CH 4'),
(29, 10, '', 'Test Question 5?', 'CH 1', 'CH 2', 'CH 3', 'CH 4', 'CH 5', 'CH 6', '', '', '', '', 'CH 5'),
(30, 10, '', 'xhsth', 'xftjh', 'xgn', 'tytyj', 'srh', 'xgnn', 'yikfyuk', 'wrWAR', 'ukffjk', 'Sefet', 'ergag  rggzeg', 'yikfyuk'),
(31, 10, '', '0 ÷ 0 = ?', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9', '0'),
(32, 10, '', 'tfjfjrtj', 'tjxfj', 'yjdtyj', 'xfgjcf', 'gcx', 'kjlblk', 'uk', 'b cvbcf', 'fggf gxfjfj xfgj', 'chgkcgj', 'thszdrgh', 'uk'),
(33, 10, '', 'tyiyti', 'tuyrtu', 'txfjt', 'cygk', 'oi7yo', '', '', '', '', '', '', 'oi7yo'),
(34, 10, '', 'xfgjxjj', 'zrhzrhzrh', 'hxh zhzdth zrhzdrh zrSEt', 'hdzhh jrtjrjryj zrgzg', 'zhzdrh rhjyjj tttt', '', '', '', '', '', '', 'zrhzrhzrh'),
(35, 1, '', 'Test Question 1', 'CH 1', 'CH 2', 'CH 3', 'CH 4', '', '', '', '', '', '', 'CH 1'),
(36, 2, '', 'Test Question 1', 'Choice 1', 'Choice 2', 'Choice 3', 'Choice 4', 'Choice 5', '', '', '', '', '', 'Choice 3'),
(37, 11, '', 'Test Question 1', 'CH1', 'CH2', 'CH3', '', '', '', '', '', '', '', 'CH1');

-- --------------------------------------------------------

--
-- Table structure for table `exam_tbl`
--
-- Creation: Apr 12, 2024 at 12:57 AM
--

DROP TABLE IF EXISTS `exam_tbl`;
CREATE TABLE `exam_tbl` (
  `ex_id` int(11) NOT NULL,
  `ex_title` varchar(255) NOT NULL,
  `ex_description` varchar(255) NOT NULL,
  `ex_time_limit` int(11) NOT NULL,
  `ex_qstn_limit` int(11) NOT NULL,
  `ex_disable_prv` varchar(255) NOT NULL,
  `ex_random_qstn` varchar(255) NOT NULL,
  `ex_status` int(1) NOT NULL,
  `ex_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_tbl`
--

INSERT INTO `exam_tbl` (`ex_id`, `ex_title`, `ex_description`, `ex_time_limit`, `ex_qstn_limit`, `ex_disable_prv`, `ex_random_qstn`, `ex_status`, `ex_created`) VALUES
(1, 'Test Exam', 'FOR TESTING', 1, 5, '', '', 1, '2024-04-30 07:55:21'),
(2, 'Test Exam 2', 'FOR TESTING 2', 2, 5, '', '', 1, '2024-04-30 00:01:27'),
(3, 'Math', 'FOR TESTING 3', 5, 20, 'on', 'on', 1, '2024-04-12 01:19:02'),
(4, 'English', 'FOR TESTING 4', 10, 30, 'on', 'on', 1, '2024-04-12 01:20:25'),
(5, 'TESTING', 'FOR TESTING 5', 20, 30, 'on', 'on', 1, '2024-04-12 01:23:01'),
(6, 'srthsh', 'aerhaehga', 40, 50, '', '', 0, '2024-04-30 00:01:03'),
(7, 'Debug Test', 'for debugging purposes', 60, 200, '', '', 1, '2024-04-30 00:08:09'),
(8, 'TESTINGS', 'TESTETSTETSTETS', 60, 50, 'yes', 'yes', 1, '2024-04-15 02:57:58'),
(9, 'Debug Exam', 'Exam for Debugging', 20, 50, 'yes', '', 1, '2024-04-18 06:27:09'),
(10, 'EXAM PAGE DEBUGGING', 'FOR DEBUGGING PURPOSES.', 10, 5, '', 'yes', 1, '2024-04-29 00:08:43'),
(11, 'Test Exam 3', 'For Testing 3', 2, 5, 'yes', '', 1, '2024-04-30 00:02:39');

-- --------------------------------------------------------

--
-- Table structure for table `feedback_tbl`
--
-- Creation: May 02, 2024 at 07:29 AM
--

DROP TABLE IF EXISTS `feedback_tbl`;
CREATE TABLE `feedback_tbl` (
  `fb_id` int(11) NOT NULL,
  `exmne_id` int(11) NOT NULL,
  `fb_exmne_as` varchar(255) NOT NULL,
  `fb_feedback` varchar(255) NOT NULL,
  `fb_date` date NOT NULL,
  `fb_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback_tbl`
--

INSERT INTO `feedback_tbl` (`fb_id`, `exmne_id`, `fb_exmne_as`, `fb_feedback`, `fb_date`, `fb_created`) VALUES
(1, 1, 'Test D. User Jr.', 'Very Easy!', '2024-05-02', '2024-05-02 08:41:22'),
(2, 4, 'LBRDC T. User Jr.', 'Very Difficult! >:(', '2024-05-02', '2024-05-02 08:41:55'),
(3, 4, 'LBRDC T. User Jr.', 'Test Anonymous', '2024-05-02', '2024-05-02 08:44:42'),
(4, 4, 'LBRDC T. User Jr.', 'thzdhhseh', '2024-05-02', '2024-05-02 08:45:27'),
(5, 4, 'LBRDC T. User Jr.', 'azrhraeher', '2024-05-02', '2024-05-02 08:47:42'),
(6, 4, 'LBRDC T. User Jr.', 'stehehseh', '2024-05-02', '2024-05-02 08:48:28'),
(7, 4, 'LBRDC T. User Jr.', 'ytuktyukgcfhjn', '2024-05-02', '2024-05-02 08:49:25'),
(8, 4, 'LBRDC T. User Jr.', 'wrghwerahwaewerhewaah', '2024-05-02', '2024-05-02 08:49:55'),
(9, 4, 'LBRDC T. User Jr.', 'jktyjkydtjkdtjk', '2024-05-02', '2024-05-02 08:51:53'),
(10, 4, 'Anonymous', 'fyjdtyjdtjk', '2024-05-02', '2024-05-02 08:54:05'),
(11, 7, 'Anonymous', 'Anticheat Broken', '2024-05-03', '2024-05-03 01:54:50'),
(12, 4, 'Anonymous', 'aerhaeh', '2024-05-03', '2024-05-03 05:04:31');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_user`
--
ALTER TABLE `admin_user`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `cluster_tbl`
--
ALTER TABLE `cluster_tbl`
  ADD PRIMARY KEY (`clu_id`);

--
-- Indexes for table `examinee_answers`
--
ALTER TABLE `examinee_answers`
  ADD PRIMARY KEY (`exans_id`);

--
-- Indexes for table `examinee_attempt`
--
ALTER TABLE `examinee_attempt`
  ADD PRIMARY KEY (`exatmpt_id`);

--
-- Indexes for table `examinee_tbl`
--
ALTER TABLE `examinee_tbl`
  ADD PRIMARY KEY (`exmne_id`);

--
-- Indexes for table `exam_cluster_tbl`
--
ALTER TABLE `exam_cluster_tbl`
  ADD PRIMARY KEY (`exclu_id`);

--
-- Indexes for table `exam_question_tbl`
--
ALTER TABLE `exam_question_tbl`
  ADD PRIMARY KEY (`exqstn_id`);

--
-- Indexes for table `exam_tbl`
--
ALTER TABLE `exam_tbl`
  ADD PRIMARY KEY (`ex_id`);

--
-- Indexes for table `feedback_tbl`
--
ALTER TABLE `feedback_tbl`
  ADD PRIMARY KEY (`fb_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_user`
--
ALTER TABLE `admin_user`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cluster_tbl`
--
ALTER TABLE `cluster_tbl`
  MODIFY `clu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `examinee_answers`
--
ALTER TABLE `examinee_answers`
  MODIFY `exans_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT for table `examinee_attempt`
--
ALTER TABLE `examinee_attempt`
  MODIFY `exatmpt_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `examinee_tbl`
--
ALTER TABLE `examinee_tbl`
  MODIFY `exmne_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `exam_cluster_tbl`
--
ALTER TABLE `exam_cluster_tbl`
  MODIFY `exclu_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT for table `exam_question_tbl`
--
ALTER TABLE `exam_question_tbl`
  MODIFY `exqstn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=38;

--
-- AUTO_INCREMENT for table `exam_tbl`
--
ALTER TABLE `exam_tbl`
  MODIFY `ex_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `feedback_tbl`
--
ALTER TABLE `feedback_tbl`
  MODIFY `fb_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
