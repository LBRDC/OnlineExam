-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 03, 2024 at 10:46 AM
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
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cluster_tbl`
--
ALTER TABLE `cluster_tbl`
  MODIFY `clu_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `examinee_answers`
--
ALTER TABLE `examinee_answers`
  MODIFY `exans_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `examinee_attempt`
--
ALTER TABLE `examinee_attempt`
  MODIFY `exatmpt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `examinee_tbl`
--
ALTER TABLE `examinee_tbl`
  MODIFY `exmne_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_cluster_tbl`
--
ALTER TABLE `exam_cluster_tbl`
  MODIFY `exclu_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_question_tbl`
--
ALTER TABLE `exam_question_tbl`
  MODIFY `exqstn_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `exam_tbl`
--
ALTER TABLE `exam_tbl`
  MODIFY `ex_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `feedback_tbl`
--
ALTER TABLE `feedback_tbl`
  MODIFY `fb_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
