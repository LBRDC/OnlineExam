-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2024 at 10:23 AM
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
-- Creation: Apr 08, 2024 at 08:01 AM
--

CREATE TABLE IF NOT EXISTS `admin_user` (
  `admin_id` int(11) NOT NULL AUTO_INCREMENT,
  `admin_username` varchar(255) NOT NULL,
  `admin_fname` varchar(255) NOT NULL,
  `admin_lname` varchar(255) NOT NULL,
  `admin_password` varchar(255) NOT NULL,
  `admin_super` int(1) NOT NULL,
  `admin_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`admin_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cluster_tbl`
--
-- Creation: Apr 08, 2024 at 08:03 AM
--

CREATE TABLE IF NOT EXISTS `cluster_tbl` (
  `clu_id` int(11) NOT NULL AUTO_INCREMENT,
  `clu_name` varchar(255) NOT NULL,
  `clu_description` varchar(255) NOT NULL,
  `clu_status` int(1) NOT NULL,
  `clu_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`clu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `examinee_answers`
--
-- Creation: Apr 08, 2024 at 08:18 AM
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
-- Creation: Apr 08, 2024 at 08:19 AM
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
-- Creation: Apr 08, 2024 at 08:16 AM
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
-- Creation: Apr 08, 2024 at 08:08 AM
--

CREATE TABLE IF NOT EXISTS `exam_cluster_tbl` (
  `exclu_id` int(11) NOT NULL AUTO_INCREMENT,
  `ex_id` int(11) NOT NULL,
  `clu_id` int(11) NOT NULL,
  PRIMARY KEY (`exclu_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `exam_question_tbl`
--
-- Creation: Apr 08, 2024 at 08:11 AM
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
-- Creation: Apr 08, 2024 at 08:06 AM
--

CREATE TABLE IF NOT EXISTS `exam_tbl` (
  `ex_id` int(11) NOT NULL AUTO_INCREMENT,
  `ex_title` varchar(255) NOT NULL,
  `ex_description` varchar(255) NOT NULL,
  `ex_time_limit` int(11) NOT NULL,
  `ex_qstn_limit` int(11) NOT NULL,
  `ex_disable_nxt` varchar(255) NOT NULL,
  `ex_random_qstn` varchar(255) NOT NULL,
  `ex_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`ex_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `feedback_tbl`
--
-- Creation: Apr 08, 2024 at 08:21 AM
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
