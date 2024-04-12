-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 12, 2024 at 10:22 AM
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
-- Creation: Apr 11, 2024 at 12:33 AM
-- Last update: Apr 12, 2024 at 03:36 AM
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
(2, 'Test Cluster 2', 'Test 2', 0, '2024-04-11 06:04:46'),
(3, 'Information Technology', 'IT', 1, '2024-04-11 06:29:25'),
(4, 'Debug', 'for debugging purposes', 1, '2024-04-12 01:28:46'),
(5, 'Admin', 'for admin purposes', 1, '2024-04-12 01:29:08'),
(6, 'Debug 2', '', 1, '2024-04-12 03:36:24');

-- --------------------------------------------------------

--
-- Table structure for table `examinee_answers`
--
-- Creation: Apr 11, 2024 at 12:33 AM
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
-- Creation: Apr 11, 2024 at 12:33 AM
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
-- Creation: Apr 11, 2024 at 12:33 AM
--

CREATE TABLE IF NOT EXISTS `examinee_tbl` (
  `exmne_id` int(11) NOT NULL AUTO_INCREMENT,
  `exmne_fname` varchar(255) NOT NULL,
  `exmne_mname` varchar(255) NOT NULL,
  `exmne_lname` varchar(255) NOT NULL,
  `exmne_sfname` varchar(255) NOT NULL,
  `exmne_course` varchar(255) NOT NULL,
  `exmne_sex` varchar(255) NOT NULL,
  `exmne_birthdate` date NOT NULL,
  `exmne_contact` varchar(255) NOT NULL,
  `exmne_email` varchar(255) NOT NULL,
  `exmne_pass` varchar(255) NOT NULL,
  `exmne_status` varchar(255) NOT NULL,
  PRIMARY KEY (`exmne_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_cluster_tbl`
--
-- Creation: Apr 11, 2024 at 12:33 AM
-- Last update: Apr 12, 2024 at 01:38 AM
--

CREATE TABLE IF NOT EXISTS `exam_cluster_tbl` (
  `exclu_id` int(11) NOT NULL AUTO_INCREMENT,
  `ex_id` int(11) NOT NULL,
  `clu_id` int(11) NOT NULL,
  PRIMARY KEY (`exclu_id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_cluster_tbl`
--

INSERT INTO `exam_cluster_tbl` (`exclu_id`, `ex_id`, `clu_id`) VALUES
(1, 6, 1),
(2, 7, 1),
(3, 7, 3),
(4, 7, 4),
(5, 7, 5),
(6, 8, 1),
(7, 8, 4),
(8, 8, 5);

-- --------------------------------------------------------

--
-- Table structure for table `exam_question_tbl`
--
-- Creation: Apr 11, 2024 at 12:33 AM
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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_tbl`
--
-- Creation: Apr 12, 2024 at 12:57 AM
-- Last update: Apr 12, 2024 at 01:38 AM
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
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `exam_tbl`
--

INSERT INTO `exam_tbl` (`ex_id`, `ex_title`, `ex_description`, `ex_time_limit`, `ex_qstn_limit`, `ex_disable_prv`, `ex_random_qstn`, `ex_status`, `ex_created`) VALUES
(1, 'Test Exam', 'FOR TESTING', 10, 20, 'on', 'on', 1, '2024-04-12 00:44:35'),
(2, 'Test Exam 2', 'FOR TESTING 2', 10, 30, 'on', 'on', 1, '2024-04-12 01:05:30'),
(3, 'Math', 'FOR TESTING 3', 5, 20, 'on', 'on', 1, '2024-04-12 01:19:02'),
(4, 'English', 'FOR TESTING 4', 10, 30, 'on', 'on', 1, '2024-04-12 01:20:25'),
(5, 'TESTING', 'FOR TESTING 5', 20, 30, 'on', 'on', 1, '2024-04-12 01:23:01'),
(6, 'srthsh', 'aerhaehga', 40, 50, 'on', 'on', 1, '2024-04-12 01:23:54'),
(7, 'Debug Test', 'for debugging purposes', 60, 200, 'on', 'on', 1, '2024-04-12 01:29:40'),
(8, 'tabaeha', 'gwewg', 7, 70, 'on', 'on', 1, '2024-04-12 01:38:58');

-- --------------------------------------------------------

--
-- Table structure for table `feedback_tbl`
--
-- Creation: Apr 11, 2024 at 12:33 AM
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
