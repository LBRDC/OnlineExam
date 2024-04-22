-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 22, 2024 at 10:45 AM
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

CREATE TABLE IF NOT EXISTS `admin_user` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_username` varchar(255) NOT NULL,
  `admin_fname` varchar(255) NOT NULL,
  `admin_lname` varchar(255) NOT NULL,
  `admin_pos` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_super` int(1) NOT NULL,
  `admin_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_user`
--

INSERT INTO `admin_user` (`admin_id`, `admin_username`, `admin_fname`, `admin_lname`, `admin_pos`, `admin_password`, `admin_super`, `admin_created`) VALUES
(1, 'admin', 'Admin', 'User', 'Superuser', 'admin', 1, '2024-04-11 00:38:42');

-- --------------------------------------------------------

--
-- Table structure for table `cluster_tbl`
--

CREATE TABLE IF NOT EXISTS `cluster_tbl` (
  `clu_id` int(11) NOT NULL AUTO_INCREMENT,
  `clu_name` varchar(255) NOT NULL,
  `clu_description` varchar(255) NOT NULL,
  `clu_status` int(1) NOT NULL,
  `clu_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`clu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cluster_tbl`
--

INSERT INTO `cluster_tbl` (`clu_id`, `clu_name`, `clu_description`, `clu_status`, `clu_created`) VALUES
(1, 'TEST Cluster', 'TEST', 1, '2024-04-11 06:22:03'),
(2, 'Test Cluster 2', 'Test 2', 0, '2024-04-15 03:39:33'),
(3, 'Information Technology', 'IT', 1, '2024-04-11 06:29:25'),
(4, 'Debug', 'for debugging purposes', 1, '2024-04-12 01:28:46'),
(5, 'Admin', 'for admin purposes', 1, '2024-04-15 05:41:41'),
(6, 'Debug 2', '', 1, '2024-04-12 03:36:24');

-- --------------------------------------------------------

--
-- Table structure for table `examinee_answers`
--

CREATE TABLE IF NOT EXISTS `examinee_answers` (
  `exans_id` int(11) NOT NULL AUTO_INCREMENT,
  `exmne_id` int(11) NOT NULL,
  `exam_id` int(11) NOT NULL,
  `exqstn_id` int(11) NOT NULL,
  `exmne_answer` int(11) NOT NULL,
  `exans_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`exans_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `examinee_attempt`
--

CREATE TABLE IF NOT EXISTS `examinee_attempt` (
  `exatmpt_id` int(11) NOT NULL AUTO_INCREMENT,
  `exmne_id` int(11) NOT NULL,
  `ex_id` int(11) NOT NULL,
  `exatmpt_no` int(11) NOT NULL,
  `exatmpt_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`exatmpt_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `examinee_tbl`
--

CREATE TABLE IF NOT EXISTS `examinee_tbl` (
  `exmne_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `exmne_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`exmne_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `examinee_tbl`
--

INSERT INTO `examinee_tbl` (`exmne_id`, `exmne_clu_id`, `exmne_fname`, `exmne_mname`, `exmne_lname`, `exmne_sfname`, `exmne_sex`, `exmne_birthdate`, `exmne_email`, `exmne_pass`, `exmne_status`, `exmne_created`) VALUES
(1, '', 'Test', 'Debug', 'User', 'Jr.', 'Male', '1999-02-19', 'test@email.com', 'test', '1', '2024-04-19 05:14:42'),
(2, '4', 'Debug', 'Test', 'User', 'Sr.', 'Male', '1990-02-12', 'debug@email.com', 'debug', '1', '2024-04-19 05:22:02'),
(3, '2', 'TEST', 'test', 'Test', 'III', 'Female', '1999-02-12', 'test2@email.com', 'test', '1', '2024-04-19 05:26:38'),
(4, '3', 'LBRDC', 'Test', 'User', 'Jr.', 'Male', '1980-02-12', 'lbrdc@email.com', 'lbrdc', '1', '2024-04-22 06:31:26'),
(5, '4', 'wegweg', '', 'wG', '', '', '0000-00-00', 'gar@email.com', 'gar', '0', '2024-04-22 05:11:01');

-- --------------------------------------------------------

--
-- Table structure for table `exam_cluster_tbl`
--

CREATE TABLE IF NOT EXISTS `exam_cluster_tbl` (
  `exclu_id` int(11) NOT NULL AUTO_INCREMENT,
  `ex_id` int(11) NOT NULL,
  `clu_id` int(11) NOT NULL,
  PRIMARY KEY (`exclu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=78 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_cluster_tbl`
--

INSERT INTO `exam_cluster_tbl` (`exclu_id`, `ex_id`, `clu_id`) VALUES
(1, 6, 1),
(2, 7, 1),
(3, 7, 3),
(4, 7, 4),
(5, 7, 5),
(72, 8, 1),
(73, 8, 4),
(74, 8, 5),
(76, 9, 4),
(77, 9, 6);

-- --------------------------------------------------------

--
-- Table structure for table `exam_question_tbl`
--

CREATE TABLE IF NOT EXISTS `exam_question_tbl` (
  `exqstn_id` int(11) NOT NULL AUTO_INCREMENT,
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
  `exqstn_answer` varchar(255) NOT NULL,
  PRIMARY KEY (`exqstn_id`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
(24, 9, '', 'fxtjrtj', 'rtjzrtjrt', 'rjrtjr', 'xghxfgn', '', '', '', '', '', '', '', 'rtjzrtjrt');

-- --------------------------------------------------------

--
-- Table structure for table `exam_tbl`
--

CREATE TABLE IF NOT EXISTS `exam_tbl` (
  `ex_id` int(11) NOT NULL AUTO_INCREMENT,
  `ex_title` varchar(255) NOT NULL,
  `ex_description` varchar(255) NOT NULL,
  `ex_time_limit` int(11) NOT NULL,
  `ex_qstn_limit` int(11) NOT NULL,
  `ex_disable_prv` varchar(255) NOT NULL,
  `ex_random_qstn` varchar(255) NOT NULL,
  `ex_status` int(1) NOT NULL,
  `ex_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`ex_id`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_tbl`
--

INSERT INTO `exam_tbl` (`ex_id`, `ex_title`, `ex_description`, `ex_time_limit`, `ex_qstn_limit`, `ex_disable_prv`, `ex_random_qstn`, `ex_status`, `ex_created`) VALUES
(1, 'Test Exam', 'FOR TESTING', 10, 20, 'on', 'on', 1, '2024-04-12 00:44:35'),
(2, 'Test Exam 2', 'FOR TESTING 2', 10, 30, 'on', 'on', 1, '2024-04-12 01:05:30'),
(3, 'Math', 'FOR TESTING 3', 5, 20, 'on', 'on', 1, '2024-04-12 01:19:02'),
(4, 'English', 'FOR TESTING 4', 10, 30, 'on', 'on', 1, '2024-04-12 01:20:25'),
(5, 'TESTING', 'FOR TESTING 5', 20, 30, 'on', 'on', 1, '2024-04-12 01:23:01'),
(6, 'srthsh', 'aerhaehga', 40, 50, 'on', 'on', 0, '2024-04-17 03:00:15'),
(7, 'Debug Test', 'for debugging purposes', 60, 200, 'on', 'on', 1, '2024-04-12 01:29:40'),
(8, 'TESTINGS', 'TESTETSTETSTETS', 60, 50, 'yes', 'yes', 1, '2024-04-15 02:57:58'),
(9, 'Debug Exam', 'Exam for Debugging', 20, 50, 'yes', '', 1, '2024-04-18 06:27:09');

-- --------------------------------------------------------

--
-- Table structure for table `feedback_tbl`
--

CREATE TABLE IF NOT EXISTS `feedback_tbl` (
  `fb_id` int(11) NOT NULL AUTO_INCREMENT,
  `exmne_id` int(11) NOT NULL,
  `fb_exmne_as` varchar(255) NOT NULL,
  `fb_feedback` varchar(255) NOT NULL,
  `fb_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`fb_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
